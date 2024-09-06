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


    <div class="card my-3">
        <div class="card-header">
   Room Service 
        </div>
       <div class="row my-2">
          <div class="col-md-12 text-center">
            <a href="{{route('kots.index')}}" class="btn btn-primary">KOT</a>


             <a href="{{route('foodbills.index')}}" class="btn btn-warning">Food Bill</a> 
          </div>
       </div>
        

           
    



          {{-- data table start  --}}
        {{-- <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Room No   </th>
                    <th scope="col"> Bookig No    </th>
                    <th scope="col"> Guest Name </th>
                    <th scope="col"> Contact No </th>
                    <th scope="col"> Booking Date </th>
                    <th scope="col"> Check in Date </th>
                    <th scope="col"> Check Out Date  </th>
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
                         
                  
                </tbody>
              </table>

        </div> --}}
    </div>
</div>

@endsection