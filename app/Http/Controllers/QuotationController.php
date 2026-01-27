<?php

namespace App\Http\Controllers;

use App\Models\ledger;
use App\Models\voucher;
use App\Models\inventory;
use App\Models\Quotation;
use App\Models\optionlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('Quotation Controller Index Method');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $sales = voucher::withinFY('entry_date')->with('account')
        ->where('firm_id', Auth::user()->firm_id)
        ->where('voucher_type','sale')->orderBy('voucher_no','desc')->get();
          return view('quotation.quotation_index',compact('sales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
           $voucher = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no', $id)->where('voucher_type','Sale');
        $inventory=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no', $id)->where('voucher_type','Sale');
        $ledger = ledger::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('firm_id', Auth::user()->firm_id)->where('transaction_type', 'sale');

      


        if ($voucher->count()>0 && $inventory->count()>0 ) {
            $voucher->delete();
            $inventory->delete();
            $ledger->delete();
            return redirect('/quotations/create')->with('message', 'All matching Record deleted successfully!');

        }
        else{

            return redirect('/quotations/create')->with('message', 'No Recoird  found ');

        } 
    }
     Public function print_quotation_select($voucher_no){
      
    $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'quotation')
            ->orderBy('updated_at', 'desc')
            ->get();
    return view('quotation.quotation_print_select', compact( 'fromtlist','voucher_no'));        

   }
  


   Public function quotation_print_view($voucher_no){
    $salebill_header = voucher::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->with('account')->where('voucher_type','Sale')->where('voucher_no',$voucher_no)->first(); 
   $salebill_items=inventory::withinFY('entry_date')-> where('firm_id',Auth::user()->firm_id)->where('voucher_no',$salebill_header->voucher_no)
   ->where('voucher_type','sale')
   ->get();

 return view('quotation.quotation_print_view',compact('salebill_header','salebill_items'));

}   
 Public function quotationform(){
      
   $last_voucher = Quotation::withinFY('entry_date')
        ->where('firm_id', Auth::user()->firm_id)
        ->where('voucher_type', 'quotation')
        ->orderBy('voucher_no', 'desc')
        ->first();

    return view('quotation.quotation_create', compact('last_voucher'));
   }
}
