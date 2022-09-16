@extends('adminpanel.dataTableLayout')
@section('content')

    <div class="right_col" style="direction: {{session('lang','ar')=='ar'?'rtl':'ltr'}}" role="main">
        <div class="container">
            <div class="x_content">
                <section class="content invoice">
                    <!-- title row -->

                    <div class="row">
                        <div class="col-12 invoice-header">
                            <h4>
                                <i class="fa fa-shopping-cart"></i> @lang('order.information_date')  .
                                <small class="pull-left">@lang('order.order_date')  : {{$order->created_at}}</small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            @lang('order.bill_to')
                            <address>
                                <strong> {{$order->user_name}}.</strong>
                                <br>{{$order->user->gov}},{{$order->user->district}},{{$order->user->more_address_info}}
                                <br>@lang('order.phone_number'): {{$order->user->phone}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4 col-sm-4 invoice-col">

                            @lang('order.ship_to')
                            <address>
                                <strong> {{$order->customer_name}}.</strong>
                                <br>{{$order->gov}},{{$order->district}},{{$order->more_address_info}}
                                <br>@lang('order.phone_number'): {{$order->phone}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4 col-sm-4 invoice-col">
                            <span> @lang('order.order_number')  <b dir="ltr">#{{$order->id}}</b></span>

                            <br>
                            @if($order->coupon_discount>0)
                                <b>  @lang('order.coupon') :</b> {{$order->coupon}}
                                <b> @lang('order.coupon_discount')   :</b> {{$order->coupon_discount}}

                            @endif
                            <br>
                            <b> @lang('order.order_cost') :</b> {{$order->price}}
                            @if($order->coupon_discount>0)
                                <b>@lang('order.after_discount')  :</b> {{$order->price-$order->coupon_discount}}
                            @endif
                            <br>
{{--                            {{dd($order)}}--}}
{{--                            <b> @lang('order.order_status') :</b> {{trans('status.order_'.$order->order_status)}}--}}

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                @foreach($order->sellers as $order_seller )
                    <!-- Table row -->

                        <div style="margin: 2px 25px; padding: 5px; border: 1px solid;">
                            <div class="row invoice-info">
                                <div class="col-xs-6 col-sm-4 invoice-col">
                                    @lang('order.seller_name')
                                    <address>
                                        <strong> {{$order_seller->admin->name}}.</strong>
                                        <br>  @lang('order.trade_name')  : {{$order_seller->admin->seller->sale_name}}
                                        <br>{{$order_seller->admin->seller->gov}}
                                        ,{{$order_seller->admin->seller->district}}
                                        ,{{$order_seller->admin->seller->more_address_info}}
                                        <br>@lang('order.phone_number'): {{$order_seller->admin->phone}}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <!-- /.col -->
                                <div class="col-xs-6  invoice-col">
                                    <span>@lang('order.order_number')<b dir="ltr">#
                                            <a href="{{route('admin.shop.orders.show_seller_order',$order_seller->id)}}"> {{$order_seller->id}} </a></b></span>
                                    <br>
                                    @if($order_seller->coupon_discount>0)
                                        <b>  @lang('order.coupon')  :</b> {{$order_seller->coupon}}
                                        <b>@lang('order.coupon_discount')  :</b> {{$order_seller->coupon_discount}}
                                    @endif

                                    <br>
                                    <b> @lang('order.order_cost')  :</b> {{$order_seller->price}}
                                    @if($order_seller->coupon_discount>0)
                                        <b> @lang('order.by_the_client')  :</b> {{$order_seller->price-$order_seller->coupon_discount}}
                                    @endif

                                    <b>@lang('order.order_status') :</b> <span id="status_name_label">{{$order_seller->order_status_name}}</span>
                                    <br> <b>@lang('order.payment_method') :</b> {{trans("status.payment_method.".$order_seller->payment_method)}}
                                    <b> @lang('order.payment_status')  :</b>
                                    <span id="payment_status_name_label">
                            {{$order_seller->payment_status_name}}
                            </span>
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
                                            <th>@lang('order.quantity')</th>
                                            <th>@lang('order.item') </th>
                                            <th>@lang('order.product')</th>
                                            <th style="width: 29%">@lang('order.product_options') </th>
                                            <th> @lang('order.unit_price')</th>
                                            <th> @lang('order.total')</th>
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
                                                <td> {{$product->price}} @lang('order.real')</td>
                                                <td> {{$product->price * $product->quantity }} @lang('order.real')</td>
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




