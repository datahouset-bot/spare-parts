
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
        }

        .no-print {
            display: none !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f0f0f0;
        }

        tfoot td {
            font-weight: bold;
        }
    }

    table {
        margin-top: 15px;
    }
</style>

<div class="container mt-2">
    @if(session('message'))
        <div class="alert alert-primary">{{ session('message') }}</div>
    @endif

    <div class="no-print">
        <form action="{{ url('fnb_result') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-2 mb-3">
                    <input type="text" class="form-control date" name="from_date" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-2 mb-3">
                    <input type="text" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>
                </div>
            </div>
        </form>
    </div>

    <h3>F & B Report</h3>

    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Bill No</th>
                <th>Bill Date</th>
                <th>Table/Room</th>
                <th>Taxable Food</th>
                <th>Taxable Bar</th>
                <th>GST</th>
                <th>VAT</th>
                <th>Surcharge</th>
                <th>Bill Amount</th>
                <th>Discount</th>
                <th>Round Off</th>
                <th>Cash</th>
                <th>Cr.Card</th>
                <th>Comapany Cr.</th>
                <th>Room Cr</th>
                <th>Company Name</th>
                <th>Status</th>
                <th>Guest Name</th>
                <th>Pax</th>
            </tr>
        </thead>
        <tbody>
            @php $r1 = 0; @endphp
            @if (!empty($combinedData))
                @foreach ($combinedData as $records)
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ ++$r1 }}</td>
                            <td>{{ $record['data']->food_bill_no }}</td>
                            <td>{{ \Carbon\Carbon::parse($record['data']->voucher_date)->format('d-m-Y') }}</td>
                            <td>{{ $record['data']->foodbill_af5 }}</td>
                            <td>{{ $record['data']->total_taxable_amount - ($record['data']->total_vat * 100 / 13) }}</td>
                            <td>{{ $record['data']->total_vat * 100 / 13 }}</td>
                            <td>{{ $record['data']->total_gst_amount }}</td>
                            <td>{{ $record['data']->total_vat }}</td>
                            <td>{{ $record['data']->total_tax1 }}</td>
                            <td>{{ $record['data']->net_food_bill_amount }}</td>
                            <td>{{ $record['data']->cash_discount }}</td>
                            <td>{{ abs($record['data']->roundoff_amt) }}</td>
                            <td>{{ $record['data']->foodbill_af1 }}</td>
                            <td>{{ $record['data']->foodbill_af2 }}</td>
                            <td>{{ $record['data']->foodbill_af3 }}</td>
                            <td>{{ $record['data']->foodbill_af4 }}</td>
                            <td>{{ $record['data']->remark }}</td>
                            <td>{{ $record['data']->foodbill_af5 }}</td>
                            <td>{{ $record['data']->customer_name }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<script>
    // Auto open print dialog on page load
    window.onload = function () {
        window.print();
    }
</script>
