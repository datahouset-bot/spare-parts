@php
    include public_path('cdn/cdn.blade.php');
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css') }}">
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
    max-height: 250px;
    overflow-y: auto;
}
    body.modal-open {
        overflow: auto !important;
    }

    #payment_selection_box {
        background-color: rgb(242, 247, 247);

        border: 5px solid #2196F3;
        max-height: 270px;
        min-height: 170px;
        overflow: auto;

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
        /* Prevents Bootstrap's default max-width */
    }

    .custom-modal-size .modal-content {
        height: 30%;
        /* Ensures the modal content takes up the full height */
    }

    #pic_trigger {
        display: block;
        /* Makes the input field appear like a button */
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: bold;
        color: #007bff;
        /* Blue color for clickable text */
        background-color: #f8f9fa;
        /* Light background */
        border: 2px dashed #007bff;
        /* Dashed border to emphasize the click area */
        border-radius: 5px;
        /* Rounded corners for better aesthetics */
        text-align: center;
        /* Center the placeholder text */
        cursor: pointer;
        /* Pointer cursor to indicate interactivity */
        transition: all 0.3s ease;
        /* Smooth hover and focus effects */
    }

    /* Hover effect for better visibility */
    #pic_trigger:hover {
        background-color: #e9ecef;
        /* Slightly darker background on hover */
        border-color: #0056b3;
        /* Darker blue border */
        color: #0056b3;
        /* Darker blue text */
    }

    /* Focus effect for keyboard navigation */
    #pic_trigger:focus {
        outline: none;
        background-color: #dbe9f4;
        /* Subtle focus background */
        border-color: #003d82;
        /* Stronger blue border */
        color: #003d82;
        /* Stronger blue text */
    }

    /* Add a hint text to guide users */
    #pic_trigger::placeholder {
        color: #6c757d;
        /* Neutral gray for placeholder text */
        font-style: italic;
    }

    #room_selection_box {
        background-color: rgb(242, 247, 247);

        border: 5px solid #2196F3;
        max-height: 170px;
        min-height: 170px;
        overflow: auto;

    }

    #payment_selection_box {
        background-color: rgb(242, 247, 247);

        border: 5px solid #2196F3;
        max-height: 270px;
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

    /* Style the table rows */
    #room_selection tr {
        border-bottom: 1px solid #ddd;
    }

    /* Style the table cells */
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
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container_chekbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border: 1px solid;
    }

    /* On mouse-over, add a grey background color */
    .container_chekbox:hover input~.checkmark {
        background-color: white;
        border: 1px solid;
    }

    /* When the checkbox is checked, add a blue background */
    .container_chekbox input:checked~.checkmark {
        background-color: #2196F3;
        border: 1px solid;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container_chekbox input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container_chekbox .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 12px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
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
{{-- <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css"> --}}
{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}
{{-- <script src="jquery/master.js"></script> --}}
{{-- <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script> --}}
@extends('layouts.blank')
@section('pagecontent')
    <div class="card my-1 ">
        <div class="row ">


            <div class="container ">

                <body class="bg-primary">
                    <div class="container">

                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card  mt-1">
                                    <div class="card-header">
                                        <h5 class="text-center font-weight-light my-1" style="background-color: lightskyblue; font-size:24px;">Material CHALLAN </h5>
                                    </div>
                                    <div class="card-body">


                                        <div class="row">
                                            <!-- Room Booking -->
                                            <div class="col-md-6 col-6 mt-4">
                                                <div class="position-relative  col-md-4 w-75" style="border:none">
                                                    {{-- <label for="searchCustomer" class="position-absolute "
                                                        style="top: -22px; left: 10px;">Select Slot </label> --}}
                                                    <div id="searchCustomer">
<form id="saveForm"  action="{{ route('crusher.store') }}" method="POST" enctype="multipart/form-data">
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
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 5px;">
                                                                    <label
                                                                        for="label1"class="position-absolute bg-transparent px-2"
                                                                        style="top: -22px; left: 3px;"><span class="requierdfield">*</span>Slip No </label>
                                                                   <input type="text" value="{{ $nextSlip }}" readonly class="form-control">

                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-4 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 5px;">
                                                                    <label
                                                                        for="checkin_date"class="position-absolute bg-white px-2"
                                                                        style="top: -22px; left: 3px;"><span
                                                                            class="requierdfield">*</span>Date</label>
                                                                    <input class="form-control date" id="date"
                                                                        type="text" name="date"
                                                                        value="{{ date('Y-m-d') }}" />
                                                                    <span class="text-danger">
                                                                        @error('date')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-4 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 5px;">
                                                                    <label
                                                                        for="checkin_time"class="position-absolute bg-white px-2"
                                                                        style="top: -22px; left: 3px;"> <span
                                                                            class="requierdfield">*</span>Time</label>
                                                                    <input class="form-control" id="time"
                                                                        type="time" name="time"
                                                                        value="{{ date('Y-m-d') }}" />
                                                                    <span class="text-danger">
                                                                        @error('time')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                                  <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                    <select id="search_id" name="search_id" class="form-select">
                                                        <option disabled selected>Select party name</option>
                                                        @foreach ($account as $acc)
                                                            <option value={{ $acc['id'] }}>
                                                                {{ $acc['account_name'] }}
                                                             </option>
                                                        @endforeach
                                                             <input type="hidden" id="party_name" name="party_name">
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    @error('cust_name_id')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                                            <div class="col-md-6  col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    {{-- <span class="requierdfield">*</span> --}}
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
                                                                        @error('vehicle_no')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div> 

                                                          
                                                            
                                                            <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                            <label class="position-absolute bg-white px-2"
                                                            style="top: -21px; left: 2px;">
                                                            <span class="requierdfield">*</span>Vehicle Measure
                                                            </label>
                                                            <input class="form-control"
                                                                   id="vehicle_measure"
                                                                   type="text"
                                                                   name="vehicle_measure"
                                                                   readonly>
                                                            
                                                                    <span class="text-danger">
                                                                        @error('Vehicle_measure')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="Material"class="position-absolute bg-white px-2"
                                                                        style="top: -21px; left: 2px;"><span
                                                                            class="requierdfield">*</span>Material
                                                                    </label>
                                                                    <input class="form-control" id="Material"
                                                                        type="text" name="Material"
                                                                        value="{{ old('Material') }}"
                                                                        autocomplete="none" />
                                                                    <span class="text-danger">
                                                                        @error('Material')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>

                                                          <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="guest_name"class="position-absolute bg-white px-2"
                                                                        style="top: -21px; left: 2px;"><span
                                                                            class="requierdfield">*</span>Quantity
                                                                    </label>
                                                                    <input class="form-control" id="Quantity"
                                                                        type="text" name="Quantity"
                                                                        value="{{ old('Quantity') }}"
                                                                        autocomplete="none" />
                                                                    <span class="text-danger">
                                                                        @error('Quantity')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>

                                                                <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="guest_name"class="position-absolute bg-white px-2"
                                                                        style="top: -21px; left: 2px;">Rate
                                                                    </label>
                                                                    <input class="form-control" id="Rate"
                                                                        type="text" name="Rate"
                                                                        value="{{ old('Rate') }}"
                                                                        autocomplete="none" />
                                                                    <span class="text-danger">
                                                                        @error('Rate')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>

                                                              <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="Royalty"class="position-absolute bg-white px-2"
                                                                        style="top: -21px; left: 2px;"><span
                                                                            class="requierdfield">*</span>Royalty
                                                                    </label>
                                                                    <input class="form-control" id="Royalty"
                                                                        type="text" name="Royalty"
                                                                        value="{{ old('Royalty') }}"
                                                                        autocomplete="none" />
                                                                    <span class="text-danger">
                                                                        @error('Royalty')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>

                                                               <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="guest_name"class="position-absolute bg-white px-2"
                                                                        style="top: -21px; left: 2px;">Total 
                                                                    </label>
                                                                    <input class="form-control" id="total"
                                                                        type="text" name="total"
                                                                        value="{{ old('total') }}"
                                                                        autocomplete="none" />
                                                                    <span class="text-danger">
                                                                        @error('total')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="guest_address"class="position-absolute bg-white px-2"
                                                                        style="top: -10px; left: 10px;">Address</label>
                                                                    <input class="form-control" id="address"
                                                                        type="text" name="address"
                                                                        value="{{ old('address') }}"
                                                                        style="border: none" />
                                                                    <span class="text-danger">
                                                                        @error('address')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="guest_phone"class="position-absolute bg-white px-1"
                                                                        style="top: -14px; left: 10px;">Phone</label>
                                                                    <input class="form-control" id="phone"
                                                                        type="text" name="phone"
                                                                        value="{{ old('phone') }}"
                                                                        autocomplete="none" style="border: none" />
                                                                    <span class="text-danger">
                                                                        @error('phone')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                                <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="checkin_remark1"class="position-absolute bg-white px-2"
                                                                        style="top: -10px; left: 10px;">Remark </label>
                                                                    <input class="form-control" id="remark"
                                                                        type="text" name="remark"
                                                                        value="" style="border: none" />
                                                                    <span class="text-danger">
                                                                        @error('remark')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-6 col-6  mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="checkin_remark2"class="position-absolute bg-white px-2"
                                                                        style="top: -10px; left: 10px;">Remark 2</label>
                                                                    <input class="form-control" id="checkin_remark2"
                                                                        type="text" name="checkin_remark2"
                                                                        value="" style="border: none" />
                                                                    <span class="text-danger">
                                                                        @error('checkin_remark2')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div> --}}
{{-- 
                                                          <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-6 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="guest_idproof_no"class="position-absolute bg-white px-1"
                                                                        style="top: -14px; left: 10px;">Driver Name
                                                                    </label>
                                                                    <input class="form-control" id="guest_idproof_no"
                                                                        type="text" name="guest_idproof_no"
                                                                        value="{{ old('guest_idproof_no') }}"
                                                                        style="border: none" />
                                                                    <span class="text-danger">
                                                                        @error('guest_idproof_no')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 mt-4">
                                                                <div class="position-relative border col-md-6 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label for="guest_contery"
                                                                        class="position-absolute bg-white px-2"
                                                                        style="top: -10px; left: 10px;">Driver Mobile No</label>
                                                                    <input class="form-control" id="guest_contery"
                                                                        type="text" name="guest_contery"
                                                                        value="{{ old('guest_countery', $compinfofooter->country) }}"
                                                                        style="border: none" />
                                                                    <span class="text-danger">
                                                                        @error('guest_contery')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div> --}}

                                                            
                                                             {{-- <div class="col-md-6 col-6 mt-4">
                                                                <div class="position-relative border col-md-4 w-75"
                                                                    style="border-radius: 4px;">
                                                                    <label
                                                                        for="pic_trigger"class="position-absolute bg-white px-2"
                                                                        style="top: -10px; left: 10px;">Image 1 </label>
                                                                    <input class="form-control" id="pic"
                                                                        type="text" readonly
                                                                        placeholder="Click to upload or capture"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#fileUploadModal"
                                                                        style="border: none" />
                                                                    <span class="text-danger">
                                                                        @error('pic')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="fileUploadModal" tabindex="-1"
                                                                aria-labelledby="fileUploadModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="fileUploadModalLabel">
                                                                                Image 1 </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Drag and Drop -->
                                                                            <div class="mb-3">
                                                                                <label for="pic"
                                                                                    class="form-label">Drag & Drop</label>
                                                                                <div id="dropZone"
                                                                                    style="border: 2px dashed #007bff; padding: 15px; text-align: center; cursor: pointer; font-size: 14px;">
                                                                                    Drag & drop a file here or click
                                                                                </div>
                                                                            </div>
                                                                            <!-- Select from Gallery -->
                                                                            <div class="mb-3">
                                                                                <label for="pic"
                                                                                    class="form-label">Select from
                                                                                    Gallery</label>
                                                                                <input type="file" id="pic"
                                                                                    name="pic"
                                                                                    class="form-control" />
                                                                            </div>
                                                                            <!-- Webcam Capture -->
                                                                            <div class="mb-3">
                                                                                <label for="webcam"
                                                                                    class="form-label">Capture from
                                                                                    Webcam</label>
                                                                                <div>
                                                                                    <video id="webcam" autoplay
                                                                                        style="width: 100%; max-height: 150px;"></video>
                                                                                    <button id="captureBtn"
                                                                                        class="btn btn-primary btn-sm mt-2">Capture</button>
                                                                                    <canvas id="canvas"
                                                                                        style="display: none;"></canvas>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary btn-sm"
                                                                                id="closeBtn">Close</button>
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-sm"
                                                                                id="saveBtn">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    const $guestIdPicInput = $('#pic');
                                                                    const $triggerInput = $('#pic_trigger');
                                                                    const $captureBtn = $('#captureBtn');
                                                                    const $webcam = $('#webcam')[0];
                                                                    const $canvas = $('#canvas')[0];
                                                                    const $modal = $('#fileUploadModal');
                                                                    const $dropZone = $('#dropZone');
                                                                    const $saveForm = $('#saveForm');

                                                                    // Hide modal and remove buttons
                                                                    function closeModal() {
                                                                        $modal.modal('hide');
                                                                    }

                                                                    // Update input field and close modal
                                                                    function updateInputAndCloseModal(fileName) {
                                                                        $triggerInput.val(fileName);
                                                                        closeModal();
                                                                    }

                                                                    // Handle Drag-and-Drop
                                                                    $dropZone.on('click', function() {
                                                                        $guestIdPicInput.trigger('click');
                                                                    });

                                                                    $guestIdPicInput.on('change', function() {
                                                                        if (this.files.length > 0) {
                                                                            const fileName = this.files[0].name;
                                                                            updateInputAndCloseModal(fileName);
                                                                        }
                                                                    });

                                                                    // Handle Webcam Capture
                                                                    $captureBtn.on('click', function(e) {
                                                                        e.preventDefault();

                                                                        const context = $canvas.getContext('2d');
                                                                        $canvas.width = $webcam.videoWidth;
                                                                        $canvas.height = $webcam.videoHeight;
                                                                        context.drawImage($webcam, 0, 0, $webcam.videoWidth, $webcam.videoHeight);

                                                                        // Generate a unique file name by appending timestamp or random string
                                                                        const uniqueFileName = 'doc-id-cap-' + Date.now() + '.jpg'; // Example using timestamp

                                                                        $canvas.toBlob((blob) => {
                                                                            const file = new File([blob], uniqueFileName, {
                                                                                type: 'image/jpeg'
                                                                            }); // Use the unique file name
                                                                            const dataTransfer = new DataTransfer();
                                                                            dataTransfer.items.add(file);
                                                                            $guestIdPicInput[0].files = dataTransfer.files;

                                                                            updateInputAndCloseModal(file.name);
                                                                        });
                                                                    });

                                                                    // Start Webcam
                                                                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                                                                        navigator.mediaDevices.getUserMedia({
                                                                            video: true
                                                                        }).then((stream) => {
                                                                            $webcam.srcObject = stream;
                                                                        });
                                                                    }

                                                                    // Ensure main body is active after modal close
                                                                    $modal.on('hidden.bs.modal', function() {
                                                                        $('body').removeClass('modal-open'); // Remove modal-open class
                                                                        $('.modal-backdrop').remove(); // Remove leftover backdrop
                                                                        $('body').css('overflow', ''); // Reset to default behavior

                                                                        // 2. Check for and remove custom scrollbars implemented during modal display:
                                                                        const customScrollbars = document.querySelectorAll('.custom-scrollbar');
                                                                        customScrollbars.forEach(scrollbar => scrollbar.remove());

                                                                        // 3. If using a JavaScript library for managing scrollbars, call its reset function:
                                                                        if (typeof myScrollbarLibrary.resetScrollbar === 'function') {
                                                                            myScrollbarLibrary.resetScrollbar(); // Example: PerfectScrollbar.resetScrollbar()
                                                                        }

                                                                        // 4. For reliable cross-browser compatibility, consider additional methods:
                                                                        //    - document.documentElement.style.overflow = 'auto';
                                                                        //    - document.body.style.overflow = 'auto';
                                                                        //    (Use these if the above methods don't work consistently)
                                                                        $saveForm.focus(); // Bring focus back to the form
                                                                    });
                                                                });
                                                            </script>--}}
                                                                </div> 
                                                            </div>

