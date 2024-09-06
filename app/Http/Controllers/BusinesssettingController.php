<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\businesssetting;
use Illuminate\Support\Facades\Validator;


class BusinesssettingController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businesssetting = businesssetting::find(1);

        if(!$businesssetting){
            $newrecord= new businesssetting;
            $newrecord->id=1;
            $newrecord->calculation_type='24hour';
            $newrecord->standard_checkout_time='11:00:00';
            $newrecord->save();

        }

     return view('setting.businesssetting');   

    }

    public function update(Request $request, string $id)
    {
        $validator= validator::make($request->all(),[
            'calculation_type' => 'required',
            'standard_checkout_time'=>'required|date_format:H:i',
      
            ]);
                $id=1;
            if ($validator->passes()) {
                $standard_checkout_time = Carbon::createFromFormat('H:i', $request->input('standard_checkout_time'))->format('H:i:s');
                $businesssetting = businesssetting::find($id);
                $businesssetting->calculation_type = $request->calculation_type;
                $businesssetting->standard_checkout_time = $standard_checkout_time;
                $businesssetting->update();
        
                return redirect()->route('businesssettings.create')->with('message', 'Setting Apply Successfully!');
            } else {
                return redirect('/buinesssettings')->with('error', 'Setting Not Apply !')->withInput()->withErrors($validator);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(businesssetting $businesssetting)
    {
        //
    }
}
