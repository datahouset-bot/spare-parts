@php
    include public_path('cdn/cdn.blade.php');
@endphp

<link rel="stylesheet" href="{{ global_asset('/general_assets/css/form.css') }}">

@extends('layouts.blank')
@section('pagecontent')
<style>
 /* =============================
   STRONGER / BOLDER FONT
============================= */

/* All form text */
body, 
.form-control,
.form-select,
table,
.card,
.card-header {
    font-weight: 600; /* semi-bold */
}

/* Labels extra bold */
label {
    font-weight: 800;
}

/* Inputs text bold */
input,
select,
textarea {
    font-weight: 600;
    color: #093c74; /* darker text */
}

/* Headings */
h1, h2, h3, h4, h5 {
    font-weight: 900;
}

/* Buttons */
.btn {
    font-weight: 700;
}

/* Table headers */
table th {
    font-weight: 800;
}

/* =============================
   DARKER BORDERS
============================= */

/* Cards */
.card {
    border: 2px solid #1e293b; /* dark slate */
}

/* Inputs & selects */
.form-control,
.form-select,
input,
select,
textarea {
    border: 2px solid #1f2937 !important; /* dark gray */
}

/* Focus state */
.form-control:focus,
.form-select:focus,
input:focus,
select:focus,
textarea:focus {
    border-color: #0d6efd !important; /* Bootstrap blue */
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.35) !important;
}

/* Table borders */
table,
table th,
table td {
    border: 2px solid #1f2937 !important;
}

/* Modal border */
.modal-content {
    border: 2px solid #1f2937;
}

/* Payment side card */
.payment-card {
    border-left: 6px solid #0d6efd;
    border-top: 2px solid #1f2937;
    border-right: 2px solid #1f2937;
    border-bottom: 2px solid #1f2937;
}


</style>

<div class="container mt-4 mb-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center fw-bold">
           <h3>Vehicle Registration </h3> 
        </div>
         @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center fw-bold" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
        <div class="card-body">
            <form action="{{ route('vehicledetail.store') }}" method="POST">
                @csrf
                <div class="row">
                    {{-- ================= VEHICLE DETAILS ================= --}}
                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2" style="top:-8px; left:10px;">Vehicle Name</label>
                            <input type="text" name="vehicle_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-8px; left:10px;">Owner Name</label>
                            <input type="text" name="owner_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-8px; left:10px;">Vehicle No</label>
                            <input type="text" name="Vehicle_no" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
    <div class="position-relative border-none rounded p-2">
        <label class="position-absolute bg-white px-2" style="top:-8px; left:10px;">
            Vehicle Measure
        </label>
        <input type="text"
       name="vehicle_measure"
       class="form-control"
       value="{{ old('vehicle_measure') }}"
       placeholder="e.g. 10 Ton / 16 Wheel">

    </div>
</div>

                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-8px; left:10px;">Registration Date</label>
                            <input type="date" name="Registration_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-8px; left:10px;">Model Year</label>
                            <input type="text" name="model_year" class="form-control">
                        </div>
                    </div>

                    {{-- ================= DRIVER DETAILS ================= --}}
                

                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-8px; left:10px;">Driver Name</label>
                            <input type="text" name="Driver_name" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-8px; left:10px;">Driver Contact</label>
                            <input type="text" name="Driver_contact" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-12px; left:10px;">Driver Address</label>
                            <input type="text" name="Driver_address" class="form-control">
                        </div>
                    </div>

                    {{-- ================= OTHER DETAILS ================= --}}
                   
                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-12px; left:10px;">Insurance</label>
                            <input type="text" name="Insaurance" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="position-relative border-none rounded p-2">
                            <label class="position-absolute bg-white px-2"
                                   style="top:-12px; left:10px;">PUC</label>
                            <input type="text" name="Puc" class="form-control">
                        </div>
                    </div>

                </div>

                {{-- ================= ACTION BUTTONS ================= --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-4">Save</button>
                    <a href="{{ route('crusher.index') }}" class="btn btn-dark px-4">Back</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
