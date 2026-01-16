<?php

namespace App\Http\Controllers;

use App\Models\ledger;
use App\Models\account;
use App\Models\roomcheckin;
use App\Models\accountgroup;
use Illuminate\Http\Request;
use App\Imports\accountImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreaccountRequest;
use App\Http\Requests\UpdateaccountRequest;

class AccountController extends CustomBaseController
{

    /**
     * All account Resource Desplay Through Account Controller 
     */
    public function index()
    {
        // return ("helow account page ");
        $record = account::where('firm_id', Auth::user()->firm_id)
            ->with('accountgroup')->get();
        return view('master.account', ['data' => $record]);
    }
    public function index_dt()
    {
        // return ("helow account page ");
        $record = account::where('firm_id', Auth::user()->firm_id)->get();
        return view('master.account_dt', ['data' => $record]);
    }
    public function account_import()
    {
        // return ("helow account page ");
        $record = account::where('firm_id', Auth::user()->firm_id)->all();
        return view('master.account_import');
    }
    public function import(Request $request)
    {


        ini_set('max_execution_time', 3600);
        $validator = validator::make($request->all(), [
            'file' => 'required'

        ]);

        if ($validator->passes()) {

            $file = $request->file;
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move(public_path() . '/uploads', $filename);
            $path = public_path() . '/uploads/' . $filename;


            Excel::import(new accountImport, $path);



            return redirect('/account_import')->with('message', 'The record has been successfully inserted .');



        } else {
            return redirect()->back()->withErrors($validator);

        }







    }




