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
use App\Models\roomcheckin;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $foodbills = foodbill::select('firm_id','voucher_type','net_food_bill_amount','total_bill_value', 'total_qty', 'voucher_no','food_bill_no','service_id','voucher_date','status','user_id','customer_name','mobile', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
        ->groupBy( 'firm_id','voucher_type','net_food_bill_amount','voucher_no', 'total_bill_value', 'total_qty','food_bill_no','service_id','status','user_id','voucher_date','customer_name','mobile')
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->where('voucher_type','Restaurant_food_bill')
        ->where('firm_id',Auth::user()->firm_id)
        ->get(); 
    

        

     return view('entery.restaurant.table_foodbill_index',compact('foodbills')); 
     
    
    }
    public function table_kot_create($tableid)
    {
        $id=Auth::user()->id;


        $this->temp_item_delete($id);


         $kot_record=kot::where('firm_id', Auth::user()->firm_id)->where('voucher_type', 'RKot')->count();
     if ($kot_record > 0) {
        $lastRecord = kot::where('firm_id',Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
        $voucher_no = $lastRecord->voucher_no;
        $new_voucher_no=$voucher_no+1;
        $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)->where('firm_id',Auth::user()->firm_id)->where('voucher_type_name', 'RKot')->first();
        $voucher_prefix=$voucher_type->voucher_prefix;
        $voucher_suffix=$voucher_type->voucher_suffix;
        $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
    
     }
     else {
        $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)->where('voucher_type_name', 'RKot')->first();

        $voucher_no=$voucher_type->numbring_start_from;
        $new_voucher_no=$voucher_no+1;
        $voucher_prefix=$voucher_type->voucher_prefix;
        $voucher_suffix=$voucher_type->voucher_suffix;
        $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;

    }

     $table=table::where('firm_id',Auth::user()->firm_id)->where('id',$tableid)->first();



    $accountdata = account::where('firm_id',Auth::user()->firm_id)->get();
    $itemdata = item::where('firm_id',Auth::user()->firm_id)->get();
    

    return view('entery.restaurant.table_kot', compact('new_bill_no','new_voucher_no','tableid','table','accountdata','itemdata')); 

}


    /**
     * Show the form for creating a new resource.
     */
    public function table_foodbill_create($tableid)
    {
        $kot_record=foodbill::where('firm_id', Auth::user()->firm_id)->count();
        if ($kot_record > 0) {
           $lastRecord = foodbill::where('firm_id',Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
           $voucher_no = $lastRecord->voucher_no;
           $new_voucher_no=$voucher_no+1;
           $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)->where('voucher_type_name', 'Restaurant_food_bill')->first();
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
       
        }
        else {
           $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)->where('voucher_type_name', 'Restaurant_food_bill')->first();

           $voucher_no=$voucher_type->numbring_start_from;
           $new_voucher_no=$voucher_no+1;
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
 
       }


       $accountdata = account::where('firm_id',Auth::user()->firm_id)->get();
       $itemdata = item::where('firm_id',Auth::user()->firm_id)->get();
       $table=table::where('firm_id',Auth::user()->firm_id)->where('id',$tableid)->first();


       return view('entery.restaurant.table_foodbill_create', compact('new_bill_no','new_voucher_no','accountdata','itemdata','tableid','table'));



   
    }


    public function fetchkotRecords(string $id)
    {
        $service_id = $id;


        $itemrecords = Kot::where('firm_id',Auth::user()->firm_id)->with('item')
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
                ->where('firm_id',Auth::user()->firm_id)
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
            

            
            $kot_record = foodbill::where('firm_id', Auth::user()->firm_id)->count();
            if ($kot_record > 0) {
                $lastRecord = foodbill::where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
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

            $checkinlists = roomcheckin::where('firm_id', Auth::user()->firm_id)->where('checkout_voucher_no', 0)
                ->where('voucher_no', $service_id)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->get();

            $accountdata = account::where('firm_id',Auth::user()->firm_id)->get();
            $itemdata = item::where('firm_id',Auth::user()->firm_id)->get();


            return view('entery.restaurant.table_foodbill_create_afterselect', compact('new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata', 'itemrecords', 'service_id', 'vouchers', 'paymentmodes'));

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
        $records = Kot::where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('status', '0')
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
    //      kot::where('service_id', $request->service_id)->update(['status' => $request->voucher_no]); 

    // }


   
    public function table_foodbills_store(Request $request)
    {
        // dd($request);
        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_voucher_date = $parsed_date->format('Y-m-d');
        $service_id = $request->service_id;
        $itemrecords = Kot::where('firm_id',Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
            ->where('voucher_type', 'RKot')
            ->where('service_id', $service_id)
            ->where('status', '0')
            ->groupBy('item_id', 'rate')
            ->get();
 

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
            $newfoodbill->total_bill_value = $request->net_bill_amount;
            $newfoodbill->status = '0';
            $newfoodbill->customer_name=$request->customer_name;
            $newfoodbill->address=$request->address;
            $newfoodbill->mobile=$request->mobile;
            $newfoodbill->remark=$request->remark;
            $newfoodbill->save();


        }
        $kotvoucher_no = explode(',', $request->kot_no);
       
        kot::where('firm_id',Auth::user()->firm_id)
        ->where('service_id', $request->service_id)
        ->where('voucher_type', 'RKot')
        ->whereIn('voucher_no', $kotvoucher_no)
        ->update(['status' => $request->voucher_no]);

    }
    
    public function storexxxx(Request $request)
    {    

        $this->table_foodbills_store($request);


        
        $posting_acc_id=$request->posting_acc_id;
        if($posting_acc_id>0){

            foodbill::where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']); 
            $this->foodbill_posting($request);
            $foodbill_header=foodbill::where('user_id', $request->user_id)
            ->where('voucher_no', $request->voucher_no)
            ->first();
            $foodbill_items = foodbill::where('user_id', $request->user_id)
            ->where('voucher_no', $request->voucher_no)
            ->get();
            return view('entery.restaurant.table_foodbill_print_view',compact('foodbill_header','foodbill_items'));

        }else{
            $guest_detail = roomcheckin::where('firm_id', Auth::user()->firm_id)->where('checkout_voucher_no', 0)
            ->select('guest_name','guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
           ->groupBy('guest_name', 'guest_mobile','voucher_no')
           ->where('voucher_no', $request->service_id)->first();
           $foodbill_header=foodbill::where('firm_id', Auth::user()->firm_id)->where('user_id', $request->user_id)
           ->where('voucher_no', $request->voucher_no)
           ->first();
           $foodbill_items = foodbill::where('firm_id', Auth::user()->firm_id)->where('user_id', $request->user_id)
           ->where('voucher_no', $request->voucher_no)
           ->get();
           

           return view('entery.restaurant.table_foodbill_print_view',compact('foodbill_header','foodbill_items'));



        }
    }
    public function store(Request $request)
    {


        // $existingRecords = ledger::where('firm_id',Auth::user()->firm_id)->where('transaction_type', $request->voucher_type)
        // ->where('voucher_no', $request->voucher_no)
        // ->count();

    // if ($existingRecords >= 2) {
    //     return response()->json(['error' => 'Records already exist for this transaction type and voucher number and Please Dont Reloade and resubmit Same Entry .'], 400);
    // }

        //store record to  inventor after foodbill after store to account 

        $date_variable = $request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_voucher_date = $parsed_date->format('Y-m-d');
        $service_id = $request->service_id;
        $records = Kot::where('firm_id', Auth::user()->firm_id)->with('item')
            ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

            ->where('service_id', $service_id)
            ->where('status', '0')

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
     //----------------------------


        $this->table_foodbills_store($request); //store the record on foodbill

        // $posting_acc_id = $request->posting_acc_id;
        // if ($posting_acc_id > 0) {



if ($request->settle_payment==="Cash") {
  
        // Proceed with your logic


            foodbill::where('firm_id',Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']); 
            $this->foodbill_posting_cash($request);
            $foodbill_header = foodbill::where('foodbills.firm_id', Auth::user()->firm_id)
            ->where('foodbills.user_id', Auth::user()->id)
            ->where('foodbills.voucher_no', $request->voucher_no)
            ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
            ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
            ->first();

            $foodbill_items = foodbill::where('firm_id',Auth::user()->firm_id)->where('user_id', $request->user_id)
            ->where('voucher_no', $request->voucher_no)
            ->get();
            return view('entery.restaurant.table_foodbill_print_view',compact('foodbill_header','foodbill_items'));

        } else {

            $this->foodbill_posting($request);
            // return redirect()->route('foodbills.index')->with('message', 'Record saved successfully. Bill amount posted to room.');
            foodbill::where('firm_id',Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']);
            $guest_detail = roomcheckin::where('firm_id',Auth::user()->firm_id)->where('checkout_voucher_no', 0)
                ->select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
                ->where('voucher_no', $request->service_id)->first();
           

                $foodbill_header = foodbill::where('foodbills.firm_id', Auth::user()->firm_id)
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

                
            $foodbill_items = foodbill::where('firm_id',Auth::user()->firm_id)
                ->where('user_id', $request->user_id)
                ->where('voucher_no', $request->voucher_no)
                ->get();


            return view('entery.restaurant.table_foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));


        }

    }

    
    public function table_foodbill_print_view($voucher_no){
        $foodbill_header = foodbill::where('foodbills.firm_id', Auth::user()->firm_id)
        ->where('foodbills.user_id', Auth::user()->id)
        ->where('foodbills.voucher_no', $voucher_no)
        ->leftJoin('tables', 'foodbills.service_id', '=', 'tables.id') // Left join with tables
        ->select('foodbills.*', 'tables.table_name') // Select all foodbill columns and table_name
        ->first();
    
    // Debugging Output
    if (!$foodbill_header) {
        dd("No matching foodbill found!");
    } elseif (!$foodbill_header->table_name) {
        dd("Table name not found for service_id: " . $foodbill_header->service_id);
    }
    
    
        $service_id=$foodbill_header->service_id;
    //       $guest_detail = roomcheckin::where('checkout_voucher_no', 0)
    //     ->select('guest_name','guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
    //    ->groupBy('guest_name', 'guest_mobile','voucher_no')
    //    ->where('voucher_no',$service_id )->first();
 
        $foodbill_items = foodbill::where('firm_id',Auth::user()->firm_id)->
        where('voucher_no',$voucher_no)
       ->get();
       
        
       return view('entery.restaurant.table_foodbill_print_view',compact('foodbill_header','foodbill_items'));
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


            $transaction_type='Restaurant_food_bill';
            $receipt_remark=$request->food_bill_no.'||'.$request->service_id.'||'.$request->net_bill_amount.'||'.$request->payment_remark;
    

                $date_variable=$request->voucher_date;
                $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
                 $formatted_entry_date = $parsed_date->format('Y-m-d');
                 $accountname = account::where('firm_id',Auth::user()->firm_id)->with('accountgroup')
                 ->where('account_name', 'FoodBill Sales')->first();
                //  dd($accountname->id);

                $posting_acc_id= account::where('firm_id',Auth::user()->firm_id)->with('accountgroup')
                ->where('account_name', 'Cash')->first()->id;
         
               
                 $paymentmode=account::with('accountgroup')
                 ->where('firm_id',Auth::user()->firm_id)
                 ->where('id',  $posting_acc_id)->first();
    
                    $ledger = new ledger;
                    $ledger->firm_id=Auth::user()->firm_id;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->food_bill_no;
                    $ledger->entry_date =  $formatted_entry_date;
                    $ledger->transaction_type =$transaction_type ;
                    $ledger->payment_mode_id =  $posting_acc_id;
                    $ledger->payment_mode_name = $paymentmode->account_name;
    
                    $ledger->account_id = $accountname->id;
                    $ledger->account_name = $accountname->account_name;
                    $ledger->account_group_id =$accountname->account_group_id ;
                    $ledger->account_group_name = $accountname->accountgroup->account_group_name;
                    $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
                    $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
                    $ledger->credit = $request->net_bill_amount;           
                    $ledger->amount = $request->net_bill_amount;
                    $ledger->remark = $receipt_remark;  
                    $ledger->simpal_amount = "-" . $request->net_bill_amount;
                    $ledger->save();
    
    
                    $ledger = new ledger;
                    $ledger->firm_id=Auth::user()->firm_id;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->food_bill_no;
                    $ledger->entry_date =  $formatted_entry_date;
                    $ledger->transaction_type =$transaction_type  ;
                    $ledger->payment_mode_id =  $posting_acc_id;
                    $ledger->payment_mode_name = $accountname->account_name;                
                    $ledger->account_id = $posting_acc_id;
                    $ledger->account_name = $paymentmode->account_name;
                    $ledger->account_group_id =$paymentmode->account_group_id ;
                    $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
                    $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
                    $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
                    $ledger->debit = $request->net_bill_amount;
                    $ledger->amount = $request->net_bill_amount;
                    $ledger->remark = $receipt_remark;  
                    $ledger->simpal_amount = "+" . $request->net_bill_amount;
                    $ledger->save();
            
        }    
    



    public function destroy($voucher_no)
    {
     
        // Fetch foodbills with the given voucher_no
        $foodbills = foodbill::where('firm_id',Auth::user()->firm_id)
        ->where('voucher_no', $voucher_no)->where('voucher_type', 'Restaurant_food_bill');
        $inventory = inventory::where('firm_id',Auth::user()->firm_id)->
        where('voucher_no', $voucher_no)->where('voucher_type', 'Restaurant_food_bill');
    
        // Check if any foodbills were found
        if ($foodbills->count()) {
            // Fetch the ledger with the corresponding transaction_type and voucher_no
            $ledger = ledger::where('firm_id',Auth::user()->firm_id)
            ->where('transaction_type', 'Restaurant_food_bill')
            ->where('voucher_no', $voucher_no);
            
            // Check if a matching ledger entry was found
            if ($ledger->count()) {
                // Delete the ledger entry
                $ledger->delete();     
            }
    
            // Delete the foodbillsww
            $foodbills->delete();
        $kotdata= kot::where('firm_id',Auth::user()->firm_id)->where('voucher_type', 'RKot')
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
public function editxx($voucher_no){




    $foodbilldata=foodbill::where('voucher_no',$voucher_no)->where('firm_id',Auth::user()->firm_id)->get();
$foodbilldatafirst=$foodbilldata->first();
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
        $tempkot->item_net_value =($item->qty*$item->rate)+$item->gst_item_amount ;
        $tempkot->customer_id = $item->account_id;
 
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





return view('entery.restaurant.table_foodbill_edit_afterselect', compact('foodbilldata', 'foodbilldatafirst','paymentmodes'));



}

public function edit($voucher_no,$tableid)
{
    $foodbilldata=foodbill::where('voucher_no',$voucher_no)->where('firm_id',Auth::user()->firm_id)->first();


    $kot_record=foodbill::where('firm_id', Auth::user()->firm_id)->count();
       $voucher_type =$foodbilldata->voucher_type;
       $new_voucher_no=$foodbilldata->voucher_no;

       $new_bill_no=$foodbilldata->food_bill_no;
 


   $accountdata = account::where('firm_id',Auth::user()->firm_id)->get();
   $itemdata = item::where('firm_id',Auth::user()->firm_id)->get();
   $table=table::where('firm_id',Auth::user()->firm_id)->where('id',$tableid)->first();


   return view('entery.restaurant.table_foodbill_edit', compact('new_bill_no','new_voucher_no','accountdata','itemdata','tableid','table'));




}

public function update(Request $request){

  $voucher_no=$request->voucher_no;
  $service_id=$request->voucher_no;


  $foodbills = foodbill::where('firm_id',Auth::user()->firm_id)->where('voucher_no',$voucher_no)
  ->where( 'voucher_type', 'Restaurant_food_bill');


  
  // Check if any foodbills were found
  if ($foodbills->count()) {
    $foodbills->delete();



    




      // Fetch the ledger with the corresponding transaction_type and voucher_no
      $ledger = ledger::where('firm_id',Auth::user()->firm_id)
      ->where('transaction_type', 'Restaurant_food_bill')
      ->where('voucher_no', $voucher_no);
      
      // Check if a matching ledger entry was found
      if ($ledger->count()) {
          // Delete the ledger entry
          $ledger->delete();     
      }





      // Delete the foodbillsww
   
  }

  
  $date_variable = $request->voucher_date;
  $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
  $formatted_voucher_date = $parsed_date->format('Y-m-d');
  $service_id = $request->service_id;
  $records = Kot::where('firm_id', Auth::user()->firm_id)->with('item')
      ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))

      ->where('service_id', $service_id)


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
//----------------------------


  $this->table_foodbills_store($request); //store the record on foodbill

  // $posting_acc_id = $request->posting_acc_id;
  // if ($posting_acc_id > 0) {



if ($request->settle_payment==="Cash") {

  // Proceed with your logic


      foodbill::where('firm_id',Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']); 
      $this->foodbill_posting_cash($request);
      $foodbill_header=foodbill::where('firm_id',Auth::user()->firm_id)->where('user_id', $request->user_id)
      ->where('voucher_no', $request->voucher_no)
      ->first();
      $foodbill_items = foodbill::where('firm_id',Auth::user()->firm_id)->where('user_id', $request->user_id)
      ->where('voucher_no', $request->voucher_no)
      ->get();
      return view('entery.restaurant.table_foodbill_print_view',compact('foodbill_header','foodbill_items'));

  } else {

      $this->foodbill_posting($request);
      // return redirect()->route('foodbills.index')->with('message', 'Record saved successfully. Bill amount posted to room.');
      foodbill::where('firm_id',Auth::user()->firm_id)->where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']);
      $guest_detail = roomcheckin::where('firm_id',Auth::user()->firm_id)->where('checkout_voucher_no', 0)
          ->select('guest_name', 'guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
          ->groupBy('guest_name', 'guest_mobile', 'voucher_no')
          ->where('voucher_no', $request->service_id)->first();
      $foodbill_header = foodbill::where('firm_id',Auth::user()->firm_id)->where('user_id', $request->user_id)
          ->where('voucher_no', $request->voucher_no)
          ->first();
  
      $foodbill_items = foodbill::where('firm_id',Auth::user()->firm_id)
          ->where('user_id', $request->user_id)
          ->where('voucher_no', $request->voucher_no)
          ->get();


      return view('entery.restaurant.table_foodbill_print_view', compact('guest_detail', 'foodbill_header', 'foodbill_items'));


  }
  
  





}
public function rkot_destroy($voucher_no)
    {

        $kots = kot::where('voucher_no', $voucher_no)->where('firm_id',Auth::user()->firm_id)
        ->where('status','0')->where('voucher_type','RKot');
   
       if($kots->count()){
           $kots->delete();
           return back()->with('message', 'Record Deleteted '.$voucher_no);
       }
       else{
           return back()->with('errors', 'Check Your Kot Converted on Bill So That We Can Not Delete It    '); 
       }

    }
public function resta_fetchkot(string $id)
    {           $service_id = $id;

        $itemrecords = Kot::with(['item.gstmaster']) // Include gstmaster through the item relationship
        ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
        ->where('service_id', $service_id)
        ->where('status', '0')
        ->where('voucher_type','RKot')
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
    

    public function restaurant_kot() {
        $kots = Kot::where('kots.status', '0')
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
                'kots.ready_to_serve'
            )
            ->where('kots.firm_id', Auth::user()->firm_id)
            ->where('kots.voucher_type', 'RKot')
            ->orderByRaw('CAST(kots.voucher_no AS UNSIGNED) DESC')
            ->get();
    
        return view('entery.roomservice.kot.Rkot_index', compact('kots'));
    }
    



    public function fetchkotRecords_edit($voucher_no,$id)
    {
        $service_id = $id;
        $foodbilldata=foodbill::where('voucher_no',$voucher_no)->where('firm_id',Auth::user()->firm_id)->first();


        $itemrecords = Kot::where('firm_id',Auth::user()->firm_id)->with('item')
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
                ->where('firm_id',Auth::user()->firm_id)
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
            

            
            $kot_record = foodbill::where('firm_id', Auth::user()->firm_id)->count();
            if ($kot_record > 0) {
                $lastRecord = foodbill::where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
                 $new_voucher_no = $voucher_no;
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Restaurant_food_bill')->first();
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $foodbilldata->food_bill_no ;
         

            } else {
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Restaurant_food_bill')->first();

             
                $new_voucher_no = $voucher_no ;
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                  $new_bill_no = $voucher_no ;
            }

            $checkinlists = roomcheckin::where('firm_id', Auth::user()->firm_id)->where('checkout_voucher_no', 0)
                ->where('voucher_no', $service_id)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->get();

            $accountdata = account::where('firm_id',Auth::user()->firm_id)->get();
            $itemdata = item::where('firm_id',Auth::user()->firm_id)->get();


            return view('entery.restaurant.table_foodbill_edit_afterselect', compact('foodbilldata','new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata', 'itemrecords', 'service_id', 'vouchers', 'paymentmodes'));

        } else {
            return back()->with('message', 'No Pending Kot Records Found ');
        }


    }
    
}
