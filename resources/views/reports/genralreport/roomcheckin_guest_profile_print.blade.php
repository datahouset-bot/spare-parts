@php
include(public_path('cdn/cdn.blade.php'));
@endphp
{{-- <link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}"> --}}

@extends('layouts.blank')
@section('pagecontent')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Profile  View  </title>
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
            background-color: lightblue;
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
            background-color:#FFD700;
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
    .voucher_footer {
        display: flex;
        flex-direction: column;
        gap: 10px; /* Space between rows */
    }

    .row {
        display: flex;
        justify-content: space-around; /* Space images evenly */
        gap: 10px; /* Space between images */
    }

    .row img {
        width: 30%; /* Adjust size as needed */
        height: auto;
        border: 1px solid #ccc; /* Optional styling */
        border-radius: 5px; /* Optional styling */
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
                    <span>Guest Name:{{ $checkindata->guest_name }}</span><br>
                    <span>Father Name:{{ $checkindata->account_af4 }}</span><br>
                    <span>DOB :{{ $checkindata->account_birthday }}</span><br>
                    <span>Guest Age:{{ $checkindata->account_af5 }}</span><br>
                    <span>Guest Gender:{{ $checkindata->account_af6 }}</span><br>

                    <span>Add Line1:{{ $checkindata->address }}</span><br>
                    <span>Add Line2:{{ $checkindata->account->address2 }}</span><br>
                    <span>city:{{ $checkindata->city }}</span><br>
                    <span>State:{{ $checkindata->state }}</span><br>
                    <span>Mob:{{ $checkindata->guest_mobile }}</span><br>
  
                    <span>Email:{{ $checkindata->account->email }}</span><br>
                    <span>Document Name :{{ $checkindata->account->account_idproof_name }}</span><br>
                    <span>Document No :{{ $checkindata->account->account_idproof_no }}</span><br>
                    <span>2nd Guest Name :{{ $checkindata->checkinaf1 }}</span><br>
                    <span>2nd Guest id Name :{{ $checkindata->checkinaf5 }}</span><br>
                    <span>2nd Guest id No :{{ $checkindata->checkinaf6 }}</span><br>

                    <span>3rd Guest Name :{{ $checkindata->checkinaf3 }}</span><br>

                    <span>3rd Guest id Name :{{ $checkindata->checkinaf7 }}</span><br>
                    <span>3rd Guest id No :{{ $checkindata->checkinaf8 }}</span><br>
                    

           
                    
                </div>
                <div class="voucher_info">
                    <span class="heading">Check In Detail</span><br>
                    <span>Check In No : {{ $checkindata->check_in_no }}</span><br>
                    <span>CheckIn Date:{{ $checkindata->checkin_date }}</span><br>
                    <span>CheckIn Time:{{ $checkindata->checkin_time }}</span><br>
                    <span>Purpose Of Visit:{{ $checkindata->purpose_of_visit }}</span><br>
                    <span>Comming From:{{ $checkindata->comming_from }}</span><br>
                    <span>Going To :{{ $checkindata->going_to }}</span><br>
                    <span>Agent:{{ $checkindata->agent }}</span><br>
                     <span>Firm Name:{{ $checkindata->account_af1 }}</span><br>
                    <span>Firm Address:{{ $checkindata->account_af2 }}</span><br>
                    <span>Firm GST:{{ $checkindata->gst_no }}</span><br>
                    
                </div>
            </div>

        </div>



        <div class="detail">
                       
            {{-- <table class="table_detail">
                <thead>
                    
                    <tr>
                        <th class="th_detail"> Total Room</th>
                        <th class="th_detail">Room Type </th>
                        <th class="th_detail"> No of Guest </th>
                        <th class="th_detail">Commited Days</th>
                        <th class="th_detail">Tariff</th>


                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <td class="td_detail">4</td>
                      <td class="td_detail">3</td>

                        <td class="td_detail">{{ $checkindata->no_of_guest }}</td>
                        <td class="td_detail">{{ $checkindata->commited_days }}</td>
                        <td class="td_detail">{{ $checkindata->room_tariff_perday }}</td>
                    </tr>



            </table> --}}
            <div style="background-color: white">&nbsp;</div>



            {{-- <table class="table_detail">
                <thead>
                    
                    <tr>
                        <th class="th_detail">Plan</th>
                        <th class="th_detail">Booking Amount</th>
                        <th class="th_detail">Payment Refrance No</th>
                        <th class="th_detail">Refrance No </th>
                        <th class="th_detail">Agent </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="td_detail">{{ $checkindata->room->roomtype->package->package_name }}</td>
                        <td class="td_detail">{{ $checkindata->booking_amount }}</td>
                        <td class="td_detail">{{ $checkindata->voucher_payment_remark}}</td>
                        <td class="td_detail">{{ $checkindata->refrance_no}}</td>
                        <td class="td_detail">{{ $checkindata->agent }}</td>


                    </tr>

            </table> --}}




        </div>
        <div style="background-color: white" class="my-1">&nbsp;</div>

        <div class="voucher_footer">
          <div class="row">
            <img src="{{ asset('storage/app/public/account_image/' . $checkindata->account->account_id_pic) }}" alt="" width="70px">
            <img src="{{ asset('storage/app/public/account_image/' . $checkindata->account->account_pic1) }}" alt="" width="70px">

             
          </div>
          <div class="row">
            <img src="{{ asset('storage/app/public/account_image/' . $checkindata->checkinaf2) }}" alt="" width="70px">
     <img src="{{ asset('storage/app/public/account_image/' . $checkindata->checkinaf4) }}" alt="" width="70px">

          </div>
      </div>






        <div class="button-container my-2">
            <button class="btn btn-primary btn-lg" onclick="printInvoice()">Print</button>
            
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
