@php
    include public_path('cdn/cdn.blade.php');
@endphp
{{-- <link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}"> --}}

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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>KOT</title>
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

/* ================= PRINT ================= */
@media print {

    html, body {
        width: 210mm;
        height: auto;
        margin: 0;
        padding: 0;
    }

    .page {
        width: 100% !important;
        margin: 0 !important;
        padding: 10mm !important;
        border: 1px solid #000 !important;
        box-sizing: border-box;
        page-break-inside: avoid;
    }

    /* Hide print button */
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

            <div class="company_info">
                <div class="logo1">&nbsp;<img src="{{ asset('torage\app\public\image\\' . $pic->logo) }}" alt="qr_code" width="80px">
                </div>
                <div class="firm_detail">
                          <h3 style="color: green;">PURCHASE</h3>
                    <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
                       {{ $componyinfo->cominfo_address1 }}&nbsp;{{ $componyinfo->cominfo_address2 }}&nbsp;
                    {{ $componyinfo->cominfo_city }}&nbsp;{{ $componyinfo->cominfo_state }}
                        &nbsp;{{ $componyinfo->cominfo_pincode }}&nbsp;{{ $compinfofooter->country }}&nbsp;
                   Email:{{ $componyinfo->cominfo_email }} Phone &nbsp;{{ $componyinfo->cominfo_phone }}
                        Mobile&nbsp;{{ $componyinfo->cominfo_mobile }} 
                </div>
                <div class="logo2"><img src="{{ asset('storage\app\public\image\\' . $pic->brand) }}" alt="qr_code" width="80px">
                </div>
            </div>


            <div class="page_header">
                <div class="info-container">
                    <div class="cust_info">
                        <span>Party:{{$account_detail->account_name}}</span><br>
                        <span>Address:{{ $account_detail->address}} </span><br>
              <span>  {{ $account_detail->address2}}&nbsp;{{ $account_detail->city}}&nbsp;{{ $account_detail->state}}</span> <br>
                            <span style="font-style: italic;">
    {{ amountInWords($voucher_header->total_net_amount) }}
</span>
<br><br>
            <span>As per detail given below</span>
         
                    

{{-- 
                       <span>Name:{{ $guest_detail->guest_name }}</span><br>
                       <span>Mobile No:{{ $guest_detail->guest_mobile }}</span><br>
                       <span>Room No:{{ $guest_detail->room_nos }}</span><br>
                       <span>Check In No   :{{ $guest_detail->voucher_no }}</span><br> --}}
                    </div>
                    <div class="voucher_info">

                        <span>Invoice No : {{ $voucher_header->voucher_no }}</span><br>
                        <span>Date : {{ $voucher_header->voucher_date }}</span><br>
                        <span>Time : {{ $voucher_header->created_at->format('H:i') }}</span><br>
                        <span>Voucher Type : {{ $voucher_header->voucher_type }}</span><br>
                        
                    </div>
                </div>

            </div>
{{-- ================= HALF PAYMENT ================= --}}
    <div class="half_pay">
        <h5>Half Payment</h5>
    </div>

    {{-- ================= AMOUNT DETAIL (RIGHT SIDE) ================= --}}
           
    <div class="amount-box">
        <p><strong>Discount (if any):</strong></p>
        
        <hr>
        <h3>Grand Total: ₹ {{ $voucher_header->total_net_amount}}</h3>
    </div>

{{-- ================= AUTHORIZED SIGN ================= --}}
    <div class="signature-box">
        <div class="signature-line"></div>
        <strong>Authorized Signatory</strong><br>
        <span>For {{ $componyinfo->cominfo_firm_name }}</span>
    </div>

    {{-- ================= PRINT ================= --}}
  <div class="button-container mt-3 text-center no-print">
    <button class="btn btn-success btn-lg" onclick="window.print()">Print</button>
</div>

            </div>



          {{--    <div style="background-color: white" class="my-1">&nbsp;</div>

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
                    <span>Bank Name:{{ $compinfofooter->upiid }}</span><br>
                    &nbsp;<img src="/storage/image/{{ $pic->qrcode }}" alt="qr_code" width="80px">
                    


                </div>
                <div class="comp_sign"style="background-color:#e6ecff">

                    &nbsp;<img src="{{ asset('storage/image/' . $pic->seal) }}" alt="qr_code" width="80px">
                </div>





            </div> --}}

        </div>

      


    </body>

    </html>
@endsection
