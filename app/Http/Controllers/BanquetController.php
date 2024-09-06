<?php

namespace App\Http\Controllers;

use App\Models\banquet;
use Carbon\Carbon;
use App\Models\kot;
use App\Models\item;
use App\Models\account;
use App\Models\purchase;
use App\Models\tempentry;
use App\Models\roomcheckin;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorebanquetRequest;
use App\Http\Requests\UpdatebanquetRequest;

class BanquetController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
             $kot_record=kot::count();
         if ($kot_record > 0) {
            $lastRecord = kot::orderBy('voucher_no', 'desc')->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Kot')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Kot')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }

        $checkinlists = roomcheckin::where('checkout_voucher_no', 0)
        ->select('guest_name', 'voucher_no', DB::raw('GROUP_CONCAT(room_no ORDER BY room_no SEPARATOR ",") as room_nos'))
        ->groupBy('guest_name', 'voucher_no')
        ->get();

        $accountdata = account::all();
        $itemdata = item::all();

        return view('entery.banquet.banquet_create', compact('new_bill_no','new_voucher_no','checkinlists','accountdata','itemdata')); 

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorebanquetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(banquet $banquet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(banquet $banquet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebanquetRequest $request, banquet $banquet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(banquet $banquet)
    {
        //
    }
}
