<?php

namespace App\Http\Controllers;

use App\Models\kot;
use App\Models\item;
use App\Models\sale;
use App\Models\unit;
use App\Models\godown;
use App\Models\ledger;
use App\Models\account;
use App\Models\company;
use App\Models\voucher;
use App\Models\purchase;
use App\Models\gstmaster;
use App\Models\inventory;
use App\Models\itemgroup;
use App\Models\tempentry;
use App\Models\optionlist;
use App\Models\roomcheckin;
use App\Models\accountgroup;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoresaleRequest;
use App\Http\Requests\UpdatesaleRequest;
use Illuminate\Support\Facades\Validator;

class SaleController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $sales = voucher::with('account')->where('voucher_type','sale')->orderBy('voucher_no','desc')->get();
        $sales = voucher::withinFY('entry_date')->with('account')
        ->where('firm_id', Auth::user()->firm_id)
        ->where('voucher_type','Sale')->orderBy('voucher_no','desc')->get();
       
        
 
        return view('entery.sale.sale_index',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
 public function create()
    {
        $voucher_record=voucher::where('firm_id', Auth::user()->firm_id)->where('voucher_type','Sale')->count();
        if ($voucher_record > 0) {
           $lastRecord = voucher::where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
           $voucher_no = $lastRecord->voucher_no;
           $new_voucher_no=$voucher_no+1;
           $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'sale')->first();
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
       
        }
        else {

           $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'sale')->first();
 

           $voucher_no=$voucher_type->numbring_start_from;
           $new_voucher_no=$voucher_no+1;
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
 
       }

