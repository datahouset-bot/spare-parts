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
        <h5 class="card-title">    Add Follow Up </h5>
        

        <div class="card-body">
          <div class="form-group">
        <div class="row">
            <div class="col-md-2 my-2">
              <input type="text" class="form-control"  readonly value="{{ $data1['lead_title'] }}" >
              <span class="text-danger"> 
                @error('reminder_title')
                {{$message}}
                    
                @enderror
              </span>
            </div>
            <div class="col-md-3 my-2">
              <input type="text" class="form-control"  placeholder="Name" readonly value="{{ $data1['lead_name'] }}">
              <span class="text-danger"> 
                @error('reminder_name')
                {{$message}}
                    
                @enderror
              </span> 
            </div>
            
            <div class="col-md-3 my-2">
              <input type="text" class="form-control" name="lead_mobile" placeholder="Mobile No " readonly value="{{ $data1['lead_mobile'] }}"> 
            </div>
            <div class="col-md-2">
              <input type="text" class="form-control"  readonly value="{{ $data1['lead_city'] }}"> 
            </div>
         </div>
         <div class="row my-3">
          <div class="col-md-2 my-2">
            <input type="text" class="form-control"  readonly value="{{ $data1['lead_product'] }}"> 
          
            <span class="text-danger"> 
              @error('product')
              {{$message}}
                  
              @enderror
            </span>  
          </div>
         
          <div class="col-md-6 my-2">
            <input type="text" class="form-control"  readonly value="{{ $data1['lead_disc'] }}"> 
 

   
            <span class="text-danger"> 
              @error('reminder_disc')
              {{$message}}
                  
              @enderror
            </span>  
          </div>
          <div class="col-md-2 my-2">
            <input type="text" class="form-control"  readonly value="{{ $data1['lead_executive'] }}"> 
          

   
            <span class="text-danger"> 
              @error('reminder_disc')
              {{$message}}
                  
              @enderror
            </span>  
          </div>
          </div>

           <hr class  = "hr">

           <form action="{{url('/newfollowup')}}"   method="POST">

            @csrf

         <div class="row my-3  ">
          <div class="col-md-2 my-2">
     
            <input type="hidden" class="form-control"  name ="lead_id" readonly value="{{ $data1['id'] }}" >
             
              <input type="text" class="form-control" id="datepicker" name="followup_date" placeholder="Reminder Date "  value=""> 
              <span class="text-danger"> 
                @error('followup_date')
                {{$message}}
                    
                @enderror
              </span>  
  
  
     
     
          </div>
         
          <div class="col-md-6 my-2">
            <input type="text" class="form-control" name="followup_remark" placeholder="Remark "value =""> 
          
            <span class="text-danger"> 
              @error('followup_remark')
              {{$message}}
                  
              @enderror
            </span>  
          </div>

          <div class="col-md-1 my-2">
            <label for="">Cancel</label>
            <input class="form-check-input" type="checkbox" name ="lead_af1" value="1" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
          </div>




          <div class="col-md-1 my-2">
            <label for="">Done&nbsp;&nbsp;</label>
            <input class="form-check-input" type="checkbox" name="lead_af2" value="1" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault"></label>
        </div>


        




          <div class="col-md-2 my-2 ">
            <button type="submit" class="btn btn-primary btn-block">Save</button>
          </div>
         </div>
         <hr class = "hr">
        </form>
        <div class="card-body">

          <table class="table table-striped" id="remindtable">
              <thead>
                <tr>
                  <th scope="col">S.No</th>
                  <th scope="col"> Date </th>
                  <th scope="col"> Remark </th>
                  
                  
                </tr>
              </thead>
              <tbody>
        
                @php
                  $r1=0;
                @endphp

@foreach ($data as $record)
                  
<tr>
 
  <th scope="row">{{$r1=$r1+1}}</th>
  <td scope="col">{{ \Carbon\Carbon::parse($record['followup_date'])->format('d-m-y') }}
  
  
  </td>

  <td>{{$record['followup_remark']}}</td>


  {{-- <td><a href="{{('addfollowup/'.$record->lead->id) }}"  class="btn btn-success btn-sm" >Followup</a></td>
  --}}

</tr>
@endforeach
               

              </tbody>
            </table>
        
        </div>

          </div>


        </div>
      </div>
    </div>

        </div>
    </div>
</div>





@endsection


     
      