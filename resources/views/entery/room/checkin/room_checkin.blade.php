@php
    include public_path('cdn/cdn.blade.php');
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css') }}">
<style>
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

    #guest_id_pic_trigger {
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
    #guest_id_pic_trigger:hover {
        background-color: #e9ecef;
        /* Slightly darker background on hover */
        border-color: #0056b3;
        /* Darker blue border */
        color: #0056b3;
        /* Darker blue text */
    }

    /* Focus effect for keyboard navigation */
    #guest_id_pic_trigger:focus {
        outline: none;
        background-color: #dbe9f4;
        /* Subtle focus background */
        border-color: #003d82;
        /* Stronger blue border */
        color: #003d82;
        /* Stronger blue text */
    }

    /* Add a hint text to guide users */
    #guest_id_pic_trigger::placeholder {
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
                                        <h5 class="text-center font-weight-light my-1">JOB CARD  </h5>
                                    </div>
                                    <div class="card-body">


                                        <div class="row">
                                            <!-- Room Booking -->
<div class="col-md-3 mt-4">
    <label for="searchCustomer">Select slot Booking</label>
    <div id="searchCustomer">
        <form action="{{ url('/show_roombooking') }}" method="POST" class="form-inline" id="select_roombooking">
            @csrf
            <div class="input-group">
                <select name="roombooking_voucher_no" id="roombooking_voucher_no" class="form-select"
                    aria-label="Default select example">
                    <option selected disabled>Select slot Booking</option>
                    @foreach ($roombookings as $roombookings)
                        <option value="{{ $roombookings->voucher_no }}">
                            {{ $roombookings->guest_name }} -
                            {{ \Carbon\Carbon::parse($roombookings->checkin_date)->format('d-m-y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <span id="message"></span>
        </form>
    </div>
</div>

                                            {{-- 
                                            <div class="col-md-3 mt-4">
                                                <label for="searchCustomer">Select Room Booking</label>
                                                <div id="searchCustomer">
                                                    <form action="{{ url('/show_roombooking') }}" method= "POST"
                                                        class="form-inline" id ="select_roombooking">
                                                        @csrf
                                                        <div class="input-group">

                                                            <select name="roombooking_voucher_no"
                                                                Id ="roombooking_voucher_no"class="form-select"
                                                                aria-label="Default select example">
                                                                <option selected disabled>Select Room Booking </option>
                                                                @foreach ($roombookings as $roombookings)
                                                                    <option value="{{ $roombookings->voucher_no }}">
                                                                        {{ $roombookings->guest_name }}-{{ \Carbon\Carbon::parse($roombookings->checkin_date)->format('d-m-y') }}

                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <script>
                                                            document.getElementById('roombooking_voucher_no').addEventListener('change', function() {
                                                                var voucherNo = this.value;
                                                                if (voucherNo) {
                                                                    window.location.href = '/show_booking/' + voucherNo;
                                                                }
                                                            });
                                                        </script>

                                                        <span id="message"></span>
                                                    </form>
                                                </div>
                                            </div> --}}

                                            <!-- Room Booking Client Picture -->
                                            <div class="col-md-3 mt-1">

                                                <div id="roomBookingClientPic">
                                                    <!-- Image or content for room booking client picture -->
                                                    <img id="roombooking_guest_pic" class="mx-1"
                                                        src="{{ asset('storage/account_image/' . 'default.jpg') }}"
                                                        alt="guest_pic" width="130px">

                                                </div>
                                            </div>

                                            <!-- Search Customer -->
                                            <div class="col-md-3 mt-4">
                                                {{-- //this is code for search account by mobile no only
                                                 <label for="searchCustomer">Search Customer</label>
                                                <div id="searchCustomer">
                                                    <form class="form-inline" id ="search_acccount">
                                                        @csrf
                                                        <div class="input-group">

                                                            <input type="text" class="form-control" id="searchinput"
                                                                placeholder="Enter Contact Number" autocomplete="off">

                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="submit"
                                                                    id="search_button">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <span id="message"></span>
                                                    </form>
                                                </div> --}}
                                                <div class="input-group">

                                                    <select id="guest_search_id" name="guest_search_id"
                                                        class="js-states form-control">
                                                        <option disabled selected>Select customer</option>
                                                        @foreach ($guset_data as $record)
                                                            <option value={{ $record['id'] }}>
                                                                {{ $record['account_name'] }}&nbsp;-
                                                                &nbsp;{{ $record['mobile'] }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    @error('cust_name_id')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>

                                            {{-- </div>  --}}

                                            {{-- <div class="col-md-12 mt-4" name="itementery">
                                                <div class="col-md-3 mt-4 mx-2 ">
                             --}}
                                            <!-- Selected Customer Picture -->
                                            <div class="col-md-3 mt-1">
                                                <div id="selectedCustomerPic">
                                                    <!-- Image or content for selected customer picture -->
                                                    <img id="guest_pic_response"
                                                        class="mx-1"src="{{ asset('storage/account_image/' . ($guest_picresponse ?? 'default.jpg')) }}"
                                                        alt="guest_pic" width="130px">

                                                    <img id="uploded_id_pic_response1"
                                                        src="{{ asset('storage/account_image/' . ($guest_pic_id_response ?? 'default.jpg')) }}"
                                                        alt="Uploaded ID pic" width="130PX">
                                                </div>
                                            </div>
                                        </div>

                                        <form id ="saveForm"action="{{ route('roomcheckins.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            {{-- 2nd row checkin detail and select room no                                                          --}}
                                            <div class="row justify-content-centerm-3">
                                                <div class="col-md-8">
                                                    <div class="row form-group">
                                                        <div class="col-md-3">
                                                            <label for="label1"> No<span
                                                                    class="requierdfield">*</span> </label>
                                                            <input type="text" name="check_in_no"class=" form-control"
                                                                id="" class="" value="{{ $new_bill_no }}"
                                                                readonly>
                                                            <input type="hidden" name="voucher_no"class=" form-control"
                                                                id="" name="voucher_no" class=""
                                                                value="{{ $new_voucher_no }}" readonly>

                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="checkin_date"> Date<span
                                                                    class="requierdfield">*</span></label>
                                                            <input class="form-control date" id="checkin_date"
                                                                type="text" name="checkin_date"
                                                                value="{{ date('Y-m-d') }}" />
                                                            <span class="text-danger">
                                                                @error('checkin_date')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="checkin_time"> Time<span
                                                                    class="requierdfield">*</span></label>
                                                            <input class="form-control" id="checkin_time" type="time"
                                                                name="checkin_time" value="{{ date('Y-m-d') }}" />
                                                            <span class="text-danger">
                                                                @error('checkin_time')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>

                                                            @if(!is_null($componyinfo->componyinfo_af1))
                                                            <div class="col-md-3">
                                                            <label for="checkin_date">Expected Check-Out Date<span
                                                                    class="requierdfield"></span></label>
                                                            <input class="form-control date" id="checkout_date"
                                                                type="text" name="checkout_date"
                                                                value="{{ date('Y-m-d') }}" />
                                                            <span class="text-danger">
                                                                @error('checkout_date')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="checkin_time">Expected Check-Out Time<span
                                                                    class="requierdfield"></span></label>
                                                            <input class="form-control" id="checkout_time" type="time"
                                                                name="checkout_time" value="{{ date('Y-m-d') }}" />
                                                            <span class="text-danger">
                                                                @error('checkout_time')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>

                                                       
                                                       @endif

                                                        
                                                        
                                                        {{-- <div class="col-md-3">
                                                            <label for="commited_days">No Of Days <span
                                                                    class="requierdfield">*</span></label>
                                                            <input class="form-control" id="commited_days" type="text"
                                                                name="commited_days" value="{{ old('commited_days') }}"
                                                                required />
                                                            <span class="text-danger">
                                                                @error('commited_days')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>

                                                        </div> --}}
                                                        {{-- <div class="col-md-3">
                                                            <label for="no_of_guest">No Of Guest <span
                                                                    class="requierdfield">*</span></label>
                                                            <input class="form-control" id="no_of_guest" type="text"
                                                                name="no_of_guest" value="{{ old('no_of_guest') }}"
                                                                required />
                                                            <span class="text-danger">
                                                                @error('no_of_guest')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div> --}}
                                                        {{-- <div class="col-md-3">
                                                            <span class="requierdfield">*</span>
                                                            <label for="business_source">Business Source</label>
                                                            <select name="business_source_id" id="business_source_id"
                                                                class="form-select" aria-label="Default select example">
                                                                <option disabled
                                                                    {{ old('business_source_id') ? '' : 'selected' }}>
                                                                    Select Business Source</option>
                                                                @foreach ($businesssource as $businesssource)
                                                                    <option value="{{ $businesssource->id }}"
                                                                        {{ old('business_source_id') == $businesssource->id ? 'selected' : '' }}>
                                                                        {{ $businesssource->business_source_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger">
                                                                @error('business_source_id')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div> --}}
                                                        <div class="col-md-6"><span class="requierdfield">*</span>
                                                            <label for="package">Package</label>
                                                            <select name="package_id" id="package_id" class="form-select"
                                                                aria-label="Default select example">
                                                                <option disabled {{ old('package_id') ? '' : 'selected' }}>
                                                                    Select Package</option>
                                                                @foreach ($package as $package)
                                                                    <option value="{{ $package->id }}"
                                                                        {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                                                        {{ $package->package_name }} ||
                                                                        {{ $package->plan_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <span class="text-danger">
                                                                @error('package_id')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="checkin_remark1">Remark 1</label>
                                                            <input class="form-control" id="checkin_remark1"
                                                                type="text" name="checkin_remark1" value="" />
                                                            <span class="text-danger">
                                                                @error('checkin_remark1')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-8 mb-1">
                                                            <label for="checkin_remark2">Remark 2</label>
                                                            <input class="form-control" id="checkin_remark2"
                                                                type="text" name="checkin_remark2" value="" />
                                                            <span class="text-danger">
                                                                @error('checkin_remark2')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>


                                                    </div>
                                                </div>



                                                <div class="col-md-4" id ="room_selection_box">
                                                    <table id="room_selection"
                                                        class="table table-striped table-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th># </th>
                                                                <th>slot No </th>
                                                                <th>Payment Type</th>
                                                                <th>Tariff</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>



                                                            @foreach ($rooms as $room)
                                                                <tr>
                                                                    <td>
                                                                        <label class="container_chekbox">
                                                                            <input type="checkbox" class="room-checkbox"
                                                                                name="checkin_room_id[]"
                                                                                value="{{ $room->id }}">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text"id="checkin_room_no"
                                                                            name="checkin_room_no"
                                                                            value="{{ $room->room_no }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="checkin_roomtype"
                                                                            id="checkin_roomtype"
                                                                            value ="{{ $room->roomtype->roomtype_name }}"
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text"
                                                                            name="checkin_room_tariff"id="checkin_room_tariff"
                                                                            value="{{ $room->roomtype->room_tariff }}">
                                                                    </td>




                                                                </tr>
                                                            @endforeach



                                                        </tbody>
                                                    </table>







                                                </div>
                                            </div>


                                            {{-- 3rd row start for guest detail +valuadded                             --}}
                                            <div class="row justify-content-centerm-3 my-3">
                                                <div class="col-md-8">
                                                    <div class="row form-group">
                                                        <div class="col-md-6"><span class="requierdfield">*</span>
                                                            <label for="guest_name">Customer Name </label>
                                                            <input class="form-control" id="guest_name" type="text"
                                                                name="guest_name" value="{{ old('guest_name') }}"
                                                                autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('guest_name')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="guest_father_name">Vehicle Name </label>
                                                            <input class="form-control" id="guest_father_name" type="text"
                                                                name="guest_father_name" value="{{ old('guest_father_name') }}"
                                                                autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('guest_father_name')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>

                                                        {{-- <div class="col-md-3">
                                                            <label for="guest_age">Guest Age </label>
                                                            <input class="form-control" id="guest_age" type="text"
                                                                name="guest_age" value="{{ old('guest_age') }}"
                                                                autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('guest_age')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>


                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_gender">Guest Gender </label>
<select class="form-control" id="guest_gender" name="guest_gender">
    <option value="">-- Select Gender --</option>
    <option value="Male" {{ old('guest_gender') == 'Male' ? 'selected' : '' }}>Male</option>
    <option value="Female" {{ old('guest_gender') == 'Female' ? 'selected' : '' }}>Female</option>
    <option value="Other" {{ old('guest_gender') == 'Other' ? 'selected' : '' }}>Other</option>
</select>


                                                        </div> --}}
                                                        {{-- <div class="col-md-3">
                                                            <label for="account_birthday">DOB </label>
                                                            <input class="form-control" id="account_birthday" type="date"
                                                                name="account_birthday" value="{{ old('account_birthday') }}"
                                                                autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('account_birthday')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>


                                                        </div> --}}
                                                        <div class="col-md-3">
                                                            <label for="guest_address">Address Line 1</label>
                                                            <input class="form-control" id="guest_address" type="text"
                                                                name="guest_address"
                                                                value="{{ old('guest_address') }}" />
                                                            <span class="text-danger">
                                                                @error('guest_address')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_address2">Address Line 2</label>
                                                            <input class="form-control" id="guest_address2"
                                                                type="text" name="guest_address2"
                                                                value="{{ old('guest_address2') }}" />
                                                            <span class="text-danger">
                                                                @error('guest_address2')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_city">City</label>
                                                            <input class="form-control" id="guest_city" type="text"
                                                                name="guest_city" value="{{ old('guest_city') }}" />
                                                            <span class="text-danger">
                                                                @error('guest_city')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_state">State</label>
                                                            <input class="form-control" id="guest_state" type="text"
                                                                name="guest_state" value="{{ old('guest_state') }}" />
                                                            <span class="text-danger">
                                                                @error('guest_state')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_contery">Country</label>
                                                            <input class="form-control" id="guest_contery" type="text"
                                                                name="guest_contery"
                                                                value="{{ old('guest_countery', $compinfofooter->country) }}" />
                                                            <span class="text-danger">
                                                                @error('guest_contery')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_pincode"> Pin Code </label>
                                                            <input class="form-control" id="guest_pincode" type="text"
                                                                name="guest_pincode" value="" />
                                                            <span class="text-danger">
                                                                @error('guest_pincode')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_nationality">Nationality</label>
                                                            <input class="form-control" id="guest_nationality"
                                                                type="text" name="guest_nationality"
                                                                value="{{ old('guest_countery', $compinfofooter->country) }}" />
                                                            <span class="text-danger">
                                                                @error('guest_nationality')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3"><span class="requierdfield">*</span>
                                                            <label for="guest_mobile">Mobile</label>
                                                            <input class="form-control" id="guest_mobile" type="text"
                                                                name="guest_mobile" value="{{ old('guest_mobile') }}"
                                                                autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('guest_mobile')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>


                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_phone">Phone</label>
                                                            <input class="form-control" id="guest_phone" type="text"
                                                                name="guest_phone" value="{{ old('guest_phone') }}"
                                                                autocomplete="none" />
                                                            <span class="text-danger">
                                                                @error('guest_phone')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_email">Email</label>
                                                            <input class="form-control" id="guest_email" type="text"
                                                                name="guest_email" value="{{ old('guest_email') }}" />
                                                            <span class="text-danger">
                                                                @error('guest_email')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3 ">
                                                            <label for="label1">Agent</label>
                                                            <input type="text" class=" form-control"id=""
                                                                name="agent" class=""
                                                                value="{{ old('agent') }}">
                                                        </div>
                                                           <div class="col-md-3 ">
                                                            <label for="label1">Purpose Of Visit</label>
                                                            <input type="text" class=" form-control"id=""
                                                                name="purpose_of_visit" class=""
                                                                value="{{ old('purpose_of_visit') }}">
                                                        </div>
                                                                                                                  <div class="col-md-3 ">
                                                            <label for="label1">Comming From</label>
                                                            <input type="text" class=" form-control"id=""
                                                                name="comming_from" class=""
                                                                value="{{ old('comming_from') }}">
                                                        </div>
                                                                  <div class="col-md-3 ">
                                                            <label for="label1">GOING TO</label>
                                                            <input type="text" class=" form-control"id=""
                                                                name="going_to" class=""
                                                                value="{{ old('going_to') }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_idproof">Document Name </label>
                                                            <input class="form-control" id="guest_idproof" type="text"
                                                                name="guest_idproof"
                                                                value="{{ old('guest_idproof') }}" />
                                                            <span class="text-danger">
                                                                @error('guest_idproof')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_idproof_no">Document No </label>
                                                            <input class="form-control" id="guest_idproof_no"
                                                                type="text" name="guest_idproof_no"
                                                                value="{{ old('guest_idproof_no') }}" />
                                                            <span class="text-danger">
                                                                @error('guest_idproof_no')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="firm_name">Company Name</label>
                                                            <input class="form-control" id="firm_name" type="text"
                                                                name="firm_name" value="{{ old('firm_name') }}" />
                                                            <span class="text-danger">
                                                                @error('firm_name')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>

                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="firm_address">Company Address </label>
                                                            <input class="form-control" id="firm_address" type="text"
                                                                name="firm_address" value="{{ old('firm_address') }}" />
                                                            <span class="text-danger">
                                                                @error('firm_address')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>

                                                        </div>


                                                        <div class="col-md-3">
                                                            <label for="gst_no">GST NO </label>
                                                            <input class="form-control" id="gst_no" type="text"
                                                                name="gst_no" value="{{ old('gst_no') }}" />
                                                            <span class="text-danger">
                                                                @error('gst_no')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>

                                                        </div>
                                                        {{-- <div class="col-md-3">
                                                            <label for="guest_id_pic">Document Image </label>
                                                            <input class="form-control" id="guest_id_pic" type="file"
                                                                name="guest_id_pic" value="" />
                                                            <span class="text-danger">
                                                                @error('guest_id_pic')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_pic">Guest Image </label>
                                                            <input class="form-control" id="guest_pic" type="file"
                                                                name="guest_pic" value="{{ old('guest_pic') }}" />
                                                            <span class="text-danger">
                                                                @error('guest_pic')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>

                                                        </div> --}}
                                                        <div class="col-md-3">
                                                            <label for="guest_id_pic_trigger">Document Image</label>
                                                            <input class="form-control" id="guest_id_pic_trigger"
                                                                type="text" readonly
                                                                placeholder="Click to upload or capture"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#fileUploadModal" />
                                                            <span class="text-danger">
                                                                @error('guest_id_pic')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="fileUploadModal" tabindex="-1"
                                                            aria-labelledby="fileUploadModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="fileUploadModalLabel">
                                                                            Upload Document</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Drag and Drop -->
                                                                        <div class="mb-3">
                                                                            <label for="guest_id_pic"
                                                                                class="form-label">Drag & Drop</label>
                                                                            <div id="dropZone"
                                                                                style="border: 2px dashed #007bff; padding: 15px; text-align: center; cursor: pointer; font-size: 14px;">
                                                                                Drag & drop a file here or click
                                                                            </div>
                                                                        </div>
                                                                        <!-- Select from Gallery -->
                                                                        <div class="mb-3">
                                                                            <label for="guest_id_pic"
                                                                                class="form-label">Select from
                                                                                Gallery</label>
                                                                            <input type="file" id="guest_id_pic"
                                                                                name="guest_id_pic"
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
                                                                const $guestIdPicInput = $('#guest_id_pic');
                                                                const $triggerInput = $('#guest_id_pic_trigger');
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
                                                        </script>

                                                        <div class="col-md-3">
                                                            <label for="guest_pic_trigger">Guest Image</label>
                                                            <input class="form-control" id="guest_pic_trigger"
                                                                type="text" readonly
                                                                placeholder="Click to upload or capture"
                                                                data-bs-toggle="modal" data-bs-target="#guestPicModal">

                                                            <span class="text-danger">
                                                                @error('guest_pic')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>

                                                        <!-- Modal for Guest Image -->
                                                        <div class="modal fade" id="guestPicModal" tabindex="-1"
                                                            aria-labelledby="guestPicModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="guestPicModalLabel">
                                                                            Upload Guest Image</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Drag and Drop -->
                                                                        <div class="mb-3">
                                                                            <label for="guest_pic" class="form-label">Drag
                                                                                & Drop</label>
                                                                            <div id="guestDropZone"
                                                                                style="border: 2px dashed #007bff; padding: 15px; text-align: center; cursor: pointer; font-size: 14px;">
                                                                                Drag & drop a file here or click
                                                                            </div>
                                                                        </div>
                                                                        <!-- Select from Gallery -->
                                                                        <div class="mb-3">
                                                                            <label for="guest_pic"
                                                                                class="form-label">Select from
                                                                                Gallery</label>
                                                                            <input type="file" id="guest_pic"
                                                                                name="guest_pic" class="form-control" />
                                                                        </div>
                                                                        <!-- Webcam Capture -->
                                                                        <div class="mb-3">
                                                                            <label for="guestWebcam"
                                                                                class="form-label">Capture from
                                                                                Webcam</label>
                                                                            <div>
                                                                                <video id="guestWebcam" autoplay
                                                                                    style="width: 100%; max-height: 150px;"></video>
                                                                                <button id="guestCaptureBtn"
                                                                                    class="btn btn-primary btn-sm mt-2">Capture</button>
                                                                                <canvas id="guestCanvas"
                                                                                    style="display: none;"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-sm"
                                                                            id="guestSaveBtn">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                const $guestPicInput = $('#guest_pic');
                                                                const $guestTriggerInput = $('#guest_pic_trigger');
                                                                const $guestCaptureBtn = $('#guestCaptureBtn');
                                                                const $guestWebcam = $('#guestWebcam')[0];
                                                                const $guestCanvas = $('#guestCanvas')[0];
                                                                const $guestModal = $('#guestPicModal');
                                                                const $guestDropZone = $('#guestDropZone');

                                                                // Hide modal and remove buttons
                                                                function closeGuestModal() {
                                                                    $guestModal.modal('hide');
                                                                }

                                                                // Update input field and close modal
                                                                function updateGuestInputAndCloseModal(fileName) {
                                                                    $guestTriggerInput.val(fileName);
                                                                    closeGuestModal();
                                                                }

                                                                // Handle Drag-and-Drop
                                                                $guestDropZone.on('click', function() {
                                                                    $guestPicInput.trigger('click');
                                                                });

                                                                $guestPicInput.on('change', function() {
                                                                    if (this.files.length > 0) {
                                                                        const fileName = this.files[0].name;
                                                                        updateGuestInputAndCloseModal(fileName);
                                                                    }
                                                                });

                                                                // Handle Webcam Capture
                                                                $guestCaptureBtn.on('click', function(e) {
                                                                    e.preventDefault();

                                                                    const context = $guestCanvas.getContext('2d');
                                                                    $guestCanvas.width = $guestWebcam.videoWidth;
                                                                    $guestCanvas.height = $guestWebcam.videoHeight;
                                                                    context.drawImage($guestWebcam, 0, 0, $guestWebcam.videoWidth, $guestWebcam.videoHeight);

                                                                    // Generate unique file name by appending timestamp (or random string)
                                                                    const uniqueFileName = 'guest-pic-cap-' + Date.now() + '.png'; // Example using timestamp

                                                                    $guestCanvas.toBlob((blob) => {
                                                                        const file = new File([blob], uniqueFileName, {
                                                                            type: 'image/png'
                                                                        }); // Use the unique file name
                                                                        const dataTransfer = new DataTransfer();
                                                                        dataTransfer.items.add(file);
                                                                        $guestPicInput[0].files = dataTransfer.files;

                                                                        updateGuestInputAndCloseModal(file.name);
                                                                    });
                                                                });

                                                                // Start Webcam
                                                                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                                                                    navigator.mediaDevices.getUserMedia({
                                                                        video: true
                                                                    }).then((stream) => {
                                                                        $guestWebcam.srcObject = stream;
                                                                    });
                                                                }

                                                                // Ensure main body is active after modal close
                                                                $guestModal.on('hidden.bs.modal', function() {
                                                                    $('body').removeClass('modal-open'); // Remove modal-open class
                                                                    $('.modal-backdrop').remove(); // Remove leftover backdrop

                                                                    // Restore page scroll functionality using a combination of approaches:

                                                                    // 1. Remove CSS `overflow: hidden` from the body (if applied):
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
                                                                });
                                                            });
                                                        </script>
                                                    {{-- <div class="col-md-3">
                                                        <label for="second_guest_name">2nd Guest Name  </label>
                                                        <input class="form-control" id="second_guest_name" type="text"
                                                            name="second_guest_name" value="{{ old('second_guest_name') }}" />
                                                        <span class="text-danger">
                                                            @error('second_guest_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>

                                                    </div> --}}
                                                    {{-- <div class="col-md-3">
                                                        <label for="second_guest_id_name"> 2nd Guest Id Name  </label>
                                                        <input class="form-control" id="second_guest_id_name" type="text"
                                                            name="second_guest_id_name" value="{{ old('second_guest_id_name') }}" />
                                                        <span class="text-danger">
                                                            @error('second_guest_id_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>

                                                    </div> --}}
                                                    {{-- <div class="col-md-3">
                                                        <label for="second_guest_id_no"> 2nd Guest Id No  </label>
                                                        <input class="form-control" id="second_guest_id_no" type="text"
                                                            name="second_guest_id_no" value="{{ old('second_guest_id_no') }}" />
                                                        <span class="text-danger">
                                                            @error('second_guest_id_no')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>

                                                    </div> --}}

                                                        <!--second guest image -->
                                                        {{-- <div class="col-md-3">
                                                            <label for="second_guest_id_pic_trigger">2nd Guest Document </label>
                                                            <input class="form-control" id="second_guest_id_pic_trigger" type="text" readonly
                                                                placeholder="Click to upload or capture"
                                                                data-bs-toggle="modal" data-bs-target="#secondFileUploadModal" />
                                                            <span class="text-danger">
                                                                @error('second_guest_id_pic')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                         --}}
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="secondFileUploadModal" tabindex="-1" aria-labelledby="secondFileUploadModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="secondFileUploadModalLabel">Upload Document</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Drag and Drop -->
                                                                        <div class="mb-3">
                                                                            <label for="second_guest_id_pic" class="form-label">Drag & Drop</label>
                                                                            <div id="secondDropZone"
                                                                                style="border: 2px dashed #007bff; padding: 15px; text-align: center; cursor: pointer; font-size: 14px;">
                                                                                Drag & drop a file here or click
                                                                            </div>
                                                                        </div>
                                                                        <!-- Select from Gallery -->
                                                                        <div class="mb-3">
                                                                            <label for="second_guest_id_pic" class="form-label">Select from Gallery</label>
                                                                            <input type="file" id="second_guest_id_pic" name="second_guest_id_pic" class="form-control" />
                                                                        </div>
                                                                        <!-- Webcam Capture -->
                                                                        <div class="mb-3">
                                                                            <label for="second_webcam" class="form-label">Capture from Webcam</label>
                                                                            <div>
                                                                                <video id="second_webcam" autoplay style="width: 100%; max-height: 150px;"></video>
                                                                                <button id="secondCaptureBtn" class="btn btn-primary btn-sm mt-2">Capture</button>
                                                                                <canvas id="secondCanvas" style="display: none;"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary btn-sm" id="closeBtn">Close</button>
                                                                        <button type="button" class="btn btn-primary btn-sm" id="saveBtn">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
    const $secondGuestIdPicInput = $('#second_guest_id_pic');
    const $secondTriggerInput = $('#second_guest_id_pic_trigger');
    const $secondCaptureBtn = $('#secondCaptureBtn');
    const $secondWebcam = $('#second_webcam')[0];
    const $secondCanvas = $('#secondCanvas')[0];
    const $secondModal = $('#secondFileUploadModal');
    const $secondDropZone = $('#secondDropZone');
    const $secondSaveForm = $('#saveForm'); // Adjust this if necessary

    // Hide modal and remove buttons
    function closeSecondModal() {
        $secondModal.modal('hide');
    }

    // Update input field and close modal
    function updateSecondInputAndCloseModal(fileName) {
        $secondTriggerInput.val(fileName);
        closeSecondModal();
    }

    // Handle Drag-and-Drop
    $secondDropZone.on('click', function() {
        $secondGuestIdPicInput.trigger('click');
    });

    $secondGuestIdPicInput.on('change', function() {
        if (this.files.length > 0) {
            const fileName = this.files[0].name;
            updateSecondInputAndCloseModal(fileName);
        }
    });

    // Handle Webcam Capture
    $secondCaptureBtn.on('click', function(e) {
        e.preventDefault();

        const context = $secondCanvas.getContext('2d');
        $secondCanvas.width = $secondWebcam.videoWidth;
        $secondCanvas.height = $secondWebcam.videoHeight;
        context.drawImage($secondWebcam, 0, 0, $secondWebcam.videoWidth, $secondWebcam.videoHeight);

        // Generate a unique file name by appending timestamp or random string
        const uniqueFileName = 'doc-id-cap-' + Date.now() + '.jpg'; // Example using timestamp

        $secondCanvas.toBlob((blob) => {
            const file = new File([blob], uniqueFileName, {
                type: 'image/jpeg'
            }); // Use the unique file name
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            $secondGuestIdPicInput[0].files = dataTransfer.files;

            updateSecondInputAndCloseModal(file.name);
        });
    });

    // Start Webcam
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({
            video: true
        }).then((stream) => {
            $secondWebcam.srcObject = stream;
        });
    }

    // Ensure main body is active after modal close
    $secondModal.on('hidden.bs.modal', function() {
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
        $secondSaveForm.focus(); // Bring focus back to the form
    });
});

                                                        </script>

                                                        <!----3rd guest documnt --->

                                                        {{-- <div class="col-md-3">
                                                            <label for="third_guest_name">3rd Guest Name  </label>
                                                            <input class="form-control" id="third_guest_name" type="text"
                                                                name="third_guest_name" value="{{ old('third_guest_name') }}" />
                                                            <span class="text-danger">
                                                                @error('third_guest_name')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="third_guest_id_name">3rd Guest  Id Name  </label>
                                                            <input class="form-control" id="third_guest_id_name" type="text"
                                                                name="third_guest_id_name" value="{{ old('third_guest_id_name') }}" />
                                                            <span class="text-danger">
                                                                @error('third_guest_id_name')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="third_guest_id_no">3rd Guest  Id No  </label>
                                                            <input class="form-control" id="third_guest_id_no" type="text"
                                                                name="third_guest_id_no" value="{{ old('third_guest_id_no') }}" />
                                                            <span class="text-danger">
                                                                @error('third_guest_id_no')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="third_guest_id_pic_trigger"> 3rd Guest Document</label>
                                                            <input class="form-control" id="third_guest_id_pic_trigger" type="text" readonly
                                                                placeholder="Click to upload or capture"
                                                                data-bs-toggle="modal" data-bs-target="#thirdFileUploadModal" />
                                                            <span class="text-danger">
                                                                @error('third_guest_id_pic')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                         --}}
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="thirdFileUploadModal" tabindex="-1" aria-labelledby="thirdFileUploadModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="thirdFileUploadModalLabel">Upload Document</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Drag and Drop -->
                                                                        <div class="mb-3">
                                                                            <label for="third_guest_id_pic" class="form-label">Drag & Drop</label>
                                                                            <div id="thirdDropZone"
                                                                                style="border: 2px dashed #007bff; padding: 15px; text-align: center; cursor: pointer; font-size: 14px;">
                                                                                Drag & drop a file here or click
                                                                            </div>
                                                                        </div>
                                                                        <!-- Select from Gallery -->
                                                                        <div class="mb-3">
                                                                            <label for="third_guest_id_pic" class="form-label">Select from Gallery</label>
                                                                            <input type="file" id="third_guest_id_pic" name="third_guest_id_pic" class="form-control" />
                                                                        </div>
                                                                        <!-- Webcam Capture -->
                                                                        <div class="mb-3">
                                                                            <label for="third_webcam" class="form-label">Capture from Webcam</label>
                                                                            <div>
                                                                                <video id="third_webcam" autoplay style="width: 100%; max-height: 150px;"></video>
                                                                                <button id="thirdCaptureBtn" class="btn btn-primary btn-sm mt-2">Capture</button>
                                                                                <canvas id="thirdCanvas" style="display: none;"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary btn-sm" id="closeBtn">Close</button>
                                                                        <button type="button" class="btn btn-primary btn-sm" id="saveBtn">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
    const $thirdGuestIdPicInput = $('#third_guest_id_pic');
    const $thirdTriggerInput = $('#third_guest_id_pic_trigger');
    const $thirdCaptureBtn = $('#thirdCaptureBtn');
    const $thirdWebcam = $('#third_webcam')[0];
    const $thirdCanvas = $('#thirdCanvas')[0];
    const $thirdModal = $('#thirdFileUploadModal');
    const $thirdDropZone = $('#thirdDropZone');
    const $thirdSaveForm = $('#saveForm'); // Adjust if necessary

    // Hide modal and remove buttons
    function closeThirdModal() {
        $thirdModal.modal('hide');
    }

    // Update input field and close modal
    function updateThirdInputAndCloseModal(fileName) {
        $thirdTriggerInput.val(fileName);
        closeThirdModal();
    }

    // Handle Drag-and-Drop
    $thirdDropZone.on('click', function() {
        $thirdGuestIdPicInput.trigger('click');
    });

    $thirdGuestIdPicInput.on('change', function() {
        if (this.files.length > 0) {
            const fileName = this.files[0].name;
            updateThirdInputAndCloseModal(fileName);
        }
    });

    // Handle Webcam Capture
    $thirdCaptureBtn.on('click', function(e) {
        e.preventDefault();

        const context = $thirdCanvas.getContext('2d');
        $thirdCanvas.width = $thirdWebcam.videoWidth;
        $thirdCanvas.height = $thirdWebcam.videoHeight;
        context.drawImage($thirdWebcam, 0, 0, $thirdWebcam.videoWidth, $thirdWebcam.videoHeight);

        // Generate a unique file name by appending timestamp or random string
        const uniqueFileName = 'doc-id-cap-' + Date.now() + '.jpg'; // Example using timestamp

        $thirdCanvas.toBlob((blob) => {
            const file = new File([blob], uniqueFileName, {
                type: 'image/jpeg'
            }); // Use the unique file name
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            $thirdGuestIdPicInput[0].files = dataTransfer.files;

            updateThirdInputAndCloseModal(file.name);
        });
    });

    // Start Webcam
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({
            video: true
        }).then((stream) => {
            $thirdWebcam.srcObject = stream;
        });
    }

    // Ensure main body is active after modal close
    $thirdModal.on('hidden.bs.modal', function() {
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
        $thirdSaveForm.focus(); // Bring focus back to the form
    });
});

                                                        </script>


                                                    </div>
                                                </div>



                                                {{-- <div class="col-md-4" id ="payment_selection_box">
                                          <h5>Payment Detail</h5>
                                          <table id="room_selection" class="table table-striped table-responsive">
                                            <thead>
                                              <tr>
                                                <th> </th>
                                                <th>Amount</th>
                                   
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <td>Per Day Room Tariff</td>
                                                <td><input type="text" id="room_tariff_perday" name="room_tariff_perday" class="amount_input" readonly></td>
                                              </tr>
                                              <tr>
                                                <td>Booking Advance</td>
                                                <td>     </td>
                                              </tr>
                                  
                                              <tr>
                                                <td><select name="posting_acc_id" id="posting_acc_id">
                                                <option value="" selected disabled>Select Mode</option>
                                                @foreach ($paymentmodes as $paymentmode)
                                                <option value="{{$paymentmode->id}}" >{{$paymentmode->account_name}}</option>
                                                  
                                                @endforeach  
                                  
                                  
                                                </select></td>
                                                <td>
                                                <input type="text" class="amount_input" id="booking_amount" name="booking_amount" autocomplete="off">
                                                </td>
                                              </tr>
                                  
                                              <tr>
                                                <td>Payment Refance</td>
                                                <td><input type="text" name="voucher_payment_ref"class="amount_input"autocomplete="off"></td>
                                              </tr>
                                              <tr>
                                                <td>Payment Remark</td>
                                                <td><input type="text"  name="voucher_payment_remark" class="amount_input" autocomplete="off"></td>
                                              </tr>
                                  
                                                 
                                  
                                            </tbody>
                                           </table>
                                        </div>   --}}

                                                <div class="col-md-4">
                                                    <h5>Payment Detail</h5>
                                                    <table id="payment_selection_box"
                                                        class="table table-striped table-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>Payment Mode</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="payment_mode_body">
                                                            {{-- <tr>
                                                                <td>Per Day Room Tariff</td>
                                                                <td><input type="text" id="room_tariff_perday"
                                                                        name="room_tariff_perday" class="amount_input"
                                                                        readonly></td>
                                                            </tr> --}}
                                                            <tr>
                                                                <td>
                                                                    <select name="posting_acc_id[]"
                                                                        class="posting_acc_id">
                                                                        <option value="" selected disabled>Select
                                                                            Mode</option>
                                                                        @foreach ($paymentmodes as $paymentmode)
                                                                            <option value="{{ $paymentmode->id }}">
                                                                                {{ $paymentmode->account_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="amount_input"
                                                                        name="booking_amount[]" autocomplete="off">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- Button to add more payment modes -->


                                                    <table class="table" id="payment_det">
                                                        <tr>
                                                            <td>
                                                                <button type="button" id="add_payment_mode"
                                                                    class="btn  btn-sm btn-primary">+ Payment Mode</button>
                                                            </td>


                                                            <td><input type="text" id="total_receipt_amt"
                                                                    name="total_receipt_amt" class="amount_input"
                                                                    readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment Reference</td>
                                                            <td><input type="text" name="voucher_payment_ref"
                                                                    class="amount_input" autocomplete="off"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payment Remark</td>
                                                            <td><input type="text" name="voucher_payment_remark"
                                                                    class="amount_input" autocomplete="off"></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                {{-- <script>
                                                    // JavaScript to dynamically add more payment modes
                                                    document.getElementById('add_payment_mode').addEventListener('click', function() {
                                                        let paymentBody = document.getElementById('payment_mode_body');
                                                        let newRow = `
                                              <tr>
                                                  <td>
                                                      <select name="posting_acc_id[]" class="posting_acc_id">
                                                          <option value="" selected disabled>Select Mode</option>
                                                          @foreach ($paymentmodes as $paymentmode)
                                                          <option value="{{ $paymentmode->id }}">{{ $paymentmode->account_name }}</option>
                                                          @endforeach
                                                      </select>
                                                  </td>
                                                  <td>
                                                      <input type="text" class="amount_input" name="booking_amount[]" autocomplete="off">
                                                  </td>
                                              </tr>`;

                                                        paymentBody.insertAdjacentHTML('beforeend', newRow);
                                                    });
                                                </script> --}}
                                                <script>
                                                    // Function to calculate the total amount
                                                    function calculateTotalAmount() {
                                                        let total = 0;
                                                        document.querySelectorAll('.amount_input[name="booking_amount[]"]').forEach(function(input) {
                                                            let amount = parseFloat(input.value) || 0; // Convert the input value to a number
                                                            total += amount; // Add the value to the total
                                                        });
                                                        document.getElementById('total_receipt_amt').value = total.toFixed(2); // Update the total_receipt_amt field
                                                    }

                                                    // Add event listener to all booking_amount inputs
                                                    document.addEventListener('input', function(event) {
                                                        if (event.target.matches('.amount_input[name="booking_amount[]"]')) {
                                                            calculateTotalAmount(); // Recalculate the total whenever an amount input is changed
                                                        }
                                                    });

                                                    // JavaScript to dynamically add more payment modes
                                                    document.getElementById('add_payment_mode').addEventListener('click', function() {
                                                        let paymentBody = document.getElementById('payment_mode_body');
                                                        let newRow = `
                                                          <tr>
                                                              <td>
                                                                  <select name="posting_acc_id[]" class="posting_acc_id">
                                                                      <option value="" selected disabled>Select Mode</option>
                                                                      @foreach ($paymentmodes as $paymentmode)
                                                                      <option value="{{ $paymentmode->id }}">{{ $paymentmode->account_name }}</option>
                                                                      @endforeach
                                                                  </select>
                                                              </td>
                                                              <td>
                                                                  <input type="text" class="amount_input" name="booking_amount[]" autocomplete="off">
                                                              </td>
                                                          </tr>`;

                                                        paymentBody.insertAdjacentHTML('beforeend', newRow);

                                                        // Add event listener to the new amount input
                                                        paymentBody.querySelectorAll('.amount_input[name="booking_amount[]"]').forEach(function(input) {
                                                            input.addEventListener('input', calculateTotalAmount);
                                                        });
                                                    });
                                                </script>


                                            </div>



                                            {{-- 4rd row start for guest Correspondence                              --}}
                                            <div class="row justify-content-centerm-3 my-3">
                                                <div class="col-md-8">
                                                    <div class="row form-group mx-1">




                                                    </div>
                                                </div>





                                                <div id="contentstart">



                                                    <div class="row mb-3">



                                                        <div class="col-md-4 mt-4">
                                                            <div class="form-floating mb-3 mb-md-0">
                                                                {{--                                              
                                            <select name="room_id" Id ="room_id"class="form-select" aria-label="Default select example">
                                              <option selected disabled>Select Room No </option>
                                              @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}">
                                                        {{ $room->room_no }}
                                                       
                                                    </option>
                                              @endforeach
                
                                            </select>
                                              <label for="room_id">Room No   </label>
                                             
                                          </div>
                                          <span class="text-danger"> 
                                            @error('room_no')
                                            {{$message}}
                                                
                                            @enderror
                                          </span>

                                      </div>       
                                            
  --}}



                                                                {{-- 
                                          <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="advance_amount" type="text" name="advance_amount" value="{{ old('advance_amount') }}" />
                                                <label for="priority">Advance Amount  </label>
                                               
                                            </div>
                                            <span class="text-danger"> 
                                              @error('advance_amount')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>

                                        </div> --}}






                                                                <div class="row">

                                                                </div>
                                                            </DIV>



                                                            {{-- <input type="text" name ="room_no" id="room_no" value="" >
                                               <input type="text" name ="room_tariff" id="room_tariff" value="" >
                                               <input type="text" name ="room_dis" id="room_dis" value="" >
                                               <input type="text" name ="package_name" id="package_name" value="" >
                                               <input type="text" name ="plan_name" id="plan_name" value="" >
                                               <input type="text" name ="taxname" id="taxname" value="" >
                                               <input type="text" name ="sgst" id="sgst" value="" >
                                               <input type="text" name ="cgst" id="cgst" value="" >
                                               <input type="text" name ="igst" id="igst" value="" >
                                               <input type="text" name ="vat" id="vat" value="" >
                                               <input type="text" name ="tax1" id="tax1" value="" >
                                               <input type="text" name ="tax2" id="tax2" value="" >
                                               <input type="text" name ="tax3" id="tax3" value="" >
                                               <input type="text" name ="tax4" id="tax4" value="" >
                                               <input type="text" name ="tax5" id="tax5" value="" > --}}




                                                        </div>





                                                        @can('Save')

                                                        <div class="card-footer text-center py-3">
                                                            <div class="small">
                                                                <button id="saveButton"
                                                                    type="submit"class="btn btn-primary btn-block">Save</button>
                                                                <a
                                                                    class= "btn btn-dark  "href={{ url('amclist') }}>Back</a>
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



    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    {{-- function for calculate room traif  --}}
    <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.room-checkbox').change(function() {
                calculateTotalRoomTariff();
            });

            function calculateTotalRoomTariff() {
                let total = 0;
                $('.room-checkbox:checked').each(function() {
                    const roomTariffInput = $(this).closest('tr').find('input[name="checkin_room_tariff"]');
                    const roomTariff = parseFloat(roomTariffInput.val());
                    total += roomTariff;
                });
                $('#room_tariff_perday').val(total.toFixed(2));
            }
        });
        // 
    </script>


    {{-- Ajex for search room Detail --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#room_id').change(function() {
                var roomId = $(this).val();
                console.log(roomId);
                $.ajax({
                    url: '/roombookings/' + roomId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);



                        if (response.room_facilities) {
                            $('#facility').val(response.room_facilities);
                        } else {
                            $('#facility').val('');
                        }
                        if (response.roomtype) {
                            $('#room_type').val(response.roomtype.roomtype_name);
                        } else {
                            $('#room_type').val('');
                        }

                        if (response.room_no) {
                            $('#room_no').val(response.room_no);
                        } else {
                            $('#room_no').val('');
                        }
                        if (response.roomtype) {
                            $('#room_tariff').val(response.roomtype.room_tariff);
                        } else {
                            $('#room_tariff').val('');
                        }
                        if (response.roomtype) {
                            $('#room_dis').val(response.roomtype.room_dis);
                        } else {
                            $('#room_dis').val('');
                        }
                        if (response.roomtype) {
                            $('#package_name').val(response.roomtype.package.package_name);
                        } else {
                            $('#package_name').val('');
                        }
                        if (response.roomtype) {
                            $('#plan_name').val(response.roomtype.package.plan_name);
                        } else {
                            $('#plan_name').val('');
                        }
                        if (response.roomtype) {
                            $('#taxname').val(response.roomtype.gstmaster.taxname);
                        } else {
                            $('#taxname').val('');
                        }
                        if (response.roomtype) {
                            $('#sgst').val(response.roomtype.gstmaster.sgst);
                        } else {
                            $('#sgst').val('');
                        }
                        if (response.roomtype) {
                            $('#cgst').val(response.roomtype.gstmaster.cgst);
                        } else {
                            $('#cgst').val('');
                        }
                        if (response.roomtype) {
                            $('#igst').val(response.roomtype.gstmaster.igst);
                        } else {
                            $('#igst').val('');
                        }
                        if (response.roomtype) {
                            $('#vat').val(response.roomtype.gstmaster.vat);
                        } else {
                            $('#vat').val('');
                        }
                        if (response.roomtype) {
                            $('#tax1').val(response.roomtype.gstmaster.tax1);
                        } else {
                            $('#tax1').val('');
                        }
                        if (response.roomtype) {
                            $('#tax2').val(response.roomtype.gstmaster.tax2);
                        } else {
                            $('#tax2').val('');
                        }
                        if (response.roomtype) {
                            $('#tax3').val(response.roomtype.gstmaster.tax3);
                        } else {
                            $('#tax3').val('');
                        }
                        if (response.roomtype) {
                            $('#tax4').val(response.roomtype.gstmaster.tax4);
                        } else {
                            $('#tax4').val('');
                        }
                        if (response.roomtype) {
                            $('#tax5').val(response.roomtype.gstmaster.tax5);
                        } else {
                            $('#tax5').val('');
                        }

                    }


                });

            });
        });
    </script>
    {{-- Ajex for Account Detail --}}
    <script type="text/javascript">
        $(document).ready(function() {
           $('#guest_mobile').blur(function () {
    var contactNumber = $(this).val();
                console.log(contactNumber);

                $.ajax({
                    url: '/searchcustomer/' + contactNumber,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        if (response.customer_info) {
                            $('#guest_name').val(response.customer_info.account_name).prop('readonly', true);
                        } else {
                            $('#guest_name').prop('readonly', false);
                        }
                        if (response.customer_info) {
                            $('#guest_email').val(response.customer_info.email).prop('readonly', true);
                        } else {
                          $('#guest_email').prop('readonly', false);
                        }
                        if (response.customer_info) {
                            $('#guest_mobile').val(response.customer_info.mobile);
                        } else {
                     $('#guest_mobile').prop('readonly', false);
                        }
                        if (response.customer_info) {
                            $('#guest_address').val(response.customer_info.address).prop('readonly', true);
                        } else {
                   $('#guest_address').prop('readonly', false); 
                        }
                        if (response.customer_info) {
                            $('#guest_city').val(response.customer_info.city).prop('readonly', true);
                        } else {
                           $('#guest_city').prop('readonly', false);
                        }
                        if (response.customer_info) {
                            $('#guest_state').val(response.customer_info.state).prop('readonly', true);
                        } else {
                             $('#guest_state').prop('readonly', false);
                         
                        }
                        if (response.customer_info) {
                            $('#guest_contery').val(response.customer_info.nationality).prop('readonly', true);
                        } else {
                            
                        }
                        if (response.customer_info) {
                            $('#guest_idproof').val(response.customer_info
                                .account_idproof_name).prop('readonly', true);
                        } else {
                          $('#guest_idproof').prop('readonly', false);  
                        }
                        if (response.customer_info) {
                            $('#guest_idproof_no').val(response.customer_info
                                .account_idproof_no).prop('readonly', true);
                        } else {
                            $('#guest_idproof_no').prop('readonly', false);  
                            
                        }


                        if (response.customer_info) {
                            $('#guest_pic_response1').val(response.customer_info.account_pic1);
                        } else {
                            
                        }
                        if (response.customer_info) {
                            const imageUrl =
                                "{{ asset('storage/app/public/account_image/') }}" + '/' +
                                response.customer_info.account_pic1;
                            $('#guest_pic_response').attr('src', imageUrl);
                        } else {
                            $('#guest_pic_response').attr('src',
                                ''); // or set a default image if desired
                        }
                        if (response.customer_info) {
                            $('#uploded_id_pic_response').val(response.customer_info
                                .account_id_pic);
                            $('#uploded_id_pic_response1').attr('src',
                                '{{ asset('storage/app/public/account_image/') }}/' +
                                response.customer_info.account_id_pic);
                        } else {
                            $('#uploded_id_pic_response').val('');
                            $('#uploded_id_pic_response1').attr('src',
                                '{{ asset('storage/app/public/image/default.jpg') }}');
                        }




                        if (response.customer_info) {
                            $('#gst_no').val(response.customer_info.gst_no);
                        } else {

                            
                                      }

                        if (response.customer_info.mobile) {
alert("पिछले से गेस्ट की डिटेल मौजूदा है।\nयदि आप गेस्ट की जानकारी बदलना चाहते हैं,\nतो कृपया मोबाइल नंबर भी बदलें।\n\nGuest record found in database.\nIf you want to enter different guest details, please change the mobile number.");


}
 else {
                            $('#search_results').html(
                                '<p>No customer found with this contact number.</p>');
                        }
                    },
                    error: function() {
                        $('#search_results').html(
                            '<p>An error occurred while searching for the customer.</p>');
                    }
                });
            });
        });
    </script>
    {{-- this is function  when i select booking no cutomer search is diable  --}}

    <script>
        $(document).ready(function() {
            $('#roombooking_id').change(function() {
                if ($(this).val() !== null) {
                    $('#searchinput').prop('readonly', true);
                } else {
                    $('#searchinput').prop('readonly', false);
                }
            });
        });
    </script>
    {{-- Ajex for search roomBooking Detail --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#roombooking_id').change(function() {
                var roombooking_id = $(this).val();
                console.log(roombooking_id);
                $.ajax({
                    url: '/show_selected_booking/' + roombooking_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);



                        if (response.booking_date) {
                            $('#booking_date').val(response.booking_date);
                        } else {
                            $('#booking_date').val('');
                        }
                        if (response.guest_name) {
                            $('#room_type').val(response.guest_name);
                        } else {
                            $('#room_type').val('');
                        }

                        if (response.room_no) {
                            $('#room_no').val(response.room_no);
                        } else {
                            $('#room_no').val('');
                        }
                        if (response.room_tariff) {
                            $('#room_tariff').val(response.room_tariff);
                        } else {
                            $('#room_tariff').val('');
                        }
                        if (response.room_dis) {
                            $('#room_dis').val(response.room_dis);
                        } else {
                            $('#room_dis').val('');
                        }
                        if (response.package_name) {
                            $('#package_name').val(response.package_name);
                        } else {
                            $('#package_name').val('');
                        }
                        if (response.plan_name) {
                            $('#plan_name').val(response.plan_name);
                        } else {
                            $('#plan_name').val('');
                        }
                        if (response.taxname) {
                            $('#taxname').val(response.taxname);
                        } else {
                            $('#taxname').val('');
                        }
                        if (response.sgst) {
                            $('#sgst').val(response.sgst);
                        } else {
                            $('#sgst').val('');
                        }
                        if (response.cgst) {
                            $('#cgst').val(response.cgst);
                        } else {
                            $('#cgst').val('');
                        }
                        if (response.igst) {
                            $('#igst').val(response.igst);
                        } else {
                            $('#igst').val('');
                        }
                        if (response.vat) {
                            $('#vat').val(response.vat);
                        } else {
                            $('#vat').val('');
                        }
                        if (response.tax1) {
                            $('#tax1').val(response.tax1);
                        } else {
                            $('#tax1').val('');
                        }
                        if (response.tax2) {
                            $('#tax2').val(response.tax2);
                        } else {
                            $('#tax2').val('');
                        }
                        if (response.tax3) {
                            $('#tax3').val(response.tax3);
                        } else {
                            $('#tax3').val('');
                        }
                        if (response.tax4) {
                            $('#tax4').val(response.tax4);
                        } else {
                            $('#tax4').val('');
                        }
                        if (response.tax5) {
                            $('#tax5').val(response.tax5);
                        } else {
                            $('#tax5').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_name').val(response.guest_name);
                        } else {
                            $('#guest_name').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_email').val(response.guest_email);
                        } else {
                            $('#guest_email').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_mobile').val(response.guest_mobile);
                        } else {
                            $('#guest_mobile').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_address').val(response.guest_address);
                        } else {
                            $('#guest_address').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_city').val(response.guest_city);
                        } else {
                            $('#guest_city').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_state').val(response.guest_state);
                        } else {
                            $('#guest_state').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_contery').val(response.guest_contery);
                        } else {
                            $('#guest_contery').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_idproof').val(response.guest_idproof);
                        } else {
                            $('#guest_idproof').val('');
                        }
                        if (response.guest_name) {
                            $('#guest_idproof_no').val(response.guest_idproof_no);
                        } else {
                            $('#guest_idproof_no').val('');
                        }
                        if (response.guest_name) {
                            $('#gst_no').val(response.gst_no);
                        } else {
                            $('#gst_no').val('');
                        }
                        if (response.booking_amount) {
                            $('#booking_amount').val(response.booking_amount);
                        } else {
                            $('#booking_amount').val('');
                        }
                        if (response.guest_id_pic) {
                            $('#uploded_id_pic_response1').attr('src',
                                '{{ asset('storage/account_image/') }}/' + response
                                .guest_id_pic);
                        } else {
                            $('#uploded_id_pic_response1').attr('src',
                                '{{ asset('storage/account_image/default.jpg') }}');
                        }
                        if (response.guest_pic) {
                            $('#guest_pic_response').attr('src',
                                '{{ asset('storage/account_image/') }}/' + response
                                .guest_pic);
                        } else {

                            $('#guest_pic_response').attr('src',
                                '{{ asset('storage/account_image/default.jpg') }}');
                        }










                    }


                });

            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('#saveForm').on('submit', function() {
                // Disable the submit button and show loading spinner
                $('#saveButton')
                    .prop('disabled', true)
                    .html('<i class="fa fa-spinner fa-spin"></i> Please wait...');
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {

            $('.room-checkbox').prop('disabled', true);

            // Monitor package selection
            $('#package_id').on('change', function() {
                if ($(this).val() !== '') {
                    // Enable room checkboxes if a package is selected
                    $('.room-checkbox').prop('disabled', false);
                } else {
                    // Disable room checkboxes if no package is selected
                    $('.room-checkbox').prop('disabled', true).prop('checked',
                    false); // Also uncheck checkboxes
                }
            });


            $('#saveForm').on('submit', function(event) {
                // Check if at least one checkbox is selected
                if ($('.room-checkbox:checked').length === 0) {
                    event.preventDefault(); // Prevent form submission
                    alert(
                        "Please select at least one room to proceed. & First Select Package Then Select Room");
                }
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#guest_search_id').change(function() {
                var guest_search_id = $(this).val();

                console.log(guest_search_id);


                $.ajax({
                    url: '/searchCustomer_by_id/' + guest_search_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);




                        if (response.customer_info) {
                            $('#guest_name').val(response.customer_info.account_name).prop('readonly', true);
                        } else {
                            $('#guest_name').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_email').val(response.customer_info.email);
                        } else {
                            $('#guest_email').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_mobile').val(response.customer_info.mobile).prop('readonly', true);
                        } else {
                            $('#guest_mobile').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_address').val(response.customer_info.address);
                        } else {
                            $('#guest_address').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_city').val(response.customer_info.city);
                        } else {
                            $('#guest_city').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_state').val(response.customer_info.state);
                        } else {
                            $('#guest_state').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_contery').val(response.customer_info.nationality);
                        } else {
                            $('#guest_contery').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_idproof').val(response.customer_info
                                .account_idproof_name);
                        } else {
                            $('#guest_idproof').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_idproof_no').val(response.customer_info
                                .account_idproof_no);
                        } else {
                            $('#guest_idproof_no').val('');
                        }


                        if (response.customer_info) {
                            $('#guest_pic_response1').val(response.customer_info.account_pic1);
                        } else {
                            $('#guest_pic_response1').val('');
                        }
                        if (response.customer_info) {
                            const imageUrl =
                                "{{ asset('storage/app/public/account_image/') }}" + '/' +
                                response.customer_info.account_pic1;
                            $('#guest_pic_response').attr('src', imageUrl);
                        } else {
                            $('#guest_pic_response').attr('src',
                                ''); // or set a default image if desired
                        }
                        if (response.customer_info) {
                            $('#uploded_id_pic_response').val(response.customer_info
                                .account_id_pic);
                            $('#uploded_id_pic_response1').attr('src',
                                '{{ asset('storage/app/public/account_image/') }}/' +
                                response.customer_info.account_id_pic);
                        } else {
                            $('#uploded_id_pic_response').val('');
                            $('#uploded_id_pic_response1').attr('src',
                                '{{ asset('storage/app/public/image/default.jpg') }}');
                        }




                        if (response.customer_info) {
                            $('#gst_no').val(response.customer_info.gst_no);
                        } else {
                            $('#gst_no').val('');
                        }

                        if (response.message) {
                            $('#message').html('  ' + response.message + '');
                        } else {
                            $('#search_results').html(
                                '<p>No customer found with this contact number.</p>');
                        }



                    }


                });

            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            // Trigger AJAX request when either checkin or checkout date changes
            $('#package_id').on('change', function() {

                // Collect data from inputs
                var data = {
                    'package_id': $('#package_id').val(),

                };
                console.log("Data being sent:", data); // Debug: Check if data is being collected correctly

                // Set up CSRF token for Laravel
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Start AJAX request
                $.ajax({
                    url: '/show_room_with_package', // Adjust URL according to your Laravel routes
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        console.log("Success:", response); // Debug: Check the response



                        if (response.status === 200) {
                            console.log(response);
                            // Clear the current room list
                            //    $('#room_selection').empty();

                            if (response.status === 200) {
                                console.log(response.rooms); // Log the room data for debugging

                                // Clear the current room list
                                $('#room_selection tbody').empty();
                                var packageCharge = parseFloat(response.package_charge) ||
                                    0; // Get package charge from response

                                // room tariff calculate nahi kar raha sahi karna hai 
                                $.each(response.rooms, function(index, room) {
                                    var roomTariff = room.roomtype ? parseFloat(room
                                            .roomtype.room_tariff) || 0 :
                                        0; // Get room tariff
                                    var adjustedTariff = roomTariff +
                                        packageCharge; // Add package charge to room tariff

                                    var row = '<tr>' +
                                        '<td>' +
                                        '<label class="container_chekbox">' +
                                        '<input type="checkbox" class="room-checkbox" name="checkin_room_id[]" value="' +
                                        room.id + '">' +
                                        '<span class="checkmark"></span>' +
                                        '</label>' +
                                        '</td>' +
                                        '<td><input type="text" id="checkin_room_no" name="checkin_room_no" value="' +
                                        room.room_no + '" readonly></td>' +
                                        '<td><input type="text" id="checkin_roomtype" name="checkin_roomtype" value="' +
                                        (room.roomtype ? room.roomtype.roomtype_name :
                                            '') + '" readonly></td>' +
                                        '<td><input type="text" id="checkin_room_tariff" name="checkin_room_tariff" value="' +
                                        adjustedTariff.toFixed(2) +
                                        '" @cannot('Change_Room_Tariff') readonly @endcannot></td>' +
                                        '  </tr>';

                                    $('#room_selection tbody').append(row);
                                });
                            }


                        } else {
                            console.log("Unexpected status:", response
                                .status); // Debug: If status is not 200, log it
                        }
                    },
                    error: function(xhr, status, error) {
                        // Error handling
                        console.error("Status:", status);
                        console.error("Error:", error);
                        console.error("Response Text:", xhr.responseText);
                        console.error("Ready State:", xhr.readyState);
                        console.error("Status Text:", xhr.statusText);
                    }
                });
            });

            $('#room_selection').on('change', '.room-checkbox', function() {
                calculateTotalRoomTariff();
            });

            function calculateTotalRoomTariff() {
                let total = 0;
                $('.room-checkbox:checked').each(function() {
                    const roomTariffInput = $(this).closest('tr').find('input[name="checkin_room_tariff"]');
                    const roomTariff = parseFloat(roomTariffInput.val());
                    total += roomTariff;
                });
                $('#room_tariff_perday').val(total.toFixed(2));
            }
        });
    </script>





    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#guest_search_id").select2({
            placeholder: "Search Guest ",
            allowClear: true
        });
    </script>

    <script>
    $(document).ready(function() {
        // Initialize Select2
        $('#roombooking_voucher_no').select2({
            placeholder: "Select Room Booking",
            allowClear: true,
            width: '100%' // Makes it fit the form width
        });

        // Redirect on selection
        $('#roombooking_voucher_no').on('change', function() {
            var voucherNo = $(this).val();
            if (voucherNo) {
                window.location.href = '/show_booking/' + voucherNo;
            }
        });
    });
</script>
@endsection
