<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css') }}">

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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <style>
        td {
            margin: 1px !important;
            padding: 1px !important;
        }

        .card-header {
            margin: 0;
        }

        .col {
            margin: 0;
        }
    </style>



    {{-- <script>
        $(document).ready(function() {
            let table = new DataTable('#remindtable');

        });
    </script> --}}
    <div class="container ">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif
        @if (session('errors'))
            <div class="alert alert-danger">
                {{ session('errors') }}
            </div>
        @endif


        <div class="card">
            <div class="card-header col-md-12 text-center">
                <form action="{{ url('kot_register_result') }}" method="POST">
                    @csrf

                    <div class="row ">
                        <div class="col-md-4 ">
                            <h4>KOT Register</h4>
                        </div>
                        <div class="col-md-2">
<select name="type" id="type" class="form-select">
    <option value="" selected disabled>Select KOT Type</option>
    <option value="Rkot">All Restaurant KOT</option>
    <option value="kot">All Room KOT</option>
    <option value="clear_kot">Cleared Room KOT</option>
    <option value="clear_Rkot">Cleared Restaurant KOT</option>
    <option value="cancel_kot">Cancelled Room KOT</option>
    <option value="cancel_Rkot">Cancelled Restaurant KOT</option>
    <option value="all_kot">All KOTs</option>
</select>

                        </div>
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
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-block">OK</button>


                        </div>
                        


                </form>



            </div>
        </div>
        <div class="row my-2">

        </div>







        {{-- data table start  --}}
        
        <div class="card-body table-scrollable">

            <table class="table table-striped" id="remindtable">
                @php

                    $formattedFromDate = Carbon::parse($from_date)->format('d-m-y');
                    $formattedToDate = Carbon::parse($to_date)->format('d-m-y');
                @endphp
                    <span style="text-align: center; font-size: 18px;">
                        Report From {{ $formattedFromDate }} to {{ $formattedToDate }}
                    </span> 
               
              
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
                    
                  {{-- <tr class="{{$record['status']}}"> --}}
           
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
                    <a href="{{ url('kot_print', [$record['user_id'], $record['voucher_no']]) }}" class="btn btn-sm">
                      <i class="fa fa-print" style="font-size:20px;color:SlateBlue"></i>
                  </a>
                  
                </td>

                     <td>
                      <a href="{{ url('kot_print_view', [$record['user_id'], $record['voucher_no']]) }}" class="btn  btn-sm" ><i class="fa fa-eye" style="font-size:20px;color:SlateBlue"></i></a>
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
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right">Total:</th>
                        <th id="totalQty">0</th>
                        <th id="totalAmount">0</th>
                        <th colspan="8"></th>
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
        // $(document).ready(function() {

        //     new DataTable('#remindtable', {
        //         layout: {
        //             topStart: {
        //                 buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        //             }
        //         }
        //     });


        // });
        $(document).ready(function() {
            $('#remindtable').DataTable({
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Helper to parse float safely
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            parseFloat(i.replace(/[\₹,]/g, '')) || 0 :
                            typeof i === 'number' ? i : 0;
                    };

                    // Total over all pages
                    let totalQty = api
                        .column(5)
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    let totalAmt = api
                        .column(6)
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // Update footer
                    $(api.column(5).footer()).html(totalQty);
                    $(api.column(6).footer()).html(totalAmt.toFixed(2));
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

    </script>
@endsection
