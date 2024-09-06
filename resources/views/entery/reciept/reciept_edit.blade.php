@extends('layouts.blank')

@section('pagecontent')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('general_assets/css/table.css') }}">

<div class="container">
    @if(session('message'))
        <div class="alert alert-primary">
            {{ session('message') }}
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-header">
            Update Room Type
        </div>
        <div class="card-body">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <form action="{{ route('roomtypes.update', $record2->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="roomtype_name">Room Type Name</label>
                            <input type="text" name="roomtype_name" class="form-control" placeholder="Room Type Name" value="{{ old('roomtype_name', $record2->roomtype_name) }}">
                            <span class="text-danger">
                                @error('roomtype_name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div>
                            <label for="package_id">Package</label>
                            <select name="package_id" id="package_id" class="form-select">
                                <option value="" selected disabled>Select Package</option>
                                @foreach ($record as $package)
                                    <option value="{{ $package->id }}" {{ $record2->package_id == $package->id ? 'selected' : '' }}>
                                        {{ $package->package_name }} || {{ $package->plan_name }} || {{ $package->other_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('package_id')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div>
                            <label for="gst_id">GST / TAX %</label>
                            <select name="gst_id" id="gst_id" class="form-select">
                                <option value="" selected disabled>Select GST / Tax</option>
                                @foreach ($record1 as $gst)
                                    <option value="{{ $gst->id }}" {{ $record2->gst_id == $gst->id ? 'selected' : '' }}>
                                        {{ $gst->taxname }} || {{ number_format($gst->igst, 2) }} || {{ number_format($gst->vat, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('gst_id')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div>
                            <label for="room_tariff">Room Tariff</label>
                            <input type="text" name="room_tariff" class="form-control" placeholder="Room Charge" value="{{ old('room_tariff', $record2->room_tariff) }}">
                            <span class="text-danger">
                                @error('room_tariff')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div>
                            <label for="room_dis">Room Dis %</label>
                            <input type="text" name="room_dis" class="form-control" placeholder="Room dis On % only" value="{{ old('room_dis', $record2->room_dis) }}">
                            <span class="text-danger">
                                @error('room_dis')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm my-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
