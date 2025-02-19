<?php

namespace App\Http\Controllers;

use App\Models\kot;
use App\Models\item;
use App\Models\table;
use App\Models\account;
use App\Models\roomcheckin;
use App\Models\roomservice;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $pending_kot_items = kot::where('firm_id', Auth::user()->firm_id)
            ->where('status', '0') 
            ->where('ready_to_serve', '0')
            ->get()
            ->groupBy('voucher_no');       
    
        // Fetch the first roomcheckin record per service_id
        $pending_kot_items_header = kot::where('kots.firm_id', Auth::user()->firm_id)
            ->where('kots.status', '0')
            ->where('kots.ready_to_serve', '0')
            ->leftJoin('roomcheckins as r', function ($join) {
                $join->on('kots.service_id', '=', 'r.voucher_no')
                     ->whereRaw('r.id = (SELECT MIN(id) FROM roomcheckins WHERE roomcheckins.voucher_no = kots.service_id)');
            })
            ->select('kots.*', 'r.room_no', 'r.voucher_no') // Only required columns
            ->first(); // Fetch only the first record
    
        return view('entery.roomservice.reports.kichen_dashboard', compact('pending_kot_items', 'pending_kot_items_header'));
    }
    
    public function readytoserve(Request $request)
    {     
        $kot_voucher_no=$request->kot_voucher_no;
        $read_to_serve='Ready To Serve ';
        kot::where('voucher_no',$kot_voucher_no)->update(['ready_to_serve' =>$read_to_serve]); 
        $pending_kot_items = kot::where('firm_id',Auth::user()->firm_id)
        ->where('status', '0') 
        ->where('ready_to_serve','0')
        ->get()
        ->groupBy('voucher_no');
       return view('entery.roomservice.reports.kichen_dashboard',compact('pending_kot_items'));

    }
    public function readytoserve_print(Request $request)
    {   $id=Auth::user()->id;  


        $voucher_no=$request->kot_voucher_no;
        $kot_voucher_no=$request->kot_voucher_no;
        $read_to_serve='Ready To Serve ';
        kot::where('voucher_no',$kot_voucher_no)->update(['ready_to_serve' =>$read_to_serve]); 
        $pending_kot_items = kot::where('firm_id',Auth::user()->firm_id)
        ->where('status', '0') 
        ->where('ready_to_serve','0')
        ->get()
        ->groupBy('voucher_no');

        $kot_to_print = kot::where('user_id', $id)
        ->where('firm_id',Auth::user()->firm_id)
        ->where('voucher_no', $voucher_no)
        ->get();
        
        $kot_header=kot::where('user_id', $id)
        ->where('firm_id',Auth::user()->firm_id)
        ->where('voucher_no', $voucher_no)
        ->first();
          $checkin_no =$kot_header->service_id;
    
        $guest_detail = roomcheckin::where('checkout_voucher_no', 0)
         ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
        ->groupBy('guest_name', 'voucher_no')
        ->where('voucher_no', $kot_header->service_id)
        ->where('firm_id',Auth::user()->firm_id)
        ->first();
        if ($guest_detail === null) {

            $tabledata=table::where('id',$kot_header->service_id)->where('firm_id',Auth::user()->firm_id)->first();
          $table_name=$tabledata->table_name;
    
        }else{
            $table_name=Null;
        }
        return view('entery.roomservice.kot_print_view',compact('kot_to_print','kot_header','guest_detail','table_name'));

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
