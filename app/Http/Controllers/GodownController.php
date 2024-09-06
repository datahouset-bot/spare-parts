<?php

namespace App\Http\Controllers;

use App\Models\godown;
use App\Http\Requests\StoregodownRequest;
use App\Http\Requests\UpdategodownRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GodownController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record=godown::orderBy('godown_name', 'asc')->get();
        return view('master.godown',['data'=>$record]); 
 
    }






    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'godown_name' => 'required|unique:godowns',

        ]);


                    if ($validator->passes()) {
                $godown = new godown;
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
        $godown = godown::findOrFail($id);
  
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

        $godown =godown::findOrFail($id);
        $godown->update($request->all());

        return redirect()->route('godowns.index')->with('message', 'Record updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $godown = godown::find($id);

        // Check if the godown exists
        if ($godown) {
            if($godown->godown_name="Main Store"){
                return redirect('/godowns')->with('message', 'This Is Main Store So We Can Not Delete ');    
            }else{
                $godown->delete();
                return redirect('/godowns')->with('message', 'godown Delete successfully!');

            }
            
            
        } else {
            // godown not found
            return redirect('/godowns')->with('message', 'godown Not Found');

        }
    }
    
}
