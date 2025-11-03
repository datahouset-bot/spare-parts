<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
use App\Models\sale;
use App\Models\godown;
use App\Models\account;
use App\Models\voucher;
use App\Models\purchase;
use App\Models\inventory;
use App\Models\tempentry;
use App\Models\roomcheckin;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\stocktransfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorestocktransferRequest;
use App\Http\Requests\UpdatestocktransferRequest;

class StocktransferController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocktransfers = voucher::where('firm_id', Auth::user()->firm_id)
        ->with('account')->where('voucher_type','Stock_Transfer')->orderBy('voucher_no','desc')->get();

        return view('entery.stocktransfer.stocktransfer_index',compact('stocktransfers'));

    }
    public function create()
    {  //create function 
        $voucher_record=voucher::where('firm_id', Auth::user()->firm_id)
        ->where('voucher_type','Stock_Transfer')->count();
        if ($voucher_record > 0) {
           $lastRecord = voucher::where('firm_id', Auth::user()->firm_id)
           ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
           $voucher_no = $lastRecord->voucher_no;
           $new_voucher_no=$voucher_no+1;
           $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
           ->where('voucher_type_name', 'Stock_Transfer')->first();
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
       
        }
        else {

           $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
           ->where('voucher_type_name', 'Stock_Transfer')->first();
 

           $voucher_no=$voucher_type->numbring_start_from;
           $new_voucher_no=$voucher_no+1;
           $voucher_prefix=$voucher_type->voucher_prefix;
           $voucher_suffix=$voucher_type->voucher_suffix;
           $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
 
       }

       $godowns=godown::where('firm_id', Auth::user()->firm_id)->get();
       $accountdata = account::where('firm_id', Auth::user()->firm_id)
       ->where('account_name', 'Stock Transfer From')
       ->orWhere('account_name', 'Stock Transfer To')
       ->get();

       $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();

       return view('entery.stocktransfer.stocktransfer_create', compact('new_bill_no','new_voucher_no','accountdata','itemdata','godowns'));

    }
    public function store_to_stocktransfer($id)
    {
        $account_from = account::where('firm_id', Auth::user()->firm_id)
        ->where('account_name', 'Stock Transfer From')
                ->first();
        $account_to = account::where('firm_id', Auth::user()->firm_id)
        ->Where('account_name', 'Stock Transfer To')
        ->first();



    $records=tempentry::where('firm_id', Auth::user()->firm_id)
    ->where('user_id',$id)->get();
   
    if($records->count()){

    $totalQty = $records->sum('qty');
    $totalAmount = $records->sum('amount');
    $net_voucher_amount=$records->sum('item_net_value');
    foreach ($records as $record) {
         $purchase=new inventory;
         $purchase->firm_id= Auth::user()->firm_id;
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
         $purchase->account_id=$account_from->id;
         $purchase->net_voucher_amount=$net_voucher_amount;
         $purchase->gst_id=$record->item_gst_name; //gst id from gst master  
         $purchase->gst_item_percent=$record->item_gst_id;  
         $purchase->gst_item_amount=$record->total_gst;  
         $purchase->item_net_amount=$net_voucher_amount;  
         $purchase->simpal_qty=-($record->qty);  
         $purchase->stock_out=$record->qty;
 
         $purchase->save();
        $purchase=new inventory;
        $purchase->firm_id= Auth::user()->firm_id;
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
        $purchase->godown_id=$record->temp_af4;
        $purchase->account_id=$account_to->id;
        $purchase->net_voucher_amount=$net_voucher_amount;
        $purchase->gst_id=$record->item_gst_name; //gst id from gst master  
        $purchase->gst_item_percent=$record->item_gst_id;  
        $purchase->gst_item_amount=$record->total_gst;  
        $purchase->item_net_amount=$net_voucher_amount;  
        $purchase->simpal_qty=($record->qty);  
        $purchase->stock_in=$record->qty;
       $purchase->save();

    }
    $this->store_to_voucher($id);
    $tempkots_delete=tempentry::where('firm_id', Auth::user()->firm_id)
    ->where('user_id',$id);
    $tempkots_delete->delete();        
    return back()->with('message', 'Records Save Success Fully  ');
    }
    else{
        return back()->with('error', 'Nothing  To Save  ');
       }
     


    }
    public function store_to_voucher($id)
    {
    $record=tempentry::where('firm_id', Auth::user()->firm_id)
    ->where('user_id',$id)->where('voucher_type','Stock_Transfer')->get();
    $first_record=tempentry::where('firm_id', Auth::user()->firm_id)
    ->where('user_id',$id)->where('voucher_type','Stock_Transfer')->first();
    if($record->count()){

    $totalQty = $record->sum('qty');
    $totalAmount = $record->sum('amount');
    $net_voucher_amount=$record->sum('item_net_value');
    $total_gst=$record->sum('total_gst');
    $total_discount=$record->sum->sum('total_discount');

         $voucher=new voucher;
         $voucher->firm_id=Auth::user()->firm_id;
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

  

 
 
 
         $voucher->save();
    
    
       }
    }


    public function store(Request $request)// store temp item record use on sale controller also 
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
                 'godown_id'=>'required',
                 'to_godown_id'=>'required',
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
            $tempkot->firm_id=Auth::user()->firm_id;
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
            $tempkot->bill_no=$request->voucher_bill_no;
            $tempkot->item_gst_name=$request->gstmaster_id; //gst id  form gst master 

            $tempkot->amount=$request->item_qty*$request->item_rate;
            $tempkot->total_amount=($request->item_qty*$request->item_rate)-$request->total_item_dis_amt;
            $tempkot->temp_af1=$request->godown_id;//store godown id 
            $tempkot->temp_af4=$request->to_godown_id;//store godown id 
            $tempkot->account_id=$request->account_id;//store godown id 

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
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(stocktransfer $stocktransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(stocktransfer $stocktransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatestocktransferRequest $request, stocktransfer $stocktransfer)
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
        ->where('voucher_no', $id)->where('voucher_type','Stock_Transfer');
        $inventory=inventory::where('firm_id', Auth::user()->firm_id)
        ->where('voucher_no', $id)->where('voucher_type','Stock_Transfer');

      


        if ($voucher->count()>0 && $inventory->count()>0 ) {
            $voucher->delete();
            $inventory->delete();
            return redirect('/stocktransfers')->with('message', 'All matching Record deleted successfully!');

        }
        else{

            return redirect('/stocktransfers')->with('message', 'No Recoird  found ');

        } 


       
    }

}
