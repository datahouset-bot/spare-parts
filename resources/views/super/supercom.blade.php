<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
    
{{-- <script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
  });
</script> --}}
<style>
/* ===============================
   GLOBAL POLISH
================================ */
body {
    background: #f5f7fb;
    font-size: 14px;
}

.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
}

.card-header {
    background: linear-gradient(135deg, #0d6efd, #084298);
    color: #fff;
    font-weight: 600;
    font-size: 16px;
    padding: 12px 16px;
}

/* ===============================
   BUTTONS
================================ */
.btn-primary {
    background: #0d6efd;
    border-radius: 6px;
}

.btn-sm {
    padding: 4px 8px;
}

/* ===============================
   MODAL
================================ */
.modal-content {
    border-radius: 10px;
}

.modal-header {
    background: #0d6efd;
    color: #fff;
}

.modal-header .btn-close {
    filter: invert(1);
}

.modal-body input {
    margin-bottom: 10px;
}

/* ===============================
   TABLE
================================ */
.table {
    font-size: 13px;
    white-space: nowrap;
}

.table thead th {
    background: #1e293b;
    color: #fff;
    text-align: center;
    vertical-align: middle;
}

.table tbody td {
    vertical-align: middle;
    text-align: center;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8fafc;
}

/* ===============================
   DATATABLE WRAPPER
================================ */
.table-scrollable {
    overflow-x: auto;
    padding: 10px;
}

/* ===============================
   ICON BUTTONS
================================ */
.action-btn i {
    font-size: 18px;
}

.action-btn:hover {
    transform: scale(1.1);
}

/* ===============================
   HEADER BUTTON ROW
================================ */
.header-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

/* ===============================
   DATATABLE BUTTONS
================================ */
.dt-buttons button {
    border-radius: 6px !important;
    font-size: 13px !important;
    margin-right: 4px;
}
</style>

<div class="container-fluid ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-1">
        {{-- <div class="card-header">
    Company List 
        </div> --}}
       <div class="row my-2">
        <div class="card-header header-actions">
    <span>Company / Firm List</span>

    <button type="button"
        class="btn btn-light btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#myModal">
        <i class="fa fa-plus"></i> Add Company
    </button>
</div>
</div>
        
          <div class="container mt-1">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Company / Firm / </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('super_comp_lists.store')}}" method="POST">
                            @csrf
                            <div>

                            Firm Id   <input type="text" name ="firm_id"class="form-control" placeholder="Firm ID  ">
                            <span class="text-danger"> 
                              @error('firm_id')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                          Firm Name   <input type="text" name ="firm_name"class="form-control" placeholder="Firm Name">
                            <span class="text-danger"> 
                              @error('firm_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            Firm Mobile <input type="text" name ="firm_mobile"class="form-control" placeholder="Other">
                            <span class="text-danger"> 
                              @error('firm_mobile')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            Firm Dealer <input type="text" name ="firm_dealer"class="form-control" placeholder="firm_dealer">
                            <span class="text-danger"> 
                              @error('firm_dealer')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Activation Date  <input type="date" name ="activation_date"class="form-control" placeholder="Activation Date">
                            <span class="text-danger"> 
                              @error('activation_date')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Expiry Date <input type="date" name ="expiry_date"class="form-control" placeholder="Exipry Date">
                            <span class="text-danger"> 
                              @error('expiry_date')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Billing Amount <input type="text" name ="billing_amt"class="form-control" placeholder="Billing Amt">
                            <span class="text-danger"> 
                              @error('billing_amt')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>

                            <div>

                            Business <input type="text" name ="comp_af1"class="form-control" placeholder="Business">
                            <span class="text-danger"> 
                              @error('comp_af1')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>
                             Whatsapp <input type="text" name ="comp_af2"class="form-control" placeholder="whtsapp">
                            <span class="text-danger"> 
                              @error('comp_af2')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>
                             Wp start  to End<input type="text" name ="comp_af3"class="form-control" placeholder="whatsapp satrt and end">
                            <span class="text-danger"> 
                              @error('comp_af3')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>
                             Wp Amount<input type="text" name ="comp_af4"class="form-control" placeholder="whatsapp amount">
                            <span class="text-danger"> 
                              @error('comp_af4')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>
                             Remark1<input type="text" name ="comp_af5"class="form-control" placeholder="remark">
                            <span class="text-danger"> 
                              @error('comp_af5')
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

           
        {{-- <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myModal').trigger('focus');
            });


        </script> --}}
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Firm Id  </th>
                    <th scope="col"> Firm Name  </th>
                    <th scope="col"> Firm Mobile  </th>
                    <th scope="col"> Firm  Daeler   </th>
                    <th scope="col"> Activation Date   </th>
                    <th scope="col"> Expiery Date  </th>
                    <th scope="col"> Billing Amount  </th>
                    <th scope="col"> Chekins  </th>

                    <th scope="col"> 1 </th>
                    <th scope="col"> 2 </th>
                    <th scope="col"> 3 </th>
                    <th scope="col"> 4  </th>
                    <th scope="col"> 5  </th>
                    <th scope="col"> 6  </th>
                    <th scope="col">   </th>
                    <th scope="col">   </th>
                    <th scope="col">   </th>
                    <th scope="col">   </th>

                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($data as $record)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td>{{$record->firm_id}}</td>
                    <td>{{$record->firm_name}}</td>
                    <td>{{$record->firm_mobile}}</td>
                    <td>{{$record->firm_dealer}}</td>
                    <td>{{ \Carbon\Carbon::parse($record->activation_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->expiry_date)->format('d-m-Y') }}</td>
                    
                    <td>{{$record->billing_amt}}</td>




                    <td>{{ $record->total_roomcheckouts }}</td>

                    <td>{{$record->comp_af1}}</td>
                    <td>{{$record->comp_af2}}</td>
                    <td>{{$record->comp_af3}}</td>
                    <td>{{$record->comp_af4}}</td>
                    <td>{{$record->comp_af5}}</td>
                    <td>{{$record->comp_af6}}</td>

                    
                 <td class="d-flex gap-1 justify-content-center">
    <a href="{{ route('super_comp_lists.edit', $record->id) }}"
       class="btn btn-outline-primary btn-sm action-btn">
        <i class="fa fa-edit"></i>
    </a>
                 </td>
<td>
    <a href="{{ url('/seed', $record->firm_id) }}"
       class="btn btn-outline-success btn-sm">
        Seed
    </a>
  </td>
<td>
    <a href="{{ url('/trandelete', $record->firm_id) }}"
       class="btn btn-outline-warning btn-sm">
        Tran
    </a>
  </td>
  <td>
    <form action="{{ route('super_comp_lists.destroy', $record->id) }}"
          method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger btn-sm"
                onclick="return confirm('Delete this firm?')">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</td>

                  </tr>
                  @endforeach
                  
                  
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
 $(document).ready(function () {
    new DataTable('#remindtable', {
        responsive: true,
        scrollX: true,
        pageLength: 25,
        layout: {
            topStart: {
                buttons: [
                    { extend: 'copy', className: 'btn btn-light btn-sm' },
                    { extend: 'excel', className: 'btn btn-light btn-sm' },
                    { extend: 'pdf', className: 'btn btn-light btn-sm' },
                    { extend: 'print', className: 'btn btn-light btn-sm' }
                ]
            }
        }
    });
});

</script>

@endsection