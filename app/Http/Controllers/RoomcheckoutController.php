<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\kot;
use App\Models\room;
use App\Models\ledger;
use App\Models\account;
use App\Models\package;
use App\Models\foodbill;
use App\Models\roomtype;

use App\Models\gstmaster;
use App\Models\componyinfo;
use App\Models\othercharge;
use App\Models\roombooking;
use App\Models\roomcheckin;
use Illuminate\Support\Str;
use App\Models\roomcheckout;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\businesssource;
use App\Models\compinfofooter;
use App\Models\businesssetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreroomcheckoutRequest;
use App\Http\Requests\UpdateroomcheckoutRequest;

class RoomcheckoutController extends CustomBaseController
{

    public function index()
    {
        $roomcheckouts = roomcheckout::orderBy('voucher_no','desc')->get();
        return view('entery.room.checkout.room_checkout_index',compact('roomcheckouts'));

    }
    public function register()
    {
        $roomcheckouts = roomcheckout::orderBy('voucher_no','desc')->get();
        return view('entery.room.checkout.room_checkout_register',compact('roomcheckouts'));

    }


    /**
         * Show the form for creating a new checkout.
     */
    public function create()
    {
        $roomcheckins = DB::table('roomcheckins')
        ->select('voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'), 'check_in_no', 'guest_name' ,'guest_mobile','checkin_date','checkin_time','checkout_voucher_no')
         ->groupBy('voucher_no', 'check_in_no', 'guest_name' ,'guest_mobile','checkin_date','checkin_time','checkout_voucher_no')
        ->where('checkout_voucher_no', '0')
        ->get();
        
