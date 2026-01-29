@extends('layouts.blank')
@section('pagecontent')

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Invoice</title>

<style>
body{
    background:#eef1f5;
    font-family:Segoe UI, Arial, sans-serif;
    font-size:14px;
}

/* PAGE */
.inv-page{
    width:210mm;
    margin:20px auto;
    background:#fff;
    padding:20px;
    border-radius:8px;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
}

/* HEADER */
.inv-top{
    display:grid;
    grid-template-columns:80px 1fr 220px;
    gap:15px;
    border-bottom:2px solid #222;
    padding-bottom:12px;
}

.inv-logo{ width:70px; }

.inv-company h2{
    margin:0;
    font-size:22px;
}
.inv-company small{
    color:#555;
}

.inv-badge{
    border:2px solid #000;
    padding:10px;
    text-align:center;
    font-weight:700;
}

/* INFO */
.inv-info{
    display:grid;
    grid-template-columns:1.5fr 1fr;
    gap:20px;
    margin:18px 0;
}

.inv-box{
    border:1px solid #ccc;
    padding:10px;
    border-radius:6px;
}

/* TABLE */
.inv-table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

.inv-table th{
    background:#f1f3f6;
    border:1px solid #ccc;
    padding:8px;
}

.inv-table td{
    border:1px solid #ccc;
    padding:7px;
    text-align:center;
}

/* TOTAL CARD */
.inv-summary{
    width:35%;
    margin-left:auto;
    margin-top:12px;
}

.inv-summary table{
    width:100%;
    border-collapse:collapse;
}

.inv-summary td{
    padding:6px;
    border-bottom:1px dashed #bbb;
}

.inv-summary .grand{
    font-size:17px;
    font-weight:700;
    border-top:2px solid #000;
}

/* FOOTER */
.inv-footer{
    display:grid;
    grid-template-columns:2fr 2fr 1fr;
    gap:12px;
    margin-top:20px;
}

.inv-footer .inv-box{
    height:100%;
}

.inv-qr{
    text-align:center;
}

/* PRINT */
@media print{
    body{ background:#fff; }
    .no-print{ display:none; }
    .inv-page{ box-shadow:none; }
}
</style>
</head>

<body>

<div class="inv-page">

    {{-- HEADER --}}
    <div class="inv-top">
        <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}" class="inv-logo">

        <div class="inv-company">
            <h2>{{ $componyinfo->cominfo_firm_name }}</h2>
            <small>
                {{ $componyinfo->cominfo_address1 }},
                {{ $componyinfo->cominfo_city }},
                {{ $componyinfo->cominfo_state }} - {{ $componyinfo->cominfo_pincode }}<br>
                {{ $componyinfo->cominfo_email }} | {{ $componyinfo->cominfo_phone }}
            </small>
        </div>

        <div class="inv-badge">
            QUOTATIONS<br>
            <small>No: {{ $salebill_header->voucher_bill_no }}</small>
        </div>
    </div>

    {{-- INFO --}}
    <div class="inv-info">
        <div class="inv-box">
            <strong>BILL TO</strong><br>
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
                    
        </div>

        <div class="inv-box">
            Date : {{ $salebill_header->voucher_date }}<br>
            Time : {{ $salebill_header->created_at->format('H:i') }}<br>
            Operator : {{ $salebill_header->user_name }}
        </div>
    </div>

    {{-- ITEMS --}}
    <table class="inv-table">
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
            <td>{{ number_format($row->rate,2) }}</td>
            <td>{{ number_format($row->gst_item_percent,2) }}</td> --}}
            <td>{{ number_format($row->item_basic_amount,2) }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="inv-summary">
        <table>
            <tr><td>Basic Amount</td><td>{{ $salebill_header->total_item_basic_amount }}</td></tr>
            <tr><td>Discount</td><td>{{ $salebill_header->total_disc_item_amount }}</td></tr>
            <tr><td>SGST</td><td>{{ $salebill_header->total_gst_amount/2 }}</td></tr>
            <tr><td>CGST</td><td>{{ $salebill_header->total_gst_amount/2 }}</td></tr>
            <tr><td>Round Off</td><td>{{ $salebill_header->total_roundoff }}</td></tr>
            <tr class="grand">
                <td>GRAND TOTAL</td>
                <td>{{ $salebill_header->total_net_amount }}</td>
            </tr>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="inv-footer">
        <div class="inv-box">
    <strong>Terms & Conditions</strong>

    <ol style="padding-left:18px; margin-top:6px;">
        @foreach(preg_split("/\r\n|\r|\n/", (string)($compinfofooter->terms ?? '')) as $term)
            @if(trim($term) !== '')
                <li>{{ trim($term) }}</li>
            @endif
        @endforeach
    </ol>
</div>


        <div class="inv-box">
            <strong>Bank Details</strong><br>
            {{ $compinfofooter->bank_name }}<br>
            A/C: {{ $compinfofooter->bank_ac_no }}<br>
            IFSC: {{ $compinfofooter->bank_ifsc }}
        </div>

        <div class="inv-box inv-qr">
            <img src="/storage/image/{{ $pic->qrcode }}" width="90"><br>
            {{ $compinfofooter->upiid }}
        </div>
    </div>

     <div class="button-container my-2 gap-2 no-print">

    <!-- HOME BUTTON -->
    <a href="{{ url('/quotations') }}" class="btn btn-primary btn-lg ">
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
