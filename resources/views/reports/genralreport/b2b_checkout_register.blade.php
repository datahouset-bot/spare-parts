<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
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


    <div class="card my-1">
        <div class="card-header">
        <h4>Room Check Out B2B Register (Only GST Customer Invoice) <h4>       </div>
       <div class="container mt-1" id="account_select_form">
        <form action="{{ url('b2bsales') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-2 mb-3">
                    <input type="text" class="form-control date" name="from_date" value="{{ date('Y-m-d') }}"
                        required>
                </div>
                <div class="col-md-2 mb-3">
                    <input type="text" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}"
                        required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>

                </div>


            </div>

        </form>

    </div> 

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
 
          <table class="  " id="remindtable">
                <thead>
                  <tr>
                    <th scope="col"> GSTIN/UIN   </th>
                    <th scope="col">Receiver Name</th>
                    <th scope="col"> Invoice Number </th>
                    <th scope="col"> Invoice date </th>
                    <th scope="col"> Invoice Value </th>
                    <th scope="col"> Place Of Supply </th>
                    <th scope="col"> Reverse Charge</th>
                    <th scope="col"> Applicable % of Tax Rate</th>
                    <th scope="col"> Invoice Type</th>
       
                    <th scope="col"> E-Commerce GSTIN </th>
                    <th scope="col"> Rate </th>
                    <th scope="col"> Taxable Value </th>
                    <th scope="col"> Cess Amount </th>

                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($roomcheckouts as $record)
                    
                  <tr>
                    <td>{{$record->account->gst_no}}</td>
                    <td>{{$record->account->account_af1}}</td>   
                     <td>{{$record['check_out_no']}}</td>
                     <td scope="col">{{ \Carbon\Carbon::parse($record['checkout_date'])->format('d-m-Y') }}</td>
                     <td>{{$record->total_billamount}}</td>
                     <td>{{$record->account->state}}</td>
                     <td></td>
                     <td>N</td>
                     <td>Regular B2B</td>
                     <td></td>
                     <td>{{$record->gst_id}}</td>
                     <td>{{$record->total_room_rent}}</td>
                     <td>0 </td> 
    


                  
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets\js\form.js') }}"></script>


@endsection