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
use App\Models\optionlist;
use App\Models\componyinfo;
use App\Models\othercharge;
use App\Models\roombooking;
use App\Models\roomcheckin;
use App\Models\WhatsappSms;
use Illuminate\Support\Str;
use App\Models\roomcheckout;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\financialyear;
use App\Models\businesssource;
use App\Models\compinfofooter;
use App\Models\businesssetting;
use App\Models\softwarecompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreroomcheckoutRequest;
use App\Http\Requests\UpdateroomcheckoutRequest;

class RoomcheckoutController extends CustomBaseController
{

    // public function index()
    // {
    //     $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
    //         ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->get();
    //     return view('entery.room.checkout.room_checkout_index', compact('roomcheckouts'));
    //          $financialyear = financialyear::where('firm_id', Auth::user()->firm_id)->where('is_active_fy', '1')->first();

    // if ($financialyear) {
    //     $fy_start_date = $financialyear->financial_year_start;
    //     $fy_end_date = $financialyear->financial_year_end;
    //     $financialyeardata=$financialyear;
    // } else {
    //     $fy_start_date = Carbon::parse('2024-04-01');
    //     $fy_end_date = Carbon::parse('2026-03-31');
    //     $financialyeardata=null;
    // }

    // }

public function index()
{
    $fy_start_date = $this->fy_start_date;
    $fy_end_date = $this->fy_end_date;
    $firmId = Auth::user()->firm_id;

    // Subquery: one row per voucher_no (minimum id)
    // $checkinsSub = RoomCheckin::withinFY('checkin_date')
    //     ->where('roomcheckins.firm_id', $firmId) // ✅ qualified table
    //     ->select('*')
    //     ->whereRaw('id = (SELECT MIN(id) FROM roomcheckins WHERE voucher_no = roomcheckins.voucher_no AND firm_id = ?)', [$firmId]);

        // $ht=$checkinsSub->get();
        // dd($ht);
// Step 1: Get min ID for each voucher_no within firm and date
$minIds = DB::table('roomcheckins')
    ->whereBetween('checkin_date', [$fy_start_date, $fy_end_date])
    ->where('firm_id', $firmId)
    ->select(DB::raw('MIN(id) as id'))
    ->groupBy('voucher_no');

// Step 2: Join those back to get full records
$checkinsSub = DB::table('roomcheckins as r1')
    ->joinSub($minIds, 'min_ids', function ($join) {
        $join->on('r1.id', '=', 'min_ids.id');
    })
    ->select('r1.*');


    
    
// $ht=$checkinsSub->get();
//         dd($ht);

    // $roomcheckouts = RoomCheckout::withinFY('checkout_date')
    //     ->where('roomcheckouts.firm_id', $firmId)
    //     ->leftJoinSub($checkinsSub, 'roomcheckins', function ($join) {
    //         $join->on('roomcheckouts.checkin_voucher_no', '=', 'roomcheckins.voucher_no');
    //     })
    //     ->select(
    //         'roomcheckouts.voucher_no',
    //         'roomcheckouts.*',
    //         'roomcheckins.voucher_no as checkin_voucher_no',
    //         'roomcheckouts.room_no as checkout_room_no',
    //         'roomcheckins.*'
    //     )
    //     ->orderByRaw('CAST(roomcheckouts.voucher_no AS UNSIGNED) DESC')
    //     ->get();

    $roomcheckouts = RoomCheckout::withinFY('checkout_date')
    ->where('roomcheckouts.firm_id', $firmId)
    ->leftJoinSub($checkinsSub, 'roomcheckins', function ($join) {
        $join->on('roomcheckouts.checkin_voucher_no', '=', 'roomcheckins.voucher_no');
    })
    ->select(
        'roomcheckouts.voucher_no',
        'roomcheckouts.voucher_no as checkout_vh_no', // ✅ alias added
        'roomcheckouts.*',
        'roomcheckins.voucher_no as checkin_voucher_no',
        'roomcheckouts.room_no as checkout_room_no',
        'roomcheckins.*'
    )
    ->orderByRaw('CAST(roomcheckouts.voucher_no AS UNSIGNED) DESC')
    ->get();




    return view('entery.room.checkout.room_checkout_index', compact('roomcheckouts'));
}



    public function indexzz()
    {

       $firmId = Auth::user()->firm_id;

        $roomcheckouts = roomcheckout::where('roomcheckouts.firm_id', $firmId)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    
            ->leftJoinSub(
                DB::table('roomcheckins as r1')
                    ->selectRaw('r1.*')
                    ->whereRaw('r1.id = (SELECT MIN(id) FROM roomcheckins WHERE voucher_no = r1.voucher_no AND firm_id = ?)', [$firmId])
                     ->whereBetween('r1.checkin_date', [$this->fy_start_date, $this->fy_end_date]),
                    'roomcheckins',
                function ($join) {
                    $join->on('roomcheckouts.checkin_voucher_no', '=', 'roomcheckins.voucher_no');
                }
            )
            ->select(
                'roomcheckouts.voucher_no',  // ✅ Explicitly selecting `voucher_no` from roomcheckouts
                'roomcheckouts.*',           // ✅ Ensures `voucher_no` remains from `roomcheckouts`
                'roomcheckins.voucher_no as checkin_voucher_no', // ✅ Renaming roomcheckins.voucher_no
                'roomcheckouts.room_no as checkout_room_no',       // ✅ Renaming roomcheckins.room_no
                'roomcheckins.*'
            )
            ->orderByRaw('CAST(roomcheckouts.voucher_no AS UNSIGNED) DESC')
            ->get();



        return view('entery.room.checkout.room_checkout_index', compact('roomcheckouts'));
    }







    public function register(Request $request)
    {
        if (empty($request->from_date) || empty($request->to_date)) {
            $from_date = Carbon::today()->format('Y-m-d');
            $to_date = Carbon::today()->format('Y-m-d');
        } else {
            $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
        }


        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    
            ->whereBetween('checkout_date', [$from_date, $to_date])
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->get();
        return view('entery.room.checkout.room_checkout_register', compact('roomcheckouts', 'from_date', 'to_date'));

    }
    public function guestlog()
    {
        $guestVisits = DB::table('roomcheckouts')
            ->select(
                'guest_name',
                DB::raw('COUNT(*) as visit_count'),
                DB::raw('SUM(total_billamount) as total_amount')
            )
            ->where('firm_id', Auth::user()->firm_id)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->groupBy('guest_name')
            ->orderByDesc('visit_count')
            ->get();

        return view('entery.room.checkout.guestlog', compact('guestVisits'));

    }



