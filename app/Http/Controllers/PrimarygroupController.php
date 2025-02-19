<?php

namespace App\Http\Controllers;
use App\Models\primarygroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreprimarygroupRequest;
use App\Http\Requests\UpdateprimarygroupRequest;

class PrimarygroupController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $record=primarygroup::where('firm_id',Auth::user()->firm_id)->get();
        return view('master.primary_group.primary_group',['data'=>$record]); 

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
            'primary_group_name' => [
                'required',
                Rule::unique('primarygroups')->where(function ($query) {
                    return $query->where('firm_id', Auth::user()->firm_id);
                }),
            ],
        ]);

                    if ($validator->passes()) {
                        
                $primarygroup = new primarygroup;
                $primarygroup->firm_id=Auth::user()->firm_id;
                $primarygroup->primary_group_name= $request->primary_group_name;
                $primarygroup->save();
        
                return redirect('/primarygroups')->with('message', 'Primary Group  created successfully!');
            } else {
                return redirect('/primarygroups')->withInput()->withErrors($validator);
            }

    }

    /**
     * Display the specified resource.
     */
    public function show(primarygroup $primarygroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $primarygroup = primarygroup::where('firm_id',Auth::user()->firm_id)->where('id',$id)->first();
  
        return view('master.primary_group.primary_group_edit', compact('primarygroup'));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'primary_group_name' => [
                'required',
                Rule::unique('primarygroups')->where(function ($query) {
                    return $query->where('firm_id', Auth::user()->firm_id);
                }),
            ],
        ]);

        $primarygroup =primarygroup::where('firm_id',Auth::user()->firm_id)
        ->where('id',$id)->first();
        $primarygroup->primary_group_name= $request->primary_group_name;
        $primarygroup->update();

        return redirect()->route('primarygroups.index')->with('message', 'Primary Group Name  Updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(primarygroup $primarygroup)
    {
        //
    }
}
