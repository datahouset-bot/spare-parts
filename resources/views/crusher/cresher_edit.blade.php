@extends('layouts.blank')

@section('pagecontent')
<div class="container mt-4">
    <div class="card shadow">

        <div class="card-header bg-primary text-white text-center fw-bold">
            Edit Material Challan
        </div>

        <form action="{{ route('crusher.update', $crusher->id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row g-3">

                    {{-- SLIP --}}
                    <div class="col-md-4">
                        <label>Slip No</label>
                        <input class="form-control"
                               value="{{ $crusher->slip_no }}" readonly>
                    </div>

                    {{-- DATE --}}
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control"
                               value="{{ $crusher->date }}">
                    </div>

                    {{-- TIME --}}
                    <div class="col-md-4">
                        <label>Time</label>
                        <input type="time" name="time" class="form-control"
                               value="{{ $crusher->time }}">
                    </div>

                    {{-- ACCOUNT --}}
                    {{-- <div class="col-md-4">
                        <label>Account</label>
                        <select name="acc_id" class="form-select">
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}"
                                    {{ $crusher->acc_id == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->account_name }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- PARTY --}}
                    <div class="col-md-4">
                        <label>Party Name</label>
                        <input type="text" name="party_name"
                               class="form-control"
                               value="{{ $crusher->party_name }}">
                    </div>

                    {{-- VEHICLE --}}
                    <div class="col-md-4">
                        <label>Vehicle No</label>
                        <input type="text" name="vehicle_no"
                               class="form-control"
                               value="{{ $crusher->vehicle_no }}">
                    </div>

                    <div class="col-md-4">
                        <label>Vehicle Measure</label>
                        <input type="text" name="vehicle_measure"
                               class="form-control"
                               value="{{ $crusher->vehicle_measure }}">
                    </div>

                    {{-- MATERIAL --}}
                    <div class="col-md-4">
                        <label>Material</label>
                        <input type="text" name="Material"
                               class="form-control"
                               value="{{ $crusher->Material }}">
                    </div>

                    <div class="col-md-4">
                        <label>Material Remark</label>
                        <input type="text" name="Materialremark"
                               class="form-control"
                               value="{{ $crusher->Materialremark }}">
                    </div>

                    {{-- UNIT --}}
                    <div class="col-md-4">
                        <label>Unit</label>
                        <select name="unit" class="form-select">
                            <option value="Feet" {{ $crusher->unit == 'Feet' ? 'selected' : '' }}>Feet</option>
                            <option value="Ton" {{ $crusher->unit == 'Ton' ? 'selected' : '' }}>Ton</option>
                        </select>
                    </div>
<div class="col-md-4">
    <label>Payment Type</label>
    <select name="payment_type" class="form-select">
        <option value="">-- Select --</option>
        <option value="Cash" {{ $crusher->af6 == 'Cash' ? 'selected' : '' }}>
            Cash
        </option>
        <option value="Credit" {{ $crusher->af6 == 'Credit' ? 'selected' : '' }}>
            Credit
        </option>
    </select>
</div>

                    {{-- QUANTITY --}}
                    <div class="col-md-4">
                        <label>Quantity</label>
                        <input type="number" step="0.01"
                               id="Quantity"
                               name="Quantity"
                               class="form-control"
                               value="{{ $crusher->Quantity }}">
                    </div>

                    {{-- RATE --}}
                    <div class="col-md-4">
                        <label>Rate</label>
                        <input type="number" step="0.01"
                               id="Rate"
                               name="Rate"
                               class="form-control"
                               value="{{ $crusher->Rate }}">
                    </div>

                    {{-- ROYALTY --}}
                    <div class="col-md-4">
                        <label>Royalty Quantity</label>
                        <input type="number" step="0.01"
                               id="Royalty_Quantity"
                               name="Royalty_Quantity"
                               class="form-control"
                               value="{{ $crusher->Royalty_Quantity }}">
                    </div>

                    <div class="col-md-4">
                        <label>Royalty Rate</label>
                        <input type="number" step="0.01"
                               id="Royalty_Rate"
                               name="Royalty_Rate"
                               class="form-control"
                               value="{{ $crusher->Royalty_Rate }}">
                    </div>

                    <div class="col-md-4">
                        <label>Royalty</label>
                        <input type="number" step="0.01"
                               id="Royalty"
                               name="Royalty"
                               class="form-control"
                               value="{{ $crusher->Royalty }}">
                    </div>

                    {{-- TOTAL --}}
                    <div class="col-md-4">
                        <label>Total</label>
                        <input type="text"
                               id="Total"
                               name="Total"
                               class="form-control"
                               value="{{ $crusher->Total }}"
                               readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Grand total</label>
                        <input type="text"
                               id="grand_total"
                               name="grand_total"
                               class="form-control"
                               value="{{ $crusher->af8 }}"
                               readonly>
                    </div>
                    {{-- ====rst============ --}}
                        <div class="col-md-4">
                        <label>RST</label>
                        <input type="text" name="rst" 
                               class="form-control"
                               value="{{ $crusher->af7 }}">
                    </div>
                    {{-- CONTACT --}}
                    <div class="col-md-4">
                        <label>Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ $crusher->phone }}">
                    </div>

                    <div class="col-md-4">
                        <label>Address</label>
                        <input type="text" name="address"
                               class="form-control"
                               value="{{ $crusher->address }}">
                    </div>
<div class="col-md-4">
    <label>Loader Operator</label>
    <input type="text" name="loader"
           class="form-control"
           value="{{ $crusher->af3 }}">
</div>

<div class="col-md-4">
    <label>Driver</label>
    <input type="text" name="driver"
           class="form-control"
           value="{{ $crusher->af4 }}">
</div>

<div class="col-md-4">
    <label>Crusher Supervisor</label>
    <input type="text" name="supervisor"
           class="form-control"
           value="{{ $crusher->af5 }}">
</div>


                    {{-- REMARK --}}
                    <div class="col-md-12">
                        <label>Remark</label>
                        <input type="text" name="remark"
                               class="form-control"
                               value="{{ $crusher->remark }}">
                    </div>

                    {{-- IMAGE --}}
                    <div class="col-md-4">
                        <label>Image</label>
                        <input type="file" name="pic" class="form-control">

                        @if($crusher->pic)
    <img src="{{ asset('storage/app/public/account_image/'.$crusher->pic) }}"
         width="100"
         style="border-radius:8px;border:1px solid #ccc;">
@endif

                    </div>

                </div>
            </div>

            <div class="card-footer text-center">
                <button class="btn btn-success px-4">Update</button>
                <a href="{{ route('crusher.index') }}" class="btn btn-dark px-4">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

{{-- AUTO CALC --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {

    function calc() {
        let q  = parseFloat($('#Quantity').val()) || 0;
        let r  = parseFloat($('#Rate').val()) || 0;
        let rq = parseFloat($('#Royalty_Quantity').val()) || 0;
        let rr = parseFloat($('#Royalty_Rate').val()) || 0;

        let royalty = rq * rr;
        $('#Royalty').val(royalty.toFixed(2));

        let total = (q * r) + royalty;
        $('#Total').val(total.toFixed(2));
    }

    $('#Quantity,#Rate,#Royalty_Quantity,#Royalty_Rate').on('input', calc);
});
</script>

@endsection
