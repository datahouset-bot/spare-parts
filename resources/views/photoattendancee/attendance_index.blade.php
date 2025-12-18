@extends('layouts.blank')

@section('pagecontent')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body { background:#f5f6fa; }
    .form-card{ max-width:900px; margin:40px auto; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); }
    .form-control, .form-select{ border-radius:8px; }
    .signature-box{ border:2px solid #aaa; border-radius:8px; height:120px; background:#fff; }
</style>


<div class="card form-card">
    <div class="card-header bg-primary text-white text-center fw-bold">
        Employee Registration
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    @if(session('success'))
        <div class="alert alert-success text-center fw-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-body">
        <form method="POST" action="{{ route('attendances.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                <!-- LEFT -->
                <div class="col-md-6">
                    <input type="text" name="emp_id" class="form-control mb-3" placeholder="Employee ID">

                    <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>

                    <input type="email" name="email" class="form-control mb-3" placeholder="Email">

                    <input type="text" name="mobile" class="form-control mb-3" placeholder="Mobile No">

                    <textarea name="address" class="form-control mb-3" rows="2" placeholder="Address"></textarea>

                    <input type="text" name="document_no" class="form-control mb-3" placeholder="Document No">

                    <div class="mb-3">
                        <small class="text-muted">Report Time</small>
                        <input type="time" name="Report_time" class="form-control">
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-md-6">

                    <div class="mb-3">
                        <small class="text-muted">Upload Photo</small>
                        <input type="file" name="photo" class="form-control">
                    </div>

                    <input type="text" name="salary_amount" class="form-control mb-3" placeholder="Salary Amount">

                    <div class="mb-3">
                        <small class="text-muted">Date of Joining</small>
                        <input type="date" name="date_of_joining" class="form-control">
                    </div>

                    <select name="document_type" class="form-select mb-3">
                        <option value="">Select Document Type</option>
                        <option value="Aadhar Card">Aadhar Card</option>
                        <option value="Voter ID">Voter ID</option>
                        <option value="Driving License">Driving License</option>
                    </select>

                    <div class="mb-3">
                        <small class="text-muted">Document Upload</small>
                        <input type="file" name="document_file" class="form-control">
                    </div>
  <small class="text-muted">Buffer Time</small>
                    <input type="time" name="Buffer_time" class="form-control mb-3" placeholder="Buffer Time">
                </div>

            </div>

            <!-- TERMS -->
            <label class="fw-bold mt-3 d-block">Terms & Conditions</label>

            <div class="signature-box mb-2">
                <textarea name="terms_text" class="form-control border-0 h-100" placeholder="Enter terms"></textarea>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="terms" value="1" class="form-check-input" required>
                <label class="form-check-label">I agree to Terms & Conditions</label>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold">Register</button>

        </form>
    </div>
</div>

@endsection
