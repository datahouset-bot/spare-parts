@extends('layouts.blank')
@section('pagecontent')
<style>
    .custom-row {
        margin-right: -5px;
        margin-left: -5px;
    }
    .custom-row > [class*='col-'] {
        padding-right: 5px;
        padding-left: 5px;
    }
    .room-box {
        border: 2px solid #ccc;
        padding: 5px;
        margin: 0px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: mintcream;
    }
    h5 {
        text-align: center;
    }
    p {
        font-size: 13px;
        font-weight: 500;
        font-style: bold;
        text-align: center;
    }
    .room-box.green {
        background-color: green;
        color: white;
    }
    .links {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    .linkitem {
        margin: 0;
        padding: 0;
        background-color: red;
        align-items: left;
        font-size: 5px;
        max-height: 100%;
        max-width: 100%;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-weight: 700;
        font-style: bold;
        color: white;
        border: 2px solid aqua;
    }
    .buttonlink {
        height: 100%;
        width: 100%;
        background-color: white;
        transition-duration: 0.4s;
    }
    .buttonlink:hover {
        background-color: #dee1f0;
        color: rgb(255, 255, 255);
    }
    .colour_code {
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-style: bold;
        font-weight: 500;
        text-align: left;
        background-color: rgb(228, 237, 240);
    }
    .occupied {
        background-color: green;
        color: white;
    }
    .dirty {
        background-color: red;
        color: white;
    }
</style>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-1">
           <div class="colour_code">
           </div>
           @if(isset($message))
           <div class="alert alert-info">{{ $message }}</div>
           @endif
        </div>
        <div class="col-md-6 mt-1">
            <label for="">Select Date</label>
            <div class="form-floating mb-3 mb-md-0">
             <form class="form-inline" action="{{url('room_dashboard')}}" method="POST" >
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control date" name="selected_date" id="selected_date">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="search_button" >
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
               </div>
             </form>
            </div>
          </div>
    </div>

    <div class="row">
        @foreach($data as $record)
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mt-1">
            @php
                // Determine the class for the room-box
                $tableClass = 'vacant';
                foreach($kotlist as $kot) {
                    if ($kot->service_id == $record->id) {
                        $tableClass = 'green';
                        break;
                    }
                }
            @endphp

            <div class="room-box {{ $tableClass }}">
                <h5 class="room-no" onclick="toggleRoomDetail(this)" >Table {{ $record->table_name }}</h5>
                <div class="links">
                    <a href="{{ url('table_kot_create/'.$record->id) }}">
                        <div class="linkitem">
                            <button class="buttonlink">
                                <i class="fas fa-bread-slice" style="font-size:20px;color:rgb(224, 20, 180)"></i>
                            </button>
                        </div>
                    </a>
                    <a href="{{ url('table_facthkot_records/'.$record->id) }}">
                        <div class="linkitem">
                            <button class="buttonlink">
                                <i class="fas fa-calculator" style="font-size:20px;color:black"></i>
                            </button>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets\js\form.js')}}"></script>
<script>
function toggleRoomDetail(element) {
    var roomDetail = element.nextElementSibling;
    if (roomDetail.style.display === "none" || roomDetail.style.display === "") {
        roomDetail.style.display = "block";
    } else {
        roomDetail.style.display = "none";
    }
}
</script>

@endsection
