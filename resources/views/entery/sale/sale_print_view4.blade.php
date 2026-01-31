<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sale Invoice</title>

<style>
body{
    background:#e9edf2;
    font-family:Segoe UI, Arial, sans-serif;
    font-size:14px;
}

/* PAGE */
.doc{
    width:210mm;
    margin:20px auto;
    background:#fff;
    padding:18px;
    border:1px solid #000;
}

/* HEADER */
.doc-header{
    display:grid;
    grid-template-columns:90px 1fr 90px;
    align-items:center;
    border-bottom:2px solid #000;
    padding-bottom:10px;
}

.doc-header img{ width:70px; }

.doc-title{
    text-align:center;
}
.doc-title h2{
    margin:0;
    letter-spacing:2px;
}
.doc-title small{
    font-size:13px;
}

/* INFO BOX */
.doc-info{
    display:grid;
    grid-template-columns:1fr 1fr;
    border:1px solid #000;
    margin-top:15px;
}

.doc-info div{
    padding:10px;
    border-right:1px solid #000;
}
.doc-info div:last-child{
    border-right:none;
}

/* TABLE */
.doc-table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.doc-table th, .doc-table td{
    border:1px solid #000;
    padding:6px;
    text-align:center;
}

.doc-table th{
    background:#f2f2f2;
}

/* TOTAL STRIP */
.total-strip{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    border:1px solid #000;
    margin-top:12px;
}

.total-strip div{
    padding:8px;
    text-align:center;
    border-right:1px solid #000;
}
.total-strip div:last-child{
    border-right:none;
    font-weight:bold;
    font-size:16px;
}

/* FOOTER */
.doc-footer{
    display:grid;
    grid-template-columns:2fr 2fr 1fr;
    gap:12px;
    margin-top:20px;
}

.doc-box{
    border:1px solid #000;
    padding:8px;
    min-height:90px;
}

.doc-sign{
    text-align:center;
    margin-top:40px;
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

/* PRINT */@media print {

    /* Hide buttons */
    .no-print {
        display: none !important;
    }

    /* Page setup */
    @page {
        size: A4;
        margin: 10mm;
    }

    body {
        background: #fff !important;
        margin: 0;
        padding: 0;
    }

    /* ADD PRINT BORDER */
    .doc {
        border: 3px double #000 !important;
        margin: 0 auto !important;
        padding: 15px !important;
        box-shadow: none !important;
    }
}

</style>
</head>

<body>

<div class="doc">

    <!-- HEADER -->
    <div class="doc-header">
        <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}">

        <div class="doc-title">
            <h2>SALE INVOICE</h2>
            <small>{{ $componyinfo->cominfo_firm_name }}</small><br>
            {{ $componyinfo->cominfo_address1 }},
            {{ $componyinfo->cominfo_city }},
            {{ $componyinfo->cominfo_state }} - {{ $componyinfo->cominfo_pincode }}
        </div>

        <img src="{{ asset('storage/app/public/image/'.$pic->brand ?? '') }}">
    </div>

    <!-- INFO -->
    <div class="doc-info">
        <div>
            <strong>BILL TO</strong><br>
            {{ $salebill_header->account->account_name }}<br>
            {{ $salebill_header->account->address }}<br>
            GSTIN: {{ $salebill_header->account->gst_no }}
        </div>

        <div>
            Invoice No : {{ $salebill_header->voucher_bill_no }}<br>
            Date : {{ $salebill_header->voucher_date }}<br>
            Time : {{ $salebill_header->created_at->format('H:i') }}<br>
            Operator : {{ $salebill_header->user_name }}
        </div>
    </div>

    <!-- ITEMS -->
    <table class="doc-table">
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
            <td>{{ number_format($row->rate,2) }}</td>
            <td>{{ number_format($row->gst_item_percent,2) }}</td>
            <td>{{ number_format($row->item_basic_amount,2) }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total-strip">
        <div>Basic<br>{{ $salebill_header->total_item_basic_amount }}</div>
        <div>Discount<br>{{ $salebill_header->total_disc_item_amount }}</div>
        <div>SGST<br>{{ $salebill_header->total_gst_amount/2 }}</div>
        <div>CGST<br>{{ $salebill_header->total_gst_amount/2 }}</div>
        <div>Round<br>{{ $salebill_header->total_roundoff }}</div>
        <div>NET<br>{{ $salebill_header->total_net_amount }}</div>
    </div>

    <!-- FOOTER -->
    <div class="doc-footer">
        <div class="doc-box">
            <strong>Terms & Conditions</strong>
            <ol>
                @foreach(preg_split("/\r\n|\r|\n/", (string)($compinfofooter->terms ?? '')) as $term)
                    @if(trim($term) !== '')
                        <li>{{ trim($term) }}</li>
                    @endif
                @endforeach
            </ol>
        </div>

        <div class="doc-box">
            <strong>Bank Details</strong><br>
            {{ $compinfofooter->bank_name }}<br>
            A/C: {{ $compinfofooter->bank_ac_no }}<br>
            IFSC: {{ $compinfofooter->bank_ifsc }}
        </div>

        <div class="doc-box doc-sign">
            <img src="/storage/image/{{ $pic->qrcode }}" width="80"><br>
            {{ $compinfofooter->upiid }}
        </div>
    </div>

    <div class="doc-sign">
        <strong>Authorised Signatory</strong>
    </div>

    <!-- BUTTONS -->
    <div class="button-container no-print">
        <a href="{{ url('/sales') }}" class="btn btn-primary">Home</a>
        <button class="btn btn-success" onclick="window.print()">Print</button>
    </div>

</div>

</body>
</html>
