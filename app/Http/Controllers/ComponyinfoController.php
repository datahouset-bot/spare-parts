<?php

namespace App\Http\Controllers;

use App\Models\componyinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorecomponyinfoRequest;
use App\Http\Requests\UpdatecomponyinfoRequest;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ComponyinfoController extends CustomBaseController
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
        //
    }

    public function show_form()
    {
        $companyInfo = componyinfo::where('firm_id',Auth::user()->firm_id)->first();
        if (!$companyInfo) {
            $companyInfo = new componyinfo();
            $companyInfo->firm_id=Auth::user()->firm_id;
            $companyInfo->cominfo_firm_name= 0;
            $companyInfo->cominfo_address1=null;
                $companyInfo->cominfo_address2=null;
                $companyInfo->cominfo_city=null;
            $companyInfo->cominfo_pincode=null;
               $companyInfo->cominfo_state=null;
             $companyInfo->cominfo_phone=null;
             $companyInfo->cominfo_mobile=null;
              $companyInfo->cominfo_email=null;
             $companyInfo->cominfo_gst_no=null;
              $companyInfo->cominfo_pencard=null;
               $companyInfo->cominfo_field1=null;
              $companyInfo->cominfo_field2=null;
              $companyInfo->gst_notapplicable=null;
              $companyInfo->make_all_bill_local_gst=null;
              $companyInfo->componyinfo_af1=null;  //use for aspected checkoutdate option  on room checkin
              
              //5 additional field is empty 

            // Set other fields to null or default values 
            // Example: $companyInfo->field_name = null;
            $companyInfo->save();
        } 
        return view('setting.company_info_form',['companyInfo' => $companyInfo]);

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
        'cominfo_firm_name' => 'required',
        
        ]);
    if($validator->passes())
       {
  
        $companyInfo = componyinfo::where('firm_id',Auth::user()->firm_id)->first();
        
            //    $companyInfo=new componyinfo;
               $companyInfo->firm_id=Auth::user()->firm_id;
               $companyInfo->cominfo_firm_name=$request->cominfo_firm_name;
               $companyInfo->cominfo_address1=$request->cominfo_address1;
               $companyInfo->cominfo_address2=$request->cominfo_address2;
               $companyInfo->cominfo_city=$request->cominfo_city;
               $companyInfo->cominfo_pincode=$request->cominfo_pincode;
               $companyInfo->cominfo_state=$request->cominfo_state;
               $companyInfo->cominfo_phone=$request->cominfo_phone;
               $companyInfo->cominfo_mobile=$request->cominfo_mobile;
               $companyInfo->cominfo_email=$request->cominfo_email;
               $companyInfo->cominfo_gst_no=$request->cominfo_gst_no;
               $companyInfo->cominfo_pencard=$request->cominfo_pencard;
               $companyInfo->cominfo_field1=$request->cominfo_field1;
               $companyInfo->cominfo_field2=$request->cominfo_website;
               $companyInfo->gst_notapplicable=$request->gst_notapplicable;
              $companyInfo->make_all_bill_local_gst=$request->make_all_bill_local_gst;
              $companyInfo->componyinfo_af1=$request->requierd_aspedted_checkout;  
              $companyInfo->componyinfo_af10=$request->componyinfo_af10;   // hoptel code 
             $companyInfo->componyinfo_af2=$request->componyinfo_af2; //Enable Channel Manager  
             $companyInfo->componyinfo_af3=$request->componyinfo_af3; //channel manager hotel code 
             $companyInfo->componyinfo_af4=$request->componyinfo_af4; //Owner Mobile No For Getting Whatsapp  

               
               $companyInfo->update();
            return view('setting.company_info_form',['companyInfo' => $companyInfo])->with('message', 'Record Upaded Successfully!');
       }

       else{
        return redirect('/company_info_form')->withInput()->withErrors($validator)->with('message', 'Record Not Upaded !');
    
          }


    }

    
}