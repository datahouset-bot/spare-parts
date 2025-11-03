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
        <h4>Room Check In <h4>       </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
            <a href="{{url('room_dashboard')}}" class="btn btn-warning">Room Dash Board</a>
            <a href="{{url('roomcheckins/create')}}" class="btn btn-primary">New Check In </a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Check In No    </th>
                    <th scope="col"> Room No   </th>
                    <th scope="col"> Guest Name </th>
                    <th scope="col"> Contact No </th>
                    <th scope="col"> Total Guest  </th>
                    <th scope="col"> Check in Date </th>
                    <th scope="col"> Check in Time  </th>
                    @if(!is_null($componyinfo->componyinfo_af1))
                    <th scope="col"> Expected Check-Out Date </th>
                    <th scope="col"> Expected Check-Out Time  </th>
                    @endif

                    <th scope="col"> Status  </th>
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
                  @foreach ($roomcheckins as $record)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                     <td>{{$record->check_in_no}}</td>
                     <td>{{$record->room_nos}}</td>
                     <td>{{$record->guest_name}}</td>

                     <td>{{$record->guest_mobile}}</td>
                     <td>{{$record->no_of_guest}}</td>
                      <td scope="col">{{ \Carbon\Carbon::parse($record->checkin_date)->format('d-m-y') }}</td>
                      <td scope="col">{{ $record->checkin_time }}</td>
                      @if(!is_null($componyinfo->componyinfo_af1))
                       <td scope="col">{{ \Carbon\Carbon::parse($record->checkinaf9)->format('d-m-y') }}</td>
                      <td scope="col">{{ $record->checkinaf10 }}</td>
                      
                      @endif


                    
                     <td>
                      <button class="btn btn-sm" onclick="printRoomBooking({{ $record->voucher_no }})">
                          <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                      </button>
                  </td>
                  

                  <td>
                    <a href="{{ url('guest_reg_print', $record->voucher_no) }}" class="btn btn-sm">
                        <i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i>
                    </a>
                </td>
                
                  <td>
                      <a href="{{ route('roomcheckins.edit',  $record->voucher_no) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>
                  
                  <td><a href="{{('showeditaccount/'.$record->account_id) }}" class="btn  btn-sm"       title="Edit Guest Info" ><i class="fa fa-book" style="font-size:20px;color:blue"></i></a></td>
                  

                    <td>
                      <form action="{{ route('roomcheckins.destroy', $record->voucher_no) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this  Room Checkin ?{{$record->voucher_no}}')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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