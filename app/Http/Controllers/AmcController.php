<?php

namespace App\Http\Controllers;
use App\Models\item;
use App\Models\amc;
use App\Models\account;
use App\Models\componyinfo;
use App\Models\compinfofooter;
use App\Models\pic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exports\AMCExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\AmcListMail;
use Illuminate\Support\Facades\Mail;

class AmcController extends CustomBaseController
{
  public function __construct()
    {
        $this->middleware(['auth','verified']);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $accounts = account::all();
          $items = item::all();
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
      $accounts = account::all();
      $items = item::all();

      $amc= amc::find($id);

        return view('entery.amcformedit',[
          'accountdata' => $accounts,
          'itemdata' => $items,
          'amc' => $amc,

        ]);

    }

    public function amclist()
    {
      $amcs = Amc::with('account', 'item')->orderBy('id', 'desc')->paginate(100);

 
      // $amcs = Amc::with('account', 'item')->paginate(100);
      $columns = \Schema::getColumnListing((new Amc)->getTable());
      // $ columns variable for serch box listing page 

      // Pass the data to the view
      return view('entery.amclist', [
          'amcs' => $amcs,
          'columns' => $columns,
      ]);
  
    }
        public function amclisttest()
    {
      
      $accounts = account::all();
          $items = item::all();
        //   return $items;

         return view("entery.amcform2", [
             'accountdata' => $accounts,
              'itemdata' => $items
         ]);
      
  
    }

  





    //amc entery  function 
    public function create(Request $request)
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
             $amc=new amc;
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
      $amcs = Amc::with('account', 'item')->get();

    $data=[
      'amcs' => $amcs,
    ];
    $pdf=PDF::loadView('entery.amclistpdf', $data);

      return $pdf->download('amclists.pdf');

    }


    public function sendAmcListEmail()
    {
      $amcs = Amc::with('account', 'item')->get();

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
      $amcs = Amc::with('account', 'item')->get();

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
          $amcs = Amc::query();
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
          $amcs = $amcs->paginate(10); // Paginate the results
      
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

    
        
        $amcs = Amc::query()->where('payment_status', '=', 'Unpaid');

          
    
  
        if ($fromDate && $toDate) {
            $amcs->whereBetween('amc_end_date', [$fromDate, $toDate]);
        }

        if ($month !== '') {
          $amcs->whereMonth('amc_end_date', '=', $month);
      }
    
          $amcs = $amcs->paginate(100); // Paginate the results
    

        return view('reports.amclist_due_month', [
          'amcs' => $amcs,
          // 'columns' => $columns,


          
        
        ]);
      }
        public function amclist_end_month(Request $request)
        {
          
          
          $month = $request->input('month');
          $fromDate = $request->input('from_date');
          $toDate = $request->input('to_date');
  
      
          
          // $amcs = Amc::query()->where('payment_status', '=', 'Unpaid');
          
          $amcs = Amc::query();
  
            
      
    
          if ($fromDate && $toDate) {
              $amcs->whereBetween('amc_end_date', [$fromDate, $toDate]);
          }
  
          if ($month !== '') {
            $amcs->whereMonth('amc_end_date', '=', $month);
        }
      
            $amcs = $amcs->paginate(100); // Paginate the results
      
  
          return view('reports.amclist_end_month', [
            'amcs' => $amcs,
            // 'columns' => $columns,
  
  
            
          
          ]);
        
      }
       


      public function amc_month_inactive(Request $request)
      {
        
        
        $month = $request->input('month');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

    
        
        $amcs = Amc::query()->where('amc_status', '=', 'Inactive');

          
    
  
        if ($fromDate && $toDate) {
            $amcs->whereBetween('amc_end_date', [$fromDate, $toDate]);
        }

        if ($month !== '') {
          $amcs->whereMonth('amc_end_date', '=', $month);
      }
    
          $amcs = $amcs->paginate(100); // Paginate the results
    

        return view('reports.amc_month_inactive', [
          'amcs' => $amcs,
          // 'columns' => $columns,


          
        
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
        $amcs = Amc::query()->where('amc_status', '=', 'Inactive');

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
        $accounts = account::all();
        $items = item::all();
        $compdata=componyinfo::find(1);
        $compinfofooter = compinfofooter::find(1);

        $comppic=pic::find(1);
  
        $amc= amc::find($id);
  
          return view('entery.amc_view',[
            'accountdata' => $accounts,
            'itemdata' => $items,
            'amc' => $amc,
            'compdata'=>$compdata,
            'comppic' =>$comppic,
            'compinfofooter' => $compinfofooter,
  
          ]);
  
      }
  





}
