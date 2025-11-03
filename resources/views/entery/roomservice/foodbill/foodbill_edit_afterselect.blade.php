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
        #payment_table {
            width: 100%;
            border: 2px solid #ddd;
            font-size: 15px;
            padding: 0 !important;
            margin: 0 !important;

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

        #room_selection tr {
            border-bottom: 1px solid #ddd;
        }

        #room_selection {
            width: 100%;
            border: 2px solid #ddd;

        }

        #room_selection_box {
            background-color: rgb(242, 247, 247);

            border: 5px solid #2196F3;
            max-height: 170px;
            min-height: 170px;
            overflow: auto;
            margin-left: 30PX;

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
                Food Bill Edit 
            </div>
            <div class="row my-2">
                <div class="col-md-12 text-center">
                    <a href="{{ url('temp_item_delete/' . Auth::user()->id) }}" class="btn btn-success">Add New</a>
                   <form id="saveForm" action="{{ route('foodbills.update', $foodbill->voucher_no) }}" method="POST" style="display:inline;">
    @csrf
    @method('PUT')
                        {{-- <input  type="checkbox" name="approval" value="true" id="flexCheckDefault">
                            
                             Print Approval --}}
                        <button id="saveButton" type="submit" class="btn btn-primary">Update & Print</button>




                </div>
            </div>
            <ul id="save_form_errorlist"></ul>
            <form id="item_entry">
                <div class="row g-1 my-2  d-flex align-items-center " name="kot_header">

                    <input type="hidden" class="form-control" name="user_id" id="user_id" readonly
                        value =  "{{ Auth::user()->id }}">

                    <input type="hidden" class="form-control" name="user_name" id="user_name" readonly
                        value =  "{{ Auth::user()->name }}">
                    <div class="col-md-2 col-4  text-center">
                        <label for="voucher_date">Date</label>
                       <input type="text" class="form-control date" id="voucher_date" name="voucher_date"
       value="">
     
                    </div>

                    <div class="col-md-1 col-4 text-center" >
                        <label for="checkin_time">Time</label>
                        <input class="form-control" id="checkin_time" type="time"
                        name="checkin_time" value="{{ date('Y-m-d') }}" />
                    </div>
                    <input type="hidden" class="form-control" id="voucher_no" name="voucher_no"
                        value={{ $new_voucher_no }}>

                    <input type="hidden" class="form-control" id="voucher_type" name="voucher_type" value="Foodbill">
                    <div class="col-md-2 col-4  text-center">
                        <label for="food_bill_no">Bill No </label>
                        <input type="text" class="form-control" id ="food_bill_no"name="food_bill_no"
                            value="{{ $new_bill_no }}">
                    </div>

                    <div class="col-md-3 col-4  text-center">
                        <label for="kot_on">Select Room</label>
                        <select name="service_id" id="service_id" class="form-select">

                            @foreach ($checkinlists as $checkinlist)
                                <option selected value="{{ $checkinlist->voucher_no }}">{{ $checkinlist->guest_name }}||
                                    {{ $checkinlist->room_nos }} </option>
                            @endforeach


                        </select>

                    </div>
                    <div class="col-md-2 col-4  text-center">
                        <label for="kot_no">KOT No</label>
                        <input type="text" class="form-control" id ="kot_no"name="kot_no" value="{{ $vouchers }}">
                    </div>
                    <div class="col-md-1 col-4  text-center">
                        <label for="dis_percant">Dis %</label>
                        <input type="text" class="form-control" id ="dis_percant"name="dis_percant" autocomplete="off" value="{{$foodbill->disc_percent}}"  @cannot('Chang_Rent_Perday') readonly @endcannot>
                    </div>
                    <div class="col-md-1 col-4  text-center">
                        <label for="dis_amt_roundoff">Dis Amt</label>
                        <input type="text" class="form-control" id ="dis_amt_roundoff"name="dis_amt_roundoff" value="{{ abs($foodbill->roundoff_amt) }}"
                            autocomplete="off" >
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


                </div>
                <div class="row">

                    <div class="row my-2" name="kot_header">
                        <div class="col-md-2 col-4  text-center">
                            <label for="net_bill_amount">Amount </label>
                            <input type="text" class="form-control" id ="net_bill_amount"name="net_bill_amount"
                                value="">
                        </div>
                        <div class="col-md-2 col-4  text-center">
                            <label for="round_off">Round Off</label>
                            <input type="text" class="form-control" id ="round_off"name="round_off" value="">
                        </div>

                        <div class="col-md-2 col-4  text-center">
                            <label for="total_bill_value">Net Bill Amount </label>
                            <input type="text" class="form-control" id ="total_bill_value"name="total_bill_value"
                                value="">
                        </div>
                        <div class="col-md-2 col-4  text-center">
                            <label for="amt_in_words">Amount In Words </label>
                            <input type="text" class="form-control" id ="amt_in_words"name="amt_in_words"
                                value="">
                        </div>
                        {{-- <div class="col-md-2 col-4  text-center">
                            <label for="net_food_bill_amount">Net Bill Amount </label>
                            <input type="text" class="form-control"
                                id ="net_food_bill_amount"name="net_food_bill_amount" value=" {{$foodbill->net_food_bill_amount}}" readonly>
                        </div> --}}
                                               <div class="col-md-2 col-4  text-center">
                            <label for="net_food_bill_amount">Net Bill Amount </label>
                            <input type="text" class="form-control"
                                id ="net_food_bill_amount"name="net_food_bill_amount" value=" " readonly>
                        </div>





