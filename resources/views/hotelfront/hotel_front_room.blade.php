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
    <link rel="stylesheet" href="{{ global_asset('hotel_front_assets/css/jquery.mCustomScrollbar.min.css') }}">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="{{ global_asset('hotel_front_assets/images/loading.gif') }}" alt="#" />
        </div>
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
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false"
                                aria-label="Toggle navigation">
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
                        <h2>Our Room</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- our_room -->


    <div class="our_room1 ">
      <div class="container">
          <div class="titlepage">
              <p class="margin_0">Explore our exquisite accommodations for comfort and luxury.</p>
          </div>
          <div class="row">
            <div class="container">
               <div class="row">
                  <div class="container">
                     <div class="row">
                         @foreach ($data3 as $record3)
                             <div class="col-md-4 mb-4">
                                 <div class="card">
                                     <div class="row no-gutters">
                                         <!-- First image - 50% width and full height -->
                                         <div class="col-6">
                                             <a href="{{ asset('storage\app\public\room_image\\'.$record3->room_image1) }}" data-fancybox="gallery" data-caption="{{ $record3->description }}">
                                                 <img class="img-fluid" src="{{ asset('storage\app\public\room_image\\'.$record3->room_image1) }}" alt="Room image" style="height: 200px; object-fit: cover; width: 100%;">
                                             </a>
                                         </div>
                                         <!-- Container for second and third images -->
                                         <div class="col-6 d-flex flex-column">
                                             <!-- Second image - Half width and half height -->
                                             <a href="{{ asset('storage\app\public\room_image\\'.$record3->room_image2) }}" data-fancybox="gallery" data-caption="{{ $record3->description }}" class="mb-1">
                                                 <img class="img-fluid" src="{{ asset('storage\app\public\room_image\\'.$record3->room_image2) }}" alt="Room image" style="height: 98px; object-fit: cover; width: 100%;">
                                             </a>
                                             <!-- Third image - Half width and half height -->
                                             <a href="{{ asset('storage\app\public\room_image\\'.$record3->room_image3) }}" data-fancybox="gallery" data-caption="{{ $record3->description }}">
                                                 <img class="img-fluid" src="{{ asset('storage\app\public\room_image\\'.$record3->room_image3) }}" alt="Room image" style="height: 98px; object-fit: cover; width: 100%;">
                                             </a>
                                         </div>
                                     </div>
                                     <div class="card-body">
                                         <h1 class="card-title"> Room No {{ $record3->room_no }} </h1>
                                         <p class="card-text">{{ $record3->roomtype->roomtype_name ?? 'N/A' }}&nbsp;{{ $record3->room_facilities }}</p>
                                         <a href="{{ url('booking_by_guest_create',$firm_id) }}" class="btn btn-danger">Book Now</a>
                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>
                 
                 <!-- Include Fancybox for image zooming -->
                 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
                            
          </div>
      </div>
  </div>

    <!--  footer -->
    <footer>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class=" col-md-4">
                        <h3>Contact US</h3>
                        <ul class="conta">
                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> Address</li>
                            <li><i class="fa fa-mobile" aria-hidden="true"></i> +01 1234569540</li>
                            <li> <i class="fa fa-envelope" aria-hidden="true"></i><a href="#">
                                    demo@gmail.com</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3>Menu Link</h3>
                        <ul class="link_menu">
                            <li><a href="#">Home</a></li>
                            <li><a href="about.html"> about</a></li>
                            <li class="active"><a href="room.html">Our Room</a></li>
                            <li><a href="gallery.html">Gallery</a></li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3>News letter</h3>
                        <form class="bottom_form">
                            <input class="enter" placeholder="Enter your email" type="text"
                                name="Enter your email">
                            <button class="sub_btn">subscribe</button>
                        </form>
                        <ul class="social_icon">
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <p>
                                © 2019 All Rights Reserved. Design by <a href="https://html.design/"> Free Html
                                    Templates</a>
                                <br><br>
                                Distributed by <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
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
