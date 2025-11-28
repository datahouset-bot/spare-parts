@extends('layouts.blank')
@section('pagecontent')

<div class="container-fluid">
    <h4 class="mb-3">Daily Attendance</h4>

    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Date:</label>
                <input type="date" name="attendance_date" value="{{ $date }}" class="form-control" onchange="changeDate(this.value)" required>
            </div>

            <div class="col-md-2">
                <label>Default Status:</label>
                <select id="defaultStatus" class="form-select">
                    <option value="P">Present</option>
                    <option value="A">Absent</option>
                    <option value="H">Half Day</option>
                    <option value="S">Sunday</option>
                </select>
            </div>

            <div class="col-md-2">
                <label>Default In Time:</label>
                <input type="time" id="defaultInTime" value="11:00" class="form-control">
            </div>

            <div class="col-md-2">
                <label>Default Out Time:</label>
                <input type="time" id="defaultOutTime" value="19:00" class="form-control">
            </div>

            <div class="col-md-2 align-self-end">
                <button type="button" id="applyDefaults" class="btn btn-secondary w-100">Apply to All</button>
            </div>

            <div class="col-md-1 align-self-end">
                <button class="btn btn-primary w-100">Save</button>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>User Name</th>
                    <th>Status</th>
                    <th>Coming Time</th>
                    <th>Out Time</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    @php $data = $existing[$user->id] ?? null; @endphp
                    <tr>
                        <td>
                            {{ $user->name }}
                            <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                        </td>
                        <td>
                            <select name="status[]" class="form-select status-select">
                                <option value="P" {{ $data && $data->status=='P'?'selected':'' }}>Present</option>
                                <option value="A" {{ $data && $data->status=='A'?'selected':'' }}>Absent</option>
                                <option value="H" {{ $data && $data->status=='H'?'selected':'' }}>Half Day</option>
                                <option value="S" {{ $data && $data->status=='S'?'selected':'' }}>Sunday</option>
                            </select>
                        </td>
                        <td>
                            <input type="time" name="in_time[]" value="{{ $data->in_time ?? '' }}" class="form-control in-time">
                        </td>
                        <td>
                            <input type="time" name="out_time[]" value="{{ $data->out_time ?? '' }}" class="form-control out-time">
                        </td>
                         <td>
                            <input type="text" name="attend_af1[]" value="{{ $data->attend_af1 ?? '' }}" class="form-control ">
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>

{{-- ✅ JavaScript Section --}}
<script>
    // Date change hone par page reload with that date
    function changeDate(date) {
        window.location.href = "{{ route('attendance.index') }}?date=" + date;
    }

    // Apply Default Values to all rows
    document.getElementById('applyDefaults').addEventListener('click', function () {
        let defaultStatus = document.getElementById('defaultStatus').value;
        let defaultInTime = document.getElementById('defaultInTime').value;
        let defaultOutTime = document.getElementById('defaultOutTime').value;

        document.querySelectorAll('.status-select').forEach(select => select.value = defaultStatus);
        document.querySelectorAll('.in-time').forEach(input => input.value = defaultInTime);
        document.querySelectorAll('.out-time').forEach(input => input.value = defaultOutTime);
    });
</script>

@endsection
