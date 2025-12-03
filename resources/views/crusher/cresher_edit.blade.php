@extends('layouts.blank')

@section('pagecontent')
<div class="container mt-4">
    <div class="card shadow">

        <div class="card-header bg-primary text-white fw-bold text-center">
            Edit Material Challan
        </div>

        <form action="{{ route('crusher.update', $crusher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Slip No</label>
                        <input type="text" class="form-control"
                               value="{{ $crusher->slip_no }}" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Date</label>
                        <input type="date" class="form-control"
                               name="date"
                               value="{{ $crusher->date }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Time</label>
                        <input type="time" class="form-control"
                               name="time"
                               value="{{ $crusher->time }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Vehicle No</label>
                        <input type="text" class="form-control"
                               name="vehicle_no"
                               value="{{ $crusher->vehicle_no }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Party Name</label>
                        <input type="text" class="form-control"
                               name="party_name"
                               value="{{ $crusher->party_name }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Vehicle measure</label>
                        <input type="text" class="form-control"
                               name="vehicle_measure"
                               value="{{ $crusher->vehicle_measure }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Material</label>
                        <input type="text" class="form-control"
                               name="Material"
                               value="{{ $crusher->Material }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Quantity</label>
                        <input type="number" class="form-control"
                               id="Quantity"
                               name="Quantity"
                               value="{{ $crusher->Quantity }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Rate</label>
                        <input type="number" class="form-control"
                               id="Rate"
                               name="Rate"
                               value="{{ $crusher->Rate }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Royalty</label>
                        <input type="number" class="form-control"
                               id="Royalty"
                               name="Royalty"
                               value="{{ $crusher->Royalty }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Total</label>
                        <input type="text" class="form-control"
                               id="total"
                               name="total"
                               value="{{ $crusher->Total }}"
                               readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control"
                               name="phone"
                               value="{{ $crusher->phone }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Remark</label>
                        <input type="text" class="form-control"
                               name="remark"
                               value="{{ $crusher->remark }}">
                    </div>


                    <div class="col-md-4 mb-3">
    <label>Image</label>

    <input type="file"
           name="pic"
           class="form-control">

    {{-- ✅ SHOW OLD IMAGE --}}
    @if($crusher->pic)
        <div class="mt-2">
            <a href="{{ asset('uploads/crusher/'.$crusher->pic) }}" target="_blank">
                <img src="{{ asset('uploads/crusher/'.$crusher->pic) }}"
                     width="100"
                     style="border-radius:8px; border:1px solid #ccc;">
            </a>
        </div>
    @endif
</div>

                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-success">
                    Update
                </button>
                <a href="{{ route('crusher.index') }}" class="btn btn-dark">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

{{-- ✅ Auto Calculate Script --}}
<script>
$(document).ready(function () {

    function calculateTotal() {
        let qty = parseFloat($('#Quantity').val()) || 0;
        let rate = parseFloat($('#Rate').val()) || 0;
        let royalty = parseFloat($('#Royalty').val()) || 0;

        let total = (qty * rate) + royalty;
        $('#total').val(total.toFixed(2));
    }

    $('#Quantity, #Rate, #Royalty').on('keyup change', function () {
        calculateTotal();
    });

});
</script>
@endsection
