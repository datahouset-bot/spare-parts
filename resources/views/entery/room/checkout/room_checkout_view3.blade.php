@php
    include public_path('cdn/cdn.blade.php');
@endphp
{{-- <link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}"> --}}

{{-- @extends('layouts.blank') --}}
{{-- @section('pagecontent') --}}
<meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ $compinfofooter->ct2 }} Management</title>
        <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
{{--         
        <link href="/admin_assets/css/styles.css" rel="stylesheet" /> --}}
        <link rel="stylesheet" href="{{global_asset('/admin_assets/css/styles.css') }}"  />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Room Booking Slip </title>
       
        <style>
            @page {
                size: auto;
                margin: 1cm;
                border: solid 1px;
            }

            body {
                margin: 15px;


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
            .font8{
                font-size: small;
                font-weight: 600;
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
            .bank_detail{
    border-top: solid 1px;
    text-align: center;
    font-size: small;
    font-weight: 600;
    color:black;
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

            .voucher_info {
                width: 50%;
                background-color: gold;
                text-align: left;
                margin-left: 460px;
                padding: 5px;
                font-size: 15px;

            }


            th ,.item_record{
                border: solid 1px;
text-align: center;

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
                background-color: white;
                /* border: 1px solid; */
                text-align: center;
            }

            .td_detail {
                background-color: white;
                text-align: center;
                /* border: 1px solid; */
            }
            .td_total{
                text-align: left;
            }

            .row1 {
                display: inline;
            }

            .button-container {
                display: flex;
                justify-content: center;
                align-items: center;

            }
            .guest_detail_table{
             border: 0px !important;

             
            }
            .invno_and_date{
                padding: 0%;
                margin: 0px;
                border-top: solid 1px;
                border-bottom: solid 1px;

                margin-left: 7px;
                display: grid;
                grid-template-columns: 2fr 1fr ;
            }
            .paty_bill_head{
                                padding: 0%;
                margin: 0px;
                border-top: solid 1px;
                border-bottom: solid 1px;

                margin-left: 7px;
                display: grid;
                grid-template-columns: 2fr 1fr ;
            }

            .voucher_head {

                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                
                text-align: center;
                

            }

            .gst_no {
                font-size: medium;
                font-weight: 800;
                margin-left: 10px;
                font-style: bold;
                text-align: left;
            }
                       .party_gst_no {
                font-size: small;
                font-weight: 700;
                font-style: bold;
                text-align: left;
            }


            .bill_head {
                margin-left: 0%;
                font-size: large;
                text-align: center;
                font-weight: 800;
            }
            .bill_mobile{
                align-content: right;
            }

            .company_info {
                background-color: yellow;
                display: grid;
                grid-template-columns: 1fr 4fr 1fr;
                border: 1px solid black;
                margin-bottom: 0px;
            }


            .logo1 {
                padding: 5px;

            }

            .firm_detail {
                text-align: center;

            }

            .logo2 {
                align-content: :flex-end;
                padding:5px;

            }

            .voucher_footer {
                background-color: yellow;
                display: grid;
                grid-template-columns: 2fr 1fr ;
                border-top: 1px solid black;
                margin-bottom: 0px;
            }
            .last_footerline {
                background-color: yellow;
                display: grid;
                grid-template-columns: 2fr 1fr 1fr;
                border-bottom: 1px solid;
                border-right: 1px solid;
                margin-bottom: 0px;
  
            }
            .tax_summery td{
                padding: 5px !important;
                margin: 0 !important;
                text-align: center;
                border: solid 1px;
            }

            .tax_detail {

                height: 100px;
                text-align: center;
            }

            .terms_condition {
                text-align: left;
                height: 120px;
                border-top: 1px solid;
                padding: 1px;
                font-size: 15px;
            }

            .comp_sign {

                border-left: 1px solid;
                border-top: 1px solid;
                text-align: center;

               padding: 5px;

            }


            .qr_code {
    border-left: 1px solid;
    border-top: 1px solid;
    text-align: center; /* Align text to the right */
    position: relative; /* Enable positioning within the element */
}

.qr_code p {
    position: absolute;
    bottom: 0; /* Align the text to the bottom */
    right: 20; /* Align the text to the right */
    margin: 0; /* Remove default margin */
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

                /* td,
                th {
                    border: solid 1px;
                } */



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
                <div class= "gst_no"> GST NO:{{ $componyinfo->cominfo_gst_no }}</div>
                <div class="bill_head"> TAX INVOICE</div>
                <div class="bill_head">Invoice Date:{{ \Carbon\Carbon::parse($roomcheckouts->checkout_date)->format('d-m-Y') }}</div>


            </div>
            <div class="company_info">
                <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" alt="qr_code"
                        width="100px"></div>
                <div class="firm_detail">
                    <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
                    <span>{{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}</span><br>
                    <span>{{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;{{ $compinfofooter->country }}</span>
                    <span>Email:{{ $componyinfo->cominfo_email }} <br>Phone &nbsp;{{ $componyinfo->cominfo_phone }}
                        Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} website&nbsp;{{ $componyinfo->cominfo_field2 }}</span>
                </div>
                <div class="logo2"><img src="{{ asset('storage\app\public\image\\' . $pic->brand) }}" alt="qr_code"
                        width="100px"></div>
            </div>

                            {{-- <div class="firm_detail">
                    <span>{{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}</span>
                    <span>{{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;{{ $compinfofooter->country }}</span>
            
                </div> --}}
                <div class="invno_and_date">
                    <div>Invoice No:{{ $roomcheckouts->check_out_no }}</div>
                    <div>Invoice Date:{{ \Carbon\Carbon::parse($roomcheckouts->checkout_date)->format('d-m-Y') }}</div>
                </div>
                <div class="paty_bill_head">

                    
                    

                        <table class="guest_detail_table">
                            <thead>
                                <tr>
                                    <td width="20%"></td>
                                    <td width="2%"></td>
                                    <td width="70%"></td>
        
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room No </td>
                                    <td>:</td>
                                    <td>{{ $roomcheckouts->room_no }}</td>
                                </tr>
                                <tr>
                                    <td>Guest Name </td>
                                    <td>:</td>
                                    <td>{{ $guest_detail->account_name }}</td>
                                </tr>
                                <tr>
                                    <td>Company</td>
                                    <td>:</td>
                                    <td>{{ $guest_detail->account_af1 }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>{{ $guest_detail->address }}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>:</td>
                                    <td>{{ $guest_detail->city }}</td>
                                </tr>

                                <tr>
                                    <td>State</td>
                                    <td>:</td>
                                    <td>{{ $guest_detail->state }}</td>
                                </tr>

                                <tr>
                                    <td>Mobile</td>
                                    <td>:</td>
                                    <td>{{ $guest_detail->Mobile }}</td>
                                </tr>

                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $guest_detail->email }}</td>
                                </tr>
                                <tr>
                                    <td class="party_gst_no">Party'S GSTIN</td>
                                    <td>:</td>
                                    <td>{{ $guest_detail->gst_no  }}</td>
                                </tr>



                            </tbody>
    
                        </table>




                    <div >
                        
                        <table>
                            <thead>
                                <tr>
                                    <td width="60%"></td>
                                    <td width="10%"></td>
                                    <td width="30%"></td>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Arrival Date</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($roomcheckouts->checkin_date)->format('d-m-y') }}</td>
                                </tr>
                                <tr>
                                    <td>Arrival Time</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($roomcheckouts->checkin_time)->format('g:i A') }}</td>
                                </tr>
                                <tr>
                                    <td>Departure Date</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($roomcheckouts->checkout_date)->format('d-m-y') }}</td>
                                </tr>
                                <tr>
                                    <td>Departure Time</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($roomcheckouts->check_out_time)->format('g:i A') }}</td>
                                </tr>

                            </tbody>

                                
                            
                        </table>


                    </div>
                </div>

            


            <div class="detail">
                <table class="table_detail">
                    <thead>

                        <tr>
                            <th class="th_detail">S.No </th>
                            <th class="th_detail">Particulars </th>
                            <th class="th_detail">Days </th>
                            <th class="th_detail">Rate </th>
                            <th class="th_detail">GST </th>
                            <th class="th_detail">Amount </th>




                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="item_record">1</td>
                            <td class="item_record">{{$roomcheckins->room->roomtype->roomtype_name}}</td>
                            <td class="item_record">{{ $roomcheckouts->no_of_days }}</td>
                            <td class="item_record">{{ $roomcheckouts->per_day_tariff }}</td>
                            <td class="item_record">{{ $roomcheckouts->gst_id }}%</td>
                            <td class="item_record">{{ $roomcheckouts->total_room_rent }}</td>

                        </tr>





                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2" class="td_total">SGST </td>
                            <td class="td_detail">{{ $roomcheckouts->sgst }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2" class="td_total">CGST </td>
                            <td class="td_detail">{{ $roomcheckouts->cgst }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2" class="td_total">IGST </td>
                            <td class="td_detail">{{ $roomcheckouts->igst }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2"` class="td_total">Food Amount</td>
                            <td class="td_detail">{{ $roomcheckouts->total_food_amt }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2"` class="td_total">Add Other Charge </td>
                            <td class="td_detail">{{ $roomcheckouts->other_charge }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2"` class="td_total">Less Discount</td>
                            <td class="td_detail">{{ $roomcheckouts->discount }}</td>
                        </tr>
                        <tr>


                            <td colspan="3"></td>
                            <td colspan="2"` class="td_total">
                                Net Bill Amount
                            </td>
                            <td class="td_detail">
                                {{ $roomcheckouts->total_billamount }}
                            </td>
                        </tr>
                        <tr>

                            <td colspan="3"></td>
                            <td colspan="2" class ="td_total">Less Advance</td>
                            <td class="td_detail">{{ $roomcheckouts->total_advance }}</td>
                        </tr>

                        <tr>

                            <td colspan="3"></td>

                            <td colspan="2" class ="td_total"><h5>Net Payeble Amount</h5></td>
                            <td class="td_detail"><h5>{{ $roomcheckouts->balance_to_pay }}</h5></td>
                        </tr>



                </table>


            </div>
            <div class="bank_detail">Bank Name:{{ $compinfofooter->bank_name }}
                Bank A/C No :{{ $compinfofooter->bank_ac_no }}
                Bank IFSC:{{ $compinfofooter->bank_ifsc }}
                Bank Branch:{{ $compinfofooter->bank_branch }}
</div>


            <div class="voucher_footer">
  
                <div class="tax_detail "style="background-color:white">
 
                    <table class="table table-striped tax_summery table-resposive">
                        <thead>
                            <tr>
                                <th>SAC Code</th>
                                <th>Taxable Amount</th>
                                <th>GST%</th>
                                <th>SGST</th>
                                <th>CGST</th>
                                <th>IGST</th>
                                <th>Total Tax</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>996311</td>
                            <td>{{$roomcheckouts->total_room_rent}}</td>
                            <td>{{ $roomcheckouts->gst_id }}</td>
                            <td>{{$roomcheckouts->sgst}}</td>
                            <td>{{$roomcheckouts->cgst}}</td>
                            <td>{{$roomcheckouts->igst}}</td>
                            <td>{{$roomcheckouts->gst_total}}</td>
                            </tr>
                            
                                
                        </tbody>
                    </table>

                </div>
                <div class="for_companyname"style="background-color:white"><span>For
                        {{ $componyinfo->cominfo_firm_name }}</span><br>
                </div>




            </div>
            <div class="last_footerline">

                <div class="terms_condition"style="background-color:white">
                    {{ $compinfofooter->terms }}             
                </div>
                <div class="qr_code"style="background-color:white">
                    <p>Receiver's Signature</p>



                </div>
                <div class="comp_sign"style="background-color:white">

                    &nbsp;&nbsp;&nbsp;&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->seal) }}" alt="qr_code" width="100px">
                </div> 


            </div>






            <div class="button-container my-2">
                <a href="{{ url('roomcheckouts') }}" class="btn  btn-dark btn-lg" ><i class="fa fa-home" style="font-size:36px"></i></a>
                <button class="btn btn-primary btn-lg mx-2" onclick="printInvoice()">Print</button>
                <a href="{{ url('room_checkout_view', $roomcheckouts->voucher_no) }}" class="btn  btn-primary btn-lg" >Format 2</a>
                <a href="{{ url('room_checkout_view3', $roomcheckouts->voucher_no) }}" class="btn  btn-primary btn-lg mx-2" >Format 3</a>

            </div>



        </div>

        <script>
            function printInvoice() {
                window.print();
            }
        </script>


    </body>

    </html>
{{-- @endsection --}}
