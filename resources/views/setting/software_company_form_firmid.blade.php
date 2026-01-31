@extends('layouts.blank')
@section('pagecontent')

<div class="container py-4">

    {{-- Flash Message --}}
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-11">

            <div class="card border-0 shadow-lg rounded-4">

                {{-- Header --}}
                <div class="card-header bg-gradient-primary text-white rounded-top-4">
                    <h4 class="mb-0 text-center">
                        <i class="fa fa-building me-2"></i> Software Company Details
                    </h4>
                </div>

                <div class="card-body p-4">

                    <form action="{{ url('store_softwarecompny_firmid') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Basic Info --}}
                        <h6 class="text-primary mb-3">Basic Information</h6>
                        <div class="row g-3">
                            <div class="col-md-3 form-floating">
                                <input class="form-control" value="{{ $firm_id }}" readonly>
                                <label>Firm ID</label>
                            </div>
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

                        {{-- Customer Info --}}
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

                        {{-- Software Firm --}}
                        <h6 class="text-primary mb-3">Software Firm Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input class="form-control" name="software_firm_name"
                                       value="{{ old('software_firm_name', $software_companyInfo->software_firm_name ?? '') }}">
                                <label>Software Firm Name</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Address & Contact --}}
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

                        {{-- Social Media --}}
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

                        {{-- Logos --}}
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

                        {{-- Additional Info --}}
                        <h6 class="text-primary mb-3">Additional Information</h6>
                        <div class="row g-3">
                            <div class="col-md-4 form-floating">
                                <input class="form-control" name="software_af1"
                                       value="{{ old('software_af1', $software_companyInfo->software_af1 ?? '') }}">
                                <label>Business Type</label>
                            </div>

                            @foreach(range(2,10) as $i)
                                <div class="col-md-4 form-floating">
                                    <input class="form-control" name="software_af{{ $i }}"
                                           value="{{ old('software_af'.$i, $software_companyInfo->{'software_af'.$i} ?? '') }}">
                                    <label>Software AF{{ $i }}</label>
                                </div>
                            @endforeach
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-dark px-4">
                                ← Back
                            </a>
                            <button class="btn btn-primary px-5">
                                <i class="fa fa-save me-1"></i> Apply
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
