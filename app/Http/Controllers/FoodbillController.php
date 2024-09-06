<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
use App\Models\ledger;
use App\Models\account;
use App\Models\foodbill;
use App\Models\roomcheckin;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $foodbills = foodbill::select( 'voucher_type','total_bill_value', 'total_qty', 'voucher_no','food_bill_no','service_id','voucher_date','status','user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
        ->groupBy('voucher_type','voucher_no', 'total_bill_value', 'total_qty','food_bill_no','service_id','status','user_id','voucher_date') 
        ->orderBy('voucher_no','desc')
        ->where('voucher_type','Foodbill')
        // Ensure groupBy includes all non-aggregated selected columns
        ->get();
        $roomcheckins=roomcheckin::where('checkout_voucher_no','0')->get();
        

     return view('entery.roomservice.foodbill.foodbill_index',compact('foodbills','roomcheckins')); 
     
    
    }
    public function item_wise_sale_report_view()
   {  

    // Passing the data to the view
    return view('entery.roomservice.foodbill.item_wise_sale_report_view'); 
}
    public function item_wise_sale_report(Request $request)
   {  
    $date_variable1=$request->from_date;
    $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable1);
    $formatted_from_date = $parsed_date->format('Y-m-d');
   
    $date_variable=$request->to_date;
    $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_to_date = $parsed_date->format('Y-m-d');
   $from_date=$request->from_date;
   $to_date=$request->to_date;
    // Query to get the total quantity sold for each item
    $item_wise_sales = $item_wise_sales = Foodbill::select(
        'item_id',
        'item_name',
        'rate',

        DB::raw('SUM(qty) as total_qty_sold'),
        DB::raw('SUM(qty * rate) as total_amount')
    )
    ->groupBy('item_id', 'item_name','rate')
    ->whereBetween('voucher_date', [$formatted_from_date, $formatted_to_date])
    ->get();

    // Passing the data to the view
    return view('entery.roomservice.foodbill.item_wise_sale_report', compact('item_wise_sales','from_date','to_date')); 
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kot_record=foodbill::count();
        if ($kot_record > 0) {
           $lastRecord = foodbill::orderBy('voucher_no', 'desc')->first();
           $voucher_no = $lastRecord->voucher_no;
           $new_voucher_no=$voucher_no+1;
           $voucher_type = voucher_type::where('voucher_type_name', 'Foodbill')->first();
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
       
        }
        else {
           $voucher_type = voucher_type::where('voucher_type_name', 'Foodbill')->first();

           $voucher_no=$voucher_type->numbring_start_from;
           $new_voucher_no=$voucher_no+1;
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
 
       }

       $checkinlists = roomcheckin::where('checkout_voucher_no', 0) 
       ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
       ->groupBy('guest_name', 'voucher_no')
       ->get();

       $accountdata = account::all();
       $itemdata = item::all();

       return view('entery.roomservice.foodbill.foodbill_create', compact('new_bill_no','new_voucher_no','checkinlists','accountdata','itemdata'));



   
    }
    public function fetchkotRecords(string $id)
    {
        $service_id = $id;
        
        $itemrecords = Kot::with('item')
        ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
        
        ->where('service_id', $service_id)
        ->where('status', '0')
        ->groupBy('item_id', 'rate')
        ->get();
        if($itemrecords->count()>0){
            $vouchers = DB::table('kots')
        ->select(DB::raw('GROUP_CONCAT(DISTINCT voucher_no ORDER BY voucher_no ASC SEPARATOR ",") as voucher_nos'))
        ->where('service_id', $service_id)
        ->where('status', '0')
        ->value('voucher_nos');

        $paymentmodes=account::where('account_group_id','4')
        ->orWhere('account_group_id','5')
        ->get();

        $kot_record=foodbill::count();
        if ($kot_record > 0) {
           $lastRecord = foodbill::orderBy('voucher_no', 'desc')->first();
           $voucher_no = $lastRecord->voucher_no;
           $new_voucher_no=$voucher_no+1;
           $voucher_type = voucher_type::where('voucher_type_name', 'Foodbill')->first();
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
       
        }
        else {
           $voucher_type = voucher_type::where('voucher_type_name', 'Foodbill')->first();

           $voucher_no=$voucher_type->numbring_start_from;
           $new_voucher_no=$voucher_no+1;
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
 
       }

       $checkinlists = roomcheckin::where('checkout_voucher_no', 0)
       ->where('voucher_no',$service_id) 
       ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
       ->groupBy('guest_name', 'voucher_no')
       ->get();

       $accountdata = account::all();
       $itemdata = item::all();


       return view('entery.roomservice.foodbill.foodbill_create_afterselect', compact('new_bill_no','new_voucher_no','checkinlists','accountdata','itemdata','itemrecords','service_id','vouchers','paymentmodes'));

        }
        else{
            return back()->with('message','No Pending Kot Records Found ');
        }

        



    }

    public function store_foodbill(Request $request)
    {
        // dd($request);
        $date_variable=$request->voucher_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
         $formatted_voucher_date = $parsed_date->format('Y-m-d');
        $service_id =$request->service_id ;
        $itemrecords = Kot::with('item')
        ->select('item_id', DB::raw('SUM(qty) as qty'), 'rate', DB::raw('GROUP_CONCAT(voucher_no) as voucher_nos'))
        
        ->where('service_id', $service_id)
        ->where('status', '0')
        ->groupBy('item_id', 'rate')
        ->get();
        

         foreach($itemrecords as $record){
            // return($record);
            $newfoodbill= new foodbill;
            $newfoodbill->user_id=$request->user_id;
            $newfoodbill->user_name=$request->user_name;
            $newfoodbill->food_bill_no=$request->food_bill_no;
            $newfoodbill->voucher_date=$formatted_voucher_date;
            $newfoodbill->voucher_type=$request->voucher_type;
            $newfoodbill->voucher_no=$request->voucher_no;
            $newfoodbill->service_id=$request->service_id;
            $newfoodbill->kot_no=$request->kot_no;
            $newfoodbill->posting_acc_id=$request->posting_acc_id;
            $newfoodbill->net_food_bill_amount=$request->net_food_bill_amount;
            $newfoodbill->payment_remark=$request->payment_remark;
            $newfoodbill->food_bill_remark=$request->food_bill_remark;
            $newfoodbill->item_id=$record->item_id;
            $newfoodbill->item_name=$record->item->item_name;
            $newfoodbill->qty=$record->qty;
            $newfoodbill->rate=$record->rate;
            $newfoodbill->item_base_amount=$record->qty*$record->rate;
            $newfoodbill->disc_percent='0';
            $newfoodbill->disc_item_amount='0';
            $newfoodbill->gst_id=$record->item->gstmaster->id;
            $newfoodbill->gst_item_percent=$record->item->gstmaster->igst;
            // $newfoodbill->gst_item_amount=$record->item->gstmaster->igst;
            $newfoodbill->gst_item_amount=(($record->qty*$record->rate)*($record->item->gstmaster->igst))/100;
            $newfoodbill->net_item_amount=((($record->qty*$record->rate)*($record->item->gstmaster->igst))/100)+($record->qty*$record->rate);
            $newfoodbill->total_item=$request->total_item;
            $newfoodbill->total_qty=$request->total_qty;
            $newfoodbill->total_base_amount=$request->total_base_amount;
            $newfoodbill->cash_discount='0';
            $newfoodbill->total_taxable_amount=$request->total_base_amount;
            $newfoodbill->total_gst_amount=$request->total_gst_amount;
            $newfoodbill->total_sgst=($request->total_gst_amount)/2;
            $newfoodbill->total_cgst=($request->total_gst_amount)/2;
            $newfoodbill->total_igst='0';
            $newfoodbill->roundoff_amt=$request->round_off;
            $newfoodbill->total_amt_after_gst=($request->total_gst_amount)+($request->total_gst_amount);
            $newfoodbill->total_bill_value=$request->net_bill_amount;
            $newfoodbill->status='0';
            $newfoodbill->save();


         }
         kot::where('service_id', $request->service_id)->update(['status' => $request->voucher_no]); 

    }

    
    
    public function store(Request $request)
    {
 
        $this->store_foodbill($request);
        
        $posting_acc_id=$request->posting_acc_id;
        if($posting_acc_id>0){

            foodbill::where('voucher_no', $request->voucher_no)->update(['status' => 'direct_bill']); 
            //requierd Post amount to ledger 
            $this->foodbill_posting($request);
            return redirect()->route('foodbills.index')->with('message', 'Record saved successfully and bill amount posted to direct sale.');

        }else{
            // return redirect()->route('foodbills.index')->with('message', 'Record saved successfully. Bill amount posted to room.');
            $guest_detail = roomcheckin::where('checkout_voucher_no', 0)
            ->select('guest_name','guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
           ->groupBy('guest_name', 'guest_mobile','voucher_no')
           ->where('voucher_no', $request->service_id)->first();
           $foodbill_header=foodbill::where('user_id', $request->user_id)
           ->where('voucher_no', $request->voucher_no)
           ->first();
           $foodbill_items = foodbill::where('user_id', $request->user_id)
           ->where('voucher_no', $request->voucher_no)
           ->get();
           
            
           return view('entery.roomservice.foodbill.foodbill_print_view',compact('guest_detail','foodbill_header','foodbill_items'));


        }
    }
    public function foodbill_print_view($voucher_no){
        $foodbill_header=foodbill::where('voucher_no', $voucher_no)
        ->first();
        $service_id=$foodbill_header->service_id;
          $guest_detail = roomcheckin::where('checkout_voucher_no', 0)
        ->select('guest_name','guest_mobile', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
       ->groupBy('guest_name', 'guest_mobile','voucher_no')
       ->where('voucher_no',$service_id )->first();
 
        $foodbill_items = foodbill::where('voucher_no',$voucher_no)
       ->get();
       
        
       return view('entery.roomservice.foodbill.foodbill_print_view',compact('guest_detail','foodbill_header','foodbill_items'));
    }

    

//    return view('entery.roomservice.foodbill.foodbill_print_view');


        
    //posting foodbill amount to respective account

    public function foodbill_posting(Request $request)
        { 
            $transaction_type='Foodbill';
            $receipt_remark=$request->food_bill_no.'||'.$request->service_id.'||'.$request->net_bill_amount.'||'.$request->payment_remark;
    

                $date_variable=$request->voucher_date;
                $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
                 $formatted_entry_date = $parsed_date->format('Y-m-d');
                 $accountname = account::with('accountgroup')
                 ->where('account_name', 'FoodBill Sales')->first();
                 $paymentmode=account::with('accountgroup')
                 ->where('id', $request->posting_acc_id)->first();
    
                    $ledger = new ledger;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->food_bill_no;
                    $ledger->entry_date =  $formatted_entry_date;
                    $ledger->transaction_type =$transaction_type ;
                    $ledger->payment_mode_id = $request->posting_acc_id;
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
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->food_bill_no;
                    $ledger->entry_date =  $formatted_entry_date;
                    $ledger->transaction_type =$transaction_type  ;
                    $ledger->payment_mode_id = $request->posting_acc_id;
                    $ledger->payment_mode_name = $accountname->account_name;                
                    $ledger->account_id = $request->posting_acc_id;
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
        $foodbills = foodbill::where('voucher_no', $voucher_no);
        if($foodbills->count()){
            $foodbills->delete();
            kot::where('status', $voucher_no)->update(['status' =>'0']);

            return back()->with('message', 'Record Deleteted '.$voucher_no);
        }
        else{
            return back()->with('errors', 'No Record Found   '); 
        }
 
    }
}
