<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')

<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
        <h4>Service Report  {{$from_date}} &nbsp;   <h4>       </div>

        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped table-responsive" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Bill No    </th>
                    <th scope="col"> Slot No   </th>
                    <th scope="col">Customer Name </th>
                    <th scope="col"> Vehicle No </th>
                    <th scope="col"> Arrival Date </th>
                    <th scope="col"> Arrival Time </th>
                    <th scope="col"> Model no   </th>
                    <th scope="col"> Service charge  </th>
           
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                    $totaltariff=0;
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
                      <td>{{$record->no_of_guest}}</td>
           

                      <td>{{$record->room_tariff_perday}}</td>
                      @php
                        $totaltariff+= $record->room_tariff_perday
                      @endphp
           


                      



                    
                  
                  </tr>
                  @endforeach
                  <h1>Total Service Charge={{$totaltariff}};</h1>
                  
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