
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

<body>
<script>
  $(document).ready(function () {
    let table = new DataTable('#recordtable');
  });
  </script>

    <div class="container my-1">
        <div class="row justify-content-center align-items-center">
                <div class=" row justify-content-center align-items-center ">
                 <div class="col-12 justify-content-center align-items-center">
           
                  <div class=" d-flex align-items-center justify-content-center col-sm-12 my-2">
                          <div class="col-md-12 text-center">
                            <a href={{url('/amcform')}} class="btn btn-success">Add New AMC  </a>
                            <a href={{ route('amc.export') }} class="btn btn-primary">EXPORT  </a>
                            <a href={{url('/amcform')}} class="btn btn-info">PDF </a>
                            <a href={{url('/amcform')}} class="btn btn-dark">PRINT </a>
                            <a href={{url('/amcform')}} class="btn btn-warning">MAIL </a>
                            <a href={{url('/amcform')}} class="btn btn-secondary">SEARCH </a>
                          </div>    
                          
                          
                            

                        </div>
     



                        <h1> this is page for export amc </h1>



                <div class="com_table  d-flex align-items-center justify-content-center col-sm-12">
                   
                    
                  <table  id="recordtable" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Amc No</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Product</th>
                        <th scope="col">AMC Amount</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Paymnet</th>
                        <th scope="col">AMC Status</th>
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
                        <td scope="col">{{$amc['amc_start_date']}}</td>
                        <td scope="col">{{$amc['amc_end_date']}}</td>
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
                      
                        <td><a href="{{('itemformview/'.$amc['id']) }}"  class=""><i class="fa fa-eye" style="font-size:30px;color:DarkGreen"></i></a></td>
                        <td><a href="{{('showedititem/'.$amc['id']) }}"  class=""><i class="fa fa-edit" style="font-size:30px;color:SlateBlue"></i></a></td>
                        <td><a href="{{('deleteitem/'.$amc['id']) }}"  class=""><i class="fa fa-trash" style="font-size:30px;color:OrangeRed"></i></a></td>
                      </tr>
                      @endforeach
                      
                      
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
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