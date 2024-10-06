<?php

namespace App\Http\Controllers;
use App\Models\ledger;
use App\Models\account;
use App\Models\roomcheckin;
use App\Models\accountgroup;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class LedgerController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function reciepts()
    { 
        $ledger_record = ledger::where('transaction_type','Receipts')->count();
         if ($ledger_record > 0) {
            $lastRecord = ledger::orderBy('voucher_no', 'desc')
            ->where('transaction_type','Receipts')
            ->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Receipts')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Receipts')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }

      
        $paymentmodes=account::where('account_group_id','4')
        ->orWhere('account_group_id','5')
        ->get();
        $account_names=account::orderBy('account_name','asc')->get();
        $subquery = Ledger::select(DB::raw('MIN(id)'))
        ->where('transaction_type', 'Receipts') // Apply this filter before grouping
        ->groupBy('voucher_no');
    
    $ledgers = Ledger::whereIn('id', $subquery)
        ->orderBy('voucher_no', 'desc')
        ->get();
    
    



   


        return view('entery.reciept.reciept',compact('paymentmodes','account_names','new_bill_no','new_voucher_no','voucher_type','ledgers'));


    }

    public function payments()
    { 
        $ledger_record = ledger::where('transaction_type','Payments')->count();
         if ($ledger_record > 0) {
            $lastRecord = ledger::orderBy('voucher_no', 'desc')
            ->where('transaction_type','Payments')
            ->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Payments')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Payments')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }

      
        $paymentmodes=account::where('account_group_id','4')
        ->orWhere('account_group_id','5')
        ->get();
        $account_names=account::orderBy('account_name','asc')->get();

        $ledgers = Ledger::whereIn('id', function($query) {
                $query->select(DB::raw('MIN(id)'))
                    ->from('ledgers')
                    ->where('transaction_type','Payments')
                    ->groupBy('voucher_no');
            })
            ->orderBy('voucher_no', 'desc')
            ->get();



 


        return view('entery.payment.payment',compact('paymentmodes','account_names','new_bill_no','new_voucher_no','voucher_type','ledgers'));


    }
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
             $accountname = account::with('accountgroup')
             ->where('id', $request->account_id)->first();
             $paymentmode=account::with('accountgroup')
             ->where('id', $request->payment_mode_id)->first();

            if ($validator->passes()) {
                $ledger = new ledger;
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
                $ledger->save();


                $ledger = new ledger;
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
                     $accountname = account::with('accountgroup')
                     ->where('id', $request->account_id)->first();
                     $paymentmode=account::with('accountgroup')
                     ->where('id', $request->payment_mode_id)->first();
        
                    if ($validator->passes()) {
                        $ledger = new ledger;
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
                        $ledger->save();
        
        
                        $ledger = new ledger;
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
                        $ledger->save();
                
                        return redirect('/payments')->with('message', 'Entery saved  successfully!');
                    } else {
                        return redirect('/payments')->withInput()->withErrors($validator)->with('error', 'Record Not Save ');
                    }    
             


    }



     public function index()    {
        $accounts = Account::orderBy('account_name', 'asc')->get();
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
        $ledger_record = ledger::where('transaction_type','Advance_Receipt')->count();
         if ($ledger_record > 0) {
            $lastRecord = ledger::orderBy('voucher_no', 'desc')
            ->where('transaction_type','Advance_Receipt')
            ->first();
            $voucher_no = $lastRecord->voucher_no;
            $new_voucher_no=$voucher_no+1;
            $voucher_type = voucher_type::where('voucher_type_name', 'Advance_Receipt')->first();
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
        
         }
         else {
            $voucher_type = voucher_type::where('voucher_type_name', 'Advance_Receipt')->first();
 
            $voucher_no=$voucher_type->numbring_start_from;
            $new_voucher_no=$voucher_no+1;
            $voucher_prefix=$voucher_type->voucher_prefix;
            $voucher_suffix=$voucher_type->voucher_suffix;
            $new_bill_no=$voucher_prefix."".$new_voucher_no."".$voucher_suffix;
  
        }

      
        $paymentmodes=account::where('account_group_id','4')
        ->orWhere('account_group_id','5')
        ->get();
        $account_names = roomcheckin::with('account')
        ->where('checkout_voucher_no', '0')
        ->get()
        ->groupBy('guest_name')
        ->map(function ($group) {
            return $group->first();
        });
    
        // $ledgers = Ledger::whereIn('id', function($query) {
        //     $query->select(DB::raw('MIN(id)'))
        //         ->from('ledgers')
        //         ->groupBy('voucher_no');
        // })
        // ->where('transaction_type','Advance_Receipt')
        // ->orderBy('voucher_no','desc')
        // ->get();
        $ledgers = Ledger::
        where('transaction_type', 'Advance_Receipt')
        ->orderBy('voucher_no', 'desc')
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
             $accountname = account::with('accountgroup')
             ->where('id', $request->account_id)->first();
             $paymentmode=account::with('accountgroup')
             ->where('id', $request->payment_mode_id)->first();

            if ($validator->passes()) {
                $ledger = new ledger;
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
                $ledger->save();


                $ledger = new ledger;
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
                $ledger->save();
        
                return redirect('/advace_receipt')->with('message', 'entery saved created successfully!');
            } else {
                return redirect('/advace_receipt')->withInput()->withErrors($validator)->with('error', 'Record Not Save ');
            }    
    }    
    public function advace_receipt_print($id)
    { 
        $advancereceipts = ledger::where('transaction_type','Advance_Receipt')
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
        $ledgers = Ledger::where('account_id', $account_id)
        ->whereBetween('entry_date', [$formatted_from_date, $formatted_to_date])
        ->get();
        $accounts = Account::orderBy('account_name', 'asc')->get();
        $account_name = Account::find($account_id);
        $opening_balance_account=$account_name->op_balnce;
        $opning_balance_type=$account_name->balnce_type;
        if($formatted_to_date>$formatted_from_date){
        $ledgers_before_fromdate = Ledger::where('account_id', $account_id)
        ->where('entry_date', '<=', $formatted_from_date)
        ->get();
        }
        else if($formatted_to_date=$formatted_from_date){
            $date_variable = $request->from_date;
            $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
            $one_day_before = $parsed_date->subDay(); // Subtract one day
            $formatted_from_date_onedaybefore = $one_day_before->format('Y-m-d');
                       

            $ledgers_before_fromdate = Ledger::where('account_id', $account_id)
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



 
        if(!$ledgers->isEmpty()  ){
        return view('reports.ledger.ledger_show',compact('accounts','ledgers','account_name','from_date','to_date','final_opning_balance'));
              }
        else{
            return view('reports.ledger.ledger',compact('accounts','ledgers','account_name','from_date','to_date','final_opning_balance'))->with('message','No Record Found ');
        }      
    }

    public function destroy($id)
    {
        
        $ledger = ledger::where('transaction_type','Receipts')
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
        
        $ledger = ledger::where('transaction_type','Payments')
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
    public function advace_receipt_delete($id)
    {
        
        $ledger = ledger::where('transaction_type','Advance_Receipt')
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
        $date_variable=$request->to_date;
        $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_to_date = $parsed_date->format('Y-m-d');
       

        $accounts = account::select('accounts.id', 'accounts.account_name', 'accounts.op_balnce','balnce_type','accounts.mobile',
        DB::raw('SUM(ledgers.debit) as total_debit'),
        DB::raw('SUM(ledgers.credit) as total_credit'))
        ->leftJoin('ledgers', 'accounts.id', '=', 'ledgers.account_id')
        ->groupBy('accounts.id', 'accounts.account_name', 'accounts.op_balnce','accounts.balnce_type','accounts.mobile')
        ->get();
        // dd($accounts);
    
    $outstandingReceivables = $accounts->filter(function ($account) {
    if($account->balnce_type === 'Dr'){
        $balance = $account->op_balnce + $account->total_debit - $account->total_credit;
        return $balance>0 ;
    }
    else{
        $balance =  $account->total_debit-$account->op_balnce  - $account->total_credit;
        return $balance>0 ;
        }
    });
  




    return view('reports.ledger.outstanding_receivable', compact('outstandingReceivables'));
  
    }
    public function outstanding_payable_result(Request $request)
    {
        $date_variable=$request->to_date;
        $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date_variable);
        $formatted_to_date = $parsed_date->format('Y-m-d');
       

        $accounts = account::select('accounts.id', 'accounts.account_name', 'accounts.op_balnce','balnce_type','accounts.mobile',
        DB::raw('SUM(ledgers.debit) as total_debit'),
        DB::raw('SUM(ledgers.credit) as total_credit'))
        ->leftJoin('ledgers', 'accounts.id', '=', 'ledgers.account_id')
        ->groupBy('accounts.id', 'accounts.account_name', 'accounts.op_balnce','accounts.balnce_type','accounts.mobile')
        ->get();
        // dd($accounts);
    
    $outstandingPayables = $accounts->filter(function ($account) {
    if($account->balnce_type === 'Dr'){
        $balance = $account->op_balnce + $account->total_debit - $account->total_credit;
        
    }
    else{
        $balance =  $account->total_debit-$account->op_balnce  - $account->total_credit;
        
        }
        return $balance<0 ;
    });
//   dd($outstandingPayables);




    return view('reports.ledger.outstanding_payable', compact('outstandingPayables'));
  
    }
    public function dayend_report(Request $request)
{
    
    $listofaccount = Account::where('account_group_id', '5')
        ->orWhere('account_group_id', '4')
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

        $ledgers = Ledger::where('account_id', $account_id)
            ->whereBetween('entry_date', [$formatted_current_date, $formatted_current_date])
            ->get();

        $ledgers_before_fromdate = Ledger::where('account_id', $account_id)
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

    $accounts = Account::orderBy('account_name', 'asc')->get();

    return view('reports.ledger.dayend_report', compact('accounts', 'all_reports','formatted_current_date'));
}


    
}
