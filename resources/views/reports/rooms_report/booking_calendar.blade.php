@extends('layouts.blank')

@section('pagecontent')
    <style>
        #booked {
            background-color: green;
            color: white;
        }
        .vacant {
            background-color: white;
            color: black;
        }
    </style>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-1">
                @if (isset($message))
                    <div class="alert alert-info">{{ $message }}</div>
                @endif
            </div>
        </div>

        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Room No</td>
                        @php
                        $current_date = clone $currentDate;
                        for ($i = 0; $i < 30; $i++) {
                            echo '<td>' . $current_date->format('d-m') . '</td>';
                            $current_date->modify('+1 day');
                        }
                        @endphp
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room->room_no }}</td>
                            @php
                           
                           $current_date = clone $currentDate;        
                        for ($i = 0; $i <= 30; $i++) {
                            $current_date->format('Y-m-d') ;
                            $roomNo=$room->room_no;
                            $isBooked=$roombookings->where('room_no',$roomNo)
                            ->where('checkin_date','<=',$current_date)
                            ->where('checkout_date','>=',$current_date)
                            ->count() > 0;
                            if ($isBooked>0) {
                            echo "<td id='booked'>B</td>";

                            }else {
                                echo"<td>-</td>";
                            }

                            // echo "<td>".$isBooked."</td>";
                            $current_date->modify('+1 day');
                        }  @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="{{ global_asset('/general_assets/js/form.js') }}"></script>
@endsection
