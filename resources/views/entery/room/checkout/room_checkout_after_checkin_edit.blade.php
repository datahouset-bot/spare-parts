@php
    include public_path('cdn/cdn.blade.php');
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css') }}">
<style>
    #room_selection_box {
        background-color: rgb(242, 247, 247);

        border: 5px solid #2196F3;
        max-height: 170px;
        min-height: 170px;
        overflow: auto;

    }

    #paymnet_selection_box {
        background-color: rgb(242, 247, 247);
        border: 5px solid yellowgreen;

        overflow: auto;

    }

    #foodkot_selection_box {
        background-color: rgb(242, 247, 247);

        border: 5px solid #2196F3;
        max-height: 170px;
        min-height: 170px;
        overflow: auto;

    }


    #room_selection {
        width: 100%;
        border: 2px solid #ddd;

    }

    #foodkot_table {
        width: 100%;
        border: 2px solid #ddd;
        font-size: 13px;

    }

    #payment_table {
        width: 100%;
        border: 2px solid #ddd;
        font-size: 15px;
        padding: 0 !important;
        margin: 0 !important;

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

    .input_id {
        width: 50px;
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
</style>
@extends('layouts.blank')
@section('pagecontent')
    <div class="card my-1 ">
        <div class="row ">


            <div class="container ">
                @php
                    $r1 = 0;
                    $total_amount_kot = 0;
                    $total_food_bill_amount = 0;
                @endphp

                <body class="bg-primary">
                    <div class="container">

                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card  mt-0">
                                    <div class="card-header">
                                        <h5 class="text-center font-weight-light my-1">New Room Check Out Ente </h5>
                                    </div>
                                    <div class="card-body">


                                        <div class="row">
                                            <!-- Room Booking -->

                                            <div class="col-md-6 mt-4">

                                                <label for="searchCustomer">Selected Checkin Detail </label>
                                                <div id="searchCustomer">

             
                                                    <div class="input-group">
                                                        <input type="text" name="" id=""
                                                            class="form-control"
                                                            value="{{ $data['guest_name'] }} || {{ $data['guest_mobile'] }} || @php $roomNumbers = []; foreach ($roomNos as $roomNo) { $roomNumbers[] = $roomNo; } echo implode(',', $roomNumbers); @endphp">




                                                    </div>

                                                    <span id="message"></span>
                                                    </form>
                                                </div>

                                            </div>
                                            <div class="col-md-4 mt-4">
                                                    <span class="btn btn-danger btn-sm"
                                                    id="my_checkout">My Checkout </span> 



                                            </div>


                                        </div>


                                        <form id="saveForm" action="{{ url('/roomcheckouts_store_edit') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('POST')
                                            @csrf
                                            {{-- 2nd row checkin detail and select room no                                                          --}}
                                            <div class="row justify-content-centerm-3">
                                                <div class="col-md-8">
                                                    <div class="row form-group">
                                                        <div class="col-md-3">
                                                            <label for="label1">Invoice No </label>
                                                            <input type="text" name="check_out_no"class=" form-control"
                                                                id="check_out_no" class="" value="{{ $chekcout_data->check_out_no}}"
                                                                readonly>
                                                            <input type="hidden" name="voucher_no"class=" form-control"
                                                                id="voucher_no" name="voucher_no" class=""
                                                                value="{{ $chekcout_data->voucher_no }}" readonly>
                                                            <input type="hidden" id="bill_type"name="bill_type"class=" form-control"
                                                               
                                                                value="{{$chekcout_data->bill_type}}" readonly>
                                                               


                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="checkin_date">Check In Date</label>
                                                            <input class="form-control" id="checkin_date" type="text"
                                                                name="checkin_date"
                                                                value="{{ \Carbon\Carbon::parse($data['checkin_date'])->format('d-m-Y') }}"
                                                                readonly />
                                                            <input type="hidden"
                                                                name="checkin_voucher_no"class=" form-control"
                                                                id="" class=""
                                                                value="{{ $data['voucher_no'] }}" readonly>

                                                            <span class="text-danger">
                                                                @error('checkin_date')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="checkin_time">Check In Time</label>
                                                            <input class="form-control" type="time" name="checkin_time"
                                                                id ="checkin_time1" value="{{ $data['checkin_time'] }}"
                                                                readonly />
                                                            <span class="text-danger">
                                                                @error('checkin_time')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="checkout_date">Check Out Date</label>
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
                                                            <label for="check_out_time">Check Out Time</label>
                                                            <input class="form-control" id="check_out_time" type="time"
                                                                name="check_out_time" value="" />
                                                            <span class="text-danger">
                                                                @error('check_out_time')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="calculation_type">Caculation Type</label>
                                                            <input type="text" name ="calculation_type"
                                                                class="form-control"id="calculation_type"
                                                                value="{{ $calculation_type }}" readonly>

                                                            <span class="text-danger">
                                                                @error('caluclation_type')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>


                                                        <div class="col-md-3">
                                                            <label for="no_of_days">No Of Days</label>
                                                            <input class="form-control" id="no_of_days" type="text"
                                                                name="no_of_days" value="" readonly />
                                                            <span class="text-danger">
                                                                @error('no_of_days')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>

                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="per_day_tariff">Per Day Tariff</label>
                                                            <input class="form-control" id="per_day_tariff" type="text"
                                                                name="per_day_tariff"
                                                                value="{{ $data['room_tariff_perday'] }}" />
                                                            <span class="text-danger">
                                                                @error('per_day_tariff')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="total_room_rent">Total Room Rent</label>
                                                            <input class="form-control" id="total_room_rent"
                                                                type="text" name="total_room_rent" value=""
                                                                readonly />
                                                            <span class="text-danger">
                                                                @error('total_room_rent')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <label for="food_amount">Food Amount</label>
                                                            <input class="form-control" id="food_amount" type="text"
                                                                name="food_amount" value="" readonly />
                                                            <span class="text-danger">
                                                                @error('food_amount')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="checkin_remark1">Check In Remark</label>
                                                            <input class="form-control" id="checkin_remark1"
                                                                type="text" readonly name="checkin_remark1"
                                                                value="{{ $data['checkin_remark1'] }}||{{ $data['checkin_remark1'] }}" />
                                                            <span class="text-danger">
                                                                @error('checkin_remark1')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4 mb-1">
                                                            <label for="checkin_remark2">Checkout Remark </label>
                                                            <input class="form-control" id="checkin_remark2"
                                                                type="text" name="checkout_remark" value="" />
                                                            <span class="text-danger">
                                                                @error('checkin_remark2')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="gst_no">GST NO </label>
                                                            <input class="form-control" id="gst_no" type="text"
                                                                name="gst_no" readonly
                                                                value="{{ $account_detail->gst_no }}" />
                                                            <span class="text-danger">
                                                                @error('gst_no')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="guest_name">Guest Name </label>
                                                            <input class="form-control" id="guest_name" type="text"
                                                                name="guest_name" value="{{ $data['guest_name'] }}" />
                                                            <input class="form-control" id="account_id" type="hidden"
                                                                name="account_id" value="{{ $account_detail->id }}" />

                                                            <span class="text-danger">
                                                                @error('guest_name')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>


                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_address">Address Line 1</label>
                                                            <input class="form-control" id="guest_address" type="text"
                                                                name="guest_address"
                                                                value="{{ $account_detail->address }}" />
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
                                                                value="{{ $account_detail->address2 }}" />
                                                            <span class="text-danger">
                                                                @error('guest_address2')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_city">City</label>
                                                            <input class="form-control" id="guest_city" type="text"
                                                                name="guest_city" value="{{ $account_detail->city }}" />
                                                            <span class="text-danger">
                                                                @error('guest_city')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_state">State</label>
                                                            <input class="form-control" id="guest_state" type="text"
                                                                name="guest_state"
                                                                value="{{ $account_detail->state }}" />
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
                                                                value="{{ $account_detail->nationality }}" />
                                                            <span class="text-danger">
                                                                @error('guest_contery')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_pincode"> Pin Code </label>
                                                            <input class="form-control" id="guest_pincode" type="text"
                                                                name="guest_pincode"
                                                                value="{{ $account_detail->pincode }}" />
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
                                                                value="{{ $account_detail->nationality }}" />
                                                            <span class="text-danger">
                                                                @error('guest_nationality')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_mobile">Mobile</label>
                                                            <input class="form-control" id="guest_mobile" type="text"
                                                                name="guest_mobile"
                                                                value="{{ $account_detail->mobile }}" />
                                                            <span class="text-danger">
                                                                @error('guest_mobile')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>


                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_phone">Phone</label>
                                                            <input class="form-control" id="guest_phone" type="text"
                                                                name="guest_phone"
                                                                value="{{ $account_detail->phone }}" />
                                                            <span class="text-danger">
                                                                @error('guest_phone')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="guest_email">Email</label>
                                                            <input class="form-control" id="guest_email" type="text"
                                                                name="guest_email"
                                                                value="{{ $account_detail->email }}" />
                                                            <span class="text-danger">
                                                                @error('guest_email')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        {{-- kot Box  --}}
                                                        <div class="col-md-4 my-1 " id ="foodkot_selection_box">
                                                            <h5>Pending Kot List </h5>
                                                            <table id="foodkot_table"
                                                                class="table table-striped table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">S.No</th>
                                                                        <th scope="col"> Date </th>
                                                                        <th scope="col"> KOT No </th>
                                                                        <th scope="col"> Total Qty </th>
                                                                        <th scope="col"> Total Amount </th>
                                                                        <th scope="col"></th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($kots as $record)
                                                                        <tr>

                                                                            <th scope="row">{{ $r1 = $r1 + 1 }}</th>
                                                                            <td scope="col">
                                                                                {{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}
                                                                            </td>
                                                                            <td>{{ $record['bill_no'] }}</td>

                                                                            <td>{{ $record['total_qty'] }}</td>
                                                                            <td>{{ $record['total_amount'] }}</td>

                                                                            <span
                                                                                style="display: none">{{ $total_amount_kot += $record['total_amount'] }}</span>


                                                                            <td>
                                                                                <a href="{{ url('kot_print', [$record['user_id'], $record['voucher_no']]) }}"
                                                                                    class="btn btn-sm">
                                                                                    <i class="fa fa-print"
                                                                                        style="font-size:20px;color:SlateBlue"></i>
                                                                                </a>

                                                                            </td>

                                                                            <td>
                                                                                <a href="{{ url('kot_print_view', [$record['user_id'], $record['voucher_no']]) }}"
                                                                                    class="btn  btn-sm"><i
                                                                                        class="fa fa-eye"
                                                                                        style="font-size:20px;color:SlateBlue"></i></a>
                                                                            </td>


                                                                        </tr>
                                                                    @endforeach


                                                                </tbody>
                                                            </table>
                                                            <input type="text" class="input_id" id ="kotamount_total"
                                                                value =" {{ $total_amount_kot }}">





                                                            </table>
                                                        </div>
                                                        {{-- Food Bill Box   --}}
                                                        <div class="col-md-4 my-1 " id ="foodkot_selection_box">
                                                            <h5>Pending Food Bill </h5>
                                                            <table id="foodkot_table"
                                                                class="table table-striped table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">S.No</th>
                                                                        <th scope="col"> Date </th>
                                                                        <th scope="col"> Bill No </th>
                                                                        <th scope="col"> Total Qty </th>
                                                                        <th scope="col"> Total Amount </th>
                                                                        <th scope="col"></th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    {{-- @php
                        $r1=0;
                     $total_amount_kot=0; 
                      @endphp --}}
                                                                    @foreach ($foodbills as $record)
                                                                        <tr>

                                                                            <th scope="row">{{ $r1 = $r1 + 1 }}</th>
                                                                            <td scope="col">
                                                                                {{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}
                                                                            </td>
                                                                            <td>{{ $record['food_bill_no'] }}</td>

                                                                            <td>{{ $record['total_qty'] }}</td>
                                                                            <td>{{ $record['net_food_bill_amount'] }}</td>

                                                                            <span
                                                                                style="display: none">{{ $total_food_bill_amount += $record['net_food_bill_amount'] }}</span>


                                                                            <td>
                                                                                <a href="{{ url('foodbill_print_view', $record['voucher_no']) }}"
                                                                                    class="btn btn-sm">
                                                                                    <i class="fa fa-print"
                                                                                        style="font-size:20px;color:SlateBlue"></i>
                                                                                </a>

                                                                            </td>

                                                                            <td>
                                                                                <a href="{{ url('foodbill_print_view', $record['voucher_no']) }}"
                                                                                    class="btn  btn-sm"><i
                                                                                        class="fa fa-eye"
                                                                                        style="font-size:20px;color:SlateBlue"></i></a>
                                                                            </td>


                                                                        </tr>
                                                                    @endforeach


                                                                </tbody>
                                                            </table>
                                                            <input type="text" class="input_id"
                                                                id ="total_food_bill_amount"
                                                                value =" {{ $total_food_bill_amount }}">





                                                            </table>
                                                        </div>
                                                        {{-- rent display   --}}
                                                        <div class="col-md-4 my-1 " id ="foodkot_selection_box">
                                                            <h5>Day Wise Rent Report </h5>
                                                            <table id="rent_diplay"
                                                                class="table table-striped table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th># </th>
                                                                        <th>Start Date </th>
                                                                        <th>End Date</th>
                                                                        <th>Day Count</th>
                                                                        <th>Rent</th>
                                                                        <th>Totel</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>




                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        {{-- Food Bill Box   --}}




                                                    </div>
                                                </div>



                                                <div class="col-md-4" id ="paymnet_selection_box">
                                                    <table id="room_selection"
                                                        class="table table-striped table-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th># </th>
                                                                <th>Room No </th>
                                                                <th>Room Type</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>



                                                            @foreach ($roomcheckins as $roomcheckin)
                                                                <tr>
                                                                    <td>
                                                                        <label class="container_chekbox">
                                                                            <input type="checkbox" class="room-checkbox"
                                                                                checked="checked" disabled>
                                                                            <span class="checkmark"></span>
                                                                            <input type="hidden"
                                                                                name="room_checkout_id[]"
                                                                                value="{{ $roomcheckin->room_id }}">
                                                                        </label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text"id="checkin_room_no"
                                                                            name="checkin_room_no"
                                                                            value="{{ $roomcheckin->room_no }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="checkin_roomtype"
                                                                            id="checkin_roomtype"
                                                                            value ="{{ $roomcheckin->room->roomtype->roomtype_name }}"
                                                                            readonly>
                                                                    </td>

                                                                </tr>
                                                            @endforeach



                                                        </tbody>
                                                    </table>
                                                    <h5>Payment Detail</h5>
                                                    <table id="payment_table"
                                                        class="table table-striped table-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Amount</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Total Room Rent
                                                                    <span class="btn btn-danger btn-sm" id="tax_inclusive" data-toggle="tooltip" title="Calculate Bill (Tax Inclusive)">
                                                                        <i class="fa fa-calculator"></i>
                                                                    </span>
                                                                    
                                                                    
                                                                </td>
                                                                <td><input type="text" id="final_room_rent"
                                                                        name="final_room_rent" class="amount_input"
                                                                        readonly>
                                                                    
                                                                    
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                <td>ADD GST % <select name="gst_id" id="gst_id">

                                                                        <option selected value="{{ $gst_percent->igst }}">
                                                                            {{ $gst_percent->igst }}</option>
                                                                        <option value="0">
                                                                            0</option>


                                                                </td>

                                                                <td><input type="text" id="gst_total" name="gst_total"
                                                                        class="amount_input" readonly></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Total Food Amt </td>
                                                                <td><input type="text" class="amount_input"
                                                                        id="total_food_amt" name="total_food_amt"
                                                                        readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Add Others (+) </td>
                                                                <td><input type="text" class="amount_input"
                                                                        id="add_other" name="add_other"autocomplete="off">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Less Discount (-) </td>
                                                                <td><input type="text" class="amount_input"
                                                                        id="less_discount" name="less_discount"
                                                                        autocomplete="off">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bill Amount </td>
                                                                <td><input type="text" class="amount_input"
                                                                        id="bill_amount" name="bill_amount" readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Total Advance </td>
                                                                <td><input type="text" class="amount_input"
                                                                        id="total_advance" name="total_advance"
                                                                        value={{ $final_opning_balance }} readonly></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Balance To Pay
                                                                    <span class="btn btn-secondary btn-sm"
                                                                        id="recalculate">Recalculate</span>
                                                                </td>
                                                                <td><input type="text" class="amount_input"
                                                                        id="balance_to_pay" name="balance_to_pay"
                                                                        readonly></td>
                                                            </tr>

                                                            <tr>
                                                                {{-- <td>Pay <select name="posting_acc_id" id="posting_acc_id">
                                                                        <option selected disabled>Select Mode </option>
                                                                        
                                                                        @foreach ($paymentmodes as $records)
                                                                            <option value="{{ $records->id }}">
                                                                                {{ $records->account_name }}</option>
                                                                        @endforeach



                                                                    </select></td>


                                                                <td><input type="text"
                                                                        name ="total_receipt_amt"class="amount_input"
                                                                        id="total_receipt_amt" placeholder="0"
                                                                        autocomplete="off"></td>
                                                            </tr> --}}
                                                                <div class="col-md-4" id="payment_selection_box">

                                                                    <table id="room_selection"
                                                                        class="table table-striped table-responsive">
                                                                        <thead>

                                                                        </thead>
                                                                        <tbody id="payment_mode_body">
                                                                            <tr>
                                                                                <td>
                                                                                    <select name="posting_acc_id[]"
                                                                                        class="posting_acc_id">
                                                                                        <option value="" selected
                                                                                            disabled>Select
                                                                                            Mode</option>
                                                                                        @foreach ($paymentmodes as $paymentmode)
                                                                                            <option
                                                                                                value="{{ $paymentmode->id }}">
                                                                                                {{ $paymentmode->account_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="amount_input"
                                                                                        name="booking_amount[]"
                                                                                        autocomplete="off">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <!-- Button to add more payment modes -->


                                                                    <table class="table" id="payment_det">
                                                                        <tr>
                                                                            <td>
                                                                                <button type="button"
                                                                                    id="add_payment_mode"
                                                                                    class="btn  btn-sm btn-primary">+
                                                                                    Payment Mode</button>
                                                                            </td>


                                                                            <td><input type="text"
                                                                                    id="total_receipt_amt"
                                                                                    name="total_receipt_amt"
                                                                                    class="amount_input" readonly></td>
                                                                        </tr>
                                                                        <td>Credit to {{ $data['guest_name'] }} <input
                                                                                type="hidden" name="amt_post_credit_id"
                                                                                class="input_id" id="amt_post_credit_id"
                                                                                value="{{ $data['account_id'] }}"autocomplete="off"
                                                                                readonly>




                                                                        </td>


                                                                        <td><input type="text"
                                                                                name ="amt_post_credit_amt"
                                                                                id="amt_post_credit_amt"
                                                                                class="amount_input " placeholder="0"
                                                                                autocomplete="off"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Balance</td>
                                                                <td><input type="text" id ="balance_amt"
                                                                        name="balance_amt"class="amount_input" readonly>
                                                                </td>
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





                                                </tbody>
                                                </table>







                                            </div>

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







                                        <div class="card-footer text-center py-3">
                                            <div class="small">
                                                <button type="submit"
                                                    id="save_button"class="btn btn-primary btn-block">Save</button>
                                                <a class= "btn btn-dark  "href={{ url('amclist') }}>Back</a>
                                            </div>
                                        </div>





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
            $('#search_acccount').submit(function(event) {
                event.preventDefault(); // Prevent the form from submitting via the browser
                var contactNumber = $('#searchinput').val();
                console.log(contactNumber);

                $.ajax({
                    url: '/searchcustomer/' + contactNumber,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        if (response.customer_info) {
                            $('#guest_name').val(response.customer_info.account_name);
                        } else {
                            $('#guest_name').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_email').val(response.customer_info.email);
                        } else {
                            $('#guest_email').val('');
                        }
                        if (response.customer_info) {
                            $('#guest_mobile').val(response.customer_info.mobile);
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
                            const imageUrl = "{{ asset('storage/account_image/') }}" + '/' +
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
                                '{{ asset('storage/account_image/') }}/' + response
                                .customer_info.account_id_pic);
                        } else {
                            $('#uploded_id_pic_response').val('');
                            $('#uploded_id_pic_response1').attr('src',
                                '{{ asset('storage/account_image/default.jpg') }}');
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
            $('#roomcheckin_voucher_no').change(function() {
                if ($(this).val() !== null) {
                    $('#searchinput').prop('readonly', true);
                } else {
                    $('#searchinput').prop('readonly', false);
                }
            });
        });
    </script>
    {{-- Ajex for room Rent Calculation  --}}
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#calculation_type').change(function() {

            var calculation_type = $('#calculation_type').val();
            var checkin_date = $('#checkin_date').val();
            var checkin_time = $('#checkin_time1').val();
            var checkout_date = $('#checkout_date').val();
            var checkout_time = $('#check_out_time').val();
            var per_day_tariff = $('#per_day_tariff').val();

            console.log(calculation_type);
            console.log(checkin_date);
            console.log(checkin_time);
            console.log(checkout_date);
            console.log(checkout_time);
            console.log(per_day_tariff);

            $.ajax({
                url: '/roomcheckouts/' + calculation_type,
                type: 'GET',
                data: {
                    checkin_date: checkin_date,
                    checkin_time: checkin_time,
                    checkout_date: checkout_date,
                    checkout_time: checkout_time,
                    per_day_tariff: per_day_tariff
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    var food_bill_amt = parseFloat($('#total_food_bill_amount').val()) || 0;
                    var kot_amt = parseFloat($('#kotamount_total').val()) || 0;
                    var total_food_amt = food_bill_amt + kot_amt;
                    var gst_percent = parseFloat($('#gst_id').val()) || 0;
                    $('#food_amount').val(total_food_amt);
                    $('#total_food_amt').val(total_food_amt);
                    $('#no_of_days').val(response.no_of_days);
                    $('#total_room_rent').val(response.total_rent);
                    $('#final_room_rent').val(response.total_rent);
                    var add_other = parseFloat($('#add_other').val()) || 0;
                    var less_discount = parseFloat($('#less_discount').val()) || 0;
                    var total_advance = parseFloat($('#total_advance').val()) || 0;
                    var final_room_rent = parseFloat($('#final_room_rent').val()) || 0;
                    var gst_total = (gst_percent * final_room_rent) / 100;
                    $('#gst_total').val(gst_total);
                    var bill_amount = final_room_rent + total_food_amt + gst_total + add_other;
                    $('#bill_amount').val(bill_amount);

                    var balance_to_pay = final_room_rent + total_advance + total_food_amt + gst_total -
                        less_discount;
                    $('#balance_to_pay').val(balance_to_pay);


                    // Clear the table before appending new rows
                    $('#rent_diplay tbody').empty();

                    // Append the calculated values as rows to the table
                    response.day_entries.forEach(function(entry, index) {
                        $('#rent_diplay tbody').append(
                            '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + entry.checkin_date + '</td>' +
                            '<td>' + entry.checkout_date + '</td>' +
                            '<td>' + entry.day_count + '</td>' +
                            '<td>' + entry.rent + '</td>' +
                            '<td>' + entry.total + '</td>' +
                            '</tr>'
                        );
                    });
                }
            });
            // });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            function recalculate() {
                var calculation_type = $('#calculation_type').val();
                var checkin_date = $('#checkin_date').val();
                var checkin_time = $('#checkin_time1').val();
                var checkout_date = $('#checkout_date').val();
                var checkout_time = $('#check_out_time').val();
                var per_day_tariff = $('#per_day_tariff').val();

                console.log(calculation_type);
                console.log(checkin_date);
                console.log(checkin_time);
                console.log(checkout_date);
                console.log(checkout_time);
                console.log(per_day_tariff);

                $.ajax({
                    url: '/roomcheckouts/' + calculation_type,
                    type: 'GET',
                    data: {
                        checkin_date: checkin_date,
                        checkin_time: checkin_time,
                        checkout_date: checkout_date,
                        checkout_time: checkout_time,
                        per_day_tariff: per_day_tariff
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        var food_bill_amt = parseFloat($('#total_food_bill_amount').val()) || 0;
                        var kot_amt = parseFloat($('#kotamount_total').val()) || 0;
                        var total_food_amt = food_bill_amt + kot_amt;
                        var gst_percent = parseFloat($('#gst_id').val()) || 0;
                        $('#food_amount').val(total_food_amt);
                        $('#total_food_amt').val(total_food_amt);
                        $('#no_of_days').val(response.no_of_days);
                        $('#total_room_rent').val(response.total_rent);
                        $('#final_room_rent').val(response.total_rent);
                        var add_other = parseFloat($('#add_other').val()) || 0;
                        var less_discount = parseFloat($('#less_discount').val()) || 0;
                        var total_advance = parseFloat($('#total_advance').val()) || 0;
                        var final_room_rent = parseFloat($('#final_room_rent').val()) || 0;
                        var total_receipt_amt = parseFloat($('#total_receipt_amt').val()) || 0;
                        var amt_post_credit_amt = parseFloat($('#amt_post_credit_amt').val()) || 0;
                        var total_receipt_amt = parseFloat($('#total_receipt_amt').val()) || 0;
                        var gst_total = (gst_percent * final_room_rent) / 100;
                       $('#gst_total').val(gst_total.toFixed(2));

                        var bill_amount = final_room_rent + total_food_amt + gst_total + add_other -
                            less_discount;
                        $('#bill_amount').val(bill_amount.toFixed(2));

                        var balance_to_pay = bill_amount + total_advance;
                        $('#balance_to_pay').val(balance_to_pay.toFixed(2));

                        var balance_amt = balance_to_pay - total_receipt_amt - amt_post_credit_amt;

                        // var balance_amt = $('#balance_to_pay').val();
                        $('#balance_amt').val(balance_amt.toFixed(2));

                        // Clear the table before appending new rows
                        $('#rent_diplay tbody').empty();

                        // Append the calculated values as rows to the table
                        response.day_entries.forEach(function(entry, index) {
                            $('#rent_diplay tbody').append(
                                '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + entry.checkin_date + '</td>' +
                                '<td>' + entry.checkout_date + '</td>' +
                                '<td>' + entry.day_count + '</td>' +
                                '<td>' + entry.rent + '</td>' +
                                '<td>' + entry.total + '</td>' +
                                '</tr>'
                            );
                        });
                    }
                });
            }

            $('#recalculate').on('click', function(e) {
                e.preventDefault();
                recalculate();
            });

            $('#per_day_tariff').on('keyup', function() {
                recalculate();
            });
            $('#add_other').on('keyup', function() {
                recalculate();
            });
            $('#less_discount').on('keyup', function() {
                recalculate();
            });

            $('#total_receipt_amt').on('input', function() {
                recalculate();
            });
            $('.amount_input').on('keyup', function() {
                recalculate();
            });
            $(document).on('keyup', '.amount_input', function() {
                recalculate();
            });


            $('#amt_post_credit_amt').on('keyup', function() {
                recalculate();
            });


            // Apply the same function to multiple inputs using a class
            $('.gst_id').on('change', function() {
                recalculate();
            });

            $('[data-toggle="tooltip"]').tooltip(); 
    
    $('#tax_inclusive').click(function() {
        // Show confirmation alert
        var userConfirmed = confirm("Do you want to Calculate This Bill Tax Inclusive?");
        
        if (userConfirmed) {
            // Get values from #final_room_rent and #gst_id
            var per_day_tariff = parseFloat($('#per_day_tariff').val()) || 0;
            var gstPercent = parseFloat($('#gst_id').val()) || 0;

            // Calculate tax-inclusive value
            if (gstPercent > 0) {
                var taxInclusiveValue = per_day_tariff / (1 + (gstPercent / 100));
                var gstValue = per_day_tariff - taxInclusiveValue; // Calculate the GST value deducted

                // Update the input fields with the new values
                $('#per_day_tariff').val(taxInclusiveValue.toFixed(2));
                // $('#gst_total').val(gstValue.toFixed(2)); // Update #gst_total with the calculated GST value

                alert("Taxable Value: " + taxInclusiveValue.toFixed(2) + 
                      "\nGST /Tax  value : " + gstValue.toFixed(2));
                      recalculate();
                      $(this).addClass('disabled').css('pointer-events', 'none').css('opacity', '0.6');

            } else {
                alert("Invalid GST percentage. Please enter a valid value.");
            }
        }
    });


        });
    </script>

    {{-- check if balance_amt  value is 0 or not and if 0 then save other wise not click   --}}

    <script>
        $(document).ready(function() {



            $('#save_button').on('click', function(e) {
                var balanceAmt = parseFloat($('#balance_amt').val());

                if (balanceAmt !== 0) {
                    e.preventDefault();
                    alert('Please enter the proper balance amount. It should be 0.');
                }
            });
        });
    </script>

    <script>
        // validation for check if customer select posting account then amount is mendetory 
        $(document).ready(function() {
            $('#save_button').on('click', function(e) {
                var postingAccId = $("#posting_acc_id").val();
                var voucherPostingAmt = $("#total_receipt_amt").val();

                // Remove any previous error messages
                $(".error").remove();

                // if (postingAccId !== "") { // If an account is selected
                //     if (voucherPostingAmt === "") { // Check if the amount field is empty
                //         e.preventDefault(); // Prevent form submission
                //         $("#total_receipt_amt").after(
                //             '<span class="error" style="color:red;">Voucher Posting Amount is required </span>'
                //             );
                //     }
                // }
            });

            // Optionally, you can also clear the error message once the user starts typing in the field
            $("#total_receipt_amt").on('input', function() {
                $(".error").remove();
            });
        });
    </script>
   

   <script>
    $(document).ready(function() {
        // Trigger the AJAX request on click of #my_checkout
        $('#my_checkout').click(function() {
            // Show confirmation alert
            var userConfirmed = confirm("Do you want to create a My Checkout Bill?");

            if (userConfirmed) {
                console.log('User confirmed checkout.');
                
                // Proceed with AJAX request if the user confirms
                $.ajax({
                    url: '/My_Check_out', // The route to your My_Check_out function
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('AJAX Success: ', response);

                        // Update the input fields with the response data
                        $('#check_out_no').val(response.new_bill_no);
                        $('#voucher_no').val(response.new_voucher_no);
                        $('#bill_type').val(response.bill_type);

                        // Optional: Alert the user that the values have been updated
                        alert('My Checkout Bill generated successfully!');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', error);
                        console.log('Status: ', status);
                        console.log('Response: ', xhr.responseText);
                    }
                });
            } else {
                console.log('User cancelled checkout.');
            }
        });
    });
</script>
{{-- <script>
      $(document).ready(function () {
        $('#saveForm').on('submit', function () {
            // Disable the submit button and show loading spinner
            $('#save_button').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Please wait...');
        });
    });
    </script> --}}
    
        
    



@endsection
