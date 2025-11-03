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
    
public function showShiftTableForm()
{
    $tables = Table::where('firm_id',Auth::user()->firm_id)->get();
    return view('entery.restaurant.shift_table', compact('tables'));
}
public function shiftTableAction(Request $request)
{
    $from = $request->input('from_table');
    $to = $request->input('to_table');

    if ($from == $to) {
        return redirect()->back()->with('error', 'Source and destination table cannot be the same.');
    }

    $updated = Kot::where('firm_id',Auth::user()->firm_id)->where('service_id', $from)->update(['service_id' => $to]);

    if ($updated > 0) {
        return redirect()->back()->with('success', 'KOTs successfully shifted to the selected table.');
    } else {
        return redirect()->back()->with('error', 'No KOTs found to shift from the selected table.');
    }
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
                $table->table_group = $request->table_group;
                
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
               $kot_Unprinted = kot::select('voucher_no')
    ->where('status', '0')   
    ->where('ready_to_serve', 'Unprinted')
    ->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_type', 'kot')
    ->groupBy('voucher_no')
    ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
    ->get()
    ->count();
      $Rkot_Unprinted = kot::select('voucher_no')
      ->where('status', '0')
    ->where('ready_to_serve', 'Unprinted')
    ->where('firm_id', Auth::user()->firm_id)
    ->where('voucher_type', 'Rkot')
    ->groupBy('voucher_no')
    ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
    ->get()
    ->count();

        $data=table::where('firm_id',Auth::user()->firm_id)->orderByRaw('CAST(table_name AS UNSIGNED) asc')->get();
        $kotlist=kot::where('firm_id',Auth::user()->firm_id)->orderBy('service_id','asc')->where('status','0')->where('voucher_type','RKot')->get();
 
        return view('entery.restaurant.table_dashboard',compact('data','kotlist','kot_Unprinted','Rkot_Unprinted'));
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
     $table->table_name=$request->table_name; 
      $table->table_group=  $request->input('table_group') === 'Null' ? null : $request->input('table_group');
     $table->update(); 


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
