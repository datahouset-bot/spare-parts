<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\unit;
use App\Models\company;
use App\Models\gstmaster;
use Illuminate\Support\Facades\Validator;
use App\Models\itemgroup;


use Illuminate\Http\Request;


class ItemController extends CustomBaseController
{
    public function __construct()
    {
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create','store','addPermissionToRole','givePermissionToRole']]);
        $this-> middleware('permission:update role', ['only' => ['update','edit']]);
        $this-> middleware('permission:delete role', ['only' => ['destroy']]);
        $this->middleware(['auth', 'verified']);
    }



    public function index()
    {
        $records = item::with('company', 'itemgroup', 'unit', 'gstmaster')->get();
        return view('master.item', ['data' => $records]);

        // return view('master.item', compact('records'));
    }
    public function item_dt()
    {
        $record = item::all();
        return view('master.item_dt', ['data' => $record]);

        //  return view('master.item');
    }

    public function itemform()
    {
        $company = company::all();
        $itemgroup = itemgroup::all();
        $unit = unit::all();
        $gstmaster = gstmaster::all();


        return view('master.itemform', [
            'companydata' => $company,
            'itemgroupdata' => $itemgroup,
            'unit' => $unit,
            'gstmaster' => $gstmaster,


        ]);
    }

    public function insertitem(Request $request)
    {
        // dd($request);

        $validator = validator::make($request->all(), [
            'item_name' => 'required|unique:items',
            'item_barcode' => 'numeric',
            'mrp' => 'required|numeric',
            'sale_rate' => 'required|numeric',
            'sale_rate_a' => 'numeric',
            'sale_rate_b' => 'numeric',
            'sale_rate_c' => 'numeric',
            'purchase_rate' => 'numeric',
             'group_id'=>'required',
            'company_id'=>'required',
             'item_gst_id'=>'required|numeric',
            'unit_id' => 'required|numeric',
        ]);
       

        if ($validator->passes()) {
            $company_name = company::find($request->company_id);
            $group_name = itemgroup::find($request->group_id);
            $unit_name = unit::find($request->unit_id);
            $item = new item;
            $item->item_name = $request->item_name;
            $item->item_barcode = $request->item_barcode;
            $item->item_company = $company_name->comp_name;
            $item->item_group = $group_name->item_group;
            $item->item_unit = $unit_name->primary_unit_name;
            $item->company_id = $request->company_id;
            $item->group_id = $request->group_id;
            $item->unit_id = $request->unit_id;
            $item->item_gst_id = $request->item_gst_id;

            $item->mrp = $request->mrp;
            $item->sale_rate = $request->sale_rate;
            $item->sale_rate_a = $request->sale_rate_a;
            $item->sale_rate_b = $request->sale_rate_b;
            $item->sale_rate_c = $request->sale_rate_c;
            $item->purchase_rate = $request->purchase_rate;


            $item->save();
            return redirect('item');
        } else {
            return redirect('/itemform')->withInput()->withErrors($validator);

        }



    }

    public function itemformview($id)
    {
        $record = item::find($id);

        return view('master.itemformview', ['data' => $record]);

    }

    public function show_item_form_edit($id)
    {


        $company = company::all();
        $itemgroup = itemgroup::all();
        $unit = unit::all();
        $gstmaster = gstmaster::all();



        $record = item::find($id);

        return view('master.itemformedit', ['data' => $record, 'companydata' => $company,
        'itemgroupdata' => $itemgroup,
        'unit' => $unit,
        'gstmaster' => $gstmaster,]);

    }
    public function edit_item(Request $request)
    {
        // this is use for save the record of edited item 
        $validator = validator::make($request->all(), [
            'item_name' => 'required',
            'item_barcode' => 'numeric',
            'mrp' => 'required|numeric',
            'sale_rate' => 'required|numeric',
            'sale_rate_a' => 'numeric',
            'sale_rate_b' => 'numeric',
            'sale_rate_c' => 'numeric',
            'purchase_rate' => 'numeric',
            // 'group_id'=>'required|numeric',
            // 'company_id'=>'required|numeric',
            // 'item_gst_id'=>'required|numeric',
            'unit_id' => 'required|numeric',
        ]);
        // echo"<pre>";
        // print_r($request->all());
        if ($validator->passes()) {
            $company_name = company::find($request->company_id);
            $group_name = itemgroup::find($request->group_id);
            $unit_name = unit::find($request->unit_id);
            $item = item::find($request->id);
            $item->item_name = $request->item_name;
            $item->item_name = $request->item_name;
            $item->item_barcode = $request->item_barcode;
            $item->item_company = $company_name->comp_name;
            $item->item_group = $group_name->item_group;
            $item->item_unit = $unit_name->primary_unit_name;
            $item->company_id = $request->company_id;
            $item->group_id = $request->group_id;
            $item->unit_id = $request->unit_id;
            $item->item_gst_id = $request->item_gst_id;
            $item->mrp = $request->mrp;
            $item->sale_rate = $request->sale_rate;
            $item->sale_rate_a = $request->sale_rate_a;
            $item->sale_rate_b = $request->sale_rate_b;
            $item->sale_rate_c = $request->sale_rate_c;
            $item->purchase_rate = $request->purchase_rate;
            $item->update();
            return redirect('item');
        } else {
            return redirect('/itemform')->withInput()->withErrors($validator);
        }
    }

    public function destroy(item $item, $id)
    {
        item::destroy(['id', $id]);
        return redirect('item');

        //
    }


    public function searchitem($item_id)
    {
        // Search for the customer by contact number
        $item = item::with('gstmaster')-> where('id', $item_id)->first();

        if ($item) {
            return response()->json([
                'message' => '<p class="alart alart-success">Record Found <p>',
                'item_info' => $item->toArray()
            ]);
        } else {
            return response()->json([
                'message' => ' <p class="alart alart-danger">No Record Found<p>',
                'item_info' => null
            ]);
        }


    }
}