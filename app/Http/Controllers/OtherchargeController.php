<?php

namespace App\Http\Controllers;
use App\Models\account;
use App\Models\othercharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OtherchargeController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $account=account::where('firm_id',Auth::user()->firm_id)->get();
        $othercharge=othercharge::where('firm_id',Auth::user()->firm_id)->with('account')->get();
        return view ('master.other_charge.other_charge',compact('account','othercharge'));
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

        // Validate the request
        $validator= validator::make($request->all(),[
            'charge_name' => 'required|string',
            'charge_type' => 'required|string',
            'input_type' => 'required|string',
            'applicable_on' => 'required|string',
            'charge_posting_account' => 'required|string',
        ]);

        if ($validator->passes()) {
            $othercharge = new othercharge;
            $othercharge->firm_id =Auth::user()->firm_id;
            $othercharge->charge_name=$request->charge_name;
            $othercharge->charge_type=$request->charge_type;
            $othercharge->input_type=$request->input_type;
            $othercharge->applicable_on=$request->applicable_on;	
            $othercharge->charge_posting_account=$request->charge_posting_account;
	
            $othercharge->save();
    
            return redirect('/othercharges')->with('message', 'Other Charge  created successfully!');
        } else {
            return redirect('/othercharges')->withInput()->withErrors($validator);
        }
  
    }
    /**
     * Display the specified resource.
     */
    public function show(othercharge $othercharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(othercharge $othercharge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, othercharge $othercharge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
     othercharge::destroy(['id',$id]);         
        return redirect('othercharges')->with('message', 'Record Succesfully  Deleted  ');


    }
}