        return view('entery.room.checkout.room_checkout', compact('roomcheckins'));
     
    }

    //store room checkout new 
    public function roomcheckouts_store(Request $request)
    { 
    // dd($request);


       
        $validator= validator::make($request->all(),[
            'voucher_no' => 'required|string|max:255',
            'check_out_no' => 'required|string|max:255',
            'checkin_date' => 'required|date',
            'checkin_time' => 'required|date_format:H:i:s',
            'checkout_date' => 'required|date',
            'check_out_time' => 'required',
            'calculation_type' => 'required|string|max:255',
            'no_of_days' => 'required|integer',
            'per_day_tariff' => 'required|numeric',
            'total_room_rent' => 'required|numeric',
            'guest_name' => 'required|string|max:255',
            'guest_mobile' => 'required|string|max:255',
            'amt_posting_acc' => 'required|string|max:255',
            'voucher_posting_amt' => 'required|numeric',
            'room_no' => 'required|string|max:255',
            'room_id' => 'required|integer|exists:rooms,id', // Assuming you have a rooms table
            'checkin_voucher_no' => 'required|string|max:255',
            'amt_post_credit_id'=>'required',
        ]);
        // if($validator->passes())
        // {
        //     return " validator pass  try to save data ";

        // }
        // else{
        //     // return back()->withInput()->withErrors($validator);
        //     return back()->withInput()->withErrors($validator);

        // }

        $guest_detail=account::where('id',$request->amt_post_credit_id)->first();
        $guest_gst_code=$guest_detail->gst_code;
        $comp_detail=componyinfo::find(1)->first();
        $comp_gst_code=$comp_detail->cominfo_field1;




        $date_variable=$request->checkin_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
         $formatted_checkin_date = $parsed_date->format('Y-m-d');
         $validatedData['checkin_date'] = $formatted_checkin_date ;

         $date_variable2=$request->checkout_date;
         $parsed_date2 = Carbon::createFromFormat('d-m-Y', $date_variable2);
          $formatted_checkout_date = $parsed_date2->format('Y-m-d');
          $validatedData['checkout_date'] = $formatted_checkout_date ;
 

       
        $checkout_room_ids = $request->room_checkout_id;
        $checkin_voucher_no = $request->checkin_voucher_no;

        // Update all RoomCheckin records with the given voucher_no
        $checkinUpdated = RoomCheckin::where('voucher_no', $checkin_voucher_no)
                                     ->update(['checkout_voucher_no' => $request->voucher_no]);


        $checkout =  new roomcheckout;
        $checkout->voucher_no=$request->voucher_no;
        $checkout->check_out_no=$request->check_out_no;
        $checkout->checkin_date=$formatted_checkin_date;
        $checkout->checkin_time=$request->checkin_time;
        $checkout->checkout_date=$formatted_checkout_date;
        $checkout->check_out_time=$request->check_out_time;
        $checkout->calculation_type=$request->calculation_type;
        $checkout->per_day_tariff=$request->per_day_tariff;
        $checkout->no_of_days=$request->no_of_days;
        $checkout->total_room_rent=$request->total_room_rent;
        $checkout->gst_id=$request->gst_id;
        $checkout->gst_total=$request->gst_total;
        // dd($guest_gst_code);
        if($guest_gst_code === $comp_gst_code ) {
            $checkout->sgst=$request->gst_total/2;
            $checkout->cgst=$request->gst_total/2;

        
        } elseif($guest_gst_code === ""){
            $checkout->sgst=$request->gst_total/2;
            $checkout->cgst=$request->gst_total/2;

        }
        
        else {
            $checkout->igst=$request->gst_total;
        }
        
        

        $checkout->final_room_rent=$request->total_room_rent+$request->gst_total;
        $checkout->total_food_amt=$request->total_food_amt;
        $checkout->other_charge=$request->add_other;
        $checkout->discount=$request->less_discount;
        $checkout->total_billamount=$request->bill_amount;
        $checkout->total_advance=$request->total_advance;
        $checkout->balance_to_pay=$request->balance_to_pay;
        $checkout->guest_name=$request->guest_name;
        $checkout->guest_mobile=$request->guest_mobile;
        $checkout->posting_acc_id=$request->posting_acc_id;
        $checkout->voucher_posting_amt=$request->voucher_posting_amt;
        $checkout->checkin_voucher_no=$request->checkin_voucher_no;
        $checkout->amt_post_credit_amt=$request->amt_post_credit_amt;
        $checkout->amt_post_credit_id=$request->amt_post_credit_id;
        $checkout->account_id=$request->account_id;

        $roomIds = [];
    $roomNos = [];
    foreach($checkout_room_ids as $room_checkout_id) {
        $roomdetails = Room::where('id', $room_checkout_id)->first();
        if ($roomdetails) {
            // Add room ID and room number to arrays
            $roomIds[] = $room_checkout_id;
            $roomNos[] = $roomdetails->room_no;

            // Update room status to 'dirty'
            Room::where('id', $room_checkout_id)->update(['room_status' => 'dirty']);
        }
    }
    $checkout->room_id = implode(',', $roomIds);
    $checkout->room_no = implode(',', $roomNos);
    

        
        $checkout->save();
        $posting_acc_id = $request->posting_acc_id;
        $voucher_posting_amt = $request->voucher_posting_amt;
        $amt_post_credit_id=$request->amt_post_credit_id;
        $amt_post_credit_amt=$request->amt_post_credit_amt;
        
        if ($posting_acc_id > 0 || $voucher_posting_amt != 0) {
            // $a="this is account posting on bank ";
            $this->post_amount($request);
        }
        if ( $amt_post_credit_amt > 0||$amt_post_credit_amt !=Null ) {
            $this->post_amount_credit($request);
            // $b="this is account posting on bank ";
        }
        //    return $a." ---- ".$b;

        $this->sale_post_amount($request);

        $guest_mobile = $request->guest_mobile;
        $guest_detail=account::where('mobile',$guest_mobile)->first();
       

        $voucher_no=$request->voucher_no;    
        $roomcheckouts= roomcheckout::where('voucher_no',$voucher_no)->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view', compact('roomcheckouts','guest_detail','totaldays'));
        

    }
    
    // room chekout print_view 
    public function room_checkout_view($voucher_no){
       
        $roomcheckouts = roomcheckout::with('account')
        ->where('voucher_no', $voucher_no)->first();
 

        // Calculate the total days between checkin and checkout
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $checkin_voucher_no=$roomcheckouts->checkin_voucher_no;
        $roomcheckins=roomcheckin::with('room','package')
        ->where('voucher_no',$checkin_voucher_no)->first();
        // dd($roomcheckins);

        $days = $checkinDate->diffInDays($checkoutDate);
  
        $foodBills = foodbill::where('service_id', $checkin_voucher_no)
                         ->selectRaw('voucher_date, SUM(total_bill_value) as total_amount')
                         ->groupBy('voucher_date')
                         ->get()
                         ->keyBy('voucher_date'); // Keyed by date for easy access in the view
       
        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('mobile', $guest_mobile)->first();
    

        return view('entery.room.checkout.room_checkout_view', compact('roomcheckouts', 'guest_detail', 'days','foodBills','roomcheckins'));
    
    }
    
    //OLD ROOM CHECKOUT VIEW 
    public function room_checkout_view2($voucher_no){
       
        $roomcheckouts= roomcheckout::where('voucher_no',$voucher_no)->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile=$roomcheckouts->guest_mobile;
        $guest_detail=account::where('mobile',$guest_mobile)->first();
        $checkin_voucher_no=$roomcheckouts->checkin_voucher_no;
        $roomcheckins=roomcheckin::with('room','package')
        ->where('voucher_no',$checkin_voucher_no)->first();
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view', compact('roomcheckouts','guest_detail','totaldays','roomcheckins'));
        

    }
    public function room_checkout_view3($voucher_no){
      
        $roomcheckouts= roomcheckout::where('voucher_no',$voucher_no)->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile=$roomcheckouts->guest_mobile;
        $guest_detail=account::where('mobile',$guest_mobile)->first();
        $checkin_voucher_no=$roomcheckouts->checkin_voucher_no;
        $roomcheckins=roomcheckin::with('room','package')
        ->where('voucher_no',$checkin_voucher_no)->first();
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view3', compact('roomcheckouts','guest_detail','totaldays','roomcheckins'));
        

    }
    //clear dirty room  id is voucgher_no 
    public function dirty_room_clear($id)
    {

        $roomDetails = Room::where('id',$id);


        if ($roomDetails->room_status='dirty') {
   
            $roomDetails->update(['room_status' => 'vacant']);
            return back()->with('message', 'Selected room is clean. You can assign a new guest.');
        }
    
        return back()->with('error', 'Room not found.');
    }
        //function for edit checkin 
        public function edit()
    {
        //
    }
