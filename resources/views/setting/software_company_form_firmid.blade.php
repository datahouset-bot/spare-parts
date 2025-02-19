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
                                        <h3 class="text-center font-weight-light my-4">Software Company Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ url('store_softwarecompny_firmid') }}" method="POST">
                                            @csrf
                                            <div class="row">

                                            

                                            <!-- Activation Date -->
                                            <div class="form-floating col-md-3 mb-3">
                                                <input class="form-control" id="firm_id" type="text" name="firm_id" value="{{$firm_id}} "  readonly/>
                                                <label for="activation_date">Firm Id </label>
                                            </div>
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
                                                        <input class="form-control" id="software_af1" type="text" name="software_af1" value="{{ old('software_af1' , $software_companyInfo->{'software_af1' } ?? '') }}" />
                                                        <label for="software_af1">Business Type  </label>
                                                    </div>
                                                </div>
                                                @foreach (range(2, 10) as $index)
                                                    <div class="col-md-4 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <input class="form-control" id="software_af{{ $index }}" type="text" name="software_af{{ $index }}" value="{{ old('software_af' . $index, $software_companyInfo->{'software_af' . $index} ?? '') }}" />
                                                            <label for="software_af{{ $index }}">Software AF{{ $index }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
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
