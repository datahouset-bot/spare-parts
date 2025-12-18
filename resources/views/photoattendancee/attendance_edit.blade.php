@extends('layouts.blank')

@section('pagecontent')

<div class="container mt-4">

    <div class="card shadow form-card">
        <div class="card-header bg-warning text-dark fw-bold text-center">
            Edit Employee - {{ $employee->name }}
        </div>

        @if(session('success'))
            <div class="alert alert-success text-center fw-bold m-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('attendances.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <!-- LEFT SIDE -->
                    <div class="col-md-6">

                        <div class="mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" name="emp_id" class="form-control" 
                                   value="{{ $employee->emp_id }}">
                        </div>

                        <input type="text" name="name" class="form-control mb-3"
                               value="{{ $employee->name }}" required>

                        <input type="email" name="email" class="form-control mb-3"
                               value="{{ $employee->email }}">

                        <input type="text" name="mobile" class="form-control mb-3"
                               value="{{ $employee->mobile }}">

                        <textarea name="address" class="form-control mb-3" rows="2">{{ $employee->address }}</textarea>

                        <div class="mb-3">
                            <label class="form-label">Document no.</label>
                        <input type="text" name="document_no" class="form-control mb-3"
                               value="{{ $employee->document_no }}"></div>

                        <div class="mb-3">
                            <label class="form-label">Report Time</label>
                            <input type="time" name="report_time" class="form-control"
                                   value="{{ $employee->Report_time }}">
                        </div>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-md-6">

                        <div class="mb-3">
                            <label class="form-label">Upload New Photo</label><br>

                            @if($employee->photo)
                                <img src="{{ asset('storage/app/public/attendance/photos/' . $employee->photo) }}"
                                width="100" height="100" class="rounded mb-2">
                            @endif

                            <input type="file" name="photo" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Salary amount</label>
                        <input type="text" name="salary_amount" class="form-control mb-3"
                            value="{{ $employee->salary_amount }}"></div>

                             <div class="mb-3">
                            <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control mb-3"
                            value="{{ $employee->designation }}"></div>

                        <div class="mb-3">
                            <label class="form-label">Date of Joining</label>
                            <input type="date" name="date_of_joining" class="form-control"
                            value="{{ $employee->date_of_joining }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Document Type</label>
                        <select name="document_type" class="form-select mb-3">
                            <option value="Aadhar Card" {{ $employee->document_type == "Aadhar Card" ? "selected" : "" }}>Aadhar Card</option>
                            <option value="Voter ID" {{ $employee->document_type == "Voter ID" ? "selected" : "" }}>Voter ID</option>
                            <option value="Driving License" {{ $employee->document_type == "Driving License" ? "selected" : "" }}>Driving License</option>
                        </select>
                        </div>

                        <label class="form-label">Document Upload</label>
                        @if($employee->document_submit)
                        <img src ="{{ asset('storage/app/public/attendance/documents/' . $employee->document_submit) }}"
                            width="100" height="100" class="rounded mb-2">
                            
                        @endif

                        <input type="file" name="document_file" class="form-control mb-3">

                        <div class="mb-3">
                            <label class="form-label">Report Time</label>
                        <input type="time" name="buffer_time" class="form-control mb-3"
                               value="{{ $employee->Buffer_time }}">
                        </div>

                    </div>

                </div>

                <!-- TERMS -->
                <label class="fw-bold mt-3 d-block">Terms & Conditions</label>

                <div class="signature-box mb-2">
<textarea
    name="terms_text"
    id="terms_text"
    class="form-control border-0 h-100"
    rows="6"
    placeholder="• Enter terms here">{{ old('terms_text', $employee->terms_text) }}</textarea>

                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="terms" value="1" 
                           class="form-check-input"
                           {{ $employee->terms ? 'checked' : '' }}>
                    <label class="form-check-label">I agree to Terms & Conditions</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Update Employee</button>

            </form>
        </div>
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const textarea = document.getElementById('terms_text');

    // Ensure every line starts with •
    function normalizeBullets() {
        let lines = textarea.value.split('\n').map(line => {
            line = line.trim();
            if (!line) return '';
            return line.startsWith('•') ? line : '• ' + line;
        });
        textarea.value = lines.join('\n');
    }

    // Auto bullet on Enter
    textarea.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            textarea.value += '\n• ';
        }
    });

    // Normalize while typing
    textarea.addEventListener('input', normalizeBullets);

    // Initial load normalization
    if (!textarea.value.trim()) {
        textarea.value = '• ';
    } else {
        normalizeBullets();
    }

});
</script>


@endsection
