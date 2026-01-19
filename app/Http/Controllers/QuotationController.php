<?php

namespace App\Http\Controllers;

use App\Models\voucher;
use App\Models\Quotation;
use App\Models\optionlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('quotation.quotation_create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          $sales = Quotation::withinFY('entry_date')->with('account')
        ->where('firm_id', Auth::user()->firm_id)
        ->where('voucher_type','Sale')->orderBy('voucher_no','desc')->get();

    return view('quotation.quotation_index', compact('sales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

     Public function print_quotation_select($voucher_no){
      
    $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Quotation')
            ->orderBy('updated_at', 'desc')
            ->get();
    return view('entery.sale.sale_print_select', compact( 'fromtlist','voucher_no'));        

   }
  
    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        //
    }
}
