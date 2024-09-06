<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')

<div class="container ">

    <div class="card my-3">
        <div class="card-header">
         Account List 
        </div>
       <div class="row ">
        <div class="col-md-12 text-center"><a href={{url('/accountform')}} class="btn btn-primary">Add New Account  </a>

          <button class="btn btn-dark mx-2">Import</button></div></div>
         
        <div class="card-body">
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
                    <td>{{$record['account_group']}}</td>
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