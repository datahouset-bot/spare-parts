@extends('layouts.blank')

@section('pagecontent')
<style>
/* ================= PRINT SETTINGS ================= */
@media print {

    /* Hide buttons + footer */
    .card-footer,
    .btn,
    button {
        display: none !important;
    }

    /* Remove card shadow & border for clean paper */
    .card {
        border: none !important;
        box-shadow: none !important;
    }

    body {
        background: #fff !important;
    }
}
</style>

<div class="container mt-4">
    <div class="card shadow">
        

        <div class="card-header bg-info text-white fw-bold text-center">
            Material Challan Details
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-4 mb-3"><strong>Slip No:</strong> {{ $crusher->slip_no }}</div>
                <div class="col-md-4 mb-3"><strong>Date:</strong> {{ \Carbon\Carbon::parse($crusher->date)->format('d-m-Y') }}</div>
                <div class="col-md-4 mb-3"><strong>Time:</strong> {{ $crusher->time }}</div>

                <div class="col-md-4 mb-3"><strong>Vehicle No:</strong> {{ $crusher->vehicle_no }}</div>
                <div class="col-md-4 mb-3"><strong>Vehicle Measure:</strong> {{ $crusher->vehicle_measure}}</div>
                <div class="col-md-4 mb-3"><strong>Party Name:</strong> {{ $crusher->party_name }}</div>

                <div class="col-md-4 mb-3"><strong>Material:</strong> {{ $crusher->Material }}</div>
                <div class="col-md-4 mb-3"><strong>Quantity:</strong> {{ $crusher->Quantity }}</div>
                <div class="col-md-4 mb-3"><strong>Rate:</strong> {{ number_format($crusher->Rate, 2) }}</div>

                <div class="col-md-4 mb-3"><strong>Royalty:</strong> {{ number_format($crusher->Royalty, 2) }}</div>
                <div class="col-md-4 mb-3"><strong>Total:</strong> {{ number_format($crusher->Total, 2) }}</div>
                <div class="col-md-4 mb-3"><strong>Phone:</strong> {{ $crusher->phone }}</div>

                <div class="col-md-12 mb-3">
                    <strong>Remark:</strong>
                    <div class="border rounded p-2">
                        {{ $crusher->remark ?? '-' }}
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer text-center">
            <a href="{{ route('crusher.index') }}" class="btn btn-dark">
                Back
            </a>

            <a href="{{ route('crusher.edit', $crusher->id) }}" class="btn btn-primary">
                Edit
            </a>
        <button onclick="printChallan()" class="btn btn-success">
    Print
</button>


        </div>

    </div>
</div>
<script>
function printChallan() {
    window.print();
}
</script>

@endsection
