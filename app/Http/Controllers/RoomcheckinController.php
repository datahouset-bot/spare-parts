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
use App\Models\inventory;
use App\Models\optionlist;
use App\Models\othercharge;
use App\Models\roombooking;
use App\Models\roomcheckin;
use Illuminate\Support\Str;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\businesssource;
use App\Models\compinfofooter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreroomcheckinRequest;
use App\Http\Requests\UpdateroomcheckinRequest;

class RoomcheckinController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $roomcheckins = DB::table('roomcheckins')
        ->select('voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'), 'check_in_no', 'guest_name' ,'guest_mobile','checkin_date','checkin_time','checkout_voucher_no')
         ->groupBy('voucher_no', 'check_in_no', 'guest_name' ,'guest_mobile','checkin_date','checkin_time','checkout_voucher_no')
        ->where('checkout_voucher_no', '0')
        ->get();


        // Step 2: Retrieve the full records based on those IDs

         return view('entery.room.checkin.room_checkin_index', compact('roomcheckins'));

    }
    public function police_station_report()
    {


        $roomcheckins = DB::table('roomcheckins')
         ->leftJoin('accounts', 'roomcheckins.account_id', '=', 'accounts.id')

        ->select('voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'), 'check_in_no', 'guest_name' ,'guest_mobile','checkin_date','checkin_time','checkout_voucher_no','account_id','account_id_pic', 'account_pic1','account_idproof_name','account_idproof_no','nationality','state','city','address','address2','comming_from','going_to','no_of_guest')
         ->groupBy('voucher_no', 'check_in_no', 'guest_name' ,'guest_mobile','checkin_date','checkin_time','checkout_voucher_no','account_id','account_id_pic', 'account_pic1','account_idproof_name','account_idproof_no','nationality','state','city','address','address2','comming_from','going_to','no_of_guest')
        ->where('checkout_voucher_no', '0')
        ->get();

