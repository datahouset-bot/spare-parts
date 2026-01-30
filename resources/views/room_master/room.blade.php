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
    box-shadow: 0 14px 30px rgba(0,0,0,0.12);
    animation: fadeUp 0.6s ease;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== HEADER ===== */
.card-header {
    background: linear-gradient(135deg, #6366f1, #1e3a8a);
    color: #fff;
    border-radius: 18px 18px 0 0;
    padding: 18px;
    font-size: 22px;
    font-weight: 700;
    text-align: center;
    letter-spacing: 1px;
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
    box-shadow: 0 6px 18px rgba(99,102,241,0.45);
}

.btn-outline-primary {
    border-radius: 50%;
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

/* ===== ICONS ===== */
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
    from { transform: scale(0.92); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.modal-header {
    background: linear-gradient(135deg, #6366f1, #1e3a8a);
    color: #fff;
    border-radius: 18px 18px 0 0;
}

/* ===== FORM INPUTS ===== */
.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #c7d2fe;
}

.form-control:focus, .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.25);
}

/* ===== DATATABLE SEARCH ===== */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px;
    padding: 6px 14px;
}
</style>


<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif
@if(session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif


    <div class="card my-3">
        <div class="card-header">
        slot
        </div>
      <div class="action-bar">
    <button type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#myModal">
        <i class="fa fa-plus"></i> Add Slot
    </button>
</div>

        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add slot </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('rooms.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>

                           slot No  <input type="text" name ="room_no"class="form-control" placeholder="slot No  ">
                            <span class="text-danger"> 
                              @error('room_no')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <label class="form-label">Service Type</label>

<div class="input-group">
    <select name="roomtype_id"
            id="myitemgroup"
            class="myitemgroup form-select">
        <option value="" selected disabled>Select service</option>

        @foreach ($data2 as $record2)
            <option value="{{ $record2['id'] }}">
                {{ $record2['roomtype_name'] }}
                || {{ $record2['room_tariff'] }}
                || {{ $record2->gstmaster->taxname }}
            </option>
        @endforeach
    </select>

    <!-- ➕ ADD SERVICE TYPE -->
    <a href="{{ url('/roomtypes') }}"
       class="btn btn-outline-primary"
       title="Add Service Type">
        <i class="fa fa-plus"></i>
    </a>
</div>

<span class="text-danger">
    @error('roomtype_id') {{ $message }} @enderror
</span>

                          {{-- <div> --}}
{{-- 
                          SLOT no  <select  name ="room_floor" id ="myitemgroup"class="myitemgroup form-select" aria-label="Default select example">
                              <option  value ="" selected disabled>Select Vehicle slot</option>
                              <option value=1>1</option>
                              <option value=2>2</option>
                              <option value=3>3</option>
                              <option value=4>4</option>
                              <option value=5>5</option>
                              <option value=6>6</option>
                              <option value=7>7</option>
                              <option value=8>8</option>
                              <option value=9>9</option>
                              <option value=10>10</option>
                              <option value=11>11</option>
                              <option value=12>12</option>
                              <option value=13>13</option>
                              <option value=14>14</option>
                              <option value=15>15</option>
                              </select>
                            <span class="text-danger"> 
                              @error('room_floor')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  --}}
                          <div> 
                            ADD ON's  <input type="text" name ="room_facilities"class="form-control" placeholder="Room Facilities  ">
                            <span class="text-danger"> 
                              @error('room_facilities')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div> 
                            Vehicle Image 1  <input type="file" name ="room_image1"class="form-control" >
                            <span class="text-danger"> 
                              @error('room_image1')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div> 
                           Vehicle Image 2  <input type="file" name ="room_image2"class="form-control" >
                            <span class="text-danger"> 
                              @error('room_image2')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div> 
                            Vehicle Image 3  <input type="file" name ="room_image3"class="form-control" >
                            <span class="text-danger"> 
                              @error('room_image3')
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
                    <th scope="col">slot No</th>
                    <th scope="col">Service Type</th>
                    {{-- <th scope="col">Vehicle no</th> --}}
                    <th scope="col">ADD ON's</th>
                    {{-- <th scope="col">Image 1</th>
                    <th scope="col">Image 2</th>
                    <th scope="col">Image 3</th> --}}
                    <th scope="col">EDIT</th>
                    <th scope="col">DELETE</th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($data3 as $record3)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td>{{$record3->room_no}}</td>
                    <td>{{$record3->roomtype->roomtype_name ?? 'N/A'}}</td>
                    {{-- <td>{{$record3->room_floor}}</td> --}}
                    <td>{{$record3->room_facilities}}</td>
                    {{-- <td>
                       <img src="{{ asset('storage/room_image/' . $record3->room_image1) }}" alt="qr_code" width="80px">                      
                  </td>
                  <td>
                    <img src="{{ asset('storage/room_image/' . $record3->room_image2) }}" alt="qr_code" width="80px">                      
               </td>
               <td>
                <img src="{{ asset('storage/room_image/' . $record3->room_image3) }}" alt="qr_code" width="80px">                      
           </td> --}}


                    
                  <td>
                      <a href="{{ route('rooms.edit', $record3['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('rooms.destroy', $record3['id']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this room')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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
            search: "🔍 Search Slot:",
            lengthMenu: "Show _MENU_ slots",
            info: "Showing _START_ to _END_ of _TOTAL_ slots"
        }
    });
});
$('#myModal').on('shown.bs.modal', function () {
    $(this).find('input:first').focus();
});

</script>

@endsection