@extends('layouts.blank')

@section('pagecontent')
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<style>
/* Clamp remarks to 2 lines */
.remarks-cell {
    max-width: 250px;
    line-height: 1.4em;
    max-height: 2.8em;           /* 2 lines × line-height */
    overflow: hidden;
    text-overflow: ellipsis;

    display: -webkit-box;
    -webkit-line-clamp: 2;       /* CHANGE TO 1 FOR SINGLE LINE */
    -webkit-box-orient: vertical;

    white-space: normal;
    word-break: break-word;
    text-align: left;
    vertical-align: top;
-webkit-line-clamp: 4;
max-height: 5.2em;

}
</style>


<div class="container-fluid">

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
                   <a href="{{ url('attendances') }}" class="btn btn-success float-end m-3">
                    + Add New Employee
                </a>

<table id="employeeTable"
       class="table table-bordered table-striped table-hover mb-0 text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Salary</th>
                            <th>Advance Salary</th>
                            <th>Designation</th>
                            <th>Date of Joining</th>
                            <th>Document Type</th>
                            <th>Photo</th>
                            <th>Document</th>
                            <th>Report Time</th>
                            <th>Buffer Time</th>
                            <th>Terms & condition</th>
                            <th class="no-export"></th>
                            <th class="no-export"></th>
                            <th class="no-export"></th>
                            <th class="no-export"></th>
                            <th class="no-export"></th>

                        </tr>
                    </thead>

                    <tbody>
                        @forelse($employees as $key => $employee)

                        {{-- EMPLOYEE ROW --}}
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $employee->af5 }}</td>
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
<td> {{ $employee->af6}}</td>

                            <td>{{ $employee->date_of_joining }}</td>
                            <td>{{ $employee->document_type }}</td>

                            <td>


<img src="{{ asset('storage\app\public\room_image\\' . $employee->photo) }}"   width="80px">
                            </td>

                            <td>
                                   <img src="{{ asset('storage\app\public\item_image\\'.$employee->document_submit) }}" width="80px">
                            </td>

                            <td>{{ $employee->Report_time }}</td>
                            <td>{{ $employee->Buffer_time }}</td>
                            <td class="remarks-cell" title="{{ $employee->terms_text }}">
                            {{ $employee->terms_text }}</td>


                            <td>

<a href="{{ route('attendances.show', $employee->id) }}"
   class="btn btn-sm btn-info text-white"
   title="View Full">
    <i class="fa-solid fa-eye"></i>
</a>
                            </td>
                            {{-- EDIT --}}
                            <td>
                            <a href="{{ route('attendances.edit', $employee->id) }}"
                            class="btn btn-sm btn-primary"
                            title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                            </a>
</td>

                            {{-- DELETE --}}
                            <td>
                            <form action="{{ route('attendances.destroy', $employee->id) }}"
                            method="POST"
                            onsubmit="return confirm('Delete this employee?');"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                        
                            <button class="btn btn-sm btn-danger" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            </form>
</td>
                            {{-- PRINT --}}
                            <td>
                      <a href="{{ route('employee.print', $employee->id) }}"
   class="btn btn-sm btn-primary"
   title="Print">
    <i class="fa-solid fa-print"></i>
</a>

</td>
                            {{-- ADD ADVANCE SALARY --}}
                            <td>
                        <button class="btn btn-sm btn-secondary"
        onclick="openAdvanceModal(
            {{ $employee->id }},
            '{{ $employee->name }}',
            {{ $employee->salary_amount }}
        )"
        title="Add Advance">
    <i class="fa-solid fa-indian-rupee-sign"></i>
</button>

</td>

                        </tr>


                     
                        @empty

                        @endforelse
                    </tbody>

                </table>

            

            </div>
        </div>
    </div>

</div>
<!-- Advance Salary Modal -->
<div class="modal fade" id="advanceModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <form action="{{ route('advance.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Advance Salary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Hidden Fields -->
                    <input type="hidden" name="emp_no" id="modal_emp_no">
                    <input type="hidden" name="emp_name" id="modal_emp_name">
                    <input type="hidden" name="salary" id="modal_salary">

                    <div class="mb-3">
                        <label class="form-label">Employee Name</label>
                        <input type="text" class="form-control" id="modal_emp_name_show" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Advance Amount</label>
                        <input type="number" name="advance_salary"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date"
                               class="form-control"
                               value="{{ date('Y-m-d') }}" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Save Advance
                    </button>
                    <button type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>



{{-- =============================model for print user script============================== --}}


{{-- =============================end model for print user script============================== --}}


<script>
function showAdvanceInput(id) {
    document.getElementById('advance-row-' + id).style.display = 'table-row';
}

function hideAdvanceInput(id) {
    document.getElementById('advance-row-' + id).style.display = 'none';
}
</script>
<script>
$(document).ready(function () {
    $('#employeeTable').DataTable({
        pageLength: 10, // default
        lengthMenu: [
            [10, 25, 50, 100, -1],
            ['10 rows', '25 rows', '50 rows', '100 rows', 'All']
        ],
        scrollX: true,
        dom: 'lBfrtip', // 👈 l = length menu
        buttons: [
            {
                extend: 'print',
                title: 'Employee Report',
                exportOptions: {
                    columns: ':not(.no-export)'
                }
            },
            {
                extend: 'csv',
                title: 'Employee Report',
                exportOptions: {
                    columns: ':not(.no-export)'
                }
            }
        ]
    });
});
</script>

<script>
function openAdvanceModal(empId, empName, salary) {

    $('#modal_emp_no').val(empId);
    $('#modal_emp_name').val(empName);
    $('#modal_salary').val(salary);

    $('#modal_emp_name_show').val(empName);

    let modal = new bootstrap.Modal(document.getElementById('advanceModal'));
    modal.show();
}
</script>


@endsection
