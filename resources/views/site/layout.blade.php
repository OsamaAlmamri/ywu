<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>اتحاد نساء اليمن</title>
    <!-- Stylesheets -->

    <link href="{{  asset('site/css/bootstrap.css')  }}" rel="stylesheet">
    <!--	<link rel="stylesheet" href="css/bootstrap-rtl.min.css">-->
    <link rel="stylesheet" href="{{  asset('site/css/rtl/bootstrap-rtl.css')  }}">

    <link href="{{asset('site/css/main.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/css/responsive.css')  }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{  asset('site/images/Logo250px.png')  }}" type="image/x-icon">
    <link rel="icon" href="{{  asset('site/images/Logo250px.png')  }}" type="image/x-icon">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Titillium+Web:wght@300;400;600;700;900&display=swap"
        rel="stylesheet">

    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><!--<script src="js/respond.js"></script>--><![endif]-->


</head>

<body>

<div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Main Header-->
    <header class="main-header header-style-one">

        <!-- Header Top -->
        <div class="header-top">
            <div class="auto-container">
                <div class="clearfix">

                    <!-- Top Left -->
                    <div class="top-right pull-right clearfix">

                        <!-- Info List -->
                        <ul class="info-list">
                            <li><span>الخط الساخن:</span><a href="tel:8000999"> 01 8000999</a></li>
                            <!--							<li><span>Email Us:</span><a href="mailto:info@yourcompany.com"> info@yourcompany.com</a></li>-->
                        </ul>

                    </div>

                    <!-- Top Right -->
                    <div class="top-left pull-left clearfix">
                        <!-- Login Nav -->
                        <ul class="login-nav">
                            <li><a href="login.html"> تسجيل الدخول</a></li>
                            <li><a href="register.html">انشاء حساب</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- Header Upper -->
        <div class="header-upper">
            <div class="auto-container">
                <div class="clearfix">

                    <div class="pull-right logo-box">
                        <div class="logo"><a href="index.html">
                                <img width="100" src="{{asset('site/images/Logo250px.png') }}" alt=""
                                                                    title="Bootcamp"></a></div>
                    </div>
                    <div class="nav-outer clearfix">
                        <!--Mobile Navigation Toggler-->
                        <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>
                        <!-- Main Menu -->
                        <nav class="main-menu show navbar-expand-md">
                            <div class="navbar-header">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li class=" @if(Request::segment(1)=='home' or Request::segment(1)=='') current @endif"><a href="{{route('site.home')}}">الرئيسية</a></li>
                                    <li class=" @if(Request::segment(1)=='courses' ) current @endif"><a href="{{route('site.courses')}}">التدريب</a></li>
                                    <li class=" @if(Request::segment(1)=='consultant' ) current @endif"><a href="{{route('site.consultant')}}">الاستشارات</a></li>
                                    <li class=" @if(Request::segment(1)=='women' ) current @endif"><a href="{{route('site.women')}}">قضياء المرأة</a></li>
                                    <li class=" @if(Request::segment(1)=='privacy' ) current @endif"><a href="{{route('site.privacy')}}""> سياية الخصوصية</a> </li>
                                    <li class=" @if(Request::segment(1)=='about' ) current @endif"><a href="{{route('site.about')}}"> عنا</a></li>
                                    <li class=" @if(Request::segment(1)=='concatUs' ) current @endif"><a href="{{route('site.concatUs')}}">تواصل معنا</a></li>
                                    <!--									<li class="current dropdown"><a href="#">الرئيسية</a>-->
                                    <!--										<ul>-->
                                    <!--											<li><a href="index.html">Home Page 01</a></li>-->
                                    <!--											<li><a href="index-2.html">Home Page 02</a></li>-->
                                    <!--											<li><a href="index-3.html">Home Page 03</a></li>-->
                                    <!--										</ul>-->
                                    <!--									</li>-->
                                    <!--									<li class="dropdown"><a href="#">Pages</a>-->
                                    <!--										<ul>-->
                                    <!--											<li><a href="price.html">Pricing</a></li>-->
                                    <!--											<li><a href="login.html">Login</a></li>-->
                                    <!--											<li><a href="register.html">Register</a></li>-->
                                    <!--											<li><a href="privacy.html">Privacy Policy</a></li>-->
                                    <!--											<li><a href="comming-soon.html">Coming Soon</a></li>-->
                                    <!--										</ul>-->
                                    <!--									</li>-->
                                    <!--									<li class="dropdown"><a href="#">Courses</a>-->
                                    <!--                                        <ul>-->
                                    <!--                                            <li><a href="course.html">Courses As Grid</a></li>-->
                                    <!--											<li><a href="course-list.html">Courses As List</a></li>-->
                                    <!--											<li><a href="course-path.html">Course Topics</a></li>-->
                                    <!--											<li><a href="course-lesson.html">Course Lesson</a></li>-->
                                    <!--											<li><a href="course-detail.html">Course Details</a></li>-->
                                    <!--                                        </ul>-->
                                    <!--                                    </li>-->
                                    <!--									<li class="dropdown"><a href="#">Books</a>-->
                                    <!--                                        <ul>-->
                                    <!--                                            <li><a href="books.html">Books</a></li>-->
                                    <!--                                            <li><a href="books-detail.html">Book Detail</a></li>-->
                                    <!--                                        </ul>-->
                                    <!--                                    </li>-->
                                    <!--									<li class="dropdown"><a href="#">Profiles</a>-->
                                    <!--                                        <ul>-->
                                    <!--                                            <li><a href="intro-profile.html">Instructor Profile</a></li>-->
                                    <!--											<li><a href="student-profile.html">Student Profile</a></li>-->
                                    <!--											<li><a href="edit-profile.html">Edit Profile</a></li>-->
                                    <!--                                        </ul>-->
                                    <!--                                    </li>-->
                                    <!--									<li class="dropdown"><a href="#">Blog</a>-->
                                    <!--                                        <ul>-->
                                    <!--                                            <li><a href="blog.html">Blog</a></li>-->
                                    <!--											<li><a href="blog-detail.html">Blog Detail</a></li>-->
                                    <!--											<li><a href="error.html">Not Found / 404</a></li>-->
                                    <!--                                        </ul>-->
                                    <!--                                    </li>-->
                                    <!--									<li class="dropdown"><a href="#">Links</a>-->
                                    <!--                                        <ul>-->
                                    <!--                                            <li><a href="https://www.wikipedia.org">Wikipedia</a></li>-->
                                    <!--											<li><a href="https://www.education.com">Education</a></li>-->
                                    <!--											<li><a href="https://www.theidioms.com">The Idioms</a></li>-->
                                    <!--                                        </ul>-->
                                    <!--                                    </li>-->
                                    <!--									<li><a href="contact.html">Contact Us</a></li>-->
                                </ul>
                            </div>

                        </nav>

                    </div>

                </div>
            </div>
        </div>
        <!-- End Header Upper -->

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-multiply"></span></div>

            <nav class="menu-box">
                <div class="nav-logo"><a href="index.html"><img src="{{asset('site/images/logo-5.png')}}" alt="" title=""></a></div>
                <div class="menu-outer">
                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                </div>
            </nav>
        </div>
        <!-- End Mobile Menu -->

    </header>
    <!-- End Main Header -->

    @yield('content')


    <!--Main Footer-->
    <footer class="main-footer">
        <!-- Pattern Layer -->
        <div class="pattern-layer paroller" data-paroller-factor="0.60" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image:url('{{asset('site/images/icons/icon-1.png')}}')"></div>
        <div class="pattern-layer-two" data-paroller-factor="0.60"
             data-paroller-factor-lg="0.20" data-paroller-type="foreground"
             data-paroller-direction="vertical"
             style="background-image:url('{{asset('site/images/icons/icon-3.png')}}')">
        </div>
        <div class="auto-container">

            <!-- Widgets Section -->
            <div class="widgets-section">
                <div class="row clearfix">

                    <!-- Big Column -->
                    <div class="big-column col-lg-6 col-md-12 col-sm-12">
                        <div class="row clearfix">

                            <!--Footer Column-->
                            <div class="footer-column col-lg-7 col-md-6 col-sm-12">
                                <div class="footer-widget logo-widget">
                                    <div class="logo">
                                        <a href="index.html"><img src="{{asset('site/images/footer-logo.png')}}" alt=""></a>
                                    </div>
                                    <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                        you’re, they’re two waters own morning gathered greater.
                                    </div>
                                    <div class="social-box">
                                        <a href="#" class="fa fa-facebook"></a>
                                        <a href="#" class="fa fa-instagram"></a>
                                        <a href="#" class="fa fa-twitter"></a>
                                        <a href="#" class="fa fa-google"></a>
                                        <a href="#" class="fa fa-pinterest-p"></a>
                                    </div>
                                    <div class="copyright">Copyright &copy; 2020 AuburnForest</div>
                                </div>
                            </div>

                            <!--Footer Column-->
                            <div class="footer-column col-lg-5 col-md-6 col-sm-12">
                                <div class="footer-widget links-widget">
                                    <h4>About Us</h4>
                                    <ul class="links-widget">
                                        <li><a href="#">Afficiates</a></li>
                                        <li><a href="#">Partners</a></li>
                                        <li><a href="#">Reviews</a></li>
                                        <li><a href="#">Blogs</a></li>
                                        <li><a href="#">Newsletter</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Big Column -->
                    <div class="big-column col-lg-6 col-md-12 col-sm-12">
                        <div class="row clearfix">

                            <!--Footer Column-->
                            <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                                <div class="footer-widget links-widget">
                                    <h4>Resource</h4>
                                    <ul class="links-widget">
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="#">Support Area</a></li>
                                        <li><a href="#">Documentations</a></li>
                                        <li><a href="#">How it works</a></li>
                                        <li><a href="#">Terms of Policy</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!--Footer Column-->
                            <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                                <div class="footer-widget links-widget">
                                    <h4>Quick Links</h4>
                                    <ul class="links-widget">
                                        <li><a href="#">home</a></li>
                                        <li><a href="#">About us</a></li>
                                        <li><a href="#">Features</a></li>
                                        <li><a href="#">Pricing</a></li>
                                        <li><a href="#">Contact</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </footer>