$godowns=godown::where('firm_id', Auth::user()->firm_id)->get();
$sundry_SundryCreditors_id = accountgroup::where('firm_id', Auth::user()->firm_id)
->where('account_group_name', 'Sundry Debtors')->first();
$accountdata = account::where('firm_id', Auth::user()->firm_id)->where('account_group_id', $sundry_SundryCreditors_id->id)->get();   
$itemdata = item::where('firm_id', Auth::user()->firm_id)->get();
 $accountgroups = accountgroup::where('firm_id', Auth::user()->firm_id)->get();

  $itemCompanies = company::where('firm_id', Auth::user()->firm_id)
        ->orderBy('id')
        ->get();

    $itemGroups = itemgroup::where('firm_id', Auth::user()->firm_id)
        ->orderBy('id')
        ->get();
   $units = unit::where('firm_id', Auth::user()->firm_id)
        ->orderBy('id')
        ->get();

    $gsts = Gstmaster::where('firm_id', Auth::user()->firm_id)
        ->orderBy('id')
        ->get();
       return view('entery.sale.sale_create', compact('new_bill_no','new_voucher_no','accountdata','itemdata','godowns','accountgroups','itemCompanies','itemGroups','units','gsts'));

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store_to_voucher($id)
    {
    $record=tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id',$id)->where('voucher_type','sale')->get();
    $first_record=tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id',$id)->where('voucher_type','sale')->first();
    $voucher_terms = $first_record->voucher_remark;


    if($record->count()){

    $totalQty = $record->sum('qty');
    $totalAmount = $record->sum('amount');
    $net_voucher_amount=$record->sum('item_net_value');
    $total_gst=$record->sum('total_gst');
    $total_discount=$record->sum->sum('total_discount');

         $voucher=new voucher;
         $voucher->firm_id = Auth::user()->firm_id;
         $voucher->entry_date=$first_record->entry_date;
         $voucher->voucher_no=$first_record->voucher_no;
         $voucher->voucher_date=$first_record->voucher_date;
         $voucher->voucher_type=$first_record->voucher_type;
         $voucher->voucher_bill_no=$first_record->bill_no;
         $voucher->user_id=$first_record->user_id;
         $voucher->user_name=$first_record->user_name;
         $voucher->account_id=$first_record->account_id;
         $voucher->total_qty=$totalQty;

         $voucher->total_item_basic_amount=$totalAmount;
         $voucher->total_disc_item_amount=$total_discount;
         $voucher->total_gst_amount=$total_gst;
         $voucher->total_roundoff="0";
         $voucher->total_net_amount=$net_voucher_amount;
         $voucher->voucher_terms=$voucher_terms;


         if ($voucher_terms === 'Credit') {



            $posting_acc = account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('account_name', 'Cash')->first();
            $posting_acc_id = $posting_acc->id;

            $bill_amount = $net_voucher_amount;



            $paymentmode= account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('id', $first_record->account_id)->first();
                $accountname= account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('account_name', 'Sales')->first();

            $ledger = new ledger;
            $ledger->firm_id = Auth::user()->firm_id;
            $ledger->voucher_no = $first_record->voucher_no;
            $ledger->reciept_no = $first_record->bill_no;
            $ledger->entry_date = $first_record->entry_date;
            $ledger->transaction_type = 'sale';
            $ledger->payment_mode_id = $posting_acc_id;
            $ledger->payment_mode_name = $paymentmode->account_name;

            $ledger->account_id = $accountname->id;
            $ledger->account_name = $accountname->account_name;
            $ledger->account_group_id = $accountname->account_group_id;
            $ledger->account_group_name = $accountname->accountgroup->account_group_name;
            $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
            $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
            $ledger->credit = $net_voucher_amount;
            $ledger->amount = $net_voucher_amount;
            $ledger->remark = "Sale/" . $first_record->bill_no;
            $ledger->simpal_amount = "-" .$net_voucher_amount;
            $ledger->userid = Auth::user()->id;
            $ledger->username = Auth::user()->name;
            //post_amt -  this amount post on 
            $ledger->save();


            $ledger = new ledger;
            $ledger->firm_id = Auth::user()->firm_id;
            $ledger->voucher_no = $first_record->voucher_no;
            $ledger->reciept_no = $first_record->bill_no;
            $ledger->entry_date = $first_record->entry_date;
            $ledger->transaction_type = 'sale';
            $ledger->payment_mode_id = $accountname->id;
            $ledger->payment_mode_name = $accountname->account_name;
            $ledger->account_id = $paymentmode->id;
            $ledger->account_name = $paymentmode->account_name;
            $ledger->account_group_id = $paymentmode->account_group_id;
            $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
            $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
            $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
            $ledger->debit = $net_voucher_amount;
            $ledger->amount = $net_voucher_amount;
            $ledger->remark = "Sale/" . $first_record->bill_no;
            $ledger->simpal_amount = "+" . $net_voucher_amount;
            $ledger->userid = Auth::user()->id;
            $ledger->username = Auth::user()->name;
            //post_amt + 
            $ledger->save();
        } else {


            $posting_acc = account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('account_name', 'Cash')->first();
            $posting_acc_id = $posting_acc->id;

            $bill_amount = $net_voucher_amount;



            $paymentmode = account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('account_name', 'Cash')->first();
                $accountname= account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('account_name', 'Sales')->first();

            $ledger = new ledger;
            $ledger->firm_id = Auth::user()->firm_id;
            $ledger->voucher_no = $first_record->voucher_no;
            $ledger->reciept_no = $first_record->bill_no;
            $ledger->entry_date = $first_record->entry_date;
            $ledger->transaction_type = 'sale';
            $ledger->payment_mode_id = $posting_acc_id;
            $ledger->payment_mode_name = $paymentmode->account_name;

            $ledger->account_id = $accountname->id;
            $ledger->account_name = $accountname->account_name;
            $ledger->account_group_id = $accountname->account_group_id;
            $ledger->account_group_name = $accountname->accountgroup->account_group_name;
            $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
            $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
            $ledger->credit = $net_voucher_amount;
            $ledger->amount = $net_voucher_amount;
            $ledger->remark = "Sale/" . $first_record->bill_no;
            $ledger->simpal_amount = "-" . $net_voucher_amount;
            $ledger->userid = Auth::user()->id;
            $ledger->username = Auth::user()->name;
            //post_amt -  this amount post on 
            $ledger->save();


            $ledger = new ledger;
            $ledger->firm_id = Auth::user()->firm_id;
            $ledger->voucher_no = $first_record->voucher_no;
            $ledger->reciept_no = $first_record->bill_no;
            $ledger->entry_date = $first_record->entry_date;
            $ledger->transaction_type = 'sale';
            $ledger->payment_mode_id = $accountname->id;
            $ledger->payment_mode_name = $accountname->account_name;
            $ledger->account_id = $paymentmode->id;
            $ledger->account_name = $paymentmode->account_name;
            $ledger->account_group_id = $paymentmode->account_group_id;
            $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
            $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
            $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
            $ledger->debit = $net_voucher_amount;
            $ledger->amount = $net_voucher_amount;
            $ledger->remark = "Sale/" . $first_record->bill_no;
            ;
            $ledger->simpal_amount = "+" . $net_voucher_amount;
            ;
            $ledger->userid = Auth::user()->id;
            $ledger->username = Auth::user()->name;
            //post_amt + 
            $ledger->save();




        }

 
 
 
         $voucher->save();
    
    
       }
    }

    public function store_to_sale($id)
    {
     
    $records=tempentry::where('user_id',$id)->get();
   
    if($records->count()){

    $totalQty = $records->sum('qty');
    $totalAmount = $records->sum('amount');
    $net_voucher_amount=$records->sum('item_net_value');
    foreach ($records as $record) {
        
         $purchase=new inventory;
         $purchase->firm_id = Auth::user()->firm_id;
         $purchase->entry_date=$record->entry_date;
         $purchase->voucher_no=$record->voucher_no;
         $purchase->voucher_date=$record->voucher_date;
         $purchase->voucher_type=$record->voucher_type;
         $purchase->voucher_bill_no=$record->bill_no;
         $purchase->user_id=$record->user_id;
         $purchase->user_name=$record->user_name;
         $purchase->item_id=$record->item_id;
         $purchase->item_name=$record->item_name;
         $purchase->qty=$record->qty;
         $purchase->rate=$record->rate;
         $purchase->item_basic_amount=$record->amount;
         $purchase->godown_id=$record->temp_af1;
         $purchase->account_id=$record->account_id;
         $purchase->net_voucher_amount=$net_voucher_amount;
         $purchase->gst_id=$record->item_gst_name; //gst id from gst master  
         $purchase->gst_item_percent=$record->item_gst_id;  
         $purchase->gst_item_amount=$record->total_gst;  
         $purchase->item_net_amount=$net_voucher_amount;  
         $purchase->simpal_qty=-($record->qty);  
         $purchase->stock_out=$record->qty;
       

        $purchase->save();

    }
    $this->store_to_voucher($id);
    $tempkots_delete=tempentry::where('user_id',$id)
    ->where('firm_id',Auth::user()->firm_id);
    $tempkots_delete->delete();
   $vouchers=voucher::with('account')->get();

$salebill_header = voucher::with('account')
->where('firm_id',Auth::user()->firm_id)
->where('voucher_type','Sale')->orderBy('voucher_no','desc')->first();
$salebill_items=inventory::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
->where('voucher_no',$salebill_header->voucher_no)
->where('voucher_type','Sale')
->get();
 $sales = voucher::withinFY('entry_date')->with('account')
        ->where('firm_id', Auth::user()->firm_id)
        ->where('voucher_type','Sale')->orderBy('voucher_no','desc')->get();
        
           $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'sale')
            ->orderBy('updated_at', 'desc')
            ->get();
            $voucher_no=$salebill_header->voucher_no;
    return view('entery.sale.sale_print_select', compact( 'fromtlist','voucher_no')); 
    }
    else{
        return back()->with('error', 'Nothing  To Save  ');
       }
     


    }
    //======================================================== 
    // use to select sale format at print
    // =======================================================

   Public function print_sale_select($voucher_no){
      
    $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'sale')
            ->orderBy('updated_at', 'desc')
            ->get();
    return view('entery.sale.sale_print_select', compact( 'fromtlist','voucher_no'));        

   }
  


   Public function sale_print_view($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Sale')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','Sale')
   ->get();

 return view('entery.sale.sale_print_view',compact('salebill_header','salebill_items'));

}   

