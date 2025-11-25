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
                background-color:white;
                width: 50%;
                /* Adjusted width to accommodate for separation */
                padding: 5px;
                box-sizing: border-box;
                text-align: left;
                font-size: 20px;
            }

            .voucher_info {
                width: 50%;
                background-color: white;
                text-align: left;
                padding: 5px;
                 font-size: 20px;
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
                background-color:rgb(22, 21, 21);
                color: white;
                border: none;
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
                background-color: rgb(196, 196, 191);
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
                background-color:rgb(158, 155, 155);
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
                background-color:white;
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
                    @if(!empty($componyinfo->cominfo_gst_no))
    <h6>GST No: {{ $componyinfo->cominfo_gst_no }}</h6>
@endif
                    <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
{{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}&nbsp;
                    {{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;{{ $compinfofooter->country }}&nbsp;
                   Email:{{ $componyinfo->cominfo_email }} <br>Phone &nbsp;{{ $componyinfo->cominfo_phone }},&nbsp;
                        Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} 
                </div>
                <div class="logo2"><img src="{{ asset('storage\app\public\image\\' . $pic->qrcode) }}" alt="qr_code"
                        width="80px">
               
                </div>
            </div>
            <div class="header_info">
                     
                 
            </div>


            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                        <span class="heading">Customer Detail</span><br>
                        <span>Invoice No:{{$guest_detail->voucher_no}}</span><br>
                    <span>Invoice Date:{{ $guest_detail->checkin_date}}</span><br>
                        @if(isset($guest_detail->guest_name))
                        <span>Billed To: {{ $guest_detail->guest_name }}</span><br>
                    @else
                        <span>Guest Name: No record</span><br>
                    @endif
                      <span>Mobile no:{{ $guest_detail->phone }}</span><br>
                    <span>Delivery Address:{{ $guest_detail->address}}</span><br>
                    @if(isset($guest_detail->room_nos))
                        <span>policy No: {{ $guest_detail->room_nos }}</span><br>
                    @else
                        <span>policy No: No record</span><br>
                    @endif
                     <span>Policy No:{{ $guest_detail->accout_group_id}}</span><br>
                    <span>Campaign Name:{{ $guest_detail->state}}</span><br>
                     <span>Effective from:{{ $guest_detail->email}}</span><br>
                    <span>Effective to:{{ $guest_detail->email}}</span><br>
                   
                    

{{-- 
                       <span>Name:{{ $guest_detail->guest_name }}</span><br>
                       <span>Mobile No:{{ $guest_detail->guest_mobile }}</span><br>
                       <span>Room No:{{ $guest_detail->room_nos }}</span><br>
                       <span>Check In No   :{{ $guest_detail->voucher_no }}</span><br> --}}
                    </div>
                    <div class="voucher_info">
                         <span>Jobcard  No:{{ $foodbill_header->user_id}}</span><br>
                        <span> Jobcard Date: {{ \Carbon\Carbon::parse($guest_detail->checkin_date)->format('d-m-y') }}   
                        </span><br>
                        <span>Invoice  type:{{ $foodbill_header->voucher_no}}</span><br>
                        <span>Payment type:{{ $foodbill_header->user_name}}</span><br>
                    <span>Refrence No:{{ $foodbill_header->food_bill_no}}</span><br>
                    <span>Repair type:{{ $foodbill_header->voucher_type}}</span><br>
                    <span>kM Reading:{{ $foodbill_header->kot_no}}</span><br>
                    <span>Date of sale:{{ $foodbill_header->voucher_date}}</span><br>
                    
                    <span>Registration No :{{$foodbill_header->service_id}} </span><br>
                    <span>Chassis  No:{{$guest_detail->room_Id}}</span><br>
                    <span>Engine No:{{ $guest_detail->business_source_Id}}</span><br>
                    <span>Model name:{{ $foodbill_header->user_name }}</span><br>
                     <span>Model year:{{$guest_detail->no_of_guest}}</span><br>

                        {{-- <span>Invoice No : {{ $foodbill_header->food_bill_no }}</span><br>
                        <span>Date : {{ $foodbill_header->voucher_date }}</span><br>
                        <span>Time : {{ $foodbill_header->created_at->format('H:i') }}</span><br> --}}
                    </div>
                </div>

            </div>



            <div class="detail">



                <table class="table_detail">
                    <thead>

                        <tr>
                            <th class="th_detail">S.no</th>
                            <th class="th_detail">parts code</th>
                            <th class="th_detail">parts Name</th>
                            <th class="th_detail">UOM</th>
                            <th class="th_detail">Qty</th>
                            <th class="th_detail">Rate</th>
                            <th class="th_detail">TAXABLE AMOUNT</th>
                            <th class="th_detail">TD AMOUNT</th>
                            <th class="th_detail">SGST/UTGST</th>
                            <th class="th_detail">GGST%</th>
                            <th class="th_detail">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $sno=0;
                        @endphp
                        @foreach ($foodbill_items as $records )
                        <tr style="font-size: 20px">
                            <td>{{$sno=$sno+1}}</td>
                            <td>{{$records->item_id}}</td>
                            <td>{{$records->item_name}}</td>
                            <td>{{$records->voucher_type}}</td>
                            <td>{{ number_format($records->qty, 0) }}</td>
                            <td>{{ number_format($records->rate,1)}}</td>
                            <td>{{ number_format($records->total_sgst,1)}}</td>
                            <td>{{ number_format($records->gst_item_percent,1)}}</td>
                            <td>{{ number_format($records->total_cgst,1)}}</td>
                            <td>{{ number_format($records->total_gst_amount,1)}}</td>
                            <td>{{ number_format($records->item_base_amount,1)}}</td>  
                        </tr>
                            
                        @endforeach
  
                </table>





            </div>
            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                       
                        <span>Total Item ={{$foodbill_header->total_item}}</span><br>
                        <span>Total Qty ={{$foodbill_header->total_qty}}</span><br>
                        <span>Kot Number ={{$foodbill_header->rate}}</span><br>
                       
                    </div>
                    <div class="voucher_info">
                        <table id="footer_total" style="font-size: 20px">
                            <tr>
                                <td>Basic Amt:</td>
                                <td>{{ $foodbill_header->total_base_amount }}</td>
                            </tr>
                           @if(!is_null($foodbill_header->cash_discount) && $foodbill_header->cash_discount != 0)
                            <tr>
                                <td>Dis {{ $foodbill_header->disc_percent}}% :</td>
                                <td>{{ $foodbill_header->cash_discount }}</td>                            </tr>
                            @endif
                        

                            @if(!is_null($foodbill_header->total_sgst) && $foodbill_header->total_sgst != 0)
                            <tr>
                                <td>SGST Amt:</td>
                                <td>{{ $foodbill_header->total_sgst }}</td>
                            </tr>
                            @endif
                            @if(!is_null($foodbill_header->total_cgst) && $foodbill_header->total_cgst != 0)
                            <tr>
                                <td>CGST Amt:</td>
                                <td>{{ $foodbill_header->total_cgst }}</td>
                            </tr>
                            @endif
                        
                           
                            @if(!is_null($foodbill_header->total_vat) && $foodbill_header->total_vat != 0)
                            <tr>
                                <td>Vat Amt:</td>
                                <td>{{ $foodbill_header->total_vat }}</td>
                            </tr>
                           
                        
                            <tr>
                                <td>Sur Amt:</td>
                                <td>{{ $foodbill_header->total_tax1 }}</td>
                            </tr>
                             @endif

                            <tr>
                                <td>Round Off:</td>
                                <td>{{ $foodbill_header->total_taxable_amount }}</td>
                            </tr>
                            <tr>
                                <td>Grand Total :</td>
                                <td><h3>{{ $foodbill_header->net_food_bill_amount }}</h3></td>
                            </tr>
                        </table>


                    </div>
                </div>

            </div>



            <div style="background-color: white" class="my-1">&nbsp;</div>

            {{-- <div class="voucher_footer">
                <div class="terms "style="background-color:#e6ecff">
                    <h5>Terms & Conditions</h5>
                    <span>{{ $compinfofooter->terms }}</span>
                </div>
                <div class="for_companyname"style="background-color:#e6ecff"><span>For
                        {{ $componyinfo->cominfo_firm_name }}</span><br></div>
                <div class="bank_detail"style="background-color:#e6ecff">
                    <span>Bank Name:{{ $compinfofooter->bank_name }}</span><br>
                    <span>Bank A/C No :{{ $compinfofooter->bank_ac_no }}</span><br>
                    <span>Bank IFSC:{{ $compinfofooter->bank_ifsc }}</span><br>
                    <span>Bank Branch:{{ $compinfofooter->bank_branch }}</span><br>
                </div>
                <div class="qr_code"style="background-color:#e6ecff">
                    <span>Bank Name:{{ $compinfofooter->upiid }}</span><br>
                    &nbsp;<img src="/storage/image/{{ $pic->qrcode }}" alt="qr_code" width="80px">
                    


                </div>
                <div class="comp_sign"style="background-color:#e6ecff">

                    &nbsp;<img src="{{ asset('storage/image/' . $pic->seal) }}" alt="qr_code" width="80px">
                </div>





            </div> --}}






            <div class="button-container my-2">
                <button class="btn btn-success btn-lg" onclick="printInvoice()">Print</button>
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
