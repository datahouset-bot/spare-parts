<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" class="no-js" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Edge Responsive Multipurpose Template</title>
    <meta name="description" content="">
    {{-- <link rel="stylesheet" href="{{ asset('/test.css') }}"> --}}
    {{-- <link href="{{ url('public/assets/test.css') }}" rel="stylesheet"> --}}
    
    
    <link rel="stylesheet" href="{{ global_asset('front_assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" >
    <!-- CSS FILES -->
    {{-- <link rel="stylesheet" href="{{ asset('\front_assets\css\bootstrap.min.css') }}"/> --}}
    <link rel="stylesheet" href="{{ global_asset('front_assets/css/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" href="{{global_asset('/front_assets/css/bootstrap.min.css')}}"/> --}}
     <link rel="stylesheet" href="{{global_asset('/front_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{global_asset('/front_assets/css/flexslider.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{global_asset('/front_assets/css/style.css')}}" media="screen" data-name="skins">
    <link rel="stylesheet" href="{{global_asset('/front_assets/css/layout/wide.css')}}" data-name="layout">

    <link rel="stylesheet" href="{{global_asset('/front_assets/css/animate.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{global_asset('/front_assets/css/switcher.css')}}" media="screen" />
    


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
#navbar{
    display: inline;
}
.youtube-button {
            text-align: center;
            margin: 20px 0;
        }
        
</style>
</head>
<body class="home">

                       





    <header id="header">
        <!-- Start header-top -->
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="hidden-xs col-lg-7 col-sm-5 top-info">
                        {{-- <span><i class="fa fa-phone"></i>Phone:{{$softwarecompinfo->software_mobile}},{{$softwarecompinfo->software_phone}}</span> --}}
                        {{-- <span class="hidden-sm"><i class="fa fa-envelope"></i>Email: {{$softwarecompinfo->software_email}}</span> --}}
                    </div>
                    <div class="col-lg-5 col-sm-7 top-info clearfix">
                        <ul>

                            @guest

                            @if (Route::has('login'))
                                <a class="btn btn-danger"  href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif
                            
                            @if (Route::has('register'))
                                    <a class="btn btn-success" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif

                            @else
                            {{-- <li class="nav-item dropdown"> --}}
                                {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{route('home')}}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> --}}
                                    <a href="{{ route('home') }}" class = "btn btn-warning"> 
                                    {{ Auth::user()->name }} -Go To  Dashboard 
                                </a>

                                {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> --}}
                                    <a class=" btn btn-primary dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                
                            {{-- </li> --}}



                            @endguest


                        
                            <li><a class="my-facebook" href="{{$softwarecompinfo->software_facebook}}"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="my-tweet" href="{{$softwarecompinfo->software_youtube}}"><i class="fa fa-youtube"></i></a></li>
                            <li><a class="my-pint" href="{{$softwarecompinfo->software_af1}}"><i class="fa fa-pinterest"></i></a></li>
                            <li><a class="my-rss" href="{{$softwarecompinfo->software_af2}}"><i class="fa fa-rss"></i></a></li>
                            <li><a class="my-skype" href="{{$softwarecompinfo->software_af3}}"><i class="fa fa-skype"></i></a></li>
                            <li><a class="my-google" href="{{$softwarecompinfo->software_af4}}"><i class="fa fa-google-plus"></i></a></li>
                            <li><a class="my-rss" href="{{$softwarecompinfo->software_af5}}"><i class="fa fa-eye"></i></a></li>
                            <li><a class="my-skype" href="{{$softwarecompinfo->software_af6}}"><i class="fa fa-edit"></i></a></li>
                            <li><a class="my-google" href="{{$softwarecompinfo->software_af7}}"><i class="fa fa-print"></i></a></li>
                            <li>
                                <form class="search-bar">
                                    <label for="search" class="search-label">
                                        <button class="search-button"><i class="fa fa-search"></i></button><!-- Fix the break-row-bug
                                        --><input type="text" id="search" class="search-input" />
                                    </label>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </header>
<!--End Header-->

