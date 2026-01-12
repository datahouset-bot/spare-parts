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

<style>/* ==================================================
   PREMIUM ERP UI – BOLD & VISUAL (SAFE OVERRIDES)
================================================== */

/* ---------- PAGE & CARD ---------- */
body {
    background: #f1f5f9;
}

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

.btn-secondary {
    font-weight: 600;
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
    padding: 16px 20px;
}

.modal-title {
    font-size: 21px;
    font-weight: 800;
}

/* ---------- MODAL BODY TEXT ---------- */
.modal-body {
    font-size: 16px;
    font-weight: 600;
    color: #0f172a;
}

/* ---------- INPUTS ---------- */
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

/* Placeholder */
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

/* Hover */
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

<div class="container-fluid">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
          GST / VAT / TAX  Master 
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New GST / VAT / TAX %
      </button>
          </div></div>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add GST%</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('gstmasters.store')}}" method="POST">
                            @csrf
                            <div>

                              Tax Name <input type="text" name ="taxname"class="form-control" placeholder="Tax Name ">
                              <span class="text-danger"> 
                                @error('taxname')
                                {{$message}}
                                    
                                @enderror
                              </span>
                            </div>
                            <div>

                             HSN NO  <input type="text" name ="hsn_no"class="form-control" placeholder="HSN No ">
                              <span class="text-danger"> 
                                @error('hsn_no')
                                {{$message}}
                                    
                                @enderror
                              </span>
                            </div>
                            
                            <div>

                            SGST % <input type="text" name ="sgst"class="form-control" placeholder="SGST ">
                            <span class="text-danger"> 
                              @error('sgst')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            CGST %  <input type="text" name ="cgst"class="form-control" placeholder="CSGST">
                            <span class="text-danger"> 
                              @error('cgst')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            IGST %  <input type="text" name ="igst"class="form-control" placeholder="IGST">
                            <span class="text-danger"> 
                              @error('igst')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <hr class="divider">
                          For Other Countery  Who Have Vat Or Other  than  GST
                          <hr>
                          <div>

                            VAT %  <input type="text" name ="vat"class="form-control" placeholder="VAT">
                            <span class="text-danger"> 
                              @error('vat')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX1 %  <input type="text" name ="tax1"class="form-control" placeholder="TAX 1">
                            <span class="text-danger"> 
                              @error('tax1')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX2 %  <input type="text" name ="tax2"class="form-control" placeholder="TAX2">
                            <span class="text-danger"> 
                              @error('tax2')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX3 %  <input type="text" name ="tax3"class="form-control" placeholder="TAX 3">
                            <span class="text-danger"> 
                              @error('tax3')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX4 %  <input type="text" name ="tax4"class="form-control" placeholder="TAX 4">
                            <span class="text-danger"> 
                              @error('tax4')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX5 %  <input type="text" name ="tax5"class="form-control" placeholder="TAX 5">
                            <span class="text-danger"> 
                              @error('tax5')
                              {{$message}}
                                  
                              @enderror
                            </span>
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
                    <th scope="col"> NAME</th>
                    <th scope="col"> HSN No</th>
                    <th scope="col"> SGST % </th>
                    <th scope="col"> CGST % </th>
                    <th scope="col"> IGST % </th>
                    <th scope="col"> VAT % </th>
                    <th scope="col"> TAX1 % </th>
                    <th scope="col"> TAX2 % </th>
                    <th scope="col"> TAX3 % </th>
                    <th scope="col"> TAX4 % </th>
                    <th scope="col"> TAX5 % </th>
 
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
                    <td>{{$record['taxname']}}</td>
                    <td>{{$record['hsn_no']}}</td>
                    <td>{{$record['sgst']}}</td>
                    <td>{{$record['cgst']}}</td>
                    <td>{{$record['igst']}}</td>
                    <td>{{$record['vat']}}</td>
                    <td>{{$record['tax1']}}</td>
                    <td>{{$record['tax2']}}</td>
                    <td>{{$record['tax3']}}</td>
                    <td>{{$record['tax4']}}</td>
                    <td>{{$record['tax5']}}</td>


                    
                  <td>
                      <a href="{{ route('gstmasters.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('gstmasters.destroy', $record['id']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this package?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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