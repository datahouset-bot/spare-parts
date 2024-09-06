<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\primarygroup;
use App\Http\Requests\StoreprimarygroupRequest;
use App\Http\Requests\UpdateprimarygroupRequest;

class PrimarygroupController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $record=primarygroup::all();
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
            'primary_group_name' => 'required|unique:primarygroups'
   
        ]);


                    if ($validator->passes()) {
                $primarygroup = new primarygroup;
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
        $primarygroup = primarygroup::findOrFail($id);
  
        return view('master.primary_group.primary_group_edit', compact('primarygroup'));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
         'primary_group_name' => 'required|unique:primarygroups'
        ]);

        $primarygroup =primarygroup::findOrFail($id);
        $primarygroup->update($request->all());

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
