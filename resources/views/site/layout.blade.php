<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> YemenWe</title>
    <!-- Stylesheets -->

    <link href="{{  asset('site/css/bootstrap.min.css')  }}" rel="stylesheet">
    {{--    <!--	<link rel="stylesheet" href="css/bootstrap-rtl.min.css">-->--}}
    <link rel="stylesheet" href="{{  asset('site/css/rtl/bootstrap-rtl.css')  }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <link href="{{asset('site/css/main5.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/css/responsive.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/css/mcq.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/vue/loading2.css')  }}" rel="stylesheet">
    {{--    <link href="{{  asset('css/app.css')  }}" rel="stylesheet">--}}
    <link href="{{  asset('css/toastr.css')  }}" rel="stylesheet">

    <meta name="theme-color" content="#593c97">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#593c97">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#00ab15">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
    <link rel="shortcut icon" href="{{  asset('site/images/logo_white.png')  }}" type="image/x-icon">
    <link rel="icon" href="{{  asset('site/images/logo_white.png')  }}" type="image/x-icon">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Titillium+Web:wght@300;400;600;700;900&display=swap"
        rel="stylesheet">
    <link href="{!! asset('newLibs\lightbox2\css\lightbox.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <link href="{{asset('site/css/osama3.css')  }}" rel="stylesheet">

    <style>
        .search-box button {
            margin-top: 0;
        }

        .wrapper {
            height: 130px;
        }

        .image_box img:not(.zoomImage) {

            height: 130px;
            width: 150px;
        }

        .lower-content h6:first-child {
            text-align: center;
            font-size: 14px;
        }

        .cource-block-two .inner-box .lower-content {
            position: relative;
            padding: 5px 6px;
            font-size: 0.875rem;
        }

        .product_price_box {
            font-size: 9px;
            color: black;
        }

        .product_name_box {
            font-size: 9px;
            font-weight: 600;
        }

        .inner_currancy {
            font-size: 11px;
        }

        .multiselect__option, .multiselect__tag {

            font-size: 9px;
        }

        .page-title h1 {
            padding-bottom: 5px;
            margin-top: -20px;
        }

        .like_product_button {
            margin-top: -127px;
        }

        .product_countainer {

            box-shadow: 0 3px 7px 0 rgba(0, 0, 0, 0.5);
        }


        .one_seller_box {
            margin-right: -30px;
            margin-left: -30px;
            font-size: 13px;
            border: 1px solid;
            margin-bottom: 5px;

        }

        /*.cource-block-two .wrapper*/
        /*{*/
        /*    height: 200px;*/
        /*}*/
        /*.cource-block-two .divClass*/
        /*{*/
        /*    height: 163px;*/
        /*}*/
        select.form-control:not([size]):not([multiple]) {
            height: auto;
        }
        .profile-form .form-group input[type="text"],
        .profile-form .form-group input[type="password"], .profile-form .form-group input[type="tel"],
        .profile-form .form-group input[type="email"], .profile-form .form-group select {
            border-radius: 5px;
            background: #f5f0ff;
        }
        .sweet-content-content
        {
            width: 100%;
        }

        .table {
            width: 100%;
            overflow-y: scroll;
        }
        .one_seller_box .table
        {
            font-size:10px;
        }
    </style>
</head>
<body>

