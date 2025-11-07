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
use App\Models\optionlist;
use App\Models\componyinfo;
use App\Models\roomcheckin;
use App\Models\WhatsappSms;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\softwarecompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
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
        $foodbills = foodbill::withinFY('voucher_date')->select('firm_id', 'voucher_type', 'total_bill_value', 'total_qty', 'voucher_no', 'food_bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
            ->groupBy('firm_id', 'voucher_type', 'voucher_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date')
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->where('voucher_type', 'Foodbill')
            ->where('firm_id', Auth::user()->firm_id)
            // Ensure groupBy includes all non-aggregated selected columns
            ->get();
        $roomcheckins = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)->get();


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
        $item_sales = inventory::withinFY('entry_date')->select(
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
            $lastRecord = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            // dd($lastRecord);
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Foodbill')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Foodbill')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }

        $checkinlists = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('checkout_voucher_no', 0)
            ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'voucher_no')
            ->get();

        $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
        $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();

        return view('entery.roomservice.foodbill.foodbill_create', compact('new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata'));




    }
    public function fetchkotRecords(string $id)
    {

        $service_id = $id;

        $itemrecords = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('voucher_type', 'Kot')
            ->where('status', '0')
            ->groupBy('item_id', 'rate')
            ->get();
        if ($itemrecords->count() > 0) {
            $vouchers = Kot::withinFY('voucher_date')
                ->select(DB::raw('GROUP_CONCAT(DISTINCT voucher_no ORDER BY voucher_no ASC SEPARATOR ",") as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', '0')
                ->where('voucher_type', 'Kot')
                ->where('firm_id', Auth::user()->firm_id)
                ->value('voucher_nos');

            $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
                })
                ->get();

            $kot_record = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->count();
            if ($kot_record > 0) {
                $lastRecord = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();

                $voucher_no = $lastRecord->voucher_no;
                $new_voucher_no = $voucher_no + 1;
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Foodbill')->first();
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

            $checkinlists = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                ->where('checkout_voucher_no', 0)
                ->where('voucher_no', $service_id)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->get();

            $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
            $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();


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
        $records = Kot::withinFY('voucher_date')->with('item')
            ->select('firm_id', 'item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
            ->where('firm_id', Auth::user()->firm_id)
            ->where('service_id', $service_id)
            ->where('status', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->groupBy('item_id', 'rate')
            ->get();
        $account = account::where('firm_id', Auth::user()->firm_id)->where('account_name', 'FoodBill Sales')->first();
        $account_id = $account->id;
        $godown = godown::where('firm_id', Auth::user()->firm_id)->where('godown_name', 'Kitchen')->first();
        $godown_id = $godown->id;


        foreach ($records as $record) {
            $itemrecord = new inventory;
            $itemrecord->firm_id = Auth::user()->firm_id;
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



        $existingRecords = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
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
        $itemrecords = Kot::withinFY('voucher_date')->with('item')
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

        $store_time = $request->checkin_time;
        $checkinlist = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('checkout_voucher_no', 0)
            ->where('voucher_no', $request->service_id)
            ->select('guest_name', 'voucher_no','guest_mobile', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'voucher_no','guest_mobile')
            ->first();

            $paymentsetlmentType=$request->settle_payment;


        foreach ($itemrecords as $record) {
            // return($record);
            $itembaseamount = $record->qty * $record->rate;
            $itemdiscountamt = (($record->qty * $record->rate) * $request->dis_percant) / 100;
            $itemgst = $record->item->gstmaster->igst;
            $itemvat = $record->item->gstmaster->vat;
            $itemtax1 = $record->item->gstmaster->tax1;

            $itemtaxableamt = ($itembaseamount - $itemdiscountamt);
            $itemnetamt = $itemtaxableamt + (($itemtaxableamt * $itemgst) / 100);


            $newfoodbill = new foodbill;
            $newfoodbill->firm_id = Auth::user()->firm_id;
            $newfoodbill->user_id = $request->user_id;
            $newfoodbill->user_name = $request->user_name;
            $newfoodbill->mobile=$checkinlist->guest_mobile;
            $newfoodbill->customer_name=$checkinlist->guest_name;

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
            $newfoodbill->vat_percent = $itemvat;
            $newfoodbill->tax1_percent = $itemtax1;
            // $newfoodbill->gst_item_amount=$record->item->gstmaster->igst;
            $newfoodbill->gst_item_amount = (($record->qty * $record->rate) * ($record->item->gstmaster->igst)) / 100;
            $newfoodbill->item_vatamt = (($record->qty * $record->rate) * ($record->item->gstmaster->vat)) / 100;
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
            $newfoodbill->total_vat = $request->total_vat_amount;
            $newfoodbill->total_tax1 = $request->total_tax1_amount;
            $newfoodbill->roundoff_amt = $request->round_off;
            $newfoodbill->total_amt_after_gst = ($request->total_gst_amount) + ($request->total_gst_amount);
            $newfoodbill->total_bill_value = $request->net_food_bill_amount;
            $newfoodbill->status = '0';
            $date = $formatted_voucher_date; // Assuming this is in 'Y-m-d' format
            $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
            $newfoodbill->created_at = "$date $time";
            if ($paymentsetlmentType == "yes") {

                $newfoodbill->payment_remark = "Multi Payment ";
                $cashTotal = 0;
                $otherTotal = 0;

                foreach ($request->payment_data as $payment) {
                    if (isset($payment['name']) && strtolower($payment['name']) == 'cash') {
                        $cashTotal += (float) $payment['amount'];
                    } else {
                        $otherTotal += (float) $payment['amount'];
                    }
                }
                $newfoodbill->foodbill_af1 = $cashTotal;     // Store cash amount
                $newfoodbill->foodbill_af2 = $otherTotal;    // Store other payments/card payment  sum
                $newfoodbill->foodbill_af5 = " Direct Bill Room No- " . $checkinlist->room_nos;
                $newfoodbill->remark = $request->remark;

            } else {
                $newfoodbill->foodbill_af4 = $request->net_food_bill_amount;
                $newfoodbill->foodbill_af5 = "Settle Room No- " . $checkinlist->room_nos;
            }

            $newfoodbill->save();




        }

        // $request->kot_no
        // kot::withinFY('voucher_date')->where('service_id', $request->service_id)->update(['status' => $request->voucher_no]);
        $voucherNos = explode(',', $request->kot_no); // Split comma-separated voucher numbers

        foreach ($voucherNos as $voucherNo) {
            kot::withinFY('voucher_date')->where('service_id', $request->service_id)
                ->where('voucher_no', trim($voucherNo))
                ->update(['status' => $request->voucher_no]);
        }


    }







    public function store(Request $request)
    {


        $settle_status = $request->settle_payment;





        //store record to  inventor after foodbill after store to account 
        if (!isset($_POST['approval']) || $_POST['approval'] !== "true") {

            $date_variable = $request->voucher_date;
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
            $service_id = $request->service_id;
            $records = Kot::withinFY('voucher_date')->with('item')
                ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

                ->where('service_id', $service_id)
                ->where('status', '0')
                ->groupBy('item_id', 'rate')
                ->where('firm_id', Auth::user()->firm_id)
                ->get();

            $account = account::where('account_name', 'FoodBill Sales')->where('firm_id', Auth::user()->firm_id)->first();
            $account_id = $account->id;
            $godown = godown::where('godown_name', 'Kitchen')->where('firm_id', Auth::user()->firm_id)->first();
            $godown_id = $godown->id;


            foreach ($records as $record) {
                $itemrecord = new inventory;
                $itemrecord->firm_id = Auth::user()->firm_id;
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

            //    $settle_payment = $request->settle_payment;

            if ($settle_status == "yes") {
                // dd($request->settle_payment);

                foodbill::withinFY('voucher_date')->where('voucher_no', $request->voucher_no)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->where('service_id', $request->service_id)

                    ->update(['status' => 'direct_bill']);

                $this->foodbill_posting($request);
                return redirect()->route('foodbills.index')->with('message', 'Record saved successfully and bill amount posted to direct sale.');
                // dd($settle_payment);

            } else {
                // return redirect()->route('foodbills.index')->with('message', 'Record saved successfully. Bill amount posted to room.');
                $guest_detail = roomcheckin::withinFY('checkin_date')->select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
                    ->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $request->service_id)->first();
                $foodbill_header = foodbill::withinFY('voucher_date')->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->where('service_id', $request->service_id)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->first();
                $foodbill_items = foodbill::withinFY('voucher_date')->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                         ->where('service_id', $request->service_id)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->get();
        $method_type = "Foodbill_store";
        $voucher_no = $request->voucher_no;
        
        $this->sendfoodbillWhatsapp($method_type, $voucher_no);

                return view('entery.roomservice.foodbill.foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));


            }

        } else {

            //this is code for print approvel bill 
            $inputbagdata = $request->all(); // Extract all input data as an array

            $date_variable = $request->voucher_date;
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
            $service_id = $request->service_id;
            $voucher_no = $request->voucher_no;
            $roomcheckins = roomcheckin::withinFY('checkin_date')->where('voucher_no', $service_id)->where('firm_id', Auth::user()->firm_id)->get();
            $roomcheckins_first = $roomcheckins->first();


            $itemrecords = Kot::withinFY('voucher_date')->with(['item.gstmaster']) // Include gstmaster through the item relationship
                ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', '0')
                ->where('voucher_type', 'Kot')
                ->where('firm_id', Auth::user()->firm_id)
                ->groupBy('item_id', 'rate')
                ->get();




            return view('entery.roomservice.foodbill.room_foodbill_print_Approval', compact('inputbagdata', 'itemrecords', 'roomcheckins', 'roomcheckins_first'));


        }

    }
    public function foodbill_print_view($voucher_no)
    {
        $foodbill_header = foodbill::withinFY('voucher_date')->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();
        $service_id = $foodbill_header->service_id;
        $guest_detail = roomcheckin::withinFY('checkin_date')->select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
            ->where('voucher_no', $service_id)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();

        $foodbill_items = foodbill::withinFY('voucher_date')->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('service_id',$service_id)
            ->get();


        return view('entery.roomservice.foodbill.foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));
    }



    //    return view('entery.roomservice.foodbill.foodbill_print_view');


  public function foodbill_print_view_new($voucher_no)
    {

        $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Check_in')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('entery.roomservice.foodbill.foodbills_print_select', compact('voucher_no', 'fromtlist'));

    }
    //posting foodbill amount to respective account

    public function foodbill_posting(Request $request)
    {


        $transaction_type = 'Foodbill';
        $receipt_remark = $request->food_bill_no . '||' . $request->service_id . '||' . $request->net_bill_amount . '||' . $request->payment_remark;


        $date_variable = $request->voucher_date;

        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_entry_date = $parsed_date->format('Y-m-d');
        $accountname = account::with('accountgroup')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('account_name', 'FoodBill Sales')->first();
        $paymentmode = account::with('accountgroup')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('id', $request->posting_acc_id)->first();

        $payment_data = $request->payment_data;

        if (is_array($payment_data) && !empty($payment_data)) {
            foreach ($payment_data as $payment) {
                if ($payment['amount'] !== Null) {
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
            $ledger->firm_id = Auth::user()->firm_id;
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
            $ledger->firm_id = Auth::user()->firm_id;
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
    public function edit($voucher_no)
    { 
        $foodbill = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_no', $voucher_no)->first();


        $new_bill_no = $foodbill->food_bill_no;

        $new_voucher_no = $foodbill->voucher_no;

        $service_id = $foodbill->service_id;

        $itemrecords = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('voucher_type', 'kot')
            ->where('status', $voucher_no)
            ->groupBy('item_id', 'rate')
            ->get();
            // dd($itemrecords);

        if ($itemrecords->count() > 0) {
            $vouchers = Kot::withinFY('voucher_date')
                ->select(DB::raw('GROUP_CONCAT(DISTINCT voucher_no ORDER BY voucher_no ASC SEPARATOR ",") as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', $voucher_no)
                ->where('voucher_type', 'Kot')
                ->where('firm_id', Auth::user()->firm_id)
                ->value('voucher_nos');

            $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
                })
                ->get();

            $kot_record = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->count();


            $checkinlists = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                ->where('checkout_voucher_no', 0)
                ->where('voucher_no', $service_id)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->get();

            $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
            $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();


            return view('entery.roomservice.foodbill.foodbill_edit_afterselect', compact('new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata', 'itemrecords', 'service_id', 'vouchers', 'paymentmodes', 'foodbill'));

        } else {
            return back()->with('message', 'No Pending Kot Records Found ');
        }


    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request)
    {
                    $date_variable = $request->voucher_date;
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
        

        $settle_status = $request->settle_payment;
        $voucherno = $request->voucher_no;
        $serviceid = $request->service_id;
        $firmId = Auth::user()->firm_id;

        // Fetch the records
        $foodbills = foodbill::withinFY('voucher_date')->where('firm_id', $firmId)
            ->where('service_id', $serviceid)
            ->where('voucher_no', $voucherno)
            ->get();

        $kots = kot::withinFY('voucher_date')->where('firm_id', $firmId)
            ->where('service_id', $serviceid)
            ->where('status', $voucherno) // Assuming you store voucher_no in status temporarily
            ->get();

        $inventories = inventory::withinFY('entry_date')->where('firm_id', $firmId)
            ->where('voucher_no', $voucherno)
            ->where('voucher_type', $request->voucher_type)
            ->get();

        $ledgers = ledger::withinFY('entry_date')->where('firm_id', $firmId)
            ->where('voucher_no', $voucherno)
            ->where('transaction_type', $request->voucher_type)
            ->get();

        // If any of them have records, proceed to delete/update




        //store record to  inventor after foodbill after store to account 
        if (!isset($_POST['approval']) || $_POST['approval'] !== "true") {
            if ($foodbills->isNotEmpty() || $kots->isNotEmpty() || $inventories->isNotEmpty() || $ledgers->isNotEmpty()) {

                // Delete foodbill records
                foreach ($foodbills as $foodbill) {
                    $foodbill->delete();
                }

                // Update kot status to 0 instead of deleting
                foreach ($kots as $kot) {
                    $kot->status = 0;
                    $kot->save();
                }

                // Delete inventory records
                foreach ($inventories as $inventory) {
                    $inventory->delete();
                }

                // Delete ledger records
                foreach ($ledgers as $ledger) {
                    $ledger->delete();
                }
            }


            $date_variable = $request->voucher_date;
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
            $service_id = $request->service_id;
            $records = Kot::withinFY('voucher_date')->with('item')
                ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

                ->where('service_id', $service_id)
                ->where('status', '0')
                ->groupBy('item_id', 'rate')
                ->where('firm_id', Auth::user()->firm_id)
                ->get();

            $account = account::where('account_name', 'FoodBill Sales')->where('firm_id', Auth::user()->firm_id)->first();
            $account_id = $account->id;
            $godown = godown::where('godown_name', 'Kitchen')->where('firm_id', Auth::user()->firm_id)->first();
            $godown_id = $godown->id;


            foreach ($records as $record) {
                $itemrecord = new inventory;
                $itemrecord->firm_id = Auth::user()->firm_id;
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
            $method_type = "Foodbill_update";
        $voucher_no = $request->voucher_no;
        
        $this->sendfoodbillWhatsapp($method_type, $voucher_no);

            //    $settle_payment = $request->settle_payment;

            if ($settle_status == "yes") {
                // dd($request->settle_payment);

                foodbill::withinFY('voucher_date')->where('voucher_no', $request->voucher_no)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->update(['status' => 'direct_bill']);

                $this->foodbill_posting($request);
                return redirect()->route('foodbills.index')->with('message', 'Record saved successfully and bill amount posted to direct sale.');
                // dd($settle_payment);


            } else {
                // return redirect()->route('foodbills.index')->with('message', 'Record saved successfully. Bill amount posted to room.');
                $guest_detail = roomcheckin::withinFY('checkin_date')->select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
                    ->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $request->service_id)->first();
                $foodbill_header = foodbill::withinFY('voucher_date')->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->first();
                $foodbill_items = foodbill::withinFY('voucher_date')->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                     ->where('service_id', $request->service_id)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->get();



                return view('entery.roomservice.foodbill.foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));


            }

        } else {

            //this is code for print approvel bill 
            $inputbagdata = $request->all(); // Extract all input data as an array

            $date_variable = $request->voucher_date;
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
            $service_id = $request->service_id;
            $voucher_no = $request->voucher_no;
            $roomcheckins = roomcheckin::withinFY('checkin_date')->where('voucher_no', $service_id)->where('firm_id', Auth::user()->firm_id)->get();
            $roomcheckins_first = $roomcheckins->first();


            $itemrecords = Kot::withinFY('voucher_date')->with(['item.gstmaster']) // Include gstmaster through the item relationship
                ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', '0')
                ->where('voucher_type', 'Kot')
                ->where('firm_id', Auth::user()->firm_id)
                ->groupBy('item_id', 'rate')
                ->get();




            return view('entery.roomservice.foodbill.room_foodbill_print_Approval', compact('inputbagdata', 'itemrecords', 'roomcheckins', 'roomcheckins_first'));


        }
    }
    //     public function update(Request $request)
//     {



    //         $settle_status=$request->settle_payment;

    // if ($settle_status =="yes") {
//             // dd($request->settle_payment);


    //                     $transaction_type = 'Foodbill';
//         $receipt_remark = $request->food_bill_no . '||' . $request->service_id . '||' . $request->net_bill_amount . '||' . $request->payment_remark;


    //         $date_variable = $request->voucher_date;

    //         $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
//         $formatted_entry_date = $parsed_date->format('Y-m-d');



    // $cashTotal = 0;
// $otherTotal = 0;

    // // Calculate cash and other payments
// foreach ($request->payment_data as $payment) {
//     if (isset($payment['name']) && strtolower($payment['name']) == 'cash') {
//         $cashTotal += (float) $payment['amount'];
//     } else {
//         $otherTotal += (float) $payment['amount'];
//     }
// }

    // // Now update the existing foodbill with voucher_no and firm_id
// Foodbill::withinFY('voucher_date')->where('voucher_no', $request->voucher_no)
//     ->where('firm_id', Auth::user()->firm_id)
//     ->update([
//         'status' => 'direct_bill',
//         'payment_remark' => 'Multi Payment',
//         'foodbill_af1' => $cashTotal,
//         'foodbill_af2' => $otherTotal,
// 'remark' => $request->remark . " | Settle Date: " . $formatted_entry_date,

    //     ]);


    //         $accountname = account::with('accountgroup')
//             ->where('firm_id', Auth::user()->firm_id)
//             ->where('account_name', 'FoodBill Sales')->first();
//         $paymentmode = account::with('accountgroup')
//             ->where('firm_id', Auth::user()->firm_id)
//             ->where('id', $request->posting_acc_id)->first();

    //         $payment_data = $request->payment_data;

    //         if (is_array($payment_data) && !empty($payment_data)) {
//             foreach ($payment_data as $payment) {
//                 if ($payment['amount'] !== Null) {
//                     $paymentmode = account::with('accountgroup')
//                         ->where('firm_id', Auth::user()->firm_id)
//                         ->where('id', $payment['id'])
//                         ->first();

    //                     // Create a ledger entry for each payment mode
//                     $ledger = new ledger;
//                     $ledger->firm_id = Auth::user()->firm_id;
//                     $ledger->voucher_no = $request->voucher_no;
//                     $ledger->reciept_no = $request->food_bill_no;
//                     $ledger->entry_date = $formatted_entry_date;
//                     $ledger->transaction_type = $transaction_type;
//                     $ledger->payment_mode_id = $payment['id'];
//                     $ledger->payment_mode_name = $paymentmode->account_name;
//                     $ledger->account_id = $accountname->id;
//                     $ledger->account_name = $accountname->account_name;
//                     $ledger->account_group_id = $accountname->account_group_id;
//                     $ledger->account_group_name = $accountname->accountgroup->account_group_name;
//                     $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
//                     $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
//                     $ledger->credit = $payment['amount'];
//                     $ledger->amount = $payment['amount'];
//                     $ledger->remark = $receipt_remark;
//                     $ledger->simpal_amount = "-" . $payment['amount'];
//                     $ledger->userid = Auth::user()->id;
//                     $ledger->username = Auth::user()->name;
//                     $ledger->save();

    //                     // Create another ledger entry for the payment mode
//                     $ledger = new ledger;
//                     $ledger->firm_id = Auth::user()->firm_id;
//                     $ledger->voucher_no = $request->voucher_no;
//                     $ledger->reciept_no = $request->food_bill_no;
//                     $ledger->entry_date = $formatted_entry_date;
//                     $ledger->transaction_type = $transaction_type;
//                     $ledger->payment_mode_id = $payment['id'];
//                     $ledger->payment_mode_name = $paymentmode->account_name;
//                     $ledger->account_id = $payment['id'];
//                     $ledger->account_name = $paymentmode->account_name;
//                     $ledger->account_group_id = $paymentmode->account_group_id;
//                     $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
//                     $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
//                     $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
//                     $ledger->debit = $payment['amount'];
//                     $ledger->amount = $payment['amount'];
//                     $ledger->remark = $receipt_remark;
//                     $ledger->simpal_amount = "+" . $payment['amount'];
//                     $ledger->userid = Auth::user()->id;
//                     $ledger->username = Auth::user()->name;
//                     $ledger->save();
//                 }
//             }


    //             return redirect()->route('foodbills.index')->with('message', 'Record saved successfully and bill amount posted to direct sale.');
//             // dd($settle_payment);

    //         }

    //     }
// }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($voucher_no)
    { 

      // ROOM SERVICE FOOD BILL DELETE METHOD   
        $method_type = "Foodbill_delete";
       $this->sendfoodbillWhatsapp($method_type, $voucher_no);
        $foodbills = foodbill::withinFY('voucher_date')->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id);
        $inventory = inventory::withinFY('entry_date')->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)->where('voucher_type', 'Foodbill');
        $ledger = ledger::withinFY('entry_date')->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)->where('transaction_type', 'Foodbill');


        if ($foodbills->count()) {
            $ledger->delete();
            $foodbills->delete();
            $kots = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                ->where('status', $voucher_no)

                ->update(['status' => '0']);
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
    {
        $service_id = $id;

        $itemrecords = Kot::withinFY('voucher_date')->with(['item.gstmaster']) // Include gstmaster through the item relationship
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
            ->where('service_id', $service_id)
            ->where('status', '0')
            ->where('firm_id', Auth::user()->firm_id)
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
    public function fetchkot_foodbilledit(string $id)
    {


        $service_id = $id;

        $itemrecords = Kot::withinFY('voucher_date')->with(['item.gstmaster']) // Include gstmaster through the item relationship
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
            // ->where('service_id', $service_id)
            ->where('status', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->groupBy('item_id', 'rate')
            ->get();

        // $user_id = $id;
        // $itemrecords = tempentry
        // 'user_id', $user_id)->get();

        return response()->json([
            'message' => 'Records fetched successfully for checkin ' . $service_id,
            'status' => 200,
            'itemrecords' => $itemrecords->toArray(),
        ]);
    }


    
    public function sendfoodbillWhatsapp($method_type, $voucher_no)
{
    $firmId = Auth::user()->firm_id;

    // ✅ Check if table exists
    if (!Schema::hasTable('whatsapp_sms')) {
        return back()->with('error', 'WhatsApp template table missing.');
    }

    // ✅ Fetch WhatsApp Template
    $whatsapp = WhatsappSms::where('firm_id', $firmId)
        ->where('transection_type', $method_type)
        ->where('wp_active', '1')
        ->first();

    // ✅ Fetch software company info
    $software_companyInfo = softwarecompany::where('firm_id', $firmId)->first();

    // ✅ Validate configuration
    if (
        !$whatsapp ||
        !$software_companyInfo ||
        empty($software_companyInfo->software_af4) ||
        strtolower($software_companyInfo->software_af4) === 'af'
    ) {
        return back()->with('error', 'WhatsApp not configured or inactive.');
    }

    // ✅ Fetch records

     $wp_record = Foodbill::where('firm_id', $firmId)->where('voucher_no', $voucher_no)->first();

    $componyinfo = Componyinfo::where('firm_id', $firmId)->first();

    if (!$wp_record || !$componyinfo) {
        return back()->with('error', 'Record not found.');
    }

    // ✅ Owner & partner numbers (comma-separated)
    $owner_and_partner_mobile = $componyinfo->componyinfo_af4;

    // ✅ Replace placeholders
    $template = $whatsapp->wp_message;
    $name = Auth::user()->name;

    $placeholders = [
        '{firm_name}' => $componyinfo->cominfo_firm_name,
        '{room_no}' => $wp_record->foodbill_af5,
        '{voucher_no}' => $wp_record->food_bill_no,
        '{bill_date}'=> $wp_record->voucher_date,
        '{customer_name}'=>$wp_record->customer_name,

        '{total_billamount}' => $wp_record->total_bill_value,
        '{room_tariff_perday}' => $wp_record->room_tariff_perday,
        '{total_item}'=>$wp_record->total_item,
        '{total_qty}'=> $wp_record->total_qty,
        '{guest_name}' => $wp_record->customer_name,
        '{checkin_date}' => $wp_record->checkin_date,
        '{check_in_no}' => $wp_record->check_in_no,
        '{address1}' => $componyinfo->cominfo_address1,
        '{address2}' => $componyinfo->cominfo_address2,
        '{city}' => $componyinfo->cominfo_city,
        '{pincode}' => $componyinfo->cominfo_pincode,
        '{state}' => $componyinfo->cominfo_state,
        '{email}' => $componyinfo->cominfo_email,
        '{website}' => $componyinfo->cominfo_field2,
        '{firm_id}' => $firmId,
        '{phone}' => $componyinfo->cominfo_phone,
        '{mobile}' => $componyinfo->cominfo_mobile,
        '{name}' => $name,
    ];

    $message = str_replace(array_keys($placeholders), array_values($placeholders), $template);

    // ✅ WhatsApp API details
    $url = $software_companyInfo->software_af5;
    $authentic_key = $software_companyInfo->software_af4;

    // ✅ Validity check
    $validity_date = Carbon::parse($software_companyInfo->software_af6)->startOfDay();
    $current_date = now()->startOfDay();

    if ($current_date->greaterThan($validity_date)) {
        return "WhatsApp validity has expired. Please recharge.";
    }

    // ✅ Collect numbers
    $numbers = [];

    // 🔸 Add guest number only if NOT destroy
    if ($method_type !== 'Foodbill_delete' && $method_type !== 'Foodbill_update') {
        $numbers[] = preg_replace('/\D/', '', trim($wp_record->mobile));
    
    }

    // 🔸 Add owner/partner numbers
    if (!empty($owner_and_partner_mobile)) {
        $ownerNumbers = explode(',', $owner_and_partner_mobile);
        foreach ($ownerNumbers as $num) {
            $clean = preg_replace('/\D/', '', trim($num));
            if (!empty($clean)) {
                $numbers[] = $clean;
            }
        }
    }

    // ✅ Clean + remove duplicates
    $numbers = array_filter($numbers);
    $numbers = array_map('trim', $numbers);
    $numbers = array_unique($numbers, SORT_STRING);
    $numbers = array_values($numbers);

    // ✅ Send message to each number once
    $success = 0;
    $failed = 0;

    foreach ($numbers as $mobile) {
        $response = Http::get($url, [
            'authentic-key' => $authentic_key,
            'route' => 1,
            'number' => $mobile,
            'message' => $message,
        ]);

        $data = $response->json();

        if (isset($data['status']) && $data['status'] == 'success') {
            $success++;
        } else {
            $failed++;
        }
    }

    // ✅ Final response
    if ($success > 0) {
        return back()->with('message', "WhatsApp sent successfully to {$success} number(s).");
    } else {
        return back()->with('error', "Failed to send WhatsApp message.");
    }
}

}
