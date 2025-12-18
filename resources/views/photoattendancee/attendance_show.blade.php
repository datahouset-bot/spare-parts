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
            
                                           
<img src="{{ asset('storage\app\public\room_image\\' . $employee->photo) }}" 
                         width="180" class="rounded shadow mb-2">
            
            </div>

            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr><th>Name</th><td>{{ $employee->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $employee->email }}</td></tr>
                    <tr><th>Mobile</th><td>{{ $employee->mobile }}</td></tr>
                    <tr><th>Address</th><td>{{ $employee->address }}</td></tr>
             <tr>
    <th>Salary</th>
    <td>
        ₹{{ $employee->salary_amount }}

        <form method="POST"
              action="{{ route('salary.status.update', $employee->id) }}"
              class="d-inline ms-3">
            @csrf
            @method('PUT')

            <label class="ms-2">
                <input type="checkbox"
                       name="salary_status"
                       value="paid"
                       onchange="this.form.submit()"
                       {{ $employee->salary_status === 'paid' ? 'checked' : '' }}>
                <span class="fw-bold text-success">Paid</span>
            </label>
        </form>

        @if($employee->salary_status === 'unpaid')
            <span class="badge bg-danger ms-2">Unpaid</span>
        @endif
    </td>
</tr>

                    <tr><th>Date of Joining</th><td>{{ $employee->date_of_joining }}</td></tr>
                     @if($employee->document_submit)
        <tr>
            <th>Document</th>
            <td>
                
                                   <immg src="{{ asset('storage\app\public\item_image\\'.$employee->document_submit) }}" width="80px">
            </td>
        </tr>
    @else
        <tr>
            <th>Document</th>
            <td class="text-muted">No document uploaded</td>
        </tr>
    @endif
                </table>
            </div>

        </div>
    </div>

<form method="GET" class="mb-3">
    <div class="row">

        <!-- MONTH DROPDOWN -->
        <div class="col-md-4">
            <label class="fw-bold">Select Month</label>
            <select name="month" class="form-select" onchange="this.form.submit()">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('month', now()->month) == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- <!-- YEAR DROPDOWN -->
        <div class="col-md-4">
            <label class="fw-bold">Select Year</label>
            <select name="year" class="form-select" onchange="this.form.submit()">
                @for ($y = now()->year; $y >= now()->year - 10; $y--)
                    <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div> --}}

    </div>
</form>

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
                        <th>Actions</th>

                    </tr>
                </thead>

              <tbody>
@foreach($advances as $key => $adv)
<tr>
    <td>{{ $key + 1 }}</td>
    <td>₹{{ $adv->advance_salary }}</td>
    <td>{{ $adv->date }}</td>
    <td>{{ $adv->remark ?? '-' }}</td>
    <td>
        <button class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#editAdvanceModal{{ $adv->id }}">
            Edit
        </button>
    </td>
</tr>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editAdvanceModal{{ $adv->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('advance.update', $adv->id) }}">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Advance Salary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold">Advance Amount</label>
                        <input type="number"
                               name="advance_salary"
                               class="form-control"
                               value="{{ $adv->advance_salary }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Date</label>
                        <input type="date"
                               name="date"
                               class="form-control"
                               value="{{ $adv->date }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Remark</label>
                        <input type="text"
                               name="remark"
                               class="form-control"
                               value="{{ $adv->remark }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

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
{{-- <form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <select name="month" class="form-select" onchange="this.form.submit()">
                <option value="">Select Month</option>

                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</form> --}}


    <!-- ATTENDANCE SUMMARY -->
   
<form method="GET" class="mb-3">
    <div class="col-md-4">
        <label class="fw-bold">Select Month</label>
        <select name="month" class="form-select" onchange="this.form.submit()">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                </option>
            @endfor
        </select>
    </div>
</form>

<!-- SUMMARY -->
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

<!-- ATTENDANCE TABLE -->
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
    <td>
        @if($day->status == 'present')
            <span class="text-success fw-bold">PRESENT</span>
        @elseif($day->status == 'late')
            <span class="text-success fw-bold">LATE</span><br>
            <small class="text-success">{{ $day->late_message }}</small>
        @else
            <span class="text-danger fw-bold">ABSENT</span>
        @endif
    </td>
</tr>
@endforeach
</tbody>

</table>


    <a href="{{ route('attendances.create') }}" class="btn btn-primary mt-3">
        Back to Employee List
    </a>

</div>

@endsection
