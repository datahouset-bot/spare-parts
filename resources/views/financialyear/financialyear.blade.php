<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <style>
      .active1{
        background-color: yellowgreen !important;
        font-weight: 800px !important;
        font-size: large !important;
        color: darkblue !important; 
      }
    </style>
    
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
       Financial Year
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Financial Year
      </button>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Financial Year</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('financialyears.store')}}" method="POST">
                            @csrf


                           <input type="hidden" name ="firm_id"class="form-control" value={{Auth::user()->firm_id}} readonly>
                          <div>

                            Finacial Year  <input type="text" name ="financial_year"class="form-control" placeholder="Finacial Year Name Like 2024-2025 " required>
                            <span class="text-danger"> 
                              @error('financial_year')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                           Financial Year Start <input type="date" name ="financial_year_start"class="form-control" placeholder="Start Date" required>
                            <span class="text-danger"> 
                              @error('financial_year_start')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                                                    <div>

                           Financial Year End <input type="date" name ="financial_year_end"class="form-control" placeholder="End Date" required>
                            <span class="text-danger"> 
                              @error('financial_year_end')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  



                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                          </form>
                         
                          </div>
                    </div>
                </div>
            </div>
        </div>

           
        <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myModal').trigger('focus');
            });


        </script>
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Finnancial Year   </th>
                    <th scope="col"> Start Date</th>
                    <th scope="col">End Date  </th>
                    <th scope="col">Is Active   </th>
                    <th scope="col"> </th>
                    <th scope="col">Change  Active Finacial Year    </th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($data as $record)
                    
         <tr class=" {{ 'active' . $record->is_active_fy }}">

           
                    <th scope="row" >{{$r1=$r1+1}}</th>
                    <td>{{$record->financial_year}}</td>
                    <td>{{$record->financial_year_start}}</td>
                    <td>{{$record->financial_year_end}}</td>
                   <td>{{$record->is_active_fy}}</td>


                    
                  <td>
                      <a href="{{ route('financialyears.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>
                   <td>
                      <a href="{{ route('financialyears.show', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-calendar" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('financialyears.destroy', $record['id']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this Financial Year?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
                      </form>
                  </td>
                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection