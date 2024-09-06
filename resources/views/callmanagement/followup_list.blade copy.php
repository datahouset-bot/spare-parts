
@extends('layouts.blank')
@section('pagecontent')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker1" ).datepicker({
      dateFormat:"dd-mm-yy",
      changeMonth:true,
      changeYear:true,

           
    }).datepicker('setDate','0');
    $( "#datepicker2" ).datepicker({
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
        <h5 class="card-title">    Follow Up List </h5>
        
        <form action="{{url('/followup_list_datewise')}}"   method="POST">
          
          @csrf
        <div class="card-body">
          <div class="form-group">
        <div class="row">

           <hr class  = "hr">

         <div class="row my-3  text align-center">
          <div class="col-md-2 my-3">
             <input type="text" class="form-control" id="datepicker1" name="from_date" placeholder="from date"  value=""> 
              <span class="text-danger"> 
                @error('from_date')
                {{$message}}
                    
                @enderror
              </span>  
             </div>
             <div class="col-md-2 my-3">
              <input type="text" class="form-control" id="datepicker2" name="to_date" placeholder="To Date "  value=""> 
               <span class="text-danger"> 
                 @error('to_date')
                 {{$message}}
                     
                 @enderror
               </span>  
              </div>
         
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-block">OK</button>
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
                  <th scope="col"> Title </th>
                  <th scope="col"> Name </th>
                  <th scope="col"> Product</th>
                  <th scope="col"> Mobile</th>
                  <th scope="col"> Remark </th>
                  <th scope="col"> Executive </th>


                  <th scope="col">  </th>
                  
                  
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

                  <td>{{ $record->lead->lead_title }}</td>
                  <td>{{ $record->lead->lead_name }}</td>
                  <td>{{ $record->lead->lead_product }}</td>
                  <td>{{ $record->lead->lead_mobile }}</td>
                  <td>{{$record['followup_remark']}}</td>
                  <td>{{ $record->lead->lead_executive }}</td>
      
  
                  <td><a href="{{('addfollowup/'.$record->lead->id) }}"  class="btn btn-success btn-sm" >Followup</a></td>
                  
        
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


     
      