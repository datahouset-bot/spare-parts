<?php
namespace App\Http\Controllers;
use App\Models\optionlist;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OptionlistController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $optionlist=optionlist::where('firm_id',Auth::user()->firm_id)->get();
      $vouchertype=voucher_type::where('firm_id',Auth::user()->firm_id)
      ->orderBy('voucher_type_name','asc')
      ->get(); 


  
     return  view ('setting.optionlist',compact('optionlist','vouchertype'));
    }

    public function store(Request $request)
    {
        $validator= validator::make($request->all(),[
            'option_type' => 'required',
             'option_name' => 'required'
            ]);
            if ($validator->passes()) {
                $optionlist = new optionlist;
                $optionlist->firm_id=Auth::user()->firm_id;
                $optionlist->option_type = $request->option_type;
                $optionlist->option_name = $request->option_name;
                $optionlist->format_name = $request->format_name;
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
        $optionlist=optionlist::where('firm_id',Auth::user()->firm_id)->find($id);
        $vouchertype=voucher_type::where('firm_id',Auth::user()->firm_id)
        ->orderBy('voucher_type_name','asc')
        ->get(); 
        return  view ('setting.optionlist_edit',compact('optionlist','vouchertype'));
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
                $optionlist = optionlist::where('firm_id',Auth::user()->firm_id)
                ->find($id);
                $optionlist->option_type = $request->option_type;
                $optionlist->option_name = $request->option_name;
                $optionlist->format_name = $request->format_name;
                 $optionlist->update();



                 return redirect()->route('optionlists.index')->with('message', 'Option Created Successfully!');
                } else {
                    return redirect('/optionlists')->with('error', 'Option Not Created!')->withInput()->withErrors($validator);
                }
    
    }


    public function destroy(string $id)
    {
        $optionlist = optionlist::where('firm_id',Auth::user()->firm_id)->find($id);

        // Check if the optionlist exists
        if ($optionlist) {
            // Delete the optionlist
            $optionlist->delete();
            return redirect('/optionlists')->with('message', 'Format Delete successfully!');
        } else {
            // optionlist not found
            return redirect('/optionlists')->with('message', 'Format Not Found');

        }
    }
}
