@php
include(public_path('cdn/cdn.blade.php'));
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css')}}">
<style>
  #room_selection_box{
    background-color: rgb(242, 247, 247);
  
    border: 5px solid   #2196F3   ;
    max-height: 170px;
    min-height: 170px;
    overflow: auto; 

  }
  #payment_selection_box{
    background-color: rgb(242, 247, 247);
  
    border: 5px solid   #2196F3   ;
    max-height: 270px;
    min-height: 170px;
    overflow: auto; 

  }
  #room_selection {
    width: 100%;
    border: 2px solid #ddd;

}
#other_charge_detail{
 width: 200px;
 font-size: 15px;

}

/* Style the table rows */
#room_selection tr{
    border-bottom: 1px solid #ddd;
}

/* Style the table cells */
#room_selection td {
    padding: 3px;
    text-align: left;
    font-style: bold;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    font-size: 20px;
    border: 1px solid #ddd;
background-color: white;
 color: #048af8;
}


.container_chekbox {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 1px;
  cursor: pointer;
  font-size: large;
  text-align: center;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container_chekbox input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border: 1px solid;
}

/* On mouse-over, add a grey background color */
.container_chekbox:hover input ~ .checkmark {
  background-color: white;
  border: 1px solid;
}

/* When the checkbox is checked, add a blue background */
.container_chekbox input:checked ~ .checkmark {
  background-color: #2196F3;
  border: 1px solid;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container_chekbox input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container_chekbox .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 12px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
#checkin_room_tariff{
  width: 55px;
  font-size:15px;
}
#checkin_room_dis{
  width: 35px;
  font-size:15px;
}
#checkin_room_no{
  width: 80px;
  font-size: 15px;

}
#checkin_roomtype{
  width: 130px;
  font-size: 15px;
}
label{
color:blue;
font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
font-size: 15px;
font-style: bold;
font-weight:800;
}
.amount_input{
  width: 100px;
  font-size: 15px;
}
.requierdfield{
  color: red;
  font-size:x-large;
  text-align: left;
}
</style>
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
                                    <div class="card-header">
                                      <h5 class="text-center font-weight-light my-1">New Room Booking Entery </h5></div>
                                    <div class="card-body">


                                          <div class="row">
                                            <!-- Room Booking -->

                                            <div class="col-md-3 mt-4">
                                           
                                           
                                            </div>

                                            <!-- Room Booking Client Picture -->
                                            
                                
                                            <!-- Search Customer -->
                                            <div class="col-md-3 mt-4">
                                                <label for="searchCustomer">Search Customer</label>
                                                <div id="searchCustomer">
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

                                                        <span id="message"></span>
                                                    </form>
                                                </div>
                                            </div>
                                
                                            <!-- Selected Customer Picture -->
                                            <div class="col-md-6 mt-1">
                                                <div id="selectedCustomerPic">
                                                    <!-- Image or content for selected customer picture -->
                                                    <img id="guest_pic_response"  class="mx-1"src="{{ asset('storage\app\public\account_image\\' . ($guest_picresponse ?? 'default.jpg')) }}" alt="guest_pic" width="130px">
                                                    
                                                    <img id="uploded_id_pic_response1" src="{{ asset('storage\app\public\account_image\\' . ($guest_pic_id_response ?? 'default.jpg')) }}" alt="Uploaded ID pic" width="130PX">             
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{route('roombookings.store')}}" method="POST" enctype="multipart/form-data">
                                          @csrf          
             {{-- 2nd row checkin detail and select room no                                                          --}}
    <div class="row justify-content-centerm-3">
                                        <div class="col-md-8">
                                          <div class="row form-group">
                                            <div class="col-md-3"><span class="requierdfield">*</span>
                                              <label for="label1">Room Booking No </label>
                                              <input type="text" name="booking_no"class=" form-control"id=""   class="" value="{{$new_bill_no}}" readonly>
                                              <input type="hidden"  name="voucher_no"class=" form-control"id=""  name="voucher_no" class="" value="{{$new_voucher_no}}" readonly>
                                              
                                            </div>
                                            <div class="col-md-3"><span class="requierdfield">*</span>
                                              <label for="booking_date">Booking Date</label>
                                              <input class="form-control date" id="booking_date" type="text" name="booking_date" value="{{ date('Y-m-d') }}" />                                           
                                              <span class="text-danger"> 
                                                @error('booking_date')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>

                                            <div class="col-md-3"><span class="requierdfield">*</span>
                                              <label for="booking_time">Booking Time</label>
                                                  @php
                                                $currentTime = \Carbon\Carbon::now()->format('H:i');
                                            @endphp
                                                  <input class="form-control" id="booking_time" type="time" name="booking_time" value="{{$currentTime }}" />
                                                <span class="text-danger"> 
                                                  @error('booking_time')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
                                                 
                                              </div>
                                              <div class="col-md-3"><span class="requierdfield">*</span>
                                                <label for="checkin_date">Check In  Date</label>
                                                <input class="form-control date" id="checkin_date" type="text" name="checkin_date" value="{{ date('Y-m-d') }}" />                                           
                                                <span class="text-danger"> 
                                                  @error('checkin_date')
                                                  {{$message}}
                                                      
                                                  @enderror
                                                </span>
                                              </div>
  


                                              <div class="col-md-3"><span class="requierdfield">*</span>
                                            <label for="checkin_time">Check In Time</label>
                                             <input class="form-control" id="checkin_time" type="time" name="checkin_time" value="{{ date('Y-m-d') }}" />
                                              <span class="text-danger"> 
                                                @error('checkin_time')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3"><span class="requierdfield">*</span>
                                              <label for="checkout_date">Check Out Date</label>
                                              <input class="form-control date" id="checkout_date" type="text" name="checkout_date" value="{{ date('Y-m-d') }}" />                                           
                                              <span class="text-danger"> 
                                                @error('checkout_date')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>



                                            <div class="col-md-3"><span class="requierdfield">*</span>
                                          <label for="checkout_time">Check Out Time</label>
                                           <input class="form-control" id="checkout_time" type="time" name="checkout_time" value="{{ date('Y-m-d') }}" />
                                            <span class="text-danger"> 
                                              @error('checkout_time')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>
                                          </div>

                                            <div class="col-md-3">
                                              <span class="requierdfield">*</span><label for="commited_days">No Of Days</label>
                                              <input class="form-control" id="commited_days" type="text" name="commited_days" value="{{ old('commited_days') }}" autocomplete="off" />
                                              <span class="text-danger"> 
                                                @error('commited_days')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>

                                            </div>
                                            <div class="col-md-3"><span class="requierdfield">*</span>
                                              <label for="no_of_guest">No Of Guest</label>
                                              <input class="form-control" id="no_of_guest" type="text" name="no_of_guest" value="{{old('no_of_guest')}}" autocomplete="off" />
                                              <span class="text-danger"> 
                                                @error('no_of_guest')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3"><span class="requierdfield">*</span>
                                              <label for="business_source">Business Source</label>
                                              <select name="business_source_id" Id ="business_source_id "class="form-select" aria-label="Default select example">
                                                <option selected disabled>Select Buiness Source </option>
                                                @foreach ($businesssource as $businesssource)
                                                      <option value="{{ $businesssource->id }}">
                                                          {{ $businesssource->business_source_name }}
                                                         
                                                      </option>
                                                @endforeach
                  
                                              </select>
                                              <span class="text-danger"> 
                                                @error('business_source_id')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-6"><span class="requierdfield">*</span>
                                              <label for="package">Package</label>
                                              <select name="package_id" Id ="package_id"class="form-select" aria-label="Default select example">
                                                <option selected disabled>Select Package </option>
                                                @foreach ($package as $package)
                                                      <option value="{{ $package->id }}">
                                                          {{ $package->package_name }}||{{ $package->plan_name }}
                                                         
                                                      </option>
                                                @endforeach
                  
                                              </select>
                                              <span class="text-danger"> 
                                                @error('package_id')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
  
                                          </div>
                                        </div>
                                       


                                      <div class="col-md-4" id ="room_selection_box">
                                       <table id="room_selection" class="table table-striped table-responsive">
                                        <thead>
                                          <tr>
                                            <th># </th>
                                            <th>Room No </th>
                                            <th>Room Type</th>
                                            <th>Tariff</th>

                                          </tr>
                                        </thead>
                                        <tbody>
                                        
                                          <span class="text-danger"> 
                                          @error('booking_room_id')
                                          {{$message}}
                                              
                                          @enderror
                                        </span>

                                        @foreach ($rooms as $room)
                                        <tr>                                              


                                            <td>
                                                <label class="container_chekbox">
                                                    <input type="checkbox" class="room-checkbox" name="booking_room_id[]" value="{{ $room->id }}">
                                                    <span class="checkmark"></span>
                                                </label> 
                                            </td>
                                            <td>
                                                <input type="text"id="checkin_room_no" name="checkin_room_no" value="{{ $room->room_no }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="checkin_roomtype" id="checkin_roomtype" value ="{{ $room->roomtype->roomtype_name }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="checkin_room_tariff"id="checkin_room_tariff" value="{{ $room->roomtype->room_tariff }}" >
                                            </td>
                                            {{-- <td>
                                                <input type="text" name="checkin_room_dis"id="checkin_room_dis" value="{{ $room->roomtype->room_dis }}" readonly>
                                            </td> --}}
                                        </tr>
                                        @endforeach
                                        


                                        </tbody>
                                       </table>
                                        

                                         



                                         
                                      </div>  
    </div>                        

                                   
           {{-- 3rd row start for guest detail +valuadded                             --}}
          <div class="row justify-content-centerm-3 my-3">
                                        <div class="col-md-8">
                                          <div class="row form-group">
                                            <div class="col-md-6"><span class="requierdfield">*</span>
                                              <label for="guest_name">Guest Name </label>
                                              <input class="form-control" id="guest_name" type="text" name="guest_name" value="{{ old('guest_name') }}" autocomplete="none"/>
                                              <span class="text-danger"> 
                                                @error('guest_name')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>


                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_address">Address Line 1</label>
                                              <input class="form-control" id="guest_address" type="text" name="guest_address" value="{{ old('guest_address') }}" />
                                              <span class="text-danger"> 
                                                @error('guest_address')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_address2">Address Line 2</label>
                                              <input class="form-control" id="guest_address2" type="text" name="guest_address2" value="{{ old('guest_address2') }}" />
                                              <span class="text-danger"> 
                                                @error('guest_address2')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_city">City</label>
                                              <input class="form-control" id="guest_city" type="text" name="guest_city" value="{{ old('guest_city') }}" />
                                              <span class="text-danger"> 
                                                @error('guest_city')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_state">State</label>
                                              <input class="form-control" id="guest_state" type="text" name="guest_state" value="{{ old('guest_state') }}" />
                                              <span class="text-danger"> 
                                                @error('guest_state')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_contery">Country</label>
                                              <input class="form-control" id="guest_contery" type="text" name="guest_contery" value="{{ old('guest_countery',$compinfofooter->country ) }}" />
                                              <span class="text-danger"> 
                                                @error('guest_contery')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_pincode"> Pin Code </label>
                                              <input class="form-control" id="guest_pincode" type="text" name="guest_pincode" value="" />
                                              <span class="text-danger"> 
                                                @error('guest_pincode')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                             <div class="col-md-3">
                                              <label for="guest_nationality">Nationality</label>
                                              <input class="form-control" id="guest_nationality" type="text" name="guest_nationality" value="{{ old('guest_countery',$compinfofooter->country ) }}" />
                                              <span class="text-danger"> 
                                                @error('guest_nationality')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3"><span class="requierdfield">*</span>
                                              <label for="guest_mobile">Mobile</label>
                                              <input class="form-control" id="guest_mobile" type="text" name="guest_mobile" value="{{ old('guest_mobile') }}" autocomplete="none"/>
                                              <span class="text-danger"> 
                                                @error('guest_mobile')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>


                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_phone">Phone</label>
                                              <input class="form-control" id="guest_phone" type="text" name="guest_phone" value="{{ old('guest_phone') }}"  autocomplete="none"/>
                                              <span class="text-danger"> 
                                                @error('guest_phone')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div> 
                                            <div class="col-md-3">
                                              <label for="guest_email">Email</label>
                                              <input class="form-control" id="guest_email" type="text" name="guest_email" value="{{ old('guest_email') }}" />
                                              <span class="text-danger"> 
                                                @error('guest_email')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>   
                                            <div class="col-md-3 ">
                                              <label for="label1">Agent</label>
                                              <input type="text" class=" form-control"id=""  name="agent" class="" value="{{ old('agent') }}">
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_idproof">Document Name </label>
                                              <input class="form-control" id="guest_idproof" type="text" name="guest_idproof" value="{{ old('guest_idproof') }}" />
                                              <span class="text-danger"> 
                                                @error('guest_idproof')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_idproof_no">Document No </label>
                                              <input class="form-control" id="guest_idproof_no" type="text" name="guest_idproof_no" value="{{ old('guest_idproof_no') }}" />
                                              <span class="text-danger"> 
                                                @error('guest_idproof_no')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                
                                            <div class="col-md-3">
                                              <label for="firm_name">Company  Name</label>
                                              <input class="form-control" id="firm_name" type="text" name="firm_name" value="{{ old('firm_name') }}" />
                                              <span class="text-danger"> 
                                                @error('firm_name')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                   
                                            </div>
                                
                                            <div class="col-md-3">
                                              <label for="firm_address">Company Address </label>
                                              <input class="form-control" id="firm_address" type="text" name="firm_address" value="{{ old('firm_address') }}" />
                                              <span class="text-danger"> 
                                                @error('firm_address')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                   
                                            </div>
                                
                                
                                            <div class="col-md-3">
                                              <label for="gst_no">GST NO </label>
                                              <input class="form-control" id="gst_no" type="text" name="gst_no" value="{{ old('gst_no') }}" />
                                              <span class="text-danger"> 
                                                @error('gst_no')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                   
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_id_pic">Document Image  </label>
                                              <input class="form-control" id="guest_id_pic" type="file" name="guest_id_pic" value="" />
                                              <span class="text-danger"> 
                                                @error('guest_id_pic')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                            </div>
                                            <div class="col-md-3">
                                              <label for="guest_pic">Guest Image </label>
                                              <input class="form-control" id="guest_pic" type="file" name="guest_pic" value="{{ old('guest_pic') }}" />
                                              <span class="text-danger"> 
                                                @error('guest_pic')
                                                {{$message}}
                                                    
                                                @enderror
                                              </span>
                                
                                            </div>
                                

                                          </div>
                                        </div>
                                       
                                        <div class="col-md-4" id ="payment_selection_box">
                                          <h5>Payment Detail</h5>
                                          <table id="room_selection" class="table table-striped table-responsive">
                                            <thead>
                                              <tr>
                                                <th> </th>
                                                <th>Amount</th>
                                   
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <td>Per Day Room Tariff</td>
                                                <td><input type="text" id="room_tariff_perday" name="room_tariff_perday" class="amount_input" readonly></td>
                                              </tr>
                                              <tr>
                                                <td>Booking Advance</td>
                                                <td>     </td>
                                              </tr>
                                  
                                              <tr>
                                                <td><select name="posting_acc_id" id="posting_acc_id">
                                                <option value="" selected disabled>Select Mode</option>
                                                @foreach ($paymentmodes as $paymentmode )
                                                <option value="{{$paymentmode->id}}" >{{$paymentmode->account_name}}</option>
                                                  
                                                @endforeach  
                                  
                                  
                                                </select></td>
                                                <td>
                                                <input type="text" class="amount_input" id="booking_amount" name="booking_amount" autocomplete="off">
                                                </td>
                                              </tr>
                                  
                                              <tr>
                                                <td>Payment Refance</td>
                                                <td><input type="text" name="voucher_payment_ref"class="amount_input"autocomplete="off"></td>
                                              </tr>
                                              <tr>
                                                <td>Payment Remark</td>
                                                <td><input type="text"  name="voucher_payment_remark" class="amount_input" autocomplete="off"></td>
                                              </tr>
                                  
                                                 
                                  
                                            </tbody>
                                           </table>
                                        </div>  
                                  </div>                        
                                  
                                          
                                        
       {{-- 4rd row start for guest Correspondence                              --}}
  <div class="row justify-content-centerm-3 my-3">
        <div class="col-md-8">
          <div class="row form-group mx-1">
  
            


          </div>
  </div>
       


     
 
  <div id="contentstart">

       

                                            <div class="row mb-3">
                                              


                                        <div class="col-md-4 mt-4">
                                          <div class="form-floating mb-3 mb-md-0">
{{--                                              
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
                                            
  --}}
                                           
                                            
                                   
{{-- 
                                          <div class="col-md-4 mt-4">
                                            <div class="form-floating mb-3 mb-md-0">
                                              <input class="form-control" id="advance_amount" type="text" name="advance_amount" value="{{ old('advance_amount') }}" />
                                                <label for="priority">Advance Amount  </label>
                                               
                                            </div>
                                            <span class="text-danger"> 
                                              @error('advance_amount')
                                              {{$message}}
                                                  
                                              @enderror
                                            </span>

                                        </div> --}}

                                        
                        



                                        <div class="row">
                                          
                                               </div></DIV>



                                               {{-- <input type="text" name ="room_no" id="room_no" value="" >
                                               <input type="text" name ="room_tariff" id="room_tariff" value="" >
                                               <input type="text" name ="room_dis" id="room_dis" value="" >
                                               <input type="text" name ="package_name" id="package_name" value="" >
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
                                               <input type="text" name ="tax5" id="tax5" value="" > --}}

                                                
                                                
                                                        
                                            </div>
                                                




                                            
                                            
                                    <div class="card-footer text-center py-3">
                                        <div class="small">
                                          <button type="submit"class="btn btn-primary btn-block">Save</button>
                                          <a  class= "btn btn-dark  "href={{url('amclist')}}>Back</a></div>
                                    </div>





                                  </form>
                </div id="content close ">
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
      {{-- function for calculate room traif  --}}
              <script src="{{ global_asset('/general_assets\js\form.js')}}"></script>
              <script>
                $(document).ready(function() {
                    $('.room-checkbox').change(function() {
                        calculateTotalRoomTariff();
                    });
            
                    function calculateTotalRoomTariff() {
                        let total = 0;
                        $('.room-checkbox:checked').each(function() {
                            const roomTariffInput = $(this).closest('tr').find('input[name="checkin_room_tariff"]');
                            const roomTariff = parseFloat(roomTariffInput.val());
                            total += roomTariff;
                        });
                        $('#room_tariff_perday').val(total.toFixed(2));
                    }
                });
            // </script>


             {{-- Ajex for search room Detail --}}
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


                              if (response.customer_info){$('#guest_pic_response1').val(response.customer_info.account_pic1);} 
                              else {$('#guest_pic_response1').val('');}
                              if (response.customer_info) {
                                const imageUrl = "{{ asset('storage/app/public/account_image/') }}" + '/' + response.customer_info.account_pic1;
                                $('#guest_pic_response').attr('src', imageUrl);
                            } else {
                                $('#guest_pic_response').attr('src', ''); // or set a default image if desired
                            }
                                 if (response.customer_info) {
                                  $('#uploded_id_pic_response').val(response.customer_info.account_id_pic);
                                  $('#uploded_id_pic_response1').attr('src', '{{ asset('storage/app/public/account_image/') }}/' + response.customer_info.account_id_pic);
                              } else {
                                  $('#uploded_id_pic_response').val('');
                                  $('#uploded_id_pic_response1').attr('src', '{{ asset('storage/app/public/image/default.jpg') }}');
                              } 




                              if (response.customer_info){$('#gst_no').val(response.customer_info.gst_no);} 
                              else {$('#gst_no').val('');}                                        

                              if (response.message) {
                                  $('#message').html('  ' + response.message +'');
                              } else {
                                  $('#search_results').html('<p>No customer found with this contact number.</p>');
                              }
                          },
                          error: function() {
                              $('#search_results').html('<p>An error occurred while searching for the customer.</p>');
                          }
                      });
                  });
              });
          </script>
           {{-- this is function  when i select booking no cutomer search is diable  --}}

           <script>
  $(document).ready(function() {
        $('#roombooking_id').change(function() {
            if ($(this).val() !== null) {
                $('#searchinput').prop('readonly', true);
            } else {
                $('#searchinput').prop('readonly', false);
            }
        });
    });
           </script>
           {{-- Ajex for search roomBooking Detail --}}
           <script type="text/javascript">
            $(document).ready(function() {
                $('#roombooking_id').change(function() {
                    var roombooking_id = $(this).val();
                    console.log(roombooking_id); 
                            $.ajax({
                            url: '/show_selected_booking/' + roombooking_id,
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                              console.log(response);



                              if (response.booking_date)
                               {
                                        $('#booking_date').val(response.booking_date);
                               } else {
                                        $('#booking_date').val('');
                                      }
                                      if (response.guest_name)
                                       {$('#room_type').val(response.guest_name);}
                                      else {$('#room_type').val('');}       

                                      if (response.room_no){$('#room_no').val(response.room_no);} 
                                      else {$('#room_no').val('');}
                                      if (response.room_tariff){$('#room_tariff').val(response.room_tariff);} 
                                      else {$('#room_tariff').val('');}
                                      if (response.room_dis){$('#room_dis').val(response.room_dis);} 
                                      else {$('#room_dis').val('');}
                                      if (response.package_name){$('#package_name').val(response.package_name);} 
                                      else {$('#package_name').val('');}
                                      if (response.plan_name){$('#plan_name').val(response.plan_name);} 
                                      else {$('#plan_name').val('');}
                                      if (response.taxname){$('#taxname').val(response.taxname);} 
                                      else {$('#taxname').val('');}
                                      if (response.sgst){$('#sgst').val(response.sgst);} 
                                      else {$('#sgst').val('');}
                                      if (response.cgst){$('#cgst').val(response.cgst);} 
                                      else {$('#cgst').val('');}
                                      if (response.igst){$('#igst').val(response.igst);} 
                                      else {$('#igst').val('');}
                                      if (response.vat){$('#vat').val(response.vat);} 
                                      else {$('#vat').val('');}
                                      if (response.tax1){$('#tax1').val(response.tax1);} 
                                      else {$('#tax1').val('');}
                                      if (response.tax2){$('#tax2').val(response.tax2);} 
                                      else {$('#tax2').val('');}
                                      if (response.tax3){$('#tax3').val(response.tax3);} 
                                      else {$('#tax3').val('');}
                                      if (response.tax4){$('#tax4').val(response.tax4);} 
                                      else {$('#tax4').val('');}
                                      if (response.tax5){$('#tax5').val(response.tax5);} 
                                      else {$('#tax5').val('');}
                                      if (response.guest_name){$('#guest_name').val(response.guest_name);} 
                                      else {$('#guest_name').val('');}
                                      if (response.guest_name){$('#guest_email').val(response.guest_email);} 
                                      else {$('#guest_email').val('');}
                                      if (response.guest_name){$('#guest_mobile').val(response.guest_mobile);} 
                                      else {$('#guest_mobile').val('');}
                                      if (response.guest_name){$('#guest_address').val(response.guest_address);} 
                                      else {$('#guest_address').val('');}
                                      if (response.guest_name){$('#guest_city').val(response.guest_city);} 
                                      else {$('#guest_city').val('');}
                                      if (response.guest_name){$('#guest_state').val(response.guest_state);} 
                                      else {$('#guest_state').val('');}
                                      if (response.guest_name){$('#guest_contery').val(response.guest_contery);} 
                                      else {$('#guest_contery').val('');}
                                      if (response.guest_name){$('#guest_idproof').val(response.guest_idproof);} 
                                      else {$('#guest_idproof').val('');}
                                      if (response.guest_name){$('#guest_idproof_no').val(response.guest_idproof_no);} 
                                      else {$('#guest_idproof_no').val('');}
                                      if (response.guest_name){$('#gst_no').val(response.gst_no);} 
                                      else {$('#gst_no').val('');}
                                      if (response.booking_amount){$('#booking_amount').val(response.booking_amount);} 
                                      else {$('#booking_amount').val('');}
                                      if (response.guest_id_pic) {
                                          $('#uploded_id_pic_response1').attr('src', '{{ asset('storage/account_image/') }}/' + response.guest_id_pic);
                                      } else {
                                          $('#uploded_id_pic_response1').attr('src', '{{ asset('storage/account_image/default.jpg') }}');
                                      } 
                                      if (response.guest_pic) {
                                        $('#guest_pic_response').attr('src', '{{ asset('storage/account_image/') }}/' + response.guest_pic);
                                    } else {

                                        $('#guest_pic_response').attr('src', '{{ asset('storage/account_image/default.jpg') }}');
                                    } 










                                } 
                            

                        });
                      
                });
            });
        </script>

@endsection
