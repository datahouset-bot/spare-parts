
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    @page {
        size: A4;
        margin: 20mm;
    }

    body {
        font-size: 14px;
        color: #000;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px 8px;
        vertical-align: top;
    }

    th {
        width: 30%;
        background: #f3f3f3;
    }

  .company_info {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    border-bottom: 3px solid #000;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.logo1,
.logo2 {
    width: 90px;
    text-align: center;
}

.logo1 img,
.logo2 img {
    max-width: 80px;
    max-height: 80px;
}

.firm_detail {
    text-align: center;
    line-height: 1.4;
}

.firm_detail h4 {
    margin: 0;
    font-weight: 700;
}

.small-text {
    font-size: 12px;
}


    .terms-section {
        margin-top: 15px;
    }

    .terms-title {
        font-weight: 700;
        margin-bottom: 5px;
        display: block;
    }

    .terms-text {
        white-space: pre-line;
        line-height: 1.6;
        text-align: justify;
    }

   .photo-pair {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .photo-box {
            width: 48%;
            text-align: center;
        }

        .photo-box img {
            max-width: 100%;
            max-height: 180px;
            border: 1px solid #000;
        }
/* Blank passport-size document box */
.document-frame {
    width: 135px;      /* passport width */
    height: 170px;     /* passport height */
    border: 1.5px solid #000;
    margin: 0 auto;
}


    .signature-section {
        display: flex;
        justify-content: space-between;
        margin-top: 60px;
    }

    .signature-box {
        width: 45%;
        text-align: center;
    }

    .signature-line {
        border-top: 2px solid #000;
        margin-top: 45px;
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
{{-- COMPANY HEADER --}}
<div class="company_info">
    <div class="logo1">
            <img src="{{ asset('storage/app/public/image/'.$pic->logo) }}" alt="Logo" width="80">
    </div>
    <div class="firm_detail">
        <h4>{{ $componyinfo->cominfo_firm_name }}</h4>
        <div class="small-text">
            {{ $componyinfo->cominfo_address1 }}
            {{ $componyinfo->cominfo_address2 }},
            {{ $componyinfo->cominfo_city }},
            {{ $componyinfo->cominfo_state }}
            {{ $componyinfo->cominfo_pincode }},
            {{ $compinfofooter->country }}
        </div>
        <div class="small-text">
            Email: {{ $componyinfo->cominfo_email }}
            &nbsp; | &nbsp;
            Phone: {{ $componyinfo->cominfo_phone }}
            &nbsp; | &nbsp;
            Mobile: {{ $componyinfo->cominfo_mobile }}
        </div>
    </div>
</div>


<h5 class="text-center fw-bold">Employee Details</h5>

{{-- EMPLOYEE DETAILS --}}
<table>
    <tr><th>Employee ID</th><td>{{ $employee->af5 }}</td></tr>
    <tr><th>Name</th><td>{{ $employee->name }}</td></tr>
    <tr><th>Email</th><td>{{ $employee->email ?? '-' }}</td></tr>
    <tr><th>Mobile</th><td>{{ $employee->mobile ?? '-' }}</td></tr>
    <tr><th>Address</th><td>{{ $employee->address ?? '-' }}</td></tr>
    <tr><th>Designation</th><td>{{ $employee->af6 ?? '-' }}</td></tr>
    <tr><th>Salary</th><td>{{ $employee->salary_amount ?? '-' }}</td></tr>
    <tr><th>Date of Joining</th><td>{{ $employee->date_of_joining ?? '-' }}</td></tr>
    <tr><th>Document Type</th><td>{{ $employee->document_type ?? '-' }}</td></tr>
    <tr><th>Document Number</th><td>{{ $employee->document_no ?? '-' }}</td></tr>
    <tr><th>Report Time</th><td>{{ $employee->Report_time ?? '-' }}</td></tr>
    <tr><th>Buffer Time</th><td>{{ $employee->Buffer_time ?? '-' }}</td></tr>
</table>

{{-- TERMS & CONDITIONS --}}
<div class="terms-section">
    <span class="terms-title">Terms and Conditions:</span>
    <div class="terms-text">
        {{ $employee->terms_text ?? '-' }}
    </div>
</div>

{{-- PHOTOS --}}

<div class="photo-pair">
    <div class="photo-box">
        <p class="fw-bold">Employee Photo</p>
                   <img src="{{ asset('storage/app/public/room_image/'.$employee->photo) }}">
            </div>
<div class="photo-box">
    <p class="fw-bold">Document</p>

    <div class="document-frame"></div>
</div>

    </div>
</div>

{{-- SIGNATURES --}}
<div class="signature-section">
    <div class="signature-box">
        <div class="signature-line"></div>
        <strong>Employee Signature</strong>
    </div>

    <div class="signature-box">
        <div class="signature-line"></div>
        <strong>Official Signature</strong>
    </div>
</div>
<div class="d-flex justify-content-between mb-3 no-print">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        ← Back
    </a>

    <button onclick="window.print()" class="btn btn-primary">
        🖨 Print
    </button>
</div>

