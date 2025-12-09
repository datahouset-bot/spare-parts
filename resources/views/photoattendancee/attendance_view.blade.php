@extends('layouts.blank')

@section('pagecontent')

<div class="container fluid">

    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Employee List
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center fw-bold m-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Salary</th>
                            <th>Advance Salary</th>
                            <th col="2">Date of Joining</th>
                            <th>Document Type</th>
                            <th>Photo</th>
                            <th>Document</th>
                            <th>Report Time</th>
                            <th>Buffer Time</th>
                            <th>Remarks</th>
                            <th colspan="5"><h5>Actions</h5></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($employees as $key => $employee)

                        {{-- EMPLOYEE ROW --}}
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->mobile }}</td>
                            <td>{{ $employee->salary_amount }}</td>
                            <td>
    @if($employee->latestAdvance)
        ₹{{ $employee->latestAdvance->advance_salary }}
        {{ ' (' . $employee->latestAdvance->date . ')'   }}
    @else
        -
    @endif
</td>

                            <td>{{ $employee->date_of_joining }}</td>
                            <td>{{ $employee->document_type }}</td>

                            <td>
                                @if($employee->photo)
                                    <a class="btn btn-sm btn-info text-white"
                                       href="{{ asset('uploads/attendance/photos/' . $employee->photo) }}"
                                       target="_blank">View</a>
                                @else N/A @endif
                            </td>

                            <td>
                                @if($employee->document_submit)
                                    <a class="btn btn-sm btn-info text-white"
                                       href="{{ asset('uploads/attendance/documents/' . $employee->document_submit) }}"
                                       target="_blank">View</a>
                                @else N/A @endif
                            </td>

                            <td>{{ $employee->Report_time }}</td>
                            <td>{{ $employee->Buffer_time }}</td>
                            <td>{{ $employee->terms_text }}</td>

                            <td>
    <a href="{{ route('attendances.show', $employee->id) }}"
       class="btn btn-sm btn-info text-white">View Full</a>
</td>

                            {{-- EDIT --}}
                            <td>
                                <a href="{{ route('attendances.edit', $employee->id) }}"
                                   class="btn btn-sm btn-primary">Edit</a>
                            </td>

                            {{-- DELETE --}}
                            <td>
                                <form action="{{ route('attendances.destroy', $employee->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this employee?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>

                            {{-- PRINT --}}
                            <td>
                                <button class="btn btn-sm btn-warning"
                                        onclick="printSingleEmployee({{ $employee->id }})">
                                    Print
                                </button>
                            </td>

                            {{-- ADD ADVANCE SALARY --}}
                            <td>
                                <button class="btn btn-sm btn-secondary"
                                        onclick="showAdvanceInput({{ $employee->id }})">
                                    Add Advance
                                </button>
                            </td>
                        </tr>


                        {{-- ADVANCE SALARY HIDDEN ROW --}}
                        <tr id="advance-row-{{ $employee->id }}"
                            style="display:none; background:#f7f7f7;">
                            <td colspan="16">

                                <form action="{{ route('advance.store') }}" method="POST" class="d-flex gap-3">
                                    @csrf

                                    <input type="hidden" name="emp_no" value="{{ $employee->id }}">
                                    <input type="hidden" name="emp_name" value="{{ $employee->name }}">

                                    <input type="hidden" name="salary" value="{{ $employee->salary_amount }}">

                                    <input type="number" name="advance_salary"
                                           class="form-control w-25"
                                           placeholder="Enter Advance Amount" required>

                                    <input type="date" name="date"
                                           class="form-control w-25"
                                           value="{{ date('Y-m-d') }}" required>

                                    <button type="submit" class="btn btn-success">
                                        Save
                                    </button>

                                    <button type="button" class="btn btn-danger"
                                            onclick="hideAdvanceInput({{ $employee->id }})">
                                        Cancel
                                    </button>
                                </form>

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="16" class="text-center text-danger">
                                No Employees Found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

                <a href="{{ url('attendances') }}" class="btn btn-success float-end m-3">
                    + Add New Employee
                </a>

            </div>
        </div>
    </div>

</div>

<script>
function showAdvanceInput(id) {
    document.getElementById('advance-row-' + id).style.display = 'table-row';
}

function hideAdvanceInput(id) {
    document.getElementById('advance-row-' + id).style.display = 'none';
}
</script>

@endsection
