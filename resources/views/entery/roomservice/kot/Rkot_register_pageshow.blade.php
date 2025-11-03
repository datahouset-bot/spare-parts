<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
    
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


<form method="GET" action="" id="kotForm">
    <div class="card my-3">
        <div class="card-header">
            Restaurant KOT Register
        </div>

        <div class="row form-group p-3">
            <div class="col-md-6">
                <select name="table_id" id="table_id" class="form-select">
                    @foreach ($tables as $record)
                        <option value="{{ $record->id }}">{{ $record->table_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Show</button>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('kotForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const tableId = document.getElementById('table_id').value;
        if (tableId) {
            window.location.href = '/table_wise_item_result/' + tableId;
        }
    });
</script>
        
           
    



        
    </div>
</div>

@endsection