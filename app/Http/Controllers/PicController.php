<?php

namespace App\Http\Controllers;

use App\Models\pic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorepicRequest;
use App\Http\Requests\UpdatepicRequest;
use Illuminate\Support\Facades\Validator;

class PicController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware(['auth','verified']);
 
     }
 
   
    public function index()
    {
        // $pic=pic::find(1);

        $comppic = pic::where('firm_id',Auth::user()->firm_id)->first();
        if (!$comppic) {
            $comppic = new pic();

            $comppic->logo=null;
            $comppic->qrcode=null;
            $comppic->seal=null;
            $comppic->signature=null;
            $comppic->brand=null;
            $comppic->save();
        }


        // show the image url 
        // return view('setting.comp_pic_form',['comppic'=> $pic]);
        return view('setting.comp_pic_form',['comppic' =>$comppic]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    
     public function store(Request $request)
    {

        //  dd($request->all());
        // dd($request->file('comp_logo')->getExtension());
        // dd($request->file('comp_logo')->getExtension());
    //    dd($request->file('comp_logo')->getClientOriginalName());
    //     dd($request->file('comp_qrcode')->getClientOriginalName());

    // foreach ($request->file('comp_logo') as $file) {
    //     dd($file->getClientOriginalName());
    // }
    
    // foreach ($request->file('comp_qrcode') as $file) {
    //     dd($file->getClientOriginalName());
    // }
    
        //  dd($request->file('comp_logo')->getClientOriginalExtension());

        
        //  return $request->file('comp_logo')->store('public\uploads');
        // $pic = new Pic();

        // $image=$request->comp_logo;
        // $name=$image->getClientOriginalName();
        // $image->storeAS('public\image',$name);
        // $image_save=new pic;
        // $image_save->logo=$name;
        // $image_save->save();
         // $image_save=new pic;
        $comppic = pic::where('firm_id',Auth::user()->firm_id)->first();
        $image=$request->comp_logo;
        $name=$image->getClientOriginalName();
        $image->storeAS('public\image',$name);
      
      
        // $image2=$request->comp_qrcode;
        // $name2=$image2->getClientOriginalName();
        // $image2->storeAS('public\image',$name2);

        // $comppic->qrcode=$name2;
        $comppic->logo=$name;
        $comppic->update();
        return view('setting.comp_pic_form',['comppic' =>$comppic]);

    }

    public function comp_pic_qrstore(Request $request)
    {      
        $comppic = pic::where('firm_id',Auth::user()->firm_id)->first();
        $image=$request->comp_qr;
        $name=$image->getClientOriginalName();
        $image->storeAS('public\image',$name);
        $comppic->qrcode=$name;
        $comppic->update();

       return view('setting.comp_pic_form',['comppic' =>$comppic]);

    }
    public function comp_pic_sealstore(Request $request)
    {      
        $comppic = pic::where('firm_id',Auth::user()->firm_id)->first();
        $image=$request->comp_seal;
        $name=$image->getClientOriginalName();
        $image->storeAS('public\image',$name);
        $comppic->seal=$name;
        $comppic->update();

       return view('setting.comp_pic_form',['comppic' =>$comppic]);

    }

    public function comp_pic_signaturestore(Request $request)
    {      
        $comppic = pic::where('firm_id',Auth::user()->firm_id)->first();
        $image=$request->comp_signature;
        $name=$image->getClientOriginalName();
        $image->storeAS('public\image',$name);
        $comppic->signature=$name;
        $comppic->update();

       return view('setting.comp_pic_form',['comppic' =>$comppic]);

    } 
    public function comp_pic_brandstore(Request $request)
    {      
        $comppic = pic::where('firm_id',Auth::user()->firm_id)->first();
        $image=$request->comp_brand;
        $name=$image->getClientOriginalName();
        $image->storeAS('public\image',$name);
        $comppic->brand=$name;
        $comppic->update();

       return view('setting.comp_pic_form',['comppic' =>$comppic]);

    } 

   
}