<div class="col-md-2">
    <label for="settle_payment">Settle to Payment</label>
    <select id="settle_payment" name="settle_payment" class="form-select">
        <option value="no">Settle To Room</option>
        <option value="yes">Settle To Payment</option>
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
                        <input type="hidden" 
                            name="payment_data[{{ $index }}][id]" 
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









                        {{-- <div class="col-md-2 col-4  text-center">
                    <label for="payment_remark">Payment Remark </label>
                    <input type="text" class="form-control" id ="payment_remark"name="payment_remark"
                        value="">
                </div>
                <div class="col-md-2 col-4  text-center">
                    <label for="food_bill_remark">Remark </label>
                    <input type="text" class="form-control" id ="food_bill_remark"name="food_bill_remark"
                        value="">
                </div> --}}






                    </div>
                    <div class="col-3">
                        <input type="hidden" name="total_item" id="total_item" value ="">
                        <input type="hidden" name="total_qty" id="total_qty" value="">

                        <input type="hidden" name="total_base_amount" id="total_base_amount" value="">
                        <input type="hidden" name="total_discount_amount" id="total_discount_amount" value="">
                        <input type="hidden" name="total_gst_amount" id="total_gst_amount" value="">
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
        $(document).ready(function() {
            function fetchAndDisplayRecords(service_id) {
                $.ajax({
                    url: '/fetchkot_foodbilledit/' + service_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        if (response.status === 200) {
                            var itemRecords = response.itemrecords;
                                                     var totalQty = 0;
                            var totalAmount = 0;
                            var itemdiscountamt = 0;
                            var itemvalue = 0;
                            var itemtaxable = 0;
                            var gstpercent = 0;
                            var itemgstamt = 0;
                            var itemnetvalue = 0;
                            var totalgstamt = 0;
                            var totalvatamt = 0;
                            var totaltax1amt=0; 
                            var totalitemtaxable = 0;
                            var totalnetvalue = 0;
                            var totalitemdiscount = 0;



                            $('#sold_item_record tbody').empty(); // Clear previous records

                            itemRecords.forEach(function(record, index) {
                                var amount = record.qty * record.rate;
                                totalQty += parseFloat(record.qty);

                                gstpercent = record.item.gstmaster.igst;
                                vatpercent = record.item.gstmaster.vat;
                                tax1percent = record.item.gstmaster.tax1;

                                totalAmount += amount;
                                dis_percant = $('#dis_percant').val();
                                dis_amt_roundoff = $('#dis_amt_roundoff').val();
                                const excludedGroups = ['BAVRAGE', 'HARD DRINK', 'DESERT','LIQUOR'];
                                if (!excludedGroups.includes(record.item.item_group.toUpperCase())) {
    itemdiscountamt = ((record.qty * record.rate) * dis_percant) / 100;
} else {
    itemdiscountamt = 0;
}
                                totalitemdiscount += itemdiscountamt;
                                itemtaxable = amount - itemdiscountamt;
                                totalitemtaxable += itemtaxable;
                                itemgstamt = (((amount - itemdiscountamt) * gstpercent) / 100);
                                totalgstamt += itemgstamt;
                                itemvatamt=((amount - itemdiscountamt) * vatpercent) / 100  ;
                                totalvatamt +=itemvatamt;
                                itemtax1amt= ((((amount - itemdiscountamt) * vatpercent) / 100)*10)/100 ;   
                                totaltax1amt +=itemtax1amt; 

                                itemnetvalue = itemtaxable + itemgstamt +itemvatamt+itemtax1amt;
                                totalnetvalue += itemnetvalue;


                                $('#sold_item_record tbody').append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${record.item.item_name}</td>
                                        <td>${record.qty}</td>
                                        <td>${record.rate}</td>
                                        <td>${amount.toFixed(2)}</td>
                                       <td>${!excludedGroups.includes(record.item.item_group.toUpperCase()) ? dis_percant : ''}</td> 


                                        <td>${itemdiscountamt.toFixed(2)}</td>
                                        <td>${itemtaxable.toFixed(2)}</td>
                                        <td>${record.item.gstmaster.igst}</td>
                                      <td>${parseFloat(record.item.gstmaster.vat).toFixed(2)}</td>
                                      <td>${parseFloat(record.item.gstmaster.tax1).toFixed(2)}</td>

                                        <td>${itemnetvalue.toFixed(2)}</td>
                                             

                                       
                                    </tr>
                                `);
                            });

                            // $('#total_item').val(dis_amt_roundoff);
                            $('#total_item').val(itemRecords.length);
                            $('#total_qty').val(totalQty);
                            $('#total_records').text(itemRecords.length);
                            $('#total_qty1').text(totalQty);
                            $('#total_amount').text(totalAmount.toFixed(2));
                            $('#total_base_amount').val(totalAmount);

                            // $('#total_discount').text(dis_amt_roundoff.toFixed(2));
                            $('#total_discount').text(totalitemdiscount.toFixed(2));
                            $('#total_taxable').text(totalitemtaxable.toFixed(2));
                            $('#total_gstamt').text(totalgstamt.toFixed(2));
                            $('#total_gst_amount').val(totalgstamt.toFixed(2));
                            $('#total_vatamt').text(totalvatamt.toFixed(2));
                            $('#total_vat_amount').val(totalvatamt.toFixed(2));
                            $('#total_tax1amt').text(totaltax1amt.toFixed(2));
                            $('#total_tax1_amount').val(totaltax1amt.toFixed(2));


                            $('#total_netvalue').text(totalnetvalue.toFixed(2));
                            $('#net_bill_amount').val(totalnetvalue.toFixed(2));
                            var roundoff = totalnetvalue - Math.round(totalnetvalue)-dis_amt_roundoff;
                            $('#round_off').val(roundoff.toFixed(
                            2));
                             $('#net_food_bill_amount').val(Math.round(totalnetvalue -
                             dis_amt_roundoff));
                            $('#total_bill_value').val(Math.round(totalnetvalue - dis_amt_roundoff));
                            $('#total_discount_amount').val(parseFloat(totalitemdiscount));



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
            var serviceId = $("#voucher_no").val();
            if (serviceId) {
                fetchAndDisplayRecords(serviceId);
            }

            $('#dis_percant').keyup(function(event) {
                var serviceId = $("#voucher_no").val();
                console.log(serviceId);

                if (serviceId) {
                    fetchAndDisplayRecords(serviceId);
                } else {
                    alert('Service ID is required');
                }
            });


            $('#dis_amt_roundoff').keyup(function(event) {
                var serviceId = $("#voucher_no").val();
                console.log(serviceId);

                if (serviceId) {
                    fetchAndDisplayRecords(serviceId);
                } else {
                    alert('Service ID is required');
                }
            });


        });
    </script>
{{-- 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const settlePaymentSelect = document.getElementById('settle_payment');
        const roomSelectionBox = document.getElementById('room_selection_box');
        const submitButton = document.getElementById('saveButton');
        const netFoodBillAmountInput = document.getElementById('net_food_bill_amount');

        // Show or hide the room selection box based on dropdown selection
        settlePaymentSelect.addEventListener('change', function () {
            if (this.value === 'yes') {
                roomSelectionBox.style.display = 'block'; // Show the section
            } else {
                roomSelectionBox.style.display = 'none'; // Hide the section
            }
        });

        // Validate form before submission
        submitButton.addEventListener('click', function (event) {
            // Prevent form submission
            event.preventDefault();

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

                // Check if total amount equals net food bill amount
                if (!hasEntry) {
                    alert('Please enter at least one payment amount.');
                    return; // Stop submission
                }

                if (totalAmount !== netFoodBillAmount) {
                    alert('Posting amount should equal to net amount.');
                    return; // Stop submission
                }
            }

            // Submit the form
            alert('Form submitted successfully!'); // Replace this with actual form submission logic
            document.querySelector('form').submit(); // Replace with the correct form selector if needed
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const submitButton = document.getElementById('saveButton');
    const saveForm = document.getElementById('saveForm');

    submitButton.addEventListener('click', function (event) {
        // Perform validations here
        const isValid = true; // Replace with your validation logic

        if (!isValid) {
            event.preventDefault();
            alert('Please fix validation errors.');
        } else {
            saveForm.submit(); // Ensure the form submits after validation
        }
    });
});

$(document).ready(function() {
            $('#saveForm').on('submit', function() {
                // Disable the submit button and show loading spinner
                $('#saveButton').prop('disabled', true).html(
                    '<i class="fa fa-spinner fa-spin"></i> Please wait...');
            });
        });


</script> --}}
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
</script>


@endsection