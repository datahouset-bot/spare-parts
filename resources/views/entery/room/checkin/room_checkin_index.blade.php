<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css')}}">

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
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

/* ================= HEADER ================= */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    background: linear-gradient(135deg, #f8fafc, #eef2f7);
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

/* ================= BUTTONS ================= */
.action-buttons {
    text-align: center;
    padding: 12px;
}

.action-buttons .btn {
    margin: 4px;
    padding: 7px 18px;
    border-radius: 25px;
    font-weight: 600;
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
    opacity: .85;
    transition: transform .15s ease, opacity .15s ease;
}

.table .fa:hover {
    transform: scale(1.25);
    opacity: 1;
}

.fa-print { color: #0d6efd; }
.fa-edit  { color: #0ea5e9; }
.fa-book  { color: #6366f1; }
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

    @if(session('message'))
        <div class="alert alert-primary text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="page-card">

        {{-- HEADER --}}
        <div class="page-header">
            <div class="page-title">
                <i class="fa fa-car"></i> Vehicle Move In
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="action-buttons">
            <a href="{{ url('room_dashboard') }}" class="btn btn-warning">
                <i class="fa fa-dashboard me-1"></i> Dashboard
            </a>
            <a href="{{ url('roomcheckins/create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> New Entry
            </a>
        </div>

        {{-- TABLE --}}
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle" id="remindtable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Registration No</th>
                        <th>Slot No</th>
                        <th>Customer Name</th>
                        <th>Vehicle No</th>
                        <th>Model Year</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th colspan="4" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $r1 = 0; @endphp
                    @foreach ($roomcheckins as $record)
                        <tr>
                            <td>{{ ++$r1 }}</td>
                            <td>{{ $record->check_in_no }}</td>
                            <td>{{ $record->room_nos }}</td>
                            <td>{{ $record->guest_name }}</td>
                            <td>{{ $record->guest_mobile }}</td>
                            <td>{{ $record->no_of_guest }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->checkin_date)->format('d-m-y') }}</td>
                            <td>{{ $record->checkin_time }}</td>

                            <td>
                                <a href="{{ url('checkin_print_format', $record->voucher_no) }}" class="btn btn-sm">
                                    <i class="fa fa-print"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('roomcheckins.edit', $record->voucher_no) }}" class="btn btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('showeditaccount/'.$record->account_id) }}"
                                   class="btn btn-sm"
                                   title="Edit Guest Info">
                                    <i class="fa fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('roomcheckins.destroy', $record->voucher_no) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this Room Check-In?')">
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
