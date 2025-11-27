<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets/css/table.css')}}">

@extends('layouts.blank')

@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

<div class="container-fluid ">
    @if(session('message'))
        <div class="alert alert-primary">
            {{ session('message') }}
        </div>
    @endif

    <div class="card my-3">
        <div class="card-header">
            <h4>Purchase</h4>
        </div>

        <div class="card-body table-scrollable">
            @foreach ($closing_stock as $godown_id => $stocks) 
                <!-- Display Godown Name -->
                <h3>Godown: {{ $stocks->first()->godown->godown_name }}</h3>

                <!-- Table for Items in this Godown with unique ID -->
                <table class="table table-striped" id="remindtable{{ $godown_id }}">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Stock In</th>
                            <th scope="col">Stock Out</th>
                            <th scope="col">Closing Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $r1 = 0;
                            $total_stock_in = 0;
                            $total_stock_out = 0;
                            $total_closing_stock = 0;
                        @endphp

                        @foreach ($stocks as $stock)
                            @php
                                $r1++; // Increment item counter
                                $total_stock_in += $stock->total_stock_in;
                                $total_stock_out += $stock->total_stock_out;
                                $total_closing_stock += $stock->total_stock;
                            @endphp
                            <tr>
                                <td>{{ $r1 }}</td> <!-- Item serial number -->
                                <td>{{ $stock->item_name }}</td>
                                <td>{{ $stock->total_stock_in }}</td>
                                <td>{{ $stock->total_stock_out }}</td>
                                <td>{{ $stock->total_stock }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td>Total</td>
                            <td>Total Items = {{ $r1 }}</td>
                            <td>{{ $total_stock_in }}</td>
                            <td>{{ $total_stock_out }}</td>
                            <td>{{ $total_closing_stock }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endforeach
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
  $(document).ready(function () {
      @foreach ($closing_stock as $godown_id => $stocks)
        // Initialize DataTable for each table with a unique id
        new DataTable('#remindtable{{ $godown_id }}', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
      @endforeach
  });
</script>
@endsection
