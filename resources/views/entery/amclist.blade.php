
@extends('layouts.blank')
@section('pagecontent')
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
    border: 1px solid yellow;
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
       
       
       
        {{-- <div class=" d-flex align-items-center justify-content-center col-md-6 "> --}}
          <form action={{url('/amclist')}} method="POST">
                    <div class="col-md-12 text-center">
                            @csrf
                                 
                       
                            
                            <select name="column_name" class="myitem"id="column_name">
                              <option value="">Select</option>
                              @foreach ($columns as $column)
                              <option value="{{ $column }}">{{ $column }}</option>
                               @endforeach
                            </select>
                            <input type="text" name="search_box"placeholder="Type Keywords for Search"> 
                            <input type="date"  name="from_date" value="{{  date('Y-m-d') }}" class="">
                            <input type="date" name ="to_date"  value="{{  date('Y-m-d') }}"class="">
                           
                            <button   type="submit" class="btn btn-primary">OK</button>
                          </form>
                          <a href={{url('/amclist')}} class="btn btn-warning" ><i class="fa fa-refresh" style="font-size:20px;color:black"></i> </a>
                            <a href={{url('/amcform')}} class="btn btn-success">Add New AMC  </a>
                            <a href={{ route('amc.export') }} class="btn btn-primary">EXPORT  </a>
                            <a href={{url('/amclist-pdf')}} class="btn btn-info">PDF </a>
                            <a href={{url('/amclist-print')}} class="btn btn-dark">PRINT </a>
                            <a href={{url('/amclist-mail')}} class="btn btn-warning">MAIL </a>
                            
                          </div>    
                          
                          
                            

                  </div>
            <table  id="recordtable" class="table table-striped table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">{{ $compinfofooter->ct2 }}&nbsp; No</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Product</th>
                        <th scope="col">{{ $compinfofooter->ct2 }}&nbsp;Amount</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Days</th>
                        <th scope="col">Paymnet</th>
                        <th scope="col">{{ $compinfofooter->ct2 }}&nbsp;Status</th>
                        <th scope="col">Type</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                       </tr>
                    </thead>
                    <tbody>
                
                      @php
                        $r1=0;
                
                      @endphp
                      @foreach ($amcs as $amc)
                        
                      <tr>
                        <td scope="row">{{$r1=$r1+1}}</td>
                        <td scope="col">{{$amc['id']}}</td>
                        <td scope="col">{{ $amc->item->item_name }}</td>
                        <td scope="col">{{ $amc->account->account_name }}</td>
                        <td scope="col">{{$amc['amc_amount']}}</td>
                        {{-- <td scope="col">{{$amc['amc_start_date']}}</td>
                        <td scope="col">{{$amc['amc_end_date']}}</td> --}}
                        <td scope="col">{{ \Carbon\Carbon::parse($amc['amc_start_date'])->format('d-m-y') }}</td>
                   <td scope="col">{{ \Carbon\Carbon::parse($amc['amc_end_date'])->format('d-m-y') }}</td>
                   
                   {{-- for  diffrence day calculation  --}}

                   @php
                     $startDateTime = \Carbon\Carbon::parse($amc['amc_start_date'])->startOfDay()->addHours(0)->addMinutes(1);
                      $endDateTime = \Carbon\Carbon::parse($amc['amc_end_date'])->endOfDay()->subMinutes(1);

                      $diffInDays = $startDateTime->diffInDays($endDateTime) + 1; // Add 1 to count the start day
                   @endphp
                   <td scope="col">{{ $diffInDays }}</td>

                        {{-- <td scope="col">{{$amc['payment_status']}}</td> --}}
                        <td scope="col">
                          @php
                              $paymentStatus = $amc['payment_status'];
                              $badgeColor = '';
                      
                              if ($paymentStatus === 'Paid') {
                                  $badgeColor = 'success'; // Green color for Paid status
                              } elseif ($paymentStatus === 'Unpaid') {
                                  $badgeColor = 'danger'; // Yellow color for Due status
                              } elseif ($paymentStatus === 'Unknown') {
                                  $badgeColor = 'dark'; // Dark color for Unknown status
                              } else {
                                  $badgeColor = 'secondary'; // Default color if status doesn't match
                              }
                          @endphp
                      
                          <span class="badge badge-{{ $badgeColor }}">{{ $paymentStatus }}</span>
                      </td>
                      
                        {{-- <td scope="col">{{$amc['amc_status']}}</td> --}}
                        <td scope="col">
                          @php
                              $status = $amc['amc_status'];
                              $badgeColor = '';
                      
                              if ($status === 'Active') {
                                  $badgeColor = 'success'; // Green color for Active status
                              } elseif ($status === 'Inactive') {
                                  $badgeColor = 'danger'; // Red color for Deactive status
                              } elseif ($status === 'Unknown') {
                                  $badgeColor = 'dark'; // Dark color for Unknown status
                              } else {
                                  $badgeColor = 'secondary'; // Default color if status doesn't match
                              }
                          @endphp
                      
                          <span class="badge badge-{{ $badgeColor }}">{{ $status }}</span>
                      </td>
                        {{-- <td scope="col">{{$amc['priority']}}</td>   amcpriority  --}}

                        <td scope="col">
                          @php
                              $priority = $amc['priority'];
                              $badgeColor = 'secondary'; // Default color if none of the conditions match
                      
                              if ($priority === 'Gold') {
                                  $badgeColor = 'warning '; // Or any other custom color
                              } elseif ($priority === 'Platinum') {
                                  $badgeColor = 'success'; // Or any other custom color
                              } elseif ($priority === 'silver') {
                                  $badgeColor = 'dark'; // Or any other custom color
                              } elseif ($priority === 'bronze') {
                                  $badgeColor = 'info'; // Or any other custom color
                              }
                          @endphp
                      
                          <span class="badge badge-{{ $badgeColor }}">{{ $priority }}</span>
                      </td>
                      
                        <td><a href="{{('amc_view/'.$amc['id']) }}"  class=""><i class="fa fa-eye" style="font-size:20px;color:DarkGreen"></i></a></td>
                        <td><a href="{{('show_edit_amc/'.$amc['id']) }}"  class=""><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a></td>
                        <td><a href="{{('delete_amc/'.$amc['id']) }}"  class=""><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></a></td>
                      </tr>
                      @endforeach
                      
                    </tbody>
            </table>

        
    <div class="d-flex justify-content-center">
      {{ $amcs->links() }}
  </div>    
        </div>
        
       

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
       ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        ></script>
        </body>

</html>

@endsection