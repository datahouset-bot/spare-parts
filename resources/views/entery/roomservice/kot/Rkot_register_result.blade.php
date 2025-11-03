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
@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif


    <div class="card my-3">
        <div class="card-header  text-center">
       Restaurant KOT Register  <h1>Tabel:{{$table_name}}</h1>
        </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">


           </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> KOT Date  </th>
                    <th scope="col"> KOT Time  </th>
                    <th scope="col"> Oprater Name  </th>

                    <th scope="col"> Bill No   </th>
                     
                    <th scope="col">Item Name   </th>
                    <th scope="col"> Qty  </th>
                    <th scope="col"> Rate </th>
                    <th scope="col"> Amount </th>
                    <th scope="col"> Remark </th>
                     <th scope="col">Print Kot   </th>
                 
 
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($kots as $record)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td scope="col">{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}</td>
                    <td>{{ $record->created_at->format('H:i') }}</td>
                    <td>
                      {{$record['user_name']}}
                      
                    </td> 
                    <td>{{$record['bill_no']}}</td>
                     <td>{{$record->item_name}}</td>
                     <td>{{$record['qty']}}</td>
                     <td>{{$record['rate']}}</td> 
                     <td>{{$record['amount']}}</td> 
                     <td>{{$record->kot_remark}}</td>
                     <td>
                      <a href="{{ url('kot_print_view', [$record['user_id'], $record['voucher_no']]) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                     </td>
   
                  </td> 
</td> 


                    

                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection