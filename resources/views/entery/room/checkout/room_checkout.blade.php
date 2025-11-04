@php
    include public_path('cdn/cdn.blade.php');
@endphp
<link rel="stylesheet" href="{{ global_asset('/general_assets\css\form.css') }}">
<style>
    #room_selection_box {
        background-color: rgb(242, 247, 247);

        border: 5px solid #2196F3;
        max-height: 170px;
        min-height: 170px;
        overflow: auto;

    }

    #room_selection {
        width: 100%;
        border: 2px solid #ddd;

    }

    /* Style the table rows */
    #room_selection tr {
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
    .container_chekbox:hover input~.checkmark {
        background-color: white;
        border: 1px solid;
    }

    /* When the checkbox is checked, add a blue background */
    .container_chekbox input:checked~.checkmark {
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
    .container_chekbox input:checked~.checkmark:after {
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

    #checkin_room_tariff {
        width: 55px;
        font-size: 15px;
    }

    #checkin_room_dis {
        width: 35px;
        font-size: 15px;
    }

    #checkin_room_no {
        width: 50px;
    }

    #checkin_roomtype {
        width: 130px;
        font-size: 15px;
    }

    label {
        color: blue;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-size: 15px;
        font-style: bold;
        font-weight: 800;
    }

    .amount_input {
        width: 100px;
        font-size: 15px;
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
                                        <h5 class="text-center font-weight-light my-1">Select slot For Invoice </h5>
                                    </div>
                                    <div class="card-body">


                                        <div class="row">
                                            <!-- Room Booking -->

                                            <div class="col-md-10 mt-4">
                                                <form class="form-inline" id="select_roomcheckout">
                                                    @csrf
                                                    <div class="input-group">
                                                        <select name="roomcheckin_voucher_no" id="roomcheckin_voucher_no"
                                                            class="form-select" aria-label="Default select example">
                                                            <option selected disabled>Select Slot</option>
                                                            @foreach ($roomcheckins as $roomcheckin)
                                                                <option value="{{ $roomcheckin->voucher_no }}">
                                                                    {{ $roomcheckin->guest_name }}||{{ $roomcheckin->guest_mobile }}||{{ $roomcheckin->room_nos }}||{{ $roomcheckin->check_in_no }}||
                                                                    <td scope="col">
                                                                        {{ \Carbon\Carbon::parse($roomcheckin->checkin_date)->format('d-m-y') }}
                                                                    </td>
                                                                    ||{{ $roomcheckin->checkin_time }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </form>

                                                <script>
                                                    document.getElementById('roomcheckin_voucher_no').addEventListener('change', function() {
                                                        var voucherNo = this.value;
                                                        if (voucherNo) {
                                                            window.location.href = '/show_checkin/' + voucherNo;
                                                        }
                                                    });
                                                </script>


                                            </div>

                                            <form action="{{ route('roomcheckouts.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                {{-- 2nd row checkin detail and select room no                                                          --}}



                                                {{-- 4rd row start for guest Correspondence                              --}}






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

                                                        </div>
                                                    </DIV>






                                                </div>







                                                <div class="card-footer text-center py-3">
                                                    <div class="small">

                                                        <a class= "btn btn-dark  "href={{ url('home') }}>Back</a>
                                                    </div>
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
            <script src="{{ global_asset('/general_assets\js\form.js') }}"></script>
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
                // 
            </script>


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



                                if (response.room_facilities) {
                                    $('#facility').val(response.room_facilities);
                                } else {
                                    $('#facility').val('');
                                }
                                if (response.roomtype) {
                                    $('#room_type').val(response.roomtype.roomtype_name);
                                } else {
                                    $('#room_type').val('');
                                }

                                if (response.room_no) {
                                    $('#room_no').val(response.room_no);
                                } else {
                                    $('#room_no').val('');
                                }
                                if (response.roomtype) {
                                    $('#room_tariff').val(response.roomtype.room_tariff);
                                } else {
                                    $('#room_tariff').val('');
                                }
                                if (response.roomtype) {
                                    $('#room_dis').val(response.roomtype.room_dis);
                                } else {
                                    $('#room_dis').val('');
                                }
                                if (response.roomtype) {
                                    $('#package_name').val(response.roomtype.package.package_name);
                                } else {
                                    $('#package_name').val('');
                                }
                                if (response.roomtype) {
                                    $('#plan_name').val(response.roomtype.package.plan_name);
                                } else {
                                    $('#plan_name').val('');
                                }
                                if (response.roomtype) {
                                    $('#taxname').val(response.roomtype.gstmaster.taxname);
                                } else {
                                    $('#taxname').val('');
                                }
                                if (response.roomtype) {
                                    $('#sgst').val(response.roomtype.gstmaster.sgst);
                                } else {
                                    $('#sgst').val('');
                                }
                                if (response.roomtype) {
                                    $('#cgst').val(response.roomtype.gstmaster.cgst);
                                } else {
                                    $('#cgst').val('');
                                }
                                if (response.roomtype) {
                                    $('#igst').val(response.roomtype.gstmaster.igst);
                                } else {
                                    $('#igst').val('');
                                }
                                if (response.roomtype) {
                                    $('#vat').val(response.roomtype.gstmaster.vat);
                                } else {
                                    $('#vat').val('');
                                }
                                if (response.roomtype) {
                                    $('#tax1').val(response.roomtype.gstmaster.tax1);
                                } else {
                                    $('#tax1').val('');
                                }
                                if (response.roomtype) {
                                    $('#tax2').val(response.roomtype.gstmaster.tax2);
                                } else {
                                    $('#tax2').val('');
                                }
                                if (response.roomtype) {
                                    $('#tax3').val(response.roomtype.gstmaster.tax3);
                                } else {
                                    $('#tax3').val('');
                                }
                                if (response.roomtype) {
                                    $('#tax4').val(response.roomtype.gstmaster.tax4);
                                } else {
                                    $('#tax4').val('');
                                }
                                if (response.roomtype) {
                                    $('#tax5').val(response.roomtype.gstmaster.tax5);
                                } else {
                                    $('#tax5').val('');
                                }

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

                                if (response.customer_info) {
                                    $('#guest_name').val(response.customer_info.account_name);
                                } else {
                                    $('#guest_name').val('');
                                }
                                if (response.customer_info) {
                                    $('#guest_email').val(response.customer_info.email);
                                } else {
                                    $('#guest_email').val('');
                                }
                                if (response.customer_info) {
                                    $('#guest_mobile').val(response.customer_info.mobile);
                                } else {
                                    $('#guest_mobile').val('');
                                }
                                if (response.customer_info) {
                                    $('#guest_address').val(response.customer_info.address);
                                } else {
                                    $('#guest_address').val('');
                                }
                                if (response.customer_info) {
                                    $('#guest_city').val(response.customer_info.city);
                                } else {
                                    $('#guest_city').val('');
                                }
                                if (response.customer_info) {
                                    $('#guest_state').val(response.customer_info.state);
                                } else {
                                    $('#guest_state').val('');
                                }
                                if (response.customer_info) {
                                    $('#guest_contery').val(response.customer_info.nationality);
                                } else {
                                    $('#guest_contery').val('');
                                }
                                if (response.customer_info) {
                                    $('#guest_idproof').val(response.customer_info
                                    .account_idproof_name);
                                } else {
                                    $('#guest_idproof').val('');
                                }
                                if (response.customer_info) {
                                    $('#guest_idproof_no').val(response.customer_info
                                        .account_idproof_no);
                                } else {
                                    $('#guest_idproof_no').val('');
                                }


                                if (response.customer_info) {
                                    $('#guest_pic_response1').val(response.customer_info.account_pic1);
                                } else {
                                    $('#guest_pic_response1').val('');
                                }
                                if (response.customer_info) {
                                    const imageUrl = "{{ asset('storage/account_image/') }}" + '/' +
                                        response.customer_info.account_pic1;
                                    $('#guest_pic_response').attr('src', imageUrl);
                                } else {
                                    $('#guest_pic_response').attr('src',
                                    ''); // or set a default image if desired
                                }
                                if (response.customer_info) {
                                    $('#uploded_id_pic_response').val(response.customer_info
                                        .account_id_pic);
                                    $('#uploded_id_pic_response1').attr('src',
                                        '{{ asset('storage/account_image/') }}/' + response
                                        .customer_info.account_id_pic);
                                } else {
                                    $('#uploded_id_pic_response').val('');
                                    $('#uploded_id_pic_response1').attr('src',
                                        '{{ asset('storage/account_image/default.jpg') }}');
                                }




                                if (response.customer_info) {
                                    $('#gst_no').val(response.customer_info.gst_no);
                                } else {
                                    $('#gst_no').val('');
                                }

                                if (response.message) {
                                    $('#message').html('  ' + response.message + '');
                                } else {
                                    $('#search_results').html(
                                        '<p>No customer found with this contact number.</p>');
                                }
                            },
                            error: function() {
                                $('#search_results').html(
                                    '<p>An error occurred while searching for the customer.</p>');
                            }
                        });
                    });
                });
            </script>
            {{-- this is function  when i select booking no cutomer search is diable  --}}

            <script>
                $(document).ready(function() {
                    $('#roomcheckin_voucher_no').change(function() {
                        if ($(this).val() !== null) {
                            $('#searchinput').prop('readonly', true);
                        } else {
                            $('#searchinput').prop('readonly', false);
                        }
                    });
                });
            </script>
            {{-- Ajex for search roomcheckin Detail --}}
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#roomcheckin_voucher_no').change(function() {
                        var roomcheckin_voucher_no = $(this).val();
                        console.log(roomcheckin_voucher_no);
                        $.ajax({
                            url: '/roomcheckins/' + roomcheckin_voucher_no,
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);



                                // if (response.booking_date)
                                //  {
                                //           $('#booking_date').val(response.booking_date);
                                //  } else {
                                //           $('#booking_date').val('');
                                //         }
                                //         if (response.guest_name)
                                //          {$('#room_type').val(response.guest_name);}
                                //         else {$('#room_type').val('');}       

                                //         if (response.room_no){$('#room_no').val(response.room_no);} 
                                //         else {$('#room_no').val('');}
                                //         if (response.room_tariff){$('#room_tariff').val(response.room_tariff);} 
                                //         else {$('#room_tariff').val('');}
                                //         if (response.room_dis){$('#room_dis').val(response.room_dis);} 
                                //         else {$('#room_dis').val('');}
                                //         if (response.package_name){$('#package_name').val(response.package_name);} 
                                //         else {$('#package_name').val('');}
                                //         if (response.plan_name){$('#plan_name').val(response.plan_name);} 
                                //         else {$('#plan_name').val('');}
                                //         if (response.taxname){$('#taxname').val(response.taxname);} 
                                //         else {$('#taxname').val('');}
                                //         if (response.sgst){$('#sgst').val(response.sgst);} 
                                //         else {$('#sgst').val('');}
                                //         if (response.cgst){$('#cgst').val(response.cgst);} 
                                //         else {$('#cgst').val('');}
                                //         if (response.igst){$('#igst').val(response.igst);} 
                                //         else {$('#igst').val('');}
                                //         if (response.vat){$('#vat').val(response.vat);} 
                                //         else {$('#vat').val('');}
                                //         if (response.tax1){$('#tax1').val(response.tax1);} 
                                //         else {$('#tax1').val('');}
                                //         if (response.tax2){$('#tax2').val(response.tax2);} 
                                //         else {$('#tax2').val('');}
                                //         if (response.tax3){$('#tax3').val(response.tax3);} 
                                //         else {$('#tax3').val('');}
                                //         if (response.tax4){$('#tax4').val(response.tax4);} 
                                //         else {$('#tax4').val('');}
                                //         if (response.tax5){$('#tax5').val(response.tax5);} 
                                //         else {$('#tax5').val('');}
                                //         if (response.guest_name){$('#guest_name').val(response.guest_name);} 
                                //         else {$('#guest_name').val('');}
                                //         if (response.guest_name){$('#guest_email').val(response.guest_email);} 
                                //         else {$('#guest_email').val('');}
                                //         if (response.guest_name){$('#guest_mobile').val(response.guest_mobile);} 
                                //         else {$('#guest_mobile').val('');}
                                //         if (response.guest_name){$('#guest_address').val(response.guest_address);} 
                                //         else {$('#guest_address').val('');}
                                //         if (response.guest_name){$('#guest_city').val(response.guest_city);} 
                                //         else {$('#guest_city').val('');}
                                //         if (response.guest_name){$('#guest_state').val(response.guest_state);} 
                                //         else {$('#guest_state').val('');}
                                //         if (response.guest_name){$('#guest_contery').val(response.guest_contery);} 
                                //         else {$('#guest_contery').val('');}
                                //         if (response.guest_name){$('#guest_idproof').val(response.guest_idproof);} 
                                //         else {$('#guest_idproof').val('');}
                                //         if (response.guest_name){$('#guest_idproof_no').val(response.guest_idproof_no);} 
                                //         else {$('#guest_idproof_no').val('');}
                                //         if (response.guest_name){$('#gst_no').val(response.gst_no);} 
                                //         else {$('#gst_no').val('');}
                                //         if (response.booking_amount){$('#booking_amount').val(response.booking_amount);} 
                                //         else {$('#booking_amount').val('');}
                                //         if (response.guest_id_pic) {
                                //             $('#uploded_id_pic_response1').attr('src', '{{ asset('storage/account_image/') }}/' + response.guest_id_pic);
                                //         } else {
                                //             $('#uploded_id_pic_response1').attr('src', '{{ asset('storage/account_image/default.jpg') }}');
                                //         } 
                                //         if (response.guest_pic) {
                                //           $('#guest_pic_response').attr('src', '{{ asset('storage/account_image/') }}/' + response.guest_pic);
                                //       } else {

                                //           $('#guest_pic_response').attr('src', '{{ asset('storage/account_image/default.jpg') }}');
                                //       } 










                            }


                        });

                    });
                });
            </script>

<script>
    $(document).ready(function() {
        $('#saveForm').on('submit', function(event) {
            // Check if at least one checkbox is selected
            if ($('.room-checkbox:checked').length === 0) {
                event.preventDefault(); // Prevent form submission
                alert("Please select at least one room to proceed.");
            }
        });
    });
</script>


        @endsection
