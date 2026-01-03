<?php

namespace App\Http\Controllers;
use App\Models\ledger;
use App\Models\account;
use App\Models\optionlist;
use App\Models\roomcheckin;
use App\Models\accountgroup;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LedgerController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function reciepts()
    { 
        $ledger_record = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        ->where('transaction_type','Receipts')->count();
         if ($ledger_record > 0) {
            $lastRecord = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->where('transaction_type','Receipts')
            ->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)
            ->where('voucher_type_name', 'Receipts')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)
            ->where('voucher_type_name', 'Receipts')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }

      
        $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
        ->whereHas('accountGroup', function ($query) {
            $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
        })
        ->get();
        $account_names=account::where('firm_id',Auth::user()->firm_id)
        ->orderBy('account_name','asc')->get();
        $subquery = Ledger::select(DB::raw('MIN(id)'))
        ->where('transaction_type', 'Receipts') // Apply this filter before grouping
        ->where('firm_id',Auth::user()->firm_id)
        ->groupBy('voucher_no');
    
    $ledgers = Ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
         ->whereIn('id', $subquery)
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->get();
    
    



   


        return view('entery.reciept.reciept',compact('paymentmodes','account_names','new_bill_no','new_voucher_no','voucher_type','ledgers'));


    }

// ========================Select format of receipt format view=======================================


public function reciepts_format($voucher_no){
 $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Receipts')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('entery.reciept.receipt_format_print', compact('voucher_no', 'fromtlist'));
}
// ====================================print reepit print===============================================
public function slip_print_view($voucher_no) 
{
        $account_names=account::where('firm_id',Auth::user()->firm_id)
        ->orderBy('account_name','asc')->get();
        $subquery = Ledger::select(DB::raw('MIN(id)'))
        ->where('transaction_type', 'Receipts') // Apply this filter before grouping
        ->where('firm_id',Auth::user()->firm_id)
        ->groupBy('voucher_no');
    
    $ledgers = Ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
         ->whereIn('id', $subquery)
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->get();
    

    return view('entery.reciept.reciept_print_view', compact('account_names','ledgers') );
}



// ===========================Payment============================================================
    public function payments()
    { 
        $ledger_record = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        ->where('transaction_type','Payments')->count();
         if ($ledger_record > 0) {
            $lastRecord = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->where('transaction_type','Payments')
            ->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)
            ->where('voucher_type_name', 'Payments')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)
            ->where('voucher_type_name', 'Payments')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }

      
        $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
        ->whereHas('accountGroup', function ($query) {
            $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
        })
        ->get();
        $account_names=account::where('firm_id',Auth::user()->firm_id)
        ->orderBy('account_name','asc')->get();

        $ledgers = Ledger::withinFY('entry_date')->whereIn('id', function ($query) {
            $query->select(DB::raw('MIN(id)'))
                  ->from('ledgers')
                  ->where('transaction_type', 'Payments')
                  ->where('firm_id', Auth::user()->firm_id) // Filter by firm_id in the subquery
                  ->groupBy('voucher_no');
        })
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->get();



 


        return view('entery.payment.payment',compact('paymentmodes','account_names','new_bill_no','new_voucher_no','voucher_type','ledgers'));


    }
// ============================================Select payment format=============================================================================================
public function payment_format($voucher_no){
 $fromtlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Payments')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('entery.payment.payment_format_print', compact('voucher_no', 'fromtlist'));
}
// =================================================select payment print format=======================================================================================
public function payment_print_view($voucher_no)
{
     $account_names=account::where('firm_id',Auth::user()->firm_id)
        ->orderBy('account_name','asc')->get();

        $ledgers = Ledger::withinFY('entry_date')->whereIn('id', function ($query) {
            $query->select(DB::raw('MIN(id)'))
                  ->from('ledgers')
                  ->where('transaction_type', 'Payments')
                  ->where('firm_id', Auth::user()->firm_id) // Filter by firm_id in the subquery
                  ->groupBy('voucher_no');
        })
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->get();

    
     return view('entery.payment.payment_print_view',compact('ledgers','account_names') );
}

