<?php

namespace App\Http\Controllers;

use App\Models\godown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoregodownRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdategodownRequest;

class GodownController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record=godown:: where('firm_id',Auth::user()->firm_id)->orderBy('godown_name', 'asc')->get();
        return view('master.godown',['data'=>$record]); 
 
    }






    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'godown_name' => 'required|unique:godowns',

        ]);


                    if ($validator->passes()) {

                $godown = new godown;
                $godown->firm_id=Auth::user()->firm_id;
                $godown->godown_name = $request->godown_name;
                $godown->godown_address=$request->godown_address;


                $godown->save();
        
                return redirect('/godowns')->with('message', 'godown created successfully!');
            } else {
                return redirect('/godowns')->withInput()->withErrors($validator);
            }

    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $godown = godown::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
  
        return view('master.godown_edit', compact('godown'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'godown_name' => 'required',
            
        ]);

        $godown =godown::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        $godown->update($request->all());

        return redirect()->route('godowns.index')->with('message', 'Record updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $godown = Godown::where('firm_id', Auth::user()->firm_id)
            ->where('id', $id)
            ->first(); // Use first() to retrieve a single record instead of get()
        
        // Check if the godown exists
        if ($godown) {
            if ($godown->godown_name === "Main Store") { // Use === for comparison
                return redirect('/godowns')->with('message', 'This is the Main Store, so it cannot be deleted.');
            } else {
                $godown->delete();
                return redirect('/godowns')->with('message', 'Godown deleted successfully!');
            }
        } else {
            // Godown not found
            return redirect('/godowns')->with('message', 'Godown not found.');
        }
    }
    
    
}
