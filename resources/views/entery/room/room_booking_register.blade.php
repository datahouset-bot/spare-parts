<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
    
{{-- <script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
  });
</script> --}}
<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
        Room Booking
        </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
            <a href="{{url('room_dashboard')}}" class="btn btn-warning">Room Dash Board</a>
            <a href="{{route('roombookings.create')}}" class="btn btn-primary">Book New Room</a>
            <a href="{{url('pending_booking')}}" class="btn btn-danger">Unconfirmed Bookings</a>
            <a href="{{url('/clear_booking')}}" class="btn btn-dark">Clear Booking</a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Room No   </th>
                    <th scope="col"> Bookig No    </th>
                    <th scope="col"> Guest Name </th>
                    <th scope="col"> Contact No </th>
                    <th scope="col"> Booking Date </th>
                    <th scope="col"> Booking Time </th>
                    <th scope="col"> Check in Date </th>
                    <th scope="col"> Check in Time </th>
                    <th scope="col"> Check Out Date  </th>
                    <th scope="col"> Check Out Time </th>
                    <th scope="col"> Vehicle No  </th>
                    <th scope="col"> Parking No  </th>
                    <th scope="col"> Booking Remark  </th>

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
                     <td scope="col">{{$record->booking_time }}</td>
                     <td scope="col">{{ \Carbon\Carbon::parse($record->checkin_date)->format('d-m-y') }}</td>
                     <td scope="col">{{$record->checkin_time }}</td>
                     <td scope="col">{{ \Carbon\Carbon::parse($record->checkout_date)->format('d-m-y') }}</td>
                     <td scope="col">{{$record->checkout_time }}</td>
                     <td scope="col">{{$record->bookingaf1}}</td>
                     <td scope="col">{{ $record->bookingaf2 }}</td>
                     <td scope="col">{{ $record->bookingaf3 }}</td>
                     

                    
                     <td>
                      <button class="btn btn-sm" onclick="printRoomBooking({{ $record->voucher_no }})">
                          <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                      </button>
                  </td>
                  

                     <td>
                      <a href="{{ url('roombooking_view', $record->voucher_no) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
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
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<script>
  $(document).ready(function () 
  {

    new DataTable('#remindtable', {
    layout: {
        topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
    }
});


  }
  );
 
</script>


@endsection