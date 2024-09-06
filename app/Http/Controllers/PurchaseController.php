<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
use App\Models\account;
use App\Models\purchase;
use App\Models\tempentry;
use App\Models\roomcheckin;
use App\Models\voucher_type;
use Illuminate\Http\Request;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kot_record=purchase::count();
        if ($kot_record > 0) {
           $lastRecord = purchase::orderBy('voucher_no', 'desc')->first();
           $voucher_no = $lastRecord->voucher_no;
           $new_voucher_no=$voucher_no+1;
           $voucher_type = voucher_type::where('voucher_type_name', 'Purchase')->first();
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
       
        }
        else {
           $voucher_type = voucher_type::where('voucher_type_name', 'Purchase')->first();

           $voucher_no=$voucher_type->numbring_start_from;
           $new_voucher_no=$voucher_no+1;
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
 
       }


       $accountdata = account::where('account_group_id','2')->get();
   
       $itemdata = item::all();

       return view('entery.purchase.purchase_create', compact('new_bill_no','new_voucher_no','accountdata','itemdata'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $validator= validator::make($request->all(),[
                'item_id' => 'required',
                'item_qty'=>'required',
                 'item_rate'=>'required',
                 'item_amount'=>'required',
                 'user_id'=>'required',
                 'voucher_no'=>'required',
                 'voucher_date'=>'required',
                 'user_name'=>'required',
                //  'service_id'=>'required',
               
                 
                ]);
         if ($validator->passes()) {            
            $item = item::where('id', $request->item_id)->firstOrFail();
            $itemName = $item->item_name;
            // format entery date 
            $date_variable=$request->voucher_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
             $formatted_voucher_date = $parsed_date->format('Y-m-d');
             //storing data 
            $tempkot = new tempentry;
            $tempkot->user_id = $request->user_id;
            $tempkot->user_name=$request->user_name;
            $tempkot->entry_date=now();  
            $tempkot->voucher_date=$formatted_voucher_date;
            $tempkot->voucher_no=$request->voucher_no;
            $tempkot->voucher_type=$request->voucher_type;
            $tempkot->bill_no=$request->kot_no;
            $tempkot->item_id=$request->item_id;
            $tempkot->item_name=$itemName;
            $tempkot->qty=$request->item_qty;
            $tempkot->rate=$request->item_rate;
            $tempkot->dis_percent=$request->dis_p;
            $tempkot->dis_amt=$request->dis_amt;
            $tempkot->total_discount=$request->total_item_dis_amt;
            $tempkot->item_gst_id=$request->gst_p;
            $tempkot->total_gst=$request->gst_amt;
            $tempkot->item_net_value=$request->net_item_amt;
            $tempkot->customer_id=$request->account_id;
            $tempkot->voucher_remark=$request->terms;
            $tempkot->customer_id=$request->account_id;
            $tempkot->bill_no=$request->purchase_bill_no;
            $tempkot->amount=$request->item_qty*$request->item_rate;
            $tempkot->total_amount=($request->item_qty*$request->item_rate)-$request->total_item_dis_amt;
            $tempkot->save();
            $itemName="test item ";
                return response()->json([
                    'message' => 'I am ready to save through AJAX  hariom ji '.$itemName,
                    'status' => 200,
                ]);
          }  else {
            $itemName="test item ";
            return response()->json([
    
                'message' => 'Bad Request. Check Your Input'.$itemName,
                'status' => 400,
                'errors' => $validator->errors(),
                  ]);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(purchase $purchase)
    {
        //
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
    public function destroy(purchase $purchase)
    {
        //
    }


    public function fetchItemRecords_inventory(string $id)
    {
        $user_id = $id;
        $itemrecords = tempentry::where('user_id', $user_id)->get();
        
        return response()->json([
            'message' => 'Records fetched successfully for user ' . $user_id,
            'status' => 200,
            'itemrecords' => $itemrecords->toArray(),
        ]);
    }
}
