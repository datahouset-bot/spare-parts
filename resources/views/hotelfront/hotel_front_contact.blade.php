<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>{{ $componyinfo->cominfo_firm_name }}</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ global_asset('hotel_front_assets/css/bootstrap.min.css') }}">
      <!-- style css -->
      <link rel="stylesheet" href="{{ global_asset('hotel_front_assets/css/style.css') }}">

      <!-- Responsive-->
     <link rel="stylesheet" href="{{ global_asset('hotel_front_assets/css/responsive.css') }}">     
      <!-- fevicon -->
      <link rel="icon" href="{{ global_asset('hotel_front_assets/images/fevicon.png') }}" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{global_asset('hotel_front_assets/css/jquery.mCustomScrollbar.min.css')}}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="{{global_asset('hotel_front_assets/images/loading.gif')}}" alt="#"/></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.html"><img src="images/logo.png" alt="#" /></a>
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
      <!-- end header inner -->
      <!-- end header -->
     <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                      <h2>Contact Us</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--  contact -->
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
                           <input class="contactus" placeholder="{{ $componyinfo->cominfo_firm_name }} " type="type" name="Name" readonly> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="{{ $componyinfo->cominfo_email }}" type="type" name="Email"readonly> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="{{ $componyinfo->cominfo_mobile }}" type="type" name="Phone Number" readonly>                          
                        </div>
                        <div class="col-md-12">
                           <textarea class="textarea" placeholder="{{ $componyinfo->cominfo_phone }}" type="type" Message="Name"></textarea>
                        </div>
                        <div class="col-md-12">
                           <!--<button class="send_btn">Send</button>-->
                        </div>
                     </div>
                  </form>
               </div>
               <div class="col-md-6">
                  <div class="map_main">
                     <!--<div class="map-responsive">-->
                     <!--   <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=Eiffel+Tower+Paris+France" width="600" height="400" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>-->
                     <!--</div>-->
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3752.8399879622184!2d77.91773067522497!3d19.846722281523032!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd18098853440bd%3A0xd686c589320a16bd!2sHotel%20MAULI!5e0!3m2!1sen!2sin!4v1727515343852!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
               </div>
            </div>
         </div>
      </div>
            <!-- end contact -->
      <!--  footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class=" col-md-4">
                     <h3>Contact US</h3>
                     <ul class="conta">
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> "{{ $componyinfo->cominfo_address1 }}&nbsp; &nbsp; {{ $componyinfo->cominfo_address2 }}"</li>
                        <li><i class="fa fa-mobile" aria-hidden="true"></i> {{ $componyinfo->cominfo_phone }} &nbsp; {{ $componyinfo->cominfo_mobile }}</li>
                        <li> <i class="fa fa-envelope" aria-hidden="true"></i><a href="#">{{ $componyinfo->cominfo_email }}</a></li>
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
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="{{ global_asset('hotel_front_assets/js/jquery.min.js') }}"></script>
      <script src="{{ global_asset('hotel_front_assets/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ global_asset('hotel_front_assets/js/jquery-3.0.0.min.js') }}"></script>
      <script src="{{ global_asset('hotel_front_assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script src="{{ global_asset('hotel_front_assets/js/custom.js') }}"></script>
     
   </body>
</html>