// dd($roomcheckins);


        // Step 2: Retrieve the full records based on those IDs

         return view('entery.room.checkin.police_station_report', compact('roomcheckins'));

    }

    public function create()
    {



        $uniqueIds = roombooking::where('checkin_voucher_no', '0')
            ->groupBy('voucher_no')
            ->select(DB::raw('MIN(id) as id'))
            ->pluck('id');

        $roombookings = roombooking::whereIn('id', $uniqueIds)
            ->where('checkin_voucher_no', '=', 0)
            ->get();
        $paymentmodes = account::where('account_group_id', '4')
            ->orWhere('account_group_id', '5')
            ->get();



        $businesssource = businesssource::all();
        $package = package::all();
        $othercharges = othercharge::all();



        $rooms = room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->where('room_status', 'vacant')
            ->get();

        $checkin_record = roomcheckin::count();
        if ($checkin_record > 0) {
            $lastRecord = RoomCheckin::orderBy('voucher_no', 'desc')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Check_In')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Check_In')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }


        return view('entery.room.checkin.room_checkin', compact('rooms', 'roombookings', 'businesssource', 'package', 'new_bill_no', 'new_voucher_no', 'othercharges', 'paymentmodes'));






    }
    public function ledger_show(Request $request, $id)
    {
        $roomcheckins = roomcheckin::where('voucher_no', $id)->first();
        $account_id = $roomcheckins->account_id;



        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $ledgers = ledger::where('account_id', $account_id)
            ->get();

        $accounts = Account::orderBy('account_name', 'asc')->get();
        $account_name = Account::find($account_id);
        $opening_balance_account = $account_name->op_balnce;
        $opning_balance_type = $account_name->balnce_type;
        $debit_total = 0;
        $credit_total = 0;

        foreach ($ledgers as $record) {
            $debit_total += $record->debit;
            $credit_total += $record->credit;
        }
        $total_balance = $debit_total - $credit_total;
        if ($opning_balance_type === 'Dr') {
            $final_opning_balance = $total_balance + $opening_balance_account;
        } else {
            $final_opning_balance = $total_balance - $opening_balance_account;
        }
        return [
            'final_opning_balance' => $final_opning_balance,
            // Add other values you may need to return
        ];


    }
    public function create_after_select_booking($voucherNo)
    {

        // $ledgerData = $this->ledger_show($request, $id);


        // Retrieve room bookings within the specified date range
        $roombookings = RoomBooking::with('room')->where('voucher_no', $voucherNo)->get();
        $booking_detail = RoomBooking::where('voucher_no', $voucherNo)->first();


        $businesssource = businesssource::all();
        $package = package::all();
        $othercharges = othercharge::all();
        $paymentmodes = account::where('account_group_id', '4')
        ->orWhere('account_group_id', '5')
        ->get();




        $rooms = room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->where('room_status', 'vacant')
            ->get();

        $checkin_record = roomcheckin::count();
        if ($checkin_record > 0) {
            $lastRecord = RoomCheckin::orderBy('voucher_no', 'desc')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Check_In')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Check_In')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }


        return view('entery.room.checkin.room_checkin_select_booking', compact('rooms', 'roombookings', 'businesssource', 'package', 'new_bill_no', 'new_voucher_no', 'othercharges', 'booking_detail','paymentmodes'));






    }
    public function store1(Request $request)
    {

        dd($request);

    }

    public function vacant_all_room()
    { // this is for vacant all room 
        Room::query()->update(['room_status' => 'vacant']);
        return redirect()->back()->with('message', 'All room statuses have been updated to vacant.');
    }

    public function create_account(Request $request)
    {
        $uploadPath = 'uploads/account_image';
        if ($request->hasFile('guest_id_pic')) {
            $image1 = $request->guest_id_pic;
            $name = $image1->getClientOriginalName();
            $image1->storeAS('public\account_image', $name);
            $validatedData['guest_id_pic'] = $name;


        } else {
            $name = NULL;
        }
        if ($request->hasFile('guest_pic')) {

            $image2 = $request->guest_pic;
            $name2 = $image2->getClientOriginalName();
            $image2->storeAS('public\account_image', $name2);
            $validatedData['guest_pic'] = $name2;
        } else {
            $name2 = NULL;
        }


        $customer = Account::Where('mobile', $request->guest_mobile)
            ->first();
        if ($customer == null) {


            $account = new account;
            $account->account_name = $request->guest_name;
            $account->account_group_id = '6';
            $account->op_balnce = '0';
            $account->balnce_type = 'Dr';
            $account->city = $request->guest_city;
            $account->state = $request->guest_state;
            $account->mobile = $request->guest_mobile;
            $account->gst_no = $request->gst_no;
            $account->gst_code = substr($request->gst_no, 0, 2);
            $account->address = $request->guest_address;
            $account->address = $request->guest_address2;
            $account->account_idproof_name = $request->guest_idproof;
            $account->account_idproof_no = $request->guest_idproof_no;
            $account->account_id_pic = $name;
            $account->account_pic1 = $name2;
            $account->email = $request->guest_email;
            $account->nationality = $request->guest_contery;
            $account->pincode = $request->guest_pincode;
            $account->account_af1=$request->firm_name;
            $account->account_af2=$request->firm_address;
 

            $account->save();
        }

    }
    public function post_amount(Request $request)
    {
        $posting_acc_id = $request->posting_acc_id;
        $booking_amount = $request->booking_amount;
        if ($posting_acc_id > 0 | $booking_amount > 0) {


            $date_variable = $request->checkin_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_entry_date = $parsed_date->format('Y-m-d');
            $accountname = account::with('accountgroup')
                ->where('mobile', $request->guest_mobile)->first();
            $paymentmode = account::with('accountgroup')
                ->where('id', $request->posting_acc_id)->first();

            $ledger = new ledger;
            $ledger->voucher_no = $request->voucher_no;
            $ledger->reciept_no = $request->check_in_no;
            $ledger->entry_date = $formatted_entry_date;
            $ledger->transaction_type = 'Check_In';
            $ledger->payment_mode_id = $posting_acc_id;
            $ledger->payment_mode_name = $paymentmode->account_name;

            $ledger->account_id = $accountname->id;
            $ledger->account_name = $accountname->account_name;
            $ledger->account_group_id = $accountname->account_group_id;
            $ledger->account_group_name = $accountname->accountgroup->account_group_name;
            $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
            $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
            $ledger->credit = $request->booking_amount;
            $ledger->amount = $request->booking_amount;
            $ledger->remark ='Check_In/'. $request->check_in_no;
            $ledger->simpal_amount = "-" . $request->booking_amount;
            $ledger->save();


            $ledger = new ledger;
            $ledger->voucher_no = $request->voucher_no;
            $ledger->reciept_no = $request->check_in_no;
            $ledger->entry_date = $formatted_entry_date;
            $ledger->transaction_type = 'Check_In';
            $ledger->payment_mode_id = $posting_acc_id;
            $ledger->payment_mode_name = $accountname->account_name;
            $ledger->account_id = $posting_acc_id;
            $ledger->account_name = $paymentmode->account_name;
            $ledger->account_group_id = $paymentmode->account_group_id;
            $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
            $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
            $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
            $ledger->amount = $request->booking_amount;
            $ledger->remark ='Check_In/'. $request->check_in_no;
            $ledger->debit = $request->booking_amount;
            $ledger->simpal_amount = "+" . $request->booking_amount;
            $ledger->save();


        }
    }


    public function store(Request $request)
    {
        // dd($request);


        $validator= validator::make($request->all(),[
            // 'token' => $request->input('token', Str::uuid()),
            'check_in_no' => 'required|string',
            'voucher_no' => 'required|string',
            'checkin_date' => 'required|date',
            'checkin_time' => 'required|date_format:H:i',
            'guest_name' => 'required|string',
            'guest_mobile' => 'required|string',
            'business_source_id'=>'required|string',
            'package_id'=>'required|string'


        ]);
        if ($validator->passes()) {
        $guest_mobile = $request->guest_mobile;
        $find_account = account::where('mobile', $guest_mobile)->first();
        // dd($find_account);


        if ($find_account !== NULL) {
            $this->post_amount($request);
            $account_id = $find_account->id;

            $date_variable = $request->checkin_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_checkin_date = $parsed_date->format('Y-m-d');
            $validatedData['checkin_date'] = $formatted_checkin_date;


            $checkin_room_ids = $request->checkin_room_id;

            foreach ($checkin_room_ids as $checkin_room_id) {
                $checkIn = new roomcheckin;


                $roomdetails = room::where('id', $checkin_room_id)->first();
                $checkIn->room_id = $checkin_room_id;
                $checkIn->room_no = $roomdetails->room_no;
                $checkIn->business_source_id = $request->business_source_id;

                $checkIn->package_id = $roomdetails->roomtype->package_id;
                $checkIn->guest_name = $request->guest_name;
                $checkIn->account_id = $account_id;

                $checkIn->guest_mobile = $request->guest_mobile;
                $checkIn->commited_days = $request->commited_days;
                $checkIn->no_of_guest = $request->no_of_guest;
                $checkIn->checkin_remark1 = $request->checkin_remark1;
                $checkIn->checkin_remark2 = $request->checkin_remark2;
                $checkIn->purpose_of_visit = $request->purpose_of_visit;
                $checkIn->comming_from = $request->comming_from;
                $checkIn->going_to = $request->going_to;
                $checkIn->posting_acc_id = $request->posting_acc_id;

                $checkIn->voucher_payment_ref = $request->voucher_payment_ref;
                $checkIn->voucher_payment_remark = $request->voucher_payment_remark;
                $checkIn->checkin_advance = $request->booking_amount;
                $checkIn->agent = $request->agent;
  

                $checkIn->check_in_no = $request->check_in_no;
                $checkIn->voucher_no = $request->voucher_no;
                $checkIn->checkin_date = $formatted_checkin_date;
                $checkIn->checkin_time = $request->checkin_time;
                $checkIn->room_tariff_perday = $request->room_tariff_perday;
                $checkIn->booking_voucher_no = $request->booking_voucher_no;

                //  $checkIn->checkin_room_id=$request->checkin_room_id;


                $checkIn->save();

                $booking_voucher_no = $request->booking_voucher_no;

                if ($booking_voucher_no > 0) {
                    $roombooking_update = roombooking::where('voucher_no', $request->booking_voucher_no)->update(['checkin_voucher_no' => $request->voucher_no]);

                }
                room::where('id', $checkin_room_id)->update(['room_status' => 'occupied']);

            }

        } else {
            $this->create_account($request);
            $this->store($request);
        }






        //retuern to dashboard 
        $currentDate = Carbon::now()->toDateString();

        // Fetch booked room IDs where the current date is between checkin_date and checkout_date
        $bookedRoomIds = roombooking::where('checkin_date', '<=', $currentDate)
            ->where('checkout_date', '>=', $currentDate)
            ->where('checkin_voucher_no', '0')
            ->pluck('room_id')
            ->toArray();

        // Fetch all rooms with their room types
        $rooms = Room::with('roomtype')->get();
        //posting amount to ledger 




        return view('entery.room.room_dashboard', ['data' => $rooms, 'bookedRoomIds' => $bookedRoomIds]);


     
    } else {
     return back()->withInput()->withErrors($validator);
    }





    }






    public function show_roombooking(Request $request)
    {
        $id = $request->roombooking_id;
        $rooms = room::with(['roomtype.gstmaster', 'roomtype.package'])->get();

        $roombookings = roombooking::find($id);
        return view('entery.room.checkin.room_checkin_selected_booking', compact('rooms', 'roombookings'));

    }
    public function show(Request $request, $id)
    {   //this is function for show all detail when we select anychecin in checkout voucher  using ajex 
        if ($request->ajax()) {
            \Log::info('AJAX request received');
        }
        $roomcheckins = roomcheckin::where('voucher_no', $id)->get();


        if ($roomcheckins) {
            return response()->json($roomcheckins->toArray());
        } else {
            return response()->json([]);
        }
    }




    public function edit(roomcheckin $roomcheckin)
    {
        // open Form For edit Checkin 
    }

    public function update(UpdateroomcheckinRequest $request, roomcheckin $roomcheckin)
    {
        //Update Edited Check In 
    }

    public function destroy(string $id)
    {

        // Find all room check-in records with the given voucher_no $id is voucehr no 
        roombooking::where('checkin_voucher_no', $id)->update(['checkin_voucher_no' => '0']);
        $roomcheckins = roomcheckin::where('voucher_no', $id)->get();
        //   $invntory=$foodbill = foodbill::where('service_id', $id)->first();
            // $foodbill_voucher_no=$invntory->voucer_no;
            // $inventory=inventory::where('voucher_type', 'Foodbill')->where('voucher_no',$foodbill_voucher_no);
            // dd($inventory);


        if ($roomcheckins->isEmpty()) {
            return redirect('/roomcheckins')->with('message', 'No room check-ins found for the provided voucher number');
        }

        // Loop through each room check-in record
        foreach ($roomcheckins as $roomcheckin) {
            // Retrieve the room associated with the room check-in
            $room = Room::find($roomcheckin->room_id);

            if ($room) {
                // Update the room status to "vacant"
                $room->room_status = 'vacant';
                $room->save();
            }



            // Delete the room check-in record
            $roomcheckin->delete();
            $foodbill = foodbill::where('service_id', $id);
            
            if ($foodbill) {
                // Update the room status to "vacant"

                $foodbill->delete();
            }
            $kot = kot::where('service_id', $id);
            if ($kot) {
                // Update the room status to "vacant"

                $kot->delete();
            }
          
            $ledger=ledger::where('transaction_type','Check_In')
            ->where('voucher_no',$id);
            if ($ledger) {
                // Update the room status to "vacant"

                $ledger->delete();
            }


        }

        return redirect('/roomcheckins')->with('message', 'All matching room check-ins deleted successfully!');
    }

    public function roomcheckin_view(string $id)
    {
        $roomcheckins = roomcheckin::where('voucher_no', $id)->get();

        echo "<pre>";
        print_r($roomcheckins);
        // if ($roomcheckins->isEmpty()) {
        //     return redirect('/roomcheckins')->with('message', 'No room check-ins found for the provided voucher number');
        // }

        // foreach ($roomcheckins as $roomcheckin) {
        //     $room = Room::find($roomcheckin->room_id);
        // }

        // return redirect('/roomcheckins')->with('message', 'All matching room check-ins  show heare ');





    }
    public function show_selected_booking(Request $request, $id)
    {   //this is function for show all detail of rooms only  when we select any room using ajex 
        if ($request->ajax()) {
            \Log::info('AJAX request received');
        }

        $roombooking = roombooking::all()->find($id);


        if ($roombooking) {
            return response()->json($roombooking->toArray());
        } else {
            return response()->json([]);
        }
    }
}



