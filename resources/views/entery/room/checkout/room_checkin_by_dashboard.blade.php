@php
include(public_path('cdn/cdn.blade.php'));
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}">

@extends('layouts.blank')
@section('pagecontent')
   
<div class="card my-1 ">
 <div class="row ">

  
  <div class="container ">

    <body class="bg-primary">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card  mt-1">
                                    <div class="card-header"><h5 class="text-center font-weight-light my-1">New Room Booking Entery </h5></div>
                                    <div class="card-body">
                                                 <div class="class row-mb-3">
 

                                                  <div class="col-md-4 mt-4">
                                                <label for="">Seach Guest</label>
                                                <div class="form-floating mb-3 mb-md-0">
                                                 <form class="form-inline" id ="search_acccount">
                                                    @csrf

                                                    <div class="input-group">

                                                        <input type="text" class="form-control" id="searchinput" placeholder="Enter Contact Number" autocomplete="off">

                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="submit" id="search_button" >
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                   <p id="message" ></p>

                                                 </form>

                                                </div>
                                                

                                            </div>





                                            <form action="{{route('roombookings.store')}}" method="POST" enctype="multipart/form-data">
                                              @csrf
                                     

                                            <div class="row mb-3">
                                                <div class="col-md-4 mt-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control date" id="booking_date" type="text" name="booking_date" value="{{ date('Y-m-d') }}" />

                                           
                                                      <span class="text-danger"> 
                                                        @error('booking_date')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="booking_date">Booking Date </label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                    @php
                                                    $currentTime = \Carbon\Carbon::now()->format('H:i');
                                                @endphp
                                                      <input class="form-control" id="booking_time" type="time" name="booking_time" value="{{ date('Y-m-d') }}" />
                                                    <span class="text-danger"> 
                                                      @error('booking_time')
                                                      {{$message}}
                                                          
                                                      @enderror
                                                    </span>
                                                      <label for="booking_time">Booking Time </label>
                                                     
                                                  </div>
                                              </div>
                                                <div class="col-md-4 mt-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                      <input class="form-control date" id="checkin_date" type="text" name="checkin_date" value="{{ date('Y-m-d') }}" />
                                                    <span class="text-danger"> 
                                                      @error('checkin_date')
                                                      {{$message}}
                                                          
                                                      @enderror
                                                    </span>
                                                      <label for="account_group">Check In Date </label>
                                                     
                                                  </div>
                                              </div>

                                              <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="checkin_time" type="time" name="checkin_time" value="{{ date('Y-m-d') }}" />
                                                  <span class="text-danger"> 
                                                    @error('checkin_time')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
                                                    <label for="account_group">Check In Time </label>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-4">
                                              <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control date_plus_1" id="checkout_date" type="text" name="checkout_date" value="{{ date('Y-m-d') }}" />
                                                <span class="text-danger"> 
                                                  @error('checkout_date')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
                                                  <label for="account_group">Check Out Date </label>
                                                 
                                              </div>
                                          </div>
                                          <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="checkout_time" type="time" name="checkout_time" value="{{ date('Y-m-d') }}" />
                                              <span class="text-danger"> 
                                                @error('checkout_time')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                                <label for="account_group">Check Out Time </label>
                                               
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                          <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="room_id" type="text" name="room_id" 
                                              value="{{ $rooms->room_no }}" />
                                              <label for="priority">Room No   </label>
                                             
                                          </div>
                                          <span class="text-danger"> 
                                            @error('refrance_no')
                                            {{$message}}
                                                
                                            @enderror
                                          </span>

                                      </div>                                              <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="booking_mode" type="text" name="booking_mode" value="{{ old('booking_mode') }}" />
                                                  <span class="text-danger"> 
                                                    @error('booking_mode)')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
                                                    <label for="booking_mode">Booking Mode  </label>
                                                   
                                                </div>
                                            </div>
                                            
 
                                           
                                                <div class="col-md-4 mt-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                   
                                                    <select name="payment_status" Id ="payment_status"class="form-select" aria-label="Default select example">
                                                      <option selected disabled>Select Status </option>
                                                      
                                                      <option value="Advance">Advance</option>
                                                      <option value="checkintime">At The Time Of CheckIn</option>       
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
                                                 
                                                  <select name="payment_mode" Id ="payment_mode"class="form-select" aria-label="Default select example">
                                                    <option selected disabled>Payment Mode </option>
                                                    
                                                    <option value="cash">Cash</option>
                                                    <option value="online">Online</option>       
                                                    <option value="byagrigater">By Agrigater </option>             
                                                    
                                                  </select>
                                                    <label for="payment_mode">Payment Mode  </label>
                                                   
                                                </div>
                                                <span class="text-danger"> 
                                                  @error('payment_mode')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
  
                                            </div>    
                                            


                                            <div class="col-md-4 mt-4">
                                              <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="refrance_no" type="text" name="refrance_no" value="{{ old('refrance_no') }}" />
                                                  <label for="priority">Refrance No   </label>
                                                 
                                              </div>
                                              <span class="text-danger"> 
                                                @error('refrance_no')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>

                                          </div>    
                                          
                                          <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="booking_amount" type="text" name="booking_amount" value="{{ old('booking_amount') }}" />
                                                <label for="priority">Booking Amount  </label>
                                               
                                            </div>
                                            <span class="text-danger"> 
                                              @error('booking_amount')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>

                                        </div>
                                        
                                          <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                               
                                              <input class="form-control" id="room_type" type="text" readonly name="room_type" value="{{$rooms->roomtype->roomtype_name}}
                                              " />
                                                
                                                <label for="room_type">Room Type   </label>
                                               
                                            </div>
                                            <span class="text-danger"> 
                                              @error('room_type')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>

                                        </div>    
                                        <div class="col-md-4 mt-4">
                                          <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="facility" type="text" readonly name="facility" value="{{$rooms->room_facilities}}
                                              " />
                                            <span class="text-danger"> 
                                              @error('facility')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>
                                              <label for="facility">Facility</label>
                                             
                                          </div>
                                      </div>
  
                                        <div class="col-md-4 mt-4">
                                          <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="guest_name" type="text" name="guest_name" value="{{ old('guest_name') }}" />
                                            <span class="text-danger"> 
                                              @error('guest_name')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>
                                              <label for="guest_name">Guest Name</label>
                                             
                                          </div>
                                      </div>
  



                                                <div class="col-md-4 mt-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="guest_email" type="text" name="guest_email" value="{{ old('guest_email') }}" />
                                                      <span class="text-danger"> 
                                                        @error('guest_email')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="guest_email">Guest Email</label>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="guest_mobile" type="text" name="guest_mobile" value="{{ old('guest_mobile') }}" />
                                                      <span class="text-danger"> 
                                                        @error('guest_mobile')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="guest_mobile">Contact No </label>
                                                       
                                                    </div>

                                                </div>  
                                                <div class="col-md-4 mt-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                      <input class="form-control" id="guest_address" type="text" name="guest_address" value="{{ old('guest_address') }}" />
                                                    <span class="text-danger"> 
                                                      @error('guest_address')
                                                      {{$message}}
                                                          
                                                      @enderror
                                                    </span>
                                                      <label for="guest_address">Address </label>
                                                     
                                                  </div>

                                              </div>  
                                              <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="guest_city" type="text" name="guest_city" value="{{ old('guest_city') }}" />
                                                  <span class="text-danger"> 
                                                    @error('guest_city')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
                                                    <label for="guest_city">City </label>
                                                   
                                                </div>

                                            </div>  
                                            <div class="col-md-4 mt-4">
                                              <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="guest_state" type="text" name="guest_state" value="{{ old('guest_state') }}" />
                                                <span class="text-danger"> 
                                                  @error('guest_state')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
                                                  <label for="guest_state">State </label>
                                                 
                                              </div>

                                          </div>  
                                          <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="guest_contery" type="text" name="guest_contery" value="{{ old('guest_countery',$compinfofooter->country ) }}" />
                                              <span class="text-danger"> 
                                                @error('guest_contery')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                                <label for="guest_contery">Contery </label>
                                               
                                            </div>

                                        </div>  

                                                <div class="col-md-4 mt-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="guest_idproof" type="text" name="guest_idproof" value="{{ old('guest_idproof') }}" />
                                                      <span class="text-danger"> 
                                                        @error('guest_idproof')
                                                        {{$message}}
                                                            
                                                        @enderror
                                                      </span>
                                                        <label for="guest_idproof">Id Proof Doumnet Name</label>
                                                       
                                                    </div>

                                                </div>
                                                <div class="col-md-4 mt-4">
                                                  <div class="form-floating mb-3 mb-md-0">
                                                      <input class="form-control" id="guest_idproof_no" type="text" name="guest_idproof_no" value="{{ old('guest_countery') }}" />
                                                    <span class="text-danger"> 
                                                      @error('guest_idproof_no')
                                                      {{$message}}
                                                          
                                                      @enderror
                                                    </span>
                                                      <label for="guest_idproof_no">Id No  </label>
                                                     
                                                  </div>
    
                                              </div>      
                                              <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="gst_no" type="text" name="gst_no" value="{{ old('gst_no') }}" />
                                                  <span class="text-danger"> 
                                                    @error('gst_no')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
                                                    <label for="gst_no">GST NO  / Tax No   </label>
                                                   
                                                </div>
    
                                            </div>    

                                          </div> {{-- closing for 1st form row  --}}
                                        <div class="row">
                                              <div class="col-md-3 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="guest_id_pic" type="file" name="guest_id_pic" value="" />
                                                  <span class="text-danger"> 
                                                    @error('guest_id_pic')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
                                                    <label for="guest_id_pic">Upload Id Proof  Pic </label>
                                                </span>
                                                <input type="text" id="uploded_id_pic_response" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">

                                              <div class="form-floating mb-3 mb-md-0">
                                                <img id="uploded_id_pic_response1" src="{{ asset('storage/account_image/' . ($guest_pic_id_response ?? 'default.jpg')) }}" alt="Uploaded ID pic" width="80px">             

                                          </div>
                                        </div>
                                            <div class="col-md-3 mt-4">
                                              <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="guest_pic" type="file" name="guest_pic" value="{{ old('guest_pic') }}" />
                                                <span class="text-danger"> 
                                                  @error('guest_pic')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
                                                <input type="text" id="guest_pic_response1" value="">
                                                <span class="text-success">

   


                                                </span>
                                                  <label for="account_id_pic">Upload Guest Pic  </label>
                                                 
                                              </div>                                             

                                          </div> 
                                          <div class="col-md-3 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <div class="form-floating mb-3 mb-md-0">
                                                <img id="guest_pic_response" src="{{ asset('storage/account_image/' . ($guest_picresponse ?? 'default.jpg')) }}" alt="guest_pic" width="80px">  
                                              </div>                            
                                            </div>                                             

                                        </div>   
                                        </div>
