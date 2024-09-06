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
                                    <div class="card-header"><h5 class="text-center font-weight-light my-1">Room Booking Modify </h5></div>
                                    <div class="card-body">
                                        <form action="{{route('roombookings.update', $roombooking->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')

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
                                                      <input class="form-control" id="booking_time" type="time" name="booking_time" value="{{$roombooking->booking_time}}" />
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
                                                    <input class="form-control" id="checkin_time" type="time" name="checkin_time" value="{{$roombooking->checkin_time}}" />
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
                                                  <input class="form-control date" id="checkout_date" type="text" name="checkout_date" value="{{ date('Y-m-d') }}" />
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
                                                <input class="form-control" id="checkout_time" type="time" name="checkout_time" value="{{$roombooking->checkout_time }}" />
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
                                             
                                            <select name="room_id" Id ="room_id"class="form-select" aria-label="Default select example">
                                              <option selected disabled>Select Room No </option>
                                              @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}">
                                                        {{ $room->room_no }}
                                                       
                                                    </option>
                                              @endforeach
                
                                            </select>
                                              <label for="room_id">Room No   </label>
                                             
                                          </div>
                                          <span class="text-danger"> 
                                            @error('room_no')
                                            {{$message}}
                                                
                                            @enderror
                                          </span>

                                      </div>       
                                              <div class="col-md-4 mt-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="booking_mode" type="text" name="booking_mode" value="{{ old('booking_mode',$roombooking->booking_mode) }}" />
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
                                                <input class="form-control" id="refrance_no" type="text" name="refrance_no" value="{{ old('refrance_no',$roombooking->refrance_no) }}" />
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
                                              <input class="form-control" id="booking_amount" type="text" name="booking_amount" value="{{ old('booking_amount',$roombooking->booking_amount) }}" />
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
                                               
                                              <input class="form-control" id="room_type" type="text" readonly name="room_type" value="{{ old('room_type') }} " />
                                                
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
                                              <input class="form-control" id="facility" type="text" readonly name="facility" value="{{ old('facility') }}" />
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
                                              <input class="form-control" id="guest_name" type="text" name="guest_name" value="{{ old('guest_name',$roombooking->guest_name) }}" />
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
                                                        <input class="form-control" id="guest_email" type="text" name="guest_email" value="{{ old('guest_email',$roombooking->guest_email) }}" />
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
                                                        <input class="form-control" id="guest_mobile" type="text" name="guest_mobile" value="{{ old('guest_mobile',$roombooking->guest_mobile) }}" />
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
                                                      <input class="form-control" id="guest_address" type="text" name="guest_address" value="{{ old('guest_address',$roombooking->guest_address) }}" />
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
                                                    <input class="form-control" id="guest_city" type="text" name="guest_city" value="{{ old('guest_city',$roombooking->guest_city) }}" />
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
                                                  <input class="form-control" id="guest_state`" type="text" name="guest_state" value="{{ old('guest_state',$roombooking->guest_state) }}" />
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
                                                  <input class="form-control" id="guest_contery" type="text" name="guest_contery" value="{{ old('guest_countery',$roombooking->guest_contery) }}" />
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
                                                        <input class="form-control" id="guest_idproof" type="text" name="guest_idproof" value="{{ old('guest_idproof',$roombooking->guest_idproof) }}" />
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
                                                      <input class="form-control" id="guest_idproof_no" type="text" name="guest_idproof_no" value="{{ old('guest_countery',$roombooking->guest_idproof_no) }}" />
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
                                                    <input class="form-control" id="guest_id_pic" type="file" name="guest_id_pic" value="{{ old('guest_id_pic') }}" />
                                                  <span class="text-danger"> 
                                                    @error('guest_id_pic')
                                                    {{$message}}
                                                        
                                                    @enderror
                                                  </span>
                                                    <label for="guest_id_pic">Upload Id Proof  Pic </label>
                                                   
                                                </div>

                                            </div>
                                            <div class="col-md-4 mt-4">
                                              <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="account_id_pic" type="file" name="account_id_pic" value="{{ old('account_id_pic') }}" />
                                                <span class="text-danger"> 
                                                  @error('account_id_pic')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
                                                  <label for="account_id_pic">Upload Guest Pic  </label>
                                                 
                                              </div>

                                          </div>    
                                               </div>


                                               <input type="text" name ="room_no" id="room_no" value="" >
                                               <input type="text" name ="room_tariff" id="room_tariff" value="" >
                                               <input type="text" name ="room_dis" id="room_dis" value="" >
                                               <input type="text" name ="package_name" id="package_name" value="{{old('package_name')}}" >
                                               <input type="text" name ="plan_name" id="plan_name" value="" >
                                               <input type="text" name ="taxname" id="taxname" value="" >
                                               <input type="text" name ="sgst" id="sgst" value="" >
                                               <input type="text" name ="cgst" id="cgst" value="" >
                                               <input type="text" name ="igst" id="igst" value="" >
                                               <input type="text" name ="vat" id="vat" value="" >
                                               <input type="text" name ="tax1" id="tax1" value="" >
                                               <input type="text" name ="tax2" id="tax2" value="" >
                                               <input type="text" name ="tax3" id="tax3" value="" >
                                               <input type="text" name ="tax4" id="tax4" value="" >
                                               <input type="text" name ="tax5" id="tax5" value="" >

                                                
                                                
                                                        
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
             
           

            <script type="text/javascript">
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
            </script>
             

@endsection
