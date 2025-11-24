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
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New 
      </button>
          </div></div>
        
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
                          <div>

                            Service Type     <select  name ="roomtype_id" id ="myitemgroup"class="myitemgroup form-select" aria-label="Default select example">
                              <option  value ="" selected disabled>Select service</option>
                            @foreach ($data2 as $record2 )
                                                       
                              <option value={{$record2['id']}}>{{$record2['roomtype_name']}}&nbsp;||&nbsp; {{$record2['room_tariff']}}&nbsp;||&nbsp;{{$record2->gstmaster->taxname}}</option>
                              @endforeach
                            </select>
                            <span class="text-danger"> 
                              @error('roomtype_id')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
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

@endsection