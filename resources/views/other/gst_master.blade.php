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
          GST / VAT / TAX  Master 
        </div>
       <div class="row my-2">
        <div class="col-md-12 text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
          Add New GST / VAT / TAX %
      </button>
          </div></div>
        
          <div class="container mt-5">
            
    
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add GST%</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('gstmasters.store')}}" method="POST">
                            @csrf
                            <div>

                              Tax Name <input type="text" name ="taxname"class="form-control" placeholder="Tax Name ">
                              <span class="text-danger"> 
                                @error('taxname')
                                {{$message}}
                                    
                                @enderror
                              </span>
                            </div>
                            <div>

                            SGST % <input type="text" name ="sgst"class="form-control" placeholder="SGST ">
                            <span class="text-danger"> 
                              @error('sgst')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            CGST %  <input type="text" name ="cgst"class="form-control" placeholder="CSGST">
                            <span class="text-danger"> 
                              @error('cgst')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            IGST %  <input type="text" name ="igst"class="form-control" placeholder="IGST">
                            <span class="text-danger"> 
                              @error('igst')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <hr class="divider">
                          For Other Countery  Who Have Vat Or Other  than  GST
                          <hr>
                          <div>

                            VAT %  <input type="text" name ="vat"class="form-control" placeholder="VAT">
                            <span class="text-danger"> 
                              @error('vat')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX1 %  <input type="text" name ="tax1"class="form-control" placeholder="TAX 1">
                            <span class="text-danger"> 
                              @error('tax1')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX2 %  <input type="text" name ="tax2"class="form-control" placeholder="TAX2">
                            <span class="text-danger"> 
                              @error('tax2')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX3 %  <input type="text" name ="tax3"class="form-control" placeholder="TAX 3">
                            <span class="text-danger"> 
                              @error('tax3')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX4 %  <input type="text" name ="tax4"class="form-control" placeholder="TAX 4">
                            <span class="text-danger"> 
                              @error('tax4')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            TAX5 %  <input type="text" name ="tax5"class="form-control" placeholder="TAX 5">
                            <span class="text-danger"> 
                              @error('tax5')
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
                    <th scope="col"> NAME</th>
                    <th scope="col"> SGST % </th>
                    <th scope="col"> CGST % </th>
                    <th scope="col"> IGST % </th>
                    <th scope="col"> VAT % </th>
                    <th scope="col"> TAX1 % </th>
                    <th scope="col"> TAX2 % </th>
                    <th scope="col"> TAX3 % </th>
                    <th scope="col"> TAX4 % </th>
                    <th scope="col"> TAX5 % </th>
 
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
                    <td>{{$record['taxname']}}</td>
                    <td>{{$record['sgst']}}</td>
                    <td>{{$record['cgst']}}</td>
                    <td>{{$record['igst']}}</td>
                    <td>{{$record['vat']}}</td>
                    <td>{{$record['tax1']}}</td>
                    <td>{{$record['tax2']}}</td>
                    <td>{{$record['tax3']}}</td>
                    <td>{{$record['tax4']}}</td>
                    <td>{{$record['tax5']}}</td>


                    
                  <td>
                      <a href="{{ route('gstmasters.edit', $record['id']) }}" class="btn  btn-sm" ><i class="fa fa-edit" style="font-size:20px;color:SlateBlue"></i></a>
                  </td>


                    <td>
                      <form action="{{ route('gstmasters.destroy', $record['id']) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete this package?')"><i class="fa fa-trash" style="font-size:20px;color:OrangeRed"></i></button>
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