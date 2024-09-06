@extends('layouts.blank')

@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

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
                                                    <input type="text" id="account_name" name="account_name" value="" placeholder="Search Account Name" autocomplete="off">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add New Customer</button>
                                                    <input type="text" id="account_id" name="account_id" value="" autocomplete="off">
                                                </div>
                                                <span class="text-danger">
                                                    @error('cust_name_id')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" id="product_name" name="product_name" value="" placeholder="Search Product" autocomplete="off">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal2"> Add New Product</button>
                                                    <input type="text" id="product_id" name="product_id" value="" autocomplete="off">
                                                </div>
                                                <span class="text-danger">
                                                    @error('cust_name_id')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-md-6">
                                                <select id="search_results" size="5" class="select-hide form-control"></select>
                                            </div>
     

                                        </div>

                                        
                                        
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a class="btn btn-dark" href="{{ url('amclist') }}">Back</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-2">
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="create_account" method="POST">
                                    @csrf
                                    <div id="main_detail" class="row mb-3">
                                        <div class="col-md-8">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="account_name_modal" type="text" name="account_name" value="{{ old('account_name') }}" />
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
                                                <select name="account_group" id="account_group" class="form-select" aria-label="Default select example">
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
                                                <input class="form-control" id="op_balnce" type="text" name="op_balnce" value="{{ old('op_balnce') }}" />
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
                                                <select name="balnce_type" id="balnce_type" class="form-select" aria-label="Default select example">
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
                                                <input class="form-control" id="address" type="text" name="address" value="{{ old('address') }}" />
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
                                                <input class="form-control" id="city" type="text" name="city" value="{{ old('city') }}" />
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
                                                <input class="form-control" id="phone" type="text" name="phone" value="{{ old('phone') }}" />
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
                                                <input class="form-control" id="mobile" type="text" name="mobile" value="{{ old('mobile') }}" />
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
                                                <input class="form-control" id="email" type="text" name="email" value="{{ old('email') }}" />
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
                                                <input class="form-control" id="person_name" type="text" name="person_name" value="{{ old('person_name') }}" />
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
                                                <input class="form-control" id="gst_no" type="text" name="gst_no" value="{{ old('gst_no') }}" />
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
                                                <input class="form-control" id="state" type="text" name="state" value="{{ old('state') }}" />
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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


<style>
    .select-hide {
        display: none;
    }
    .selected {
        background-color: blue;
        color: white; /* Ensures the text is readable on a blue background */
    }
    #search_results {
        max-height: 100px; /* Adjust as needed */
        overflow-y: auto;
        width: 30%;
        position: absolute;
        z-index: 1000;
        background-color: white;
        margin-top: 1px;
        border: 1px solid #ddd;
    }
    #search_results option {
        padding: 5px;
        cursor: pointer;
    }
    #search_results option:hover {
        background-color: #f1f1f1;
    }
</style>

<script>
    $(document).ready(function() {
        let selectedIndex = -1;
        let results = [];

        $("#account_name").on('keyup', function(e) {
            var value = $(this).val();

            if (value === '') {
                $("#account_id").val('');
                $("#search_results").addClass('select-hide');
                selectedIndex = -1;
                return;
            } else {
                $("#search_results").removeClass('select-hide');
            }

            if (e.key === "ArrowDown" || e.key === "ArrowUp") {
                if (e.key === "ArrowDown") {
                    selectedIndex = (selectedIndex + 1) % results.length;
                } else if (e.key === "ArrowUp") {
                    selectedIndex = (selectedIndex - 1 + results.length) % results.length;
                }
                $("#search_results").children().removeClass('selected');
                $("#search_results").children().eq(selectedIndex).addClass('selected');
                // Scroll the selected item into view
                $("#search_results").children().eq(selectedIndex)[0].scrollIntoView({
                    behavior: "smooth",
                    block: "nearest"
                });
                return;
            }

            $.ajax({
                type: "GET",
                url: "{{ URL('/searchAccount') }}", // Update this URL to your route
                data: {'account_name': value},
                success: function(data) {
                    results = data.results;
                    var html = '';

                    results.forEach(function(result, index) {
                        html += '<option value="' + result.id + '">' + result.account_name + '</option>';
                    });

                    $("#search_results").html(html);

                    // if (results.length === 1) {
                    //     $("#account_name").val(results[0].account_name);
                    //     $("#account_id").val(results[0].id);
                    // }

                    selectedIndex = -1;
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        $("#search_results").on('change', function() {
            var selectedId = $(this).val();
            var selectedName = $("#search_results option:selected").text();
            $("#account_name").val(selectedName);
            $("#account_id").val(selectedId);
            $("#search_results").addClass('select-hide');
        });

        // Hide search results when moving the cursor away from the account_name input
        $('#account_name').on('blur', function() {
            setTimeout(function() {
                $('#search_results').addClass('select-hide');
            }, 200); // Delay to allow selecting from the dropdown
        });

        // Ensure the search results stay visible when interacting with the dropdown
        $('#search_results').on('focus', function() {
            $('#search_results').removeClass('select-hide');
        });

        $(document).click(function(event) {
            if (!$(event.target).closest('#account_name, #search_results').length) {
                $("#search_results").addClass('select-hide');
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === "Enter" && !$("#search_results").hasClass('select-hide') && selectedIndex > -1) {
                e.preventDefault();
                $("#account_name").val($("#search_results option").eq(selectedIndex).text());
                $("#account_id").val($("#search_results option").eq(selectedIndex).val());
                $("#search_results").addClass('select-hide');
                selectedIndex = -1;
            }
        });

        $("#account_name").on('focus', function() {
            if (results.length > 0) {
                $("#search_results").removeClass('select-hide');
            }
        });

        // Handle mouse click on options
        $("#search_results").on('click', 'option', function() {
            var selectedName = $(this).text();
            var selectedId = $(this).val();
            $("#account_name").val(selectedName);
            $("#account_id").val(selectedId);
            $("#search_results").addClass('select-hide');
        });

        // Handle mouse hover on options
        $("#search_results").on('mouseover', 'option', function() {
            $("#search_results").children().removeClass('selected');
            $(this).addClass('selected');
            selectedIndex = $(this).index();
        });
    });
</script>





@endsection
