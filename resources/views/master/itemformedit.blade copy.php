
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

                                                <div class="col-md-6 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="company" type="text" name="company" value="{{ $data['company'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('company')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="company">Comapny</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="group" type="text" name="group" value="{{ $data['group'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('group')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="group">Group</label>
                                                       
                                                    </div>

                                                </div>    



                                                <div class="col-md-4 mt-2">
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
                                                <div class="col-md-4 mt-2">
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
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="unit" type="text" name="unit" value="{{ $data['unit'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('unit')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="unit">Unit</label>
                                                       
                                                    </div>

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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
   




    <div class="card my-3">
        <div class="card-header">
         Item List 
        </div>
       <div class="row ">
         
        <div class="card-body">
           
    </div>
</div>

@endsection