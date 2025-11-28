<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<div class="container ">

    <div class="card my-3">
        <div class="card-header">
       Lable List 
        </div>
       <div class="row ">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mymodel2">
          Modify Label 
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
                          <form action="{{url('/update_lable')}}" method="post">
                            @csrf
                            @method('PUT')

                            @foreach ($data as $index => $label)
                            <label for="">{{ $label->id }}</label>
                            <input type="hidden" name="labels[{{ $index }}][id]" value="{{ $label->id }}">
                            
                            <div class="mb-2">
                                <label>Field Name</label>
                                <input type="text" name="labels[{{ $index }}][field_name]" class="form-control" value="{{ $label->field_name }}">
                            </div>
                            <div class="mb-2">
                                <label>Replaced Field Name</label>
                                <input type="text" name="labels[{{ $index }}][replaced_field_name]" class="form-control" value="{{ $label->replaced_field_name }}">
                            </div>
                            <div class="mb-2">
                                <label>Visibility (0 or 1)</label>
                                <input type="text" name="labels[{{ $index }}][is_visible]" class="form-control" value="{{ $label->is_visible }}">
                            </div>
                            <hr>
                        @endforeach
                    
                        <button type="submit" class="btn btn-primary">Update All Labels</button>
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