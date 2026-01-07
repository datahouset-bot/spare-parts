@php
    include public_path('cdn/cdn.blade.php');
@endphp

@extends('layouts.blank')

@section('pagecontent')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<style>
/* ========= GLOBAL UI ========= */
.card {
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
}
.form-label {
    font-weight: 600;
    font-size: 13px;
    color: #0d6efd;
}
.form-control,
.form-select,
.select2-container--default .select2-selection--single {
    height: 42px !important;
    border-radius: 8px;
    font-size: 14px;
}
.select2-selection__rendered {
    line-height: 42px !important;
}
.select2-selection__arrow {
    height: 42px !important;
}
.section-title {
    font-weight: 700;
    font-size: 15px;
    margin: 20px 0 10px;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 6px;
}
.image-trigger {
    cursor: pointer;
    background: #f8f9fa;
}
.input-group .select2-container {
    flex: 1 1 auto !important;
    width: auto !important;
}

.input-group .btn {
    white-space: nowrap;
}

</style>

<div class="container mt-3">

    {{-- ALERTS --}}
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header text-center fw-bold">
            Add Item / Product
        </div>

        <div class="card-body">
            <form action="{{ url('/saveitem') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- BASIC DETAILS --}}
                <div class="section-title">Basic Details</div>

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Item / Product Name</label>
                        <input type="text" name="item_name" class="form-control" value="{{ old('item_name') }}">
                        @error('item_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Barcode No</label>
                        <input type="text" name="item_barcode" class="form-control" value="{{ old('item_barcode') }}">
                        @error('item_barcode') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

              {{-- COMPANY & GROUP --}}
<div class="section-title">Classification</div>

<div class="row g-3">

    {{-- COMPANY --}}
    <div class="col-md-6">
        <label class="form-label">Company</label>

        <div class="input-group">
            <select name="company_id" id="mycompany" class="form-select">
                <option value="">Select Company</option>
                @foreach($companydata as $c)
                    <option value="{{ $c->id }}">{{ $c->comp_name }}</option>
                @endforeach
            </select>

            <button type="button"
                    class="btn btn-outline-primary"
                    id="addCompanyBtn"
                    title="Add New Company">
                <i class="fa fa-plus"></i>
            </button>
        </div>

        @error('company_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- ITEM GROUP --}}
    <div class="col-md-6">
        <label class="form-label">Item Group</label>

        <div class="input-group">
            <select name="group_id" id="myitemgroup" class="form-select">
                <option value="">Select Group</option>
                @foreach($itemgroupdata as $g)
                    <option value="{{ $g->id }}">{{ $g->item_group }}</option>
                @endforeach
            </select>

            <button type="button"
                    class="btn btn-outline-primary"
                    id="addGroupBtn"
                    title="Add New Item Group">
                <i class="fa fa-plus"></i>
            </button>
        </div>

        @error('group_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

</div>

                {{-- PRICING --}}
                <div class="section-title">Pricing</div>

                <div class="row g-3">
                    <div class="col-md-2"><label class="form-label">MRP</label><input class="form-control" name="mrp"></div>
                    <div class="col-md-2"><label class="form-label">Sale Rate</label><input class="form-control" name="sale_rate"></div>
                    <div class="col-md-2"><label class="form-label">Rate A</label><input class="form-control" name="sale_rate_a"></div>
                    <div class="col-md-2"><label class="form-label">Rate B</label><input class="form-control" name="sale_rate_b"></div>
                    <div class="col-md-2"><label class="form-label">Rate C</label><input class="form-control" name="sale_rate_c"></div>
                    <div class="col-md-2"><label class="form-label">Purchase Rate</label><input class="form-control" name="purchase_rate"></div>
                </div>

                {{-- TAX & UNIT --}}
                <div class="section-title">Tax & Unit</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Unit</label>
                        <select name="unit_id" class="form-select">
                            <option value="">Select Unit</option>
                            @foreach($unit as $u)
                                <option value="{{ $u->id }}">{{ $u->primary_unit_name }}</option>
                            @endforeach
                        </select>
                        @error('unit_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">GST / Tax</label>
                        <select name="item_gst_id" class="form-select">
                            <option value="">Select GST</option>
                            @foreach($gstmaster as $g)
                                <option value="{{ $g->id }}">{{ $g->taxname }}</option>
                            @endforeach
                        </select>
                        @error('item_gst_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- IMAGE --}}
                <div class="section-title">Item Image</div>

                <input type="file" name="item_image" class="form-control">

                {{-- SAVE --}}
                <div class="text-center mt-4">
                    <button class="btn btn-primary px-5">Save Item</button>
                    <a href="{{ url('item') }}" class="btn btn-dark px-4">Back</a>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
$('#mycompany, #myitemgroup').select2({
    width: '100%',
    placeholder: 'Select option',
    allowClear: true
});
</script>
<script>
$('#addCompanyBtn').on('click', function () {
    window.open('/company', '_blank'); // company add page
});

$('#addGroupBtn').on('click', function () {
    window.open('/itemgroups', '_blank'); // item group add page
});
</script>


@endsection
