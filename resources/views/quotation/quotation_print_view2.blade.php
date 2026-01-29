@php
    include public_path('cdn/cdn.blade.php');
@endphp

@extends('layouts.blank')

@section('pagecontent')

<style>
/* ===== PAGE ===== */
.alt-page{
    width:190mm;
    margin:20px auto;
    background:#fff;
    padding:15px;
    border:1px solid #000;
    font-size:14px;
}

/* ===== HEADER ===== */
.alt-header{
    display:grid;
    grid-template-columns:80px 1fr 120px;
    align-items:center;
    border-bottom:2px solid #000;
    padding-bottom:10px;
}

.alt-logo{ width:70px; }

/* ===== INFO ===== */
.alt-info{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
    margin:15px 0;
}

/* ===== TABLE ===== */
.alt-table{
    width:100%;
    border-collapse:collapse;
}

.alt-table th,
.alt-table td{
    border:1px solid #000;
    padding:6px;
    text-align:center;
}

/* ===== TOTAL ===== */
.alt-total{
    width:35%;
    margin-left:auto;
    margin-top:10px;
}

.alt-total .grand{
    font-weight:700;
    font-size:16px;
}

/* ===== FOOTER ===== */
.alt-footer{
    display:grid;
    grid-template-columns:2fr 2fr 1fr;
    gap:15px;
    margin-top:20px;
    border-top:1px solid #000;
    padding-top:10px;
}

/* ===== BUTTONS ===== */
.button-container{
    display:flex;
    justify-content:center;
    gap:15px;
    margin-top:20px;
}

/* ===== PRINT ===== */
@media print{
    .no-print{ display:none; }
    body{ background:#fff; }
}
</style>

<div class="alt-page">

{{-- HEADER --}}
<div class="alt-header">
    <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}" class="alt-logo">

    <div>
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

    <div class="alt-invoice-tag">QUOTATIONS</div>
</div>

{{-- INFO --}}
<div class="alt-info">
    <div></div>
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
                {{-- <th>Qty</th>
                <th>Rate</th>
                <th>GST%</th> --}}
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php($i=1)
            @foreach($salebill_items as $row)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $row->item_name }}</td>
                {{-- <td>{{ number_format($row->qty,0) }}</td>
                <td>{{ number_format($row->rate,1) }}</td>
                <td>{{ number_format($row->gst_item_percent,1) }}</td> --}}
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
    <strong>Terms & Conditions</strong>

    <ol style="padding-left:18px; margin-top:6px;">
        @foreach(preg_split("/\r\n|\r|\n/", (string)($compinfofooter->terms ?? '')) as $term)
            @if(trim($term) !== '')
                <li>{{ trim($term) }}</li>
            @endif
        @endforeach
    </ol>
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

     <div class="button-container my-2 gap-2 no-print">

    <!-- HOME BUTTON -->
    <a href="{{ url('/quotations') }}" class="btn btn-primary btn-lg">
        <i class="fa fa-home"></i> Home
    </a>

    <!-- PRINT BUTTON -->
    <button class="btn btn-success btn-lg" onclick="window.print()">
        <i class="fa fa-print"></i> Print
    </button>

</div>

</div>

</body>


    </html>
@endsection
