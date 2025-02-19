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
use  App\Models\User;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreroomcheckoutRequest;
use App\Http\Requests\UpdateroomcheckoutRequest;


class ReportController extends CustomBaseController
{

    public function room_food_gstreport_pageshow(){
        $roomcheckouts = [];
        $combinedData=[];
        return view('reports.genralreport.room_food_register',compact('roomcheckouts'));
    }

//     public function roomfood_gstreport(Request $request){


//         $validator = validator::make($request->all(), [
//             'from_date' => 'required',
//             'to_date' => 'required',
            
//         ]);

       

//         if ($validator->passes()) {
        
//         $date_variable=$request->from_date;
//         $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
//         $formatted_from_date = $parsed_date->format('Y-m-d');
       
//         $date_variable=$request->to_date;
//         $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
//         $formatted_to_date = $parsed_date->format('Y-m-d');
//         $foodbills = foodbill::select('voucher_type', 'total_bill_value', 'total_qty', 'voucher_no', 'food_bill_no', 'service_id', 'voucher_date', 'status', 'user_id', DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos'))
//         ->groupBy('voucher_type', 'voucher_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date')
//         ->orderBy('voucher_no', 'desc')
//         ->where('voucher_type', 'Foodbill')
//         ->whereBetween('voucher_date', [$formatted_from_date, $formatted_to_date])
//         // Ensure groupBy includes all non-aggregated selected columns
//         ->get();



//         $roomcheckouts = roomcheckout::with('account') // Assuming there's a relationship defined
//         ->whereBetween('checkout_date', [$formatted_from_date, $formatted_to_date])
//         ->orderBy('voucher_no', 'desc')
//         ->get();
    
//     return view('reports.genralreport.room_food_register', compact('roomcheckouts'));
    
//     }
// }

public function roomfood_gstreport(Request $request) {
    $validator = validator::make($request->all(), [
        'from_date' => 'required',
        'to_date' => 'required',
    ]);

    if ($validator->passes()) {
        $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');

        // Fetch food bills
        $foodbills = foodbill::select(
            'voucher_type',
            'food_bill_no', 
            'total_bill_value', 
            'total_qty', 
            'voucher_no', 
            'food_bill_no', 
            'service_id', 
            'voucher_date', 
            'status', 
            'user_id',
            'total_sgst',
            'total_cgst',
            'total_igst',
            'total_taxable_amount', 
            'customer_name',
            'address',
            'mobile',
            'remark',

            'total_gst_amount',
            DB::raw('GROUP_CONCAT(voucher_no ORDER BY voucher_date SEPARATOR ",") as room_nos')
        )
        ->groupBy('voucher_type', 'voucher_no', 'total_bill_value', 'total_qty', 'food_bill_no', 'service_id', 'status', 'user_id', 'voucher_date','total_sgst','total_cgst','total_igst','total_taxable_amount','total_gst_amount','customer_name','address','mobile','remark')
        ->orderBy('voucher_date', 'desc')
        ->where('voucher_type', 'Foodbill')
        ->where('firm_id',Auth::user()->firm_id)

        ->whereBetween('voucher_date', [$from_date, $to_date])
        ->get();

        // Fetch room checkouts
        $roomcheckouts = roomcheckout::with('account')
           ->where('firm_id',Auth::user()->firm_id)
            ->whereBetween('checkout_date', [$from_date, $to_date])
            ->orderBy('checkout_date', 'desc')
            ->get();

        // Combine and arrange data by date
        $combinedData = [];
        
        // Add food bills to combined data
        foreach ($foodbills as $bill) {
            $date = $bill->voucher_date;
            if (!isset($combinedData[$date])) {
                $combinedData[$date] = [];
            }
            $combinedData[$date][] = [
                'type' => 'foodbill',
                'data' => $bill,
            ];
        }

        // Add room checkouts to combined data
        foreach ($roomcheckouts as $checkout) {
            $date = $checkout->checkout_date;
            if (!isset($combinedData[$date])) {
                $combinedData[$date] = [];
            }
            $combinedData[$date][] = [
                'type' => 'roomcheckout',
                'data' => $checkout,
            ];
        }

        // Sort combined data by date
        krsort($combinedData);
 
        return view('reports.genralreport.room_food_register', compact('combinedData'));
    }

    return back()->withErrors($validator)->withInput();
}

public function b2bsales_pageshow(){
        $roomcheckouts = [];
        return view('reports.genralreport.b2b_checkout_register',compact('roomcheckouts'));
    }

