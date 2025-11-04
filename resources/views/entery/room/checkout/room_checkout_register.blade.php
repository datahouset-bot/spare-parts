@extends('layouts.blank')
@section('pagecontent')

<!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>
<script src="{{ global_asset('/general_assets/js/form.js') }}"></script>

<style>
    td,th,tr {
        margin: 1px !important;
        padding: 1px !important;
    }

</style>

<div class="container">
    @if(session('message'))
    <div class="alert alert-primary">{{ session('message') }}</div>
    @endif

    <div class="card my-3">
        <div class="card-header text-center">
            <form action="{{ url('roomcheckout_register') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <h4>Move Out Register</h4>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control gdate" name="from_date"
                            value="{{ \Carbon\Carbon::parse($from_date)->format('d-m-Y') }}" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control gdate" name="to_date"
                            value="{{ \Carbon\Carbon::parse($to_date)->format('d-m-Y') }}" required>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-block">OK</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-scrollable">
            <table class="display" id="remindtable">
                <thead>
                    <tr>
                        <th>S.No</th><th>Bill No</th><th>Bill Date</th><th>Vehicle No</th><th>customer Name</th>
                        <th>Address</th><th>City</th><th>Mobile</th><th>Email</th><th>State</th><th>GST No</th>
                        <th>Check in</th><th>Check Out</th><th>Days</th><th>Food Amt</th>
                        <th>GST %</th><th>SGST</th>
                        <th>CGST</th><th>IGST</th><th>Taxable</th><th>Total GST</th><th>Bill Amt</th>
                        <th>Advance</th><th>Net Pay</th><th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $r1 = 0; @endphp
                    @foreach ($roomcheckouts as $record)
                    <tr>
                        <td>{{ ++$r1 }}</td>
                        <td>{{ $record->check_out_no }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->checkout_date)->format('d-m-y') }}</td>
                        <td>{{ $record->room_no }}</td>
                        <td>{{ $record->guest_name }}</td>
                        <td>{{ $record->account->address }}</td>
                        <td>{{ $record->account->city }}</td>
                        <td>{{ $record->account->mobile }}</td>
                        <td>{{ $record->account->email }}</td>
                        <td>{{ $record->account->state }}</td>
                        <td>{{ $record->account->gst_no }}</td>
                        {{-- <td>{{ \Carbon\Carbon::parse($record->checkin_date)->format('d-m-y') }}</td> --}}
                        {{-- <td>{{ \Carbon\Carbon::parse($record->checkout_date)->format('d-m-y') }}</td> --}}
                        {{-- <td>{{ $record->no_of_days }}</td> --}}
                        <td>{{ $record->total_food_amt }}</td>
                        <td>{{ $record->gst_id }}</td>
                        <td>{{ $record->sgst }}</td>
                        <td>{{ $record->cgst }}</td>
                        <td>{{ $record->igst }}</td>
                        <td>{{ $record->total_room_rent }}</td>
                        <td>{{ $record->gst_total }}</td>
                        <td>{{ $record->total_billamount }}</td>
                        <td>{{ $record->total_advance }}</td>
                        <td>{{ $record->balance_to_pay }}</td>
                        <td>
                            <a href="{{ url('room_checkout_view', $record->voucher_no) }}" class="btn btn-sm">
                                <i class="fa fa-eye" style="color:SlateBlue;font-size:20px"></i>
                            </a>
                        </td>
                        <td>
                            <a href="https://wa.me/{{ $record->guest_mobile }}">
                                <i class="fa fa-bullhorn" style="color:green;font-size:20px"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="14" style="text-align:right">Total:</th>
                        <th id="total_food_amt"></th><th></th>
                        <th id="sgst_total"></th><th id="cgst_total"></th><th id="igst_total"></th>
                        <th id="taxable_total"></th><th id="gst_total"></th><th id="bill_total"></th>
                        <th id="advance_total"></th><th id="netpay_total"></th><th></th><th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#remindtable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel',
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 8; // Smaller font for more fit
                    doc.styles.tableHeader.fontSize = 9;
                    doc.styles.tableHeader.alignment = 'center';
                    doc.content[1].margin = [0, 0, 0, 0]; // Remove extra padding
                    // Adjust column widths manually if needed
                    const colCount = doc.content[1].table.body[0].length;
                    doc.content[1].table.widths = Array(colCount).fill('*'); // or specify e.g., ['5%', '10%', '10%', ...]
                    // doc.content[1].table.widths = ['4%', '2%', '10%', '10%', '10%', '*', '*', '*']; 
                }
            },
            'print'
        ],
        pageLength: 10,
        footerCallback: function (row, data, start, end, display) {
            function toNumber(i) {
                return typeof i === 'string' ?
                    parseFloat(i.replace(/[^0-9.-]+/g, '')) || 0 :
                    typeof i === 'number' ? i : 0;
            }

            let api = this.api();
            let totalCols = [14, 16, 17, 18, 19, 20, 21, 22, 23];

            totalCols.forEach(function (colIdx) {
                let total = api.column(colIdx).data().reduce(function (a, b) {
                    return toNumber(a) + toNumber(b);
                }, 0);
                $(api.column(colIdx).footer()).html(total.toFixed(2));
            });
        }
    });
});
</script>


@endsection
