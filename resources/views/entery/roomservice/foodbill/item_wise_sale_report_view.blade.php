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
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

.card-header {
    background: linear-gradient(135deg, #ffffff, #eef2f7);
    font-size: 18px;
    font-weight: 700;
    padding: 14px 20px;
    border-bottom: 1px solid #e5e9f0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-header i {
    color: #0d6efd;
}

/* ================= FORM ================= */
.form-label {
    font-weight: 600;
    font-size: 14px;
}

.form-control {
    border-radius: 8px;
    font-size: 14px;
}

.form-control:focus {
    box-shadow: 0 0 0 .2rem rgba(13,110,253,.15);
}

/* ================= FILTER BOX ================= */
.filter-box {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px;
    border: 1px solid #e5e9f0;
}

/* ================= BUTTON ================= */
.btn-primary {
    border-radius: 30px;
    padding: 8px 22px;
    font-weight: 600;
}

/* ================= TABLE ================= */
.table-scrollable {
    margin-top: 15px;
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
        justify-content: center;
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
            <i class="fa fa-bar-chart"></i>
            Item Wise Sales Report
        </div>

        {{-- FILTER FORM --}}
        <div class="card-body">
            <div class="filter-box">
                <form action="{{ url('item_wise_sale_report') }}" method="POST">
                    @csrf

                    <div class="row g-3 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="text"
                                   class="form-control date"
                                   name="from_date"
                                   value="{{ date('Y-m-d') }}"
                                   required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="text"
                                   class="form-control date"
                                   name="to_date"
                                   value="{{ date('Y-m-d') }}"
                                   required>
                        </div>

                        <div class="col-md-3 text-md-start text-center">
                            <button type="submit" class="btn btn-primary mt-2">
                                <i class="fa fa-search me-1"></i> Generate Report
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>

        {{-- RESULT TABLE PLACEHOLDER --}}
        <div class="card-body table-scrollable">
            {{-- Result table will appear here --}}
        </div>

    </div>
</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets/js/form.js') }}"></script>

@endsection
