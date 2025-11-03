@php
    include public_path('cdn/cdn.blade.php');
@endphp
{{-- <link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}"> --}}

@extends('layouts.blank')
@section('pagecontent')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>KOT</title>
        <style>
            @page {
                size: auto;
                margin: 0;
            }

            body {
                margin: 0;
               
            }
            
            button,.navbar-brand,.sb-topnav,{
                    display: none;
                }

            .page {
                height: auto;
                /* Changed height to auto */
                width: 190mm;
                /* Width of A4 paper */
                margin: 0 auto;
                margin-top: 10px;
                padding: 0px;
                border: 1px solid;
                border-radius: 2px;
                width: 80%;

            }

            .page_header {
                /* display: none; Initially hidden */
                position: relative;
                top: 0;
                width: 100%;
                background-color: beige;
                padding: 0px;
                text-align: center;


            }

            .info-container {
                display: flex;
                justify-content: space-between;
                margin: 5px;
                /* Added margin-bottom for separation */
                margin-right: 5px;

            }
            #footer_total{
                width: 100%;
                 font-size: 15px;
                 padding: 2px; 
            }
                               
            .cust_info {
                background-color: aquamarine;
                width: 50%;
                /* Adjusted width to accommodate for separation */
                padding: 5px;
                box-sizing: border-box;
                text-align: left;
            }

            .voucher_info {
                width: 50%;
                background-color: gold;
                text-align: left;
                padding: 5px;
                fon
            }
            .qty_total{
                text-align: left;
            }

            td,th{
                    border: solid 1px;
                }
            .detail {
                background-color: silver;
                width: 100%;
                text-align: right;
            }


            .table_detail {
background-color:white;
                width: 100%;
                padding: 2px;
            }

            .th_detail {
                background-color: white;
                border: 1px solid;
                text-align: center;
            }

            .td_detail {
                background-color: white;
                text-align: center;
                border: 1px solid;
            }

            .row1 {
                display: inline;
            }
            .button-container {
                display: flex;
                justify-content: center;
                align-items: center;

            }

            .voucher_head {
                background-color: yellow;
                display: grid;
                grid-template-columns: 100%;
                font: 100px;
                text-align: center;

            }

            .gst_no {
                font-size: medium;
                font-weight: 800;
                margin-left: 10px;
                font-style: bold;
            }

            .bill_head {
                margin-left: 0%;
                font-size: x-large;
            }
            .header_info{
                width: 100%;
                text-align: center;
              
            }

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

            .voucher_footer {
                background-color: yellow;
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                border: 1px solid black;
                margin-bottom: 0px;
            }

            .terms {
                grid-column: 1 / 3;
                height: 100px;
                text-align: center;
            }

            .bank_detail {
                text-align: left;
                height: 120px;
                border-top: 1px solid;
                padding: 1px;
                font-size: 15px;
            }

            .comp_sign {

                border-left: 1px solid;
                text-align: center;

            }


            .qr_code {
                border-left: 1px solid;
                border-top: 1px solid;
                text-align: center;

            }

            .for_companyname {
                border-left: 1px solid;
                text-align: center;
            }

            /* CSS for page breaks */
            @media print {
                .page_header {
                    display: block;
                    /* Displayed when printing */
                    height: auto;
                /* Changed height to auto */
                width: 190mm;
                /* Width of A4 paper */
                margin: 0px ;
                margin-top: 0px;
                padding: 0px;
                border-radius: 2px;
                width: 100%;
                padding: 0in;

                }
                td,th{
                    border: solid 1px;
                }
                


                button,.navbar-brand {
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






    </head>

    <body>

        <div class="page">

            <div class="company_info">
                <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" alt="qr_code"
                        width="80px">
                </div>
                <div class="firm_detail">
                    <h6>{{ $componyinfo->cominfo_firm_name }}</h6>
                    <h2>Approval Bill </h2>
                </div>
                <div class="logo2"><img src="{{ asset('storage\app\public\image\\' . $pic->qrcode) }}" alt="qr_code"
                        width="80px">
               
                </div>
            </div>
            <div class="header_info">
                     {{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}&nbsp;
                    {{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;{{ $compinfofooter->country }}&nbsp;
                   Email:{{ $componyinfo->cominfo_email }} Phone &nbsp;{{ $componyinfo->cominfo_phone }}
                        Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} 
                 
            </div>



            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                       @if(isset($roomcheckins_first['guest_name']))
                        <span>Guest Name:{{$roomcheckins_first->guest_name}} </span><br>
                    @else
                        <span>Guest Name:</span><br>
                    @endif
                     
                    @if(isset($roomcheckins_first->account->address))
                        <span>Adress: {{ $roomcheckins_first->account->address }}</span><br>
                    @else
                        <span>Address:</span><br>
                    @endif
                    
                    @if(isset($roomcheckins_first->account->mobile))
                        <span>Mobile: {{ $roomcheckins_first->account->mobile }}</span><br>
                    @else
                        <span>Mobile: </span><br>
                    @endif
                    @if(isset($inputbagdata['remark']))
                    <span>Remark: {{ $inputbagdata['remark'] }}</span><br>
                @else
                    <span>Remark: </span><br>
                @endif
                    


                    </div>
                    <div class="voucher_info">

                        <span>Invoice No :   {{ $inputbagdata['food_bill_no'] }}</span><br>
                        <span>Date : {{ $inputbagdata['voucher_date'] }}</span><br>
                          Time:<span id="current-time"></span> <br>
                         <span>Room No :&nbsp;
                        @foreach ($roomcheckins as $record )
                            {{$record->room_no}} ,
                        @endforeach    
                        </span>

                    </div>
                </div>

            </div>



          <div class="detail">



                <table class="table_detail">
                    <thead>

                        <tr>
                            <th class="th_detail">S.no</th>
                            <th class="th_detail">Item Name</th>
                            <th class="th_detail">Qty</th>
                            <th class="th_detail">Rate</th>
                            <th class="th_detail">Gst%</th>
                            <th class="th_detail">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $sno=0;
                        @endphp
                        @foreach ($itemrecords as $records ) 
                        <tr>
                            <td>{{$sno=$sno+1}}</td>
                          <td>{{$records->item->item_name}}</td>
                          <td>{{ number_format($records->qty, 0) }}</td>
                          <td>{{ number_format($records->rate,1)}}</td>
                          <td>{{ number_format($records->item->gstmaster->igst,2)}}</td>

                          <td>{{ number_format($records->rate*$records->qty,1)}}</td>  
                        </tr>
                            
                         @endforeach
  
                </table>





            </div>
            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                       
                        <span>Total Item ={{$inputbagdata['total_item']}}</span><br>
                        <span>Total Qty ={{$inputbagdata['total_qty']}}</span><br>
                        <span> Kot Nos ={{$inputbagdata['kot_no']}}</span><br>
                       
                    </div>
                    <div class="voucher_info">
                        <table id="footer_total">
                            <tr>
                                <td>Basic Amt:</td>
                                <td>{{ $inputbagdata['total_base_amount'] }}</td>
                            </tr>
                            <tr>
                                <td>Dis {{ $inputbagdata['dis_percant']}}% :</td>
                                <td>{{ $inputbagdata['total_discount_amount'] }}</td>
                            </tr>

                            <tr>
                                <td>SGST Amt:</td>
                                <td>{{ $inputbagdata['total_gst_amount']/2 }}</td>
                            </tr>
                            <tr>
                                <td>CGST Amt:</td>
                                <td>{{ $inputbagdata['total_gst_amount']/2  }}</td>
                            </tr>
                            <tr>
                                <td>Round Off:</td>
                                <td>{{ $inputbagdata['round_off'] }}</td>
                            </tr>
                            <tr>
                                <td>Grand Total :</td>
                                <td><h3>{{ $inputbagdata['net_food_bill_amount'] }}</h3></td>
                            </tr>
                        </table>


                    </div>
                </div>

            </div> 



            <div style="background-color: white" class="my-1">&nbsp;</div>






            <div class="button-container my-2">
                <button class="btn btn-primary btn-lg" onclick="printInvoice()">Print</button>
                <a href="{{url('/table_dashboard')}}" class ="btn btn-info btn-lg mx-2">Restaurent</a>
               <a href="{{url('/room_dashboard')}}" class ="btn btn-dark btn-lg mx-2">Room Dashboard </a>
            </div>



        </div>

        <script>
            function printInvoice() {
                window.print();
            }
        </script>
           <script>
            // script for getting current time from browser pc 
            $(document).ready(function() {
                function getCurrentTime() {
                    var currentDate = new Date();
                    var hours = currentDate.getHours();
                    var minutes = currentDate.getMinutes();
                    var seconds = currentDate.getSeconds();
                    
                    // Add leading zeros to hours, minutes, and seconds
                    hours = (hours < 10) ? "0" + hours : hours;
                    minutes = (minutes < 10) ? "0" + minutes : minutes;

                    
                    var timeString = hours + ":" + minutes + "" ;
                    $('#current-time').text(timeString);
                }
        
                // Call the function once to display the time initially
                getCurrentTime();
        
                // Update the time every second
                setInterval(getCurrentTime, 1000);
            });
        </script>


    </body>

    </html>
@endsection
