<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <!-- Add these in your <head> or layout -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<style>
    /* ============================================
   GLOBAL PAGE RESPONSIVENESS
============================================ */
.container-fluid {
    padding-left: 12px !important;
    padding-right: 12px !important;
}

.card {
    border-radius: 10px;
}

/* ============================================
   MODAL RESPONSIVENESS
============================================ */
.modal-dialog {
    max-width: 700px;
}

@media (max-width: 768px) {
    .modal-dialog {
        max-width: 95% !important;
        margin: 10px auto;
    }
    .modal-body .col-md-6,
    .modal-body .col-md-12 {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
}

/* Form fields inside modal */
.modal-body label {
    font-weight: 600;
    font-size: 14px;
}

.modal-body input,
.modal-body select {
    font-size: 14px;
    padding: 8px 10px;
}

/* ============================================
   TABLE RESPONSIVENESS
============================================ */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

table th {
    white-space: nowrap;
}

table td {
    vertical-align: middle;
}

/* Smaller font on mobile */
@media (max-width: 768px) {
    table td,
    table th {
        font-size: 13px;
        padding: 6px;
    }
}

/* Action buttons spacing */
.table .btn {
    padding: 3px 6px;
}

/* ============================================
   BUTTON & UI OPTIMIZATIONS
============================================ */
.btn {
    border-radius: 6px !important;
}

.btn-primary {
    font-size: 15px;
}

/* Disable button animation on save */
#saveButton[disabled] {
    opacity: 0.8;
}

/* ============================================
   SELECT2 FIX IN MODAL
============================================ */
.select2-container {
    width: 100% !important;
}

.select2-selection {
    min-height: 38px !important;
    padding-top: 3px !important;
}

/* For mobile: dropdown inside modal */
@media (max-width: 768px) {
    .select2-container--open .select2-dropdown {
        left: 0 !important;
        width: 100% !important;
    }
}

</style>
    <script>
        $(document).ready(function() {
            let table = new DataTable('#remindtable');

        });
    </script>

     <div class="container-fluid px-3">
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
                ADD Reciept
            </div>
            <div class="row my-2">
                <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#myModal">
                        Add New Reciept
                    </button>
                </div>
            </div>



            <div class="container mt-2">


                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Reciept</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="saveForm" action="{{ url('/reciept_store') }}" method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="transaction_type">Voucher Name </label>
                                        <input type="text" value={{ $voucher_type->voucher_type_name }}
                                            class ="form-control" name="transaction_type" readonly>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="reciept_no">Reciept No </label>
                                        <input type="text" value={{ $new_bill_no }} class ="form-control"
                                            name="reciept_no">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="voucher_number">Voucher No </label>
                                        <input type="text" value={{ $new_voucher_no }} class ="form-control"
                                            name="voucher_no">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="entry_date">Date </label>
                                        <input type="text" class ="form-control date" name="entry_date" @cannot('Change_Date&Time')readonly data-restrict="true"  @endcannot>

                                    </div>
                                    <div class="col-md-12">
                                        <label for="payment_mode_id">Payment Mode </label>
                                        <select id="payment_mode_id" name="payment_mode_id"
                                            class="form-control myitemgroup form-select">
                                            <option value="" disabled selected>Select Paymnt Mode</option>
                                            @foreach ($paymentmodes as $paymentmode)
                                                <option value="{{ $paymentmode->id }}">{{ $paymentmode->account_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('payment_mode_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="account_id">Account</label>
                                        <select id="account_id" name="account_id"
                                            class="form-control myitemgroup form-select">
                                            <option value="" disabled selected>Select Account</option>
                                            @foreach ($account_names as $record)
                                                <option value="{{ $record->id }}">{{ $record->account_name }}|| {{ $record->mobile }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('account_id')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="reciept_amount">Amount </label>
                                        <input type="text" class ="form-control " placeholder=" Amount"
                                            name="receipt_amount">
                                        <span class="text-danger">
                                            @error('receipt_amount')
                                                {{ $message }}
                                            @enderror
                                        </span>

                                    </div>
                                    <div class="col-md-12">
                                        <label for="reciept_discount">Discount </label>
                                        <input type="text" class ="form-control " placeholder=" Discount"
                                            name="receipt_discount">
                                        <span class="text-danger">
                                            @error('receipt_discount')
                                                {{ $message }}
                                            @enderror
                                        </span>

                                    </div>

                                    <div class="col-md-12">
                                        <label for="receipt_remark">Remark </label>
                                        <input type="text" class ="form-control " placeholder=" Remark"
                                            name="receipt_remark">
                                        <span class="text-danger">
                                            @error('receipt_remark')
                                                {{ $message }}
                                            @enderror
                                        </span>

                                    </div>



                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button id="saveButton" type="submit" class="btn btn-primary">Save </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                $('#myModal').on('shown.bs.modal', function() {
                    $('#myModal').trigger('focus');
                });
                $(document).ready(function() {
            $('#saveForm').on('submit', function() {
                $('#saveButton').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Please wait...');
            });
        });
            </script>




            {{-- data table start  --}}
            <div class="card-body table-scrollable">
                <table class="table table-striped" id="remindtable">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col"> Date </th>
                            <th scope="col"> Reciept No </th>
                            <th scope="col"> Payment Mode </th>
                            <th scope="col"> Account Name </th>
                            <th scope="col"> Amount</th>
                            <th scope="col"> Remark</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $r1 = 0;
                        @endphp
                        @foreach ($ledgers as $ledger)
                            <tr>

                                <th scope="row">{{ $r1 = $r1 + 1 }}</th>
                                <td>{{ $ledger->entry_date }}</td>
                                <td>{{ $ledger->reciept_no }}</td>
                                <td>{{ $ledger->payment_mode_name }}</td>
                                <td>{{ $ledger->account_name }}</td>
                                <td>{{ $ledger->amount }}</td>
                                <td>{{ $ledger->remark }}</td>




                                <td>
                                    {{-- {{ route('roomtypes.edit', $ledger['id']) }} --}}
                                    <a href="" class="btn  btn-sm"><i class="fa fa-edit"
                                            style="font-size:20px;color:SlateBlue"></i></a>
                                </td>
 <td>
                                    {{-- {{ route('roomtypes.edit', $ledger['id']) }} --}}
                                    <a href="{{url('reciepts_format',$ledger->voucher_no)}}" class="btn  btn-sm"><i class="fa fa-eye"
                                            style="font-size:20px;color:SlateBlue"></i></a>
                                </td>

                                <td>
                                    <form action="{{ route('ledgers.destroy', $ledger->voucher_no) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn  btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this Reciept?')"><i
                                                class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <!-- Bootstrap 5 JS Bundle (with Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>
    <script>
        $(document).ready(function() {
             
            // Disable datepicker interaction if permission is restricted
            $('[data-restrict="true"]').datepicker('destroy'); // Prevent calendar from appearing
        });
    </script>
<script>
    $(document).ready(function () {
        let isSelect2Initialized = false;

        $('#myModal').on('shown.bs.modal', function () {
            if (!isSelect2Initialized) {
                $('#account_id, #payment_mode_id').select2({
                    dropdownParent: $('#myModal'),
                    width: '100%',
                    placeholder: "Select option"
                });
                isSelect2Initialized = true;
            }
        });
    });
</script>


@endsection

