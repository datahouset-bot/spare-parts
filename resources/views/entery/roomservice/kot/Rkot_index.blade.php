<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">
<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
<style>
  .cancel{
    background-color: rgb(240, 185, 185) !important;
  }
  .Unprinted{
     background-color: rgb(1, 240, 1) !important;
  }
</style>
<script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
  });
</script>
<div class="container ">
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


    <div class="card my-3">
        <div class="card-header">
       Restaurant KOT 
        </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">


             <a href="{{url('/kots/create')}}" class="btn btn-success">New KOT</a>
             <a href="{{url('/kots_cleared/Rkot')}}" class="btn btn-primary">Cleared KOT List </a>
             <a href="{{ url('/nckot_register') }}" class="btn btn-danger">Nc KOT Register </a>
             <a href="{{ url('/kots_cancel') }}" class="btn btn-danger">Cancel KOT</a>
             <a href="{{ url('/table_wise_item') }}" class="btn btn-dark">Table Wise Item</a>
             <a href="{{ url('/kot_register_pageshow') }}" class="btn btn-info">Kot Register</a>

             <a href="{{url('/kichen_dashboard')}}" class="btn btn-warning">Kitchen Dashboard </a>
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr >
                    <th scope="col">S.No</th>
                    <th scope="col"> Date  </th>
                    <th scope="col"> KOT No    </th>
                    <th scope="col"> Table No  </th>
                    <th scope="col"> Total Qty </th>
                    <th scope="col"> Total Amount </th>
                    <th scope="col"> Serve Status </th>
                    <th scope="col"> Remark </th>
                    <th scope="col"> Status </th>
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
                  @foreach ($kots as $record)
                    
                  <tr class="{{$record['status']}} {{$record->ready_to_serve}}">
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td scope="col">{{ \Carbon\Carbon::parse($record['voucher_date'])->format('d-m-y') }}</td>
                     <td>{{$record['bill_no']}}</td>
                     <td>{{$record->table_name}}</td>
                     <td>{{$record['total_qty']}}</td>
                     <td>{{$record['total_amount']}}</td> 
                     <td>{{$record['ready_to_serve']}}</td> 
                    <td>{{$record['kot_remark']}}</td> 
                     <td>{{$record['status']}}</td> 


                    

                  <td>
                    <a href="{{ url('Rkot_print', [$record['user_id'], $record['voucher_no']]) }}" class="btn btn-sm">
                      <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                  </a>
                  
                </td>

                     <td>
                      <a href="{{ url('Rkot_print_view', [$record['user_id'], $record['voucher_no']]) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
                  </td> 
                  <td>
                      <a href="{{ url('rkot_edit', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>
<!-- Cancel Button -->
<td>
    <button class="btn btn-sm text-danger open-cancel-modal" 
            data-voucher="{{ $record['voucher_no'] }}"
            title="Cancel">
        <i class="fa fa-times-circle" style="font-size:20px;"></i>
    </button>
</td>

                <td>
                    <a href="{{ url('rkot_destroy', $record['voucher_no']) }}" class="btn  btn-sm" ><i class="fa fa-trash" style="font-size:20px;color:red"></i></a>
                </td>

                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
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