Public function sale_print_view2($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Sale')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','Sale')
   ->get();

 return view('entery.sale.sale_print_view2',compact('salebill_header','salebill_items'));

   }  
   
Public function sale_print_view3($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Sale')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','Sale')
   ->get();

 return view('entery.sale.sale_print_view3',compact('salebill_header','salebill_items'));

   }   
   
Public function sale_print_view4($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Sale')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','Sale')
   ->get();

 return view('entery.sale.sale_print_view4',compact('salebill_header','salebill_items'));

   }   
   /**
     * Display the specified resource.
     */
  
    /**
     * Show the form for editing the specified resource.
     */
public function edit($voucher_no)
{
    $sale = voucher::where('voucher_no', $voucher_no)
        ->where('firm_id', Auth::user()->firm_id)
        ->firstOrFail();

    $items = inventory::where('voucher_no', $voucher_no)
        ->where('voucher_type', 'Sale')
        ->where('firm_id', Auth::user()->firm_id)
        ->get();

    $godowns = godown::where('firm_id', Auth::user()->firm_id)->get();

    $sundry = accountgroup::where('firm_id', Auth::user()->firm_id)
        ->where('account_group_name', 'Sundry Debtors')
        ->first();

    $accountdata = account::where('firm_id', Auth::user()->firm_id)
        ->where('account_group_id', $sundry->id)
        ->get();

    $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();

    return view('entery.sale.sale_edit', compact(
        'sale',
        'items',      // ✅ IMPORTANT
        'accountdata',
        'itemdata',
        'godowns'
    ));
}


    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $voucher_no)
{
    DB::transaction(function () use ($request, $voucher_no) {

        // 1️⃣ Update voucher
        $voucher = voucher::where('voucher_no', $voucher_no)->firstOrFail();

        $voucher->update([
            'account_id' => $request->account_id,
            'voucher_date' => $request->voucher_date,
            'voucher_terms' => $request->voucher_terms,
            'voucher_bill_no' => $request->voucher_bill_no,
            'total_qty' => $request->total_qty,
            'total_item_basic_amount' => $request->total_item_basic_amount,
            'total_disc_item_amount' => $request->total_disc_item_amount,
            'total_gst_amount' => $request->total_gst_amount,
            'total_net_amount' => $request->total_net_amount,
        ]);

        // 2️⃣ DELETE OLD INVENTORY ITEMS
        inventory::where('voucher_no', $voucher_no)
            ->where('voucher_type', 'Sale')
            ->delete();

        // 3️⃣ INSERT UPDATED ITEMS FROM TEMPENTRY
        $items = tempentry::where('user_id', Auth::user()->id)
            ->where('voucher_type', 'Sale')
            ->get();

        foreach ($items as $item) {
            inventory::create([
                'firm_id' => Auth::user()->firm_id,
                'voucher_no' => $voucher_no,
                'voucher_type' => 'Sale',
                'voucher_date' => $voucher->voucher_date,
                'item_id' => $item->item_id,
                'item_name' => $item->item_name,
                'qty' => $item->qty,
                'rate' => $item->rate,
                'item_basic_amount' => $item->amount,
                'total_discount' => $item->total_discount,
                'total_amount' => $item->total_amount,
                'gst_id' => $item->item_gst_name,
                'gst_item_percent' => $item->item_gst_id,
                'gst_item_amount' => $item->total_gst,
                'item_net_amount' => $item->item_net_value,
                'godown_id' => $item->temp_af1,
                'stock_out' => $item->qty,
                'simpal_qty' => -$item->qty,
            ]);
        }

        // 4️⃣ CLEAR TEMP
        tempentry::where('user_id', Auth::user()->id)->delete();
    });

    return response()->json(['status' => 'updated']);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find all room check-in records with the given voucher_no $id is voucehr no 
      
        $voucher = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no', $id)->where('voucher_type','Sale');
        $inventory=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no', $id)->where('voucher_type','Sale');
        $ledger = ledger::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('firm_id', Auth::user()->firm_id)->where('transaction_type', 'sale');

      


        if ($voucher->count()>0 && $inventory->count()>0 ) {
            $voucher->delete();
            $inventory->delete();
            $ledger->delete();
            return redirect('/sales')->with('message', 'All matching Record deleted successfully!');

        }
        else{

            return redirect('/sales')->with('message', 'No Recoird  found ');

        } 


       
    }
public function updateSaleItem(Request $request, $id)
{
    $item = inventory::where('id', $id)
        ->where('firm_id', Auth::user()->firm_id)
        ->firstOrFail();

    $amount = $request->qty * $request->rate;

    $item->update([
        'qty' => $request->qty,
        'rate' => $request->rate,
        'item_basic_amount' => $amount,
        'item_net_amount' => $amount + $item->gst_item_amount,
        'stock_out' => $request->qty,
        'simpal_qty' => -$request->qty
    ]);

    return response()->json(['status' => 'updated']);
}
public function deleteSaleItem($id)
{
    inventory::where('id', $id)
        ->where('firm_id', Auth::user()->firm_id)
        ->delete();

    return response()->json(['status' => 'deleted']);
}

}
