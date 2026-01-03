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
            .alt-page{
    width:190mm;
    margin:auto;
    background:#fff;
    padding:15px;
    border:1px solid #000;
    font-size:14px;
}

.alt-header{
    display:grid;
    grid-template-columns:80px 1fr 120px;
    align-items:center;
    border-bottom:2px solid #000;
    padding-bottom:10px;
}

.alt-logo{ width:70px; }

.alt-invoice-tag{
    background:#000;
    color:#fff;
    text-align:center;
    padding:6px;
    font-weight:700;
}

.alt-info{
    display:grid;
    grid-template-columns:1fr 1fr;
    margin:15px 0;
}

.alt-table{
    width:100%;
    border-collapse:collapse;
}

.alt-table th, .alt-table td{
    border:1px solid #000;
    padding:6px;
    text-align:center;
}

.alt-total{
    width:30%;
    margin-left:auto;
    margin-top:10px;
}

.alt-total table{
    width:100%;
}

.alt-total td{
    padding:2px;
}

.alt-total .grand{
    font-weight:700;
    font-size:16px;
}

.alt-footer{
    display:grid;
    grid-template-columns:2fr 2fr 1fr;
    margin-top:20px;
    border-top:1px solid #000;
    padding-top:10px;
}

.alt-qr{
    text-align:center;
}

@media print{
    .no-print{ display:none; }
}

        </style>






    </head>
<body>

<div class="alt-page">

    {{-- ================= HEADER ================= --}}
    <div class="alt-header">
        <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}" class="alt-logo">

        <div class="alt-company">
            <h3>{{ $componyinfo->cominfo_firm_name }}</h3>
            <small>
                {{ $componyinfo->cominfo_address1 }},
                {{ $componyinfo->cominfo_city }},
                {{ $componyinfo->cominfo_state }} -
                {{ $componyinfo->cominfo_pincode }}<br>
                Email: {{ $componyinfo->cominfo_email }} |
                Phone: {{ $componyinfo->cominfo_phone }}
            </small>
        </div>

        <div class="alt-invoice-tag">
            SALE INVOICE
        </div>
    </div>

    {{-- ================= CUSTOMER + INVOICE ================= --}}
    <div class="alt-info">
        <div>
            <strong>BILL TO</strong><br>
            {{ $salebill_header->account->account_name }}<br>
            {{ $salebill_header->account->address }}<br>
            GSTIN: {{ $salebill_header->account->gst_no }}
        </div>

        <div>
            <table>
                <tr><td>Invoice No</td><td>: {{ $salebill_header->voucher_bill_no }}</td></tr>
                <tr><td>Date</td><td>: {{ $salebill_header->voucher_date }}</td></tr>
                <tr><td>Time</td><td>: {{ $salebill_header->created_at->format('H:i') }}</td></tr>
                <tr><td>Operator</td><td>: {{ $salebill_header->user_name }}</td></tr>
            </table>
        </div>
    </div>

    {{-- ================= ITEMS ================= --}}
    <table class="alt-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>GST%</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php($i=1)
            @foreach($salebill_items as $row)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $row->item_name }}</td>
                <td>{{ number_format($row->qty,0) }}</td>
                <td>{{ number_format($row->rate,1) }}</td>
                <td>{{ number_format($row->gst_item_percent,1) }}</td>
                <td>{{ number_format($row->item_basic_amount,1) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ================= TOTALS ================= --}}
    <div class="alt-total">
        <table>
            <tr><td>Basic Amount:-</td><td>{{ $salebill_header->total_item_basic_amount }}</td></tr>
            <tr><td>Discount:-</td><td>{{ $salebill_header->total_disc_item_amount }}</td></tr>
            <tr><td>SGST:-</td><td>{{ $salebill_header->total_gst_amount/2 }}</td></tr>
            <tr><td>CGST:-</td><td>{{ $salebill_header->total_gst_amount/2 }}</td></tr>
            <tr><td>Round Off:-</td><td>{{ $salebill_header->total_roundoff }}</td></tr>
            <tr class="grand">
                <td>GRAND TOTAL</td>
                <td>{{ $salebill_header->total_net_amount }}</td>
            </tr>
        </table>
    </div>

    {{-- ================= FOOTER ================= --}}
    <div class="alt-footer">
        <div>
            <strong>Terms & Conditions</strong><br>
            {{ $compinfofooter->terms }}
        </div>

        <div>
            <strong>Bank Details</strong><br>
            {{ $compinfofooter->bank_name }}<br>
            A/C: {{ $compinfofooter->bank_ac_no }}<br>
            IFSC: {{ $compinfofooter->bank_ifsc }}
        </div>

        <div class="alt-qr">
            <img src="/storage/image/{{ $pic->qrcode }}" width="90"><br>
            {{ $compinfofooter->upiid }}
        </div>
    </div>

    <div class="text-center my-3 no-print">
        <button class="btn btn-success" onclick="window.print()">Print</button>
    </div>

</div>

</body>


    </html>
@endsection