<section class="wrapper">
<!--start info service-->
    <section class="info_service">
        <div class="container">
            <div class="row sub_content">
                <div class="col-lg-12 col-md-12 col-sm-12 wow fadeInDown">
                    <h1 class="intro text-center">"{{$softwarecompinfo->software_firm_name}}: A Complete Solution for Hotel Management"
                    </h1>
                    <p class="lead text-center">"{{$softwarecompinfo->software_firm_name}} Hotel ERP offers comprehensive, easy-to-use management solutions for hotels, enhancing operations, improving guest experience, and streamlining processes for efficient and effective hotel management."</p>
                </div>
                <div class="rs_box  wow bounceInRight" data-wow-offset="200">
                    <div class="col-sm-6 col-lg-3">
                        <div class="serviceBox_3">
                            <div class="service-icon">
                                <i class="fa fa-bed"></i>
                            </div>
                            <h3>Room Tracking </h3>
                            <p>"Room tracking ensures real-time updates on room status, availability, occupancy, and maintenance, enhancing efficiency and guest satisfaction."</p>
                            <a class="read" href="#">Read more</a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="serviceBox_3">
                            <div class="service-icon">
                                <i class="fa fa-bell"></i>
                            </div>
                            <h3>Room Service </h3>
                            <p>"Room service provides guests with convenient in-room dining, enhancing their stay with prompt delivery of food and beverages."</p>
                            <a class="read" href="#">Read more</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="serviceBox_3">
                            <div class="service-icon">
                                <i class="fa fa-money"></i>
                            </div>
                            <h3>Fund Flow </h3>
                            <p>"Fund flow tracks the movement of financial resources, ensuring efficient allocation, optimizing cash management, and improving financial planning and analysis."</p>
                            <a class="read" href="#">Read more</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="serviceBox_3">
                            <div class="service-icon">
                                <i class="fa fa-table"></i>
                            </div>
                            <h3>Hotel Analytics</h3>
                            <p>"Hotel analytics provides detailed insights into performance metrics, guest behaviors, booking trends, and financial data, optimizing decision-making and operational efficiency."</p>
                            <a class="read" href="#">Read more</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
<!--end info service-->

