<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
<script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
  });
</script>
<div class="container ">
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
      label Setting
  </div>

  <div class="row">
      <div class="col-md-12 text-center">
          <!-- Flex wrapper for inline buttons -->
          <div class="d-flex justify-content-center flex-wrap gap-2 align-items-center">

              <!-- Add New Company -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                  Add New field 
              </button>


          </div>
      </div>
  </div>


      
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      
      <script>
          $('#deleteUnusedBtn').on('click', function () {
              let confirmText = prompt("Type 'delete' to confirm deletion of all unused companies:");
      
              if (confirmText && confirmText.toLowerCase() === 'delete') {
                  $('#deleteUnusedForm').submit();
              } else {
                  alert("Deletion cancelled. You must type 'delete' exactly.");
              }
          });
      </script>
      
      
         
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Label Updation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{url('/save_batchseeting')}}" method="POST">
                            @csrf

                           Field Name  <input type="text" name ="field_name"class="form-control" placeholder="Field Name" autocomplete="off">
                            <span class="text-danger"> 
                              @error('field_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                            
                           New Field Name  <input type="text" name ="replaced_field_name" class="form-control" placeholder="New Name" autocomplete="off">
                           <span class="text-danger"> 
                            @error('replaced_field_name')
                            {{$message}}
                                
                            @enderror
                          </span>
                          visible <input type="text" name ="is_visible" class="form-control" placeholder="is visible " autocomplete="off">
                          <span class="text-danger"> 
                           @error('is_visible')
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
            <table class="table table-striped " id="remindtable">
                <thead>
                  <tr>

                    <th scope="col">Field Name</th>
                    <th scope="col">New Name</th>
                    <th scope="col">is visible</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($data as $record)
                    
                  <tr>
                    {{-- <th scope="row">{{$record['id']}}</th> --}}
                    <td>{{$record['field_name']}}</td>
                    <td>{{$record['replaced_field_name']}}</td>
                    <td>{{$record['is_visible']}}</td>

                    <td><a href="{{('batch_lebel_edit/'.$record['id']) }}"  ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a></td>
                    
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection