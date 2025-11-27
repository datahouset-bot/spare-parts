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
<div class="container-fluid px-3 ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif


    <div class="card my-1">
        <div class="card-header">
        <h4>F & B Report  <h4>       </div>
       <div class="container mt-1" id="account_select_form">
        <form action="{{ url('fnb_result') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-3">
                           <select name="bill_type" id="bill_type"  class="form-select"required>
                            <option value="" selected disabled>Select Type </option>
                            <option value="Foodbill" >Service Bills  </option>
                            <option value="Restaurant_food_bill" >Parts  Bills  </option>
                            <option value="" >All  Bills  </option>

                           </select>
                </div>
                <div class="col-md-3 mb-3">
                           <select name="view_type" id="view_type"  class="form-select"required>
                            <option value="view" selected >View  </option>
                            <option value="print" >Print  </option>


                           </select>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control date" name="from_date" value="{{ date('Y-m-d') }}"
                        required>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}"
                        required>
                </div>
                <div class="col-md-2 float-end">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>

                </div>


            </div>

        </form>

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
{{-- 
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
 
</script> --}}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets\js\form.js') }}"></script>

<script>
    $(document).ready(function () {
    let table = new DataTable('#remindtable', {
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '->',
                        footer: true, // Enable footer export
                        exportOptions: {
                            columns: ':visible', // Export visible columns
                            modifier: {
                                page: 'all' // Export all pages
                            }
                        },
                        customize: function (xlsx) {
                            let sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:last', sheet).after(
                                '<row><c t="inlineStr"><is><t>Total</t></is></c>' +
                                '<c></c><c></c><c></c><c></c><c></c>' +
                                '<c t="n"><v>' + totalSGST + '</v></c>' +
                                '<c t="n"><v>' + totalCGST + '</v></c>' +
                                '<c t="n"><v>' + totalIGST + '</v></c>' +
                                '<c t="n"><v>' + totalTaxable + '</v></c>' +
                                '<c t="n"><v>' + totalGST + '</v></c>' +
                                '<c t="n"><v>' + totalBillAmt + '</v></c>' +
                                '<c t="n"><v>' + totalAdvance + '</v></c>' +
                                '<c t="n"><v>' + totalNetPayAmt + '</v></c>'
                            );
                        }
                    },
                    'copy', 'csv','excel', 'pdf', 'print'
                ]
            }
        },
        footerCallback: function (row, data, start, end, display) {
    let api = this.api();

    // Function to sum values, handling empty or non-numeric values
    let sumColumn = function (colIdx) {
        return api
            .column(colIdx, { page: 'all' })
            .data()
            .reduce((a, b) => {
                let valA = parseFloat(a) || 0; // Convert 'a' to a number, default to 0
                let valB = parseFloat(b) || 0; // Convert 'b' to a number, default to 0
                return valA + valB;
            }, 0);
    };

    // Calculate column totals
    let totalSGST = sumColumn(15); // Update index as per your table
    let totalCGST = sumColumn(16);
    let totalIGST = sumColumn(17);
    let totalTaxable = sumColumn(18);
    let totalGST = sumColumn(19);
    let totalBillAmt = sumColumn(20);
    let totalAdvance = sumColumn(21);
    let totalNetPayAmt = sumColumn(22);

    // Update table footer
    $(api.column(15).footer()).html(totalSGST.toFixed(2));
    $(api.column(16).footer()).html(totalCGST.toFixed(2));
    $(api.column(17).footer()).html(totalIGST.toFixed(2));
    $(api.column(18).footer()).html(totalTaxable.toFixed(2));
    $(api.column(19).footer()).html(totalGST.toFixed(2));
    $(api.column(20).footer()).html(totalBillAmt.toFixed(2));
    $(api.column(21).footer()).html(totalAdvance.toFixed(2));
    $(api.column(22).footer()).html(totalNetPayAmt.toFixed(2));
}

    });
});

</script>
@endsection