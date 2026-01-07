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

// ============================store for cresher====================================
public function store(Request $request)
{
    // ================= VALIDATION =================
    $request->validate([

        'pic'               => 'required |image|mimes:jpg,jpeg,png|max:2048',
        'Quantity'        => 'required',
        'Material'        => 'required',
        'vehicle_no'      => 'required',
        'party_name'      => 'required',
    ]);

    // ================= CREATE =================
    $crusher = new Cresher();

    // Auto slip number
    $crusher->slip_no = (Cresher::max('slip_no') ?? 0) + 1;

    // Basic
    $crusher->date = $request->date;
    $crusher->time = $request->time;
    $crusher->acc_id          = $request->search_id;

    // Party & Vehicle
    $crusher->party_name      = $request->party_name;
    $crusher->vehicle_no      = $request->vehicle_no;
    $crusher->vehicle_measure = $request->vehicle_measure;

    // Material
    $crusher->Material       = $request->Material;
    $crusher->Materialremark = $request->Materialremark;
    $crusher->unit           = $request->unit;
    $crusher->Quantity       = $request->Quantity;
    $crusher->Rate           = $request->Rate;

    // Royalty
    $crusher->Royalty_Quantity = $request->Royalty_Quantity;
    $crusher->Royalty_Rate     = $request->Royalty_Rate;
    $crusher->Royalty          = $request->Royalty;

    // Financial
    $crusher->Total       = $request->total;

    // Contact
    $crusher->address = $request->address;
    $crusher->phone   = $request->phone;

    // Remark
    $crusher->remark = $request->remark;
    // ================= VEHICLE ID (SAFE DEFAULT) =================
$crusher->vehicle_id = $request->vehicle_id ?: null;


    // Operators (your af fields)
    $crusher->af3 = $request->loader;
    $crusher->af4 = $request->Driver;
    $crusher->af5 = $request->supervisor;
    $crusher->af6 = $request->payment_type;
$crusher->af7          = $request->rst;
$crusher->af8  = $request->grand_total;


    // ================= IMAGE =================
 if ($request->hasFile('pic')) {

    $pic_image = $request->pic;
    $name = $pic_image->getClientOriginalName();

    $pic_image->storeAs('public/account_image', $name);

    $crusher->pic = $name;
}

// ================= SAVE =================
$crusher->save();


    // ================= AJAX RESPONSE =================
    return response()->json([
        'success' => true,
        'message' => 'Material Challan saved successfully',
        'redirect' => route('crusher.show', $crusher->id),
    ]);
}


/**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $crusher = Cresher::findOrFail($id);

    // ================= VALIDATION =================
    $request->validate([
       
        'Rate'             => 'nullable|numeric',
        'Royalty'          => 'nullable|numeric',
        'Total'            => 'nullable|numeric',
        'address'          => 'nullable|string',
        'phone'            => 'nullable|string|max:20',
        'remark'           => 'nullable|string',

        // 🔹 operator fields
        'loader'           => 'nullable|string|max:255',
        'driver'           => 'nullable|string|max:255',
        'supervisor'       => 'nullable|string|max:255',

    ]);

    // ================= BASIC =================
    $crusher->date  = $request->date;
    $crusher->time  = $request->time;

    // ================= VEHICLE =================
    $crusher->vehicle_no      = $request->vehicle_no;
    $crusher->party_name      = $request->party_name;
    $crusher->vehicle_measure = $request->vehicle_measure;

    // ================= MATERIAL =================
    $crusher->Material        = $request->Material;
    $crusher->Materialremark  = $request->Materialremark;
    $crusher->unit            = $request->unit;
    $crusher->Quantity        = $request->Quantity;
    $crusher->Rate            = $request->Rate;

    // ================= ROYALTY =================
    $crusher->Royalty_Quantity = $request->Royalty_Quantity;
    $crusher->Royalty_Rate     = $request->Royalty_Rate;
    $crusher->Royalty          = $request->Royalty;

    // ================= FINANCIAL =================
    $crusher->Total = $request->Total;

    // ================= CONTACT =================
    $crusher->address = $request->address;
    $crusher->phone   = $request->phone;

    // ================= REMARK =================
    $crusher->remark = $request->remark;

    // ================= OPERATOR DETAILS (FIXED) =================
    $crusher->af3 = $request->loader;
    $crusher->af4 = $request->driver;
    $crusher->af5 = $request->supervisor;
  $crusher->af6 = $request->payment_type;
$crusher->af7          = $request->rst;
$crusher->af8  = $request->grand_total;
    // ================= IMAGE =================
   if ($request->hasFile('pic')) {

    $pic_image = $request->pic;
    $name = $pic_image->getClientOriginalName();

    $pic_image->storeAs('public/account_image', $name);

    $crusher->pic = $name;
}

// ================= SAVE =================
$crusher->save();
    return redirect()
        ->route('crusher.index')
        ->with('success', 'Material Challan updated successfully!');
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


// ============================= vehicle detail entry part============================

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

            return redirect()->route('vehicledetail.index')->with('success', 'Vehicle details saved successfully');
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
 
   public function show($id)
{
    $crusher = Cresher::findOrFail($id);
    return view('crusher.cresher_print', compact('crusher'));
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
}
