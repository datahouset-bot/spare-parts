@php
include(public_path('cdn/cdn.blade.php'));
@endphp


@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')
<div class="container ">

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Edit Item</h3></div>
                                    <div class="card-body">
                                        <form action="{{url('/edititem')}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div> <input type="hidden" value="{{ $data['id'] }}" name="id"></div>

                                            <div class="row mb-3">
                                                <div class="col-md-8">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="item_name" type="text" name="item_name" value="{{ $data['item_name'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('item_name')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="item_name">Item/Product Name</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="item_barcode" type="text" name="item_barcode" value="{{ $data['id'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('item_barcode')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="item_barcode">Barcode No</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                    <select  name ="company_id" id ="company"class="mycompany form-select" aria-label="Default select example">
                                                        <option  value ="" selected disabled>Select Company</option>
                                                      @foreach ($companydata as $record )
                                                        
                                                    
                                                        <option value={{$record['id']}}>{{$record['comp_name']}} </option>
                                                        @endforeach
                                                      </select>
                                                      <span class="text-danger"> 
                                                        @error('company_id')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-2">

                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select  name ="group_id" id ="myitemgroup"class="myitemgroup form-select" aria-label="Default select example">
                                                            <option  value ="" selected disabled>Select group</option>
                                                          @foreach ($itemgroupdata as $record )
                                                            
                                                        
                                                            <option value={{$record['id']}}>{{$record['item_group']}} </option>
                                                            @endforeach
                                                          </select>
                                                          <span class="text-danger"> 
                                                            @error('group_id')
                                                            {{$message}}
                                                                
                                                            @enderror
                                                          </span>
        







                                                </div>

                                                </div>   
                                                <div class="col-md-2 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="mrp" type="text" name="mrp" value="{{ $data['mrp'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('mrp')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="mrp">MRP</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="sale_rate" type="text" name="sale_rate" value="{{ $data['sale_rate'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('sale_rate')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="sale_rate">Sale Rate</label>
                                                       
                                                    </div>

                                                </div>  
                                                <div class="col-md-2 mt-2">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                      <input class="form-control" id="sale_rate_a" type="text" name="sale_rate_a" value="{{ $data['sale_rate_a'] }}"/>
                                                    <span class="text-danger"> 
                                                      @error('sale_rate_a')
                                                      {{$message}}
                                                          
                                                      @enderror
                                                    </span>
                                                      <label for="sale_rate_a">Rate A</label>
                                                     
                                                  </div>

                                              </div>  
                                                <div class="col-md-2 mt-2">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                      <input class="form-control" id="sale_rate_b" type="text" name="sale_rate_b" value="{{ $data['sale_rate_b'] }}" />
                                                    <span class="text-danger"> 
                                                      @error('sale_rate_b')
                                                      {{$message}}
                                                          
                                                      @enderror
                                                    </span>
                                                      <label for="sale_rate_b">Rate B</label>
                                                     
                                                  </div>

                                              </div>  
                                              <div class="col-md-2 mt-2">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="sale_rate_c" type="text" name="sale_rate_c" value="{{ $data['sale_rate_c'] }}" />
                                                  <span class="text-danger"> 
                                                    @error('sale_rate_c')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
                                                    <label for="sale_rate_c">Rate C</label>
                                                   
                                                </div>

                                            </div>  
                                            <div class="col-md-2 mt-2">
                                              <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="purchase_rate" type="text" name="purchase_rate" value="{{ $data['purchase_rate'] }}" />
                                                <span class="text-danger"> 
                                                  @error('purchase_rate')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
                                                  <label for="purchase_rate"> Purchase Rate </label>
                                                 
                                              </div>

                                          </div>  
                                                <div class="col-md-2 mt-2">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                         
                                                          <select name="unit_id" Id ="unit"class="form-select" aria-label="Default select example">
                                                            <option selected disabled>Select Unit </option>
                                                            @foreach ($unit as $unit )
                                                              <option value="{{$unit->id}}">{{$unit->primary_unit_name}}</option>
                                                            @endforeach
                                                            
                                                          </select>
                                                            <label for="unit">Unit  </label>
                                                           
                                                        </div>
                                                        <span class="text-danger"> 
                                                          @error('unit_id')
                                                          {{$message}}
                                                              
                                                          @enderror
                                                        </span>
          
                                                    </div>   
                                                    <div class="col-md-2 mt-2">
                                                      <div class="form-floating mb-3 mb-md-0">
                                                       
                                                        <select name="item_gst_id" Id ="item_gst"class="form-select" aria-label="Default select example">
                                                          <option selected disabled>GST / Tax %  </option>
                                                          @foreach ($gstmaster as $gstmaster )
                                                            <option value="{{$gstmaster->id}}">{{$gstmaster->taxname}}</option>
                                                          @endforeach
                                                          
                                                        </select>
                                                          <label for="GST %">GST /Tax %   </label>
                                                         
                                                      </div>
                                                      <span class="text-danger"> 
                                                        @error('item_gst_id')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
        
                                                  </div>     
        
        








                                                    {{-- <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="unit" type="text" name="unit" value="{{ old('unit') }}" />
                                                      <span class="text-danger"> 
                                                        @error('unit')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="unit">Unit</label>
                                                       
                                                    </div> --}}

                                                </div>    

                                                        
                                            </div>
                                                




                                            
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit"class="btn btn-primary btn-block">Update</button>
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a  class= "btn btn-dark  "href={{url('item')}}>Back</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script>
            $('.myitemgroup').chosen();
            $('.mycompany').chosen();
        </script>
        
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
                <link rel="stylesheet" href="/resources/demos/style.css">
                <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
              
                      <script src="{{ global_asset('/general_assets\js\form.js')}}"></script>
          


@endsection