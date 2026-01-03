<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\account;
use App\Models\cctvVisit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class cctvcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $visits = cctvVisit::latest()->get();
    return view('cctv.cctv_index', compact('visits'));
}

  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("cctv.cctv_entry", );
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'cust_name' => 'nullable|string|max:255',
        'product'   => 'nullable|string|max:255',
    ]);

    $visit = new cctvVisit();

    $visit->csr = $request->csr;
    $visit->date = $request->date;

    $visit->customer_name = $request->cust_name;
    $visit->address = $request->address;
    $visit->city = $request->city;
    $visit->state = $request->state;

    $visit->product = $request->product;
    $visit->problem = $request->problem;

    $visit->system_status = $request->system;
    $visit->call_status = $request->status;

    $visit->equipment_type = $request->equipment_type;
    $visit->make = $request->make;
    $visit->serial_no = $request->serial_no;

    $visit->reported = $request->reported;
    $visit->location = $request->location;

    $visit->serviceDate = $request->sDate;
    $visit->servicetime = $request->time;

    $visit->rendered = $request->rendered;

    $visit->save();

    return back()->with('success', 'Visit saved successfully');
}

    /**
     * Display the specified resource.
     */
   public function show($id)
{
    $visit = cctvVisit::findOrFail($id);

    return view('cctv.cctv_print', compact('visit'));
}

// pdf format

public function pdf($id)
{
    $visit = cctvVisit::findOrFail($id);

    $pdf = Pdf::loadView('cctv.cctv_pdf', compact('visit'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('CCTV_Service_Report_'.$visit->id.'.pdf');
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
   public function destroy($id)
{
    $visit = cctvVisit::findOrFail($id);
    $visit->delete();

    return redirect()
        ->route('cctv.index')
        ->with('success', 'Visit deleted successfully');
}

}
