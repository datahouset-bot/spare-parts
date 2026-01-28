<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\unit;
use App\Models\godown;
use App\Models\ledger;
use App\Models\account;
use App\Models\company;
use App\Models\voucher;
use App\Models\gstmaster;
use App\Models\inventory;
use App\Models\itemgroup;
use App\Models\Quotation;
use App\Models\tempentry;
use App\Models\optionlist;
use App\Models\accountgroup;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $sales = voucher::withinFY('entry_date')->with('account')
        ->where('firm_id', Auth::user()->firm_id)
        ->where('voucher_type','Quotation')->orderBy('voucher_no','desc')->get();
          return view('quotation.quotation_index',compact('sales'));
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

    $gsts = gstmaster::where('firm_id', Auth::user()->firm_id)
        ->orderBy('id')
        ->get();
       return view('quotation.quotation_create', compact('new_bill_no','new_voucher_no','accountdata','itemdata','godowns','accountgroups','itemCompanies','itemGroups','units','gsts'));

    }

       public function store_to_voucher($id)
    {
    $record=tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id',$id)->where('voucher_type','Quotation')->get();
    $first_record=tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id',$id)->where('voucher_type','Quotation')->first();
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
            $ledger->transaction_type = 'Quotation';
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
            $ledger->remark = "Quotation/" . $first_record->bill_no;
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
            $ledger->transaction_type = 'Quotation';
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
            $ledger->remark = "Quotation/" . $first_record->bill_no;
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
            $ledger->transaction_type = 'Quotation';
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
            $ledger->remark = "Quotation/" . $first_record->bill_no;
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
            $ledger->transaction_type = 'Quotation';
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
            $ledger->remark = "Quotation/" . $first_record->bill_no;
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

    public function store_to_quotation($id)
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
         $purchase->invent_af2 = $record->remark_1;
         $purchase->invent_af3 = $record->remark_2;
         $purchase->invent_af4 = $record->remark_3;

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
            ->where('option_type', 'Quotation')
            ->orderBy('updated_at', 'desc')
            ->get();
            $voucher_no=$salebill_header->voucher_no;
    return view('quotation.quotation_print_select', compact( 'fromtlist','voucher_no')); 
    }
    else{
        return back()->with('error', 'Nothing  To Save  ');
       }
     


    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
           $voucher = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no', $id)->where('voucher_type','Quotation');
        $inventory=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no', $id)->where('voucher_type','Quotation');
        $ledger = ledger::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('firm_id', Auth::user()->firm_id)->where('transaction_type', 'Quotation');

      


        if ($voucher->count()>0 && $inventory->count()>0 ) {
            $voucher->delete();
            $inventory->delete();
            $ledger->delete();
            return redirect('/quotations/create')->with('message', 'All matching Record deleted successfully!');

        }
        else{

            return redirect('/quotations/create')->with('message', 'No Recoird  found ');

        } 
    }
     Public function print_quotation_select($voucher_no){
      
    $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Quotation')
            ->orderBy('updated_at', 'desc')
            ->get();
    return view('quotation.quotation_print_select', compact( 'fromtlist','voucher_no'));        

   }
  
   Public function quotation_print_view2($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Quotation')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','Quotation')
   ->get();

 return view('quotation.quotation_print_view2',compact('salebill_header','salebill_items'));

} 

 Public function quotation_print_view3($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Quotation')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','Quotation')
   ->get();

 return view('quotation.quotation_print_view3',compact('salebill_header','salebill_items'));

} 

 Public function quotation_print_view4($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Quotation')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','Quotation')
   ->get();

 return view('quotation.quotation_print_view4',compact('salebill_header','salebill_items'));

} 

 Public function quotation_print_view($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Quotation')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','Quotation')
   ->get();

 return view('quotation.quotation_print_view',compact('salebill_header','salebill_items'));

} 
}
