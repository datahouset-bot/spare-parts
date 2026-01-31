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
/* ================= GLOBAL ================= */
body {
    background: #f3f6fb;
    font-family: "Segoe UI", Tahoma, sans-serif;
}

/* ================= CARD ================= */
.card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 12px 30px rgba(0,0,0,.08);
    overflow: hidden;
}

/* ================= CARD HEADER ================= */
.card-header {
    background: linear-gradient(135deg, #ffffff, #eef2f7);
    padding: 14px 18px;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h4 {
    margin: 0;
    font-weight: 700;
    color: #1f2937;
}

/* ================= FILTER FORM ================= */
#account_select_form {
    background: #ffffff;
    border-radius: 12px;
    padding: 15px;
    margin: 10px;
    box-shadow: 0 8px 22px rgba(0,0,0,.06);
}

/* ================= INPUT ================= */
.form-control {
    height: 38px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
}

.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 .15rem rgba(37,99,235,.25);
}

/* ================= BUTTON ================= */
.btn-primary {
    border-radius: 30px;
    padding: 7px 26px;
    font-weight: 600;
    box-shadow: 0 6px 16px rgba(37,99,235,.35);
    transition: all .2s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 22px rgba(37,99,235,.45);
}

/* ================= TABLE AREA ================= */
.table-scrollable {
    background: #ffffff;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,.06);
}

/* Compact table cells */
td {
    padding: 6px !important;
}

/* ================= ALERT ================= */
.alert {
    border-radius: 10px;
    font-weight: 500;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .card-header {
        text-align: center;
    }

    #account_select_form .row > div {
        margin-bottom: 10px;
    }

    .btn-primary {
        width: 100%;
    }
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
        <h4>Vehicle Service Report <h4>       </div>
       <div class="container mt-1" id="account_select_form">
        <form action="{{ url('roomsales_report_result') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-2 mb-3">
                    <input type="text" class="form-control date" name="from_date" value="{{ date('Y-m-d') }}"
                        required>
                </div>
                {{-- <div class="col-md-2 mb-3">
                    <input type="text" class="form-control date" name="to_date" value="{{ date('Y-m-d') }}"
                        required>
                </div> --}}
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>

                </div>


            </div>

        </form>

    </div> 

           
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
 
          {{-- <table class="  " id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">Type</th>
                    <th scope="col"> Place Of Supply</th>
                    <th scope="col"> Applicable % of Tax Rate </th>
                    <th scope="col"> Rate</th>
                    <th scope="col"> Taxable Value</th>
                    <th scope="col"> Cess Amount</th>
                    <th scope="col"> E-Commerce GSTIN </th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                    @if ($total_5_percent_taxable_value>0)
                        
                  <tr>
           

                     <td></td>
                     <td></td>
                     <td></td>
                     <td>5</td>
                     <td>{{$total_5_percent_taxable_value}}</td>
                     <td>0</td>
                     <td></td>

                  </tr>
                  @endif
                  @if ($total_12_percent_taxable_value>0)
                      
                  <tr>
           

                    <td></td>
                    <td></td>
                    <td></td>
                    <td>12</td>
                    <td>{{$total_12_percent_taxable_value}}</td>
                    <td>0</td>
                    <td></td>

                 </tr>
                 @endif
                 @if ($total_18_percent_taxable_value>0)
                     
                 <tr>
           

                  <td></td>
                  <td></td>
                  <td></td>
                  <td>18</td>
                  <td>{{$total_18_percent_taxable_value}}</td>
                  <td>0</td>
                  <td></td>

               </tr>
               @endif
               @if($total_28_percent_taxable_value > 0)
               <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td>28</td>
                   <td>{{ $total_28_percent_taxable_value }}</td>
                   <td>0</td>
                   <td></td>
               </tr>
           @endif
           
                  
                  
                </tbody>
              </table> --}}

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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ global_asset('/general_assets\js\form.js') }}"></script>


@endsection