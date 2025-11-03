<?php

namespace App\Http\Controllers;

use App\Models\kot;
use App\Models\roombooking;
use App\Models\roomcheckin;
use Illuminate\Http\Request;
use App\Models\financialyear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorefinancialyearRequest;
use App\Http\Requests\UpdatefinancialyearRequest;

class FinancialyearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        $record=financialyear::where('firm_id',Auth::user()->firm_id)->get();
        // dd($record);
        return view('financialyear.financialyear',['data'=>$record]); 
 

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
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'firm_id' => 'required|string',
        'financial_year' => 'required|string',
        'financial_year_start' => 'required|date',
        'financial_year_end' => 'required|date',
    ]);

    if ($validator->passes()) {
        $financialYear = new FinancialYear();
        $financialYear->firm_id = $request->firm_id;
        $financialYear->financial_year = $request->financial_year;
        $financialYear->financial_year_start = $request->financial_year_start;
        $financialYear->financial_year_end = $request->financial_year_end;
        $financialYear->is_active_fy = "0"; // checkbox

        $financialYear->save();

        return redirect()->route('financialyears.index')->with('message', 'Financial year created successfully!');
    } else {
        return redirect()->back()->withInput()->withErrors($validator);
    }
}


    /**
     * Display the specified resource.
     */
public function show(string $id)
{
    $firmId = Auth::user()->firm_id;
        $kots=kot::withinFY('voucher_date')->where('firm_id',Auth::user()->firm_id)->where('kots.status', '0')
        ->where('voucher_type'  ,'Kot')
        ->get();
        $Rkots=kot::withinFY('voucher_date')->where('firm_id',Auth::user()->firm_id)->where('kots.status', '0')
        ->where('voucher_type'  ,'RKot')
        ->get();

       $currentdate= now();
$roombookings = roombooking::withinFY('checkin_date')->where('firm_id', Auth::user()->firm_id)
    ->where('checkin_voucher_no', '0')
    ->where('checkin_date', '>', $currentdate)
    ->get();


       
        $roomcheckins=roomcheckin::withinFY('checkin_date')->where('firm_id',Auth::user()->firm_id)->where('checkout_voucher_no','0')->get();
        // dd($roomcheckins);

 if ($kots->count() > 0||$Rkots->count()>0 || $roomcheckins->count() > 0 ) {
return '<h1 style="color: red; font-weight: 800; text-align: center;">
    Cannot change financial year because  KOT / Room Check-ins are pending.<br> Please complete invoices first.
  <br>Pending KOT Records: ' . $kots->count() . '<br>, Pending Restaurant KOTs: ' . $Rkots->count() 
  . '<br>, Pending Room Check-ins: ' . $roomcheckins->count() . ',<br> Pending Bookings: ' . $roombookings->count() . '
    </h1>';


}


    // Set all financial years of this firm to inactive (0)
    FinancialYear::where('firm_id', $firmId)->update(['is_active_fy' => 0]);

    // Set only the selected financial year to active (1)
    FinancialYear::where('id', $id)->update(['is_active_fy' => 1]);

    return redirect()->route('financialyears.index')->with('message', 'Financial year activated successfully.');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = FinancialYear::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        return view('FinancialYear.FinancialYear_edit', compact('record'));

 
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, string $id)
{

    $request->validate([
        'firm_id' => 'required|string',
        'financial_year' => 'required|string',
        'financial_year_start' => 'required|date',
        'financial_year_end' => 'required|date',
    ]);

    $financialYear = FinancialYear::findOrFail($id);

    $financialYear->firm_id = $request->firm_id;
    $financialYear->financial_year = $request->financial_year;
    $financialYear->financial_year_start = $request->financial_year_start;
    $financialYear->financial_year_end = $request->financial_year_end;

    $financialYear->update();

    return redirect()->route('financialyears.index')->with('message', 'Financial year updated successfully!');
}

   
     
    /**
     * Remove the specified resource from storage.
     */
 public function destroy(string $id)
{
    $financialYear = FinancialYear::findOrFail($id);
    $financialYear->delete();

    return redirect()->route('financialyears.index')->with('message', 'Financial year deleted successfully.');
}


}
