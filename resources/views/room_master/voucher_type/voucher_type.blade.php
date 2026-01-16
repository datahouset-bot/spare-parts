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
<div class="container-fluid ">
    
  @if (session('message'))
  <div class="alert alert-primary">
    {{ session('message') }}      
</div>
  @else
  @if (session('errer_message'))
  <div class="alert alert-danger">
    {{ session('errer_message') }}      
</div>          
  @endif
  <div></div>

  @endif  



    <div class="card my-3">
        <div class="card-header">
        Voucher Type 
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New Voucher Type
      </button>
          <button class="btn btn-info mx-2">Export</button></div></div>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Voucher Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('voucher_types.store')}}" method="POST">
                            @csrf
                            <div>

                           Voucher Type Name  <input type="text" name ="voucher_type_name"class="form-control" placeholder="Voucher Type Name   ">
                            <span class="text-danger"> 
                              @error('voucher_type_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Starting Number  <input type="text" name ="numbring_start_from"class="form-control" placeholder=" Starting Number">
                            <span class="text-danger"> 
                              @error('numbring_start_from')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>
                            Voucher Prefix  <input type="text" name ="voucher_prefix"class="form-control" placeholder=" Voucher Prefix">
                            <span class="text-danger"> 
                              @error('voucher_prefix')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>    
                          <div>
                            Voucher Suffix  <input type="text" name ="voucher_suffix"class="form-control" placeholder=" Voucher suffix">
                            <span class="text-danger"> 
                              @error('voucher_suffix')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>    
                          <div>
                            Voucher Type  <input type="text" name ="voucher_type"class="form-control" placeholder=" Voucher Type">
                            <span class="text-danger"> 
                              @error('voucher_type')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>    
                          <div>
                            Numbring Style  <select name="voucher_numbring_style" id="voucher_numbring_style" class="form-control">
                              <option value="" selected disabled>Select Numbring Style</option>
                              <option value="voucher_no_continue"  >Continue</option>
                              <option value="voucher_no_daily"  >Daily</option>
                              <option value="voucher_no_manual"  >Manual</option>
                
                
                              </select>
                            <span class="text-danger"> 
                              @error('numbring_style')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>    
                          <div>
                            Voucher Print Name  <input type="text" name ="voucher_print_name"class="form-control" placeholder=" Voucher Print Name">
                            <span class="text-danger"> 
                              @error('voucher_print_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>
                            Voucher Remark  <input type="text" name ="voucher_remark"class="form-control" placeholder=" Voucher Remark">
                            <span class="text-danger"> 
                              @error('voucher_remark')
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
        <div class="card-body table-scrollable ">
            <table class="table table-striped" id="remindtable">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col"> Voucher Type Name    </th>
                    <th scope="col">Voucher type</th>
                    <th scope="col"> Starting Voucher Number  </th>
                    <th scope="col"> Voucher Prefix  </th>
                    <th scope="col"> Voucher Suffix  </th>
                    <th scope="col"> Numbering  Style  </th>
                    <th scope="col"> Voucher Print Name   </th>
                    <th scope="col"> Voucher Remark   </th>
                     <th scope="col"></th>
                    {{-- <th scope="col"></th> --}}
                  </tr>
                </thead>
                <tbody>

                  @php
                    $r1=0;
                  @endphp
                  @foreach ($data as $record)
                    
                  <tr>
           
                    <th scope="row">{{$r1=$r1+1}}</th>
                    <td>{{$record['voucher_type_name']}}</td>
                    <td>{{$record['voucher_af1']}}</td>
                    <td>{{$record['numbring_start_from']}}</td>
                    <td>{{$record['voucher_prefix']}}</td>

                    <td>{{$record['voucher_suffix']}}</td>

                    <td>{{$record['voucher_numbring_style']}}</td>

                    <td>{{$record['voucher_print_name']}}</td>

                    <td>{{$record['voucher_remark']}}</td>



    


                    
                  <td>
                      <a href="{{ route('voucher_types.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    {{-- <td>
                      <form action="{{ route('voucher_types.destroy', $record['id']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this package?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
                      </form>
                  </td> --}}
                  
                  </tr>
                  @endforeach
                  
                  
                </tbody>
              </table>

        </div>
    </div>
</div>

@endsection