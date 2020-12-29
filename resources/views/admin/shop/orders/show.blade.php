@extends('adminpanel.dataTableLayout')
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <div class="x_content">
                <section class="content invoice">
                    <div class="row">
                        <div class="col-xs-12 invoice-header">
                            <h1>
                                <i class="fa fa-user"></i> صاحب الطلب .
                                <small class="pull-left">تاریخ الطلب : {{$order_seller->order->created_at}}</small>
                            </h1>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            صاحب الطلب
                            <address>
                                <strong> {{$order_seller->order->user->name}}.</strong>
                                <br> {{$order_seller->order->user->gov}},{{$order_seller->order->user->district}}
                                ,{{$order_seller->order->user->more_address_info}}
                                <br> رقم النلفون : {{$order_seller->order->user->phone}}
                            </address>
                        </div>
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            مستلم الطلب
                            <address>
                                <strong> {{$order_seller->order->customer_name}}.</strong>
                                <br>{{$order_seller->order->gov}}
                                ,{{$order_seller->order->district}},{{$order_seller->order->more_address_info}}
                                <br> رقم النلفون : {{$order_seller->order->phone}}
                                <br><strong>مكان التسليم المتفق</strong> : <span
                                    id="new_delivery_location_label">{{$order_seller->new_delivery_location}}</span>
                            </address>
                        </div>
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            <span>رقم الطلب <b dir="ltr">#{{$order_seller->id}}</b></span>
                            @if (auth()->user()->type=='admin')

                                <span>رقم الطلب الاساسي <b dir="ltr">#
                               <a href="{{route('admin.shop.orders.show_main_order',$order_seller->order_id)}}"> {{$order_seller->order_id}} </a></b></span>
                            @endif
                            <br>
                            @if($order_seller->coupon_discount>0)
                                <b> الكوبون :</b> {{$order_seller->coupon}}
                                <b>تخفيض الكوبون :</b> {{$order_seller->coupon_discount}}
                                <br>
                            @endif

                            <b>تكلفة الطلب :</b> {{$order_seller->price}}
                            @if($order_seller->coupon_discount>0)
                                <b> على العميل :</b> {{$order_seller->price-$order_seller->coupon_discount}}
                            @endif
                            <br>

                            <b>حالة الطلب :</b> <span id="status_name_label">{{$order_seller->order_status_name}}</span>
                            <br> <b>طريقة الدفع :</b> {{trans("status.payment_method.".$order_seller->payment_method)}}
                            <b> حالة الدفع :</b> {{$order_seller->payment_status_name}}

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 table">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>العدد</th>
                                    <th>الحالة الجديدة</th>
                                    <th>المنتج</th>
                                    <th style="width: 49%">خيارات المنتج</th>
                                    <th>سعر الوحدة</th>
                                    <th> الاجمالي</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order_seller->products as $product)
                                    <tr>
                                        <td>{{$product->quantity}}</td>
                                        <td>{{$product->product->category}} </td>
                                        <td>{{$product->product->name}} </td>
                                        <td>{
                                            @foreach($product->product_attributes_descriptions as $att)
                                                ( {{$att->products_options_name}}
                                                , {{$att->products_options_values_name}})
                                            @endforeach
                                            }
                                        </td>
                                        <td> {{$product->price}} ریال</td>
                                        <td> {{$product->price * $product->quantity }} ریال</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row no-print hidden-print">
                        <div class="col-xs-6">
                            <button class="btn btn-default" onclick="window.print();"><i
                                    class="fa fa-print"></i> طباعة
                            </button>
                        </div>
                        @if ((Auth::user()->can('manage orders') == true) )
                            @if ($order_seller->status!="cancel_by_user" and ($order_seller->status!="cancel_by_seller"))

                                <div class="col-xs-6">
                                    <button class="btn btn-default" id="change_status"><i
                                            class="fa fa-share"></i> تغيير حالة الطلب
                                    </button>

                                    <button class="btn btn-default" id="add_address"><i
                                            class="fa fa-map-marker"></i> تحديد مكان التسليم
                                    </button>

                                    @if (!in_array($order_seller->status, ['cancel_by_user','shipping', 'delivery']))

                                        <button class="btn btn-warning" id="cance_order"><i
                                                class="fa fa-trash"></i>الغاء الطلب
                                        </button>
                                    @endif

                                </div>
                            @endif
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>


    <div id="cancel_model" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> الغاء الطلب </h4>

                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">سبب اللغاء :</label>
                            <textarea style="margin: 0px; width: 100%; height: 183px;" rows="3" id="cancel_description">

