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

            .voucher_info {
                width: 50%;
                background-color: gold;
                text-align: left;
                padding: 5px;
                font-size: 15px;

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
                <div class="bill_head">Service parts Bill</div><br>
                {{ $componyinfo->cominfo_firm_name }}
            </div>

            {{-- <div class="company_info">
                <div class="logo1">&nbsp;<img src="{{ asset('storage/image/' . $pic->logo) }}" alt="qr_code" width="80px">
                </div>
                <div class="firm_detail">
                    <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
                    <span>{{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}</span><br>
                    <span>{{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;<br>{{ $compinfofooter->country }}</span>
                    <span>Email:{{ $componyinfo->cominfo_email }} Phone &nbsp;{{ $componyinfo->cominfo_phone }}
                        Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} </span>
                </div>
                <div class="logo2"><img src="{{ asset('storage/image/' . $pic->brand) }}" alt="qr_code" width="80px">
                </div>
            </div> --}}


            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                        <span class="heading">Customer Detail</span><br>
                        @if(isset($guest_detail->guest_name))
    <span>Customer Name: {{ $guest_detail->guest_name }}</span><br>
@else
    <span></span><br>
@endif

@if(isset($guest_detail->room_nos))
    <span>Vehicle slot No: {{ $guest_detail->room_nos }}</span><br>
@else
    <span>Vehicle No :&nbsp;{{$table_name}} </span><br>
@endif
@if(isset($kot_header->kot_remark))
    <span>Remark: {{ $kot_header->kot_remark }}</span><br>
@else
    <span> </span><br>
@endif

@if(isset($guest_detail->voucher_no))
    <span> Voucher No: {{ $guest_detail->voucher_no }}</span><br>
@else
    <span> </span><br>
@endif
                    </div>
                    <div class="voucher_info">

                        <span>Vehicle No : {{ $kot_header->bill_no }}</span><br>
                        <span>Date : {{ $kot_header->voucher_date }}</span><br>
                        <span>Time : {{ $kot_header->created_at->format('H:i') }}</span><br>
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
                            @cannot('Rate_Hide_On_Kot')
                                                        <th class="th_detail">Rate</th>
                                


                            <th class="th_detail">Amount</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sno = 0;
                        @endphp
                        @foreach ($kot_to_print as $records)
                            <tr>
                                <td>{{ $sno = $sno + 1 }}</td>

                                <td>{{ $records->item_name }}</td>
                                <td>{{ number_format($records->qty, 0) }}</td>
                                  @cannot('Rate_Hide_On_Kot')
                                <td>{{ number_format($records->rate, 1) }}</td>
                                <td>{{ number_format($records->amount, 1) }}</td>
                                @endcan
                            </tr>
                        @endforeach

                </table>





            </div>
            <div class="qty_total">
                Total Item  QTY={{ $kot_header->total_qty }}
                 @cannot('Rate_Hide_On_Kot')

                Total Amount ={{ $kot_header->total_amount }}
                @endcan
            </div>
            <div style="background-color: white" class="my-1">&nbsp;</div>


            <div class="button-container my-2">
                <button class="btn btn-primary btn-lg" onclick="printInvoice()">Print</button>
                @can('Restaurant')
                                     <a href="{{url('/table_dashboard')}}" class ="btn btn-info btn-lg mx-2">book a slot</a>
                @endcan

            </div>



        </div>

        <script>
            function printInvoice() {
                window.print();
            }
        </script>


    {{-- this code for direct print throw browser  --}}
{{-- <div class="my-2">
    <label><input type="radio" name="print_type" value="chrome" checked> Print via Chrome</label>
    <label class="mx-3"><input type="radio" name="print_type" value="direct"> Print Direct (QZ Tray)</label>
</div> --}}

{{-- <div class="button-container my-2">
    <button class="btn btn-primary btn-lg" onclick="printInvoice()">Print</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/qz-tray/qz-tray.js"></script> --}}
{{-- 
<script>
    const kotData = [
        {
            type: 'raw',
            format: 'plain',
            data: `KOT No: {{ $kot_header->bill_no }}
Date: {{ $kot_header->voucher_date }}
Time: {{ $kot_header->created_at->format('H:i') }}

Items:
@foreach($kot_to_print as $record)
{{ $record->item_name }} x {{ number_format($record->qty, 0) }}
@endforeach

Total Qty: {{ $kot_header->total_qty }}
Total Amt: {{ $kot_header->total_amount }}`
        }
    ];

    function printInvoice() {
        const printType = document.querySelector('input[name="print_type"]:checked').value;

        if (printType === 'chrome') {
            window.print(); // Uses Chrome print dialog
        } else {
            // Direct Print via QZ Tray
            const printer1 = "Canon LBP2900";
            const printer2 = "Microsoft Print to PDF"; // Replace with actual name

            qz.websocket.connect().then(() => {
                const config1 = qz.configs.create(printer1);
                const config2 = qz.configs.create(printer2);

                qz.print(config1, kotData).then(() => {
                    console.log("Printed on " + printer1);
                }).catch(err => {
                    alert("Error printing on " + printer1 + ": " + err.message);
                });

                qz.print(config2, kotData).then(() => {
                    console.log("Printed on " + printer2);
                }).catch(err => {
                    alert("Error printing on " + printer2 + ": " + err.message);
                });

            }).catch(err => {
                alert("QZ Tray is not running. Please start it.");
                console.error(err);
            });
        }
    }
</script> --}}




    </body>

    </html>
@endsection
