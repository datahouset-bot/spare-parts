<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">

@extends('layouts.blank')
@section('pagecontent')

<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

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
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

.card-header {
    background: linear-gradient(135deg, #ffffff, #eef2f7);
    font-size: 18px;
    font-weight: 700;
    padding: 14px 20px;
    border-bottom: 1px solid #e5e9f0;
}

/* ================= FORM ================= */
.form-label {
    font-weight: 600;
    font-size: 14px;
}

.form-control,
.form-select {
    border-radius: 8px;
    font-size: 14px;
}

.form-control:focus,
.form-select:focus {
    box-shadow: 0 0 0 .2rem rgba(13,110,253,.15);
}

/* ================= RADIO FORMAT ================= */
.format-box {
    border: 1px solid #e5e9f0;
    border-radius: 10px;
    padding: 10px;
    background: #fff;
}

.format-box .form-check {
    margin-bottom: 6px;
}

/* ================= BUTTON ================= */
.btn-primary {
    border-radius: 30px;
    padding: 8px 20px;
    font-weight: 600;
}

/* ================= TABLE ================= */
.table-scrollable {
    margin-top: 10px;
}

.table {
    background: #fff;
    font-size: 13px;
}

.table th {
    background: #f1f5f9;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 12px;
}

td {
    padding: 4px !important;
}

/* ================= ALERT ================= */
.alert {
    border-radius: 10px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .card-header {
        text-align: center;
    }
}
</style>

<div class="container mt-3">

    {{-- MESSAGE --}}
    @if(session('message'))
        <div class="alert alert-primary text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="card my-2">

        {{-- HEADER --}}
        <div class="card-header">
            👮 Customer Details Report
        </div>

        {{-- FILTER FORM --}}
        <div class="card-body">
            <form action="{{ url('police_station_report_result') }}" method="POST">
                @csrf

                <div class="row g-3 align-items-end">

                    <div class="col-md-2">
                        <label class="form-label">From Date</label>
                        <input type="text" class="form-control date" name="from_date"
                               value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">To Date</label>
                        <input type="text" class="form-control date" name="to_date"
                               value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Guest Name Font</label>
                        <select class="form-select" name="guest_name_font">
                            @for($i = 7; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ $i == 7 ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Address Font</label>
                        <select class="form-select" name="guest_address_font">
                            @for($i = 7; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ $i == 7 ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Mobile Font</label>
                        <select class="form-select" name="guest_mobile_font">
                            @for($i = 7; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ $i == 7 ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Format</label>
                        <div class="format-box">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" value="1" checked>
                                <label class="form-check-label">Format 1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" value="2">
                                <label class="form-check-label">Format 2</label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check me-1"></i> Generate Report
                    </button>
                </div>

            </form>
        </div>

        {{-- EMPTY TABLE AREA (RESULT RENDERED ON NEXT PAGE) --}}
        <div class="card-body table-scrollable"></div>

    </div>
</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets/js/form.js') }}"></script>

@endsection