</div> <!-- ✅ END LEFT col-md-8 -->

<!-- =======================
     RIGHT SIDE – PAYMENT
======================= -->
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
                         @endforeach
                                        --}}
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
                                                                        type="submit"class="btn btn-primary btn-block">Save</button>
                                                                    <a
                                                                        class= "btn btn-dark  "href={{ url('crusher') }}>Back</a>
                                                                </div>
                                                            </div>
                                                        @endcan




                                        </form>
                                    </div id="content close ">
                                </div>
                            </div>
                        </div>
                    </div>
                    </main>
            </div>
        </div>
    </div>
   </div>
</div>
</div>
</div>
</div>

<script>
$(document).ready(function () {

    $('#search_id').on('change', function () {

        let selectedPartyName = $(this).find(':selected').text().trim();

        $('#party_name').val(selectedPartyName);

    });

});
</script>


<script>

$(document).ready(function () {

    function calculateTotal() {
        let quantity = parseFloat($('#Quantity').val()) || 0;
        let rate     = parseFloat($('#Rate').val()) || 0;
        let royalty = parseFloat($('#Royalty').val()) || 0;
if(royalty){
    let total = (quantity * rate) + royalty;

        // ✅ Fix to 2 decimal places (optional)
        $('#total').val(total.toFixed(2));
}
else{
    let total = (quantity * rate);

        // ✅ Fix to 2 decimal places (optional)
        $('#total').val(total.toFixed(2));
}
        
    }

    // 🔥 Trigger calculation on input change
    $('#Quantity, #Rate, #Royalty').on('keyup change', function () {
        calculateTotal();
    });

});
</script>

