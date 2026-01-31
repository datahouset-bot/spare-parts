@extends('layouts.blank')
@section('pagecontent')

<div class="container py-4">
    

<!-- Modal (for confirmation) -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteConfirmModalLabel">⚠️ Confirm Deletion</h5>
      </div>
      <div class="modal-body">
        <p><strong>Warning:</strong> If you continue, <span class="text-danger">ALL transactions will be permanently deleted</span> and <u>cannot be recovered</u>.</p>

        <p>Please type the code below to confirm:</p>
        <h4 id="captchaCode" class="text-center fw-bold text-primary"></h4>

        <input type="text" id="captchaInput" class="form-control mt-2" placeholder="Enter above code to confirm">

        <p class="mt-3 text-danger"><strong>Wait 5 minutes before you can confirm deletion.</strong></p>
        <div class="text-center fw-bold fs-5" id="countdownTimer">05:00</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a id="finalDeleteLink" href="{{ url('/room_transection_delete', Auth::user()->firm_id) }}" class="btn btn-danger disabled">Confirm Delete</a>
      </div>
    </div>
  </div>
</div>

<!-- JS Section -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const deleteBtn = document.getElementById('deleteAllBtn');
    const captchaCodeEl = document.getElementById('captchaCode');
    const captchaInput = document.getElementById('captchaInput');
    const finalDeleteLink = document.getElementById('finalDeleteLink');
    const countdownEl = document.getElementById('countdownTimer');

    let captchaCode = '';

    function generateCaptcha(length = 10) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    function startCountdown(minutes = 5) {
        let time = minutes * 60;
        const timer = setInterval(() => {
            const m = String(Math.floor(time / 60)).padStart(2, '0');
            const s = String(time % 60).padStart(2, '0');
            countdownEl.textContent = `${m}:${s}`;
            time--;

            if (time < 0) {
                clearInterval(timer);
                countdownEl.textContent = "You can now confirm deletion!";
                finalDeleteLink.classList.remove('disabled');
            }
        }, 1000);
    }

    deleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        captchaCode = generateCaptcha();
        captchaCodeEl.textContent = captchaCode;
        captchaInput.value = '';
        finalDeleteLink.classList.add('disabled');
        countdownEl.textContent = '05:00';
        startCountdown(5);
        new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
    });

    captchaInput.addEventListener('input', function() {
        if (captchaInput.value === captchaCode && !finalDeleteLink.classList.contains('disabled')) {
            finalDeleteLink.classList.remove('disabled');
        } else {
            finalDeleteLink.classList.add('disabled');
        }
    });
});
</script>


    {{-- Flash Message --}}
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-12">

            <div class="card border-0 shadow-lg rounded-4">

                {{-- Header --}}
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <h5 class="mb-0">
                        <i class="fa fa-building me-2"></i> Software Company Details
                    </h5>

                    {{-- Delete Button --}}
                    {{-- <button class="btn btn-sm btn-danger" id="deleteAllBtn">
                        <i class="fa fa-trash me-1"></i> Delete All Transactions
                    </button> --}}
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('softwarecompanies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- ================= BASIC INFO ================= --}}
                        <h6 class="text-primary mb-3">Basic Dates</h6>
                        <div class="row g-3">
                            <div class="col-md-3 form-floating">
                                <input class="form-control" type="date" name="activation_date"
                                       value="{{ old('activation_date', $software_companyInfo->activation_date ?? '') }}">
                                <label>Activation Date</label>
                            </div>

                            <div class="col-md-3 form-floating">
                                <input class="form-control" type="date" name="expiry_date"
                                       value="{{ old('expiry_date', $software_companyInfo->expiry_date ?? '') }}">
                                <label>Expiry Date</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ================= CUSTOMER ================= --}}
                        <h6 class="text-primary mb-3">Customer Information</h6>
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input class="form-control" name="customer_firm_name"
                                       value="{{ old('customer_firm_name', $software_companyInfo->customer_firm_name ?? '') }}">
                                <label>Customer Firm Name</label>
                            </div>

                            <div class="col-md-3 form-floating">
                                <input class="form-control" name="customer_mobile"
                                       value="{{ old('customer_mobile', $software_companyInfo->customer_mobile ?? '') }}">
                                <label>Customer Mobile</label>
                            </div>

                            <div class="col-md-3 form-floating">
                                <input class="form-control" name="customer_phone"
                                       value="{{ old('customer_phone', $software_companyInfo->customer_phone ?? '') }}">
                                <label>Customer Phone</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ================= SOFTWARE ================= --}}
                        <h6 class="text-primary mb-3">Software Firm</h6>
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input class="form-control" name="software_firm_name"
                                       value="{{ old('software_firm_name', $software_companyInfo->software_firm_name ?? '') }}">
                                <label>Software Firm Name</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ================= ADDRESS ================= --}}
                        <h6 class="text-primary mb-3">Address & Contact</h6>
                        <div class="row g-3">
                            @foreach (['software_address1','software_address2','software_city','software_pincode','software_state','software_phone','software_mobile','software_email','software_website'] as $field)
                                <div class="col-md-4 form-floating">
                                    <input class="form-control" name="{{ $field }}"
                                           value="{{ old($field, $software_companyInfo->$field ?? '') }}">
                                    <label>{{ ucwords(str_replace('_',' ', $field)) }}</label>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-4">

                        {{-- ================= SOCIAL ================= --}}
                        <h6 class="text-primary mb-3">Social Media</h6>
                        <div class="row g-3">
                            @foreach (['software_facebook','software_youtube','software_twitter'] as $field)
                                <div class="col-md-4 form-floating">
                                    <input class="form-control" name="{{ $field }}"
                                           value="{{ old($field, $software_companyInfo->$field ?? '') }}">
                                    <label>{{ ucwords(str_replace('_',' ', $field)) }}</label>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-4">

                        {{-- ================= LOGOS ================= --}}
                        <h6 class="text-primary mb-3">Logos</h6>
                        <div class="row g-3">
                            @foreach (['software_logo1','software_logo2','software_logo3','software_logo4'] as $field)
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ ucwords(str_replace('_',' ', $field)) }}</label>
                                    <input class="form-control" type="file" name="{{ $field }}">
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-4">

                        {{-- ================= EXTRA ================= --}}
                        <h6 class="text-primary mb-3">Additional Configuration</h6>
                        <div class="row g-3">
                            @foreach(range(1,10) as $i)
                                <div class="col-md-4 form-floating">
                                    <input class="form-control"
                                           name="software_af{{ $i }}"
                                           value="{{ $software_companyInfo->{'software_af'.$i} ?? '' }}">
                                    <label>AF {{ $i }}</label>
                                </div>
                            @endforeach
                        </div>

                        {{-- ================= ACTIONS ================= --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                                ← Back
                            </a>

                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fa fa-save me-1"></i> Apply
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
