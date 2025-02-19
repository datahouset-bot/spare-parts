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
      <title>keto</title>
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout inner_page">
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
                                 <a class="nav-link" href="{{url('/hotel_blog',$firm_id)}}">Food </a>
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
                      <h2>Food</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- blog -->

      <div class="gallery-container">
    <button class="nav-btn prev-btn">&lt;</button>
    <div class="gallery-wrapper">
        <div class="gallery">
            @foreach ($itemdata as $record)
            <div class="gallery-item">
                @if ($record->item_image)
                <img 
                   src="{{ asset('storage\app\public\account_image\\' . $record->item_image) }}" 
                    alt="{{ $record->item_image }}" 
                
                    class="gallery-img">
                @else
                <div class="placeholder">No Image</div>
                @endif
                <span class="item-name">{{ $record->item_group }}</span><br>
                <span class="item-name">{{ $record->item_name }}-{{ $record->mrp }}/-</span>
            </div>
            @endforeach
        </div>
    </div>
    <button class="nav-btn next-btn">&gt;</button>
</div>

<style>
    /* Container styling */
    .gallery-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        width: 80%;
        margin: auto;
        overflow: hidden;
    }

    /* Wrapper ensures items stay in a single row */
    .gallery-wrapper {
        overflow: hidden;
        width: 100%;
    }

    /* Gallery styling */
    .gallery {
        display: flex;
        transition: transform 0.5s ease-in-out;
        gap: 20px;
    }

    /* Individual items */
    .gallery-item {
        flex: 0 0 calc(33.33% - 20px); /* 3 items visible */
        text-align: center;
    }

    .gallery-img {
        width: 100%;
        max-height: 200px;
        border-radius: 8px;
    }

    .placeholder {
        width: 100%;
        height: 150px;
        background: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 16px;
        color: #555;
    }

    .item-name {
        margin-top: 10px;
        font-size: 14px;
        color: #333;
    }

    /* Navigation buttons */
    .nav-btn {
        background-color: #555;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 18px;
        border-radius: 5px;
        cursor: pointer;
        user-select: none;
        transition: background-color 0.3s;
    }

    .nav-btn:hover {
        background-color: #333;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const gallery = document.querySelector('.gallery');
        const items = document.querySelectorAll('.gallery-item');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');

        const itemsToShow = 3; // Number of visible items
        const itemWidth = items[0].clientWidth + 20; // Item width + gap
        let currentIndex = 0;

        function updateGalleryPosition() {
            const offset = currentIndex * itemWidth;
            gallery.style.transform = `translateX(-${offset}px)`;
        }

        prevBtn.addEventListener('click', function () {
            if (currentIndex > 0) {
                currentIndex--;
                updateGalleryPosition();
            }
        });

        nextBtn.addEventListener('click', function () {
            if (currentIndex < items.length - itemsToShow) {
                currentIndex++;
                updateGalleryPosition();
            }
        });
    });
</script>


              
      <!-- end blog -->
     
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