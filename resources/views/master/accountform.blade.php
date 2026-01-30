@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<style>
/* ================= GLOBAL ================= */
body {
    background: #f4f6f9;
}

.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

.card-header {
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: #fff;
    font-weight: 600;
    font-size: 16px;
    padding: 14px 20px;
}

.card-body {
    padding: 24px;
}

/* ================= FORM ================= */
.form-floating > label,
label {
    font-size: 13px;
    font-weight: 600;
    color: #555;
}

.form-control,
.form-select {
    border-radius: 8px;
    font-size: 14px;
    height: 40px;
}

.form-control:focus,
.form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.15rem rgba(78,115,223,.25);
}

/* ================= SECTIONS ================= */
.section-title {
    font-size: 14px;
    font-weight: 700;
    color: #4e73df;
    margin: 20px 0 10px;
    border-left: 4px solid #4e73df;
    padding-left: 10px;
}

/* ================= BUTTONS ================= */
.btn-primary {
    background: linear-gradient(135deg, #4e73df, #224abe);
    border: none;
    border-radius: 8px;
    font-weight: 600;
}

.btn-dark {
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 13px;
}

.btn-outline-primary {
    border-radius: 8px;
}

/* ================= REQUIRED ================= */
.requierdfield {
    color: red;
    font-size: 16px;
}

/* ================= FILE INPUT ================= */
input[type="file"] {
    height: auto;
}

/* ================= FOOTER ================= */
.card-footer {
    background: #f8f9fc;
    border-top: 1px solid #e3e6f0;
}
</style>
  


<div class="container">
    <div class="card my-1">
        <div class="card-header">
            Add Account
        </div>
        <div class="card-body form-group">
            <form action="{{ url('/create_account') }}" method="POST"enctype="multipart/form-data">
                @csrf
                @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="section-title">Basic Account Information</div>


            <div id="detail_a" class="row">
                <div class="col-md-8">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="account_name" type="text"
                            name="account_name" value="{{ old('account_name') }}" />
                        <span class="text-danger">
                            @error('account_name')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="account_name">Account Name </label>

                    </div>
                </div>

              <div class="col-md-6 mt-2">
    <div class="form-group">
        <label class="floating-label" for="account_group_id">Account Group</label>

        <div class="input-group">
            <select name="account_group_id"
                    id="account_group_id"
                    class="form-select"
                    required>
                <option value="" disabled selected>Select Account Group</option>
                @foreach ($accountgroups as $accountgroup)
                    <option value="{{ $accountgroup->id }}">
                        {{ $accountgroup->account_group_name }}
                    </option>
                @endforeach
            </select>

            <!-- ➕ ADD BUTTON -->
          <button type="button"
        class="btn btn-outline-primary"
        id="openAccountGroupModal"
        title="Add Account Group">
    <i class="fa fa-plus"></i>
</button>

        </div>

        <span class="text-danger">
            @error('account_group_id') {{ $message }} @enderror
        </span>
    </div>
</div>

                <div class="col-md-6 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="op_balnce" type="text"
                            name="op_balnce" value="{{ old('op_balnce') }}" />
                        <span class="text-danger">
                            @error('op_balnce')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="op_balnce">Opening Balance </label>
                    </div>
                </div>

                <div class="col-md-4 mt-2">


                    <div class="form-floating mb-3 mb-md-0">
                        <select name="balnce_type" Id ="balnce_type"class="form-select"
                            aria-label="Default select example">
                            <option selected disabled>Select</option>
                            <option value="Dr">Dr</option>
                            <option value="Cr">Cr</option>
                        </select>
                        <label for="balnce_type">Balance Type </label>
                        <span class="text-danger">
                            @error('balnce_type')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="address" type="text"
                            name="address" value="{{ old('address') }}" />
                        <span class="text-danger">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="address">Address</label>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="city" type="text"
                            name="city" value="{{ old('city') }}" />
                        <span class="text-danger">
                            @error('city')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="city">City</label>

                    </div>

                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="phone" type="text"
                            name="phone" value="{{ old('phone') }}" />
                        <span class="text-danger">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="phone">Phone</label>

                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="mobile" type="text"
                            name="mobile" value="{{ old('mobile') }}" />
                        <span class="text-danger">
                            @error('mobile')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="mobile">Mobile</label>

                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="emial" type="text"
                            name="email" value="{{ old('email') }}" />
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="email">Email</label>

                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="person_name" type="text"
                            name="person_name" value="{{ old('person_name') }}" />
                        <span class="text-danger">
                            @error('person_name')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="person_name">Contact Person Name </label>

                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="gst_no" type="text"
                            name="gst_no" value="{{ old('gst_no') }}" />
                        <span class="text-danger">
                            @error('gst_no')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="gst_no">GST No </label>

                    </div>

                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="state" type="text"
                            name="state" value="{{ old('state') }}" />
                        <span class="text-danger">
                            @error('state')
                                {{ $message }}
                            @enderror
                        </span>
                        <label for="state">State </label>

                    </div>

                </div>
            </div>
           <button id="part_b" type="button" class="btn btn-outline-primary btn-sm mt-3">
    + Additional Details (Part B)
</button>

            <div id="detail_b" class="row">
                
<div class="section-title">Additional Business Details</div>
                <div class="col-md-4">
                    <label for="">Root A/c</label>
                    <input type="text"  name ="account_af3"class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="">Firm / Company</label>
                    <input type="text"  name ="account_af1"class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="">Firm / Company Address </label>
                    <input type="text"  name ="account_af2"class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="">Pincode</label>
                    <input type="text" name="pincode" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Nationality</label>
                    <input type="text" name="nationality" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Address 2</label>
                    <input type="text" name="address2" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">PAN Card</label>
                    <input type="text" name="pen_card" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">ID Proof Name</label>
                    <input type="text" name="account_idproof_name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Id Proof No </label>
                    <input type="text" name="account_idproof_no" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for=""> Account Id Pic </label>
                    <input type="file" name="account_id_pic" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Account Pic</label>
                    <input type="file" name="account_pic1" class="form-control">
                </div>

            </div>
         <button id="part_c" type="button" class="btn btn-outline-primary btn-sm mt-3">
    + Other Information (Part C)
</button>

            <div id="detail_c" class="row">
                <div class="section-title">Other Information</div>

                <div class="col-md-4">
                    <label for="">Birthday</label>
                    <input type="text" name="account_birthday" class="form-control date">
                </div>
                <div class="col-md-4">
                    <label for="">Anniversary</label>
                    <input type="text" name="account_anniversary" class="form-control date">
                </div>
                <div class="col-md-4">
                    <label for="">Gst Code</label>
                    <input type="text" name="gst_code" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Account Code</label>
                    <input type="text" name ="account_code"class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Credit Days</label>
                    <input type="text" name ="account_cr_days"class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Salesman</label>
                    <input type="text" name ="account_salsman"class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Account Route</label>
                    <input type="text" name ="account_route"class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Attachment</label>
                    <input type="text"  name ="account_attachment1"class="form-control">
                </div>
            </div>

            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
    💾 Save Account
</button>


                </div>
            </div>
        </form>
        <div class="card-footer text-center py-3">
            <div class="small"><a
                    class= "btn btn-dark  "href={{ url()->previous() }}>Back</a></div>
        </div>
        </div>
    </div>
</div>
{{-- =========================================
ACCOUNT GROUP MODAL (OUTSIDE FORM)
========================================= --}}
<div class="modal fade" id="accountGroupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Account Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="accountGroupForm" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label>Account Group Name <span class="text-danger">*</span></label>
                        <input type="text" name="account_group_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Primary Group Name <span class="text-danger">*</span></label>
                     <select name="primary_group_id" class="form-select" required>
    <option value="" disabled selected>Select Primary Group</option>

    @foreach ($primarygroups as $group)
        <option value="{{ $group->id }}">
            {{ $group->primary_group_name }}
        </option>
    @endforeach
</select>

                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            💾 Save Group
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
{{-- ============================================================================================ --}}

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

<script src="{{ global_asset('/general_assets/js/form.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#detail_b,#detail_c').hide();
        $('#part_b').click(function() {
            $('#detail_c').hide();
        });
        $('#part_b').click(function() {
          $('#detail_b').show();  // Always show #detail_c
        });
        $('#part_c').click(function() {
          $('#detail_c').show();  // Always show #detail_c
        });


    });
</script>
<script>
$('#accountGroupForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('accountgroup.store.ajax') }}",
        type: "POST",
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {

            // Add new option to dropdown
            let option = new Option(
                res.account_group_name,
                res.id,
                true,
                true
            );

            $('#account_group_id').append(option).trigger('change');

            $('#accountGroupModal').modal('hide');
            $('#accountGroupForm')[0].reset();
        },
        error: function (xhr) {

    if (xhr.responseJSON?.type === 'validation') {
        alert(Object.values(xhr.responseJSON.errors).join('\n'));
    }
    else if (xhr.responseJSON?.type === 'server') {
        alert(xhr.responseJSON.message);

        if (xhr.responseJSON.debug) {
            console.error('Debug:', xhr.responseJSON.debug);
        }
    }
    else {
        alert('Unexpected error occurred.');
    }
}

    });
});
</script>
<script>
$('#openAccountGroupModal').on('click', function () {
    $('#accountGroupModal').modal('show');
});
</script>


@endsection
