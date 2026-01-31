@extends('layouts.blank')
@section('pagecontent')

<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css') }}">
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
.report-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    padding: 18px;
}

/* ================= HEADER ================= */
.report-title {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
    text-align: center;
    margin-bottom: 15px;
}

/* ================= FILTER FORM ================= */
.filter-box {
    background: #f9fafb;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 10px;
}

.filter-box label {
    font-weight: 600;
    font-size: 14px;
}

.filter-box .form-control {
    border-radius: 8px;
}

/* ================= BUTTON ================= */
.btn-primary {
    padding: 8px 22px;
    font-size: 15px;
    border-radius: 25px;
    box-shadow: 0 6px 15px rgba(13,110,253,.25);
}

/* ================= ALERT ================= */
.alert {
    border-radius: 10px;
    font-size: 14px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .filter-box {
        text-align: center;
    }
}
</style>

<div class="container my-3">

    @if(session('message'))
        <div class="alert alert-primary text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="report-card">

        {{-- PAGE TITLE --}}
        <div class="report-title">
            📊 Day End Report (Date Wise)
        </div>

        {{-- FILTER FORM --}}
        <div class="filter-box" id="account_select_form">
            <form action="{{ url('datewisedayend') }}" method="POST">
                @csrf
                <div class="row align-items-end justify-content-center">

                    <div class="col-md-3 mb-3">
                        <label>Start Date</label>
                        <input type="text"
                               class="form-control date"
                               name="from_date"
                               value="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>End Date</label>
                        <input type="text"
                               class="form-control date"
                               name="to_date"
                               value="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <div class="col-md-2 mb-3 text-center">
                        <button type="submit" class="btn btn-primary mt-2">
                            <i class="fa fa-search me-1"></i> Generate
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- RESULT AREA (TABLE CAN BE ENABLED LATER) --}}
        <div class="text-center text-muted mt-3">
            <em>Select date range and click Generate to view report</em>
        </div>

    </div>
</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets/js/form.js') }}"></script>

@endsection
