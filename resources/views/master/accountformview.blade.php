
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">View Accout</h3></div>
                                    <div class="card-body">
                                        <form action="" method="">
                                           <div> <input type="hidden" value="{{ $data['id'] }}" name="id"></div>

                                            <div class="row mb-3">
                                                <div class="col-md-8">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="account_name" type="text" name="account_name" value="{{ $data['account_name'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('account_name')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="account_name">Account Name </label>
                                                       
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="account_group" type="text" name="account_group" value="{{ $data['account_group'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('account_group')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="account_group">Account Group</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="op_balnce" type="text" name="op_balnce" value="{{ $data['op_balnce'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('op_balnce')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="op_balnce">Opning Balance </label>
                                                       
                                                    </div>

                                                </div>    



                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="balnce_type" type="text" name="balnce_type" value="{{ $data['balnce_type'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('balnce_type')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="balnce_type">Balance_Type</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="address" type="text" name="address" value="{{ $data['address'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('address')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="address">Address</label>
                                                       
                                                    </div>

                                                </div>  
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="city" type="text" name="city" value="{{ $data['city'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('city')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="city">City</label>
                                                       
                                                    </div>

                                                </div>    
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="phone" type="text" name="phone" value="{{ $data['phone'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('phone')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="phone">Phone</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="mobile" type="text" name="mobile" value="{{ $data['mobile'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('mobile')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="mobile">Mobile</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="emial" type="text" name="emial" value="{{ $data['email'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('email')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="email">Email</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="person_name" type="text" name="person_name" value="{{ $data['person_name'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('person_name')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="person_name">Contact Person Name </label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="gst_no" type="text" name="gst_no" value="{{ $data['gst_no'] }}" />
                                                      <span class="text-danger"> 
                                                        @error('gst_no')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="gst_no">GST No </label>
                                                       
                                                    </div>
                                                </div>
                                                 

                                                
                                                
                                                        
                                            </div>
                                                




                                            
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a  class= "btn btn-dark  "href={{url('account')}}>Back</a></div>
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