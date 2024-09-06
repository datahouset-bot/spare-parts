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
        <h4>Police Station Report  <h4>       </div>

        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped table-responsive" id="remindtable1">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Check In No    </th>
                    <th scope="col"> Room No   </th>
                    <th scope="col"> Guest Name </th>
                    <th scope="col"> Contact No </th>
                    <th scope="col"> Check in Date </th>
                    <th scope="col"> Check in Time </th>
                    <th scope="col"> Person Pic </th>
                    <th scope="col"> Document Name  </th>
                    <th scope="col"> Documnet No   </th>
                    <th scope="col"> Documnet Pic   </th>
                    <th scope="col"> Countery </th>
     
                    <th scope="col"> Comming From  </th>
                    <th scope="col"> Going To   </th>
                    <th scope="col"> No Of Guest   </th>
           
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
                      <td scope="col">{{ \Carbon\Carbon::parse($record->checkin_date)->format('d-m-y') }}</td>
                      <td scope="col">{{ $record->checkin_time }}</td>
                      <td><img src="{{ asset('storage\app\public\image\\' . $record->account_pic1) }}" alt="" width="70px"></td>
 
                      <td>{{$record->account_idproof_name}}</td>
                      <td>{{$record->account_idproof_no}}</td>
                      <td><img src="{{ asset('storage\app\public\image\\' . $record->account_id_pic) }}" alt="" width="70px"></td>
                      <td>{{$record->nationality}}</td>
                      <td>{{$record->comming_from}}</td>
                      <td>{{$record->going_to}}</td>
                      <td>{{$record->no_of_guest}}</td>



                      



                    
                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection