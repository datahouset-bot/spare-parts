

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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


        

<style>
  .table-scrollable {
    /* border-style: solid;
    border-color: blue; */

    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Enables momentum scrolling in iOS Safari */
  }

  .highlight {
  background-color: lightyellow;
}

</style>
 <div class="container">
  
  @if(session('message'))
    <div class="alert alert-primary my-3">
        {{ session('message') }}
    </div>
  @endif


      <div class="card my-3" style="width: 100%;">
        <h5 class="card-title">To do / Reminder / Task </h5>
        {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
        
        <form action="{{url('/todolist')}}"   method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
        <div class="row">
            <div class="col-md-2 my-2">
              
            <input type="text" class="form-control" id="datepicker" name="reminder_date_given" placeholder="Reminder Date "  value=""> 
            <span class="text-danger"> 
              @error('reminder_date_given')
              {{$message}}
                  
              @enderror
            </span>  



            </div>
            <div class="col-md-2 my-2">
              <input type="text" class="form-control" name="reminder_title" placeholder="Title">
              <span class="text-danger"> 
                @error('reminder_title')
                {{$message}}
                    
                @enderror
              </span>
            </div>
            <div class="col-md-3 my-2">
              <input type="text" class="form-control" name="reminder_name" placeholder="Name"> 
              <span class="text-danger"> 
                @error('reminder_name')
                {{$message}}
                    
                @enderror
              </span>
            </div>
            <div class="col-md-3 my-2">
              <input type="text" class="form-control" name="reminder_mobile" placeholder="Mobile No "> 
              <span class="text-danger"> 
                @error('reminder_mobile')
                {{$message}}
                    
                @enderror
              </span>
            </div>
            <div class="col-md-2 my-2">
              <input type="text" class="form-control" name="reminder_city" placeholder="City"> 
            </div>
         </div>
         <div class="row my-3 my-2">
          <div class="col-md-10">
            <input type="text" class="form-control" name="reminder_disc" placeholder="Discription ">
            <span class="text-danger"> 
              @error('reminder_disc')
              {{$message}}
                  
              @enderror
            </span>  
          </div>
          <div class="col-md-2 my-2">
            <button type="submit"class="btn btn-primary btn-block">Save</button>
          </div>
         </div>
        </form>


          </div>


        </div>
      </div>
    </div>

    <div class="row" class="text-center">
      <div class="col-md-12 text-center">
        <a href="{{url('/todolist')}}" class ="btn btn-danger my-2 mx-2">  Pending To-Dos </a>
        <a href="{{url('/tododonelist')}}" class ="btn btn-success my-2 mx-2">  Completed To-Dos </a>
        <a href="{{url('/todolist_dt')}}" class ="btn btn-danger my-2 mx-2">  Data Table   </a>
        <a href="{{url('todo_import_show')}}" class ="btn btn-danger my-2 mx-2">  Import  </a>
        
        <a href="{{url('/todolist')}}" class ="btn btn-danger my-2 mx-2">  Mail  </a>
      
      </div>
      
    </div>



          {{-- data table start  --}}
        <div class="card-body table-scrollable">

            <table class=" table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Date </th>
                    <th scope="col"> Title </th>
                    <th scope="col"> Name </th>
                    <th scope="col"> Mobile </th>
                    <th scope="col"> City</th>
                    <th scope="col"> Discription</th>
                    <th scope="col"> Done</th>
                    <th scope="col"></th>
                    
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                 @foreach ($data as $record)
                    
                  <tr>
                   
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td scope="col">{{ \Carbon\Carbon::parse($record['reminder_date'])->format('d-m-y') }}</td>
                    {{-- <td>{{$record['reminder_date']}}</td> --}}
                    <td>{{$record['reminder_title']}}</td>
                    <td>{{$record['reminder_name']}}</td>
                    <td>{{$record['reminder_mobile']}}</td>
                    <td>{{$record['reminder_city']}}</td>
                    <td>{{$record['reminder_disc']}}</td>

                    <form action="{{url('/tododone')}}"   method="POST">
                      @method('PUT')
                      @csrf      
                    <td><div class="form-check">
                      <input type="hidden" name ='id' value="{{$record['id']}}" >
                      <input class="form-check-input" type="checkbox" name ="reminder_af1" value="1" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">
                       
                      </label>
                    </div></td>

                    <td><button type="submit"class="btn btn-primary btn-sm ">Done</button></td>

                  </form>

                    <td><a href="{{('showtodo/'.$record['id']) }}"  class="btn btn-primary btn-sm" >Edit</a></td>

                    <td><a href="{{('deletetodo/'.$record['id']) }}"  class="btn btn-danger btn-sm">Delete</a></td>
                  </tr>
                  @endforeach
                   
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection