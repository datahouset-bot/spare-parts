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
 Update GST / TAX
  </div>
  <div class="card-body">
    <div class="row justify-content-center align-items-center">
<div class="col-md-6">
  <form action="{{ route('gstmasters.update', $gstmaster->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>

    Tax Name <input type="text" name ="taxname"class="form-control" placeholder="Package " value="{{ old('taxname', $gstmaster->taxname) }}">
    <span class="text-danger"> 
      @error('package_name')
      {{$message}}
          
      @enderror
    </span>
  </div>
  <div>

    HSN No <input type="text" name ="hsn_no"class="form-control" placeholder="hsn " value="{{ old('hsn_no', $gstmaster->hsn_no) }}">
    <span class="text-danger"> 
      @error('hsn_no')
      {{$message}}
          
      @enderror
    </span>
  </div>
  <div>

    SGST %  <input type="text" name ="sgst"class="form-control" value="{{ old('sgst', $gstmaster->sgst) }}">
    <span class="text-danger"> 
      @error('sgst')
      {{$message}}
          
      @enderror
    </span>
  </div>  

  <div>

    CGST %  <input type="text" name ="cgst"class="form-control" value="{{ old('cgst', $gstmaster->cgst) }}">
    <span class="text-danger"> 
      @error('cgst')
      {{$message}}
          
      @enderror
    </span>
  </div>  
  <div>

    IGST %  <input type="text" name ="igst"class="form-control" value="{{ old('igst', $gstmaster->igst) }}">
    <span class="text-danger"> 
      @error('igst')
      {{$message}}
          
      @enderror
    </span>
  </div>  
  <div>

    VAT %  <input type="text" name ="vat"class="form-control" value="{{ old('vat', $gstmaster->vat) }}">
    <span class="text-danger"> 
      @error('vat')
      {{$message}}
          
      @enderror
    </span>
  </div>  
  <div>

    TAX1 %  <input type="text" name ="tax1"class="form-control" value="{{ old('tax1', $gstmaster->tax1) }}">
    <span class="text-danger"> 
      @error('tax1')
      {{$message}}
          
      @enderror
    </span>
  </div>  
  <div>

    TAX2 %  <input type="text" name ="tax2"class="form-control" value="{{ old('tax2', $gstmaster->tax2) }}">
    <span class="text-danger"> 
      @error('tax2')
      {{$message}}
          
      @enderror
    </span>
  </div>  
  <div>

    TAX3 %  <input type="text" name ="tax3"class="form-control" value="{{ old('tax3', $gstmaster->tax3) }}">
    <span class="text-danger"> 
      @error('tax3')
      {{$message}}
          
      @enderror
    </span>
  </div>  
  <div>

    TAX4 % <input type="text" name ="tax4"class="form-control" value="{{ old('tax4', $gstmaster->tax4) }}">
    <span class="text-danger"> 
      @error('tax4')
      {{$message}}
          
      @enderror
    </span>
  </div>  
  <div>

    TAX5 %  <input type="text" name ="tax5"class="form-control" value="{{ old('tax5', $gstmaster->tax5) }}">
    <span class="text-danger"> 
      @error('tax5')
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