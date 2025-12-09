@extends('layouts.blank')

@section('pagecontent')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

    <h2 class="fw-bold mb-4 text-center">Attendance Status for {{ $date }}</h2>

    {{-- DATE FILTER --}}
    <form method="GET" action="{{ route('attendancephoto.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="date" name="date" class="form-control" value="{{ $date }}">
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

                            {{-- @elseif($item['status'] == 'Half Day')
                                <span class="badge bg-warning text-dark">Half Day</span> --}}

                            @else
                                <span class="badge bg-danger">Absent</span>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
