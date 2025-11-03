<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
use App\Models\table;
use App\Models\account;
use App\Models\tempentry;
use App\Models\roomcheckin;
use App\Models\roomservice;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\compinfofooter;
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

        $kots = Kot::where('kots.status', '0')
            ->leftJoin('roomcheckins', function ($join) {
                $join->on('kots.service_id', '=', 'roomcheckins.voucher_no')
                    ->whereColumn('roomcheckins.firm_id', 'kots.firm_id') // Ensure firm_id matches
                    ->where('kots.voucher_type', 'Kot'); // Ensuring join applies only to 'Kot' type
            })
            ->leftJoin('vouchers', function ($join) {
                $join->on('kots.voucher_no', '=', 'vouchers.voucher_no')
                    ->whereColumn('kots.firm_id', 'vouchers.firm_id'); // Ensuring firm_id matches
            })
            ->select(
                'kots.voucher_type',
                'kots.total_amount',
                'kots.total_qty',
                'kots.voucher_no',
                'kots.bill_no',
                'kots.service_id',
                'kots.voucher_date',
                'kots.status',
                'kots.user_id',
                'kots.voucher_date',
                'kots.ready_to_serve',
                'vouchers.voucher_remark', // Example column from vouchers
                'vouchers.voucher_terms',  // Example column from vouchers
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN roomcheckins.firm_id = kots.firm_id THEN roomcheckins.room_no END ORDER BY roomcheckins.room_no SEPARATOR ",") as room_nos'), // Collect only room numbers for the auth firm_id
                DB::raw('GROUP_CONCAT(DISTINCT kots.voucher_no ORDER BY kots.voucher_date SEPARATOR ",") as kot_voucher_nos') // Collect voucher numbers
            )
            ->groupBy(
                'kots.voucher_type',
                'kots.voucher_no',
                'kots.total_amount',
                'kots.total_qty',
                'kots.bill_no',
                'kots.service_id',
                'kots.status',
                'kots.user_id',
                'kots.voucher_date',
                'kots.ready_to_serve',
                'vouchers.voucher_remark', // Add vouchers columns to groupBy
                'vouchers.voucher_terms'
            )
            ->withinFY('kots.voucher_date')
            ->where('kots.firm_id', Auth::user()->firm_id) // Ensure firm_id matches for kots
            ->where('kots.voucher_type', 'Kot')
            ->orderByRaw('CAST(kots.voucher_no AS UNSIGNED) DESC')
            ->get();

        return view('entery.roomservice.kot.kot_index', compact('kots'));
    }




    // 
    public function kots_cleared($kot_type)
    {


        $kots = Kot::withinFY('voucher_date')->where('status', '!=', '0')
            ->select('voucher_type', 'total_amount', 'total_qty', 'voucher_no', 'bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
            ->groupBy('voucher_type', 'voucher_no', 'total_amount', 'total_qty', 'bill_no', 'service_id', 'status', 'user_id', 'voucher_date')  // Ensure groupBy includes all non-aggregated selected columns
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_type', $kot_type)

            ->orderBy('voucher_date', 'desc')

            ->get();

        // return $kots;
        return view('entery.roomservice.kot.kot_index', compact('kots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $id = Auth::user()->id;

        $tempEntry = tempentry::where('firm_id', Auth::user()->firm_id)
        ->where('user_id', $id)
        ->exists();

   if ($tempEntry) {
    $clearUrl = url('temp_item_delete/' . Auth::user()->id);

    return response('
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">
            <h1 style="color: red; text-align: center; margin-bottom: 20px;">
                Already KOT Created from Another Device or Tab Using the Same User ID
            </h1>
            <button onclick="window.history.back()" style="padding: 10px 20px; font-size: 16px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Go Back
            </button>
            <a href="' . $clearUrl . '" style="margin-top: 20px; padding: 10px 20px; font-size: 16px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">
                Clear All Entry
            </a>
        </div>
    ', 403);
}
        $this->temp_item_delete($id);

        $kot_record = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->count();
        if ($kot_record > 0) {
            $lastRecord = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
                ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no = $voucher_no + 1;
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Kot')->first();
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        } else {
            $voucher_type = voucher_type::where('firm_id', Auth::user()->firm_id)
                ->where('voucher_type_name', 'Kot')->first();

            $voucher_no = $voucher_type->numbring_start_from;
            $new_voucher_no = $voucher_no + 1;
            $voucher_prefix = $voucher_type->voucher_prefix;
            $voucher_suffix = $voucher_type->voucher_suffix;
            $new_bill_no = $voucher_prefix . "" . $new_voucher_no . "" . $voucher_suffix;

        }

        $checkinlists = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
            ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'voucher_no')
            ->where('firm_id', Auth::user()->firm_id)
            ->get();

        $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
        // $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();
        $itemdata = Item::where('firm_id', Auth::user()->firm_id)
    ->whereHas('itemgroup', function ($query) {
        $query->where('head_group', '!=', 'Raw_Material');
    })
    ->get();


        return view('entery.roomservice.room_kot', compact('new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata'));

    }
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'item_id' => 'required',
            'item_qty' => 'required',
            'item_rate' => 'required',
            'item_amount' => 'required',
            'user_id' => 'required',
            'voucher_no' => 'required',
            'voucher_date' => 'required',
            'user_name' => 'required',
            'service_id' => 'required',


        ]);
        //     $compinfofooter=compinfofooter::where('firm_id',Auth::user()->firm_id)->first();
        //    $inclusive= $compinfofooter->ct6;
        if ($validator->passes()) {
            $item = item::where('id', $request->item_id)
                ->where('firm_id', Auth::user()->firm_id)->firstOrFail();
            $itemName = $item->item_name;
            // format entery date 
            $date_variable = $request->voucher_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_voucher_date = $parsed_date->format('Y-m-d');

            
            //storing data 
            $tempkot = new tempentry;
            $tempkot->firm_id = Auth::user()->firm_id;
            $tempkot->user_id = $request->user_id;
            $tempkot->user_name = $request->user_name;
            $tempkot->entry_date = now();
            $tempkot->voucher_date = $formatted_voucher_date;
            $tempkot->voucher_no = $request->voucher_no;
            $tempkot->voucher_type = $request->voucher_type;
            $tempkot->bill_no = $request->kot_no;
            $tempkot->item_id = $request->item_id;
            $tempkot->item_name = $itemName;
            $tempkot->qty = $request->item_qty;
            $tempkot->temp_af4 = $request->kot_remark;

            $item = item::where('id', $request->item_id)->first();
            $itemgstpercent = $item->gstmaster->igst;
            $gstbase = $itemgstpercent + 100;

            $compinfo = compinfofooter::where('firm_id', Auth::user()->firm_id)->first();
            $taxinclusive_status = $compinfo->ct6;

            if ($taxinclusive_status == 1) {
                $tempkot->rate = ($request->item_rate / $gstbase) * 100;


            } else {
                $tempkot->rate = $request->item_rate;
            }




            $tempkot->amount = $request->item_amount;
            $tempkot->sale_to_voucher_no = $request->service_id;
            $tempkot->temp_af1 = $request->checkin_time;   //store kot creation time
            $tempkot->save();
            $itemName = "test item ";
            return response()->json([
                'message' => 'I am ready to save through AJAX  hariom ji ' . $taxinclusive_status,
                'status' => 200,
            ]);
        } else {
            $itemName = "test item ";
            return response()->json([

                'message' => 'Bad Request. Check Your Input' . $itemName,
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }
    }


    public function store3(Request $request)
    {
        //store temprary data orignal  

        $validator = validator::make($request->all(), [
            'item_id' => 'required',
            'item_qty' => 'required',
            'item_rate' => 'required',
            'item_amount' => 'required',
            'user_id' => 'required',
            'voucher_no' => 'required',
            'voucher_date' => 'required',
            'user_name' => 'required',
            'service_id' => 'required',


        ]);

        if ($validator->passes()) {

            //geting item name 
            $item = item::where('id', $request->item_id)->firstOrFail();
            $itemName = $item->item_name;
            // format entery date 
            $date_variable = $request->voucher_date;
            $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
            $formatted_voucher_date = $parsed_date->format('Y-m-d');
            //storing data 
            $tempkot = new tempentry;
            $tempkot->user_id = $request->user_id;
            $tempkot->user_name = $request->user_name;
            $tempkot->entry_date = now();
            $tempkot->voucher_date = $formatted_voucher_date;
            $tempkot->voucher_no = $request->voucher_no;
            $tempkot->voucher_type = $request->voucher_type;
            $tempkot->bill_no = $request->kot_no;
            $tempkot->item_id = $request->item_id;
            $tempkot->item_name = $itemName;
            $tempkot->qty = $request->item_qty;
            $tempkot->rate = $request->item_rate;
            $tempkot->amount = $request->item_amount;
            $tempkot->sale_to_voucher_no = $request->service_id;

            $tempkot->save();



            return response()->json([
                'message' => 'Record Save Successfully  ' . $itemName,
                'status' => 200,
            ]);
        } else {
            $itemName = "test item ";
            return response()->json([
                'message' => 'Bad Request. Check Your Input' . $itemName,
                'status' => 400,
                'errors' => $validator->errors(),
            ]);

        }


    }

    public function store_toKot($id,$voucher_no)
    {  
        
        $lastRecord = kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')->where('voucher_no', $voucher_no)->first();
        if ($lastRecord) {

            $inc_voucher_no = (int) $lastRecord->voucher_no + 1;


            $tempkots = tempentry::where('user_id', $id)
                ->where('firm_id', Auth::user()->firm_id)->get();
       
            $tempkots_first = tempentry::where('user_id', $id)
                ->where('firm_id', Auth::user()->firm_id)->first();
            $store_time = $tempkots_first->temp_af1;
         

            if ($tempkots->count()) {
                $totalQty = $tempkots->sum('qty');
                $totalAmount = $tempkots->sum('amount');
                

                foreach ($tempkots as $tempkot) {
                    $kot = new kot;
                    $kot->firm_id = Auth::user()->firm_id;
                    $kot->entry_date = $tempkot->entry_date;
                    $kot->voucher_no = $inc_voucher_no;
                    $kot->voucher_date = $tempkot->voucher_date;
                    $kot->voucher_type = $tempkot->voucher_type;
                    $kot->bill_no = $inc_voucher_no;
                    $kot->user_id = $tempkot->user_id;
                    $kot->user_name = $tempkot->user_name;
                    $kot->item_id = $tempkot->item_id;
                    $kot->item_name = $tempkot->item_name;
                    $kot->qty = $tempkot->qty;
                    $kot->rate = $tempkot->rate;
                    $kot->amount = $tempkot->amount;
                    $kot->total_qty = $totalQty;
                    $kot->total_amount = $totalAmount;
                    $kot->kot_remark = $tempkot->temp_af4;
                    $kot->service_id = $tempkot->sale_to_voucher_no;
                    $kot->ready_to_serve='Unprinted';
                    $date = $tempkot->entry_date; // Assuming this is in 'Y-m-d' format
                    $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
                    $kot->created_at = "$date $time";
                    $kot->save();
                }
                $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
                $tempkots_delete->delete();

                $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $inc_voucher_no)
                    ->get();
                $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $inc_voucher_no)
                    ->first();
 

                $guest_detail = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
                    ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'voucher_no')
                    ->where('voucher_no', $kot_header->service_id)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->first();
                if ($guest_detail === null) {

                    $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
                    $table_name = $tabledata->table_name;
                    $table_group = $tabledata->table_group;

                    if ($table_group == "Nc") {
                        kot::withinFY('voucher_date')->where('user_id', $id)
                            ->where('firm_id', Auth::user()->firm_id)
                            ->where('voucher_no', $tempkots_first->voucher_no)
                            ->update(['status' => 'Nc']);
                    }


                } else {
                    $table_name = Null;
                }


return redirect('/room_dashboard')->with('message', 'Records saved successfully.');
            } else {
                return back()->with('error', 'Nothing  To Save  ');
            }

        } else {



            $tempkots = tempentry::where('user_id', $id)
                ->where('firm_id', Auth::user()->firm_id)->get();
            $tempkots_first = tempentry::where('user_id', $id)
                ->where('firm_id', Auth::user()->firm_id)->first();
            $store_time = $tempkots_first->temp_af1;

            if ($tempkots->count()) {
                $totalQty = $tempkots->sum('qty');
                $totalAmount = $tempkots->sum('amount');

                foreach ($tempkots as $tempkot) {
                    $kot = new kot;
                    $kot->firm_id = Auth::user()->firm_id;
                    $kot->entry_date = $tempkot->entry_date;
                    $kot->voucher_no = $tempkot->voucher_no;
                    $kot->voucher_date = $tempkot->voucher_date;
                    $kot->voucher_type = $tempkot->voucher_type;
                    $kot->bill_no = $tempkot->bill_no;
                    $kot->user_id = $tempkot->user_id;
                    $kot->user_name = $tempkot->user_name;
                    $kot->item_id = $tempkot->item_id;
                    $kot->item_name = $tempkot->item_name;
                    $kot->qty = $tempkot->qty;
                    $kot->rate = $tempkot->rate;
                    $kot->amount = $tempkot->amount;
                    $kot->total_qty = $totalQty;
                    $kot->total_amount = $totalAmount;
                    $kot->kot_remark = $tempkot->temp_af4;
                    $kot->service_id = $tempkot->sale_to_voucher_no;
                    $kot->ready_to_serve='Unprinted';
                    $date = $tempkot->entry_date; // Assuming this is in 'Y-m-d' format
                    $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
                    $kot->created_at = "$date $time";
                    $kot->save();
                }
                $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
                $tempkots_delete->delete();

                $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $tempkots_first->voucher_no)
                    ->get();
                $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $tempkots_first->voucher_no)
                    ->first();



                $guest_detail = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
                    ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'voucher_no')
                    ->where('voucher_no', $kot_header->service_id)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->first();
                if ($guest_detail === null) {

                    $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
                    $table_name = $tabledata->table_name;
                    $table_group = $tabledata->table_group;

                    if ($table_group == "Nc") {
                        kot::withinFY('voucher_date')->where('user_id', $id)
                            ->where('firm_id', Auth::user()->firm_id)
                            ->where('voucher_no', $tempkots_first->voucher_no)
                            ->update(['status' => 'Nc']);
                    }


                } else {
                    $table_name = Null;
                }


