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
      <script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
  });
</script>

<div class="container ">
  @if (session('message'))
          <div class="alert alert-primary">
              {{ session('message') }}
          </div>
      @endif
      @if (session('error'))
          <div class="alert alert-danger ">
              {{ session('error') }}
          </div>
      @endif


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
                    <th scope="col">Barcode</th>
                    <th scope="col">Group</th>
                    <th scope="col">Head Group</th>
                    <th scope="col">MRP</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Unit</th>
                    <th scope="col">GST/ TAX %</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
 
                    <th scope="col"></th>
 
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
                    <td>{{$record->company->comp_name }}</td>
                    <td>{{$record->item_barcode }}</td>
                    <td>{{$record->itemgroup->item_group}}</td>
                    <td>{{$record->itemgroup->head_group}}</td>
                    <td>{{$record['mrp']}}</td>
                    <td>{{$record['sale_rate']}}</td>
                    <td>{{$record->unit->primary_unit_name}}</td>
                    <td>{{$record->gstmaster->taxname}}</td>
 
                    <td><a href="{{('itemformview/'.$record['id']) }}"  class="btn  btn-sm"><i class="fa fa-eye" style="font-size:20px;color:DarkGreen"></i></a></a></td>
                    <td>
                      @can('update role')
                      <a href="{{('showedititem/'.$record['id']) }}"  class="btn  btn-sm"><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                      @endcan
                      </td>
 
                    <td>
                      @can('delete role')
 
                      <a href="{{('deleteitem/'.$record['id']) }}"  class="btn  btn-sm"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></a>
                      @endcan
 
                      </td>
                   
                      </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection