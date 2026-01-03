
@php
if (!function_exists('amountInWords')) {

    function amountInWords($number)
    {
        $no = floor($number);
        $decimal = round($number - $no, 2) * 100;

        $digits_length = strlen($no);
        $i = 0;
        $str = [];
        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
            17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
            60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        ];

        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;

            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21)
                    ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred
                    : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else {
                $str[] = null;
            }
        }

        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal)
            ? " And " . $words[$decimal / 10] . " " . $words[$decimal % 10] . " Paise"
            : '';

        return trim("Rupees $Rupees Only");
    }
}
@endphp



@extends('layouts.blank')
@section('pagecontent')

<!DOCTYPE html>
<html>
<head>
<style>
@page {
    size: A5;
    margin: 8mm;
}

body {
    font-family: "Times New Roman", serif;
    font-size: 12px;
}

.receipt {
    border: 1px solid #000;
    padding: 8px;
}

/* HEADER */
.header {
    text-align: center;
    border-bottom: 1px solid #000;
    padding-bottom: 6px;
}

.header img {
    height: 50px;
}

.header h4 {
    margin: 4px 0;
    font-size: 16px;
    color: green;
}

.header small {
    font-size: 11px;
}

/* INFO */
.info {
    display: flex;
    justify-content: space-between;
    margin-top: 6px;
}

.info div {
    width: 48%;
}

/* AMOUNT WORD */
.amount-words {
    margin-top: 6px;
    font-style: italic;
    font-size: 11px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 8px;
}

th, td {
    border: 1px solid #000;
    padding: 4px;
    font-size: 11px;
    text-align: center;
}

th {
    background: #444;
    color: #fff;
}

/* TOTAL BOX */
.total-box {
    border-top: 1px dashed #000;
    margin-top: 8px;
    padding-top: 6px;
    text-align: right;
}

.total-box h4 {
    margin: 4px 0;
}

/* SIGNATURE */
.signature {
    margin-top: 25px;
    text-align: center;
}

.signature-line {
    border-top: 1px solid #000;
    width: 60%;
    margin: 20px auto 5px;
}

@media print {
    button { display: none; }
}
</style>
</head>

<body>

<div class="receipt">

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}">
        <h4>PAYMENT RECEIPT</h4>
        <strong>{{ $componyinfo->cominfo_firm_name }}</strong><br>
        <small>
            {{ $componyinfo->cominfo_address1 }} {{ $componyinfo->cominfo_address2 }},
            {{ $componyinfo->cominfo_city }} {{ $componyinfo->cominfo_state }} - {{ $componyinfo->cominfo_pincode }}<br>
            Mobile: {{ $componyinfo->cominfo_mobile }}
        </small>
    </div>

    @foreach($ledgers as $recipt)
    {{-- INFO --}}
    <div class="info">
        <div>
            <strong>Party:</strong> {{ $recipt->account_name }}<br>
            <strong>Mode:</strong> {{ $recipt->payment_mode_name }}
        </div>
        <div style="text-align:right">
            <strong>Invoice:</strong> {{ $recipt->reciept_no }}<br>
            <strong>Date:</strong> {{ $recipt->entry_date }}
        </div>
    </div>

    <div class="amount-words">
        {{ amountInWords($recipt->amount) }}
    </div>
    @endforeach

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Account</th>
                <th>Mode</th>
                <th>Dr</th>
                <th>Cr</th>
                <th>Amt</th>
            </tr>
        </thead>
        <tbody>
            @php $sno=1; @endphp
            @foreach ($ledgers as $records)
            <tr>
                <td>{{ $sno++ }}</td>
                <td>{{ $records->account_name }}</td>
                <td>{{ $records->payment_mode_name }}</td>
                <td>{{ $records->debit }}</td>
                <td>{{ $records->credit }}</td>
                <td>{{ number_format($records->amount,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    @foreach($ledgers as $detail)
    <div class="total-box">
        <div>Debit : ₹ {{ number_format($detail->debit,2) }}</div>
        <div>Credit : ₹ {{ number_format($detail->credit,2) }}</div>
        <div>Remark : {{ $detail->remark }}</div>
        <h4>Total : ₹ {{ number_format($detail->amount,2) }}</h4>
    </div>
    @endforeach

    {{-- SIGNATURE --}}
    <div class="signature">
        <div class="signature-line"></div>
        Authorized Signatory<br>
        For {{ $componyinfo->cominfo_firm_name }}
    </div>

    <div class="text-center mt-2">
        <button onclick="window.print()">Print</button>
    </div>

</div>

</body>
</html>
@endsection
