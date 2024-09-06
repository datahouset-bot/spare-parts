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
        Other Charge 
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New Charge
      </button>
          </div></div>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Charge</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('othercharges.store')}}" method="POST">
                            @csrf
                            <div>

                            Charge Head Name  <input type="text" name ="charge_name"class="form-control" placeholder="Charge Name   ">
                            <span class="text-danger"> 
                              @error('charge_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                         <div> 
                          Charg Type <select name="charge_type" id="" class="form-control">
                            <option value="" selected disabled> Select Charg Type</option>
                            <option value="+">+</option>
                         <option value="-">-</option>
                         <option value="NULL">No Effect</option>

                          </select> 
                            <span class="text-danger"> 
                              @error('charge_type')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div> 
                            Input Type <select name="input_type" id="" class="form-control">
                              <option value="" selected disabled> Select Input type</option>
                              <option value="%">%</option>
                           <option value="amount">Amount</option>

  
                           </select> 
                              <span class="text-danger"> 
                                @error('input_type')
                                {{$message}}
                                    
                                @enderror
                              </span>
                            </div>  
                          <div> 
                            Aplicable On  <select name="applicable_on" id="" class="form-control">
                              <option value="" selected disabled> Select Aplicable </option>
                              <option value="net">Net Value</option>
                              <option value="base">Base Value</option>
                              <option value="per_day">Per Day </option>
                              <option value="per_person">Per Person </option>
                              <option value="per_hour">Per Hour </option>
                              <option value="absolute">Absolute Amount </option>
                               
                            </select> 
                              <span class="text-danger"> 
                                @error('applicable_on')
                                {{$message}}
                                    
                                @enderror
                              </span>
                            </div>  
                            <div> 
                             Posting Account  <select name="charge_posting_account" id="" class="form-control">
                                <option value="" selected disabled> Select Account To Post   </option>
                                @foreach ($account as $account)
                               <option value="{{$account->id}}">{{$account->account_name}}</option>                  
                                  
                                @endforeach

                                 
                              </select> 
                                <span class="text-danger"> 
                                  @error('charge_posting_account')
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
                    <th scope="col"> Charge Name  </th>
                    <th scope="col"> Charge Type </th>
                    <th scope="col"> Input Type </th>
                    <th scope="col">Applicable On  </th>
                    <th scope="col"> Postin Account </th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($othercharge as $record2)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td>{{$record2->charge_name}}</td>
                    <td>{{$record2->charge_type}}</td>
                    <td>{{$record2->input_type}}</td>
                    <td>{{$record2->applicable_on}}</td>
                    <td>{{$record2->account->account_name}}</td>



                    
                  <td>
                      <a href="{{ route('othercharges.edit', $record2['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('othercharges.destroy', $record2['id']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this roomtype?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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