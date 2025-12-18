@extends('layouts.blank')

@section('pagecontent')
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

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
                            <th>Designation</th>
                            <th col="2">Date of Joining</th>
                            <th>Document Type</th>
                            <th>Photo</th>
                            <th>Document</th>
                            <th>Report Time</th>
                            <th>Buffer Time</th>
                            <th>Terms & condition</th>
                            <th colspan="5"><h5>Actions</h5></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($employees as $key => $employee)

                        {{-- EMPLOYEE ROW --}}
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $employee->emp_id }}</td>
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
<td> {{ $employee->designation}}</td>

                            <td>{{ $employee->date_of_joining }}</td>
                            <td>{{ $employee->document_type }}</td>

                            <td>


<img src="{{ asset('storage\app\public\room_image\\' . $employee->photo) }}"   width="80px">
                            </td>

                            <td>
                                   <immg src="{{ asset('storage\app\public\item_image\\'.$employee->document_submit) }}" width="80px">
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
                        <button class="btn btn-sm btn-warning"
        onclick="printEmployee({{ $employee->id }})"
        title="Print">
    <i class="fa-solid fa-print"></i>
</button>

</td>
                            {{-- ADD ADVANCE SALARY --}}
                            <td>
                        <button class="btn btn-sm btn-secondary"
        onclick="showAdvanceInput({{ $employee->id }})"
        title="Add Advance">
    <i class="fa-solid fa-indian-rupee-sign"></i>
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

            

            </div>
        </div>
    </div>

</div>



{{-- =============================model for print user script============================== --}}
{{-- Load jQuery once --}}
<script>
const employeesData = @json($employees->keyBy('id'));
const baseUrl = "{{ url('') }}";

// Base64 blank image (offline safe)
const blankImg = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg==";

const companyName = @json($componyinfo->cominfo_firm_name ?? '');
const companyAddress = @json(
    trim(
        ($componyinfo->cominfo_address1 ?? '') . ' ' .
        ($componyinfo->cominfo_address2 ?? '') . ' ' .
        ($componyinfo->cominfo_city ?? '') . ' ' .
        ($componyinfo->cominfo_state ?? '') . ' ' .
        ($componyinfo->cominfo_pincode ?? '') . ' ' .
        ($compinfofooter->country ?? '')
    )
);

// ✅ FIXED PATH (also had typo)
const companyLogo = "{{ asset('storage\app\public\image\\' . $pic->logo) }}";

