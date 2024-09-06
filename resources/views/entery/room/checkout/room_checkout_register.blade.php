<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <style>
      td{
        margin: 1px !important;
        padding: 1px !important;
      }
    </style>
    
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
        <h4>Room Check Out Register <h4>       </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
            <a href="{{url('room_dashboard')}}" class="btn btn-warning">Room Dash Board</a>
            <a href="{{url('roomcheckouts/create')}}" class="btn btn-primary">New Check Out </a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
 
          <table class="  " id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Bill No    </th>
                    <th scope="col"> Room No   </th>
                    <th scope="col"> Guest Name </th>
                    <th scope="col"> Address </th>
                    <th scope="col"> City </th>
                    <th scope="col"> Mobile </th>
                    <th scope="col"> Email Id </th>
                    <th scope="col"> State </th>
                    <th scope="col"> GST No  </th>
                    <th scope="col"> Check in Date </th>
                    <th scope="col"> Check Out Date  </th>
                    <th scope="col"> Total Days  </th>
                    <th scope="col"> Food Amount  </th>
                    <th scope="col"> GST % </th>
                    <th scope="col"> SGST </th>
                    <th scope="col"> CGST </th>
                    <th scope="col"> IGST </th>
                    <th scope="col"> Taxable </th>
                    <th scope="col"> Total GST </th>
                    <th scope="col">  Bill Amt  </th> 
                    <th scope="col"> Advance  </th>
                    <th scope="col"> Net Pay Amt  </th>
                    <th></th>
                    <th></th>    
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($roomcheckouts as $record)
                    
                  <tr>
           
                    <td scope="row">{{$r1=$r1+1}}</td>
                     <td>{{$record['check_out_no']}}</td>
                     <td>{{$record['room_no']}}</td>
                     <td>{{$record['guest_name']}}</td>
                     <td>{{$record->account->address}}</td>
                     <td>{{$record->account->city}}</td>
                     <td>{{$record->account->mobile}}</td>
                     <td>{{$record->account->email}}</td>
                     <td>{{$record->account->state}}</td>
                     <td>{{$record->account->gst_no}}</td>
                     <td scope="col">{{ \Carbon\Carbon::parse($record['checkin_date'])->format('d-m-y') }}</td>
                     <td scope="col">{{ \Carbon\Carbon::parse($record['checkout_date'])->format('d-m-y') }}</td>
                     <td>{{$record['no_of_days']}}</td>
                     <td>{{$record->total_food_amt}}</td>
                     <td>{{$record->gst_id}}</td>
                     <td>{{$record->sgst}}</td>
                     <td>{{$record->cgst}}</td>
                     <td>{{$record->igst}}</td>
                     <td>{{$record->total_room_rent}}</td>
                     <td>{{$record->gst_total}}</td>
                     <td>{{$record->total_billamount}}</td>
                     <td>{{$record->total_advance}}</td>
                     <td>{{$record->balance_to_pay}}</td>




                    
                  

                     <td>
                      <a href="{{ url('room_checkout_view', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                  </td> 
                  <td><a href="https://wa.me/{{$record['guest_mobile']}}" ><i class="fa fa-bullhorn"style="font-size:20px;color:green"></i> </a></td>



                  
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