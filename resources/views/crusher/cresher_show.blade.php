{{-- @extends('layouts.blank')

@section('pagecontent') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    
<style>
    /* ================= PRINT SETTINGS ================= */
  @media print {

    /* existing rules */
    .card-footer,
    .btn,
    button {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    body {
        background: #fff !important;
        margin: 0;
    }

    /* === IMPORTANT FIX === */
    .challan-wrapper {
        page-break-after: always;
        page-break-inside: avoid;
    }
}

    /* ============== CHALLAN LAYOUT ============== */
    .challan-wrapper {
        max-width: 650px;
        margin: 20px auto;
        padding: 30px 25px 40px;
        border: 1px solid #000;
        background: #fff;
    }

    /* ==== LOGO ROW (like reference image) ==== */
    .logo-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .logo-left,
    .logo-center,
    .logo-right {
        flex: 1;
    }

    .logo-left {
        text-align: left;
    }

    .logo-center {
        text-align: center;
    }

    .logo-right {
        text-align: right;
    }

    .logo-row img {
        max-height: 80px;
        width: auto;
    }

    .challan-title-bar {
        background: #333;
        color: #fff;
        text-align: center;
        padding: 8px 0;
        margin: 20px 0 30px;
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .challan-row {
        display: flex;
        align-items: center;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .challan-label {
        min-width: 110px;
        font-weight: 500;
    }

    .challan-label.short {
        min-width: 80px;
    }

    .challan-dotted {
        flex: 1;
        border-bottom: 1px dotted #000;
        min-height: 20px;
        padding: 0 4px;
        display: flex;
        align-items: center;
    }

    .challan-dotted.small {
        max-width: 160px;
    }

    .challan-multiline {
        min-height: 40px;
    }

    .challan-bottom-space {
        height: 40px;
    }

    .challan-sign-row {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
        font-size: 15px;
        font-weight: 500;
    }

    .challan-sign {
        text-align: center;
        flex: 1;
    }
</style>
</head>
<body>
    <div class="card-body">
    <div class="challan-wrapper">

        {{-- LOGO ROW LIKE SAMPLE IMAGE --}}
        <div class="logo-row">
            <div class="logo-left">
                <img src="{{ asset('storage/app/public/image/' . $pic->logo) }}" alt="left_logo">
                {{-- e.g. excavator image --}}
            </div>
            <div class="logo-center">
                <img src="{{ asset('storage/app/public/image/' . $pic->logo) }}" alt="center_logo">
                {{-- e.g. Durga eyes image --}}
            </div>
            <div class="logo-right">
                <img src="{{ asset('storage/app/public/image/' . $pic->logo) }}" alt="right_logo">
                {{-- e.g. MNM text logo --}}
            </div>
        </div>

        <!-- Title bar like sample -->
        <div class="challan-title-bar">
            मटेरियल चालान
        </div>

        {{-- क्रमांक / दिनांक --}}
        <div class="challan-row">
            <span class="challan-label">क्रमांक</span>
            <span class="challan-dotted small">
                {{ $crusher->slip_no }}
            </span>

            <span class="challan-label short ms-3">दिनांक</span>
            <span class="challan-dotted small">
                {{ \Carbon\Carbon::parse($crusher->date)->format('d-m-Y') }}
            </span>
        </div>

        {{-- समय --}}
        <div class="challan-row">
            <span class="challan-label">समय</span>
            <span class="challan-dotted small">
                {{ $crusher->time }}
            </span>
            <span class="ms-3">सुबह / शाम</span>
        </div>

        {{-- वाहन नं. --}}
        <div class="challan-row">
            <span class="challan-label">वाहन नं.</span>
            <span class="challan-dotted">
                {{ $crusher->vehicle_no }}
            </span>
        </div>

        {{-- माल / रॉयल्टी --}}
        <div class="challan-row">
            <span class="challan-label">माल</span>
            <span class="challan-dotted small">
                {{ $crusher->Material }}
            </span>

            {{-- <span class="challan-label short ms-3">रॉयल्टी</span>
            <span class="challan-dotted small">
                {{ number_format($crusher->Royalty, 2) }}
            </span> --}}
        </div>

        {{-- मात्रा / गाड़ी का नाप --}}
        <div class="challan-row">
            <span class="challan-label">मात्रा</span>
            <span class="challan-dotted small">
                {{ $crusher->Quantity }}
            </span>

            <span class="challan-label short ms-3">गाड़ी का नाप</span>
            <span class="challan-dotted small">
                {{ $crusher->vehicle_measure }}
            </span>
        </div>

        {{-- पार्टी का नाम व पता --}}
        <div class="challan-row">
            <span class="challan-label">पार्टी का नाम व पता:-</span>
            <span class="challan-dotted challan-multiline">
                {{ $crusher->party_name }}
                {{-- , {{ $crusher->address ?? '' }} --}}
                @if($crusher->phone)
                    , {{ $crusher->phone }}
                @endif
            </span>
        </div>

        <div class="challan-row">
            <span class="challan-dotted challan-multiline">
            </span>
        </div>

        {{-- कैश / खाता  /  RST --}}
        <div class="challan-row">
            <span class="challan-label">कैश / खाता</span>
            <span class="challan-dotted small">
                {{-- left blank for manual entry --}}
            </span>

            <span class="challan-label short ms-3">RST</span>
            <span class="challan-dotted small">
                {{ number_format($crusher->Total, 2) }}
            </span>
        </div>

        <div class="challan-bottom-space"></div>

        {{-- Signatures --}}
        <div class="challan-sign-row">
            <div class="challan-sign">
                लोडर ऑपरेटर
            </div>
            <div class="challan-sign">
                हस्ता. ड्राइवर
            </div>
            <div class="challan-sign">
                हस्ता. केशर सुपरवाइजर
            </div>
        </div>

        <div class="card-footer text-center mt-5">
            <a href="{{ route('crusher.index') }}" class="btn btn-dark">
                Back
            </a>

            <a href="{{ route('crusher.edit', $crusher->id) }}" class="btn btn-primary">
                Edit
            </a>

            <button onclick="printChallan()" class="btn btn-success">
                Print
            </button>
        </div>

    </div>
</div>

<script>
    function printChallan() {
        window.print();
    }
</script>

</body>
</html>


{{-- @endsection --}}
