@extends('layouts.blank')

@section('pagecontent')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />


    <div class="container ">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif

        <div class="card my-3">
            <div class="card-header">
                Add New Amc
            </div>
            <div class="row my-2">
                <div class="col-md-12 text-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-1">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-1">AMC Entry</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ url('/amccreat') }}" method="POST" id="amcForm">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="input-group">

                                                        <select id="single" class="js-states form-control">
                                                            <option value="" disabled selected>Select Account</option>
                                                            @foreach ($accountdata as $record)
                                                                <option value={{ $record['id'] }}>
                                                                    {{ $record['account_name'] }} </option>
                                                            @endforeach

                                                        </select>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#myModal">Add New
                                                            Customer</button>
                                                        <input type="text" id="account_id" name="account_id"
                                                            value="" autocomplete="off">
                                                    </div>
                                                    <span class="text-danger">
                                                        @error('cust_name_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="product_name" name="product_name"
                                                            value="" placeholder="Search Product" autocomplete="off">
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#myModal2"> Add New
                                                            Product</button>
                                                        <input type="hidden" id="product_id" name="product_id"
                                                            value="" autocomplete="off">
                                                    </div>
                                                    <span class="text-danger">
                                                        @error('prod_name_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                                <div class="col-md-6">

                                                </div>


                                            </div>



                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a class="btn btn-dark" href="{{ url('amclist') }}">Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-2">
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="create_account" >
                                       @csrf
                                       @method('POST')
                                        <div id="main_detail" class="row mb-3">
                                            <div class="col-md-8">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="account_name_modal" type="text"
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
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select name="account_group" id="account_group" class="form-select"
                                                        aria-label="Default select example">
                                                        <option selected disabled>Select</option>
                                                        <option value="Customer">Customer</option>
                                                        <option value="Field Staff">Field Staff</option>
                                                        <option value="Expense">Expense</option>
                                                        <option value="Income">Income</option>
                                                        <option value="Supplier">Supplier</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <label for="account_group">Account Group </label>
                                                    <span class="text-danger">
                                                        @error('account_group')
                                                            {{ $message }}
                                                        @enderror
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
                                                    <label for="op_balnce">Opning Balance </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select name="balnce_type"  id="balnce_type" class="form-select"
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
                                                    <input class="form-control" id="email" type="text"
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
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        $('#myModal').on('shown.bs.modal', function() {
                            $('#myModal').trigger('focus');
                        });
                    </script>

                    <script type="text/javascript">

                        $(document).ready(function() {
                            $('#create_account').submit(function(e) {
                                e.preventDefault();
                                var formData = $(this).serialize();
                                console.log(formData);

                                $.ajax({
                                    url: '/create/',
                                    type: 'POST',
                            
                                    data: formData,
                                    success: function(response) {
                                        $('#myModal').modal('hide');
                                        $('#create_account')[0].reset();
                                    },
                                    error: function(xhr) {
                                        console.log(xhr.responseText);
                                        alert('Error adding customer. Please try again.');
                                    }
                                });
                            });
                        });
                    </script>

                    
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#single").select2({
            placeholder: "Select Account",
            allowClear: true
        });
    </script>
@endsection