    public function create()
    {
        //show the list of account landing page 
        $accountgroups = accountgroup::where('firm_id', Auth::user()->firm_id)->get();
        return view('master.accountform', compact('accountgroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {

        //  dd($request);


        $validator = validator::make($request->all(), [

            'account_name' => [
                'required',
                'unique:accounts,account_name,NULL,id,firm_id,' . auth()->user()->firm_id,
            ],
            'account_group_id' => 'required',
            'balnce_type' => 'required'
        ]);

        $uploadPath = 'uploads/account_image';
        if ($request->hasFile('account_id_pic')) {
            $image1 = $request->account_id_pic;
            $account_id_pic = $image1->getClientOriginalName();
            $image1->storeAS('public\account_image', $account_id_pic);


        } else {
            $account_id_pic = NULL;
        }
        if ($request->hasFile('account_pic1')) {

            $image2 = $request->account_pic1;
            $account_pic1 = $image2->getClientOriginalName();
            $image2->storeAS('public\account_image', $account_pic1);


        } else {
            $account_pic1 = NULL;
        }

       if (!empty($request->gst_no)) {
                // Extract first 2 characters from GST number
                $gst_code = substr($request->gst_no, 0, 2);
            
            }


         else{
            $gst_code = NULL;
         }
        if ($validator->passes()) {
            $account = new account;
            $account->firm_id = Auth::user()->firm_id;
            $account->account_name = $request->account_name;
            $account->account_group_id = $request->account_group_id;
            $account->op_balnce = $request->op_balnce;
            $account->balnce_type = $request->balnce_type;
            $account->city = $request->city;
            $account->state = $request->state;
            $account->phone = $request->phone;
            $account->mobile = $request->mobile;
            $account->person_name = $request->person_name;
            $account->gst_no = $request->gst_no;
            $account->address = $request->address;
            $account->email = $request->email;
            $account->account_af1 = $request->account_af1;  //guest firm name 
            $account->account_af2 = $request->account_af2; // guest firm address
            $account->account_af3 = $request->account_af3; //for root account 
            $account->nationality = $request->nationality;
            $account->address2 = $request->address2;
            $account->pen_card = $request->pen_card;
            $account->account_idproof_name = $request->account_idproof_name;
            $account->account_idproof_no = $request->account_idproof_no;
            $account->account_id_pic = $account_id_pic;
            $account->account_pic1 = $account_pic1;
            $account->account_birthday = $request->account_birthday;
            $account->account_anniversary = $request->account_anniversary;
            $account->gst_code =  $gst_code;
            $account->account_code = $request->account_code;
            $account->account_cr_days = $request->account_cr_days;
            $account->account_salsman = $request->account_salsman;
            $account->account_route = $request->account_route;
            $account->account_attachment1 = $request->account_attachment1;
            $account->save();
            return redirect()->back()->with('success', 'Account is created successfully.');
        } else {
            return redirect('/accountform')->withInput()->withErrors($validator);

        }

    }

    public function destroy(Account $account, $id)
    {
        // Check if the account is used in a ledger
        $ledgerRecord = ledger::where('firm_id', Auth::user()->firm_id)
            ->where('account_id', $id)
            ->exists(); // Check only existence for better performance

        // Fetch the account to delete if it exists, belongs to the same firm, and is not marked as 'root'
        $accountToDelete = account::where('id', $id)
            ->where('firm_id', Auth::user()->firm_id)
            ->where(function ($query) {
                $query->where('account_af3', '=', '0')
                    ->orWhereNull('account_af3'); // Allow NULL or '0' values for account_af3
            })
            ->first();

        // If there are no ledger records and the account is deletable
        if (!$ledgerRecord && $accountToDelete) {
            // Delete the account
            $accountToDelete->delete();

            return redirect('account')->with('message', 'Account is deleted successfully.');
        }

        // Check if the account is a root account
        if ($accountToDelete && $accountToDelete->account_af3 !== NULL && $accountToDelete->account_af3 !== '0') {
            return redirect('account')->with('error', 'Account is a root account and cannot be deleted.');
        }

        return redirect('account')->with('error', 'Account is used in a transaction or cannot be deleted.');
    }


    public function edit($id)
    {
        $record = account::where('firm_id', Auth::user()->firm_id)->find($id);

        $accountgroups = accountgroup::all();

        return view('master.accountformedit', ['data' => $record, 'accountgroups' => $accountgroups]);
    }
    public function update(Request $request)
    {

        
            if (!empty($request->gst_no)) {
                // Extract first 2 characters from GST number
                $gst_code = substr($request->gst_no, 0, 2);
            
            }

        // this is use for save the record of edited item 
        $validator = validator::make($request->all(), [
            'account_name' => 'required',
            'balnce_type' => 'required',
            'account_group_id' => 'required',
        ]);
        $uploadPath = 'uploads/account_image';
        if ($request->hasFile('account_id_pic')) {
            $image1 = $request->account_id_pic;
            $account_id_pic = $image1->getClientOriginalName();
            $image1->storeAS('public\account_image', $account_id_pic);


        } else {
            $account_id_pic = NULL;
        }
        if ($request->hasFile('account_pic1')) {

            $image2 = $request->account_pic1;
            $account_pic1 = $image2->getClientOriginalName();
            $image2->storeAS('public\account_image', $account_pic1);


        } else {
            $account_pic1 = NULL;
        }
        //    echo "account updation form request ";
        //     echo"<pre>";
        //     print_r($request->all());
        if ($validator->passes()) {
            $account = account::where('firm_id', Auth::user()->firm_id)->find($request->id);
            $account->account_name = $request->account_name;
            $account->account_group_id = $request->account_group_id;
            $account->op_balnce = $request->op_balnce;
            $account->balnce_type = $request->balnce_type;
            $account->city = $request->city;
            $account->state = $request->state;
            $account->phone = $request->phone;
            $account->mobile = $request->mobile;
            $account->person_name = $request->person_name;
            $account->gst_no   = $request->gst_no;
            $account->gst_code = !empty($request->gst_no) ? substr($request->gst_no, 0, 2) : null;
            $account->address = $request->address;
            $account->email = $request->email;
            $account->account_af1 = $request->account_af1;  //guest firm name 
            $account->account_af2 = $request->account_af2; // guest firm address
            $account->account_af3 = $request->account_af3; //for root account 
            $account->nationality = $request->nationality;
            $account->address2 = $request->address2;
            $account->pen_card = $request->pen_card;
            $account->account_idproof_name = $request->account_idproof_name;
            $account->account_idproof_no = $request->account_idproof_no;
            $account->account_id_pic = $account_id_pic;
            $account->account_pic1 = $account_pic1;
            $account->account_birthday = $request->account_birthday;
            $account->account_anniversary = $request->account_anniversary;
            $account->account_code = $request->account_code;
            $account->account_cr_days = $request->account_cr_days;
            $account->account_salsman = $request->account_salsman;
            $account->account_route = $request->account_route;
            $account->account_attachment1 = $request->account_attachment1;
            $account->update();
            return redirect('account');
        } else {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function accountformview($id)
    {
        $record = account::where('firm_id', Auth::user()->firm_id)->find($id);
        $accountgroups = accountgroup::all();

        return view('master.accountformview', ['data' => $record, 'accountgroups' => $accountgroups]);

    }


    public function downloadExcel()
    {
        $filePath = public_path('uploads/sample/Account_import.xlsx');

        if (file_exists($filePath)) {
            return Response::download($filePath, 'Account_import.xlsx');
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }


    public function searchCustomer($contactNumber)
    {
        $firm_id=Auth::user()->firm_id;
        // Search for the customer by contact number
        $customer = account::where('firm_id', Auth::user()->firm_id)
            // ->where('phone', $contactNumber)
            ->Where('mobile', $contactNumber)
            ->first();

        if ($customer) {
            return response()->json([
                'message' => '<p class="alart alart-success">Record Found Sucessfully <p>.'.$firm_id,
                'customer_info' => $customer->toArray()
            ]);
        } else {
            return response()->json([
                'message' => ' <p class="alart alart-danger">No Record Found<p>',
                'customer_info' => null
            ]);
        }
    }


        public function searchcustomer_check_in_pending($contactNumber)
    {
        $firm_id=Auth::user()->firm_id;
        // Search for the customer by contact number
        $customer = roomcheckin::where('firm_id', Auth::user()->firm_id)
            // ->where('phone', $contactNumber)
            ->Where('guest_mobile', $contactNumber)
            ->where('checkout_voucher_no','0')
            ->first();

        if ($customer) {
            return response()->json([
                'message' => '<p class="alart alart-success">Record Found Sucessfully <p>.'.$firm_id,
                'customer_info' => $customer->toArray(),
                'status'=>200,
            ]);
        } else {
            return response()->json([
                'message' => ' <p class="alart alart-danger">No Record Found<p>',
                'customer_info' => null,
                'status'=>400,
            ]);
        }
    }

    public function searchCustomer_by_id($id)
    {
        // Search for the customer by contact number

        $customer = account::where('id', $id)->where('firm_id', Auth::user()->firm_id)
            ->first();

        if ($customer) {
            return response()->json([
                'message' => '<p class="alart alart-success">Record Found Sucessfully <p>',
                'customer_info' => $customer->toArray()
            ]);
        } else {
            return response()->json([
                'message' => ' <p class="alart alart-danger">No Record Found<p>',
                'customer_info' => null
            ]);
        }
    }

   public function createAccountAjax(Request $request)
{
    // ✅ AJAX-safe validation
    $validator = Validator::make($request->all(), [
        'account_name'     => 'required|string|max:255',
        'account_group_id' => 'required|integer',
        'op_balnce'        => 'nullable|numeric',
        'balnce_type'      => 'required|in:Dr,Cr',
        'mobile'           => 'nullable|string',
        'gst_no'           => 'nullable|string',
        'address'          => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $account = Account::create([
        'firm_id'          => Auth::user()->firm_id,
        'account_name'     => $request->account_name,
        'account_group_id' => $request->account_group_id,
        'op_balnce'        => $request->op_balnce ?? 0,
        'balnce_type'      => $request->balnce_type,
        'mobile'           => $request->mobile,
        'gst_no'           => $request->gst_no,
        'address'          => $request->address,
    ]);

    // ✅ JSON RESPONSE (THIS FIXES EVERYTHING)
    return response()->json([
        'id'           => $account->id,
        'account_name' => $account->account_name,
        'message'      => 'Account created successfully'
    ]);
}

}
