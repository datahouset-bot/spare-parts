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
<div class="container-fluid ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-3">
        <div class="card-header">
        <h4>Item Wise Stock  <h4>       </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
            <a href="{{url('purchases/create')}}" class="btn btn-primary">New Purchase  </a>
            <a href="{{url('purchases')}}" class="btn btn-dark"> Purchase Register </a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
 
          <table class="table table-striped" id="remindtable">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Item Name     </th>
                    <th scope="col"> Stock In </th>
                    <th scope="col"> Stock Out</th>
                    <th scope="col"> Closing Stock</th>




                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                    $total_stock_in=0;
                    $total_stock_out=0;
                    $total_closing_stock=0;


                  @endphp
                  @foreach ($closing_stock as $record)
                    
                  <tr>
           @php
                    $total_stock_in +=$record->total_stock_in;
                    $total_stock_out +=$record->total_stock_out;
                    $total_closing_stock +=$record->total_stock;
           @endphp
                    <td scope="row">{{$r1=$r1+1}}</td>
                    <td>{{$record->item_name}}</td>
                     <td>{{$record->total_stock_in}}</td>
                     <td>{{$record->total_stock_out}}</td>
                     <td>{{$record->total_stock}}</td>

                    

                    
                  </tr>
                  @endforeach

                  
                  
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <td>Total</td>
                        <td> Total Item ={{$r1}}</td>
                        <td> {{$total_stock_in}}</td>
                        <td> {{$total_stock_out}}</td>
                        <td> {{$total_closing_stock}}</td>
                    </tr>
                </tfoot>
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