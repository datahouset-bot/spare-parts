<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CCTV Service Report</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 13px;
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        .section-heading {
            background: #000;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 6px;
            margin: 15px 0 8px 0;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
            width: 25%;
        }

        .signature td {
            height: 80px;
            text-align: center;
            vertical-align: bottom;
        }
    </style>
</head>
<body>

<h3>CUSTOMER SERVICE REPORT</h3>

<div class="section-heading">Customer Details</div>
<table>
    <tr><th>CSR</th><td>{{ $visit->csr }}</td><th>Date</th><td>{{ $visit->date }}</td></tr>
    <tr><th>Customer Name</th><td>{{ $visit->customer_name }}</td><th>Status</th><td>{{ $visit->call_status }}</td></tr>
    <tr><th>Address</th><td>{{ $visit->address }}</td><th>City</th><td>{{ $visit->city }}</td></tr>
    <tr><th>State</th><td>{{ $visit->state }}</td><th>Product</th><td>{{ $visit->product }}</td></tr>
</table>

<div class="section-heading">Nature of Problem</div>
<table>
    <tr><th>Problem</th><td>{{ $visit->problem }}</td></tr>
    <tr><th>System Status</th><td>{{ $visit->system_status }}</td></tr>
    <tr><th>Equipment</th><td>{{ $visit->equipment_type }}</td></tr>
    <tr><th>Make</th><td>{{ $visit->make }}</td></tr>
    <tr><th>Serial No</th><td>{{ $visit->serial_no }}</td></tr>
    <tr><th>Reported By</th><td>{{ $visit->reported }}</td></tr>
    <tr><th>Location</th><td>{{ $visit->location }}</td></tr>
</table>

<div class="section-heading">Service Details</div>
<table>
    <tr><th>Service Date</th><td>{{ $visit->serviceDate }}</td><th>Time</th><td>{{ $visit->servicetime }}</td></tr>
    <tr><th>Service Rendered</th><td colspan="3">{{ $visit->rendered }}</td></tr>
</table>

<table class="signature">
    <tr>
        <td>Customer Signature</td>
        <td>Service Engineer Signature</td>
    </tr>
</table>

</body>
</html>
