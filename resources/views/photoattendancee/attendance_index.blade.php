@extends('layouts.blank')

@section('pagecontent')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body { background:#f5f6fa; }
    .form-card{ max-width:900px; margin:40px auto; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); }
    .form-control, .form-select{ border-radius:8px; }
    .signature-box{ border:2px solid #aaa; border-radius:8px; height:120px; background:#fff; }
     .form-control, .form-select{ border-radius:8px; }

   body { background:#f5f6fa; }
   #reqfild{
    color: red;
    font-size: large;
    font-weight: 400;
   }

    .form-card{
        max-width:900px;
        margin:40px auto;
        border-radius:12px;
        box-shadow:0 10px 25px rgba(0,0,0,0.1);
    }

    .terms-box{
        border:2px solid #aaa;
        border-radius:8px;
        background:#fff;
        padding:6px;
    }

    .terms-list{
        list-style-type: disc;
        padding-left:20px;
        margin:0;
    }

    .terms-list li{
        margin-bottom:6px;
    }

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
                   <div class="mb-2">
    <small class="text-muted">Employee ID</small>
    <input
        type="text"
        name="emp_id"
        class="form-control"
        placeholder="HSI/EMP/0001"
    >
</div> 

                    <div class="mb-2">
                    <small class="text-muted"><span id="reqfild">*</span>Employee Name</small>
                    <input type="text" name="name" class="form-control mb-3" placeholder="Name" required></div>

                    <div class="mb-2">
                    <small class="text-muted"><span id="reqfild">*</span>Email</small>
                    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required></div>

                    <div class="mb-2">
                    <small class="text-muted"><span id="reqfild">*</span>Mobile no</small>
                    <input type="text" name="mobile" class="form-control mb-3" placeholder="Mobile No" required></div>

                    <div class="mb-2">
                    <small class="text-muted"><span id="reqfild">*</span>Address</small>
                    <textarea name="address" class="form-control mb-3" rows="2" placeholder="Address"required></textarea></div>


                    <div class="mb-2">
                    <small class="text-muted"><span id="reqfild">*</span>Document no.</small>
                    <input type="text" name="document_no" class="form-control mb-3" placeholder="Document No" required></div>

                    <div class="mb-2">
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

                       <div class="mb-3">
                        <small class="text-muted">Salary Amount</small>
                    <input type="text" name="salary_amount" class="form-control mb-3" placeholder="Salary Amount"></div>
                  
                    <div class="mb-3">
                        <small class="text-muted">Designatiom</small>
                    <input type="text" name="af6" class="form-control mb-3" placeholder="Designation"></div>


                    <div class="mb-3">
                        <small class="text-muted">Date of Joining</small>
                        <input type="date" name="date_of_joining" class="form-control">
                    </div>
                       <div class="mb-3">
                        <small class="text-muted">Document Type</small>
                    <select name="document_type" class="form-select mb-3">
                        <option value="">Select Document Type</option>
                        <option value="Aadhar Card">Aadhar Card</option>
                        <option value="Voter ID">Voter ID</option>
                        <option value="Driving License">Driving License</option>
                    </select> </div>

                    <div class="mb-3">
                        <small class="text-muted">Document Upload Only Image(jpg,png)</small>
                        <input type="file" name="document_file" class="form-control">
                    </div>
  <small class="text-muted">Buffer Time</small>
                    <input type="time" name="Buffer_time" class="form-control mb-3" placeholder="Buffer Time">
                </div>

            </div>

           <label class="fw-bold mt-3">Terms & Conditions</label>

            <div class="terms-box mb-2">
             <textarea
    name="terms_text"
    id="terms_text"
    class="form-control border-0"
    rows="5"
    placeholder="Type terms here"
>{{ old('terms_text') 
    ?? ($employeeWithTerms && $employeeWithTerms->terms_text 
        ? $employeeWithTerms->terms_text 
        : '') 
}}
</textarea>

            </div>



            <div class="form-check mb-3">
                <input type="checkbox" name="terms" value="1" class="form-check-input" required>
                <label class="form-check-label">I agree to Terms & Conditions</label>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold">Register</button>

        </form>
    </div>
</div>



<script>
const textarea = document.getElementById('terms_text');
const preview  = document.getElementById('termsPreview');

/* Ensure bullets exist */
function normalizeBullets() {
    let lines = textarea.value.split('\n').map(line => {
        line = line.trim();
        if (!line) return '';
        return line.startsWith('•') ? line : '• ' + line;
    });

    textarea.value = lines.join('\n');
}

/* Render preview */
function renderPreview() {
    let lines = textarea.value
        .split('\n')
        .map(l => l.replace(/^•\s*/, '').trim())
        .filter(l => l !== '');

    preview.innerHTML = lines.map(l => `<li>${l}</li>`).join('');
}

/* Handle typing */
textarea.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        textarea.value += '\n• ';
    }
});

/* On input */
textarea.addEventListener('input', () => {
    normalizeBullets();
    renderPreview();
});

/* Auto load old data */
document.addEventListener('DOMContentLoaded', () => {
    if (!textarea.value.trim()) {
        textarea.value = '• ';
    } else {
        normalizeBullets();
    }
    renderPreview();
});
</script>

@endsection
