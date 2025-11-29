<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cresher;

class Crushercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $creshers = cresher::latest()->get();
    return view('crusher.cresher_index', compact('creshers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('crusher.cresher_entry');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { dd($request);
        // ✅ Simple validation
        $request->validate([
            'slip_no'    => 'required',
            'date'       => 'required',
            'time'       => 'required',
            'vehicle_no' => 'required',
            'party_name' => 'required',
        ]);
        Cresher::create([
            'slip_no'      => $request->slip_no,
            'date'         => $request->date,
            'time'         => $request->time,
            'vehicle_no'   => $request->vehicle_no,
            'party_name'   => $request->party_name,
            'Vehicle_name'=> $request->Vehicle_name,
            'Material'     => $request->Material,
            'Royalty'      => $request->Royalty,
            'Quantity'     => $request->Quantity,
            'address'      => $request->address,
            'phone'        => $request->phone,
            'remark'       => $request->remark,
            'pic'          => $request->pic,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Cresher data saved successfully'
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
