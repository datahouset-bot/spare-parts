<?php

namespace App\Http\Controllers;
use App\Models\unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreunitRequest;
use App\Http\Requests\UpdateunitRequest;
use Illuminate\Support\Facades\Validator;

class UnitController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record=unit::orderBy('primary_unit_name', 'asc')->where('firm_id',Auth::user()->firm_id)->get();
        return view('master.unit',['data'=>$record]); 
 
    }
    public function fetchUnits()
{
    $records = unit::orderBy('primary_unit_name', 'asc')->where('firm_id',Auth::user()->firm_id)->get();
    return response()->json($records);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function unit_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'primary_unit_name' => [
                'required',
                'unique:units,primary_unit_name,NULL,id,firm_id,' . auth()->user()->firm_id,
            ],
            'alternate_unit_name'=>'required',
             'conversion' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $unit = new unit;
            $unit->firm_id=Auth::user()->firm_id;
            $unit->primary_unit_name = $request->input('primary_unit_name');
            $unit->conversion = $request->input('conversion');
            $unit->alternate_unit_name = $request->input('alternate_unit_name');

            $unit->save();
            return response()->json([
                'status'=>200,
                'message'=>'Student Added Successfully.'
            ]);
        }

    }




    public function store(Request $request)
    {

$validator = Validator::make($request->all(), [
    'primary_unit_name' => [
        'required',
        'unique:units,primary_unit_name,NULL,id,firm_id,' . auth()->user()->firm_id,
    ],
    'conversion' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
]);


                    if ($validator->passes()) {
                $unit = new unit;
                $unit->firm_id=Auth::user()->firm_id;
                $unit->primary_unit_name = $request->primary_unit_name;
                $unit->conversion=$request->conversion;
                $unit->alternate_unit_name=$request->alternate_unit_name;

                $unit->save();
        
                return redirect('/units')->with('message', 'Unit created successfully!');
            } else {
                return redirect('/units')->withInput()->withErrors($validator);
            }

    }

    /**
     * Display the specified resource.
     */
    public function show(unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = unit::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
  
        return view('master.unit_edit', compact('unit'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'primary_unit_name' => 'required',
            'conversion' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $unit =unit::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        $unit->update($request->all());

        return redirect()->route('units.index')->with('message', 'unit updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = unit::where('firm_id',Auth::user()->firm_id)->find($id);

        // Check if the unit exists
        if ($unit) {
            // Delete the unit
            $unit->delete();
            return redirect('/units')->with('message', 'Unit Delete successfully!');
        } else {
            // unit not found
            return redirect('/units')->with('message', 'unit Not Found');

        }
    }
    public function storeAjax(Request $request)
{
    $request->validate([
        'primary_unit_name'   => 'required|string|max:255',
        'conversion'          => 'nullable|numeric|min:0',
        'alternate_unit_name' => 'nullable|string|max:255',
    ]);
try{
    $unit = Unit::create([
        'firm_id'             => Auth::user()->firm_id,
        'primary_unit_name'   => $request->primary_unit_name,
        'conversion'          => $request->conversion,
        'alternate_unit_name' => $request->alternate_unit_name,
    ]);} 
    catch(\Throwable $e){
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getline(),
            'file'=> $e->getfile(),
        ],500);

    }

    return response()->json([
        'id' => $unit->id,
        'primary_unit_name' => $unit->primary_unit_name,
        'conversion' => $unit->conversion,
        'alternate_unit_name' => $unit->alternate_unit_name,
    ]);
}

}
