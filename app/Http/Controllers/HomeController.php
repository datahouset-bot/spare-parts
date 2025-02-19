<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\amc;
use App\Models\room;
use App\Models\softwarecompany;
use App\Models\todo;
use App\Models\Followup;
use App\Models\roomcheckin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends CustomBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

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




        // Pass the counts to the view


                $user = Auth::user();
        $softwarecompinfo = softwarecompany::where('firm_id',Auth::user()->firm_id)->first();
        $expiryDate = Carbon::parse($softwarecompinfo->expiry_date);
        $currentDate = Carbon::now();
        $daysDifference = $currentDate->diffInDays($expiryDate, false); // false for signed differen       

        if ($user->email !== 'datahouset@gmail.com') {

        

            if ($daysDifference < 0) { // Expiry date is in the past
                return view('subscription_expired');

            }
            else{
                return view('home', compact('roomcheckin','currentDate','vacantroom','occupiedroom' ,'dirtyroom','daysDifference','amcCount', 'dueAmcCount','pendingTask','todayFollowup' ));    
            }
        }
        else{


            // $expiryDate = Carbon::parse($softwarecompinfo->expiry_date);
            // $currentDate = Carbon::now();
            // $daysDifference = $currentDate->diffInDays($expiryDate, false); // false for signed difference
        

                return view('home', compact('roomcheckin','currentDate','vacantroom','occupiedroom' ,'dirtyroom','daysDifference','amcCount', 'dueAmcCount','pendingTask','todayFollowup' ));    
           
    }
    
}
}
