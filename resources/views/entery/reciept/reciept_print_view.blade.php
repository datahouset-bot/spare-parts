@php
    include public_path('cdn/cdn.blade.php');
@endphp

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
                $counter = count($str);
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : '';
                $str[] = ($number < 21)
                    ? $words[$number] . " " . $digits[$counter] . $hundred
                    : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $hundred;
            } else {
                $str[] = null;
            }
        }

        return "Rupees " . implode('', array_reverse($str)) . " Only";
    }
}
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Receipt</title>

<style>
@page { size: A4; margin: 10mm; }

body {
    margin: 0;
    font-family: "Times New Roman", serif;
    background: #f5f5f5;
}

/* ================= ACTION BAR ================= */
.action-bar{
    background:#ffffff;
    padding:10px 15px;
    border-bottom:1px solid #ccc;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.action-bar .btn{
    padding:6px 16px;
    font-size:14px;
    border-radius:4px;
    margin-left:5px;
}

/* ================= PAGE ================= */
.page {
    width: 80%;
    margin: 15px auto;
    background:#fff;
    border: 1px solid #000;
    padding: 10px;
}

/* ================= HEADER ================= */
.company_info {
    display: grid;
    grid-template-columns: 1fr 4fr 1fr;
    border-bottom: 1px solid #000;
    padding-bottom: 5px;
}

.firm_detail { text-align: center; }

/* ================= INFO ================= */
.info-container {
    display: flex;
    justify-content: space-between;
    padding: 5px;
}

.cust_info, .voucher_info {
    width: 50%;
    font-size: 18px;
}

.voucher_info { text-align: right; }

/* ================= HALF PAYMENT ================= */
.half_pay {
    border: 1px solid #000;
    padding: 15px;
    margin-top: 10px;
}

/* ================= AMOUNT ================= */
.amount-box {
    width: 50%;
    margin-left: auto;
    border: 1px solid #000;
    padding: 10px;
}

/* ================= SIGN ================= */
.signature-box {
    width: 40%;
    margin-left: auto;
    margin-top: 50px;
    text-align: center;
}

.signature-line {
    border-top: 1px solid #000;
    margin-top: 40px;
}

/* ================= FOOTER ================= */
.voucher_footer {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    border: 1px solid #000;
    margin-top: 20px;
}

/* ================= PRINT ================= */
@media print {
    .no-print { display: none !important; }
    body { background:#fff; }
}
</style>
</head>

<body>

{{-- ACTION BAR --}}
<div class="action-bar no-print">
    <strong>Receipt</strong>
    <div>
        <a href="{{ url('/reciepts') }}" class="btn btn-secondary">Home</a>
        <button onclick="window.print()" class="btn btn-success">Print</button>
    </div>
</div>

<div class="page">

{{-- HEADER --}}
<div class="company_info">
    <div><img src="{{ asset('storage/app/public/image/'.$pic->logo) }}" width="80"></div>
    <div class="firm_detail">
        <h3 style="color:green;">RECEIPT</h3>
        <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
        {{ $componyinfo->cominfo_address1 }} {{ $componyinfo->cominfo_address2 }}<br>
        {{ $componyinfo->cominfo_city }} {{ $componyinfo->cominfo_state }} {{ $componyinfo->cominfo_pincode }}<br>
        Mobile: {{ $componyinfo->cominfo_mobile }}
    </div>
    <div><img src="{{ asset('storage/app/public/image/'.$pic->brand) }}" width="80"></div>
</div>

{{-- PARTY INFO --}}
@foreach ($ledgers as $recipt)
<div class="info-container">
    <div class="cust_info">
        <strong>Party:</strong> {{ $recipt->account_name }}<br>
        <strong>Transaction:</strong> {{ $recipt->payment_mode_name }}<br><br>
        <i>{{ amountInWords($recipt->amount) }}</i>
    </div>
    <div class="voucher_info">
        <strong>Receipt No:</strong> {{ $recipt->voucher_no }}<br>
        <strong>Date:</strong> {{ $recipt->entry_date }}
    </div>
</div>
@endforeach

<div class="half_pay"><h5>Half Payment</h5></div>

@foreach ($ledgers as $detail)
<div class="amount-box">
    <h3>Grand Total: ₹ {{ number_format($detail->amount,2) }}</h3>
</div>
@endforeach

<div class="signature-box">
    <div class="signature-line"></div>
    <strong>Authorized Signatory</strong><br>
    For {{ $componyinfo->cominfo_firm_name }}
</div>

</div>
</body>

</html>
