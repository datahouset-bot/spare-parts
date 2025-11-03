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
        <title>Room Check Out Invoice </title>

        <style>
            @page {
                size: auto;
                margin: 0;
            }

            body {
                margin: 0;

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

            .cust_info {
                background-color: aquamarine;
                width: 50%;
                /* Adjusted width to accommodate for separation */
                padding: 5px;
                box-sizing: border-box;
                text-align: left;
            }

            .item {
                padding: 30px;
                margin-left: 10ch;
                text-align: center;
                border: 1px solid;

            }

            .table_hader td {
                border: 1px solid;

            }


            .voucher_info {
                width: 50%;
                background-color: gold;
                text-align: left;
                padding: 5px;
                font-size: 15px;

            }

            .row1 {
                width: 100%
            }

            .tfooter_amount {
                text-align: left;


            }

            .row1 td {
                border: solid 1px;

            }


            td,
            th {
                border: solid 1px;
            }

            .detail {
                background-color: white;
                width: 100%;
                text-align: right;
            }

            .qty_total {
                text-align: center;
            }

            .table_detail {
                background-color: white;
                width: 100%;
                padding: 5px;
            }

            .table_hader {
                background-color: white;
                width: 100%;
                padding: 5px;
            }

            .table_footer {
                background-color: white;
                width: 100%;
                padding: 5px;
            }

            .table_hader td {
                border: 0px;
            }

            .table_footer td {
                border: 0px;
            }



            .th_detail {
                background-color: white;
                border: 1px solid;
                text-align: center;
                padding: 5px;
            }

            .td_detail {
                background-color: white;
                text-align: center;
                border: 1px solid;
                padding: 5px;
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

            .company_info {
                background-color: yellow;
                display: grid;
                grid-template-columns: 1fr 2fr 2fr;
                border: 1px solid black;
                margin-bottom: 0px;
                text-align: left;
            }

            .logo1 {}

            .firm_detail {
                text-align: left;

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



                button {
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
                    padding: 20px;
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

            {{-- <div class= "voucher_head">
                <div class= "gst_no"> GST NO:{{ $componyinfo->cominfo_gst_no }}</div>
                <div class="bill_head">INVOICE</div>


            </div> --}}
            <div class="company_info">
                <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" alt="qr_code"
                        width="80px"></div>
                <div class="firm_detail">
                    <h4>{{ $componyinfo->cominfo_firm_name }}</h4>

                </div>
                <div class="firm_detail">
                    <span>{{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}</span><br>
                    <span>{{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;<br>{{ $compinfofooter->country }}</span>
                    <span>Email:{{ $componyinfo->cominfo_email }} Phone &nbsp;{{ $componyinfo->cominfo_phone }}
                        Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} &nbsp;@if (!empty($componyinfo->cominfo_gst_no))
                            <h5>GST NO :&nbsp;{{ $componyinfo->cominfo_gst_no }}</h5>
                        @endif
                    </span>
                </div>

            </div>

            <div class="detail">
                <table class="table_detail">
                    <thead>
                        <tr>
                            <td>G.R.C.No:{{ $roomcheckouts->checkin_voucher_no }}</td>
                            <td>Bill No: {{ $roomcheckouts->check_out_no }} </td>
                            <td>Bill Date: {{ \Carbon\Carbon::parse($roomcheckouts->checkout_date)->format('d-m-y') }}
                            </td>
                        </tr>

                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <table class="table_detail">
                    <thead>
                        <tr>
                            <td>Room No</td>
                            <td>Guest Name </td>
                            <td>Room Tariff</td>
                            <td>Room Type-</td>
                            <td>Nationality</td>

                        </tr>


                    </thead>
                    <tbody>
                        <td>{{ $roomcheckouts->room_no }}</td>
                        <td>{{ $roomcheckouts->guest_name }}</td>
                        <td>{{ $roomcheckouts->per_day_tariff }}</td>
                        <td>{{ $roomcheckins->room->roomtype->roomtype_name }}</td>
                        <td>{{ $roomcheckouts->account->nationality }}</td>

                    </tbody>
                </table>
                <table class="table_detail">
                    <thead>
                        <tr>
                            <td>Address</td>
                            <td>Arrival Date & Time </td>
                            <td>Departure Date And Time </td>


                        </tr>


                    </thead>
                    <tbody>
                        <td>{{ $guest_detail->address }}&nbsp;{{ $guest_detail->_city }} &nbsp;{{ $guest_detail->state }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($roomcheckouts->checkin_date)->format('d-m-y') }}
                            &nbsp; {{ $roomcheckouts->checkin_time }}</td>
                        <td>{{ \Carbon\Carbon::parse($roomcheckouts->checkout_date)->format('d-m-y') }}
                            &nbsp;{{ $roomcheckouts->check_out_time }}</td>


                    </tbody>
                </table>
                <table class="table_detail">
                    <thead>
                        <tr>
                            <td>Company GSTIN NO</td>
                            <td> Mobile</td>
                            <td>Email</td>
                            <td>Plan & Package </td>



                        </tr>


                    </thead>
                    <tbody>
                        <td>{{ $guest_detail->gst_no }}</td>
                        <td> {{ $guest_detail->mobile }}</td>
                        <td>{{ $guest_detail->email }}</td>
                        <td>{{ $roomcheckins->package->package_name }}||
                            &nbsp;{{ $roomcheckins->package->plan_name }}||&nbsp;{{ $roomcheckins->package->other_name }}
                        </td>


                    </tbody>
                </table>
            </div>




            <div class="detail">
                <table class="table_hader">
                    <thead>

                        <tr>
                            <th class="th_detail">Date</th>
                            <th class="th_detail">SAC Code</th>
                            <th class="th_detail">Description </th>
                            <th class="th_detail">Per Day Charge </th>




                        </tr>
                    </thead>
                    <tbody>

                        @for ($i = 0; $i < $totaldays; $i++)
                            @php

                                $checkindate = \Carbon\Carbon::parse($roomcheckouts->checkin_date)
                                    ->addDays($i)
                                    ->format('Y-m-d');

                                $roomTariff = $roomcheckouts->per_day_tariff;
                                //  $foodBill = $foodBills->get($checkindate)->total_amount ?? 0;
                                //  $totalForDay = $roomTariff + $foodBill;
                            @endphp

                            <tr class="item">

                                <td>{{ \Carbon\Carbon::parse($checkindate)->format('d-m-y') }}
                                </td>
                                <td>996311</td>
                                <td>Room Charge</td>
                                <td>{{ $roomTariff }}</td>
                                {{-- <td>{{$foodBill}}</td> --}}
                                {{-- <td>{{ number_format($totalForDay, 2) }}</td> --}}


                            </tr>
                        @endfor




                </table>

                <hr>
                <table class="table_footer">
                    <thead>
                        <tr>
                            <td style="width: 25%"></td>
                            <td style="width: 35%"></td>
                            <td style="width: 25%"></td>
                            <td style="width: 15%"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">Total Room Tariff</td>
                            <td class="tfooter_amount">{{ $roomcheckouts->total_room_rent }}</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">SGST</td>
                            <td class="tfooter_amount">{{ $roomcheckouts->sgst }}</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">CGST</td>
                            <td class="tfooter_amount">{{ $roomcheckouts->cgst }}</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">IGST</td>
                            <td class="tfooter_amount">{{ $roomcheckouts->igst }}

                            </td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">Add Other Charge</td>
                            <td class="tfooter_amount">{{ $roomcheckouts->other_charge }}</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">Total Food Amount</td>
                            <td class="tfooter_amount">{{ $roomcheckouts->total_food_amt }}</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">Less Discount</td>
                            <td class="">{{ $roomcheckouts->discount }}</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">
                                Net Bill Amount
                            </td>
                            <td class="tfooter_amount">
                                {{ $roomcheckouts->total_billamount }}
                            </td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">Less Advance</td>
                            <td class="tfooter_amount">{{ $roomcheckouts->total_advance }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="">
                                <h5>Net Payable Amount</h5>
                            </td>
                            <td class="tfooter_amount">
                                <h5>{{ $roomcheckouts->balance_to_pay }}</h5>
                            </td>

                        </tr>
                    </tbody>
                </table>



            </div>
            <div style="background-color: white" class="my-1">&nbsp;</div>

            <div class="voucher_footer">
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
                    &nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->qrcode) }}" alt="qr_code"
                        width="80px">
                    {{-- <img src="/storage/image/qr.jpeg" alt="qr_code" width="80px">  this is abal to print image --}}


                </div>
                <div class="comp_sign"style="background-color:#e6ecff">

                    &nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->seal) }}" alt="qr_code" width="80px">
                </div>





            </div>






            <div class="button-container my-2">
                <a href="{{ url('roomcheckouts') }}" class="btn  btn-danger btn-lg"><i class="fa fa-home"
                        style="font-size:36px"></i></a>
                <button class="btn btn-dark btn-lg mx-2" onclick="printInvoice()">Print</button>
                <a href="{{ url('room_checkout_view2', $roomcheckouts->voucher_no) }}"
                    class="btn  btn-primary btn-lg">Format 2</a>
                <a href="{{ url('room_checkout_view3', $roomcheckouts->voucher_no) }}"
                    class="btn  btn-success btn-lg mx-2">Format 3</a>
                <a href="{{ url('room_checkout_view4', $roomcheckouts->voucher_no) }}"
                    class="btn  btn-warning btn-lg mx-2">Format 4(A5)</a>

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
