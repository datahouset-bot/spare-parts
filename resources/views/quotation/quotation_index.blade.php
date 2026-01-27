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
<div class="container-fluid" style="max-width:90% !important;">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


   <div class="card my-3 w-100" style="border-radius:5px;">
        <div class="card-header">
        <h4>Quotation list  <h4>       </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
           <a href="{{ route('quotations.create') }}" class="btn btn-primary">
    New Quotation
</a>

            {{-- <a href="{{url('sale_register')}}" class="btn btn-dark"> Register sale </a> --}}
          </div>
       </div>
        
<div class="row mb-3">
    <div class="col-md-3">
        <label class="fw-bold">From Date</label>
        <input type="date" id="fromDate" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="fw-bold">To Date</label>
        <input type="date" id="toDate" class="form-control">
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary w-50" id="filterDate">
            <i class="fa fa-filter"></i> 0K
        </button>
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-secondary w-100" id="resetDate">
            <i class="fa fa-refresh"></i> Today
        </button>
    </div>
</div>

          {{-- data table start  --}}
        <div class="card-body table-scrollable">
 
          <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Terms</th>

                    <th scope="col"> Bill No    </th>
                    <th scope="col"> Bill Date</th>
                    <th scope="col"> Party</th>
                    <th scope="col">Total Qty </th>
                    <th scope="col">Taxable Amt</th>
                    <th scope="col">Total Discount </th>
                    <th scope="col">Tax Amt </th>
                    <th scope="col"> Bill Amount  </th>
  
                    <th scope="col">Print</th>
                    {{-- <th scope="col">View</th> --}}
                    <th scope="col">Edit</th>
                    <th scope="col">Message</th>
                    <th scope="col">Delete</th>


                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
            @foreach ($sales as $record)
                    
            <tr>
           
              <td scope="row">{{$r1=$r1+1}}</td>
              <td>{{$record->voucher_terms}}</td>
              <td>{{$record->voucher_bill_no}}</td>

              <td scope="col">{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}</td>
                    
              <td>{{ $record->account->account_name ?? 'N/A' }}</td>


               <td>{{$record['total_qty']}}</td>
               <td>{{$record['total_item_basic_amount']}}</td>
               <td>{{$record['total_disc_item_amount']}}</td>
               <td>{{$record['total_gst_amount']}}</td>
               <td>{{$record['total_net_amount']}}</td>      
               {{-- <td>
                <button class="btn btn-sm" onclick="printRoomBooking({{url('room_checkout_view', $record['voucher_no'])  }})">
                    <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                </button>
            </td> --}}
                  

               <td>
                <a href="{{ url('print_quotation_select', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
            </td> 
            <td>
                <a href="{{ route('sales.edit', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
            </td>
            <td><a href="http://wa.me/91{{$record}}" ><i class="fa fa-bullhorn"style="font-size:20px;color:green"></i> </a></td>


              <td>
                <form action="{{ route('quotations.destroy', $record['voucher_no']) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this  Record ?{{$record['voucher_no']}}')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
                </form>
            </td>
                  
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

{{-- <script>
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
 
</script> --}}
  <script>
$(document).ready(function () {

    // Get today's date (YYYY-MM-DD)
    let today = new Date().toISOString().split('T')[0];

    // Set default dates
    $('#fromDate').val(today);
    $('#toDate').val(today);

    // Custom date filter
    $.fn.dataTable.ext.search.push(function (settings, data) {

        let min = $('#fromDate').val();
        let max = $('#toDate').val();

        // Bill Date column (index 3) → format: d-m-y
        let billDateStr = data[3]; 
        let parts = billDateStr.split('-');
        let billDate = new Date(`20${parts[2]}-${parts[1]}-${parts[0]}`);

        if (
            (!min && !max) ||
            (!min && billDate <= new Date(max)) ||
            (new Date(min) <= billDate && !max) ||
            (new Date(min) <= billDate && billDate <= new Date(max))
        ) {
            return true;
        }
        return false;
    });

    // Initialize DataTable
    let table = new DataTable('#remindtable', {
        order: [[3, 'desc']], // order by Bill Date
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        }
    });

    // Apply default (today) filter
    table.draw();

    // Filter button
    $('#filterDate').on('click', function () {
        table.draw();
    });

    // Reset to Today
    $('#resetDate').on('click', function () {
        $('#fromDate').val(today);
        $('#toDate').val(today);
        table.draw();
    });

});
</script>
<script>
document.addEventListener('keydown', function (e) {

    // SHIFT + N → New Sale Invoice
    if (e.shiftKey && e.key.toLowerCase() === 'n') {

        // Prevent default browser behavior
        e.preventDefault();

        // Ignore while typing in inputs
        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) return;

        // Redirect to New Sale Invoice page
        window.location.href = "{{ url('sales/create') }}";
    }

});
</script>



@endsection