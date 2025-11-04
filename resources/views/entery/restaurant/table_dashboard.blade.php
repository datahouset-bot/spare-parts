 {{-- @if($kot_Unprinted > 0 || $Rkot_Unprinted > 0)
    <style>
        .kot-alert-row {
            background-color: #ffe6e6; /* Light red background for row */
            color: #d60000;
            font-weight: bold;
        }

        .blinking-bulb {
            display: inline-block;
            width: 14px;
            height: 14px;
            margin-right: 8px;
            background-color: red;
            border-radius: 50%;
            animation: blinker 1.2s linear infinite;
            box-shadow: 0 0 6px red;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .kot-link {
            text-decoration: none;
            color: #d60000;
            font-size: 16px;
        }

        .kot-link:hover {
            text-decoration: underline;
        }
    </style>

    @if($kot_Unprinted > 0)
        <tr class="kot-alert-row">
            <th>
                <span class="blinking-bulb"></span>
                <a href="{{ route('kots.index') }}" class="kot-link">Room Kot Unprinted - {{ $kot_Unprinted }}</a>
            </th>
        </tr>
    @endif

    @if($Rkot_Unprinted > 0)
        <tr class="kot-alert-row">
            <th>
                <span class="blinking-bulb"></span>
                <a href="{{ url('/restaurant_kot') }}" class="kot-link">Restaurant Kot Unprinted - {{ $Rkot_Unprinted }}</a>
            </th>
        </tr>
    @endif
@endif --}}

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
        border: 2px solid #f30606;
        padding: 5px;
        margin: 5px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(209, 63, 63, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        /* background-color: mintcream; */
    }
    .room-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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
           <div class="colour_code col-md-6">
<button class="btn btn-danger" onclick="window.location.href='{{ url('showShiftTableForm') }}'">Shift Table</button>

           </div>
           <div class="col-md-12">
            @if($kot_Unprinted > 0 || $Rkot_Unprinted > 0)
    <style>
        .kot-alert-row {
            background-color: #ffe6e6; /* Light red background for row */
            color: #d60000;
            font-weight: bold;
        }

        .blinking-bulb {
            display: inline-block;
            width: 14px;
            height: 14px;
            margin-right: 8px;
            background-color: red;
            border-radius: 50%;
            animation: blinker 1.2s linear infinite;
            box-shadow: 0 0 6px red;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .kot-link {
            text-decoration: none;
            color: #d60000;
            font-size: 16px;
        }

        .kot-link:hover {
            text-decoration: underline;
        }
    </style>

    @if($kot_Unprinted > 0)
        <tr class="kot-alert-row">
            <th>
                <span class="blinking-bulb"></span>
                <a href="{{ route('kots.index') }}" class="kot-link">Room Kot Unprinted - {{ $kot_Unprinted }}</a>
            </th>
        </tr>
    @endif

    @if($Rkot_Unprinted > 0)
        <tr class="kot-alert-row">
            <th>
                <span class="blinking-bulb"></span>
                <a href="{{ url('/restaurant_kot') }}" class="kot-link">Restaurant Kot Unprinted - {{ $Rkot_Unprinted }}</a>
            </th>
        </tr>
    @endif
@endif
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

    <div class="row ">
        {{-- @foreach($data as $record)
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
        @endforeach --}}
        @php
    // Group tables by `table_group`, treating NULL/empty as 'NULL'
    $grouped = $data->groupBy(function($item) {
        return $item->table_group ?: 'NULL';
    });

    // Desired display order
    $groupOrder = ['NULL', 'TakeAway', 'Nc'];
    $otherGroups = $grouped->keys()->diff($groupOrder);
    $orderedGroups = collect($groupOrder)->merge($otherGroups);
@endphp

@foreach($orderedGroups as $group)
    <div class="col-12 text-center" style="background-color: yellowgreen">
        <span class="text-center" style="font-weight: 800px; font-size: large; color: black; text-align: center;">
            {{ $group === 'NULL' ? 'General' : ucfirst($group) }}
        </span>
        
    </div>

    @foreach($grouped[$group] ?? [] as $record)
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mt-1">
            @php
                $tableClass = 'vacant';
                foreach($kotlist as $kot) {
                    if ($kot->service_id == $record->id) {
                        $tableClass = 'green';
                        break;
                    }
                }
            @endphp

            <div class="room-box {{ $tableClass }}">
                <h5 class="room-no" onclick="toggleRoomDetail(this)">Slot{{ $record->table_name }}</h5>
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
<hr>
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
