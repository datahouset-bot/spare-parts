<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
use App\Models\table;
use App\Models\godown;
use App\Models\ledger;
use App\Models\account;
use App\Models\foodbill;
use App\Models\inventory;
use App\Models\tempentry;
use App\Models\componyinfo;
use App\Models\roomcheckin;
use App\Models\WhatsappSms;
use App\Models\accountgroup;
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


class RestaController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodbills = foodbill::withinFY('voucher_date')->select('firm_id', 'voucher_type', 'net_food_bill_amount', 'total_bill_value', 'total_qty', 'voucher_no', 'food_bill_no', 'service_id', 'voucher_date', 'status', 'user_id', 'customer_name', 'mobile', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
            ->groupBy('firm_id', 'voucher_type', 'net_food_bill_amount', 'voucher_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date', 'customer_name', 'mobile')
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->where('voucher_type', 'Restaurant_food_bill')
            ->where('firm_id', Auth::user()->firm_id)
            ->whereDate('voucher_date', Carbon::today())
            ->get();
        $from_date = Carbon::today();
        $to_date = Carbon::today();




        return view('entery.restaurant.table_foodbill_index', compact('foodbills', 'from_date', 'to_date'));


    }

    public function rest_foodbill_index_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date_format:d-m-Y',
            'to_date' => 'required|date_format:d-m-Y',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');



        $foodbills = foodbill::withinFY('voucher_date')->select('firm_id', 'voucher_type', 'net_food_bill_amount', 'total_bill_value', 'total_qty', 'voucher_no', 'food_bill_no', 'service_id', 'voucher_date', 'status', 'user_id', 'customer_name', 'mobile', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
            ->groupBy('firm_id', 'voucher_type', 'net_food_bill_amount', 'voucher_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date', 'customer_name', 'mobile')
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->where('voucher_type', 'Restaurant_food_bill')
            ->where('firm_id', Auth::user()->firm_id)
            ->whereBetween('voucher_date', [$from_date, $to_date])
            ->get();


        //  kaam karna hai date format me kaam karna hai ki jo date aa rahi wahi usme select ho 

        return view('entery.restaurant.table_foodbill_index', compact('foodbills', 'from_date', 'to_date'));


    }
    public function table_kot_create($tableid)
    {
        $id = Auth::user()->id;

        $tempEntry = tempentry::where('firm_id', Auth::user()->firm_id)
            ->where('user_id', $id)
            ->exists();

        if ($tempEntry) {
            $clearUrl = url('temp_item_delete/' . Auth::user()->id);

            return response('
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">
            <h1 style="color: red; text-align: center; margin-bottom: 20px;">
                Already KOT Created from Another Device or Tab Using the Same User ID
            </h1>
            <button onclick="window.history.back()" style="padding: 10px 20px; font-size: 16px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Go Back
            </button>
            <a href="' . $clearUrl . '" style="margin-top: 20px; padding: 10px 20px; font-size: 16px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">
                Clear All Entry
            </a>
        </div>
    ', 403);
        }



        $this->temp_item_delete($id);


        $kot_record = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_type', 'RKot')->count();
        if ($kot_record > 0) {
            $lastRecord = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'RKot')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'RKot')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }

        $table = table::where('firm_id', Auth::user()->firm_id)->where('id', $tableid)->first();



        $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
        // $itemdata = item::where('firm_id', Auth::user()->firm_id)
        //     ->orderBy('item_name', 'asc')
        //     ->get();
        $itemdata = Item::where('firm_id', Auth::user()->firm_id)
    ->whereHas('itemgroup', function ($query) {
        $query->where('head_group', '!=', 'Raw_Material');
    })
                ->orderBy('item_name', 'asc')
    ->get();



        return view('entery.restaurant.table_kot', compact('new_bill_no', 'new_voucher_no', 'tableid', 'table', 'accountdata', 'itemdata'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function table_foodbill_create($tableid)
    {
        $kot_record = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->count();
      
        if ($kot_record > 0) {
            $lastRecord = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Restaurant_food_bill')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Restaurant_food_bill')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }


        $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
        $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();
        $table = table::where('firm_id', Auth::user()->firm_id)->where('id', $tableid)->first();


        return view('entery.restaurant.table_foodbill_create', compact('new_bill_no', 'new_voucher_no', 'accountdata', 'itemdata', 'tableid', 'table'));




    }


    public function fetchkotRecords(string $id)
    {
        $service_id = $id;
        $table = table::where('id', $service_id)->first();


        $itemrecords = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('status', '0')
            ->where('voucher_type', 'RKot')

            ->groupBy('item_id', 'rate')
            ->get();

        if ($itemrecords->count() > 0) {
            $vouchers = DB::table('kots')
                ->select(DB::raw('GROUP_CONCAT(DISTINCT voucher_no ORDER BY voucher_no ASC SEPARATOR ",") as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', '0')
                ->where('voucher_type', 'RKot')
                ->where('firm_id', Auth::user()->firm_id)
                ->value('voucher_nos');


            $paymentmodes = Account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['Cash In Hand', 'BANK ACCOUNT']);
                })
                ->get()
                ->sortBy(function ($account) {
                    $order = ['Cash In Hand', 'BANK ACCOUNT'];
                    return array_search($account->accountGroup->account_group_name, $order);
                });



            $kot_record = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->count();
            if ($kot_record > 0) {
                $lastRecord = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
                
                $voucher_no = $lastRecord->voucher_no;
                $new_voucher_no = $voucher_no + 1;
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Restaurant_food_bill')->first();
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

            } else {
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_type_name', 'Restaurant_food_bill')->first();

                $voucher_no = $voucher_type->numbring_start_from;
                $new_voucher_no = $voucher_no + 1;
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

            }


            $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
            $itemdata = item::with('itemgroup')->where('firm_id', Auth::user()->firm_id)->get();
            // $creditaccounts = Account::where('firm_id', Auth::user()->firm_id)
            //     ->whereHas('accountGroup', function ($query) {
            //         $query->whereIn('account_group_name', ['Sundry Debtors']);
            //     })
            //     ->get()
            //     ->sortBy(function ($account) {
            //         $order = ['Sundry Debtors'];
            //         return array_search($account->accountGroup->account_group_name, $order);
            //     });

            //    $account_names = roomcheckin::withinFY('checkin_date')->where('firm_id',Auth::user()->firm_id)->with('account')
            //     ->where('checkout_voucher_no', '0')
            //     ->get();
            //    dd($account_names); 
            $sundryDebtors = Account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->where('account_group_name', 'Sundry Debtors');
                })
                ->get(['id', 'account_name']);

            // 2. Get accounts from roomcheckin who are still checked-in
            $checkedInAccounts = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                ->where('checkout_voucher_no', '0') // still checked-in
                ->with('account:id,account_name')   // load related account
                ->get()
                ->pluck('account') // extract account model
                ->filter()         // remove nulls
                ->unique('id');    // remove duplicate accounts

            // 3. Combine both sets of accounts and remove duplicates
            $creditaccounts = $sundryDebtors->merge($checkedInAccounts)->unique('id');

            // 4. Optional: sort by account_name
            $creditaccounts = $creditaccounts->sortBy('account_name');
            $checkinlists = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                ->where('checkout_voucher_no', 0)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->get();

            $sundryGroup = accountgroup::where('firm_id', Auth::user()->firm_id)
                ->where(function ($query) {
                    $query->where('account_group_name', 'Sundry Debtors')
                        ->orWhere('account_group_name', 'Guest Customer');
                })
                ->get();

            // Fetch accounts where group ID is in the list
            $accountnames = account::where('firm_id', Auth::user()->firm_id)
                ->whereIn('account_group_id', $sundryGroup->pluck('id'))
                ->get();








            return view('entery.restaurant.table_foodbill_create_afterselect', compact('new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata', 'itemrecords', 'service_id', 'vouchers', 'paymentmodes', 'creditaccounts', 'table', 'accountnames'));

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
        $records = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('status', '0')
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


    // public function table_foodbills_store(Request $request)
    // {
    //     // dd($request);
    //     $date_variable=$request->voucher_date;
    //     $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
    //      $formatted_voucher_date = $parsed_date->format('Y-m-d');
    //     $service_id =$request->service_id ;
    //     // dd($service_id);
    //     $itemrecords = Kot::with('item')
    //     ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

    //     ->where('service_id', $service_id)
    //     ->where('status', '0')
    //     ->groupBy('item_id', 'rate')
    //     ->get();


    //      foreach($itemrecords as $record){
    //         // return($record);
    //         $newfoodbill= new foodbill;
    //         $newfoodbill->user_id=$request->user_id;
    //         $newfoodbill->user_name=$request->user_name;
    //         $newfoodbill->food_bill_no=$request->food_bill_no;
    //         $newfoodbill->voucher_date=$formatted_voucher_date;
    //         $newfoodbill->voucher_type=$request->voucher_type;
    //         $newfoodbill->voucher_no=$request->voucher_no;
    //         $newfoodbill->service_id=$request->service_id;
    //         $newfoodbill->kot_no=$request->kot_no;
    //         $newfoodbill->posting_acc_id=$request->posting_acc_id;
    //         $newfoodbill->net_food_bill_amount=$request->net_food_bill_amount;
    //         $newfoodbill->payment_remark=$request->payment_remark;
    //         $newfoodbill->food_bill_remark=$request->food_bill_remark;
    //         $newfoodbill->item_id=$record->item_id;
    //         $newfoodbill->item_name=$record->item->item_name;
    //         $newfoodbill->qty=$record->qty;
    //         $newfoodbill->rate=$record->rate;
    //         $newfoodbill->item_base_amount=$record->qty*$record->rate;
    //         $newfoodbill->disc_percent='0';
    //         $newfoodbill->disc_item_amount='0';
    //         $newfoodbill->gst_id=$record->item->gstmaster->id;
    //         $newfoodbill->gst_item_percent=$record->item->gstmaster->igst;
    //         // $newfoodbill->gst_item_amount=$record->item->gstmaster->igst;
    //         $newfoodbill->gst_item_amount=(($record->qty*$record->rate)*($record->item->gstmaster->igst))/100;
    //         $newfoodbill->net_item_amount=((($record->qty*$record->rate)*($record->item->gstmaster->igst))/100)+($record->qty*$record->rate);
    //         $newfoodbill->total_item=$request->total_item;
    //         $newfoodbill->total_qty=$request->total_qty;
    //         $newfoodbill->total_base_amount=$request->total_base_amount;
    //         $newfoodbill->cash_discount='0';
    //         $newfoodbill->total_taxable_amount=$request->total_base_amount;
    //         $newfoodbill->total_gst_amount=$request->total_gst_amount;
    //         $newfoodbill->total_sgst=($request->total_gst_amount)/2;
    //         $newfoodbill->total_cgst=($request->total_gst_amount)/2;
    //         $newfoodbill->total_igst='0';
    //         $newfoodbill->roundoff_amt=$request->round_off;
    //         $newfoodbill->total_amt_after_gst=($request->total_gst_amount)+($request->total_gst_amount);
    //         $newfoodbill->total_bill_value=$request->net_bill_amount;
    //         $newfoodbill->status='0';
    //         $newfoodbill->customer_name=$request->customer_name;
    //         $newfoodbill->address=$request->address;
    //         $newfoodbill->mobile=$request->mobile;
    //         $newfoodbill->remark=$request->remark;

    //         $newfoodbill->save();


    //      }
    //      kot::withinFY('voucher_date')->where('service_id', $request->service_id)->update(['status' => $request->voucher_no]); 

    // }



    public function table_foodbills_store(Request $request)
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
        $service_id = $request->service_id;
        $itemrecords = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
            ->where('voucher_type', 'RKot')
            ->where('service_id', $service_id)
            ->where('status', '0')
            ->groupBy('item_id', 'rate')
            ->get();
        $account_id = account::where('firm_id', Auth::user()->firm_id)->where('id', $request->account_id)->first();


        foreach ($itemrecords as $record) {
            // return($record);
            $itembaseamount = $record->qty * $record->rate;
            $itemdiscountamt = (($record->qty * $record->rate) * $request->dis_percant) / 100;
            $itemgst = $record->item->gstmaster->igst;
            $itemvat = $record->item->gstmaster->vat;
            $itemtax1 = $record->item->gstmaster->tax1;

            $itemtaxableamt = ($itembaseamount - $itemdiscountamt);
            $itemnetamt = $itemtaxableamt + (($itemtaxableamt * $itemgst) / 100) + (($itemtaxableamt * $itemvat) / 100) + ((($itemtaxableamt * $itemvat) / 100) * 10) / 100;


            $newfoodbill = new foodbill;
            $newfoodbill->firm_id = Auth::user()->firm_id;
            $newfoodbill->user_id = $request->user_id;
            $newfoodbill->user_name = $request->user_name;
            $newfoodbill->food_bill_no = $request->food_bill_no;
            $newfoodbill->voucher_date = $formatted_voucher_date;
            $newfoodbill->voucher_type = $request->voucher_type;
            $newfoodbill->voucher_no = $request->voucher_no;

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

            $newfoodbill->total_vat = $request->total_vat_amount;
            $newfoodbill->total_tax1 = $request->total_tax1_amount;

            $newfoodbill->roundoff_amt = $request->round_off;
            $newfoodbill->total_amt_after_gst = ($request->total_gst_amount) + ($request->total_gst_amount);
            $newfoodbill->total_bill_value = $request->net_bill_amount;

            $newfoodbill->customer_name = $request->customer_name;
            $newfoodbill->address = $request->address;
            $newfoodbill->mobile = $request->mobile;

            $newfoodbill->foodbill_af6 = $request->dis_amt_roundoff;


            if ($request->settle_payment === "Cash") {
                $newfoodbill->payment_remark = "Cash";
                $newfoodbill->foodbill_af1 = $request->net_bill_amount;
                $newfoodbill->remark = $request->remark;
                $newfoodbill->service_id = $request->service_id;
                $newfoodbill->status = '0';
                $newfoodbill->foodbill_af5 = " Cash T-" . $request->table_name;

            } elseif ($request->settle_payment === "Credit") {
                $newfoodbill->payment_remark = "Credit";
                $account = account::where('id', $request->credit_account_id)->first();
                $newfoodbill->remark = $account->account_name;

                $newfoodbill->posting_acc_id = $request->credit_account_id;
                $newfoodbill->foodbill_af3 = $request->net_food_bill_amount;
                $newfoodbill->service_id = $request->service_id;
                $newfoodbill->status = '0';

            } elseif ($request->settle_payment === "Room") {
                $checkin_voucherno = $request->room_account_id;
                $checkinlist = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                    ->where('checkout_voucher_no', 0)
                    ->where('voucher_no', $checkin_voucherno)
                    ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'voucher_no')
                    ->first();

                if ($checkinlist) {
                    $newfoodbill->foodbill_af5 = "Settel To Room- " . $checkinlist->room_nos;
                    $newfoodbill->status = '0';
                }

                $newfoodbill->service_id = $checkin_voucherno;
Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
    ->whereIn('voucher_no', explode(',', $request->kot_no))
    ->update(['voucher_type' => 'kot','service_id'=>$checkin_voucherno,'status'=>$request->voucher_no]);
            $newfoodbill->voucher_type = 'Foodbill';
                $newfoodbill->status = '0';
                $newfoodbill->foodbill_af4 = $request->net_food_bill_amount;


            } else {
                $newfoodbill->service_id = $request->service_id;
                $newfoodbill->status = '0';
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
                $newfoodbill->remark = $request->remark;
            }
            if (!empty($account_id)) {
                //manage firm gst and posting gst according gst code 
                $newfoodbill->firm_name = $account_id->account_af1;
                $newfoodbill->gst_no = $account_id->gst_no;
                $newfoodbill->bill_type = 'B2B';

                $account_gst_code = $account_id->gst_code;
                $comp_detail = componyinfo::where('firm_id', Auth::user()->firm_id)->first();
                $comp_gst_code = $comp_detail->cominfo_field1;
                if ($account_gst_code != $comp_gst_code) {
                    $newfoodbill->total_sgst = '0';
                    $newfoodbill->total_cgst = '0';
                    $newfoodbill->total_igst = $request->total_gst_amount;
                } else {
                    $newfoodbill->total_sgst = ($request->total_gst_amount) / 2;
                    $newfoodbill->total_cgst = ($request->total_gst_amount) / 2;
                    $newfoodbill->total_igst = '0';




                }




            } else {

                $newfoodbill->total_sgst = ($request->total_gst_amount) / 2;
                $newfoodbill->total_cgst = ($request->total_gst_amount) / 2;
                $newfoodbill->total_igst = '0';

            }


            $newfoodbill->save();


        }
        $kotvoucher_no = explode(',', $request->kot_no);

        kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
            ->where('service_id', $request->service_id)
            ->where('voucher_type', 'RKot')
            ->whereIn('voucher_no', $kotvoucher_no)
            ->update(['status' => $request->voucher_no]);

    }


    public function store(Request $request)
    {

        //  DD($request);

        $existingRecords = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)->where('transaction_type', $request->voucher_type)
        ->where('voucher_no', $request->voucher_no)
        ->count();

        if ($existingRecords >= 2) {
            return response()->json(['error' => 'Records already exist for this transaction type and voucher number and Please Dont Reloade and resubmit Same Entry .'], 400);
        }

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
            $records = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
                ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

                ->where('service_id', $service_id)
                ->where('status', '0')

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
            //----------------------------


            $this->table_foodbills_store($request); //store the record on foodbill
            
 
        $method_type = "Restaurant_food_bill_store";
        $voucher_no = $request->voucher_no;
     
 
        $this->sendfoodbillWhatsapp($method_type, $voucher_no);

            

            // $posting_acc_id = $request->posting_acc_id;
            // if ($posting_acc_id > 0) {



            if ($request->settle_payment === "Cash") {

                // Proceed with your logic


                foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']);
                $this->foodbill_posting_cash($request);
                $foodbill_header = foodbill::withinFY('voucher_date')->where('foodbills.firm_id', Auth::user()->firm_id)
                    ->where('foodbills.user_id', Auth::user()->id)
                    ->where('foodbills.voucher_no', $request->voucher_no)
                    ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
                    ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
                    ->first();
                    // dd($foodbill_header);

                $foodbill_items = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->where('service_id', $request->service_id)
                    ->get();
                return view('entery.restaurant.table_foodbill_print_view', compact('foodbill_header', 'foodbill_items'));

            } elseif ($request->settle_payment === "Credit") {

                foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']);
                $this->foodbill_posting_credit($request);
                $foodbill_header = foodbill::withinFY('voucher_date')->where('foodbills.firm_id', Auth::user()->firm_id)
                    ->where('foodbills.user_id', Auth::user()->id)
                    ->where('foodbills.voucher_no', $request->voucher_no)
                    ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
                    ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
                    ->first();

                $foodbill_items = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->where('service_id', $request->service_id)
                    ->get();
                return view('entery.restaurant.table_foodbill_print_view', compact('foodbill_header', 'foodbill_items'));


            } elseif ($request->settle_payment === "Room") {

                $guest_detail = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)->where('checkout_voucher_no', 0)
                    ->select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
                    ->where('voucher_no', $request->room_account_id)->first();


                $foodbill_header = foodbill::withinFY('voucher_date')->where('foodbills.firm_id', Auth::user()->firm_id)
                    ->where('foodbills.user_id', Auth::user()->id)
                    ->where('foodbills.service_id', $request->room_account_id)
                    ->where('voucher_no', $request->voucher_no)
                    // ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
                    // ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
                    ->first();
                // dd( $foodbill_header);

                $foodbill_items = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('user_id', $request->user_id)
                    ->where('service_id', $request->room_account_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->get();

 
                return view('entery.restaurant.table_foodbill_print_view', compact('foodbill_header', 'foodbill_items', 'guest_detail'));


            } else {

                $this->foodbill_posting($request);
                // return redirect()->route('foodbills.index')->with('message', 'Record saved successfully. Bill amount posted to room.');
                foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']);
                $guest_detail = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)->where('checkout_voucher_no', 0)
                    ->select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
                    ->where('voucher_no', $request->service_id)->first();


                $foodbill_header = foodbill::withinFY('voucher_date')->where('foodbills.firm_id', Auth::user()->firm_id)
                    ->where('foodbills.user_id', Auth::user()->id)
                    ->where('foodbills.voucher_no', $request->voucher_no)
                    ->where('foodbills.service_id', $request->service_id)
                    ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
                    ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
                    ->first();



                // Debugging Output
                if (!$foodbill_header) {
                    dd("No matching foodbill found!");
                } elseif (!$foodbill_header->table_name) {
                    dd("Table name not found for service_id: " . $foodbill_header->service_id);
                }


                $foodbill_items = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                    ->where('user_id', $request->user_id)
                    ->where('service_id', $request->service_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->get();



                return view('entery.restaurant.table_foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));



            }
        } else {
            $inputbagdata = $request->all(); // Extract all input data as an array

            $date_variable = $request->voucher_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_voucher_date = $parsed_date->format('Y-m-d');
            $service_id = $request->service_id;
            $table = table::where('firm_id', Auth::user()->firm_id)->where('id', $service_id)->first();

            $itemrecords = Kot::with(['item.gstmaster']) // Include gstmaster through the item relationship
                ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', '0')
                ->where('voucher_type', 'RKot')
                ->where('firm_id', Auth::user()->firm_id)
                ->groupBy('item_id', 'rate')
                ->get();




            return view('entery.restaurant.table_foodbill_print_Approval', compact('inputbagdata', 'itemrecords', 'table'));


        }




    }


    public function table_foodbill_print_view($voucher_no)
    {
        //  dd($voucher_no);
        $foodbill_header = foodbill::withinFY('voucher_date')->where('foodbills.firm_id', Auth::user()->firm_id)
            // ->where('foodbills.user_id', Auth::user()->id)
            ->where('foodbills.voucher_no', $voucher_no)
            ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
            ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
            ->first();
        //   dd($foodbill_header);
        // Debugging Output
        if (!$foodbill_header) {
            return "no record found ";
        } elseif (!$foodbill_header->table_name) {
            dd("Table name not found for service_id: " . $foodbill_header->service_id);
        }


        $service_id = $foodbill_header->service_id;
        //       $guest_detail = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
        //     ->select('guest_name','guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
        //    ->groupBy('guest_name', 'guest_mobile','voucher_no')
        //    ->where('voucher_no',$service_id )->first();

        $foodbill_items = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->where('service_id', $service_id)
            ->get();


        return view('entery.restaurant.table_foodbill_print_view', compact('foodbill_header', 'foodbill_items'));
    }




    //posting foodbill amount to respective account


    public function foodbill_posting(Request $request)
    {
        $transaction_type = 'Restaurant_food_bill';
        $receipt_remark = $request->food_bill_no . '||' . $request->service_id . '||' . $request->net_food_bill_amount . '||' . $request->payment_remark;

        // Parse and format the date
        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_entry_date = $parsed_date->format('Y-m-d');

        // Retrieve account details
        $accountname = account::with('accountgroup')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('account_name', 'FoodBill Sales')
            ->first();

        $payment_data = $request->payment_data;

        // Check if payment_data is present and contains records
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
            // Handle the case where no payment_data is provided
            $paymentmode = account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('id', $request->posting_acc_id)
                ->first();

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
        }
    }


    public function foodbill_posting_cash(Request $request)
    {


        $transaction_type = 'Restaurant_food_bill';
        $receipt_remark = $request->food_bill_no . '||' . $request->service_id . '||' . $request->net_bill_amount . '||' . $request->payment_remark;


        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_entry_date = $parsed_date->format('Y-m-d');
        $accountname = account::where('firm_id', Auth::user()->firm_id)->with('accountgroup')
            ->where('account_name', 'FoodBill Sales')->first();
        //  dd($accountname->id);

        $posting_acc_id = account::where('firm_id', Auth::user()->firm_id)->with('accountgroup')
            ->where('account_name', 'Cash')->first()->id;


        $paymentmode = account::with('accountgroup')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('id', $posting_acc_id)->first();

        $ledger = new ledger;
        $ledger->firm_id = Auth::user()->firm_id;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->food_bill_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = $transaction_type;
        $ledger->payment_mode_id = $posting_acc_id;
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
        $ledger->save();


        $ledger = new ledger;
        $ledger->firm_id = Auth::user()->firm_id;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->food_bill_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = $transaction_type;
        $ledger->payment_mode_id = $posting_acc_id;
        $ledger->payment_mode_name = $accountname->account_name;
        $ledger->account_id = $posting_acc_id;
        $ledger->account_name = $paymentmode->account_name;
        $ledger->account_group_id = $paymentmode->account_group_id;
        $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
        $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
        $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
        $ledger->debit = $request->net_food_bill_amount;
        $ledger->amount = $request->net_food_bill_amount;
        $ledger->remark = $receipt_remark;
        $ledger->simpal_amount = "+" . $request->net_food_bill_amount;
        $ledger->save();

    }
    public function foodbill_posting_credit(Request $request)
    {

        $credit_account_id = $request->credit_account_id;



        $transaction_type = 'Restaurant_food_bill';
        $receipt_remark = $request->food_bill_no . '||' . $request->service_id . '||' . $request->net_bill_amount . '||' . $request->payment_remark;


        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_entry_date = $parsed_date->format('Y-m-d');
        $accountname = account::where('firm_id', Auth::user()->firm_id)->with('accountgroup')
            ->where('account_name', 'FoodBill Sales')->first();
        //  dd($accountname->id);

        $posting_acc_id = $credit_account_id;


        $paymentmode = account::with('accountgroup')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('id', $posting_acc_id)->first();

        $ledger = new ledger;
        $ledger->firm_id = Auth::user()->firm_id;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->food_bill_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = $transaction_type;
        $ledger->payment_mode_id = $posting_acc_id;
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
        $ledger->save();


        $ledger = new ledger;
        $ledger->firm_id = Auth::user()->firm_id;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->food_bill_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = $transaction_type;
        $ledger->payment_mode_id = $posting_acc_id;
        $ledger->payment_mode_name = $accountname->account_name;
        $ledger->account_id = $posting_acc_id;
        $ledger->account_name = $paymentmode->account_name;
        $ledger->account_group_id = $paymentmode->account_group_id;
        $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
        $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
        $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
        $ledger->debit = $request->net_food_bill_amount;
        $ledger->amount = $request->net_food_bill_amount;
        $ledger->remark = $receipt_remark;
        $ledger->simpal_amount = "+" . $request->net_food_bill_amount;
        $ledger->save();


    }




    public function destroy($voucher_no)
    {
         $method_type = "Restaurant_food_bill_delete";
        
        $this->sendfoodbillWhatsapp($method_type, $voucher_no);

        // Fetch foodbills with the given voucher_no
        $foodbills = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)->where('voucher_type', 'Restaurant_food_bill');
        $inventory = inventory::where('firm_id', Auth::user()->firm_id)->
            where('voucher_no', $voucher_no)->where('voucher_type', 'Restaurant_food_bill');

        // Check if any foodbills were found
        if ($foodbills->count()) {
            // Fetch the ledger with the corresponding transaction_type and voucher_no
            $ledger = ledger::withinFY('entry_date')->where('firm_id', Auth::user()->firm_id)
                ->where('transaction_type', 'Restaurant_food_bill')
                ->where('voucher_no', $voucher_no);

            // Check if a matching ledger entry was found
            if ($ledger->count()) {
                // Delete the ledger entry
                $ledger->delete();
            }

            // Delete the foodbillsww
            $foodbills->delete();
            $kotdata = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_type', 'RKot')
                ->where('status', $voucher_no)->update(['status' => '0']);


            if ($inventory->count()) {
                $inventory->delete();
            }
            return back()->with('message', 'Record Deleted ' . $voucher_no);
        } else {
            return back()->with('errors', 'No Record Found');
        }
    }
    public function temp_item_delete($id)
    {
        $user_id = $id;
        $itemrecords = tempentry::where('firm_id', Auth::user()->firm_id)
            ->where('user_id', $user_id);
        if ($itemrecords->count()) {
            $itemrecords->delete();
            return back()->with('message', 'Welcome on New Kot ');
        } else {
            return back()->with('message', 'Please Add Items   ');
        }




    }
    public function editxx($voucher_no)
    {




        $foodbilldata = foodbill::withinFY('voucher_date')->where('voucher_no', $voucher_no)->where('firm_id', Auth::user()->firm_id)->get();
        $foodbilldatafirst = $foodbilldata->first();
        // dd($foodbilldatafirst);
        $paymentmodes = Account::where('firm_id', Auth::user()->firm_id)
            ->whereHas('accountGroup', function ($query) {
                $query->whereIn('account_group_name', ['Cash In Hand', 'BANK ACCOUNT']);
            })
            ->get()
            ->sortBy(function ($account) {
                $order = ['Cash In Hand', 'BANK ACCOUNT'];
                return array_search($account->accountGroup->account_group_name, $order);
            });





        foreach ($foodbilldata as $item) {
            $tempkot = new tempentry();
            $tempkot->firm_id = Auth::user()->firm_id;
            $tempkot->user_id = Auth::user()->id;
            $tempkot->user_name = Auth::user()->name;
            $tempkot->entry_date = now();
            $tempkot->voucher_date = $item->voucher_date;
            $tempkot->voucher_no = $item->voucher_no;
            $tempkot->voucher_type = $item->voucher_type;
            $tempkot->bill_no = $item->food_bill_no;
            $tempkot->item_id = $item->item_id;
            $tempkot->item_name = $item->item_name;
            $tempkot->qty = $item->qty;
            $tempkot->rate = $item->rate;
            $tempkot->dis_percent = $item->dis_percent ?? 0;
            $tempkot->dis_amt = $item->dis_amt ?? 0;
            $tempkot->total_discount = $item->total_discount ?? 0;
            $tempkot->item_gst_id = $item->gst_item_percent;
            $tempkot->total_gst = $item->gst_item_amount ?? 0;
            $tempkot->item_net_value = ($item->qty * $item->rate) + $item->gst_item_amount;
            $tempkot->customer_id = $item->account_id;

            $tempkot->item_gst_name = $item->gst_id; // GST ID from GST master

            // Calculate amount and total amount
            $tempkot->amount = $item->qty * $item->rate;
            $tempkot->total_amount = ($item->qty * $item->rate) - ($item->total_discount ?? 0);

            // Store godown ID and account ID
            $tempkot->temp_af1 = $item->godown_id;
            $tempkot->account_id = $item->account_id;

            // Save to the database
            $tempkot->save();
        }





        return view('entery.restaurant.table_foodbill_edit_afterselect', compact('foodbilldata', 'foodbilldatafirst', 'paymentmodes'));



    }

    public function edit($voucher_no, $tableid)
    {
        $foodbilldata = foodbill::withinFY('voucher_date')->where('voucher_no', $voucher_no)->where('firm_id', Auth::user()->firm_id)->first();


        $kot_record = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->count();
        $voucher_type = $foodbilldata->voucher_type;
        $new_voucher_no = $foodbilldata->voucher_no;

        $new_bill_no = $foodbilldata->food_bill_no;



        $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
        $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();
        $table = table::where('firm_id', Auth::user()->firm_id)->where('id', $tableid)->first();


        return view('entery.restaurant.table_foodbill_edit', compact('new_bill_no', 'new_voucher_no', 'accountdata', 'itemdata', 'tableid', 'table', 'foodbilldata'));




    }
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

        $voucher_no = $request->voucher_no;
        $service_id = $request->voucher_no;


        $foodbills = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_no', $voucher_no)
            ->where('voucher_type', 'Restaurant_food_bill');



        // Check if any foodbills were found
        if ($foodbills->count()) {
            $foodbills->delete();








            // Fetch the ledger with the corresponding transaction_type and voucher_no
            $ledger = ledger::withinFY('entry_date')->where('firm_id', Auth::user()->firm_id)
                ->where('transaction_type', 'Restaurant_food_bill')
                ->where('voucher_no', $voucher_no);

            // Check if a matching ledger entry was found
            if ($ledger->count()) {
                // Delete the ledger entry
                $ledger->delete();
            }





            // Delete the foodbillsww




        }



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
            Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                ->where('service_id', $service_id)
                ->where('status', $voucher_no)
                ->update(['status' => 0]);
            $records = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
                ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

                ->where('service_id', $service_id)
                ->where('status', 0)


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
            //----------------------------


            $this->table_foodbills_store($request); //store the record on foodbill

                            $method_type = "Restaurant_food_bill_update";
        $voucher_no = $request->voucher_no;
        
        $this->sendfoodbillWhatsapp($method_type, $voucher_no);


            // $posting_acc_id = $request->posting_acc_id;
            // if ($posting_acc_id > 0) {



            if ($request->settle_payment === "Cash") {

                // Proceed with your logic


                foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']);
                $this->foodbill_posting_cash($request);
                $foodbill_header = foodbill::withinFY('voucher_date')->where('foodbills.firm_id', Auth::user()->firm_id)
                    ->where('foodbills.user_id', Auth::user()->id)
                    ->where('foodbills.voucher_no', $request->voucher_no)
                    ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
                    ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
                    ->first();

                $foodbill_items = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->where('service_id', $foodbill_header->service_id)
                    ->get();


                return view('entery.restaurant.table_foodbill_print_view', compact('foodbill_header', 'foodbill_items'));

            } elseif ($request->settle_payment === "Credit") {

                foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']);
                $this->foodbill_posting_credit($request);
                $foodbill_header = foodbill::withinFY('voucher_date')->where('foodbills.firm_id', Auth::user()->firm_id)
                    ->where('foodbills.user_id', Auth::user()->id)
                    ->where('foodbills.voucher_no', $request->voucher_no)
                    ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
                    ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
                    ->first();

                $foodbill_items = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->wher('voucher_no', $service_id)
                    ->get();
                return view('entery.restaurant.table_foodbill_print_view', compact('foodbill_header', 'foodbill_items'));


            } else {

                $this->foodbill_posting($request);
                // return redirect()->route('foodbills.index')->with('message', 'Record saved successfully. Bill amount posted to room.');
                foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']);
                $guest_detail = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)->where('checkout_voucher_no', 0)
                    ->select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
                    ->where('voucher_no', $request->service_id)->first();


                $foodbill_header = foodbill::withinFY('voucher_date')->where('foodbills.firm_id', Auth::user()->firm_id)
                    ->where('foodbills.user_id', Auth::user()->id)
                    ->where('foodbills.voucher_no', $request->voucher_no)
                    ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
                    ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
                    ->first();



                // Debugging Output
                if (!$foodbill_header) {
                    dd("No matching foodbill found!");
                } elseif (!$foodbill_header->table_name) {
                    dd("Table name not found for service_id: " . $foodbill_header->service_id);
                }


                $foodbill_items = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                    ->where('user_id', $request->user_id)
                    ->where('voucher_no', $request->voucher_no)
                    ->where('service_id', $request->service_id)

                    ->get();


                    



                return view('entery.restaurant.table_foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));



            }
        } else {
            $inputbagdata = $request->all(); // Extract all input data as an array

            $date_variable = $request->voucher_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_voucher_date = $parsed_date->format('Y-m-d');
            $service_id = $request->service_id;
            $table = table::where('firm_id', Auth::user()->firm_id)->where('id', $service_id)->first();

            $itemrecords = Kot::with(['item.gstmaster']) // Include gstmaster through the item relationship
                ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', '0')
                ->where('voucher_type', 'RKot')
                ->where('firm_id', Auth::user()->firm_id)
                ->groupBy('item_id', 'rate')
                ->get();




            return view('entery.restaurant.table_foodbill_print_Approval', compact('inputbagdata', 'itemrecords', 'table'));


        }







    }

    public function settle_show($voucher_no, $tableid)
    {
        $service_id = $tableid;
        $foodbilldata = foodbill::withinFY('voucher_date')->where('voucher_no', $voucher_no)->where('firm_id', Auth::user()->firm_id)->first();
        $table = table::where('id', $tableid)->where('firm_id', Auth::user()->firm_id)->first();


        $itemrecords = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('status', $voucher_no)
            ->where('voucher_type', 'RKot')

            ->groupBy('item_id', 'rate')
            ->get();

        if ($itemrecords->count() > 0) {
            $vouchers = DB::table('kots')
                ->select(DB::raw('GROUP_CONCAT(DISTINCT voucher_no ORDER BY voucher_no ASC SEPARATOR ",") as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', $voucher_no)
                ->where('voucher_type', 'RKot')
                ->where('firm_id', Auth::user()->firm_id)
                ->value('voucher_nos');


            $paymentmodes = Account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['Cash In Hand', 'BANK ACCOUNT']);
                })
                ->get()
                ->sortBy(function ($account) {
                    $order = ['Cash In Hand', 'BANK ACCOUNT'];
                    return array_search($account->accountGroup->account_group_name, $order);
                });



            $kot_record = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->count();
            if ($kot_record > 0) {
                $lastRecord = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
                $new_voucher_no = $voucher_no;
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Restaurant_food_bill')->first();
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $foodbilldata->food_bill_no;


            } else {
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_type_name', 'Restaurant_food_bill')->first();


                $new_voucher_no = $voucher_no;
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_no;
            }

            $checkinlists = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)->where('checkout_voucher_no', 0)
                ->where('voucher_no', $service_id)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->get();

            $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
            $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();

            $creditaccounts = Account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['Sundry Debtors']);
                })
                ->get()
                ->sortBy(function ($account) {
                    $order = ['Sundry Debtors'];
                    return array_search($account->accountGroup->account_group_name, $order);
                });
            $sundryGroup = accountgroup::where('firm_id', Auth::user()->firm_id)
                ->where(function ($query) {
                    $query->where('account_group_name', 'Sundry Debtors')
                        ->orWhere('account_group_name', 'Guest Customer');
                })
                ->get();
            $accountnames = account::where('firm_id', Auth::user()->firm_id)
                ->whereIn('account_group_id', $sundryGroup->pluck('id'))
                ->get();
            return view('entery.restaurant.table_foodbill_edit_afterselect', compact('foodbilldata', 'new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata', 'itemrecords', 'service_id', 'vouchers', 'paymentmodes', 'creditaccounts', 'table', 'accountnames'));

        } else {
            return back()->with('message', 'No Pending Kot Records Found ');
        }

    }

    public function rkot_destroy($voucher_no)
    {

        $kots = kot::withinFY('voucher_date')->where('voucher_no', $voucher_no)->where('firm_id', Auth::user()->firm_id)
            ->where('status', '0')->where('voucher_type', 'RKot');

        if ($kots->count()) {
            $kots->delete();
            return back()->with('message', 'Record Deleteted ' . $voucher_no);
        } else {
            return back()->with('errors', 'Check Your Kot Converted on Bill So That We Can Not Delete It    ');
        }

    }
    public function resta_fetchkot(string $id)
    {
        $service_id = $id;

        $itemrecords = Kot::with(['item.gstmaster']) // Include gstmaster through the item relationship
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
            ->where('service_id', $service_id)
            ->where('status', '0')
            ->where('voucher_type', 'RKot')
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


    public function resta_fetchkot_edit($voucher_no, $id)
    {
        $service_id = $id;

        $itemrecords = Kot::with(['item.gstmaster']) // Include gstmaster through the item relationship
            ->select(
                'item_id',
                DB::raw('SUM(qty) as qty'),
                'rate',
                DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos')
            )
            ->where('service_id', $service_id)
            ->where('status', $voucher_no)
            ->where('voucher_type', 'RKot')
            ->where('firm_id', Auth::user()->firm_id)
            ->groupBy('item_id', 'rate')
            ->get();



        return response()->json([
            'message' => "Records fetched successfully for check-in (Voucher No: $voucher_no, Service ID: $service_id)",
            'status' => 200,
            'itemrecords' => $itemrecords->toArray(),
        ]);
    }


    public function restaurant_kot()
    {  
        $kots = kot::withinFY('voucher_date')->where(function ($query) {
            $query->where('kots.status', 'cancel')
                ->orWhere('kots.status', '0');
        })
            ->join('tables', 'kots.service_id', '=', 'tables.id') // Joining tables to get table_name
            ->select(
                'kots.voucher_type',
                'kots.total_amount',
                'kots.total_qty',
                'kots.voucher_no',
                'kots.bill_no',
                'kots.service_id',
                'tables.table_name', // Selecting table_name
                'kots.voucher_date',
                'kots.status',
                'kots.user_id',
                'kots.kot_remark',
                'kots.ready_to_serve',
                DB::raw('GROUP_CONCAT(kots.voucher_no ORDER BY kots.voucher_date SEPARATOR ",") as room_nos')
            )
            ->groupBy(
                'kots.voucher_type',
                'kots.voucher_no',
                'kots.total_amount',
                'kots.total_qty',
                'kots.bill_no',
                'kots.service_id',
                'tables.table_name', // Include table_name in groupBy
                'kots.status',
                'kots.user_id',
                'kots.voucher_date',
                'kots.ready_to_serve',
                'kots.kot_remark',
            )
            ->where('kots.firm_id', Auth::user()->firm_id)
            ->where('kots.voucher_type', 'RKot')
            ->orderByRaw('CAST(kots.voucher_no AS UNSIGNED) DESC')
            ->get();

        return view('entery.roomservice.kot.Rkot_index', compact('kots'));
    }

    public function kot_register_pageshow()
    {
        $kots = kot::join('tables', 'kots.service_id', '=', 'tables.id') // Joining tables to get table_name
            ->select(
                'kots.voucher_type',
                'kots.total_amount',
                'kots.total_qty',
                'kots.voucher_no',
                'kots.bill_no',
                'kots.service_id',
                'tables.table_name', // Selecting table_name
                'kots.voucher_date',
                'kots.status',
                'kots.user_id',
                'kots.kot_remark',
                'kots.ready_to_serve',
                DB::raw('GROUP_CONCAT(kots.voucher_no ORDER BY kots.voucher_date SEPARATOR ",") as room_nos')
            )
            ->groupBy(
                'kots.voucher_type',
                'kots.voucher_no',
                'kots.total_amount',
                'kots.total_qty',
                'kots.bill_no',
                'kots.service_id',
                'tables.table_name', // Include table_name in groupBy
                'kots.status',
                'kots.user_id',
                'kots.voucher_date',
                'kots.ready_to_serve',
                'kots.kot_remark',
            )
            ->where('kots.firm_id', Auth::user()->firm_id)
            ->whereDate('voucher_date', Carbon::today())
            ->orderByRaw('CAST(kots.voucher_no AS UNSIGNED) DESC')
            ->get();

        $from_date = Carbon::today();
        $to_date = Carbon::today();




        return view('entery.restaurant.kot_register_pageshow', compact('kots', 'from_date', 'to_date'));



    }

    public function kot_register_result(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date_format:d-m-Y',
            'to_date' => 'required|date_format:d-m-Y',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');

        $kots = kot::join('tables', 'kots.service_id', '=', 'tables.id') // Joining tables to get table_name
            ->select(
                'kots.voucher_type',
                'kots.total_amount',
                'kots.total_qty',
                'kots.voucher_no',
                'kots.bill_no',
                'kots.service_id',
                'tables.table_name', // Selecting table_name
                'kots.voucher_date',
                'kots.status',
                'kots.user_id',
                'kots.kot_remark',
                'kots.ready_to_serve',
                DB::raw('GROUP_CONCAT(kots.voucher_no ORDER BY kots.voucher_date SEPARATOR ",") as room_nos')
            )
            ->groupBy(
                'kots.voucher_type',
                'kots.voucher_no',
                'kots.total_amount',
                'kots.total_qty',
                'kots.bill_no',
                'kots.service_id',
                'tables.table_name', // Include table_name in groupBy
                'kots.status',
                'kots.user_id',
                'kots.voucher_date',
                'kots.ready_to_serve',
                'kots.kot_remark',
            )
            ->where('kots.firm_id', Auth::user()->firm_id)
            ->whereBetween('voucher_date', [$from_date, $to_date])
            ->orderByRaw('CAST(kots.voucher_no AS UNSIGNED) DESC')

            ->when($request->type == 'kot', function ($query) {
        return $query->where('kots.voucher_type', 'kot');
    })
     ->when($request->type == 'Rkot', function ($query) {
        return $query->where('kots.voucher_type', 'Rkot');
    })
->when($request->type == 'clear_kot', function ($query) {
    return $query->where('kots.voucher_type', 'kot')
                 ->where('kots.status', '!=', 0);
})
->when($request->type == 'clear_Rkot', function ($query) {
    return $query->where('kots.voucher_type', 'Rkot')
                 ->where('kots.status', '!=', 0);
})
->when($request->type == 'cancel_kot', function ($query) {
    return $query->where('kots.voucher_type', 'kot')
                 ->where('kots.status',  'cancel');
})
->when($request->type == 'cancel_Rkot', function ($query) {
    return $query->where('kots.voucher_type', 'Rkot')
                 ->where('kots.status',  'cancel');
})

            ->get();


        return view('entery.restaurant.kot_register_pageshow', compact('kots', 'from_date', 'to_date'));


    }

    public function table_wise_item()
    {
        //page show
        $tables = table::where('firm_id', Auth::user()->firm_id)->get();


        return view('entery.roomservice.kot.Rkot_register_pageshow', compact('tables'));


    }
    public function nckot_register()
    {
        //page show
        $tableIds = Table::where('firm_id', Auth::user()->firm_id)
            ->where('table_group', 'Nc')
            ->pluck('id'); // returns a collection of IDs

        // Fetch KOTs for those tables
        $kots = Kot::with('user')
            ->where(function ($query) {
                $query->where('status', 'Nc')
                    ->orWhere('status', 'cancel');
            })
            ->where('firm_id', Auth::user()->firm_id)
            ->whereIn('service_id', $tableIds) // get KOTs for all the table IDs
            ->orderBy('voucher_no', 'desc')
            ->get();



        return view('entery.roomservice.kot.Nckot_register_result', compact('kots'));
    }

    public function table_wise_item_result($table_id)
    {
        $kots = Kot::with('user')
            ->where('status', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('service_id', $table_id)
            ->orderBy('voucher_no', 'desc')
            ->get();


        $table_name = table::where('firm_id', Auth::user()->firm_id)
            ->where('id', $table_id)
            ->first()
            ->table_name;

        return view('entery.roomservice.kot.Rkot_register_result', compact('kots', 'table_name'));
    }


    public function rkot_edit($voucher_no)
    {
        $kots_items = kot::withinFY('voucher_date')->where('voucher_no', $voucher_no)
            ->where('voucher_type', 'Rkot')
            ->where('firm_id', Auth::user()->firm_id)
            ->get();
        $kot_firstrecord = $kots_items->first();
        $table = table::where('firm_id', Auth::user()->firm_id)->where('id', $kot_firstrecord->service_id)->first();
        $tableid = $kot_firstrecord->service_id;
        $voucher_terms = $kot_firstrecord->voucher_terms;

        $new_bill_no = $kot_firstrecord->bill_no;
        $new_voucher_no = $voucher_no;
        $user_id = $kot_firstrecord->user_id;
        $this->temp_item_delete($user_id);

        foreach ($kots_items as $item) {
            $tempkot = new tempentry();
            $tempkot->firm_id = Auth::user()->firm_id;
            $tempkot->user_id = Auth::user()->id;
            $tempkot->user_name = Auth::user()->name;
            $tempkot->entry_date = now();
            $tempkot->voucher_date = $item->voucher_date;
            $tempkot->voucher_no = $item->voucher_no;
            $tempkot->voucher_type = $item->voucher_type;
            $tempkot->bill_no = $item->bill_no;
            $tempkot->sale_to_voucher_no = $tableid;
            $tempkot->item_id = $item->item_id;
            $tempkot->item_name = $item->item_name;
            $tempkot->qty = $item->qty;
            $tempkot->rate = $item->rate;
            $tempkot->dis_percent = $item->dis_percent ?? 0;
            $tempkot->dis_amt = $item->dis_amt ?? 0;
            $tempkot->total_discount = $item->total_discount ?? 0;
            $tempkot->item_gst_id = $item->gst_item_percent;
            $tempkot->total_gst = $item->gst_item_amount ?? 0;
            $tempkot->item_net_value = ($item->qty * $item->rate) + $item->gst_item_amount;
            $tempkot->customer_id = $item->account_id;

            $tempkot->item_gst_name = $item->gst_id; // GST ID from GST master

            $tempkot->amount = $item->qty * $item->rate;
            $tempkot->total_amount = ($item->qty * $item->rate) - ($item->total_discount ?? 0);

            // Store godown ID and account ID
            $tempkot->account_id = $item->account_id;
            $tempkot->temp_af1 = $item->created_at->format('H:i');


            // Save to the database
            $tempkot->save();
        }


        $id = Auth::user()->id;








        $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
        $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();


        return view('entery.restaurant.table_rkot_edit', compact('new_bill_no', 'new_voucher_no', 'tableid', 'table', 'accountdata', 'itemdata'));

    }



    public function fetchkotRecords_edit($voucher_no, $id, $only_settel)
    {
        $service_id = $id;
        $foodbilldata = foodbill::withinFY('voucher_date')->where('voucher_no', $voucher_no)->where('firm_id', Auth::user()->firm_id)->first();
        $table = table::where('id', $id)->where('firm_id', Auth::user()->firm_id)->first();
// dd($table);

        $itemrecords = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('status', $voucher_no)
            ->where('voucher_type', 'RKot')

            ->groupBy('item_id', 'rate')
            ->get();
            

        if ($itemrecords->count() > 0) {
            $vouchers = DB::table('kots')
                ->select(DB::raw('GROUP_CONCAT(DISTINCT voucher_no ORDER BY voucher_no ASC SEPARATOR ",") as voucher_nos'))
                ->where('service_id', $service_id)
                ->where('status', $voucher_no)
                ->where('voucher_type', 'RKot')
                ->where('firm_id', Auth::user()->firm_id)
                ->value('voucher_nos');


            $paymentmodes = Account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['Cash In Hand', 'BANK ACCOUNT']);
                })
                ->get()
                ->sortBy(function ($account) {
                    $order = ['Cash In Hand', 'BANK ACCOUNT'];
                    return array_search($account->accountGroup->account_group_name, $order);
                });



            $kot_record = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->count();
            if ($kot_record > 0) {
                $lastRecord = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
                $new_voucher_no = $voucher_no;
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Restaurant_food_bill')->first();
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $foodbilldata->food_bill_no;


            } else {
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_type_name', 'Restaurant_food_bill')->first();


                $new_voucher_no = $voucher_no;
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_no;
            }

            $checkinlists = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)->where('checkout_voucher_no', 0)
                ->where('voucher_no', $service_id)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->get();

            $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
            $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();

            $creditaccounts = Account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['Sundry Debtors']);
                })
                ->get()
                ->sortBy(function ($account) {
                    $order = ['Sundry Debtors'];
                    return array_search($account->accountGroup->account_group_name, $order);
                });
            $sundryGroup = accountgroup::where('firm_id', Auth::user()->firm_id)
                ->where(function ($query) {
                    $query->where('account_group_name', 'Sundry Debtors')
                        ->orWhere('account_group_name', 'Guest Customer');
                })
                ->get();
            $accountnames = account::where('firm_id', Auth::user()->firm_id)
                ->whereIn('account_group_id', $sundryGroup->pluck('id'))
                ->get();

            return view('entery.restaurant.table_foodbill_edit_afterselect', compact('foodbilldata', 'new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata', 'itemrecords', 'service_id', 'vouchers', 'paymentmodes', 'creditaccounts', 'table', 'accountnames', 'only_settel'));

        } else {
            return back()->with('message', 'No Pending Kot Records Found ');
        }


    }

    public function rkot_update($id)
    {
        $tempkots = tempentry::where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)->get();
        $tempkots_first = tempentry::where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $this->rkot_destroy($tempkots_first->voucher_no);

        $store_time = $tempkots_first->temp_af1;


        if ($tempkots->count()) {
            $totalQty = $tempkots->sum('qty');
            $totalAmount = $tempkots->sum('amount');

            foreach ($tempkots as $tempkot) {
                $kot = new kot;
                $kot->firm_id = Auth::user()->firm_id;
                $kot->entry_date = $tempkot->entry_date;
                $kot->voucher_no = $tempkot->voucher_no;
                $kot->voucher_date = $tempkot->voucher_date;
                $kot->voucher_type = $tempkot->voucher_type;
                $kot->bill_no = $tempkot->bill_no;
                $kot->user_id = $tempkot->user_id;
                $kot->user_name = $tempkot->user_name;
                $kot->item_id = $tempkot->item_id;
                $kot->item_name = $tempkot->item_name;
                $kot->qty = $tempkot->qty;
                $kot->rate = $tempkot->rate;
                $kot->amount = $tempkot->amount;
                $kot->total_qty = $totalQty;
                $kot->total_amount = $totalAmount;
                $kot->kot_remark = $tempkot->kot_remark;
                $kot->service_id = $tempkot->sale_to_voucher_no;
                $date = $tempkot->entry_date; // Assuming this is in 'Y-m-d' format
                $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
                $kot->created_at = "$date $time";
                $kot->save();
            }
            $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
            $tempkots_delete->delete();
            return redirect('restaurant_kot')->with('message', 'Records Saved Successfully');

        } else {
            return back()->with('error', 'Nothing  To Save  ');
        }



    }

    public function rkot_update_print($id, $voucher_no)
    {
        $tempkots = tempentry::where('user_id', $id)->where('firm_id', Auth::user()->firm_id)->get();
        $tempkots_first = tempentry::where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $store_time = $tempkots_first->temp_af1;
        $this->rkot_destroy($tempkots_first->voucher_no);

        if ($tempkots->count() > 0) {
            $totalQty = $tempkots->sum('qty');
            $totalAmount = $tempkots->sum('amount');
            foreach ($tempkots as $tempkot) {
                $kot = new kot;
                $kot->firm_id = Auth::user()->firm_id;
                $kot->entry_date = $tempkot->entry_date;
                $kot->voucher_no = $tempkot->voucher_no;
                $kot->voucher_date = $tempkot->voucher_date;
                $kot->voucher_type = $tempkot->voucher_type;
                $kot->bill_no = $tempkot->bill_no;
                $kot->user_id = $tempkot->user_id;
                $kot->user_name = $tempkot->user_name;
                $kot->item_id = $tempkot->item_id;
                $kot->item_name = $tempkot->item_name;
                $kot->qty = $tempkot->qty;
                $kot->rate = $tempkot->rate;
                $kot->amount = $tempkot->amount;
                $kot->total_qty = $totalQty;
                $kot->total_amount = $totalAmount;
                $kot->kot_remark = $tempkot->kot_remark;
                $kot->service_id = $tempkot->sale_to_voucher_no;
                $date = $tempkot->entry_date; // Assuming this is in 'Y-m-d' format
                $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
                $kot->created_at = "$date $time";
                $kot->save();
            }
            $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
            $tempkots_delete->delete();
            $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $voucher_no)
                ->get();
            $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $voucher_no)
                ->first();

            $guest_detail = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->where('voucher_no', $kot_header->service_id)
                ->where('firm_id', Auth::user()->firm_id)
                ->first();
            if ($guest_detail === null) {

                $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
                $table_name = $tabledata->table_name;

            } else {
                $table_name = Null;
            }


            return view('entery.roomservice.kot_print_view', compact('kot_to_print', 'kot_header', 'guest_detail', 'table_name'));
        } else {
            return back()->with('error', 'Nothing To Print  ');
        }
    }

    public function Rkot_print_view($id, $voucher_no)
    {



        $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->get(); 
                     kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_no', $voucher_no)
    ->where('ready_to_serve', 'Unprinted')
    ->update(['ready_to_serve' => '0']);


        $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->first();
        $checkin_no = $kot_header->service_id;
        $guest_detail="";

        // $guest_detail = roomcheckin::select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
        //     ->groupBy('guest_name', 'voucher_no')
        //     ->where('voucher_no', $kot_header->service_id)
        //     ->where('firm_id', Auth::user()->firm_id)
        //     ->first();


            $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
            $table_name = $tabledata->table_name;



        return view('entery.roomservice.kot_print_view', compact('kot_to_print', 'kot_header', 'guest_detail', 'table_name'));
    }
    public function Rkot_print($id, $voucher_no)
    {


        $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)
            ->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();
         kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_no', $voucher_no)
    ->where('ready_to_serve', 'Unprinted')
    ->update(['ready_to_serve' => '0']);

        $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->first();
            $guest_detail="";

        // $guest_detail = roomcheckin::select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
        //     ->groupBy('guest_name', 'voucher_no')
        //     ->where('voucher_no', $kot_header->service_id)
        //     ->where('firm_id', Auth::user()->firm_id)
        //     ->first();


            $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
            $table_name = $tabledata->table_name;

        return view('entery.roomservice.kot.kot_print', compact('kot_to_print', 'kot_header', 'guest_detail', 'table_name'));
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
    if ($method_type !== 'Restaurant_food_bill_delete' && $method_type !== 'Restaurant_food_bill_update') {
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
