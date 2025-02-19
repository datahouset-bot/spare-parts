<?php

namespace App\Http\Controllers;
use App\Models\amc;
use App\Models\pic;
use App\Models\item;
use App\Models\account;
use App\Mail\AmcListMail;
use App\Exports\AMCExport;
use App\Models\optionlist;
use App\Models\componyinfo;
use Illuminate\Http\Request;
use App\Models\compinfofooter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class AmcController extends CustomBaseController
{
  public function __construct()
  {
      $this->middleware('permission:view role', ['only' => ['index']]);
      $this->middleware('permission:create role', ['only' => ['create','store','addPermissionToRole','givePermissionToRole']]);
      $this-> middleware('permission:update role', ['only' => ['update','edit']]);
      $this-> middleware('permission:delete role', ['only' => ['destroy']]);


      $this->middleware(['auth', 'verified']);
  }
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
         $accounts = account::where('firm_id',Auth::user()->firm_id)->get();
          $items = item::where('firm_id',Auth::user()->firm_id)->get();
        //   return $items;

         return view("entery.amcform", [
             'accountdata' => $accounts,
              'itemdata' => $items
         ]);
    }

    public function destroy(amc $amc,$id)

    {
        amc::destroy(['id',$id]);         
        return redirect('amclist')->with('message', 'Your Amc Deleted  successfully Amc No  = '.$id);

        //
    }   


    public function show_edit_amc(amc $amc,$id)
    {      
      $accounts = account::where('firm_id',Auth::user()->firm_id)->get();
      $items = item::where('firm_id',Auth::user()->firm_id)->get();

      $amc= amc::find($id);

        return view('entery.amcformedit',[
          'accountdata' => $accounts,
          'itemdata' => $items,
          'amc' => $amc,

        ]);

    }

    public function amclist()
    {
      $amcs = Amc::where('firm_id',Auth::user()->firm_id)->with('account', 'item')->orderBy('id', 'desc')->paginate(100);

 
      // $amcs = Amc::with('account', 'item')->paginate(100);
      $columns = \Schema::getColumnListing((new Amc)->getTable());
      // $ columns variable for serch box listing page 

      // Pass the data to the view
      return view('entery.amclist', [
          'amcs' => $amcs,
          'columns' => $columns,
      ]);
  
    }
    public function amc_format($id)
    {
        $formatlist = optionlist::where('firm_id', Auth::user()->firm_id)
            ->where('option_type', 'Amc')
            ->orderBy('updated_at', 'desc')
            ->get();
    
        return view('entery.print_selection', compact('formatlist', 'id'));
    }
    

        public function amclisttest()
    {
      
      $accounts = account::where('firm_id',Auth::user()->firm_id)->get();
          $items = item::where('firm_id',Auth::user()->firm_id)->get();
        //   return $items;

         return view("entery.amcform2", [
             'accountdata' => $accounts,
              'itemdata' => $items
         ]);
      
  
    }

  





    //amc entery  function 
    public function store(Request $request)
    {
                  echo"<pre>";
          print_r($request->all());
       $validator= validator::make($request->all(),[
          'amc_start_date' => 'required',
          'amc_end_date' => 'required',
          'amc_amount' => 'required|numeric',
          'cust_name_id' => 'required|numeric',
          'amc_product_id' => 'required|numeric',
          'payment_status'=>'required',
          'amc_status'=>'required',
          'priority'=>'required'

          ]);

          $received_date1=$request->amc_start_date;
          $parsed_date1 = \Carbon\Carbon::createFromFormat('d-m-Y', $received_date1);
           $formatted_date1 = $parsed_date1->format('Y-m-d');

           $received_date2=$request->amc_end_date;
           $parsed_date2 = \Carbon\Carbon::createFromFormat('d-m-Y', $received_date2);
            $formatted_date2 = $parsed_date2->format('Y-m-d');
 


      if($validator->passes())
        {



             $amc=new amc;
          $amc->firm_id=Auth::user()->firm_id;   
          $amc->amc_start_date=$formatted_date1;
          $amc->amc_end_date=$formatted_date2;
          $amc->amc_amount=$request->amc_amount;
          $amc->remark1=$request->remark1;
          $amc->remark2=$request->remark2;
          $amc->executive=$request->executive;
          $amc->cust_name_id=$request->cust_name_id;
          $amc->amc_product_id=$request->amc_product_id;
          $amc->payment_status=$request->payment_status;
          $amc->amc_status=$request->amc_status;
          $amc->priority=$request->priority;

          $amc->save();
          return redirect('amclist');
        }    
        else{
          return redirect('/amcform')->withInput()->withErrors($validator);
      
            }

    }

    public function update_amc(Request $request)
    {
          //         echo"<pre>";
          // print_r($request->all());
     $validator= validator::make($request->all(),[
          'amc_start_date' => 'required',
          'amc_end_date' => 'required',
          'amc_amount' => 'required|numeric',
          'cust_name_id' => 'required|numeric',
          'amc_product_id' => 'required|numeric',
          'payment_status'=>'required',
          'amc_status'=>'required',
          'priority'=>'required'

          ]);
      if($validator->passes())
        {
          $amc=amc::find($request->id);
          $amc->firm_id=Auth::user()->firm_id;
 
          $amc->amc_start_date=$request->amc_start_date;
          $amc->amc_end_date=$request->amc_end_date;
          $amc->amc_amount=$request->amc_amount;
          $amc->remark1=$request->remark1;
          $amc->remark2=$request->remark2;
          $amc->executive=$request->executive;
          $amc->executive=$request->executive;
          $amc->cust_name_id=$request->cust_name_id;
          $amc->amc_product_id=$request->amc_product_id;
          $amc->payment_status=$request->payment_status;
          $amc->amc_status=$request->amc_status;
          $amc->priority=$request->priority;
          $amc->update();



          return redirect('amclist');
        }    
        else{
          return redirect('/amcform')->withInput()->withErrors($validator);
      
            }

    }


    
    public function export()
    {
      // exporting the amc list 
      return Excel::download(new AMCExport, 'amc_export.xlsx');
    }


    public function pdf()
    {
      // this is for genrate pdf of amc lists 
      $amcs = Amc::where('firm_id',Auth::user()->firm_id)->with('account', 'item')->get();

    $data=[
      'amcs' => $amcs,
    ];
    $pdf=PDF::loadView('entery.amclistpdf', $data);

      return $pdf->download('amclists.pdf');

    }


    public function sendAmcListEmail()
    {
      $amcs = Amc::where('firm_id',Auth::user()->firm_id)->with('account', 'item')->get();

      // Pass data to the view
      $data = [
          'amcs' => $amcs,
      ];

      $pdf = PDF::loadView('entery.amclistpdf', $data);


      Mail::send([], [], function ($message) use ($pdf) {
        $message->to('datahouset@gmail.com')
                ->subject('AMC List Mail')
                ->attachData($pdf->output(), 'amclists.pdf', [
                    'mime' => 'application/pdf',
                ]);
            });

    return "Email sent with AMC list PDF attached!";

    }

    public function printamclist()
    {
      $amcs = Amc::where('firm_id',Auth::user()->firm_id)->with('account', 'item')->get();

      // Pass data to the view
      $data = [
          'amcs' => $amcs,
      ];
  
      // Generate PDF from the view
      $pdf = PDF::loadView('entery.amclistpdf', $data);
  
      // Return the PDF for streaming (instead of download)
      return $pdf->stream('amclists.pdf');
    }




      public function amclistsearch(Request $request)
      {
          // Get search parameters from the request
          $columnName = $request->input('column_name');
          $searchBox = $request->input('search_box');
          $fromDate = $request->input('from_date');
          $toDate = $request->input('to_date');
      
          // Query the AMCs
          $amcs = Amc::where('firm_id',Auth::user()->firm_id)->get();
          $columns = \Schema::getColumnListing((new Amc)->getTable());

      
          // Apply search filters
          if ($columnName && $searchBox) {
              $amcs->where($columnName, 'LIKE', "%$searchBox%");
          }
      
          // Apply date range filter
          if ($fromDate && $toDate) {
              $amcs->whereBetween('amc_end_date', [$fromDate, $toDate]);
          }
      
          // Execute the query
          $amcs = $amcs->where('firm_id',Auth::user()->firm_id)->paginate(10); // Paginate the results
      
          // Pass the results to the view
          return view('entery.amclist', [
            'amcs' => $amcs,
            'columns' => $columns,
        
        ]);
      }
      


      public function amclist_due(Request $request)
      {
        $columnName = $request->input('column_name');
        $searchBox = $request->input('search_box');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

    
        // Query the AMCs
        // $amcs = Amc::query();
        $amcs = Amc::query()->where('payment_status', '=', 'Unpaid');

        $columns = \Schema::getColumnListing((new Amc)->getTable());
  
    
        if ($columnName && $searchBox) {
          $amcs->where($columnName, 'LIKE', "%$searchBox%");
      }
  
        // Apply search filters
            // $amcs->where('payment_status', '=', "Unpaid");
        
        // Apply date range filter
        if ($fromDate && $toDate) {
            $amcs->whereBetween('amc_end_date', [$fromDate, $toDate]);
        }
    
        // Execute the query
        $amcs = $amcs->paginate(100); // Paginate the results
    
        // Pass the results to the view
        return view('reports.amclist_due', [
          'amcs' => $amcs,
          'columns' => $columns,
      
      ]);   
    }


    public function amclist_due_month(Request $request)
    {
        $month = $request->input('month');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
    
        // Start building the query
        $amcsQuery = Amc::where('firm_id', Auth::user()->firm_id)
            ->where('payment_status', '=', 'Unpaid');
    
        // Apply date range filter if both `from_date` and `to_date` are provided
        if ($fromDate && $toDate) {
            $amcsQuery->whereBetween('amc_end_date', [$fromDate, $toDate]);
        }
    
        // Apply month filter if `month` is provided
        if ($month !== '') {
            $amcsQuery->whereMonth('amc_end_date', '=', $month);
        }
    
        // Paginate the results
        $amcs = $amcsQuery->paginate(100);
    
        // Return the view with data
        return view('reports.amclist_due_month', [
            'amcs' => $amcs,
        ]);
    }
    
      public function amclist_end_month(Request $request)
{
    $month = $request->input('month');
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');

    // Start building the query
    $amcsQuery = Amc::where('firm_id', Auth::user()->firm_id);

    // Apply date range filter if both `from_date` and `to_date` are provided
    if ($fromDate && $toDate) {
        $amcsQuery->whereBetween('amc_end_date', [$fromDate, $toDate]);
    }

    // Apply month filter if `month` is provided
    if ($month !== '') {
        $amcsQuery->whereMonth('amc_end_date', '=', $month);
    }

    // Retrieve the results
    $amcs = $amcsQuery->get();

    // Return the view with data
    return view('reports.amclist_end_month', [
        'amcs' => $amcs,
    ]);
}