// ====================================================================select print view 2nd format====================================================================================================
public function payment_print_view2($voucher_no)
{
     $account_names=account::where('firm_id',Auth::user()->firm_id)
        ->orderBy('account_name','asc')->get();

        $ledgers = Ledger::withinFY('entry_date')->whereIn('id', function ($query) {
            $query->select(DB::raw('MIN(id)'))
                  ->from('ledgers')
                  ->where('transaction_type', 'Payments')
                  ->where('firm_id', Auth::user()->firm_id) // Filter by firm_id in the subquery
                  ->groupBy('voucher_no');
        })
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->get();

    
     return view('entery.payment.payment_print_view2',compact('ledgers','account_names') );
}
// ================================================================================thirt print view===============================================================================
public function payment_print_view3($voucher_no)
{
     $account_names=account::where('firm_id',Auth::user()->firm_id)
        ->orderBy('account_name','asc')->get();

        $ledgers = Ledger::withinFY('entry_date')->whereIn('id', function ($query) {
            $query->select(DB::raw('MIN(id)'))
                  ->from('ledgers')
                  ->where('transaction_type', 'Payments')
                  ->where('firm_id', Auth::user()->firm_id) // Filter by firm_id in the subquery
                  ->groupBy('voucher_no');
        })
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->get();

    
     return view('entery.payment.payment_print_view3',compact('ledgers','account_names') );
}
// =======================================================================================================================================================

    public function reciept_store(Request $request)
    { 


        
        $validator= validator::make($request->all(),[
            'voucher_no' => 'required|string',
            'entry_date' => 'required|date',
            'payment_mode_id' => 'required|integer',
            'account_id' => 'required|integer',
            'receipt_amount' => 'required|numeric',
            'receipt_remark' => 'nullable|string', 
            'transaction_type'=>'required|string',
            'reciept_no'=>'required',
            ]);
            $date_variable=$request->entry_date;
            $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
             $formatted_entry_date = $parsed_date->format('Y-m-d');
       

              $fy_start_date = $this->fy_start_date;
            $fy_end_date = $this->fy_end_date;
            $financialyeardata = $this->financialyeardata;
            if (
                $financialyeardata &&
                $formatted_entry_date < $fy_start_date ||
                $formatted_entry_date > $fy_end_date
            ) {

                return view('error.checkdate_on_fy',compact('fy_start_date','fy_end_date'));

            }
             $accountname = account::where('firm_id',Auth::user()->firm_id)
             ->with('accountgroup')
             ->where('id', $request->account_id)->first();
             $paymentmode=account::where('firm_id',Auth::user()->firm_id)
             ->with('accountgroup')
             ->where('id', $request->payment_mode_id)->first();

            if ($validator->passes()) {
                $ledger = new ledger;
                $ledger->firm_id=Auth::user()->firm_id;
                
                $ledger->voucher_no = $request->voucher_no;
                $ledger->reciept_no = $request->reciept_no;
                $ledger->entry_date =  $formatted_entry_date;
                $ledger->transaction_type =$request->transaction_type  ;
                $ledger->payment_mode_id = $request->account_id;
                $ledger->payment_mode_name = $paymentmode->account_name;

                $ledger->account_id = $request->account_id;
                $ledger->account_name = $accountname->account_name;
                $ledger->account_group_id =$accountname->account_group_id ;
                $ledger->account_group_name = $accountname->accountgroup->account_group_name;
                $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
                $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
                $ledger->credit = $request->receipt_amount;           
                $ledger->amount = $request->receipt_amount;
                $ledger->remark = $request->receipt_remark;  
                $ledger->simpal_amount = "-" . $request->receipt_amount;
                $ledger->userid = Auth::user()->id; // Assign the authenticated user's ID
                $ledger->username = Auth::user()->name;
                $ledger->save();


                $ledger = new ledger;
                $ledger->firm_id=Auth::user()->firm_id;
                
                $ledger->voucher_no = $request->voucher_no;
                $ledger->reciept_no = $request->reciept_no;
                $ledger->entry_date =  $formatted_entry_date;
                $ledger->transaction_type =$request->transaction_type  ;
                $ledger->payment_mode_id = $request->payment_mode_id;
                $ledger->payment_mode_name = $accountname->account_name;                
                $ledger->account_id = $request->payment_mode_id;
                $ledger->account_name = $paymentmode->account_name;
                $ledger->account_group_id =$paymentmode->account_group_id ;
                $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
                $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
                $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
                $ledger->debit = $request->receipt_amount;
                $ledger->amount = $request->receipt_amount;
                $ledger->remark = $request->receipt_remark;  
                $ledger->simpal_amount = "+" . $request->receipt_amount;
                $ledger->userid = Auth::user()->id; 
                $ledger->username = Auth::user()->name;
                $ledger->save();
        
                return redirect('/reciepts')->with('message', 'entery saved created successfully!');
            } else {
                return redirect('/reciepts')->withInput()->withErrors($validator)->with('error', 'Record Not Save ');
            }    
    }    


            public function payment_store(Request $request)
            { 
        
                $validator= validator::make($request->all(),[
                    'voucher_no' => 'required|string',
                    'entry_date' => 'required|date',
                    'payment_mode_id' => 'required|integer',
                    'account_id' => 'required|integer',
                    'receipt_amount' => 'required|numeric',
                    'receipt_remark' => 'nullable|string', 
                    'transaction_type'=>'required|string',
                    'reciept_no'=>'required',
                    ]);
                    $date_variable=$request->entry_date;
                    $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
                     $formatted_entry_date = $parsed_date->format('Y-m-d');
                       $fy_start_date = $this->fy_start_date;
            $fy_end_date = $this->fy_end_date;
            $financialyeardata = $this->financialyeardata;
            if (
                $financialyeardata &&
                $formatted_entry_date < $fy_start_date ||
                $formatted_entry_date > $fy_end_date
            ) {

                return view('error.checkdate_on_fy',compact('fy_start_date','fy_end_date'));

            }
                     $accountname = account::where('firm_id',Auth::user()->firm_id)->with('accountgroup')
                     ->where('id', $request->account_id)->first();
                     $paymentmode=account::where('firm_id',Auth::user()->firm_id)->with('accountgroup')
                     ->where('id', $request->payment_mode_id)->first();
        
                    if ($validator->passes()) {
                        $ledger = new ledger;
                        $ledger->firm_id=Auth::user()->firm_id;

                    
                        $ledger->voucher_no = $request->voucher_no;
                        $ledger->reciept_no = $request->reciept_no;
                        $ledger->entry_date =  $formatted_entry_date;
                        $ledger->transaction_type =$request->transaction_type  ;
                        $ledger->payment_mode_id = $request->account_id;
                        $ledger->payment_mode_name = $paymentmode->account_name;
        
                        $ledger->account_id = $request->account_id;
                        $ledger->account_name = $accountname->account_name;
                        $ledger->account_group_id =$accountname->account_group_id ;
                        $ledger->account_group_name = $accountname->accountgroup->account_group_name;
                        $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
                        $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
                        $ledger->debit = $request->receipt_amount;                
 
                        $ledger->amount = $request->receipt_amount;
                        $ledger->remark = $request->receipt_remark;  
                        $ledger->simpal_amount = "-" . $request->receipt_amount;
                        $ledger->userid = Auth::user()->id; 
                        $ledger->username = Auth::user()->name;
                        $ledger->save();
        
        
                        $ledger = new ledger;
                        $ledger->firm_id=Auth::user()->firm_id;
                        $ledger->voucher_no = $request->voucher_no;
                        $ledger->reciept_no = $request->reciept_no;
                        $ledger->entry_date =  $formatted_entry_date;
                        $ledger->transaction_type =$request->transaction_type  ;
                        $ledger->payment_mode_id = $request->payment_mode_id;
                        $ledger->payment_mode_name = $accountname->account_name;                
                        $ledger->account_id = $request->payment_mode_id;
                        $ledger->account_name = $paymentmode->account_name;
                        $ledger->account_group_id =$paymentmode->account_group_id ;
                        $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
                        $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
                        $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
                        $ledger->credit = $request->receipt_amount;

                        $ledger->amount = $request->receipt_amount;
                        $ledger->remark = $request->receipt_remark;  
                        $ledger->simpal_amount = "+" . $request->receipt_amount;
                        $ledger->userid = Auth::user()->id; 
                        $ledger->username = Auth::user()->name;
                        $ledger->save();
                
                        return redirect('/payments')->with('message', 'Entery saved  successfully!');
                    } else {
                        return redirect('/payments')->withInput()->withErrors($validator)->with('error', 'Record Not Save ');
                    }    
             


    }



     public function index()    {
        $accounts = Account::where('firm_id',Auth::user()->firm_id)->orderBy('account_name', 'asc')->get();
        $final_opning_balance=0;
        return view('reports.ledger.ledger',compact('accounts','final_opning_balance'));

    }
    public function outstanding_receivable()    {
        //this is open first page 
        $outstandingReceivables=[];
   
    return view('reports.ledger.outstanding_receivable', compact('outstandingReceivables'));

    }
    public function outstanding_payable()    {

     //this is open first page 
       $outstandingPayables=[];
   
    return view('reports.ledger.outstanding_payable', compact('outstandingPayables'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function advace_receipt()
    { 
        $ledger_record = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)->where('transaction_type','Advance_Receipt')->count();
         if ($ledger_record > 0) {
            $lastRecord = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
            ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
            ->where('transaction_type','Advance_Receipt')
            ->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Advance_Receipt')
            ->where('firm_id',Auth::user()->firm_id)
            ->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('firm_id',Auth::user()->firm_id)
            ->where('voucher_type_name', 'Advance_Receipt')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }

      
        $paymentmodes = account::where('firm_id', Auth::user()->firm_id)
        ->whereHas('accountGroup', function ($query) {
            $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
        })
        ->get();
        $account_names = roomcheckin::where('firm_id',Auth::user()->firm_id)->with('account')
        ->where('checkout_voucher_no', '0')
        ->get()
        ->groupBy('guest_name')
        ->map(function ($group) {
            return $group->first();
        });
    
        // $ledgers = Ledger::withinFY('entry_date')->whereIn('id', function($query) {
        //     $query->select(DB::raw('MIN(id)'))
        //         ->from('ledgers')
        //         ->groupBy('voucher_no');
        // })
        // ->where('transaction_type','Advance_Receipt')
        // ->orderBy('voucher_no','desc')
        // ->get();
        $ledgers = Ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        ->where('transaction_type', 'Advance_Receipt')
        ->orderByRaw('CAST(voucher_no AS UNSIGNED) DESC')
        ->get()
        ->groupBy('voucher_no')
        ->map(function ($voucher_no) {
            return $voucher_no->last();
        });




   


        return view('entery.advance_receipt.advace_receipt',compact('paymentmodes','account_names','new_bill_no','new_voucher_no','voucher_type','ledgers'));


    }

    public function advace_receipt_store(Request $request)
    { 

        $validator= validator::make($request->all(),[
            'voucher_no' => 'required|string',
            'entry_date' => 'required|date',
            'payment_mode_id' => 'required|integer',
            'account_id' => 'required|integer',
            'receipt_amount' => 'required|numeric',
            'receipt_remark' => 'nullable|string', 
            'transaction_type'=>'required|string',
            'reciept_no'=>'required',
            ]);
            $date_variable=$request->entry_date;
            $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
             $formatted_entry_date = $parsed_date->format('Y-m-d');
               $fy_start_date = $this->fy_start_date;
            $fy_end_date = $this->fy_end_date;
            $financialyeardata = $this->financialyeardata;
            if (
                $financialyeardata &&
                $formatted_entry_date < $fy_start_date ||
                $formatted_entry_date > $fy_end_date
            ) {

                return view('error.checkdate_on_fy',compact('fy_start_date','fy_end_date'));

            }
             $accountname = account::where('firm_id',Auth::user()->firm_id)->with('accountgroup')
             ->where('id', $request->account_id)->first();
             $paymentmode=account::where('firm_id',Auth::user()->firm_id)->with('accountgroup')
             ->where('id', $request->payment_mode_id)->first();

            if ($validator->passes()) {
                $ledger = new ledger;
                $ledger->firm_id=Auth::user()->firm_id;
                $ledger->voucher_no = $request->voucher_no;
                $ledger->reciept_no = $request->reciept_no;
                $ledger->entry_date =  $formatted_entry_date;
                $ledger->transaction_type =$request->transaction_type  ;
                $ledger->payment_mode_id = $request->account_id;
                $ledger->payment_mode_name = $paymentmode->account_name;

                $ledger->account_id = $request->account_id;
                $ledger->account_name = $accountname->account_name;
                $ledger->account_group_id =$accountname->account_group_id ;
                $ledger->account_group_name = $accountname->accountgroup->account_group_name;
                $ledger->primary_group_id = $accountname->accountgroup->primary_group_id;
                $ledger->primary_group_name = $accountname->accountgroup->primaryGroup->primary_group_name;
                $ledger->credit = $request->receipt_amount;           
                $ledger->amount = $request->receipt_amount;
                $ledger->remark = $request->receipt_remark;  
                $ledger->simpal_amount = "-" . $request->receipt_amount;
                $ledger->userid = Auth::user()->id; 
                $ledger->username = Auth::user()->name;
                $ledger->save();


                $ledger = new ledger;
                $ledger->firm_id=Auth::user()->firm_id;
                $ledger->voucher_no = $request->voucher_no;
                $ledger->reciept_no = $request->reciept_no;
                $ledger->entry_date =  $formatted_entry_date;
                $ledger->transaction_type =$request->transaction_type  ;
                $ledger->payment_mode_id = $request->payment_mode_id;
                $ledger->payment_mode_name = $accountname->account_name;                
                $ledger->account_id = $request->payment_mode_id;
                $ledger->account_name = $paymentmode->account_name;
                $ledger->account_group_id =$paymentmode->account_group_id ;
                $ledger->account_group_name = $paymentmode->accountgroup->account_group_name;
                $ledger->primary_group_id = $paymentmode->accountgroup->primary_group_id;
                $ledger->primary_group_name = $paymentmode->accountgroup->primaryGroup->primary_group_name;
                $ledger->debit = $request->receipt_amount;
                $ledger->amount = $request->receipt_amount;
                $ledger->remark = $request->receipt_remark;  
                $ledger->simpal_amount = "+" . $request->receipt_amount;
                $ledger->userid = Auth::user()->id; 
                $ledger->username = Auth::user()->name;
                $ledger->save();
        
                return redirect('/advace_receipt')->with('message', 'entery saved created successfully!');
            } else {
                return redirect('/advace_receipt')->withInput()->withErrors($validator)->with('error', 'Record Not Save ');
            }    
    }    
    public function advace_receipt_print($id)
    { 
        $advancereceipts = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        ->where('transaction_type','Advance_Receipt')
        ->where('voucher_no',$id)
        ->first();

       return view('entery.advance_receipt.advance_receipt_print_view',compact('advancereceipts'));
        
          
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function ledger_show(Request $request)
    {
        $account_id = $request->account_id;

        $date_variable=$request->from_date;
        $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_from_date = $parsed_date->format('Y-m-d');
       
        $date_variable=$request->to_date;
        $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_to_date = $parsed_date->format('Y-m-d');
       
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $ledgers = Ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        ->where('account_id', $account_id)
        ->whereBetween('entry_date', [$formatted_from_date, $formatted_to_date])
        ->get();

        $accounts = Account::where('firm_id',Auth::user()->firm_id)
        ->orderBy('account_name', 'asc')->get();
        $account_name = Account::where('firm_id',Auth::user()->firm_id)->find($account_id);
        $opening_balance_account=$account_name->op_balnce;
        $opning_balance_type=$account_name->balnce_type;
        if($formatted_to_date>$formatted_from_date){
            $date_variable = $request->from_date;
            $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
            $one_day_before = $parsed_date->subDay(); // Subtract one day
            $formatted_from_date_onedaybefore = $one_day_before->format('Y-m-d');

            $ledgers_before_fromdate = Ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)->first()
        ->where('account_id', $account_id)
        ->where('entry_date', '<=', $formatted_from_date_onedaybefore)
        ->get();
 

        }

        else if($formatted_to_date=$formatted_from_date){
            $date_variable = $request->from_date;
            $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
            $one_day_before = $parsed_date->subDay(); // Subtract one day
            $formatted_from_date_onedaybefore = $one_day_before->format('Y-m-d');
                       

            $ledgers_before_fromdate = Ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
            ->where('account_id', $account_id)
        ->where('entry_date', '<=', $formatted_from_date_onedaybefore)
        ->get();
        }
        else {
            return("Your Date Selection Is Wrong Please Try Again With proper Date ");
        }
        $debit_total=0;
        $credit_total=0;

        foreach($ledgers_before_fromdate  as $record )
        {
            $debit_total+=$record->debit;
            $credit_total+=$record->credit;
       }
       $total_balance=$debit_total-$credit_total;
       if($opning_balance_type==='Dr'){
        $final_opning_balance=$total_balance+$opening_balance_account;
       }else{
        $final_opning_balance=$total_balance-$opening_balance_account;
       }

    //    dd($final_opning_balance);



 
        if(!$ledgers->isEmpty()  ){
        return view('reports.ledger.ledger_show',compact('accounts','ledgers','account_name','from_date','to_date','final_opning_balance'));
              }
        else{
            return view('reports.ledger.ledger',compact('accounts','ledgers','account_name','from_date','to_date','final_opning_balance'))->with('message','No Record Found ');
        }      
    }

    public function destroy($id)
    {
        
        $ledger = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        ->where('transaction_type','Receipts')
        ->where('voucher_no',$id);

        // Check if the package exists
        if ($ledger) {
            // Delete the package
            $ledger->delete();
            return redirect('/reciepts')->with('message', 'Reciepts Delete successfully!');
        } else {
            // Package not found
            return redirect('/reciepts')->with('message', 'Reciepts Not Found');

        }
    }

    public function payment_delete($id)
    {
        
        $ledger = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        ->where('transaction_type','Payments')
        ->where('voucher_no',$id);

        // Check if the package exists
        if ($ledger) {
            // Delete the package
            $ledger->delete();
            return redirect('/payments')->with('message', 'Payments Delete successfully!');
        } else {
            // Package not found
            return redirect('/payments')->with('message', 'Payments Not Found');

        }
    }
    public function advace_receipt_delete($id)
    {
        
        $ledger = ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        ->where('transaction_type','Advance_Receipt')
        ->where('voucher_no',$id);

        // Check if the package exists
        if ($ledger) {
            // Delete the package
            $ledger->delete();
            return redirect('/advace_receipt')->with('message', 'advace receipt Delete successfully!');
        } else {
            // Package not found
            return redirect('/advace_receipt')->with('message', 'advace receipt Not Found');

        }
    }
    
   public function outstanding_receivable_result(Request $request)
{
    $date_variable = $request->to_date;
    $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_to_date = $parsed_date->format('Y-m-d');

    $firm_id = Auth::user()->firm_id;

    // Get active Financial Year
    $financialyear = \App\Models\financialyear::where('firm_id', $firm_id)
        ->where('is_active_fy', 1)
        ->first();

    // Initialize optional date filter
    $dateFilterStart = null;
    $dateFilterEnd = null;

    if ($financialyear) {
        $dateFilterStart = $financialyear->financial_year_start;
        $dateFilterEnd = $financialyear->financial_year_end;
    }

    // Build query
    $accountsQuery = Account::select(
        'accounts.id',
        'accounts.firm_id',
        'accounts.account_name',
        'accounts.op_balnce',
        'accounts.balnce_type',
        'accounts.mobile',
        DB::raw('SUM(CASE WHEN '.($dateFilterStart ? 'ledgers.entry_date BETWEEN "'.$dateFilterStart.'" AND "'.$dateFilterEnd.'"' : '1=1').' THEN ledgers.debit ELSE 0 END) as total_debit'),
        DB::raw('SUM(CASE WHEN '.($dateFilterStart ? 'ledgers.entry_date BETWEEN "'.$dateFilterStart.'" AND "'.$dateFilterEnd.'"' : '1=1').' THEN ledgers.credit ELSE 0 END) as total_credit')
    )
    ->leftJoin('ledgers', 'accounts.id', '=', 'ledgers.account_id')
    ->where('accounts.firm_id', $firm_id)
    ->groupBy(
        'accounts.id',
        'accounts.firm_id',
        'accounts.account_name',
        'accounts.op_balnce',
        'accounts.balnce_type',
        'accounts.mobile'
    );

    $accounts = $accountsQuery->get();

    // Filter only positive receivables
    $outstandingReceivables = $accounts->filter(function ($account) {
        if ($account->balnce_type === 'Dr') {
            $balance = $account->op_balnce + $account->total_debit - $account->total_credit;
            return $balance > 0;
        } else {
            $balance = $account->total_debit - $account->op_balnce - $account->total_credit;
            return $balance > 0;
        }
    });

    return view('reports.ledger.outstanding_receivable', compact('outstandingReceivables'));
}


public function outstanding_payable_result(Request $request)
{
    // Parse and format to_date (optional for future use)
    $date_variable = $request->to_date;
    $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
    $formatted_to_date = $parsed_date->format('Y-m-d');

    $firm_id = Auth::user()->firm_id;

    // Get active financial year
    $financialyear = \App\Models\financialyear::where('firm_id', $firm_id)
        ->where('is_active_fy', 1)
        ->first();

    // Initialize optional date filter
    $dateFilterStart = null;
    $dateFilterEnd = null;

    if ($financialyear) {
        $dateFilterStart = $financialyear->financial_year_start;
        $dateFilterEnd = $financialyear->financial_year_end;
    }

    // Fetch accounts and sum ledger values conditionally
    $accounts = Account::select(
            'accounts.id',
            'accounts.account_name',
            'accounts.op_balnce',
            'accounts.balnce_type',
            'accounts.mobile',
            DB::raw('SUM(CASE WHEN '.($dateFilterStart ? 'ledgers.entry_date BETWEEN "'.$dateFilterStart.'" AND "'.$dateFilterEnd.'"' : '1=1').' THEN ledgers.debit ELSE 0 END) as total_debit'),
            DB::raw('SUM(CASE WHEN '.($dateFilterStart ? 'ledgers.entry_date BETWEEN "'.$dateFilterStart.'" AND "'.$dateFilterEnd.'"' : '1=1').' THEN ledgers.credit ELSE 0 END) as total_credit')
        )
        ->leftJoin('ledgers', 'accounts.id', '=', 'ledgers.account_id')
        ->where('accounts.firm_id', $firm_id)
        ->groupBy(
            'accounts.id',
            'accounts.account_name',
            'accounts.op_balnce',
            'accounts.balnce_type',
            'accounts.mobile'
        )
        ->get();

    // Filter for outstanding payables (negative balances)
    $outstandingPayables = $accounts->filter(function ($account) {
        if ($account->balnce_type === 'Dr') {
            $balance = $account->op_balnce + $account->total_debit - $account->total_credit;
        } else {
            $balance = $account->total_debit - $account->op_balnce - $account->total_credit;
        }
        return $balance < 0;
    });

    return view('reports.ledger.outstanding_payable', compact('outstandingPayables'));
}

    public function dayend_report(Request $request)
{
    
    $listofaccount = account::where('firm_id', Auth::user()->firm_id)
    ->whereHas('accountGroup', function ($query) {
        $query->whereIn('account_group_name', ['BANK ACCOUNT', 'Cash In Hand']);
    })
    ->get();

    $current_date = \Carbon\Carbon::now();
    $formatted_current_date = $current_date->format('Y-m-d');
     $one_day_before=\Carbon\Carbon::now();
     $one_day_before = now()->subDay(); // Get current date and subtract one day
    $formated_one_day_before = $one_day_before->format('Y-m-d');
   

    $from_date = $request->from_date;
    $to_date = $request->to_date;

    $all_reports = [];

    foreach ($listofaccount as $account) {
        $account_id = $account->id;
        $account_name = $account->account_name;
        $opening_balance_account = $account->op_balnce;
        $opning_balance_type = $account->balnce_type;

        $ledgers = Ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
        
        ->where('account_id', $account_id)
            ->whereBetween('entry_date', [$formatted_current_date, $formatted_current_date])
            ->get();

        $ledgers_before_fromdate = Ledger::withinFY('entry_date')->where('firm_id',Auth::user()->firm_id)
            ->where('account_id', $account_id)
            ->where('entry_date', '<=', $formated_one_day_before)
            ->get();

        $debit_total = 0;
        $credit_total = 0;

        foreach ($ledgers_before_fromdate as $record) {
            $debit_total += $record->debit;
            $credit_total += $record->credit;
        }

        $total_balance = $debit_total - $credit_total;
        $final_opning_balance = ($opning_balance_type === 'Dr') ? $total_balance + $opening_balance_account : $total_balance - $opening_balance_account;

        $all_reports[] = [
            'account_name' => $account_name,
            'ledgers' => $ledgers,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'final_opning_balance' => $final_opning_balance,
        ];
    }

    $accounts = Account::where('firm_id',Auth::user()->firm_id)->orderBy('account_name', 'asc')->get();

    return view('reports.ledger.dayend_report', compact('accounts', 'all_reports','formatted_current_date'));
}


    
}
