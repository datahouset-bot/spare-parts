<?php

namespace App\Http\Controllers;

use Storage;
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

// =====================use to store Vehicle detail entry========================
 public function vehicledetailstore(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'vehicle_name'      => 'required|string|max:255',
            'owner_name'        => 'required|string|max:255',
            'Vehicle_no'        => 'nullable|string',
            'Registration_date' => 'nullable|date',
        ]);

        if ($validate->passes()) {

            $vehicle = new vehicledetail();

            // ✅ vehicle details
            $vehicle->vehicle_name      = $request->vehicle_name;
            $vehicle->owner_name        = $request->owner_name;
            $vehicle->Vehicle_no        = $request->Vehicle_no;
            $vehicle->vehicle_measure   = $request->vehicle_measure;
            $vehicle->Registration_date = $request->Registration_date;

            // ✅ driver details
            $vehicle->Driver_name       = $request->Driver_name;
            $vehicle->Driver_contact    = $request->Driver_contact;
            $vehicle->Driver_address    = $request->Driver_address;
            $vehicle->model_year        = $request->model_year;

            // ✅ optional
            $vehicle->Insaurance        = $request->Insaurance;
            $vehicle->Puc               = $request->Puc;

            $vehicle->save();

            return redirect()->back()->with('success', 'Vehicle details saved successfully');
        }

        return redirect()->back()
            ->withErrors($validate)
            ->withInput();
    }

public function vehicledetailindex()
    {
        $vehicles = vehicledetail::latest()->get();
        return view('crusher.vehicledetail_index', compact('vehicles'));
    }


public function vehicledetailcreate()
    {
        return view('crusher.vehicledetail_entry');
    }

    public function create()
    {   $vehicle = vehicledetail::get();
        $account = account::where('firm_id', Auth::user()->firm_id)->get();
        $nextSlip = (cresher::max('slip_no') ?? 0) + 1;
return view('crusher.cresher_entry', compact('account','nextSlip','vehicle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'party_name' => 'required',
            'vehicle_no' => 'required|string|max:255',
            'pic' => 'nullable|file|mimes:jpg,jpeg,png,pdf',

        ]);

        if ($validate->passes()) {
             $lastSlip = cresher::max('slip_no');
        $slipNo = $lastSlip ? $lastSlip + 1 : 1;

            $crusher = new cresher();
            // save the data
            $crusher->vehicle_id = $request->vehicle_id;
            $crusher->account_id = $request->search_id;
            $crusher->slip_no =  $slipNo;
            $crusher->date = $request->date;
            $crusher->time = $request->time;
            $crusher->vehicle_no = $request->vehicle_no;
            $crusher->party_name = $request->party_name;
            $crusher->Vehicle_measure = $request->Vehicle_measure;
            $crusher->Material = $request->Material;
            $crusher->Royalty = $request->Royalty;
            $crusher->Rate = $request->rate;
            $crusher->Total = $request->total;
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
   public function show($id)
{
    $crusher = Cresher::findOrFail($id);
    return view('crusher.cresher_show', compact('crusher'));
}
    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    $crusher = Cresher::findOrFail($id);
    return view('crusher.cresher_edit', compact('crusher'));
}


// ===============================to open vehicle detail edit page============================
public function vehicledetailedit($id)
{
    $vehicle = vehicledetail::findOrFail($id);
    return view('crusher.vehicledetail_edit', compact('vehicle'));
}
 // ===============================to delete vehicle detail============================
 public function vehicledetaildestroy($id)
{
    $vehicle = vehicledetail::findOrFail($id);

    $vehicle->delete();

    return redirect()
        ->route('vehicledetail.index')
        ->with('success', 'Vehicle detail deleted successfully!');
}
// ==============================to update vehicle detail============================
public function vehicledetailupdate(Request $request, $id)
{
    $request->validate([
        'vehicle_name' => 'required',
        'Vehicle_no'   => 'required',
    ]);
    $vehicle = vehicledetail::findOrFail($id);  
     $vehicle->update([
        'vehicle_name'      => $request->vehicle_name,
        'owner_name'        => $request->owner_name,
        'Vehicle_no'        => $request->Vehicle_no,
        'vehicle_measure'   => $request->vehicle_measure,
        'Registration_date' => $request->Registration_date,
        'model_year'        => $request->model_year,
        'Driver_name'       => $request->Driver_name,
        'Driver_contact'    => $request->Driver_contact,
        'Driver_address'    => $request->Driver_address,
        'Insaurance'        => $request->Insaurance,
        'Puc'               => $request->Puc,
    ]);

    return redirect()
        ->route('vehicledetail.index')
        ->with('success', 'Vehicle detail updated successfully');
}

/**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $crusher = Cresher::findOrFail($id);

    // fields
    $crusher->party_name      = $request->party_name;
    $crusher->vehicle_measure = $request->vehicle_measure;
    $crusher->Material        = $request->Material;
    $crusher->Quantity        = $request->Quantity;
    $crusher->Rate            = $request->Rate;
    $crusher->Royalty         = $request->Royalty;
    $crusher->Total           = $request->total;
    $crusher->phone           = $request->phone;
    $crusher->remark          = $request->remark;

    // image
    if ($request->hasFile('pic')) {
        if ($crusher->pic && file_exists(public_path('uploads/crusher/'.$crusher->pic))) {
            @unlink(public_path('uploads/crusher/'.$crusher->pic));
        }

        $file = $request->file('pic');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/crusher'), $filename);

        $crusher->pic = $filename;
    }

    $crusher->save();  // ✅ single save

    return redirect()
        ->route('crusher.index')
        ->with('success', 'Challan updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */

public function destroy($id)
{
    // Special "delete all" case
    if ($id === 'all') {
        // Option 1: delete everything & reset IDs
        Cresher::truncate();

        // Option 2 (if you don't want to reset auto-increment):
        // Crusher::query()->delete();

        return redirect()
            ->route('crusher.index')
            ->with('success', 'All challan records deleted successfully.');
    }

    // Normal single delete
    $crusher = Cresher::findOrFail($id);
    $crusher->delete();

    return redirect()
        ->route('crusher.index')
        ->with('success', 'Challan deleted successfully.');
}
}
