<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\accountgroup;
use App\Http\Requests\StoreaccountgroupRequest;
use App\Http\Requests\UpdateaccountgroupRequest;
use App\Models\primarygroup;

class AccountgroupController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $primarygroups=primarygroup::all();
         $data = AccountGroup::with('primarygroup')->get();
  
        return view('master.account_group.account_group',['primarygroups'=>$primarygroups,'data'=>$data]); 
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
            'account_group_name' => 'required|unique:accountgroups',
            'primary_group_id' => 'required',
   
        ]);


                    if ($validator->passes()) {
                $accountgroup = new accountgroup;
                $accountgroup->account_group_name= $request->account_group_name;
                $accountgroup->primary_group_id= $request->primary_group_id;
                $accountgroup->save();
        
                return redirect('/accountgroups')->with('message', 'Account  Group  Created successfully!');
            } else {
                return redirect('/accountgroups')->withInput()->withErrors($validator);
            }

    }


    /**
     * Display the specified resource.
     */
    public function show(accountgroup $accountgroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $accountgroup = accountgroup::findOrFail($id);
        $primarygroups=primarygroup::all();
        return view('master.account_group.account_group_edit', compact('accountgroup','primarygroups'));
 
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'account_group_name' => 'required|unique:accountgroups',
            'primary_group_id' => 'required',
      ]);

        $accountgroup = accountgroup::findOrFail($id);
        $accountgroup->update($request->all());

        return redirect()->route('accountgroups.index')->with('message', 'Account Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accountgroup = accountgroup::find($id);

        // Check if the package exists
        if ($accountgroup) {
            // Delete the package
            $accountgroup->delete();
            return redirect('/accountgroups')->with('message', 'Account Group Delete Successfully!');
        } else {
            // accountgroup not found
            return redirect('/accountgroups')->with('message', 'accountgroup Not Found');

        }
    }

}
