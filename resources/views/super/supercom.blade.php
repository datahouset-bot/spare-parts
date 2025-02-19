<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    
    
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
    Company List 
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New Company / Hotel / Firm 
      </button>
          </div></div>
        
          <div class="container mt-1">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Company / Firm / </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('super_comp_lists.store')}}" method="POST">
                            @csrf
                            <div>

                            Firm Id   <input type="text" name ="firm_id"class="form-control" placeholder="Firm ID  ">
                            <span class="text-danger"> 
                              @error('firm_id')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                          Firm Name   <input type="text" name ="firm_name"class="form-control" placeholder="Firm Name">
                            <span class="text-danger"> 
                              @error('firm_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            Firm Mobile <input type="text" name ="firm_mobile"class="form-control" placeholder="Other">
                            <span class="text-danger"> 
                              @error('firm_mobile')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            Firm Dealer <input type="text" name ="firm_dealer"class="form-control" placeholder="firm_dealer">
                            <span class="text-danger"> 
                              @error('firm_dealer')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Activation Date  <input type="date" name ="activation_date"class="form-control" placeholder="Activation Date">
                            <span class="text-danger"> 
                              @error('activation_date')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Expiry Date <input type="date" name ="expiry_date"class="form-control" placeholder="Exipry Date">
                            <span class="text-danger"> 
                              @error('expiry_date')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Billing Amount <input type="text" name ="billing_amt"class="form-control" placeholder="Billing Amt">
                            <span class="text-danger"> 
                              @error('billing_amt')
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

           
        {{-- <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myModal').trigger('focus');
            });


        </script> --}}
    



          {{-- data table start  --}}
        <div class="card-body table-scrollable">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Firm Id  </th>
                    <th scope="col"> Firm Name  </th>
                    <th scope="col"> Firm Mobile  </th>
                    <th scope="col"> Firm  Daeler   </th>
                    <th scope="col"> Activation Date   </th>
                    <th scope="col"> Expiery Date  </th>
                    <th scope="col"> Billing Amount  </th>

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
                  @foreach ($data as $record)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td>{{$record['firm_id']}}</td>
                    <td>{{$record['firm_name']}}</td>
                    <td>{{$record['firm_mobile']}}</td>
                    <td>{{$record['firm_dealer']}}</td>
                    <td>{{ \Carbon\Carbon::parse($record['activation_date'])->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($record['expiry_date'])->format('d-m-Y') }}</td>
                    
                    <td>{{$record['billing_amt']}}</td>


                    
                  <td>
                      <a href="{{ route('super_comp_lists.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>
                <td>
                    <a href="{{ url('/seed', $record['firm_id']) }}" class="btn  btn-sm" >Seed</a>
                </td>
                <td>
                  <a href="{{ url('/trandelete', $record['firm_id']) }}" class="btn  btn-sm" >Trandelete</a>
              </td>


                    <td>
                      <form action="{{ route('super_comp_lists.destroy', $record['id']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this Company?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
                      </form>
                  </td>
                  
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