<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\softwarecompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoresoftwarecompanyRequest;
use App\Http\Requests\UpdatesoftwarecompanyRequest;

class SoftwarecompanyController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $software_companyInfo = softwarecompany::where('firm_id',Auth::user()->firm_id)->first();
    
        if (!$software_companyInfo) 
        {
            $software_companyInfo = new softwarecompany();
           
            $software_companyInfo->activation_date = null;
            $software_companyInfo->expiry_date = null;
            $software_companyInfo->customer_firm_name = null;
            $software_companyInfo->customer_mobile = null;
            $software_companyInfo->customer_phone = null;
            $software_companyInfo->software_firm_name = null;
            $software_companyInfo->software_address1 = null;
            $software_companyInfo->software_address2 = null;
            $software_companyInfo->software_city = null;
            $software_companyInfo->software_pincode = null;
            $software_companyInfo->software_state = null;
            $software_companyInfo->software_phone = null;
            $software_companyInfo->software_mobile = null;
            $software_companyInfo->software_email = null;
            $software_companyInfo->software_website = null;
            $software_companyInfo->software_facebook = null;
            $software_companyInfo->software_youtube = null;
            $software_companyInfo->software_twitter = null;
            $software_companyInfo->software_logo1 = null;
            $software_companyInfo->software_logo2 = null;
            $software_companyInfo->software_logo3 = null;
            $software_companyInfo->software_logo4 = null;
            $software_companyInfo->software_af1 = null;
            $software_companyInfo->software_af2 = null;
            $software_companyInfo->software_af3 = null;
            $software_companyInfo->software_af4 = null;
            $software_companyInfo->software_af5 = null;
            $software_companyInfo->software_af6 = null;
            $software_companyInfo->software_af7 = null;
            $software_companyInfo->software_af8 = null;
            $software_companyInfo->software_af9 = null;
            $software_companyInfo->software_af10 = null;
    
            $software_companyInfo->save();
        }
    
        return view('setting.software_company_form', ['software_companyInfo' => $software_companyInfo]);
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
    $validator = Validator::make($request->all(), [
        'software_firm_name' => 'required',
        'customer_firm_name' => 'required',
    ]);

    if ($validator->passes()) 
    {
        $software_companyInfo = softwarecompany::where('firm_id',Auth::user()->firm_id)->first();


        $software_companyInfo->activation_date = $request->activation_date;
        $software_companyInfo->expiry_date = $request->expiry_date;
        $software_companyInfo->customer_firm_name = $request->customer_firm_name;
        $software_companyInfo->customer_mobile = $request->customer_mobile;
        $software_companyInfo->customer_phone = $request->customer_phone;
        $software_companyInfo->software_firm_name = $request->software_firm_name;
        $software_companyInfo->software_address1 = $request->software_address1;
        $software_companyInfo->software_address2 = $request->software_address2;
        $software_companyInfo->software_city = $request->software_city;
        $software_companyInfo->software_pincode = $request->software_pincode;
        $software_companyInfo->software_state = $request->software_state;
        $software_companyInfo->software_phone = $request->software_phone;
        $software_companyInfo->software_mobile = $request->software_mobile;
        $software_companyInfo->software_email = $request->software_email;
        $software_companyInfo->software_website = $request->software_website;
        $software_companyInfo->software_facebook = $request->software_facebook;
        $software_companyInfo->software_youtube = $request->software_youtube;
        $software_companyInfo->software_twitter = $request->software_twitter;
        $software_companyInfo->software_logo1 = $request->software_logo1;
        $software_companyInfo->software_logo2 = $request->software_logo2;
        $software_companyInfo->software_logo3 = $request->software_logo3;
        $software_companyInfo->software_logo4 = $request->software_logo4;
        $software_companyInfo->software_af1 = $request->software_af1;
        $software_companyInfo->software_af2 = $request->software_af2;
        $software_companyInfo->software_af3 = $request->software_af3;
        $software_companyInfo->software_af4 = $request->software_af4;
        $software_companyInfo->software_af5 = $request->software_af5;
        $software_companyInfo->software_af6 = $request->software_af6;
        $software_companyInfo->software_af7 = $request->software_af7;
        $software_companyInfo->software_af8 = $request->software_af8;
        $software_companyInfo->software_af9 = $request->software_af9;
        $software_companyInfo->software_af10 = $request->software_af10;

        $software_companyInfo->update();

        return redirect()->back()->with('message', 'Record Updated Successfully!');
    } 
    else {
        return redirect()->back()->withInput()->withErrors($validator)->with('message', 'Record Not Updated!');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(softwarecompany $softwarecompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(softwarecompany $softwarecompany)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesoftwarecompanyRequest $request, softwarecompany $softwarecompany)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(softwarecompany $softwarecompany)
    {
        //
    }
}
