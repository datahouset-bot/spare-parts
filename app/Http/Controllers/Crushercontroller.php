<?php

namespace App\Http\Controllers;

use App\Models\account;
use App\Models\cresher;
use Illuminate\Http\Request;
use App\Models\vehicledetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    // =====================use to show Vehicle detail entry========================

public function Vehicledetail(){
    return view('crusher.vehicledetail_entry');
}

  public function vehicledetailstore(Request $request)  
{
    $validate = Validator::make($request->all(), [
        'vehicle_name'      => 'required|string|max:255',
        'owner_name'        => 'required|string|max:255',
        'Vehicle_no'        => 'required|string|max:50|unique:vehicledetail,Vehicle_no',
        'Registration_date' => 'required|date',

        'Driver_name'       => 'required|string|max:255',
        'Driver_contact'    => 'required|string|max:20',
        'Driver_address'    => 'nullable|string|max:255',
        'model_year'        => 'required|string|max:10',

        'Insaurance'        => 'nullable|string|max:255',
        'Puc'               => 'nullable|string|max:255',
    ]);

    if ($validate->passes()) {

        $vehicle = new vehicledetail();

        // ✅ vehicle details
        $vehicle->vehicle_name       = $request->vehicle_name;
        $vehicle->owner_name         = $request->owner_name;
        $vehicle->Vehicle_no         = $request->Vehicle_no;
        $vehicle->Registration_date  = $request->Registration_date;

        // ✅ driver details
        $vehicle->Driver_name        = $request->Driver_name;
        $vehicle->Driver_contact     = $request->Driver_contact;
        $vehicle->Driver_address     = $request->Driver_address;
        $vehicle->model_year         = $request->model_year;

        // ✅ optional details
        $vehicle->Insaurance         = $request->Insaurance;
        $vehicle->Puc                = $request->Puc;

        // ❌ additional fields intentionally excluded (af3–af9)

        $vehicle->save();

        // ✅ resource redirect
        return redirect()

            ->with('success', 'Vehicle details saved successfully');
    }
    else {
        return redirect()->back()
            ->withErrors($validate)
            ->withInput();
    }
}




    public function create()
    {
        $account = account::where('firm_id', Auth::user()->firm_id)->get();
        $nextSlip = (cresher::max('slip_no') ?? 0) + 1;
return view('crusher.cresher_entry', compact('account','nextSlip'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'vehicle_no' => 'required',
            'party_name' => 'required',
            'Vehicle_name' => 'required|string|max:255',
            'vehicle_no' => 'required|string|max:255',
            'pic' => 'nullable|file|mimes:jpg,jpeg,png,pdf',

        ]);

        if ($validate->passes()) {
             $lastSlip = cresher::max('slip_no');
        $slipNo = $lastSlip ? $lastSlip + 1 : 1;

            $crusher = new cresher();
            // save the data
            $crusher->account_id = $request->search_id;
            $crusher->slip_no =  $slipNo;
            $crusher->date = $request->date;
            $crusher->time = $request->time;
            $crusher->vehicle_no = $request->vehicle_no;
            $crusher->party_name = $request->party_name;
            $crusher->Vehicle_name = $request->Vehicle_name;
            $crusher->Material = $request->Material;
            $crusher->Royalty = $request->Royalty;
            $crusher->Quantity = $request->Quantity;
            $crusher->address = $request->address;
            $crusher->phone = $request->phone;
            $crusher->remark = $request->remark;
            // to save the image

            if ($request->hasFile('pic')) {
                $file = $request->file('pic');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/crusher'), $filename);
                $crusher->pic = $filename;
            }

            // save the data

            $crusher->save();
            return response()->
         json(['message'=>'Material challan successfully!'],200);
        } else {
            // make model
            return response()->json(['errors' => $validate->errors(), 'message' => 'Validation failed'], 422);
        }
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
