<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<style>
table {
            font-family: Calibri, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        /* Define table header styles */
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            padding: 8px;
            text-align: left;
        }

        /* Define table row styles */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #fff;
        }

        /* Define table cell styles */
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
    </style>    
    



</head>

<body>
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
                      
                      
                      </tr>
                      @endforeach
                      
                      
                    </tbody>
                  </table>
            </div>

       
    </div>

    
    
</body>

</html>

                        {{-- <td scope="col">{{$amc['payment_status']}}</td> --}}
                        {{-- <td scope="col">{{$amc['priority']}}</td>   amcpriority  --}}
                        {{-- <td scope="col">{{$amc['amc_status']}}</td> --}}
