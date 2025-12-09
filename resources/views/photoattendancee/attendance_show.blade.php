@extends('layouts.blank')

@section('pagecontent')

<div class="container mt-4">

    <!-- EMPLOYEE DETAILS -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            Employee Full Details – {{ $employee->name }}
        </div>

        <div class="card-body row">

            <div class="col-md-4 text-center">
                @if($employee->photo)
                    <img src="{{ asset('uploads/attendance/photos/' . $employee->photo) }}"
                         width="180" class="rounded shadow mb-2">
                @endif
            </div>

            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr><th>Name</th><td>{{ $employee->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $employee->email }}</td></tr>
                    <tr><th>Mobile</th><td>{{ $employee->mobile }}</td></tr>
                    <tr><th>Address</th><td>{{ $employee->address }}</td></tr>
                    <tr><th>Salary</th><td>₹{{ $employee->salary_amount }}</td></tr>
                    <tr><th>Date of Joining</th><td>{{ $employee->date_of_joining }}</td></tr>
                </table>
            </div>

        </div>
    </div>


    <!-- ADVANCE SALARY TABLE -->
    <div class="card shadow mb-4">
        <div class="card-header bg-warning fw-bold">
            Advance Salary Records
        </div>

        <div class="card-body">

            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Advance Amount</th>
                        <th>Date</th>
                        <th>Remarks</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($advances as $key => $adv)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>₹{{ $adv->advance_salary }}</td>
                            <td>{{ $adv->date }}</td>
                            <td>{{ $adv->remarks ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="mt-3 p-3 bg-light border">
                <h5 class="fw-bold">Advance Summary</h5>
                <p><b>Total Advance:</b> ₹{{ $totalAdvance }}</p>
                <p><b>Monthly Salary:</b> ₹{{ $employee->salary_amount }}</p>
                <p><b>Remaining Salary:</b> ₹{{ $employee->salary_amount - $totalAdvance }}</p>
            </div>

        </div>
    </div>


    <!-- ATTENDANCE SUMMARY -->
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white fw-bold">
            Attendance Summary
        </div>

        <div class="card-body">

            <div class="row text-center mb-3">
                <div class="col-md-4">
                    <h4 class="text-success">Present</h4>
                    <h3>{{ $presentDays }}</h3>
                </div>
                <div class="col-md-4">
                    <h4 class="text-danger">Absent</h4>
                    <h3>{{ $absentDays }}</h3>
                </div>
                <div class="col-md-4">
                    <h4 class="text-primary">Total Days</h4>
                    <h3>{{ $totalDays }}</h3>
                </div>
            </div>

            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($attendance as $day)
                        <tr>
                            <td>{{ $day->date }}</td>
                            <td class="{{ $day->status == 'present' ? 'text-success' : 'text-danger' }}">
                                {{ strtoupper($day->status) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


    <a href="{{ route('attendances.create') }}" class="btn btn-primary mt-3">
        Back to Employee List
    </a>

</div>

@endsection
