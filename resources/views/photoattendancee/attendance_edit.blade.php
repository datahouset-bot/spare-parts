@extends('layouts.blank')

@section('pagecontent')

<style>
.form-card{
    border-radius:15px;
}
.form-control,.form-select{
    border-radius:10px;
}
.card{
    border-radius:15px;
}
.bg-gradient-warning{
    background:linear-gradient(45deg,#ffc107,#ffdd57);
}
textarea:focus,input:focus,select:focus{
    box-shadow:0 0 6px rgba(13,110,253,.4);
}
.section-title{
    border-bottom:2px solid #eee;
    padding-bottom:6px;
    margin-bottom:15px;
    font-weight:bold;
}
.preview-img{
    width:120px;
    height:120px;
    object-fit:cover;
}
</style>

<div class="container mt-4">

    <div class="card shadow form-card">

        <!-- HEADER -->
        <div class="card-header bg-gradient-warning text-dark text-center py-3">
            <h4 class="fw-bold mb-0">
                <i class="fa-solid fa-user-pen me-2"></i>
                Edit Employee
            </h4>
            <small>{{ $employee->name }}</small>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="alert alert-success text-center fw-bold m-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-body">

            <form action="{{ route('attendances.update',$employee->id) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- LEFT SIDE -->
                    <div class="col-md-6">

                        <h5 class="section-title text-primary">
                            <i class="fa-solid fa-id-card me-2"></i> Personal Information
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" class="form-control"
                                   value="{{ $employee->af5 }}"   name= "emp_id" >
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $employee->name }}" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control"
                                   value="{{ $employee->email }}">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                            <input type="text" name="mobile" class="form-control"
                                   value="{{ $employee->mobile }}">
                        </div>

                        <textarea name="address" rows="2"
                                  class="form-control mb-3"
                                  placeholder="Address">{{ $employee->address }}</textarea>

                        <div class="mb-3">
                            <label class="form-label">Document No.</label>
                            <input type="text" name="document_no"
                                   class="form-control"
                                   value="{{ $employee->document_no }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Report Time</label>
                            <input type="time" name="report_time"
                                   class="form-control"
                                   value="{{ $employee->Report_time }}">
                        </div>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-md-6">

                        <h5 class="section-title text-success">
                            <i class="fa-solid fa-briefcase me-2"></i> Job Details
                        </h5>

                        <!-- PHOTO -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-body text-center">
                                <label class="fw-bold">Employee Photo</label><br>
                                @if($employee->photo)
                                    <img src="{{ asset('storage\app\public\room_image\\'.$employee->photo) }}"
                                         class="rounded-circle border mb-2 preview-img">
                                @endif
                                <input type="file" name="photo" class="form-control mt-2">
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                            <input type="text" name="salary_amount"
                                   class="form-control"
                                   value="{{ $employee->salary_amount }}">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                            <input type="text" name="designation"
                                   class="form-control"
                                   value="{{ $employee->af6 }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Joining</label>
                            <input type="date" name="date_of_joining"
                                   class="form-control"
                                   value="{{ $employee->date_of_joining }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Document Type</label>
                            <select name="document_type" class="form-select">
                                <option value="Aadhar Card" {{ $employee->document_type=='Aadhar Card'?'selected':'' }}>Aadhar Card</option>
                                <option value="Voter ID" {{ $employee->document_type=='Voter ID'?'selected':'' }}>Voter ID</option>
                                <option value="Driving License" {{ $employee->document_type=='Driving License'?'selected':'' }}>Driving License</option>
                            </select>
                        </div>

                        <!-- DOCUMENT -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-body text-center">
                                <label class="fw-bold">Document Upload</label><br>
                                @if($employee->document_submit)
                                    <img src="{{ asset('storage\app\public\item_image\\'.$employee->document_submit) }}"
                                         class="border rounded mb-2 preview-img">
                                @endif
                                <input type="file" name="document_file" class="form-control mt-2">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Buffer Time</label>
                            <input type="time" name="buffer_time"
                                   class="form-control"
                                   value="{{ $employee->Buffer_time }}">
                        </div>

                    </div>
                </div>

                <!-- TERMS -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header fw-bold bg-light">
                        <i class="fa-solid fa-file-contract me-2"></i>
                        Terms & Conditions
                    </div>
                    <div class="card-body p-2">
                        <textarea name="terms_text" id="terms_text"
                                  rows="6"
                                  class="form-control border-0"
                                  placeholder="• Enter terms here">{{ old('terms_text',$employee->terms_text) }}</textarea>
                    </div>
                </div>

                <div class="form-check mt-3">
                    <input class="form-check-input"
                           type="checkbox" name="terms" value="1"
                           {{ $employee->terms ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-danger">
                        I agree to Terms & Conditions
                    </label>
                </div>

                <button type="submit"
                        class="btn btn-success btn-lg w-100 fw-bold mt-4 shadow">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    Update Employee
                </button>

            </form>
        </div>
    </div>
</div>

<!-- BULLET AUTO SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded',function(){
    const textarea=document.getElementById('terms_text');

    function normalize(){
        let lines=textarea.value.split('\n').map(l=>{
            l=l.trim();
            if(!l)return '';
            return l.startsWith('•')?l:'• '+l;
        });
        textarea.value=lines.join('\n');
    }

    textarea.addEventListener('keydown',e=>{
        if(e.key==='Enter'){
            e.preventDefault();
            textarea.value+='\n• ';
        }
    });

    textarea.addEventListener('input',normalize);

    if(!textarea.value.trim()){
        textarea.value='• ';
    }else{
        normalize();
    }
});
</script>

@endsection
