<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
  <style>
/* ================= PAGE BACKGROUND ================= */
body {
    background: #f4f6fb;
    font-family: "Segoe UI", system-ui, sans-serif;
}

/* ================= CARD ================= */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 14px 35px rgba(0,0,0,0.08);
}

/* ================= CARD HEADER ================= */
.card-header {
    background: linear-gradient(135deg, #ffffff, #eef2f7);
    border-bottom: 1px solid #e5e7eb;
    padding: 14px 18px;
}

.card-header h4 {
    margin: 0;
    font-weight: 700;
    color: #1f2937;
}

/* ================= BUTTON BAR ================= */
.card .row.my-2 {
    padding-bottom: 8px;
}

.btn {
    border-radius: 30px;
    padding: 6px 22px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-warning {
    box-shadow: 0 6px 16px rgba(245,158,11,0.35);
}

.btn-primary {
    box-shadow: 0 6px 16px rgba(37,99,235,0.35);
}

.btn:hover {
    transform: translateY(-1px);
}

/* ================= TABLE CONTAINER ================= */
.table-scrollable {
    background: #ffffff;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 10px 26px rgba(0,0,0,0.06);
}

/* ================= TABLE ================= */
table {
    border-collapse: separate;
    border-spacing: 0;
}

thead th {
    background: #f1f5f9;
    font-weight: 700;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

/* Compact but readable */
td {
    padding: 8px !important;
    vertical-align: middle;
}

/* Hover effect */
tbody tr {
    transition: background 0.2s ease, transform 0.15s ease;
}

tbody tr:hover {
    background: #f8fafc;
    transform: scale(1.003);
}

/* ================= NUMBER HIGHLIGHTS ================= */
td:nth-child(3),
td:nth-child(4) {
    font-weight: 700;
    color: #2563eb;
}

/* ================= EMPTY ROW ================= */
tbody tr td[colspan] {
    padding: 20px !important;
    font-weight: 600;
    color: #6b7280;
}

/* ================= DATATABLE BUTTONS ================= */
.dt-buttons .dt-button {
    border-radius: 20px !important;
    border: none !important;
    padding: 6px 14px !important;
    background: #e5e7eb !important;
    font-weight: 600;
}

.dt-buttons .dt-button:hover {
    background: #2563eb !important;
    color: #fff !important;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .card-header {
        text-align: center;
    }

    .btn {
        width: 100%;
        margin-bottom: 6px;
    }

    table {
        font-size: 14px;
    }
}
</style>

{{-- <script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
  });
</script> --}}
<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
        <h4>Vehicle Log  <h4>       </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
            <a href="{{url('room_dashboard')}}" class="btn btn-warning">Spare part DashBoard</a>
            <a href="{{url('roomcheckouts/create')}}" class="btn btn-primary">New MoveOut </a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
 
          <table class="  " id="remindtable">
                <thead>
  <tr>
                        <th>S.No</th>
                        <th>Customer Name</th>
                        <th>No. of service/entry</th>
                        <th>Total Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($guestVisits as $guest)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $guest->guest_name }}</td>
                            <td>{{ $guest->visit_count }}</td>
                            <td>{{ number_format($guest->total_amount, 2) }}</td>
                        </tr>
                    @endforeach

                    @if ($guestVisits->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">No records found</td>
                        </tr>
                    @endif
                                 
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<script>
  $(document).ready(function () 
  {

    new DataTable('#remindtable', {
    layout: {
        topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
    }
});


  }
  );
 
</script>


@endsection