    public function b2bsales(Request $request){


        $validator = validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
            
        ]);

       

        if ($validator->passes()) {
        
        $date_variable=$request->from_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_from_date = $parsed_date->format('Y-m-d');
       
        $date_variable=$request->to_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_to_date = $parsed_date->format('Y-m-d');
       


        $roomcheckouts = roomcheckout::where('firm_id',Auth::user()->firm_id)
        ->with('account') // Assuming there's a relationship defined
        ->whereBetween('checkout_date', [$formatted_from_date, $formatted_to_date])
        ->whereHas('account', function($query) {
            $query->whereNotNull('gst_no'); // Filter to only include accounts with a GST number
        })
        ->orderBy('voucher_no', 'desc')
        ->where('firm_id',Auth::user()->firm_id)
        ->get();
    
    return view('reports.genralreport.b2b_checkout_register', compact('roomcheckouts'));
    
    }
}

public function roomsales_report_pageshow(){
    $roomcheckouts = [];
    return view('reports.genralreport.roomsales_report_pageshow',compact('roomcheckouts'));
}
public function roomsales_report_result(Request $request)
{
    $validator = Validator::make($request->all(), [
        'from_date' => 'required',
    ]);

    if ($validator->passes()) {
        // Format the from_date
        $formatted_from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
        $from_date = $request->from_date;

        $roomcheckins = DB::table('roomcheckins')
            ->leftJoin('accounts', 'roomcheckins.account_id', '=', 'accounts.id')
            ->select(
                'roomcheckins.voucher_no',
                DB::raw('GROUP_CONCAT(roomcheckins.room_no ORDER BY roomcheckins.room_no ASC SEPARATOR ", ") as room_nos'),
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
                'accounts.address',
                'accounts.address2',
                'roomcheckins.comming_from',
                'roomcheckins.going_to',
                'roomcheckins.no_of_guest',
                'roomcheckins.room_tariff_perday'
            )
            ->where('roomcheckins.firm_id', Auth::user()->firm_id) // Filter by firm ID
            ->where(function ($query) use ($formatted_from_date) {
                $query->where('roomcheckins.checkin_date', $formatted_from_date) // Case 1: Match checkin_date
                      ->orWhere('roomcheckins.checkout_voucher_no', 0) // Case 2: checkout_voucher_no = 0
                      ->orWhereDate('roomcheckins.updated_at', $formatted_from_date);
            })
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
                'accounts.address',
                'accounts.address2',
                'roomcheckins.comming_from',
                'roomcheckins.going_to',
                'roomcheckins.no_of_guest',
                'roomcheckins.room_tariff_perday'
            )
            ->get();

        return view('entery.room.checkin.room_sales_report', compact('roomcheckins', 'from_date'));
    }

    return redirect()->back()->withErrors($validator->errors());
}


public function b2csales_pageshow(){
    $roomcheckouts = [];
    return view('reports.genralreport.b2c_checkout_pageshow',compact('roomcheckouts'));
}



