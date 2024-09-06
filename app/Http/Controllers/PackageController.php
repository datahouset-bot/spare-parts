<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\package;
use Illuminate\Support\Facades\Validator;
class PackageController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record=package::all();
        return view('room_master.package',['data'=>$record]); 
 

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
        $validator= validator::make($request->all(),[
            'package_name' => 'required',
            'plan_name'=>'required'
             
            ]);
            if ($validator->passes()) {
                $package = new package;
                $package->package_name = $request->package_name;
                $package->plan_name=$request->plan_name;
                $package->other_name=$request->other_name;

                $package->save();
        
                return redirect('/packages')->with('message', 'Package created successfully!');
            } else {
                return redirect('/packages')->withInput()->withErrors($validator);
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
        $package = Package::findOrFail($id);
        return view('room_master.package_edit', compact('package'));
 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'package_name' => 'required',
            'plan_name' => 'required',
            'other_name' => 'required',
        ]);

        $package = Package::findOrFail($id);
        $package->update($request->all());

        return redirect()->route('packages.index')->with('message', 'Package updated successfully.');
    }
   
     
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = Package::find($id);

        // Check if the package exists
        if ($package) {
            // Delete the package
            $package->delete();
            return redirect('/packages')->with('message', 'Package Delete successfully!');
        } else {
            // Package not found
            return redirect('/packages')->with('message', 'Package Not Found');

        }
    }
        //
}

