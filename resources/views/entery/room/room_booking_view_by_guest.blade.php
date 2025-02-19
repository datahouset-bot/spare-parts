@php
include(public_path('cdn/cdn.blade.php'));
@endphp
{{-- <link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}"> --}}

@extends('layouts.fullblank')
@section('pagecontent')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking Slip </title>
      <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            }

        .page {
            height: auto; /* Changed height to auto */
            width: 190mm; /* Width of A4 paper */
            margin: 0 auto;
            margin-top: 10px;
            padding: 0px;
            border: 1px solid;
            border-radius: 2px;
            width: 80%;
            padding: .3in;
        }

        .page_header {
            /* display: none; Initially hidden */
            position: relative;
            top: 0;
            width: 100%;
            background-color:beige;
            padding: 0px;
            text-align: center;
            

        }

        .info-container {
            display: flex;
            justify-content: space-between;
            margin: 5px; /* Added margin-bottom for separation */
            margin-right: 5px; 

        }

        .cust_info{
            background-color: aquamarine;
            width: 50%; /* Adjusted width to accommodate for separation */
            padding: 5px;
            box-sizing: border-box;
            text-align: left;
        }

        .voucher_info {
            width: 50%;
            background-color: gold;
            text-align: left;
            padding: 5px;
        }

        .detail {
            background-color: silver;
            width: 100%;
            text-align: right;
        }

        .table_detail {
            padding: 2px;
            background-color: gray;
            width: 100%;
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
        .row1{
          display: inline;
        }
        .heading{
            font-weight: 1000;
        }
        br{
            background-color: white;
        }
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
         
        }
        .voucher_head{
            background-color: yellow;
            display: grid;
            grid-template-columns: 30% 70%;
        }
        .gst_no{
            font-size: medium;
            font-weight: 800;
            margin-left: 10px;
            font-style: bold;
        }
        .bill_head
        {
            margin-left: 20%;
            font-size: x-large;
        }
        .company_info{
            background-color: yellow;
            display: grid;
            grid-template-columns: 1fr 4fr 1fr;
            border: 1px solid black;
            margin-bottom: 0px;
        }
        .logo1{

}
        .firm_detail{
            text-align: center;

        }
        
        .logo2{
align-content: :flex-end;

        }

        .voucher_footer{
            background-color: yellow;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            border: 1px solid black;
            margin-bottom: 0px;
        }
        .terms{
            grid-column: 1 / 3;
            height: 100px;
            text-align: center;
        }
        .bank_detail{
            text-align: left;
            height: 120px;
            border-top: 1px solid;
            padding: 1px;
            font-size: 15px; 
        }
        .comp_sign{

            border-left: 1px solid;
            text-align: center;

        }


        .qr_code{
            border-left: 1px solid;
            border-top: 1px solid;
            text-align: center;

        }

        .for_companyname{
            border-left: 1px solid; 
            text-align: center;
        }

        /* CSS for page breaks */
        @media print
         {
            .page_header {
                display: block; /* Displayed when printing */
            }

            button{
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
                position:initial;
                margin: 0in 0in 0in 0in;
                width: 100%;
                border: 1px solid;
            }
            .bg-dark ,.d-flex{
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

        <div class= "voucher_head">
            <div class= "gst_no" > GST NO:{{ $componyinfo->cominfo_gst_no }}</div>
            <div class="bill_head">Room Booking Slip</div>


        </div>
        <div class="company_info">
          <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\'.$pic->logo) }}" alt="qr_code" width="80px"></div>
          <div class="firm_detail"><h4>{{ $componyinfo->cominfo_firm_name }}</h4>
            <span>{{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}</span><br>
            <span>{{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }} &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;<br>{{$compinfofooter->country }}</span>
            <span>Email:{{ $componyinfo->cominfo_email }} Phone &nbsp;{{ $componyinfo->cominfo_phone }} Mobile&nbsp;{{ $componyinfo->cominfo_mobile }}   </span>
</div>
          <div class="logo2"><img src="{{ asset('storage\app\public\image\\' . $pic->brand) }}" alt="qr_code" width="80px"></div>  
        </div>
   
        
            <div class="page_header">
            <div class="info-container">
                <div class="cust_info">
                    <span class="heading">Guest Detail</span><br>
                    <span>Guest Name:{{ $roombooking->guest_name }}</span><br>
                    <span>Add:{{ $roombooking->guest_address }}</span><br>
                    <span>city:{{ $roombooking->guest_city }}</span><br>
                    <span>State:{{ $roombooking->guest_state }}</span><br>
                    <span>Mob:{{ $roombooking->guest_mobile }}</span><br>
  
                    <span>Email:{{ $roombooking->guest_email }}</span><br>
           
                    
                </div>
                <div class="voucher_info">
                    <span class="heading">Booking Detail</span><br>
                    <span>Booking No : {{ $roombooking->booking_no }}</span><br>
                    <span>Booking Date:{{ $roombooking->booking_date }}</span><br>
                    <span>Booking Time:{{ $roombooking->booking_time }}</span><br>
                    <span>Aspected Check In Date: {{ \Carbon\Carbon::parse($roombooking->checkin_date)->format('d-m-y') }}   
                         </span><br>
                    <span>Check In Time:{{ $roombooking->checkin_time }}</span><br>
                    <span>Aspected Check Out Date:{{ \Carbon\Carbon::parse($roombooking->checkout_date)->format('d-m-y') }}</span><br>
                    <span>Check Out Time :{{ $roombooking->checkout_time }}</span><br>
                    <span>Total Day  :{{$totaldays }}</span><br>
                </div>
            </div>

        </div>



        <div class="detail">
            <table class="table_detail">
                <thead>
                    
                    <tr>
                        <th class="th_detail">Room No </th>
                        <th class="th_detail">Total Rooms </th>
                        <th class="th_detail"> No of Guest </th>
                        <th class="th_detail">Commited Days</th>
                        <th class="th_detail">Tariff</th>


                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="td_detail">
   
                            @foreach ($roomnos as $roomrecords )
                                    {{$roomrecords->room_nos}}                            
                            @endforeach

                    </td>

                        <td class="td_detail">total rooms</td>
                        <td class="td_detail">{{ $roombooking->no_of_guest }}</td>
                        <td class="td_detail">{{ $roombooking->commited_days }}</td>
                        <td class="td_detail">{{ $roombooking->room_tariff_perday }}</td>
                    </tr>



            </table>
            <div style="background-color: white">&nbsp;</div>



            <table class="table_detail">
                <thead>
                    
                    <tr>
                        <th class="th_detail">Booking Amount</th>
                        <th class="th_detail">Payment Refrance No</th>
                        <th class="th_detail">Refrance No </th>
                        <th class="th_detail">Agent </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td class="td_detail">{{ $roombooking->booking_amount }}</td>
                        <td class="td_detail">{{ $roombooking->voucher_payment_remark}}</td>
                        <td class="td_detail">{{ $roombooking->refrance_no}}</td>
                        <td class="td_detail">{{ $roombooking->agent }}</td>


                    </tr>

            </table>




        </div>
        <div style="background-color: white" class="my-1">&nbsp;</div>

        <div class="voucher_footer">
            <div class="terms "style="background-color:#e6ecff">
            <h5>Terms & Conditions</h5>
            <span >{{$compinfofooter->terms}}</span>
            </div>
            <div class="for_companyname"style="background-color:#e6ecff"><span>For {{ $componyinfo->cominfo_firm_name }}</span><br></div>
            <div class="bank_detail"style="background-color:#e6ecff">
            <span>Bank Name:{{$compinfofooter->bank_name}}</span><br>
            <span>Bank A/C No :{{$compinfofooter->bank_ac_no}}</span><br>
            <span>Bank IFSC:{{$compinfofooter->bank_ifsc}}</span><br>
            <span>Bank Branch:{{$compinfofooter->bank_branch}}</span><br>
            </div>
            <div class="qr_code"style="background-color:#e6ecff">
                <span>Bank Name:{{$compinfofooter->upiid}}</span><br>
                &nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->qrcode) }}" alt="qr_code" width="80px">
                {{-- <img src="/storage/image/qr.jpeg" alt="qr_code" width="80px">  this is abal to print image --}}
                

            </div>
            <div class="comp_sign"style="background-color:#e6ecff">
                
                &nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->seal) }}" alt="qr_code" width="80px">
            </div>  




  
        </div>






        <div class="button-container my-2">
            <button class="btn btn-primary btn-lg" onclick="printInvoice()">Print</button>
            <a  class= "btn btn-dark  "href={{url('hotel_index')}}>Home</a></div>
        </div>



    </div>

    <script>
        function printInvoice() {
            window.print();
        }
    </script>


</body>
</html>
@endsection