<!--Start recent work-->
    <section class="latest_work">
        <div class="container">
            <div class="row sub_content">
                <div class="carousel-intro">
                    <div class="col-md-12">
                        <div class="dividerHeading">
                            <h4><span>Recent Work</span></h4>
                        </div>
                        <div class="carousel-navi">
                            <div id="work-prev" class="arrow-left jcarousel-prev"><i class="fa fa-angle-left"></i></div>
                            <div id="work-next" class="arrow-right jcarousel-next"><i class="fa fa-angle-right"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="jcarousel recent-work-jc">
                    <ul class="jcarousel-list">
                        <!-- Recent Work Item -->
                        <li class="col-sm-3 col-md-3 col-lg-3">
                            <figure class="touching effect-bubba">
                                <img src="images/portfolio/portfolio_1.png" alt="" class="img-responsive">

                                <div class="option">
                                    <a href="portfolio_single.html" class="fa fa-link"></a>
                                    <a href="images/portfolio/portfolio_1.png" class="fa fa-search mfp-image"></a>
                                </div>
                                <figcaption class="item-description">
                                    <h5>Touch and Swipe</h5>
                                    <p>Technology</p>
                                </figcaption>
                            </figure>
                        </li>

                        <!-- Recent Work Item -->
                        <li class="col-sm-3 col-md-3 col-lg-3">
                            <figure class="touching effect-bubba">
                                <img src="images/portfolio/portfolio_2.png" alt="" class="img-responsive">

                                <div class="option">
                                    <a href="portfolio_single.html" class="fa fa-link"></a>
                                    <a href="images/portfolio/portfolio_2.png" class="fa fa-search mfp-image"></a>
                                </div>
                                <figcaption class="item-description">
                                    <h5>Touch and Swipe</h5>
                                    <p>Technology</p>
                                </figcaption>
                            </figure>
                        </li>

                        <!-- Recent Work Item -->
                        <li class="col-sm-3 col-md-3 col-lg-3">
                            <figure class="touching effect-bubba">
                                <img src="images/portfolio/portfolio_3.png" alt="" class="img-responsive">

                                <div class="option">
                                    <a href="portfolio_single.html" class="fa fa-link"></a>
                                    <a href="images/portfolio/portfolio_3.png" class="fa fa-search mfp-image"></a>
                                </div>
                                <figcaption class="item-description">
                                    <h5>Touch and Swipe</h5>
                                    <p>Technology</p>
                                </figcaption>
                            </figure>
                        </li>

                        <!-- Recent Work Item -->
                        <li class="col-sm-3 col-md-3 col-lg-3">
                            <figure class="touching effect-bubba">
                                <img src="images/portfolio/portfolio_4.png" alt="" class="img-responsive">

                                <div class="option">
                                    <a href="portfolio_single.html" class="fa fa-link"></a>
                                    <a href="images/portfolio/portfolio_4.png" class="fa fa-search mfp-image"></a>
                                </div>
                                <figcaption class="item-description">
                                    <h5>Touch and Swipe</h5>
                                    <p>Technology</p>
                                </figcaption>
                            </figure>
                        </li>

                        <!-- Recent Work Item -->
                        <li class="col-sm-3 col-md-3 col-lg-3">
                            <figure class="touching effect-bubba">
                                <img src="images/portfolio/portfolio_5.png" alt="" class="img-responsive">

                                <div class="option">
                                    <a href="portfolio_single.html" class="fa fa-link"></a>
                                    <a href="images/portfolio/portfolio_5.png" class="fa fa-search mfp-image"></a>
                                </div>
                                <figcaption class="item-description">
                                    <h5>Touch and Swipe</h5>
                                    <p>Technology</p>
                                </figcaption>
                            </figure>
                        </li>

                        <!-- Recent Work Item -->
                        <li class="col-sm-3 col-md-3 col-lg-3">
                            <figure class="touching effect-bubba">
                                <img src="images/portfolio/portfolio_6.png" alt="" class="img-responsive">

                                <div class="option">
                                    <a href="portfolio_single.html" class="fa fa-link"></a>
                                    <a href="images/portfolio/portfolio_6.png" class="fa fa-search mfp-image"></a>
                                </div>
                                <figcaption class="item-description">
                                    <h5>Touch and Swipe</h5>
                                    <p>Technology</p>
                                </figcaption>
                            </figure>
                        </li>

                        <!-- Recent Work Item -->
                        <li class="col-sm-3 col-md-3 col-lg-3">
                            <figure class="touching effect-bubba">
                                <img src="images/portfolio/portfolio_7.png" alt="" class="img-responsive">

                                <div class="option">
                                    <a href="portfolio_single.html" class="fa fa-link"></a>
                                    <a href="images/portfolio/portfolio_7.png" class="fa fa-search mfp-image"></a>
                                </div>
                                <figcaption class="item-description">
                                    <h5>Touch and Swipe</h5>
                                    <p>Technology</p>
                                </figcaption>
                            </figure>
                        </li>

                        <!-- Recent Work Item -->
                        <li class="col-sm-3 col-md-3 col-lg-3">
                            <figure class="touching effect-bubba">
                                <img src="images/portfolio/portfolio_8.png" alt="" class="img-responsive">

                                <div class="option">
                                    <a href="portfolio_single.html" class="fa fa-link"></a>
                                    <a href="images/portfolio/portfolio_8.png" class="fa fa-search mfp-image"></a>
                                </div>
                                <figcaption class="item-description">
                                    <h5>Touch and Swipe</h5>
                                    <p>Technology</p>
                                </figcaption>
                            </figure>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<!--Start recent work-->

<!-- Parallax with Testimonial -->
    <section class="parallax parallax-1">
        <div class="container">
            <!--<h2 class="center">Testimonials</h2>-->
            <div class="row">
                <div id="parallax-testimonial-carousel" class="parallax-testimonial carousel wow fadeInUp">
                    <div class="carousel-inner">
                        {{-- <div class="active item">
                            <div class="parallax-testimonial-item">
                                <blockquote>
                                    <p>Donec convallis, metus nec tempus aliquet, nunc metus adipiscing leo, a lobortis nisi dui ut odio. Nullam ultrices, eros accumsan vulputate faucibus, turpis tortor dictum.</p>
                                </blockquote>
                                <p>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </p>
                                <div class="parallax-testimonial-review">
                                    <img src="images/testimonials/1.png" alt="testimonial">
                                    <span>Jonathan Dower</span>
                                    <small>Company Inc.</small>
                                </div>
                            </div>
                        </div> --}}

                        <div class="item">
                            <div class="parallax-testimonial-item">
                                <blockquote>
                                    <p>Metus aliquet tincidunt metus, sit amet mattis lectus sodales ac. Suspendisse rhoncus dictum eros, ut egestas eros luctus eget. Nam nibh sem, mattis et feugiat ut, porttitor nec risus.</p>
                                </blockquote>
                                <p>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </p>
                                <div class="parallax-testimonial-review">
                                    <img src="images/testimonials/2.png" alt="testimonial">
                                    <span>Jonathan Dower</span>
                                    <small>Leopard</small>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="parallax-testimonial-item">
                                <blockquote>
                                    <p>Nunc aliquet tincidunt metus, sit amet mattis lectus sodales ac. Suspendisse rhoncus dictum eros, ut egestas eros luctus eget. Nam nibh sem, mattis et feugiat ut, porttitor nec risus.</p>
                                </blockquote>
                                <p>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </p>
                                <div class="parallax-testimonial-review">
                                    <img src="images/testimonials/3.png" alt="testimonial">
                                    <span>Jonathan Dower</span>
                                    <small>Leopard</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ol class="carousel-indicators">
                        <li data-slide-to="0" data-target="#parallax-testimonial-carousel" class=""></li>
                        <li data-slide-to="1" data-target="#parallax-testimonial-carousel" class="active"></li>
                        <li data-slide-to="2" data-target="#parallax-testimonial-carousel" class=""></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
