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

        .no-gutter,
        .form-control {
            margin: 0 !important;
            padding: 0 !important;
        }

        .footer_input {
            width: 100px;
            padding: 0px;
            margin: 0px;

        }

        td,
        th {
            margin: 0px !important;
            padding: 0px !important;
            border: 1px solid blue;
            text-align: left;
            padding-left: 10px !important;
        }

        .left-margin {
            margin-left: 30px;
        }

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


        /* input css  */

</style>

<style>
    /* This targets the actual dropdown menu */
    .select2-container--default .select2-results > .select2-results__options {
        max-width: 80vw !important; /* 80% of the viewport width */
        min-width: 300px;
        white-space: nowrap;
        background: lightcyan;
    }
    
    /* Optional: style the dropdown container */
    .wide-dropdown .select2-dropdown {
        width: 80vw !important;
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
                New Stock Issue 
                <a href="{{ url('temp_item_delete/' . Auth::user()->id) }}" class="btn btn-success">Add New</a>
                <a href="{{ url('store_to_sale/' . Auth::user()->id) }}" class="btn btn-primary">Save</a>
            </div>
            {{-- <div class="row my-2">
                <div class="col-md-12 text-center">
                    <a href="{{ url('temp_item_delete/' . Auth::user()->id) }}" class="btn btn-success">Add New</a>
                    <a href="{{ url('store_toKot/' . Auth::user()->id) }}" class="btn btn-primary">Save</a>
                

                </div>
            </div> --}}
            <ul id="save_form_errorlist"></ul>
            <form id="item_entry">
                <div class="row no-gutter" name="kot_header">
                    {{-- hidden input --}}
                    <input type="hidden" class="form-control" name="user_id" id="user_id" readonly
                        value =  "{{ Auth::user()->id }}">
                    <input type="hidden" class="form-control" name="user_name" id="user_name" readonly
                        value =  "{{ Auth::user()->name }}">
                    <input type="hidden" class="form-control" id="voucher_no" name="voucher_no"
                        value={{ $new_voucher_no }}>
                    <input type="hidden" class="form-control" id="voucher_type" name="voucher_type" value="sale">
                    {{-- <input type="hidden" class="form-control" id="total_item_dis_amt" name="total_item_dis_amt" > --}}

                    {{-- hidden input close  --}}


                    <div class="col-md-2 col-4 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control date" id="voucher_date" name="voucher_date" required>
                            <label class="floating-label" for="voucher_date">Date</label>
                        </div>
                    </div>
                    
                    <div class="col-md-1 col-4 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="entery_no" name="entery_no" value="{{ $new_voucher_no }}" required>
                            <label class="floating-label" for="entery_no">Entry No</label>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-4 text-center">
                        <div class="form-group">
                            <select id="godown_id" name="godown_id" class="form-select" required>
                                @foreach ($godowns as $godown)
                                    <option value="{{ $godown->id }}" selected>{{ $godown->godown_name }}</option>
                                @endforeach
                            </select>
                            <label class="floating-label" for="godown_id">Godown</label>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-4 text-center">
                        <div class="form-group">
                            <select name="terms" id="terms" class="form-select" required>
                                <option value="Cash" selected>Cash</option>
                                <option value="Credit">Credit</option>
                            </select>
                            <label class="floating-label" for="terms">Terms</label>
                        </div>
                       
                    </div>
                    <div class="col-md-1 col-4 text-center ">
                        <div class="form-group">
                            <input type="text" id="purchase_bill_date" class="form-control date" name="purchase_bill_date" required>
                            <label class="floating-label" for="purchase_bill_date">Bill Date</label>
                        </div>
                    </div>
                    
                    <div class="col-md-1 col-4 text-center">
                        <div class="form-group">
                            <input type="text" id="voucher_bill_no" class="form-control" name="voucher_bill_no" value="{{ $new_bill_no }}" required>
                            <label class="floating-label" for="voucher_bill_no">Bill No</label>
                        </div>
                    </div>
                    
                    <div class="col-md-3  text-center row ">
                        {{-- <div class="form-group"> --}}
                            <select name="account_id" id="account_id" class="form-select" required>
                                <option selected disabled>Select Party</option>
                                @foreach ($accountdata as $record)
                                    <option value="{{ $record->id }}">{{ $record->account_name }}</option>
                                @endforeach
                            </select>
                            {{-- <label class="floating-label" for="account_id">Account Name</label> --}}
                        {{-- </div> --}}
                    </div>
                    
                </div>
                <div class="row no-gutter" name="itementery">
                <div class="row no-gutter" name="itementery">
                    <div class="col-md-3   ">
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

                    <div class="col-md-1 col-3 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="qty" name="qty" placeholder=" " required autocomplete="off">
                            <label class="floating-label" for="qty">QTY</label>
                        </div>
                    </div>
                    <div class="col-md-2 col-3 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="rate" name="rate" placeholder=" " required>
                            <label class="floating-label" for="rate">Rate</label>
                            <span id="display_rate" style="position: absolute; right: 5px; top: -10px; font-size: 12px; color: #666;"></span>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-3 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="amount" name="amount" placeholder=" " required readonly>
                            <label class="floating-label" for="amount">Basic</label>
                        </div>
                    </div>
                
                    <div class="col-md-1 col-3 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="dis_p" name="dis_p" placeholder=" ">
                            <label class="floating-label" for="dis_p">Dis%</label>
                        </div>
                    </div>
                    
                    {{-- <div class="col-md-2 col-3 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="dis_amt" name="dis_amt" placeholder=" ">
                            <label class="floating-label" for="dis_amt">Dis Amt</label>
                        </div>
                    </div>
                     --}}
                    <div class="col-md-2 col-3 col-sm-2text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="total_item_dis_amt" name="total_item_dis_amt" placeholder=" ">
                            <label class="floating-label" for="total_item_dis_amt">Dis Amt</label>
                        </div>
                    </div>
                    
                    <div class="col-md-1 col-3 col-sm-2 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="gst_p" name="gst_p" placeholder=" " required readonly>
                            <label class="floating-label" for="gst_p">GST %</label>
                        </div>
                    </div>
                    
                    <input type="hidden" class="form-control" id="gstmaster_id" name="gstmaster_id" required readonly>
                    
                    <div class="col-md-2 col-3 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="gst_amt" name="gst_amt" placeholder=" " required readonly>
                            <label class="floating-label" for="gst_amt">GST Amt</label>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-3 text-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="net_item_amt" name="net_item_amt" placeholder=" " required readonly>
                            <label class="floating-label" for="net_item_amt">Net</label>
                        </div>
                    </div>
                    <div class="col-md-2  col-3  text-center">

                        <button type="submit" name="additem" id ="additem"class="btn btn-success ">+</button>

                    </div>
                </div>


            </form>

            <div class="row my-2 mx-2">
                <table id ="sold_item_record"class="table table-striped  table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <td>S.No</td>
                            <td width="20%">Item Name</td>
                            <td>Qty</td>
                            <td>Rate</td>
                            <td>Amount</td>
                            <td>Dis%</td>
                            <td>Dis Amt</td>
                            <td>Total Disc</td>
                            <td>Taxable</td>
                            <td>GST%</td>
                            <td>GST Amt</td>
                            <td>Net Value </td>

                            <td></td>
                            <td></td>
                        </tr>

                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td>Total </td>
                            <td ><input type="text" class="footer_input" name="total_records" id="total_records"></td>
                            <td ><input type="text" class="footer_input" name="total_qty"id="total_qty"></td>
                            <td></td>
                            <td ><input type="text" class="footer_input" name="total_amount"id="total_amount"></td>
                            <td></td>
                            <td></td>
                            <td ><input type="text" class="footer_input" name="total_bill_discount"id="total_bill_discount"></td>
                            <td><input type="text" class="footer_input"id="total_bill_taxable"name="total_bill_taxable" id="total_bill_taxable"></td>
                            <td id=""></td>
                            <td><input type="text" class="footer_input"name ="total_bill_gst"id ="total_bill_gst"></td>
                            <td><input type="text" class="footer_input"name ="total_bill_net"id ="total_bill_net"></td>
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
        $("#account_id").select2({
            placeholder: "Select Account",
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
                            $('#gst_p').val(response.item_info.gstmaster.igst);
                            $('#gstmaster_id').val(response.item_info.gstmaster.id);
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
                // Parse input values, defaulting to 0 if empty or invalid
                var qty = parseFloat($('#qty').val()) || 0;
                var rate = parseFloat($('#rate').val()) || 0;
                var dis_p = parseFloat($('#dis_p').val()) || 0;
                var dis_amt = parseFloat($('#dis_amt').val()) || 0;
                var gst_p = parseFloat($('#gst_p').val()) || 0;

                // Calculate the amount based on quantity and rate
                var amount = qty * rate;
                $('#amount').val(amount.toFixed(2)); // Optional: format to 2 decimal places

                // Calculate the discount amount from percentage and total discount amount
                var dis_amt_p = (amount * dis_p) / 100;
                var total_item_dis_amt = dis_amt + dis_amt_p;
                $('#total_item_dis_amt').val(total_item_dis_amt.toFixed(2)); // Optional: format to 2 decimal places

                // Calculate amount after discount
                var amount_after_discount = amount - total_item_dis_amt;

                // Calculate GST amount based on the amount after discount
                var gst_amt = amount_after_discount * (gst_p / 100);
                $('#gst_amt').val(gst_amt.toFixed(2)); // Optional: format to 2 decimal places

                // Calculate net item amount
                var basic_amt = amount - total_item_dis_amt;
                var net_item_amt = basic_amt + gst_amt;
                $('#net_item_amt').val(net_item_amt.toFixed(2)); // Optional: format to 2 decimal places
            }

            // Attach event listeners to input fields
            $('#rate, #qty, #dis_p, #dis_amt, #gst_p').on('keyup change input', function() {
                amtcalulate();
            });

            // No need for an event handler on #gst_amt if it's only a display field
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
             var account_id = $('#account_id').val();
  

            
            // Function to handle form submission and AJAX request
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
                    'entery_no': $('#entery_no').val(),
                    'terms': $('#terms').val(),
                    'voucher_bill_no': $('#voucher_bill_no').val(),
                    'account_id': $('#account_id').val(),
                    'purchase_bill_date': $('#purchase_bill_date').val(),
                    'dis_p': $('#dis_p').val(),
                    'dis_amt': $('#dis_amt').val(),
                    'gst_p': $('#gst_p').val(),
                    'gst_amt': $('#gst_amt').val(),
                    'net_item_amt': $('#net_item_amt').val(),
                    'total_item_dis_amt': $('#total_item_dis_amt').val(),
                    'godown_id':$('#godown_id').val(),
                    'gstmaster_id':$('#gstmaster_id').val()


                };

                $.ajax({
                    url: '/purchases', // Adjust the URL as per your Laravel routes
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log("Success:", response);
                        if (response.status === 200) {
                            // Clear form fields and reset
                            $('#item_id').val('');
                            $('#qty').val('');
                            $('#rate').val('');
                            $('#amount').val('');
                            $('#dis_p').val('');
                            $('#dis_amt').val('');
                            $('#gst_p').val('');
                            $('#gst_amt').val('');
                            $('#net_item_amt').val('');
                            $('#total_item_dis_amt').val('');
                            $('#gstmaster_id').val('');
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

            // Attach submit event handler to the form
            $('#item_entry').on('submit', function(e) {
                e.preventDefault();
                itementry();
            });
        });
    </script>


    {{-- fetching records --}}
    <script>
        $(document).ready(function() {
            function fetchAndDisplayRecords(user_id) {
                $.ajax({
                    url: '/fetchItemRecords_inventory/' + user_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        if (response.status === 200) {
                            var itemRecords = response.itemrecords;
                            var totalQty = 0;
                            var totalAmount = 0;
                            var total_bill_discount=0;
                            var total_bill_taxable=0;
                            var total_bill_gst=0;
                            var total_bill_net=0;



                            $('#sold_item_record tbody').empty(); // Clear previous records

                            itemRecords.forEach(function(record, index) {
                                var amount = record.qty * record.rate;
                                totalQty += parseFloat(record.qty);
                                totalAmount += parseFloat(amount);
                                total_bill_discount+=parseFloat(record.total_discount);
                                total_bill_taxable+=parseFloat(record.total_amount);
                                total_bill_gst += parseFloat(record.total_gst);
                                total_bill_net += parseFloat(record.item_net_value);


                                $('#sold_item_record tbody').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${record.item_name}</td>
                                    <td>${record.qty}</td>
                                    <td>${record.rate}</td>
                                    <td>${record.amount}</td>
                                    <td>${ record.dis_percent ?? 0 }</td>

                                    <td>${record.dis_amt??0}</td>
                                    <td>${record.total_discount}</td>
                                    <td>${record.total_amount}</td>
                                    <td>${record.item_gst_id}</td>
                                     <td>${record.total_gst}</td>
                                    <td>${record.item_net_value}</td>
                                     <td>
                                        <span class="btn btn-danger btn-sm delete-record" data-id="${record.id}">
                                                X
                                            </span>
                                        </td>
                                </tr>
                            `);
                            });

                            $('#total_records').val(itemRecords.length);
                            $('#total_qty').val(totalQty);
                            $('#total_amount').val(totalAmount);
                            $('#total_bill_discount').val(total_bill_discount);
                            $('#total_bill_taxable').val(total_bill_taxable);
                            $('#total_bill_gst').val(total_bill_gst);
                            $('#total_bill_net').val(total_bill_net);

                        } else {
                            alert('Failed to fetch records');
                        }
                    },
                    error: function() {
                        alert('Error fetching records');
                    }
                });
            }

            // Delete Record Handler
            $(document).on('click', '.delete-record', function () {
                var recordId = $(this).data('id');
                console.log("Deleting record:", recordId);
    
                $.ajax({
                    url: '/delete_kot_temprecord/' + recordId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        var user_id = $("#user_id").val();
                        if (user_id) {
                            fetchAndDisplayRecords(user_id);
                        }
                    },
                    error: function () {
                        alert('Error deleting record');
                    }
                });
            });
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
                var user_id = $("#user_id").val();
                console.log(user_id);
                if (user_id) {
                    fetchAndDisplayRecords(user_id);
                } else {
                    alert('User ID is required');
                }


            });

            // Fetch records on Enter key press
            $('#user_id').keyUp(function(event) {
                var user_id = $("#user_id").val();
                console.log(user_id);
                if (user_id) {
                    fetchAndDisplayRecords(user_id);
                } else {
                    alert('User ID is required');
                }




            });






            console.log("fetching record function");
        });
    </script>
    <script>
            
    </script>
@endsection
