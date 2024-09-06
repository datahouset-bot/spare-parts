<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\room;
use App\Models\ledger;
use App\Models\account;
use App\Models\package;
use App\Models\roomtype;
use App\Models\gstmaster;
use App\Models\optionlist;
use App\Models\roombooking;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\businesssource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreroombookingRequest;
use App\Http\Requests\UpdateroombookingRequest;

class RoombookingController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth']);

    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
 
        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.room_booking', compact('rooms'));

    }

    public function create()
    {
        //    $document_name=optionlist::where('option_type','document_name')->get();
        //    $agent_name=optionlist::where('option_type','agent_name')->get();
        //     $state=optionlist::where('option_type','state')->get();
        //     $country=optionlist::where('option_type','country')->get();
        //     $nationality=optionlist::where('option_type','nationality')->get();
        //     'document_name','agent_name','state','country','nationality',

        $businesssource=businesssource::all();
        $package=package::all();
        $paymentmodes=account::where('account_group_id','4')
        ->orWhere('account_group_id','5')
        ->get();

        $roombooking_record = roombooking::count();
         if ($roombooking_record > 0) {
            $lastRecord = roombooking::orderBy('voucher_no', 'desc')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Room_booking')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Room_booking')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }



        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.room_booking', compact('rooms','businesssource','package','new_bill_no','new_voucher_no','paymentmodes'));

    }


    public function booking_by_guest_create()
    {


        $businesssource=businesssource::all();
        $package=package::all();
        $paymentmodes=account::where('account_group_id','4')
        ->orWhere('account_group_id','5')
        ->get();

        $roombooking_record = roombooking::count();
         if ($roombooking_record > 0) {
            $lastRecord = roombooking::orderBy('voucher_no', 'desc')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Room_booking')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Room_booking')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }



        $rooms = room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->where('room_status', 'vacant')
            ->get();
        return view('entery.room.room_booking_by_guest', compact('rooms','businesssource','package','new_bill_no','new_voucher_no','paymentmodes'));

    }


        public function home()
        {
        // $roombooking = roombooking::where('checkin_voucher_no','0')->get();
        $roombooking = DB::table('roombookings')
    ->select('voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'), 'booking_no', 'guest_name' ,'guest_mobile','booking_date','checkin_date','checkout_date')
    ->where('checkin_voucher_no', '0')
    ->groupBy('voucher_no', 'booking_no', 'guest_name','guest_mobile','booking_date','checkin_date','checkout_date')
    ->get();
    // dd($roombookings);
        return view('entery.room.room_booking_home', compact('roombooking'));
        }
        public function clear_booking()
        {
        $roombooking = roombooking::all();
        return view('entery.room.room_booking_home', compact('roombooking'));
        }
       
        public function pending_booking()
        {
        $roombooking = roombooking::where('checkin_voucher_no','book_by_guest')->get();
        return view('entery.room.room_booking_pending', compact('roombooking'));
        }

    public function post_amount(Request $request ){
        $posting_acc_id=$request->posting_acc_id;
        $booking_amount=$request->booking_amount; 
        if ($posting_acc_id>0|$booking_amount>0){
    
    
                $date_variable=$request->booking_date;
                $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
                 $formatted_entry_date = $parsed_date->format('Y-m-d');
                 $accountname = account::with('accountgroup')
                 ->where('mobile', $request->guest_mobile)->first();
                 $paymentmode=account::with('accountgroup')
                 ->where('id', $request->posting_acc_id)->first();
           
                    $ledger = new ledger;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->booking_no;
                    $ledger->entry_date =  $formatted_entry_date;
                    $ledger->transaction_type ='Room_booking'  ;
                    $ledger->payment_mode_id = $posting_acc_id;
                    $ledger->payment_mode_name = $paymentmode->account_name;
    
                    $ledger->account_id = $accountname->id;
                    $ledger->account_name = $accountname->account_name;
                    $ledger->account_group_id =$accountname->account_group_id ;
                    $ledger->account_group_name = $accountname->accountgroup->account_group_name;
                    $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
                    $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
                    $ledger->credit = $request->booking_amount;           
                    $ledger->amount = $request->booking_amount;
                    $ledger->remark = "Room_booking/".$request->booking_no;  
                    $ledger->tran_voucher_no=$request->voucher_no;
                    $ledger->simpal_amount = "-" . $request->booking_amount;
                    $ledger->save();
    
    
                    $ledger = new ledger;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->booking_no;
                    $ledger->entry_date =  $formatted_entry_date;
                    $ledger->transaction_type ='Room_booking'  ;
                    $ledger->payment_mode_id = $posting_acc_id;
                    $ledger->payment_mode_name = $accountname->account_name;                
                    $ledger->account_id = $posting_acc_id;
                    $ledger->account_name = $paymentmode->account_name;
                    $ledger->account_group_id =$paymentmode->account_group_id ;
                    $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
                    $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
                    $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
                    $ledger->debit = $request->booking_amount;
                    $ledger->amount = $request->booking_amount;
                    $ledger->remark = "Room_booking/".$request->booking_no;  
                    $ledger->tran_voucher_no=$request->voucher_no;
                    $ledger->simpal_amount = "+" . $request->booking_amount;
                    $ledger->save();
            
                  
                } 
    }
    

    public function create_account(Request $request){
            $uploadPath = 'uploads/account_image';
            if ($request->hasFile('guest_id_pic')) {
                $image1=$request->guest_id_pic;
                $name=$image1->getClientOriginalName();
                $image1->storeAS('public\account_image',$name);
                $validatedData['guest_id_pic'] = $name ;
              

            }else{
                $name = NULL ;
            }
            if ($request->hasFile('guest_pic')) {

                $image2=$request->guest_pic;
                $name2=$image2->getClientOriginalName();
                $image2->storeAS('public\account_image',$name2);
                $validatedData['guest_pic'] = $name2 ;
            }else{
                $name2 =NULL;
            }    

   
             $customer = Account::Where('mobile', $request->guest_mobile)
            ->first();
            if($customer == null)
            {   
                 
           
                  $account=new account;
                  $account->account_name=$request->guest_name;
                  $account->account_group_id='6';
                  $account->op_balnce='0';
                  $account->balnce_type='Dr';
                  $account->city=$request->guest_city;
                  $account->state=$request->guest_state;
                  $account->mobile=$request->guest_mobile;
                  $account->gst_no=$request->gst_no;
                  $account->gst_code = substr($request->gst_no, 0, 2);
                  $account->address=$request->guest_address;
                  $account->address=$request->guest_address2;
                  $account->account_idproof_name=$request->guest_idproof;
                  $account->account_idproof_no=$request->guest_idproof_no;
                  $account->account_id_pic=$name;
                  $account->account_pic1=$name2;
                  $account->email=$request->guest_email;
                  $account->nationality=$request->guest_contery;
                  $account->pincode=$request->guest_pincode;
                  $account->save();
            }
      
    }

         public function store(Request $request){     

            $validated = $request->validate([
        'booking_no' => 'required|string',
        'voucher_no' => 'required|string',
         'booking_date' => 'required|date',
         'booking_time' => 'required|date_format:H:i',
         'checkin_date' => 'required|date',
         'checkin_time' => 'required|date_format:H:i',
         'checkout_date' => 'required|date',
         'checkout_time' => 'required|date_format:H:i',
         'no_of_guest' => 'required|integer',
        'business_source_id' => 'required',
        'package_id' => 'required|exists:packages,id',
        'guest_name' => 'required|string',
        'guest_mobile' => 'required|string',
    ]);
    $customer = Account::Where('mobile', $request->guest_mobile)
            ->first();
            if($customer == null)
            {
               $this->create_account($request);
            }

            $date_variable=$request->booking_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
         $formatted_booking_date = $parsed_date->format('Y-m-d');
         $validatedData['booking_date'] = $formatted_booking_date ;

         $date_variable=$request->checkin_date;
         $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
          $formatted_checkin_date = $parsed_date->format('Y-m-d');
          $validatedData['checkin_date'] = $formatted_checkin_date ;
          
          $date_variable=$request->checkout_date;
          $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
           $formatted_checkout_date = $parsed_date->format('Y-m-d');
           $validatedData['checkout_date'] = $formatted_checkout_date ;
           if ($request->hasFile('guest_id_pic')) {
            $image1=$request->guest_id_pic;
            $name=$image1->getClientOriginalName();
            $image1->storeAS('public\account_image',$name);
                    
        }else{
            $name=NULL;
        }
        if ($request->hasFile('guest_pic')) {
            $image2=$request->guest_pic;
            $name2=$image2->getClientOriginalName();
            $image2->storeAS('public\account_image',$name2);
        }else{
            $name2=NULL;
        }    

   
    
        $booking_room_ids = $request->booking_room_id;
       
    foreach ($booking_room_ids as $booking_room_id) {
         $roombooking =  new roombooking;
        
         
         $roomdetails= room::where('id', $booking_room_id)->first();
         $roombooking->room_id=$booking_room_id; 
         $roombooking->room_no=$roomdetails->room_no;
         $roombooking->guest_name=$request->guest_name;
         $roombooking->guest_mobile=$request->guest_mobile;
         $roombooking->booking_no=$request->booking_no;
         $roombooking->voucher_no=$request->voucher_no;
         $roombooking->booking_date=$formatted_booking_date;
         $roombooking->booking_time=$request->checkin_time;
         $roombooking->checkin_date=$formatted_checkin_date;
         $roombooking->checkin_time=$request->checkin_time;
         $roombooking->checkout_date=$formatted_checkout_date;
         $roombooking->checkout_time=$request->checkout_time;
         $roombooking->no_of_guest=$request->no_of_guest;
         $roombooking->commited_days=$request->commited_days;
         $roombooking->business_source_id=$request->business_source_id;
         $roombooking->package_id=$request->package_id;
         $roombooking->gst_no=$request->gst_no;
         $roombooking->firm_address=$request->firm_address;
         $roombooking->firm_name=$request->firm_name;
         $roombooking->guest_idproof_no=$request->guest_idproof_no;
         $roombooking->guest_idproof=$request->guest_idproof;
         $roombooking->agent=$request->agent;
         $roombooking->guest_phone=$request->guest_phone;
         $roombooking->guest_nationality=$request->guest_nationality;
         $roombooking->guest_pincode=$request->guest_pincode;
         $roombooking->guest_contery=$request->guest_contery;
         $roombooking->guest_state=$request->guest_state;
         $roombooking->guest_address=$request->guest_address;
         $roombooking->guest_address2=$request->guest_address2;
         $roombooking->guest_city=$request->guest_city;
         $roombooking->guest_email=$request->guest_email;
         $roombooking->voucher_payment_remark=$request->voucher_payment_remark;
         $roombooking->refrance_no=$request->voucher_payment_ref;
         $roombooking->booking_amount=$request->booking_amount;
         $roombooking->posting_acc_id=$request->posting_acc_id;
         $roombooking->room_tariff_perday=$request->room_tariff_perday;
         $roombooking->guest_id_pic=$name;
         $roombooking->guest_pic=$name2;
        $roombooking->save();
        
    }   
   $this->post_amount($request);
   $voucher_no=$request->voucher_no;
   $roombooking= roombooking::where('voucher_no',$voucher_no)->first();
   $checkinDate = Carbon::parse($roombooking->checkin_date);
   $checkoutDate = Carbon::parse($roombooking->checkout_date);
   $totaldays = $checkinDate->diffInDays($checkoutDate);
   // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
   return view('entery.room.room_booking_view', compact('roombooking','totaldays'));

   
}

