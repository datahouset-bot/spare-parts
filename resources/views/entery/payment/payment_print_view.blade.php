


            

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
@page { size: A4; margin: 10mm; }

body {
    font-family: "Times New Roman", serif;
}

.page {
    width: 80%;
    margin: auto;
    border: 1px solid #000;
    padding: 10px;
}

/* HEADER */
.company_info {
    display: grid;
    grid-template-columns: 1fr 4fr 1fr;
    border-bottom: 1px solid #000;
    padding-bottom: 5px;
}

.firm_detail { text-align: center; }

/* PARTY INFO */
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

/* HALF PAYMENT */
.half_pay {
    border: 1px solid #000;
    padding: 15px;
    margin-top: 10px;
}

/* AMOUNT */
.amount-box {
    width: 50%;
    margin-left: auto;
    border: 1px solid #000;
    padding: 10px;
}

/* SIGNATURE */
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
 td,th{
                    border: solid 1px;
                }
            .detail {
                background-color: silver;
                width: 100%;
                text-align: center;
            }



            .table_detail {
background-color:white;
                width: 100%;
                padding: 2px;
                
            }

            .th_detail {
                color: white;
                background-color:rgb(58, 58, 58);
                border: none;
                text-align: center;
            }

            
@media print {
    button { display: none; }
}
</style>
</head>

<body>

<div class="page">

    {{-- HEADER --}}
    <div class="company_info">
        <div>
            <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}" width="90%">
        </div>

        <div class="firm_detail">
            <h3 style="color:green;">PAYMENTS</h3>
            <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
            {{ $componyinfo->cominfo_address1 }} {{ $componyinfo->cominfo_address2 }} <br>
            {{ $componyinfo->cominfo_city }} {{ $componyinfo->cominfo_state }} {{ $componyinfo->cominfo_pincode }} <br>
            Mobile: {{ $componyinfo->cominfo_mobile }}
        </div>
    </div>

    {{-- PARTY INFO --}}
    @foreach($ledgers as $recipt)
    <div class="info-container">
        <div class="cust_info">
            <strong>Party:</strong> {{ $recipt->account_name }} <br>
            <strong>Transaction:</strong> {{ $recipt->payment_mode_name }} <br><br>

            <em>{{ amountInWords($recipt->amount) }}</em><br><br>
            <span>As per detail given below</span>
        </div>

        <div class="voucher_info">
            <strong>Invoice No:</strong> {{ $recipt->reciept_no }} <br>
            <strong>Date:</strong> {{ $recipt->entry_date }}
        </div>
    </div>
    @endforeach

    <div class="detail">



                <table class="table_detail">
                    <thead>

                        <tr>
                            <th class="th_detail">S.no</th>
                            <th class="th_detail">Item Name</th>
                            <th class="th_detail">Payment mode</th>
                            <th class="th_detail">Debit</th>

                            <th class="th_detail">Credit</th>
                            <th class="th_detail">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $sno=0;
                        @endphp
                        @foreach ($ledgers as $records )
                        <tr>
                            <td>{{$sno=$sno+1}}</td>
                          <td>{{$records->account_name}}</td>
                           <td>{{ ($records->payment_mode_name) }}</td>
                          <td>{{ ($records->debit)}}</td>
                          <td>{{ ($records->credit)}}</td>

                          <td>{{ number_format($records->amount)}}</td>  
                        </tr>
                            
                        @endforeach
  
                </table>

            </div>

    {{-- HALF PAYMENT --}}
    <div class="half_pay">
        <h5>Half Payment</h5>
    </div>
<br>
    {{-- AMOUNT --}}
    @foreach($ledgers as $detail)
    <div class="amount-box">
        <p><strong>Discount (if any):</strong></p>
        <hr>
        <h5>DEBIT: ₹ {{ number_format($detail->debit,2) }}</h5>
        <h5>CREDIT: ₹ {{ number_format($detail->credit,2) }}</h5>
        <h5>REMARK: ₹ {{ ($detail->remark) }}</h5>
        <hr>
        <h3>Grand Total: ₹ {{ number_format($detail->amount,2) }}</h3>
    </div>
    @endforeach

    {{-- SIGNATURE --}}
    <div class="signature-box">
        <div class="signature-line"></div>
        <strong>Authorized Signatory</strong><br>
        <span>For {{ $componyinfo->cominfo_firm_name }}</span>
    </div>

    {{-- PRINT --}}
    <div class="text-center mt-3">
        <button class="btn btn-success btn-lg" onclick="window.print()">Print</button>
    </div>

</div>

</body>
</html>
@endsection