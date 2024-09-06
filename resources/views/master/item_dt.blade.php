<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .table-scrollable {
    /* border-style: solid;
    border-color: blue; */

    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Enables momentum scrolling in iOS Safari */
  }

  </style>
@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script>
      <script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
  });
</script>

<div class="container ">

    <div class="card my-3">
        <div class="card-header">
         Item List 
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><a href={{url('/itemform')}} class="btn btn-primary">Add New Item  </a>
          <a href={{url('/item_dt')}} class="btn btn-dark">Register </a>
          <button class="btn btn-warning mx-2">Import</button></div></div>

         
        <div class="card-body table-scrollable">
            <table class="table   table-striped"id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Group</th>
                    <th scope="col">MRP</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Unit</th>
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
                    <td>{{$record['item_name']}}</td>
                    <td>{{$record['company']}}</td>
                    <td>{{$record['group']}}</td>
                    <td>{{$record['mrp']}}</td>
                    <td>{{$record['sale_rate']}}</td>
                    <td>{{$record['unit']}}</td>
     
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