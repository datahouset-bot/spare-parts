@php
    include public_path('cdn/cdn.blade.php');
@endphp

@extends('layouts.blank')

@section('pagecontent')

<style>
/* ================= PAGE ================= */
.quote-page{
    width:210mm;
    margin:15px auto;
    background:#fff;
    padding:18px;
    font-size:13px;
    border:1px solid #999;
}

/* ================= HEADER ================= */
.quote-header{
    display:flex;
    justify-content:space-between;
    border-bottom:2px solid #000;
    padding-bottom:10px;
}

.quote-company h3{
    margin:0;
    font-size:18px;
}

.quote-company small{
    font-size:12px;
}

.quote-title{
    font-size:22px;
    font-weight:700;
}

/* ================= INFO ================= */
.quote-info{
    display:grid;
    grid-template-columns:1fr 1fr;
    margin:15px 0;
    gap:15px;
}

.quote-info table{
    width:100%;
    font-size:13px;
}

/* ================= ITEMS ================= */
.quote-table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

.quote-table th,
.quote-table td{
    border:1px solid #000;
    padding:6px;
    text-align:center;
}

.quote-table th{
    background:#f2f2f2;
}

/* ================= TOTAL ================= */
.quote-total{
    width:35%;
    margin-left:auto;
    margin-top:10px;
}

.quote-total table{
    width:100%;
    border-collapse:collapse;
}

.quote-total td{
    padding:5px;
    border:1px solid #000;
}

.quote-total .grand{
    font-weight:700;
    font-size:15px;
}

/* ================= FOOTER ================= */
.quote-footer{
    display:grid;
    grid-template-columns:2fr 1fr 1fr;
    gap:15px;
    margin-top:20px;
    border-top:1px solid #000;
    padding-top:10px;
    font-size:12px;
}

/* ================= BUTTONS ================= */
.no-print{
    text-align:center;
    margin-top:20px;
}

@media print{
    .no-print{display:none;}
    body{background:#fff;}
}
/* ================= FORMAT SWITCH ================= */
.format-switch{
    display:flex;
    justify-content:center;
    gap:12px;
    margin:15px auto;
    flex-wrap:wrap;
}

.format-switch .btn{
    padding:8px 16px;
    font-size:14px;
    font-weight:600;
    border-radius:6px;
}

</style>

<div class="quote-page">

{{-- HEADER --}}
<div class="quote-header">
    <div class="quote-company">
        <h3>{{ $componyinfo->cominfo_firm_name }}</h3>
        <small>
            {{ $componyinfo->cominfo_address1 }},
            {{ $componyinfo->cominfo_city }},
            {{ $componyinfo->cominfo_state }} - {{ $componyinfo->cominfo_pincode }}<br>
            Phone: {{ $componyinfo->cominfo_phone }} |
            Email: {{ $componyinfo->cominfo_email }}
        </small>
    </div>

    <div class="quote-title">QUOTATION</div>
</div>

{{-- CUSTOMER + META --}}
<div class="quote-info">
    <div>
        <strong>Quotation For</strong><br>
        {{ $salebill_header->account->account_name ?? '' }}<br>
        {{ $salebill_header->account->address ?? '' }}<br>
        {{ $salebill_header->account->city ?? '' }}
    </div>

    <div>
        <table>
            <tr><td>Quotation No</td><td>: {{ $salebill_header->voucher_bill_no }}</td></tr>
            <tr><td>Date</td><td>: {{ $salebill_header->voucher_date }}</td></tr>
            <tr><td>Prepared By</td><td>: {{ $salebill_header->user_name }}</td></tr>
        </table>
    </div>
</div>

{{-- ITEMS --}}
<table class="quote-table">
    <thead>
        <tr>
            <th>Qty</th>
            <th>Description</th>
            <th>Unit Price</th>
            <th>Tax%</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($salebill_items as $item)
        <tr>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->item_name }}</td>
            <td>{{ number_format($item->rate,2) }}</td>
            <td>{{ number_format($item->gst_item_percent,2) }}</td>
            <td>{{ number_format($item->item_basic_amount,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- TOTAL --}}
<div class="quote-total">
    <table>
        <tr><td>Subtotal</td><td>{{ $salebill_header->total_item_basic_amount }}</td></tr>
        <tr><td>Tax</td><td>{{ $salebill_header->total_gst_amount }}</td></tr>
        <tr class="grand">
            <td>Total</td>
            <td>{{ $salebill_header->total_net_amount }}</td>
        </tr>
    </table>
</div>

{{-- FOOTER --}}
<div class="quote-footer">
    <div>
        <strong>Terms & Conditions</strong>
        <ol>
            @foreach(preg_split("/\r\n|\r|\n/", (string)($compinfofooter->terms ?? '')) as $term)
                @if(trim($term)) <li>{{ trim($term) }}</li> @endif
            @endforeach
        </ol>
    </div>

    <div>
        <strong>Bank Details</strong><br>
        {{ $compinfofooter->bank_name }}<br>
        A/C: {{ $compinfofooter->bank_ac_no }}<br>
        IFSC: {{ $compinfofooter->bank_ifsc }}
    </div>

    <div style="text-align:center">
        <img src="/storage/image/{{ $pic->qrcode }}" width="80"><br>
        {{ $compinfofooter->upiid }}
    </div>
</div>

{{-- BUTTONS --}}
<div class="no-print">
    <a href="{{ url('/quotations') }}" class="btn btn-primary">Home</a>
    <button onclick="window.print()" class="btn btn-success">Print</button>
    <div class="format-switch no-print">
    <a href="{{ url('/quotation_print_view2/'.$salebill_header->voucher_no) }}" class="btn btn-outline-primary">
    Format 2
    </a>

   <a href="{{ url('/quotation_print_view3/'.$salebill_header->voucher_no) }}" class="btn btn-outline-success">
    Format 3
    </a>

   <a href="{{ url('/quotation_print_view4/'.$salebill_header->voucher_no) }}" class="btn btn-outline-warning">
    Format 4
    </a>

    <button onclick="window.print()" class="btn btn-outline-dark">
        Print
    </button>
</div>

</div>

</div>
@endsection
