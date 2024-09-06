<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')

<div class="container ">

    <div class="card my-3">
        <div class="card-header">
        Item  Wise Sale Report 
        </div>
       <div class="row ">
        <div class="container mx-1">
          <form action="{{ url('item_wise_sale_report') }}" method="POST">
              @csrf
              <div class="row">
                  <div class="col-md-3 mb-3">
                    Form Date
                      <input type="text" class="form-control date" name="from_date" value="{{ date('Y-m-d') }}" required>
                  </div>
                  <div class="col-md-3 mb-3">
                     To Date
                      <input type="text" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}" required>
                  </div>
                  <div class="col-md-2 my-4">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>
                </div>

              </div>

          </form>
      </div> 
        <div class="card-body">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Amount</th>

                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                    $totalitem=0;
                    $totalamount=0;
                  @endphp
                  @foreach ($item_wise_sales as $record)
                  <tr>
                    @php
                        $totalitem+=$record->total_qty_sold;
                        $totalamount+=$record->total_amount;
                    @endphp
                    <th scope="row">{{ $r1 = $r1 + 1 }}</th>
                    <td>{{$record->item_name}}</td>
                    <td>{{$record->total_qty_sold}}</td>
                    <td>{{$record->rate}}</td>
                    <td>{{ number_format($record->total_amount, 2) }}</td>


                  </tr>
                    
                  @endforeach
                  
                  
                </tbody>
                <tfoot>
                  <tr><td></td>

                    <td>Total</td>
                    <td>{{ $totalitem }}</td>
                    <td></td>
                    <td>{{ number_format($totalamount, 2) }}</td>
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
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets\js\form.js') }}"></script>
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