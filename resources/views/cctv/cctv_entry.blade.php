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


    <style>
      /* ===== PDF style section heading ===== */
.section-heading {
    background: #000;
    color: #fff;
    text-align: center;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 10px 0;
    margin: 25px 0 15px 0;
    font-size: 16px;
    text-transform: uppercase;
}

    </style>


<div class="card my-1 ">
 <div class="row ">

  
  <div class="container ">

    <body class="bg-primary">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card  mt-1">
                                    <div class="card-header"><h5 class="text-center font-weight-light my-1">New Visit Entry </h5></div>
                                    <div class="card-body">
                                <form action="{{ route('cctv.store') }}" method="POST">
                                              @csrf
                                     
<div class="section-heading">
    Customer Service Report
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif


                                            <div class="row mb-3">
                                              <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="CSR" name="csr" type="text" />
                                                    <label for="csr">CSR</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control date" id="date" type="text" name="date" value="{{ date('Y-m-d') }}" />
                                                    <label for="date"> Date</label>
                                                </div>
                                              </div>

                                               <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                         <input class="form-control" id="cust_name" type="text" name="cust_name" />
                                                <label for="priority">Customer Name</label>                                              
                                            </div>
                                        </div>

                                     
                                    <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="address" type="text" name="address" />
                                                <label for="priority">ADDRESS </label>                                              
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="city" type="text" name="city" />
                                                <label for="priority">City</label>                                              
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="state" type="text" name="state" />
                                                <label for="priority">State</label>                                              
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" name="product" type="text" />
                                                <label for="priority">Product</label>                                              
                                            </div>
                                        </div>
                                      
                                      
                                        <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                 
                                                  <select name="status" Id ="status"class="form-select" aria-label="Default select example">
                                                    <option selected disabled>Select Status </option>
                                                    
                                                    <option value="Warranty">Warranty</option>
                                                    <option value="AMC">AMC</option>       
                                                    {{-- <option value="Unknown">Unknown </option>              --}}
                                                    
                                                  </select>
                                                    <label for="status">Status of Call  </label>
                                                   
                                                </div>
                                            </div>    

                                            <div class="section-heading">
                                            Nature of Problem
                                            </div>

                                    
                                    <div class="col-md-4 mt-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                          <input class="form-control" id="problem" type="text" name="problem" value="{{ old('problem') }}" />
                                            <label for="priority">Problem Reported</label>
                                        </div>
                                    </div>    
                                                <div class="col-md-4 mt-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                    <select name="system" Id ="system"class="form-select" aria-label="Default select example">
                                                      <option selected disabled>Select System Down</option>
                                                      <option value="Yes">Yes</option>
                                                      <option value="No">NO</option>       
                                                    </select>
                                                      <label for="system">System status </label>
                                                    
                                                  </div>
                                              </div>    
  
                                            
                                            
                                             <div class="col-md-4 mt-4">
    <div class="form-floating mb-3 mb-md-0">
        <input class="form-control" id="equipment_type" type="text" name="equipment_type" />
        <label>Equipment Type</label>
    </div>
</div>

                                            <div class="col-md-4 mt-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                          <input class="form-control" id="Make" type="text" name="make" />
                                            <label for="priority">Make</label>
                                        </div>
                                    </div>    

                                          <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="serial_no" type="text" name="serial_no"  />
                                                <label for="priority">Serial no </label>
                                               
                                            </div>

                                        </div>
                                        
 

                                        <div class="col-md-4 mt-4">
                                          <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="reported" type="text" name="reported"/>
                                              <label for="priority">Call Reported by </label>
                                          </div>
                                      </div>
                                      
                                      <div class="col-md-4 mt-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                          <input class="form-control" id="location" type="text" name="location"  />
                                            <label for="priority">Location of installation </label>
                                        </div>
                                    </div>

                                      <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="sDate" type="date" name="sDate" />
                                                <label for="priority">Date</label>                                              
                                            </div>
                                        </div>

                                      <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="time" type="time" name="time" />
                                                <label for="priority">TIME</label>                                              
                                            </div>
                                        </div>

                                        <div class="section-heading">
                                        Service Details
                                        </div>
                                        <div class="col-md-12 mt-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                          <input class="form-control" id="rendered" type="text" name="rendered" value="{{ old('rendered') }}" />
                                            <label for="priority">Service rendered </label>
                                           
                                        </div>
                                        <span class="text-danger"> 
                                          @error('rendered')
                                          {{$message}}
                                              
                                          @enderror
                                        </span>

                                    </div>

  
                                        {{-- <div class="col-md-4 mt-4">
                                          <div class="form-floating mb-3 mb-md-0">
                                            <input type="text" class="form-control" name="executive" readonly value =  "{{ Auth::user()->name }}" > 

                                            <span class="text-danger"> 
                                              @error('executive')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>
                                              <label for="executive">Executive Name</label>
                                             
                                          </div>
                                      </div> --}}
                                                                                            
                                    <div class="card-footer text-center my-4">
                                      <div class="small">
                                        <button type="submit"class="btn btn-primary btn-block">Save</button>
                                        <a  class= "btn btn-dark  "href={{url('amclist')}}>Back</a></div>
                                  </div>





                                </form>

                  </div>
        </div>
      </div>

@endsection
