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
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->

    {{--    <link href="{{  asset('vendors/bootstrap/dist/css/bootstrap.min.css')  }}" rel="stylesheet">--}}
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
    <link href="{!! asset('js/dataTables.bootstrap.min.css') !!}" media="all" rel="stylesheet">
    <link href="{!! asset('newLibs/data-table/css/buttons.dataTables.min.css') !!}" media="all" rel="stylesheet">
    <link href="{!! asset('newLibs/data-table/css/buttons.dataTables.min.css') !!}" media="all" rel="stylesheet">
    type="text/css"/>
    <link href="{!! asset('newLibs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}"
          media="all" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('newLibs/data-table/extensions/responsive/css/responsive.dataTables.css') !!}"
          media="all" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('newLibs\lightbox2\css\lightbox.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <link href="{!! asset('new_admin/css/custom.css') !!}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('new_admin/css/styles.css') !!}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('newLibs\toastr\toastr.css') !!}" media="all" rel="stylesheet" type="text/css"/>
    <script
        src="https://cdn.tiny.cloud/1/ldt6r8rxr9v18fsljk2n08p2tc1sjecegs1z8j9ssv2ya90d/tinymce/5/tinymce.min.js"></script>

    <style>

        #social-links {
            text-align: center;
            margin-top: 10px;
        }

        #social-links ul {
            list-style: none;
            display: inline-block;
        }

        #social-links ul li {
            font-size: 20px;
            float: right;
            padding: 6px;
        }

        #social-links span.fa {
            display: block;
        }

        .my_store_url {
            font-size: 17px;
            color: blue;
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
        {{--        @if (auth()->user()->type=="seller")--}}
        <div id="my_store_link" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">مشاركة الرابط الخاص بمتجري </h4>


                    </div>
                    <div class="modal-body">
                        <a class="my_store_url" href="https://https://yemenwe.com/shop/seller/{{auth()->id()}}"
                           target="_blank">
                            فتح متجري
                        </a>
                        {!! Share::page("https://yemenwe.com/shop/seller/".auth()->id(), null, ['class' => 'my_store_links' ])
                                        ->facebook()
                                        ->whatsapp()
                                        ->twitter()
                                        ->telegram()
                                        ->linkedin()
                                   !!}

                    </div>
                </div>
            </div>
        </div>

    {{--   @endif--}}

    @include('adminpanel.includeHF.footer')
    <!-- /footer content -->
    </div>
</div>
<!-- lock_screen -->
<div id="sound"></div>

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
<script src="{!! asset('new_admin/js/image-picker.min.js') !!}"></script>
/***************************/
<script src="{!! asset('newLibs/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('newLibs/data-table/extensions/buttons/js/dataTables.buttons.min.js') !!}"></script>
<script src="{!! asset('newLibs/data-table/extensions/buttons/js/jszip.min.js') !!}"></script>
<script src="{!! asset('newLibs/datatables.net-buttons/js/buttons.print.min.js') !!}"></script>
<script src="{!! asset('newLibs/datatables.net-buttons/js\buttons.html5.min.js') !!}"></script>
<script src="{!! asset('newLibs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('newLibs\lightbox2\js\lightbox.min.js') !!}"></script>
<script src="{!! asset('newLibs\toastr\toastr.min.js') !!}"></script>
@yield('scripts')
<!-- Custom js -->
<script src="{{asset('firebase\firebase-app.js')}}"></script>
<script src="{{asset('firebase\firebase-messaging.js')}}"></script>
<script src="{{asset('firebase\firebase-firestore.js')}}"></script>
<script src="{{asset('firebase\firebase-analytics.js')}}"></script>

<script src="{{ asset('js/share.js') }}"></script>
<script>

    $(document).on('click', '#open_my_store', function (e) {
        $('#my_store_link').modal('show');
    });


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

</body>

</html>

