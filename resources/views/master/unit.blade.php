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
      /* ================================
   GLOBAL PAGE POLISH
================================ */
body {
    background: #f1f5f9;
}

/* ================================
   CARD STYLING
================================ */
.card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.10);
}

.card-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: #fff;
    border-radius: 16px 16px 0 0;
    padding: 16px 20px;
}

.card-header h3 {
    margin: 0;
    font-weight: 700;
}

/* ================================
   TOP BUTTON BAR
================================ */
.card .btn {
    border-radius: 10px;
    font-weight: 600;
}

.card .btn-primary {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
}

.card .btn-info {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    border: none;
}

/* ================================
   MODAL UI
================================ */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.modal-header {
    background: #1e293b;
    color: #fff;
    border-radius: 16px 16px 0 0;
}

.modal-title {
    font-weight: 00;
}

.modal-body input.form-control {
    margin-bottom: 10px;
}

/* ================================
   INPUT POLISH
================================ */
.form-control {
    border-radius: 10px;
    border: 2px solid #334155;
    font-size: 19px;
}

.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.25);
}

/* ================================
   TABLE UI
================================ */
.table {
    font-size: 14px;
}

.table thead {
    background: #e2e8f0;
}

.table thead th {
    font-weight: 700;
    color: #0f172a;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8fafc;
}

.table tbody tr:hover {
    background-color: #e0f2fe;
}

/* ================================
   ACTION ICONS
================================ */
.table .btn-sm {
    padding: 6px 8px;
    border-radius: 8px;
}

.table .fa-edit {
    color: #2563eb !important;
    transition: transform 0.2s ease;
}

.table .fa-trash {
    color: #dc2626 !important;
    transition: transform 0.2s ease;
}

.table .fa-edit:hover,
.table .fa-trash:hover {
    transform: scale(1.25);
}

/* ================================
   DATATABLE SEARCH + PAGINATION
================================ */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 10px;
    border: 2px solid #334155;
    padding: 6px 10px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px;
    margin: 2px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #2563eb !important;
    color: #fff !important;
}

    </style>
<script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
  });
</script>
<div class="container-fluid">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
        
         <h3> Unit  List</h3> 
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New Unit
      </button>
          <button class="btn btn-info mx-2">Export</button></div></div>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Group</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{url('/units')}}" method="POST">
                            @csrf
                            <div>

                           Primary Unit Name   <input type="text" name ="primary_unit_name"class="form-control" placeholder="Primary Unit Name ">
                            <span class="text-danger"> 
                              @error('primary_unit_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                            Conversion  <input type="text" name ="conversion"class="form-control" placeholder="Conversion ">
                            <span class="text-danger"> 
                              @error('conversion')
                              {{$message}}
                                  
                              @enderror
                            </span>
                            Alternate Unit Name   <input type="text" name ="alternate_unit_name"class="form-control" placeholder="Alternate Unit Name">
                            <span class="text-danger"> 
                              @error('alternate_unit_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
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
                    <th scope="col"> Primary Unit Name  </th>
                    <th scope="col"> Conversion  </th>
                    <th scope="col"> Alternate Unit Name   </th>
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
                    {{-- <th scope="row">{{$record['id']}}</th> --}}
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td>{{$record['primary_unit_name']}}</td>
                    <td>{{$record['conversion']}}</td>
                    <td>{{$record['alternate_unit_name']}}</td>

                    <td>
                      <a href="{{ route('units.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>

                    
                    </td>
                    <td> <form action="{{ route('units.destroy', $record['id']) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this unit?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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