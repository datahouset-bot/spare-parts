<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <style>
/* ================= PAGE ================= */
body {
    background: #f4f6fb;
    font-family: "Segoe UI", system-ui, sans-serif;
}

/* ================= CARD ================= */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

.card-header {
    background: linear-gradient(135deg, #ffffff, #eef2f7);
    border-bottom: 1px solid #e5e7eb;
    padding: 14px 18px;
}

.card-header h4 {
    margin: 0;
    font-weight: 700;
    color: #1f2937;
}

/* ================= ACTION BAR ================= */
.card .row.my-2 {
    margin-top: 10px;
}

.card .btn {
    border-radius: 22px;
    padding: 6px 18px;
    font-weight: 600;
    margin: 4px;
}

/* ================= TABLE CONTAINER ================= */
.table-scrollable {
    background: #fff;
    border-radius: 12px;
    padding: 14px;
}

/* ================= TABLE ================= */
table {
    border-collapse: separate;
    border-spacing: 0;
}

thead th {
    background: #0f172a !important;
    color: #fff !important;
    font-weight: 700;
    border-bottom: 2px solid #334155;
}

/* Table rows */
tbody tr {
    transition: background 0.2s ease, transform 0.15s ease;
}

tbody tr:hover {
    background: #f8fafc;
    transform: scale(1.002);
}

/* Cells */
td {
    padding: 8px !important;
    vertical-align: middle;
}

/* ================= NUMERIC ALIGNMENT ================= */
td:nth-child(3),
td:nth-child(4),
td:nth-child(5) {
    text-align: right;
    font-weight: 600;
}

/* ================= FOOTER ================= */
tfoot {
    background: #0f172a;
    color: #fff;
    font-weight: 700;
}

tfoot td {
    padding: 10px !important;
}

/* ================= DATATABLE CONTROLS ================= */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px;
    padding: 4px 12px;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 10px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .card-header h4 {
        text-align: center;
    }

    .card .btn {
        width: 100%;
    }

    td, th {
        font-size: 13px;
    }
}
</style>

    
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