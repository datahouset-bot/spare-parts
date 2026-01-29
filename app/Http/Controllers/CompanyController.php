<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends CustomBaseController
{ 
    //    public function __construct()
    // {
    //     $this->middleware('permission:view role', ['only' => ['index']]);
    //     $this->middleware('permission:create role', ['only' => ['create','store','addPermissionToRole','givePermissionToRole']]);
    //     $this-> middleware('permission:update role', ['only' => ['update','edit']]);
    //     $this-> middleware('permission:delete role', ['only' => ['destroy']]);
    //     $this->middleware(['auth', 'verified']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record = company::where('firm_id', Auth::user()->firm_id)->get();
        return view('master.companylist', ['data' => $record]);
        //
    }



    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {


        $validator = validator::make($request->all(), [
            'comp_name' => [
                'required',
                'unique:companies,comp_name,NULL,id,firm_id,' . auth()->user()->firm_id,
            ],
            // Assuming you meant "float", you can use numeric instead.
        ]);
        if ($validator->passes()) {
            $company = new Company;
            $company->firm_id = Auth::user()->firm_id;
            $company->comp_name = $request->comp_name;
            $company->comp_dis = $request->comp_dis;
            $company->save();

            return redirect()->back()->with('message', 'Company created successfully!');
        } else {
            return redirect('company')->withInput()->withErrors($validator);
        }
    }

    // public function destroy(company $compnies,$id)

    // {
    //     company::destroy(['id',$id]);         
    //     return redirect('company');

    // }
    public function destroy(Company $companies, $id)
    {
        try {
            // Attempt to delete the record
            $deleted = Company::where('firm_id', Auth::user()->firm_id)
                ->where('id', $id)
                ->delete();
            // Check if the deletion was successful
            if ($deleted) {
                return redirect('company')->with('message', 'Record deleted successfully.');
            } else {
                return redirect('company')->with('error', 'Could not delete the record.');
            }
        } catch (\Exception $e) {
            // Catch any exception that occurs and handle it
            return redirect('company')->with('error', 'We cannot delete this record because it is used on an item.');
        }
    }



    public function show_company_form_edit($id)
    {
        $record = company::where('firm_id', Auth::user()->firm_id)->find($id);

        return view('master.companyedit', ['data' => $record]);
    }

    public function edit_company(Request $request)
    {




        $validator = validator::make($request->all(), [
            'comp_name' => 'required',
            // Assuming you meant "float", you can use numeric instead.
        ]);
        if ($validator->passes()) {
            $company = Company::where('firm_id', Auth::user()->firm_id)->find($request->id);
            $company->comp_name = $request->comp_name;
            $company->comp_dis = $request->comp_dis;
            $company->update();
            return redirect('company');
        } else {
            return redirect('showeditecompany')->withInput()->withErrors($validator);
        }
    }
    public function storeAjax(Request $request)
    {
        $request->validate([
            'comp_name' => 'required|string|max:255',
            'Dis'       => 'nullable|numeric',
        ]);
        try {
            $company = Company::create([
                'firm_id'   => Auth::user()->firm_id,
                'comp_name' => $request->comp_name,
                'comp_dis'       => $request->Dis ?? 0,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], 500);
        }


        return response()->json([
            'id'        => $company->id,
            'comp_name' => $company->comp_name,
        ]);
    }
}
