<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorepurchaseRequest;
use App\Http\Requests\UpdatepurchaseRequest;

class PurchaseController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = voucher::with('account')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_type', 'Purchase')->orderBy('voucher_no', 'desc')->get();

        return view('entery.purchase.purchase_index', compact('purchases'));

    }

    /**
     * Show the form for creating a new resource.
     */
 
 public function create()
    {

        $voucher_record = voucher::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_type', 'Purchase')->count();
        if ($voucher_record > 0) {
            $lastRecord = voucher::where('firm_id', Auth::user()->firm_id)
                ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Purchase')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {

            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Purchase')->first();


            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }

        $godowns = godown::where('firm_id', Auth::user()->firm_id)->get();
        $sundry_SundryCreditors_id = accountgroup::where('firm_id', Auth::user()->firm_id)
            ->where('account_group_name', 'Sundry Creditors')->first();
$accountgroups = accountgroup::where('firm_id', Auth::user()->firm_id)->get();
        $accountdata = account::where('firm_id', Auth::user()->firm_id)->where('account_group_id', $sundry_SundryCreditors_id->id)->get();

        $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();

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
     

        return view('entery.purchase.purchase_create', compact('new_bill_no', 'new_voucher_no', 'accountdata', 'accountgroups',
        'itemdata', 'godowns',
        'itemCompanies','gsts','units','itemGroups'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)// store temp item record use on sale controller also 
    {
        $validator = validator::make($request->all(), [
            'item_id' => 'required',
            'item_qty' => 'required',
            'item_rate' => 'required',
            'item_amount' => 'required',
            'user_id' => 'required',
            'voucher_no' => 'required',
            'voucher_date' => 'required',
            'user_name' => 'required',
            'godown_id' => 'required',
            //  'service_id'=>'required',


        ]);
        if ($validator->passes()) {
            $item = item::where('firm_id', Auth::user()->firm_id)
                ->where('id', $request->item_id)->firstOrFail();
            $itemName = $item->item_name;
            // format entery date 
            $date_variable = $request->purchase_bill_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_voucher_date = $parsed_date->format('Y-m-d');
               $fy_start_date = $this->fy_start_date;
            $fy_end_date = $this->fy_end_date;
            $financialyeardata = $this->financialyeardata;
            if (
                $financialyeardata &&
                $formatted_voucher_date < $fy_start_date ||
                $formatted_voucher_date > $fy_end_date
            ) {

                return view('error.checkdate_on_fy',compact('fy_start_date','fy_end_date'));

            }
            //storing data 
            $tempkot = new tempentry;
            $tempkot->firm_id = Auth::user()->firm_id;
            $tempkot->user_id = $request->user_id;
            $tempkot->user_name = $request->user_name;
            $tempkot->entry_date = now();
            $tempkot->voucher_date = $formatted_voucher_date;
            $tempkot->voucher_no = $request->voucher_no;
            $tempkot->voucher_type = $request->voucher_type;
            $tempkot->bill_no = $request->kot_no;
            $tempkot->item_id = $request->item_id;
            $tempkot->item_name = $itemName;
            $tempkot->qty = $request->item_qty;
            $tempkot->rate = $request->item_rate;
            $tempkot->dis_percent = $request->dis_p;
            $tempkot->dis_amt = $request->dis_amt;
            $tempkot->total_discount = $request->total_item_dis_amt;
            $tempkot->item_gst_id = $request->gst_p;
            $tempkot->total_gst = $request->gst_amt;
            $tempkot->item_net_value = $request->net_item_amt;
            $tempkot->customer_id = $request->account_id;
            $tempkot->voucher_remark = $request->terms;
            $tempkot->customer_id = $request->account_id;
            $tempkot->bill_no = $request->voucher_bill_no;
            $tempkot->item_gst_name = $request->gstmaster_id; //gst id  form gst master 

            $tempkot->amount = $request->item_qty * $request->item_rate;
            $tempkot->total_amount = ($request->item_qty * $request->item_rate) - $request->total_item_dis_amt;
            $tempkot->temp_af1 = $request->godown_id;//store godown id 
            $tempkot->account_id = $request->account_id;//store godown id 

            $tempkot->save();
            $itemName = "test item ";
            return response()->json([
                'message' => 'I am ready to save through AJAX  hariom ji ' . $itemName,
                'status' => 200,
            ]);
        } else {
            $itemName = "test item ";
            return response()->json([

                'message' => 'Bad Request. Check Your Input' . $itemName,
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function store_to_voucher($id)
    {

        $record = tempentry::where('firm_id', Auth::user()->firm_id)
            ->where('user_id', $id)->where('voucher_type', 'Purchase')->get();
        $first_record = tempentry::where('firm_id', Auth::user()->firm_id)
            ->where('user_id', $id)->where('voucher_type', 'Purchase')->first();
        $voucher_terms = $first_record->voucher_remark;




        if ($record->count()) {

            $totalQty = $record->sum('qty');
            $totalAmount = $record->sum('amount');
            $net_voucher_amount = $record->sum('item_net_value');
            $total_gst = $record->sum('total_gst');
            $total_discount = $record->sum->sum('total_discount');

            $voucher = new voucher;
            $voucher->firm_id = Auth::user()->firm_id;

            $voucher->entry_date = $first_record->entry_date;
            $voucher->voucher_no = $first_record->voucher_no;
            $voucher->voucher_date = $first_record->voucher_date;
            $voucher->voucher_type = $first_record->voucher_type;
            $voucher->voucher_bill_no = $first_record->bill_no;
            $voucher->user_id = $first_record->user_id;
            $voucher->user_name = $first_record->user_name;
            $voucher->account_id = $first_record->account_id;
            $voucher->total_qty = $totalQty;

            $voucher->total_item_basic_amount = $totalAmount;
            $voucher->total_disc_item_amount = $total_discount;
            $voucher->total_gst_amount = $total_gst;
            $voucher->total_roundoff = "0";
            $voucher->total_net_amount = $net_voucher_amount;
            $voucher->voucher_terms=$voucher_terms;
            $voucher->voucher_af1=$first_record->temp_af1;








            if ($voucher_terms === 'Credit') {



                $posting_acc = account::with('accountgroup')
                    ->where('firm_id', Auth::user()->firm_id)
                    ->where('account_name', 'Cash')->first();
                $posting_acc_id = $posting_acc->id;

                $bill_amount = $net_voucher_amount;



                $accountname= account::with('accountgroup')
                    ->where('firm_id', Auth::user()->firm_id)
                    ->where('id', $first_record->account_id)->first();
                    $paymentmode= account::with('accountgroup')
                    ->where('firm_id', Auth::user()->firm_id)
                    ->where('account_name', 'Purchase')->first();

                $ledger = new ledger;
                $ledger->firm_id = Auth::user()->firm_id;
                $ledger->voucher_no = $first_record->voucher_no;
                $ledger->reciept_no = $first_record->bill_no;
                $ledger->entry_date = $first_record->voucher_date;
                $ledger->transaction_type = 'Purchase';
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
                $ledger->remark = "Purchase/" . $first_record->bill_no;
                $ledger->simpal_amount = "-" . $first_record->bill_no;
                $ledger->userid = Auth::user()->id;
                $ledger->username = Auth::user()->name;
                //post_amt -  this amount post on 
                $ledger->save();


                $ledger = new ledger;
                $ledger->firm_id = Auth::user()->firm_id;
                $ledger->voucher_no = $first_record->voucher_no;
                $ledger->reciept_no = $first_record->bill_no;
                $ledger->entry_date = $first_record->voucher_date;
                $ledger->transaction_type = 'Purchase';
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
                $ledger->remark = "Purchase/" . $net_voucher_amount;
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



                $accountname = account::with('accountgroup')
                    ->where('firm_id', Auth::user()->firm_id)
                    ->where('account_name', 'Cash')->first();
                    $paymentmode= account::with('accountgroup')
                    ->where('firm_id', Auth::user()->firm_id)
                    ->where('account_name', 'Purchase')->first();

                $ledger = new ledger;
                $ledger->firm_id = Auth::user()->firm_id;
                $ledger->voucher_no = $first_record->voucher_no;
                $ledger->reciept_no = $first_record->bill_no;
                $ledger->entry_date = $first_record->voucher_date;
                $ledger->transaction_type = 'Purchase';
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
                $ledger->remark = "Purchase/" . $first_record->bill_no;
                $ledger->simpal_amount = "-" . $first_record->bill_no;
                $ledger->userid = Auth::user()->id;
                $ledger->username = Auth::user()->name;
                //post_amt -  this amount post on 
                $ledger->save();


                $ledger = new ledger;
                $ledger->firm_id = Auth::user()->firm_id;
                $ledger->voucher_no = $first_record->voucher_no;
                $ledger->reciept_no = $first_record->bill_no;
                $ledger->entry_date = $first_record->voucher_date;
                $ledger->transaction_type = 'Purchase';
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
                $ledger->remark = "Purchase/" . $net_voucher_amount;
                ;
                $ledger->simpal_amount = "+" . $net_voucher_amount;
                ;
                $ledger->userid = Auth::user()->id;
                $ledger->username = Auth::user()->name;
                //post_amt + 
                $ledger->save();




            }
            $voucher->save(); //saving voucher


        }


    }






    public function store_to_purchase($id)
    {
        $records = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id)->get();

        if ($records->count()) {

            $totalQty = $records->sum('qty');
            $totalAmount = $records->sum('amount');
            $net_voucher_amount = $records->sum('item_net_value');
            foreach ($records as $record) {
                $purchase = new inventory;
                $purchase->firm_id = Auth::user()->firm_id;
                
                $purchase->entry_date = $record->entry_date;
                $purchase->voucher_no = $record->voucher_no;
                $purchase->voucher_date = $record->voucher_date;
                $purchase->voucher_type = $record->voucher_type;
                $purchase->voucher_bill_no = $record->bill_no;
                $purchase->user_id = $record->user_id;
                $purchase->user_name = $record->user_name;
                $purchase->item_id = $record->item_id;
                $purchase->item_name = $record->item_name;
                $purchase->qty = $record->qty;
                $purchase->rate = $record->rate;
                $purchase->item_basic_amount = $record->amount;
                $purchase->godown_id = $record->temp_af1;
                $purchase->account_id = $record->account_id;
                $purchase->net_voucher_amount = $net_voucher_amount;
                $purchase->gst_id = $record->item_gst_name; //gst id from gst master  
                $purchase->gst_item_percent = $record->item_gst_id;
                $purchase->gst_item_amount = $record->total_gst;
                $purchase->item_net_amount = $net_voucher_amount;
                $purchase->simpal_qty = ($record->qty);
                $purchase->stock_in = $record->qty;
                $purchase->save();

            }
            $this->store_to_voucher($id);
            $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
            $tempkots_delete->delete();
            return redirect('/purchases')->with('message', 'Purchase Voucher Save successfully!');
        } else {
            return back()->with('error', 'Nothing  To Save  ');
        }



    }
    public function show($voucher_no)
    {
        $voucher_header = voucher::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
            ->first();



        // $guest_detail = roomcheckin::select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
        //     ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
        //     ->where('voucher_no', $service_id)
        //     ->where('firm_id',Auth::user()->firm_id)
        //     ->first();

        $voucher_items = inventory::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
        ->where('voucher_type','Purchase')

            ->get();



        return view('entery.purchase.purchase_print_view', compact( 'voucher_header', 'voucher_items'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function temp_item_delete($id)
    {
        $user_id = $id;
         $itemrecords = tempentry::where('firm_id',Auth::user()->firm_id)
         ->where('user_id', $user_id);
        if($itemrecords->count()){
            $itemrecords->delete();
            return back()->with('message', 'Welcome on New Kot ');
        }
        else{
            return back()->with('message', 'Please Add Items   '); 
        }
        
        
 

    }
    public function edit($voucher_no)
    {




        $voucher_header = voucher::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
            ->first();
        $voucher_terms=$voucher_header->voucher_terms;    

        $new_bill_no=$voucher_header->vouchr_bill_no;
        $new_voucher_no=$voucher_no;
        $user_id=$voucher_header->user_id;
        $this->temp_item_delete($user_id);

        $voucher_items = inventory::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
            ->get();
            foreach ($voucher_items as $item) {
                $tempkot = new tempentry();
                $tempkot->firm_id = Auth::user()->firm_id;
                $tempkot->user_id = Auth::user()->id;
                $tempkot->user_name = Auth::user()->name;
                $tempkot->entry_date = now();
                $tempkot->voucher_date = $item->voucher_date;
                $tempkot->voucher_no = $item->voucher_no;
                $tempkot->voucher_type = $item->voucher_type;
                $tempkot->bill_no = $item->voucher_bill_no;
                $tempkot->item_id = $item->item_id;
                $tempkot->item_name = $item->item_name;
                $tempkot->qty = $item->qty;
                $tempkot->rate = $item->rate;
                $tempkot->dis_percent = $item->dis_percent ?? 0;
                $tempkot->dis_amt = $item->dis_amt ?? 0;
                $tempkot->total_discount = $item->total_discount ?? 0;
                $tempkot->item_gst_id = $item->gst_item_percent;
                $tempkot->total_gst = $item->gst_item_amount ?? 0;
                $tempkot->item_net_value =($item->qty*$item->rate)+$item->gst_item_amount ;
                $tempkot->customer_id = $item->account_id;
                $tempkot->voucher_remark = $voucher_terms;
                $tempkot->item_gst_name = $item->gst_id; // GST ID from GST master
        
                // Calculate amount and total amount
                $tempkot->amount = $item->qty * $item->rate;
                $tempkot->total_amount = ($item->qty * $item->rate) - ($item->total_discount ?? 0);
        
                // Store godown ID and account ID
                $tempkot->temp_af1 =$item->godown_id;
                $tempkot->account_id = $item->account_id;
        
                // Save to the database
                $tempkot->save();
            }
        



            $godowns = godown::where('firm_id', Auth::user()->firm_id)->get();
            $sundry_SundryCreditors_id = accountgroup::where('firm_id', Auth::user()->firm_id)
                ->where('account_group_name', 'Sundry Creditors')->first();
    
            $accountdata = account::where('firm_id', Auth::user()->firm_id)->where('account_group_id', $sundry_SundryCreditors_id->id)->get();
    
            $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();
         
    
            return view('entery.purchase.purchase_edit', compact('new_bill_no', 'new_voucher_no', 'accountdata', 'itemdata', 'godowns','voucher_header','voucher_items'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepurchaseRequest $request, purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find all room check-in records with the given voucher_no $id is voucehr no 

        $voucher = voucher::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)->where('voucher_type', 'Purchase');
        $inventory = inventory::where('firm_id', Auth::user()->firm_id)->where('voucher_no', $id)->where('voucher_type', 'Purchase');
        $ledger = ledger::where('firm_id', Auth::user()->firm_id)->where('transaction_type', 'Purchase');



        if ($voucher->count() > 0 && $inventory->count() > 0) {
            $voucher->delete();
            $inventory->delete();
            $ledger->delete();
            return redirect('/purchases')->with('message', 'All matching room check-ins deleted successfully!');

        } else {

            return redirect('/purchases')->with('message', 'No Recoird  found ');

        }



    }


    public function fetchItemRecords_inventory(string $id)
    {
        $user_id = $id;
        $itemrecords = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Records fetched successfully for user ' . $user_id,
            'status' => 200,
            'itemrecords' => $itemrecords->toArray(),
        ]);
    }

    public function store_to_modify_purchase($id)
    {
       
        $records = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id)->get();
        $first_record=$records->first();
       
        $oldvoucher_no=$first_record->voucher_no;
        $oldvoucher_type=$first_record->voucher_type;
        $oldcustomer_id=$first_record->customer_id;
        $oldfirm_id=$first_record->firm_id;
        //delete old voucher 
        $voucherdata=voucher::where('voucher_no',$oldvoucher_no)->where('firm_id',$oldfirm_id)
        ->where('account_id',$oldcustomer_id)
        ->where('voucher_type',$oldvoucher_type);

        $inventorydata=inventory::where('voucher_no',$oldvoucher_no)->where('firm_id',$oldfirm_id)->where('voucher_type',$oldvoucher_type);
        if($voucherdata){
            $voucherdata->delete();
        }
        if($voucherdata){
            $inventorydata->delete();
        }


        if ($records->count()) {

            $totalQty = $records->sum('qty');
            $totalAmount = $records->sum('amount');
            $net_voucher_amount = $records->sum('item_net_value');
            foreach ($records as $record) {
                $purchase = new inventory;
                $purchase->firm_id = Auth::user()->firm_id;
                
                $purchase->entry_date = $record->entry_date;
                $purchase->voucher_no = $record->voucher_no;
                $purchase->voucher_date = $record->voucher_date;
                $purchase->voucher_type = $record->voucher_type;
                $purchase->voucher_bill_no = $record->bill_no;
                $purchase->user_id = $record->user_id;
                $purchase->user_name = $record->user_name;
                $purchase->item_id = $record->item_id;
                $purchase->item_name = $record->item_name;
                $purchase->qty = $record->qty;
                $purchase->rate = $record->rate;
                $purchase->item_basic_amount = $record->amount;
                $purchase->godown_id = $record->temp_af1;
                $purchase->account_id = $record->account_id;
                $purchase->net_voucher_amount = $net_voucher_amount;
                $purchase->gst_id = $record->item_gst_name; //gst id from gst master  
                $purchase->gst_item_percent = $record->item_gst_id;
                $purchase->gst_item_amount = $record->total_gst;
                $purchase->item_net_amount = $net_voucher_amount;
                $purchase->simpal_qty = ($record->qty);
                $purchase->stock_in = $record->qty;
                $purchase->save();

            }
            $this->store_to_voucher($id);
            $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
            $tempkots_delete->delete();
            return redirect('/purchases')->with('message', 'Purchase Voucher Save successfully!');
        } else {
            return back()->with('error', 'Nothing  To Save  ');
        }
    }
    public function purchase_show($voucher_no){
          $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'purchase')
            ->orderBy('updated_at', 'desc')
            ->get();
    return view('entery.purchase.purchase_print_format', compact( 'fromtlist','voucher_no'));        

    }
   public function purchase_print_view($voucher_no){
   $voucher_header = voucher::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
            ->first();

        $voucher_items = inventory::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
        ->where('voucher_type','Purchase')

            ->get();
            $account_detail=account::where('account_name','purchase')  ->first();

 return view('entery.purchase.purchase_print_view',compact('voucher_header','voucher_items','account_detail'));
   }


public function purchase_print_view2($voucher_no)
{
$voucher_header = voucher::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
            ->first();

        $voucher_items = inventory::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
        ->where('voucher_type','Purchase')

            ->get();
            $account_detail=account::where('account_name','purchase')  ->first();

return view('entery.purchase.purchase_print_view2',compact('voucher_header','voucher_items','account_detail'));
}

public function purchase_print_view3($voucher_no)
{
$voucher_header = voucher::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
            ->first();      
            $voucher_items = inventory::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
        ->where('voucher_type','Purchase')

            ->get();
            $account_detail=account::where('account_name','purchase')  ->first();

return view('entery.purchase.purchase_print_view3',compact('voucher_header','voucher_items','account_detail'));
}
}

