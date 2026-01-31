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
    font-family: "Segoe UI", Arial, sans-serif;
}

/* ================= CARD ================= */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
}

.card-header {
    background: linear-gradient(135deg, #ffffff, #eef2f7);
    font-size: 18px;
    font-weight: 700;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* ================= TOP BUTTONS ================= */
.top-actions {
    text-align: center;
    margin-bottom: 12px;
}

.top-actions .btn {
    margin: 4px;
    padding: 8px 16px;
    border-radius: 30px;
    font-weight: 600;
}

/* ================= TABLE ================= */
.table {
    font-size: 14px;
    background: #fff;
}

.table thead th {
    background: #f1f5f9;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: .4px;
    font-weight: 700;
}

.table tbody tr {
    transition: background .15s ease;
}

.table tbody tr:hover {
    background: #f0f7ff;
}

.table td,
.table th {
    vertical-align: middle;
    white-space: nowrap;
}

/* ================= ACTION ICONS ================= */
.action-btn {
    border: none;
    background: transparent;
    padding: 0 4px;
}

.action-btn i {
    font-size: 18px;
    transition: transform .15s ease, opacity .15s ease;
}

.action-btn i:hover {
    transform: scale(1.25);
    opacity: 1;
}

.fa-print { color: #6366f1; }
.fa-eye { color: #0d6efd; }
.fa-check { color: #16a34a; }
.fa-edit { color: #6f42c1; }
.fa-trash { color: #dc2626; }

/* ================= ALERT ================= */
.alert {
    border-radius: 10px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }

    .table {
        font-size: 13px;
    }
}
</style>

<script>
$(document).ready(function () {
    new DataTable('#remindtable', {
        pageLength: 10,
        lengthChange: false
    });
});
</script>

<div class="container mt-3">

    {{-- MESSAGE --}}
    @if(session('message'))
        <div class="alert alert-primary text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="card my-3">

        {{-- HEADER --}}
        <div class="card-header">
            <span>🚗 Spare-Parts Booking</span>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="top-actions">
            <a href="{{ url('room_dashboard') }}" class="btn btn-warning">
                <i class="fa fa-dashboard me-1"></i> Dashboard
            </a>

            <a href="{{ route('roombookings.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Book New Parts
            </a>

            <a href="{{ url('pending_booking') }}" class="btn btn-danger">
                <i class="fa fa-clock-o me-1"></i> Waiting
            </a>

            <a href="{{ url('/clear_booking') }}" class="btn btn-dark">
                <i class="fa fa-sign-out me-1"></i> Move Out
            </a>
        </div>

        {{-- TABLE --}}
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle" id="remindtable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Slot No</th>
                        <th>Vehicle No</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Booking Date</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th colspan="5" class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @php $r1 = 0; @endphp
                    @foreach ($roombooking as $record)
                        <tr>
                            <td>{{ ++$r1 }}</td>
                            <td>{{ $record->room_nos }}</td>
                            <td>{{ $record->booking_no }}</td>
                            <td>{{ $record->guest_name }}</td>
                            <td>{{ $record->guest_mobile }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->booking_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->checkin_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->checkout_date)->format('d-m-Y') }}</td>

                            <td>
                                <button class="action-btn" onclick="printRoomBooking({{ $record->voucher_no }})">
                                    <i class="fa fa-print"></i>
                                </button>
                            </td>

                            <td>
                                <a href="{{ url('roombooking_view', $record->voucher_no) }}" class="action-btn">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>

                            <td>
                                <a href="{{ url('roombooking_confirm', $record->voucher_no) }}" class="action-btn">
                                    <i class="fa fa-check"></i>
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('roombookings.edit', $record->voucher_no) }}" class="action-btn">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('roombookings.destroy', $record->voucher_no) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn"
                                        onclick="return confirm('Are you sure you want to delete this booking?')">
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
