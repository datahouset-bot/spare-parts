@extends('layouts.blank')
<style>
    /* ================= PAGE BACKGROUND ================= */
    body {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
    }

    /* ================= CARD ================= */
    .card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 14px 40px rgba(0, 0, 0, .12);
        animation: fadeUp .35s ease;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ================= HEADER ================= */
    .card-header {
        background: linear-gradient(135deg, #4338ca, #1e3a8a);
        color: #fff;
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        border-radius: 18px 18px 0 0;
        padding: 18px;
    }

    /* ================= FORM INPUTS ================= */
    .form-control,
    .form-select,
    textarea {
        border-radius: 10px;
        border: 2px solid #c7d2fe;
        font-size: 14px;
    }

    .form-control:focus,
    .form-select:focus,
    textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, .25);
    }

    /* ================= FLOATING LABEL ================= */
    .form-floating>label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    /* ================= CHECKBOX ================= */
    .form-check-input {
        border-radius: 6px;
        border: 2px solid #6366f1;
    }

    .form-check-label {
        font-weight: 600;
        color: #1e293b;
    }

    /* ================= SECTION DIVIDER ================= */
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e40af;
        border-left: 5px solid #6366f1;
        padding-left: 12px;
        margin: 28px 0 14px;
    }

    /* ================= TERMS TEXTAREA ================= */
    textarea {
        resize: vertical;
        min-height: 120px;
    }

    /* ================= BUTTON ================= */
    .btn-primary {
        border-radius: 28px;
        font-weight: 700;
        padding: 10px;
        transition: all .25s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(99, 102, 241, .45);
    }

    .btn-dark {
        border-radius: 22px;
        padding: 6px 18px;
    }

    /* ================= FOOTER ================= */
    .card-footer {
        background: #f1f5f9;
        border-radius: 0 0 18px 18px;
    }
</style>