public function b2csales(Request $request)
{
    $validator = Validator::make($request->all(), [
        'from_date' => 'required',
        'to_date' => 'required',
    ]);

    if ($validator->passes()) {
        // Format the dates
        $formatted_from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
        $formatted_to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
        
        // Fetch room checkouts data
        $roomcheckouts_5_percent = RoomCheckout::with('account')
            ->where('firm_id',Auth::user()->firm_id)
            
            ->whereBetween('checkout_date', [$formatted_from_date, $formatted_to_date])
            ->whereHas('account', function($query) {
                $query->whereNull('gst_no');
            })
            
            ->where('gst_id','5')
            ->where('bill_type','Check_out')

            ->sum('total_room_rent');
                    // Fetch food bills data with GST filters
        $foodbills_5_percent = FoodBill::where('firm_id',Auth::user()->firm_id)
        ->whereBetween('voucher_date', [$formatted_from_date, $formatted_to_date])
        ->where('firm_id',Auth::user()->firm_id)
        ->where('gst_item_percent', 5)
        ->sum('item_base_amount'); // Sum of 5% GST items
        $total_5_percent_taxable_value = $roomcheckouts_5_percent + $foodbills_5_percent;
 

        $roomcheckouts_12_percent = RoomCheckout::with('account')
        ->where('firm_id',Auth::user()->firm_id)  
        
        ->whereBetween('checkout_date', [$formatted_from_date, $formatted_to_date])
            ->whereHas('account', function($query) {
                $query->whereNull('gst_no');
            })
            
            ->where('gst_id','12')
            ->where('bill_type','Check_out')

            ->sum('total_room_rent');
                    // Fetch food bills data with GST filters
        $foodbills_12_percent = FoodBill::where('firm_id',Auth::user()->firm_id)->whereBetween('voucher_date', [$formatted_from_date, $formatted_to_date])
        ->where('firm_id',Auth::user()->firm_id)
        ->where('gst_item_percent', 12)
        ->sum('item_base_amount'); // Sum of 5% GST items
  
        $total_12_percent_taxable_value = $roomcheckouts_12_percent + $foodbills_12_percent;
        $roomcheckouts_18_percent = RoomCheckout::where('firm_id',Auth::user()->firm_id)->with('account')
        ->whereBetween('checkout_date', [$formatted_from_date, $formatted_to_date])
        ->whereHas('account', function($query) {
            $query->whereNull('gst_no');
        })
        
        ->where('gst_id','18')
        ->where('bill_type','Check_out')
        ->where('firm_id',Auth::user()->firm_id)

        ->sum('total_room_rent');

                // Fetch food bills data with GST filters
    $foodbills_18_percent = FoodBill::where('firm_id',Auth::user()->firm_id)
    ->whereBetween('voucher_date', [$formatted_from_date, $formatted_to_date])
    ->where('gst_item_percent', 18)
    ->where('firm_id',Auth::user()->firm_id)
    ->sum('item_base_amount'); // Sum of 5% GST items
    $total_18_percent_taxable_value = $roomcheckouts_18_percent + $foodbills_18_percent;
    $roomcheckouts_28_percent = RoomCheckout::where('firm_id',Auth::user()->firm_id)
    ->with('account')
    ->whereBetween('checkout_date', [$formatted_from_date, $formatted_to_date])
    ->whereHas('account', function($query) {
        $query->whereNull('gst_no');
    })
    
    ->where('gst_id','28')
    ->where('firm_id',Auth::user()->firm_id)

    ->sum('total_room_rent');
            // Fetch food bills data with GST filters
$foodbills_28_percent = FoodBill::where('firm_id',Auth::user()->firm_id)
->whereBetween('voucher_date', [$formatted_from_date, $formatted_to_date])
->where('gst_item_percent', 28)
->where('firm_id',Auth::user()->firm_id)
->sum('item_base_amount'); // Sum of 5% GST items
$total_28_percent_taxable_value = $roomcheckouts_28_percent + $foodbills_28_percent;



        return view('reports.genralreport.b2c_checkout_register', compact('total_5_percent_taxable_value','total_12_percent_taxable_value','total_18_percent_taxable_value','total_28_percent_taxable_value'));
    }

    return redirect()->back()->withErrors($validator);
}


public function my_checkout_register_pageshow(){
    $roomcheckouts = [];
    $combinedData=[];
    return view('reports.genralreport.my_checkout_register',compact('roomcheckouts'));
}


public function my_checkout_register(Request $request)
{
    $validator = validator::make($request->all(), [
        'from_date' => 'required',
        'to_date' => 'required',
        
    ]);

   

    if ($validator->passes()) {
    
    $date_variable=$request->from_date;
    $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_from_date = $parsed_date->format('Y-m-d');
   
    $date_variable=$request->to_date;
    $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_to_date = $parsed_date->format('Y-m-d');
   


    $roomcheckouts = roomcheckout::where('firm_id',Auth::user()->firm_id)
    ->whereBetween('checkout_date', [$formatted_from_date, $formatted_to_date])
    ->orderBy('voucher_no','desc')->where('bill_type','My_Check_out')->get();
     return view('reports.genralreport.my_checkout_register',compact('roomcheckouts'));
    }
}
public function checkout_register_pageshow(){
    $roomcheckouts = [];
    $combinedData=[];
    return view('reports.genralreport.checkout_register',compact('roomcheckouts'));
}


