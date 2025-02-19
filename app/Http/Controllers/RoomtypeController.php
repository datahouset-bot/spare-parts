<?php

namespace App\Http\Controllers;
use App\Models\package;
use App\Models\roomtype;
use App\Models\gstmaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreroomtypeRequest;
use App\Http\Requests\UpdateroomtypeRequest;

class RoomtypeController extends CustomBaseController
{
    public function index()
    {
         $record=package::where('firm_id',Auth::user()->firm_id)->get();
         $record1=gstmaster::where('firm_id',Auth::user()->firm_id)->get();
         $record2 =roomtype::where('firm_id',Auth::user()->firm_id)->with('package','gstmaster')->get();


        return view('room_master.roomtype',['data'=>$record,'data1'=>$record1,'data2'=>$record2]); 


        

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
        // echo "<pre>";
        // print_r($request->all());

        $validator= validator::make($request->all(),[
            'roomtype_name' => 'required',
            'package_id'=>'required',
            'gst_id'=>'required',
            'room_tariff'=>'required|numeric'
             
            ]);
            if ($validator->passes()) {
                $roomtype = new roomtype;
                $roomtype->firm_id=Auth::user()->firm_id;
                $roomtype->roomtype_name = $request->roomtype_name;
                $roomtype->package_id=$request->package_id;
                $roomtype->gst_id=$request->gst_id;
                $roomtype->room_tariff=$request->room_tariff;
                $roomtype->room_dis=$request->room_dis;

                $roomtype->save();
        
                return redirect('/roomtypes')->with('message', 'Room Type Created successfully!');
            } else {
                return redirect('/roomtypes')->withInput()->withErrors($validator);
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
        $record = Package::where('firm_id',Auth::user()->firm_id)->get();
        $record1 = GstMaster::where('firm_id',Auth::user()->firm_id)->get();
        $record2 = RoomType::where('firm_id',Auth::user()->firm_id)->findOrFail($id);

        return view('room_master.roomtype_edit', compact('record2', 'record1', 'record'));

 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'roomtype_name' => 'required',
            'package_id'=>'required',
            'gst_id'=>'required',
            'room_tariff'=>'required|numeric'
             
        ]);

        $roomtype = roomtype::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        $roomtype->update($request->all());

        return redirect()->route('roomtypes.index')->with('message', 'Room Type Updated Successfully.');
    }
   
     
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roomtype = roomtype::where('firm_id',Auth::user()->firm_id)->find($id);

        // Check if the roomtype exists
        if ($roomtype) {
            // Delete the roomtype
            $roomtype->delete();
            return redirect('/roomtypes')->with('message', 'roomtype Delete successfully!');
        } else {
            // roomtype not found
            return redirect('/roomtypes')->with('message', 'roomtype Not Found');

        }
    }

}
