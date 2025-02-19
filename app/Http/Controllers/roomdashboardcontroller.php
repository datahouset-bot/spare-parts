<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\room;
use App\Models\package;
use App\Models\roomtype;
use App\Models\gstmaster;
use App\Models\roombooking;
use App\Models\roomcheckin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class roomdashboardcontroller extends CustomBaseController
{

    public function room_dashboard()
    {
        // Get the current date
        $currentDate = Carbon::now()->toDateString();
    
        // Fetch booked room IDs where the current date is between checkin_date and checkout_date
        $bookedRoomIds = roombooking::where('firm_id',Auth::user()->firm_id)
        ->where('checkin_date', '<=', $currentDate)
                                      ->where('checkout_date', '>=', $currentDate)
                                      ->where('checkin_voucher_no','0')
                                      ->pluck('room_id')
                                      ->toArray();

       $roomcheckinsData= roomcheckin::where('firm_id',Auth::user()->firm_id)
       ->where('checkout_voucher_no', '0')->get();
                             
    
        // Fetch all rooms with their room types
        $data = Room::with('roomtype')->where('firm_id',Auth::user()->firm_id)->get();
        $currentDate = now()->toDateString();
        $roomcheckin= roomcheckin::where('firm_id',Auth::user()->firm_id)->where('checkout_voucher_no', '0')
        ->count();
         $vacantroom=room::where('firm_id',Auth::user()->firm_id)->where("room_status" , 'vacant') 
         ->count();
         $occupiedroom=room::where('firm_id',Auth::user()->firm_id)->where("room_status" , 'occupied') 
         ->count();
         $dirtyroom=room::where('firm_id',Auth::user()->firm_id)->where("room_status" , 'dirty') 
         ->count();
 
    

        return view('entery.room.room_dashboard', compact('roomcheckin','currentDate','vacantroom','occupiedroom' ,'dirtyroom','data','bookedRoomIds','roomcheckinsData'));
    }

    public function room_dashboard_datewise(Request $request)
    {

        // echo("<pre>");
        // print_r($request->all());
        $vacantroom="";
        $occupiedroom="";
        $dirtyroom="";


        $received_date = $request->selected_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $received_date);
        $selected_date = $parsed_date->format('Y-m-d');
        
        $currentDate = Carbon::parse($selected_date)->toDateString();
        $message = "Your selected date result is: $received_date";

        
    
        $bookedRoomIds = roombooking::where('firm_id',Auth::user()->firm_id)
                                       ->where('checkin_date', '<=', $currentDate)
                                      ->where('checkout_date', '>=', $currentDate)
                                      ->pluck('room_id')
                                      ->toArray();
    
        $rooms = Room::with('roomtype')->where('firm_id',Auth::user()->firm_id)->get();
       $roomcheckinsData= roomcheckin::where('firm_id',Auth::user()->firm_id)
       ->where('checkout_voucher_no', '0')->get();
    
        return view('entery.room.room_dashboard', ['data' => $rooms,'message' => $message ,'bookedRoomIds' => $bookedRoomIds,'roomcheckinsData'=>$roomcheckinsData,
    'vacantroom'=>$vacantroom,'occupiedroom'=>$occupiedroom ,'dirtyroom'=>$dirtyroom]);
    }
}