</textarea>

                            <span class="print-error-msg alert-danger" id="modal_error_description"></span>

                        </div>

                        <input type="button" name="cancel_action_button" id="cancel_action_button"
                               class="btn btn-warning"
                               value="تاكيد اللغاء"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="add_addressModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> تحديد مكان التسليم </h4>

                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">مكان تسليم الطلب :</label>


                            <div class="col-sm-8">
                                <input type="text" id="new_delivery_location" class="form-control" >

                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_new_delivery_location"></span>

                        </div>

                        <input type="button" name="new_delivery_location_action_button"
                               id="new_delivery_location_action_button"
                               class="btn btn-warning"
                               value="تاكيد "/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> تغيير حالة الطلب </h4>


                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">الحالة الجديدة :</label>
                            <div class="col-sm-8">

                                {!!Form ::select('status', getSellerOrderStatus(0),'',['class' => ' form-control', 'id' => 'filter_status'])!!}

                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_category_id"></span>

                        </div>
                        <input type="button" name="action_button" id="action_button" class="btn btn-warning"
                               value="تغيير"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('custom_js')
    <script>
        $(document).on('click', '#change_status', function (e) {
            $('#formModal').modal('show');
            e.preventDefault();
        });

        $(document).on('click', '#add_address', function (e) {
            $('#add_addressModal').modal('show');
            e.preventDefault();
        });

        $(document).on('click', '#cance_order', function (e) {
            $('#cancel_model').modal('show');
            e.preventDefault();
        });
        $('#cancel_action_button').click(function () {
            $.ajax({
                url: "{{route('admin.shop.orders.change_sub_status')}}",
                method: 'post',
                dataType: 'json',// data type that i want to return
                data: '_token=' + ("{{csrf_token()}}") +
                    '&order_id=' + "{{$order_seller->id}}" +
                    '&status=' + "cancel_by_seller" +
                    '&description=' + $("#cancel_description").val(),
                beforeSend: function () {
                    $('#ok_button').text('جاري الالغاء ...');
                },
                success: function (data) {
                    $("#cancel_model .print-error-msg").html('');

                    $("#status_name_label").html(data.order_status_name);
                    toastr.info("تم الغاء الطلب بنجاح");
                    $('#change_status').remove();
                    $('#cance_order').remove();
                    $('#confirmModal').modal('hide');
                },
                error: function (jqXhr, status) {
                    console.log(jqXhr);
                    if (jqXhr.status === 422) {
                        $("#cancel_model .print-error-msg").html('');
                        var errors = jqXhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $("#cancel_model").find("#modal_error_" + key).html(value);
                        });
                    }
                }

            });
        });

        $('#new_delivery_location_action_button').click(function () {
            $.ajax({
                url: "{{route('admin.shop.orders.new_delivery_location')}}",
                method: 'post',
                dataType: 'json',// data type that i want to return
                data: '_token=' + ("{{csrf_token()}}") +
                    '&order_id=' + "{{$order_seller->id}}" +
                    '&new_delivery_location=' + $("#new_delivery_location").val(),
                beforeSend: function () {
                    $('#ok_button').text('جاري التاكيد ...');
                },
                success: function (data) {
                    $("#cancel_model .print-error-msg").html('');

                    $("#status_name_label").html(data.order_status_name);
                    toastr.info("تم تحديد المكان  بنجاح");

                    $('#new_delivery_location_label').html($("#new_delivery_location").val());
                    $('#add_addressModal').modal('hide');
                },
                error: function (jqXhr, status) {
                    console.log(jqXhr);
                    if (jqXhr.status === 422) {
                        $("#add_addressModal .print-error-msg").html('');
                        var errors = jqXhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $("#add_addressModal").find("#modal_error_" + key).html(value);
                        });
                    }
                }

            });
        });

        $('#action_button').click(function () {
            $.ajax({
                url: "{{route('admin.shop.orders.change_sub_status')}}",
                method: 'post',
                dataType: 'json',// data type that i want to return
                data: '_token=' + ("{{csrf_token()}}") +
                    '&order_id=' + "{{$order_seller->id}}" +
                    '&status=' + $("#filter_status").val(),
                beforeSend: function () {
                    $('#ok_button').text('جاري التاكيد...');
                },
                success: function (data) {
                    $("#status_name_label").html(data.order_status_name);
                    toastr.info("تم تغيير حالة الطلب بنجاح");
                    $('#confirmModal').modal('hide');
                }
            });
        });


    </script>
@endsection
