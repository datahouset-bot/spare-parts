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
        #credit_account_id {

width: 200px;

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
                Restaurant  Bill  edit 
            </div>
            <div class="row my-2">
                <div class="col-md-12 text-center">
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#myModal">
                    Add New KOT
                </button> --}}
                <a href="{{ url('temp_item_delete/' . Auth::user()->id) }}" class="btn btn-success">Add New</a>
                <form id ="saveForm" action="{{ url('table_foodbills_update') }}" method="POST" style="display:inline;">
                    @csrf
                                            <input type="checkbox" name="b2bbill" value="true" id="b2bbillcheckbox">

                        B2B Bill

                    <button id="saveButton" type="submit" class="btn btn-primary">Save & Print</button>



                </div>
            </div>
            <ul id="save_form_errorlist"></ul>
            <form id="item_entry">
                <div class="row my-2" name="kot_header">

                    <input type="hidden" class="form-control" name="user_id" id="user_id" readonly
                        value =  "{{ Auth::user()->id }}">
                    

                    <input type="hidden" class="form-control" name="user_name" id="user_name" readonly
                        value =  "{{ Auth::user()->name }}">
                        @php
    $readonly = ($only_settel == '1') ? 'readonly' : '';
@endphp

                    <div class="col-md-2 col-4  text-center">
                        <label for="voucher_date">Date</label>
                        <input type="text" class="form-control date" id ="voucher_date" name="voucher_date"  {{ $readonly }}>
                    </div>

                    <input type="hidden" class="form-control" id="voucher_no" name="voucher_no"
                        value={{ $new_voucher_no }} {{ $readonly }}>
 

                    <input type="hidden" class="form-control" id="voucher_type" name="voucher_type" value="Restaurant_food_bill">
                    <div class="col-md-2 col-4  text-center">
                        <label for="food_bill_no">Bill No </label>
                        <input type="text" class="form-control" id ="food_bill_no"name="food_bill_no"
                            value="{{ $new_bill_no }} "{{ $readonly }}>
                    </div>

                    <div class="col-md-2 col-4  text-center">
                        <label for="service_type">Service Type</label>
                        <select name="service_type" id="service_type" class="form-select">
 
                            <option selected value="table_service">Table Service</option>
 

                        </select>

                    </div>
                    <div class="col-md-2 col-4  text-center">
                        <label for="kot_on">Selected Table</label>
                        <select name="service_id" id="service_id" class="form-select">
                            <option value="{{$service_id}}">{{$service_id}}</option>




                        </select>

                    </div>
                    <div class="col-md-2 col-4  text-center">
                        <label for="kot_no">KOT No</label>
                        <input type="text" class="form-control" id ="kot_no"name="kot_no" value="{{ $foodbilldata->kot_no }} "{{ $readonly }}>
                        
                    </div>
                    <div class="col-md-1 col-4  text-center">
                        <label for="dis_percant">Dis %</label>
                        <input type="text" class="form-control" id ="dis_percant"name="dis_percant" {{ $readonly }} value="{{abs($foodbilldata->disc_percent)}} ">
                    </div>
                    <div class="col-md-1 col-4  text-center">
                        <label for="dis_amt_roundoff">Dis Amt</label>
                        <input type="text" class="form-control" id ="dis_amt_roundoff"name="dis_amt_roundoff" value="{{ $foodbilldata->foodbill_af6 }}
