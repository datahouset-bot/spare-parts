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
use App\Models\componyinfo;
use App\Models\othercharge;
use App\Models\roombooking;
use App\Models\roomcheckin;
use App\Models\WhatsappSms;
use Illuminate\Support\Str;
use App\Models\accountgroup;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\businesssource;
use App\Models\compinfofooter;
use App\Models\softwarecompany;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
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


        $roomcheckins = roomcheckin::select(
            'account_id',
            'voucher_no',
            DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'),
            'check_in_no',
            'guest_name',
            'guest_mobile',
            'checkin_date',
            'checkin_time',
            'checkout_voucher_no',
            'no_of_guest',
            'checkinaf9',
            'checkinaf10'

        )
            ->withinFY('checkin_date')
            ->where('checkout_voucher_no', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->groupBy(
                'account_id',
                'voucher_no',
                'check_in_no',
                'guest_name',
                'guest_mobile',
                'checkin_date',
                'checkin_time',
                'checkout_voucher_no',
                'no_of_guest',
                'checkinaf9',
            'checkinaf10'
            )
            ->get();



        // Step 2: Retrieve the full records based on those IDs

        return view('entery.room.checkin.room_checkin_index', compact('roomcheckins'));

    }

    public function guest_reg_print($id)
    {


        $roomcheckins = roomcheckin::withinFY('checkin_date')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)->first();
        $guset_details = account::where('firm_id', Auth::user()->firm_id)
            ->where('mobile', $roomcheckins->guest_mobile)->first();
        $roomnos = roomcheckin::withinFY('checkin_date')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)->get();


        return view('entery.room.room_checkin_view', compact('roomcheckins', 'guset_details', 'roomnos'));

    }


    public function police_station_report()
    {
        $roomcheckouts = [];
        return view('reports.genralreport.police_station_pageshow', compact('roomcheckouts'));
    }
    public function police_station_report_result(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);




        if ($validator->passes()) {
            // Format the dates
            $formatted_from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
            $formatted_to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');

            $roomcheckins = roomcheckin::query()
                ->select(
                    'roomcheckins.voucher_no',
                    \DB::raw('GROUP_CONCAT(roomcheckins.room_no ORDER BY roomcheckins.room_no ASC SEPARATOR ", ") as room_nos'),
                    'roomcheckins.check_in_no',
                    'roomcheckins.guest_name',
                    'roomcheckins.guest_mobile',
                    'roomcheckins.checkin_date',
                    'roomcheckins.checkin_time',
                    'roomcheckins.checkout_voucher_no',
                    'roomcheckins.account_id',
                    'accounts.account_id_pic',
                    'accounts.account_pic1',
                    'accounts.account_idproof_name',
                    'accounts.account_idproof_no',
                    'accounts.nationality',
                    'accounts.state',
                    'accounts.pincode',
                    'accounts.city',
                    'accounts.address',
                    'accounts.address2',
                    'roomcheckins.comming_from',
                    'roomcheckins.going_to',
                    'roomcheckins.no_of_guest',
                    'roomcheckins.checkinaf1',
                    'roomcheckins.checkinaf2',
                    'roomcheckins.checkinaf3',
                    'roomcheckins.checkinaf4',
                    'roomcheckins.checkinaf5',
                    'roomcheckins.checkinaf6',
                    'roomcheckins.checkinaf7',
                    'roomcheckins.checkinaf8',
                    'roomcheckins.checkinaf9',
                    'roomcheckins.checkinaf10',
                )
                ->leftJoin('accounts', 'roomcheckins.account_id', '=', 'accounts.id')
                ->withinFY('checkin_date') // This works now
                ->where('roomcheckins.firm_id', Auth::user()->firm_id)
                ->whereBetween('roomcheckins.checkin_date', [$formatted_from_date, $formatted_to_date])
                ->groupBy(
                    'roomcheckins.voucher_no',
                    'roomcheckins.check_in_no',
                    'roomcheckins.guest_name',
                    'roomcheckins.guest_mobile',
                    'roomcheckins.checkin_date',
                    'roomcheckins.checkin_time',
                    'roomcheckins.checkout_voucher_no',
                    'roomcheckins.account_id',
                    'accounts.account_id_pic',
                    'accounts.account_pic1',
                    'accounts.account_idproof_name',
                    'accounts.account_idproof_no',
                    'accounts.nationality',
                    'accounts.state',
                    'accounts.city',
                    'accounts.pincode',
                    'accounts.address',
                    'accounts.address2',
                    'roomcheckins.comming_from',
                    'roomcheckins.going_to',
                    'roomcheckins.no_of_guest',
                    'roomcheckins.checkinaf1',
                    'roomcheckins.checkinaf2',
                    'roomcheckins.checkinaf3',
                    'roomcheckins.checkinaf4',
                    'roomcheckins.checkinaf5',
                    'roomcheckins.checkinaf6',
                    'roomcheckins.checkinaf7',
                    'roomcheckins.checkinaf8',
                    'roomcheckins.checkinaf9',
                    'roomcheckins.checkinaf10',
                )
                ->get();


            if ($request->input('format') == "2") {
                        $guest_name_font=$request->guest_name_font;
        $guest_address_font=$request->guest_address_font;
        
       $guest_mobile_font=$request->guest_mobile_font;

                $pdf = Pdf::loadView('entery.room.checkin.police_station_report2', compact('roomcheckins','guest_name_font','guest_address_font','guest_mobile_font'));

                // Set paper size and orientation
                $pdf->setPaper('A4', 'portrait');

                // Return PDF response
                return $pdf->stream('police_station_report.pdf'); // For inline view

                // return view('entery.room.checkin.police_station_report2', compact('roomcheckins'));
            } else {
                return view('entery.room.checkin.police_station_report', compact('roomcheckins'));
            }


        }
    }


    public function create()
    {



        $uniqueIds = roombooking::withinFY('checkin_date')->where('checkin_voucher_no', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->groupBy('voucher_no')
            ->select(DB::raw('MIN(id) as id'))
            ->pluck('id');

        $roombookings = roombooking::withinFY('checkin_date')->whereIn('id', $uniqueIds)
            ->where('checkin_voucher_no', '=', 0)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();
        $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
            ->whereHas('accountGroup', function ($query) {
                $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
            })
            ->get();



        $businesssource = businesssource::where('firm_id', Auth::user()->firm_id)->get();
        $package = package::where('firm_id', Auth::user()->firm_id)->get();
        $othercharges = othercharge::where('firm_id', Auth::user()->firm_id)->get();



        $rooms = room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->where('firm_id', Auth::user()->firm_id)
            ->where('room_status', 'vacant')
            ->get();

        $checkin_record = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->count();
        if ($checkin_record > 0) {
            $lastRecord = RoomCheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Check_In')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Check_In')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }
        $gust_customer_account_search = accountgroup::where('firm_id', Auth::user()->firm_id)->
            Where('account_group_name', 'Guest Customer')
            ->first();
        $accountgroup_id = $gust_customer_account_search->id;
        $guset_data = account::where('firm_id', Auth::user()->firm_id)
            ->where('account_group_id', $accountgroup_id)->
            orderBy('account_name', 'asc')

            ->get();


        return view('entery.room.checkin.room_checkin', compact('rooms', 'roombookings', 'businesssource', 'package', 'new_bill_no', 'new_voucher_no', 'othercharges', 'paymentmodes', 'guset_data'));

    }
     public function checkin_print_view($voucher_no)
    {

        $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Check_in')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('entery.room.checkin.room_checkinn_print_select', compact('voucher_no', 'fromtlist'));

    }
    public function ledger_show($id)
    {
        $roombookings = roombooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)->first();

        $account_details = account::where('firm_id', Auth::user()->firm_id)
            ->where('mobile', $roombookings->guest_mobile)->first();


        $account_id = $account_details->id;




        $from_date = Carbon::now()->subYear()->format('Y-m-d');
        $to_date = Carbon::now()->addYear()->format('Y-m-d');
        $ledgers = ledger::withinFY('entry_date')->where('firm_id', Auth::user()->firm_id)
            ->where('account_id', $account_id)
            ->get();

        $accounts = Account::where('firm_id', Auth::user()->firm_id)
            ->orderBy('account_name', 'asc')->get();
        $account_name = Account::find($account_id);

        $opblance = $account_name->op_balnce;
        if ($opblance) {
            $opening_balance_account = $opblance;
        } else {
            $opening_balance_account = 0;
        }
        // $opening_balance_account=$account_name->op_balnce;
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
        $ledgerData = $this->ledger_show($voucherNo);

        // $ledgerData = $this->ledger_show($request, $id);


        // Retrieve room bookings within the specified date range
        $roombookings = RoomBooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->with('room')->where('voucher_no', $voucherNo)->get();
        $roombooking_firstrecord = RoomBooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->with('room')->where('voucher_no', $voucherNo)->first();

        $booking_detail = RoomBooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucherNo)->first();


        $businesssource = businesssource::where('firm_id', Auth::user()->firm_id)->get();
        $package = package::where('firm_id', Auth::user()->firm_id)->get();
        $othercharges = othercharge::where('firm_id', Auth::user()->firm_id)->get();
        $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
            ->whereHas('accountGroup', function ($query) {
                $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
            })
            ->get();




