<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="fontiran.com:license" content="Y68A9">
    <link rel="icon" href="{{asset('build/images/favicon.ico')}}" type="image/ico"/>
    <title>لوحة التحكم </title>

    <!-- Bootstrap -->
    <link href="{{  asset('vendors/bootstrap/dist/css/bootstrap.min.css')  }}" rel="stylesheet">
    {{-- <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{  asset('vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
{{--    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">--}}
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{!! asset('new_admin/css/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />

    <link href="{!! asset('new_admin/css/image-picker.css') !!}" media="all" rel="stylesheet" type="text/css" />

    <!-- cdn -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- datatable -->
{{--    <link rel="stylesheet" href="js/dataTables.bootstrap.min.css"/>--}}
    <link href="{!! asset('js/dataTables.bootstrap.min.css') !!}" media="all" rel="stylesheet"
    <link href="{!! asset('newLibs/data-table/css/buttons.dataTables.min.css') !!}" media="all" rel="stylesheet"
    <link href="{!! asset('newLibs/data-table/css/buttons.dataTables.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <link href="{!! asset('newLibs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}"
          media="all" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('newLibs/data-table/extensions/responsive/css/responsive.dataTables.css') !!}"
          media="all" rel="stylesheet" type="text/css"/>

    <link href="{!! asset('newLibs\lightbox2\css\lightbox.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <style>

        .form-horizontal .control-label {
            text-align: right !important;
        }

        td .fa-toggle-on {
            color: #15e408;
            font-size: 25px;
        }

        td .fa-toggle-off {
            color: #fa1135;
            font-size: 25px;
        }


        .panel-shadow {
            box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
        }

        .panel-white {
            border: 1px solid #dddddd;
        }

        .panel-white .panel-heading {
            color: #333;
            background-color: #fff;
            border-color: #ddd;
        }

        .panel-white .panel-footer {
            background-color: #fff;
            border-color: #ddd;
        }

        .post .post-heading {
            height: 95px;
            padding: 20px 15px;
        }

        .post .post-heading .avatar {
            width: 60px;
            height: 60px;
            display: block;
            margin-right: 15px;
        }

        .post .post-heading .meta .title {
            margin-bottom: 0;
        }

        .post .post-heading .meta .title a {
            color: black;
            padding-right: 10px;
        }

        .post .post-heading .meta .title a:hover {
            color: #aaaaaa;
        }

        .post .post-heading .meta .time {
            margin-top: 8px;
            margin-right: 10px;
            color: #999;
        }

        .post .post-image .image {
            width: 100%;
            height: auto;
        }

        .post .post-description {
            padding: 15px;
            margin-right: 30px;
            text-align: right;
        }

        .post .post-description p {
            font-size: 20px;
        }

        .post .post-description .stats {
            margin-top: 20px;
        }

        .post .post-description .stats .stat-item {
            display: inline-block;
            margin-right: 15px;
        }

        .post .post-description .stats .stat-item .icon {
            margin-right: 8px;
        }

        .post .post-footer {
            border-top: 1px solid #ddd;
            padding: 15px;
        }

        .post .post-footer .input-group-addon a {
            color: #454545;
        }

        .post .post-footer .comments-list {
            padding: 0;
            margin-top: 20px;
            list-style-type: none;
        }

        .post .post-footer .comments-list .comment {
            display: block;
            width: 100%;
            margin: 20px 0;
        }

        .post .post-footer .comments-list .comment .avatar {
            width: 35px;
            height: 35px;
        }

        .post .post-footer .comments-list .comment .comment-heading {
            display: block;
            width: 100%;
        }

        .post .post-footer .comments-list .comment .comment-heading .user {
            font-size: 14px;
            font-weight: bold;
            display: inline;
            margin-top: 0;
            padding-left: 10px;
        }

        .post .post-footer .comments-list .comment .comment-heading .time {
            font-size: 12px;
            color: #aaa;
            margin-top: 0;
            display: inline;
        }

        .post .post-footer .comments-list .comment .comment-body {
            margin-right: 50px;
            text-align: right;
        }

        .post .post-footer .comments-list .comment > .comments-list {
            margin-right: 50px;
        }

    </style>
    <style>
        .thumbnail {
            margin-bottom: 20px
        }

        .thumbnail .thumb {
            position: relative;
            display: block
        }

        .thumbnail {
            height: auto;
            overflow: hidden;
        }

        .thumb-img {
            position: relative;
            display: block
        }

        .thumb-img:hover .caption-hover {
            background-color: rgba(0, 0, 0, 0.7);
            visibility: visible;
            opacity: 1;
            filter: alpha(opacity=100);
            position: absolute;
            width: 100%;
            height: 100%
        }

        a[data-lightbox="example-set"] .img-fluid, a[data-lightbox="roadtrip"] .img-fluid, a[data-toggle="lightbox"] .img-fluid {
            margin: 10px 0
        }

        .nav.navbar-nav > li > a {
            color: #ffffff;
        }

        .nav.navbar-nav > li > a {
            color: #ffffff !important;
        }

        .nav_menu {
            background: black;
        }

        body {
            color: #000000;
            background: #000000;
        }

        a {
            color: #ffffff;
        }

        body .container.body .right_col {
            background: #f6f7fb;
        }

        .left_col {
            background: #000000;
        }

        .nav_title, .sidebar-footer {
            background: #000000;
        }

        .nav-md .container.body .col-md-3.left_col {
            min-height: auto;
            width: 230px;
            position: fixed;

        }

        .nav-md .container.body .col-md-3.left_col {
            min-height: auto;
            width: 230px;
            /*position: fixed;*/

        }

        .nav-sm .container.body .col-md-3.left_col {
            min-height: auto;
            /*position: fixed;*/

        }

        .form-horizontal .checkbox, .form-horizontal .checkbox-inline, .form-horizontal .radio, .form-horizontal .radio-inline {
            padding-top: 0;
        }

        .post_user_name {
            color: black;
        }

        div.dt-buttons {
            position: relative;
            float: right;
        }
    </style>

    <style>

        .card-block {
            padding: 1.25rem
        }

        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            border: none;
            margin-bottom: 30px
        }

        .card .card-footer {
            background-color: #fff;
            border-top: none
        }

        .card .card-header {
            background-color: transparent;
            border-bottom: none;
            padding: 25px 20px
        }

        .card .card-header .card-header-left {
            display: inline-block
        }

        .card .card-header .card-header-right {
            border-radius: 0 0 0 7px;
            right: 10px;
            top: 18px;
            display: inline-block;
            float: right;
            padding: 7px 0;
            position: absolute
        }

        .card .card-header .card-header-right i {
            margin: 0 8px;
            cursor: pointer;
            font-size: 16px;
            color: #919aa3;
            line-height: 20px
        }

        .card .card-header .card-header-right i.icofont.icofont-spinner-alt-5 {
            display: none
        }

        .card .card-header .card-header-right .card-option {
            -webkit-transition: 0.3s ease-in-out;
            transition: 0.3s ease-in-out
        }

        .card .card-header .card-header-right .card-option li {
            display: inline-block
        }

        .card .card-header span {
            color: #919aa3;
            display: block;
            font-size: 13px;
            margin-top: 5px
        }

        .card .card-header + .card-block, .card .card-header + .card-block-big {
            padding-top: 0
        }

        .card .card-header h5 {
            margin-bottom: 0;
            color: #505458;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-right: 10px;
            line-height: 1.4
        }

        .card .card-block table tr {
            padding-bottom: 20px
        }

        .card .card-block .sub-title {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px
        }

        .card .card-block code {
            background-color: #eee;
            margin: 5px;
            display: inline-block
        }

        .card .card-block .dropdown-menu {
            top: 38px
        }

        .card .card-block p {
            line-height: 25px
        }

        .card .card-block a.dropdown-item {
            margin-bottom: 0;
            font-size: 14px;
            -webkit-transition: 0.25s;
            transition: 0.25s
        }

        .card .card-block a.dropdown-item:active, .card .card-block a.dropdown-item .active {
            background-color: #9a161c
        }

        .card .card-block.remove-label i {
            margin: 0;
            padding: 0
        }

        .card .card-block.button-list span.badge {
            margin-left: 5px
        }

        .card .card-block .dropdown-menu {
            background-color: #fff;
            padding: 0
        }

        .card .card-block .dropdown-menu .dropdown-divider {
            background-color: #ddd;
            margin: 3px 0
        }

        .card .card-block .dropdown-menu > a {
            padding: 10px 16px;
            line-height: 1.429
        }

        .card .card-block .dropdown-menu > li > a:focus, .card .card-block .dropdown-menu > li > a:hover {
            background-color: rgba(202, 206, 209, 0.5)
        }

        .card .card-block .dropdown-menu > li:first-child > a:first-child {
            border-top-right-radius: 4px;
            border-top-left-radius: 4px
        }

        .card .card-block .badge-box {
            padding: 10px;
            margin: 12px 0
        }

        .card .card-block-big {
            padding: 30px 35px
        }

        .card .card-block-small {
            padding: 15px 20px
        }

        .pcoded .card.full-card {
            position: fixed;
            top: 56px;
            z-index: 99999;
            -webkit-box-shadow: none;
            box-shadow: none;
            left: 0;
            border-radius: 0;
            border: 1px solid #ddd;
            width: 100vw;
            height: calc(100vh - 56px)
        }

        .pcoded .card.full-card.card-load {
            position: fixed
        }

        .pcoded .card.card-load {
            position: relative;
            overflow: hidden
        }

        .pcoded .card.card-load .card-loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 999
        }

        .pcoded .card.card-load .card-loader i {
            margin: 0 auto;
            color: #ab7967;
            font-size: 20px
        }

        .card-header-text {
            margin-bottom: 0;
            font-size: 1rem;
            color: rgba(51, 51, 51, 0.85);
            font-weight: 600;
            display: inline-block;
            vertical-align: middle
        }

        .nav-md .container.body .col-md-3.left_col {

            position: absolute;
        }

    </style>


</head>
<!-- /header content -->

<body class="nav-md">
<div class="container body">
    <div class="main_container">

        <!-- /top navigation -->

    @include('adminpanel.includeHF.header')
    <!-- /header content -->

        <!-- page content -->
    @yield('content')

    <!-- /page content -->

        <!-- footer content -->

    @include('adminpanel.includeHF.footer')
    <!-- /footer content -->
    </div>
</div>
<!-- lock_screen -->

@include('adminpanel.includeHF.lock_screen')

<!-- lock_screen -->
<!-- jQuery -->
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>

<!-- bootstrap-daterangepicker -->
<script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>

<script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('build/js/custom.min.js') }}"></script>
<!-- خاص بجزئية الحذف -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
<!--datatable -->
{{--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>--}}


/***************************/
<script src="{!! asset('new_admin/js/dropzone.js') !!}"></script>
<script src="{!! asset('new_admin/js/image-picker.js') !!}"></script>
<script src="{!! asset('new_admin/js/image-picker.min.js') !!}"></script>
/***************************/
<script src="{!! asset('newLibs/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('newLibs/data-table/extensions/buttons/js/dataTables.buttons.min.js') !!}"></script>
<script src="{!! asset('newLibs/data-table/extensions/buttons/js/jszip.min.js') !!}"></script>
<script src="{!! asset('newLibs/datatables.net-buttons/js/buttons.print.min.js') !!}"></script>
<script src="{!! asset('newLibs/datatables.net-buttons/js\buttons.html5.min.js') !!}"></script>
<script src="{!! asset('newLibs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('newLibs\lightbox2\js\lightbox.min.js') !!}"></script>
@yield('scripts')
</body>

</html>

