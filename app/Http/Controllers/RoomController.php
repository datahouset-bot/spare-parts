<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\room;
use App\Models\package;
use App\Models\roomtype;
use App\Models\gstmaster;
use App\Models\roombooking;
use App\Models\roomcheckin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {    $record=package::where('firm_id',Auth::user()->firm_id)->get();
        $record1=gstmaster::where('firm_id',Auth::user()->firm_id)->get();
        $record2 =roomtype::with('package','gstmaster')
        ->where('firm_id',Auth::user()->firm_id)->get();
        $record3 = Room::where('firm_id',Auth::user()->firm_id)->get();
          return view('room_master.room',['data'=>$record,'data1'=>$record1,'data2'=>$record2,'data3'=>$record3]); 
    
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 // Validate the incoming request
 $request->validate([
    'room_no' => 'required|string|max:255',
    'roomtype_id' => 'required|exists:roomtypes,id',
    // 'room_floor' => 'required|integer',
    'room_facilities' => 'nullable|string|max:255',
    'room_image1' => 'nullable|image|max:2048',
    'room_image2' => 'nullable|image|max:2048',
    'room_image3' => 'nullable|image|max:2048',
]);

// Create a new Room instance
$room = new Room();
$room->firm_id=Auth::user()->firm_id;
$room->room_no = $request->room_no;
$room->roomtype_id = $request->roomtype_id;
$room->room_floor = $request->room_floor;
$room->room_facilities = $request->room_facilities;

// Define the upload path
$uploadPath = 'uploads/room_image';

// Store the images with their original names if they exist
if ($request->hasFile('room_image1')) {

    $room_image1=$request->room_image1;
    $name=$room_image1->getClientOriginalName();
    $room_image1->storeAS('public\room_image',$name);
    $room->room_image1=$name;

}
if ($request->hasFile('room_image2')) {
    $room_image2=$request->room_image2;
    $name=$room_image2->getClientOriginalName();
    $room_image2->storeAS('public\room_image',$name);
    $room->room_image2=$name;

}
if ($request->hasFile('room_image3')) {
    $room_image3=$request->room_image3;
    $name=$room_image3->getClientOriginalName();
    $room_image3->storeAS('public\room_image',$name);
    $room->room_image3=$name;

}

// Save the Room instance to the database
$room->save();

// Redirect back with a success message
return redirect()->route('rooms.index')->with('message', 'Room added successfully.');
}
public function edit($room_id)
{

    $room=room::where('id',$room_id)->where('firm_id',Auth::user()->firm_id)->first();
    $package=package::where('firm_id',Auth::user()->firm_id)->get();
    $gstmaster=gstmaster::where('firm_id',Auth::user()->firm_id)->get();
    $roomtype =roomtype::with('package','gstmaster')->where('firm_id',Auth::user()->firm_id)->get();
    return view ('room_master.room_edit',compact('room','package','gstmaster','roomtype'));


}    
public function Update (Request $request,string $id){

    $request->validate([
        'room_no' => 'required|string|max:255',
        'roomtype_id' => 'required|exists:roomtypes,id',
        'room_floor' => 'required|integer',
        'room_facilities' => 'nullable|string|max:255',
        'room_image1' => 'nullable|image|max:2048',
         'room_image2' => 'nullable|image|max:2048',
         'room_image3' => 'nullable|image|max:2048',
    ]);
    

    $room = room::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
    $room->room_no = $request->room_no;
    $room->roomtype_id = $request->roomtype_id;
    $room->room_floor = $request->room_floor;
    $room->room_facilities = $request->room_facilities;

// Define the upload path
$uploadPath = 'uploads/room_image';

// Store the images with their original names if they exist
if ($request->hasFile('room_image1')) {

    $room_image1=$request->room_image1;
    $name=$room_image1->getClientOriginalName();
    $room_image1->storeAS('public\room_image',$name);
    $room->room_image1=$name;

}
if ($request->hasFile('room_image2')) {
    $room_image2=$request->room_image2;
    $name=$room_image2->getClientOriginalName();
    $room_image2->storeAS('public\room_image',$name);
    $room->room_image2=$name;

}
if ($request->hasFile('room_image3')) {
    $room_image3=$request->room_image3;
    $name=$room_image3->getClientOriginalName();
    $room_image3->storeAS('public\room_image',$name);
    $room->room_image3=$name;

}

// Save the Room instance to the database
$room->update();



    return redirect()->route('rooms.index')->with('message', 'Room updated successfully.');


}

    public function mark_room_dirty()
    {
        $rooms = Room::with(['roomtype.gstmaster', 'roomtype.package'])->where('firm_id',Auth::user()->firm_id)->get();
        return view('entery.room.room_mark_dirty', compact('rooms'));    
    }
    public function change_status_dirty(Request $request)
    {
        
        $validator= validator::make($request->all(),[
            'selected_room_id' => 'required',
            
            ]);
            if ($validator->passes()) {
              $selected_room_ids=$request->selected_room_id;
              foreach ($selected_room_ids as $record ) {
                $room_id=$record;
                Room::where('id', $room_id)->where('firm_id',Auth::user()->firm_id)->update(['room_status' => 'dirty']);
              }
        


                return redirect('/room_dashboard')->with('message', 'Record Updated  Succes fully!');
            } else {
                return redirect('/room_dashboard')->withInput()->withErrors($validator);
            }
    }

    


     public function destroy($room_id)
    {
        // Retrieve records from roomcheckin and roombooking tables
        $roomcheckin = roomcheckin::where('room_id', $room_id)->where('firm_id',Auth::user()->firm_id)->get();
        $roombooking = roombooking::where('room_id', $room_id)->where('firm_id',Auth::user()->firm_id)->get();
if ($roomcheckin->isEmpty()&& $roombooking->isEmpty()){
    $roomid = room::where('id',$room_id)->where('firm_id',Auth::user()->firm_id);
    $roomid->delete();
    return redirect('/rooms')->with('message', 'Room Delete successfully!');
}
        


     else {
            // Package not found
            return redirect('/rooms')->with('message', 'Room Not Found Or Use In Transection ');

        }
    }
    

    }

    

