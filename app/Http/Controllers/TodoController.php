<?php

namespace App\Http\Controllers;
use App\Models\todo;
use App\Imports\todoImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\FlareClient\Http\Response;
use Illuminate\Support\Facades\Validator;



class TodoController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);

    }
    
    public function index()
    {

        $record = Todo::query()->where('firm_id',Auth::user()->firm_id)
        ->where('reminder_af1', '=', '0')->get();
        // $record = Todo::query()->where('reminder_af1', '=', '1')->get();
          // $record=todo::all();
        return view('callmanagement.todolist',['data'=>$record]);

        
    }

    public function index_dt()
    {

        $record = Todo::query()->where('firm_id',Auth::user()->firm_id)
        ->where('reminder_af1', '=', '0')->get();
        // $record = Todo::query()->where('reminder_af1', '=', '1')->get();
          // $record=todo::all();
        return view('callmanagement.todolist_dt',['data'=>$record]);

        
    }


    public function index_done()
    {

        $record = Todo::query()->where('firm_id',Auth::user()->firm_id)
        ->where('reminder_af1', '=', '1')->get();
        // $record = Todo::query()->where('reminder_af1', '=', '1')->get();
          // $record=todo::all();
        return view('callmanagement.todolist',['data'=>$record]);

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function view()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
                // comapny data insert to table 
        //        echo"<pre>";
        // print_r($request->all());

  

  
         $validator= validator::make($request->all(),[
            'reminder_title' => 'required',
            'reminder_name' => 'required',
            'reminder_disc' => 'required',
            'reminder_date_given'=>'required',
             
             ]);
            if ($validator->passes()) {
                $received_date=$request->reminder_date_given;
                $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $received_date);
                 $formatted_date = $parsed_date->format('Y-m-d');


                 $todo = new todo;
                 $todo->firm_id=Auth::user()->firm_id;
                $todo->reminder_date = $formatted_date;
                $todo->reminder_title = $request->reminder_title;
                $todo->reminder_name = $request->reminder_name;
                $todo->reminder_mobile = $request->reminder_mobile;
                $todo->reminder_city = $request->reminder_city;
                $todo->reminder_disc = $request->reminder_disc;


                 $todo->save();
        
                 return redirect('/todolist')->with('message', 'The record has been saved successfully');
                } else {
                 return redirect('/todolist')->withInput()->withErrors($validator);
                }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $record= todo::find($id);

         return view('callmanagement.todolistmodify',['data'=>$record]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        echo"<pre>";
        print_r($request->all());
        $todo = todo::find($request->id);
        $todo->reminder_af1 = $request->reminder_af1;
        $todo->update();
        return redirect('todolist');

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //                echo"<pre>";
        // print_r($request->all());

  

  
         $validator= validator::make($request->all(),[
            'reminder_title' => 'required',
            'reminder_name' => 'required',
            'reminder_disc' => 'required',
             
             ]);
            if ($validator->passes()) {
                $received_date=$request->reminder_date_given;
                $parsed_date = \Carbon\Carbon::createFromFormat('d-m-Y', $received_date);
                 $formatted_date = $parsed_date->format('Y-m-d');
        
                $todo=todo::find($request->id);
   
                $todo->reminder_date = $formatted_date;
                $todo->reminder_title = $request->reminder_title;
                $todo->reminder_name = $request->reminder_name;
                $todo->reminder_mobile = $request->reminder_mobile;
                $todo->reminder_city = $request->reminder_city;
                $todo->reminder_disc = $request->reminder_disc;


                 $todo->update();
        
                 return redirect('/todolist')->with('message', 'The record has been updated successfully.');
                } else {
                 return redirect('/todolist')->withInput()->withErrors($validator)->with('message', 'Please try again with valid data');
                }
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(todo $todo,$id)
    {
        todo::destroy(['id',$id]);         
        return redirect('/todolist')->with('message', 'The record has been successfully deleted.');    }

    public function import_show()
    {
        return view('callmanagement.todolist_import');
    }

    public function import(Request $request)
    {
        $validator= validator ::make ($request->all(),[
            'file'=>'required'

        ]);

        if($validator->passes()){
    
            $file=$request->file;
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;
            $file->move(public_path().'/uploads',$filename);
            $path=public_path().'/uploads/'.$filename;


             Excel::import(new todoImport, $path);
        


           return redirect('/todo_import_show')->with('message', 'The record has been successfully inserted .'); 
        


        }
        else{
            return redirect()->back()->withErrors($validator);

        }
       

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



}