return redirect('/room_dashboard')->with('message', 'Records saved successfully.');

            } else {
                return back()->with('error', 'Nothing  To Save  ');
            }

        }



    }

    public function store_and_print($id, $voucher_no)
    {
        
        $lastRecord = kot::withinFY('voucher_date')
        ->where('firm_id', Auth::user()->firm_id)
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->where('voucher_no', $voucher_no)
        ->first();
             
        // dd($hh);
        if ($lastRecord) {

            $inc_voucher_no = (int) $lastRecord->voucher_no + 1;

            $tempkots = tempentry::where('user_id', $id)->where('firm_id', Auth::user()->firm_id)->get();
            $tempkots_first = tempentry::where('user_id', $id)
                ->where('firm_id', Auth::user()->firm_id)->first();
            $store_time = $tempkots_first->temp_af1;

            if ($tempkots->count() > 0) {
                $totalQty = $tempkots->sum('qty');
                $totalAmount = $tempkots->sum('amount');
                foreach ($tempkots as $tempkot) {
                    $kot = new kot;
                    $kot->firm_id = Auth::user()->firm_id;
                    $kot->entry_date = $tempkot->entry_date;
                    $kot->voucher_no = $inc_voucher_no;
                    $kot->voucher_date = $tempkot->voucher_date;
                    $kot->voucher_type = $tempkot->voucher_type;
                    $kot->bill_no = $inc_voucher_no;
                    $kot->user_id = $tempkot->user_id;
                    $kot->user_name = $tempkot->user_name;
                    $kot->item_id = $tempkot->item_id;
                    $kot->item_name = $tempkot->item_name;
                    $kot->qty = $tempkot->qty;
                    $kot->rate = $tempkot->rate;
                    $kot->amount = $tempkot->amount;
                    $kot->total_qty = $totalQty;
                    $kot->total_amount = $totalAmount;
                    $kot->kot_remark = $tempkot->temp_af4;
                    $kot->service_id = $tempkot->sale_to_voucher_no;
                    $date = $tempkot->entry_date; // Assuming this is in 'Y-m-d' format
                    $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
                    $kot->created_at = "$date $time";
                    $kot->save();
                }
                $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
                $tempkots_delete->delete();
                $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $inc_voucher_no)
                    ->get();
                $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $inc_voucher_no)
                    ->first();


                $guest_detail = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
                    ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'voucher_no')
                    ->where('voucher_no', $kot_header->service_id)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->first();
                if ($guest_detail === null) {

                    $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
                    $table_name = $tabledata->table_name;
                    $table_group = $tabledata->table_group;

                    if ($table_group == "Nc") {
                        kot::withinFY('voucher_date')->where('user_id', $id)
                            ->where('firm_id', Auth::user()->firm_id)
                            ->where('voucher_no', $voucher_no)
                            ->update(['status' => 'Nc']);
                    }


                } else {
                    $table_name = Null;
                }


                return view('entery.roomservice.kot_print_view', compact('kot_to_print', 'kot_header', 'guest_detail', 'table_name'));
            } else {
                return back()->with('error', 'Nothing To Print  ');
            }


        } else {



            $tempkots = tempentry::where('user_id', $id)->where('firm_id', Auth::user()->firm_id)->get();
            $tempkots_first = tempentry::where('user_id', $id)
                ->where('firm_id', Auth::user()->firm_id)->first();
            $store_time = $tempkots_first->temp_af1;

            if ($tempkots->count() > 0) {
                $totalQty = $tempkots->sum('qty');
                $totalAmount = $tempkots->sum('amount');
                foreach ($tempkots as $tempkot) {
                    $kot = new kot;
                    $kot->firm_id = Auth::user()->firm_id;
                    $kot->entry_date = $tempkot->entry_date;
                    $kot->voucher_no = $tempkot->voucher_no;
                    $kot->voucher_date = $tempkot->voucher_date;
                    $kot->voucher_type = $tempkot->voucher_type;
                    $kot->bill_no = $tempkot->bill_no;
                    $kot->user_id = $tempkot->user_id;
                    $kot->user_name = $tempkot->user_name;
                    $kot->item_id = $tempkot->item_id;
                    $kot->item_name = $tempkot->item_name;
                    $kot->qty = $tempkot->qty;
                    $kot->rate = $tempkot->rate;
                    $kot->amount = $tempkot->amount;
                    $kot->total_qty = $totalQty;
                    $kot->total_amount = $totalAmount;
                    $kot->kot_remark = $tempkot->temp_af4;
                    $kot->service_id = $tempkot->sale_to_voucher_no;
                    $date = $tempkot->entry_date; // Assuming this is in 'Y-m-d' format
                    $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
                    $kot->created_at = "$date $time";
                    $kot->save();
                }
                $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
                $tempkots_delete->delete();
                $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $voucher_no)
                    ->get();
                $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                    ->where('voucher_no', $voucher_no)
                    ->first();


                $guest_detail = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
                    ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                    ->groupBy('guest_name', 'voucher_no')
                    ->where('voucher_no', $kot_header->service_id)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->first();
                if ($guest_detail === null) {

                    $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
                    $table_name = $tabledata->table_name;
                    $table_group = $tabledata->table_group;

                    if ($table_group == "Nc") {
                        kot::withinFY('voucher_date')->where('user_id', $id)
                            ->where('firm_id', Auth::user()->firm_id)
                            ->where('voucher_no', $voucher_no)
                            ->update(['status' => 'Nc']);
                    }


                } else {
                    $table_name = Null;
                }


                return view('entery.roomservice.kot_print_view', compact('kot_to_print', 'kot_header', 'guest_detail', 'table_name'));
            } else {
                return back()->with('error', 'Nothing To Print  ');
            }


        }
    }
    public function kot_print($id, $voucher_no)
    {


        $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)
            ->where('voucher_no', $voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();
         kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_no', $voucher_no)
    ->where('ready_to_serve', 'Unprinted')
    ->update(['ready_to_serve' => '0']);

        $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->first();

        $guest_detail = roomcheckin::select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'voucher_no')
            ->where('voucher_no', $kot_header->service_id)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();

        if ($guest_detail === null) {

            $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
            $table_name = $tabledata->table_name;

        } else {
            $table_name = Null;
        }

        return view('entery.roomservice.kot.kot_print', compact('kot_to_print', 'kot_header', 'guest_detail', 'table_name'));
    }
    public function kot_print_view($id, $voucher_no)
    {



        $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->get(); 
                     kot::withinFY('voucher_date')->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_no', $voucher_no)
    ->where('ready_to_serve', 'Unprinted')
    ->update(['ready_to_serve' => '0']);


        $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $voucher_no)
            ->first();
        $checkin_no = $kot_header->service_id;

        $guest_detail = roomcheckin::select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'voucher_no')
            ->where('voucher_no', $kot_header->service_id)
            ->where('firm_id', Auth::user()->firm_id)
            ->first();


        if ($guest_detail === null) {

            $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
            $table_name = $tabledata->table_name;

        } else {
            $table_name = Null;
        }


        return view('entery.roomservice.kot_print_view', compact('kot_to_print', 'kot_header', 'guest_detail', 'table_name'));
    }

    public function fetchItemRecords(string $id)
    {
        $user_id = $id;
        $itemrecords = tempentry::where('user_id', $user_id)
            ->where('firm_id', Auth::user()->firm_id)
            ->get();

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

        $kots = kot::withinFY('voucher_date')->where('voucher_no', $voucher_no)->where('firm_id', Auth::user()->firm_id)
            ->where('status', '0')
            ->where('voucher_type', 'Kot');
 ;



        if ($kots->count()) {
            $kots->delete();
            return back()->with('message', 'Record Deleteted ' . $voucher_no);
        } else {
            return back()->with('errors', 'Check Your Kot Converted on Bill So That We Can Not Delete It    ');
        }

    }
    public function temp_item_delete($id)
    {
        $user_id = $id;
        $itemrecords = tempentry::where('firm_id', Auth::user()->firm_id)
            ->where('user_id', $user_id);
        if ($itemrecords->count()) {
            $itemrecords->delete();
            return back()->with('message', 'Welcome on New Kot ');
        } else {
            return back()->with('message', 'Please Add Items   ');
        }




    }

    public function delete_kot_temprecord($recordValue)
    {
        // Search for the customer by contact number

        $tempitem_record = tempentry::where('id', $recordValue)->where('firm_id', Auth::user()->firm_id)
            ->first();

        if ($tempitem_record) {
            $tempitem_record->delete();

            return response()->json([
                'message' => '<p class="alart alart-success">Record Delete Sucessfully <p>'

            ]);
        } else {
            return response()->json([
                'message' => ' <p class="alart alart-danger">No Record Found<p>',
                'customer_info' => null
            ]);
        }
    }

    public function kot_edit($voucher_no)
    {
        $this->temp_item_delete(Auth::user()->id);
        $kots_items = kot::withinFY('voucher_date')->where('voucher_no', $voucher_no)
            ->where('voucher_type', 'kot')
            ->where('firm_id', Auth::user()->firm_id)
            ->get();
        $kot_firstrecord = $kots_items->first();
        $service_id = $kot_firstrecord->service_id;

        $checkinlists = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
            ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
            ->groupBy('guest_name', 'voucher_no')
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_no', $kot_firstrecord->service_id)
            ->first();
        if (!$checkinlists) {
            return "<span style='color: red; font-weight: bold;'>Please select a table KOT from the restaurant menu. This is not a room service KOT.</span>";

        }


        $tableid = $kot_firstrecord->service_id;
        $voucher_terms = $kot_firstrecord->voucher_terms;

        $new_bill_no = $kot_firstrecord->bill_no;
        $new_voucher_no = $voucher_no;
        $user_id = $kot_firstrecord->user_id;
        $this->temp_item_delete($user_id);

        foreach ($kots_items as $item) {
            $tempkot = new tempentry();
            $tempkot->firm_id = Auth::user()->firm_id;
            $tempkot->user_id = Auth::user()->id;
            $tempkot->user_name = Auth::user()->name;
            $tempkot->entry_date = now();
            $tempkot->voucher_date = $item->voucher_date;
            $tempkot->voucher_no = $item->voucher_no;
            $tempkot->voucher_type = $item->voucher_type;
            $tempkot->bill_no = $item->bill_no;
            $tempkot->sale_to_voucher_no = $tableid;
            $tempkot->item_id = $item->item_id;
            $tempkot->item_name = $item->item_name;
            $tempkot->qty = $item->qty;
            $tempkot->rate = $item->rate;
            $tempkot->dis_percent = $item->dis_percent ?? 0;
            $tempkot->dis_amt = $item->dis_amt ?? 0;
            $tempkot->total_discount = $item->total_discount ?? 0;
            $tempkot->item_gst_id = $item->gst_item_percent;
            $tempkot->total_gst = $item->gst_item_amount ?? 0;
            $tempkot->item_net_value = ($item->qty * $item->rate) + $item->gst_item_amount;
            $tempkot->customer_id = $item->account_id;

            $tempkot->item_gst_name = $item->gst_id; // GST ID from GST master

            $tempkot->amount = $item->qty * $item->rate;
            $tempkot->total_amount = ($item->qty * $item->rate) - ($item->total_discount ?? 0);

            // Store godown ID and account ID
            $tempkot->account_id = $item->account_id;
            $tempkot->temp_af1 = $item->created_at->format('H:i');


            // Save to the database
            $tempkot->save();
        }


        $id = Auth::user()->id;








        $accountdata = account::where('firm_id', Auth::user()->firm_id)->get();
        $itemdata = item::where('firm_id', Auth::user()->firm_id)->get();


        return view('entery.restaurant.room_kot_edit', compact('new_bill_no', 'new_voucher_no', 'checkinlists', 'accountdata', 'itemdata', 'service_id'));

    }



    public function kot_update($id)
    {

        $tempkots = tempentry::where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)->get();
        $tempkots_first = tempentry::where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $this->destroy($tempkots_first->voucher_no);
        $store_time = $tempkots_first->temp_af1;

        if ($tempkots->count()) {
            $totalQty = $tempkots->sum('qty');
            $totalAmount = $tempkots->sum('amount');

            foreach ($tempkots as $tempkot) {
                $kot = new kot;
                $kot->firm_id = Auth::user()->firm_id;
                $kot->entry_date = $tempkot->entry_date;
                $kot->voucher_no = $tempkot->voucher_no;
                $kot->voucher_date = $tempkot->voucher_date;
                $kot->voucher_type = $tempkot->voucher_type;
                $kot->bill_no = $tempkot->bill_no;
                $kot->user_id = $tempkot->user_id;
                $kot->user_name = $tempkot->user_name;
                $kot->item_id = $tempkot->item_id;
                $kot->item_name = $tempkot->item_name;
                $kot->qty = $tempkot->qty;
                $kot->rate = $tempkot->rate;
                $kot->amount = $tempkot->amount;
                $kot->total_qty = $totalQty;
                $kot->total_amount = $totalAmount;
                $kot->kot_remark = $tempkot->kot_remark;
                $kot->service_id = $tempkot->sale_to_voucher_no;
                $date = $tempkot->entry_date; // Assuming this is in 'Y-m-d' format
                $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
                $kot->created_at = "$date $time";
                $kot->save();
            }
            $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
            $tempkots_delete->delete();
            return redirect('kots')->with('message', 'Records Update Successfully');
        } else {
            return back()->with('error', 'Nothing  To Save  ');
        }



    }

    public function kot_update_print($id, $voucher_no)
    {
        $tempkots = tempentry::where('user_id', $id)->where('firm_id', Auth::user()->firm_id)->get();
        $tempkots_first = tempentry::where('user_id', $id)
            ->where('firm_id', Auth::user()->firm_id)->first();
        $this->destroy($tempkots_first->voucher_no);
        $store_time = $tempkots_first->temp_af1;

        if ($tempkots->count() > 0) {
            $totalQty = $tempkots->sum('qty');
            $totalAmount = $tempkots->sum('amount');
            foreach ($tempkots as $tempkot) {
                $kot = new kot;
                $kot->firm_id = Auth::user()->firm_id;
                $kot->entry_date = $tempkot->entry_date;
                $kot->voucher_no = $tempkot->voucher_no;
                $kot->voucher_date = $tempkot->voucher_date;
                $kot->voucher_type = $tempkot->voucher_type;
                $kot->bill_no = $tempkot->bill_no;
                $kot->user_id = $tempkot->user_id;
                $kot->user_name = $tempkot->user_name;
                $kot->item_id = $tempkot->item_id;
                $kot->item_name = $tempkot->item_name;
                $kot->qty = $tempkot->qty;
                $kot->rate = $tempkot->rate;
                $kot->amount = $tempkot->amount;
                $kot->total_qty = $totalQty;
                $kot->total_amount = $totalAmount;
                $kot->kot_remark = $tempkot->kot_remark;
                $kot->service_id = $tempkot->sale_to_voucher_no;
                $date = $tempkot->entry_date; // Assuming this is in 'Y-m-d' format
                $time = $store_time . ':00'; // Append ':00' to make it 'H:i:s'
                $kot->created_at = "$date $time";
                $kot->save();
            }
            $tempkots_delete = tempentry::where('firm_id', Auth::user()->firm_id)->where('user_id', $id);
            $tempkots_delete->delete();
            $kot_to_print = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $voucher_no)
                ->get();
            $kot_header = kot::withinFY('voucher_date')->where('user_id', $id)->where('firm_id', Auth::user()->firm_id)
                ->where('voucher_no', $voucher_no)
                ->first();

            $guest_detail = roomcheckin::withinFY('checkin_date')->where('checkout_voucher_no', 0)
                ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
                ->groupBy('guest_name', 'voucher_no')
                ->where('voucher_no', $kot_header->service_id)
                ->where('firm_id', Auth::user()->firm_id)
                ->first();
            if ($guest_detail === null) {

                $tabledata = table::where('id', $kot_header->service_id)->where('firm_id', Auth::user()->firm_id)->first();
                $table_name = $tabledata->table_name;

            } else {
                $table_name = Null;
            }


            return view('entery.roomservice.kot_print_view', compact('kot_to_print', 'kot_header', 'guest_detail', 'table_name'));
        } else {
            return back()->with('error', 'Nothing To Print  ');
        }
    }


    public function cancel_rkot(Request $request)
    {
        $kots = kot::withinFY('voucher_date')->where('voucher_no', $request->voucher_no)
            ->where('firm_id', Auth::user()->firm_id)
            ->where('voucher_type', 'Rkot')
            ->where(function ($query) {
                $query->where('status', '0')
                    ->orWhere('status', 'Nc');
            });

        if ($kots->count()) {
            $kots->update(['status' => 'cancel', 'kot_remark' => $request->cancel_remark]);

            return back()->with('message', 'Record Cancelled: ' . $request->voucher_no);
        } else {
            return back()->with('errors', 'Check your KOT – it may be already converted into a bill, so it cannot be deleted.');
        }
    }




}
