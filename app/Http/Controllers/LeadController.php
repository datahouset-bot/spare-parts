<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Followup;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class LeadController extends CustomBaseController
{
    public function index()
    {
        return view ('callmanagement.coldcall');
    }

    public function store(Request $request)
    {

        $validator= validator::make($request->all(),[
            'lead_title' => 'required',
            'lead_name' => 'required',
            'lead_mobile' => 'required',
            'lead_product'=>'required',
            'lead_disc'=>'required',
             
             ]);
            if ($validator->passes()) {

                $lead = new Lead;
                $lead->lead_title =$request->lead_title;
                $lead->lead_name = $request->lead_name;
                $lead->lead_mobile = $request->lead_mobile;
                $lead->lead_city = $request->lead_city;
                $lead->lead_product = $request->lead_product;
                $lead->lead_disc = $request->lead_disc;
                $lead->lead_executive = $request->lead_executive;

                 $lead->save();


                 $followup = new Followup;
                 // Assign lead_id after saving the lead
                 $followup->lead_id = $lead->id;
                 // Get current date
                 $followup->followup_date = date('Y-m-d H:i:s');
                 $followup->followup_remark = '0';
             
                 // Save the followup
                 $followup->save();
        
                 return redirect('/followup_list')->with('message', 'The record has been saved successfully');
                } else {
                 return redirect('/coldcall')->withInput()->withErrors($validator);
                }



    }
 public function addfollowup($id)
    {
        $record= Followup::query()->where('lead_id', '=', $id)
        ->orderByDesc('followup_date')
        ->get();
 
        $record1= Lead::find($id);

         return view('callmanagement.followup',['data'=>$record,
         'data1'=>$record1
    
           ]);

      }

    public function newfollowup(Request $request )
    {

        // echo"<pre>";
        // print_r($request->all());

        $validator= validator::make($request->all(),[
            'followup_remark' => 'required',
            'followup_date' => 'required',
            'lead_id' => 'required',
             
             ]);
            if ($validator->passes()) {

                


                 $followup = new Followup;



                 // Assign lead_id after saving the lead
                 $followup->lead_id =$request->lead_id ;
                 
                 // date format converion on yy-mmdd
                  $from_date=$request->followup_date;
                  $parsed_from_date = Carbon::createFromFormat('d-m-Y', $from_date);
                  $new_from_date = $parsed_from_date->format('Y-m-d');

                 $followup->followup_date = $new_from_date;
                 $followup->followup_remark =$request-> followup_remark;
             
                 // Save the followup
                 $followup->save();

                 $lead=Lead::find($request->lead_id) ;
                 //insertion of don=12 and cancal =1 otherwise 0 
                 $af1=$request->lead_af1;
                 $af2=$request->lead_af2;
                 if ($af1===null){
                    $lead->lead_af1=0;

                 }else
                 {
                    $lead->lead_af1=$af1;   
                 }
                if ($af2===null){
                    $lead->lead_af2=0;

                 }else
                 {
                    $lead->lead_af2=$af2;   
                 }
                 $lead->update();
        
                 return redirect('/followup_list')->with('message', 'The record has been saved successfully');
                } else {
                    return redirect()->back()->withInput()->withErrors($validator);

                }


        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }


    public function followup()
    {


         return view('callmanagement.followup');
    }

    public function followup_list()
     {    
        $currentDate = now()->toDateString();
       $record = Followup::getRecordsWithHighestIdForEachLead()
       ->whereDate('followup_date', $currentDate)
       ->orderBy('followup_date')
       ->get();
 
        // Pass data to the view
         $lead=Lead::all();
   

              return view('callmanagement.followup_list',['data'=>$record,
              'lead'=> $lead
              ]);

     }




    public function followup_list_date_wise(Request $request)
    {    


        $from_date=$request->from_date;
        $parsed_from_date = Carbon::createFromFormat('d-m-Y', $from_date);
         $new_from_date = $parsed_from_date->format('Y-m-d');
         //form date
       
         
         $to_date=$request->to_date;
         $parsed_to_date = Carbon::createFromFormat('d-m-Y', $to_date);
          $new_to_date = $parsed_to_date->format('Y-m-d');
         //to date

         $record = Followup::getRecordsWithHighestIdForEachLead()
          ->whereBetween('followup_date', [$new_from_date, $new_to_date])
          ->orderBy('followup_date')
          ->get();
            $lead=Lead::all();
        return view('callmanagement.followup_list',['data'=>$record,
        'lead'=> $lead
        ]);




        // public function followup_list_date_wise(Request $request)
        // {    
    
    
        //     $from_date=$request->from_date;
        //     $parsed_from_date = Carbon::createFromFormat('d-m-Y', $from_date);
        //      $new_from_date = $parsed_from_date->format('Y-m-d');
        //      //form date
           
             
        //      $to_date=$request->to_date;
        //      $parsed_to_date = Carbon::createFromFormat('d-m-Y', $to_date);
        //       $new_to_date = $parsed_to_date->format('Y-m-d');
        //      //to date
    
    
        //     $record = Followup::query()->whereBetween('followup_date', [$new_from_date, $new_to_date])->get();
        //         $lead=Lead::all();
        //     return view('callmanagement.followup_list',['data'=>$record,
        //     'lead'=> $lead
        //     ]);





    }


}