function printEmployee(id) {
    let emp = employeesData[id];
    if (!emp) return alert("Employee not found!");

    let photo = emp.photo 
        ? baseUrl + "storage\app\public\room_image\\" + emp.photo 
        : blankImg;

    let document = emp.document_submit 
        ? baseUrl + "storage\app\public\item_image\\" + emp.document_submit 
        : blankImg;

    let printWin = window.open("", "_blank", "width=900,height=1100");
printWin.document.write(`
<html>
<head>
    <title>Employee Print</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body { padding: 20px;}
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        td, th { border:1px solid #000; padding:6px; font-size:14px; }
        img.photo { width:160px; border:1px solid #444; }

    
 .header {
    display: grid;
    grid-template-columns: auto 1fr auto; /* left | center | right */
    align-items: center;
    border-bottom: 3px solid #000;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.header .logo img {
    height: 70px;
}

.header .company-info {
    text-align: center;
}

.header .company-info h4 {
    margin: 0;
    font-weight: 700;
}

.header .company-info small {
    font-size: 13px;
}

.photo-pair {
    display: flex;
    justify-content: center;
    gap: 80px;
    margin-top: 30px;
}

.photo-box {
    text-align: center;
}

.photo-placeholder {
    width: 220px;        /* increased size */
    height: 180px;       /* increased size */
    border: 2px solid #000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
}

        .signature-section {
    display: flex;
    justify-content: space-between;
    margin-top: 60px;
}

.signature-box {
    width: 45%;
    text-align: center;
}

.signature-line {
    border-top: 2px solid #000;
    margin-top: 50px;
}

    </style>
</head>

<body>

    <!-- COMPANY HEADER -->
  <div class="header">

    <!-- COMPANY LOGO (LEFT) -->
    <div class="logo">
        <img src="${companyLogo}" onerror="this.style.display='none'">
    </div>

    <!-- COMPANY NAME (CENTER) -->
    <div class="company-info">
        <h4>${companyName}</h4>
        <small>${companyAddress}</small>
    </div>

</div>


    <h5 class="text-center fw-bold">Employee Details</h5>

 <div class="photo-row">

    <!-- DETAILS TABLE -->
    <table>
        <tr><th>ID</th><td>${emp.id}</td></tr>
        <tr><th>Name</th><td>${emp.name}</td></tr>
        <tr><th>Email</th><td>${emp.email ?? "-"}</td></tr>
        <tr><th>Mobile</th><td>${emp.mobile ?? "-"}</td></tr>
        <tr><th>Address</th><td>${emp.address ?? "-"}</td></tr>
        <tr><th>Salary</th><td>${emp.salary_amount ?? "-"}</td></tr>
        <tr><th>Date of Joining</th><td>${emp.date_of_joining ?? "-"}</td></tr>
        <tr><th>Document Type</th><td>${emp.document_type ?? "-"}</td></tr>
        <tr><th>Document Number</th><td>${emp.document_no ?? "-"}</td></tr>
        <tr><th>Report Time</th><td>${emp.Report_time ?? "-"}</td></tr>
        <tr><th>Buffer Time</th><td>${emp.Buffer_time ?? "-"}</td></tr>
    </table>
 <div style="display:flex; margin-top:10px;">
    <strong style="min-width:180px;">Term and Conditions:-</strong>
    <span>${emp.terms_text ?? "-"}</span>
</div>
<div class="photo-pair">
    <div class="photo-box">
        <div class="photo-placeholder">
            <img src="${photo}" style="max-width:100%; max-height:100%;">
        </div>
    </div>

    <div class="photo-box">
        <div class="photo-placeholder"></div>
    
    </div>
</div>

</div>


    <!-- SIGNATURES -->
   <div class="signature-section">
    <div class="signature-box">
        <div class="signature-line"></div>
        <h6 class="mt-2">Employee Signature</h6>
    </div>

    <div class="signature-box">
        <div class="signature-line"></div>
        <h6 class="mt-2">Official Signature</h6>
    </div>
</div>

</body>
</html>

</body>
</html>
`);

    printWin.document.close();

    // Wait for images → print
    printWin.onload = () => {
        setTimeout(() => {
            printWin.print();
            printWin.close();
        }, 300);
    };
}
</script>



{{-- =============================end model for print user script============================== --}}


<script>
function showAdvanceInput(id) {
    document.getElementById('advance-row-' + id).style.display = 'table-row';
}

function hideAdvanceInput(id) {
    document.getElementById('advance-row-' + id).style.display = 'none';
}
</script>



                </table>


            </div>
        </div>
    </div>

</div>



{{-- =============================model for print user script============================== --}}
{{-- Load jQuery once --}}
<script>
const employeesData = @json($employees->keyBy('id'));
const baseUrl = "{{ url('') }}";

// Base64 blank image (offline safe)
const blankImg = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg==";

const companyName = @json($componyinfo->cominfo_firm_name ?? '');
const companyAddress = @json(
    trim(
        ($componyinfo->cominfo_address1 ?? '') . ' ' .
        ($componyinfo->cominfo_address2 ?? '') . ' ' .
        ($componyinfo->cominfo_city ?? '') . ' ' .
        ($componyinfo->cominfo_state ?? '') . ' ' .
        ($componyinfo->cominfo_pincode ?? '') . ' ' .
        ($compinfofooter->country ?? '')
    )
);

// ✅ FIXED PATH (also had typo)
const companyLogo = "{{ asset('storage\app\public\image\\' . $pic->logo) }}";

