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
        <h4>Room Check Out <h4>       </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
            <a href="{{url('room_dashboard')}}" class="btn btn-warning"> DashBoard</a>
            <a href="{{url('roomcheckouts/create')}}" class="btn btn-primary">Ready to moveOut </a>
            <a href="{{url('roomcheckout_register')}}" class="btn btn-dark"> moveout Register </a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
 
          <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Bill No    </th>
                    <th scope="col"> Vehicle No   </th>                 
                    <th scope="col"> chaches No   </th>
                    <th scope="col"> customer Name </th>
                    <th scope="col"> Contact No </th>
                    {{-- <th scope="col"> Check in Date </th>
                    <th scope="col"> Check Out Date  </th> --}}
                    <th scope="col"> Total Days  </th>
                    <th scope="col">  Bill Amount  </th>
                    <th scope="col"></th>
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
                  @foreach ($roomcheckouts as $record)
                    
                  <tr>
           
                    <td scope="row">{{$r1=$r1+1}}</td>
                     <td>{{$record['check_out_no']}}</td>
                     <td>{{$record->checkin_checkout_voucher_no }}</td>
                    
                    
                     <td>{{$record->checkout_room_no}}</td>
                     
                     <td>{{$record['guest_name']}}</td>
                     <td>{{$record['guest_mobile']}}</td>
                     <td scope="col">{{ \Carbon\Carbon::parse($record['checkin_date'])->format('d-m-y') }}</td>
                     <td scope="col">{{ \Carbon\Carbon::parse($record['checkout_date'])->format('d-m-y') }}</td>
                     <td>{{$record['no_of_days']}}</td>
                     <td>{{$record['total_billamount']}}</td>


                    
                     <td>
                      <button class="btn btn-sm" onclick="printRoomBooking({{url('checkout_vh_no', $record['checkout_voucher_no'])  }})">
                          <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                      </button>
                  </td>
                  

                     <td>
                      <a href="{{ url('checkout_print_view', $record['checkout_voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                  </td> 
                  <td>
                      <a href="{{ url('roomcheckouts/' . $record['checkout_voucher_no'] . '/edit') }}" class="btn btn-sm">
    <i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i>
</a>

                  </td>
                  {{-- <td><a href="https://wa.me/{{$record['guest_mobile']}}" ><i class="fa fa-bullhorn"style="font-size:20px;color:green"></i> </a></td> --}}
                  {{-- <td><a href="https://wapp.powerstext.in/http-tokenkeyapi.php?authentic-key=393444617461486f7573653130301747389187&route=1&number={{$record['guest_mobile']}}&message=Thanks For Stay With Us We Are testing whtsapp " ><i class="fa fa-bullhorn"style="font-size:20px;color:green"></i> </a></td> --}}

<td>
    <a href="#" onclick="sendWhatsApp('{{ $record['guest_mobile'] }}'); return false;">
        <i class="fa fa-bullhorn" style="font-size:20px;color:green"></i>
    </a>
</td>

<script>
    function sendWhatsApp(mobile) {
        fetch(`/send-whatsapp?number=${mobile}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("WhatsApp message sent");
                } else {
                    alert("Failed to send WhatsApp message");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong");
            });
    }
</script>

                    <td>
                      <form action="{{ url('roomcheckouts/' . $record['checkout_vh_no']) }}" method="POST" style="display:inline;">
                         @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this  Room Check Out ?{{$record['checkout_voucher_no']}}')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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