    public function create()
    {
        $roomcheckins = DB::table('roomcheckins')
            ->select('voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no ASC SEPARATOR ", ") as room_nos'), 'check_in_no', 'guest_name', 'guest_mobile', 'checkin_date', 'checkin_time', 'checkout_voucher_no')
            ->groupBy('voucher_no', 'check_in_no', 'guest_name', 'guest_mobile', 'checkin_date', 'checkin_time', 'checkout_voucher_no')
            ->where('checkout_voucher_no', '0')
            // ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('firm_id', Auth::user()->firm_id)
            ->get();

        return view('entery.room.checkout.room_checkout', compact('roomcheckins'));

    }

    //store room checkout new 
    public function roomcheckouts_store_edit(Request $request)
    {

        $method_type = "Check_out_update";
        $voucher_no = $request->voucher_no;
        $this->sendCheckOutWhatsapp($method_type, $voucher_no);
        // dd($request);
        $roomcheckout = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $request->voucher_no)
            // ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->first();

        if ($roomcheckout) {
            $roomcheckins = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', $request->voucher_no)

                ->where('firm_id', Auth::user()->firm_id)
                ->first();
        }

        if ($roomcheckins) {
            $account_id = $roomcheckins->account_id;

            // Delete room checkout record


            // Delete related ledger records
            ledger::withinFY('entry_date')->where('voucher_no', $request->voucher_no)
                ->where('firm_id', Auth::user()->firm_id)
                ->whereIn('transaction_type', ['Check_Out', 'Room_Checkout'])
                ->delete();



            $roomcheckout->delete();
        }



        $validator = validator::make($request->all(), [
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
            'amt_post_credit_id' => 'required',
            'bill_type' => 'required',
        ]);
        // if($validator->passes())
        // {
        //     return " validator pass  try to save data ";

        // }
        // else{
        //     // return back()->withInput()->withErrors($validator);
        //     return back()->withInput()->withErrors($validator);

        // }

        $guest_detail = account::where('firm_id', Auth::user()->firm_id)
            ->where('id', $request->amt_post_credit_id)->first();
        $guest_gst_code = $guest_detail->gst_code;
        $comp_detail = componyinfo::where('firm_id', Auth::user()->firm_id)->first();
        $comp_gst_code = $comp_detail->cominfo_field1;
        $make_all_bill_local_gst = $comp_detail->make_all_bill_local_gst;




        $date_variable = $request->checkin_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_checkin_date = $parsed_date->format('Y-m-d');
        $validatedData['checkin_date'] = $formatted_checkin_date;

        $date_variable2 = $request->checkout_date;
        $parsed_date2 = Carbon::createFromFormat('d-m-Y', $date_variable2);
        $formatted_checkout_date = $parsed_date2->format('Y-m-d');
        $validatedData['checkout_date'] = $formatted_checkout_date;

                              $fy_start_date = $this->fy_start_date;
                    $fy_end_date = $this->fy_end_date;
                    $financialyeardata=$this->financialyeardata;
                    if ($financialyeardata && 
    $formatted_checkout_date < $fy_start_date || 
    $formatted_checkout_date > $fy_end_date) {

return view('error.checkdate_on_fy',compact('fy_start_date','fy_end_date'));

}



        $checkout_room_ids = $request->room_checkout_id;
        $checkin_voucher_no = $request->checkin_voucher_no;

        // Update all RoomCheckin records with the given voucher_no
        $checkinUpdated = RoomCheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $checkin_voucher_no)
            ->update(['checkout_voucher_no' => $request->voucher_no]);


        $checkout = new roomcheckout;
        $checkout->firm_id = Auth::user()->firm_id;

        $checkout->voucher_no = $request->voucher_no;
        $checkout->check_out_no = $request->check_out_no;
        $checkout->checkin_date = $formatted_checkin_date;
        $checkout->checkin_time = $request->checkin_time;
        $checkout->checkout_date = $formatted_checkout_date;
        $checkout->check_out_time = $request->check_out_time;
        $checkout->calculation_type = $request->calculation_type;
        $checkout->per_day_tariff = $request->per_day_tariff;
        $checkout->no_of_days = $request->no_of_days;
        $checkout->total_room_rent = $request->total_room_rent;
        $checkout->gst_id = $request->gst_id;
        $checkout->gst_total = $request->gst_total;
        // dd($guest_gst_code);
        if ($guest_gst_code === $comp_gst_code || empty($guest_gst_code) || $make_all_bill_local_gst == 1) {
            $checkout->sgst = $request->gst_total / 2;
            $checkout->cgst = $request->gst_total / 2;


        } elseif ($guest_gst_code === "") {
            $checkout->sgst = $request->gst_total / 2;
            $checkout->cgst = $request->gst_total / 2;

        } else {
            $checkout->igst = $request->gst_total;
        }



        $checkout->final_room_rent = $request->total_room_rent + $request->gst_total;
        $checkout->total_food_amt = $request->total_food_amt;
        $checkout->other_charge = $request->add_other;
        $checkout->discount = $request->less_discount;
        $checkout->total_billamount = $request->bill_amount;
        $checkout->total_advance = $request->total_advance;
        $checkout->balance_to_pay = $request->balance_to_pay;
        $checkout->guest_name = $request->guest_name;
        $checkout->guest_mobile = $request->guest_mobile;
        // $checkout->posting_acc_id="0";
        $checkout->voucher_posting_amt = $request->total_receipt_amt;
        $checkout->checkin_voucher_no = $request->checkin_voucher_no;
        $checkout->amt_post_credit_amt = $request->amt_post_credit_amt;
        $checkout->amt_post_credit_id = $request->amt_post_credit_id;
        $checkout->account_id = $request->account_id;
        $checkout->bill_type = $request->bill_type;
        $checkout->userid = Auth::user()->id;
        $checkout->username = Auth::user()->name;



        $roomIds = [];
        $roomNos = [];
        foreach ($checkout_room_ids as $room_checkout_id) {
            $roomdetails = Room::where('firm_id', Auth::user()->firm_id)
                ->where('id', $room_checkout_id)->first();
            if ($roomdetails) {
                // Add room ID and room number to arrays
                $roomIds[] = $room_checkout_id;
                $roomNos[] = $roomdetails->room_no;

                // Update room status to 'dirty'
                Room::where('firm_id', Auth::user()->firm_id)
                    ->where('id', $room_checkout_id)->update(['room_status' => 'dirty']);
            }
        }
        $checkout->room_id = implode(',', $roomIds);
        $checkout->room_no = implode(',', $roomNos);



        $checkout->save();
        $posting_acc_id = $request->posting_acc_id;
        $voucher_posting_amt = $request->voucher_posting_amt;
        $amt_post_credit_id = $request->amt_post_credit_id;
        $amt_post_credit_amt = $request->amt_post_credit_amt;

        if ($posting_acc_id > 0 || $voucher_posting_amt != 0) {
            // $a="this is account posting on bank ";
            $this->post_amount($request);
        }
        if ($amt_post_credit_amt > 0 || $amt_post_credit_amt != Null) {
            $this->post_amount_credit($request);
            // $b="this is account posting on bank ";
        }
        //    return $a." ---- ".$b;

        $this->sale_post_amount($request);


        $guest_mobile = $request->guest_mobile;
        $guest_detail = account::where('firm_id', Auth::user()->firm_id)
            ->where('mobile', $guest_mobile)->first();


        $voucher_no = $request->voucher_no;
        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view', compact('roomcheckouts', 'guest_detail', 'totaldays'));
    }



    // room chekout print_view 
    public function checkout_print_view($voucher_no)
    {

        $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Check_out')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('entery.room.checkout.room_checkout_print_select', compact('voucher_no', 'fromtlist'));

    }
    public function room_checkout_view($voucher_no)
    {

        $roomcheckouts = roomcheckout::withinFY('checkout_date')->with('account')
            ->where('firm_id', Auth::user()->firm_id)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('voucher_no', $voucher_no)->first();


        // Calculate the total days between checkin and checkout
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $checkin_voucher_no = $roomcheckouts->checkin_voucher_no;
        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room', 'package')
            ->where('voucher_no', $checkin_voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();
        // dd($roomcheckins);

        $days = $checkinDate->diffInDays($checkoutDate);

        $foodBills = foodbill::withinFY('voucher_date')->where('service_id', $checkin_voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->selectRaw('voucher_date, SUM(total_bill_value) as total_amount')
            ->groupBy('voucher_date')
            ->get()
            ->keyBy('voucher_date'); // Keyed by date for easy access in the view

        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('mobile', $guest_mobile)->where('firm_id', Auth::user()->firm_id)->first();


        return view('entery.room.checkout.room_checkout_view', compact('roomcheckouts', 'guest_detail', 'days', 'foodBills', 'roomcheckins'));

    }

    //OLD ROOM CHECKOUT VIEW 
    public function room_checkout_view2($voucher_no)
    {

        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('voucher_no', $voucher_no)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('firm_id', Auth::user()->firm_id)
            ->where('mobile', $guest_mobile)->first();
        $checkin_voucher_no = $roomcheckouts->checkin_voucher_no;
        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room', 'package')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $checkin_voucher_no)->first();
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view2', compact('roomcheckouts', 'guest_detail', 'totaldays', 'roomcheckins'));


    }
    public function room_checkout_view3($voucher_no)
    {

        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('voucher_no', $voucher_no)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('firm_id', Auth::user()->firm_id)
            ->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('mobile', $guest_mobile)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkin_voucher_no = $roomcheckouts->checkin_voucher_no;
        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room', 'package')
            ->where('voucher_no', $checkin_voucher_no)
            ->where('firm_id', Auth::user()->firm_id)->first();
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view3', compact('roomcheckouts', 'guest_detail', 'totaldays', 'roomcheckins'));


    }

    public function room_checkout_view4($voucher_no)
    {

        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('voucher_no', $voucher_no)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('mobile', $guest_mobile)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkin_voucher_no = $roomcheckouts->checkin_voucher_no;
        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room', 'package')
            ->where('voucher_no', $checkin_voucher_no)
            ->where('firm_id', Auth::user()->firm_id)->first();
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view4', compact('roomcheckouts', 'guest_detail', 'totaldays', 'roomcheckins'));


    }
    public function room_checkout_view5($voucher_no)
    {

        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('mobile', $guest_mobile)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkin_voucher_no = $roomcheckouts->checkin_voucher_no;
        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room', 'package')
            ->where('voucher_no', $checkin_voucher_no)
            ->where('firm_id', Auth::user()->firm_id)->first();
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view3', compact('roomcheckouts', 'guest_detail', 'totaldays', 'roomcheckins'));


    }
    public function room_checkout_view6($voucher_no)
    {

        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('voucher_no', $voucher_no)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('firm_id', Auth::user()->firm_id)
            ->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('mobile', $guest_mobile)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkin_voucher_no = $roomcheckouts->checkin_voucher_no;
        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room', 'package')
            ->where('voucher_no', $checkin_voucher_no)
            ->where('firm_id', Auth::user()->firm_id)->first();
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view6', compact('roomcheckouts', 'guest_detail', 'totaldays', 'roomcheckins'));


    }

     public function room_checkout_view7($voucher_no)
    {

        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('voucher_no', $voucher_no)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('firm_id', Auth::user()->firm_id)
            ->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('mobile', $guest_mobile)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkin_voucher_no = $roomcheckouts->checkin_voucher_no;
        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room', 'package')
            ->where('voucher_no', $checkin_voucher_no)
            ->where('firm_id', Auth::user()->firm_id)->first();
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view7', compact('roomcheckouts', 'guest_detail', 'totaldays', 'roomcheckins'));


    }
     public function room_checkout_view8($voucher_no)
    {

        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('voucher_no', $voucher_no)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        $guest_mobile = $roomcheckouts->guest_mobile;
        $guest_detail = account::where('mobile', $guest_mobile)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $checkin_voucher_no = $roomcheckouts->checkin_voucher_no;
        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room', 'package')
            ->where('voucher_no', $checkin_voucher_no)
            ->where('firm_id', Auth::user()->firm_id)->first();
         $foodbills = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                ->where('service_id', $checkin_voucher_no)
                ->where('status', '0')
                ->select('net_food_bill_amount', 'total_bill_value', 'kot_no', 'total_qty', 'voucher_no', 'food_bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
                ->groupBy('net_food_bill_amount', 'voucher_no', 'kot_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
               ->orderBy('voucher_no','ASC')
                ->get();
  
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        return view('entery.room.checkout.room_checkout_view8', compact('roomcheckouts', 'guest_detail', 'totaldays', 'roomcheckins','foodbills'));


    }
    //clear dirty room  id is voucgher_no 
    public function dirty_room_clear($id)
    {

        $roomDetails = Room::where('id', $id)->where('firm_id', Auth::user()->firm_id);


        if ($roomDetails->room_status = 'dirty') {

            $roomDetails->update(['room_status' => 'vacant']);
            return back()->with('message', 'Selected room is clean. You can assign a new guest.');
        }


    }
    //function for 
    //  checkin 
    public function edit($voucher_no)
    {
        $id = $voucher_no;

        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room')
            ->where('checkout_voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();
        $roomcheckins_first = $roomcheckins->first();
        $chekcout_data = roomcheckout::withinFY('checkout_date')->where('voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();

        $lastpayment = ledger::withinFY('entry_date')->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->whereIn('transaction_type', ['Check_Out'])
            ->where('credit', '>', 0)
            ->get();




        $roomcheckin_voucher_no = $roomcheckins->first()->voucher_no;
        $ledgerData = $this->ledger_show_edit($id);

        // dd( $roomcheckins);
        // $account_id=$roomcheckins->account_id;
        // $ledgerData = $this->ledger_show($request, $id);

        if ($roomcheckins->isNotEmpty()) {
            // Extract the first record's details
            $firstRecord = $roomcheckins->first();
            $gst_percent = $firstRecord->room->roomtype->gstmaster;

            $account_id = $firstRecord->account_id;
            $data = $firstRecord->toArray();
            $account_detail = account::where('id', $account_id)
                ->where('firm_id', Auth::user()->firm_id)->first();


            // Extract room numbers into an array
            $roomNos = $roomcheckins->pluck('room_no')->toArray();

            // Remove room_no from the first record's data to avoid duplication
            unset($data['room_no']);

            $checkout_record = roomcheckout::withinFY('checkout_date')->where('bill_type', 'Check_out')
                ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

                ->where('firm_id', Auth::user()->firm_id)
                ->count();
            if ($checkout_record > 0) {
                $lastRecord = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
                    ->where('bill_type', 'Check_out')->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
                $voucher_no = $lastRecord->voucher_no;
                $new_voucher_no = $voucher_no + 1;
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_type_name', 'Check_Out')->first();
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;
                $bill_type = $voucher_type->voucher_type_name;

            } else {
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_type_name', 'Check_Out')->first();

                $voucher_no = $voucher_type->numbring_start_from;
                $new_voucher_no = $voucher_no + 1;
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;
                $bill_type = $voucher_type->voucher_type_name;

            }

            $kots = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                ->where('service_id', $roomcheckin_voucher_no)
                ->where('status', '0')
                ->select('total_amount', 'total_qty', 'voucher_no', 'bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
                ->groupBy('voucher_no', 'total_amount', 'total_qty', 'bill_no', 'service_id', 'status', 'user_id', 'voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
                ->get();


            $foodbills = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                ->where('service_id', $roomcheckin_voucher_no)
                ->where('status', '0')
                ->select('net_food_bill_amount', 'total_bill_value', 'kot_no', 'total_qty', 'voucher_no', 'food_bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
                ->groupBy('net_food_bill_amount', 'voucher_no', 'kot_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
                ->get();

            $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
                })
                ->get();

            $businesssettings = businesssetting::where('firm_id', Auth::user()->firm_id)->first();
            $calculation_type = $businesssettings->calculation_type;

            // Pass all data except room_no and room_nos separately
            return view('entery.room.checkout.room_checkout_after_checkin_edit', ['calculation_type' => $calculation_type, 'roomcheckins' => $roomcheckins, 'account_detail' => $account_detail, 'gst_percent' => $gst_percent, 'data' => $data, 'roomNos' => $roomNos, 'new_bill_no' => $new_bill_no, 'new_voucher_no' => $new_voucher_no, 'kots' => $kots, 'foodbills' => $foodbills, 'paymentmodes' => $paymentmodes, 'bill_type' => $bill_type, 'roomcheckins_first' => $roomcheckins_first, 'chekcout_data' => $chekcout_data, 'final_opning_balance' => $ledgerData['final_opning_balance'], 'lastpayment' => $lastpayment]);
            // dd( ['data' => $data, 'roomNos' => $roomNos]);
        } else {
            // Handle the case when no records are found
            return view('entery.room.checkout.room_checkout_after_checkin_edit', ['data' => [], 'roomNos' => []]);
        }


        //
    }

//     public function sendCheckOutWhatsappOLD($method_type, $voucher_no)
//     {

//         $firmId = Auth::user()->firm_id;
//         // Fetch WhatsApp Template
//         $whatsapp = null;
//         if (Schema::hasTable('whatsapp_sms')) {
//             $whatsapp = WhatsappSms::where('firm_id', $firmId)
//                 ->where('transection_type', $method_type)
//                 ->where('wp_active', '1')
//                 ->first();

//             // Fetch software company info
//             $software_companyInfo = softwarecompany::where('firm_id', $firmId)->first();

//             // ✅ Validate: template exists and auth key is not 'af' or empty
//             if ($whatsapp && $software_companyInfo && !empty($software_companyInfo->software_af4) && strtolower($software_companyInfo->software_af4) !== 'af') {

//                 $wp_record = Roomcheckout::withinFY('checkout_date')->where('firm_id', $firmId)->where('voucher_no', $voucher_no)->first();

//                 $componyinfo = Componyinfo::where('firm_id', $firmId)->first();

//                 if ($wp_record || $componyinfo) {


//                     // Replace placeholders
//                     $template = $whatsapp->wp_message;
//                     $name = Auth::user()->name;

//                     $placeholders = [
//                         '{firm_name}' => $componyinfo->cominfo_firm_name,
//                         '{room_no}' => $wp_record->room_no,
//                         '{voucher_no}' => $wp_record->voucher_no,
//                         '{checkout_date}' => date('d-m-Y', strtotime($wp_record->checkout_date)),
//                         '{total_billamount}' => $wp_record->total_billamount,
//                         '{guest_name}' => $wp_record->guest_name,
//                         '{address1}' => $componyinfo->cominfo_address1,
//                         '{address2}' => $componyinfo->cominfo_address2,
//                         '{city}' => $componyinfo->cominfo_city,
//                         '{pincode}' => $componyinfo->cominfo_pincode,
//                         '{state}' => $componyinfo->cominfo_state,
//                         '{email}' => $componyinfo->cominfo_email,
//                         '{website}' => $componyinfo->cominfo_field2,
//                         '{firm_id}' => $firmId,
//                         '{phone}' => $componyinfo->cominfo_phone,
//                         '{mobile}' => $componyinfo->cominfo_mobile,
//                         '{name}' => $name,

//                     ];

//                     $message = str_replace(array_keys($placeholders), array_values($placeholders), $template);

//                     // Send WhatsApp
//                     $url = $software_companyInfo->software_af5;
//                     $authentic_key = $software_companyInfo->software_af4;

//                     // $validity_date = Carbon::parse($software_companyInfo->software_af6)->startOfDay(); // assume end of validity is the full day
// // $current_date = now()->startOfDay(); // ignore time portion

//                     // if ($current_date->greaterThan($validity_date)) {
// //     return "WhatsApp validity has expired. Please recharge.";
// // }

//                     if ($method_type == "Check_out_store") {
//                         $mobile = $wp_record->guest_mobile;
//                     } else {
//                         $mobile = $componyinfo->cominfo_mobile;

//                     }


//                     $response = Http::get($url, [
//                         'authentic-key' => $authentic_key,
//                         'route' => 1,
//                         'number' => $mobile,
//                         'message' => $message,
//                     ]);

//                     // Handle response
//                     $data = $response->json();


//                 }

//             }


//         }

//         // Fetch data


//         if (isset($data['status']) && $data['status'] == 'success') {
//             return back()->with('message', 'WhatsApp message sent successfully!');
//         } else {
//             return back()->with('error', 'Failed to send WhatsApp message.');
//         }
//     }

    public function sendCheckOutWhatsapp($method_type, $voucher_no)
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
     $wp_record = Roomcheckout::withinFY('checkout_date')->where('firm_id', $firmId)->where('voucher_no', $voucher_no)->first();


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
    if ($method_type !== 'Check_out_delete' && !empty($wp_record->guest_mobile)) {
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
    //req code for update checkout 

    public function roomcheckouts_store(Request $request)
    {

        $existingRecords = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $request->voucher_no)
            ->where('bill_type','=',$request->bill_type)
            ->count();

        if ($existingRecords >= 1) {
            $html = '
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">
            <h2 style="color: red; text-align: center;">
                ⚠️ Duplicate bill number not allowed.<br>
                ⚠️ पहले से रिकॉर्ड मौजूद है। डुप्लिकेट बिल नंबर मान्य नहीं है।
            </h2>
 <button onclick="history.back()" style="margin-top: 20px; background-color: #343a40; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                <- Back 
            </button>
        </div>
    ';
            return response($html, 400);
        }





        $validator = validator::make($request->all(), [
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
            'amt_post_credit_id' => 'required',
            'bill_type' => 'required',
        ]);
        // if($validator->passes())
        // {
        //     return " validator pass  try to save data ";

        // }
        // else{
        //     // return back()->withInput()->withErrors($validator);
        //     return back()->withInput()->withErrors($validator);

        // }

        $kots = Kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
            ->where('service_id', $request->checkin_voucher_no)
            ->where('status', '0');

        if ($kots->exists()) {  // Use exists() instead of isExist()
            $kots->update([
                'status' => $request->voucher_no,
                'ready_to_serve' => 'direct_checkout'
            ]);
        }



        $guest_detail = account::where('firm_id', Auth::user()->firm_id)
            ->where('id', $request->amt_post_credit_id)->first();

        $guest_gst_code = $guest_detail->gst_code;
        $comp_detail = componyinfo::where('firm_id', Auth::user()->firm_id)->first();
        $comp_gst_code = $comp_detail->cominfo_field1;
        $make_all_bill_local_gst = $comp_detail->make_all_bill_local_gst;




        $date_variable = $request->checkin_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_checkin_date = $parsed_date->format('Y-m-d');
        $validatedData['checkin_date'] = $formatted_checkin_date;

        $date_variable2 = $request->checkout_date;
        $parsed_date2 = Carbon::createFromFormat('d-m-Y', $date_variable2);
        $formatted_checkout_date = $parsed_date2->format('Y-m-d');
        $validatedData['checkout_date'] = $formatted_checkout_date;

                       $fy_start_date = $this->fy_start_date;
                    $fy_end_date = $this->fy_end_date;
                    $financialyeardata=$this->financialyeardata;
                    if ($financialyeardata && 
    $formatted_checkout_date < $fy_start_date || 
    $formatted_checkout_date > $fy_end_date) {

return view('error.checkdate_on_fy',compact('fy_start_date','fy_end_date'));

}



        $checkout_room_ids = $request->room_checkout_id;
        $checkin_voucher_no = $request->checkin_voucher_no;

        // Update all RoomCheckin records with the given voucher_no
        $checkinUpdated = RoomCheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $checkin_voucher_no)
            ->update([
                'checkout_voucher_no' => $request->voucher_no,
                'checkinaf9' => $formatted_checkout_date
            ]);


        $checkout = new roomcheckout;
        $checkout->firm_id = Auth::user()->firm_id;

        $checkout->voucher_no = $request->voucher_no;
        $checkout->check_out_no = $request->check_out_no;
        $checkout->checkin_date = $formatted_checkin_date;
        $checkout->checkin_time = $request->checkin_time;
        $checkout->checkout_date = $formatted_checkout_date;
        $checkout->check_out_time = $request->check_out_time;
        $checkout->calculation_type = $request->calculation_type;
        $checkout->per_day_tariff = $request->per_day_tariff;
        $checkout->no_of_days = $request->no_of_days;
        $checkout->total_room_rent = $request->total_room_rent;
        $checkout->gst_id = $request->gst_id;
        $checkout->gst_total = $request->gst_total;
        // dd($guest_gst_code);
        if ($guest_gst_code === $comp_gst_code || empty($guest_gst_code) || $make_all_bill_local_gst == 1) {
            // If guest GST code matches company GST code, or guest GST code is empty/null
            $checkout->sgst = $request->gst_total / 2;
            $checkout->cgst = $request->gst_total / 2;
            $checkout->igst = 0; // Optional: reset IGST
        } else {
            // Otherwise, apply IGST
            $checkout->sgst = 0; // Optional: reset SGST
            $checkout->cgst = 0; // Optional: reset CGST
            $checkout->igst = $request->gst_total;
        }

        $checkout->final_room_rent = $request->total_room_rent + $request->gst_total;
        $checkout->total_food_amt = $request->total_food_amt;
        $checkout->other_charge = $request->add_other;
        $checkout->discount = $request->less_discount;
        $checkout->total_billamount = $request->bill_amount;
        $checkout->total_advance = $request->total_advance;
        $checkout->balance_to_pay = $request->balance_to_pay;
        $checkout->guest_name = $request->guest_name;
        $checkout->guest_mobile = $request->guest_mobile;
        // $checkout->posting_acc_id="0";
        $checkout->voucher_posting_amt = $request->total_receipt_amt;
        $checkout->checkin_voucher_no = $request->checkin_voucher_no;
        $checkout->amt_post_credit_amt = $request->amt_post_credit_amt;
        $checkout->amt_post_credit_id = $request->amt_post_credit_id;
        $checkout->account_id = $request->account_id;
        $checkout->bill_type = $request->bill_type;
        $checkout->userid = Auth::user()->id;
        $checkout->username = Auth::user()->name;



        $roomIds = [];
        $roomNos = [];
        foreach ($checkout_room_ids as $room_checkout_id) {
            $roomdetails = Room::where('firm_id', Auth::user()->firm_id)
                ->where('id', $room_checkout_id)->first();
            if ($roomdetails) {
                // Add room ID and room number to arrays
                $roomIds[] = $room_checkout_id;
                $roomNos[] = $roomdetails->room_no;

                // Update room status to 'dirty'
                Room::where('firm_id', Auth::user()->firm_id)
                    ->where('id', $room_checkout_id)->update(['room_status' => 'dirty']);
            }
        }
        $checkout->room_id = implode(',', $roomIds);
        $checkout->room_no = implode(',', $roomNos);



        $checkout->save();
        $posting_acc_id = $request->posting_acc_id;
        $voucher_posting_amt = $request->voucher_posting_amt;
        $amt_post_credit_id = $request->amt_post_credit_id;
        $amt_post_credit_amt = $request->amt_post_credit_amt;

        if ($posting_acc_id > 0 || $voucher_posting_amt != 0) {
            // $a="this is account posting on bank ";
            $this->post_amount($request);
        }
        if ($amt_post_credit_amt > 0 || $amt_post_credit_amt != Null) {
            $this->post_amount_credit($request);
            // $b="this is account posting on bank ";
        }
        //    return $a." ---- ".$b;

        $this->sale_post_amount($request);


        $guest_mobile = $request->guest_mobile;
        $guest_detail = account::where('firm_id', Auth::user()->firm_id)
            ->where('mobile', $guest_mobile)->first();


        $voucher_no = $request->voucher_no;
        $roomcheckouts = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('voucher_no', $voucher_no)->first();
        $checkinDate = Carbon::parse($roomcheckouts->checkin_date);
        $checkoutDate = Carbon::parse($roomcheckouts->checkout_date);
        $totaldays = $checkinDate->diffInDays($checkoutDate);
        // $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->get();
        $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Check_out')
            ->orderBy('updated_at', 'desc')
            ->get();
        $method_type = "Check_out_store";
        $voucher_no = $request->voucher_no;
        $this->sendCheckOutWhatsapp($method_type, $voucher_no);

        //         $mobile = $request->guest_mobile;
// $message = urlencode("Thank you for staying with us! Your checkout is completed. Voucher No: " . $request->voucher_no . " - Data House  technologyy");

        // $whatsapp_url = "https://wapp.powerstext.in/http-tokenkeyapi.php?authentic-key=393444617461486f7573653130301747389187&route=1&number=$mobile&message=$message";

        // try {
//     $response = Http::get($whatsapp_url);
// } catch (\Exception $e) {
//     Log::error('WhatsApp sending failed: ' . $e->getMessage());
// }



        return view('entery.room.checkout.room_checkout_print_select', compact('voucher_no', 'fromtlist'));


    }





    // show ledger
    public function ledger_show(Request $request, $id)
    {
        $roomcheckins = roomcheckin::withinFY('checkin_date')->where('voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)->first();

        $account_id = $roomcheckins->account_id;



        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $ledgers = ledger::withinFY('entry_date')->where('account_id', $account_id)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();


        $accounts = Account::orderBy('account_name', 'asc')
            ->where('firm_id', Auth::user()->firm_id)
            ->get();


        $account_name = account::where('id', $account_id)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();

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
    public function ledger_show_edit($id)
    {
        $roomcheckins = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)->first();

        $account_id = $roomcheckins->account_id;



        // $from_date = $request->from_date;
        // $to_date = $request->to_date;
        $ledgers = ledger::withinFY('entry_date')->where('account_id', $account_id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('transaction_type', '!=', 'Check_Out')
            ->where('transaction_type', '!=', 'Room_Checkout')
            ->where('transaction_type', '!=', 'Advance_Receipt')
            ->get();




        $accounts = Account::orderBy('account_name', 'asc')
            ->where('firm_id', Auth::user()->firm_id)
            ->get();


        $account_name = account::where('id', $account_id)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();

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
    //show checkin when select checkin no 
    public function show_checkin(Request $request, $id)
    {



        $roomcheckins = roomcheckin::withinFY('checkin_date')->with('room')
            ->where('voucher_no', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();

            $package_id=$roomcheckins->first()->package_id;
       
            $packagedata=Package::where('id',$package_id)->first();
        $package_name=$packagedata->package_name;

        // $account_id=$roomcheckins->account_id;
        $ledgerData = $this->ledger_show($request, $id);

        if ($roomcheckins->isNotEmpty()) {
            // Extract the first record's details
            $firstRecord = $roomcheckins->first();
            $gst_percent = $firstRecord->room->roomtype->gstmaster;

            $account_id = $firstRecord->account_id;
            $data = $firstRecord->toArray();
            $account_detail = account::where('id', $account_id)
                ->where('firm_id', Auth::user()->firm_id)->first();


            // Extract room numbers into an array
            $roomNos = $roomcheckins->pluck('room_no')->toArray();

            // Remove room_no from the first record's data to avoid duplication
            unset($data['room_no']);

            $checkout_record = roomcheckout::withinFY('checkout_date')->where('bill_type', 'Check_out')
                ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

                ->where('firm_id', Auth::user()->firm_id)
                ->whereBetween('checkout_date', [$this->fy_start_date, $this->fy_end_date])

                ->count();
            if ($checkout_record > 0) {
                // $lastRecord = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
                //     ->where('bill_type', 'Check_out')->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();

                $lastRecord = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
                    ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

                    ->where('bill_type', 'Check_out')
                    ->whereBetween('checkout_date', [$this->fy_start_date, $this->fy_end_date])
                    ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
                    ->first();

                $voucher_no = $lastRecord->voucher_no;
                $new_voucher_no = $voucher_no + 1;
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_type_name', 'Check_Out')->first();
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;
                $bill_type = $voucher_type->voucher_type_name;

            } else {
                $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_type_name', 'Check_Out')->first();

                $voucher_no = $voucher_type->numbring_start_from;
                $new_voucher_no = $voucher_no + 1;
                $voucher_prefix = $voucher_type->voucher_prefix;
                $voucher_suffix = $voucher_type->voucher_suffix;
                $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;
                $bill_type = $voucher_type->voucher_type_name;

            }

            $kots = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                ->where('service_id', $id)
                ->where('status', '0')
                ->select('total_amount', 'total_qty', 'voucher_no', 'bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
                ->groupBy('voucher_no', 'total_amount', 'total_qty', 'bill_no', 'service_id', 'status', 'user_id', 'voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
                ->get();



            if ($kots->count() > 0) {
                return '
    <div style="text-align:center; margin-top:50px; font-family:sans-serif;">
        <h1 style="color:red;">Room KOTs are pending, please generate Food Bill before Checkout.</h1>
        <h2 style="color:blue;">रूम का KOT पेंडिंग है, पहले फूड बिल बनाएं फिर चेकआउट करें।</h2>
        <br>
        <button onclick="history.back()" style="padding:10px 20px; font-size:16px; background-color:black; color:white; border:none; border-radius:5px; cursor:pointer;">
            🔙 Back / वापस जाएं
        </button>
    </div>
    ';
            }


            $foodbills = foodbill::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                ->where('service_id', $id)
                ->where('status', '0')
                ->select('net_food_bill_amount', 'total_bill_value', 'kot_no', 'total_qty', 'voucher_no', 'food_bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
                ->groupBy('net_food_bill_amount', 'voucher_no', 'kot_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
                ->get();



            $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
                ->whereHas('accountGroup', function ($query) {
                    $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
                })
                ->get();

            $businesssettings = businesssetting::where('firm_id', Auth::user()->firm_id)->first();
            $calculation_type = $businesssettings->calculation_type;

            // Pass all data except room_no and room_nos separately
            return view('entery.room.checkout.room_checkout_after_checkin', ['calculation_type' => $calculation_type, 'roomcheckins' => $roomcheckins, 'account_detail' => $account_detail, 'gst_percent' => $gst_percent, 'data' => $data, 'roomNos' => $roomNos, 'new_bill_no' => $new_bill_no, 'new_voucher_no' => $new_voucher_no, 'kots' => $kots, 'foodbills' => $foodbills, 'paymentmodes' => $paymentmodes, 'final_opning_balance' => $ledgerData['final_opning_balance'],'package_name'=> $package_name, 'bill_type' => $bill_type],);
            // dd( ['data' => $data, 'roomNos' => $roomNos]);
        } else {
            // Handle the case when no records are found
            return view('your_view_name', ['data' => [], 'roomNos' => []]);
        }
    }

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
            $businesssettings = businesssetting::where('firm_id', Auth::user()->firm_id)->first();
            $standard_checkout_time = $businesssettings->standard_checkout_time;

            switch ($calculation_type) {
                case '24hour':
                    $total_hours = ($interval->days * 24) + $interval->h + ($interval->i / 60);
                    $no_of_days = ceil($total_hours / 24);
                    break;

                case '12hour':
                    // Standard checkout time for calculations
                    $standard_time = new \DateTime($checkin_date->format('Y-m-d') . ' ' . $standard_checkout_time);

                    // Adjust standard checkout time for check-in date
                    if ($checkin_date > $standard_time) {
                        $standard_time->modify('+1 day');
                    }

                    $no_of_days = 1; // Start with the first day

                    while ($standard_time < $checkout_date) {
                        $no_of_days++;
                        $standard_time->modify('+1 day');
                    }
                    break;

                case 'hourly':
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
                                'rent' => $per_day_tariff,
                                'total' => $per_day_tariff * ($i + 1)
                            ];
                        } elseif ($i == $no_of_days - 1) {
                            // Last day entry
                            $day_entries[] = [
                                'day_count' => 1,
                                'checkin_date' => Carbon::parse($current_date_time)->format('Y-m-d') . ' ' . Carbon::parse($standard_checkout_time)->format('H:i:s'),
                                'checkout_date' => $checkout_date->format('Y-m-d H:i:s'),
                                'rent' => $per_day_tariff,
                                'total' => $per_day_tariff * ($i + 1)
                            ];
                        } else {
                            // Middle days
                            $day_entries[] = [
                                'day_count' => 1,
                                'checkin_date' => $current_date_time->format('Y-m-d 11:00:00'),
                                'checkout_date' => $end_date_time->format('Y-m-d 11:00:00'),
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
                'day_entries' => $day_entries,
                'standard_checkout_time' => $standard_checkout_time
            ]);
        }
    }


    public function destroy(string $id)
    {

        $method_type = "Check_out_delete";
        $voucher_no = $id;


        $this->sendCheckOutWhatsapp($method_type, $voucher_no);
        $roomcheckout = roomcheckout::withinFY('checkout_date')->where('firm_id', Auth::user()->firm_id)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->where('voucher_no', $id);
        // $roomcheckin=roomcheckin::whare('checkout_voucher_no',$id)->get();
        $roomsdetails = RoomCheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
            ->where('checkout_voucher_no', $id)->get();



        // Check if the roomcheckout exists
        if ($roomcheckout) {

            foreach ($roomsdetails as $roomdetail) {
                $room_id = $roomdetail->room_id;
                Room::where('firm_id', Auth::user()->firm_id)
                    ->where('id', $room_id)->update(['room_status' => 'occupied']);
            }


            // Delete the roomcheckout
            $roomcheckout->delete();
            $checkinUpdated = RoomCheckin::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
                ->where('checkout_voucher_no', $id)
                ->update(['checkout_voucher_no' => '0']);
            $ledger = ledger::withinFY('entry_date')->where('firm_id', Auth::user()->firm_id)
                ->where('transaction_type', 'Check_Out')
                ->where('voucher_no', $id);
            if ($ledger) {
                // Update the room status to "vacant"

                $ledger->delete();
            }
            $ledger_sale = ledger::withinFY('entry_date')->where('firm_id', Auth::user()->firm_id)
                ->where('transaction_type', 'Room_Checkout')
                ->where('voucher_no', $id);
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


    public function post_amount(Request $request)
    {
        $posting_acc_ids = $request->posting_acc_id;  // Array of account IDs
        $booking_amounts = $request->booking_amount;  // Array of amounts
        $checkout_room_ids = $request->room_checkout_id;
        $roomIds = [];
        $roomNos = [];
        foreach ($checkout_room_ids as $room_checkout_id) {
            $roomdetails = Room::where('firm_id', Auth::user()->firm_id)
                ->where('id', $room_checkout_id)->first();
            if ($roomdetails) {
                // Add room ID and room number to arrays
                $roomIds[] = $room_checkout_id;
                $roomNos[] = $roomdetails->room_no;

                // Update room status to 'dirty'
                Room::where('firm_id', Auth::user()->firm_id)
                    ->where('id', $room_checkout_id)->update(['room_status' => 'dirty']);
            }
        }



        // Check if the arrays are set and contain values
        if (is_array($posting_acc_ids) && is_array($booking_amounts) && count($posting_acc_ids) > 0 && count($booking_amounts) > 0) {

            $date_variable = $request->checkout_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_entry_date = $parsed_date->format('Y-m-d');

            // Get the account name details using the guest's mobile number
            $accountname = account::where('firm_id', Auth::user()->firm_id)
                ->with('accountgroup')
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


                    // Credit ledger entry
                    $ledger = new ledger;
                    $ledger->firm_id = Auth::user()->firm_id;
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
                    $ledger->credit = $booking_amount;
                    $ledger->amount = $booking_amount;
                    $ledger->remark = $request->bill_type . "/" . $request->check_out_no . "/Room-" . implode(',', $roomNos);
                    $ledger->tran_voucher_no = $request->voucher_no;
                    $ledger->simpal_amount = "-" . $booking_amount;
                    $ledger->userid = Auth::user()->id;
                    $ledger->username = Auth::user()->name;

                    $ledger->save();

                    // Debit ledger entry
                    $ledger = new ledger;
                    $ledger->firm_id = Auth::user()->firm_id;
                    $ledger->voucher_no = $request->voucher_no;
                    $ledger->reciept_no = $request->check_out_no;
                    ;
                    $ledger->entry_date = $formatted_entry_date;
                    $ledger->transaction_type = 'Check_Out';
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
                    $ledger->remark = $request->bill_type . "/" . $request->check_out_no . "/Room-" . implode(',', $roomNos);
                    $ledger->tran_voucher_no = $request->voucher_no;
                    $ledger->simpal_amount = "+" . $booking_amount;
                    $ledger->userid = Auth::user()->id;
                    $ledger->username = Auth::user()->name;
                    $ledger->save();
                }
            }
        }
    }

    public function sale_post_amount(Request $request)
    {
        $posting_acc_id = $request->amt_post_credit_id;
        $bill_amount = $request->bill_amount;
        $checkout_room_ids = $request->room_checkout_id;
        $roomIds = [];
        $roomNos = [];
        foreach ($checkout_room_ids as $room_checkout_id) {
            $roomdetails = Room::where('firm_id', Auth::user()->firm_id)
                ->where('id', $room_checkout_id)->first();
            if ($roomdetails) {
                // Add room ID and room number to arrays
                $roomIds[] = $room_checkout_id;
                $roomNos[] = $roomdetails->room_no;

                // Update room status to 'dirty'
                Room::where('firm_id', Auth::user()->firm_id)
                    ->where('id', $room_checkout_id)->update(['room_status' => 'dirty']);
            }
        }
        if ($posting_acc_id > 0 | $bill_amount > 0) {


            $date_variable = $request->checkout_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_entry_date = $parsed_date->format('Y-m-d');
            $paymentmode = account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('mobile', $request->guest_mobile)->first();
            $accountname = account::with('accountgroup')
                ->where('firm_id', Auth::user()->firm_id)
                ->where('account_name', 'Room_Checkout')->first();

            $ledger = new ledger;
            $ledger->firm_id = Auth::user()->firm_id;
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
            $ledger->remark = "Room_Checkout/" . $request->check_out_no . "Room-" . implode(',', $roomNos);
            $ledger->simpal_amount = "-" . $request->bill_amount;
            $ledger->userid = Auth::user()->id;
            $ledger->username = Auth::user()->name;
            //post_amt -  this amount post on 
            $ledger->save();


            $ledger = new ledger;
            $ledger->firm_id = Auth::user()->firm_id;
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
            $ledger->remark = "Room_Checkout/" . $request->check_out_no;
            $ledger->simpal_amount = "+" . $request->bill_amount;
            $ledger->userid = Auth::user()->id;
            $ledger->username = Auth::user()->name;
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
                ->where('mobile', $request->guest_mobile)
                ->where('firm_id', Auth::user()->firm_id)->first();
            $paymentmode = account::with('accountgroup')
                ->where('id', $request->amt_post_credit_id)
                ->where('firm_id', Auth::user()->firm_id)->first();



        }
    }

    public function My_Check_out()
    {
        //this function only send bill voucher no  and voucher type through ajex 
        $checkout_record = roomcheckout::withinFY('checkout_date')->where('bill_type', 'My_Check_out')->where('firm_id', Auth::user()->firm_id)
            ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

            ->count();
        if ($checkout_record > 0) {
            $lastRecord = roomcheckout::withinFY('checkout_date')->where('bill_type', 'My_Check_out')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
                ->whereBetween('roomcheckouts.checkout_date', [$this->fy_start_date, $this->fy_end_date]) // 👈 Filter by financial year    

                ->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('voucher_type_name', 'My_Check_out')->where('firm_id', Auth::user()->firm_id)->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;
            $bill_type = $voucher_type->voucher_type_name;

        } else {
            $voucher_type = voucher_type::where('voucher_type_name', 'My_Check_out')
                ->where('firm_id', Auth::user()->firm_id)->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;
            $bill_type = $voucher_type->voucher_type_name;

        }

        return response()->json([
            'new_bill_no' => $new_bill_no,
            'new_voucher_no' => $new_voucher_no,
            'bill_type' => $bill_type
        ]);
    }



}
