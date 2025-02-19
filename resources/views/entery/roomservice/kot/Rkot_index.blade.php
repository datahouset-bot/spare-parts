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
        <div class="card-header">
       Restaurant KOT 
        </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">


             <a href="{{url('/kots/create')}}" class="btn btn-success">New KOT</a>
             <a href="{{url('/kots_cleared')}}" class="btn btn-primary">Cleared KOT List </a>
             <a href="{{url('/kichen_dashboard')}}" class="btn btn-warning">Kitchen Dashboard </a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Date  </th>
                    <th scope="col"> KOT No    </th>
                    <th scope="col"> Table No  </th>
                    <th scope="col"> Total Qty </th>
                    <th scope="col"> Total Amount </th>
                    <th scope="col"> Serve Status </th>
                    <th scope="col"> Status </th>
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
                  @foreach ($kots as $record)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td scope="col">{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}</td>
                     <td>{{$record['bill_no']}}</td>
                     <td>{{$record->table_name}}</td>
                     <td>{{$record['total_qty']}}</td>
                     <td>{{$record['total_amount']}}</td> 
                     <td>{{$record['ready_to_serve']}}</td> 
                     <td>{{$record['status']}}</td> 


                    

                  <td>
                    <a href="{{ url('kot_print', [$record['user_id'], $record['voucher_no']]) }}" class="btn btn-sm">
                      <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                  </a>
                  
                </td>

                     <td>
                      <a href="{{ url('kot_print_view', [$record['user_id'], $record['voucher_no']]) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                  </td> 
                  <td>
                      <a href="{{ route('roombookings.edit', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>
                  <td>
                    <a href="{{ url('rkot_destroy', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-trash" style="font-size:20px;color:red"></i></a>
                </td>

                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection