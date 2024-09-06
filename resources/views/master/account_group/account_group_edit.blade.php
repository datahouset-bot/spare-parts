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
 Update Unit 
  </div>
  <div class="card-body">
    <div class="row justify-content-center align-items-center">
<div class="col-md-6">
  <form action="{{ route('accountgroups.update', $accountgroup->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>

      Account Group Name   <input type="text" name ="account_group_name"class="form-control" value="{{$accountgroup->account_group_name}}">
      <span class="text-danger"> 
        @error('account_group_name')
        {{$message}}
            
        @enderror
      </span>
     
  </div>
  <div>

    Primary Group Name  <select name="primary_group_id" class="form-control">
      <option value="" selected disabled>Select Primary Group </option>
      @foreach ($primarygroups as $primarygroup )
      <option value="{{$primarygroup->id}}">{{$primarygroup->primary_group_name}}</option>
        
      @endforeach

    </select>
  </div>  
  <div>

  </div>  

    <button type="submit" class="btn btn-primary btn-sm my-2">Update </button>
 
  </form>



</div>
    </div>

    
  </div>
</div>










    {{-- <div class="card my-3">
        <div class="card-header">
        Edit unit
        </div>
       <div class="row my-2 mx-4">
       <div class="col-md-6">
        
            
    
            <!-- Modal -->
                        
                          <form action="{{route('units.store')}}" method="POST">
                            @csrf
                            <div>

                            unit Name  <input type="text" name ="unit_name"class="form-control" placeholder="unit ">
                            <span class="text-danger"> 
                              @error('unit_name')
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