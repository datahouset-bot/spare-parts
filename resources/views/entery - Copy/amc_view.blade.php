@php
include(public_path('cdn/cdn.blade.php'));
@endphp
@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <link rel="stylesheet" media="print" href="{{ asset('public/admin_assets/css/amc_print.css') }}"  />
     <title>Invoice #6</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        label {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }

        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 1px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }

        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }

        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }

        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }

        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }

        .no-border {
            border: 1px solid #fff !important;
        }

        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }

        #voucher_type {
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="order-details">
        <thead>
            <tr>
                <h3 id="voucher_type">{{ $compinfofooter->ct3 }} </h3>
            </tr>
            <tr>
                <th width="60%" colspan="2">
                    <div class="row">
                        <div class="col-4">
                            <img src="{{ asset('\storage\app\public\image\\' . $comppic->logo) }}" alt="" width="130px">
                            <img src="{{ asset('\storage\app\public\image\\' . $comppic->brand) }}" alt="" width="130px">
                        </div>
                        <div class="col-8">

                            <div class="col-12">
                                <table style="width:100%">
                                    <tr>
                                        <td class="voucher_head"> {{ $compdata['cominfo_firm_name'] }}</td>
                                    <tr>
                                    <tr>
                                        <td class="voucher_head_detail">{{ $compdata['cominfo_address1'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="voucher_head">{{ $compdata['cominfo_address2'] }}&nbsp;{{ $compdata['cominfo_city'] }}</td>

                                    <tr>
                                    <tr>
                                        <td class="voucher_head_detail"> {{ $compdata['cominfo_state'] }}&nbsp;{{ $compdata['cominfo_pincode'] }}  &nbsp;  {{ $compinfofooter->country }}</td>
                                    </tr>
                                    <tr>
                                        <td class="voucher_head">{{ $compdata['cominfo_email'] }}</td>

                                    <tr>
                                    <tr>
                                        <td class="voucher_head_detail">GST NO- &nbsp;{{ $compdata['cominfo_gst_no'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="voucher_head">{{ $compdata['cominfo_pencard'] }}</td>

                                    <tr>
                                    <tr>
                                        <td class="voucher_head_detail">{{ $compdata['cominfo_field1'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="voucher_head_detail">{{ $compdata['cominfo_field2'] }}</td>
                                    </tr>
                                </table>


                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12">

                                <div class="col-12">
                                    <table style="width:100%">
                                        <tr>
                                            <td class="customer_header">Buyer (Bill To ) </td>
                                        <tr>
                                        <tr>
                                            <td class="customer_header">{{ $amc->account->account_name }} &nbsp;</td>
                                        <tr>
                                        <tr>
                                            <td class="customer_header">{{ $amc->account->address }}&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="customer_header">{{ $amc->account->city }}&nbsp;</td>

                                        <tr>
                                        <tr>
                                            <td class="customer_header">{{ $amc->account->state }} &nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="customer_header">{{ $amc->account->phone }}&nbsp;</td>

                                        <tr>
                                        <tr>
                                            <td class="customer_header">{{ $amc->account->mobile }} &nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="customer_header">{{ $amc->account->email }}&nbsp;</td>

                                        <tr>
                                        <tr>
                                            <td class="customer_header">{{ $amc->account->person_name }} &nbsp;</td>
                                        </tr>
                                    </table>


                                </div>
                            </div>




                </th>
                <!-- this is for second side bill head -->
                <th width="40%" colspan="2" class="text-end company-data">
                    <div class="row">
                        <div class="col-6">
                            <table style="width:100%">
                                <tr>
                                    <td class="voucher_head">Invoice No </td>
                                <tr>
                                <tr>
                                    <td class="voucher_head_detail">{{ $compinfofooter->voucher_prefix }}{{ $amc['id'] }}{{ $compinfofooter->voucher_suffix }}</td>
                                </tr>
                                <tr>
                                    <td class="voucher_head">AMC Start Date  </td>

                                <tr>
                                <tr>
                                    <td class="voucher_head_detail">{{ $amc['amc_start_date'] }}</td>
                                </tr>
                                <tr>
                                    <td class="voucher_head">AMC End Date</td>

                                <tr>
                                <tr>
                                    <td class="voucher_head_detail">{{ $amc['amc_end_date'] }}</td>
                                </tr>
                                <tr>
                                    <td class="voucher_head">AMC Amount </td>

                                <tr>
                                <tr>
                                    <td class="voucher_head_detail">{{ $amc['amc_amount'] }} </td>
                                </tr>
                                <tr>
                                    <td class="voucher_head">AMC Status</td>

                                <tr>
                                <tr>
                                    <td class="voucher_head_detail">{{ $amc['amc_status'] }}&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="voucher_head_detail">{{ $amc['remark1'] }}&nbsp;</td>
                                <tr>
                                <tr>
                                    <td class="voucher_head_detail"> {{ $amc['remark2']}}&nbsp;</td>
                                <tr>
                                <tr>
                                    <td class="voucher_head_detail">{{ $amc['executive']}}&nbsp;</td>
                                <tr>

                                </tr>
            </tr>
    </table>


    </div>
    <div class="col-6">
        <table style="width:100%">
            <tr>
                <td class="heading1">Product Details  </td>

            <tr>
            <tr>
                <td class="voucher_head_detail">Name: {{ $amc->item->item_name }}</td>
            </tr>
            <tr>
                <td class="voucher_head">Company: {{ $amc->item->company }}</td>

            <tr>
            <tr>
                <td class="voucher_head_detail">Group: {{ $amc->item->group }}</td>
            </tr>
            <tr>
                <td class="voucher_head_detail">MRP: {{ $amc->item->mrp }}</td>
            </tr>
            <tr>
                <td class="voucher_head_detail">Sale Rate: {{ $amc->item->sale_rate }}</td>
            </tr>
            <tr>
                <td class="voucher_head">Unit: {{ $amc->item->unit }}</td>

            <tr>
            <tr>
                <td class="voucher_head_detail">Product Code : {{ $amc->item->id }}</td>
            </tr>
            
        </table>


    </div>



    </th>
    </tr>





    </thead>
    <tbody>

    </tbody>
    </table>

    <table>
        <thead>
            <tr class="bg-blue">
                <th>S.No</th>
                <th>Product</th>
                <th>HSN/SAC</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Dis%</th>
                <th>DisAmt</th>
                <th>SGST%</th>
                <th>CGST%</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="7%">1</td>
                <td>
                  {{ $amc->item->item_name }}
                </td>
                <td width="7%">5465465</td>
                <td width="7%">2</td>
                <td width="7%" class="fw-bold">Pcs</td>
                <td width="7%" class="fw-bold">12000</td>
                <td width="7%" class="fw-bold">10%</td>
                <td width="7%" class="fw-bold">1200</td>
                <td width="7%" class="fw-bold">9</td>
                <td width="7%" class="fw-bold">9</td>
                <td width="7%" class="fw-bold">{{ $amc['amc_amount'] }}</td>
            </tr>
            <tr>
                <td colspan="10" class="total-heading">Total Amount in &nbsp;{{ $compinfofooter->currency }} - <small>Inc. all vat/tax</small> :</td>
                <td colspan="1" class="total-heading">RS-{{ $amc['amc_amount'] }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <div class="row">
        <div class="col-5">
            <h5>Terms & Conditions</h5>
            {{ $compinfofooter->terms }}
        </div>
        <div class="col-2">
            <img src="{{ asset('\storage\app\public\image\\' . $comppic->qrcode) }}" alt="" width="130px">
          
        </div>
        <div class="col-5">
            <table style="width:100%">
                Company Bank Details
                <tr>
                  <td>A/c Holder Name </td>
                  <td>:</td>
                  <td> {{ $compdata['cominfo_firm_name'] }}</td>
                  
                </tr>
                <tr>
                    <td>Bank Name </td>
                    <td>:</td>
                    <td>{{ $compinfofooter->bank_name }}</td>
                </tr>
                <tr>
                    <td>A/c No  </td>
                    <td>:</td>
                    <td>{{ $compinfofooter->bank_ac_no }} </td>
                </tr>  
                <tr>
                    <td>IFSC Code & Branch  </td>
                    <td>:</td>
                    <td> {{ $compinfofooter->bank_ifsc }} &nbsp; -{{ $compinfofooter->bank_branch }}</td>
                </tr>
                <tr>
                    <td>UPI ID & Pay NO  </td>
                    <td>:</td>
                    <td> {{ $compinfofooter->upiid }} &nbsp;&  :{{ $compinfofooter->pay_no }}</td>
                </tr>
            </table>

            <div class="footer_sign">
                <p > {{ $compdata['cominfo_firm_name'] }} </p> 
                <img src="{{ asset('\storage\app\public\image\\' . $comppic->seal) }}" alt="" width="130px">
                <img src="{{ asset('\storage\app\public\image\\' . $comppic->signature) }}" alt="" width="130px">

                <p>Authorised Signatory</p>
            </div>


        </div>
    </div>
    <p class="text-center">
      All Subject To {{ $compinfofooter->ct1 }} Jurisdiction <br> 
      {{ $compinfofooter->voucher_note }}


    </p>


<script>
  $('.myitem').chosen();
  $('.mycustomer').chosen();
</script>

@endsection
