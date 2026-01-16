<?php

namespace App\Http\Controllers;

use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;


class VoucherTypeController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record=voucher_type::where('firm_id',Auth::user()->firm_id)->get();
        return view('room_master.voucher_type.voucher_type',['data'=>$record]); 
        //  return view('room_master.voucher_type.voucher_type'); 
 

    }
    public function store(Request $request)
    {
        $validator= validator::make($request->all(),[
            'voucher_type_name' => 'required|unique:voucher_types,voucher_type_name',
            'numbring_start_from'=>'nullable|integer',
            'voucher_prefix'=>'nullable',
            'voucher_suffix'=>'nullable',
            'voucher_numbring_style'=>'nullable',
            'voucher_print_name'=>'nullable',
            'voucher_type' => 'nullable|string|max:50',
            'voucher_remark'=>'nullable'
             
            ]);
            if ($validator->passes()) {
                $voucher_type = new voucher_type;
                $voucher_type->firm_id=Auth::user()->firm_id;
                $voucher_type->voucher_type_name = $request->voucher_type_name;
                $voucher_type->voucher_af1 = $request->voucher_type;
                $voucher_type->numbring_start_from=$request->numbring_start_from;
                $voucher_type->voucher_prefix=$request->voucher_prefix;
                $voucher_type->voucher_suffix=$request->voucher_suffix;
                $voucher_type->voucher_numbring_style=$request->voucher_numbring_style;
                $voucher_type->voucher_print_name=$request->voucher_print_name;
                $voucher_type->voucher_remark=$request->voucher_remark;
                $voucher_type->save();
        
                return redirect('/voucher_types')->with('message', 'Voucher Type  created successfully!');
            } else {
                return redirect('/voucher_types')->withInput()->withErrors($validator)->with('errer_message', 'Voucher Type Not Created');
            }

        }


    /**
     * Display the specified resource.
     */
    public function show(voucher_type $voucher_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        return view('room_master.voucher_type.voucher_type_edit', compact('voucher_type'));
    
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'voucher_type_name' => 'required',
            'numbring_start_from'=>'nullable|integer',
            'voucher_prefix'=>'nullable',
            'voucher_suffix'=>'nullable',
            'voucher_numbring_style'=>'nullable',
            'voucher_print_name'=>'nullable',
            'voucher_remark'=>'nullable'
  
        ]);

        $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)->findOrFail($id);
        $voucher_type->update($request->all());

        return redirect()->route('voucher_types.index')->with('message', 'Voucher Type Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(voucher_type $voucher_type)
    {
        //
    }
}