//req code for update checkout 
    public function update()
    {
        //
    }

   // show ledger
    public function ledger_show(Request $request ,$id)
    {
        $roomcheckins = roomcheckin::where('voucher_no', $id)->first();
        $account_id=$roomcheckins->account_id;


       
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $ledgers = ledger::where('account_id', $account_id)
        ->get();

        $accounts = Account::orderBy('account_name', 'asc')->get();
        $account_name = Account::find($account_id);
        $opening_balance_account=$account_name->op_balnce;
        $opning_balance_type=$account_name->balnce_type;
        $debit_total=0;
        $credit_total=0;

        foreach($ledgers  as $record )
        {
            $debit_total+=$record->debit;
            $credit_total+=$record->credit;
       }
       $total_balance=$debit_total-$credit_total;
       if($opning_balance_type==='Dr'){
        $final_opning_balance=$total_balance+$opening_balance_account;
       }else{
        $final_opning_balance=$total_balance-$opening_balance_account;
       }
       return [
        'final_opning_balance' => $final_opning_balance,
        // Add other values you may need to return
    ];

      
    }
    //show checkin when select checkin no 
    public function show_checkin(Request $request ,$id)
    {
  


        $roomcheckins = roomcheckin::with('room')
        ->where('voucher_no', $id)->get();
        // $account_id=$roomcheckins->account_id;
        $ledgerData = $this->ledger_show($request, $id);
 
        if ($roomcheckins->isNotEmpty()) {
            // Extract the first record's details
            $firstRecord = $roomcheckins->first();
            $gst_percent=$firstRecord->room->roomtype->gstmaster;

            $account_id=$firstRecord->account_id;
            $data = $firstRecord->toArray();
            $account_detail=account::where('id',$account_id)->first();

    
            // Extract room numbers into an array
            $roomNos = $roomcheckins->pluck('room_no')->toArray();
    
            // Remove room_no from the first record's data to avoid duplication
            unset($data['room_no']);

            $checkout_record = roomcheckout::count();
            if ($checkout_record > 0) {
               $lastRecord = roomcheckout::orderBy('voucher_no', 'desc')->first();
               $voucher_no = $lastRecord->voucher_no;
               $new_voucher_no=$voucher_no+1;
               $voucher_type = voucher_type::where('voucher_type_name', 'Check_Out')->first();
               $voucher_prefix=$voucher_type->voucher_prefix;
               $voucher_suffix=$voucher_type->voucher_suffix;
               $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
               
            }
            else {
               $voucher_type = voucher_type::where('voucher_type_name', 'Check_Out')->first();
    
               $voucher_no=$voucher_type->numbring_start_from;
               $new_voucher_no=$voucher_no+1;
               $voucher_prefix=$voucher_type->voucher_prefix;
               $voucher_suffix=$voucher_type->voucher_suffix;
               $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
               
     
           }
  
           $kots = kot::where('service_id', $id)
           ->where('status','0')
           ->select('total_amount', 'total_qty', 'voucher_no','bill_no','service_id','voucher_date','status','user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
           ->groupBy('voucher_no', 'total_amount', 'total_qty','bill_no','service_id','status','user_id','voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
           ->get();

             $foodbills = foodbill::where('service_id', $id)
           ->where('status','0')
           ->select('net_food_bill_amount','total_bill_value','kot_no', 'total_qty', 'voucher_no','food_bill_no','service_id','voucher_date','status','user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
           ->groupBy('net_food_bill_amount','voucher_no','kot_no', 'total_bill_value', 'total_qty','food_bill_no','service_id','status','user_id','voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
           ->get();

           $paymentmodes=account::where('account_group_id','4')
           ->orWhere('account_group_id','5')
           ->get();

         $businesssettings=businesssetting::find(1);
         $calculation_type=$businesssettings->calculation_type;

            // Pass all data except room_no and room_nos separately
            return view('entery.room.checkout.room_checkout_after_checkin',['calculation_type'=>$calculation_type,'roomcheckins'=>$roomcheckins,'account_detail' => $account_detail,'gst_percent'=>$gst_percent,'data'=>$data, 'roomNos' => $roomNos,'new_bill_no'=>$new_bill_no,'new_voucher_no'=>$new_voucher_no,'kots'=>$kots,'foodbills'=>$foodbills,'paymentmodes'=>$paymentmodes,'final_opning_balance' => $ledgerData['final_opning_balance']]);
            // dd( ['data' => $data, 'roomNos' => $roomNos]);
        } else {
            // Handle the case when no records are found
            return view('your_view_name', ['data' => [], 'roomNos' => []]);
        }
    }

//for calcution room rent 
public function show(Request $request, $calculation_type)
{

    if ($request->ajax()) {
        \Log::info('AJAX request received');

        $checkin_date = new \DateTime($request->checkin_date . ' ' . $request->checkin_time);
        $checkout_date = new \DateTime($request->checkout_date . ' ' . $request->checkout_time);
        $interval = $checkin_date->diff($checkout_date);
        $per_day_tariff = $request->per_day_tariff;  
        $no_of_days = 0;
        $day_entries = [];
        $businesssettings=businesssetting::find(1);
        $standard_checkout_time=$businesssettings->standard_checkout_time;

        switch ($calculation_type) {
            case '24hour':
                $total_hours = ($interval->days * 24) + $interval->h + ($interval->i / 60);
                $no_of_days = ceil($total_hours / 24);
                break;

            case '12hour':
                // Base checkout time for comparison
                $base_checkin_11am = new \DateTime($checkin_date->format('Y-m-d') . $standard_checkout_time);
                $base_checkout_11am = new \DateTime($checkout_date->format('Y-m-d') . $standard_checkout_time);

                // Adjust 11 AM times to the next day if necessary
                if ($checkin_date > $base_checkin_11am) {
                    $base_checkin_11am->modify('+1 day');
                }
                if ($checkout_date > $base_checkout_11am) {
                    $base_checkout_11am->modify('+1 day');
                }

                // Initialize the number of days
                $no_of_days = 0;

                // Check if check-in time is more than 3 hours after 11:00 AM
                if ($checkin_date > $base_checkin_11am->modify('-8 hours')) {
                    $no_of_days++;
                }

                // Calculate the full days from 11:00 AM to 11:00 AM
                $full_days_interval = $base_checkin_11am->diff($checkout_date);
                $full_days = $full_days_interval->days;
                $no_of_days += $full_days;

                // Check if checkout time is more than 3 hours after 11:00 AM
                $remaining_interval = $base_checkout_11am->diff($checkout_date);
                if ($remaining_interval->h >= 3 || ($remaining_interval->h == 2 && $remaining_interval->i > 0)) {
                    $no_of_days++;
                }
                break;

            case 'hourly':
                $interval = $checkin_date->diff($checkout_date);
                $total_hours = ($interval->days * 24) + $interval->h + ($interval->i / 60);
                $no_of_days = ceil($total_hours / 24);
                break;
        }

        $total_rent = $per_day_tariff * $no_of_days;

        // Generate day entries
        $current_date_time = clone $checkin_date;

        switch ($calculation_type) {
            case '24hour':
                for ($i = 0; $i < $no_of_days; $i++) {
                    $end_date_time = (clone $current_date_time)->modify('+1 day');

                    $day_entries[] = [
                        'day_count' => 1,
                        'checkin_date' => $current_date_time->format('d-m-y H:i:s'),
                        'checkout_date' => $end_date_time->format('d-m-y H:i:s'),
                        'rent' => $per_day_tariff,
                        'total' => $per_day_tariff * ($i + 1)
                    ];

                    $current_date_time->modify('+1 day');
                }
                break;

            case '12hour':
                for ($i = 0; $i < $no_of_days; $i++) {
                    $end_date_time = (clone $current_date_time)->modify('+1 day');

                    // Adjust the day entry to reflect actual check-in and check-out times
                    if ($i == 0) {
                        // First day entry
                        $day_entries[] = [
                            'day_count' => 1,
                            'checkin_date' => $current_date_time->format('Y-m-d H:i:s'),
                            'checkout_date' => Carbon::parse($end_date_time)->format('Y-m-d') . ' ' . Carbon::parse($standard_checkout_time)->format('H:i:s'),

                            // 'checkout_date' => $end_date_time->format('Y-m-d 11:00:00'),
                              // First checkout at 11:00 AM next day
                            'rent' => $per_day_tariff,
                            'total' => $per_day_tariff * ($i + 1)
                        ];
                    } elseif ($i == $no_of_days - 1) {
                        // Last day entry
                        $day_entries[] = [
                            'day_count' => 1,
                            // 'checkin_date' => $current_date_time->format('Y-m-d 11:00:00'),
'checkin_date' => Carbon::parse($current_date_time)->format('Y-m-d') . ' ' . Carbon::parse($standard_checkout_time)->format('H:i:s'),


                            'checkout_date' => $checkout_date->format('Y-m-d H:i:s'),  // Actual checkout time
                            'rent' => $per_day_tariff,
                            'total' => $per_day_tariff * ($i + 1)
                        ];
                    } else {
                        // Middle days
                        $day_entries[] = [
                            'day_count' => 1,
                            'checkin_date' => $current_date_time->format('Y-m-d 11:00:00'),
                            'checkout_date' => $end_date_time->format('Y-m-d 11:00:00'),  // 11:00 AM next day
                            'rent' => $per_day_tariff,
                            'total' => $per_day_tariff * ($i + 1)
                        ];
                    }

                    $current_date_time->modify('+1 day');
                }
                break;
        }

        return response()->json([
            'no_of_days' => $no_of_days,
            'total_rent' => $total_rent,
            'day_entries' => $day_entries
        ]);
    }
}

public function destroy(string $id)
{
    $roomcheckout = roomcheckout::where('voucher_no',$id);
    // $roomcheckin=roomcheckin::whare('checkout_voucher_no',$id)->get();
    $roomsdetails = RoomCheckin::where('checkout_voucher_no', $id)->get();



    // Check if the roomcheckout exists
    if ($roomcheckout) {

     foreach ($roomsdetails as $roomdetail) {
        $room_id = $roomdetail->room_id;
        Room::where('id', $room_id)->update(['room_status' => 'occupied']);
                }


        // Delete the roomcheckout
        $roomcheckout->delete();
        $checkinUpdated = RoomCheckin::where('checkout_voucher_no', $id)
        ->update(['checkout_voucher_no' => '0']);
        $ledger=ledger::where('transaction_type','Check_Out')
        ->where('voucher_no',$id);
        if ($ledger) {
            // Update the room status to "vacant"

            $ledger->delete();
        }
        $ledger_sale=ledger::where('transaction_type','Room_Checkout')
                      ->where('voucher_no',$id);    
                      if ($ledger_sale) {
                        // Update the room status to "vacant"
            
                        $ledger_sale->delete();
                    }

        return redirect('/roomcheckouts')->with('message', 'Record Delete successfully!');
    } else {
        // roomcheckout not found
        return redirect('/roomcheckouts')->with('error', 'roomcheckout Not Found');

    }
}

//function for post amount to ledger 
public function post_amount(Request $request)
{
    $posting_acc_id = $request->posting_acc_id;
    $amt_post_credit_amt = $request->amt_post_credit_amt;
    if ($posting_acc_id > 0 | $amt_post_credit_amt > 0) {


        $date_variable = $request->checkin_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_entry_date = $parsed_date->format('Y-m-d');
        $accountname = account::with('accountgroup')
            ->where('mobile', $request->guest_mobile)->first();
        $paymentmode = account::with('accountgroup')
            ->where('id', $request->posting_acc_id)->first();

        $ledger = new ledger;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->check_out_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = 'Check_Out';
        $ledger->payment_mode_id = $posting_acc_id;
        $ledger->payment_mode_name = $paymentmode->account_name;

        $ledger->account_id = $accountname->id;
        $ledger->account_name = $accountname->account_name;
        $ledger->account_group_id = $accountname->account_group_id;
        $ledger->account_group_name = $accountname->accountgroup->account_group_name;
        $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
        $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
        $ledger->credit = $request->voucher_posting_amt;
        $ledger->amount = $request->voucher_posting_amt;
        $ledger->remark = "Check_Out/".$request->check_out_no;
        $ledger->simpal_amount = "-" . $request->voucher_posting_amt;
        //post_amt -  this amount post on 
        $ledger->save();


        $ledger = new ledger;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->check_out_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = 'Check_Out';
        $ledger->payment_mode_id = $posting_acc_id;
        $ledger->payment_mode_name = $accountname->account_name;
        $ledger->account_id = $posting_acc_id;
        $ledger->account_name = $paymentmode->account_name;
        $ledger->account_group_id = $paymentmode->account_group_id;
        $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
        $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
        $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
        $ledger->debit = $request->voucher_posting_amt;
        $ledger->amount = $request->voucher_posting_amt;
        $ledger->remark = "Check_Out/".$request->check_out_no;
        $ledger->simpal_amount = "+" . $request->voucher_posting_amt;
                //post_amt + 
        $ledger->save();


    }
}

public function sale_post_amount(Request $request)
{
    $posting_acc_id = $request->posting_acc_id;
    $bill_amount = $request->bill_amount;
    if ($posting_acc_id > 0 | $bill_amount > 0) {


        $date_variable = $request->checkin_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_entry_date = $parsed_date->format('Y-m-d');
        $paymentmode = account::with('accountgroup')
            ->where('mobile', $request->guest_mobile)->first();
        $accountname = account::with('accountgroup')
            ->where('account_name', 'Room_Checkout')->first();

        $ledger = new ledger;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->check_out_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = 'Room_Checkout';
        $ledger->payment_mode_id = $posting_acc_id;
        $ledger->payment_mode_name = $paymentmode->account_name;

        $ledger->account_id = $accountname->id;
        $ledger->account_name = $accountname->account_name;
        $ledger->account_group_id = $accountname->account_group_id;
        $ledger->account_group_name = $accountname->accountgroup->account_group_name;
        $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
        $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
        $ledger->credit = $request->bill_amount;
        $ledger->amount = $request->bill_amount;
        $ledger->remark = "Room_Checkout/".$request->check_out_no;
        $ledger->simpal_amount = "-" . $request->bill_amount;
        //post_amt -  this amount post on 
        $ledger->save();


        $ledger = new ledger;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->check_out_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = 'Room_Checkout';
        $ledger->payment_mode_id = $accountname->id;
        $ledger->payment_mode_name = $accountname->account_name;
        $ledger->account_id = $paymentmode->id;
        $ledger->account_name = $paymentmode->account_name;
        $ledger->account_group_id = $paymentmode->account_group_id;
        $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
        $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
        $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
        $ledger->debit = $request->bill_amount;
        $ledger->amount = $request->bill_amount;
        $ledger->remark = "Room_Checkout/".$request->check_out_no;
        $ledger->simpal_amount = "+" . $request->bill_amount;
                //post_amt + 
        $ledger->save();


    }
}
public function post_amount_credit(Request $request)
{   


    $amt_post_credit_id = $request->amt_post_credit_id;
    $amt_post_credit_amt = $request->amt_post_credit_amt;
    if ($amt_post_credit_id > 0 | $amt_post_credit_amt > 0) {

        $date_variable = $request->checkin_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_entry_date = $parsed_date->format('Y-m-d');
        $accountname = account::with('accountgroup')
            ->where('mobile', $request->guest_mobile)->first();
        $paymentmode = account::with('accountgroup')
            ->where('id', $request->amt_post_credit_id)->first();

        $ledger = new ledger;
        $ledger->voucher_no = $request->voucher_no;
        $ledger->reciept_no = $request->check_out_no;
        $ledger->entry_date = $formatted_entry_date;
        $ledger->transaction_type = 'Check_Out';
        $ledger->payment_mode_id = $amt_post_credit_id;
        $ledger->payment_mode_name = $paymentmode->account_name;

        $ledger->account_id = $accountname->id;
        $ledger->account_name = $accountname->account_name;
        $ledger->account_group_id = $accountname->account_group_id;
        $ledger->account_group_name = $accountname->accountgroup->account_group_name;
        $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
        $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
        $ledger->debit = $amt_post_credit_amt;
        $ledger->amount = $amt_post_credit_amt;
        $ledger->remark = $request->voucher_no;
        $ledger->simpal_amount = "+" . $amt_post_credit_amt;
        //post_amount_save _credit wala function
        $ledger->save();


        // $ledger = new ledger;
        // $ledger->voucher_no = $request->voucher_no;
        // $ledger->reciept_no = $request->check_out_no;
        // $ledger->entry_date = $formatted_entry_date;
        // $ledger->transaction_type = 'Check_Out';
        // $ledger->payment_mode_id = $amt_post_credit_id;
        // $ledger->payment_mode_name = $accountname->account_name;
        // $ledger->account_id = $amt_post_credit_id;
        // $ledger->account_name = $paymentmode->account_name;
        // $ledger->account_group_id = $paymentmode->account_group_id;
        // $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
        // $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
        // $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
        // $ledger->debit = $request->voucher_posting_amt;
        // $ledger->amount = $request->voucher_posting_amt;
        // $ledger->remark = $request->voucher_no;
        // $ledger->simpal_amount = "+" . $request->voucher_posting_amt;
        // $ledger->save();


    }
}


    
}
