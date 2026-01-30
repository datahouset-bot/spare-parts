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
/* ================= PAGE BACKGROUND ================= */
body {
    background: #f4f6f9;
}

/* ================= CARD ================= */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 10px 28px rgba(0,0,0,0.08);
}

.card-header {
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    padding: 14px 20px;
}

/* ================= ACTION BUTTON ================= */
.add-btn {
    border-radius: 30px;
    font-weight: 600;
    padding: 8px 22px;
}

/* ================= MODAL ================= */
.modal-content {
    border-radius: 14px;
    border: none;
    box-shadow: 0 10px 28px rgba(0,0,0,0.2);
}

.modal-header {
    background: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.modal-title {
    font-weight: 700;
    color: #4e73df;
}

.modal-body label {
    font-size: 13px;
    font-weight: 600;
    margin-top: 10px;
}

/* ================= FORM ================= */
.form-control,
.form-select {
    border-radius: 8px;
    font-size: 14px;
}

.form-control:focus,
.form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.15rem rgba(78,115,223,.25);
}

/* ================= SELECT + PLUS ================= */
.payment-mode-group .btn {
    border-radius: 8px;
    margin-left: 6px;
}

/* ================= TABLE ================= */
.table {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
}

.table thead th {
    background: #f1f3f9;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    color: #333;
}

.table tbody tr:hover {
    background: #f8f9fc;
}

/* ================= ACTION ICONS ================= */
.action-icon {
    font-size: 18px;
    transition: transform .2s ease, color .2s ease;
}

.action-icon:hover {
    transform: scale(1.25);
}

