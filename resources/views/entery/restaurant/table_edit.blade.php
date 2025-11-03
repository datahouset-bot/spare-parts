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
  <form action="{{ route('tables.update', $table->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>

    Table Name  <input type="text" name ="table_name"class="form-control" placeholder="table " value="{{ old('table_name', $table->table_name) }}">
    <span class="text-danger"> 
      @error('table_name')
      {{$message}}
          
      @enderror
    </span>
  </div>

                     <div>
                            Select Table Group

<select name="table_group" id="table_group" class="form-select">
 
<option value="Null" {{ old('table_group', $table->table_group) === null ? 'selected' : '' }}>General</option>


  <option value="Nc" {{ old('table_group', $table->table_group) == 'Nc' ? 'selected' : '' }}>NC</option>
  <option value="TakeAway" {{ old('table_group', $table->table_group) == 'TakeAway' ? 'selected' : '' }}>Take Away</option>
  <option value="SelfService" {{ old('table_group', $table->table_group) == 'SelfService' ? 'selected' : '' }}>Self Service</option>
</select>


                            <span class="text-danger"> 
                              @error('table_group')
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