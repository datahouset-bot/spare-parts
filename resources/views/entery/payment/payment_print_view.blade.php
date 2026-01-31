@php
    include public_path('cdn/cdn.blade.php');
@endphp

@extends('layouts.blank')
@section('pagecontent')


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





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PAYMENT RECEIPTS</title>

<style>
@page {
    size: A4;
    margin: 10mm;
}

body {
    margin: 0;
    font-family: "Times New Roman", serif;
}

/* ================= PAGE ================= */
.page {
    width: 80%;
    margin: auto;
    margin-top: 10px;
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

.firm_detail {
    text-align: center;
}

/* ================= INFO ================= */
.info-container {
    display: flex;
    justify-content: space-between;
    padding: 5px;
}

.cust_info {
    width: 50%;
    font-size: 18px;
}

.voucher_info {
    width: 50%;
    font-size: 18px;
    text-align: right;
}

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

.amount-box h3 {
    margin: 5px 0;
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

/* ==============footer======================= */
  .voucher_footer {
                background-color: bisque;
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                border: 1px solid black;
                margin-bottom: 0px;
            }

            .terms {
                grid-column: 1 / 3;
                height: 100px;
                text-align: center;
            }

            .bank_detail {
                text-align: left;
                height: 120px;
                border-top: 1px solid;
                padding: 1px;
                font-size: 15px;
            }

            .comp_sign {

                border-left: 1px solid;
                text-align: center;

            }


            .qr_code {
                border-left: 1px solid;
                border-top: 1px solid;
                text-align: center;

            }

            .for_companyname {
                border-left: 1px solid;
                text-align: center;
            }
/* ================= PRINT ================= */@media print {
    .no-print,
    .no-print * {
        display: none !important;
        visibility: hidden !important;
    }
}

</style>
</head>

<body>

<div class="page">

    {{-- ================= HEADER ================= --}}
    <div class="company_info">
        <div>
            <img src="{{ asset('storage\app\public\image\\' . $pic->logo) }}" width="80">
        </div>

        <div class="firm_detail">
            <h3 style="color: green;">PAYMENT RECEIPT</h3>
            <h4><strong>{{ $componyinfo->cominfo_firm_name }}</strong></h4>
            {{ $componyinfo->cominfo_address1 }} {{ $componyinfo->cominfo_address2 }} <br>
            {{ $componyinfo->cominfo_city }} {{ $componyinfo->cominfo_state }} {{ $componyinfo->cominfo_pincode }} <br>
            Mobile: {{ $componyinfo->cominfo_mobile }}
        </div>

        <div>
            <img src="{{ asset('storage\app\public\image\\' . $pic->brand) }}" width="80">
        </div>
    </div>

    {{-- ================= PARTY INFO ================= --}}
    @foreach ($ledgers as $recipt)
    <div class="info-container">
        <div class="cust_info">
            <strong>Party:</strong> {{ $recipt->account_name ?? 'N/A' }} <br>
            <strong>Transaction:</strong> {{ $recipt->payment_mode_name }} <br>
<br>
               <span style="font-style: italic;">
    {{ amountInWords($recipt->amount) }}
</span>
<br><br>
            <span>As per detail given below</span>
         
        </div>

        <div class="voucher_info">
            <strong>  <h5>Receipt No:</strong> {{ $recipt->voucher_no }}</h5> <br>
            <strong> <h5>Date:</strong> {{ $recipt->entry_date }}</h5>
        </div>
    </div>
    @endforeach

    {{-- ================= HALF PAYMENT ================= --}}
    <div class="half_pay">
        <h5>Half Payment</h5>
    </div>

    {{-- ================= AMOUNT DETAIL (RIGHT SIDE) ================= --}}
    @foreach ($ledgers as $detail)
    <div class="amount-box">
        <p><strong>Discount (if any):</strong></p>
        
        <hr>
        <h3>Grand Total: ₹ {{ number_format($detail->amount,2) }}</h3>
    </div>
    @endforeach

    {{-- ================= AUTHORIZED SIGN ================= --}}
    <div class="signature-box">
        <div class="signature-line"></div>
        <strong>Authorized Signatory</strong><br>
        <span>For {{ $componyinfo->cominfo_firm_name }}</span>
    </div>
      {{-- ======================Voucher Footer============================ --}}
    <div class="voucher_footer">
                <div class="terms "style="background-color:#e6ecff">
                    <h5>Terms & Conditions</h5>
                    <span>{{ $compinfofooter->terms }}</span>
                </div>
                <div class="for_companyname"style="background-color:#e6ecff"><span>For
                        {{ $componyinfo->cominfo_firm_name }}</span><br></div>
                <div class="bank_detail"style="background-color:#e6ecff">
                    <span>Bank Name:{{ $compinfofooter->bank_name }}</span><br>
                    <span>Bank A/C No :{{ $compinfofooter->bank_ac_no }}</span><br>
                    <span>Bank IFSC:{{ $compinfofooter->bank_ifsc }}</span><br>
                    <span>Bank Branch:{{ $compinfofooter->bank_branch }}</span><br>
                </div>
                <div class="qr_code"style="background-color:#e6ecff">
                    <span>Bank id:{{ $compinfofooter->upiid }}</span><br>
                    &nbsp;<img src="/storage/image/{{ $pic->qrcode }}" alt="qr_code" width="80px">
                </div>
                <div class="comp_sign"style="background-color:#e6ecff">

                    &nbsp;<img src="{{ asset('storage/image/' . $pic->seal) }}" alt="qr_code" width="80px">
                </div>
            </div>

    {{-- ================= PRINT ================= --}}
  <div class="button-container mt-3 text-center no-print">
    <button class="btn btn-success btn-lg" onclick="window.print()">Print</button>
</div>


</div>

</body>
</html>
@endsection
