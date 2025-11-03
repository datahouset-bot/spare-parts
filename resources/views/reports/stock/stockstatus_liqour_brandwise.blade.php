

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">

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
    <div class="container ">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif

        <table class="table table-striped" id="remindtable">
          <thead class="table-dark">
              <tr>
                  <th scope="col">Brand </th>
                  <th scope="col"> stock In ML </th>

                  <th scope="col"> Stock Out ML</th>
                  <th scope="col"> Closing ML</th>

                  <th scope="col"> Closing Bottel</th>




              </tr>
          </thead>
          <tbody>

              @php
                  $r1 = 0;
                  $total_stock_in = 0;
                  $total_stock_out = 0;
                  $total_closing_stock = 0;

              @endphp

              @php
                  $grouped = $closing_stock->groupBy('company_name');
              @endphp

              @foreach ($grouped as $company => $records)
                  @php
                      // Check if this company has at least one item in the LIQUOR group
                      $liquor_records = $records->filter(function ($r) {
            return in_array(strtoupper($r->group_name), ['LIQUOR', 'HARD DRINK']);

                      });

                      if ($liquor_records->isEmpty()) {
                          continue; // skip this company if no LIQUOR items
                      }

                      $stock_in_unit2 = 0;
                      $stock_out_unit2 = 0;
                  @endphp

                  @foreach ($liquor_records as $record)
                      @php
                          $stock_in_unit2 +=
                              $record->total_stock_in * $record->conversion;
                          $stock_out_unit2 +=
                              $record->total_stock_out * $record->conversion;
                      @endphp
                  @endforeach

                  <tr class="table-secondary">
                      <td><strong>{{ $company }}</strong></td>
                      <td><strong>{{ $stock_in_unit2 }}</strong></td>
                      <td><strong>{{ $stock_out_unit2 }}</strong></td>
                      <td><strong>{{ $stock_in_unit2 - $stock_out_unit2 }}</strong></td>
                      <td><strong>{{ round(($stock_in_unit2 - $stock_out_unit2) / 750, 2) }}</strong>
                      </td>
                  </tr>
              @endforeach

    </div>


                                {{-- <a href="{{url('purchases/create')}}" class="btn btn-primary">New Purchase  </a>
            <a href="{{url('purchases')}}" class="btn btn-dark"> Purchase Register </a> --}}

                                {{-- data table start  --}}
                                {{-- <div class="card-body table-scrollable"> --}}

    

                                {{-- </div> --}}








              
                            
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
                $(document).ready(function() {

                    new DataTable('#remindtable', {
                        layout: {
                            topStart: {
                                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                            }
                        }
                    });


                });
            </script>
        @endsection