<script>
$(document).ready(function () {

    $('#vehicle_id').on('change', function () {

        let selectedOption = $(this).find(':selected');

        // ✅ Vehicle Measure
        let vehicleMeasure = selectedOption.data('vehicle-measure');
        $('#vehicle_measure').val(vehicleMeasure);

        // ✅ Vehicle Number
        let vehicleNo = selectedOption.data('vehicle-no');
        $('#vehicle_no').val(vehicleNo);
    });

});
</script>


<script>
$(document).ready(function () {
    let now = new Date();

    // ✅ Current Date YYYY-MM-DD
    let date = now.toISOString().split('T')[0];
    $('#date').val(date);

    // ✅ Current Time HH:MM
    let hours = String(now.getHours()).padStart(2, '0');
    let minutes = String(now.getMinutes()).padStart(2, '0');
    $('#time').val(hours + ':' + minutes);
});
</script>

{{-- ==========================================use to save data===================================== --}}
          <script>
$(document).ready(function () {

    $('#saveForm').on('submit', function (e) {
        e.preventDefault();
        let form = this;
   let formdata = {
            search_id: $('#search_id').val(),
            vehicle_id: $('#vehicle_id').val(),
            slip_no: $('#slip_no').val(),
            date: $('#date').val(),
            time: $('#time').val(),
            vehicle_no: $('#vehicle_no').val(),
            party_name: $('#party_name').val(),
            Vehicle_measure: $('#vehicle_measure').val(),
            Material: $('#Material').val(),
            Royalty: $('#Royalty').val(),
            rate: $('#Rate').val(),
            total: $('#total').val(),
            Quantity: $('#Quantity').val(),
            address: $('#address').val(),
            phone: $('#phone').val(),
            remark: $('#remark').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        // ✅ Disable button & show loader
        $('#saveButton')
            .prop('disabled', true)
            .html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: formdata,   // ✅ SAME VARIABLE
            success: function (response) {

                $('#saveButton').prop('disabled', false).html('Save');
          console.log("✅ Response save ", response);
            alert(response.message);
            },
            error: function (xhr) {

                $('#saveButton').prop('disabled', false).html('Save');

                if (xhr.status === 422) {
                    let message = '';
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        message += value[0] + "\n";
                    });
                    alert(message);
                } else {
                    alert("❌ Server error");
                }
            }
        });
    });

});
</script>

@endsection
