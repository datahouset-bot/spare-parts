<?php

namespace App\Http\Controllers;

use App\Models\componyinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $companyInfo = componyinfo::find(1);
        if (!$companyInfo) {
            $companyInfo = new componyinfo();
            $companyInfo->id = 1;
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
    // echo "<pre>";
    // print_r($request->all());
   
    $validator= validator::make($request->all(),[
        'cominfo_firm_name' => 'required',
        
        ]);
    if($validator->passes())
       {
  
        $companyInfo = componyinfo::find(1);
            //    $companyInfo=new componyinfo;
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
               
               $companyInfo->update();
            return view('setting.company_info_form',['companyInfo' => $companyInfo])->with('message', 'Record Upaded Successfully!');
       }

       else{
        return redirect('/company_info_form')->withInput()->withErrors($validator)->with('message', 'Record Not Upaded !');
    
          }


    }

    /**
     * Display the specified resource.
     */
    public function show(componyinfo $componyinfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(componyinfo $componyinfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecomponyinfoRequest $request, componyinfo $componyinfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   
}