<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\gstmaster;
use Illuminate\Support\Facades\Validator;
class GstmasterController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record=gstmaster::all();
        return view('other.gst_master',['data'=>$record]); 

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
        $validator= validator::make($request->all(),[
            'taxname' => ['required', 'string'],
            'sgst' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'cgst' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'igst' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'vat' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax1' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax2' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax3' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax4' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax5' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/']
            
            ]);
            if ($validator->passes()) {
                $gstmaster = new gstmaster;
                $gstmaster->taxname = $request->taxname;
                $gstmaster->sgst = $request->sgst;
                $gstmaster->cgst = $request->cgst;
                $gstmaster->igst = $request->igst;
                $gstmaster->vat = $request->vat;
                $gstmaster->tax1 = $request->tax1;
                $gstmaster->tax2 = $request->tax2;
                $gstmaster->tax3 = $request->tax3;
                $gstmaster->tax4 = $request->tax4;
                $gstmaster->tax5 = $request->tax5;


                $gstmaster->save();
        
                return redirect('/gstmasters')->with('message', 'Tax/ GST created successfully!');
            } else {
                return redirect('/gstmasters')->withInput()->withErrors($validator);
            }

    }

    /**
     * Display the specified resource.
     */
    public function show(gstmaster $gstmaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gstmaster = gstmaster::findOrFail($id);
        return view('other.gst_master_edit', compact('gstmaster'));
 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'taxname' => ['required', 'string'],
            'sgst' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'cgst' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'igst' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'vat' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax1' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax2' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax3' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax4' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/'],
            'tax5' => [ 'numeric', 'regex:/^\d+(\.\d{1,4})?$/']
        ]);

        $gstmster = gstmaster::findOrFail($id);
        $gstmster->update($request->all());

        return redirect()->route('gstmasters.index')->with('message', 'GST / TAX  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gstmaster = gstmaster::find($id);

        // Check if the gstmaster exists
        if ($gstmaster) {
            // Delete the gstmaster
            $gstmaster->delete();
            return redirect('/gstmasters')->with('message', 'GST / Tax Master Delete successfully!');
        } else {
            // gstmaster not found
            return redirect('/gstmasters')->with('message', 'GST / Tax  Not Found');

        }

        //
    }
}
