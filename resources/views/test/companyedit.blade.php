<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<div class="container ">

    <div class="card my-3">
        <div class="card-header">
         Company List 
        </div>
       <div class="row ">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mymodel2">
          Modify Company 
      </button>
          <button class="btn btn-info mx-2">Export</button></div></div>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="mymodel2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{url('/editcompany')}}" method="post">
                            @csrf
                            @method('PUT')

                            <div> <input type="hidden" value="{{ $data['id'] }}" name="id"></div>


                            Company Name  <input type="text" name ="comp_name"class="form-control" value="{{ $data['comp_name'] }}">
                            <span class="text-danger"> 
                              @error('comp_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                            
                           Company Dis %  <input type="text" name ="comp_dis" class="form-control" value="{{ $data['comp_dis'] }}">
                           <span class="text-danger"> 
                            @error('comp_dis')
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
            $('#mymodel2').on('shown.bs.modal', function () {
                $('#mymodel2').trigger('focus');
            });
        </script>
    



          {{-- data table start  --}}
        {{-- <div class="card-body">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Company</th>
                    <th scope="col">Dis %</th>
                    <th scope="col"></th>
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
                    <td>{{$record['comp_name']}}</td>
                    <td>{{$record['comp_dis']}}</td>

                    <td><a href="{{('itemformview/'.$record['id']) }}"  class="btn btn-info btn-sm">View</a></td>
                    <td><a href="{{('showeditecompany/'.$record['id']) }}"  class="btn btn-primary btn-sm">Edit</a></td>
                    <td><a href="{{('deletecompany/'.$record['id']) }}"  class="btn btn-danger btn-sm">Delete</a></td>
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div> --}}
    </div>
</div>

@endsection