<span>

                                               <input id="room_id" type="text" name="room_id" 
                                               value="{{ $rooms->id }}" />

                                               <input type="text" name ="room_no" id="room_no" value="{{$rooms->room_no}}" >

                                               <input type="text" name ="room_tariff" id="room_tariff" value="{{$rooms->roomtype->room_tariff}}" >

                                               <input type="text" name ="room_dis" id="room_dis" value="{{$rooms->roomtype->room_dis}}" >

                                               <input type="text" name ="package_name" id="package_name" value="{{$rooms->roomtype->package->package_name}}" >
                                               <input type="text" name ="plan_name" id="plan_name" value="{{$rooms->roomtype->package->plan_name}}" >
                                               <input type="text" name ="taxname" id="taxname" value="{{$rooms->roomtype->gstmaster->taxname}}" >
                                               <input type="text" name ="sgst" id="sgst" value="{{$rooms->roomtype->gstmaster->sgst}}" >
                                               <input type="text" name ="cgst" id="cgst" value="{{$rooms->roomtype->gstmaster->cgst}}" >
                                               <input type="text" name ="igst" id="igst" value="{{$rooms->roomtype->gstmaster->igst}}" >
                                               <input type="text" name ="vat" id="vat" value="{{$rooms->roomtype->gstmaster->vat}}" >
                                               <input type="text" name ="tax1" id="tax1" value="{{$rooms->roomtype->gstmaster->tax1}}" >
                                               <input type="text" name ="tax2" id="tax2" value="{{$rooms->roomtype->gstmaster->tax2}}" >
                                               <input type="text" name ="tax3" id="tax3" value="{{$rooms->roomtype->gstmaster->tax3}}" >
                                               <input type="text" name ="tax4" id="tax4" value="{{$rooms->roomtype->gstmaster->tax4}}" >
                                               <input type="text" name ="tax5" id="tax5" value="{{$rooms->roomtype->gstmaster->tax5}}" >

