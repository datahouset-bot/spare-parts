<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>{{ $firm_cominfo->cominfo_firm_name }}</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="stylesheet" href="{{ global_asset('hotel_front_assets/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ global_asset('hotel_front_assets/css/style.css') }}">

     <link rel="stylesheet" href="{{ global_asset('hotel_front_assets/css/responsive.css') }}">     
      <link rel="icon" href="{{ global_asset('hotel_front_assets/images/fevicon.png') }}" type="image/gif" />
      <link rel="stylesheet" href="{{global_asset('hotel_front_assets/css/jquery.mCustomScrollbar.min.css')}}">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   </head>
   <body class="main-layout">
      <div class="loader_bg">
      </div>
      <header>
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <img src="{{ asset('storage\app\public\image\\' . $firm_pic->logo) }}" alt="qr_code"
                                 width="80px">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">
                                 <a class="nav-link" href="{{url($firm_id)}}">Home</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="{{url('/hotel_about',$firm_id)}}">About</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="{{url('/hotel_room',$firm_id)}}">Our room</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="{{url('/hotel_gallery',$firm_id)}}">Gallery</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="{{url('/hotel_blog',$firm_id)}}">Blog</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="{{url('/hotel_contact',$firm_id)}}">Contact Us</a>
                              </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <section class="banner_main">
         <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#myCarousel" data-slide-to="0" class="active"></hotelli>
               <li data-target="#myCarousel" data-slide-to="1"></li>
               <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">

<img class="first-slide" 
     src="{{ asset('storage\app\public\image\\' . $firm_pic->pic_af1) }}" 
     alt="First slide"
     style="width:100%; height:70vh; object-fit:cover;">

                  <div class="container">
                  </div>
               </div>
               <div class="carousel-item">
                  <img class="second-slide" src="{{ asset('storage\app\public\image\\' . $firm_pic->pic_af2) }}" alt="Second slide"      style="width:100%; height:70vh; object-fit:cover;">
               </div>
               <div class="carousel-item">
                  <img class="third-slide" src="{{ asset('storage\app\public\image\\' . $firm_pic->pic_af3) }}" alt="Third slide"      style="width:100%; height:70vh; object-fit:cover;">
               </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
         </div>
         <div class="booking_ocline">
            <div class="container">
               <div class="row">
                  <div class="col-md-5">
                     <div class="book_room">
                        <h1>Book a Room Online</h1>
                        <form class="book_now">
                           <div class="row">
                              
                              <div class="col-md-12">
                                 <a class="book_btn" href="{{url('hotel_room',$firm_id)}}">
                                    &nbsp;&nbsp;&nbsp;Book Now
                              </a>
                              </div>

                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <div class="about">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-5">
                  <div class="titlepage">
                     <h2>About Us</h2>
                     <p>Welcome to {{ $firm_cominfo->cominfo_firm_name }}, where comfort meets elegance. Nestled in the heart of {{ $firm_cominfo->cominfo_city }}, our hotel offers a serene escape with a blend of modern amenities and traditional charm. Since our establishment, we have been dedicated to providing an exceptional experience for all our guests. </p>
                     <a class="read_more" href="Javascript:void(0)"> Read More</a>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="about_img">
                     <figure><img src="{{ asset('storage\app\public\image\\' . $firm_pic->pic_af4) }}" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="contact">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Contact Us</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <form id="request" class="main_form">
                     <div class="row">
                        <div class="col-md-12 ">
                           <input class="contactus" placeholder="{{ $firm_cominfo->cominfo_firm_name }} " type="type" name="Name" readonly> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="{{ $firm_cominfo->cominfo_email }}" type="type" name="Email"readonly> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="{{ $firm_cominfo->cominfo_mobile }}" type="type" name="Phone Number" readonly>                          
                        </div>
                        <div class="col-md-12">
                           <textarea class="textarea" placeholder="{{ $firm_cominfo->cominfo_phone }}" type="type" Message="Name"></textarea>
                        </div>
                        <div class="col-md-12">
                        </div>
                     </div>
                  </form>
               </div>
<div class="col-md-6">

    
    @if(!empty($firm_cominfo->componyinfo_af10))
        @php
            $mapValue = $firm_cominfo->componyinfo_af10;

            // If user mistakenly pasted full Google short link
            if (Str::startsWith($mapValue, 'http')) {
                $mapValue = null; // ignore short links
            }
        @endphp

        @if($mapValue)
            <iframe 
                src="https://www.google.com/maps/embed?pb={{ $mapValue }}" 
                width="600" height="450" 
                style="border:0;" allowfullscreen 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        @endif
    @endif
</div>

            </div>
         </div>
      </div>
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class=" col-md-4">
                     <h3>Contact US</h3>
                     <ul class="conta">
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> "{{ $firm_cominfo->cominfo_address1 }}&nbsp; &nbsp; {{ $firm_cominfo->cominfo_address2 }}"</li>
                        <li><i class="fa fa-mobile" aria-hidden="true"></i> {{ $firm_cominfo->cominfo_phone }} &nbsp; {{ $firm_cominfo->cominfo_mobile }}</li>
                        <li> <i class="fa fa-envelope" aria-hidden="true"></i><a href="#">{{ $firm_cominfo->cominfo_email }}</a></li>
                     </ul>
                  </div>
                  <div class="col-md-4">
                     <h3>Menu Link</h3>
                     <ul class="link_menu">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="about.html"> about</a></li>
                        <li><a href="room.html">Our Room</a></li>
                        <li><a href="gallery.html">Gallery</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                     </ul>
                  </div>
                  <div class="col-md-4">
                     <h3>News letter</h3>
                     <form class="bottom_form">
                        <input class="enter" placeholder="Enter your email" type="text" name="Enter your email">
                        <button class="sub_btn">subscribe</button>
                     </form>
                     <ul class="social_icon">
                        <li><a href="{{$softwarecompinfo->software_facebook}}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="{{$softwarecompinfo->software_twitter}}"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        <li><a href="{{$softwarecompinfo->software_youtube}}"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-10 offset-md-1">
                        
                        <p>
                        ©  {{ now()->format('Y') }} All Rights Reserved. Design by {{$softwarecompinfo->software_firm_name}}  </a>
                        <br><br>
                        Distributed by &nbsp; {{$softwarecompinfo->software_firm_name}}
                        </p>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      
      <script src="{{ global_asset('hotel_front_assets/js/jquery.min.js') }}"></script>
<script src="{{ global_asset('hotel_front_assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ global_asset('hotel_front_assets/js/jquery-3.0.0.min.js') }}"></script>
<script src="{{ global_asset('hotel_front_assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ global_asset('hotel_front_assets/js/custom.js') }}"></script>

      
   </body>
</html>



