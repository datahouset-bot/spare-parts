@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<style>
.requierdfield{
  color: red;
  font-size:x-large;
  text-align: left;
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
            <span id="part_b" class="btn btn-dark btn-sm">Show Part B</span>            
            <div id="detail_b" class="row">
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
            <span id="part_c" class="btn btn-dark btn-sm">Show Part C </span>
            <div id="detail_c" class="row">
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
