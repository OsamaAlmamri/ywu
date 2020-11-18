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
                                                                             style="font-size: 20px"></i> عدد المنتجات </span>
                        <div class="count">{{$products}}</div>
                    </div>
                </div>

            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style=" color: #0055cc;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-user-circle"
                                                                     style="font-size: 20px"></i> عدد الطلبات</span>
                        <div class="count">{{$all_orders}} </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style=" color: #374E0C;">
                <div class="card">
                    <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-user-plus"
                                                                     style="font-size: 20px"></i> عدد الطلبات الجديدة</span>
                        <div class="count">{{$new_orders}} </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #AA22FF;">
                <div class="card">
                    <div class="card-block">
                        <div class="count_top" style="font-weight: bold"><i class="fa fa-female"
                                                                            style="font-size: 20px"></i>
                          عدد الطلبات المسلمة
                        </div>
                        <div class="count">{{$deliver_orders}}</div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection



