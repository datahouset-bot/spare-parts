
@extends('layouts.blank')
@section('pagecontent')

<div class="container ">
  @if(session('message'))
    <div class="alert alert-primary">
        {{ session('message') }}
    </div>
@endif

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Other Details  </h3></div>
                                    <div class="card-body">
                                        <form action="{{url('/comp_info_footer')}}" method="POST">
                                            @csrf
                                             @method('put')
                                             


                                            <div class="row mb-3">
                                              <div class="col-md-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="bank_name" type="text" name="bank_name" value="{{ $compinfofooter->bank_name }}" />
                                                     <span class="text-danger"> 
                                                        @error('bank_name')`
                                                        {{$message}}
                                                        
                                                      @enderror
                                                     </span>
                                                    <label for="bank_name">Bank Name </label>
                                                  </div>
                                                  
                                              </div>

                                              <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="bank_ac_no" type="text" name="bank_ac_no" value="{{ $compinfofooter->bank_ac_no }}" />
                                                   <span class="text-danger"> 
                                                      @error('bank_ac_no')`
                                                      {{$message}}
                                                      
                                                    @enderror
                                                   </span>
                                                  <label for="bank_ac_no">Bank A/c No </label>
                                                </div>
                                                
                                                </div>
                                            
                                            




                                               <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="bank_ifsc" type="text" name="bank_ifsc" value="{{ $compinfofooter->bank_ifsc }}" />
                                                 <span class="text-danger"> 
                                                    @error('bank_ifsc')`
                                                    {{$message}}
                                                    
                                                  @enderror
                                                 </span>
                                                <label for="bank_ifsc">Bank IFSC </label>
                                                </div>
                                              
                                                </div>                                             
                                            </div>

                                            <div class="row mb-3">
                                              <div class="col-md-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="upiid" type="text" name="upiid" value="{{ $compinfofooter->upiid }}" />
                                                     <span class="text-danger"> 
                                                        @error('upiid')`
                                                        {{$message}}
                                                        
                                                      @enderror
                                                     </span>
                                                    <label for="upiid">UPI ID </label>
                                                  </div>
                                                  
                                              </div>

                                              <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="pay_no" type="text" name="pay_no" value="{{ $compinfofooter->pay_no }}" />
                                                   <span class="text-danger"> 
                                                      @error('pay_no')`
                                                      {{$message}}
                                                      
                                                    @enderror
                                                   </span>
                                                  <label for="pay_no">Phone Pay / Gpay </label>
                                                </div>
                                                
                                                </div>
                                            
                                            




                                               <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="bank_branch" type="text" name="bank_branch" value="{{ $compinfofooter->bank_branch }}" />
                                                 <span class="text-danger"> 
                                                    @error('bank_branch')`
                                                    {{$message}}
                                                    
                                                  @enderror
                                                 </span>
                                                <label for="bank_branch">Bank Branch </label>
                                                </div>
                                              
                                                </div>                                             
                                            </div>
                                             <div class="row mb-3">
                                              <div class="col-md-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="voucher_prefix" type="text" name="voucher_prefix" value="{{ $compinfofooter->voucher_prefix }}" />
                                                     <span class="text-danger"> 
                                                        @error('voucher_prefix')`
                                                        {{$message}}
                                                        
                                                      @enderror
                                                     </span>
                                                    <label for="voucher_prefix">Voucher Prefix</label>
                                                  </div>
                                                  
                                              </div>

                                              <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="voucher_suffix" type="text" name="voucher_suffix" value="{{ $compinfofooter->voucher_suffix}}" />
                                                   <span class="text-danger"> 
                                                      @error('voucher_suffix')`
                                                      {{$message}}
                                                      
                                                    @enderror
                                                   </span>
                                                  <label for="voucher_suffix">Voucher Suffix </label>
                                                </div>
                                                
                                                </div>
                                            
                                            




                                               <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="voucher_note" type="text" name="voucher_note" value="{{ $compinfofooter->voucher_note}}" />
                                                 <span class="text-danger"> 
                                                    @error('voucher_note')`
                                                    {{$message}}
                                                    
                                                  @enderror
                                                 </span>
                                                <label for="voucher_note">Voucher Note </label>
                                                </div>
                                              
                                                </div>                                             
                                            </div>
                                            
                                            <div class="row mb-3">
                                              <div class="col-md-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="ct1" type="text" name="ct1" value="{{ $compinfofooter->ct1}}" />
                                                     <span class="text-danger"> 
                                                        @error('ct1')`
                                                        {{$message}}
                                                        
                                                      @enderror
                                                     </span>
                                                    <label for="ct1">Jurisdiction  </label>
                                                  </div>
                                                  
                                              </div>
                                              

                                              <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                  <select class="form-select" id="country" name="country">
                                                    <option value="India" {{ old('country', $compinfofooter->country) == 'India' ? 'selected' : '' }}> Indian</option>
                                                   
                                                    <option value="USA" {{ old('country', $compinfofooter->country) == 'USA' ? 'selected' : '' }}> USA</option>
                                                    <option value="UK" {{ old('country', $compinfofooter->country) == 'UK' ? 'selected' : '' }}> UK</option>
                                                    <option value="Canada" {{ old('country', $compinfofooter->country) == 'Canada' ? 'selected' : '' }}> Canada</option>
                                                    <option value="Australia" {{ old('country', $compinfofooter->country) == 'Australia' ? 'selected' : '' }}> Australia</option>
                                                    <option value="UAE" {{ old('country', $compinfofooter->country) == 'UAE' ? 'selected' : '' }}> UAE</option>
                                                    <option value="Saudi Arabia" {{ old('country', $compinfofooter->country) == 'Saudi Arabia' ? 'selected' : '' }}> Saudi Arabia</option>
                                                    <option value="Indonesia" {{ old('country', $compinfofooter->country) == 'Indonesia' ? 'selected' : '' }}> Indonesia</option>
                                                    <option value="Pakistan" {{ old('country', $compinfofooter->country) == 'Pakistan' ? 'selected' : '' }}> Pakistan</option>
                                                    
                                                    
                                                </select>
                                                   <span class="text-danger"> 
                                                      @error('country')`
                                                      {{$message}}
                                                      
                                                    @enderror
                                                   </span>
                                                  <label for="country">Countery </label>
                                                </div>
                                                
                                                </div>
                                                
                                                <div class="col-md-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                      <select class="form-select" id="currency" name="currency">
                                                          <option value="INR" {{ old('currency', $compinfofooter->currency) == 'INR' ? 'selected' : '' }}>&#x20B9; Indian Rupee (INR)</option>
                                                          <option value="USD" {{ old('currency', $compinfofooter->currency) == 'USD' ? 'selected' : '' }}>&#36; US Dollar (USD)</option>
                                                          <option value="EUR" {{ old('currency', $compinfofooter->currency) == 'EUR' ? 'selected' : '' }}>&#x20AC; Euro (EUR)</option>
                                                          <option value="GBP" {{ old('currency', $compinfofooter->currency) == 'GBP' ? 'selected' : '' }}>&#xa3; British Pound (GBP)</option>
                                                          <option value="JPY" {{ old('currency', $compinfofooter->currency) == 'JPY' ? 'selected' : '' }}>&#xa5; Japanese Yen (JPY)</option>
                                                          <option value="AUD" {{ old('currency', $compinfofooter->currency) == 'AUD' ? 'selected' : '' }}>&#x41;&#x24; Australian Dollar (AUD)</option>
                                                          <option value="AED" {{ old('currency', $compinfofooter->currency) == 'AED' ? 'selected' : '' }}>&#x62f;.&#x625; United Arab Emirates Dirham (AED)</option>
                                                          <option value="SAR" {{ old('currency', $compinfofooter->currency) == 'SAR' ? 'selected' : '' }}>&#x0631;.&#x0633; Saudi Riyal (SAR)</option>
                                                      </select>
                                                      <span class="text-danger"> 
                                                          @error('currency')
                                                          {{$message}}
                                                          @enderror
                                                      </span>
                                                      <label for="currency">Currency</label>
                                                  </div>
                                              </div>
                                            </div>

                                            <div class="row mb-3">
                                              <div class="col-md-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="ct2" type="text" name="ct2" value="{{ $compinfofooter->ct2}}" />
                                                     <span class="text-danger"> 
                                                        @error('ct2')`
                                                        {{$message}}
                                                        
                                                      @enderror
                                                     </span>
                                                    <label for="ct2">Business  </label>
                                                  </div>
                                                  
                                              </div>
                                              <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="ct3" type="text" name="ct3" value="{{ $compinfofooter->ct3}}" />
                                                   <span class="text-danger"> 
                                                      @error('ct3')`
                                                      {{$message}}
                                                      
                                                    @enderror
                                                   </span>
                                                  <label for="ct3">Invoice Head </label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                              <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="ct4" type="text" name="ct4" value="{{ $compinfofooter->ct4}}" />
                                                 <span class="text-danger"> 
                                                    @error('ct4')`
                                                    {{$message}}
                                                    
                                                  @enderror
                                                 </span>
                                                <label for="ct4">Other3  </label>
                                              </div>
                                              
                                          </div>

                                                
                                                                                          </div>
                                            <div class="input-group mb-3 mb-md-0">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text">Terms &amp; Conditions</span>
                                              </div>
                                              <textarea rows="4" cols="50" name="terms" class="form-control" aria-label="With textarea">{{ $compinfofooter->terms }}</textarea>
                                            </div>
                                            
                                                                                  
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit"class="btn btn-primary btn-block">Apply</button>
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a  class= "btn btn-dark  "href={{ url()->previous() }}>Back</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
           
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
   




    
</div>

@endsection