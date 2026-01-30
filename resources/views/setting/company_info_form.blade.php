@extends('layouts.blank')
@section('pagecontent')
<style>
/* ================= PAGE BACKGROUND ================= */
body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
}

/* ================= CARD ================= */
.card {
    border-radius: 18px;
    border: none;
    box-shadow: 0 14px 40px rgba(0,0,0,.12);
    animation: fadeUp .4s ease;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ================= CARD HEADER ================= */
.card-header {
    background: linear-gradient(135deg, #4f46e5, #1e3a8a);
    color: #fff;
    font-weight: 700;
    font-size: 20px;
    text-align: center;
    border-radius: 18px 18px 0 0;
}

/* ================= FORM ================= */
.form-floating label {
    font-size: 14px;
    font-weight: 600;
    color: #334155;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #c7d2fe;
    font-size: 14px;
    height: 46px;
}

.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99,102,241,.25);
}

/* ================= SECTION DIVIDER ================= */
.section-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e3a8a;
    margin: 24px 0 12px;
    padding-bottom: 6px;
    border-bottom: 2px solid #e5e7eb;
}

/* ================= CHECKBOX GROUP ================= */
.checkbox-group {
    background: #f8fafc;
    border: 2px dashed #c7d2fe;
    padding: 14px;
    border-radius: 12px;
}

.checkbox-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    cursor: pointer;
}

/* ================= BUTTON ================= */
.btn-primary {
    border-radius: 28px;
    font-weight: 700;
    font-size: 15px;
    padding: 10px;
    transition: all .25s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(99,102,241,.45);
}

/* ================= FOOTER ================= */
.card-footer {
    background: #f1f5f9;
    border-radius: 0 0 18px 18px;
}
</style>

    <div class="container-fluid">
        @if (session('message'))
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
                                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                                        <div class="card-header">
                                            <h3 class="text-center font-weight-light my-4">Company / Firm / Business Details
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ url('/compinfo_store') }}" method="POST">
                                                @csrf
                                                @method('put')
<div class="section-title">Basic Firm Information</div>

                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="firm_name" type="text"
                                                                name="cominfo_firm_name"
                                                                value="{{ $companyInfo->cominfo_firm_name }}" />
                                                            <span class="text-danger">
                                                                @error('cominfo_firm_name')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="firm_name">Firm Name </label>

                                                        </div>
                                                    </div>


                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="address1" type="text"
                                                                name="cominfo_address1"
                                                                value="{{ $companyInfo->cominfo_address1 }}" />
                                                            <span class="text-danger">
                                                                @error('address1')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="address1">Address1</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="address2" type="text"
                                                                name="cominfo_address2"
                                                                value="{{ $companyInfo->cominfo_address2 }}" />
                                                            <span class="text-danger">
                                                                @error('address2')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="address2">Address2</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="city" type="text"
                                                                name="cominfo_city"
                                                                value="{{ $companyInfo->cominfo_city }}" />
                                                            <span class="text-danger">
                                                                @error('city')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="city">City</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="pincode" type="text"
                                                                name="cominfo_pincode"
                                                                value="{{ $companyInfo->cominfo_pincode }}" />
                                                            <span class="text-danger">
                                                                @error('pincode')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="pincode">Pincode</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="state" type="text"
                                                                name="cominfo_state"
                                                                value="{{ $companyInfo->cominfo_state }}" />
                                                            <span class="text-danger">
                                                                @error('state')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="state">State</label>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="phone" type="text"
                                                                name="cominfo_phone"
                                                                value="{{ $companyInfo->cominfo_phone }}" />
                                                            <span class="text-danger">
                                                                @error('phone')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="phone">Phone</label>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="mobile" type="text"
                                                                name="cominfo_mobile"
                                                                value="{{ $companyInfo->cominfo_mobile }}" />
                                                            <span class="text-danger">
                                                                @error('mobile')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="mobile">Mobile</label>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="cominfo_email" type="text"
                                                                name="cominfo_email"
                                                                value="{{ $companyInfo->cominfo_email }}" />
                                                            <span class="text-danger">
                                                                @error('cominfo_email')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="cominfo_email">Email</label>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="website" type="text"
                                                                name="cominfo_website"
                                                                value="{{ $companyInfo->cominfo_field2 }}" />
                                                            <span class="text-danger">
                                                                @error('website')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="website">Website</label>

                                                        </div>
                                                    </div>
                                                    <div class="section-title">Tax & Registration Details</div>

                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="gst_no" type="text"
                                                                name="cominfo_gst_no"
                                                                value="{{ $companyInfo->cominfo_gst_no }}" />
                                                            <span class="text-danger">
                                                                @error('gst_no')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="gst_no">GST No </label>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="field1" type="text"
                                                                name="cominfo_field1"
                                                                value="{{ $companyInfo->cominfo_field1 }}" />
                                                            <span class="text-danger">
                                                                @error('field1')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="field1">Company GST CODE </label>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="pencard" type="text"
                                                                name="cominfo_pencard"
                                                                value="{{ $companyInfo->cominfo_pencard }}" />
                                                            <span class="text-danger">
                                                                @error('pencard')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="pencard">PAN Card No </label>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="field2" type="text"
                                                                name="cominfo_field2"
                                                                value="{{ $companyInfo->cominfo_field2 }}" />
                                                            <span class="text-danger">
                                                                @error('field2')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="field2">Reg No 2 </label>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="field2" type="text"
                                                                name="componyinfo_af10"
                                                                value="{{ $companyInfo->componyinfo_af10 }}" />
                                                            <span class="text-danger">
                                                                @error('field2')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="field2">Google Map Link </label>

                                                        </div>

                                                    </div>
