<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
use App\Models\account;
use App\Models\tempentry;
use App\Models\roomcheckin;
use App\Models\roomservice;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KotController extends CustomBaseController
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);

    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kots = Kot::where('status','0')
        ->select('total_amount', 'total_qty', 'voucher_no','bill_no','service_id','voucher_date','status','user_id','ready_to_serve', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
        ->groupBy('voucher_no', 'total_amount', 'total_qty','bill_no','service_id','status','user_id','voucher_date','ready_to_serve')  // Ensure groupBy includes all non-aggregated selected columns
        ->get();

// return $kots;
        return view('entery.roomservice.kot.kot_index', compact('kots'));
    }
   // 
   public function kots_cleared()
   {
       $kots = Kot::where('status','!=','0')
       ->select('total_amount', 'total_qty', 'voucher_no','bill_no','service_id','voucher_date','status','user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
       ->groupBy('voucher_no', 'total_amount', 'total_qty','bill_no','service_id','status','user_id','voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
       ->get();

// return $kots;
       return view('entery.roomservice.kot.kot_index', compact('kots'));
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
             $kot_record=kot::count();
         if ($kot_record > 0) {
            $lastRecord = kot::orderBy('voucher_no', 'desc')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Kot')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Kot')->first();
 
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

        return view('entery.roomservice.room_kot', compact('new_bill_no','new_voucher_no','checkinlists','accountdata','itemdata')); 

    }
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
             'service_id'=>'required',
           
             
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
        $tempkot->amount=$request->item_amount;
        $tempkot->sale_to_voucher_no=$request->service_id;
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


    public function store3(Request $request)
    {
        //store temprary data orignal  
 
        $validator= validator::make($request->all(),[
            'item_id' => 'required',
            'item_qty'=>'required',
             'item_rate'=>'required',
             'item_amount'=>'required',
             'user_id'=>'required',
             'voucher_no'=>'required',
             'voucher_date'=>'required',
             'user_name'=>'required',
             'service_id'=>'required',
           
             
            ]);

     if ($validator->passes()) {

       //geting item name 
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
        $tempkot->amount=$request->item_amount;
        $tempkot->sale_to_voucher_no=$request->service_id;
        $tempkot->save();

        

        return response()->json([
            'message' => 'Record Save Successfully  '.$itemName,
            'status' => 200,
        ]);
    }
    else {
        $itemName="test item ";
        return response()->json([
            'message' => 'Bad Request. Check Your Input'.$itemName,
            'status' => 400,
            'errors' => $validator->errors(),
        ]);
   
    }
       
         
    }

    public function store_toKot($id)
    {
    $tempkots=tempentry::where('user_id',$id)->get();
    if($tempkots->count()){
    $totalQty = $tempkots->sum('qty');
    $totalAmount = $tempkots->sum('amount');
    foreach ($tempkots as $tempkot) {
         $kot=new kot;
         $kot->entry_date=$tempkot->entry_date;
         $kot->voucher_no=$tempkot->voucher_no;
         $kot->voucher_date=$tempkot->voucher_date;
         $kot->voucher_type='Kot';
         $kot->bill_no=$tempkot->bill_no;
         $kot->user_id=$tempkot->user_id;
         $kot->user_name=$tempkot->user_name;
         $kot->item_id=$tempkot->item_id;
         $kot->item_name=$tempkot->item_name;
         $kot->qty=$tempkot->qty;
         $kot->rate=$tempkot->rate;
         $kot->amount=$tempkot->amount;
         $kot->total_qty=$totalQty;
         $kot->total_amount=$totalAmount;
         $kot->kot_remark=$tempkot->kot_remark;
         $kot->service_id=$tempkot->sale_to_voucher_no;
         $kot->save();
    }
    $tempkots_delete=tempentry::where('user_id',$id);
    $tempkots_delete->delete();        
    return back()->with('message', 'Records Save Success Fully  ');
    }
    else{
        return back()->with('error', 'Nothing  To Save  ');
       }
     


    }

    public function store_and_print($id,$voucher_no)
    {
    $tempkots=tempentry::where('user_id',$id)->get();
    if($tempkots->count()>0){
    $totalQty = $tempkots->sum('qty');
    $totalAmount = $tempkots->sum('amount');
    foreach ($tempkots as $tempkot) {
         $kot=new kot;
         $kot->entry_date=$tempkot->entry_date;
         $kot->voucher_no=$tempkot->voucher_no;
         $kot->voucher_date=$tempkot->voucher_date;
         $kot->voucher_type='Kot';
         $kot->bill_no=$tempkot->bill_no;
         $kot->user_id=$tempkot->user_id;
         $kot->user_name=$tempkot->user_name;
         $kot->item_id=$tempkot->item_id;
         $kot->item_name=$tempkot->item_name;
         $kot->qty=$tempkot->qty;
         $kot->rate=$tempkot->rate;
         $kot->amount=$tempkot->amount;
         $kot->total_qty=$totalQty;
         $kot->total_amount=$totalAmount;
         $kot->kot_remark=$tempkot->kot_remark;
         $kot->service_id=$tempkot->sale_to_voucher_no;
         $kot->save();
    }
    $tempkots_delete=tempentry::where('user_id',$id);
    $tempkots_delete->delete();        
    $kot_to_print = kot::where('user_id', $id)
    ->where('voucher_no', $voucher_no)
    ->get();
    $kot_header=kot::where('user_id', $id)
    ->where('voucher_no', $voucher_no)
    ->first();

    $guest_detail = roomcheckin::where('checkout_voucher_no', 0)
     ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
    ->groupBy('guest_name', 'voucher_no')
    ->where('voucher_no', $kot_header->service_id)->first();

    return view('entery.roomservice.kot_print_view',compact('kot_to_print','kot_header','guest_detail'));
   } 
   else{
    return back()->with('error', 'Nothing To Print  ');
   }
    }
   public function kot_print($id,$voucher_no)
   {
    $kot_to_print = kot::where('user_id', $id)
    ->where('voucher_no', $voucher_no)
    ->get();
    $kot_header=kot::where('user_id', $id)
    ->where('voucher_no', $voucher_no)
    ->first();

    $guest_detail = roomcheckin::where('checkout_voucher_no', 0)
     ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
    ->groupBy('guest_name', 'voucher_no')
    ->where('voucher_no', $kot_header->service_id)->first();
    return view('entery.roomservice.kot.kot_print',compact('kot_to_print','kot_header','guest_detail'));
   } 
   public function kot_print_view($id,$voucher_no)
   {
      
    $kot_to_print = kot::where('user_id', $id)
    ->where('voucher_no', $voucher_no)
    ->get();
    
    $kot_header=kot::where('user_id', $id)
    ->where('voucher_no', $voucher_no)
    ->first();
      $checkin_no =$kot_header->service_id;

    $guest_detail = roomcheckin::where('checkout_voucher_no', 0)
     ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
    ->groupBy('guest_name', 'voucher_no')
    ->where('voucher_no', $kot_header->service_id)->first();
     
    return view('entery.roomservice.kot_print_view',compact('kot_to_print','kot_header','guest_detail'));
   } 

    public function fetchItemRecords(string $id)
    {
        $user_id = $id;
        $itemrecords = tempentry::where('user_id', $user_id)->get();
        
        return response()->json([
            'message' => 'Records fetched successfully for user ' . $user_id,
            'status' => 200,
            'itemrecords' => $itemrecords->toArray(),
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kot $kot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, kot $kot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($voucher_no)
    {
        $kots = kot::where('voucher_no', $voucher_no)
        ->where('status','0');
       if($kots->count()){
           $kots->delete();
           return back()->with('message', 'Record Deleteted '.$voucher_no);
       }
       else{
           return back()->with('errors', 'Check Your Kot Converted on Bill So That We Can Not Delete It    '); 
       }

    }
        public function temp_item_delete($id)
    {
        $user_id = $id;
         $itemrecords = tempentry::where('user_id', $user_id);
        if($itemrecords->count()){
            $itemrecords->delete();
            return back()->with('message', 'Wecome on New Kot ');
        }
        else{
            return back()->with('message', 'Please Add Items   '); 
        }
        
        
 

    }
}
