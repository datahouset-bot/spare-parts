<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\unit;
use App\Models\batch;
use App\Models\company;
use App\Models\gstmaster;
use App\Models\itemgroup;
use App\Models\labelsetting;
use Illuminate\Http\Request;
use App\Imports\FullItemsImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class ItemController extends CustomBaseController
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view role', ['only' => ['index']]);
    //     $this->middleware('permission:create role', ['only' => ['create','store','addPermissionToRole','givePermissionToRole']]);
    //     $this-> middleware('permission:update role', ['only' => ['update','edit']]);
    //     $this-> middleware('permission:delete role', ['only' => ['destroy']]);


    //     $this->middleware(['auth', 'verified']);
    // }



    public function index()
    {
        $records = item::with('company', 'itemgroup', 'unit', 'gstmaster')
        ->where('firm_id',Auth::user()->firm_id)
        ->get();
        return view('master.item', ['data' => $records]);

        // return view('master.item', compact('records'));
    }
    public function item_dt()
    {
        $record = item::where('firm_id',Auth::user()->firm_id)->get();
        return view('master.item_dt', ['data' => $record]);

        //  return view('master.item');
    }

    public function itemform()
    {
        $company = company::where('firm_id',Auth::user()->firm_id)->get();
        $itemgroup = itemgroup::where('firm_id',Auth::user()->firm_id)->get();
        $unit = unit::where('firm_id',Auth::user()->firm_id)->get();
        $gstmaster = gstmaster::where('firm_id',Auth::user()->firm_id)->get();

        $labelsetting=labelsetting::where('firm_id',Auth::user()->firm_id)->get();
        return view('master.itemform', [
            'companydata' => $company,
            'itemgroupdata' => $itemgroup,
            'unit' => $unit,
            'gstmaster' => $gstmaster,
            'labelsetting'=>$labelsetting


        ]);
    }

    public function insertitem(Request $request)
    { 
        if ($request->hasFile('item_image')) {
            $image1 = $request->file('item_image'); // Use `file()` method to access uploaded file
            $originalName = $image1->getClientOriginalName(); // Original file name
            $timestamp = time(); // Current timestamp
            $uniqueName = $timestamp . '_' . $originalName; // Combine timestamp and original name for uniqueness
            $image1->storeAs('public/account_image', $uniqueName); // Save file with unique name
        }
        
        // if ($request->hasFile('item_image')) {
        //     $image1 = $request->file('item_image');
        //     $name = $image1->getClientOriginalName();
        //     $image1->storeAS('public\account_image\item_image', $name);
        


        // }
         

        $validator = validator::make($request->all(), [
           'item_name' => [
        'required',
        'unique:items,item_name,NULL,id,firm_id,' . auth()->user()->firm_id,
    ],
            'item_barcode' => 'nullable|numeric',
            'mrp' => 'required|numeric',
            'sale_rate' => 'required|numeric',
             'sale_rate_a' => 'nullable|numeric',
            'sale_rate_b' => 'nullable|numeric',
            'sale_rate_c' => 'nullable|numeric',
            'purchase_rate' => 'nullable|numeric',
             'group_id'=>'required',
            'company_id'=>'required',
             'item_gst_id'=>'required|numeric',
            'unit_id' => 'required|numeric',
        ]);

       

        if ($validator->passes()) {
            $company_name = company::where('firm_id',Auth::user()->firm_id)->find($request->company_id);
            $group_name = itemgroup::where('firm_id',Auth::user()->firm_id)->find($request->group_id);
            $unit_name = unit::where('firm_id',Auth::user()->firm_id)->find($request->unit_id);
            $item = new item;
            $item->firm_id=Auth::user()->firm_id;
            $item->item_name = $request->item_name;
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
            $item->short_name = $request->short_name;
            if (is_null($request->item_barcode)) {
                $last_item = Item::
                where('firm_id',Auth::user()->firm_id)->orderByRaw('CAST(id AS UNSIGNED) DESC')->first();
                if($last_item->exists()){

                // Check if $last_item is null to handle cases where there are no items in the database
                $last_item_id = $last_item->id+10000 ;
                 $item->item_barcode = $last_item_id ;
                }else{
                    $item->item_barcode=10001;
                }
            }
            
            else{
                $item->item_barcode = $request->item_barcode;

            }



            
            if ($request->hasFile('item_image')) {
                $item->item_image=$uniqueName;
            }
            $item->save();
            return redirect('item');
        } else {
            return redirect('/itemform')->withInput()->withErrors($validator);

        }



    }

    public function itemformview($id)
    {
        $record = item::where('firm_id',Auth::user()->firm_id)->find($id);

        return view('master.itemformview', ['data' => $record]);

    }

    public function show_item_form_edit($id)
    {


        $company = company::where('firm_id',Auth::user()->firm_id)->get();
        $itemgroup = itemgroup::where('firm_id',Auth::user()->firm_id)->get();
        $unit = unit::where('firm_id',Auth::user()->firm_id)->get();
        $gstmaster = gstmaster::where('firm_id',Auth::user()->firm_id)->get();



        $record = item::where('firm_id',Auth::user()->firm_id)->find($id);
        $labelsetting=labelsetting::where('firm_id',Auth::user()->firm_id)->get();

        return view('master.itemformedit', ['data' => $record, 'companydata' => $company,
        'itemgroupdata' => $itemgroup,
        'unit' => $unit,
        'gstmaster' => $gstmaster,
        'labelsetting'=>$labelsetting,
    
    ]);

    }
    public function edit_item(Request $request)
    {

        // dd("test");
        // this is use for save the record of edited item 
        $validator = validator::make($request->all(), [
            'item_name' => 'required',
            'item_barcode' => 'numeric',
            'mrp' => 'required|numeric',
            'sale_rate' => 'required|numeric',
            // 'sale_rate_a' => 'numeric',
            // 'sale_rate_b' => 'numeric',
            // 'sale_rate_c' => 'numeric',
            // 'purchase_rate' => 'numeric',
            // 'group_id'=>'required|numeric',
            // 'company_id'=>'required|numeric',
            // 'item_gst_id'=>'required|numeric',
            'unit_id' => 'required|numeric',
        ]);
        // echo"<pre>";
        // print_r($request->all());
        if ($validator->passes()) {
            $company_name = company::where('firm_id',Auth::user()->firm_id)->find($request->company_id);
            $group_name = itemgroup::where('firm_id',Auth::user()->firm_id)->find($request->group_id);
            $unit_name = unit::where('firm_id',Auth::user()->firm_id)->find($request->unit_id);
            $item = item::where('firm_id',Auth::user()->firm_id)->find($request->id);
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
        try {
            // Attempt to delete the item
            item::where('firm_id',Auth::user()->firm_id)
            ->where('id',$id)
            ->delete();
    
            // Redirect back with success message
            return redirect('item')->with('message', 'Item deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Catch the exception and show a friendly error message
            return redirect('item')->with('error', 'Item is used in a transaction. Please delete the transaction first.');
        }
    }
    

    public function searchitem($item_id)
    {
        // Search for the customer by contact number
        $item = item::where('firm_id',Auth::user()->firm_id)
        ->with('gstmaster')-> where('id', $item_id)->first();

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
    public function searchitem_batch($item_id)
    {
        $startTime = microtime(true); // Start timer
    
        $batch = batch::where('firm_id', Auth::user()->firm_id)
                      ->where('item_id', $item_id)
                      ->get();
    
        $endTime = microtime(true); // End timer
        $executionTime = round(($endTime - $startTime) * 1000, 2); // Time in milliseconds
    
        if ($batch->isNotEmpty()) {
            return response()->json([
                'message' => '<p class="alert alert-success">Batch Record Found</p>',
                'batch_info' => $batch->toArray(),
                'execution_time_ms' => $executionTime . ' ms'
            ]);
        } else {
            return response()->json([
                'message' => '<p class="alert alert-danger">No Record Found for selected item</p>',
                'batch_info' => null,
                'execution_time_ms' => $executionTime . ' ms'
            ]);
        }
    }
    


    public function importItems(Request $request)
{
    Excel::import(new FullItemsImport, $request->file('file'));
    return back()->with('success', 'Items and master data imported successfully!');
}
}