@section('pagecontent')
    <div class="container-fluid ">
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
                                    <div class="card shadow-lg border-0 rounded-lg ">
                                        <div class="card-header">
                                            <h3 class="text-center font-weight-light ">Other Details </h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ url('/comp_info_footer') }}" method="POST">
                                                @csrf
                                                @method('put')


                                                <div class="section-title">Bank & Payment Details</div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="bank_name" type="text"
                                                                name="bank_name" value="{{ $compinfofooter->bank_name }}" />
                                                            <span class="text-danger">
                                                                @error('bank_name')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="bank_name">Bank Name </label>
                                                        </div>

                                                    </div>



                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="bank_ac_no" type="text"
                                                                name="bank_ac_no"
                                                                value="{{ $compinfofooter->bank_ac_no }}" />
                                                            <span class="text-danger">
                                                                @error('bank_ac_no')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="bank_ac_no">Bank A/c No </label>
                                                        </div>

                                                    </div>






                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="bank_ifsc" type="text"
                                                                name="bank_ifsc" value="{{ $compinfofooter->bank_ifsc }}" />
                                                            <span class="text-danger">
                                                                @error('bank_ifsc')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="bank_ifsc">Bank IFSC </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="upiid" type="text"
                                                                name="upiid" value="{{ $compinfofooter->upiid }}" />
                                                            <span class="text-danger">
                                                                @error('upiid')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="upiid">UPI ID </label>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="pay_no" type="text"
                                                                name="pay_no" value="{{ $compinfofooter->pay_no }}" />
                                                            <span class="text-danger">
                                                                @error('pay_no')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="pay_no">Phone Pay / Gpay </label>
                                                        </div>

                                                    </div>






                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="bank_branch" type="text"
                                                                name="bank_branch"
                                                                value="{{ $compinfofooter->bank_branch }}" />
                                                            <span class="text-danger">
                                                                @error('bank_branch')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="bank_branch">Bank Branch </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="section-title">Voucher & Invoice Settings</div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="voucher_prefix" type="text"
                                                                name="voucher_prefix"
                                                                value="{{ $compinfofooter->voucher_prefix }}" />
                                                            <span class="text-danger">
                                                                @error('voucher_prefix')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="voucher_prefix">Voucher Prefix</label>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="voucher_suffix" type="text"
                                                                name="voucher_suffix"
                                                                value="{{ $compinfofooter->voucher_suffix }}" />
                                                            <span class="text-danger">
                                                                @error('voucher_suffix')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="voucher_suffix">Voucher Suffix </label>
                                                        </div>

                                                    </div>






                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="voucher_note" type="text"
                                                                name="voucher_note"
                                                                value="{{ $compinfofooter->voucher_note }}" />
                                                            <span class="text-danger">
                                                                @error('voucher_note')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="voucher_note">Voucher Note </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="section-title">Region & Currency</div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="ct1" type="text"
                                                                name="ct1" value="{{ $compinfofooter->ct1 }}" />
                                                            <span class="text-danger">
                                                                @error('ct1')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="ct1">Jurisdiction </label>
                                                        </div>

                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <select class="form-select" id="country" name="country">
                                                                <option value="India"
                                                                    {{ old('country', $compinfofooter->country) == 'India' ? 'selected' : '' }}>
                                                                    Indian</option>

                                                                <option value="USA"
                                                                    {{ old('country', $compinfofooter->country) == 'USA' ? 'selected' : '' }}>
                                                                    USA</option>
                                                                <option value="UK"
                                                                    {{ old('country', $compinfofooter->country) == 'UK' ? 'selected' : '' }}>
                                                                    UK</option>
                                                                <option value="Canada"
                                                                    {{ old('country', $compinfofooter->country) == 'Canada' ? 'selected' : '' }}>
                                                                    Canada</option>
                                                                <option value="Australia"
                                                                    {{ old('country', $compinfofooter->country) == 'Australia' ? 'selected' : '' }}>
                                                                    Australia</option>
                                                                <option value="UAE"
                                                                    {{ old('country', $compinfofooter->country) == 'UAE' ? 'selected' : '' }}>
                                                                    UAE</option>
                                                                <option value="Saudi Arabia"
                                                                    {{ old('country', $compinfofooter->country) == 'Saudi Arabia' ? 'selected' : '' }}>
                                                                    Saudi Arabia</option>
                                                                <option value="Indonesia"
                                                                    {{ old('country', $compinfofooter->country) == 'Indonesia' ? 'selected' : '' }}>
                                                                    Indonesia</option>
                                                                <option value="DR Congo"
                                                                    {{ old('country', $compinfofooter->country) == 'DR Congo' ? 'selected' : '' }}>
                                                                    DR Congo</option>
                                                                <option value="Madagascar"
                                                                    {{ old('country', $compinfofooter->country) == 'Madagascar' ? 'selected' : '' }}>
                                                                    Madagascar</option>


                                                            </select>
                                                            <span class="text-danger">
                                                                @error('country')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="country">Countery </label>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <select class="form-select" id="currency" name="currency">
                                                                <option value="INR"
                                                                    {{ old('currency', $compinfofooter->currency) == 'INR' ? 'selected' : '' }}>
                                                                    &#x20B9; Indian Rupee (INR)</option>
                                                                <option value="USD"
                                                                    {{ old('currency', $compinfofooter->currency) == 'USD' ? 'selected' : '' }}>
                                                                    &#36; US Dollar (USD)</option>
                                                                <option value="EUR"
                                                                    {{ old('currency', $compinfofooter->currency) == 'EUR' ? 'selected' : '' }}>
                                                                    &#x20AC; Euro (EUR)</option>
                                                                <option value="GBP"
                                                                    {{ old('currency', $compinfofooter->currency) == 'GBP' ? 'selected' : '' }}>
                                                                    &#xa3; British Pound (GBP)</option>
                                                                <option value="JPY"
                                                                    {{ old('currency', $compinfofooter->currency) == 'JPY' ? 'selected' : '' }}>
                                                                    &#xa5; Japanese Yen (JPY)</option>
                                                                <option value="AUD"
                                                                    {{ old('currency', $compinfofooter->currency) == 'AUD' ? 'selected' : '' }}>
                                                                    &#x41;&#x24; Australian Dollar (AUD)</option>
                                                                <option value="AED"
                                                                    {{ old('currency', $compinfofooter->currency) == 'AED' ? 'selected' : '' }}>
                                                                    &#x62f;.&#x625; United Arab Emirates Dirham (AED)
                                                                </option>
                                                                <option value="SAR"
                                                                    {{ old('currency', $compinfofooter->currency) == 'SAR' ? 'selected' : '' }}>
                                                                    &#x0631;.&#x0633; Saudi Riyal (SAR)</option>
                                                                <option value="MGA"
                                                                    {{ old('currency', $compinfofooter->currency) == 'MGA' ? 'selected' : '' }}>
                                                                    Malagasy Ariary (AR)</option>
                                                            </select>
                                                            <span class="text-danger">
                                                                @error('currency')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="currency">Currency</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="section-title">Business Configuration</div>

                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="ct2" type="text"
                                                                name="ct2" value="{{ $compinfofooter->ct2 }}" />
                                                            <span class="text-danger">
                                                                @error('ct2')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="ct2">Business </label>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="ct3" type="text"
                                                                name="ct3" value="{{ $compinfofooter->ct3 }}" />
                                                            <span class="text-danger">
                                                                @error('ct3')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="ct3">Invoice Head </label>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="ct4" type="text"
                                                                name="ct4" value="{{ $compinfofooter->ct4 }}" />
                                                            <span class="text-danger">
                                                                @error('ct4')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="ct4">Hotel Link </label>
                                                        </div>

                                                    </div>


                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="ct5" type="text"
                                                                name="ct5" value="{{ $compinfofooter->ct5 }}" />
                                                            <span class="text-danger">
                                                                @error('ct5')
                                                                    `
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="ct5">Bank A/c Name </label>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <select class="form-select" id="ct7" name="ct7">
                                                                <option value="GST"
                                                                    {{ old('ct7', $compinfofooter->ct7) == 'GST' ? 'selected' : '' }}>
                                                                    GST</option>
                                                                <option value="VAT"
                                                                    {{ old('ct7', $compinfofooter->ct7) == 'VAT' ? 'selected' : '' }}>
                                                                    VAT</option>

                                                            </select>
                                                            <span class="text-danger">
                                                                @error('tax_type')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                            <label for="tax_type">Tax System</label>
                                                        </div>

                                                    </div>


                                                </div>


                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-check mb-3 mb-md-0">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="ct6" name="ct6" value="1"
                                                                {{ old('ct6', $compinfofooter->ct6) == 1 ? 'checked' : '' }}>

                                                            <label class="form-check-label" for="ct6">Restaurant &
                                                                Room Food Bill Tax Inclusive </label>
                                                            <br>
                                                            <span class="text-danger">
                                                                @error('ct6')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-group mb-3 mb-md-0">
                                                    <div class="section-title">Terms & Conditions</div>

                        
                                                    <textarea rows="6" name="terms" class="form-control"
                                                        placeholder="• One term per line&#10;• Appears on invoice&#10;• Keep it short">
{{ old('terms', $compinfofooter->terms) }}
</textarea>

                                                </div>


                                                <div class="mt-4 mb-0">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary btn-lg">
                                                            💾 Save & Apply Changes
                                                        </button>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a
                                                    class= "btn btn-dark  "href={{ url()->previous() }}>Back</a></div>
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
