@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')



<div class="container">
    <div class="card my-1">
        <div class="card-header">
            Add Account
        </div>
        <div class="card-body form-group">
            <form action="{{ url('/create') }}" method="POST">
                @csrf

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


                    <div class="form-floating mb-3 mb-md-0">


                        <select name="account_group_id"
                            Id ="account_group_id"class="form-select"
                            aria-label="Default select example">
                            <option selected disabled>Select Account Group </option>
                            @foreach ($accountgroups as $accountgroup)
                            <option value="{{$accountgroup->id}}">{{$accountgroup->account_group_name}}</option>  
                            @endforeach
                        </select>
                        <label for="account_group_id">Account Group </label>

                        <span class="text-danger">
                            @error('account_group_id')
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


                        <select name="balnce_type" Id ="balnce_type"class="form-select"
                            aria-label="Default select example">
                            <option selected disabled>Select</option>

                            <option value="Dr">Dr</option>
                            <option value="Cr">Cr</option>

                        </select>
                        <label for="balnce_type">Balance_type </label>

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
            <span id="part_b" class="btn btn-dark btn-sm">Show Part B</span>            
            <div id="detail_b" class="row">
                <div class="col-md-4">
                    <label for="">Input</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Input</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Input</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <span id="part_c" class="btn btn-dark btn-sm">Show Part C </span>
            <div id="detail_c" class="row">
                <div class="col-md-4">
                    <label for="">Input</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Input</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Input</label>
                    <input type="text" class="form-control">
                </div>
            </div>

            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button
                        type="submit"class="btn btn-primary btn-block">Save</button>
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

@endsection