<!-- end : Parallax with Testimonial -->

    <section class="feature_bottom">
        <div class="container">
            <div class="row sub_content">
                <div class="col-lg-6  wow slideInLeft" data-wow-duration="1s">
                    <div class="dividerHeading">
                        <h4><span>Why Choose Us?</span></h4>
                    </div>
                    <p>"Choose {{$softwarecompinfo->software_firm_name}} Hotel ERP for seamless management and unmatched efficiency. Our system offers intuitive interfaces, real-time analytics, and customizable features to streamline operations and enhance guest satisfaction. Experience the future of hospitality management with us!"</p>
                    <ul class="list_style circle">
                        <li><a href="#"> Comprehensive Features</a></li>
                        <li><a href="#"> User-Friendly Interface</a></li>
                        <li><a href="#"> Real-Time Analytics</a></li>
                        <li><a href="#"> Customizable Solutions</a></li>
                        <li><a href="#"> Exceptional Support</a></li>
                    </ul>
                </div>

                <!-- TESTIMONIALS -->
                <div class="col-lg-6 wow slideInRight" data-wow-duration="1s">
                    <div class="dividerHeading">
                        <h4><span>What Client's Say</span></h4>
                    </div>

                    <ul class="progress-skill-bar mrg-0">
                        <li>
                            <span class="lable">80%</span>
                            <div class="progress_skill">
                                <div data-height="100" role="progressbar" data-value="70" class="bar" style="width: 0px; height: 0px;">
                                        Easy To Use
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="lable">93%</span>
                            <div class="progress_skill">
                                <div data-height="100" role="progressbar" data-value="80" class="bar" style="width: 0px; height: 0px;">
                                    Fully Responsive Across All Devices
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="lable">99%</span>
                            <div class="progress_skill">
                                <div data-height="100" role="progressbar" data-value="90" class="bar" style="width: 0px; height: 0px;">
                                    Simple and Reliable
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="lable">86%</span>
                            <div class="progress_skill">
                                <div data-height="100" role="progressbar" data-value="80" class="bar" style="width: 0px; height: 0px;">
                                    Optimal Print Format and Reporting
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="lable">89%</span>
                            <div class="progress_skill">
                                <div data-height="100" role="progressbar" data-value="70" class="bar" style="width: 0px; height: 0px;">
                                Best Support 
                                </div>
                            </div>
                        </li>
                    </ul>
                </div><!-- TESTIMONIALS END -->
            </div>
        </div>
    </section>

    <section class="team">
        <div class="container">
            <div class="row  sub_content">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="dividerHeading">
                        <h4><span>Meet the Team</span></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="our-team">
                        <div class="pic">
                            <img src="images/teams/1.png" alt="profile img">
                            <div class="social_media_team">
                                <ul class="team_social">
                                    <li><a class="fb" href="#." data-placement="top" data-toggle="tooltip" title="Facbook"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="twtr" href="#." data-placement="top" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="gmail" href="#." data-placement="top" data-toggle="tooltip" title="Google"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team_prof">
                            <h3 class="names">Hariom <small>Manager </small></h3>
                            <p class="description">Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commo, magnase quis lacinia ornare, quam ante aliqua nisi, eu iaculis leo purus venenatis scelerisque. </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="our-team">
                        <div class="pic">
                            <img src="images/teams/2.png" alt="profile img">
                            <div class="social_media_team">
                                <ul class="team_social">
                                    <li><a class="fb" href="#." data-placement="top" data-toggle="tooltip" title="Facbook"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="twtr" href="#." data-placement="top" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="gmail" href="#." data-placement="top" data-toggle="tooltip" title="Google"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team_prof">
                            <h3 class="names">Pankaj<small>Web Developer</small></h3>
                            <p class="description">Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commo, magnase quis lacinia ornare, quam ante aliqua nisi, eu iaculis leo purus venenatis scelerisque. </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="our-team">
                        <div class="pic">
                            <img src="images/teams/3.png" alt="profile img">
                            <div class="social_media_team">
                                <ul class="team_social">
                                    <li><a class="fb" href="#." data-placement="top" data-toggle="tooltip" title="Facbook"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="twtr" href="#." data-placement="top" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="gmail" href="#." data-placement="top" data-toggle="tooltip" title="Google"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team_prof">
                            <h3 class="names">Reshma<small>Web Desginer</small></h3>
                            <p class="description">Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commo, magnase quis lacinia ornare, quam ante aliqua nisi, eu iaculis leo purus venenatis scelerisque. </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="our-team">
                        <div class="pic">
                            <img src="images/teams/4.png" alt="profile img">
                            <div class="social_media_team">
                                <ul class="team_social">
                                    <li><a class="fb" href="#." data-placement="top" data-toggle="tooltip" title="Facbook"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="twtr" href="#." data-placement="top" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="gmail" href="#." data-placement="top" data-toggle="tooltip" title="Google"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="team_prof">
                            <h3 class="names">Sonali<small>Web Developer</small></h3>
                            <p class="description">Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commo, magnase quis lacinia ornare, quam ante aliqua nisi, eu iaculis leo purus venenatis scelerisque. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="clients">
        <div class="container">
            <div class="row sub_content">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="dividerHeading">
                        <h4><span>Our Clients</span></h4>

                    </div>

                    <div class="our_clients">
                        <ul class="client_items clearfix">
                            <li class="col-sm-3 col-md-3 col-lg-3"><a href="services.html"  data-placement="bottom" data-toggle="tooltip" title="Client 1" ><img src="images/clients/1.png" alt="" /></a></li>
                            <li class="col-sm-3 col-md-3 col-lg-3"><a href="services.html" data-placement="bottom" data-toggle="tooltip" title="Client 2" ><img src="images/clients/2.png" alt="" /></a></li>
                            <li class="col-sm-3 col-md-3 col-lg-3"><a href="services.html" data-placement="bottom" data-toggle="tooltip" title="Client 3" ><img src="images/clients/3.png" alt="" /></a></li>
                            <li class="col-sm-3 col-md-3 col-lg-3"><a href="services.html" data-placement="bottom" data-toggle="tooltip" title="Client 4" ><img src="images/clients/4.png" alt="" /></a></li>
                        </ul><!--/ .client_items-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="promo_box wow bounceInUp" data-wow-offset="50">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-9 col-lg-9">
                    <div class="promo_content">
                        <h3>Best Software For Hotel Business .</h3>
                        <p>{{$softwarecompinfo->software_firm_name}} Hotel ERP: The ultimate software solution for hotel businesses, offering comprehensive features, real-time analytics, and exceptional support to streamline operations and elevate guest satisfaction </p>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3">
                    {{-- <div class="pb_action">
                        <a class="btn btn-lg btn-default" href="#fakelink">
                            <i class="fa fa-youtube"></i>
                            Watch Demo 
                        </a>
                    </div> --}}
                    <div class="youtube-button">
                        <script src="https://apis.google.com/js/platform.js"></script>
                        <div class="g-ytsubscribe" data-channelid="UCArw9uq7lQNVMyWSLO9XzuQ" data-layout="full" data-count="default"></div>
                    </div>
                
                </div>
            </div>
        </div>
    </section>
