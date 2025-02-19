<?php

namespace App\Http\Controllers;
use App\Models\itemgroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreitemgroupRequest;
use App\Http\Requests\UpdateitemgroupRequest;

class ItemgroupController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);

    }

   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $record=itemgroup::where('firm_id',Auth::user()->firm_id)->get();
        return view('master.Itemgrouplist',['data'=>$record]); 
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

                // comapny data insert to table 
        //        echo"<pre>";
        // print_r($request->all());

        $validator= validator::make($request->all(),[
           'item_group' => [
        'required',
        'unique:itemgroups,item_group,NULL,id,firm_id,' . auth()->user()->firm_id,
    ],
           
            'head_group'=>'required'
             
            ]);
            if ($validator->passes()) {
                $itemgroup = new itemgroup;
                $itemgroup->firm_id=Auth::user()->firm_id;
                $itemgroup->item_group = $request->item_group;
                $itemgroup->head_group=$request->head_group;

                $itemgroup->save();
        
                return redirect('/itemgroups')->with('message', 'Group created successfully!');
            } else {
                return redirect('/itemgroups')->withInput()->withErrors($validator);
            }

    }
    

    /**
     * Display the specified resource.
     */
    public function show(itemgroup $id)
    {
        $record= itemgroup::where('firm_id',Auth::user()->firm_id)->find($id);

        return view('master.itemgrouplist',['data'=>$record]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(itemgroup $id)
    {
        //
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateitemgroupRequest $request, itemgroup $itemgroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(itemgroup $itemgroup, $id)
{
    try {
        // Attempt to delete the record
        $deleted = itemgroup::where('firm_id',Auth::user()->firm_id)
        ->where('id',$id)
        ->delete();

        // Check if the deletion was successful
        if ($deleted) {
            return redirect('itemgroups')->with('message', 'Record successfully deleted.');
        } else {
            return redirect('itemgroups')->with('message', 'Could not delete the record.');
        }
    } catch (\Exception $e) {
        // Catch any exception that occurs and handle it
        return redirect('itemgroups')->with('message', 'We cannot delete this record because it is used on an item.');
    }
}

}
