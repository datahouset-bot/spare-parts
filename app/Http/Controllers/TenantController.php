<?php

namespace App\Http\Controllers;
use App\Models\Tenant;
use App\Models\domain;
use App\Jobs\SeedTenantJob;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);

    }


 
    public function index()
    {  //tenent registration page 
        return view ('tenant.home');
    }

    public function list()
    { 
        $tenant=Tenant::with('domains')->get();
        // dd($tenant->toArray());


          return view ('tenant.tenantlist',['tenant'=>$tenant]);
    }

    public function create()
    {
    }
    
     public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:4|confirmed',
            'password_confirmation' => 'required|string|min:4',
            'domain_name' => 'required|string|max:255|unique:domains,domain',  
        ]);
    
        $tenant = Tenant::create([
            
            'name' => $validatedData['name'], // Include the 'name' field
            'email' => $validatedData['email'],
            // 'password' => bcrypt($validatedData['password']), // Make sure to hash the password
         'password' => Hash::make($validatedData['password']),
        ]);
    
        $tenant->domains()->create([
            'domain' => $validatedData['domain_name'] . '.' . config('app.domain')
        ]);
         return redirect('register');
        

    }

    public function show_superadmin()
    {
        return View ('Super_admin');

    }
    public function destroy(Tenant $tenant ,$id)
    {
        //
        Tenant::destroy(['id',$id]);         
        return view('tenant.tenantlist')->with('message', 'Tenant Succesfully  Deleted  ');


    }


}
