
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
       
       
       
        <div class="container mt-5">
          <form action="{{ url('ledger_show') }}" method="POST">
              @csrf
              <div class="row">
                  <div class="col-md-3 mb-3 mx-3">
                    Salect Account  
                    <select name="account_id" class="form-control" id="account_id" required>
                          <option value="" selected disabled>Select Account Name</option>
                          @foreach ($accounts as $account)
                          <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-3 mb-3">
                    Form Date
                      <input type="text" class="form-control date" name="from_date" value="{{ date('Y-m-d') }}" required>
                  </div>
                  <div class="col-md-3 mb-3">
                     To Date
                      <input type="text" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}" required>
                  </div>
                  <div class="col-md-2 my-4">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>
                </div>

              </div>

          </form>
      </div>
                        <div>
                          
                        <table class ="table table-striped ">
                            <thead>
                              <tr>
                                <td>Date</td>
                                <td>Account Name</td>
                                <td>Remark</td>
                                <td>Debit </td>
                                <td>Credit </td>
                                <td>Balance</td>
                              </tr>
                             </thead>  
                             <tbody>

                              <tr>
                                <td></td>
                                <td>Closing Balnce</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @php
                              $opening_balanceDisplay = abs($final_opning_balance) . ($final_opning_balance >= 0 ? ' Dr' : ' Cr');
                                @endphp
                                <td>{{$opening_balanceDisplay}}</td>
                              </tr>
                                
 
                                
  
                            
               
                             </tbody>
                        </table>  
  
                        </div> 
                          
                            

                  </div>



                </div>


        

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