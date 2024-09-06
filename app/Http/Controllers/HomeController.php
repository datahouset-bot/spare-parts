<?php

namespace App\Http\Controllers;

use App\Models\amc;
use App\Models\roomcheckin;
use App\Models\todo;
use App\Models\room;
use App\Models\Followup;
use Illuminate\Http\Request;

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

    
        $currentDate = now()->toDateString();
       $roomcheckin= roomcheckin::where('checkout_voucher_no', '0')
       ->count();
        $vacantroom=room::where("room_status" , 'vacant') 
        ->count();
        $occupiedroom=room::where("room_status" , 'occupied') 
        ->count();
        $dirtyroom=room::where("room_status" , 'dirty') 
        ->count();


        // Pass the counts to the view
        return view('home', compact('roomcheckin','currentDate','vacantroom','occupiedroom' ,'dirtyroom' ));    
    }
    
}