<div class="section-title">System Settings</div>

                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">

                                                            @if (auth()->check() && Auth::user()->email === Auth::user()->firm_id . '@gmail.com')
                                                              <div class="checkbox-group">
    <label>
        <input type="checkbox" name="gst_notapplicable" value="1"
            {{ $companyInfo->gst_notapplicable ? 'checked' : '' }}>
        GST Not Applicable
    </label>

    <label>
        <input type="checkbox" name="make_all_bill_local_gst" value="1"
            {{ $companyInfo->make_all_bill_local_gst ? 'checked' : '' }}>
        Make All Bill Local GST
    </label>

    <label>
        <input type="checkbox" name="requierd_aspedted_checkout" value="1"
            {{ $companyInfo->componyinfo_af1 ? 'checked' : '' }}>
        Require Expected Check-Out
    </label>
<div class="section-title">Channel Manager Configuration</div>

    <label>
        <input type="checkbox" name="componyinfo_af2" value="1"
            {{ $companyInfo->componyinfo_af2 ? 'checked' : '' }}>
        Enable Channel Manager
    </label>
</div>


                                                        </div>
                                                        @endif

                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="field2" type="text"
                                                                name="componyinfo_af4"
                                                                value="{{ $companyInfo->componyinfo_af4 }}" />
                                                            <span class="text-danger">
                                                                @error('componyinfo_af4')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="field2">Owner & Partner Mobile No For Whatsapp
                                                            </label>
                                                        </div>
                                                    </div>

                                              <div class="col-md-4 mt-2 {{ $companyInfo->componyinfo_af2 == 1 ? 'show' : 'hide' }}">
    <div class="form-floating mb-3 mb-md-0">
        <input class="form-control" id="field2" type="text"
               name="componyinfo_af3"
               value="{{ $companyInfo->componyinfo_af3 }}" />
        <span class="text-danger">
            @error('componyinfo_af3')
                {{ $message }}
            @enderror
        </span>
        <label for="field2">Hotel Channel Manager Code</label>
    </div>
</div>

<style>
.hide {
    display: none;
}
.show {
    display: block;
}
</style>









                                                </div>






                                                <div class="mt-4 mb-0">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary">
    💾 Save Company Details
</button>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a class= "btn btn-dark  "href={{ url('home') }}>Dash
                                                    Board </a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
            </script>
            <script src="js/scripts.js"></script>






    </div>
@endsection
