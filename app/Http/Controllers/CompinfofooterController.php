<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\compinfofooter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorecompinfofooterRequest;
use App\Http\Requests\UpdatecompinfofooterRequest;

class CompinfofooterController extends CustomBaseController
{
    public function __construct()
     {
         $this->middleware(['auth','verified']);
 
     }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compinfofooter = compinfofooter::find(1);
        if (!$compinfofooter) {
            $compinfofooter = new compinfofooter();
            $compinfofooter->id = 1;
            $compinfofooter->bank_name = "enterbankname" ;
            $compinfofooter->bank_ac_no = "Eneter Bank A/C NO ";
            $compinfofooter->bank_ifsc ="Eneter Bank ifsc ";
            $compinfofooter->upiid = "upiid";
            $compinfofooter->pay_no = "pay_no";
            $compinfofooter->bank_branch = "bank_branch";
            $compinfofooter->voucher_prefix = "voucher_prefix";
            $compinfofooter->voucher_suffix = "voucher_suffix";
            $compinfofooter->voucher_note = "voucher_note";
            $compinfofooter->country = "country";
            $compinfofooter->currency = "currency";
            $compinfofooter->terms = "terms";
            $compinfofooter->ct1 = "ct1";
            $compinfofooter->ct2 = "ct2";
            $compinfofooter->ct3 = "ct3";
            $compinfofooter->ct4 = "ct4"; //user for hotel link 
            $compinfofooter->ct5 = "ct5";  // use for hotel bank a/c name 
            $compinfofooter->ct6 = "ct6";
            $compinfofooter->ct7 = "ct7";
            $compinfofooter->ct8 = "ct8";
            $compinfofooter->ct9 = "ct9";
    
    
        
            $compinfofooter->save();
        } 
        return view ('setting.comp_info_footer',['compinfofooter'=>$compinfofooter]);
     
        
     }

    
    public function store(Request $request)
    {
        // echo"<pre>";
        // return print_r($request->all());
        $compinfofooter = compinfofooter::find(1);
        $compinfofooter->bank_name = $request->bank_name;
        $compinfofooter->bank_ac_no = $request->bank_ac_no;
        $compinfofooter->bank_ifsc = $request->bank_ifsc;
        $compinfofooter->upiid = $request->upiid;
        $compinfofooter->pay_no = $request->pay_no;
        $compinfofooter->bank_branch = $request->bank_branch;
        $compinfofooter->voucher_prefix = $request->voucher_prefix;
        $compinfofooter->voucher_suffix = $request->voucher_suffix;
        $compinfofooter->voucher_note = $request->voucher_note;
        $compinfofooter->country = $request->country;
        $compinfofooter->currency = $request->currency;
        $compinfofooter->terms = $request->terms;
        $compinfofooter->ct1 = $request->ct1;
        $compinfofooter->ct2 = $request->ct2;
        $compinfofooter->ct3 = $request->ct3;
        $compinfofooter->ct4 = $request->ct4; //use for hotel link 
        $compinfofooter->ct5 = $request->ct5; //use for bank/ac name
        $compinfofooter->ct6 = $request->ct6;
        $compinfofooter->ct7 = $request->ct7;
        $compinfofooter->ct8 = $request->ct8;
        $compinfofooter->ct9 = $request->ct9;


        $compinfofooter->update();
  
        return view('setting.comp_info_footer',['compinfofooter' => $compinfofooter])->with('message', 'Record Upaded Successfully!');

        }

        public function sql_query()
        {
            return view('setting.sql_query');
        }
    
        public function sql_query_execute(Request $request)
        {
            $sql = $request->input('sql_query');
            try {
                // Use DB::statement for non-select queries
                DB::statement($sql);
                return view('sql_query')->with('results', 'Query executed successfully.');
            } catch (\Exception $e) {
                return view('sql_query')->with('error', $e->getMessage());
            }
        }

    
}
