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
use App\Models\othercharge;
use App\Models\roombooking;
use App\Models\accountgroup;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\businesssource;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
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

        $rooms = Room::where('firm_id', Auth::user()->firm_id)
            ->with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.room_booking', compact('rooms'));

    }
    public function register()
    {
        // $roombooking = roombooking::where('checkin_voucher_no','0')->get();
        $roombooking = DB::table('roombookings')

            ->select('firm_id', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'), 'booking_no', 'guest_name', 'guest_mobile', 'booking_date', 'checkin_date', 'checkout_date', 'bookingaf1', 'bookingaf2', 'bookingaf3', 'checkin_time', 'booking_time', 'checkout_time')
            ->where('checkin_voucher_no', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->groupBy('firm_id', 'voucher_no', 'booking_no', 'guest_name', 'guest_mobile', 'booking_date', 'checkin_date', 'checkout_date', 'bookingaf1', 'bookingaf2', 'bookingaf3', 'checkin_time', 'booking_time', 'checkout_time')
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->get();
        // dd($roombookings);
        return view('entery.room.room_booking_register', compact('roombooking'));

    }

    public function create()
    {
        //    $document_name=optionlist::where('option_type','document_name')->get();
        //    $agent_name=optionlist::where('option_type','agent_name')->get();
        //     $state=optionlist::where('option_type','state')->get();
        //     $country=optionlist::where('option_type','country')->get();
        //     $nationality=optionlist::where('option_type','nationality')->get();
        //     'document_name','agent_name','state','country','nationality',

        $businesssource = businesssource::where('firm_id', Auth::user()->firm_id)->get();
        $package = package::where('firm_id', Auth::user()->firm_id)->get();
        $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
            ->whereHas('accountGroup', function ($query) {
                $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
            })
            ->get();

        $roombooking_record = roombooking::where('firm_id', Auth::user()->firm_id)->count();
        if ($roombooking_record > 0) {
            $lastRecord = roombooking::where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();

            // $lastRecord = roombooking::orderBy('voucher_no', 'desc')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Room_booking')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)->where('voucher_type_name', 'Room_booking')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }



        $rooms = Room::where('firm_id', Auth::user()->firm_id)->with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.room_booking', compact('rooms', 'businesssource', 'package', 'new_bill_no', 'new_voucher_no', 'paymentmodes'));

    }


    //this is old function 
    // public function show_rooms_available_for_booking(Request $request)
    // {
    //     $checkinDate = $request->checkin_date;
    //     $checkoutDate = $request->checkout_date;
    //     $checkin_time=$request->checkin_time;
    //     $checkout_time=$request->checkout_time;
    //     $package_id=$request->package_id;
    //     $package=package::where('firm_id', Auth::user()->firm_id)->where('id',$package_id)->first();
    //     $package_charge=$package->other_name;   //this is package charge 


    //     // Parse check-in date
    //     $parsed_checkinDate = Carbon::createFromFormat('d-m-Y', $checkinDate);
    //     $formatted_checkinDate = $parsed_checkinDate->format('Y-m-d');

    //     // Parse check-out date
    //     $parsed_checkoutDate = Carbon::createFromFormat('d-m-Y', $checkoutDate);
    //     $formatted_checkoutDate = $parsed_checkoutDate->format('Y-m-d');


    //     $checkinDate = Carbon::createFromFormat('d-m-Y', $checkinDate)->format('Y-m-d');
    //     $checkoutDate = Carbon::createFromFormat('d-m-Y', $checkoutDate)->format('Y-m-d');

    //     $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])
    //     ->leftJoin('roombookings', function ($join) use ($checkinDate, $checkoutDate, $checkin_time, $checkout_time) {
    //         $join->on('rooms.id', '=', 'roombookings.room_id')
    //             ->where(function ($query) use ($checkinDate, $checkoutDate, $checkin_time, $checkout_time) {
    //                 $query->where(function ($q) use ($checkinDate, $checkoutDate) {
    //                     // Check for date overlaps
    //                     $q->whereBetween('roombookings.checkin_date', [$checkinDate, $checkoutDate])
    //                       ->orWhereBetween('roombookings.checkout_date', [$checkinDate, $checkoutDate])
    //                       ->orWhere(function ($q2) use ($checkinDate, $checkoutDate) {
    //                           $q2->where('roombookings.checkin_date', '<=', $checkinDate)
    //                              ->where('roombookings.checkout_date', '>=', $checkoutDate);
    //                       });
    //                 })->orWhere(function ($q) use ($checkinDate, $checkin_time) {
    //                     // Exclude rooms where the checkout overlaps the desired check-in
    //                     $q->where('roombookings.checkout_date', '=', $checkinDate)
    //                       ->where(function ($q2) use ($checkin_time) {
    //                           $q2->where('roombookings.checkout_time', '>=', $checkin_time)
    //                              ->orWhere('roombookings.checkout_time', '>', $checkin_time); // Adjust logic to exclude overlapping bookings
    //                       });
    //                 })->orWhere(function ($q) use ($checkoutDate, $checkout_time) {
    //                     // Exclude rooms where the check-in overlaps the desired check-out
    //                     $q->where('roombookings.checkin_date', '=', $checkoutDate)
    //                       ->where('roombookings.checkin_time', '<=', $checkout_time);
    //                 });
    //             });
    //     })
    //     ->whereNull('roombookings.room_id')  // Only rooms not booked
    //     ->where('rooms.firm_id', Auth::user()->firm_id)
    //     ->select('rooms.*')  // Select room fields
    //     ->get();






    //     // Return JSON response for testing
    //     return response()->json([
    //         'message' => 'We received the data successfully',
    //         'checkinDate' => $checkinDate,
    //         'checkoutDate' => $checkoutDate,
    //         'checkin_time'=>$checkin_time,
    //         'checkout_time'=>$checkout_time,
    //         'formatted_checkinDate' => $formatted_checkinDate,
    //         'formatted_checkoutDate' => $formatted_checkoutDate,
    //         'rooms' => $rooms,
    //         'package_charge'=>$package_charge,
    //         'status' => 200, // Uncomment this line to see room data in the response
    //     ], 200);
    // }







    // public function booking_by_guest_create($firm_id)
    // {
    //     //requierd setup


    //     $businesssource = businesssource::where('firm_id', $firm_id)->get();
    //     $package = package::where('firm_id', $firm_id)->get();
    //     $paymentmodes = account::where('firm_id', $firm_id)
    //         ->whereHas('accountGroup', function ($query) {
    //             $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
    //         })
    //         ->get();

    //     $roombooking_record = roombooking::where('firm_id', $firm_id)->count();
    //     if ($roombooking_record > 0) {
    //         $lastRecord = roombooking::where('firm_id', $firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
    //         $voucher_no = $lastRecord->voucher_no;
    //         $new_voucher_no = $voucher_no + 1;
    //         $voucher_type = voucher_type::where('firm_id', $firm_id)->where('voucher_type_name', 'Room_booking')->first();
    //         $voucher_prefix = $voucher_type->voucher_prefix;
    //         $voucher_suffix = $voucher_type->voucher_suffix;
    //         $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

    //     } else {
    //         $voucher_type = voucher_type::where('firm_id', $firm_id)->where('voucher_type_name', 'Room_booking')->first();

    //         $voucher_no = $voucher_type->numbring_start_from;
    //         $new_voucher_no = $voucher_no + 1;
    //         $voucher_prefix = $voucher_type->voucher_prefix;
    //         $voucher_suffix = $voucher_type->voucher_suffix;
    //         $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

    //     }



    //     $rooms = room::with(['roomtype.gstmaster', 'roomtype.package'])
    //         ->where('room_status', 'vacant')
    //         ->where('firm_id', $firm_id)->get();

    //     return view('entery.room.room_booking_by_guest', compact('rooms', 'businesssource', 'package', 'new_bill_no', 'new_voucher_no', 'paymentmodes', 'firm_id'));

    // }


    public function show_rooms_available_for_booking(Request $request)
    {
        $checkinDate = $request->checkin_date;
        $checkoutDate = $request->checkout_date;
        $checkinTime = $request->checkin_time;
        $checkoutTime = $request->checkout_time;
        $packageId = $request->package_id;

        // Fetch package details
        $package = Package::where('firm_id', Auth::user()->firm_id)
            ->where('id', $packageId)
            ->first();
        $packageCharge = $package ? $package->other_name : null; // Ensure package is not null

        // Format check-in and check-out datetime
        $formattedCheckinDateTime = Carbon::createFromFormat('d-m-Y H:i', "$checkinDate $checkinTime")->format('Y-m-d H:i:s');
        $formattedCheckoutDateTime = Carbon::createFromFormat('d-m-Y H:i', "$checkoutDate $checkoutTime")->format('Y-m-d H:i:s');

        // Fetch rooms available for booking
        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->leftJoin('roombookings', function ($join) use ($formattedCheckinDateTime, $formattedCheckoutDateTime) {
                $join->on('rooms.id', '=', 'roombookings.room_id')
                    ->where(function ($query) use ($formattedCheckinDateTime, $formattedCheckoutDateTime) {
                        $query->where(function ($subQuery) use ($formattedCheckinDateTime, $formattedCheckoutDateTime) {
                            $subQuery->whereRaw(
                                "? < CONCAT(roombookings.checkout_date, ' ', COALESCE(roombookings.checkout_time, '00:00:00')) AND ? > CONCAT(roombookings.checkin_date, ' ', COALESCE(roombookings.checkin_time, '00:00:00'))",
                                [$formattedCheckinDateTime, $formattedCheckoutDateTime]
                            );
                        });
                    });
            })
            ->whereNull('roombookings.room_id') // Exclude rooms with bookings
            ->where('rooms.firm_id', Auth::user()->firm_id)
            ->select('rooms.*')
            ->get();


        // Return JSON response
        return response()->json([
            'message' => 'We received the data successfully',
            'checkin_datetime' => $formattedCheckinDateTime,
            'checkout_datetime' => $formattedCheckoutDateTime,
            'rooms' => $rooms,
            'package_charge' => $packageCharge,
            'status' => 200,
        ], 200);
    }
    public function show_rooms_available_for_booking_by_guest(Request $request)
    {
        $checkinDate = $request->checkin_date;
        $checkoutDate = $request->checkout_date;
        $firm_id = $request->firm_id;

        // Parse check-in date
        $parsed_checkinDate = Carbon::createFromFormat('d-m-Y', $checkinDate);
        $formatted_checkinDate = $parsed_checkinDate->format('Y-m-d');

        // Parse check-out date
        $parsed_checkoutDate = Carbon::createFromFormat('d-m-Y', $checkoutDate);
        $formatted_checkoutDate = $parsed_checkoutDate->format('Y-m-d');

        // Fetch rooms that are available for booking
        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->leftJoin('roombookings', function ($join) use ($formatted_checkinDate, $formatted_checkoutDate) {
                $join->on('rooms.id', '=', 'roombookings.room_id')
                    ->where(function ($query) {
                        $query->where('roombookings.checkin_voucher_no', '=', 0)
                            ->orWhere('roombookings.checkin_voucher_no', '=', 'book_by_guest');
                    })
                    ->where(function ($query) use ($formatted_checkinDate, $formatted_checkoutDate) {
                        $query->whereBetween('roombookings.checkin_date', [$formatted_checkinDate, $formatted_checkoutDate])
                            ->orWhereBetween('roombookings.checkout_date', [$formatted_checkinDate, $formatted_checkoutDate])
                            ->orWhere(function ($query) use ($formatted_checkinDate, $formatted_checkoutDate) {
                                $query->where('roombookings.checkin_date', '<=', $formatted_checkinDate)
                                    ->where('roombookings.checkout_date', '>=', $formatted_checkoutDate);
                            });
                    });
            })
            ->whereNull('roombookings.room_id')  // Only rooms not booked
            ->where('rooms.firm_id', $firm_id)
            ->select('rooms.*')  // Select room fields

            ->get();

        // Return JSON response for testing
        return response()->json([
            'message' => 'We received the data successfully',
            'checkinDate' => $checkinDate,
            'checkoutDate' => $checkoutDate,
            'formatted_checkinDate' => $formatted_checkinDate,
            'formatted_checkoutDate' => $formatted_checkoutDate,
            'rooms' => $rooms,
            'status' => 200, // Uncomment this line to see room data in the response
        ], 200);
    }



    public function home()
    {
        // $roombooking = roombooking::where('checkin_voucher_no','0')->get();
        $roombooking = DB::table('roombookings')
            ->select(
                'voucher_no',
                DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'),
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date',
                'checkin_time',
                'checkout_time',
                'no_of_guest',
                'commited_days',
                'room_tariff_perday',
                'booking_amount'
            )
            ->where('checkin_voucher_no', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->groupBy('voucher_no', 'booking_no', 'guest_name', 'guest_mobile', 'booking_date', 'checkin_date', 'checkout_date', 'checkin_time', 'checkout_time', 'no_of_guest', 'commited_days', 'room_tariff_perday', 'booking_amount')

            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->get();
        // dd($roombookings);
        return view('entery.room.room_booking_home', compact('roombooking'));
    }
    public function clear_booking()
    {
        $roombooking = roombooking::where('firm_id', Auth::user()->firm_id)->get();
        return view('entery.room.room_booking_home', compact('roombooking'));
    }

    public function pending_booking()
    {
        // $roombooking = roombooking::where('checkin_voucher_no', 'book_by_guest')->where('firm_id', Auth::user()->firm_id)->get();
        $roombooking = DB::table('roombookings')
            ->select('firm_id', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'), 'booking_no', 'guest_name', 'guest_mobile', 'booking_date', 'checkin_date', 'checkout_date')
            ->where('checkin_voucher_no', 'book_by_guest')
            ->where('firm_id', Auth::user()->firm_id)
            ->groupBy('firm_id', 'voucher_no', 'booking_no', 'guest_name', 'guest_mobile', 'booking_date', 'checkin_date', 'checkout_date')
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->get();

        return view('entery.room.room_booking_pending', compact('roombooking'));
    }



    public function post_amount(Request $request)
    {
        $posting_acc_ids = $request->posting_acc_id;  // Array of account IDs
        $booking_amounts = $request->booking_amount;  // Array of amounts

        // Check if the arrays are set and contain values
        if (is_array($posting_acc_ids) && is_array($booking_amounts) && count($posting_acc_ids) > 0 && count($booking_amounts) > 0) {

            $date_variable = $request->booking_date;
            $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_entry_date = $parsed_date->format('Y-m-d');

            // Get the account name details using the guest's mobile number
            $accountname = account::with('accountgroup')
                ->where('mobile', $request->guest_mobile)->first();

            // Loop through each payment mode and amount
            foreach ($posting_acc_ids as $index => $posting_acc_id) {
                $booking_amount = $booking_amounts[$index];

                // Ensure the payment mode and amount are valid
                if ($posting_acc_id > 0 && $booking_amount > 0) {

                    // Get the payment mode details by ID
                    $paymentmode = account::with('accountgroup')
                        ->where('id', $posting_acc_id)->first();

                    // Credit ledger entry
                    $ledger = new ledger;
                    $ledger->firm_id = Auth::user()->firm_id;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->booking_no;
                    $ledger->entry_date = $formatted_entry_date;
                    $ledger->transaction_type = 'Room_booking';
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
                    $ledger->remark = "Room_booking/" . $request->booking_no;
                    $ledger->tran_voucher_no = $request->voucher_no;
                    $ledger->simpal_amount = "-" . $booking_amount;
                    $ledger->userid = Auth::user()->id;
                    $ledger->username = Auth::user()->name;
                    $ledger->save();

                    // Debit ledger entry
                    $ledger = new ledger;
                    $ledger->firm_id = Auth::user()->firm_id;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->booking_no;
                    $ledger->entry_date = $formatted_entry_date;
                    $ledger->transaction_type = 'Room_booking';
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
                    $ledger->remark = "Room_booking/" . $request->booking_no;
                    $ledger->tran_voucher_no = $request->voucher_no;
                    $ledger->simpal_amount = "+" . $booking_amount;
                    $ledger->userid = Auth::user()->id;
                    $ledger->username = Auth::user()->name;
                    $ledger->save();
                }
            }
        }
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


        $customer = Account::where('firm_id', Auth::user()->firm_id)->Where('mobile', $request->guest_mobile)
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
            $account->address = $request->guest_address2;
            $account->account_idproof_name = $request->guest_idproof;
            $account->account_idproof_no = $request->guest_idproof_no;
            $account->account_id_pic = $name;
            $account->account_pic1 = $name2;
            $account->email = $request->guest_email;
            $account->nationality = $request->guest_contery;
            $account->pincode = $request->guest_pincode;
            $account->save();
        }

    }


    public function create_account_by_guest(Request $request)
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


        $customer = Account::where('firm_id', $request->firm_id)->Where('mobile', $request->guest_mobile)
            ->first();

        $gust_customer_account_search = Account::where('firm_id', $request->firm_id)->
            Where('account_name', 'Guest Customer')
            ->first();
        $accountgroup_id = $gust_customer_account_search->account_group_id;

        if ($customer == null) {


            $account = new account;
            $account->firm_id = $request->firm_id;
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
            $account->address = $request->guest_address2;
            $account->account_idproof_name = $request->guest_idproof;
            $account->account_idproof_no = $request->guest_idproof_no;
            $account->account_id_pic = $name;
            $account->account_pic1 = $name2;
            $account->email = $request->guest_email;
            $account->nationality = $request->guest_contery;
            $account->pincode = $request->guest_pincode;
            $account->save();
        }

    }

    public function store(Request $request)
    {

        $existingRecords = roombooking::where('voucher_no', $request->voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->count();

        if ($existingRecords >= 1) {
            return response()->json(['error' => 'Records already exist for this transaction type and voucher number and Please Dont Reloade and resubmit Same Entry .'], 400);
        }

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
        $posting_acc_ids = $request->posting_acc_id;  // Array of account IDs
        $booking_amounts = $request->booking_amount;  // Array of amounts

        $customer = Account::Where('mobile', $request->guest_mobile)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();
        if ($customer == null) {
            $this->create_account($request);
        }

        $date_variable = $request->booking_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_booking_date = $parsed_date->format('Y-m-d');
        $validatedData['booking_date'] = $formatted_booking_date;

        $date_variable = $request->checkin_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_checkin_date = $parsed_date->format('Y-m-d');
        $validatedData['checkin_date'] = $formatted_checkin_date;

        $date_variable = $request->checkout_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_checkout_date = $parsed_date->format('Y-m-d');
        $validatedData['checkout_date'] = $formatted_checkout_date;
        if ($request->hasFile('guest_id_pic')) {
            $image1 = $request->guest_id_pic;
            $name = $image1->getClientOriginalName();
            $image1->storeAS('public\account_image', $name);

        } else {
            $name = NULL;
        }
        if ($request->hasFile('guest_pic')) {
            $image2 = $request->guest_pic;
            $name2 = $image2->getClientOriginalName();
            $image2->storeAS('public\account_image', $name2);
        } else {
            $name2 = NULL;
        }



        $booking_room_ids = $request->booking_room_id;

        foreach ($booking_room_ids as $booking_room_id) {
            $roombooking = new roombooking;
            $roombooking->firm_id = Auth::user()->firm_id;

            $roomdetails = room::where('id', $booking_room_id)->first();
            $roombooking->room_id = $booking_room_id;
            $roombooking->room_no = $roomdetails->room_no;
            $roombooking->guest_name = $request->guest_name;
            $roombooking->guest_mobile = $request->guest_mobile;
            $roombooking->booking_no = $request->booking_no;
            $roombooking->voucher_no = $request->voucher_no;
            $roombooking->booking_date = $formatted_booking_date;
            $roombooking->booking_time = $request->booking_time;
            $roombooking->checkin_date = $formatted_checkin_date;
            $roombooking->checkin_time = $request->checkin_time;
            $roombooking->checkout_date = $formatted_checkout_date;
            $roombooking->checkout_time = $request->checkout_time;
            $roombooking->no_of_guest = $request->no_of_guest;
            $roombooking->commited_days = $request->commited_days;
            $roombooking->business_source_id = $request->business_source_id;
            $roombooking->package_id = $request->package_id;
            $roombooking->gst_no = $request->gst_no;
            $roombooking->firm_address = $request->firm_address;
            $roombooking->firm_name = $request->firm_name;
            $roombooking->guest_idproof_no = $request->guest_idproof_no;
            $roombooking->guest_idproof = $request->guest_idproof;
            $roombooking->agent = $request->agent;
            $roombooking->guest_phone = $request->guest_phone;
            $roombooking->guest_nationality = $request->guest_nationality;
            $roombooking->guest_pincode = $request->guest_pincode;
            $roombooking->guest_contery = $request->guest_contery;
            $roombooking->guest_state = $request->guest_state;
            $roombooking->guest_address = $request->guest_address;
            $roombooking->guest_address2 = $request->guest_address2;
            $roombooking->guest_city = $request->guest_city;
            $roombooking->guest_email = $request->guest_email;
            $roombooking->voucher_payment_remark = $request->voucher_payment_remark;
            $roombooking->refrance_no = $request->voucher_payment_ref;
            $roombooking->booking_amount = $request->total_receipt_amt;


            //  $roombooking->posting_acc_id=$request->posting_acc_id;
            $roombooking->room_tariff_perday = $request->room_tariff_perday;
            $roombooking->guest_id_pic = $name;
            $roombooking->guest_pic = $name2;

            $roombooking->bookingaf1 = $request->vehicle_no;
            $roombooking->bookingaf2 = $request->parking_no;
            $roombooking->bookingaf3 = $request->booking_remark;
            $roombooking->save();

        }
        $this->post_amount($request);
        $voucher_no = $request->voucher_no;
        $roombooking = roombooking::where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();

        $roomnos = DB::table('roombookings')
            ->select(
                'firm_id',
                'voucher_no',
                DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'),
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date'
            )
            ->where('checkin_voucher_no', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->groupBy(
                'firm_id',
                'voucher_no',
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date'
            )
            ->get();

        $roombookingdata = roombooking::where('voucher_no', $request->voucher_no)
            ->where('checkin_voucher_no', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->get();
        $totalroom = $roombookingdata->count();

        $checkinDate = Carbon::parse($roombooking->checkin_date);
        $checkoutDate = Carbon::parse($roombooking->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);

        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.room_booking_view', compact('roombooking', 'totaldays', 'roomnos', 'totalroom', 'roombookingdata'));


    }

    public function store_by_guest_booking(Request $request)
    {
        // dd($request);

        $firm_id = $request->firm_id;


        $existingRecords = roombooking::where('voucher_no', $request->voucher_no)
            ->where('firm_id', $firm_id)
            ->count();

        if ($existingRecords >= 1) {
            return response()->json(['error' => 'Records already exist for this transaction type and voucher number and Please Dont Reloade and resubmit Same Entry .'], 400);
        }

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
            ->where('firm_id', $firm_id)
            ->first();
        if ($customer == null) {
            $this->create_account_by_guest($request);
        }

        $date_variable = $request->booking_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_booking_date = $parsed_date->format('Y-m-d');
        $validatedData['booking_date'] = $formatted_booking_date;

        $date_variable = $request->checkin_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_checkin_date = $parsed_date->format('Y-m-d');
        $validatedData['checkin_date'] = $formatted_checkin_date;

        $date_variable = $request->checkout_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_checkout_date = $parsed_date->format('Y-m-d');
        $validatedData['checkout_date'] = $formatted_checkout_date;
        if ($request->hasFile('guest_id_pic')) {
            $image1 = $request->guest_id_pic;
            $name = $image1->getClientOriginalName();
            $image1->storeAS('public\account_image', $name);

        } else {
            $name = NULL;
        }
        if ($request->hasFile('guest_pic')) {
            $image2 = $request->guest_pic;
            $name2 = $image2->getClientOriginalName();
            $image2->storeAS('public\account_image', $name2);
        } else {
            $name2 = NULL;
        }



        $booking_room_ids = $request->booking_room_id;


        foreach ($booking_room_ids as $booking_room_id) {
            $roombooking = new roombooking;


            $roomdetails = room::where('id', $booking_room_id)->first();
            $roombooking->firm_id = $firm_id;
            $roombooking->room_id = $booking_room_id;
            $roombooking->room_no = $roomdetails->room_no;
            $roombooking->guest_name = $request->guest_name;
            $roombooking->guest_mobile = $request->guest_mobile;
            $roombooking->booking_no = $request->booking_no;
            $roombooking->voucher_no = $request->voucher_no;
            $roombooking->booking_date = $formatted_booking_date;
            $roombooking->booking_time = $request->booking_time;
            $roombooking->checkin_date = $formatted_checkin_date;
            $roombooking->checkin_time = $request->checkin_time;
            $roombooking->checkout_date = $formatted_checkout_date;
            $roombooking->checkout_time = $request->checkout_time;
            $roombooking->no_of_guest = $request->no_of_guest;
            $roombooking->commited_days = $request->commited_days;
            $roombooking->business_source_id = $request->business_source_id;
            $roombooking->package_id = $request->package_id;
            $roombooking->gst_no = $request->gst_no;
            $roombooking->firm_address = $request->firm_address;
            $roombooking->firm_name = $request->firm_name;
            $roombooking->guest_idproof_no = $request->guest_idproof_no;
            $roombooking->guest_idproof = $request->guest_idproof;
            $roombooking->agent = $request->agent;
            $roombooking->guest_phone = $request->guest_phone;
            $roombooking->guest_nationality = $request->guest_nationality;
            $roombooking->guest_pincode = $request->guest_pincode;
            $roombooking->guest_contery = $request->guest_contery;
            $roombooking->guest_state = $request->guest_state;
            $roombooking->guest_address = $request->guest_address;
            $roombooking->guest_address2 = $request->guest_address2;
            $roombooking->guest_city = $request->guest_city;
            $roombooking->guest_email = $request->guest_email;
            $roombooking->voucher_payment_remark = $request->voucher_payment_remark;
            $roombooking->refrance_no = $request->voucher_payment_ref;
            $roombooking->booking_amount = $request->total_receipt_amt;


            //  $roombooking->posting_acc_id=$request->posting_acc_id;
            $roombooking->room_tariff_perday = $request->room_tariff_perday;
            $roombooking->guest_id_pic = $name;
            $roombooking->guest_pic = $name2;

            $roombooking->bookingaf1 = $request->vehicle_no;
            $roombooking->bookingaf2 = $request->parking_no;
            $roombooking->bookingaf3 = $request->booking_remark;
            $roombooking->checkin_voucher_no = 'book_by_guest';

            $roombooking->save();

        }


        $voucher_no = $request->voucher_no;
        $roombooking = roombooking::where('voucher_no', $voucher_no)->where('firm_id', $firm_id)->first();

        // $roomnos = DB::table('roombookings')
// ->select('voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'), 'booking_no', 'guest_name' ,'guest_mobile','booking_date','checkin_date','checkout_date')
// ->where('checkin_voucher_no', 'book_by_guest')
// ->groupBy('voucher_no', 'booking_no', 'guest_name','guest_mobile','booking_date','checkin_date','checkout_date')
// ->where('voucher_no',$voucher_no)
// ->get();
        $roomnos = DB::table('roombookings')
            ->select(

                'voucher_no',
                DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'),
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date'
            )
            ->where('checkin_voucher_no', 'book_by_guest')
            ->where('firm_id', $firm_id)
            ->where('voucher_no', $voucher_no)
            ->groupBy(

                'voucher_no',
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date'
            )
            ->get();
        // dd($roomnos);

        $checkinDate = Carbon::parse($roombooking->checkin_date);
        $checkoutDate = Carbon::parse($roombooking->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);

        // dd($roomnos);

        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.room_booking_view_by_guest', compact('roombooking', 'totaldays', 'roomnos'));


    }





    public function show(Request $request, $id)
    {   //this is function for show all detail of rooms only  when we select any room using ajex 
        if ($request->ajax()) {
            \Log::info('AJAX request received');
        }

        $room = Room::with(['roomtype.gstmaster', 'roomtype.package'])->where('firm_id', Auth::user()->firm_id)->find($id);


        if ($room) {
            return response()->json($room->toArray());
        } else {
            return response()->json([]);
        }
    }


    public function ledger_show($id)
    {
        $roombookings = roombooking::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)->first();

        $account_details = account::where('firm_id', Auth::user()->firm_id)
            ->where('mobile', $roombookings->guest_mobile)->first();


        $account_id = $account_details->id;




        $from_date = Carbon::now()->subYear()->format('Y-m-d');
        $to_date = Carbon::now()->addYear()->format('Y-m-d');
        $ledgers = ledger::where('firm_id', Auth::user()->firm_id)
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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $voucher_no)
    {
        $ledgerData = $this->ledger_show($voucher_no);
        $final_opning_balance = $ledgerData['final_opning_balance'] ?? 0;


        $roombookings_data = roombooking::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->where('checkin_voucher_no', '0')
            ->get();


        $roombookings_first = roombooking::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->where('checkin_voucher_no', '0')
            ->first();




        $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
            ->whereHas('accountGroup', function ($query) {
                $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
            })
            ->get();



        $businesssource = businesssource::where('firm_id', Auth::user()->firm_id)->get();
        $package = package::where('firm_id', Auth::user()->firm_id)->get();
        $othercharges = othercharge::where('firm_id', Auth::user()->firm_id)->get();



        $rooms_data = Room::with(['roomtype.gstmaster', 'roomtype.package'])

            ->where('firm_id', Auth::user()->firm_id)
            ->get();

        // Fetch room check-ins based on criteria

        // Get room numbers from room check-ins
        $bookingRoomNumbers = $roombookings_data
            ->where('firm_id', Auth::user()->firm_id)
            ->pluck('room_no')
            ->unique();



        // Fetch rooms associated with check-ins
        $bookingRooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->whereIn('room_no', $bookingRoomNumbers)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();



        // Combine vacant rooms and rooms from check-ins
        $rooms = $rooms_data->merge($bookingRooms)->unique('room_no');



        $new_bill_no = $roombookings_first->booking_no;

        $new_voucher_no = $roombookings_first->voucher_no;



        return view('entery.room.room_booking_edit', compact(
            'rooms',
            'bookingRooms',
            'roombookings_data',
            'businesssource',
            'roombookings_first',
            'package',
            'new_bill_no',
            'new_voucher_no',
            'othercharges',
            'paymentmodes'
        ))->with([
                    'final_opning_balance' => $ledgerData['final_opning_balance']
                ]);







    }

    public function update(Request $request)
    {

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
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

        // If validation passes, proceed with updating the data
        if ($validator->passes()) {



            $roombookingData = roombooking::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $request->voucher_no);
            // Fetch a single record
        
        $ledgerdata = ledger::where('reciept_no', $request->booking_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->get(); // Fetch a collection of records
        
        if ($roombookingData) {
            // Delete the roombooking record if it exists
            if ($roombookingData) {
                $roombookingData->delete();
            }
        
            // Delete all ledger records if they exist
            if (!$ledgerdata->isEmpty()) {
                ledger::whereIn('id', $ledgerdata->pluck('id'))->delete();
            }
        }
        

            $posting_acc_ids = $request->posting_acc_id;  // Array of account IDs
            $booking_amounts = $request->booking_amount;  // Array of amounts

            $customer = Account::Where('mobile', $request->guest_mobile)
                ->where('firm_id', Auth::user()->firm_id)
                ->first();
            if ($customer == null) {
                $this->create_account($request);
            }

            $date_variable = $request->booking_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_booking_date = $parsed_date->format('Y-m-d');
            $validatedData['booking_date'] = $formatted_booking_date;

            $date_variable = $request->checkin_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_checkin_date = $parsed_date->format('Y-m-d');
            $validatedData['checkin_date'] = $formatted_checkin_date;

            $date_variable = $request->checkout_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_checkout_date = $parsed_date->format('Y-m-d');
            $validatedData['checkout_date'] = $formatted_checkout_date;
            if ($request->hasFile('guest_id_pic')) {
                $image1 = $request->guest_id_pic;
                $name = $image1->getClientOriginalName();
                $image1->storeAS('public\account_image', $name);

            } else {
                $name = NULL;
            }
            if ($request->hasFile('guest_pic')) {
                $image2 = $request->guest_pic;
                $name2 = $image2->getClientOriginalName();
                $image2->storeAS('public\account_image', $name2);
            } else {
                $name2 = NULL;
            }



            $booking_room_ids = $request->booking_room_id;

            foreach ($booking_room_ids as $booking_room_id) {
                $roombooking = new roombooking;
                $roombooking->firm_id = Auth::user()->firm_id;

                $roomdetails = room::where('id', $booking_room_id)->first();
                $roombooking->room_id = $booking_room_id;
                $roombooking->room_no = $roomdetails->room_no;
                $roombooking->guest_name = $request->guest_name;
                $roombooking->guest_mobile = $request->guest_mobile;
                $roombooking->booking_no = $request->booking_no;
                $roombooking->voucher_no = $request->voucher_no;
                $roombooking->booking_date = $formatted_booking_date;
                $roombooking->booking_time = $request->booking_time;
                $roombooking->checkin_date = $formatted_checkin_date;
                $roombooking->checkin_time = $request->checkin_time;
                $roombooking->checkout_date = $formatted_checkout_date;
                $roombooking->checkout_time = $request->checkout_time;
                $roombooking->no_of_guest = $request->no_of_guest;
                $roombooking->commited_days = $request->commited_days;
                $roombooking->business_source_id = $request->business_source_id;
                $roombooking->package_id = $request->package_id;
                $roombooking->gst_no = $request->gst_no;
                $roombooking->firm_address = $request->firm_address;
                $roombooking->firm_name = $request->firm_name;
                $roombooking->guest_idproof_no = $request->guest_idproof_no;
                $roombooking->guest_idproof = $request->guest_idproof;
                $roombooking->agent = $request->agent;
                $roombooking->guest_phone = $request->guest_phone;
                $roombooking->guest_nationality = $request->guest_nationality;
                $roombooking->guest_pincode = $request->guest_pincode;
                $roombooking->guest_contery = $request->guest_contery;
                $roombooking->guest_state = $request->guest_state;
                $roombooking->guest_address = $request->guest_address;
                $roombooking->guest_address2 = $request->guest_address2;
                $roombooking->guest_city = $request->guest_city;
                $roombooking->guest_email = $request->guest_email;
                $roombooking->voucher_payment_remark = $request->voucher_payment_remark;
                $roombooking->refrance_no = $request->voucher_payment_ref;
                $roombooking->booking_amount = $request->total_receipt_amt;


                //  $roombooking->posting_acc_id=$request->posting_acc_id;
                $roombooking->room_tariff_perday = $request->room_tariff_perday;
                $roombooking->guest_id_pic = $name;
                $roombooking->guest_pic = $name2;

                $roombooking->bookingaf1 = $request->vehicle_no;
                $roombooking->bookingaf2 = $request->parking_no;
                $roombooking->bookingaf3 = $request->booking_remark;
                $roombooking->save();

            }
            $this->post_amount($request);
            $voucher_no = $request->voucher_no;
            $roombooking = roombooking::where('voucher_no', $voucher_no)
                ->where('firm_id', Auth::user()->firm_id)
                ->first();

            $roomnos = DB::table('roombookings')
                ->select(
                    'firm_id',
                    'voucher_no',
                    DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'),
                    'booking_no',
                    'guest_name',
                    'guest_mobile',
                    'booking_date',
                    'checkin_date',
                    'checkout_date'
                )
                ->where('checkin_voucher_no', '0')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $voucher_no)
                ->groupBy(
                    'firm_id',
                    'voucher_no',
                    'booking_no',
                    'guest_name',
                    'guest_mobile',
                    'booking_date',
                    'checkin_date',
                    'checkout_date'
                )
                ->get();

            $roombookingdata = roombooking::where('voucher_no', $request->voucher_no)
                ->where('checkin_voucher_no', '0')
                ->where('firm_id', Auth::user()->firm_id)
                ->get();
            $totalroom = $roombookingdata->count();

            $checkinDate = Carbon::parse($roombooking->checkin_date);
            $checkoutDate = Carbon::parse($roombooking->checkout_date);
            $totaldays = $checkinDate->diffInDays($checkoutDate);

            // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
            return view('entery.room.room_booking_view', compact('roombooking', 'totaldays', 'roomnos', 'totalroom', 'roombookingdata'));

            // Update the booking information

            // Redirect to the booking home page with a success message


        } else {
            dd("save nahi hoga");
            // Return back with validation errors and input data
            // return back()->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roombooking = roombooking::where('firm_id', Auth::user()->firm_id)->where('voucher_no', $id);
        $ledger = ledger::where('transaction_type', 'Room_booking')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id);




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
        $roombooking = roombooking::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)->count();
        if ($roombooking > 0) {
            roombooking::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $id)->update(['checkin_voucher_no' => '0']);

        }
        return redirect('/pending_booking')->with('message', 'Selected Booking Confirm you can  Make Check In ');

    }


    public function roombooking_print_view($voucher_no)
    {

        $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Room_booking')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('entery.room.checkout.room_checkout_print_select', compact('voucher_no', 'fromtlist'));

    }

    public function view($id)
    {

        $roomnos = DB::table('roombookings')
            ->select(
                'firm_id',
                'voucher_no',
                DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'),
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date'
            )
            // ->where('checkin_voucher_no', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)
            ->groupBy(
                'firm_id',
                'voucher_no',
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date'
            )
            ->get();
        $roombookingdata = roombooking::where('voucher_no', $id)
            ->get();
        $totalroom = $roombookingdata->count();


        $roombooking = roombooking::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)->first();
        $checkinDate = Carbon::parse($roombooking->checkin_date);
        $checkoutDate = Carbon::parse($roombooking->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);

        return view('entery.room.room_booking_view', compact('roombooking', 'totaldays', 'roomnos', 'totalroom', 'roombookingdata'));
    }
    public function roombooking_print2($id)
    {

        $roomnos = DB::table('roombookings')
            ->select(
                'firm_id',
                'voucher_no',
                DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'),
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date'
            )
            // ->where('checkin_voucher_no', '0')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)
            ->groupBy(
                'firm_id',
                'voucher_no',
                'booking_no',
                'guest_name',
                'guest_mobile',
                'booking_date',
                'checkin_date',
                'checkout_date'
            )
            ->get();
        $roombookingdata = roombooking::where('voucher_no', $id)
        ->where('firm_id', Auth::user()->firm_id)
            ->get();
        $totalroom = $roombookingdata->count();
        


        $roombooking = roombooking::where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $id)->first();
        $checkinDate = Carbon::parse($roombooking->checkin_date);
        $checkoutDate = Carbon::parse($roombooking->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);

        return view('entery.room.room_booking_view2', compact('roombooking', 'totaldays', 'roomnos', 'totalroom', 'roombookingdata'));
    }


    public function roombooking_by_dashboard($id)
    {

        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->findOrFail($id);
        return view('entery.room.room_booking_by_dashboard', compact('rooms'));
    }

    public function booking_calendar()
    {
        $currentDate = Carbon::now();
        $rooms = Room::with('roomtype')->where('firm_id', Auth::user()->firm_id)->get();

        // Get all bookings
        $roombookings = Roombooking::where('firm_id', Auth::user()->firm_id)
            ->where('checkin_voucher_no', '0')->get();

        return view('reports.rooms_report.booking_calendar', [
            'currentDate' => $currentDate,
            'rooms' => $rooms,
            'roombookings' => $roombookings,
        ]);
    }

    public function booking_by_guest_create($firm_id)
    {
        //requierd setup


        $businesssource = businesssource::where('firm_id', $firm_id)->get();
        $package = package::where('firm_id', $firm_id)->get();
        $paymentmodes = account::where('firm_id', $firm_id)
            ->whereHas('accountGroup', function ($query) {
                $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
            })
            ->get();

        $roombooking_record = roombooking::where('firm_id', $firm_id)->count();
        if ($roombooking_record > 0) {
            $lastRecord = roombooking::where('firm_id', $firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id', $firm_id)->where('voucher_type_name', 'Room_booking')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id', $firm_id)->where('voucher_type_name', 'Room_booking')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }



        $rooms = room::with(['roomtype.gstmaster', 'roomtype.package'])
            ->where('room_status', 'vacant')
            ->where('firm_id', $firm_id)->get();

        return view('entery.room.room_booking_by_guest', compact('rooms', 'businesssource', 'package', 'new_bill_no', 'new_voucher_no', 'paymentmodes', 'firm_id'));

    }




}
