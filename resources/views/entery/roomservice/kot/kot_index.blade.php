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
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.card-header {
    background: linear-gradient(135deg, #ffffff, #eef2f7);
    border-bottom: 1px solid #e5e7eb;
    padding: 14px 18px;
}

.card-header h3 {
    margin: 0;
    font-weight: 700;
    color: #1f2937;
}

/* ================= TOP BUTTON BAR ================= */
.card .row.my-2 {
    margin-top: 10px;
}

.card .btn {
    border-radius: 22px;
    font-weight: 600;
    padding: 6px 16px;
    margin: 4px;
}

/* ================= TABLE WRAPPER ================= */
.table-scrollable {
    background: #fff;
    border-radius: 12px;
    padding: 12px;
}

/* ================= TABLE ================= */
table {
    border-collapse: separate;
    border-spacing: 0;
}

/* Header */
thead th {
    background: #f1f5f9;
    font-weight: 700;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

/* Cells */
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
    transform: scale(1.002);
}

/* ================= UNPRINTED / STATUS ROW ================= */
.Unprinted {
    background-color: #dcfce7 !important;
    font-weight: 700;
}

/* ================= STATUS TEXT ================= */
td:nth-child(7),
td:nth-child(8) {
    font-weight: 700;
}

/* ================= ACTION ICONS ================= */
.btn-sm i {
    transition: transform 0.15s ease, opacity 0.15s ease;
}

.btn-sm:hover i {
    transform: scale(1.25);
    opacity: 0.9;
}

/* ================= DATATABLE CONTROLS ================= */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px;
    padding: 4px 10px;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 10px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .card-header h3 {
        text-align: center;
    }

    .card .btn {
        width: 100%;
    }
}
</style>

    
<script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
  });
</script>
<div class="container-fluid ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif
@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif


    <div class="card my-3">
        <div class="card-header">
     <h3> Part bill list </h3>
        </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">


             <a href="{{url('/kots/create')}}" class="btn btn-success">New Service bill</a>
             <a href="{{url('/kots_cleared/kot')}}" class="btn btn-primary">Cleared service List </a>
             {{-- <a href="{{url('/kichen_dashboard')}}" class="btn btn-warning">Kitchen Dashboard </a> --}}
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Date  </th>
                    <th scope="col"> Part No    </th>
                    <th scope="col"> Service On </th>
                    <th scope="col"> Total Qty </th>
                    <th scope="col"> Total Amount </th>
                    <th scope="col"> Bill Print Status </th>
                    <th scope="col"> Status </th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($kots as $record)
                    
                  <tr class="{{$record->ready_to_serve}}">
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td scope="col">{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}</td>
                     <td>{{$record['bill_no']}}</td>
                     <td>{{$record->room_nos}}</td>
                     <td>{{$record['total_qty']}}</td>
                     <td>{{$record['total_amount']}}</td> 
                     <td>{{$record['ready_to_serve']}}</td> 
                     <td>{{$record['status']}}</td> 


                    

                  <td>
                    <a href="{{ url('kot_print', [$record['user_id'], $record['voucher_no']]) }}" class="btn btn-sm">
                      <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                  </a>
                  
                </td>

                     <td>
                      <a href="{{ url('kot_print_view', [$record['user_id'], $record['voucher_no']]) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                  </td> 
                  <td>
                      <a href="{{ url('kot_edit', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('kots.destroy', $record['voucher_no']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this  Record ?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
                      </form>
                  </td>
                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection