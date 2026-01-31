@php
    include public_path('cdn/cdn.blade.php');
@endphp

@php
if (!function_exists('amountInWords')) {
    function amountInWords($number)
    {
        $no = floor($number);
        $decimal = round($number - $no, 2) * 100;

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

        $str = [];
        $i = 0;
        while ($no > 0) {
            $divider = ($i == 2) ? 10 : 100;
            $number = $no % $divider;
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;

            if ($number) {
                $str[] = ($number < 21)
                    ? $words[$number] . " " . $digits[count($str)]
                    : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[count($str)];
            }
        }

        return "Rupees " . implode(' ', array_reverse($str)) . " Only";
    }
}
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purchase Voucher</title>

<style>
@page {
    size: A6;
    margin: 10mm;
}

body{
    margin:0;
    font-family:"Times New Roman", serif;
    font-size:15px;
}

/* ================= PAGE ================= */
.page{
    width:50%;
    margin:10px auto;
    border:1px solid #000;
    padding:10px;
}

/* ================= HEADER ================= */
.company_info{
    display:grid;
    grid-template-columns:1fr 4fr 1fr;
    border-bottom:1px solid #000;
    padding-bottom:5px;
}

.firm_detail{
    text-align:center;
}

/* ================= INFO ================= */
.info-container{
    display:flex;
    justify-content:space-between;
    margin-top:10px;
}

.cust_info,
.voucher_info{
    width:48%;
    font-size:16px;
}

.voucher_info{
    text-align:right;
}

/* ================= BOXES ================= */
.half_pay,
.amount-box{
    border:1px solid #000;
    padding:10px;
    margin-top:10px;
}

.amount-box{
    width:50%;
    margin-left:auto;
}

.signature-box{
    margin-top:40px;
    text-align:right;
}

.signature-line{
    width:200px;
    border-top:1px solid #000;
    margin-left:auto;
    margin-bottom:5px;
}

/* ================= BUTTONS ================= */
.button-container{
    display:flex;
    justify-content:center;
    gap:14px;
    margin-top:20px;
}

.btn{
    padding:10px 22px;
    font-size:16px;
    font-weight:bold;
    border-radius:6px;
    border:none;
    cursor:pointer;
    text-decoration:none;
}

.btn-primary{
    background:#0d6efd;
    color:#fff;
}

.btn-primary:hover{
    background:#0b5ed7;
}

.btn-success{
    background:#198754;
    color:#fff;
}

.btn-success:hover{
    background:#157347;
}

/* ================= PRINT ================= */
@media print{
    .no-print{ display:none !important; }
    .page{
        width:89%;
        margin:0;
        padding:10mm;
        border:1px solid #000;
    }
}
</style>
</head>

<body>

<div class="page">

    <!-- HEADER -->
    <div class="company_info">
        <div>
            <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}" width="70">
        </div>

        <div class="firm_detail">
            <h3 style="color:green;">PURCHASE</h3>
            <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
            {{ $componyinfo->cominfo_address1 }},
            {{ $componyinfo->cominfo_city }},
            {{ $componyinfo->cominfo_state }}
        </div>

        <div>
            <img src="{{ asset('storage/app/public/image/'.$pic->brand) }}" width="70">
        </div>
    </div>

    <!-- INFO -->
    <div class="info-container">
        <div class="cust_info">
            Party: {{ $account_detail->account_name }}<br>
            Address: {{ $account_detail->address }}<br>
            <em>{{ amountInWords($voucher_header->total_net_amount) }}</em>
        </div>

        <div class="voucher_info">
            Invoice No: {{ $voucher_header->voucher_no }}<br>
            Date: {{ $voucher_header->voucher_date }}<br>
            Time: {{ $voucher_header->created_at->format('H:i') }}
        </div>
    </div>

    <!-- HALF PAYMENT -->
    <div class="half_pay">
        <strong>Half Payment</strong>
    </div>

    <!-- AMOUNT -->
    <div class="amount-box">
        <strong>Grand Total:</strong><br>
        ₹ {{ $voucher_header->total_net_amount }}
    </div>

    <!-- SIGN -->
    <div class="signature-box">
        <div class="signature-line"></div>
        Authorized Signatory<br>
        For {{ $componyinfo->cominfo_firm_name }}
    </div>

    <!-- BUTTONS -->
    <div class="button-container no-print">
        <a href="{{ url('/purchases') }}" class="btn btn-primary">Home</a>
        <button class="btn btn-success" onclick="window.print()">Print</button>
    </div>

</div>

</body>
</html>
