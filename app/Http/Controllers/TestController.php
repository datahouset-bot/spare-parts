<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\Test;
use App\Models\account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 class TestController extends Controller
{

    public function searchbox(Request $request)
    {
        if ($request->ajax()) {
            // Retrieve the value sent from the client-side
            $account_name = $request->input('account_name');
    
            $results = \DB::table('accounts')
                ->where('account_name', 'LIKE', $account_name . '%')
                ->orderBy('account_name', 'asc')
                ->get();
            
            return response()->json(['res' => $results]);
        } else {
            // Handle non-AJAX requests
            return view("test.searchbox");
        }
    }
    



public function searchAccount(Request $request)
{
    // Get the search term from the request
    $searchTerm = $request->input('account_name');

    // Perform the search query using the account model
    // $results = account::where('account_name', 'like', "%$searchTerm%")->get();
    $results = \DB::table('accounts')
    ->where('account_name', 'LIKE', $searchTerm . '%')
    ->orderBy('account_name', 'asc')
    ->get();


    // Return the search results as JSON
    return response()->json(['results' => $results]);
}

    
    public function index(Request $request)
    {
    
        return view("test.test_view");
    }

    public function show()
    {
        $accounts = account::all();
        $items = item::all();

     return response()->json([
        'accountdata' => $accounts,
             'itemdata' => $items
     ]);



    }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    // return response()->json(['res'=>'gated ']);

        
        
        $validator= validator::make($request->all(),[
            'account_name' => 'required|unique:accounts',
            'account_group' => 'required',
            'balnce_type' => 'required'
            ]);
                if($validator->passes())
           {
        
                  $account=new account;
                  $account->account_name=$request->account_name;
                  $account->account_group=$request->account_group;
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
                 
                 $account->save();
                 
         


                 return response()->json(['res'=>'New Account Added Successfully']);
           }

           else{
            return redirect('/accountform')->withInput()->withErrors($validator);
        
              }


        
    }

    /**return response()->json(['res'=>'gated ']);
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