</section><!--end wrapper-->

<!--start footer-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="widget_title">
                    <h4><span>About Us</span></h4>
                </div>
                <div class="widget_content">
                    <p>Welcome to {{$softwarecompinfo->software_firm_name}} ERP, where we revolutionize hotel management with our cutting-edge Hotel ERP system. At {{$softwarecompinfo->software_firm_name}}, we understand the complexities and challenges that come with running a successful hotel. That’s why we’ve developed a comprehensive solution designed to streamline operations, enhance guest experiences, and maximize efficiency.</p>
                    <ul class="contact-details-alt">
                        <li><i class="fa fa-map-marker"></i> <p><strong>Address</strong>: {{$softwarecompinfo->software_address1}}&nbsp;{{$softwarecompinfo->software_address2}}&nbsp;{{$softwarecompinfo->software_city}}&nbsp;{{$softwarecompinfo->software_state}}&nbsp;{{$softwarecompinfo->software_pincode}}</p></li>
                        <li><i class="fa fa-user"></i> <p><strong>Phone</strong>:{{$softwarecompinfo->software_mobile}}</p></li>
                        <li><i class="fa fa-envelope"></i> <p><strong>Email</strong>: <a href="#">{{$softwarecompinfo->software_email}}</a></p></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="widget_title">
                    <h4><span>Recent Posts</span></h4>
                </div>
                <div class="widget_content">
                    <ul class="links">
                        <li> <a href="#">Aenean commodo ligula eget dolor<span>November 07, 2020</span></a></li>
                        <li> <a href="#">Temporibus autem quibusdam <span>November 05, 2020</span></a></li>
                        <li> <a href="#">Debitis aut rerum saepe <span>November 03, 2020</span></a></li>
                        <li> <a href="#">Et voluptates repudiandae <span>November 02, 2020</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="widget_title">
                    <h4><span>Twitter</span></h4>

                </div>
                <div class="widget_content">
                    <ul class="tweet_list">
                        <li class="tweet_content item">
                            <p class="tweet_link"><a href="#">@yahooobaba </a> Lorem ipsum dolor et, consectetur adipiscing eli</p>
                            <span class="time">29 September 2020</span>
                        </li>
                        <li class="tweet_content item">
                            <p class="tweet_link"><a href="#">@yahooobaba </a> Lorem ipsum dolor et, consectetur adipiscing eli</p>
                            <span class="time">29 September 2020</span>
                        </li>
                        <li class="tweet_content item">
                            <p class="tweet_link"><a href="#">@yahooobaba </a> Lorem ipsum dolor et, consectetur adipiscing eli</p>
                            <span class="time">29 September 2020</span>
                        </li>
                    </ul>
                </div>
                <div class="widget_content">
                    <div class="tweet_go"></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="widget_title">
                    <h4><span>Flickr Gallery</span></h4>
                </div>
                <div class="widget_content">
                    <div class="flickr">
                        <ul id="flickrFeed" class="flickr-feed"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--end footer-->

