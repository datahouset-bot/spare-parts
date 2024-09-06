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

           
    });
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
        <h5 class="card-title">To do / Reminder / Task </h5>
        {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
        
        <form action="{{url('/updatetodo')}}"   method="POST">
          @method('PUT')
          @csrf
        <div class="card-body">
          <div class="form-group">
        <div class="row">
            <div class="col-md-2">

              <div> <input type="text" value="{{ $data['id'] }}" name="id"></div> 

            <input type="text" class="form-control" id="datepicker" name="reminder_date_given" placeholder="Reminder Date "  value="{{ \Carbon\Carbon::parse($data['reminder_date'])->format('d-m-Y') }}"> 
            <span class="text-danger"> 
              @error('reminder_date_given')
              {{$message}}
                  
              @enderror
            </span>  


            </div>
            <div class="col-md-2">
              <input type="text" class="form-control" name="reminder_title" value="{{ $data['reminder_title'] }}">
              <span class="text-danger"> 
                @error('reminder_title')
                {{$message}}
                    
                @enderror
              </span>
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control" name="reminder_name" placeholder="Name" value ="{{ $data['reminder_name'] }}">
              <span class="text-danger"> 
                @error('reminder_name')
                {{$message}}
                    
                @enderror
              </span> 
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control" name="reminder_mobile" placeholder="Mobile No " value ="{{ $data['reminder_mobile'] }}"> 
            </div>
            <div class="col-md-2">
              <input type="text" class="form-control" name="reminder_city" placeholder="city" value ="{{ $data['reminder_city'] }}"> 
            </div>
         </div>
         <div class="row my-3">
          <div class="col-md-10">
            <input type="text" class="form-control" name="reminder_disc" placeholder="Discription "value ="{{ $data['reminder_disc'] }}"> 
          
            <span class="text-danger"> 
              @error('reminder_disc')
              {{$message}}
                  
              @enderror
            </span>  
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-block">Update</button>
          </div>
         </div>
        </form>


          </div>


        </div>
      </div>
    </div>

        </div>
    </div>
</div>

@endsection