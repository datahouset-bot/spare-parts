<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <style>
      td{
        margin: 1px !important;
        padding: 1px !important;
      }
    </style>
    
{{-- <script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
  });
</script> --}}
<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-1">
        <div class="card-header">
        <h4>Payment Register <h4>       </div>
       <div class="container mt-1" id="account_select_form">
        <form action="{{ url('payment_register_result') }}" method="POST">
            @csrf
            <div class="row">
             <div class="col-md-2 ">
                 @php
                                use Carbon\Carbon;
                                $defaultDate = $from_date
                                    ? Carbon::parse($from_date)->format('d-m-Y')
                                    : Carbon::now('Asia/Kolkata')->format('d-m-Y');
                            @endphp

                            <input type="text" class="form-control gdate" id="from_date" name="from_date"
                                value="{{ $defaultDate }}" required>







                        </div>
                        <div class="col-md-2 ">
                            <input type="text" class="form-control gdate" id="to_date" name="to_date"
                                value="{{ \Carbon\Carbon::parse($to_date)->format('d-m-Y') }}" required>
                        </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>

                </div>


            </div>

        </form>

    </div> 

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
          <div class="mb-2">
    <strong>Report From:</strong> {{ \Carbon\Carbon::parse($from_date)->format('d-m-Y') }}
    <strong>To:</strong> {{ \Carbon\Carbon::parse($to_date)->format('d-m-Y') }}
</div>

 
          <table class="  " id="remindtable">
                              <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col"> Date  </th>
                        <th scope="col"> Reciept No  </th>
                        <th scope="col"> Payment Mode </th>
                        <th scope="col"> Account Name </th>
                        <th scope="col"> Amount</th>
                        <th scope="col"> Remark</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $r1 = 0;
                    @endphp
                    @foreach ($ledgers as $ledger)
                
              <tr>
       
                <th scope="row">{{$r1=$r1+1}}</th>
         <td>{{ Carbon::parse($ledger->entry_date)->format('d-m-y') }}</td>

                <td>{{$ledger->reciept_no}}</td>
                <td>{{$ledger->payment_mode_name}}</td>
                <td>{{$ledger->account_name}}</td>
                <td>{{$ledger->amount}}</td>
                <td>{{$ledger->remark}}</td>



                
              <td>
                {{-- {{ route('roomtypes.edit', $ledger['id']) }} --}}
                  <a href="" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
              </td>


                <td>
                    <a href="{{ url('payment_delete/'. $ledger->voucher_no) }}" onclick="return confirm('Are you sure you want to delete this Reciept?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></a>
                 
              </td>
              
              </tr>
              @endforeach    
                  
                </tbody>
         <tfoot>
        <tr>
            <th colspan="5" style="text-align:right">Total:</th>
            <th id="totalAmount"></th>
            <th colspan="3"></th>
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
$(document).ready(function () {
    let fromDate = "{{ \Carbon\Carbon::parse($from_date)->format('d-m-Y') }}";
    let toDate = "{{ \Carbon\Carbon::parse($to_date)->format('d-m-Y') }}";

    new DataTable('#remindtable', {
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'copy',
                        messageTop: 'Report From ' + fromDate + ' To ' + toDate
                    },
                    {
                        extend: 'csv',
                        messageTop: 'Report From ' + fromDate + ' To ' + toDate
                    },
                    {
                        extend: 'excel',
                        messageTop: 'Report From ' + fromDate + ' To ' + toDate
                    },
                    {
                        extend: 'pdf',
                        messageTop: 'Report From ' + fromDate + ' To ' + toDate
                    },
                    {
                        extend: 'print',
                        messageTop: function () {
                            return 'Report From ' + fromDate + ' To ' + toDate;
                        }
                    }
                ]
            }
        },
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            var intVal = function (i) {
                return typeof i === 'string'
                    ? i.replace(/[\$,]/g, '') * 1
                    : typeof i === 'number'
                    ? i
                    : 0;
            };

            var total = api
                .column(5, { search: 'applied' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var pageTotal = api
                .column(5, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(5).footer()).html(pageTotal );
        }
    });
});
 
</script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets\js\form.js') }}"></script>
<script>
        $(function() {
            $(".gdate").datepicker({
                dateFormat: "dd-mm-yy"
            });
        });
    </script>

@endsection