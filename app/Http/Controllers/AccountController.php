<?php

namespace App\Http\Controllers;

use App\Models\ledger;
use App\Models\account;
use App\Models\accountgroup;
use Illuminate\Http\Request;
use App\Imports\accountImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreaccountRequest;
use App\Http\Requests\UpdateaccountRequest;

class AccountController  extends CustomBaseController
{
    
    public function __construct()
    {
        $this->middleware(['auth','verified']);

    }
    /**
     * All account Resource Desplay Through Account Controller 
     */
    public function index()
    {
        // return ("helow account page ");
        $record=account::with('accountgroup')->get();
        return view('master.account',['data'=>$record]);
    }
    public function index_dt()
    {
        // return ("helow account page ");
        $record=account::all();
        return view('master.account_dt',['data'=>$record]);
    }
    public function account_import()
    {
        // return ("helow account page ");
        $record=account::all();
        return view('master.account_import');
    }
    public function import(Request $request)
    {


        ini_set('max_execution_time',3600);
        $validator= validator ::make ($request->all(),[
            'file'=>'required'

        ]);

        if($validator->passes()){
    
            $file=$request->file;
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;
            $file->move(public_path().'/uploads',$filename);
            $path=public_path().'/uploads/'.$filename;


             Excel::import(new accountImport, $path);
        


           return redirect('/account_import')->with('message', 'The record has been successfully inserted .'); 
        


        }
        else{
            return redirect()->back()->withErrors($validator);

        }




        
   

    }




    public function create()
    {
        //show the list of account landing page 
       $accountgroups=accountgroup::all(); 
        return view('master.accountform',compact('accountgroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        
    //  dd($request);
        
        
        $validator= validator::make($request->all(),[
            'account_name' => 'required|unique:accounts',
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


        if($validator->passes())
           {
                  $account=new account;
                  $account->account_name=$request->account_name;
                  $account->account_group_id=$request->account_group_id;
                  $account->op_balnce=$request->op_balnce;
                  $account->balnce_type=$request->balnce_type;
                  $account->city=$request->city;
                  $account->state=$request->state;
                  $account->phone=$request->phone;
                  $account->mobile=$request->mobile;
                 $account->person_name=$request->person_name;
                  $account->gst_no=$request->gst_no;
                  $account->address=$request->address;
                  $account->email=$request->email;
                  $account->account_af1=$request->account_af1;  //guest firm name 
                  $account->account_af2=$request->account_af2; // guest firm address
                  $account->account_af3=$request->account_af3; //for root account 
                  $account->nationality=$request->nationality;
                  $account->address2=$request->address2;
                  $account->pen_card=$request->pen_card;
                  $account->account_idproof_name=$request->account_idproof_name;
                  $account->account_idproof_no=$request->account_idproof_no;
                  $account->account_id_pic=$account_id_pic;
                  $account->account_pic1=$account_pic1;
                  $account->account_birthday=$request->account_birthday;   
                  $account->account_anniversary=$request->account_anniversary;   
                  $account->gst_code=$request->gst_code;   
                  $account->account_code=$request->account_code;   
                  $account->account_cr_days=$request->account_cr_days;   
                  $account->account_salsman=$request->account_salsman;     
                  $account->account_route=$request->account_route;     
                  $account->account_attachment1=$request->account_attachment1;              
                 $account->save();
                return redirect('account');
           }

           else{
            return redirect('/accountform')->withInput()->withErrors($validator);
        
              }

    }

    


    

    
    public function destroy(account $account,$id)
    {
        // Get the ledger records for the account
    $ledgerrecord = Ledger::where('account_id', $id)->get();
    
    // Check if the account is not marked as 'yes' in 'account_af1' and matches the ID
    $accountToDelete = Account::where('account_af3', '!=', 'yes')
        ->where('id', $id)
        ->first(); // Use first() instead of get() for a single record
    
    if ($ledgerrecord->isEmpty() && $accountToDelete) {
        // Delete the account
        $accountToDelete->delete();
        
        return redirect('account')->with('message', 'Account is deleted successfully.');
    } else {
        return redirect('account')->with('error', 'Account is used in a transaction Or Account Type IS root account, so it cannot be deleted.');
    }   

    }
    public function edit($id)
    {      
        $record= account::find($id);
       
        $accountgroups=accountgroup::all();

        return view('master.accountformedit',['data'=>$record,'accountgroups'=>$accountgroups]);
    }
    public function update(Request $request)
    {
        // this is use for save the record of edited item 
         $validator= validator::make($request->all(),[
            'account_name' => 'required',
            'balnce_type' => 'required',
            'account_group_id'=>'required',
         ]);
    //    echo "account updation form request ";
    //     echo"<pre>";
    //     print_r($request->all());
         if($validator->passes())
            {
              $account=account::find($request->id);
              $account->account_name=$request->account_name;
              $account->account_group_id=$request->account_group_id;
              $account->op_balnce=$request->op_balnce;
              $account->balnce_type=$request->balnce_type;
              $account->city=$request->city;
              $account->state=$request->state;
              $account->phone=$request->phone;
              $account->mobile=$request->mobile;
              $account->person_name=$request->person_name;
              $account->gst_no=$request->gst_no;
              $account->address=$request->address;
              $account->email=$request->email;
              $account->account_af1=$request->account_af1;  //guest firm name 
              $account->account_af2=$request->account_af2; // guest firm address
              $account->account_af3=$request->account_af3; //for root account 
              $account->nationality=$request->nationality;
              $account->address2=$request->address2;
              $account->pen_card=$request->pen_card;
              $account->account_idproof_name=$request->account_idproof_name;
              $account->account_idproof_no=$request->account_idproof_no;
              $account->account_id_pic=$request->account_id_pic;
              $account->account_pic1=$request->account_pic1;
              $account->account_birthday=$request->account_birthday;   
              $account->account_anniversary=$request->account_anniversary;   
              $account->gst_code=$request->gst_code;   
              $account->account_code=$request->account_code;   
              $account->account_cr_days=$request->account_cr_days;   
              $account->account_salsman=$request->account_salsman;     
              $account->account_route=$request->account_route;     
              $account->account_attachment1=$request->account_attachment1;              
              $account->update();
               return redirect('account');
           }

          else{
            return redirect()->back()->withInput()->withErrors($validator);

              } 
    }               

    public function accountformview($id)
    {      
        $record= account::find($id);

        return view('master.accountformview',['data'=>$record]);
      
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
        // Search for the customer by contact number
        $customer = account::where('phone', $contactNumber)
                            ->orWhere('mobile', $contactNumber)
                            ->first();

        if ($customer) {
            return response()->json([
                'message' => '<p class="alart alart-success">Record Found Sucessfully <p>',
                'customer_info' => $customer->toArray()
            ]);
        } 
        else {
            return response()->json([
                'message' => ' <p class="alart alart-danger">No Record Found<p>',
                'customer_info' => null
            ]);
        }
    }

}
