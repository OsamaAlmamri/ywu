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
                            </address>
                        </div>
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            <span>رقم الطلب <b dir="ltr">#{{$order_seller->id}}</b></span>
                            @if (auth()->user()->type=='admin')

                                <span>رقم الطلب الاساسي <b dir="ltr">#
                               <a href="{{route('admin.shop.orders.show_main_order',$order_seller->id)}}"> {{$order_seller->id}} </a></b></span>
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
                        @if ((Auth::user()->can('manage orders') == true))

                            <div class="col-xs-6">
                                <button class="btn btn-default" id="change_status"><i
                                        class="fa fa-share"></i> تغيير حالة الطلب
                                </button>
                            </div>
                        @endif
                    </div>
                </section>
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
                            <label class="control-label col-sm-4">الصنف :</label>
                            <div class="col-sm-8">

                                {!!Form ::select('status', getSellerOrderStatus(0),'',['class' => ' form-control', 'id' => 'filter_status'])!!}

                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_category_id"></span>

                        </div>
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
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
                    $('#confirmModal').modal('hide');
                }
            });
        });


    </script>
@endsection
