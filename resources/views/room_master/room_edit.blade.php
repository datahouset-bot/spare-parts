@extends('layouts.blank')

@section('pagecontent')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('general_assets/css/table.css') }}">

 <div class="container-fluid px-3">
    @if(session('message'))
        <div class="alert alert-primary">
            {{ session('message') }}
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-header">
            Update Slot Details
        </div>
        <div class="card-body">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-8">
<div class="modal-body">
    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
                            <div>

                            Slot No  <input type="text" name ="room_no"class="form-control" value="{{$room->room_no}}">
                            <span class="text-danger"> 
                              @error('room_no')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>
                            Service Type
                            <select name="roomtype_id" id="myitemgroup" class="myitemgroup form-select" aria-label="Default select example">
                                <option value="" disabled>Select service Type</option>
                                @foreach ($roomtype as $record2)
                                    <option value="{{ $record2['id'] }}" 
                                        @if (old('roomtype_id', $room->roomtype_id) == $record2['id']) selected @endif>
                                        {{ $record2['roomtype_name'] }}&nbsp;||&nbsp;{{ $record2['room_tariff'] }}&nbsp;||&nbsp;{{ $record2->gstmaster->taxname }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('roomtype_id')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        
                        <div>
                          Floor
                          <select name="room_floor" id="myitemgroup" class="myitemgroup form-select" aria-label="Default select example">
                            @for ($i = 1; $i <= 15; $i++)
                              <option value="{{ $i }}" @if (old('room_floor', $room->room_floor) == $i) selected @endif>{{ $i }}</option>
                            @endfor
                          </select>
                          <span class="text-danger">
                            @error('room_floor')
                              {{ $message }}
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>&nbsp; &nbsp;
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