<div class="page-wrapper" id="app">
    <input type="hidden" name="" id="device_token" value="">
    {{--    <nav-header></nav-header>--}}
    <header class="main-header header-style-one">

        <!-- Header Top -->
        <div class="header-top">
            <div class="auto-container">
                <div class="clearfix">

                    <!-- Top Left -->
                    <div class="top-right pull-right clearfix">

                        <!-- Info List -->
                        <ul class="info-list">
                            <li><span> للمساعدة والدعم :</span><a style="font-size: 19px" href="tel:+967778998366">
                                    778998366 967+</a></li>
                        </ul>
                        <!--                            <router-link to="/">Home</router-link>-->
                        <!--                            |-->
                        <!--                            <router-link to="/about">About</router-link>-->
                        <!--                            <span v-if="isLoggedIn"> | <a @click="logout">Logout</a></span>-->

                    </div>

                    <!-- Top Right -->
                    <div class="top-left pull-left clearfix">
                        <!-- Login Nav -->
                        <ul class="login-nav">
                            <li :class="[{'login-nav_active':currentPage!='register'}]"
                                @click="$scrollToTop" v-if="!isLoggedIn">

                                <router-link to="/login"> تسجيل الدخول</router-link>
                            </li>
                            <li @click="$scrollToTop" v-if="!isLoggedIn"
                                :class="[{'login-nav_active':currentPage=='register'}]"
                            >
                                <router-link to="/register"> انشاء حساب</router-link>
                            </li>
                            <li>
                                <router-link @click.native="scrollToTop()" v-if="isLoggedIn" to="/profile">

                                </router-link>
                            </li>

                            <li :class="[{'login-nav_active':currentPage!='profile'}]" @click="$scrollToTop"
                                v-if="isLoggedIn">
                                <router-link to="/logout"> تسجيل الخروج</router-link>
                            </li>
                            <li :class="[{'login-nav_active':currentPage=='profile'}]" @click="$scrollToTop"
                                v-if="isLoggedIn">
                                <router-link to="/profile"> الصفحة الشخصية</router-link>
                            </li>
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
                        <div class="logo"
                        ><a href="#" class="">
                                <img width="50" src="site/images/logo_white.png" alt=""
                                     title=" Yemen Women Union Developments"></a></div>
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
                                    <li :class="['dropdown' , {'shop_drown':(currentPage=='shop'|| currentPage=='my_orders'
                                     || currentPage=='CategoryProducts' || currentPage=='home' || currentPage=='home2' || currentPage=='shop_search'|| currentPage=='course_details'||
                                     currentPage=='shop_like' ||currentPage=='cart')},{'current':currentPage=='shop'}]">
                                        <a href="#">
                                            السوق الإلكتروني
                                        </a>
                                        <ul>
                                            <li :class="['shop_element_item',{'current':currentPage=='shop'}]">
                                                <router-link @click.native="scrollToTop()" to="/shop">
                                                    الرئيسية
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentPage=='my_orders'}]">
                                                <router-link @click.native="scrollToTop()"
                                                             to="/my_orders" v-if="isLoggedIn">
                                                    طلباتي
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentPage=='shop_search'}]">
                                                <router-link @click.native="scrollToTop()"
                                                             to="/shop_search">
                                                    بحث
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentPage=='shop_like'}]">
                                                <router-link @click.native="scrollToTop()"
                                                             to="/shop_like" v-if="isLoggedIn">
                                                    المفضلة
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentPage=='cart'}]">
                                                <router-link @click.native="scrollToTop()" to="/cart" v-if="isLoggedIn">
                                                    السلة
                                                </router-link>
                                            </li>

                                        </ul>
                                    </li>


                                    {{--                                    <li :class="[{'current':(currentPage=='home' ||currentPage=='home2')}]">--}}
                                    {{--                                        <router-link @click="$scrollToTop" to="/home"> الرئيسية</router-link>--}}
                                    {{--                                    </li>--}}
                                    <li :class="[{'current':currentPage=='courses'}]">
                                        <router-link @click.native="scrollToTop()" to="/courses"> التدريب</router-link>
                                    </li>

                                    <li :class="[{'current':currentPage=='consultant'}]">
                                        <router-link @click.native="scrollToTop()" to="/consultant"> الإستشارات
                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentPage=='women'}]">
                                        <router-link @click.native="scrollToTop()" to="/women"> شؤون المرأة
                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentPage=='privacy'}]">
                                        <router-link @click.native="scrollToTop()" to="/privacy"> سياسة الخصوصية
                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentPage=='concatUs'}]">
                                        <router-link @click.native="scrollToTop()" to="/concatUs"> تواصل معنا
                                        </router-link>
                                    </li>
                                    {{--                                    <li :class="[{'current':currentPage=='shop'}]">--}}
                                    {{--                                        <router-link @click.native="scrollToTop()" to="/shop"> السوق الالكتروني--}}
                                    {{--                                        </router-link>--}}
                                    {{--                                    </li>--}}
                                    {{--                                    <li :class="[{'current':currentPage=='cart'}]">--}}
                                    {{--                                        <router-link @click.native="scrollToTop()" to="/cart"> السلة--}}
                                    {{--                                        </router-link>--}}
                                    {{--                                    </li>--}}
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
                <div class="nav-logo" style="text-align: center">
                    <router-link @click.native="scrollToTop()" to="/home"></router-link>
                    <img
                        style="width: 130px;    margin-bottom: -30px;" src="site/images/logo_white.png"
                        alt=""
                        title=""></a></div>
                <div class="menu-outer">
                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                </div>
            </nav>
        </div>
        <!-- End Mobile Menu -->

    </header>

    <toast-success title="{{ session('success-title')??$successTitle??'' }}"
                   body="{{ session('success-body')??$successBody??'' }} "></toast-success>
    <toast-error title="{{ session('error-title')??$errorTitle??'' }}"
                 body="{{ session('error-body')??$errorBody??'' }}"></toast-error>

    <toast-stack title="{{ session('stack-title')??$stackTitle??'' }}"
                 body="{{ session('stack-body')??$stackTitle??'' }}"></toast-stack>

    <search-filed title="courses" v-if="ShowPublickSearchFiled"></search-filed>
    <router-view :key="$route.fullPath"></router-view>
    <!-- Call To Action Section Two -->

    <section class="call-to-action-section-two"
        style="background-image:url('{{asset('site/images/background/4.png')}}')">
        <div class="auto-container">

        </div>

        <div class="content">
            <h2>هل انت على استعداد للبدء؟</h2>
            <div class="text">يمكنك الان تصفح وشراء المنتجات و اخذ الدورات التدريبية
                و <br>نشر و عرض الإستشارات بكل سهولة .
            </div>
            <div class="buttons-box">
                <router-link class="theme-btn btn-style-one" @click.native="scrollToTop()" to="/shop">
                     <span class="txt"> تسوق الآن  <i
                             class="fa fa-angle-left"></i></span>
                </router-link>
                <router-link class="theme-btn btn-style-two" @click.native="scrollToTop()" to="/consultant">

                    <span class="txt">الإستشارات <i
                            class="fa fa-angle-left"></i></span>
                </router-link>

            </div>
        </div>
    </section>

    <footer class="main-footer">
        <!-- Pattern Layer -->
        <div class="pattern-layer paroller" data-paroller-factor="0.60" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image:url('{{asset('site/images/icons/icon-1.png')}}')">


        </div>
        {{--        <div class="pattern-layer-two" data-paroller-factor="0.60"--}}
        {{--             data-paroller-factor-lg="0.20" data-paroller-type="foreground"--}}
        {{--             data-paroller-direction="vertical"--}}
        {{--             style="background-image:url('{{asset('site/images/icons/icon-3.png')}}')">--}}
        {{--        </div>--}}
        <div class="auto-container">

            <!-- Widgets Section -->
            <div class="widgets-section" style="padding: 58px 1px 20px;">

                <div class="row clearfix">
                    <!-- Big Column -->
                    <div class="big-column  col-md-9 col-sm-12">
                        <div class="row clearfix">
                            <!--Footer Column-->
                            <div class="footer-column col-4">
                                <div class="footer-widget logo-widget">
                                    <div class="logo">
                                        <a href="/">
                                            <router-link @click.native="scrollToTop()" to="/home"></router-link>
                                            <img style="width: 39%" src="site/images/footer/1.png" alt=""></a>
                                    </div>

                                </div>
                            </div>
                            {{--                            <!--Footer Column-->--}}
                            {{--                            <div class="footer-column col-6">--}}
                            {{--                                <div class="footer-widget logo-widget">--}}
                            {{--                                    <div class="logo">--}}
                            {{--                                        <a href="/">--}}
                            {{--                                            <router-link @click.native="scrollToTop()" to="/home"></router-link>--}}
                            {{--                                            <img style="width: 60%" src="site/images/logo_white.png" alt=""></a>--}}
                            {{--                                    </div>--}}

                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <!--Footer Column-->--}}

                            <div class="footer-column col-4">
                                <div class="footer-widget logo-widget">
                                    <div class="logo">
                                        <a href="/">
                                            <router-link @click.native="scrollToTop()" to="/home"></router-link>
                                            <img style="width: 105%;
    margin-top: -9%;" src="site/images/footer/2.png" alt=""></a>
                                    </div>

                                </div>
                            </div>
                            <!--Footer Column-->
                            <!--Footer Column-->


                            <div class="footer-column col-4">
                                <div class="footer-widget logo-widget">
                                    <div class="logo">
                                        <a href="/">
                                            <router-link @click.native="scrollToTop()" to="/home"></router-link>
                                            <img style="width: 80%" src="/site/images/footer/3.png" alt=""></a>
                                    </div>

                                </div>
                            </div>
                            <!--Footer Column-->

                        </div>
                    </div>
                    <div class="big-column  col-md-3 col-sm-12" style="text-align: center">
                        <div class="footer-column  col-12">
                            <div class="footer-widget links-widget">
                                <h4> تنزيل التطبيقات</h4>

                                <ul class="links-widget" style="    margin-top: 1px;">
                                    <li>
                                        <a href="{{route('download_app') }}" target="_blank">
                                            {{--                                        <a href="https://play.google.com/store/apps/" target="_blank">--}}
                                            <img
                                                src="/site/images/google-play-img.png" alt=""></a>
                                        {{--                                            <a href="https://play.google.com/store/apps/details?id=com.sahltaxi.passenger" target="_blank"><img src="assets/img/google-play-img.png" alt=""></a>--}}

                                    </li>
                                    <li>

                                        <a href="https://itunes.apple.com" target="_blank"><img
                                                src="/site/images/app-stor-img.png" alt=""></a>
                                        {{--                                            <a href="https://itunes.apple.com/qa/app/sahl-taxi/id1455325390?mt=8" target="_blank"><img src="assets/img/app-stor-img.png" alt=""></a>--}}
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </footer>
    <div class="footer_menu_copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="last_footer">
                        <div class="copy_right">
                            <p style="text-align: center"><a href="#">حقوق النشر والتصميم محفوظة © لاتحاد نساء اليمن</a>
                            </p>
                        </div>

                    </div>
                </div>
                {{--            <div class="col-md-5">--}}
                {{--                <div class="last_footer">--}}

                {{--                    <div class="developer" style="text-align: center">--}}
                {{--                        <p>تصميم وتطوير: <a href="https://www.facebook.com/Eng.Osama.Almamari"--}}
                {{--                                            title="م.اسامة المعمري">م.اسامة المعمري</a></p>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>
        </div>
    </div>

</div>

<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-arrow-circle-up"></span></div>
{{--//for vue JS--}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('site/vue/vue-clazy-load.min.js') }}"></script>
<script src="{!! asset('newLibs\lightbox2\js\lightbox.min.js') !!}"></script>


<script src="{!! asset('site/js/jquery.js') !!}"></script>
<script src="{!! asset('site/js/popper.min.js') !!}"></script>
<script src="{!! asset('site/js/jquery.scrollTo.js') !!}"></script>
<script src="{!! asset('site/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('site/js/jquery.mCustomScrollbar.concat.min.js') !!}"></script>
{{--<script src="{!! asset('site/js/jquery.fancybox.js') !!}"></script>--}}
<script src="{!! asset('site/js/appear.js') !!}"></script>
{{--<script src="{!! asset('site/js/swiper.min.js') !!}"></script>--}}
{{--<script src="{!! asset('site/js/element-in-view.js') !!}"></script>--}}
{{--<script src="{!! asset('site/js/jquery.paroller.min.js') !!}"></script>--}}

{{--<script src="{!! asset('site/js/validate.js') !!}"></script>--}}

{{--<script src="{!! asset('site/js/parallax.min.js') !!}"></script>--}}
{{--<script src="{!! asset('site/js/tilt.jquery.min.js') !!}"></script>--}}
<!--Master Slider-->
{{--<script src="{!! asset('site/js/jquery.easing.min.js') !!}"></script>--}}
{{--<script src="{!! asset('site/js/owl.js') !!}"></script>--}}
{{--<script src="{!! asset('site/js/wow.js') !!}"></script>--}}
{{--<script src="{!! asset('site/js/jquery-ui.js') !!}"></script>--}}
<script src="{!! asset('site/js/script.js') !!}"></script>

<script src="{{asset('firebase\firebase-app.js')}}"></script>
<script src="{{asset('firebase\firebase-messaging.js')}}"></script>
{{--<script src="{{asset('firebase\firebase-firestore.js')}}"></script>--}}
{{--<script src="{{asset('firebase\firebase-analytics.js')}}"></script>--}}

<script>

    $(document).ready(function () {
        // Your web app's Firebase configuration
        var notificattions = $('#admin_notification');
        var notificationsCount = parseInt($('#notification_count').text());

        function playSound() {
            var mp3Source = '<source src="{{url('')}}/1.mp3" type="audio/mpeg">';
            var oggSource = '<source src="{{url('')}}/1.ogg" type="audio/ogg">';
            var embedSource = '<embed hidden="true" autostart="true" loop="false" src="{{url('')}}/1.mp3">';
            document.getElementById("sound").innerHTML = '<audio autoplay="autoplay">' + mp3Source + oggSource + embedSource + '</audio>';
        }

        function newNotification(data) {
            toastr.info(data.message);
            var existingNotifications = notificattions.html();
            var newNotificationHtml = '<li>\n' +
                '                            <a>\n' +
                '                                <span class="image">\n' +
                '                                    <img src="' + data.sender_image + '" alt=" Image"/>\n' +
                '                                </span>\n' +
                '                                <span>\n' +
                '                          <span>' + data.sender_name + ' </span>\n' +
                '                          <span class="time">الان  </span>\n' +
                // '                          <span class="time">' + data.date + ' </span>\n' +
                '                        </span>\n' +
                '                                <span class="message">' + data.message + '</span>\n' +
                '                            </a>\n' +
                '                        </li>';
            notificattions.html(newNotificationHtml + existingNotifications);
            notificationsCount += 1;
            $('#notification_count').text(notificationsCount);
        }

        var firebaseConfig = {
            apiKey: "AIzaSyA6i0L2F8RrJ13E0dRCZWdgJMWnzKx-x30",
            authDomain: "halaalmadi-e8464.firebaseapp.com",
            databaseURL: "https://halaalmadi-e8464.firebaseio.com",
            projectId: "halaalmadi-e8464",
            storageBucket: "halaalmadi-e8464.appspot.com",
            messagingSenderId: "51100198139",
            appId: "1:51100198139:web:1e7f13b469cd102a4ffc5e",
            measurementId: "G-LYPYW0D2ZZ"
        };
// Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();
        messaging.requestPermission()
            .then(function () {
                console.log('Notification permission granted.');
                // TODO(developer): Retrieve a Instance ID token for use with FCM.
                // ...
            })
            .catch(function (err) {
                console.log('Unable to get permission to notify.----------- ', err);
            });
        messaging.usePublicVapidKey("BOhwORjxRrq_yMgeKxEZ06IhrFdSxONWttCKZrJTwJ4N84hxNZ9rS_8-kHvGBrKaPlcxUFgd9oinnd4DpfSjHAE");
        // Get Instance ID token. Initially this makes a network call, once retrieved
        // subsequent calls to getToken will return from cache.
        messaging.requestPermission()
            .then(() => {
                console.log("Have Permission");
                return messaging.getToken();
            })
            .then(token => {
                console.log("FCM Token:", token);
                $("#device_token").val(token);
                //Do something with TOken like subscribe to topics
            })
            .catch(error => {
                if (error.code === "messaging/permission-blocked") {
                    console.log("Please Unblock Notification Request Manually");
                } else {
                    console.log("Error Occurred", error);
                }
            });
        messaging.onMessage(function (payload) {
            console.log('Message received. ', payload);
            newNotification(payload.data);
            playSound();


        });


    })

</script>


@yield('js')


</body>
</html>
