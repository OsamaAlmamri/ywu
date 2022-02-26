<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> YemenWe</title>
    <!-- Stylesheets -->
    <link rel="manifest" href="{{  asset('manifest.json')}}"/>

    <link href="{{  asset('site/css/bootstrap.min.css')  }}" rel="stylesheet">
    {{--    <link href="{{  asset('site/css/themes.css')  }}" rel="stylesheet">--}}
    {{--    <link  href="http://templates.g5plus.net/glowing/css/themes.css"  rel="stylesheet">--}}

    {{--    <!--	<link rel="stylesheet" href="css/bootstrap-rtl.min.css">-->--}}
    <link rel="stylesheet" href="{{  asset('site/css/rtl/bootstrap-rtl.css')  }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    {{--    <link href="{{asset('site/css/main5.css')  }}" rel="stylesheet">--}}

    @if( isset($_COOKIE["style_lang"]) and $_COOKIE["style_lang"]!="ar")
        <link id="style_lang" href="{{asset('site/css/main_en.css')  }}" rel="stylesheet">
    @else
        <link id="style_lang" href="{{asset('site/css/main5.css')  }}" rel="stylesheet">
    @endif
    <link href="{{  asset('site/css/responsive.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/css/mcq.css')  }}" rel="stylesheet">
    <link href="{{  asset('site/vue/loading2.css')  }}" rel="stylesheet">
    {{--    <link href="{{  asset('css/app.css')  }}" rel="stylesheet">--}}
    {{--    <link href="{{  asset('css/toastr.css')  }}" rel="stylesheet">--}}

    <meta name="theme-color" content="#593c97">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#593c97">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#00ab15">
    {{--    <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>--}}
    <link rel="icon" href="{{  asset('site/images/logo_white.png')  }}" type="image/x-icon">
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Titillium+Web:wght@300;400;600;700;900&display=swap"
        rel="stylesheet">
    <link href="{!! asset('newLibs\lightbox2\css\lightbox.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link href="{{asset('site/css/osama3.css')  }}" rel="stylesheet">

    <style>

        :root {
            --blue: #007bff;
            --indigo: #6610f2;
            --purple: #6f42c1;
            --pink: #e83e8c;
            --red: #dc3545;
            --orange: #fd7e14;
            --yellow: #ffc107;
            --green: #28a745;
            --teal: #20c997;
            --cyan: #17a2b8;
            --white: #fff;
            --gray: #6c757d;
            --gray-dark: #343a40;
            --primary: #593c97;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .consultant_category {
            color: white;
            border-radius: 25% 25%;
            padding: 2px 20px;
            background: var(--primary);

        }

        .filter_option_serller {
            height: 500px;
        }

        .box-inner {
            text-align: start;
        }

        .filter_option_serller .multiselect__content-wrapper {
            max-height: 400px !important;
            display: block !important;
        }

        .multiselect__option--selected {
            background: #9d84bd;
            color: #35495e;
            font-weight: 700;
        }

        .option_more_address_info {
            display: block;
            width: 100px;
            overflow: hidden;
            word-wrap: break-word;
            text-overflow: ellipsis;
            max-height: 16px;
            line-height: 16px
        }

        .search-box button {
            margin-top: 0;
        }

        .wrapper {
            height: 150px;
        }

        .image_box img:not(.zoomImage) {

            height: 150px;
            width: 170px;
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

        .sweet-content-content {
            width: 100%;
        }

        .table {
            width: 100%;
            overflow-y: scroll;
        }

        .one_seller_box .table {
            font-size: 10px;
        }

        .divClass {
            background-position: initial;

        }


        .like_product_button {
            top: unset;
        }

        .product_info_box {
            padding: 0;
            margin: 0px 0 -1px 0px;

        }

        .product_countainer_link {
            padding: 0;
        }

        .product_countainer_link {

            border-radius: 10%;

        }

        .product_name_box {
            font-size: 12px;
            border-radius: 10px;
        }

        .one_product_name {
            padding: 2px;
        }

        .product_gov {
            font-size: 11px;
            font-weight: 300;
            background: #593c97;
            /*min-width: 30%;*/
            width: 40%;
            color: white;
            padding: 5px 4px;
            border-radius: 10px 0;
        }

        .product_price_box {
            font-size: 15px;
            color: black;
            direction: ltr;

            margin-bottom: 0px;
            padding: 0 6px;
            margin-bottom: 15px;
        }

        .product_price_top {
            top: 0;
            position: absolute;
            background: #9781d0;
            color: white;
            padding: 12px;


        }

        body, .sidebar-page-container {
            background: #593c9721;
        }

        .category_image_box {
            background: unset;
        }

        /*.shop_sidebar{*/
        /*position: fixed;*/
        /*z-index: 1;*/
        /*top: 20px;*/
        /*left: 10px;*/
        /*background: #eee;*/
        /*overflow-x: hidden;*/
        /*padding: 8px 0;*/
        /*}*/

        .shop_sidebar {
            margin: 0;
            padding: 0;
            width: 200px;
            background-color: #f1f1f1;
            position: sticky;
            height: 100%;
            overflow: auto;
        }

        .shop_sidebar a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
        }

        .shop_sidebar a.active {
            background-color: #04AA6D;
            color: white;
        }

        .shop_sidebar a:hover:not(.active) {
            background-color: #555;
            color: white;
        }

        div.content {
            margin-left: 200px;
            padding: 1px 16px;
            height: 1000px;
        }

        @media screen and (max-width: 700px) {
            .shop_sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .shop_sidebar a {
                float: left;
            }

            div.content {
                margin-left: 0;
            }
        }

        @media screen and (max-width: 400px) {
            .shop_sidebar a {
                text-align: center;
                float: none;
            }
        }
    </style>

    {{-- notification style --}}

    <style>

        .navbar-default .dropdown-menu.notify-drop {
            min-width: 330px;
            background-color: #fff;
            min-height: 360px;
            max-height: 360px;
        }

        .navbar-default .dropdown-menu.notify-drop .notify-drop-title {
            border-bottom: 1px solid #e2e2e2;
            padding: 5px 15px 10px 15px;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content {
            min-height: 280px;
            max-height: 280px;
            overflow-y: scroll;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-track {
            background-color: #F5F5F5;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar {
            width: 8px;
            background-color: #F5F5F5;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-thumb {
            background-color: #ccc;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li {
            border-bottom: 1px solid #e2e2e2;
            padding: 10px 0px 5px 0px;

        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li:nth-child(2n+0) {
            background-color: #fafafa;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li:after {
            content: "";
            clear: both;
            display: block;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li:hover {
            background-color: #fcfcfc;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li:last-child {
            border-bottom: none;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li .notify-img {
            float: left;
            display: inline-block;
            width: 45px;
            height: 45px;
            margin: 0px 0px 8px 0px;
        }

        .navbar-default .dropdown-menu.notify-drop .allRead {
            margin-right: 7px;
        }

        .navbar-default .dropdown-menu.notify-drop .rIcon {
            float: right;
            color: #999;
        }

        .navbar-default .dropdown-menu.notify-drop .rIcon:hover {
            color: #333;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li a {
            font-size: 12px;
            font-weight: normal;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li {
            font-weight: bold;
            font-size: 11px;

        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li hr {
            margin: 5px 0;
            width: 70%;
            border-color: #e2e2e2;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content .pd-l0 {
            padding-left: 0;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li p {
            font-size: 11px;
            color: #666;
            font-weight: normal;
            margin: 3px 0;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li p.time {
            font-size: 10px;
            font-weight: 600;
            top: -6px;
            margin: 8px 0px 0px 0px;
            padding: 0px 3px;
            border: 1px solid #e2e2e2;
            position: relative;
            background-image: linear-gradient(#fff, #f2f2f2);
            display: inline-block;
            border-radius: 2px;
            color: #B97745;
        }

        .navbar-default .dropdown-menu.notify-drop .drop-content > li p.time:hover {
            background-image: linear-gradient(#fff, #fff);
        }

        .navbar-default .dropdown-menu.notify-drop .notify-drop-footer {
            border-top: 1px solid #e2e2e2;
            bottom: 0;
            position: relative;
            padding: 8px 15px;
        }

        .navbar-default .dropdown-menu.notify-drop .notify-drop-footer a {
            color: #777;
            text-decoration: none;
        }

        .navbar-default .dropdown-menu.notify-drop .notify-drop-footer a:hover {
            color: #333;
        }


        .notify-drop {
            transform: translate3d(-230px, 25px, 0px) !important;
        }
    </style>

    <style>

        .menu-item,
        .menu-open-button {
            background: #EEEEEE;
            border-radius: 100%;
            width: 30px;
            height: 30px;
            margin-left: -40px;
            position: absolute;
            color: #FFFFFF;
            text-align: center;
            line-height: 30px;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            -webkit-transition: -webkit-transform ease-out 200ms;
            transition: -webkit-transform ease-out 200ms;
            transition: transform ease-out 200ms;
            transition: transform ease-out 200ms, -webkit-transform ease-out 200ms;
        }

        .menu-open {
            display: none;
        }

        .menu {



            margin: auto;
            position: absolute;
            /* top: 0; */
            /* bottom: 0; */
            /* left: 0; */
            /* right: 0; */
            width: 80px;
            /* height: 80px; */
            text-align: center;
            z-index: 9;
            box-sizing: border-box;
            font-size: 15px;
        }

        .share-icon {
            color: #596778;
            /*background color*/
        }

        .menu-item:hover {
            background: #EEEEEE;
            color: #3290B1;
        }

        .menu-item:nth-child(3) {
            -webkit-transition-duration: 180ms;
            transition-duration: 180ms;
        }

        .menu-item:nth-child(4) {
            -webkit-transition-duration: 180ms;
            transition-duration: 180ms;
        }

        .menu-item:nth-child(5) {
            -webkit-transition-duration: 180ms;
            transition-duration: 180ms;
        }

        .menu-item:nth-child(6) {
            -webkit-transition-duration: 180ms;
            transition-duration: 180ms;
        }

        .menu-item:nth-child(7) {
            -webkit-transition-duration: 180ms;
            transition-duration: 180ms;
        }

        .menu-item:nth-child(8) {
            -webkit-transition-duration: 180ms;
            transition-duration: 180ms;
        }

        .menu-item:nth-child(9) {
            -webkit-transition-duration: 180ms;
            transition-duration: 180ms;
        }

        .menu-open-button {
            z-index: 2;
            -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
            -webkit-transition-duration: 400ms;
            transition-duration: 400ms;
            -webkit-transform: scale(1.1, 1.1) translate3d(0, 0, 0);
            transform: scale(1.1, 1.1) translate3d(0, 0, 0);
            cursor: pointer;
            box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        }

        .menu-open-button:hover {
            -webkit-transform: scale(1.2, 1.2) translate3d(0, 0, 0);
            transform: scale(1.2, 1.2) translate3d(0, 0, 0);
        }

        .menu-open:checked + .menu-open-button {
            -webkit-transition-timing-function: linear;
            transition-timing-function: linear;
            -webkit-transition-duration: 200ms;
            transition-duration: 200ms;
            -webkit-transform: scale(0.8, 0.8) translate3d(0, 0, 0);
            transform: scale(0.8, 0.8) translate3d(0, 0, 0);
        }

        .menu-open:checked ~ .menu-item {
            -webkit-transition-timing-function: cubic-bezier(0.935, 0, 0.34, 1.33);
            transition-timing-function: cubic-bezier(0.935, 0, 0.34, 1.33);
        }

        .menu-open:checked ~ .menu-item:nth-child(3) {
            transition-duration: 180ms;
            -webkit-transition-duration: 180ms;
            -webkit-transform:  translate3d(0.04181px, -52.4997px, 0);
            transform: translate3d(0.04181px, -52.4997px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(4) {
            transition-duration: 280ms;
            -webkit-transition-duration: 280ms;
            -webkit-transform: translate3d(45.4733px, -26.23586px, 0);
            transform: translate3d(45.4733px, -26.23586px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(5) {
            transition-duration: 380ms;
            -webkit-transition-duration: 380ms;
            -webkit-transform:translate3d(45.4733px, 26.23586px, 0);
            transform: translate3d(45.4733px, 26.23586px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(6) {
            transition-duration: 480ms;
            -webkit-transition-duration: 480ms;/**/
            -webkit-transform: translate3d(0.0418px, 52.50097px, 0);
            transform: translate3d(0.0418px, 52.50097px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(7) {
            transition-duration: 580ms;
            -webkit-transition-duration: 580ms;
            -webkit-transform: translate3d(-45.43145px, 26.31064px, 0);
            transform: translate3d(-45.43145px, 26.31064px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(8) {
            transition-duration: 680ms;
            -webkit-transition-duration: 680ms;
            -webkit-transform: translate3d(-45.51506px, -26.17095px, 0);
            transform: translate3d(-45.51506px, -26.17095px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(9) {
            transition-duration: 780ms;
            -webkit-transition-duration: 780ms;
            -webkit-transform: translate3d(-0.12542px, -52.4997px, 0);
            transform: translate3d(-0.12542px, -52.4997px, 0);
        }

        .facebook_share_btn {
            background-color: #3b5998;
            box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .facebook_share_btn:hover {
            color: #3b5998;
            text-shadow: none;
        }

        .twitter_share_btn {
            background-color: #00aced;
            box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .twitter_share_btn:hover {
            color: #00aced;
            text-shadow: none;
        }

        .telegram_share_btn {
            background-color: #2ea6da;
            box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .telegram_share_btn:hover {
            color: #2ea6da;
            text-shadow: none;
        }

        .instagram_share_btn {
            background-color: #972fbc;
            box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .instagram_share_btn:hover {
            color: #972fbc;
            text-shadow: none;
        }

        .linkedin_share_btn {
            background-color: #026eaa;
            box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .linkedin_share_btn:hover {
            color: #026eaa;
            text-shadow: none;
        }

        .whatsapp_share_btn {
            background-color: #41f521;
            box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .whatsapp_share_btn:hover {
            color: #41f521;
            text-shadow: none;
        }

        /*redesigner*/

        .redesigner {
            width: 100%;
            position: fixed;
            bottom: 0;
            text-align: center;
            font-weight: 500;
            font-size: 20px;
            color: white;
            text-decoration: none;
            letter-spacing: 1.5px;
        }

        .redesigner a:nth-child(1) {
            text-decoration: none;
            transition:all 0.5s;
        }

        .redesigner a:nth-child(1):hover {
            text-decoration: none;
            letter-spacing:5px;
            transition:all 0.5s;
        }

        .redesigner a:nth-child(3) {
            letter-spacing: normal;
            font-size: 10px;
            text-decoration: none;
        }

        .redesigner a:nth-child(3):hover {
            text-decoration: none;
        }

        .main-header .header-top .login-nav li:nth-child(2) a {

            padding: 0;
            background: unset;
            color: #03382e;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;

        }
    </style>
</head>


<body style="direction: {{(isset($_COOKIE['style_lang']) and $_COOKIE['style_lang']!='ar')?'ltr':'rtl'}}">

<div class="page-wrapper " id="my_site_app">
    <input type="hidden" name="" id="device_token" value="">
    {{--    <nav-header></nav-header>--}}
    <vue-header></vue-header>

    <toast-stack title="{{ session('stack-title')??$stackTitle??'' }}"
                 body="{{ session('stack-body')??$stackTitle??'' }}"></toast-stack>

    <search-filed title="courses" v-if="ShowPublickSearchFiled"></search-filed>
    <router-view :key="$route.fullPath"></router-view>
    <!-- Call To Action Section Two -->

    {{--    <section class="call-to-action-section-two"--}}
    {{--             style="background-image:url('{{asset('site/images/background/4.png')}}')">--}}
    {{--        <div class="auto-container">--}}

    {{--        </div>--}}

    {{--        <div class="content">--}}
    {{--            <h2>هل انت على استعداد للبدء؟</h2>--}}
    {{--            <div class="text">يمكنك الان تصفح وشراء المنتجات و اخذ الدورات التدريبية--}}
    {{--                و <br>نشر و عرض الإستشارات بكل سهولة .--}}
    {{--            </div>--}}
    {{--            <div class="buttons-box">--}}
    {{--                <router-link class="theme-btn btn-style-one" @click.native="scrollToTop()" to="/shop">--}}
    {{--                     <span class="txt"> تسوق الآن  <i--}}
    {{--                             class="fa fa-angle-left"></i></span>--}}
    {{--                </router-link>--}}
    {{--                <router-link class="theme-btn btn-style-two" @click.native="scrollToTop()" to="/consultant">--}}

    {{--                    <span class="txt">الإستشارات <i--}}
    {{--                            class="fa fa-angle-left"></i></span>--}}
    {{--                </router-link>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

    <footer class="main-footer">
        <!-- Pattern Layer -->
        {{--        <div class="pattern-layer paroller" data-paroller-factor="0.60" data-paroller-factor-lg="0.20"--}}
        {{--             data-paroller-type="foreground" data-paroller-direction="vertical"--}}
        {{--             style="background-image:url('{{asset('site/images/icons/icon-1.png')}}')">--}}


        {{--        </div>--}}
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
                                            <img style="width: 39%" src="/site/images/footer/1.png" alt=""></a>
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
                                            <img style="width: 80%;margin-top: -2%;" src="/site/images/footer/3.png"
                                                 alt=""></a>
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
                                            <img style="width: 100%" src="/site/images/footer/4.png" alt=""></a>
                                    </div>

                                </div>
                            </div>
                            <!--Footer Column-->

                        </div>
                    </div>
                    <div class="big-column  col-md-3 col-sm-12" style="text-align: center">
                        <div class="footer-column  col-12">
                            <div class="footer-widget links-widget">
                                <footer-download></footer-download>

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
                            <p style="text-align: center">
                                <footer-app></footer-app>
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

<div class="scroll-to-top scroll-to-target" data-target="html">
    <span class="fa fa-arrow-circle-up"></span></div>
{{--//for vue JS--}}
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('site/vue/vue-clazy-load.min.js') }}"></script>
<script src="{!! asset('newLibs\lightbox2\js\lightbox.min.js') !!}"></script>


<script src="{!! asset('site/js/jquery.js') !!}"></script>
<script src="{!! asset('site/js/jquery.paroller.min.js') !!}"></script>
{{--<script src="{!! asset('site/js/popper.min.js') !!}"></script>--}}
<script src="{!! asset('site/js/jquery.scrollTo.js') !!}"></script>
{{--<script src="{!! asset('site/js/bootstrap.min.js') !!}"></script>--}}
<script src="{!! asset('site/js/jquery.mCustomScrollbar.concat.min.js') !!}"></script>

<script src="{!! asset('site/js/script.js') !!}"></script>

<script src="{{asset('firebase\firebase-app.js')}}"></script>
<script src="{{asset('firebase\firebase-messaging.js')}}"></script>
{{--<script src="{{asset('firebase\firebase-firestore.js')}}"></script>--}}
{{--<script src="{{asset('firebase\firebase-analytics.js')}}"></script>--}}

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js');
        });
    }
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


        const firebaseConfig = {
            apiKey: "AIzaSyDEcBVuKQk8ionFo3MR4K4zkb7BQ9baTXs",
            authDomain: "yemenwe-d2ed4.firebaseapp.com",
            projectId: "yemenwe-d2ed4",
            storageBucket: "yemenwe-d2ed4.appspot.com",
            messagingSenderId: "752937676482",
            appId: "1:752937676482:web:ce642e226e3ec88717d55b",
            measurementId: "G-DS5Z7LJJTR"
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
        messaging.usePublicVapidKey("BEdgvSjrQD98fkHWrOKCMq7G1ZhYmHmR_mBzGy3BEy-A-FPLeOaFTgGrKYyFKkN3eN9E2SIlCOfGiO_4CarHxEA");
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
<script>
    import FooterDownload from "../../js/components/footerDownload";

    export default {
        components: {FooterDownload}
    }
</script>
