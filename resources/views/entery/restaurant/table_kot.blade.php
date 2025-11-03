<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <style>
        #display_rate {
            color: black;

            background-color: yellow;
            font-size: 20px;
        }

        .custom-row {
            margin-right: -1px;
            margin-left: -1px;
        }

        .custom-row>[class*='col-'] {
            padding-right: 1px;
            padding-left: 1px;
        }
    </style>

    <script>
        $(document).ready(function() {
            let table = new DataTable('#remindtable');

        });
    </script>

    <div class="container ">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger ">
                {{ session('error') }}
            </div>
        @endif


        <div class="card my-3">
            <div class="card-header">
                ADD KOT
            </div>
            <div class="row my-2">
                <div class="col-md-12 text-center">
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#myModal">
                    Add New KOT
                </button> --}}
                    <a href="{{ url('temp_item_delete/' . Auth::user()->id) }}" class="btn btn-success">Add New</a>
                    <a href="{{ url('store_toKot/' . Auth::user()->id). '/' . $new_voucher_no }}" class="btn btn-primary">Save</a>
                    <a href="{{ url('store_and_print/' . Auth::user()->id) . '/' . $new_voucher_no }}"
                        class="btn btn-dark">Save & Print</a>

                </div>
            </div>
            <ul id="save_form_errorlist"></ul>
            <form id="item_entry">
                <div class="row my-2" name="kot_header">
                    {{-- hidden input--}}
                        <input type="hidden" class="form-control" name="user_id" id="user_id" readonly
                            value =  "{{ Auth::user()->id }}">
                            <input type="hidden" class="form-control" name="user_name" id="user_name" readonly
                            value =  "{{ Auth::user()->name }}">
                            <input type="hidden" class="form-control" id="voucher_no" name="voucher_no"
                            value={{ $new_voucher_no }}>
                            <input type="hidden" class="form-control" id="voucher_type" name="voucher_type" value="RKot">
                    {{-- hidden input close  --}}

                    <div class="col-md-2 col-4  text-center">
                        <label for="voucher_date">Date</label>
                        <input type="text" class="form-control date" id ="voucher_date" name="voucher_date">
                        <input class="form-control" id="checkin_time" type="time"
                        name="checkin_time" value="{{ date('Y-m-d') }}" />
                    </div>


                    <div class="col-md-2 col-4  text-center">
                        <label for="kot_no">KOT No</label>
                        <input type="text" class="form-control" id ="kot_no"name="kot_no" value="{{ $new_bill_no }}">
                    </div>
                    {{-- <div class="col-md-2 col-4  text-center">
                        <label for="waiter_name">Waiter Name</label>
                        <input type="text" id="waiter_name" class="form-control" name="waiter_name" value="sandeep">
                    </div> --}}
                    <div class="col-md-2 col-4  text-center">
                        <label for="service_type">Service Type</label>
                        <select name="service_type" id="service_type" class="form-select">

                            <option value="room_service" selected>Table Service</option>
    


                        </select>

                    </div>
                    <div class="col-md-2 col-4  text-center">
                        <label for="kot_on">Selected Table</label>
                        <select name="service_id" id="service_id" class="form-select">
                            <option  value="{{$tableid}}" >{{$table->table_name}} </option>
                            {{-- @foreach ($checkinlists as $checkinlist)
                                <option value="{{ $checkinlist->voucher_no }}">{{ $checkinlist->room_nos }} ||{{ $checkinlist->guest_name }}
                                    </option>
                            @endforeach --}}


                        </select>

                    </div>
                         <div class="col-md-2 col-4  text-center">
                        <label for="kot_remark">KOT Remark</label>
                        <input type="text" class="form-control" id ="kot_remark"name="kot_remark" >
                    </div>
                </div>
                <div class="row my-2" name="itementery">
                    <div class="col-md-3 mt-4 mx-2 ">
                        <div class="input-group">

                            <select id="item_id" name="item_id" class="js-states form-control">
                                <option disabled selected>Select Item</option>
                                @foreach ($itemdata as $record)
                                    <option value={{ $record['id'] }}>
                                        {{ $record['item_name'] }}||{{ $record['item_barcode'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger">
                            @error('cust_name_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-2  col-3   text-center">
                        <label for="qty">QTY </label>
                        <input type="text" class ="form-control " id="qty" name="qty"  autocomplete="off"  required>
                    </div>
                    <div class="col-md-2 col-3  text-center">
                        <label for="rate">Rate&nbsp;&nbsp; </label><span id="display_rate"></span>
                        <input type="text" class ="form-control " id ="rate" name="rate" required>
                    </div>
                    <div class="col-md-2 col-3  text-center">
                        <label for="amount">amount </label>
                        <input type="text" class ="form-control " id="amount" name="amount" required readonly>
                    </div>
                    <div class="col-md-2  col-3  text-center">

                        <button type="submit" name="additem" id ="additem"class="btn btn-success mt-4">+</button>

                    </div>
                </div>


            </form>

            <div class="row my-2 mx-2">
                <table id ="sold_item_record"class="table table-striped  table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <td>S.No</td>
                            <td>Item Name</td>
                            <td>Qty</td>
                            <td>Rate</td>
                            <td>Amount</td>
                            <td></td>
                            <td></td>
                        </tr>

                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td>Total </td>
                            <td id="total_records"></td>
                            <td id="total_qty"></td>
                            <td></td>
                            <td id="total_amount"></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tfoot>

                </table>

            </div>



            <div class="container mt-5">



            </div>


            <script>
                $('#myModal').on('shown.bs.modal', function() {
                    $('#myModal').trigger('focus');
                });
            </script>




            
        </div>
    </div>



    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#item_id").select2({
            placeholder: "Select Item",
            allowClear: true
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>


    {{-- Ajex for getting item rate  --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#item_id').change(function() {
                var item_id = $(this).val();

                console.log(item_id);


                $.ajax({
                    url: '/searchitem/' + item_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);



                        if (response.item_info) {
                            $('#rate').val(response.item_info.sale_rate);
                            $('#display_rate').text(response.item_info.sale_rate);
                        } else {
                            $('#rate').val('');
                        }



                    }


                });

            });
        });
    </script>
    {{-- script for amount  rate*amount calculation --}}
    <script>
        $(document).ready(function() {
            function amtcalulate() {
                var qty = $('#qty').val();
                var rate = $('#rate').val();
                var amount = qty * rate;
                $('#amount').val(amount);
            }
            $('#rate').on('blur', function() {
                amtcalulate();
            });
            $('#qty').on('keyup', function() {
                amtcalulate();
            });

        });
    </script>
    {{-- script for saving record  --}}
    {{-- script for saving record --}}
    {{--    this is old code -31-5-25
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#item_entry').submit(function(e) {
            //     e.preventDefault();

            function itementry() {

                var data = {
                    'item_id': $('#item_id').val(),
                    'user_name': $('#user_name').val(),
                    'item_qty': $('#qty').val(),
                    'item_rate': $('#rate').val(),
                    'item_amount': $('#amount').val(),
                    'user_id': $('#user_id').val(),
                    'voucher_date': $('#voucher_date').val(),
                    'voucher_no': $('#voucher_no').val(),
                    'voucher_type': $('#voucher_type').val(),
                    'kot_no': $('#kot_no').val(),
                    'waiter_name': $('#waiter_name').val(),
                    'service_type': $('#service_type').val(),
                    'service_id': $('#service_id').val(),
                    'kot_remark': $('#kot_remark').val(),
                    'checkin_time':$('#checkin_time').val(),
                };
                console.log("Data being sent:", data);
                $("#additem").prop("disabled", true);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/kots', // Adjust the URL as per your Laravel routes
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        console.log("Success:", response);
                        if (response.status === 200) {
                            $('#item_id').val('');
                            $('#qty').val('');
                            $('#rate').val('');
                            $('#amount').val('');
                            $('#item_id').focus();
                            $("#additem").prop("disabled", false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Status:", status);
                        console.error("Error:", error);
                        console.error("Response Text:", xhr.responseText);
                        console.error("Ready State:", xhr.readyState);
                        console.error("Status Text:", xhr.statusText);
                    }
                });

            }

            $('#item_entry').submit(function(e) {
                e.preventDefault();
                itementry();
            });


        });
    </script> --}}
