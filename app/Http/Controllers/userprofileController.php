<?php

namespace App\Http\Controllers;

use app\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\Validator;

class userprofileController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');

    }


    public function show()
    {
         return view('master.account');
        // return" this is from account ";
        
    }
    public function show_userprofile()
    {
        if(Auth::user()->email != 'datahouset@gmail.com') {
        $record = User::where('email', '!=', 'datahouset@gmail.com')
        ->where('email','!=',Auth::user()->firm_id.'@gmail.com')
        ->where('firm_id',Auth::user()->firm_id)
        ->get();
    }else{
        $record = User::where('email', '!=', 'datahouset@gmail.com')
                ->get();
    }
        return view('userprofile', ['data' => $record]);
         
    }
    public function verifyid($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Set the email_verified_at field to the current date and time
        $user->email_verified_at = now(); // Using Laravel's helper function for current timestamp
    
        // Save the changes to the database
        $user->save();
        if(Auth::user()->email != 'datahouset@gmail.com') {
        $record = User::where('email', '!=', 'datahouset@gmail.com')
        ->where('email','!=',Auth::user()->firm_id.'@gmail.com')
        ->where('firm_id',Auth::user()->firm_id)
        ->get();
    }else{
        $record = User::where('email', '!=', 'datahouset@gmail.com')
                ->get();
    }
        return view('userprofile', ['data' => $record]);

    }
    

    public function delete_userprofile(User $user,$id )
    {
        $user = User::findOrFail($id);        
        $useremail=$user->email;

        if($useremail!=='datahouset@gmail.com'){
         $user->delete();
         return redirect('/users')->with('status','User Delete Successfully');
        }
        else{
         return redirect('/users')->with('status','Master Id You Can Not Delete  Contact Your Service Provider ');
 
        }
      
    }
    public function modify(Request $request)
    {

        //  echo"<pre>";
        // print_r($request->all()); 
        //this is code for test the recived input  

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:4','confirmed'],
                'password_confirmation' => ['required', 'string', 'min:4']
            ]
        );




        //  return print_r($request);

        // $data= $request->name;
        // return $data;

         $data=user::find($request->id);

        $data->name=$request->name;
        $data->email=$request->email;
        $data->password=$request->password;
        $data->save();
        return redirect ('userprofile');
      
    }

    
    public function show_user_form($id)
    {
        //this is function for show  record on item formfor update of item 
        $record= user::find($id);
        return view('auth.edituser.edituser',['data'=>$record]);
         
    }





}
