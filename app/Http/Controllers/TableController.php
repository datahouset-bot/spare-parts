<?php

namespace App\Http\Controllers;


use App\Models\kot;
use App\Models\item;
use App\Models\table;
use App\Models\account;
use App\Models\foodbill;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TableController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record=table::where('firm_id',Auth::user()->firm_id)->get();
        return view('entery.restaurant.table',['data'=>$record]); 
        // 

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
        // dd($request);
        $validator= validator::make($request->all(),[
            'table_name' => 'required',
             
            ]);
            if ($validator->passes()) {
                $table = new table;
                $table->firm_id=Auth::user()->firm_id;
                $table->table_name = $request->table_name;
                
                $table->save();
        
                return redirect('/tables')->with('message', 'table created successfully!');
            } else {
                return redirect('/tables')->withInput()->withErrors($validator);
            }
    }

    /**
     * Display the specified resource.
     */
    public function table_dashboard()
    { 
        $data=table::where('firm_id',Auth::user()->firm_id)->orderByRaw('CAST(id AS UNSIGNED) asc')->get();
        $kotlist=kot::where('firm_id',Auth::user()->firm_id)->orderBy('service_id','asc')->where('status','0')->where('voucher_type','RKot')->get();
 
        return view('entery.restaurant.table_dashboard',compact('data','kotlist'));
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $table = table::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        return view('entery.restaurant.table_edit', compact('table'));
 
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'table_name' => 'required',
               ]);

        $table = table::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        $table->update($request->all());

        return redirect()->route('tables.index')->with('message', 'Table updated successfully.');
    }
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $table = table::where('firm_id',Auth::user()->firm_id)->find($id);

        // Check if the package exists
        if ($table) {
            // Delete the package
            $table->delete();
            return redirect('/tables')->with('message', 'Table Delete successfully!');
        } else {
            // Table not found
            return redirect('/tables')->with('message', 'Table Not Found');

        }
    }
}