.icon-edit { color: #4e73df; }
.icon-view { color: #1cc88a; }
.icon-delete { color: #e74a3b; }

/* ================= DATATABLE INPUT ================= */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px;
    padding: 6px 14px;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 8px;
}

/* ================= ALERT ================= */
.alert {
    border-radius: 12px;
}
</style>

    <script>
        $(document).ready(function() {
            let table = new DataTable('#remindtable');

        });
    </script>
  
  <div class="container-fluid ">
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
            Add Payment 
        </div>
        <div class="row my-2">
            <div class="col-md-12 text-center">
              <button type="button"
        class="btn btn-primary add-btn"
        data-bs-toggle="modal"
        data-bs-target="#myModal">
    <i class="fa fa-plus"></i> Add New Payment
</button>

            </div>
        </div>



        <div class="container mt-5">


            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="saveForm" action="{{url('/payment_store')}}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <label for="transaction_type">Voucher Name </label>
                                    <input type="text" value={{$voucher_type->voucher_type_name}} class ="form-control" name="transaction_type" readonly>
                                </div>

                                <div class="col-md-12">
                                    <label for="reciept_no">Payment  No  </label>
                                    <input type="text" value={{$new_bill_no}} class ="form-control" name="reciept_no" >
                                </div>
                                <div class="col-md-12">
                                    <label for="voucher_number">Voucher No  </label>
                                    <input type="text" value={{$new_voucher_no}} class ="form-control" name="voucher_no" >
                                </div>

                                <div class="col-md-12">
                                    <label for="entry_date">Date </label>
                                    <input type="text"  class ="form-control date" name="entry_date" @cannot('Change_Date&Time')readonly data-restrict="true"  @endcannot>

                                </div>
            <div class="col-md-12">
    <label for="payment_mode_id">Payment Mode</label>

    <div class="input-group payment-mode-group">
        <select id="payment_mode_id" name="payment_mode_id"
                class="form-control myitemgroup form-select">
            <option value="" disabled selected>Select Payment Mode</option>

            @foreach ($paymentmodes as $paymentmode)
                <option value="{{ $paymentmode->id }}">
                    {{ $paymentmode->account_name }}
                </option>
            @endforeach
        </select>
 <button type="button" id="openPaymentModeModal"
                                                class="btn btn-outline-primary">
                                                <i class="fa fa-plus"></i>
                                            </button>

    </div>

    <span class="text-danger">
        @error('payment_mode_id') {{ $message }} @enderror
    </span>
</div>

                        <div class="col-md-12">
    <label for="account_id">Account</label>

    <div class="input-group payment-mode-group">
        <select id="account_id" name="account_id"
                class="form-control myitemgroup form-select">
            <option value="" disabled selected>Select Account</option>

            @foreach ($account_names as $record)
                <option value="{{ $record->id }}">
                    {{ $record->account_name }} || {{ $record->mobile }}
                </option>
            @endforeach
        </select>
 <button type="button" id="openAccountModal" class="btn btn-outline-primary">
                                                <i class="fa fa-plus"></i>
                                            </button>

    </div>

    <span class="text-danger">
        @error('account_id') {{ $message }} @enderror
    </span>
</div>
                                <div class="col-md-12">
                                    <label for="reciept_amount">Amount </label>
                                    <input type="text" class ="form-control " placeholder=" Amount"
                                        name="receipt_amount">
                                        <span class="text-danger"> 
                                            @error('receipt_amount')
                                            {{$message}}
                                             @enderror
                                        </span>

                                </div>

                                <div class="col-md-12">
                                    <label for="receipt_remark">Remark </label>
                                    <input type="text" class ="form-control " placeholder=" Remark"name="receipt_remark">
                                    <span class="text-danger"> 
                                        @error('receipt_remark')
                                        {{$message}}
                                         @enderror``
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
                        <th scope="col"> Date  </th>
                        <th scope="col"> Reciept No  </th>
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
       
                <th scope="row">{{$r1=$r1+1}}</th>
                <td>{{$ledger->entry_date}}</td>
                <td>{{$ledger->reciept_no}}</td>
                <td>{{$ledger->payment_mode_name}}</td>
                <td>{{$ledger->account_name}}</td>
                <td>{{$ledger->amount}}</td>
                <td>{{$ledger->remark}}</td>



                
              <td>
                {{-- {{ route('roomtypes.edit', $ledger['id']) }} --}}
                  <a href="" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
              </td>
              <td>
  <a href="{{url('payment_format',$ledger->voucher_no)}}" class="btn  btn-sm"><i class="fa fa-eye"
                                            style="font-size:20px;color:SlateBlue"></i></a>
                                </td>


                <td>
                    <a href="{{ url('payment_delete/'. $ledger->voucher_no) }}" onclick="return confirm('Are you sure you want to delete this Reciept?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></a>
                 
              </td>
              
              </tr>
              @endforeach
             
              
            </tbody>
          </table> 

                  {{-- ======================================Acount model ajax ================================================= --}}
             <div class="modal fade"
     id="accountModal"
     tabindex="-1"
     data-bs-backdrop="false"
     data-bs-focus="false"
     aria-hidden="true"
     style="z-index:1060">

                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Add New Account</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form id="accountForm">
                                    @csrf

                                    <div class="row">

                                        <div class="col-md-6">
                                            <label>Account Name</label>
                                            <input type="text" name="account_name" class="form-control" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Account Group</label>
                                            <select name="account_group_id" class="form-select" required>
                                                <option disabled selected>Select Group</option>
                                                @foreach ($accountgroups as $group)
                                                    <option value="{{ $group->id }}">
                                                        {{ $group->account_group_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label>Mobile</label>
                                            <input type="text" name="mobile" class="form-control">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label>GST No</label>
                                            <input type="text" name="gst_no" class="form-control">
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control"></textarea>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label>Opening Balance</label>
                                            <input type="number" step="0.01" name="op_balnce" class="form-control"
                                                value="0">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label>Balance Type</label>
                                            <select name="balnce_type" class="form-select">
                                                <option value="Dr">Dr</option>
                                                <option value="Cr">Cr</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            Save Account
                                        </button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
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

<script>
document.addEventListener('keydown', function (e) {

    // Ignore when typing inside inputs
    if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) return;

    // SHIFT + N → Open Add Payment Modal
    if (e.shiftKey && e.key.toLowerCase() === 'n') {
        e.preventDefault();

        let modalEl = document.getElementById('myModal');
        if (!modalEl) return;

        // Bootstrap 5 modal instance
        let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
});
</script>
<script>
document.getElementById('myModal')?.addEventListener('shown.bs.modal', function () {
    this.querySelector('input:not([readonly])')?.focus();
});
</script>
  {{-- //*
    ======================================================================
    Account ajax 
    ==========================================================
    //* --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $('#accountForm').on('submit', function (e) {
    e.preventDefault();

    $.post("{{ route('create_account_ajax') }}",
        $(this).serialize(),
        function (res) {

            let group = res.group_name.toLowerCase();

            // Allowed for payment mode
            let isCashOrBank =
                group.includes('cash in hand') ||
                group.includes('Bank account');

            // ACCOUNT SELECT → always add
            if (currentSource === 'account') {
                let option = new Option(res.account_name, res.id, true, true);
                $('#account_id').append(option).trigger('change');
            }

            // PAYMENT MODE SELECT → only if Cash / Bank
            if (currentSource === 'payment' && isCashOrBank) {
                let option = new Option(res.account_name, res.id, true, true);
                $('#payment_mode_id').append(option).trigger('change');
            }

            $('#accountModal').modal('hide');
            $('#accountForm')[0].reset();
        }
    ).fail(function (xhr) {
        alert(Object.values(xhr.responseJSON.errors).join('\n'));
    });
});

    </script>
   <script>
let currentTargetSelect = null;

// ACCOUNT +
$('#openAccountModal').on('click', function () {
    currentTargetSelect = '#account_id';
    currentSource = 'account';

    $('#myModal').modal('hide');
    $('#accountModal').modal('show');
});

// PAYMENT MODE +
$('#openPaymentModeModal').on('click', function () {
    currentTargetSelect = '#payment_mode_id';
    currentSource = 'payment';

    $('#myModal').modal('hide');
    $('#accountModal').modal('show');
});

</script>
<script>
$('#accountModal').on('hidden.bs.modal', function () {
    $('#myModal').modal('show');
});
</script>


    <script>
document.addEventListener('keydown', function (e) {

    // ❌ DO NOT interfere when Account or Payment modal is open
    if (
        document.getElementById('accountModal')?.classList.contains('show') ||
        document.getElementById('paymentModeModal')?.classList.contains('show')
    ) {
        return;
    }

    // Only receipt modal logic
    if (!document.getElementById('myModal')?.classList.contains('show')) return;

    if (e.key === 'Enter') {

        if (['TEXTAREA'].includes(e.target.tagName)) return;

        e.preventDefault();

    }
});
</script>



@endsection
