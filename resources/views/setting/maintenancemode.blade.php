@extends('layouts.blank')

@section('pagecontent')
<div class="container mt-4">

    <h4 class="mb-4">Maintenance Mode Settings</h4>

    @if (session('message'))
        <div class="alert alert-primary">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('maintenancemode.update') }}" method="POST">
        @csrf
        {{-- Use PUT or PATCH if your route expects it --}}
        @method('POST') 

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode"
                value="1" {{ $maintenancemode->maintenance_mode ? 'checked' : '' }}>
            <label class="form-check-label" for="maintenance_mode">Enable Maintenance Mode</label>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time"
                value="{{ $maintenancemode->start_time }}">
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time"
                value="{{ $maintenancemode->end_time }}">
        </div>

        <div class="mb-3">
            <label for="message1" class="form-label">Message 1</label>
            <input type="text" class="form-control" id="message1" name="message1"
                value="{{ $maintenancemode->message1 }}">
        </div>

        <div class="mb-3">
            <label for="message2" class="form-label">Message 2</label>
            <input type="text" class="form-control" id="message2" name="message2"
                value="{{ $maintenancemode->message2 }}">
        </div>

        <div class="mb-3">
            <label for="message3" class="form-label">Message 3</label>
            <input type="text" class="form-control" id="message3" name="message3"
                value="{{ $maintenancemode->message3 }}">
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>

{{-- Bootstrap Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
@endsection
