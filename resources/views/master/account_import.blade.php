<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      dateFormat:"dd-mm-yy",
      changeMonth:true,
      changeYear:true,

           
    }).datepicker('setDate','0');
  } );
  </script>
    
    
<script>
  $(document).ready(function () {
    let table = new DataTable('#remindtable');
   
   });
</script>


        

 <div class="container">
  
  @if(session('message'))
    <div class="alert alert-primary my-3">
        {{ session('message') }}
    </div>
  @endif




      <div class="card my-3" style="width: 100%;">
        
        <div class="my-2 mx-2">
        <form method="POST" action="{{ url('downloadExcel') }}">
          @csrf
          <button type="submit" class="btn btn-primary">Sample Excel</button>
      </form></div> 
        <h3 class="card-title">&nbsp;&nbsp;Account List Import </h3>
        {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
        
        <form action="{{url('/account_import')}}"   method="POST"  enctype="multipart/form-data">
          @csrf
        <div class="card-body">
          <div class="form-group">
        <div class="row">
            <div class="col-md-6">
 
         <div class="row my-10">
          <div class="col-md-10">
            <input type="file" class="form-control" name="file" >
            <label for="">Select Only .xls (excel) File </label>
            <span class="text-danger"> 
              @error('file')
              {{$message}}
                  
              @enderror
            </span>  
          </div>
          <div class="col-md-2">
            <button type="submit"class="btn btn-primary btn-block">Upload</button>
          </div>
         </div>
        </form>
        <br>
        <br>
        <div>
          <h5>Instruction</h5>
          <ul>
            <li>1.Try To Upload  max 500 record at once </li>
            <li>2.Wait Wile getting message Reord Succesfully Uploaded  </li>
            <li>3.First download sample File and then add record on downloded xls  </li>
            <li>4.dont Change Column Sequnce </li>
          </ul>


        </div>


        


          </div>


        </div>
      </div>
    </div>

    </div>
</div>

@endsection