<section class="footer_bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <p class="copyright">&copy; Copyright 202-254 | Powered by  <a href="https://www.yahoobaba.net/">{{$softwarecompinfo->software_firm_name}} ERP </a></p>
            </div>

            <div class="col-sm-6 ">
                <div class="footer_social">
                    <ul class="footbot_social">
                        <li><a class="fb" href="#." data-placement="top" data-toggle="tooltip" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a class="twtr" href="#." data-placement="top" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a class="dribbble" href="#." data-placement="top" data-toggle="tooltip" title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
                        <li><a class="skype" href="#." data-placement="top" data-toggle="tooltip" title="Skype"><i class="fa fa-skype"></i></a></li>
                        <li><a class="rss" href="#." data-placement="top" data-toggle="tooltip" title="RSS"><i class="fa fa-rss"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery-1.10.2.min.js')}}"></script>
<script src="{{global_asset('/front_assets/js/bootstrap.min.js')}}"></script>
<script src="{{global_asset('/front_assets/js/jquery.easing.1.3.js')}}"></script>
<script src="{{global_asset('/front_assets/js/retina-1.1.0.min.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery.cookie.js')}}"></script> <!-- jQuery cookie -->
{{-- <script type="text/javascript" src="{{global_asset('/front_assets/js/styleswitch.js')}}"></script> <!-- Style Colors Switcher --> --}}
<!--
<script src="js/jquery.fractionslider.js" type="text/javascript" charset="utf-8"></script>
-->
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery.smartmenus.min.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery.smartmenus.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery.jcarousel.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jflickrfeed.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery.magnific-popup.min.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery.isotope.min.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/swipe.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery-scrolltofixed-min.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery-scrolltofixed-min.js')}}"></script>
<script type="text/javascript" src="{{global_asset('/front_assets/js/jquery.flexslider-min.js')}}"></script>

<script src="{{global_asset('/front_assets/js/main.js')}}"></script>

<!-- Start Style Switcher -->
<div class="switcher"></div>
<!-- End Style Switcher -->
    <script>
        $('.flexslider.top_slider').flexslider({
            animation: "fade",
            controlNav: false,
            directionNav: true,
            prevText: "&larr;",
            nextText: "&rarr;"
        });
    </script>

    <!-- WARNING: Wow.js doesn't work in IE 9 or less -->
    <!--[if gte IE 9 | !IE ]><!-->
        <script type="text/javascript" src="/front_assets/js/wow.min.js"></script>
        <script>
            // WOW Animation
            new WOW().init();
        </script>
    <![endif]-->

</body>
