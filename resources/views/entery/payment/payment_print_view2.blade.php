@extends('layouts.blank')
@section('pagecontent')

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
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty',
            50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];

        $str = [];
        $i = 0;
        while ($no > 0) {
            $divider = ($i == 2) ? 10 : 100;
            $number = $no % $divider;
            $no = floor($no / $divider);
            if ($number) {
                $str[] = ($number < 21)
                    ? $words[$number] . ' ' . $digits[$i]
                    : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$i];
            }
            $i++;
        }
        return "Rupees " . implode(' ', array_reverse($str)) . " Only";
    }
}
@endphp

<!DOCTYPE html>
<html>
<head>
<style>
@page { size: A4; margin: 12mm; }

body {
    background: #f2f4f7;
    font-family: "Segoe UI", Arial, sans-serif;
    font-size: 14px;
}

/* MAIN PAGE */
.page {
    width: 210mm;
    margin: auto;
    background: #fff;
    padding: 18px;
    border-radius: 8px;
    box-shadow: 0 0 25px rgba(0,0,0,0.12);
}

/* HEADER */
.header {
    display: grid;
    grid-template-columns: 90px 1fr 90px;
    align-items: center;
    border-bottom: 2px solid #333;
    padding-bottom: 12px;
}
.header img { max-height: 80px; }

.firm_detail {
    text-align: center;
}
.firm_detail h3 {
    margin: 0;
    font-size: 22px;
    color: green;
}
.firm_detail h4 {
    margin: 4px 0;
    font-size: 18px;
}

/* INFO */
.info-box {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    padding-bottom: 10px;
    border-bottom: 1px dashed #ccc;
}
.info-left, .info-right {
    width: 50%;
}
.info-right { text-align: right; }

.amount-words {
    margin-top: 10px;
    padding: 8px 12px;
    background: #f9fafb;
    border-left: 4px solid #333;
    font-style: italic;
}

/* TABLE */
table {
    width: 100%;
    margin-top: 15px;
    border-collapse: collapse;
}
th, td {
    border: 1px solid #333;
    padding: 8px;
    text-align: center;
}
th {
    background: #f1f1f1;
}

/* SUMMARY */
.summary {
    width: 45%;
    margin-left: auto;
    margin-top: 15px;
    border: 1px solid #333;
}
.summary div {
    display: flex;
    justify-content: space-between;
    padding: 8px;
    border-bottom: 1px solid #333;
}
.summary div:last-child {
    font-weight: bold;
    font-size: 16px;
}

/* SIGNATURE */
.signature {
    margin-top: 50px;
    display: flex;
    justify-content: space-between;
}
.sign-box {
    width: 30%;
    text-align: center;
}
.sign-line {
    border-top: 1px solid #333;
    margin-bottom: 6px;
}

/* PRINT */


    /* vouchere footer */
    
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

    <!-- HEADER -->
    <div class="header">
        <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}">
        <div class="firm_detail">
            <h3>PAYMENT RECEIPT</h3>
            <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
            {{ $componyinfo->cominfo_address1 }} {{ $componyinfo->cominfo_address2 }}<br>
            {{ $componyinfo->cominfo_city }} {{ $componyinfo->cominfo_state }} - {{ $componyinfo->cominfo_pincode }}<br>
            Mobile: {{ $componyinfo->cominfo_mobile }}
        </div>
        <img src="{{ asset('storage/app/public/image/'.$pic->brand) }}">
    </div>

    @foreach($ledgers as $recipt)
    <!-- INFO -->
    <div class="info-box">
        <div class="info-left">
            <strong>Party:</strong> {{ $recipt->account_name }}<br>
            <strong>Mode:</strong> {{ $recipt->payment_mode_name }}
        </div>
        <div class="info-right">
            <strong>Receipt No:</strong> {{ $recipt->reciept_no }}<br>
            <strong>Date:</strong> {{ $recipt->entry_date }}
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
            <th>#</th><th>Account</th><th>Mode</th>
            <th>Debit</th><th>Credit</th><th>Amount</th>
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
    <!-- SUMMARY -->
    <div class="summary">
        <div><span>Debit</span><span>₹ {{ number_format($detail->debit,2) }}</span></div>
        <div><span>Credit</span><span>₹ {{ number_format($detail->credit,2) }}</span></div>
        <div><span>Total</span><span>₹ {{ number_format($detail->amount,2) }}</span></div>
    </div>
    @endforeach

    <!-- SIGN -->
    <div class="signature">
        <div class="sign-box"><div class="sign-line"></div>Prepared By</div>
        <div class="sign-box"><div class="sign-line"></div>Receiver</div>
        <div class="sign-box"><div class="sign-line"></div>Authorized Signatory</div>
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
