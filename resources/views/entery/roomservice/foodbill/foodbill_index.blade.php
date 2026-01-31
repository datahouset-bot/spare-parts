<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">

@extends('layouts.blank')
@section('pagecontent')

<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

<style>
/* ================= GLOBAL ================= */
body {
    background: #f4f6f9;
    font-family: 'Segoe UI', Arial, sans-serif;
}

/* ================= CARD ================= */
.page-card {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(0,0,0,.08);
    padding: 15px;
}

/* ================= HEADER ================= */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    border-bottom: 1px solid #e5e7eb;
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
}

.page-title i {
    color: #0d6efd;
    margin-right: 6px;
}

/* ================= BUTTON ================= */
.btn-primary {
    border-radius: 25px;
    padding: 7px 18px;
    font-weight: 600;
    box-shadow: 0 6px 15px rgba(13,110,253,.25);
}

/* ================= TABLE ================= */
.table {
    font-size: 14px;
}

.table thead th {
    background: #f1f5f9;
    font-weight: 600;
    color: #334155;
    border-bottom: 2px solid #dee2e6;
}

.table tbody tr {
    transition: background .15s ease;
}

.table tbody tr:hover {
    background: #f8fafc;
}

.table td {
    vertical-align: middle;
}

/* ================= ACTION ICONS ================= */
.table .btn-sm {
    padding: 4px 6px;
}

.table .fa {
    font-size: 18px;
    transition: transform .15s ease, opacity .15s ease;
    opacity: .85;
}

.table .fa:hover {
    transform: scale(1.25);
    opacity: 1;
}

.fa-print { color: #0d6efd; }
.fa-eye   { color: #6366f1; }
.fa-edit  { color: #0ea5e9; }
.fa-trash { color: #ef4444; }

/* ================= ALERT ================= */
.alert {
    border-radius: 10px;
    font-size: 14px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
}
</style>

<script>
$(document).ready(function () {
    new DataTable('#remindtable');
});
</script>

<div class="container my-3">

    @if (session('message'))
        <div class="alert alert-primary text-center">
            {{ session('message') }}
        </div>
    @endif

    @if (session('errors'))
        <div class="alert alert-danger text-center">
            {{ session('errors') }}
        </div>
    @endif

    <div class="page-card">

        {{-- HEADER --}}
        <div class="page-header">
            <div class="page-title">
                <i class="fa fa-cutlery"></i> Service Bill
            </div>

            <a href="{{ route('foodbills.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> New Bill
            </a>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive mt-3">
            <table class="table table-striped align-middle" id="remindtable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th>Invoice No</th>
                        <th>Slot No</th>
                        <th>Customer</th>
                        <th>Total Qty</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th colspan="4" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $r1 = 0; @endphp
                    @foreach ($foodbills as $record)
                        @php
                            $service_id = $record['service_id'];
                            $result_checkin = collect($roomcheckins)->firstWhere('voucher_no', $service_id);
                        @endphp
                        <tr>
                            <td>{{ ++$r1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}</td>
                            <td>{{ $record['food_bill_no'] }}</td>
                            <td>{{ $record['service_id'] }}</td>
                            <td>
                                @if($result_checkin)
                                    {{ $result_checkin->guest_name }} | {{ $result_checkin->room_no }}
                                @endif
                            </td>
                            <td>{{ $record['total_qty'] }}</td>
                            <td>{{ $record['total_bill_value'] }}</td>
                            <td>
                                <span class="badge bg-success">{{ $record['status'] }}</span>
                            </td>

                            <td>
                                <a href="{{ url('foodbill_print_view', $record['voucher_no']) }}" class="btn btn-sm">
                                    <i class="fa fa-print"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('foodbill_print_view_new', $record['voucher_no']) }}" class="btn btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('foodbills.edit', $record['voucher_no']) }}" class="btn btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('foodbills.destroy', $record['voucher_no']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
