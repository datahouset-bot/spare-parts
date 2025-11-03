@extends('layouts.blank')

@section('pagecontent')
<div class="container">
    <h4>Attendance Report</h4>
    <form action="{{ route('attendance.report.show') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label>Employee:</label>
                <select name="user_id" class="form-select" required>
                    <option value="">Select Employee</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>Official In:</label>
                <input type="time" name="official_in" value="11:00" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>Official Out:</label>
                <input type="time" name="official_out" value="19:00" class="form-control" required>
            </div>
            <div class="col-md-1 align-self-end">
                <button class="btn btn-primary w-100">Show</button>
            </div>
        </div>
    </form>
</div>
@endsection
