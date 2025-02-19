@php
include(public_path('cdn/cdn.blade.php'));
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}">

@extends('layouts.blank')
@section('pagecontent')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="jquery/master.js"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
<div class="card my-1 ">
 <div class="row ">

  
  <div class="container ">

    <body class="bg-primary">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card  mt-1">
                                    <div class="card-header"><h5 class="text-center font-weight-light my-1">New AMC Entery </h5></div>
                                    <div class="card-body">
                                   




                                            <form action="{{url('/amccreat')}}" method="POST">
                                              @csrf
                                     

                                            <div class="row mb-3">
                                              <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control date" id="amc_start_date" type="text" name="amc_start_date" value="{{ date('Y-m-d') }}" />
                                                    <span class="text-danger">
                                                        @error('amc_start_date')
                                                        {{$message}}
                                                        @enderror
                                                    </span>
                                                    <label for="amc_start_date">Amc Start Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control date" id="amc_end_date" type="text" name="amc_end_date" value="{{ date('Y-m-d') }}" />
                                                    <span class="text-danger">
                                                        @error('amc_end_date')
                                                        {{$message}}
                                                        @enderror
                                                    </span>
                                                    <label for="amc_end_date">Amc End Date</label>
                                                </div>
                                              </div>
                                        <div class="col-md-3 mt-4">
                                                                                    <label for="cust_name_id">Select Account   </label>
                                          <div class="form-floating mb-3 mb-md-0">

                                             
                                            <select  name ="cust_name_id" id ="account_id"class="mycustomer form-select" aria-label="Default select example">
                                              <option  value ="" selected disabled>Select Customer</option>
                                            @foreach ($accountdata as $record )
                                              
                                          
                                              <option value={{$record['id']}}>{{$record['account_name']}} </option>
                                              @endforeach
                                            </select>
                                            <span class="text-danger"> 
                                              @error('cust_name_id')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>

                                             
                                          </div>
                                          <span class="text-danger"> 
                                            @error('room_no')
                                            {{$message}}
                                                
                                            @enderror
                                          </span>
                                        

                                      </div><div class="col-md-4 mt-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                           
                                          <select name="amc_product_id" Id ="amc_product_id"class="form-select" aria-label="Default select example">
                                            <option selected disabled>Select Product </option>
                                            @foreach ($itemdata as $record)
                                            <option value={{ $record['id']}}>{{ $record['item_name']}}</option>                                                          
                                            @endforeach

              
                                          </select>
                                            <label for="amc_product_id">Product   </label>
                                           
                                        </div>
                                        <span class="text-danger"> 
                                          @error('amc_product_id')
                                          {{$message}}
                                              
                                          @enderror
                                        </span>

                                    </div>      
                                           
                                                <div class="col-md-4 mt-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                   
                                                    <select name="amc_status" Id ="amc_status"class="form-select" aria-label="Default select example">
                                                      <option selected disabled>Select AMC Status </option>
                                                      
                                                      <option value="Active">Active</option>
                                                      <option value="Inactive">Inactive</option>       
                                                      <option value="Unknown">Unknown </option>             
                                                      
                                                    </select>
                                                      <label for="amc_status">AMC Status   </label>
                                                    
                                                  </div>
                                                  <span class="text-danger"> 
                                                    @error('amc_status')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
    
                                              </div>    
  
                                            
                                              <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                 
                                                  <select name="payment_status" Id ="payment_status"class="form-select" aria-label="Default select example">
                                                    <option selected disabled>Select Status </option>
                                                    
                                                    <option value="Paid">Paid</option>
                                                    <option value="Unpaid">Unpaid</option>       
                                                    <option value="Unknown">Unknown </option>             
                                                    
                                                  </select>
                                                    <label for="payment_status">Payment Status  </label>
                                                   
                                                </div>
                                                <span class="text-danger"> 
                                                  @error('payment_status')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
  
                                            </div>    
                                                                                    
                                            <div class="col-md-4 mt-4">
                                              <div class="form-floating mb-3 mb-md-0">
                                               
                                                <select name="priority" Id ="priority"class="form-select" aria-label="Default select example">
                                                  <option selected disabled>Select Priority </option>
                                                  
                                                  <option value="Gold">Gold</option>
                                                  <option value="Platinum">Platinum</option>       
                                                  <option value="Silver">Silver</option>             
                                                  <option value="Bronze">Bronze</option>                                                                     
                                               
                                                </select>
                                             
                                                  <label for="priority">Priority  </label>
                                                 
                                              </div>
                                              <span class="text-danger"> 
                                                @error('priority')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>

                                          </div>     

                                          <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="amc_amount" type="text" name="amc_amount" value="{{ old('amc_amount') }}" />
                                                <label for="priority">AMC Amount  </label>
                                               
                                            </div>
                                            <span class="text-danger"> 
                                              @error('amc_amount')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>

                                        </div>
                                        
 

                                        <div class="col-md-4 mt-4">
                                          <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="remark1" type="text" name="remark1" value="{{ old('remark1') }}" />
                                              <label for="priority">Product Remark </label>
                                             
                                          </div>
                                          <span class="text-danger"> 
                                            @error('remark1')
                                            {{$message}}
                                                
                                            @enderror
                                          </span>

                                      </div>
                                      
                                      <div class="col-md-4 mt-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                          <input class="form-control" id="remark2" type="text" name="remark2" value="{{ old('remark2') }}" />
                                            <label for="priority">Remark2  </label>
                                           
                                        </div>
                                        <span class="text-danger"> 
                                          @error('remark2')
                                          {{$message}}
                                              
                                          @enderror
                                        </span>

                                    </div>

  
                                        <div class="col-md-4 mt-4">
                                          <div class="form-floating mb-3 mb-md-0">
                                            <input type="text" class="form-control" name="executive" readonly value =  "{{ Auth::user()->name }}" > 

                                            <span class="text-danger"> 
                                              @error('executive')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>
                                              <label for="executive">Executive Name</label>
                                             
                                          </div>
                                      </div>
                                                                                            
                                    <div class="card-footer text-center my-4">
                                      <div class="small">
                                        <button type="submit"class="btn btn-primary btn-block">Save</button>
                                        <a  class= "btn btn-dark  "href={{url('amclist')}}>Back</a></div>
                                  </div>





                                </form>

                  </div>
        </div>
      </div> 
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#account_id").select2({
            placeholder: "Select Account",
            allowClear: true
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>

@endsection
