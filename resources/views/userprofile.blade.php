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
        <div class="col-md-12 text-center">
         
        <div class="card-body">
           <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Firm Id </th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email Id</th>
                    <th scope="col">Status</th>
                    <th scope="col">Reg.Date</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $record)
                    
                  <tr>
                    <th scope="row">{{$record['id']}}</th>
                    <td>{{$record['firm_id']}}</td>
                    <td>{{$record['name']}}</td>
                    <td>{{$record['email']}}</td>
                    <td>{{$record['email_verified_at']}}</td>
                    <td>{{$record['created_at']}}</td>
                    <td><a href="{{('verifyid/'.$record['id']) }}"  class="btn btn-info btn-sm">Varify</a></td>
                    <td><a href="{{('viwprofileform/'.$record['id']) }}"  class="btn btn-primary btn-sm">Edit</a></td>
                    <td><a href="{{('deleteprofile/'.$record['id']) }}"  class="btn btn-danger btn-sm">Delete</a></td>
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
    order: [], // 👈 disables initial sorting

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