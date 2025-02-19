<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\inventory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreinventoryRequest;
use App\Http\Requests\UpdateinventoryRequest;
use Symfony\Component\HttpFoundation\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $closing_stock = Inventory::select('item_id', 'item_name')
            ->where('firm_id', Auth::user()->firm_id)
            ->selectRaw('COALESCE(SUM(stock_in), 0) as total_stock_in')
            ->selectRaw('COALESCE(SUM(stock_out), 0) as total_stock_out')
            ->selectRaw('COALESCE(SUM(stock_in), 0) - COALESCE(SUM(stock_out), 0) as total_stock')
            ->groupBy('item_id', 'item_name')
            ->get();


        return view("reports.stock.stockstatus", compact("closing_stock"));

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
    public function store(StoreinventoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $closing_stock = Inventory::where('firm_id', Auth::user()->firm_id)->with('godown')->select('item_id', 'item_name', 'godown_id')
            ->selectRaw('COALESCE(SUM(stock_in), 0) as total_stock_in')
            ->selectRaw('COALESCE(SUM(stock_out), 0) as total_stock_out')
            ->selectRaw('COALESCE(SUM(stock_in), 0) - COALESCE(SUM(stock_out), 0) as total_stock')
            ->groupBy('item_id', 'item_name', 'godown_id')
            ->with('godown')
            ->where('firm_id', Auth::user()->firm_id) // Assuming godown relation exists
            ->get()
            ->groupBy('godown_id'); // Group by godown ID


        return view("reports.stock.stockstatus_store_wise", compact("closing_stock"));

    }
    public function item_wise_stock_pageshow()
    {
        $items = item::where('firm_id', Auth::user()->firm_id)->orderBy('item_name', 'asc')->get();
        $final_opning_balance = 0;
        $inveterydata = [];
        return view('reports.stock.itemwise_stock', compact('items', 'final_opning_balance', 'inveterydata'));
    }



    public function item_wise_stock(Request $request)
    {
        $item_id = $request->item_id;




        $date_variable = $request->from_date;
        $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_from_date = $parsed_date->format('Y-m-d');

        $date_variable = $request->to_date;
        $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_to_date = $parsed_date->format('Y-m-d');

        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $inventorydata = inventory::where('firm_id', Auth::user()->firm_id)
            ->where('item_id', $item_id)
            ->whereBetween('entry_date', [$formatted_from_date, $formatted_to_date])
            ->get();


        $items = item::where('firm_id', Auth::user()->firm_id)
            ->orderBy('item_name', 'asc')->get();
        $item_name = item::where('firm_id', Auth::user()->firm_id)->find($item_id);
        $opening_balance_account = 0;

        if ($formatted_to_date > $formatted_from_date) {
            $date_variable = $request->from_date;
            $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
            $one_day_before = $parsed_date->subDay(); // Subtract one day
            $formatted_from_date_onedaybefore = $one_day_before->format('Y-m-d');

            $stock_before_fromdate = inventory::where('firm_id', Auth::user()->firm_id)->first()
                ->where('item_id', $item_id)
                ->where('entry_date', '<=', $formatted_from_date_onedaybefore)
                ->get();


        } else if ($formatted_to_date = $formatted_from_date) {
            $date_variable = $request->from_date;
            $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
            $one_day_before = $parsed_date->subDay(); // Subtract one day
            $formatted_from_date_onedaybefore = $one_day_before->format('Y-m-d');


            $stock_before_fromdate = inventory::where('firm_id', Auth::user()->firm_id)
                ->where('item_id', $item_id)
                ->where('entry_date', '<=', $formatted_from_date_onedaybefore)
                ->get();
        } else {
            return ("Your Date Selection Is Wrong Please Try Again With proper Date ");
        }
        $debit_total = 0;
        $credit_total = 0;


        foreach ($stock_before_fromdate as $record) {
            $debit_total += $record->stock_in;
            $credit_total += $record->stock_out;
        }
        $total_balance = $debit_total - $credit_total;
        
            $final_opning_balance = $total_balance ;
    //    dd($final_opning_balance); 





        if (!$inventorydata->isEmpty()) {
            return view('reports.stock.itemwise_stock_show', compact('inventorydata', 'items', 'item_name', 'from_date', 'to_date', 'final_opning_balance'));
        } else {
            return view('reports.stock.itemwise_stock_show', compact('inventorydata', 'items', 'item_name', 'from_date', 'to_date', 'final_opning_balance'))->with('message', 'No Record Found ');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateinventoryRequest $request, inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inventory $inventory)
    {
        //
    }
}
