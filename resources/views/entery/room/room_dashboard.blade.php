<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    <style>
        .custom-row {
            margin-right: -5px;
            margin-left: -5px;
        }

        .custom-row>[class*='col-'] {
            padding-right: 5px;
            padding-left: 5px;
        }
    </style>

    <style>
        .room-box {

            border: 2px solid #f44336;
            padding: 5px;
            margin: 5px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: mintcream;
            transition: transform 0.3s, box-shadow 0.3s;
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
            /* color: blue;  */
            text-align: center;
        }

        .room-box.orange {
            background-color: orange;
            color: blue;
        }

        .room-box.orange a {
            background-color: orange;
            color: blue;
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
            /* Green */
            color: rgb(255, 255, 255);
        }

        .colour_code {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;

            font-style: bold;
            font-weight: 500;
            text-align: left;
            background-color: rgb(209, 228, 235);
        }

        .occupied {
            background-color: green;
            color: white;

        }

        .dirty {
            background-color: red;
            color: white;

        }

        button {
            border: 0px;
            margin: 1px;
            margin-right: 1px;
            color: black;
            font-size: large;
            font-weight: 400;
            border: 1px solid white;
        }
    </style>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-1">
                <div class="colour_code">
                    <button style="background-color: mintcream">Vacant</button>
                    {{-- <button style="background-color:orange">Booked</button> --}}
                    <button style="background-color: green">on Working</button>
                    <button style="background-color: red">ready to out</button>&nbsp;&nbsp;
                    @can('Vacant_All_Room')
                        <button style="background-color: mintcream" onclick="confirmAction()">Vacant All</button>
                    @endcan

                    <button style="background-color: red"
                        onclick="window.location.href='{{ url('/mark_room_dirty') }}'">pending vehicles</button>
                    <table class="table table-striped">
                        <thead>
                            <tr>

                                <th>Vacant -{{ $vacantroom }}</th>
                                <th>Occupied-{{ $occupiedroom }}</th>
                                <th>Move out-{{ $dirtyroom }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                            <td>{{$roomcheckin}}</td>
                            <td>{{$vacantroom}}</td>
                            <td>{{$occupiedroom}}</td>
                            <td>{{$dirtyroom}}</td>

                        </tr> --}}
                        </tbody>

                    </table>
                </div>

                @if (isset($message))
                    <div class="alert alert-info">{{ $message }}</div>
                @endif


            </div>
            {{-- <div class="col-md-6 mt-1">
                <label for="">Check Advance Booked vehicles......Select Date </label>
                <div class="form-floating mb-3 mb-md-0">
                    <form class="form-inline" action="{{ url('room_dashboard') }}" method="POST">
                        @csrf

                        <div class="input-group">
                            <input type="text" class="form-control date" name="selected_date" id="selected_date">

                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="search_button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>


                    </form>

                </div>

            </div> --}}
        </div>

        <div class="row">
            @foreach ($data as $room)
                <div class="col-lg-2 col-md-4 col-sm-6 col-6 mt-1">
                    @php
                        // Determine the class for the room-box
                        $roomClass = '';
                        if ($room->room_status === 'occupied') {
                            $roomClass = 'occupied';
                        } elseif ($room->room_status === 'dirty') {
                            $roomClass = 'dirty';
                        } elseif (in_array($room->id, $bookedRoomIds)) {
                            $roomClass = 'orange';
                        } else {
                            $roomClass = 'vacant';
                        }
                        $button_background = '';
                        if ($room->room_status === 'occupied') {
                            $button_background = 'occupied_button';
                        } elseif ($room->room_status === 'dirty') {
                            $button_background = 'dirty__button';
                        } elseif (in_array($room->id, $bookedRoomIds)) {
                            $button_background = 'orange__button';
                        } else {
                            $button_background = 'vacant__button';
                        }
                        $roomVoucher = $roomcheckinsData->firstWhere('room_id', $room->id);
                        if ($roomVoucher) {
                            $voucherNo = $roomVoucher->voucher_no ?? '';
                            $guestname = $roomVoucher->guest_name ?? '';
                            $guestmobile = $roomVoucher->guest_mobile ?? '';
                        } else {
                            $voucherNo = '';
                            $guestname = '';
                            $guestmobile = '';
                        }

                    @endphp

                    <div class="room-box {{ $roomClass }}">
                        {{-- <h6>Room ID: {{ $room->id }}</h6> --}}
                        <h5 class="room-no" onclick="toggleRoomDetail(this)"> {{ $room->room_no }}</h5>

                        <p class="room-detail" style="display:none;">Name
                            ({{ $guestname ?? '' }}&nbsp;{{ $guestmobile ?? '' }}) &nbsp;Type
                            {{ $room->roomtype->roomtype_name }}&nbsp;||&nbsp;{{ $room->roomtype->room_tariff }}
                            Facilities: {{ $room->room_facilities }} </p>
                        <div class="links">
                            <a href="{{ url('roombookings/create') }}" title="Book a slot">
                                <div class="linkitem">
                                    <button class="buttonlink">
                                        <i class="fa fa-phone" style="font-size:20px;color:orange"></i>

                                    </button>


                                </div>
                            </a>
                            @if ($voucherNo)
                            <a href="{{ url('#') }}" title="Job card">    
                            @else
                            <a href="{{ url('roomcheckins/create') }}" title="Job card">

                                
                            @endif

                                
                                <div class="linkitem">
                                    <button class="buttonlink {{ $button_background }}">

                                        <i class="fa fa-wrench" style="font-size:20px;color:green"></i>


                                    </button>


                                </div>
                            </a>
                            <a href="{{ url('/kots/create/' . $voucherNo) }}" title="parts bill">

                                <div class="linkitem">

                                    <button class="buttonlink">

                                        <i class="fas fa-bread-slice"
                                            style="font-size:20px;color:rgb(224, 20, 180)
                                      "></i>


                                    </button>


                                </div>
                            </a>
                            <a href="{{ url('facthkot_records/' . $voucherNo) }}" title="Make invoice">
                                <div class="linkitem">
                                    <button class="buttonlink">

                                        <i class="fas fa-calculator" style="font-size:20px;color:black"></i>


                                    </button>


                                </div>
                            </a>

                            @if (!empty($voucherNo))
                                <!-- If voucherNo exists -->
                                <a href="{{ url('show_checkin/' . $voucherNo) }}" title="Gate pass">
                                    <div class="linkitem">
                                        <button class="buttonlink">
                                            <i class="fa fa-walking" style="font-size:20px;color:rgb(39, 6, 248)"></i>
                                        </button>
                                    </div>
                                </a>
                            @else
                                <!-- If voucherNo is not available -->
                                <a href="{{ url('roomcheckouts/create') }}" title="Gate pass">
                                    <div class="linkitem">
                                        <button class="buttonlink">
                                            <i class="fa fa-walking" style="font-size:20px;color:rgb(39, 6, 248)"></i>
                                        </button>
                                    </div>
                                </a>
                            @endif
    
                            @can('sale')
                        <a href="{{ url('/sales') }}" title="bill">
                                    <div class="linkitem">
                                        <button class="buttonlink">
                                            <i class="fa-solid fa-cart-plus" style="color: #f44336"></i>
                                            {{-- <i class="fa fa-calculator" style="font-size:20px;color:rgb(39, 6, 248)"></i> --}}
                                        </button>
                                    </div>
                                </a>
            @endcan
                            
{{-- 
                            @if ($voucherNo)
                            <a href="" title="Clear Dirty Room">
                            @else
                            <a href="#" title="Clear Dirty Room"
                                onclick="confirmAndRedirect('{{ url('dirty_room_clear', $room->id) }}'); return false;">     
                            @endif
                           
                                <div class="linkitem">
                                    <button class="buttonlink">
                                        <i class="fa fa-broom" style="font-size:20px;color:red"></i>
                                    </button>
                                </div>
                            </a> --}}

                            <script>
                                function confirmAndRedirect(url) {
                                    if (confirm('Are you sure you want to proceed?')) {
                                        const userInput = prompt('Please enter "123" to continue:');
                                        if (userInput && userInput.trim().toLowerCase() === '123') {
                                            window.location.href = url;
                                        } else {
                                            alert('Operation cancelled. Please enter "123" exactly to proceed.');
                                        }
                                    } else {
                                        alert('Operation cancelled.');
                                    }
                                }
                            </script>








                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>





    </div>
    </div>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

    <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>
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
    <script>
        function confirmAction() {
            if (confirm('Do you want to convert all Rooms to vacant rooms?')) {
                window.location.href = '{{ url('/mark_room_dirty') }}';
            }
        }
    </script>

@endsection
