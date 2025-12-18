@extends('layouts.blank')

@section('pagecontent')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
<h2 class="fw-bold mb-4 text-center">
    Attendance Status
    @if(!empty($fromDate) && !empty($toDate))
        <br>
        <small class="text-muted">
            {{ \Carbon\Carbon::parse($fromDate)->format('d-m-Y') }}
            —
            {{ \Carbon\Carbon::parse($toDate)->format('d-m-Y') }}
        </small>
    @endif
</h2>

{{-- DATE RANGE FILTER --}}
<form method="GET" action="{{ route('attendancephoto.index') }}" class="mb-3">
    <div class="row g-2 justify-content-center">

        <div class="col-md-3">
            <label class="fw-bold">From Date</label>
            <input
                type="date"
                name="from_date"
                class="form-control"
                value="{{ $fromDate ?? request('from_date') }}">
        </div>

        <div class="col-md-3">
            <label class="fw-bold">To Date</label>
            <input
                type="date"
                name="to_date"
                class="form-control"
                value="{{ $toDate ?? request('to_date') }}">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">
                View
            </button>
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
    <th>Late Message / Remark</th>
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

<td>
@if($item['checkin_photo'])
<img src="{{ asset('storage/attendance/checkin/'.$item['checkin_photo']) }}" width="70">
@else <span class="text-muted">No Photo</span> @endif
</td>

<td>{{ $item['checkin_time'] }}</td>

<td>
@if($item['checkout_photo'])
<img src="{{ asset('storage/attendance/checkout/'.$item['checkout_photo']) }}" width="70">
@else <span class="text-muted">No Photo</span> @endif
</td>

<td>{{ $item['checkout_time'] }}</td>

{{-- STATUS --}}
<td>
@if($item['status']=='Present')
<span class="badge bg-success">Present</span>
@elseif($item['status']=='Late')
<span class="badge bg-warning text-dark">Late</span>
@elseif($item['status']=='Half Day')
<span class="badge bg-warning text-dark">Half Day</span>
@else
<span class="badge bg-danger">Absent</span>
@endif
</td>

{{-- LATE MESSAGE + REMARK --}}
<td class="text-start px-2">
@if($item['status']=='Late' && !empty($item['late_message']))
    <span class="fw-bold text-warning">
        {{ $item['late_message'] }}
    </span><br>
@endif

@if(!empty($item['Remark']))
    <small class="text-danger fw-bold">
        {{ $item['Remark'] }}
    </small>
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
    data-remark="{{ $item['Remark'] }}"
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

{{-- EDIT MODAL --}}
<div class="modal fade" id="editAttendanceModal" tabindex="-1">
<div class="modal-dialog">
<form method="POST" action="{{ route('attendancephoto.updateStatus') }}">
@csrf

<input type="hidden" name="emp_id" id="modal_emp_id">
<input type="hidden" name="date" id="modal_date">

<div class="modal-content">
<div class="modal-header">
<h5>Edit Attendance</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<label>Status</label>
<select name="status" id="modal_status" class="form-select mb-2">
<option value="Present">Present</option>
<option value="Absent">Absent</option>
<option value="Half Day">Half Day</option>
<option value="Late">Late</option>
</select>

<label>Remark</label>
<input type="text" name="Remark" id="modal_Remark" class="form-control">
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
document.getElementById('editAttendanceModal')
.addEventListener('show.bs.modal', function (e) {

    let b = e.relatedTarget;

    modal_emp_id.value = b.dataset.emp;
    modal_date.value   = b.dataset.date;
    modal_status.value = b.dataset.status;

    // data-remark always becomes lowercase
    modal_Remark.value = b.dataset.remark ?? '';
});
</script>

@endsection
