@php
    include public_path('cdn/cdn.blade.php');
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css') }}">

@extends('layouts.blank')

@section('pagecontent')
<style>
    /* ==============================
       GLOBAL FORM LOOK
    ============================== */
    .card {
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .card-header {
        font-weight: 700;
        letter-spacing: .3px;
    }

    label {
        font-size: 13px;
        background: white;
        padding: 0 6px;
    }

    /* ==============================
       INPUT POLISH
    ============================== */
    .form-control {
        border-radius: 8px;
        padding: 8px 10px;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25);
    }

    /* ==============================
       FIELD BLOCK SPACING
    ============================== */
    .position-relative {
        margin-bottom: 16px;
    }

    /* ==============================
       PAYMENT DETAIL CARD
    ============================== */
    .payment-card {
        position: sticky;
        top: 90px;
        border-left: 5px solid #0d6efd;
    }

    .payment-card table th {
        background: #f1f5f9;
        font-size: 13px;
    }

    .payment-card table td {
        vertical-align: middle;
    }

    /* ==============================
       AMOUNT INPUT
    ============================== */
    .amount_input {
        width: 100%;
        border-radius: 6px;
        padding: 6px;
        font-weight: 600;
        text-align: right;
    }

    /* ==============================
       BUTTONS
    ============================== */
    .btn-primary {
        border-radius: 10px;
    }

    .btn-success, .btn-dark {
        border-radius: 8px;
    }

    /* ==============================
       TABLE SCROLL
    ============================== */
    #payment_selection_box {
        background-color: rgb(242, 247, 247);
        border: 5px solid #2196F3;
        max-height: 270px;
        min-height: 170px;
        overflow: auto;
    }

    body.modal-open {
        overflow: auto !important;
    }

    #guest_pic_trigger {
        display: block;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: bold;
        color: #007bff;
        background-color: #f8f9fa;
        border: 2px dashed #007bff;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #guest_pic_trigger:hover {
        background-color: #e9ecef;
        border-color: #0056b3;
        color: #0056b3;
    }

    #guest_pic_trigger:focus {
        outline: none;
        background-color: #dbe9f4;
        border-color: #003d82;
        color: #003d82;
    }

    .custom-modal-size .modal-dialog {
        width: 40%;
        height: 40%;
        max-width: none;
    }

    .custom-modal-size .modal-content {
        height: 30%;
    }

    #pic_trigger {
        display: block;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: bold;
        color: #007bff;
        background-color: #f8f9fa;
        border: 2px dashed #007bff;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #pic_trigger:hover {
        background-color: #e9ecef;
        border-color: #0056b3;
        color: #0056b3;
    }

    #pic_trigger:focus {
        outline: none;
        background-color: #dbe9f4;
        border-color: #003d82;
        color: #003d82;
    }

    #pic_trigger::placeholder {
        color: #6c757d;
        font-style: italic;
    }

    #room_selection_box {
        background-color: rgb(242, 247, 247);
        border: 5px solid #2196F3;
        max-height: 170px;
        min-height: 170px;
        overflow: auto;
    }

    #room_selection,
    #payment_det {
        width: 100%;
        border: 2px solid #ddd;
    }

    #other_charge_detail {
        width: 200px;
        font-size: 15px;
    }

    #room_selection tr {
        border-bottom: 1px solid #ddd;
    }

    #room_selection td {
        padding: 3px;
        text-align: left;
        font-style: bold;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-size: 20px;
        border: 1px solid #ddd;
        background-color: white;
        color: #048af8;
    }

    #payment_dt td {
        padding: 3px;
        text-align: left;
        font-style: bold;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-size: 20px;
        border: 1px solid #ddd;
        background-color: white;
        color: #048af8;
    }

    .container_chekbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 1px;
        cursor: pointer;
        font-size: large;
        text-align: center;
        user-select: none;
    }

    .container_chekbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border: 1px solid;
    }

    .container_chekbox:hover input ~ .checkmark {
        background-color: white;
        border: 1px solid;
    }

    .container_chekbox input:checked ~ .checkmark {
        background-color: #2196F3;
        border: 1px solid;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .container_chekbox input:checked ~ .checkmark:after {
        display: block;
    }

    .container_chekbox .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 12px;
        border: solid white;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }

    #checkin_room_tariff {
        width: 55px;
        font-size: 15px;
    }

    #checkin_room_dis {
        width: 35px;
        font-size: 15px;
    }

    #checkin_room_no {
        width: 80px;
        font-size: 15px;
    }

    #checkin_roomtype {
        width: 130px;
        font-size: 15px;
    }

    label {
        color: blue;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-size: 15px;
        font-style: bold;
        font-weight: 800;
    }

    .amount_input {
        width: 100px;
        font-size: 15px;
    }

    .requierdfield {
        color: red;
        font-size: x-large;
        text-align: left;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<div class="card my-1">
    <div class="row">
        <div class="container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card mt-1">
                            <div class="card-header">
                                <h5 class="text-center font-weight-light my-1"
                                    style="background-color: lightskyblue; font-size:24px;">
                                    Material CHALLAN
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!-- LEFT SIDE -->
                                    <div class="col-md-6 col-6 mt-4">
                                        <div class="position-relative col-md-4 w-75" style="border:none">
                                            <div id="searchCustomer">
                                                <form id="saveForm" action="{{ route('crusher.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <span id="message"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-centerm-3">
                                        <div class="col-md-8">
                                            <div class="row form-group">
                                                <div class="row g-0">
                                                    <div class="col-md-4 col-4 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 5px;">
                                                            <label for="label1" class="position-absolute bg-transparent px-2"
                                                                   style="top: -22px; left: 3px;">
                                                                <span class="requierdfield">*</span>Slip No
                                                            </label>
                                                            <input type="text" value="{{ $nextSlip }}" readonly class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-4 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 5px;">
                                                            <label for="checkin_date" class="position-absolute bg-white px-2"
                                                                   style="top: -22px; left: 3px;">
                                                                <span class="requierdfield">*</span>Date
                                                            </label>
                                                            <input class="form-control date" id="date" type="text" name="date"
                                                                   value="{{ date('Y-m-d') }}" />
                                                            <span class="text-danger">
                                                                @error('date') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-4 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 5px;">
                                                            <label for="checkin_time" class="position-absolute bg-white px-2"
                                                                   style="top: -22px; left: 3px;">
                                                                <span class="requierdfield">*</span>Time
                                                            </label>
                                                            <input class="form-control" id="time" type="time" name="time"
                                                                   value="{{ date('H:i') }}" />
                                                            <span class="text-danger">
                                                                @error('time') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <select id="search_id" name="search_id" class="form-select">
                                                                <option disabled selected>Select party name</option>
                                                                @foreach ($account as $acc)
                                                                    <option value="{{ $acc['id'] }}">
                                                                        {{ $acc['account_name'] }}
                                                                    </option>
                                                                @endforeach
                                                                <input type="hidden" id="party_name" name="party_name">
                                                            </select>
                                                        </div>
                                                        <span class="text-danger">
                                                            @error('cust_name_id') {{ $message }} @enderror
                                                        </span>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <div class="input-group">
                                                                <select id="vehicle_id" name="vehicle_id" class="form-select">
                                                                    <option disabled selected>Select Vehicle no</option>
                                                                    @foreach ($vehicle as $acc)
                                                                    <option value="{{ $acc->id }}"
                                                                        data-vehicle-measure="{{ $acc->vehicle_measure }}"
                                                                        data-vehicle-no="{{ $acc->Vehicle_no }}">
                                                                        {{ $acc->Vehicle_no }}
                                                                    </option>
                                                                    @endforeach
                                                                    <input type="hidden" id="vehicle_no" name="vehicle_no">
                                                                </select>
                                                            </div>

                                                            <span class="text-danger">
                                                                @error('vehicle_no') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label class="position-absolute bg-white px-2"
                                                                   style="top: -21px; left: 2px;">
                                                                <span class="requierdfield">*</span>Vehicle Measure
                                                            </label>
                                                            <input class="form-control" id="vehicle_measure" type="text"
                                                                   name="vehicle_measure" readonly>
                                                            <span class="text-danger">
                                                                @error('Vehicle_measure') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="Material" class="position-absolute bg-white px-2"
                                                                   style="top: -21px; left: 2px;">
                                                                <span class="requierdfield">*</span>Material
                                                            </label>
                                                            <input class="form-control" id="Material" type="text" name="Material"
                                                                   value="{{ old('Material') }}" autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('Material') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="Quantity" class="position-absolute bg-white px-2"
                                                                   style="top: -21px; left: 2px;">
                                                                <span class="requierdfield">*</span>Quantity
                                                            </label>
                                                            <input class="form-control" id="Quantity" type="text" name="Quantity"
                                                                   value="{{ old('Quantity') }}" autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('Quantity') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="Rate" class="position-absolute bg-white px-2"
                                                                   style="top: -21px; left: 2px;">
                                                                Rate
                                                            </label>
                                                            <input class="form-control" id="Rate" type="text" name="Rate"
                                                                   value="{{ old('Rate') }}" autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('Rate') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="Royalty" class="position-absolute bg-white px-2"
                                                                   style="top: -21px; left: 2px;">
                                                                <span class="requierdfield">*</span>Royalty
                                                            </label>
                                                            <input class="form-control" id="Royalty" type="text" name="Royalty"
                                                                   value="{{ old('Royalty') }}" autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('Royalty') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="total" class="position-absolute bg-white px-2"
                                                                   style="top: -21px; left: 2px;">
                                                                Total
                                                            </label>
                                                            <input class="form-control" id="total" type="text" name="total"
                                                                   value="{{ old('total') }}" autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('total') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="address" class="position-absolute bg-white px-2"
                                                                   style="top: -10px; left: 10px;">
                                                                Address
                                                            </label>
                                                            <input class="form-control" id="address" type="text" name="address"
                                                                   value="{{ old('address') }}" style="border: none" />
                                                            <span class="text-danger">
                                                                @error('address') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="phone" class="position-absolute bg-white px-1"
                                                                   style="top: -14px; left: 10px;">
                                                                Phone
                                                            </label>
                                                            <input class="form-control" id="phone" type="text" name="phone"
                                                                   value="{{ old('phone') }}" autocomplete="none" style="border: none" />
                                                            <span class="text-danger">
                                                                @error('phone') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="remark" class="position-absolute bg-white px-2"
                                                                   style="top: -10px; left: 10px;">
                                                                Remark
                                                            </label>
                                                            <input class="form-control" id="remark" type="text" name="remark"
                                                                   value="" style="border: none" />
                                                            <span class="text-danger">
                                                                @error('remark') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    {{-- IMAGE 1 FIELD --}}
                                                    <div class="col-md-6 col-6 mt-4">
                                                        <div class="position-relative border col-md-4 w-75" style="border-radius: 4px;">
                                                            <label for="pic_trigger" class="position-absolute bg-white px-2"
                                                                   style="top: -10px; left: 10px;">
                                                                Image 1
                                                            </label>
                                                            <input class="form-control"
                                                                   id="pic_trigger"
                                                                   type="text"
                                                                   readonly
                                                                   placeholder="Click to upload or capture"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#fileUploadModal"
                                                                   style="border: none" />
                                                            <span class="text-danger">
                                                                @error('pic') {{ $message }} @enderror
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="fileUploadModal" tabindex="-1"
                                                         aria-labelledby="fileUploadModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="fileUploadModalLabel">
                                                                        Image 1
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Drag and Drop -->
                                                                    <div class="mb-3">
                                                                        <label for="pic" class="form-label">Drag & Drop</label>
                                                                        <div id="dropZone"
                                                                             style="border: 2px dashed #007bff; padding: 15px; text-align: center; cursor: pointer; font-size: 14px;">
                                                                            Drag & drop a file here or click
                                                                        </div>
                                                                    </div>
                                                                    <!-- Select from Gallery -->
                                                                    <div class="mb-3">
                                                                        <label for="pic_file" class="form-label">Select from Gallery</label>
                                                                        <input type="file" id="pic_file" name="pic" class="form-control" />
                                                                    </div>
                                                                    
                                                                    <!-- Webcam Capture -->
                                                                    <div class="mb-3">
                                                                        <label for="webcam" class="form-label">Capture from Webcam</label>
                                                                        <div>
                                                                            <video id="webcam" autoplay
                                                                                   style="width: 100%; max-height: 150px;"></video>
                                                                            <button id="captureBtn"
                                                                                    class="btn btn-primary btn-sm mt-2">
                                                                                Capture
                                                                            </button>
                                                                            <canvas id="canvas" style="display: none;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- END IMAGE MODAL --}}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- RIGHT SIDE – PAYMENT -->
                                        <div class="col-md-4">
                                            <div class="card shadow-sm sticky-top" style="top:90px;">
                                                <div class="card-header bg-primary text-white fw-bold text-center">
                                                    Payment Detail
                                                </div>

                                                <div class="card-body p-2">
                                                    <table id="payment_selection_box"
                                                           class="table table-striped table-bordered table-sm">
                                                        <thead>
                                                        <tr>
                                                            <th>Payment Mode</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="payment_mode_body">
                                                        <tr>
                                                            <td>Total cost</td>
                                                            <td>
                                                                <input type="text"
                                                                       id="cost"
                                                                       name="cost"
                                                                       class="cost"
                                                                       readonly>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <select name="posting_acc_id[]"
                                                                        class="posting_acc_id">
                                                                    <option value="" selected disabled>Select Mode</option>
                                                                    {{-- @foreach ($paymentmodes as $paymentmode)
                                                                     <option value="{{ $paymentmode->id }}">
                                                                         {{ $paymentmode->account_name }}</option>
                                                                     @endforeach --}}
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                       class="mode"
                                                                       name="mode"
                                                                       autocomplete="off">
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                    <table class="table table-sm table-bordered" id="payment_det">
                                                        <tr>
                                                            <td>
                                                                <button type="button"
                                                                        id="add_payment_mode"
                                                                        class="btn btn-sm btn-success w-100">
                                                                    + Payment Mode
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                       id="Payment"
                                                                       name="Payment"
                                                                       class="Payment"
                                                                       readonly>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Payment Reference</td>
                                                            <td>
                                                                <input type="text"
                                                                       name="payment_ref"
                                                                       class="amount_input">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Payment Remark</td>
                                                            <td>
                                                                <input type="text"
                                                                       name="payment_remark"
                                                                       class="amount_input">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        @can('Save')
                                            <div class="card-footer text-center py-3">
                                                <div class="small">
                                                    <button id="saveButton"
                                                            type="submit"
                                                            class="btn btn-primary btn-block">
                                                        Save
                                                    </button>
                                                    <a class="btn btn-dark" href="{{ url('crusher') }}">Back</a>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>

                                    </form> {{-- end #saveForm --}}
                                </div> {{-- card-body --}}
                            </div> {{-- card --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- ======================= PARTY NAME FILL ======================= --}}
<script>
$(document).ready(function () {
    $('#search_id').on('change', function () {
        let selectedPartyName = $(this).find(':selected').text().trim();
        $('#party_name').val(selectedPartyName);
    });
});
</script>

{{-- ======================= TOTAL CALC ======================= --}}
<script>
$(document).ready(function () {

    function calculateTotal() {
        let quantity = parseFloat($('#Quantity').val()) || 0;
        let rate     = parseFloat($('#Rate').val()) || 0;
        let royalty  = parseFloat($('#Royalty').val()) || 0;

        let total = (quantity * rate) + (royalty ? royalty : 0);
        $('#total').val(total.toFixed(2));
    }

    $('#Quantity, #Rate, #Royalty').on('keyup change', calculateTotal);
});
</script>

{{-- ======================= VEHICLE DETAILS FILL ======================= --}}
<script>
$(document).ready(function () {
    $('#vehicle_id').on('change', function () {
        let selectedOption = $(this).find(':selected');

        let vehicleMeasure = selectedOption.data('vehicle-measure');
        $('#vehicle_measure').val(vehicleMeasure);

        let vehicleNo = selectedOption.data('vehicle-no');
        $('#vehicle_no').val(vehicleNo);
    });
});
</script>

{{-- ======================= DATE & TIME DEFAULT ======================= --}}
<script>
$(document).ready(function () {
    let now = new Date();

    let date = now.toISOString().split('T')[0];
    $('#date').val(date);

    let hours = String(now.getHours()).padStart(2, '0');
    let minutes = String(now.getMinutes()).padStart(2, '0');
    $('#time').val(hours + ':' + minutes);
});
</script>

{{-- ======================= IMAGE 1 SHORT SCRIPT ======================= --}}
<script>
$(function () {

    const fileInput = $('#pic_file');
    const trigger   = $('#pic_trigger');
    const modal     = $('#fileUploadModal');

    const video  = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');

    let stream     = null;
    let cameraOpen = false;

    // ✅ Drag area opens file dialog
    $('#dropZone').on('click', function () {
        fileInput.click();
    });

    // ✅ Gallery select
    fileInput.on('change', function () {
        if (this.files.length > 0) {
            trigger.val(this.files[0].name);
            modal.modal('hide');
        }
    });

    // ✅ Capture button (toggle camera → take photo)
    $('#captureBtn').on('click', async function (e) {
        e.preventDefault();

        // 👉 FIRST CLICK → OPEN CAMERA
        if (!cameraOpen) {

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Camera not supported');
                return;
            }

            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            video.style.display = 'block';

            cameraOpen = true;
            $(this).text('Take Photo');
            return;
        }

        // 👉 SECOND CLICK → CAPTURE PHOTO
        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;

        canvas.getContext('2d').drawImage(video, 0, 0);

        canvas.toBlob(function (blob) {

            let filename = 'image_' + Date.now() + '.jpg';
            let file = new File([blob], filename, { type: 'image/jpeg' });

            let dt = new DataTransfer();
            dt.items.add(file);
            fileInput[0].files = dt.files;

            trigger.val(filename);

            // ✅ Stop camera
            stream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
            video.style.display = 'none';

            cameraOpen = false;
            $('#captureBtn').text('Capture');

            modal.modal('hide');

        }, 'image/jpeg');
    });

    // ✅ When modal closes → stop camera safely
    modal.on('hidden.bs.modal', function () {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraOpen = false;
        $('#captureBtn').text('Capture');
        video.style.display = 'none';
    });

});
</script>


{{-- ======================= AJAX SAVE ======================= --}}
<script>
$(function () {
    $('#saveForm').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let formdata = new FormData(form);

        $('#saveButton')
            .prop('disabled', true)
            .html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#saveButton').prop('disabled', false).html('Save');
                alert(response.message || 'Saved successfully');
            },
            error: function (xhr) {
                $('#saveButton').prop('disabled', false).html('Save');

                if (xhr.status === 422) {
                    let message = '';
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        message += value[0] + '\n';
                    });
                    alert(message);
                } else {
                    alert('❌ Server error');
                }
            }
        });
    });
});
</script>

@endsection
