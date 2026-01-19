<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\amc;
use App\Models\kot;
use App\Models\room;
use App\Models\todo;
use App\Models\account;
use App\Models\voucher;
use App\Models\Followup;
use App\Models\componyinfo;
use App\Models\roomcheckin;
use Illuminate\Http\Request;
use App\Models\financialyear;
use App\Models\maintenancemode;
use App\Models\softwarecompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class HomeController extends CustomBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 

      $financialyear=financialyear::where('firm_id',Auth::user()->firm_id)->where('is_active_fy','1')->first();
  
     


        $amcCount = Amc::where('firm_id',Auth::user()->firm_id)->count(); // Count all AMC records
        $dueAmcCount = Amc::where('firm_id',Auth::user()->firm_id)
        ->where('payment_status', 'Unpaid')->count(); // Count due AMC records
        $pendingTask = todo::where('firm_id',Auth::user()->firm_id)
        ->where('reminder_af1', '0')->count(); // Count due AMC records
    
        $currentDate = now()->toDateString();
       $todayFollowup= Followup::       getRecordsWithHighestIdForEachLead()
       ->whereDate('followup_date', $currentDate)
       ->where('firm_id',Auth::user()->firm_id)
       ->orderBy('followup_date')
       ->count();


        // Pass the counts to the view
     
        $currentDate = now()->toDateString();
       $roomcheckin= roomcheckin::where('firm_id',Auth::user()->firm_id)
       ->where('checkout_voucher_no', '0')
       ->count();
        $vacantroom=room::where('firm_id',Auth::user()->firm_id)->where("room_status" , 'vacant') 
        ->count();
        $occupiedroom=room::where('firm_id',Auth::user()->firm_id)->where("room_status" , 'occupied') 
        ->count();
        $dirtyroom=room::where('firm_id',Auth::user()->firm_id)->where("room_status" , 'dirty') 
        ->count();
       $kot_Unprinted = kot::select('voucher_no')
    ->where('status', '0')   
    ->where('ready_to_serve', 'Unprinted')
    ->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_type', 'kot')
    ->groupBy('voucher_no')
    ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
    ->get()
    ->count();
      $Rkot_Unprinted = kot::select('voucher_no')
      ->where('status', '0')
    ->where('ready_to_serve', 'Unprinted')
    ->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_type', 'Rkot')
    ->groupBy('voucher_no')
    ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
    ->get()
    ->count();

 $today = now()->toDateString(); // YYYY-MM-DD

    // ==============================
    // Outstanding Payable (Today)
    // ==============================
    $accounts = Account::select(
            'accounts.id',
            'accounts.account_name',
            'accounts.op_balnce',
            'accounts.balnce_type',
            'accounts.mobile',

            DB::raw("SUM(
                CASE 
                    WHEN ledgers.entry_date <= '$today' 
                    THEN ledgers.debit 
                    ELSE 0 
                END
            ) as total_debit"),

            DB::raw("SUM(
                CASE 
                    WHEN ledgers.entry_date <= '$today' 
                    THEN ledgers.credit 
                    ELSE 0 
                END
            ) as total_credit")
        )
        ->leftJoin('ledgers', 'accounts.id', '=', 'ledgers.account_id')
        ->where('accounts.firm_id', Auth::user()->firm_id)
        ->groupBy(
            'accounts.id',
            'accounts.account_name',
            'accounts.op_balnce',
            'accounts.balnce_type',
            'accounts.mobile'
        )
        ->get();

    $outstandingPayables = $accounts
        ->map(function ($account) {

            if ($account->balnce_type === 'Dr') {
                $balance = $account->op_balnce
                         + $account->total_debit
                         - $account->total_credit;
            } else { // Cr
                $balance = $account->total_credit
                         - $account->total_debit
                         - $account->op_balnce;
            }

            $account->outstanding_amount = $balance;
            return $account;
        })
        ->filter(function ($account) {
            return $account->outstanding_amount < 0;
        })
        ->sortBy('outstanding_amount'); // highest payable first

        // outstanding receivable data show
        $outstandingReceivables = $accounts
    ->map(function ($account) {

        if ($account->balnce_type === 'Cr') {
            $balance = $account->op_balnce
                     + $account->total_credit
                     - $account->total_debit;
        } else { // Dr
            $balance = $account->total_debit
                     - $account->total_credit
                     - $account->op_balnce;
        }

        $account->outstanding_amount = $balance;
        return $account;
    })
    ->filter(function ($account) {
        return $account->outstanding_amount > 0; // RECEIVABLE
    })
    ->sortByDesc('outstanding_amount'); // highest receivable first


// show purchase data 
    $purchaseChart = voucher::with('account')
    ->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_type', 'Purchase')
    ->orderBy('voucher_no', 'desc')
    ->take(7)
    ->get();

                $user = Auth::user();
        $softwarecompinfo = softwarecompany::where('firm_id',Auth::user()->firm_id)->first();
        $expiryDate = Carbon::parse($softwarecompinfo->expiry_date);
        $currentDate = Carbon::now();
        $daysDifference = $currentDate->diffInDays($expiryDate, false); // false for signed differen       

        if ($user->email !== 'datahouset@gmail.com') {

        
    $maintinacemode=maintenancemode::first();
          $mode=$maintinacemode->maintenance_mode;
          

             if ($mode > 0) {
                // Subscription has expired, show 'subscription_expired' view
                return response()->view('maintancemode',compact('maintinacemode'));

            } 
            if ($daysDifference < 0) { // Expiry date is in the past
                return view('subscription_expired');

            }
            else{
                return view('home', compact('purchaseChart','outstandingPayables','outstandingReceivables',
                'roomcheckin','currentDate','vacantroom','occupiedroom' ,'dirtyroom','daysDifference','amcCount', 
                'dueAmcCount','pendingTask','todayFollowup' ,'kot_Unprinted','Rkot_Unprinted','financialyear'));    
            }
        }
        else{


            // $expiryDate = Carbon::parse($softwarecompinfo->expiry_date);
            // $currentDate = Carbon::now();
            // $daysDifference = $currentDate->diffInDays($expiryDate, false); // false for signed difference
        
  $debugData="";
               return view('home', compact( 
    'roomcheckin','currentDate','vacantroom','occupiedroom','dirtyroom',
    'daysDifference','amcCount','dueAmcCount','pendingTask','todayFollowup',
    'kot_Unprinted','Rkot_Unprinted','financialyear','debugData','sales',
'purchaseChart','outstandingPayables','outstandingReceivables'
    
));

           
    }
    
}
}
