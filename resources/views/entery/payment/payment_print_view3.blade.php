@extends('layouts.blank')
@section('pagecontent')

@php
if (!function_exists('amountInWords')) {
    function amountInWords($number)
    {
        $no = floor($number);
        $words = [
            0 => '',1=>'One',2=>'Two',3=>'Three',4=>'Four',5=>'Five',
            6=>'Six',7=>'Seven',8=>'Eight',9=>'Nine',10=>'Ten',
            11=>'Eleven',12=>'Twelve',13=>'Thirteen',14=>'Fourteen',
            15=>'Fifteen',16=>'Sixteen',17=>'Seventeen',18=>'Eighteen',
            19=>'Nineteen',20=>'Twenty',30=>'Thirty',40=>'Forty',
            50=>'Fifty',60=>'Sixty',70=>'Seventy',80=>'Eighty',90=>'Ninety'
        ];
        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
        $str=[]; $i=0;
        while($no>0){
            $divider=($i==2)?10:100;
            $number=$no%$divider; $no=floor($no/$divider);
            if($number){
                $str[] = ($number<21)
                    ? $words[$number].' '.$digits[$i]
                    : $words[floor($number/10)*10].' '.$words[$number%10].' '.$digits[$i];
            }
            $i++;
        }
        return 'Rupees '.implode(' ',array_reverse($str)).' Only';
    }
}
@endphp

<!DOCTYPE html>
<html>
<head>
<style>
@page { size:A4; margin:14mm; }

body{
    font-family: "Inter","Segoe UI",sans-serif;
    background:#eef1f5;
    font-size:15px;
    color:#222;
}

/* DOCUMENT */
.doc {
    max-width:220mm;
    margin:auto;
    background:#fff;
    padding:28px 30px;
}

/* TOP BAR */
.top-bar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding-bottom:12px;
    border-bottom:3px solid #2f5cff;
}

.top-bar img { height:65px; }

.company {
    text-align:center;
}
.company h2 {
    margin:0;
    font-size:22px;
    letter-spacing:.5px;
}
.company p {
    margin:4px 0;
    font-size:13px;
    color:#555;
}

/* TITLE */
.title {
    text-align:center;
    margin:20px 0;
    font-size:22px;
    font-weight:700;
    color:#2f5cff;
}

/* INFO GRID */
.info-grid {
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:20px;
    margin-bottom:16px;
}

.info-card {
    padding:12px;
    background:#f7f9fc;
    border-radius:6px;
}

.info-card strong {
    display:block;
    font-size:13px;
    color:#555;
    margin-bottom:4px;
}

/* AMOUNT WORDS */
.amount-words {
    margin:14px 0;
    padding:12px;
    background:#fff6e5;
    border-left:5px solid #f5a623;
    font-style:italic;
}

/* TABLE */
table {
    width:100%;
    border-collapse:collapse;
    margin-top:18px;
}

thead th {
    background:#2f5cff;
    color:#fff;
    padding:14px;
    font-size:13px;
}

tbody td {
    padding:10px;
    border-bottom:1px solid #e0e0e0;
    text-align:center;
}

tbody tr:last-child td {
    border-bottom:none;
}

/* TOTAL */
.total-box {
    width:40%;
    margin-left:auto;
    margin-top:20px;
    background:#f4f6ff;
    padding:14px;
    border-radius:6px;
}

.total-box div {
    display:flex;
    justify-content:space-between;
    margin-bottom:6px;
}
.total-box div:last-child {
    font-weight:700;
    font-size:10px;
}

/* SIGN */
.sign-row {
    margin-top:60px;
    display:flex;
    justify-content:space-between;
}
.sign {
    width:30%;
    text-align:center;
}
.sign-line {
    border-top:1px solid #555;
    margin-bottom:6px;
}

/* FOOTER */
.voucher_footer {
    margin-top:30px;
    display:grid;
    grid-template-columns:2fr 1fr 1fr;
    gap:1px;
    background:#ccc;
}
.voucher_footer > div {
    background:#f7f9fc;
    padding:12px;
}
.bank_detail { font-size:13px; }

/* PRINT */
@media print {
    body { background:#fff; }
    .doc { padding:0; }
    .no-print { display:none!important; }
}
</style>
</head>

<body>

<div class="doc">

    <!-- HEADER -->
    <div class="top-bar">
        <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}">
        <div class="company">
            <h2>{{ $componyinfo->cominfo_firm_name }}</h2>
            <p>
                {{ $componyinfo->cominfo_address1 }} {{ $componyinfo->cominfo_address2 }},
                {{ $componyinfo->cominfo_city }} {{ $componyinfo->cominfo_state }} -
                {{ $componyinfo->cominfo_pincode }}<br>
                Mobile: {{ $componyinfo->cominfo_mobile }}
            </p>
        </div>
        <img src="{{ asset('storage/app/public/image/'.$pic->brand) }}">
    </div>

    <div class="title">PAYMENT RECEIPT</div>

    @foreach($ledgers as $recipt)
    <div class="info-grid">
        <div class="info-card">
            <strong>Party</strong>
            {{ $recipt->account_name }}<br>
            <strong>Payment Mode</strong>
            {{ $recipt->payment_mode_name }}
        </div>

        <div class="info-card">
            <strong>Receipt No</strong>
            {{ $recipt->reciept_no }}<br>
            <strong>Date</strong>
            {{ $recipt->entry_date }}
        </div>
    </div>

    <div class="amount-words">
        {{ amountInWords($recipt->amount) }}
    </div>
    @endforeach

    <!-- TABLE -->
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Account</th>
            <th>Mode</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @php $i=1; @endphp
        @foreach($ledgers as $row)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $row->account_name }}</td>
            <td>{{ $row->payment_mode_name }}</td>
            <td>{{ number_format($row->debit,2) }}</td>
            <td>{{ number_format($row->credit,2) }}</td>
            <td>{{ number_format($row->amount,2) }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    @foreach($ledgers as $detail)
    <div class="total-box">
        <div><span>Debit</span><span>₹ {{ number_format($detail->debit,2) }}</span></div>
        <div><span>Credit</span><span>₹ {{ number_format($detail->credit,2) }}</span></div>
        <div><span>Total</span><span>₹ {{ number_format($detail->amount,2) }}</span></div>
    </div>
    @endforeach

    <!-- SIGN -->
    <div class="sign-row">
        <div class="sign"><div class="sign-line"></div>Prepared By</div>
        <div class="sign"><div class="sign-line"></div>Receiver</div>
        <div class="sign"><div class="sign-line"></div>Authorized Signatory</div>
    </div>

    <!-- FOOTER -->
    <div class="voucher_footer">
        <div>
            <strong>Terms & Conditions</strong><br>
            {{ $compinfofooter->terms }}
        </div>
        <div class="bank_detail">
            Bank: {{ $compinfofooter->bank_name }}<br>
            A/C: {{ $compinfofooter->bank_ac_no }}<br>
            IFSC: {{ $compinfofooter->bank_ifsc }}
        </div>
        <div style="text-align:center">
            <img src="/storage/image/{{ $pic->qrcode }}" width="80"><br>
            <img src="{{ asset('storage/image/' . $pic->seal) }}" width="70">
        </div>
    </div>

     <div class="button-container mt-3 text-center no-print">
    <button class="btn btn-success btn-lg" onclick="window.print()">Print</button>
</div>

</div>

</body>
</html>
@endsection