public function checkout_register_only(Request $request)
{
    $validator = validator::make($request->all(), [
        'from_date' => 'required',
        'to_date' => 'required',
        
    ]);

   

    if ($validator->passes()) {
    
    $date_variable=$request->from_date;
    $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_from_date = $parsed_date->format('Y-m-d');
   
    $date_variable=$request->to_date;
    $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_to_date = $parsed_date->format('Y-m-d');
   



    $roomcheckouts = roomcheckout::where('firm_id',Auth::user()->firm_id)
    ->whereBetween('checkout_date', [$formatted_from_date, $formatted_to_date])
    ->orderBy('voucher_no','desc')->get();


     return view('reports.genralreport.checkout_register',compact('roomcheckouts'));
    }
}

public function handover_view(Request $request){
    
$userlists=user::where('firm_id',Auth::user()->firm_id)->get();
     return view('reports.genralreport.handover_pageview',compact('userlists'));

}
public function handover(Request $request)
{

    $validator = validator::make($request->all(), [
        'from_date' => 'required',
        'to_date' => 'required',

        "user_id" => "requird",
      "from_time" => "requird",


      "end_time" => "requird",
        
    ]);
    $from_date = $request->from_date;
    $to_date = $request->to_date;
    $user_id=$request->user_id;
    $end_time=$request->end_time;
    $from_time=$request->from_time;

    

    $listofaccount = account::where('firm_id', Auth::user()->firm_id)
    ->whereHas('accountGroup', function ($query) {
        $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
    })
    ->get();

    $current_date = Carbon::now();
    $formatted_current_date = $current_date->format('Y-m-d');
     $one_day_before=Carbon::now();
     $one_day_before = now()->subDay(); // Get current date and subtract one day
    $formated_one_day_before = $one_day_before->format('Y-m-d');
    $date_variable=$request->from_date;
    $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_from_date = $parsed_date->format('Y-m-d');
   
    $date_variable=$request->to_date;
    $parsed_date = Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_to_date = $parsed_date->format('Y-m-d');

    


    $all_reports = [];

    foreach ($listofaccount as $account) {
        $account_id = $account->id;
        $account_name = $account->account_name;
        $opening_balance_account = $account->op_balnce;
        $opning_balance_type = $account->balnce_type;

        $ledgers = Ledger::where('firm_id',Auth::user()->firm_id)->where('account_id', $account_id)
        ->whereBetween('entry_date', [$formatted_from_date, $formatted_to_date])
        ->where('userid',$user_id)
        ->where('firm_id',Auth::user()->firm_id)
        ->get();

 
        $ledgers_before_fromdate = Ledger::where('firm_id',Auth::user()->firm_id)->where('account_id', $account_id)
            ->where('entry_date', '<=', $formated_one_day_before)
            ->where('userid',$user_id)
            ->where('firm_id',Auth::user()->firm_id)
            ->get();
  
        $debit_total = 0;
        $credit_total = 0;

        foreach ($ledgers_before_fromdate as $record) {
            $debit_total += $record->debit;
            $credit_total += $record->credit;
        }

        $total_balance = $debit_total - $credit_total;
        // $final_opning_balance = ($opning_balance_type === 'Dr') ? $total_balance + $opening_balance_account : $total_balance - $opening_balance_account;
        $final_opning_balance = "0";

        
        $all_reports[] = [
            'account_name' => $account_name,
            'ledgers' => $ledgers,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'final_opning_balance' => $final_opning_balance,
        ];
    }
    $userids=user::where('id',$user_id)->first();
     $user_name=$userids->name;
     
    $accounts = Account::orderBy('account_name', 'asc')
    ->where('firm_id',Auth::user()->firm_id)->get();

    return view('reports.genralreport.handover_report_result', compact('accounts', 'all_reports','formatted_current_date','user_name','formatted_from_date','formatted_to_date','formatted_from_date'));
}


public function roomcheckin_guest_profile_print($voucher_no){
$checkindata=roomcheckin::where('voucher_no',$voucher_no)->where('firm_id',Auth::user()->firm_id)->first();

 return view('reports.genralreport.roomcheckin_guest_profile_print',compact('checkindata'));
}


}
