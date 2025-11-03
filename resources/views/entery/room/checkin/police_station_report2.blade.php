<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Station Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        /* Define header and footer space */
        @page {
            margin-top: 60px;
            margin-bottom: 50px;
            header: html_myHeader;
            footer: html_myFooter;
        }

        /* Fixed Header Styling */
        .header {
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            border-bottom: 2px solid #000;
            padding-bottom: 0px;
            margin-bottom: 5px;
        }

        /* Table Styling */
        .table_detail {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 8px;
        }

        .table_detail th {
            background-color: #007BFF;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            padding: 2px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table_detail td {
            padding: 2px;
            border: 1px solid #ddd;
        }

        /* Alternating Row Colors */
        .table_detail tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Footer Styling */
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>

    <!-- Define Header -->
   

    <!-- Main Content -->
    <main>
        <table class="table_detail">
            <thead>
                <tr> 
                    <td colspan="6">
                        <htmlpageheader name="myHeader">
          
                            <div class="header">
                                <h6>{{ $componyinfo->cominfo_firm_name }}</h6>
                                <p>
                                    {{ $componyinfo->cominfo_address1 }} {{ $componyinfo->cominfo_address2 }},
                                    {{ $componyinfo->cominfo_city }}, {{ $componyinfo->cominfo_state }} - {{ $componyinfo->cominfo_pincode }} <br>
                                    <strong>Email:</strong> {{ $componyinfo->cominfo_email }} | 
.                                    <strong>Phone:</strong> {{ $componyinfo->cominfo_phone }} | 
                                    <strong>Mobile:</strong> {{ $componyinfo->cominfo_mobile }}
                                </p>
                            </div>
                        </htmlpageheader>

                    </td>
                
                </tr>
                <tr>
                    <th class="th_detail"  width="25%">Guest Details</th>
                    <th class="th_detail" width="10%"  >Mobile</th>

                    <th class="th_detail" width="10%">Check-in Date</th>
                    <th class="th_detail"  width="10%">Check-out Date</th>
                    <th class="th_detail" width="8%">No. of Members</th>
                    <th class="th_detail" >Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roomcheckins as $record)
                <tr>
                    <td class="td_detail">
<strong style="font-size:{{$guest_name_font}}px;">{{ $record->guest_name }}</strong><br>
                        <small style="font-size:{{$guest_address_font}}px;">ID: {{ $record->account_idproof_no }}</small><br>
                    
                        @if($record->checkinaf1)
                            <div style="font-size:{{$guest_address_font}}px;">{{ $record->checkinaf1 }}</div>
                        @endif
                    
                        @if($record->checkinaf6)
                            <div style="font-size:{{$guest_address_font}}px;">{{ $record->checkinaf6 }}</div>
                        @endif
                    
                        @if($record->checkinaf3)
                            <div style="font-size:{{$guest_address_font}}px;">{{ $record->checkinaf3 }}</div>
                        @endif
                    
                        @if($record->checkinaf8)
                            <div style="font-size:{{$guest_address_font}}px;">{{ $record->checkinaf8 }}</div>
                        @endif
                    </td>
                    <td class="td_detail" style="font-size:{{$guest_mobile_font}}px;"> {{$record->guest_mobile}}</td>
                                        <td class="td_detail" style="font-size:{{$guest_address_font}}px;">{{ \Carbon\Carbon::parse($record->checkin_date)->format('d-m-Y') }}</td>
                    <td class="td_detail"style="font-size:{{$guest_address_font}}px;">{{ \Carbon\Carbon::parse($record->checkinaf9)->format('d-m-Y') }}</td>
                    <td class="td_detail"style="font-size:{{$guest_address_font}}px;">{{ $record->no_of_guest }}</td>
                    <td class="td_detail" style="font-size:{{$guest_address_font}}px;">{{ $record->address }} {{ $record->address2 }}, {{ $record->city }}, {{ $record->state }},{{$record->pincode}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <!-- Define Footer -->
    <htmlpagefooter name="myFooter">
        <div class="footer">
            {{-- Page {PAGENO} of {nbpg} --}}
        </div>
    </htmlpagefooter>

</body>
</html>
