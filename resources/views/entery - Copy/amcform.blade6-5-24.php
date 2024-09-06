@php
include(public_path('cdn/cdn.blade.php'));
@endphp

@extends('layouts.blank')
{{-- @include('layouts.blank') --}}
@section('pagecontent')

<div class="card my-3">
  <div class="card-header">
    {{ $compinfofooter->ct2 }}&nbsp; Entery  
  </div>
 <div class="row ">

  
  <div class="container ">

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">{{ $compinfofooter->ct2 }}&nbsp; Entery</h3></div>
                                    <div class="card-body">
                                        <form action="{{url('/amccreat')}}" method="POST">
                                            @csrf
                                            

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        {{-- <input class="form-control" id="amc_start_date" type="date" name="amc_start_date" value="{{  date('Y-m-d') }}?{{ old('amc_start_date') }}" /> --}}
                                                        <input class="form-control" id="amc_start_date" type="date" name="amc_start_date" value="{{ date('Y-m-d') }}" />

                                                        {{-- <input type="date" name="from_date" value="{{ date('Y-m-d', strtotime('-1 year')) }}" class="">

                            <input type="date" name ="to_date"  value="{{  date('Y-m-d') }}"class="">  --}}

                                                      <span class="text-danger"> 
                                                        @error('amc_start_date')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="amc_start_date">Amc Start Date </label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                      <input class="form-control" id="amc_end_date" type="date" name="amc_end_date" value="{{ date('Y-m-d', strtotime('+1 year')) }}" />
                                                    <span class="text-danger"> 
                                                      @error('amc_end_date')
                                                      {{$message}}
                                                          
                                                      @enderror
                                                    </span>
                                                      <label for="account_group">Amc End Date </label>
                                                     
                                                  </div>
                                              </div>
                                              
                                              <div class="col-md-4 mt-2">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="amc_amount" type="text" name="amc_amount" value="{{ old('amc_amount') }}" />
                                                  <span class="text-danger"> 
                                                    @error('amc_amount')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
                                                    <label for="amc_amount">AMC Amount </label>
                                                   
                                                </div>
                                            </div>
                                            
 
                                            <div class="col-md-6 mt-2">

                                                    <div class="form-floating mb-3 mb-md-0">
                                                      <a href="{{url('/accountform')}}" class ="btn btn-success">+New Customer  </a>
                                                        <select  name ="cust_name_id" id ="cust_name"class="mycustomer form-select" aria-label="Default select example">
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

                                                        {{-- <label for="account_group">Customer Name </label> --}}
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                      <a href="{{url('item')}}" class ="btn btn-success">+ New Product </a>
                                                      <select name="amc_product_id" Id ="amc_product_id"class="myitem form-select" aria-label="Default select example">
                                                        <option selected disabled>Select Product</option>
                                                        @foreach ($itemdata as $record)
                                                        <option value={{ $record['id']}}>{{ $record['item_name']}}</option>                                                          
                                                        @endforeach

                                                        

                                                      </select>
                                                        {{-- <label for="op_balnce">Product Name   </label> --}}
                                                       
                                                    </div>
                                                    <span class="text-danger"> 
                                                      @error('amc_product_id')
                                                      {{$message}}
                                                          
                                                      @enderror
                                                    </span>

                                                </div>    

                                                <div class="col-md-4 mt-2">
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
  
                                            
                                              <div class="col-md-4 mt-2">
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


                                            <div class="col-md-4 mt-2">
                                              <div class="form-floating mb-3 mb-md-0">
                                                 
                                                <select name="priority" Id ="priority"class="form-select" aria-label="Default select example">
                                                  <option selected disabled>Select Priority </option>
                                                  
                                                  <option value="Gold">Gold</option>
                                                  <option value="Platinum">Platinum</option>       
                                                  <option value="Silver">Silver</option>             
                                                  <option value="Bronze">Bronze</option>                                                                     
                                               
                                                </select>
                                                  <label for="priority">Priority   </label>
                                                 
                                              </div>
                                              <span class="text-danger"> 
                                                @error('priority')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>

                                          </div>    



                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="remark1" type="text" name="remark1" value="{{ old('remark1') }}" />
                                                      <span class="text-danger"> 
                                                        @error('remark1')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="remark1">Remark1</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="remark2" type="text" name="remark2" value="{{ old('remark2') }}" />
                                                      <span class="text-danger"> 
                                                        @error('remark2')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="remark2">Remark2 </label>
                                                       
                                                    </div>

                                                </div>  
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="executive" type="text" name="executive" value="{{ old('executive') }}" />
                                                      <span class="text-danger"> 
                                                        @error('executive')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="executive">Executive</label>
                                                       
                                                    </div>

                                                </div>    
                                               </div>
                                                
                                                
                                                        
                                            </div>
                                                




                                            
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit"class="btn btn-primary btn-block">Save</button>
                                                    </div>
                                            </div>
                                        </form>
                                    
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a  class= "btn btn-dark  "href={{url('amclist')}}>Back</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
                  </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>

  <div class="card-body">
     
</div>
{{-- <select id ="myitem"class="myno" aria-label="Default select example">
  <option selected>Open this select menu</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
  <option value="4">four</option>
  <option value="5">five</option>
</select> --}}

<script>
  $('.myitem').chosen();
  $('.mycustomer').chosen();
</script>

@endsection
