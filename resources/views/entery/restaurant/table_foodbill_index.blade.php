<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<style>
/* ================= PAGE BACKGROUND ================= */
body {
    background: #f4f6fb;
    font-family: "Segoe UI", system-ui, sans-serif;
}

/* ================= CARD ================= */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 12px 32px rgba(0,0,0,0.08);
}

/* ================= HEADER ================= */
.card-header {
    background: linear-gradient(135deg, #ffffff, #eef2f7);
    border-bottom: 1px solid #e5e7eb;
    padding: 14px 18px;
}

.card-header h4 {
    margin: 0;
    font-weight: 700;
    color: #1f2937;
}

/* ================= FILTER BAR ================= */
.card-header form {
    align-items: center;
}

.card-header input {
    border-radius: 10px;
}

.card-header .btn {
    border-radius: 25px;
    padding: 6px 18px;
    font-weight: 600;
}

/* ================= REPORT PERIOD ================= */
.report-range {
    display: block;
    text-align: center;
    font-size: 15px;
    font-weight: 600;
    margin: 8px 0 14px;
    color: #374151;
}

/* ================= TABLE ================= */
.table-scrollable {
    background: #fff;
    border-radius: 12px;
    padding: 12px;
}

table {
    border-collapse: separate;
    border-spacing: 0;
}

/* Header */
thead th {
    background: #f1f5f9;
    font-weight: 700;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

/* Cells */
td {
    padding: 8px !important;
    vertical-align: middle;
}

/* Hover row */
tbody tr {
    transition: background 0.2s ease, transform 0.15s ease;
}

tbody tr:hover {
    background: #f8fafc;
    transform: scale(1.002);
}

/* ================= STATUS ================= */
td:nth-child(8) {
    font-weight: 700;
    color: #16a34a;
}

/* ================= TOTAL HIGHLIGHT ================= */
tfoot th,
tfoot td {
    background: #f9fafb;
    font-weight: 800;
    border-top: 2px solid #e5e7eb;
}

/* ================= ACTION ICONS ================= */
.btn-sm i {
    transition: transform 0.15s ease, opacity 0.15s ease;
}

.btn-sm:hover i {
    transform: scale(1.2);
    opacity: 0.9;
}

/* ================= DATATABLE BUTTONS ================= */
.dt-buttons .dt-button {
    border-radius: 20px !important;
    background: #e5e7eb !important;
    border: none !important;
    font-weight: 600;
    padding: 6px 14px !important;
}

.dt-buttons .dt-button:hover {
    background: #2563eb !important;
    color: #fff !important;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .card-header form .col-md-2,
    .card-header form .col-md-1 {
        margin-bottom: 6px;
    }

    .card-header h4 {
        text-align: center;
        margin-bottom: 8px;
    }

    .btn {
        width: 100%;
    }
}
</style>



    {{-- <script>
        $(document).ready(function() {
            let table = new DataTable('#remindtable');

        });
    </script> --}}
    <div class="container ">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif
        @if (session('errors'))
            <div class="alert alert-danger">
                {{ session('errors') }}
            </div>
        @endif


        <div class="card">
            <div class="card-header col-md-12 text-center">
                <form action="{{ url('rest_foodbill_index_register') }}" method="POST">
                    @csrf

                    <div class="row ">
                        <div class="col-md-4 ">
                            <h4>Spare parts Bill</h4>
                        </div>
                        <div class="col-md-2 ">

                            @php
                                use Carbon\Carbon;
                                $defaultDate = $from_date
                                    ? Carbon::parse($from_date)->format('d-m-Y')
                                    : Carbon::now('Asia/Kolkata')->format('d-m-Y');
                            @endphp

                            <input type="text" class="form-control gdate" id="from_date" name="from_date"
                                value="{{ $defaultDate }}" required>







                        </div>
                        <div class="col-md-2 ">
                            <input type="text" class="form-control gdate" id="to_date" name="to_date"
                                value="{{ \Carbon\Carbon::parse($to_date)->format('d-m-Y') }}" required>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-block">OK</button>


                        </div>
                        <div class="col-md-2">

                            <a href="{{ route('foodbills.create') }}" class="btn btn-success">New Parts Bill</a>
                        </div>

                </form>



            </div>
        </div>
        
        <div class="row my-2">

        </div>







        {{-- data table start  --}}
        
        <div class="card-body table-scrollable">

            <table class="table table-striped" id="remindtable">
                @php

                    $formattedFromDate = Carbon::parse($from_date)->format('d-m-y');
                    $formattedToDate = Carbon::parse($to_date)->format('d-m-y');
                @endphp
                   <span class="report-range">
    Report From {{ $formattedFromDate }} to {{ $formattedToDate }}
</span>

               
              
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col"> Date </th>
                        <th scope="col"> Bill No </th>
                        {{-- <th scope="col"> Service On </th> --}}
                        <th scope="col">Customer Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col"> Total Qty </th>
                        <th scope="col"> Total Amount </th>
                        <th scope="col"> Status </th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $r1 = 0;
                    @endphp
                    @foreach ($foodbills as $record)
                        <tr>

                            <th scope="row">{{ $r1 = $r1 + 1 }}</th>
                            <td scope="col">{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}
                            </td>
                            <td>{{ $record['food_bill_no'] }}</td>
                            @php
                                $service_id = $record['service_id'];
                                // $result_checkin = collect($roomcheckins)->firstWhere('voucher_no', $service_id);
                            @endphp


                            {{-- <td>{{ $record['service_id'] }}</td> --}}
                            <td>{{ $record['customer_name'] }}</td>
                            <td>{{ $record['mobile'] }}</td>
                            {{-- <td>{{$result_checkin->guest_name}}||{{$result_checkin->room_no}}</td> --}}
                            <td>{{ $record['total_qty'] }}</td>
                            <td>{{ $record['net_food_bill_amount'] }}</td>
                            <td>{{ $record['status'] }}</td>



                            <td>
                                {{-- we are send 1 for  ask this function is only for settel  --}}
                                <a href="{{ url('table_facthkot_records_edit', ['voucher_no' => $record['voucher_no'], 'service_id' => $record['service_id'], '1']) }}"
                                    class="btn btn-sm">
                                    <i class="fa fa-book" style="font-size:20px;color:rgb(4, 236, 23)"></i>
                                </a>

                            </td>
                            <td>
                                <a href="{{ url('table_foodbill_print_view', $record['voucher_no']) }}" class="btn btn-sm">
                                    <i class="fa fa-print" style="font-size:20px;color:rgb(3, 1, 15)"></i>
                                </a>

                            </td>

                            <td>
                                <a href="{{ url('table_foodbill_print_view', $record['voucher_no']) }}"
                                    class="btn  btn-sm"><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                            </td>
                            <td>
                                {{-- sendig 0 for this function for edit not only settel  --}}
                                <a href="{{ url('table_facthkot_records_edit', ['voucher_no' => $record['voucher_no'], 'service_id' => $record['service_id'], '0']) }}"
                                    class="btn btn-sm">
                                    <i class="fa fa-edit" style="font-size:20px;color:rgb(241, 11, 192)"></i>
                                </a>
                            </td>



                            <td>
                                <a href="{{ url('delete_foodbill', $record['voucher_no']) }}" style="display:inline;">

                                    <button type="submit" class="btn  btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this  Record ?')"><i
                                            class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align:right">Total:</th>
                        <th id="totalQty">0</th>
                        <th id="totalAmount">0</th>
                        <th colspan="6"></th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    <script>
        // $(document).ready(function() {

        //     new DataTable('#remindtable', {
        //         layout: {
        //             topStart: {
        //                 buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        //             }
        //         }
        //     });


        // });
        $(document).ready(function() {
            $('#remindtable').DataTable({
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Helper to parse float safely
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            parseFloat(i.replace(/[\₹,]/g, '')) || 0 :
                            typeof i === 'number' ? i : 0;
                    };

                    // Total over all pages
                    let totalQty = api
                        .column(5)
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    let totalAmt = api
                        .column(6)
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // Update footer
                    $(api.column(5).footer()).html(totalQty);
                    $(api.column(6).footer()).html(totalAmt.toFixed(2));
                }
            });
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>
    <script>
        $(function() {
            $(".gdate").datepicker({
                dateFormat: "dd-mm-yy"
            });
        });
    </script>

    </script>
@endsection