<script type="text/javascript">
    $(document).ready(function () {
        let isSubmitting = false;

        function showSavingMessage() {
            $("#additem").text("Saving...").prop("disabled", true);
        }

        function resetButton() {
            $("#additem").text("+").prop("disabled", false);
        }

        function fetchAndDisplayRecords(user_id) {
            $.ajax({
                url: '/facthitem_records/' + user_id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 200) {
                        let itemRecords = response.itemrecords;
                        let totalQty = 0;
                        let totalAmount = 0;

                        $('#sold_item_record tbody').empty();

                        itemRecords.forEach((record, index) => {
                            let amount = record.qty * record.rate;
                            totalQty += record.qty;
                            totalAmount += amount;

                            $('#sold_item_record tbody').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${record.item_name}</td>
                                    <td>${record.qty}</td>
                                    <td>${record.rate}</td>
                                    <td>${amount}</td>
                                    <td>
                                        <span class="btn btn-danger btn-sm" id="deletetemp_${record.id}">
                                            X
                                            <input type="hidden" id="record_no${record.id}" value="${record.id}">
                                        </span>
                                    </td>
                                </tr>
                            `);
                        });

                        $('#total_records').text(itemRecords.length);
                        $('#total_qty').text(totalQty);
                        $('#total_amount').text(totalAmount);
                    } else {
                        alert('Failed to fetch records');
                    }
                },
                error: function () {
                    alert('Error fetching records');
                }
            });
        }

        function itementry() {
            if (isSubmitting) return;
            isSubmitting = true;
            showSavingMessage();

            const data = {
                'item_id': $('#item_id').val(),
                'user_name': $('#user_name').val(),
                'item_qty': $('#qty').val(),
                'item_rate': $('#rate').val(),
                'item_amount': $('#amount').val(),
                'user_id': $('#user_id').val(),
                'voucher_date': $('#voucher_date').val(),
                'voucher_no': $('#voucher_no').val(),
                'voucher_type': $('#voucher_type').val(),
                'kot_no': $('#kot_no').val(),
                'waiter_name': $('#waiter_name').val(),
                'service_type': $('#service_type').val(),
                'service_id': $('#service_id').val(),
                'kot_remark': $('#kot_remark').val(),
                'checkin_time': $('#checkin_time').val()
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let fallbackTimeout = setTimeout(() => {
                alert("The request is taking longer than expected. Please wait or try again.");
                resetButton();
                isSubmitting = false;
            }, 10000);

            $.ajax({
                url: '/kots',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    clearTimeout(fallbackTimeout);

                    if (response.status === 200) {
                        $('#item_id, #qty, #rate, #amount').val('');
                        $('#item_id').focus();
                        const user_id = $('#user_id').val();
                        if (user_id) {
                            fetchAndDisplayRecords(user_id);
                        }
                    } else {
                        alert("Something went wrong: " + response.message);
                    }

                    resetButton();
                    isSubmitting = false;
                },
                error: function (xhr, status, error) {
                    clearTimeout(fallbackTimeout);
                    console.error("Error:", error);
                    alert("An error occurred while saving. Please try again.");
                    resetButton();
                    isSubmitting = false;
                }
            });
        }

        // Submit form
        $('#item_entry').submit(function (e) {
            e.preventDefault();
            itementry();
        });

        // Delete temporary record
        $(document).on('click', 'span.btn-danger', function () {
            const recordId = $(this).find('input[type="hidden"]').val();
            $.ajax({
                url: '/delete_kot_temprecord/' + recordId,
                type: 'GET',
                dataType: 'json',
                success: function () {
                    const user_id = $('#user_id').val();
                    if (user_id) {
                        fetchAndDisplayRecords(user_id);
                    }
                }
            });
        });

        // Initial load
        const initialUserId = $("#user_id").val();
        if (initialUserId) {
            fetchAndDisplayRecords(initialUserId);
        }

        // Extra bindings to trigger fetch on specific events
        function bindFetchEvents(selector) {
            $(selector).on('keypress blur', function (e) {
                if (e.type === 'keypress' && e.which !== 13) return;
                const user_id = $("#user_id").val();
                if (user_id) {
                    fetchAndDisplayRecords(user_id);
                }
            });
        }

        bindFetchEvents('#item_id, #qty, #rate');

        // Observer to watch when add button gets enabled again
        const observer = new MutationObserver(() => {
            if (!$('#additem').prop('disabled')) {
                const user_id = $("#user_id").val();
                if (user_id) {
                    fetchAndDisplayRecords(user_id);
                }
            }
        });

        observer.observe(document.getElementById('additem'), {
            attributes: true,
            attributeFilter: ['disabled']
        });

        console.log("Script initialized");
    });
</script>

    {{-- <script>
        $(document).ready(function() {
            $('#item_delete').submit(function(e) {
                e.preventDefault();
                console.log("ready to delete ");
            });

           
        });
    </script> --}}
@endsection