public function store_by_guest_booking(Request $request){     

    $validated = $request->validate([
'booking_no' => 'required|string',
'voucher_no' => 'required|string',
 'booking_date' => 'required|date',
 'booking_time' => 'required|date_format:H:i',
 'checkin_date' => 'required|date',
 'checkin_time' => 'required|date_format:H:i',
 'checkout_date' => 'required|date',
 'checkout_time' => 'required|date_format:H:i',
 'no_of_guest' => 'required|integer',
'business_source_id' => 'required',
'package_id' => 'required|exists:packages,id',
'guest_name' => 'required|string',
'guest_mobile' => 'required|string',
]);
$customer = Account::Where('mobile', $request->guest_mobile)
    ->first();
    if($customer == null)
    {
       $this->create_account($request);
    }

    $date_variable=$request->booking_date;
$parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
 $formatted_booking_date = $parsed_date->format('Y-m-d');
 $validatedData['booking_date'] = $formatted_booking_date ;

 $date_variable=$request->checkin_date;
 $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
  $formatted_checkin_date = $parsed_date->format('Y-m-d');
  $validatedData['checkin_date'] = $formatted_checkin_date ;
  
  $date_variable=$request->checkout_date;
  $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
   $formatted_checkout_date = $parsed_date->format('Y-m-d');
   $validatedData['checkout_date'] = $formatted_checkout_date ;
   if ($request->hasFile('guest_id_pic')) {
    $image1=$request->guest_id_pic;
    $name=$image1->getClientOriginalName();
    $image1->storeAS('public\account_image',$name);
            
}else{
    $name=NULL;
}
if ($request->hasFile('guest_pic')) {
    $image2=$request->guest_pic;
    $name2=$image2->getClientOriginalName();
    $image2->storeAS('public\account_image',$name2);
}else{
    $name2=NULL;
}    



$booking_room_ids = $request->booking_room_id;

foreach ($booking_room_ids as $booking_room_id) {
 $roombooking =  new roombooking;

 
 $roomdetails= room::where('id', $booking_room_id)->first();
 $roombooking->room_id=$booking_room_id; 
 $roombooking->room_no=$roomdetails->room_no;
 $roombooking->guest_name=$request->guest_name;
 $roombooking->guest_mobile=$request->guest_mobile;
 $roombooking->booking_no=$request->booking_no;
 $roombooking->voucher_no=$request->voucher_no;
 $roombooking->booking_date=$formatted_booking_date;
 $roombooking->booking_time=$request->checkin_time;
 $roombooking->checkin_date=$formatted_checkin_date;
 $roombooking->checkin_time=$request->checkin_time;
 $roombooking->checkout_date=$formatted_checkout_date;
 $roombooking->checkout_time=$request->checkout_time;
 $roombooking->no_of_guest=$request->no_of_guest;
 $roombooking->commited_days=$request->commited_days;
 $roombooking->business_source_id=$request->business_source_id;
 $roombooking->package_id=$request->package_id;
 $roombooking->gst_no=$request->gst_no;
 $roombooking->firm_address=$request->firm_address;
 $roombooking->firm_name=$request->firm_name;
 $roombooking->guest_idproof_no=$request->guest_idproof_no;
 $roombooking->guest_idproof=$request->guest_idproof;
 $roombooking->agent=$request->agent;
 $roombooking->guest_phone=$request->guest_phone;
 $roombooking->guest_nationality=$request->guest_nationality;
 $roombooking->guest_pincode=$request->guest_pincode;
 $roombooking->guest_contery=$request->guest_contery;
 $roombooking->guest_state=$request->guest_state;
 $roombooking->guest_address=$request->guest_address;
 $roombooking->guest_address2=$request->guest_address2;
 $roombooking->guest_city=$request->guest_city;
 $roombooking->guest_email=$request->guest_email;
 $roombooking->voucher_payment_remark=$request->voucher_payment_remark;
 $roombooking->refrance_no=$request->voucher_payment_ref;
 $roombooking->booking_amount=$request->booking_amount;
 $roombooking->posting_acc_id=$request->posting_acc_id;
 $roombooking->room_tariff_perday=$request->room_tariff_perday;
 $roombooking->guest_id_pic=$name;
 $roombooking->guest_pic=$name2;
 $roombooking->checkin_voucher_no='book_by_guest';
$roombooking->save();

}   
$this->post_amount($request);
$voucher_no=$request->voucher_no;
$roombooking= roombooking::where('voucher_no',$voucher_no)->first();
$checkinDate = Carbon::parse($roombooking->checkin_date);
$checkoutDate = Carbon::parse($roombooking->checkout_date);
$totaldays = $checkinDate->diffInDays($checkoutDate);
// $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
return view('entery.room.room_booking_view_by_guest', compact('roombooking','totaldays'));


}



    

    public function show(Request $request, $id)
    {   //this is function for show all detail of rooms only  when we select any room using ajex 
        if ($request->ajax()) {
            \Log::info('AJAX request received');
        }

        $room = Room::with(['roomtype.gstmaster', 'roomtype.package'])->find($id);


        if ($room) {
            return response()->json($room->toArray());
        } else {
            return response()->json([]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $roombooking= roombooking::findOrFail($id);

        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.room_booking_edit', compact('rooms','roombooking'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'guest_name' => 'required|string|max:255',
            'room_no' => 'required|integer',
            'room_id' => 'required|integer', 


            
        'booking_time'=>'string',
        
        'checkin_time'=>'string',
        
        'checkout_time'=>'string',

        'booking_mode'=>'string',
        'payment_status'=>'string',
        'payment_mode'=>'string',
        'refrance_no'=>'string',
        'booking_amount'=>'string',
        'room_type'=>'string',
        'facility'=>'string',
        'guest_email'=>'string',
        'guest_mobile'=>'string',
        'guest_address'=>'string',
        'guest_city'=>'string',
        'guest_state'=>'string',
        'guest_contery'=>'string',
        'guest_idproof'=>'string',
        'guest_idproof_no'=>'string',
        'room_tariff'=>'string',
        'room_dis'=>'string',
        'package_name'=>'string',
        'plan_name'=>'string',
        'taxname'=>'string',
        'sgst'=>'string',
        'cgst'=>'string',
        'igst'=>'string',
        'vat'=>'string',
        'tax1'=>'string',
        'tax2'=>'string',
        'tax3'=>'string',
        'tax4'=>'string',
        'tax5'=>'string',


        ]);

        $date_variable=$request->booking_date;
        $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
         $formatted_booking_date = $parsed_date->format('Y-m-d');
         $validatedData['booking_date'] = $formatted_booking_date ;

         $date_variable=$request->checkin_date;
         $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
          $formatted_checkin_date = $parsed_date->format('Y-m-d');
          $validatedData['checkin_date'] = $formatted_checkin_date ;
          
          $date_variable=$request->checkout_date;
          $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
           $formatted_checkout_date = $parsed_date->format('Y-m-d');
           $validatedData['checkout_date'] = $formatted_checkout_date ;


           $roombooking = roombooking::findOrFail($id);
           $roombooking->update($validatedData);
        // Optionally, you can return a response
        return redirect()->route('roombooking_home')->with('message', 'Room booking updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roombooking = roombooking::where('voucher_no',$id);
        $ledger=ledger::where('transaction_type','Room_booking')
                       ->where('voucher_no',$id);
                       



        // Check if the roombooking exists
        if ($roombooking && $ledger) {
            // Delete the roombooking
            $roombooking->delete();
            $ledger->delete();

 

            return redirect('/roombooking_home')->with('message', 'Room Booking Delete Successfully!');
        } else {
            // roombooking not found
            return redirect('/roombooking_home')->with('message', 'Room booking Not Found');

        }
    }
    
    
    public function roombooking_confirm($id)
    {   
        $roombooking= roombooking::where('voucher_no',$id)->count();
        if ($roombooking>0) {
            roombooking::where('voucher_no', $id)->update(['checkin_voucher_no' => '0']);

        }
        return redirect('/pending_booking')->with('message', 'Selected Booking Confirm you can  Make Check In ');
    
    }

    public function view($id)
    {   
        $roombooking= roombooking::where('voucher_no',$id)->first();
        $checkinDate = Carbon::parse($roombooking->checkin_date);
        $checkoutDate = Carbon::parse($roombooking->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        // dd($roombooking);
        return view('entery.room.room_booking_view', compact('roombooking','totaldays'));
    }


    public function roombooking_by_dashboard($id)
    {
 
        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->findOrFail($id);
        return view('entery.room.room_booking_by_dashboard', compact('rooms'));
    }

    public function booking_calendar() {
        $currentDate = Carbon::now();
        $rooms = Room::with('roomtype')->get();
    
        // Get all bookings
        $roombookings = Roombooking::all();
    
        return view('reports.rooms_report.booking_calendar', [
            'currentDate' => $currentDate,
            'rooms' => $rooms,
            'roombookings' => $roombookings,
        ]);
    }





}
