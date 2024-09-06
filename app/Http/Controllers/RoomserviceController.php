<?php

namespace App\Http\Controllers;

use App\Models\kot;
use App\Models\item;
use App\Models\account;
use App\Models\roomcheckin;
use App\Models\roomservice;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreroomserviceRequest;
use App\Http\Requests\UpdateroomserviceRequest;

class RoomserviceController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('entery.roomservice.room_service_index'); 

    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreroomserviceRequest $request)
    {
        //
    }

    /**
     * display the kot  on kichen dashboard 
     */
    public function kichen_dashboard()
    {
         $pending_kot_items = kot::where('status', '0') 
         ->where('ready_to_serve','0')
         ->get()
         ->groupBy('voucher_no');       
        return view('entery.roomservice.reports.kichen_dashboard',compact('pending_kot_items'));

    }
    public function readytoserve(Request $request)
    {     
        $kot_voucher_no=$request->kot_voucher_no;
        $read_to_serve='Ready To Serve ';
        kot::where('voucher_no',$kot_voucher_no)->update(['ready_to_serve' =>$read_to_serve]); 
        $pending_kot_items = kot::where('status', '0') 
        ->where('ready_to_serve','0')
        ->get()
        ->groupBy('voucher_no');
       return view('entery.roomservice.reports.kichen_dashboard',compact('pending_kot_items'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(roomservice $roomservice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateroomserviceRequest $request, roomservice $roomservice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(roomservice $roomservice)
    {
        //
    }
}
