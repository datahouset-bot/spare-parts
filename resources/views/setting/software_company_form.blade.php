@extends('layouts.blank')
@section('pagecontent')

<div class="container">
    @if(session('message'))
        <div class="alert alert-primary">
            {{ session('message') }}
        </div>
    @endif

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-1">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-1">Software Company Details</h3>
                                         {{-- <a class="btn btn-danger" href="{{ url('/room_transection_delete',Auth::user()->firm_id) }}">Delete All Transection</a> --}}
                                    {{-- <a class="btn btn-danger" id="deleteAllBtn">Delete All Transactions</a> --}}

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

                                    
                                    
                                        </div>
                                    <div class="card-body">
                                        <form action="{{ route('softwarecompanies.store') }}" method="POST">
                                            @csrf
                                            <div class="row">

                                            

                                            <!-- Activation Date -->
                                            <div class="form-floating col-md-3 mb-3">
                                                <input class="form-control" id="activation_date" type="date" name="activation_date" value="{{ old('activation_date', $software_companyInfo->activation_date ?? '') }}" />
                                                <label for="activation_date">Activation Date</label>
                                            </div>

                                            <!-- Expiry Date -->
                                            <div class="form-floating col-md-3 mb-3">
                                                <input class="form-control" id="expiry_date" type="date" name="expiry_date" value="{{ old('expiry_date', $software_companyInfo->expiry_date ?? '') }}" />
                                                <label for="expiry_date">Expiry Date</label>
                                            </div>

                                            <!-- Customer Firm Name -->
                                            <div class="form-floating col-md-6 mb-3">
                                                <input class="form-control" id="customer_firm_name" type="text" name="customer_firm_name" value="{{ old('customer_firm_name', $software_companyInfo->customer_firm_name ?? '') }}" />
                                                <label for="customer_firm_name">Customer Firm Name</label>
                                            </div>


                                            <!-- Customer Mobile -->
                                            <div class="form-floating  col-md-3 mb-3">
                                                <input class="form-control" id="customer_mobile" type="text" name="customer_mobile" value="{{ old('customer_mobile', $software_companyInfo->customer_mobile ?? '') }}" />
                                                <label for="customer_mobile">Customer Mobile</label>
                                            </div>

                                            <!-- Customer Phone -->
                                            <div class="form-floating col-md-3 mb-3">
                                                <input class="form-control" id="customer_phone" type="text" name="customer_phone" value="{{ old('customer_phone', $software_companyInfo->customer_phone ?? '') }}" />
                                                <label for="customer_phone">Customer Phone</label>
                                            </div>

                                            <!-- Software Firm Name -->
                                            <div class="form-floating col-md-6 mb-3">
                                                <input class="form-control" id="software_firm_name" type="text" name="software_firm_name" value="{{ old('software_firm_name', $software_companyInfo->software_firm_name ?? '') }}" />
                                                <label for="software_firm_name">Software Firm Name</label>
                                            </div>

                                            <!-- Address1, Address2, City, Pincode, State, Phone, Mobile, Email, Website -->
                                            <div class="row">
                                                @foreach (['software_address1', 'software_address2', 'software_city', 'software_pincode', 'software_state', 'software_phone', 'software_mobile', 'software_email', 'software_website'] as $field)
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="{{ $field }}" type="text" name="{{ $field }}" value="{{ old($field, $software_companyInfo->$field ?? '') }}" />
                                                            <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Social Media (Facebook, YouTube, Twitter) -->
                                            <div class="row">
                                                @foreach (['software_facebook', 'software_youtube', 'software_twitter'] as $field)
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="{{ $field }}" type="text" name="{{ $field }}" value="{{ old($field, $software_companyInfo->$field ?? '') }}" />
                                                            <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Logos -->
                                            <div class="row">
                                                @foreach (['software_logo1', 'software_logo2', 'software_logo3', 'software_logo4'] as $field)
                                                    <div class="col-md-3 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="{{ $field }}" type="file" name="{{ $field }}" value="{{ old($field, $software_companyInfo->$field ?? '') }}" />
                                                            <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Additional Fields (software_af1 to software_af10) -->
                                            <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af1" type="text" name="software_af1" value="{{ $software_companyInfo->software_af1  }}" />
                                                            <label for="software_af1">Business </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af2" type="text" name="software_af2" value="{{ $software_companyInfo->software_af2  }}" />
                                                            <label for="software_af2">Map Longnitute </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af3" type="text" name="software_af3" value="{{ $software_companyInfo->software_af3  }}" />
                                                            <label for="software_af3"> Map Latitute </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af4" type="text" name="software_af4" value="{{ $software_companyInfo->software_af4  }}" />
                                                            <label for="software_af4">Whatsapp Authantication  Key  </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af5" type="text" name="software_af5" value="{{ $software_companyInfo->software_af5  }}" />
                                                            <label for="software_af5">Whatsapp Api  </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af6" type="date" name="software_af6" value="{{ $software_companyInfo->software_af6  }}" />
                                                            <label for="software_af6">WhatsApp Validity  </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af7" type="text" name="software_af7" value="{{ $software_companyInfo->software_af7  }}" />
                                                            <label for="software_af7">af7 </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af8" type="text" name="software_af8" value="{{ $software_companyInfo->software_af8  }}" />
                                                            <label for="software_af8">af8 </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af9" type="text" name="software_af9" value="{{ $software_companyInfo->software_af9  }}" />
                                                            <label for="software_af9">Af9 </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af10" type="text" name="software_af10" value="{{ $software_companyInfo->software_af10  }}" />
                                                            <label for="software_af1">Af10 </label>
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block">Apply</button>
                                                </div>
                                            </div>
                                          </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">
                                            <a class="btn btn-dark" href="{{ url()->previous() }}">Back</a>
                                         
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</div>

@endsection