public function amc_month_inactive(Request $request)
{
    $month = $request->input('month');
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');

    // Start building the query
    $amcsQuery = Amc::where('firm_id', Auth::user()->firm_id)
        ->where('amc_status', '=', 'Inactive');

    // Apply date range filter if both `from_date` and `to_date` are provided
    if ($fromDate && $toDate) {
        $amcsQuery->whereBetween('amc_end_date', [$fromDate, $toDate]);
    }

    // Apply month filter if `month` is provided
    if ($month !== '') {
        $amcsQuery->whereMonth('amc_end_date', '=', $month);
    }

    // Paginate the results
    $amcs = $amcsQuery->paginate(100);

    // Return the view with data
    return view('reports.amc_month_inactive', [
        'amcs' => $amcs,
    ]);
}



        public function amc_inactive(Request $request)
      {
        
        $columnName = $request->input('column_name');
        $searchBox = $request->input('search_box');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

    
        // Query the AMCs
        // $amcs = Amc::query();
        $amcs = Amc::where('firm_id',Auth::user()->firm_id)->query()->where('amc_status', '=', 'Inactive');

        $columns = \Schema::getColumnListing((new Amc)->getTable());
  
    
        if ($columnName && $searchBox) {
          $amcs->where($columnName, 'LIKE', "%$searchBox%");
      }
  
        // Apply search filters
            // $amcs->where('payment_status', '=', "Unpaid");
        
        // Apply date range filter
        if ($fromDate && $toDate) {
            $amcs->whereBetween('amc_end_date', [$fromDate, $toDate]);
        }
    
        // Execute the query
        $amcs = $amcs->paginate(100); // Paginate the results
    
        // Pass the results to the view
        return view('reports.amc_inactive', [
          'amcs' => $amcs,
          'columns' => $columns,
      
      ]);  
      }

      public function amc_view(amc $amc,$id)
      {     
        $accounts = account::where('firm_id',Auth::user()->firm_id)->get();
        $items = item::where('firm_id',Auth::user()->firm_id)->get();
        $compdata=componyinfo::where('firm_id',Auth::user()->firm_id)->first();
        $compinfofooter = compinfofooter::where('firm_id',Auth::user()->firm_id)->first();

        $comppic=pic::where('firm_id',Auth::user()->firm_id)->first();
  
        $amc= amc::where('firm_id',Auth::user()->firm_id)->find($id);
  
          return view('entery.amc_view',[
            'accountdata' => $accounts,
            'itemdata' => $items,
            'amc' => $amc,
            'compdata'=>$compdata,
            'comppic' =>$comppic,
            'compinfofooter' => $compinfofooter,
  
          ]);
  
      }

      public function amc_view2(amc $amc,$id)
      {     
        $accounts = account::where('firm_id',Auth::user()->firm_id)->get();
        $items = item::where('firm_id',Auth::user()->firm_id)->get();
        $compdata=componyinfo::where('firm_id',Auth::user()->firm_id)->first();
        $compinfofooter = compinfofooter::where('firm_id',Auth::user()->firm_id)->first();

        $comppic=pic::where('firm_id',Auth::user()->firm_id)->first();
  
        $amc= amc::where('firm_id',Auth::user()->firm_id)->find($id);
  
          return view('entery.amc_view2',[
            'accountdata' => $accounts,
            'itemdata' => $items,
            'amc' => $amc,
            'compdata'=>$compdata,
            'comppic' =>$comppic,
            'compinfofooter' => $compinfofooter,
  
          ]);
  
      }
  





}
