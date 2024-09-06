
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
@if(session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
@endif

    <div class="card my-3">
        <div class="card-header">
         Account List 
        </div>
      <div class="row ">
        
        <div class="col-md-12 text-center my-2"><a href={{url('/accountform')}} class="btn btn-primary">Add New Account  </a>
          <a href={{url('/account_dt')}} class="btn btn-success">Data Table   </a>
          <a href={{url('/account_import')}} class="btn btn-warning">Import   </a>
    
        
      </div>
         
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Account Name</th>
                    <th scope="col">Group</th>
                    <th scope="col">Op.Balnce</th>
                    <th scope="col">Bal.Type</th>
                    {{-- <th scope="col">Address</th> --}}
                    <th scope="col">City</th>
                    {{-- <th scope="col">State</th> --}}
                    <th scope="col">Phone</th>
                    <th scope="col">Mobile</th>
                    {{-- <th scope="col">Email</th>
                    <th scope="col">Person Name</th> --}}
                    <th scope="col">GST No </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>
                    <th scope="col"> </th>

                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($data as $record)
                    
                  <tr>
                    {{-- <th scope="row">{{$record['id']}}</th> --}}
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td>{{$record['account_name']}}</td>
                    <td>{{$record->accountgroup->account_group_name}}</td>
                    <td>{{$record['op_balnce']}}</td>
                    <td>{{$record['balnce_type']}}</td>
                    {{-- <td>{{$record['address']}}</td> --}}
                    <td>{{$record['city']}}</td>
                    {{-- <td>{{$record['state']}}</td> --}}
                    <td>{{$record['phone']}}</td>
                    <td>{{$record['mobile']}}</td>
                    {{-- <td>{{$record['email']}}</td>
                    <td>{{$record['person_name']}}</td> --}}
                    <td>{{$record['gst_no']}}</td>
                    <td><a href="{{('accountformview/'.$record['id']) }}"  ><i class="fa fa-eye" style="font-size:20px;color:DarkGreen"></i></a></td>
                    <td><a href="{{('showeditaccount/'.$record['id']) }}"  ><i class="fa fa-edit" style="font-size:20px;color:blue"></i></a></td>
                    <td><a href="{{('deleteaccount/'.$record['id']) }}"  ><i class="fa fa-trash" style="font-size:20px;color:red"></i></a></td>
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection