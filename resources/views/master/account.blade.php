
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
    background: #f4f6f9;
}

/* ================= CARD ================= */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 10px 28px rgba(0,0,0,0.08);
}

.card-header {
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    padding: 14px 20px;
}

/* ================= ACTION BAR ================= */
.action-bar {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin: 12px 0;
}

.action-bar .btn {
    border-radius: 20px;
    font-weight: 600;
    padding: 6px 16px;
}

/* ================= TABLE ================= */
.table {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
}

.table thead th {
    background: #f1f3f9;
    color: #333;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    position: sticky;
    top: 0;
    z-index: 1;
}

.table tbody tr:hover {
    background: #f8f9fc;
}

/* ================= ICON ACTIONS ================= */
.action-icon {
    font-size: 18px;
    margin: 0 6px;
    transition: transform .2s, color .2s;
}

.action-icon:hover {
    transform: scale(1.2);
}

.icon-view { color: #1cc88a; }
.icon-edit { color: #4e73df; }
.icon-delete { color: #e74a3b; }

/* ================= DATATABLE SEARCH ================= */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px;
    padding: 6px 14px;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 8px;
}

/* ================= ALERT ================= */
.alert {
    border-radius: 12px;
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
@if(session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
@endif

    <div class="card my-3">
        <div class="card-header">
         Account List 
        </div>
    <div class="action-bar">
    <a href="{{ url('/accountform') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Add Account
    </a>
    <a href="{{ url('/account_dt') }}" class="btn btn-success">
        <i class="fa fa-table"></i> Data Table
    </a>
    <a href="{{ url('/account_import') }}" class="btn btn-warning">
        <i class="fa fa-upload"></i> Import
    </a>
</div>

         
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Account Name</th>
                    <th scope="col">Group</th>
                    <th scope="col">Op.Balnce</th>
                    <th scope="col">Bal.Type</th>
                    {{-- <th scope="col">Address</th> --}}
                    <th scope="col">City</th>
                    {{-- <th scope="col">State</th> --}}
                    <th scope="col">Phone</th>
                    <th scope="col">Mobile</th>
                    {{-- <th scope="col">Email</th>
                    <th scope="col">Person Name</th> --}}
                    <th scope="col">GST No </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>

                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($data as $record)
                    
                  <tr>
                    {{-- <th scope="row">{{$record['id']}}</th> --}}
       <th class="text-center">{{$r1=$r1+1}}</th>
                    <td>{{$record['account_name']}}</td>
                    <td>{{$record->accountgroup->account_group_name}}</td>
                    <td>{{$record['op_balnce']}}</td>
                    <td>{{$record['balnce_type']}}</td>
                    {{-- <td>{{$record['address']}}</td> --}}
                    <td>{{$record['city']}}</td>
                    {{-- <td>{{$record['state']}}</td> --}}
                    <td>{{$record['phone']}}</td>
                    <td>{{$record['mobile']}}</td>
                    {{-- <td>{{$record['email']}}</td>
                    <td>{{$record['person_name']}}</td> --}}
                    <td>{{$record['gst_no']}}</td>
                   <td class="text-center">
    <a href="{{ 'accountformview/'.$record['id'] }}" title="View">
        <i class="fa fa-eye action-icon icon-view"></i>
    </a>
</td>
<td class="text-center">
    <a href="{{ 'showeditaccount/'.$record['id'] }}" title="Edit">
        <i class="fa fa-edit action-icon icon-edit"></i>
    </a>
</td>
<td class="text-center">
    <a href="{{ 'deleteaccount/'.$record['id'] }}"
       title="Delete"
       onclick="return confirm('Are you sure you want to delete this account?')">
        <i class="fa fa-trash action-icon icon-delete"></i>
    </a>
</td>

                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection