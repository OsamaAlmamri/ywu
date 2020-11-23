<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Yemen Women Union Developments</title>
    <!-- Stylesheets -->

    <link href="{{  asset('site/css/bootstrap.css')  }}" rel="stylesheet">
    <!--	<link rel="stylesheet" href="css/bootstrap-rtl.min.css">-->
    <link rel="stylesheet" href="{{  asset('site/css/rtl/bootstrap-rtl.css')  }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <link href="{{asset('site/css/main.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/css/responsive.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/css/mcq.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/vue/loading.css')  }}" rel="stylesheet">
    {{--    <link href="{{  asset('css/app.css')  }}" rel="stylesheet">--}}
    <link href="{{  asset('css/toastr.css')  }}" rel="stylesheet">

    <meta name="theme-color" content="#593c97">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#593c97">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#00ab15">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
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
    <link href="{{asset('site/css/osama.css')  }}" rel="stylesheet">

    <style>
        .mobile-menu{
            left: auto;
            right: 0;
        }
        body {
            font-family: 'Droid Arabic Kufi';
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
                            <li><span>خط الاستشارات :</span><a href="tel:8000999"> 8000999 01</a></li>
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
                            <li >
                                <router-link @click.native="scrollToTop()" v-if="isLoggedIn" to="/profile">

                                </router-link>
                            </li>

                            <li :class="[{'login-nav_active':currentPage!='profile'}]"  @click="$scrollToTop" v-if="isLoggedIn">
                                <router-link to="/logout"> تسجيل الخروج</router-link>
                            </li>
                            <li  :class="[{'login-nav_active':currentPage=='profile'}]"  @click="$scrollToTop" v-if="isLoggedIn">
                                <router-link to="/profile"> الصفحة الشخصية </router-link>
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
                        ><a href="#" class="logo_box_a">
                                <img width="50" src="site/images/Logo250px.png" alt=""
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
                                        <router-link @click.native="scrollToTop()"  to="/shop">
                                            السوق الالكتروني
                                        </router-link>
                                        <ul>
                                            <li :class="['shop_element_item',{'current':currentPage=='shop'}]">
                                                <router-link @click.native="scrollToTop()"  to="/shop">
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
                                        <router-link @click.native="scrollToTop()" to="/consultant"> الاستشارات
                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentPage=='women'}]">
                                        <router-link @click.native="scrollToTop()" to="/women"> شؤون المرأة
                                        </router-link>
                                    </li>
{{--                                    <li :class="[{'current':currentPage=='privacy'}]">--}}
{{--                                        <router-link @click.native="scrollToTop()" to="/privacy"> سياية الخصوصية--}}
{{--                                        </router-link>--}}
{{--                                    </li>--}}
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
                        style="width: 130px;    margin-bottom: -30px;" src="site/images/Logo250px.png"
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


    <button @click="show=!show"></button>
    <router-view :key="$route.fullPath"></router-view>
    <!-- Call To Action Section Two -->

    <section class="call-to-action-section-two"
             style="background-image:url('site/images/background/3.png')">
        <div class="auto-container">

        </div>

        <div class="content">
            <h2>هل انت على استعداد للبدء؟</h2>
            <div class="text">يمكنك الان عرض واخذ المواد التدريبة
                و <br>نشر و عرض الاستشارات  وتصفح منتجات نساء اتحاد اليمن و وشراء هذا المنتجات .
            </div>
            <div class="buttons-box">
                <router-link class="theme-btn btn-style-one" @click.native="scrollToTop()" to="/shop">
                     <span class="txt"> تسوق الان  <i
                             class="fa fa-angle-left"></i></span>
                </router-link>
                <router-link class="theme-btn btn-style-two" @click.native="scrollToTop()" to="/consultant">

                    <span class="txt">الاستشارات <i
                            class="fa fa-angle-left"></i></span>
                </router-link>

            </div>
        </div>
    </section>

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
                            <div class="footer-column col-lg-5 col-md-5 col-sm-12">
                                <div class="footer-widget logo-widget">
                                    <div class="logo">
                                        <a href="/">
                                            <router-link @click.native="scrollToTop()" to="/home"></router-link>
                                            <img style="width: 130%" src="site/images/Logo250p50x.png" alt=""></a>
                                    </div>
                                    <div class="social-box" style="text-align: center;">
                                        <a href="https://www.facebook.com/yemenwu" class="fa fa-facebook"></a>
                                        <a href="https://www.instagram.com/yemen_women_union/"
                                           class="fa fa-instagram"></a>
                                        <a href="https://twitter.com/yemenwomenunion" class="fa fa-twitter"></a>
                                        <a href="http://yemenwu.org/rss.php" class="fa fa-google"></a>
                                        <a href="https://www.youtube.com/channel/UCqfE0KSwfIheQSODW0U_aDw"
                                           class="fa fa-youtube"></a>
                                    </div>
                                </div>
                            </div>
                            <!--Footer Column-->
                            <div class="footer-column col-lg-7 col-md-7 col-sm-12">
                                <div class="footer-widget links-widget">
                                    <h4>من نحن</h4>
                                    <div class="about-us">
                                        <p>اتحاد نساء اليمن منظمة جماهيرية طوعية غير حكومية له شخصية اعتبارية مالية مستقلة ولا يهدف الى العمل الربحي. تأسس منذ الستينات ويبلغ عدد عضواته 1,450,000 عضوة من مختلف الانتماءات السياسية والاجتماعية.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Big Column -->
                    <div class="big-column col-lg-6 col-md-12 col-sm-12">
                        <div class="row clearfix">

                            <!--Footer Column-->
                            <div class="footer-column col-lg-8 col-md-8  col-sx-12 col-sm-8">
                                <div class="footer-widget links-widget">
                                    <h4>معلومات تهمك</h4>
                                    <div class="about-us">
                                        <address class="offset-top-20">
                                            <ul class="contact-list">
                                                <li class="transition-ef inner-lan"><i class="fa fa-envelope-o"></i><a
                                                        href="mailto:info@yemenwu.org">info@yemenwu.org</a></li>
                                                <li class="transition-ef inner-lan"><i class="fa fa-phone"></i><a
                                                        href="tel:+967 01 480489">+967 01 480489</a></li>
                                                <li class="transition-ef"><i class="fa fa-map-marker"></i>المكتب
                                                    التنفيذي
                                                    صنعاء - التحرير خلف البنك المركزي
                                                </li>
                                                {{--                                                <li class="transition-ef"><i class="fa fa-inbox"></i>صندوق بريد: 3541</li>--}}
                                            </ul>
                                        </address>
                                    </div>
                                </div>
                            </div>

                            <!--Footer Column-->
                            <div class="footer-column col-lg-4 col-md-4 col-sx-12 col-sm-4">
                                <div class="footer-widget links-widget">
                                    <h4> تنزيل التطبيقات</h4>

                                    <ul class="links-widget">
                                        <li style="display: inline-block;">
                                            <a href="https://play.google.com/store/apps/" target="_blank"><img
                                                    src="site/images/google-play-img.png" alt=""></a>
                                            {{--                                            <a href="https://play.google.com/store/apps/details?id=com.sahltaxi.passenger" target="_blank"><img src="assets/img/google-play-img.png" alt=""></a>--}}
                                        </li>
                                        <li style="display: inline-block;">

                                            <a href="https://itunes.apple.com" target="_blank"><img
                                                    src="site/images/app-stor-img.png" alt=""></a>
                                            {{--                                            <a href="https://itunes.apple.com/qa/app/sahl-taxi/id1455325390?mt=8" target="_blank"><img src="assets/img/app-stor-img.png" alt=""></a>--}}
                                        </li>
                                    </ul>
                                </div>
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
                            <p style="text-align: center"><a href="#">حقوق النشر والتصميم محفوظة © 2020 Yemen Women
                                    Union Developments</a>
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

<script src="{!! asset('site/js/validate.js') !!}"></script>

<script src="{!! asset('site/js/parallax.min.js') !!}"></script>
<script src="{!! asset('site/js/tilt.jquery.min.js') !!}"></script>
<!--Master Slider-->
<script src="{!! asset('site/js/jquery.easing.min.js') !!}"></script>
<script src="{!! asset('site/js/owl.js') !!}"></script>
<script src="{!! asset('site/js/wow.js') !!}"></script>
<script src="{!! asset('site/js/jquery-ui.js') !!}"></script>
<script src="{!! asset('site/js/script.js') !!}"></script>

<script src="{{asset('firebase\firebase-app.js')}}"></script>
<script src="{{asset('firebase\firebase-messaging.js')}}"></script>
<script src="{{asset('firebase\firebase-firestore.js')}}"></script>
<script src="{{asset('firebase\firebase-analytics.js')}}"></script>

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
