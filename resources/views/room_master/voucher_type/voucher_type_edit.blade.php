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
 Voucher Type Edit  
  </div>
  <div class="card-body">
    <div class="row justify-content-center align-items-center">
<div class="col-md-6">
  <form action="{{ route('voucher_types.update', $voucher_type->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>

      Voucher Type Name  <input type="text" name ="voucher_type_name"class="form-control" value="{{ old('voucher_type_name', $voucher_type->voucher_type_name) }} " readonly >
       <span class="text-danger"> 
         @error('voucher_type_name')
         {{$message}}
             
         @enderror
       </span>
     </div>
     <div>

       Starting Number  <input type="text" name ="numbring_start_from"class="form-control" value="{{ old('numbring_start_from', $voucher_type->numbring_start_from) }}">
       <span class="text-danger"> 
         @error('numbring_start_from')
         {{$message}}
             
         @enderror
       </span>
     </div>
     <div>
       Voucher Prefix  <input type="text" name ="voucher_prefix"class="form-control" value="{{ old('voucher_prefix', $voucher_type->voucher_prefix) }}">
       <span class="text-danger"> 
         @error('voucher_prefix')
         {{$message}}
             
         @enderror
       </span>
     </div>    
     <div>
       Voucher Suffix  <input type="text" name ="voucher_suffix"class="form-control"  value="{{ old('voucher_suffix', $voucher_type->voucher_suffix) }}">
       <span class="text-danger"> 
         @error('voucher_suffix')
         {{$message}}
             
         @enderror
       </span>
     </div>
     <div>
      Numbring Style
      <select name="voucher_numbring_style" id="voucher_numbring_style" class="form-control">
          <option value="" selected disabled>Select Numbring Style</option>
          <option value="voucher_no_continue" {{ old('voucher_numbring_style', $voucher_type->voucher_numbring_style) == 'voucher_no_continue' ? 'selected' : '' }}>Continue</option>
          <option value="voucher_no_daily" {{ old('voucher_numbring_style', $voucher_type->voucher_numbring_style) == 'voucher_no_daily' ? 'selected' : '' }}>Daily</option>
          <option value="voucher_no_manual" {{ old('voucher_numbring_style', $voucher_type->voucher_numbring_style) == 'voucher_no_manual' ? 'selected' : '' }}>Manual</option>
      </select>
      <span class="text-danger">
          @error('voucher_numbring_style')
              {{ $message }}
          @enderror
      </span>
  </div>
      
     <div>
       Voucher Print Name  <input type="text" name ="voucher_print_name"class="form-control" value="{{ old('voucher_print_name', $voucher_type->voucher_print_name) }}">
       <span class="text-danger"> 
         @error('voucher_print_name')
         {{$message}}
             
         @enderror
       </span>
     </div>  
     <div>
       Voucher Remark  <input type="text" name ="voucher_remark"class="form-control" value="{{ old('voucher_remark', $voucher_type->voucher_remark) }}">
       <span class="text-danger"> 
         @error('voucher_remark')
         {{$message}}
             
         @enderror
       </span>
     </div> 




    <div>


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

                            Plan  <input type="text" name ="buiness_source_remark"class="form-control" placeholder="Food Plan">
                            <span class="text-danger"> 
                              @error('buiness_source_remark')
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