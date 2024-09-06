<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\optionlist;


class OptionlistController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { $optionlist=optionlist::all();
  
     return  view ('setting.optionlist',compact('optionlist'));
    }

    public function store(Request $request)
    {
        $validator= validator::make($request->all(),[
            'option_type' => 'required',
             'option_name' => 'required|unique:optionlists'
            ]);
            if ($validator->passes()) {
                $optionlist = new optionlist;
                $optionlist->option_type = $request->option_type;
                $optionlist->option_name = $request->option_name;
                $optionlist->save();
        
                return redirect()->route('optionlists.index')->with('message', 'Option Created Successfully!');
            } else {
                return redirect('/optionlists')->with('error', 'Option Not Created!')->withInput()->withErrors($validator);
            }
 


    }

    /**
     * Display the specified resource.
     */
    public function report_dashboard()
    {
        return view('report_dashboard');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $optionlist=optionlist::find($id);
        return  view ('setting.optionlist_edit',compact('optionlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator= validator::make($request->all(),[
            'option_type' => 'required',
             'option_name' => 'required'
            ]);
            if ($validator->passes()) {
                $optionlist = optionlist::find($id);
                $optionlist->option_type = $request->option_type;
                $optionlist->option_name = $request->option_name;
                 $optionlist->update();

                 return redirect()->route('optionlists.index')->with('message', 'Option Created Successfully!');
                } else {
                    return redirect('/optionlists')->with('error', 'Option Not Created!')->withInput()->withErrors($validator);
                }
    
    }


    public function destroy(optionlist $optionlist)
    {
        //
    }
}
