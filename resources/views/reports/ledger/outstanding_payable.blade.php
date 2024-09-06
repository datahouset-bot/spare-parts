
@extends('layouts.blank')
@section('pagecontent')
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>    
    



</head>
<style>
  /* Custom CSS to remove padding from td elements */
  .company_info {
      display: none;
  }



  td {
      padding: 0px !important;
      padding-left: 2px !important;

  }

  th,
  td {
      border: 1px solid darkblue !important;
      text-align: center;
      text-align: left;

  }

  table {
      width: 100%;
  }

  @media print {
      .company_info {
          background-color: yellow;
          display: grid;
          grid-template-columns: 1fr 4fr 1fr;
          border: 1px solid black;
          margin-bottom: 0px;
      }

      .logo1 {}

      .firm_detail {
          text-align: center;

      }

      .logo2 {
          align-content: :flex-end;

      }

      .page_header {
          display: block;
          /* Displayed when printing */
          height: auto;
          /* Changed height to auto */
          width: 190mm;
          /* Width of A4 paper */
          margin: 0px;
          margin-top: 0px;
          padding: 0px;
          border-radius: 2px;
          width: 100%;
          padding: 0in;

      }

      td,
      th {
          border: solid 1px;


      }

      td {
          padding: 0px !important;
          padding-left: 3px !important;

      }


      button,
      #print_button,
      #account_select_form {
          display: none;
      }

      .button-container {
          display: none;
          justify-content: center;
          align-items: center;

      }


      .page {
          size: A4;
          page-break-inside: avoid;
          position: initial;
          margin: 0in 0in 0in 0in;
          width: 100%;
          border: 1px solid;
      }

      .bg-dark,
      .d-flex {
          display: none !important;
      }

      .bg-dark {
          margin: 0 !important;
          padding: 0 !important;
      }
  }
</style>

<style>
  /* Apply styles to the date input */
input[type="date"] {
    padding: 8px; /* Adjust padding as needed */
    border: 1px solid #ccc; /* Define border color and width */
    border-radius: 4px; /* Add border-radius for rounded corners */
    background-color: #f7f7f7; /* Set background color */
    color: #333; /* Set text color */
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.1); /* Add a subtle box-shadow */
}
input[type="text"] {
    padding: 8px; /* Adjust padding as needed */
    border: 1px solid #ccc; /* Define border color and width */
    border-radius: 4px; /* Add border-radius for rounded corners */
    background-color: white; /* Set background color */
    color:black; /* Set text color */
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.1); /* Add a subtle box-shadow */
}

/* Apply styles when the input is focused */
input[type="date"]:focus {
    outline: none; /* Remove default focus outline */
    border-color: #4d90fe; /* Change border color on focus */
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 2px;
    text-align: center;
}

th {
    vertical-align: top;
    border: 1px solid white;
}

td {
    border: 1px solid black;
}


  .w-5 {
      height: 20px;
      width: 20px;
  }
  select {
    padding: 8px; /* Padding around the select box */
    border: 1px solid #ccc; /* Border color */
    border-radius: 5px; /* Rounded corners */
    box-sizing: border-box; /* Include padding and border in width calculation */
    margin-bottom: 10px; /* Spacing between select boxes */
}


</style>


<body>


{{-- <script>
  $(document).ready(function () {
    let table = new DataTable('#recordtable');
  });
  </script> --}}

    <div class="container-fluid my-1">
      @if(session('message'))
      <div class="alert alert-danger">
          {{ session('message') }}
      </div>
  @endif
  
       <div class="row justify-content-center align-items-center">
       
       
       
        <div class="container mt-1">
          <form action="{{ url('outstanding_payable_result') }}" method="POST">
            @csrf

              <div class="row"id="account_select_form">
                 
                <div class="col-md-3 mb-3">
                  <h5> Outstanding Payable</h5>
              </div>
             
                  <div class="col-md-3 mb-3">
                      Date
                      <input type="text" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}" required>
                  </div>
                  <div class="col-md-2 my-4">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>
                </div

              </div>

          </form>
      </div>
                        <div>
                          
                        <table class ="table table-responsive table-striped ">
                            <thead>
                              <tr class="table-dark">
                                <td>Account Name</td>
                                <td>Mobile</td>
                                <td>Balance</td>
                                <td></td>
                              </tr>
                             </thead>  
                             <tbody>
                              @php
                              $totalbalance=0;
                            @endphp

                              @foreach ($outstandingPayables as $record )
                              <tr>
                                <td>{{$record->account_name}}</td>
                                <td>{{$record->mobile}}</td>
                                @php

if($record->balnce_type === 'Dr'){
        $balance = $record->op_balnce + $record->total_debit - $record->total_credit;
            }
    else{
        $balance =  $record->total_debit-$record->op_balnce  - $record->total_credit;
        
        }
        $totalbalance+=$balance;
        $balanceDisplay = abs($balance) . ($balance >= 0 ? ' Dr' : ' Cr');
                                @endphp
                                <td>{{$balanceDisplay}}</td>
                                <td>
                                  <form action="{{ url('ledger_show') }}" method="POST">
                                    @csrf
                                    <input type="hidden"  name="account_id" value="                               {{$record->id}}">
                                    <input type="hidden" class="form-control " name="from_date" value="01-04-2019" required>
                                    <input type="hidden" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}" required>
                                    <button type="submit"><i class="fa fa-eye"
                                      style="font-size:20px;color:SlateBlue"></i></button>
                                  </form>
                                  
</td>



                              </tr>
                                
                              @endforeach
                              <tr>
                                <td>Total</td>
                                <td></td>
                                @php
                                         $totalbalanceDisplay = abs($totalbalance) . ($totalbalance >= 0 ? ' Dr' : ' Cr');
 
                                @endphp
                                <td>{{$totalbalanceDisplay}}</td>
                                <td></td> 
                                </tr>              
 
                                
  
                            
               
                             </tbody>
                        </table>  
  
                        </div> 
                          
                            

                  </div>



                </div>


                <div class="row my-2 item-justify-center" id="print_button">
                  <button class="btn btn-dark btn-sm" onclick="printInvoice()">Print</button>
              </div>
      
      
      
      
              <!-- jQuery -->
              <script>
                  function printInvoice() {
                      window.print();
                  }
              </script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#account_id").select2({
            placeholder: "Select Account Name ",
            allowClear: true
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>


        </body>

</html>

@endsection