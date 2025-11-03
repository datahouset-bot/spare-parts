<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- JS dependencies for export buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    
{{-- <script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
  });
</script> --}}
<style>
  .cancel{
    background-color: rgb(240, 185, 185) !important;
  }
</style>
<script>
  $(document).ready(function () {
    new DataTable('#remindtable', {
      dom: 'Bfrtip', // Display buttons and filters
      buttons: [
        {
          extend: 'excelHtml5',
          title: 'KOT_Report'
        },
        {
          extend: 'pdfHtml5',
          title: 'KOT_Report',
          orientation: 'landscape',
          pageSize: 'A4'
        },
        'print'
      ]
    });
  });
</script>

<div class="container my-2">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif
@if (session('errors'))
<div class="alert alert-danger">
    {{ session('errors') }}
</div>
@endif
<h1 style="text-align: center; margin-top: 20px; font-size: 28px; color: #2c3e50;">
    NC KOT Register
</h1>



           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> KOT Date  </th>
                    <th scope="col"> KOT Time  </th>
                    <th scope="col"> Oprater Name  </th>

                    <th scope="col"> Bill No   </th>
                     
                    <th scope="col">Item Name   </th>
                    <th scope="col"> Qty  </th>
                    <th scope="col"> Rate </th>
                    <th scope="col"> Amount </th>
                    <th scope="col"> Remark </th>
                    <th scope="col">Cancel   </th>

                    <th scope="col">Print Kot   </th>
                 
 
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($kots as $record)
                    
                  <tr class="{{$record['status']}}">
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td scope="col">{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}</td>
                    <td>{{ $record->created_at->format('H:i') }}</td>
                    <td>
                      {{$record['user_name']}}
                      
                    </td> 
                    <td>{{$record['bill_no']}}</td>
                     <td>{{$record->item_name}}</td>
                     <td>{{$record['qty']}}</td>
                     <td>{{$record['rate']}}</td> 
                     <td>{{$record['amount']}}</td> 
                     <td>{{$record->kot_remark}}</td>
    <!-- Cancel Button -->
<td>
    <button class="btn btn-sm text-danger open-cancel-modal" 
            data-voucher="{{ $record['voucher_no'] }}"
            title="Cancel">
        <i class="fa fa-times-circle" style="font-size:20px;"></i>
    </button>
</td>

                     <td>
                      <a href="{{ url('kot_print_view', [$record['user_id'], $record['voucher_no']]) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                     </td>
   
                  </td> 
</td> 


                    

                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
                </div>
<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="cancelForm" method="POST" action="{{ url('rkot_cancel') }}">
        @csrf
        <input type="hidden" name="voucher_no" id="cancel_voucher_no">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <label for="cancel_remark">Reason for cancellation:</label>
                <textarea name="cancel_remark" id="cancel_remark" class="form-control" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Cancel Record</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function () {
    // Initialize DataTable
    let table = new DataTable('#remindtable');

    // Handle Cancel Button Click
    $('.open-cancel-modal').on('click', function () {
      let voucherNo = $(this).data('voucher');
      $('#cancel_voucher_no').val(voucherNo);
      $('#cancelModal').modal('show');
    });
  });
</script>


@endsection