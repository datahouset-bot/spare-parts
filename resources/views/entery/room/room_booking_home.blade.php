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


    <div class="card my-3">
        <div class="card-header">
        Slot Booking
        </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
            <a href="{{url('room_dashboard')}}" class="btn btn-warning"> DashBoard</a>
            <a href="{{route('roombookings.create')}}" class="btn btn-primary">New vehicle</a>
            <a href="{{url('pending_booking')}}" class="btn btn-danger">Uncomplete Vehicle</a>
            <a href="{{url('/clear_booking')}}" class="btn btn-dark">Moveout</a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> slot No   </th>
                    <th scope="col"> Vehicle No    </th>
                    <th scope="col"> customer Name </th>
                    <th scope="col"> Contact No </th>
                    <th scope="col"> Date </th>
                    {{-- <th scope="col"> Check in Date </th> --}}
                    <th scope="col"> Time </th>
                    {{-- <th scope="col"> Check Out Date  </th> --}}
                    {{-- <th scope="col"> Check Out Time  </th> --}}
                    {{-- <th scope="col"> No Of Day  </th> --}}
                    {{-- <th scope="col"> No Of Guest  </th> --}}
                    {{-- <th scope="col"> Per Day Tariff </th> --}}
                    {{-- <th scope="col"> Total Tariff </th> --}}
                    <th scope="col"> Advance </th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($roombooking as $record)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                     <td>{{$record->room_nos}}</td>
                      <td>{{$record->booking_no}}</td>
                     <td>{{$record->guest_name}}</td>
                     <td>{{$record->guest_mobile}}</td>
                     <td scope="col">{{ \Carbon\Carbon::parse($record->booking_date)->format('d-m-y') }}</td>
                     {{-- <td scope="col">{{ \Carbon\Carbon::parse($record->checkin_date)->format('d-m-y') }}</td> --}}
                     <td scope="col">{{ $record->checkin_time }}</td>
                     {{-- <td scope="col">{{ \Carbon\Carbon::parse($record->checkout_date)->format('d-m-y') }}</td>
                     <td scope="col">{{ $record->checkout_time }}</td>
                     <td scope="col">{{ $record->commited_days }}</td>
                     <td scope="col">{{ $record->no_of_guest }}</td> --}}

                     {{-- <td scope="col">{{ $record->room_tariff_perday }}</td> --}}
                     {{-- <td scope="col">{{ $record->room_tariff_perday*$record->commited_days }}</td> --}}
                     <td scope="col">{{ $record->booking_amount ?? 0 }}</td>



                    
                     <td>
                      <button class="btn btn-sm" onclick="printRoomBooking({{ $record->voucher_no }})">
                          <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                      </button>
                  </td>
                  

                     <td>
                      <a href="{{ url('roombooking_print_view', $record->voucher_no) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                  </td> 
                  <td>
                      <a href="{{ route('roombookings.edit', $record->voucher_no) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('roombookings.destroy', $record->voucher_no) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this  Room Booking ?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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