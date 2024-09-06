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
             Table   Food Bill
            </div>
            <div class="row my-2">
                <div class="col-md-12 text-center">
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#myModal">
                    Add New KOT
                </button> --}}
                    <a href="{{ url('temp_item_delete/' . Auth::user()->id) }}" class="btn btn-success">Add New</a>
                    <a href="{{ url('store_toKot/' . Auth::user()->id) }}" class="btn btn-primary">Save</a>
                    <a href="{{ url('store_and_print/' . Auth::user()->id) . '/' . $new_voucher_no }}"
                        class="btn btn-dark">Save & Print</a>

                </div>
            </div>
            <ul id="save_form_errorlist"></ul>
            <form id="item_entry">
                <div class="row my-2" name="kot_header">
                    {{-- <div class="col-md-2 col-4  text-center"> --}}
                        <input type="hidden" class="form-control" name="user_id" id="user_id" readonly
                            value =  "{{ Auth::user()->id }}">
                    {{-- </div> --}}
                    {{-- <div class="col-md-2 col-4  text-center"> --}}
                        <input type="hidden" class="form-control" name="user_name" id="user_name" readonly
                            value =  "{{ Auth::user()->name }}">
                    {{-- </div> --}}
                    <div class="col-md-2 col-4  text-center">
                        <label for="voucher_date">Date</label>
                        <input type="text" class="form-control date" id ="voucher_date" name="voucher_date">
                    </div>
                    {{-- <div class="col-md-2 col-4  text-center"> --}}
                        {{-- <label for="voucher_no">Voucher No</label> --}}
                        <input type="hidden" class="form-control" id="voucher_no" name="voucher_no"
                            value={{ $new_voucher_no }}>
                    {{-- </div> --}}
                    <div class="col-md-2 col-4  text-center">
                        <label for="voucher_type">Voucher Type</label>
                        <input type="text" class="form-control" id="voucher_type" name="voucher_type" value="Kot">
                    </div>
                    <div class="col-md-2 col-4  text-center">
                        <label for="kot_no">KOT No</label>
                        <input type="text" class="form-control" id ="kot_no"name="kot_no" value="{{ $new_bill_no }}">
                    </div>
                    <div class="col-md-2 col-4  text-center">
                        <label for="waiter_name">Waiter Name</label>
                        <input type="text" id="waiter_name" class="form-control" name="waiter_name" value="sandeep">
                    </div>
                    <div class="col-md-2 col-4  text-center">
                        <label for="service_type">Service Type</label>
                        <select name="service_type" id="service_type" class="form-select">
                           
                            <option value="room_service" selected>Room Servic</option>
                            <option value="table_service">Table Service</option>
                            <option value="loundery">Loundery Service</option>


                        </select>

                    </div>
                    <div class="col-md-2 col-4  text-center">
                        <label for="kot_on">Select Table </label>
                        <select name="service_id" id="service_id" class="form-select">
                            <option value="" selected disabled>select table </option>
                             <option value="{{$tableid}}">{{$table->table_name}} </option>
                          


                        </select>

                    </div>
                </div>
                {{-- <div class="row my-2" name="itementery">
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
                        <input type="text" class ="form-control " id="qty" name="qty" required>
                    </div>
                    <div class="col-md-2 col-3  text-center">
                        <label for="rate">Rate&nbsp;&nbsp; </label><span id="display_rate"></span>
                        <input type="text" class ="form-control " id ="rate" name="rate" required>
                    </div>
                    <div class="col-md-2 col-3  text-center">
                        <label for="amount">amount </label>
                        <input type="text" class ="form-control " id="amount" name="amount" readonly>
                    </div>
                    <div class="col-md-2  col-3  text-center">

                        <button type="submit" name="additem" id ="additem"class="btn btn-success mt-4">+</button>

                    </div>
                </div> --}}


            </form>

            <div class="row my-2 mx-2">
                <table id ="sold_item_record"class="table table-striped  table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <td>S.No</td>
                            <td>Item Name</td>
                            <td>Qty</td>
                            <td>Rate</td>
                            <td>Basic AMT</td>
                            <td>GST %</td>
                            <td>Total AMT</td>
                            <td></td>
                        </tr>


                    </thead>
                    <tbody>


                    </tbody>
                    {{-- <tfoot class="table-dark">
                        <tr>
                            <td>Total </td>
                            <td id="total_records"></td>
                            <td id="total_qty"></td>
                            <td></td>
                            <td id="total_amount"></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tfoot> --}}

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
    {{-- script for amount calculation --}}
    <script>
        $(document).ready(function() {
            $('#rate').on('blur', function() {
                var qty = $('#qty').val();
                var rate = $('#rate').val();
                var amount = qty * rate;
                $('#amount').val(amount);
            });
        });
    </script>
    {{-- script for saving record  --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#item_entry').submit(function(e) {
                e.preventDefault();

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
                    'service_id': $('#service_id').val()
                };
                console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/kots/', // Adjust the URL as per your Laravel routes
                    type: 'POST',
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // $('#item_entry')[0].reset(); // rest the whole form  
                        if (response.status === 200) {
                            $('#item_id').val('');
                            $('#qty').val('');
                            $('#qty').val('');
                            $('#rate').val('');
                            $('#amount').val('');
                            $('#item_id').focus();

                        } else {
                            $('#save_form_errorlist').html("");
                            $.each(response.errors, function(key, err_values) {
                                $('#save_form_errorlist').addClass(
                                    "alert alert-danger ");
                                $('#save_form_errorlist').append('<li>' + err_values +
                                    '</li>')
                            });

                        }


                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error adding customer. Please try again.');
                        // Handle error response here if needed
                    }
                });
            });
        });
    </script>
    {{-- script faching the data --}}
    {{-- <script type="text/javascript">
        $(document).ready(function() {
        
            $('#additem').click(function() {
           var user_id = $("#user_id").val();
           console.log(user_id);


                $.ajax({
                    url: '/facthitem_records/' + user_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);





                        if (response.status === 200) {
                        var itemRecords = response.itemrecords;
                        var totalQty = 0;
                        var totalAmount = 0;

                        itemRecords.forEach(function(record, index) {
                            var amount = record.qty * record.rate;
                            totalQty += record.qty;
                            totalAmount += amount;
                            $('#total_records').text(itemRecords.length);


                            $('#sold_item_record tbody').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${record.item_name}</td>
                                    <td>${record.qty}</td>
                                    <td>${record.rate}</td>
                                    <td>${amount}</td>
                                    <td><button class="btn btn-primary btn-sm">Edit</button></td>
                                    <td><button class="btn btn-danger btn-sm">Delete</button></td>
                                </tr>
                            `);
                        });

                        $('#total_qty').text(totalQty);
                        $('#total_amount').text(totalAmount);
                    } else {
                        alert('Failed to fetch records');
                    }



                    }


                });

            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            function fetchAndDisplayRecords(user_id) {
                $.ajax({
                    url: '/facthitem_records/' + user_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        if (response.status === 200) {
                            var itemRecords = response.itemrecords;
                            var totalQty = 0;
                            var totalAmount = 0;

                            $('#sold_item_record tbody').empty(); // Clear previous records

                            itemRecords.forEach(function(record, index) {
                                var amount = record.qty * record.rate;
                                totalQty += record.qty;
                                totalAmount += amount;

                                $('#sold_item_record tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${record.item_name}</td>
                                <td>${record.qty}</td>
                                <td>${record.rate}</td>
                                <td>${amount}</td>
                                <td><button class="btn btn-primary btn-sm">Edit</button></td>
                                <td><button class="btn btn-danger btn-sm">Delete</button></td>
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
                    error: function() {
                        alert('Error fetching records');
                    }
                });
            }

            // Fetch records on page load
            var initialUserId = $("#user_id").val();
            if (initialUserId) {
                fetchAndDisplayRecords(initialUserId);
            }

            // Fetch records on button click
            $('#additem').click(function() {
                var user_id = $("#user_id").val();
                console.log(user_id);

                if (user_id) {
                    fetchAndDisplayRecords(user_id);
                } else {
                    alert('User ID is required');
                }
            });

            $('#additem').keypress(function() {
                var user_id = $("#user_id").val();
                console.log(user_id);

                if (user_id) {
                    fetchAndDisplayRecords(user_id);
                } else {
                    alert('User ID is required');
                }
            });
            $('#additem').click(function() {
                handleFetchRecords();
            });

            // Fetch records on Enter key press
            $('#user_id').keyUp(function(event) {
                // if (event.which === 13) { // Enter key pressed
                handleFetchRecords();
                // }
            });
        });
    </script>
    <script>
        document.getElementById('service_id').addEventListener('change', function() {
            var service_id = this.value;
            if (service_id) {
                window.location.href = '/table_facthkot_records/' + service_id;
            }
        });
    </script>
@endsection