</span>                                                
                                                
                                                        
                                            </div>
                                                




                                            
                                            
                                    <div class="card-footer text-center py-3">
                                        <div class="small">
                                          <button type="submit"class="btn btn-primary btn-block">Save</button>
                                          <a  class= "btn btn-dark  "href={{url('amclist')}}>Back</a></div>
                                    </div>





                                  </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
                  </div>
        </div>

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
      
              <script src="{{ global_asset('/general_assets\js\form.js')}}"></script>
             {{-- Ajex for search room Detail --}}
            {{-- <script type="text/javascript">
                $(document).ready(function() {
                    $('#room_id').change(function() {
                        var roomId = $(this).val();
                        console.log(roomId); 
                                $.ajax({
                                url: '/roombookings/' + roomId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                  console.log(response);


    
                                  if (response.room_facilities)
                                   {
                                            $('#facility').val(response.room_facilities);
                                   } else {
                                            $('#facility').val('');
                                          }
                                          if (response.roomtype)
                                           {$('#room_type').val(response.roomtype.roomtype_name);}
                                          else {$('#room_type').val('');}       

                                          if (response.room_no){$('#room_no').val(response.room_no);} 
                                          else {$('#room_no').val('');}
                                          if (response.roomtype){$('#room_tariff').val(response.roomtype.room_tariff);} 
                                          else {$('#room_tariff').val('');}
                                          if (response.roomtype){$('#room_dis').val(response.roomtype.room_dis);} 
                                          else {$('#room_dis').val('');}
                                          if (response.roomtype){$('#package_name').val(response.roomtype.package.package_name);} 
                                          else {$('#package_name').val('');}
                                          if (response.roomtype){$('#plan_name').val(response.roomtype.package.plan_name);} 
                                          else {$('#plan_name').val('');}
                                          if (response.roomtype){$('#taxname').val(response.roomtype.gstmaster.taxname);} 
                                          else {$('#taxname').val('');}
                                          if (response.roomtype){$('#sgst').val(response.roomtype.gstmaster.sgst);} 
                                          else {$('#sgst').val('');}
                                          if (response.roomtype){$('#cgst').val(response.roomtype.gstmaster.cgst);} 
                                          else {$('#cgst').val('');}
                                          if (response.roomtype){$('#igst').val(response.roomtype.gstmaster.igst);} 
                                          else {$('#igst').val('');}
                                          if (response.roomtype){$('#vat').val(response.roomtype.gstmaster.vat);} 
                                          else {$('#vat').val('');}
                                          if (response.roomtype){$('#tax1').val(response.roomtype.gstmaster.tax1);} 
                                          else {$('#tax1').val('');}
                                          if (response.roomtype){$('#tax2').val(response.roomtype.gstmaster.tax2);} 
                                          else {$('#tax2').val('');}
                                          if (response.roomtype){$('#tax3').val(response.roomtype.gstmaster.tax3);} 
                                          else {$('#tax3').val('');}
                                          if (response.roomtype){$('#tax4').val(response.roomtype.gstmaster.tax4);} 
                                          else {$('#tax4').val('');}
                                          if (response.roomtype){$('#tax5').val(response.roomtype.gstmaster.tax5);} 
                                          else {$('#tax5').val('');}

                                    } 
                                

                            });
                          
                    });
                });
            </script> --}}
             {{-- Ajex for Account Detail --}}
             <script type="text/javascript">
              $(document).ready(function() {
                  $('#search_acccount').submit(function(event) {
                      event.preventDefault(); // Prevent the form from submitting via the browser
                      var contactNumber = $('#searchinput').val();
                      console.log(contactNumber);
      
                      $.ajax({
                          url: '/searchcustomer/' + contactNumber,
                          type: 'GET',
                          dataType: 'json',
                          success: function(response) {
                              console.log(response);
      
                              if (response.customer_info){$('#guest_name').val(response.customer_info.account_name);} 
                              else {$('#guest_name').val('');}
                              if (response.customer_info){$('#guest_email').val(response.customer_info.email);} 
                              else {$('#guest_email').val('');}
                              if (response.customer_info){$('#guest_mobile').val(response.customer_info.mobile);} 
                              else {$('#guest_mobile').val('');}
                              if (response.customer_info){$('#guest_address').val(response.customer_info.address);} 
                              else {$('#guest_address').val('');}
                              if (response.customer_info){$('#guest_city').val(response.customer_info.city);} 
                              else {$('#guest_city').val('');}
                              if (response.customer_info){$('#guest_state').val(response.customer_info.state);} 
                              else {$('#guest_state').val('');}
                              if (response.customer_info){$('#guest_contery').val(response.customer_info.nationality);} 
                              else {$('#guest_contery').val('');}  
                              if (response.customer_info){$('#guest_idproof').val(response.customer_info.account_idproof_name);} 
                              else {$('#guest_idproof').val('');}   
                              if (response.customer_info){$('#guest_idproof_no').val(response.customer_info.account_idproof_no);} 
                              else {$('#guest_idproof_no').val('');}  
                              if (response.customer_info){$('#gst_no').val(response.customer_info.gst_no);} 
                              else {$('#gst_no').val('');}                               
                              if (response.customer_info){$('#guest_pic_response1').val(response.customer_info.account_pic1);} 
                              else {$('#guest_pic_response1').val('');}
                              if (response.customer_info) {
                                const imageUrl = "{{ asset('storage/account_image/') }}" + '/' + response.customer_info.account_pic1;
                                $('#guest_pic_response').attr('src', imageUrl);
                            } else {
                                $('#guest_pic_response').attr('src', ''); // or set a default image if desired
                            }
                                 if (response.customer_info) {
                                  $('#uploded_id_pic_response').val(response.customer_info.account_id_pic);
                                  $('#uploded_id_pic_response1').attr('src', '{{ asset('storage/account_image/') }}/' + response.customer_info.account_id_pic);
                              } else {
                                  $('#uploded_id_pic_response').val('');
                                  $('#uploded_id_pic_response1').attr('src', '{{ asset('storage/account_image/default.jpg') }}');
                              } 

                                 



                              if (response.message) {
                                  $('#message').html('<h5 style="Bacground-color:greenyellow">  ' + response.message +'</h5>');
                              } else {
                                  $('#search_results').html('<h5 style="Bacground-color:red">No customer found with this contact number.</h5>');
                              }

                          },
                          error: function() {
                              $('#search_results').html('<p>An error occurred while searching for the customer.</p>');
                          }
                      });
                  });
              });
          </script>
      

@endsection
