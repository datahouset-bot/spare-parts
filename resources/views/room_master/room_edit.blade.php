@extends('layouts.blank')

@section('pagecontent')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('general_assets/css/table.css') }}">

<div class="container">
    @if(session('message'))
        <div class="alert alert-primary">
            {{ session('message') }}
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-header">
            Update Room
        </div>
        <div class="card-body">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
<div class="modal-body">
    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')
                            <div>

                            Room No  <input type="text" name ="room_no"class="form-control" value="{{$room->room_no}}">
                            <span class="text-danger"> 
                              @error('room_no')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Room Type     <select  name ="roomtype_id" id ="myitemgroup"class="myitemgroup form-select" aria-label="Default select example">
                              <option  value ="" selected disabled>Select Room Type</option>
                            @foreach ($roomtype as $record2 )
                                                       
                              <option value={{$record2['id']}}>{{$record2['roomtype_name']}}&nbsp;||&nbsp; {{$record2['room_tariff']}}&nbsp;||&nbsp;{{$record2->gstmaster->taxname}}</option>
                              @endforeach 
                            </select>
                            <span class="text-danger"> 
                              @error('roomtype_id')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Floor   <select  name ="room_floor" id ="myitemgroup"class="myitemgroup form-select" aria-label="Default select example">
                              <option  value ="" selected disabled>Select Room Floor</option>
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
                          </div> 
                          <div> 
                            Facilities  <input type="text" name ="room_facilities"class="form-control" placeholder="Room Facilities  ">
                            <span class="text-danger"> 
                              @error('room_facilities')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div> 
                            Room Image 1  <input type="file" name ="room_image1"class="form-control" >
                            <span class="text-danger"> 
                              @error('room_image1')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div> 
                            Room Image 2  <input type="file" name ="room_image2"class="form-control" >
                            <span class="text-danger"> 
                              @error('room_image2')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div> 
                            Room Image 3  <input type="file" name ="room_image3"class="form-control" >
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
    </div>
</div>

@endsection
