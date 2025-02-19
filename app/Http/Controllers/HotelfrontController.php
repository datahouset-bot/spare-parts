<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\pic;
use App\Models\item;
use App\Models\room;
use App\Models\package;
use App\Models\roomtype;
use App\Models\gstmaster;
use App\Models\componyinfo;
use App\Models\roombooking;
use App\Models\roomcheckin;
use Illuminate\Http\Request;
use App\Models\softwarecompany;

class HotelfrontController extends Controller
{
    public function index($firm_id)
    { $firm_cominfo=componyinfo::where("firm_id", $firm_id)->first();
        $firm_pic=pic::where("firm_id", $firm_id)->first();
        $softwarecompany=softwarecompany::where("firm_id", $firm_id)->first();
   
        
        return view('hotelfront.hotel_front_index',compact('firm_cominfo','firm_pic','firm_id','softwarecompany'));
    }
    
    public function about($firm_id)
     {
    return view('hotelfront.hotel_front_about',compact('firm_id')); 
     }       

    public function room($firm_id) {
        $record=package::where("firm_id", $firm_id)->get();
        $record1=gstmaster::where("firm_id", $firm_id)->get();
        $record2 =roomtype::with('package','gstmaster')
        ->where("firm_id", $firm_id)->get();
        $record3 = Room::where("firm_id", $firm_id)->get();
     
          return view('hotelfront.hotel_front_room',['data'=>$record,'data1'=>$record1,'data2'=>$record2,'data3'=>$record3,'firm_id'=>$firm_id]); 



    }

    public function gallery ($firm_id) {
        return view('hotelfront.hotel_front_gallery',compact('firm_id'));
    }

    public function blog($firm_id) {
        $firm_cominfo=componyinfo::where("firm_id", $firm_id)->first();
        $firm_pic=pic::where("firm_id", $firm_id)->first();
        $itemdata=item::where('firm_id',$firm_id)->orderBy('item_group','asc')->get();
        return view('hotelfront.hotel_front_blog',compact('firm_id','itemdata','firm_pic','firm_cominfo'));
    }

     public function contact($firm_id) {
        return view('hotelfront.hotel_front_contact',compact('firm_id'));
    }

}
