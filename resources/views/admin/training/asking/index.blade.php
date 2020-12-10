@extends('adminpanel.master')

@section('content')

    <div class="right_col" role="main">
        <div class="row tile_count">
            <div style="font-weight: bold"><b>الاحصائيات</b></div>
            <br>

            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #eea236;">
                <div class="card">
                    <div class="card-block">
                        <span class="count_top" style="font-weight: bold"><i class="fa fa-user"
                                                                             style="font-size: 20px"></i> عدد المستخدمين</span>
                        <div class="count">{{$users}}</div>
                    </div>
                </div>

            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style=" color: #0055cc;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-user-circle"
                                                                     style="font-size: 20px"></i> عدد الموظفين</span>
                        <div class="count">{{$employees}} </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style=" color: #374E0C;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-user-plus"
                                                                     style="font-size: 20px"></i> عدد الشركاء</span>
                        <div class="count">{{$shareduser}} </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #AA22FF;">
                <div class="card">
                    <div class="card-block">
                        <div class="count_top" style="font-weight: bold"><i class="fa fa-female"
                                                                            style="font-size: 20px"></i>
                            منشورات حقوق المراءة
                        </div>
                        <div class="count">{{$women}}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #265a88;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-question-circle"
                                                                     style="font-size: 20px"></i> منشورات الاستشارات</span>
                        <div class="count">{{$pos}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #6B6464;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-mortar-board"
                                                                     style="font-size: 20px"></i> عدد الدورات التدريبية</span>
                        <div class="count">{{$trainings}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #82ad2b;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-check-circle"
                                                                     style="font-size: 20px"></i> استشارات تم قبولها</span>
                        <div class="count">{{$pos_agree}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #dd0066;">
                <div class="card">
                    <div class="card-block">
                        <span class="count_top" style="font-weight: bold"><i class="fa fa-close"
                                                                             style="font-size: 20px"></i> استشارات تم رفضها</span>
                        <div class="count">{{$soft_delete}}</div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #eea236;">
                <div class="card">
                    <div class="card-block">
                        <span class="count_top" style="font-weight: bold"><i class="fa fa-tags"
                                                                             style="font-size: 20px"></i> عدد الاصناف </span>
                        <div class="count">{{$shopCategory}}</div>
                    </div>
                </div>

            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style=" color: #0055cc;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-product-hunt"
                                                                     style="font-size: 20px"></i> عدد المنتجات </span>
                        <div class="count">{{$products}} </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style=" color: #374E0C;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-user-plus"
                                                                     style="font-size: 20px"></i> عدد البائعين </span>
                        <div class="count">{{$seller}} </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #AA22FF;">
                <div class="card">
                    <div class="card-block">
                        <div class="count_top" style="font-weight: bold"><i class="fa fa-cart-plus"
                                                                            style="font-size: 20px"></i>
                            عدد الطلبات
                        </div>
                        <div class="count">{{$all_orders}}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #265a88;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-question-circle"
                                                                     style="font-size: 20px"></i> عدد  الطلبات الجديدة </span>
                        <div class="count">{{$new_orders}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #6B6464;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-hand-grab-o"
                                                                     style="font-size: 20px"></i>  الطلبات المسلمة  </span>
                        <div class="count">{{$deliver_orders}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #82ad2b;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-check-circle"
                                                                     style="font-size: 20px"></i> الطلبات المدفوعة </span>
                        <div class="count">{{$all_payment_orders}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #dd0066;">
                <div class="card">
                    <div class="card-block">
                        <span class="count_top" style="font-weight: bold"><i class="fa fa-close"
                                                                             style="font-size: 20px"></i>  الطلبات غير المدفوعة </span>
                        <div class="count">{{$all_no_payment_orders}}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #265a88;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-question-circle"
                                                                     style="font-size: 20px"></i> عدد  الطلبات الملغية </span>
                        <div class="count">{{$cancel_orders}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #6B6464;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-id-card"
                                                                     style="font-size: 20px"></i>  عدد الكوبونات  </span>
                        <div class="count">{{$coupons}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #82ad2b;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-check-circle"
                                                                     style="font-size: 20px"></i> عدد الكوبونات  المستخدمة </span>
                        <div class="count">{{$coupons_used}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #dd0066;">
                <div class="card">
                    <div class="card-block">
                        <span class="count_top" style="font-weight: bold"><i class="fa fa-close"
                                                                             style="font-size: 20px"></i>  عدد الكوبونات غير المستخدمة </span>
                        <div class="count">{{$coupons_not_used}}</div>
                    </div>
                </div>
            </div>
        </div>

        @if ((Auth::user()->can('manage consultant') == true))

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>طلبات نشر الاستشارات</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <button style="margin: 5px;" class="btn btn-primary  btn-sm update-all" data-url="">موافقة
                        </button>
                        <button style="margin: 5px;" class="btn btn-danger btn-sm delete-all" data-url="">رفض</button>
                        @csrf
                        @include('admin.training.asking.fetch')
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).on('click', '.post_update', function (e) {
            e.preventDefault();

            var offer_id = $(this).attr('post_id');
            $.ajax({
                type: 'post',
                url: '{{ route('update') }}',
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': offer_id,
                },
                success: function (data) {
                    if (data.status == true) {
                        $('.OfferRow' + data.id).remove();
                    } else {
                        if (alert('لايمكن الموافقة على المنشور قم باستعادة حساب المستخدم اولا  ')) {
                            return null;
                        }
                    }
                }, erorr: function (reject) {
                },
            });
        });

        {{--هذا الجزء خاص الحذف--}}

        $(document).on('click', '.offer_btn_id', function (e) {
            e.preventDefault();
            var offer_id = $(this).attr('offer_id');
            $.ajax({
                type: 'post',
                url: '{{ route('delete') }}',
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': offer_id,
                },
                success: function (data) {
                    if (data.status == true) {
                        $('#success').show();
                    }
                    $('.OfferRow' + data.id).remove();
                }, erorr: function (reject) {
                },
            });
        });

        {{--هذا الجزء خاص بحذف عدة صفوف--}}

        $(document).ready(function () {

            $('#check_all').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked', false);
                }
            });

            $('.checkbox').on('click', function () {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#check_all').prop('checked', true);
                } else {
                    $('#check_all').prop('checked', false);
                }
            });

            $('.delete-all').on('click', function (e) {


                var idsArr = [];
                $(".checkbox:checked").each(function () {
                    idsArr.push($(this).attr('data-id'));
                });


                if (idsArr.length <= 0) {
                    alert("قم باختيار عنصر او اكثر للحذف ^_^");
                } else {

                    if (confirm("هل انت متاكد من رفض نشر العناصر المحددة؟")) {

                        var strIds = idsArr.join(",");

                        $.ajax({
                            url: "{{ route('post.multiple-delete') }}",
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids=' + strIds,
                            success: function (data) {
                                if (data['status'] == true) {
                                    $(".checkbox:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['message']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });


                    }
                }
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.closest('form').submit();
                }
            });

        });

        {{--هذا الجزء خاص بموافقة عدة صفوف--}}

        $(document).ready(function () {

            $('#check_all').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked', false);
                }
            });

            $('.checkbox').on('click', function () {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#check_all').prop('checked', true);
                } else {
                    $('#check_all').prop('checked', false);
                }
            });

            $('.update-all').on('click', function (e) {


                var idsArr = [];
                $(".checkbox:checked").each(function () {
                    idsArr.push($(this).attr('data-id'));
                });


                if (idsArr.length <= 0) {
                    alert("قم باختيار عنصر او اكثر للموافقة ^_^");
                } else {

                    if (confirm("هل انت متاكد من موافقة نشر العناصر المحددة؟")) {

                        var strIds = idsArr.join(",");

                        $.ajax({
                            url: "{{ route('post.multiple-update') }}",
                            type: 'post',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids=' + strIds,
                            success: function (data) {
                                if (data['status'] == true) {
                                    $(".checkbox:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['message']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                    }
                }
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.closest('form').submit();
                }
            });

        });

        {{--هذا الجزء خاص بالباجنيشن --}}

        $(document).ready(function () {

            $(document).on('click', '.page-link', function (event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                var _token = $("input[name=_token]").val();
                $.ajax({
                    url: "{{ route('fetch') }}",
                    method: "POST",
                    data: {_token: _token, page: page},
                    success: function (data) {
                        $('#table_data').html(data);
                    }
                });
            }

        });
    </script>
@endsection


