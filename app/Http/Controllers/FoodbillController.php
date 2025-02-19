<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
use App\Models\godown;
use App\Models\ledger;
use App\Models\account;
use App\Models\foodbill;
use App\Models\inventory;
use App\Models\tempentry;
use App\Models\roomcheckin;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorefoodbillRequest;
use App\Http\Requests\UpdatefoodbillRequest;

class FoodbillController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodbills = foodbill::select('firm_id','voucher_type', 'total_bill_value', 'total_qty', 'voucher_no', 'food_bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
            ->groupBy('firm_id','voucher_type', 'voucher_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date')
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->where('voucher_type', 'Foodbill')
            ->where('firm_id',Auth::user()->firm_id)
           // Ensure groupBy includes all non-aggregated selected columns
            ->get();
        $roomcheckins = roomcheckin::where('firm_id',Auth::user()->firm_id)->get();


        return view('entery.roomservice.foodbill.foodbill_index', compact('foodbills', 'roomcheckins'));


    }
    public function item_wise_sale_report_view()
    {

        // Passing the data to the view
        return view('entery.roomservice.foodbill.item_wise_sale_report_view');
    }
   
    public function item_wise_sale_report(Request $request)
    {
        // Parse and format the input dates
        $formatted_from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
        $formatted_to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
    
        $from_date = $request->from_date;
        $to_date = $request->to_date;
    
        // Query for Inventory data, grouped by item_id and item_name
        $item_sales = DB::table('inventories')->select(
            'item_id',
            'item_name',
            DB::raw('SUM(qty) as total_qty_sold'),
            'rate',
            DB::raw('SUM(qty * rate) as total_amount')
        )
            ->where('firm_id', Auth::user()->firm_id) // Filter by firm_id
            ->where(function ($query) {
                $query->where('voucher_type', 'sale')
                    ->orWhere('voucher_type', 'Foodbill')
                    ->orWhere('voucher_type', 'Restaurant_food_bill');
            })
            ->whereBetween('voucher_date', [$formatted_from_date, $formatted_to_date]) // Filter by date range
            ->groupBy('item_id', 'item_name', 'rate') // Group by item_id, item_name, and rate
            ->get();
    
        // Passing the data to the view
        return view('entery.roomservice.foodbill.item_wise_sale_report', compact('item_sales', 'from_date', 'to_date'));
    }
    

    

    public function create()
    {
        $kot_record = foodbill::count();
        if ($kot_record > 0) {
            $lastRecord = foodbill::where('firm_id',Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            // dd($lastRecord);
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)->where('voucher_type_name', 'Foodbill')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)
            ->where('voucher_type_name', 'Foodbill')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }

        $checkinlists = roomcheckin::where('firm_id',Auth::user()->firm_id)
             ->where('checkout_voucher_no', 0)
            ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'voucher_no')
            ->get();

        $accountdata = account::where('firm_id',Auth::user()->firm_id)->get();
        $itemdata = item::where('firm_id',Auth::user()->firm_id)->get();

        return view('entery.roomservice.foodbill.foodbill_create', compact('new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata'));




    }
    public function fetchkotRecords(string $id)
    {

        $service_id = $id;

        $itemrecords = Kot::where('firm_id',Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('voucher_type', 'Kot')
            ->where('status', '0')
            ->groupBy('item_id', 'rate')
            ->get();
        if ($itemrecords->count() > 0) {
            $vouchers = DB::table('kots')
                ->select(DB::raw('GROUP_CONCAT(DISTINCT voucher_no ORDER BY voucher_no ASC SEPARATOR ",") as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', '0')
                ->where('voucher_type', 'Kot')
                ->where('firm_id',Auth::user()->firm_id)
                ->value('voucher_nos');

                $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
                })
                ->get();

            $kot_record = foodbill::where('firm_id', Auth::user()->firm_id)->count();
            if ($kot_record > 0) {
                $lastRecord = foodbill::where('firm_id',Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
                
                $voucher_no = $lastRecord->voucher_no;
                $new_voucher_no = $voucher_no + 1;
                $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)->where('voucher_type_name', 'Foodbill')->first();
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

            } else {
                $voucher_type = voucher_type::where('voucher_type_name', 'Foodbill')->first();

                $voucher_no = $voucher_type->numbring_start_from;
                $new_voucher_no = $voucher_no + 1;
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

            }

            $checkinlists = roomcheckin::where('firm_id',Auth::user()->firm_id)
            ->where('checkout_voucher_no', 0)
                ->where('voucher_no', $service_id)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->get();

            $accountdata = account::where('firm_id',Auth::user()->firm_id)->get();
            $itemdata = item::where('firm_id',Auth::user()->firm_id)->get();


            return view('entery.roomservice.foodbill.foodbill_create_afterselect', compact('new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata', 'itemrecords', 'service_id', 'vouchers', 'paymentmodes'));

        } else {
            return back()->with('message', 'No Pending Kot Records Found ');
        }


    }
    public function storeinventory(Request $request)
    {

        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_voucher_date = $parsed_date->format('Y-m-d');
        $service_id = $request->service_id;
        $records = Kot::with('item')
            ->select('firm_id','item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
            ->where('firm_id',Auth::user()->firm_id)
            ->where('service_id', $service_id)
            ->where('status', '0')
            ->where('firm_id',Auth::user()->firm_id)
            ->groupBy('item_id', 'rate')
            ->get();
        $account = account::where('firm_id',Auth::user()->firm_id)->where('account_name', 'FoodBill Sales')->first();
        $account_id = $account->id;
        $godown = godown::where('firm_id',Auth::user()->firm_id)->where('godown_name', 'Kitchen')->first();
        $godown_id = $godown->id;


        foreach ($records as $record) {
            $itemrecord = new inventory;
            $itemrecord->firm_id=Auth::user()->firm_id;
            $itemrecord->entry_date = now();  //y
            $itemrecord->voucher_no = $request->voucher_no;   //y
            $itemrecord->voucher_date = $formatted_voucher_date;//y
            $itemrecord->voucher_type = $request->voucher_type;   //y
            $itemrecord->voucher_bill_no = $request->food_bill_no; //y
            $itemrecord->user_id = $request->user_id;          //y
            $itemrecord->user_name = $request->user_name;      //y
            $itemrecord->item_id = $record->item_id;       //y
            $itemrecord->item_name = $record->item->item_name;  //y
            $itemrecord->qty = $record->qty; //y
            $itemrecord->rate = $record->rate;  //y
            $itemrecord->item_basic_amount = $request->total_base_amount;  //y
            $itemrecord->godown_id = $godown->id;//y
            $itemrecord->account_id = $account_id;  //y
            $itemrecord->net_voucher_amount = $request->net_food_bill_amount;   //y
            $itemrecord->gst_id = $record->item->gstmaster->id; //gst id from gst master  
            $itemrecord->gst_item_percent = "1"; //value sahi karna hai  
            $itemrecord->gst_item_amount = $request->total_gst_amount;  //y
            $itemrecord->item_net_amount = $request->net_food_bill_amount;   //galt value hai y;  
            $itemrecord->simpal_qty = -($record->qty);  //y  
            $itemrecord->stock_out = $record->qty;  //y
            $itemrecord->save();

        }


    }








    public function store_foodbill(Request $request)
    {

        $existingRecords = foodbill::where('firm_id',Auth::user()->firm_id)
        ->where('voucher_no', $request->voucher_no)
        ->count();

             if ($existingRecords >= 2) {
                return response()->json(['error' => 'Records already exist for this transaction type and voucher number and Please Dont Reloade and resubmit Same Entry .'], 400);
            }

        // dd($request);
        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_voucher_date = $parsed_date->format('Y-m-d');
        $service_id = $request->service_id;
        $itemrecords = Kot::with('item')
    ->select(
        'firm_id',
        'item_id',
        DB::raw('SUM(qty) as qty'),
        'rate',
        DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos')
    )
    ->where('service_id', $service_id)
    ->where('status', '0')
    ->where('firm_id', Auth::user()->firm_id)
    ->groupBy('firm_id', 'item_id', 'rate') // Include firm_id in groupBy
    ->get();

    $store_time=$request->checkin_time;
  

        foreach ($itemrecords as $record) {
            // return($record);
            $itembaseamount=$record->qty * $record->rate;
            $itemdiscountamt=(($record->qty * $record->rate)*$request->dis_percant)/100;
            $itemgst=$record->item->gstmaster->igst;

            $itemtaxableamt=($itembaseamount-$itemdiscountamt);
            $itemnetamt=$itemtaxableamt+(($itemtaxableamt*$itemgst)/100);


            $newfoodbill = new foodbill;
            $newfoodbill->firm_id=Auth::user()->firm_id;
            $newfoodbill->user_id = $request->user_id;
            $newfoodbill->user_name = $request->user_name;
            $newfoodbill->food_bill_no = $request->food_bill_no;
            $newfoodbill->voucher_date = $formatted_voucher_date;
            $newfoodbill->voucher_type = $request->voucher_type;
            $newfoodbill->voucher_no = $request->voucher_no;
            $newfoodbill->service_id = $request->service_id;
            $newfoodbill->kot_no = $request->kot_no;
            $newfoodbill->posting_acc_id = $request->posting_acc_id;
            $newfoodbill->net_food_bill_amount = $request->net_food_bill_amount;
            $newfoodbill->payment_remark = $request->payment_remark;
            $newfoodbill->food_bill_remark = $request->food_bill_remark;
            $newfoodbill->item_id = $record->item_id;
            $newfoodbill->item_name = $record->item->item_name;
            $newfoodbill->qty = $record->qty;
            $newfoodbill->rate = $record->rate;
            $newfoodbill->item_base_amount = $itembaseamount;
            $newfoodbill->disc_percent = $request->dis_percant;
            $newfoodbill->disc_item_amount = $itemdiscountamt;
            $newfoodbill->gst_id = $record->item->gstmaster->id;
            $newfoodbill->gst_item_percent = $itemgst;
            // $newfoodbill->gst_item_amount=$record->item->gstmaster->igst;
            $newfoodbill->gst_item_amount = (($record->qty * $record->rate) * ($record->item->gstmaster->igst)) / 100;
            $newfoodbill->net_item_amount = $itemnetamt;
            $newfoodbill->total_item = $request->total_item;
            $newfoodbill->total_qty = $request->total_qty;
            $newfoodbill->total_base_amount = $request->total_base_amount;
            $newfoodbill->cash_discount = $request->total_discount_amount;
            $newfoodbill->total_taxable_amount = $request->total_base_amount;
            $newfoodbill->total_gst_amount = $request->total_gst_amount;
            $newfoodbill->total_sgst = ($request->total_gst_amount) / 2;
            $newfoodbill->total_cgst = ($request->total_gst_amount) / 2;
            $newfoodbill->total_igst = '0';
            $newfoodbill->roundoff_amt = $request->round_off;
            $newfoodbill->total_amt_after_gst = ($request->total_gst_amount) + ($request->total_gst_amount);
            $newfoodbill->total_bill_value = $request->net_food_bill_amount;
            $newfoodbill->status = '0';
            $date = $formatted_voucher_date; // Assuming this is in 'Y-m-d' format
            $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
            $newfoodbill->created_at = "$date $time";
            $newfoodbill->save();


        }
        kot::where('service_id', $request->service_id)->update(['status' => $request->voucher_no]);

    }







    public function store(Request $request)
    {

        //store record to  inventor after foodbill after store to account 
      

        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_voucher_date = $parsed_date->format('Y-m-d');
        $service_id = $request->service_id;
        $records = Kot::with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('status', '0')
            ->groupBy('item_id', 'rate')
            ->where('firm_id',Auth::user()->firm_id)
            ->get();

        $account = account::where('account_name', 'FoodBill Sales')->where('firm_id',Auth::user()->firm_id)->first();
        $account_id = $account->id;
        $godown = godown::where('godown_name', 'Kitchen')->where('firm_id',Auth::user()->firm_id)->first();
        $godown_id = $godown->id;


        foreach ($records as $record) {
            $itemrecord = new inventory;
            $itemrecord->firm_id=Auth::user()->firm_id;
            $itemrecord->entry_date = now();  //y
            $itemrecord->voucher_no = $request->voucher_no;   //y
            $itemrecord->voucher_date = $formatted_voucher_date;//y
            $itemrecord->voucher_type = $request->voucher_type;   //y
            $itemrecord->voucher_bill_no = $request->food_bill_no; //y
            $itemrecord->user_id = $request->user_id;          //y
            $itemrecord->user_name = $request->user_name;      //y
            $itemrecord->item_id = $record->item_id;       //y
            $itemrecord->item_name = $record->item->item_name;  //y
            $itemrecord->qty = $record->qty; //y
            $itemrecord->rate = $record->rate;  //y
            $itemrecord->item_basic_amount = $request->total_base_amount;  //y
            $itemrecord->godown_id = $godown->id;//y
            $itemrecord->account_id = $account_id;  //y
            $itemrecord->net_voucher_amount = $request->net_food_bill_amount;   //y
            $itemrecord->gst_id = $record->item->gstmaster->id; //gst id from gst master  
            $itemrecord->gst_item_percent = "1"; //value sahi karna hai  
            $itemrecord->gst_item_amount = $request->total_gst_amount;  //y
            $itemrecord->item_net_amount = $request->net_food_bill_amount;   //galt value hai y;  
            $itemrecord->simpal_qty = -($record->qty);  //y  
            $itemrecord->stock_out = $record->qty;  //y
            $itemrecord->save();
        }
     //----------------------------


        $this->store_foodbill($request); //store the record on foodbill

        $settle_payment = $request->settle_payment;
        if ($settle_payment =="yes") {

            foodbill::where('voucher_no', $request->voucher_no)
            ->where('firm_id',Auth::user()->firm_id)
            ->update(['status' => 'direct_bill']);
            //requierd Post amount to ledger 
            $this->foodbill_posting($request);
            return redirect()->route('foodbills.index')->with('message', 'Record saved successfully and bill amount posted to direct sale.');

        } else {
            // return redirect()->route('foodbills.index')->with('message', 'Record saved successfully. Bill amount posted to room.');
            $guest_detail = roomcheckin::select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
                ->where('firm_id',Auth::user()->firm_id)
                ->where('voucher_no', $request->service_id)->first();
            $foodbill_header = foodbill::where('user_id', $request->user_id)
                ->where('voucher_no', $request->voucher_no)
                ->where('firm_id',Auth::user()->firm_id)
                ->first();
            $foodbill_items = foodbill::where('user_id', $request->user_id)
                ->where('voucher_no', $request->voucher_no)
                ->where('firm_id',Auth::user()->firm_id)
                ->get();


            return view('entery.roomservice.foodbill.foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));


        }

    }
    public function foodbill_print_view($voucher_no)
    {
        $foodbill_header = foodbill::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
            ->first();
        $service_id = $foodbill_header->service_id;
        $guest_detail = roomcheckin::select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
            ->where('voucher_no', $service_id)
            ->where('firm_id',Auth::user()->firm_id)
            ->first();

        $foodbill_items = foodbill::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)
            ->get();


        return view('entery.roomservice.foodbill.foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));
    }



    //    return view('entery.roomservice.foodbill.foodbill_print_view');


  
    
    //posting foodbill amount to respective account

    public function foodbill_posting(Request $request)
    {
        


        $transaction_type = 'Foodbill';
        $receipt_remark = $request->food_bill_no . '||' . $request->service_id . '||' . $request->net_bill_amount . '||' . $request->payment_remark;


        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_entry_date = $parsed_date->format('Y-m-d');
        $accountname = account::with('accountgroup')
           ->where('firm_id',Auth::user()->firm_id)
            ->where('account_name', 'FoodBill Sales')->first();
        $paymentmode = account::with('accountgroup')
        ->where('firm_id',Auth::user()->firm_id)
            ->where('id', $request->posting_acc_id)->first();

            $payment_data = $request->payment_data;

            if (is_array($payment_data) && !empty($payment_data)) {
                foreach ($payment_data as $payment) {
                    if($payment['amount']!==Null){
                    $paymentmode = account::with('accountgroup')
                        ->where('firm_id', Auth::user()->firm_id)
                        ->where('id', $payment['id'])
                        ->first();
        
                    // Create a ledger entry for each payment mode
                    $ledger = new ledger;
                    $ledger->firm_id = Auth::user()->firm_id;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->food_bill_no;
                    $ledger->entry_date = $formatted_entry_date;
                    $ledger->transaction_type = $transaction_type;
                    $ledger->payment_mode_id = $payment['id'];
                    $ledger->payment_mode_name = $paymentmode->account_name;
                    $ledger->account_id = $accountname->id;
                    $ledger->account_name = $accountname->account_name;
                    $ledger->account_group_id = $accountname->account_group_id;
                    $ledger->account_group_name = $accountname->accountgroup->account_group_name;
                    $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
                    $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
                    $ledger->credit = $payment['amount'];
                    $ledger->amount = $payment['amount'];
                    $ledger->remark = $receipt_remark;
                    $ledger->simpal_amount = "-" . $payment['amount'];
                    $ledger->userid = Auth::user()->id;
                    $ledger->username = Auth::user()->name;
                    $ledger->save();
        
                    // Create another ledger entry for the payment mode
                    $ledger = new ledger;
                    $ledger->firm_id = Auth::user()->firm_id;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->food_bill_no;
                    $ledger->entry_date = $formatted_entry_date;
                    $ledger->transaction_type = $transaction_type;
                    $ledger->payment_mode_id = $payment['id'];
                    $ledger->payment_mode_name = $paymentmode->account_name;
                    $ledger->account_id = $payment['id'];
                    $ledger->account_name = $paymentmode->account_name;
                    $ledger->account_group_id = $paymentmode->account_group_id;
                    $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
                    $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
                    $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
                    $ledger->debit = $payment['amount'];
                    $ledger->amount = $payment['amount'];
                    $ledger->remark = $receipt_remark;
                    $ledger->simpal_amount = "+" . $payment['amount'];
                    $ledger->userid = Auth::user()->id;
                    $ledger->username = Auth::user()->name;
                    $ledger->save();
                    }
                }




               
            } else {
                $ledger = new ledger;
                $ledger->firm_id=Auth::user()->firm_id;
                $ledger->voucher_no = $request->voucher_no;
                $ledger->reciept_no = $request->food_bill_no;
                $ledger->entry_date = $formatted_entry_date;
                $ledger->transaction_type = $transaction_type;
                $ledger->payment_mode_id = $request->posting_acc_id;
                $ledger->payment_mode_name = $paymentmode->account_name;
        
                $ledger->account_id = $accountname->id;
                $ledger->account_name = $accountname->account_name;
                $ledger->account_group_id = $accountname->account_group_id;
                $ledger->account_group_name = $accountname->accountgroup->account_group_name;
                $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
                $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
                $ledger->credit = $request->net_food_bill_amount;
                $ledger->amount = $request->net_food_bill_amount;
                $ledger->remark = $receipt_remark;
                $ledger->simpal_amount = "-" . $request->net_food_bill_amount;
                $ledger->userid = Auth::user()->id; 
                $ledger->username = Auth::user()->name;
                $ledger->save();
        
        
                $ledger = new ledger;
                $ledger->firm_id=Auth::user()->firm_id;
                $ledger->voucher_no = $request->voucher_no;
                $ledger->reciept_no = $request->food_bill_no;
                $ledger->entry_date = $formatted_entry_date;
                $ledger->transaction_type = $transaction_type;
                $ledger->payment_mode_id = $request->posting_acc_id;
                $ledger->payment_mode_name = $accountname->account_name;
                $ledger->account_id = $request->posting_acc_id;
                $ledger->account_name = $paymentmode->account_name;
                $ledger->account_group_id = $paymentmode->account_group_id;
                $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
                $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
                $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
                $ledger->debit = $request->net_food_bill_amount;
                $ledger->amount = $request->net_food_bill_amount;
                $ledger->remark = $receipt_remark;
                $ledger->simpal_amount = "+" . $request->net_food_bill_amount;
                $ledger->userid = Auth::user()->id; 
                $ledger->username = Auth::user()->name;
                $ledger->save();
            }
               

        

    }




    /**
     * Display the specified resource.
     */
    public function show(foodbill $foodbill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(foodbill $foodbill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatefoodbillRequest $request, foodbill $foodbill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($voucher_no)
    {
        $foodbills = foodbill::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id);
        $inventory = inventory::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)->where('voucher_type', 'Foodbill');
        $ledger=ledger::where('voucher_no', $voucher_no)
        ->where('firm_id',Auth::user()->firm_id)->where('transaction_type', 'Foodbill');
        

        if ($foodbills->count()) {
            $ledger->delete();
            $foodbills->delete();
            kot::where('firm_id',Auth::user()->firm_id)
            ->where('status', $voucher_no)->update(['status' => '0']);
            if ($inventory->count()) {
                $inventory->delete();
            }

            return back()->with('message', 'Record Deleteted ' . $voucher_no);
        } else {
            return back()->with('errors', 'No Record Found   ');
        }

    }


    //get discount from foodbill and return value 
    public function fetchkot(string $id)
    {           $service_id = $id;

        $itemrecords = Kot::with(['item.gstmaster']) // Include gstmaster through the item relationship
        ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
        ->where('service_id', $service_id)
        ->where('status', '0')
        ->where('firm_id',Auth::user()->firm_id)
        ->groupBy('item_id', 'rate')
        ->get();
    
        // $user_id = $id;
        // $itemrecords = tempentry::where('user_id', $user_id)->get();
        
        return response()->json([
            'message' => 'Records fetched successfully for checkin ' . $service_id,
            'status' => 200,
            'itemrecords' => $itemrecords->toArray(),
        ]);
    }
   
}