</div>
<!--End pagewrapper-->

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-arrow-circle-up"></span></div>




<script src="{!! asset('site/js/jquery.js') !!}"></script>
<script src="{!! asset('site/js/popper.min.js') !!}"></script>
<script src="{!! asset('site/js/jquery.scrollTo.js') !!}"></script>
<script src="{!! asset('site/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('site/js/jquery.mCustomScrollbar.concat.min.js') !!}"></script>
<script src="{!! asset('site/js/jquery.fancybox.js') !!}"></script>
<script src="{!! asset('site/js/appear.js') !!}"></script>
<script src="{!! asset('site/js/swiper.min.js') !!}"></script>
<script src="{!! asset('site/js/element-in-view.js') !!}"></script>
<script src="{!! asset('site/js/jquery.paroller.min.js') !!}"></script>
//form
<script src="{!! asset('site/js/validate.js') !!}"></script>

<script src="{!! asset('site/js/parallax.min.js') !!}"></script>
<script src="{!! asset('site/js/tilt.jquery.min.js') !!}"></script>
<!--Master Slider-->
<script src="{!! asset('site/js/jquery.easing.min.js') !!}"></script>
<script src="{!! asset('site/js/owl.js') !!}"></script>
<script src="{!! asset('site/js/wow.js') !!}"></script>
<script src="{!! asset('site/js/jquery-ui.js') !!}"></script>
<script src="{!! asset('site/js/script.js') !!}"></script>






</body>
</html>
