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
 Update Package 
  </div>
  <div class="card-body">
    <div class="row justify-content-center align-items-center">
<div class="col-md-6">
  <form action="{{ route('packages.update', $package->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>

    Package Name  <input type="text" name ="package_name"class="form-control" placeholder="Package " value="{{ old('package_name', $package->package_name) }}">
    <span class="text-danger"> 
      @error('package_name')
      {{$message}}
          
      @enderror
    </span>
  </div>
  <div>

    Plan  <input type="text" name ="plan_name"class="form-control" value="{{ old('plan_name', $package->plan_name) }}">
    <span class="text-danger"> 
      @error('plan_name')
      {{$message}}
          
      @enderror
    </span>
  </div>  
  <div>

    Other  <input type="text"  value="{{ old('other_name', $package->other_name) }}" name ="other_name"class="form-control" placeholder="Other">
    <span class="text-danger"> 
      @error('other_name')
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