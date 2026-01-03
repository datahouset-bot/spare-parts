<!DOCTYPE html>
<html>
<head>
    <title>CCTV Service Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-size: 14px;
            padding: 20px;
        }

        .section-heading {
            background: #000;
            color: #fff;
            text-align: center;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 8px 0;
            margin: 20px 0 10px 0;
            font-size: 15px;
            text-transform: uppercase;
        }

        table th {
            width: 25%;
            background: #f2f2f2;
        }

        table td, table th {
            padding: 8px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <a href="{{ route('cctv.pdf', $visit->id) }}"
   class="btn btn-sm btn-danger">
    PDF
</a>


<div class="no-print text-end mb-3">
    <button onclick="window.print()" class="btn btn-primary">
        Print
    </button>
</div>

<h4 class="text-center fw-bold mb-3">
    CUSTOMER SERVICE REPORT
</h4>

{{-- ================= CUSTOMER DETAILS ================= --}}
<div class="section-heading">Customer Details</div>

<table class="table table-bordered">
    <tr>
        <th>CSR</th>
        <td>{{ $visit->csr }}</td>
        <th>Date</th>
        <td>{{ $visit->date }}</td>
    </tr>
    <tr>
        <th>Customer Name</th>
        <td>{{ $visit->customer_name }}</td>
        <th>Status of Call</th>
        <td>{{ $visit->call_status }}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>{{ $visit->address }}</td>
        <th>City</th>
        <td>{{ $visit->city }}</td>
    </tr>
    <tr>
        <th>State</th>
        <td>{{ $visit->state }}</td>
        <th>Product</th>
        <td>{{ $visit->product }}</td>
    </tr>
</table>

{{-- ================= NATURE OF PROBLEM ================= --}}
<div class="section-heading">Nature of Problem</div>

<table class="table table-bordered">
    <tr>
        <th>Problem Reported</th>
        <td>{{ $visit->problem }}</td>
    </tr>
    <tr>
        <th>System Status</th>
        <td>{{ $visit->system_status }}</td>
    </tr>
    <tr>
        <th>Equipment Type</th>
        <td>{{ $visit->equipment_type }}</td>
    </tr>
    <tr>
        <th>Make</th>
        <td>{{ $visit->make }}</td>
    </tr>
    <tr>
        <th>Serial No</th>
        <td>{{ $visit->serial_no }}</td>
    </tr>
    <tr>
        <th>Reported By</th>
        <td>{{ $visit->reported }}</td>
    </tr>
    <tr>
        <th>Installation Location</th>
        <td>{{ $visit->location }}</td>
    </tr>
</table>

{{-- ================= SERVICE DETAILS ================= --}}
<div class="section-heading">Service Details</div>

<table class="table table-bordered">
    <tr>
        <th>Service Date</th>
        <td>{{ $visit->serviceDate }}</td>
        <th>Service Time</th>
        <td>{{ $visit->servicetime }}</td>
    </tr>
    <tr>
        <th>Service Rendered</th>
        <td colspan="3">{{ $visit->rendered }}</td>
    </tr>
</table>

{{-- ================= SIGNATURE ================= --}}
<br><br>

<table class="table table-bordered">
    <tr>
        <td height="80" class="text-center">
            Customer Signature
        </td>
        <td height="80" class="text-center">
            Service Engineer Signature
        </td>
    </tr>
</table>

</body>
</html>
