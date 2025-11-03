<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\table.css')}}">

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
    
<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif
<div class="card mt-3">
  <div class="card-header">
 Update Financial Year
  </div>
  <div class="card-body">
    <div class="row justify-content-center align-items-center">
<div class="col-md-6">
  <form action="{{ route('financialyears.update', $record->id) }}" method="POST">
    @csrf
    @method('PUT')
   <input type="hidden" name ="firm_id"class="form-control" value={{Auth::user()->firm_id}} readonly>
                          <div>

                            Finacial Year  <input type="text" name ="financial_year"class="form-control"  value="{{$record->financial_year}}" required>
                            <span class="text-danger"> 
                              @error('financial_year')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                           Financial Year Start <input type="date" name ="financial_year_start"class="form-control"  value="{{$record->financial_year_start}}" required>
                            <span class="text-danger"> 
                              @error('financial_year_start')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                                                    <div>

                           Financial Year End <input type="date" name ="financial_year_end"class="form-control" value="{{$record->financial_year_end}}" required>
                            <span class="text-danger"> 
                              @error('financial_year_end')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  



    <button type="submit" class="btn btn-primary btn-sm my-2">Update </button>
 
  </form>



</div>
    </div>

    
  </div>
</div>










    {{-- <div class="card my-3">
        <div class="card-header">
        Edit Package
        </div>
       <div class="row my-2 mx-4">
       <div class="col-md-6">
        
            
    
            <!-- Modal -->
                        
                          <form action="{{route('packages.store')}}" method="POST">
                            @csrf
                            <div>

                            Package Name  <input type="text" name ="package_name"class="form-control" placeholder="Package ">
                            <span class="text-danger"> 
                              @error('package_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>
                          <div>

                            Plan  <input type="text" name ="plan_name"class="form-control" placeholder="Food Plan">
                            <span class="text-danger"> 
                              @error('plan_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  
                          <div>

                            Other  <input type="text" name ="other_name"class="form-control" placeholder="Other">
                            <span class="text-danger"> 
                              @error('other_name')
                              {{$message}}
                                  
                              @enderror
                            </span>
                          </div>  

                        
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                          </form>
                         
                         --}}

@endsection