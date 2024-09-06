<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Validator;
use app\Models\User;

class accountController extends Controller
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
         $record=User::all();
         return view('userprofile',['data'=>$record]);
        //  for User Tabale Record Display 
        
    }

    public function delete_userprofile(User $user,$id )
    {
        user::destroy(['id',$id]);         
        return redirect('userprofile');
        //for user table Record Delelet
      
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
