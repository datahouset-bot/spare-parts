<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
    
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
<style>
  /* ==================================================
   COMPANY LIST – PREMIUM ERP UI
   (NO HTML / JS CHANGES)
================================================== */

/* ---------- PAGE BACKGROUND ---------- */
body {
    background: #f1f5f9;
}

/* ---------- CARD ---------- */
.card {
    border-radius: 18px;
    border: none;
    box-shadow: 0 14px 40px rgba(0,0,0,0.12);
}

/* ---------- CARD HEADER ---------- */
.card-header {
    background: linear-gradient(135deg, #1e40af, #2563eb);
    color: #ffffff;
    font-size: 22px;
    font-weight: 800;
    letter-spacing: 0.4px;
    padding: 18px 22px;
    border-radius: 18px 18px 0 0;
}

/* ---------- TOP BUTTONS ---------- */
.btn {
    font-size: 16px;
    font-weight: 700;
    border-radius: 10px;
    padding: 10px 20px;
}

.btn-primary {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
}

.btn-info {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    border: none;
}

/* ---------- MODAL ---------- */
.modal-content {
    border-radius: 18px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
}

.modal-header {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #ffffff;
    border-radius: 18px 18px 0 0;
}

.modal-title {
    font-size: 21px;
    font-weight: 800;
}

/* ---------- FORM INPUTS ---------- */
.form-control {
    height: 48px;
    border-radius: 12px;
    border: 2px solid #334155;
    font-size: 16px;
    font-weight: 600;
    padding: 10px 14px;
}

.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37,99,235,0.25);
}

.form-control::placeholder {
    font-weight: 500;
    color: #64748b;
}

/* ---------- TABLE ---------- */
.table {
    font-size: 16px;
    border-collapse: separate;
    border-spacing: 0 6px;
}

/* Table Header */
.table thead th {
    background: #e2e8f0;
    font-weight: 800;
    font-size: 15px;
    color: #0f172a;
    text-transform: uppercase;
    padding: 14px 12px;
}

/* Table Body */
.table tbody td,
.table tbody th {
    font-weight: 600;
    color: #1e293b;
    padding: 14px 12px;
    background: #ffffff;
}

/* Hover Effect */
.table tbody tr:hover td {
    background: #e0f2fe;
}

/* ---------- ACTION ICONS ---------- */
.table .fa {
    font-size: 22px !important;
    transition: transform 0.25s ease;
}

.table .fa-edit {
    color: #2563eb !important;
}

.table .fa-trash {
    color: #dc2626 !important;
}

.table .fa:hover {
    transform: scale(1.3);
}

/* ---------- DATATABLE SEARCH ---------- */
.dataTables_wrapper .dataTables_filter input {
    height: 42px;
    border-radius: 10px;
    border: 2px solid #334155;
    font-size: 16px;
    font-weight: 600;
    padding: 6px 12px;
}

/* ---------- PAGINATION ---------- */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    font-size: 15px;
    font-weight: 600;
    border-radius: 8px;
    margin: 2px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    color: #ffffff !important;
}

/* ---------- ALERTS ---------- */
.alert {
    font-size: 16px;
    font-weight: 700;
    border-radius: 12px;
}

</style>


    <div class="card my-3">
        <div class="card-header">
          Account Group List  
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add Account Group 
      </button>
          <button class="btn btn-info mx-2">Export</button></div></div>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Account Group</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{url('/accountgroups')}}" method="POST">
                            @csrf
                            <div>

                           Account Group Name   <input type="text" name ="account_group_name"class="form-control" placeholder="Account Group Name  ">
                            <span class="text-danger"> 
                              @error('account_group_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                            Primary Group Name  <select name="primary_group_id" class="form-control">
                              <option value="" selected disabled>Select Primary Group </option>
                              @foreach ($primarygroups as $primarygroup )
                              <option value="{{$primarygroup->id}}">{{$primarygroup->primary_group_name}}</option>
                                
                              @endforeach

                            </select>
                          </div>
                          
                          <div class="col-md-12 mt-2">
                        
                        </div>    

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                          </form>
                         
                          </div>
                    </div>
                </div>
            </div>
        </div>
    
        <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myModal').trigger('focus');
            });
        </script>
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Account Group Name  </th>
                    <th scope="col"> Account Primary Group </th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($data as $record)
                    
                  <tr>
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td>{{$record->account_group_name}}</td>
                    <td>{{ $record->primarygroup->primary_group_name }}</td>

                    <td>
                      <a href="{{ route('accountgroups.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>

                    
                    </td>
                    <td> <form action="{{ route('accountgroups.destroy', $record['id']) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this account group?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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