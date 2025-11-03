@extends('layouts.blank')

@section('pagecontent')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<div class="container mt-2">
    @if(session('message'))
        <div class="alert alert-primary">{{ session('message') }}</div>
    @endif

    <div class="card my-1">
        <div class="card-header"><h4>F & B Report</h4></div>
        <div class="container mt-1" id="account_select_form">
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

        <div class="card-body table-scrollable">
            <table class="table table-bordered" id="remindtable">
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
                        <th> Status </th>
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
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right">Total:</th>
                        <th></th> <!-- Taxable Food -->
                        <th></th> <!-- Taxable Bar -->
                        <th></th> <!-- GST -->
                        <th></th> <!-- VAT -->
                        <th></th> <!-- Surcharge -->
                        <th></th> <!-- Bill Amount -->
                        <th></th> <!-- Discount -->
                         <th></th> <!-- round off -->
                        <th></th> <!-- Cash -->
                        <th></th> <!-- Cr.Card -->
                        <th></th> <!-- Company Cr. -->
                        <th></th> <!-- Room Cr -->
                        <th></th> <!-- Company Name -->
                        <th></th> <!-- Room Cr No -->
                        <th></th> <!-- Guest Name -->
                        <th></th> <!-- Pax -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function () {
        let table = new DataTable('#remindtable', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            },
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                function sum(colIdx) {
                    return api.column(colIdx, { page: 'all' }).data().reduce(function (a, b) {
                        let x = parseFloat(a) || 0;
                        let y = parseFloat(b) || 0;
                        return x + y;
                    }, 0);
                }

                // Adjust the column indexes below based on your real table
                const indexes = {
                    taxableFood: 4,
                    taxableBar: 5,
                    gst: 6,
                    vat: 7,
                    surcharge: 8,
                    billAmount: 9,
                    discount: 10
                };

                api.column(indexes.taxableFood).footer().innerHTML = sum(indexes.taxableFood).toFixed(2);
                api.column(indexes.taxableBar).footer().innerHTML = sum(indexes.taxableBar).toFixed(2);
                api.column(indexes.gst).footer().innerHTML = sum(indexes.gst).toFixed(2);
                api.column(indexes.vat).footer().innerHTML = sum(indexes.vat).toFixed(2);
                api.column(indexes.surcharge).footer().innerHTML = sum(indexes.surcharge).toFixed(2);
                api.column(indexes.billAmount).footer().innerHTML = sum(indexes.billAmount).toFixed(2);
                api.column(indexes.discount).footer().innerHTML = sum(indexes.discount).toFixed(2);
            }
        });
    });
</script>
@endsection