$bookedRoomIds = $roombookings->pluck('room_id');

// Ab vacant rooms me se booked rooms hata do
$rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])
    ->where('firm_id', Auth::user()->firm_id)
    ->where('room_status', 'vacant')
    ->whereNotIn('id', $bookedRoomIds) // yeh important line hai
    ->get();

        $checkin_record = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)->count();
        if ($checkin_record > 0) {
            $lastRecord = RoomCheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Check_In')
                ->where('firm_id', Auth::user()->firm_id)
                ->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Check_In')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }



        return view('entery.room.checkin.room_checkin_select_booking', [
            'rooms' => $rooms,
            'roombooking_firstrecord' => $roombooking_firstrecord,
            'roombookings' => $roombookings,
            'businesssource' => $businesssource,
            'package' => $package,
            'new_bill_no' => $new_bill_no,
            'new_voucher_no' => $new_voucher_no,
            'othercharges' => $othercharges,
            'booking_detail' => $booking_detail,
            'paymentmodes' => $paymentmodes,
            'final_opning_balance' => $ledgerData['final_opning_balance'],
        ]);







    }


    public function vacant_all_room()
    { // this is for vacant all room 
        Room::where('firm_id', Auth::user()->firm_id)->query()->update(['room_status' => 'vacant']);
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


        $customer = Account::where('firm_id', Auth::user()->firm_id)
            ->Where('mobile', $request->guest_mobile)
            ->first();
        $gust_customer_account_search = accountgroup::where('firm_id', Auth::user()->firm_id)->
            Where('account_group_name', 'Guest Customer')
            ->first();
        $accountgroup_id = $gust_customer_account_search->id;



        if ($customer == null) {


            $account = new account;
            $account->firm_id = Auth::user()->firm_id;

            $account->account_name = $request->guest_name;
            $account->account_group_id = $accountgroup_id;
            $account->op_balnce = '0';
            $account->balnce_type = 'Dr';
            $account->city = $request->guest_city;
            $account->state = $request->guest_state;
            $account->mobile = $request->guest_mobile;
            $account->gst_no = $request->gst_no;
            $account->gst_code = substr($request->gst_no, 0, 2);
            $account->address = $request->guest_address;
            $account->address2 = $request->guest_address2;
            $account->account_idproof_name = $request->guest_idproof;
            $account->account_idproof_no = $request->guest_idproof_no;
            $account->account_id_pic = $name;
            $account->account_pic1 = $name2;
            $account->email = $request->guest_email;
            $account->nationality = $request->guest_contery;
            $account->pincode = $request->guest_pincode;
            $account->account_af1 = $request->firm_name;
            $account->account_af2 = $request->firm_address;
            $account->account_af4 = $request->guest_father_name;
            $account->account_af5 = $request->guest_age;
            $account->account_af6 = $request->guest_gender;
            $account->account_birthday = $request->account_birthday;
  



            $account->save();
        }

    }

    public function post_amount(Request $request)
    {
        $posting_acc_ids = $request->posting_acc_id;  // Array of account IDs
        $booking_amounts = $request->booking_amount;  // Array of amounts

        // Check if the arrays are set and contain values
        if (is_array($posting_acc_ids) && is_array($booking_amounts) && count($posting_acc_ids) > 0 && count($booking_amounts) > 0) {

            $date_variable = $request->checkin_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_entry_date = $parsed_date->format('Y-m-d');

            // Get the account name details using the guest's mobile number
            $accountname = account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('mobile', $request->guest_mobile)->first();

            // Loop through each payment mode and amount
            foreach ($posting_acc_ids as $index => $posting_acc_id) {
                $booking_amount = $booking_amounts[$index];

                // Ensure the payment mode and amount are valid
                if ($posting_acc_id > 0 && $booking_amount > 0) {

                    // Get the payment mode details by ID
                    $paymentmode = account::with('accountgroup')
                        ->where('firm_id', Auth::user()->firm_id)
                        ->where('id', $posting_acc_id)->first();


                    $roomNos = [];

                    foreach ($request->checkin_room_id as $roomId) {
                        $roomdetails = Room::where('firm_id', Auth::user()->firm_id)
                            ->where('id', $roomId)
                            ->first();

                        if ($roomdetails) {
                            $roomNos[] = $roomdetails->room_no;
                        }
                    }


                    // Credit ledger entry
                    $ledger = new ledger;
                    $ledger->firm_id = Auth::user()->firm_id;
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
                    $ledger->credit = $booking_amount;
                    $ledger->amount = $booking_amount;
                    $ledger->remark = "Room_Checkin/" . $request->check_in_no . "/Room No" . implode(',', $roomNos);
                    $ledger->tran_voucher_no = $request->voucher_no;
                    $ledger->simpal_amount = "-" . $booking_amount;
                    $ledger->userid = Auth::user()->id;
                    $ledger->username = Auth::user()->name;
                    $ledger->save();

                    // Debit ledger entry
                    $ledger = new ledger;
                    $ledger->firm_id = Auth::user()->firm_id;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->check_in_no;
                    $ledger->entry_date = $formatted_entry_date;
                    $ledger->transaction_type = 'Check_In';
                    $ledger->payment_mode_id = $posting_acc_id;
                    $ledger->payment_mode_name = $paymentmode->account_name;
                    $ledger->account_id = $posting_acc_id;
                    $ledger->account_name = $paymentmode->account_name;
                    $ledger->account_group_id = $paymentmode->account_group_id;
                    $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
                    $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
                    $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
                    $ledger->debit = $booking_amount;
                    $ledger->amount = $booking_amount;
                    $ledger->remark = "Room_Checkin/" . $request->check_in_no . "/Room No" . implode(',', $roomNos);
                    $ledger->tran_voucher_no = $request->voucher_no;
                    $ledger->simpal_amount = "+" . $booking_amount;
                    $ledger->userid = Auth::user()->id;
                    $ledger->username = Auth::user()->name;
                    $ledger->save();
                }
            }
        }
    }


    public function store(Request $request)
    {



        $existingRecords = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $request->voucher_no)
            ->count();



        if ($existingRecords >= 1) {
            return response()->json(['error' => 'Records already exist for this transaction type and voucher number and Please Dont Reloade and resubmit Same Entry .'], 400);
        }

        $validator = validator::make($request->all(), [
            // 'token' => $request->input('token', Str::uuid()),
            'check_in_no' => 'required|string',
            'voucher_no' => 'required|string',
            'checkin_date' => 'required|date',
            'checkin_time' => 'required|date_format:H:i',
            'guest_name' => 'required|string',
            'guest_mobile' => 'required|string',
            'business_source_id' => 'required|string',
            'package_id' => 'required|string'


        ]);
        if ($validator->passes()) {
            $guest_mobile = $request->guest_mobile;
            $find_account = account::where('firm_id', Auth::user()->firm_id)
                ->where('mobile', $guest_mobile)->first();
            // dd($find_account);


            if ($find_account !== NULL) {
                $this->post_amount($request);
                $account_id = $find_account->id;

                $date_variable = $request->checkin_date;
                $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
                $formatted_checkin_date = $parsed_date->format('Y-m-d');
                $validatedData['checkin_date'] = $formatted_checkin_date;

                $fy_start_date = $this->fy_start_date;
                $fy_end_date = $this->fy_end_date;
                $financialyeardata = $this->financialyeardata;
                if (
                    $financialyeardata &&
                    $formatted_checkin_date < $fy_start_date ||
                    $formatted_checkin_date > $fy_end_date
                ) {

return view('error.checkdate_on_fy',compact('fy_start_date','fy_end_date'));

                }





                $checkin_room_ids = $request->checkin_room_id;

                foreach ($checkin_room_ids as $checkin_room_id) {
                    $checkIn = new roomcheckin;
                    $checkIn->firm_id = Auth::user()->firm_id;


                    $roomdetails = room::where('firm_id', Auth::user()->firm_id)
                        ->where('id', $checkin_room_id)->first();
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
                    // $checkIn->posting_acc_id = $request->posting_acc_id;

                    $checkIn->voucher_payment_ref = $request->voucher_payment_ref;
                    $checkIn->voucher_payment_remark = $request->voucher_payment_remark;
                    $checkIn->checkin_advance = $request->total_receipt_amt;

                    $checkIn->agent = $request->agent;


                    $checkIn->check_in_no = $request->check_in_no;
                    $checkIn->voucher_no = $request->voucher_no;
                    $checkIn->checkin_date = $formatted_checkin_date;
                    $checkIn->checkin_time = $request->checkin_time;
                    $checkIn->room_tariff_perday = $request->room_tariff_perday;
                    $checkIn->booking_voucher_no = $request->booking_voucher_no;


                    if ($request->hasFile('second_guest_id_pic')) {

                        $image3 = $request->second_guest_id_pic;
                        $name3 = $image3->getClientOriginalName();
                        $image3->storeAS('public\account_image', $name3);

                        $checkIn->checkinaf2 = $name3;

                    }
                    if ($request->hasFile('third_guest_id_pic')) {

                        $image4 = $request->third_guest_id_pic;
                        $name4 = $image4->getClientOriginalName();
                        $image4->storeAS('public\account_image', $name4);

                        $checkIn->checkinaf4 = $name4;


                    }
                    $checkIn->checkinaf1 = $request->second_guest_name;
                    $checkIn->checkinaf3 = $request->third_guest_name;
                    $checkIn->checkinaf5 = $request->second_guest_id_name;
                    $checkIn->checkinaf6 = $request->second_guest_id_no;
                    $checkIn->checkinaf7 = $request->third_guest_id_name;
                    $checkIn->checkinaf8 = $request->third_guest_id_no;
                    $checkIn->checkinaf9 = $request->checkout_date;
                    $checkIn->checkinaf10 = $request->checkout_time;



                    $checkIn->userid = Auth::user()->id;
                    $checkIn->username = Auth::user()->name;

                    //  $checkIn->checkin_room_id=$request->checkin_room_id;


                    $checkIn->save();

                    $booking_voucher_no = $request->booking_voucher_no;

                    if ($booking_voucher_no > 0) {
                        $roombooking_update = roombooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                            ->where('voucher_no', $request->booking_voucher_no)->update(['checkin_voucher_no' => $request->voucher_no]);

                    }
                    room::where('firm_id', Auth::user()->firm_id)->where('id', $checkin_room_id)->update(['room_status' => 'occupied']);

                }

            } else {
                $this->create_account($request);
                $this->store($request);
            }






            //retuern to dashboard 
            $currentDate = Carbon::now()->toDateString();

            // Fetch booked room IDs where the current date is between checkin_date and checkout_date
            $bookedRoomIds = roombooking::withinFY('checkin_date')->where('checkin_date', '<=', $currentDate)
                ->where('checkout_date', '>=', $currentDate)
                ->where('checkin_voucher_no', '0')
                ->where('firm_id', Auth::user()->firm_id)
                ->pluck('room_id')
                ->toArray();

            // Fetch all rooms with their room types
            $rooms = Room::with('roomtype')
                ->where('firm_id', Auth::user()->firm_id)
                ->get();
            //posting amount to ledger 
            $roomcheckinsData = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', '0')
                ->where('firm_id', Auth::user()->firm_id)
                ->get();

            $vacantroom = room::where('firm_id', Auth::user()->firm_id)->where("room_status", 'vacant')
                ->count();
            $occupiedroom = room::where('firm_id', Auth::user()->firm_id)->where("room_status", 'occupied')
                ->count();
            $dirtyroom = room::where('firm_id', Auth::user()->firm_id)->where("room_status", 'dirty')
                ->count();


            $method_type = "Check_in_store";
            $voucher_no = $request->voucher_no;
            $this->sendCheckinWhatsapp($method_type, $voucher_no);


            return view('entery.room.room_dashboard', ['data' => $rooms, 'bookedRoomIds' => $bookedRoomIds, 'roomcheckinsData' => $roomcheckinsData, 'vacantroom' => $vacantroom, 'occupiedroom' => $occupiedroom, 'dirtyroom' => $dirtyroom]);



        } else {
            return back()->withInput()->withErrors($validator);
        }





    }

    public function update_account(Request $request)
    {
        $account = account::where('firm_id', Auth::user()->firm_id)->find($request->account_id);
        $account->account_name = $request->guest_name;
        $account->address = $request->guest_address;
        $account->address2 = $request->guest_address2;
        $account->city = $request->guest_city;
        $account->state = $request->guest_state;
        $account->phone = $request->guest_phone;
        $account->mobile = $request->guest_mobile;

        $account->gst_no = $request->gst_no;

        if (!empty($request->gst_no)) {
            // Extract first 2 characters from GST number
            $account->gst_code = substr($request->gst_no, 0, 2);
        }


        $account->email = $request->guest_email;
        $account->account_af1 = $request->firm_name;  //guest firm name 
        $account->account_af2 = $request->firm_address; // guest firm address
        $account->account_af3 = $request->account_af3; //for root account 
        $account->nationality = $request->guest_nationality;



        $account->update();

    }

    public function update(Request $request)
    {


        $validator = validator::make($request->all(), [
            // 'token' => $request->input('token', Str::uuid()),
            'check_in_no' => 'required|string',
            'voucher_no' => 'required|string',
            'checkin_date' => 'required|date',
            'checkin_time' => 'required',
            'guest_name' => 'required|string',
            'guest_mobile' => 'required|string',
            'business_source_id' => 'required|string',
            'package_id' => 'required|string'


        ]);
        if ($validator->passes()) {
            $checkindata = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $request->voucher_no)->get();

            foreach ($checkindata as $record) {
                room::where('firm_id', Auth::user()->firm_id)->where('id', $record->room_id)->update(['room_status' => 'dirty']);
                $record->delete();

            }


            $ledger = ledger::withinFY('entry_date')->where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $request->voucher_no);
            if ($ledger) {

                // $ledger->delete();
            }



            $guest_mobile = $request->guest_mobile;
            $find_account = account::where('firm_id', Auth::user()->firm_id)
                ->where('mobile', $guest_mobile)
                ->first();

            if ($find_account) {
                $find_account->gst_no = $request->gst_no;

                if (!empty($request->gst_no) && strlen($request->gst_no) >= 2) {
                    $find_account->gst_code = substr($request->gst_no, 0, 2);
                } else {
                    $find_account->gst_code = null; // Optional: reset if GST is not valid
                }

                $find_account->save(); // ✅ This updates the existing record
            }

            if ($find_account !== NULL) {
                $this->post_amount($request);
                $account_id = $find_account->id;

                $date_variable = $request->checkin_date;
                $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
                $formatted_checkin_date = $parsed_date->format('Y-m-d');
                $validatedData['checkin_date'] = $formatted_checkin_date;

                $fy_start_date = $this->fy_start_date;
                $fy_end_date = $this->fy_end_date;
                $financialyeardata = $this->financialyeardata;
                if (
                    $financialyeardata &&
                    $formatted_checkin_date < $fy_start_date ||
                    $formatted_checkin_date > $fy_end_date
                ) {

return view('error.checkdate_on_fy',compact('fy_start_date','fy_end_date'));

                }


                $checkin_room_ids = $request->checkin_room_id;

                foreach ($checkin_room_ids as $checkin_room_id) {
                    $checkIn = new roomcheckin;
                    $checkIn->firm_id = Auth::user()->firm_id;


                    $roomdetails = room::where('firm_id', Auth::user()->firm_id)
                        ->where('id', $checkin_room_id)->first();
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
                    // $checkIn->posting_acc_id = $request->posting_acc_id;

                    $checkIn->voucher_payment_ref = $request->voucher_payment_ref;
                    $checkIn->voucher_payment_remark = $request->voucher_payment_remark;
                    $checkIn->checkin_advance = $request->total_receipt_amt;

                    $checkIn->agent = $request->agent;


                    $checkIn->check_in_no = $request->check_in_no;
                    $checkIn->voucher_no = $request->voucher_no;
                    $checkIn->checkin_date = $formatted_checkin_date;
                    $checkIn->checkin_time = $request->checkin_time;
                    $checkIn->room_tariff_perday = $request->room_tariff_perday;
                    $checkIn->booking_voucher_no = $request->booking_voucher_no;
                    $checkIn->userid = Auth::user()->id;
                    $checkIn->username = Auth::user()->name;

                    //  $checkIn->checkin_room_id=$request->checkin_room_id;


                    $checkIn->save();

                    $booking_voucher_no = $request->booking_voucher_no;

                    if ($booking_voucher_no > 0) {
                        $roombooking_update = roombooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                            ->where('voucher_no', $request->booking_voucher_no)->update(['checkin_voucher_no' => $request->voucher_no]);

                    }
                    room::where('firm_id', Auth::user()->firm_id)->where('id', $checkin_room_id)->update(['room_status' => 'occupied']);

                }

            } else {
                $this->create_account($request);
                $this->store($request);
            }






            //retuern to dashboard 
            $currentDate = Carbon::now()->toDateString();

            // Fetch booked room IDs where the current date is between checkin_date and checkout_date
            $bookedRoomIds = roombooking::withinFY('checkin_date')->where('checkin_date', '<=', $currentDate)
                ->where('checkout_date', '>=', $currentDate)
                ->where('checkin_voucher_no', '0')
                ->where('firm_id', Auth::user()->firm_id)
                ->pluck('room_id')
                ->toArray();

            // Fetch all rooms with their room types
            $rooms = Room::with('roomtype')
                ->where('firm_id', Auth::user()->firm_id)
                ->get();
            //posting amount to ledger 
            $roomcheckinsData = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', '0')
                ->where('firm_id', Auth::user()->firm_id)
                ->get();

            $vacantroom = room::where('firm_id', Auth::user()->firm_id)->where("room_status", 'vacant')
                ->count();
            $occupiedroom = room::where('firm_id', Auth::user()->firm_id)->where("room_status", 'occupied')
                ->count();
            $dirtyroom = room::where('firm_id', Auth::user()->firm_id)->where("room_status", 'dirty')
                ->count();
            $method_type = "Check_in_update";
            $voucher_no = $request->voucher_no;
            $this->sendCheckinWhatsapp($method_type, $voucher_no);

            // $this->update_account($request);



            return view('entery.room.room_dashboard', ['data' => $rooms, 'bookedRoomIds' => $bookedRoomIds, 'roomcheckinsData' => $roomcheckinsData, 'vacantroom' => $vacantroom, 'occupiedroom' => $occupiedroom, 'dirtyroom' => $dirtyroom]);



        } else {
            return back()->withInput()->withErrors($validator);
        }





    }






    public function show_roombooking(Request $request)
    {
        $id = $request->roombooking_id;
        $rooms = room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->where('firm_id', Auth::user()->firm_id)
            ->get();

        $roombooking = roombooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('id', $id) // Add condition to match the ID
            ->first(); // Retrieve the first matching record

        return view('entery.room.checkin.room_checkin_selected_booking', compact('rooms', 'roombookings'));

    }
    public function show(Request $request, $id)
    {   //this is function for show all detail when we select anychecin in checkout voucher  using ajex 
        if ($request->ajax()) {
            \Log::info('AJAX request received');
        }
        $roomcheckins = roomcheckin::withinFY('checkin_date')->where('voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();


        if ($roomcheckins) {
            return response()->json($roomcheckins->toArray());
        } else {
            return response()->json([]);
        }
    }








    public function destroy(string $id)
    {
        $method_type = "Check_in_delete";
        $voucher_no = $id;
        $this->sendCheckinWhatsapp($method_type, $voucher_no);

        // Find all room check-in records with the given voucher_no $id is voucehr no 
        roombooking::withinFY('checkin_date')->where('checkin_voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->update(['checkin_voucher_no' => '0']);
        $roomcheckins = roomcheckin::withinFY('checkin_date')->where('voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('checkout_voucher_no', '0')
            ->get();
        //   $invntory=$foodbill = foodbill::withinFY('voucher_date')->where('service_id', $id)->first();
        // $foodbill_voucher_no=$invntory->voucer_no;
        // $inventory=inventory::where('voucher_type', 'Foodbill')->where('voucher_no',$foodbill_voucher_no);
        // dd($inventory);


        if ($roomcheckins->isEmpty()) {
            return redirect('/roomcheckins')->with('message', 'No room check-ins found for the provided voucher number');
        }

        // Loop through each room check-in record
        foreach ($roomcheckins as $roomcheckin) {
            // Retrieve the room associated with the room check-in
            $room = Room::where('firm_id', Auth::user()->firm_id)
                ->where('id', $roomcheckin->room_id) // Match the room_id
                ->first(); // Retrieve the first matching record


            if ($room) {
                // Update the room status to "vacant"
                $room->room_status = 'vacant';
                $room->save();
            }



            // Delete the room check-in record
            $roomcheckin->delete();
            $foodbill = foodbill::withinFY('voucher_date')->where('service_id', $id)
                ->where('firm_id', Auth::user()->firm_id);

            if ($foodbill) {
                // Update the room status to "vacant"

                $foodbill->delete();
            }
            $kot = kot::withinFY('voucher_date')->where('service_id', $id)
                ->where('firm_id', Auth::user()->firm_id);
            if ($kot) {
                // Update the room status to "vacant"

                $kot->delete();
            }

            $ledger = ledger::withinFY('entry_date')->where('transaction_type', 'Check_In')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $id);
            if ($ledger) {
                // Update the room status to "vacant"

                $ledger->delete();
            }


        }

        return redirect('/roomcheckins')->with('message', 'All matching room check-ins deleted successfully!');
    }

    public function roomcheckin_view(string $id)
    {
        $roomcheckins = roomcheckin::withinFY('checkin_date')->where('voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();

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

        $roombooking = roombooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('id', $id) // Add condition to match the ID
            ->first(); // Retrieve the first matching record



        if ($roombooking) {
            return response()->json($roombooking->toArray());
        } else {
            return response()->json([]);
        }
    }


    public function edit(string $voucher_no)
    {
        $roomcheckins = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->where('checkout_voucher_no', '0')
            ->get();

        $romcheckins_first = roomcheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->where('checkout_voucher_no', '0')
            ->first();




        $roombookings = [];
        $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
            ->whereHas('accountGroup', function ($query) {
                $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
            })
            ->get();



        $businesssource = businesssource::where('firm_id', Auth::user()->firm_id)->get();
        $package = package::where('firm_id', Auth::user()->firm_id)->get();
        $othercharges = othercharge::where('firm_id', Auth::user()->firm_id)->get();



        $rooms_data = Room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->where('room_status', 'vacant')
            ->where('firm_id', Auth::user()->firm_id)
            ->get();

        // Fetch room check-ins based on criteria
        $roomCheckins = RoomCheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->where('checkout_voucher_no', '0')
            ->get();

        // Get room numbers from room check-ins
        $checkinRoomNumbers = $roomCheckins->pluck('room_no')->unique();

        // Fetch rooms associated with check-ins
        $checkinRooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->whereIn('room_no', $checkinRoomNumbers)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();

        // Combine vacant rooms and rooms from check-ins
        $rooms = $rooms_data->merge($checkinRooms)->unique('room_no');



        $new_bill_no = $romcheckins_first->check_in_no;
        $new_voucher_no = $romcheckins_first->voucher_no;



        return view('entery.room.checkin.room_checkin_edit', compact('rooms', 'roombookings', 'businesssource', 'package', 'new_bill_no', 'new_voucher_no', 'othercharges', 'paymentmodes', 'romcheckins_first', 'roomcheckins', 'roomCheckins'));






    }



    public function show_room_with_package(Request $request)
    {

        $package_id = $request->package_id;
        $package = package::where('firm_id', Auth::user()->firm_id)->where('id', $package_id)->first();
        $package_charge = $package->other_name;   //this is package charge 


        // Parse check-in date

        // Fetch rooms that are available for booking
        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->where('firm_id', Auth::user()->firm_id)
            ->where('room_status', 'vacant')

            ->get();

        // Return JSON response for testing
        return response()->json([
            'message' => 'We received the data successfully',
            'rooms' => $rooms,
            'package_charge' => $package_charge,
            'status' => 200, // Uncomment this line to see room data in the response
        ], 200);
    }


public function sendCheckinWhatsapp($method_type, $voucher_no)
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
    $wp_record = Roomcheckin::withinFY('checkin_date')
        ->where('firm_id', $firmId)
        ->where('voucher_no', $voucher_no)
        ->first();

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
        '{room_no}' => $wp_record->room_no,
        '{voucher_no}' => $wp_record->voucher_no,
        '{checkout_date}' => date('d-m-Y', strtotime($wp_record->checkout_date)),
        '{total_billamount}' => $wp_record->total_billamount,
        '{room_tariff_perday}' => $wp_record->room_tariff_perday,
        '{guest_name}' => $wp_record->guest_name,
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
    if ($method_type !== 'Check_in_delete' && !empty($wp_record->guest_mobile)) {
        $numbers[] = preg_replace('/\D/', '', trim($wp_record->guest_mobile));
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



