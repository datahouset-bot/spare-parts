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

<style>
/* FULL PAGE FIX */
html, body {
    width: 100%;
    overflow-x: hidden;
}

.container-fluid {
    max-width: 100%;
}

/* DataTable full width */
.dataTables_wrapper {
    width: 100%;
}

table.dataTable {
    width: 100% !important;
}

/* Sticky header remains */
.card {
    position: sticky;
    top: 0;
    z-index: 10;
}
.form-control,
.btn {
    height: 36px;
}
.dataTables_paginate,
.dataTables_info {
    padding: 8px 12px;
}


</style>
<div class="container-fluid px-0">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif



  <div class="card mb-3">
    <div class="card-body">
        <div class="row align-items-end g-2">

            <!-- Title -->
            <div class="col-md-2">
                <h4 class="mb-0">Purchase</h4>
            </div>

            <!-- New Purchase Button -->
            <div class="col-md-2">
                <a href="{{ url('purchases/create') }}"
                   class="btn btn-primary w-100">
                    New Purchase
                </a>
            </div>

            <!-- From Date -->
            <div class="col-md-2">
                <label class="fw-semibold">From Date</label>
                <input type="date" id="from_date" class="form-control">
            </div>

            <!-- To Date -->
            <div class="col-md-2">
                <label class="fw-semibold">To Date</label>
                <input type="date" id="to_date" class="form-control">
            </div>

            <!-- Filter -->
            <div class="col-md-2">
                <button class="btn btn-primary w-100" id="filterBtn">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </div>

            <!-- Reset -->
            <div class="col-md-2">
                <button class="btn btn-secondary w-100" id="resetBtn">
                    Reset
                </button>
            </div>

        </div>
    </div>
</div>


          {{-- data table start  --}}
       <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-striped w-100" id="remindtable">

                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Bill No    </th>
                    <th scope="col"> Bill Date</th>
                    <th scope="col"> Party</th>
                    <th scope="col">Total Qty </th>
                    <th scope="col">Taxable Amt</th>
                    <th scope="col">Total Discount </th>
                    <th scope="col">Tax Amt </th>
                    <th scope="col"> Bill Amount  </th>
                    <th scope="col"> Terms  </th>
  
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>


                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($purchases as $record)
                    
                  <tr>
           
                    <td scope="row">{{$r1=$r1+1}}</td>
                    <td>{{$record->voucher_bill_no}}</td>
                    <td data-date="{{ \Carbon\Carbon::parse($record['voucher_date'])->format('Y-m-d') }}">
    {{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}
</td>
                     <td>{{$record->account->account_name}}</td>
                     <td>{{$record['total_qty']}}</td>
                     <td>{{$record['total_item_basic_amount']}}</td>
                     <td>{{$record['total_disc_item_amount']}}</td>
                     <td>{{$record['total_gst_amount']}}</td>
                     <td>{{$record['total_net_amount']}}</td>
                     <td>{{$record['voucher_terms']}}</td>

                    
                     <td>
                      <button class="btn btn-sm" onclick="printRoomBooking({{url('room_checkout_view', $record['voucher_no'])  }})">
                          <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                      </button>
                  </td>
                  

                     <td>
                      <a href="{{url('purchases_show', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                  </td> 
                  <td>
                      <a href="{{ route('purchases.edit', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>
                  <td><a href="http://wa.me/91{{$record->account->mobile}}" ><i class="fa fa-bullhorn"style="font-size:20px;color:green"></i> </a></td>


                    <td>
                      <form action="{{ route('purchases.destroy', $record['voucher_no']) }}" method="POST" style="display:inline;">
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
<script>
$(document).ready(function () {

   let table = new DataTable('#remindtable', {
    responsive: false,
    scrollX: true,
    layout: {
        topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        },
        topEnd: 'search'
    }
});

    // Custom DATE RANGE filter
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {

        let fromDate = $('#from_date').val();
        let toDate   = $('#to_date').val();

        let billDate = $('#remindtable tbody tr')
            .eq(dataIndex)
            .find('td:eq(2)')
            .data('date'); // YYYY-MM-DD

        if (!billDate) return true;

        // If no filter applied
        if (fromDate === '' && toDate === '') {
            return true;
        }

        // From date only
        if (fromDate !== '' && toDate === '') {
            return billDate >= fromDate;
        }

        // To date only
        if (fromDate === '' && toDate !== '') {
            return billDate <= toDate;
        }

        // From & To both
        return billDate >= fromDate && billDate <= toDate;
    });

    // Apply filter
    $('#filterBtn').on('click', function () {
        table.draw();
    });

    // Reset filter
    $('#resetBtn').on('click', function () {
        $('#from_date').val('');
        $('#to_date').val('');
        table.draw();
    });

});
</script>

@endsection