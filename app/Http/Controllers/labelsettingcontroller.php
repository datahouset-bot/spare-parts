<?php

namespace App\Http\Controllers;

use App\Models\labelsetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StorelabelsettingRequest;
use App\Http\Requests\UpdatelabelsettingRequest;

use Illuminate\Support\Facades\Validator;
class LabelsettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function batchseeting()
    {
        $record=labelsetting::where('firm_id',Auth::user()->firm_id)->get();
        return view('master.labelsetting',['data'=>$record]);
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
        
          
        
        // Inside your Controller function:
        
        $validator = Validator::make($request->all(), [
            'field_name' => [
                'required',
                'unique:labelsettings,field_name,NULL,id,firm_id,' . auth()->user()->firm_id,
            ],
            'replaced_field_name' => 'nullable|string|max:100',
            'is_visible' => 'required|in:0,1',
        ]);
        
        if ($validator->passes()) {
            $labelSetting = new labelSetting();
            $labelSetting->firm_id = Auth::user()->firm_id;
            $labelSetting->field_name = $request->field_name;
            $labelSetting->replaced_field_name = $request->replaced_field_name;
            $labelSetting->is_visible = $request->is_visible;
            $labelSetting->save();
        
            return redirect('batchseeting')->with('message', 'Label Setting created successfully!');
        } else {
            return redirect('batchseeting')->withInput()->withErrors($validator);
        }
        

    }


    /**
     * Display the specified resource.
     */
    public function batch_lebel_edit($id)
    {      
        $record= labelSetting::where('firm_id',Auth::user()->firm_id)->get();

        return view('master.labelsettingedit',['data'=>$record]);

    }

//     public function update_lable(Request $request)
//     {
    
         
    
//         $validator= validator::make($request->all(),[
//             'field_name' => 'required',
//             'is_visible' => 'required|in:0,1',
//               // Assuming you meant "float", you can use numeric instead.
//             ]);
//             if ($validator->passes()) {
            
//             $labelSetting = labelSetting::where('firm_id',Auth::user()->firm_id)->find($request->id);
//                 $labelSetting->field_name = $request->field_name;
//                 $labelSetting->replaced_field_name = $request->replaced_field_name;
//                 $labelSetting->is_visible = $request->is_visible;
//                 $labelSetting->update();
//                 return redirect(url('/batchseeting'));

//             } else {
//                 return redirect('batchseeting')->withInput()->withErrors($validator);
//             }


// }

public function update_lable(Request $request)
{
    $labels = $request->input('labels');

    foreach ($labels as $labelData) {
        $validator = Validator::make($labelData, [
            // 'id' => 'required|exists:label_settings,id',
            'field_name' => 'required|string',
            'replaced_field_name' => 'nullable|string',
            'is_visible' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect('batchseeting')->withErrors($validator)->withInput();
        }

        $labelSetting = labelSetting::where('firm_id', Auth::user()->firm_id)->find($labelData['id']);

        if ($labelSetting) {
            $labelSetting->update([
                'field_name' => $labelData['field_name'],
                'replaced_field_name' => $labelData['replaced_field_name'],
                'is_visible' => $labelData['is_visible'],
            ]);
        }
    }

    return redirect('/batchseeting')->with('success', 'Labels updated successfully.');
}


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatelabelsettingRequest $request, labelsetting $labelsetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(labelsetting $labelsetting)
    {
        //
    }
}
