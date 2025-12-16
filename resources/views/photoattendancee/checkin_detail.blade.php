@extends('layouts.blank')

@section('pagecontent')

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<div class="container mt-4">

   <h2 class="fw-bold mb-4 text-center">
    Attendance Status
    @if(request('from_date') && request('to_date'))
        ({{ request('from_date') }} to {{ request('to_date') }})
    @endif
</h2>


{{-- DATE RANGE FILTER --}}
<form method="GET" action="{{ route('attendancephoto.index') }}" class="mb-3">
    <div class="row g-2">
        <div class="col-md-4">
            <input type="date" name="from_date" class="form-control"
                   value="{{ request('from_date') }}">
        </div>

        <div class="col-md-4">
            <input type="date" name="to_date" class="form-control"
                   value="{{ request('to_date') }}">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">View</button>
        </div>
    </div>
</form>

    <div class="card shadow">
        <div class="card-body p-0">

            <table class="table table-bordered table-hover mb-0 text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>SL</th>
                        <th>Emp ID</th>
                        <th>Name</th>

                        <th>Check-In Photo</th>
                        <th>Check-In Time</th>

                        <th>Check-Out Photo</th>
                        <th>Check-Out Time</th>

                        <th>Status</th>
                        <th>Late Message</th>
                        <th>Date</th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($attendanceData as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['emp_id'] }}</td>
                        <td>{{ $item['emp_name'] }}</td>

                        {{-- CHECK-IN PHOTO --}}
                        <td>
                            @if($item['checkin_photo'])
                                <img src="{{ asset('uploads/attendance/' . $item['checkin_photo']) }}"
                                     width="70" height="70" class="rounded border">
                            @else
                                <span class="text-muted">No Photo</span>
                            @endif
                        </td>

                        {{-- CHECK-IN TIME --}}
                        <td>
                            @if($item['checkin_time'] != '--')
                                <span class="badge bg-success">{{ $item['checkin_time'] }}</span>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>

                        {{-- CHECK-OUT PHOTO --}}
                        <td>
                            @if($item['checkout_photo'])
                                <img src="{{ asset('uploads/attendance/' . $item['checkout_photo']) }}"
                                     width="70" height="70" class="rounded border">
                            @else
                                <span class="text-muted">No Photo</span>
                            @endif
                        </td>

                        {{-- CHECK-OUT TIME --}}
                        <td>
                            @if($item['checkout_time'] != '--')
                                <span class="badge bg-danger">{{ $item['checkout_time'] }}</span>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>
                          @if($item['status'] == 'Present')
    <span class="badge bg-success">Present</span>

@elseif($item['status'] == 'Half Day')
    <span class="badge bg-warning text-dark">Half Day</span>

@elseif($item['status'] == 'Late')
    <span class="badge bg-warning text-dark">Late</span>

@else
    <span class="badge bg-danger">Absent</span>
@endif

 <td>
    @if($item['status'] == 'Late')
        <span class="badge bg-warning text-dark">Late</span><br>
        <small class="text-warning fw-bold">{{ $item['late_message'] }}</small>

    @elseif($item['status'] == 'Present')
        <span class="badge bg-success">Present</span>

    @else
        <span class="badge bg-danger">Absent</span>
    @endif
</td>

<td>{{ $item['date'] }}</td>

<td>
    <button
        class="btn btn-sm btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#editAttendanceModal"
        data-emp="{{ $item['emp_id'] }}"
        data-date="{{ $item['date'] }}"
        data-status="{{ $item['status'] }}"
    >
        Edit
    </button>
</td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>


<div class="modal fade" id="editAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('attendancephoto.updateStatus') }}">
            @csrf

            <input type="hidden" name="emp_id" id="modal_emp_id">
            <input type="hidden" name="date" id="modal_date">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="fw-bold mb-1">Status</label>
                    <select name="status" id="modal_status" class="form-select" required>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Half Day">Half Day</option>
                        <option value="Late">Late</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('editAttendanceModal').addEventListener('show.bs.modal', function (event) {

    let button = event.relatedTarget;

    document.getElementById('modal_emp_id').value = button.getAttribute('data-emp');
    document.getElementById('modal_date').value   = button.getAttribute('data-date');
    document.getElementById('modal_status').value = button.getAttribute('data-status');
});
</script>


@endsection
