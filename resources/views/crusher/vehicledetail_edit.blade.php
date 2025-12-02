@extends('layouts.blank')

@section('pagecontent')
<div class="container mt-4">
    <div class="card shadow">

        <div class="card-header bg-primary text-white fw-bold text-center">
            Edit Vehicle Detail
        </div>

        <form action="{{ route('vehicledetail.update', $vehicle->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Vehicle Name</label>
                        <input type="text" name="vehicle_name"
                               class="form-control"
                               value="{{ $vehicle->vehicle_name }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Owner Name</label>
                        <input type="text" name="owner_name"
                               class="form-control"
                               value="{{ $vehicle->owner_name }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Vehicle No</label>
                        <input type="text" name="Vehicle_no"
                               class="form-control"
                               value="{{ $vehicle->Vehicle_no }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Registration Date</label>
                        <input type="date" name="Registration_date"
                               class="form-control"
                               value="{{ $vehicle->Registration_date }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Model Year</label>
                        <input type="text" name="model_year"
                               class="form-control"
                               value="{{ $vehicle->model_year }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Driver Name</label>
                        <input type="text" name="Driver_name"
                               class="form-control"
                               value="{{ $vehicle->Driver_name }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Driver Contact</label>
                        <input type="text" name="Driver_contact"
                               class="form-control"
                               value="{{ $vehicle->Driver_contact }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Driver Address</label>
                        <input type="text" name="Driver_address"
                               class="form-control"
                               value="{{ $vehicle->Driver_address }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Insurance</label>
                        <input type="text" name="Insaurance"
                               class="form-control"
                               value="{{ $vehicle->Insaurance }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>PUC</label>
                        <input type="text" name="Puc"
                               class="form-control"
                               value="{{ $vehicle->Puc }}">
                    </div>

                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-success px-4">
                    Update Vehicle
                </button>
                <a href="{{ route('vehicledetail.index') }}"
                   class="btn btn-dark px-4">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
