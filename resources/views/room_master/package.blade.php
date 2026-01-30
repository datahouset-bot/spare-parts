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
<style>
/* ===== PAGE BACKGROUND ===== */
body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
}

/* ===== CARD ===== */
.card {
    border-radius: 18px;
    border: none;
    box-shadow: 0 14px 32px rgba(0,0,0,0.12);
    animation: fadeSlide 0.6s ease;
}

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(18px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== CARD HEADER ===== */
.card-header {
    background: linear-gradient(135deg, #6366f1, #1e3a8a);
    color: #fff;
    padding: 18px 22px;
    border-radius: 18px 18px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 22px;
    font-weight: 700;
}

/* ===== ACTION BAR ===== */
.action-bar {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin: 16px 0;
}

/* ===== BUTTONS ===== */
.btn-primary {
    border-radius: 30px;
    font-weight: 600;
    padding: 8px 24px;
    transition: all .25s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(99,102,241,.45);
}

.btn-info {
    border-radius: 30px;
    font-weight: 600;
}

/* ===== TABLE ===== */
.table {
    border-radius: 14px;
    overflow: hidden;
}

.table thead th {
    background: #eef2ff;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
}

.table tbody tr {
    transition: all .25s ease;
}

.table tbody tr:hover {
    background: #f1f5ff;
    transform: scale(1.01);
}

/* ===== ICON ACTIONS ===== */
.fa-edit, .fa-trash {
    transition: transform .2s ease, color .2s ease;
}

.fa-edit:hover {
    transform: scale(1.25);
    color: #6366f1 !important;
}

.fa-trash:hover {
    transform: scale(1.25);
    color: #dc2626 !important;
}

/* ===== MODAL ===== */
.modal-content {
    border-radius: 18px;
    animation: zoomIn .3s ease;
}

@keyframes zoomIn {
    from { transform: scale(.92); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.modal-header {
    background: linear-gradient(135deg, #6366f1, #1e3a8a);
    color: #fff;
    border-radius: 18px 18px 0 0;
}

/* ===== FORM INPUTS ===== */
.form-control {
    border-radius: 10px;
    border: 2px solid #c7d2fe;
}

.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.25);
}

/* ===== DATATABLE SEARCH ===== */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px;
    padding: 6px 14px;
}
</style>

<div class="container-fluid px-3 ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
        Service type 
        </div>
       <div class="row my-2">
       <div class="action-bar">
    <button type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#myModal">
        <i class="fa fa-plus"></i> Add Package
    </button>

    <button class="btn btn-info">
        <i class="fa fa-download"></i> Export
    </button>
</div>

        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('packages.store')}}" method="POST">
                            @csrf
                            <div>

                            Package Name  <input type="text" name ="package_name"class="form-control" placeholder="Package ">
                            <span class="text-danger"> 
                              @error('package_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Plan  <input type="text" name ="plan_name"class="form-control" placeholder="Service Plan">
                            <span class="text-danger"> 
                              @error('plan_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            Amount  <input type="text" name ="other_name"class="form-control" placeholder="Enter Charge (Only Numeric)">
                            <span class="text-danger"> 
                              @error('other_name')
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
                    <th scope="col"> Package  </th>
                    <th scope="col"> Plan </th>
                    <th scope="col"> Amount </th>
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
                    <td>{{$record['package_name']}}</td>
                    <td>{{$record['plan_name']}}</td>
                    <td>{{$record['other_name']}}</td>


                    
                  <td>
                      <a href="{{ route('packages.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('packages.destroy', $record['id']) }}" method="POST" style="display:inline;">
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
<script>
  $(document).ready(function () {
    new DataTable('#remindtable', {
        pageLength: 10,
        responsive: true,
        ordering: true,
        language: {
            search: "🔍 Search Package:",
            lengthMenu: "Show _MENU_ packages",
            info: "Showing _START_ to _END_ of _TOTAL_ packages"
        }
    });
});

</script>

@endsection