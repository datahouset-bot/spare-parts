<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\roomtype;
use App\Models\room;
use App\Models\package;
use App\Models\gstmaster;
use App\Models\roombooking;
use Carbon\Carbon;


class roomdashboardcontroller extends CustomBaseController
{

    public function room_dashboard()
    {
        // Get the current date
        $currentDate = Carbon::now()->toDateString();
    
        // Fetch booked room IDs where the current date is between checkin_date and checkout_date
        $bookedRoomIds = roombooking::where('checkin_date', '<=', $currentDate)
                                      ->where('checkout_date', '>=', $currentDate)
                                      ->where('checkin_voucher_no','0')
                                      ->pluck('room_id')
                                      ->toArray();

                             
    
        // Fetch all rooms with their room types
        $rooms = Room::with('roomtype')->get();
    
        return view('entery.room.room_dashboard', ['data' => $rooms, 'bookedRoomIds' => $bookedRoomIds]);
    }

    public function room_dashboard_datewise(Request $request)
    {

        // echo("<pre>");
        // print_r($request->all());

        $received_date = $request->selected_date;
        $parsed_date = Carbon::createFromFormat('d-m-Y', $received_date);
        $selected_date = $parsed_date->format('Y-m-d');
        
        $currentDate = Carbon::parse($selected_date)->toDateString();
        $message = "Your selected date result is: $received_date";

        
    
        $bookedRoomIds = roombooking::where('checkin_date', '<=', $currentDate)
                                      ->where('checkout_date', '>=', $currentDate)
                                      ->pluck('room_id')
                                      ->toArray();
    
        $rooms = Room::with('roomtype')->get();
    
        return view('entery.room.room_dashboard', ['data' => $rooms,'message' => $message ,'bookedRoomIds' => $bookedRoomIds]);
    }
}
