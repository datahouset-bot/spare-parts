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
        <title>Invoice</title>
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
                background-color:whitesmoke;
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
                 border: 1px dashed green;
                 font-size: 20px;
            }
                               
            .cust_info {
                background-color:whitesmoke;
                font-size: 20px;
                width: 50%;
                /* Adjusted width to accommodate for separation */
                padding: 5px;
                box-sizing: border-box;
                text-align: left;
            }

            .voucher_info {
                width: 50%;
                background-color:whitesmoke;
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
                color: white;
                background-color:rgb(58, 58, 58);
                border: none;
                text-align: center;
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
                background-color:white;
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
                background-color:rgb(224, 221, 221);
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
    background-color: bisque;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-auto-rows: auto;     /* AUTO HEIGHT */
    border: 1px solid black;
}


          .terms {
    grid-column: 1 / 3;
    min-height: 100px;        /* initial height */
    height: auto;             /* AUTO GROW */
    padding: 6px;
    text-align: left;
    overflow: visible;        /* allow expansion */
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
            .terms ol {
    margin: 4px 0;
}

.terms li {
    margin-bottom: 2px;
}

        </style>






    </head>

    <body>

        <div class="page">

            <div class="company_info">
                <div class="logo1">&nbsp;<img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" alt="qr_code" width="90%">
                </div>
                <div class="firm_detail">
                    <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
                        {{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}&nbsp;
                    {{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;{{ $compinfofooter->country }}&nbsp;
                   Email:{{ $componyinfo->cominfo_email }} Phone &nbsp;{{ $componyinfo->cominfo_phone }}
                        Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} 
                 
                </div>
                {{-- <div class="logo2"><img src="{{ asset('storage\app\public\image\\' . $pic->brand) }}" alt="qr_code" width="80px">
                </div> --}}
            </div>
            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                        @if(isset($salebill_header->account->account_name))
                        <span> Name: {{ $salebill_header->account->account_name }}</span><br>
                    @else
                        <span> Name: No record</span><br>
                    @endif
                @if(isset($salebill_header->account->address))
                    <span> address: {{ $salebill_header->account->address }}</span><br>
                @else
                    <span> address: No record</span><br>
                @endif
                @if(isset($salebill_header->account->city))
                <span> city: {{ $salebill_header->account->city }}</span><br>
            @else
                <span> city: No record</span><br>
            @endif
                    
                    


                       {{-- <span>Mobile No:{{ $salebill_header->account->mobile }}</span><br> --}}
                       <span>GSTIN  No:{{ $salebill_header->account->gst_no }}</span><br>
                      
                    </div>
                    <div class="voucher_info">

                        <span>Invoice  No    :{{ $salebill_header->voucher_bill_no }}</span><br>
                        <span>Date : {{ $salebill_header->voucher_date }}</span><br>
                        <span>Time : {{ $salebill_header->created_at->format('H:i') }}</span><br>
                         <span>Oprater : {{ $salebill_header->user_name }}</span><br>

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
                        @foreach ($salebill_items as $records )
                        <tr>
                            <td>{{$sno=$sno+1}}</td>
                          <td>{{$records->item_name}}</td>
                           <td>{{ number_format($records->qty, 0) }}</td>
                          <td>{{ number_format($records->rate,1)}}</td>
                          <td>{{ number_format($records->gst_item_percent,1)}}</td>

                          <td>{{ number_format($records->item_basic_amount,1)}}</td>  
                        </tr>
                            
                        @endforeach
  
                </table>





            </div>
            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                       
                        <span>Total Item ={{$sno}}</span><br>
                        <span>Total Qty ={{$salebill_header->total_qty}}</span><br>
                       
                    </div>
                    <div class="voucher_info">
                        <table id="footer_total">
                            <tr>
                                <td>Basic Amt:</td>
                                <td>{{ $salebill_header->total_item_basic_amount }}</td>
                            </tr>
                            <tr>
                                <td>Dis Total  </td>
                                <td>{{ $salebill_header->total_disc_item_amount }}</td>
                            </tr>

                            <tr>
                                <td>SGST Amt:</td>
                                <td>{{ $salebill_header->total_gst_amount / 2 }}</td>
                            </tr>
                            
                            <tr>
                                <td>CGST Amt:</td>
                                <td>{{ $salebill_header->total_gst_amount / 2 }}</td>
                            </tr>
                            
                            <tr>
                                <td>Round Off:</td>
                                <td>{{ $salebill_header->total_roundoff }}</td>
                            </tr>
                            <tr>
                                <td>Grand Total :</td>
                                <td><h3>{{ $salebill_header->total_net_amount }}</h3></td>
                            </tr>
                        </table>


                    </div>
                </div>

            </div>
            <div style="background-color: white" class="my-1">&nbsp;</div>
            <div class="voucher_footer">
                <div class="terms" style="background-color:#e6ecff">
    <h5>Terms & Conditions</h5>

    @if(!empty($compinfofooter->terms))
        @php
            $terms = array_filter(array_map('trim', explode("\n", $compinfofooter->terms)));
        @endphp

        <ol style="padding-left:18px; font-size:13px; text-align:left;">
            @foreach($terms as $term)
                <li>{{ $term }}</li>
            @endforeach
        </ol>
    @endif
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
                    <span>Bank id:{{ $compinfofooter->upiid }}</span><br>
                    &nbsp;<img src="/storage/image/{{ $pic->qrcode }}" alt="qr_code" width="80px">
                </div>
                <div class="comp_sign"style="background-color:#e6ecff">

                    &nbsp;<img src="{{ asset('storage/image/' . $pic->seal) }}" alt="qr_code" width="80px">
                </div>
            </div>
            <div class="button-container my-2">
                <button class="btn btn-success btn-lg" onclick="window.print()">Print</button>
            </div>
        </div>
    </body>

    </html>
@endsection
