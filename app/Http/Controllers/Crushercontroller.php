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

        'date'              => 'required|date',
        'time'              => 'required',
        'search_id'         => 'required|numeric',       // PARTY
        'vehicle_id'        => 'required|numeric',
        'vehicle_no'        => 'required|string',
        'party_name'        => 'required|string',
        'vehicle_measure'   => 'required',

        'Material'          => 'required|string',
        'Quantity'          => 'required|numeric',

        'Rate'              => 'nullable|numeric',
        'unit'              => 'nullable|string',

        'Royalty_Quantity'  => 'nullable|numeric',
        'Royalty_Rate'      => 'nullable|numeric',
        'Royalty'           => 'nullable|numeric',

        'total'             => 'nullable|numeric',

        'address'           => 'nullable|string',
        'phone'             => 'nullable|string',
        'remark'            => 'nullable|string',

     // max 2MB
    ]);

    if (!$validate->passes()) {
        return response()->json([
            'errors' => $validate->errors(),
            'message' => 'Validation failed'
        ], 422);
    }

    // Generate Slip No
    $lastSlip = cresher::max('slip_no');
    $slipNo = $lastSlip ? $lastSlip + 1 : 1;

    $crusher = new cresher();

    // BASIC
    $crusher->slip_no         = $slipNo;
    $crusher->date            = $request->date;
    $crusher->time            = $request->time;

    // FIXED: acc_id correct column
    $crusher->acc_id          = $request->search_id;

    // VEHICLE
    $crusher->vehicle_id      = $request->vehicle_id;
    $crusher->vehicle_no      = $request->vehicle_no;
    $crusher->party_name      = $request->party_name;
    $crusher->vehicle_measure = $request->vehicle_measure;

    // MATERIAL
    $crusher->Material        = $request->Material;
    $crusher->Materialremark  = $request->Materialremark;
    $crusher->Quantity        = $request->Quantity;
    $crusher->Rate            = $request->Rate;
    $crusher->unit            = $request->unit;

    // ROYALTY
    $crusher->Royalty_Quantity = $request->Royalty_Quantity;
    $crusher->Royalty_Rate     = $request->Royalty_Rate;
    $crusher->Royalty          = $request->Royalty;

    // TOTAL
    $crusher->Total        = $request->total;

    // CONTACT
    $crusher->address      = $request->address;
    $crusher->phone        = $request->phone;
    $crusher->remark       = $request->remark;

    // IMAGE (camera or file)
    if ($request->hasFile('pic')) 
    {
        $folder = public_path('uploads/crusher');

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $file = $request->file('pic');

        $filename = time().'_'.$file->getClientOriginalName();
        $file->move($folder, $filename);

        $crusher->pic = $filename;
    }

    $crusher->save();

    return response()->json([
        'message' => 'Material challan saved successfully!',
        'slip_no' => $slipNo,
    ], 200);
}




public function crusher_addstore(Request $request)
{
    // validate and return JSON (AJAX-friendly)
    $validator = Validator::make($request->all(), [
        'Vehicle_no'      => 'required|string|max:100',
        'vehicle_measure' => 'required|string|max:100',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        // Option A: explicit assign + save (no need for $fillable)
        $vehicle = new Vehicledetail();
        $vehicle->Vehicle_no = $request->input('Vehicle_no');
        $vehicle->vehicle_measure = $request->input('vehicle_measure');
        $vehicle->save();

        // return the saved model as JSON
        return response()->json([
            'message' => 'Vehicle added successfully',
            'data' => $vehicle
        ], 200);

    } catch (\Exception $e) {
        // log error server-side and return simple JSON error
        \Log::error('crusher_addstore error: '.$e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
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
