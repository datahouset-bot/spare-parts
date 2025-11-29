<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\batch;
use App\Http\Requests\StorebatchRequest;
use App\Http\Requests\UpdatebatchRequest;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $validator= validator::make($request->all(),[
            'item_id' => 'required',
            'batch_no'=>'required',
                     
             
            ]);
            if ($validator->passes()) {    
        
        $batch = new batch ;
        $batch->firm_id=Auth::user()->firm_id;
        $batch->item_id = $request->item_id;
        $batch->batch_no = $request->batch_no;
        $batch->batch_af1 = $request->batch_af1;
        $batch->batch_af2 = $request->batch_af2;
        $batch->batch_af3 = $request->batch_af3;
        $batch->batch_af4 = $request->batch_af4;
        $batch->batch_af5 = $request->batch_af5;
        $batch->mfg_date = $request->mfg_date;
        $batch->exp_date = $request->exp_date;
        $batch->batch_mrp = $request->batch_mrp;
        $batch->batch_sale_rate = $request->batch_sale_rate;
        $batch->batch_basic_rate = $request->batch_basic_rate;
        $batch->batch_a_rate = $request->batch_a_rate;
        $batch->batch_b_rate = $request->batch_b_rate;
        $batch->batch_c_rate = $request->batch_c_rate;
        $batch->batch_purchase_rate = $request->batch_purchase_rate;
        $batch->batch_op_qty = $request->batch_op_qty;
        $batch->batch_op_value = $request->batch_op_value;
        $batch->batch_barcode = $request->batch_barcode;
        $batch->batch_op_remark = $request->batch_op_remark;
        $batch->rack = $request->rack;
        
        $batch->save();
        $batchName=$request->batch_no;
            return response()->json([
                'message' => 'I am ready to save through AJAX  hariom ji '.$batchName,
                'status' => 200,
            ]);
      } 
       else {
        $batchName=$request->batch_no;
        return response()->json([

            'message' => 'Bad Request. Check Your Input'.$batchName,
            'status' => 400,
            'errors' => $validator->errors(),
              ]);
      }
    }


    /**
     * Display the specified resource.
     */
    public function show($item_id)
    {
        $batchrecords = batch::where('item_id', $item_id)
        ->where('firm_id',Auth::user()->firm_id)
        ->get();
        
        return response()->json([
            'message' => 'Records fetched successfully for user ' . $item_id,
            'status' => 200,
            'batchrecords' => $batchrecords->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $record = Batch::findOrFail($id);
        return response()->json(['status' => 200, 'data' => $record]);
    }

    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);
        $batch->update($request->all());
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Batch::find($id);
        if ($record) {
            $record->delete();
            return response()->json(['status' => 200]);
        }
    
        return response()->json(['status' => 404, 'message' => 'Record not found']);
    }
    public function searchbatch($batch_id)
    {
        // Search for the customer by contact number
        $batch = batch::where('firm_id',Auth::user()->firm_id)
   -> where('id', $batch_id)->first();

        if ($batch) {
            return response()->json([
                'message' => '<p class="alart alart-success">search batch Record Found <p>',
                'searched_batch_info' => $batch->toArray()
            ]);
        } else {
            return response()->json([
                'message' => ' <p class="alart alart-danger">No search batch Record Found<p>',
                'searched_batch_info' => null
            ]);
        }


    }
    
}
