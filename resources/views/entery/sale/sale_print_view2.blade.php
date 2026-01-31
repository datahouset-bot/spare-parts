@php
    include public_path('cdn/cdn.blade.php');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sale Invoice</title>

<style>
body{
    background:#e9edf2;
    font-family:Segoe UI, Arial, sans-serif;
    font-size:14px;
}

/* PAGE */
.alt-page{
    width:190mm;
    margin:20px auto;
    background:#fff;
    padding:15px;
    border:1px solid #000;
}

/* HEADER */
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

/* INFO */
.alt-info{
    display:grid;
    grid-template-columns:1fr 1fr;
    margin:15px 0;
}

/* TABLE */
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

/* TOTAL */
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

/* FOOTER */
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

/* BUTTONS */
.button-container{
    text-align:center;
    margin-top:20px;
}

.btn{
    padding:10px 18px;
    font-size:16px;
    border-radius:6px;
    border:none;
    cursor:pointer;
}

.btn-primary{ background:#0d6efd; color:#fff; }
.btn-success{ background:#198754; color:#fff; }

/* PRINT */
@media print{

    @page{
        size:A4;
        margin:10mm;
    }

    body{
        background:#fff;
        margin:0;
    }

    .no-print{
        display:none !important;
    }

    /* PRINT BORDER */
    .alt-page{
        border:2px solid #000 !important;
        margin:0 auto !important;
        padding:15px !important;
    }
}
</style>
</head>

<body>

<div class="alt-page">

    <!-- HEADER -->
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

        <div class="alt-invoice-tag">SALE INVOICE</div>
    </div>

    <!-- CUSTOMER + INVOICE -->
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

    <!-- ITEMS -->
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

    <!-- TOTAL -->
    <div class="alt-total">
        <table>
            <tr><td>Basic</td><td>{{ $salebill_header->total_item_basic_amount }}</td></tr>
            <tr><td>Discount</td><td>{{ $salebill_header->total_disc_item_amount }}</td></tr>
            <tr><td>SGST</td><td>{{ $salebill_header->total_gst_amount/2 }}</td></tr>
            <tr><td>CGST</td><td>{{ $salebill_header->total_gst_amount/2 }}</td></tr>
            <tr><td>Round</td><td>{{ $salebill_header->total_roundoff }}</td></tr>
            <tr class="grand">
                <td>GRAND TOTAL</td>
                <td>{{ $salebill_header->total_net_amount }}</td>
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="alt-footer">
        <div>
            <strong>Terms & Conditions</strong>
            <ol>
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

    <!-- BUTTONS -->
    <div class="button-container no-print">
        <a href="{{ url('/sales') }}" class="btn btn-primary">Home</a>
        <button class="btn btn-success" onclick="window.print()">Print</button>
    </div>

</div>

</body>
</html>