"
                            autocomplete="off" {{ $readonly }}>
                    </div>
      <div id="b2c-fields" class="row">
                        <div class="col-md-4 col-4 text-center">
                            <label for="customer_name">Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                autocomplete="off" {{ $readonly }}>
                        </div>
                        <div class="col-md-2 col-4 text-center">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                autocomplete="off" {{ $readonly }}>
                        </div>
                        <div class="col-md-2 col-4 text-center">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile"
                                autocomplete="off" {{ $readonly }}>
                        </div>
                        <div class="col-md-2 col-4  text-center">
                            <label for="remark">Remark</label>
                            <input type="text" class="form-control" id ="remark"name="remark" autocomplete="off" {{ $readonly }}>
                        </div>

                    </div>

                    <!-- Select box to show when checkbox is checked -->
                    <div id="b2b-select-box" class="row" style="display: none;">
                        <div class="col-md-4 col-4 text-center">

                            <select name="account_id" id="account_id" class="form-select" style="width: 100%;">
                                <option selected disabled>Select Party</option>
                                @foreach ($accountnames as $record)
                                    <option value="{{ $record->id }}">{{ $record->account_name }}
                                        ||{{ $record->mobile }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 col-4  text-center">
                            <label for="remark_b2b">Remark</label>
                            <input type="text" class="form-control" id ="remark_b2b"name="remark_b2b"
                                autocomplete="off">
                        </div>

                    </div>
                </div>








                <div class="row my-2 mx-2 table-scrollable">
                    <div class="row my-2 mx-2">
                        <table id ="sold_item_record"class="table table-striped  table-responsive">
                            <thead class="table-dark">
                                <tr>
                                    <td>S.No</td>
                                    <td>Item Name</td>
                                    <td>Qty</td>
                                    <td>Rate</td>
                                    <td>Amount</td>
                                    <td>Dis%</td>
                                    <td>Dis Amt</td>
                                    <td>Taxable</td>
                                    <td>GST%</td>
                                     <td>VAT%</td>
                                    <td>SUR%</td>
                                    <td>Value</td>


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
                                    <td id="total_qty1"></td>
                                    <td></td>
                                    <td id="total_amount"></td>
                                    <td></td>
                                    <td id="total_discount"></td>
                                    <td id="total_taxable"></td>
                                    <td id="total_gstamt"></td>
                                    <td id="total_vatamt"></td>
                                    <td id="total_tax1amt"></td>
                                    <td id="total_netvalue"></td>
                                </tr>

                            </tfoot>

                        </table>

                    </div>

                    {{-- <table id ="sold_item_record"class="table table-striped  table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <td>S.No</td>
                            <td>Item Name</td>
                            <td>Qty</td>
                            <td>Rate</td>
                            <td>Basic AMT</td>
                            <td>GST %</td>
                            <td>Total AMT</td>

                        </tr>


                    </thead>
                    {{-- <tbody>
                        @php
                            $r1 = 0;
                            $grandtotal_tax = 0;
                            $amount_toatl_before_roundoff = 0;
                            $qty_total = 0;
                            $basic_total = 0;
                            $amount = 0;

                            $round_off_amount=0;
                        @endphp
                        @foreach ($itemrecords as $record)
                            <tr>
                                <td>{{ $r1 = $r1 + 1 }}</td>
                                <td>{{ $record->item->item_name }}</td>
                                <td>{{ $record->qty }}</td>
                                <td>{{ $record->rate }}</td>

                                @php
                                        
                                     
                                    $amount = $record->qty * $record->rate;
                                    $item_gst = $record->item->gstmaster->igst;
                                    $item_amount = $amount;
                                    $item_taxamount = ($item_amount * $item_gst) / 100;
                                    $total_item_amount = $item_taxamount + $item_amount;
                                    $grandtotal_tax += $item_taxamount;
                                    $amount_toatl_before_roundoff += $total_item_amount;
                                    $qty_total += $record->qty;
                                    $basic_total += $item_amount;
                                    $net_amount = round($amount_toatl_before_roundoff, 0);
                                    $round_off_amount = round($net_amount - $amount_toatl_before_roundoff, 2);
  

                                @endphp
                                <td>{{ $amount }}</td>

                                <td>{{ $record->item->gstmaster->igst }}</td>
                                <td>{{ $total_item_amount }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td>Total </td>
                            <td>Total item={{ $r1 }} <input type="hidden" name="total_item" value ="{{ $r1 }}"></td>
                            <td>{{ $qty_total }} <input type="hidden" name="total_qty" value="{{$qty_total }}"></td>
                            <td></td>
                            <td>{{ $basic_total }} <input type="hidden" name="total_base_amount" value="{{ $basic_total }}"></td>
                            <td>{{ $grandtotal_tax }} <input type="hidden" name="total_gst_amount" value="{{ $grandtotal_tax }}"></td>
                            <td>{{ $amount_toatl_before_roundoff }}</td>
                        </tr>

                    </tfoot>

                </table> --}}

                </div>
                <div class="row">

                    <div class="row my-2" name="kot_header">
                 <div class="col-md-2 col-4  text-center">
                    <label for="net_bill_amount">Amount </label>
                    <input type="text" class="form-control" id ="net_bill_amount"name="net_bill_amount"
                        value="" {{ $readonly }}>
                </div>
                <div class="col-md-2 col-4  text-center">
                    <label for="round_off">Round Off</label>
                    <input type="text" class="form-control" id ="round_off"name="round_off"
                        value=""{{ $readonly }}>
                </div>

              
                <div class="col-md-2 col-4  text-center">
                    <label for="total_bill_value">Net Bill Amount </label>
                    <input type="text" class="form-control" id ="total_bill_value"name="total_bill_value"
                        value=""{{ $readonly }}>
                </div>


                <div class="col-md-2">
                    <label for="settle_payment">Settle to Payment</label>
                    <select id="settle_payment" name="settle_payment" class="form-select">
                        <option value="Cash">Settle To Cash</option>
                        <option value="yes">Settle To Payment</option>
                        <option value="Credit">Settle To Credit</option>
                    </select>
                </div>

                <div class="col-md-4" id="room_selection_box" style="display: none;">
                    <table id="room_selection" class="table table-striped table-responsive room_selection">
                        <thead>
                            <tr>
                                <th>Mode</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentmodes as $index => $paymentmode)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="payment_data[{{ $index }}][name]"
                                            value="{{ $paymentmode->account_name }}" readonly>
                                        <input type="hidden" name="payment_data[{{ $index }}][id]"
                                            value="{{ $paymentmode->id }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control payment-amount"
                                            name="payment_data[{{ $index }}][amount]"
                                            placeholder="Enter amount" min="0" autocomplete="off">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div id="credit_details_box" style="display: none;" class="col-md-2 col-4  text-center">





                    <select id="credit_account_id" name="credit_account_id">
                        <option value="Null"disabled selected>Select account</option>
                        @foreach ($creditaccounts as $record)
                            <option value="{{ $record->id }}">{{ $record->account_name }}</option>
                        @endforeach
                    </select>



                </div>







                <div class="col-md-2 col-4  text-center">
                    <label for="net_food_bill_amount">Amount To Post </label>
                    <input type="text" class="form-control"
                        id ="net_food_bill_amount"name="net_food_bill_amount" value=" " readonly>
                </div>
                <div class="col-md-2 col-4  text-center">
                    <label for="amt_in_words">Amount In Words </label>
                    <input type="text" class="form-control" id ="amt_in_words"name="amt_in_words"
                        value="">
                </div>
                

                <div class="col-md-2 col-4  text-center">
                    <label for="payment_remark">Payment Remark </label>
                    <input type="text" class="form-control" id ="payment_remark"name="payment_remark"
                        value="">
                </div>
                <div class="col-md-2 col-4  text-center">
                    <label for="food_bill_remark">Remark </label>
                    <input type="text" class="form-control" id ="food_bill_remark"name="food_bill_remark"
                        value="">
                </div>






                </div>
                <div class="col-3">
                    <input type="hidden" name="table_name" id="table_name" value =" {{ $table->table_name }}">
                    <input type="hidden" name="total_item" id="total_item" value ="">
                    <input type="hidden" name="total_qty" id="total_qty" value="">
                   
                    <input type="hidden" name="total_base_amount" id="total_base_amount" value="">
                    <input type="hidden" name="total_discount_amount"  id="total_discount_amount" value="">
                    <input type="hidden" name="total_gst_amount"  id="total_gst_amount" value="">
                    <input type="hidden" name="total_vat_amount" id="total_vat_amount" value="">
                    <input type="hidden" name="total_tax1_amount" id="total_tax1_amount" value="">

                </div>



            </form>


            <div class="container mt-5">



            </div>







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

    <script>
    $(document).ready(function () {
        $('#b2bbillcheckbox').change(function () {
            if ($(this).is(':checked')) {
                $('#b2c-fields').hide();
                $('#b2b-select-box').show();
                $('#account_id').attr('required', true);
            } else {
                $('#b2c-fields').show();
                $('#b2b-select-box').hide();
                $('#account_id').removeAttr('required');
            }
        });

        // Form submit validation
        $('#saveForm').submit(function (e) {
            if ($('#b2bbillcheckbox').is(':checked')) {
                var selectedAccount = $('#account_id').val();
                if (!selectedAccount) {
                    alert('Please select Billing Account before submitting the form Please try Again  .');
                    e.preventDefault(); // Stop form submission
                    return false;
                }
            }
        });
    });
</script>



    <script>
        $(document).ready(function() {
            function fetchAndDisplayRecords(voucher_no, service_id) {
                console.log(voucher_no);
                $.ajax({
                    url: '/resta_fetchkot_edit/' + voucher_no + '/' + service_id,  
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
    
                        if (response.status === 200) {
                            var itemRecords = response.itemrecords;
                            var totalQty = 0, totalAmount = 0, totalitemdiscount = 0, totalitemtaxable = 0;
                            var totalgstamt = 0, totalnetvalue = 0;
                           var totalvatamt = 0;
                            var totaltax1amt = 0;
                            var dis_percant = parseFloat($('#dis_percant').val()) || 0;


    
                            $('#sold_item_record tbody').empty(); // Clear previous records
    
                            itemRecords.forEach(function(record, index) {
                                var amount = record.qty * record.rate;
                                totalQty += parseFloat(record.qty);
    
                                var gstpercent = parseFloat(record.item.gstmaster.igst);
                                vatpercent = record.item.gstmaster.vat;
                                tax1percent = record.item.gstmaster.tax1;
                                totalAmount += amount;
    
                                const excludedGroups = ['BAVRAGE', 'HARD DRINK', 'DESERT',
                                    'LIQUOR','NO_DISCOUNT'
                                ];

                                if (!excludedGroups.includes(record.item.item_group
                                        .toUpperCase())) {
                                    itemdiscountamt = ((record.qty * record.rate) *
                                        dis_percant) / 100;
                                } else {
                                    itemdiscountamt = 0;
                                }

                                var dis_amt_roundoff = parseFloat($('#dis_amt_roundoff').val()) || 0;

                                                                if (!excludedGroups.includes(record.item.item_group
                                        .toUpperCase())) {
                                    itemdiscountamt = ((record.qty * record.rate) *
                                        dis_percant) / 100;
                                } else {
                                    itemdiscountamt = 0;
                                }

    
                                // var itemdiscountamt = (amount * dis_percant) / 100;
                                totalitemdiscount += itemdiscountamt;
    
                                var itemtaxable = amount - itemdiscountamt;
                                totalitemtaxable += itemtaxable;
    
                                var itemgstamt = (itemtaxable * gstpercent) / 100;
                                totalgstamt += itemgstamt;
                                                                itemvatamt = ((amount - itemdiscountamt) * vatpercent) / 100;
                                totalvatamt += itemvatamt;
                                itemtax1amt = ((((amount - itemdiscountamt) * vatpercent) /
                                    100) * 10) / 100;
                                totaltax1amt += itemtax1amt;

    
                                itemnetvalue = itemtaxable + itemgstamt + itemvatamt +
                                    itemtax1amt;
                                totalnetvalue += itemnetvalue;
    
                                $('#sold_item_record tbody').append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${record.item.item_name}</td>


                                        <td>${record.qty}</td>
                                        <td>${record.rate}</td>
                                        <td>${amount}</td>
                                        <td>${!excludedGroups.includes(record.item.item_group.toUpperCase()) ? dis_percant : ''}</td> 
                                         <td>${!excludedGroups.includes(record.item.item_group.toUpperCase()) ? parseFloat(itemdiscountamt).toFixed(2) : ''}</td> 
                                         <td>${parseFloat(itemtaxable).toFixed(2)}</td>
                                        <td>${parseFloat(record.item.gstmaster.igst).toFixed(2)}</td>
                                        <td>${parseFloat(record.item.gstmaster.vat).toFixed(2)}</td>
                                        <td>${parseFloat(record.item.gstmaster.tax1).toFixed(2)}</td>


                                        <td>${parseFloat(itemnetvalue).toFixed(2)}</td>
                                    </tr>
                                `);
                            });
    
                            $('#total_item').val(itemRecords.length);
                            $('#total_qty').val(totalQty);
                            $('#total_records').text(itemRecords.length);
                            $('#total_qty1').text(totalQty);
                            $('#total_amount').text(totalAmount.toFixed(2));
                            $('#total_base_amount').val(totalAmount.toFixed(2));
                            $('#total_discount').text(totalitemdiscount.toFixed(3));
                            $('#total_taxable').text(totalitemtaxable.toFixed(2));
                            $('#total_gstamt').text(totalgstamt.toFixed(2));
                            $('#total_gst_amount').val(totalgstamt.toFixed(2));
                                                        $('#total_vatamt').text(totalvatamt.toFixed(2));
                            $('#total_vat_amount').val(totalvatamt.toFixed(2));
                            $('#total_tax1amt').text(totaltax1amt.toFixed(2));
                            $('#total_tax1_amount').val(totaltax1amt.toFixed(2));

                            $('#total_netvalue').text(totalnetvalue.toFixed(2));
                            $('#net_bill_amount').val(totalnetvalue.toFixed(2));
    
                            var dis_amt_roundoff = parseFloat($('#dis_amt_roundoff').val()) || 0; // Default to 0 if empty or NaN
var roundoff = totalnetvalue - Math.round(totalnetvalue) - dis_amt_roundoff;
$('#round_off').val(roundoff.toFixed(2));

    
                            $('#net_food_bill_amount').val(Math.round(totalnetvalue - dis_amt_roundoff));
                            $('#total_bill_value').val(Math.round(totalnetvalue - dis_amt_roundoff));
                            $('#total_discount_amount').val(totalitemdiscount.toFixed(2));
    
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
            var voucher_no = $("#voucher_no").val();
            var serviceId = $("#service_id").val();
            if (voucher_no && serviceId) {
                fetchAndDisplayRecords(voucher_no, serviceId);
            }
    
            // Event listeners for discount fields
            $('#dis_percant, #dis_amt_roundoff').keyup(function() {
                var voucher_no = $("#voucher_no").val();
                var serviceId = $("#service_id").val();
    
                if (voucher_no && serviceId) {
                    fetchAndDisplayRecords(voucher_no, serviceId);
                } else {
                    alert('Voucher No. and Service ID are required');
                }
            });

        });
    </script>
    
    {{-- <script>
  $(document).ready(function () {
        $('#saveForm').on('submit', function () {
            // Disable the submit button and show loading spinner
            $('#saveButton')
                .prop('disabled', true)
                .html('<i class="fa fa-spinner fa-spin"></i> Please wait...');
        });
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const settlePaymentSelect = document.getElementById('settle_payment');
            const roomSelectionBox = document.getElementById('room_selection_box');
            const submitButton = document.getElementById('saveButton');
            const netFoodBillAmountInput = document.getElementById('net_food_bill_amount');
            const saveForm = document.getElementById('saveForm');
    
            // Track submission state to prevent double submission
            let isSubmitting = false;
    
            // Show or hide the room selection box based on dropdown selection
            settlePaymentSelect.addEventListener('change', function () {
                if (this.value === 'yes') {
                    roomSelectionBox.style.display = 'block'; // Show the section
                } else {
                    roomSelectionBox.style.display = 'none'; // Hide the section
                }
            });
    
            // Validate and submit the form
            submitButton.addEventListener('click', function (event) {
                // Prevent form submission by default
                event.preventDefault();
    
                // Check if the form is already being submitted
                if (isSubmitting) {
                    alert('Form is already being submitted. Please wait.');
                    return;
                }
    
                // Check if settle_payment is set to "yes"
                if (settlePaymentSelect.value === 'yes') {
                    // Calculate total amount from payment data
                    const paymentAmounts = document.querySelectorAll('.payment-amount');
                    let totalAmount = 0;
                    let hasEntry = false;
    
                    paymentAmounts.forEach(input => {
                        const value = parseFloat(input.value) || 0;
                        if (value > 0) {
                            hasEntry = true; // Ensure at least one payment is entered
                        }
                        totalAmount += value;
                    });
    
                    // Get the net food bill amount
                    const netFoodBillAmount = parseFloat(netFoodBillAmountInput.value) || 0;
    
                    // Validate the payment amounts
                    if (!hasEntry) {
                        alert('Please enter at least one payment amount.');
                        return; // Stop submission
                    }
    
                    if (totalAmount !== netFoodBillAmount) {
                        alert('Posting amount should equal to net amount.');
                        return; // Stop submission
                    }
                }
    
                // Set submission flag to true and disable the submit button
                isSubmitting = true;
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Please wait...';
    
                // Submit the form
                saveForm.submit();
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            var isSubmitting = false;
    
            function toggleFields() {
                var settlePayment = $('#settle_payment').val();
                $('#room_selection_box').toggle(settlePayment === 'yes');
                $('#credit_details_box').toggle(settlePayment === 'Credit');
            }
    
            $('#settle_payment').change(function() {
                toggleFields();
                if ($(this).val() !== 'Credit') {
                    $('#credit_account_id').val('Null');
                }
            });
    
            $('#saveButton').click(function(event) {
                event.preventDefault();
    
                if (isSubmitting) {
                    alert('Form is already being submitted. Please wait.');
                    return;
                }
    
                var settlePayment = $('#settle_payment').val();
                var netFoodBillAmount = parseFloat($('#net_food_bill_amount').val()) || 0;
    
                if (settlePayment === 'Credit') {
                    var creditCustomer = $('#customer_name').val().trim();
                    var creditAmount = parseFloat($('#total_bill_value').val()) || 0;
                    var creditAccountId = $('#credit_account_id').val();
    
                    // if (!creditCustomer) {
                    //     alert('Please enter a credit customer name.');
                    //     $('#customer_name').focus();
                    //     return;
                    // }
    
                    if (!creditAccountId || creditAccountId === 'Null') {
                        alert('Please select a Credit Account.');
                        $('#credit_account_id').focus();
                        return;
                    }
    
                    if (creditAmount <= 0) {
                        alert('Credit amount should be greater than zero.');
                        return;
                    }
                } else if (settlePayment === 'yes') {
                    var totalAmount = 0,
                        hasEntry = false;
                    $('.payment-amount').each(function() {
                        var value = parseFloat($(this).val()) || 0;
                        if (value > 0) hasEntry = true;
                        totalAmount += value;
                    });
    
                    if (!hasEntry) {
                        alert('Please enter at least one payment amount.');
                        return;
                    }
    
                    if (totalAmount !== netFoodBillAmount) {
                        alert('Posting amount should equal the net amount.');
                        return;
                    }
                }
    
                isSubmitting = true;
                $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Please wait...');
                $('#saveForm').submit();
            });
    
            toggleFields();
    
            
    
            $("#credit_account_id").select2({
                placeholder: "Select Item",
                allowClear: true
            });
                        $("#account_id").select2({
                placeholder: "Select Account",
                allowClear: true


            });
    
        });
    </script>
@endsection
