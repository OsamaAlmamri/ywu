@extends('adminpanel.dataTableLayout')
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <div class="x_content">
                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12 invoice-header">
                            <h1>
                                <i class="fa fa-user"></i> صاحب الطلب .
                                <small class="pull-left">تاریخ الطلب : {{$order_seller->order->created_at}}</small>
                            </h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-xs-6 col-sm-4 invoice-col">
                            صاحب الطلب
                            <address>
                                <strong> {{$order_seller->seller_name}}.</strong>
                                <br>{{$order_seller->order->gov}}
                                <br>{{$order_seller->order->district}},{{$order_seller->order->more_address_info}}
                                <br> رقم النلفون : {{$order_seller->order->user->name}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6 col-sm-4 invoice-col">
                            مستلم الطلب
                            <address>
                                <strong> {{$order_seller->seller_name}}.</strong>
                                <br>{{$order_seller->order->gov}}
                                <br>{{$order_seller->order->district}},{{$order_seller->order->more_address_info}}
                                <br> رقم النلفون : {{$order_seller->order->user->name}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-12 col-sm-4 invoice-col">
                            <span>رقم الطلب <b dir="ltr">#{{$order_seller->id}}</b></span>
                            <br>
                            <br>
                            <b>تكلفة الطلب :</b> {{$order_seller->price}}
                            {{--                            <br>--}}
                            {{--                            <b>پرداخت هزینه:</b> 1396/09/12--}}
                            {{--                            <br>--}}
                            {{--                            <b>حساب:</b> 968-34567--}}
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>العدد</th>
                                    <th>الصنف</th>
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
                                               ( {{$att->products_options_name}}, {{$att->products_options_values_name}})
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
                    <!-- /.row -->

{{--                    <div class="row">--}}
{{--                        <!-- accepted payments column -->--}}
{{--                        <div class="col-xs-6">--}}
{{--                            <p class="lead">روش‌های پرداخت:</p>--}}
{{--                            <img src="../build/images/visa.png" alt="Visa">--}}
{{--                            <img src="../build/images/mastercard.png" alt="Mastercard">--}}
{{--                            <img src="../build/images/american-express.png" alt="American Express">--}}
{{--                            <img src="../build/images/paypal.png" alt="Paypal">--}}
{{--                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">لورم ایپسوم--}}
{{--                                متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک--}}
{{--                                است.</p>--}}
{{--                        </div>--}}
{{--                        <!-- /.col -->--}}
{{--                        <div class="col-xs-6">--}}
{{--                            <p class="lead">پرداخت شده در 1396/09/12</p>--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table">--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <th style="width:50%">مجموع:</th>--}}
{{--                                        <td>۵۸۰,۰۰۰ ریال</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th>مالیات (9.3%)</th>--}}
{{--                                        <td>53,940 ریال</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th>هزینه ارسال:</th>--}}
{{--                                        <td>۱۰۰,۰۰۰ ریال</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th>قابل پرداخت:</th>--}}
{{--                                        <td>733,940 ریال</td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- /.col -->--}}
{{--                    </div>--}}
{{--                    <!-- /.row -->--}}

                    <!-- this row will not appear when printing -->
                    <div class="row no-print hidden-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onclick="window.print();"><i
                                    class="fa fa-print"></i> طباعة
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection



@section('custom_js')
    <script>

        $(document).on('click', '.replay_btn', function () {
            $('#replayModal').modal('show');
            $("#ques_ques_replay_id").val(0);
            $("#question_reply").val('');
        });


        $(document).on('click', '.btn_update_replay', function () {
            $('#replayModal').modal('show');
            var id = $(this).data('id');
            var old = $('#replay_text_' + id).text();
            $("#ques_ques_replay_id").val(id)
            $("#question_reply").val(old);
        });


        $(document).on('click', '.btn_delete_replay', function () {

            if (confirm('هل تريد حذف هذا الاستفسار') == true) {
                var id = $(this).data('id');
                var data = '_token=' + encodeURIComponent("{{csrf_token()}}")
                    + '&reply_id=' + id;
                $.ajax({
                    type: 'POST',
                    url: '{{ route("admin.shop.product_questions.delete_replay")}}', //Returns ID in body
                    data: data,
                    // async: false, // <<== THAT makes us wait until the server is done.
                    success: function (data) {
                        if (data == 1)
                            $('#replay_dev_' + id).remove();
                        else
                            alert(('حدث خطاء ماء اثناء الحذف'))
                    },
                    error: function (jqXhr, status) {
                        console.log(jqXhr);
                        // alert("Your error message goes here");
                    }
                });
            }

        });


        $(document).on('click', '#btnSendReply', function (e) {
                var ques_ques_id = $('#ques_ques_id').val();
                var question_reply = $('#question_reply').val();
                var ques_ques_replay_id = $('#ques_ques_replay_id').val();
                var describtion = $('#question_reply').val();
                var describtion = describtion.replace(/\s+/g, '');
                if (describtion == '')
                    alert('يجب الرد على السؤوال');
                else {
                    var data = '_token=' + encodeURIComponent("{{csrf_token()}}")
                        + '&ques_ques_id=' + ques_ques_id
                        + '&ques_ques_replay_id=' + ques_ques_replay_id
                        + '&reply=' + question_reply;
                    $.ajax({
                        type: 'POST',
                        url: '{{route("admin.shop.product_questions.replay")}}', //Returns ID in body
                        data: data,
                        // async: false, // <<== THAT makes us wait until the server is done.
                        success: function (data) {
                            $('#ReplyText' + ques_ques_id).text(question_reply);
                            $('#replayModal').modal('hide');
                            if (ques_ques_replay_id == 0)
                                location.reload();
                            else
                                $('#replay_text_' + ques_ques_replay_id).text(question_reply);
                        },
                        error: function (jqXhr, status) {
                            console.log(jqXhr);
                            // alert("Your error message goes here");
                        }
                    });
                }
            }
        );
    </script>
@endsection
