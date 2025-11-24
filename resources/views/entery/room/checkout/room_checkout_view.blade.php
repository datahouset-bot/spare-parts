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
        <title>Room Booking Slip </title>

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
                background-color: whitesmoke;
                width: 50%;
                /* Adjusted width to accommodate for separation */
                padding: 5px;
                box-sizing: border-box;
                text-align: left;
                font-size: 20px;
            }

            .voucher_info {
                width: 50%;
                background-color:whitesmoke;
                text-align: left;
                padding: 5px;
                font-size: 20px;

            }

            td,
            th {
                border: solid 1px;
            }

            .detail {
                background-color: silver;
                width: 100%;
                text-align: right;
            }

            .qty_total {
                text-align: center;
            }

            .table_detail {
                background-color: white;
                width: 100%;
            }

            .th_detail {
                background-color:rgb(35, 34, 34);
                color: white;
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
                background-color: rgb(233, 230, 230);
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
                background-color:rgb(233, 230, 230);
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

            <div class= "voucher_head">
                @if (!empty($componyinfo->cominfo_gst_no))
                    <div class="gst_no">GST NO: {{ $componyinfo->cominfo_gst_no }}</div>
                @endif

                <div class="bill_head">INVOICE</div>


            </div>
            <div class="company_info">
                <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" alt="qr_code"
                        width="80px"></div>
                <div class="firm_detail">
                    <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
                    <span>{{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}</span><br>
                    <span>{{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;<br>{{ $compinfofooter->country }}</span>
                    <span>Email:{{ $componyinfo->cominfo_email }} Phone &nbsp;{{ $componyinfo->cominfo_phone }}
                        Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} </span>
                </div>
<div class="logo2">
    <img src="{{ asset('storage/image/' . $pic->brand) }}" alt="qr_code" width="80px" onerror="this.style.display='none'">
</div>

            </div>


            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                        <span class="heading">Customer Detail</span><br>
                        <span>Customer Name:{{ $guest_detail->account_name }}</span><br>
                        <span>Add:{{ $guest_detail->address }}</span><br>
                        <span>city:{{ $guest_detail->_city }}</span><br>
                        <span>State:{{ $guest_detail->state }}</span><br>
                        <span>Mob:{{ $guest_detail->mobile }}</span><br>

                        <span>Email:{{ $guest_detail->email }}</span><br>
                        @if(!empty($guest_detail->gst_no))
                        <span>GST NO: {{ $guest_detail->gst_no }}</span><br>
@endif



                    </div>
                    <div class="voucher_info">
                        <span class="heading">Detail</span><br>
                        <span>Invoice No : {{ $roomcheckouts->check_out_no }}</span><br>
                        <span>Check In Date:
                            {{ \Carbon\Carbon::parse($roomcheckouts->checkin_date)->format('d-m-y') }}</span><br>

                        <span>Check In Time:{{ $roomcheckouts->checkin_time }}</span><br>
                        <span>Check Out Date:
                            {{ \Carbon\Carbon::parse($roomcheckouts->checkout_date)->format('d-m-y') }}</span><br>

                        <span>Check Out Time:{{ $roomcheckouts->check_out_time }}</span><br>
                        <span>Total Day :{{ $roomcheckouts->no_of_days }}</span><br>
                        <span>Room No :{{ $roomcheckouts->room_no }}</span><br>
                    </div>
                </div>

            </div>



            <div class="detail">
                <table class="table_detail">
                    <thead>

                        <tr>
                            <th class="th_detail">S.No </th>
                            <th class="th_detail">Particulars </th>
                            <th class="th_detail">Days </th>


                            <th class="th_detail">Amount </th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td_detail"></td>
                            <td class="td_detail">Room Rent Per Day -{{ $roomcheckouts->per_day_tariff }} </td>
                            <td class="td_detail">{{ $roomcheckouts->no_of_days }}</td>
                            <td class="td_detail">{{ $roomcheckouts->total_room_rent }}</td>

                        </tr>
                        @if (!empty($roomcheckouts->gst_total) && $roomcheckouts->gst_total > 0)
                            <tr>
                                <td class="td_detail"></td>
                                <td class="td_detail">GST % </td>
                                <td class="td_detail"></td>
                                <td class="td_detail">{{ $roomcheckouts->gst_total }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td class="td_detail"></td>
                            <td class="td_detail">Total Room Tariff</td>
                            <td class="td_detail"></td>
                            <td class="td_detail">{{ $roomcheckouts->final_room_rent }}</td>
                        </tr>
                        <tr>
                            <td class="td_detail"></td>
                            <td class="td_detail">Food Amount</td>
                            <td class="td_detail"></td>
                            <td class="td_detail">{{ $roomcheckouts->total_food_amt }}</td>
                        </tr>

                        <tr>
                            <td class="td_detail"></td>
                            <td class="td_detail">Add Other Charge </td>
                            <td class="td_detail"></td>
                            <td class="td_detail">{{ $roomcheckouts->other_charge }}</td>
                        </tr>
                        <tr>
                            <td class="td_detail"></td>
                            <td class="td_detail">Less Discount</td>
                            <td class="td_detail"></td>
                            <td class="td_detail">{{ $roomcheckouts->discount }}</td>
                        </tr>
                        <tr>
                            <td class="td_detail"></td>
                            <td class="td_detail">
                                <h4>Net Bill Amount</h4>
                            </td>
                            <td class="td_detail"></td>
                            <td class="td_detail">
                                <h4>{{ $roomcheckouts->total_billamount }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="td_detail"></td>
                            <td class="td_detail">Less Advance</td>
                            <td class="td_detail"></td>
                            <td class="td_detail">{{ $roomcheckouts->total_advance }}</td>
                        </tr>

                        <tr>
                            <td class="td_detail"></td>
                            <td class="td_detail">Net Payable Amount</td>
                            <td class="td_detail"></td>
                            <td class="td_detail">{{ $roomcheckouts->balance_to_pay }}</td>
                        </tr>



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
                    @if(!empty($compinfofooter->bank_ac_no))
    <span>Bank Name: {{ $compinfofooter->bank_name }}</span><br>
    <span>Bank A/C No: {{ $compinfofooter->bank_ac_no }}</span><br>
    <span>Bank IFSC: {{ $compinfofooter->bank_ifsc }}</span><br>
    <span>Bank Branch: {{ $compinfofooter->bank_branch }}</span><br>
@endif

                </div>
                <div class="qr_code"style="background-color:#e6ecff">
                    <span>UPI ID:{{ $compinfofooter->upiid }}</span><br>
                    &nbsp;
                        <img src="{{ asset('storage\app\public\image\\' . $pic->qrcode) }}" alt="qr_code"
                            width="80px " onerror="this.style.display='none'">
                        {{-- <img src="/storage/image/qr.jpeg" alt="qr_code" width="80px">  this is abal to print image --}}


                </div>
                <div class="comp_sign"style="background-color:#e6ecff">

                    &nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->seal) }}"  width="80px" onerror="this.style.display='none'">
                </div>





            </div>






            <div class="button-container my-2">
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
