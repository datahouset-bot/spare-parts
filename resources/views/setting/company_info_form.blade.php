@extends('layouts.blank')
@section('pagecontent')
    <div class="container ">
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

                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">

                                                            @if (auth()->check() && Auth::user()->email === Auth::user()->firm_id . '@gmail.com')
                                                                <div>
                                                                    <label>
                                                                        <input type="checkbox" name="gst_notapplicable"
                                                                            value="1"
                                                                            {{ $companyInfo->gst_notapplicable ? 'checked' : '' }}>
                                                                        GST Not Applicable
                                                                    </label>
                                                                    <label>
                                                                        <input type="checkbox"
                                                                            name="make_all_bill_local_gst" value="1"
                                                                            {{ $companyInfo->make_all_bill_local_gst ? 'checked' : '' }}>
                                                                        Make All Bill Local GST
                                                                    </label>
                                                                    <label>
                                                                        <input type="checkbox"
                                                                            name="requierd_aspedted_checkout"
                                                                            value="1"
                                                                            {{ $companyInfo->componyinfo_af1 ? 'checked' : '' }}>
                                                                        Requierd Expected Check-Out
                                                                    </label>
                                                                    <label>
                                                                        <input type="checkbox" name="componyinfo_af2"
                                                                            value="1"
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
                                                        <button
                                                            type="submit"class="btn btn-primary btn-block">Apply</button>
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
