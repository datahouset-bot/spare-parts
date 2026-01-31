@extends('layouts.blank')

@section('pagecontent')

<div class="container-fluid py-4">

    {{-- Alerts --}}
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">
                
                {{-- Header --}}
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="mb-0 text-center">
                        <i class="fa fa-cogs me-2"></i> Business Settings
                    </h4>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">

                    <form action="{{ route('businesssettings.update', 1) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Calculation Type --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Calculation Type
                                </label>
                                <select name="calculation_type" class="form-select">
                                    <option value="24hour" selected>24 Hour</option>
                                    <option value="12hour">12 Hour</option>
                                </select>
                                @error('calculation_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Standard Checkout Time --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Standard Checkout Time
                                </label>
                                <input type="time"
                                       name="standard_checkout_time"
                                       class="form-control"
                                       required>
                                @error('standard_checkout_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        {{-- Divider --}}
                        <hr class="my-4">

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-check me-1"></i> Apply Settings
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
