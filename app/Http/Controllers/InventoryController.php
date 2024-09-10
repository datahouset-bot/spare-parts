<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use App\Http\Requests\StoreinventoryRequest;
use App\Http\Requests\UpdateinventoryRequest;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $closing_stock = Inventory::select('item_id', 'item_name')
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
        $closing_stock = Inventory::with('godown')->select('item_id', 'item_name', 'godown_id')
        ->selectRaw('COALESCE(SUM(stock_in), 0) as total_stock_in')
        ->selectRaw('COALESCE(SUM(stock_out), 0) as total_stock_out')
        ->selectRaw('COALESCE(SUM(stock_in), 0) - COALESCE(SUM(stock_out), 0) as total_stock')
        ->groupBy('item_id', 'item_name', 'godown_id')
        ->with('godown') // Assuming godown relation exists
        ->get()
        ->groupBy('godown_id'); // Group by godown ID

    
    return view("reports.stock.stockstatus_store_wise", compact("closing_stock"));

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
