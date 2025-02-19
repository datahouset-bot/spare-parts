<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\businesssource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorebusinesssourceRequest;
use App\Http\Requests\UpdatebusinesssourceRequest;

class BusinesssourceController extends CustomBaseController
{
   
    public function index()
    {
        $record=businesssource::where('firm_id',Auth::user()->firm_id)->get();
        return view('room_master.business_source.business_source',['data'=>$record]); 
        // return view('room_master.business_source.business_source'); 
 

    }
    public function store(Request $request)
    {
        $validator= validator::make($request->all(),[
            'business_source_name' => 'required',

             
            ]);
            if ($validator->passes()) {
                $businesssource = new businesssource;
                $businesssource->firm_id=Auth::user()->firm_id;
                $businesssource->business_source_name = $request->business_source_name;
                $businesssource->buiness_source_remark=$request->buiness_source_remark;


                $businesssource->save();
        
                return redirect('/businesssources')->with('message', 'Business Source  created successfully!');
            } else {
                return redirect('/businesssources')->withInput()->withErrors($validator);
            }

        }

    public function edit(string $id)
    {
        $businesssource = businesssource::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        return view('room_master.business_source.business_source_edit', compact('businesssource'));
    
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'business_source_name' => 'required',
            'buiness_source_remark' => 'nullable'
  
        ]);

        $businesssource = businesssource::findOrFail($id);
        $businesssource->update($request->all());

        return redirect()->route('businesssources.index')->with('message', 'Business Source Updated successfully.');
    }


    public function destroy(string $id)
    {
        $businesssource = businesssource::where('firm_id',Auth::user()->firm_id)->find($id);

        // Check if the package exists
        if ($businesssource) {
            // Delete the package
            $businesssource->delete();
            return redirect('/businesssources')->with('message', 'Buiness Source  Delete successfully!');
        } else {
            // Buiness Source  not found
            return redirect('/businesssources')->with('message', 'Buiness Source  Not Found');

        }
    }

}
