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
    <link href="{!! asset('new_admin/css/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css"/>

    <link href="{!! asset('new_admin/css/image-picker.css') !!}" media="all" rel="stylesheet" type="text/css"/>

    <!-- cdn -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        window.csrf_token = "{{ csrf_token() }}"
    </script>
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
    <link href="{!! asset('new_admin/css/custom.css') !!}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('new_admin/css/styles.css') !!}" media="all" rel="stylesheet" type="text/css"/>
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

