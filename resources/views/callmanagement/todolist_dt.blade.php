<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
 
 
 

        

 <div class="container">
  
 

      <div class="card my-3" style="width: 100%;">
        <h5 class="card-title">To do / Reminder / Task </h5>
        
        {{-- <form action="{{url('/todolist')}}"   method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
        <div class="row">
            <div class="col-md-2">
              
            <input type="text" class="form-control" id="datepicker" name="reminder_date_given" placeholder="Reminder Date "  value=""> 
            <span class="text-danger"> 
              @error('reminder_date_given')
              {{$message}}
                  
              @enderror
            </span>  



            </div>
            <div class="col-md-2">
              <input type="text" class="form-control" name="reminder_title" placeholder="Title">
              <span class="text-danger"> 
                @error('reminder_title')
                {{$message}}
                    
                @enderror
              </span>
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control" name="reminder_name" placeholder="Name"> 
              <span class="text-danger"> 
                @error('reminder_name')
                {{$message}}
                    
                @enderror
              </span>
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control" name="reminder_mobile" placeholder="Mobile No "> 
            </div>
            <div class="col-md-2">
              <input type="text" class="form-control" name="reminder_city" placeholder="City"> 
            </div>
         </div>
         <div class="row my-3">
          <div class="col-md-10">
            <input type="text" class="form-control" name="reminder_disc" placeholder="Discription ">
            <span class="text-danger"> 
              @error('reminder_disc')
              {{$message}}
                  
              @enderror
            </span>  
          </div>
          <div class="col-md-2">
            <button type="submit"class="btn btn-primary btn-block">Save</button>
          </div>
         </div>
        </form> --}}


    <div class="row" class="text-center">
      <div class="col-md-12 text-center">
        <a href="{{url('/todolist')}}" class ="btn btn-danger">  Pending To-Dos </a>
        <a href="{{url('/tododonelist')}}" class ="btn btn-success">  Completed To-Dos </a>
        
        <a href="{{url('/todolist')}}" class ="btn btn-danger">  Import  </a>
        
        <a href="{{url('/todolist')}}" class ="btn btn-danger">  Mail  </a>
      
      </div>
      
    </div>



          {{-- data table start  --}}
        <div class="card-body">

            <table class="table table-striped" id="remindtable">
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



@endsection