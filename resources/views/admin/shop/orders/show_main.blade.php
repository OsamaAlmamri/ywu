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
                                <i class="fa fa-shopping-cart"></i> معلومات الطلب .
                                <small class="pull-left">تاریخ الطلب : {{$order->created_at}}</small>
                            </h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            صاحب الطلب
                            <address>
                                <strong> {{$order->user_name}}.</strong>
                                <br>{{$order->user->gov}},{{$order->district}},{{$order->user->more_address_info}}
                                <br> رقم النلفون : {{$order->user->phone}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            مستلم الطلب
                            <address>
                                <strong> {{$order->customer_name}}.</strong>
                                <br>{{$order->gov}},{{$order->district}},{{$order->more_address_info}}
                                <br> رقم النلفون : {{$order->phone}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            <span>رقم الطلب <b dir="ltr">#{{$order->id}}</b></span>
                            <br>
                            @if($order->coupon_discount>0)
                                <b> الكوبون :</b> {{$order->coupon_discount}}
                                <b>تخفيض الكوبون :</b> {{$order->coupon_discount}}

                            @endif
                            <br>
                            <b>تكلفة الطلب :</b> {{$order->price}}
                            @if($order->coupon_discount>0)
                                <b>بعد التخفيض :</b> {{$order->price-$order->coupon_discount}}
                            @endif
                            <br>
                            <b>حالة الطلب :</b> {{trans('status.payment_'.$order->payment_status)}}

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                @foreach($order->sellers as $order_seller )
                    <!-- Table row -->

                        <div style="margin: 2px 25px; padding: 5px; border: 1px solid;">
                            <div class="row invoice-info">
                                <div class="col-xs-6 col-sm-4 invoice-col">
                                    صاحب المتجر
                                    <address>
                                        <strong> {{$order_seller->admin->name}}.</strong>
                                        <br> الاسم التجاري : {{$order_seller->admin->seller->sale_name}}
                                        <br>{{$order_seller->admin->seller->gov}}
                                        ,{{$order_seller->admin->seller->district}}
                                        ,{{$order_seller->admin->seller->more_address_info}}
                                        <br> رقم النلفون : {{$order_seller->admin->phone}}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <!-- /.col -->
                                <div class="col-xs-6  invoice-col">
                                    <span>رقم الطلب <b dir="ltr">#{{$order_seller->id}}</b></span>
                                    <br>
                                    <br>
                                    <b>تكلفة الطلب :</b> {{$order_seller->price}}
                                    <br>
                                    <b> حالة الطلب :</b> {{$order_seller->order_status_name}}
                                    {{--                            <br>--}}
                                    {{--                            <b>پرداخت هزینه:</b> 1396/09/12--}}
                                    {{--                            <br>--}}
                                    {{--                            <b>حساب:</b> 968-34567--}}
                                </div>
                                <!-- /.col -->
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
                        </div>

                    @endforeach

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




