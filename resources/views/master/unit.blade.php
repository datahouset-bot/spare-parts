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