function printEmployee(id) {
    let emp = employeesData[id];
    if (!emp) return alert("Employee not found!");

    let photo = emp.photo 
        ? baseUrl + "/uploads/attendance/photos/" + emp.photo 
        : blankImg;

    let document = emp.document_submit 
        ? baseUrl + "/uploads/attendance/documents/" + emp.document_submit 
        : blankImg;

    let printWin = window.open("", "_blank", "width=900,height=1100");
printWin.document.write(`
<html>
<head>
    <title>Employee Print</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body { padding: 20px;}
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        td, th { border:1px solid #000; padding:6px; font-size:14px; }
        img.photo { width:160px; border:1px solid #444; }

    
 .header {
    display: grid;
    grid-template-columns: auto 1fr auto; /* left | center | right */
    align-items: center;
    border-bottom: 3px solid #000;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.header .logo img {
    height: 70px;
}

.header .company-info {
    text-align: center;
}

.header .company-info h4 {
    margin: 0;
    font-weight: 700;
}

.header .company-info small {
    font-size: 13px;
}

.photo-pair {
    display: flex;
    justify-content: center;
    gap: 80px;
    margin-top: 30px;
}

.photo-box {
    text-align: center;
}

.photo-placeholder {
    width: 220px;        /* increased size */
    height: 180px;       /* increased size */
    border: 2px solid #000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
}

        .signature-section {
    display: flex;
    justify-content: space-between;
    margin-top: 60px;
}

.signature-box {
    width: 45%;
    text-align: center;
}

.signature-line {
    border-top: 2px solid #000;
    margin-top: 50px;
}

    </style>
</head>

<body>

    <!-- COMPANY HEADER -->
  <div class="header">

    <!-- COMPANY LOGO (LEFT) -->
    <div class="logo">
        <img src="${companyLogo}" onerror="this.style.display='none'">
    </div>

    <!-- COMPANY NAME (CENTER) -->
    <div class="company-info">
        <h4>${companyName}</h4>
        <small>${companyAddress}</small>
    </div>

</div>


    <h5 class="text-center fw-bold">Employee Details</h5>

 <div class="photo-row">

    <!-- DETAILS TABLE -->
    <table>
        <tr><th>ID</th><td>${emp.id}</td></tr>
        <tr><th>Name</th><td>${emp.name}</td></tr>
        <tr><th>Email</th><td>${emp.email ?? "-"}</td></tr>
        <tr><th>Mobile</th><td>${emp.mobile ?? "-"}</td></tr>
        <tr><th>Address</th><td>${emp.address ?? "-"}</td></tr>
        <tr><th>Salary</th><td>${emp.salary_amount ?? "-"}</td></tr>
        <tr><th>Date of Joining</th><td>${emp.date_of_joining ?? "-"}</td></tr>
        <tr><th>Document Type</th><td>${emp.document_type ?? "-"}</td></tr>
        <tr><th>Document Number</th><td>${emp.document_no ?? "-"}</td></tr>
        <tr><th>Report Time</th><td>${emp.Report_time ?? "-"}</td></tr>
        <tr><th>Buffer Time</th><td>${emp.Buffer_time ?? "-"}</td></tr>
    </table>
 <div style="display:flex; margin-top:10px;">
    <strong style="min-width:180px;">Term and Conditions:-</strong>
    <span>${emp.terms_text ?? "-"}</span>
</div>
<div class="photo-pair">
    <div class="photo-box">
        <div class="photo-placeholder">
            <img src="${photo}" style="max-width:100%; max-height:100%;">
        </div>
    </div>

    <div class="photo-box">
        <div class="photo-placeholder"></div>
    
    </div>
</div>

</div>


    <!-- SIGNATURES -->
   <div class="signature-section">
    <div class="signature-box">
        <div class="signature-line"></div>
        <h6 class="mt-2">Employee Signature</h6>
    </div>

    <div class="signature-box">
        <div class="signature-line"></div>
        <h6 class="mt-2">Official Signature</h6>
    </div>
</div>

</body>
</html>

</body>
</html>
`);

    printWin.document.close();

    // Wait for images → print
    printWin.onload = () => {
        setTimeout(() => {
            printWin.print();
            printWin.close();
        }, 300);
    };
}
</script>



{{-- =============================end model for print user script============================== --}}


<script>
function showAdvanceInput(id) {
    document.getElementById('advance-row-' + id).style.display = 'table-row';
}

function hideAdvanceInput(id) {
    document.getElementById('advance-row-' + id).style.display = 'none';
}
</script>

@endsection
