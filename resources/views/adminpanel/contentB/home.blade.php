@extends('adminpanel.master')

@section('content')
    <div class="right_col" role="main">
        <!-- top tiles -->
        الاحصائيات
        <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> تعداد کاربران</span>
                <div class="count">2500</div>
                <span class="count_bottom"><i class="green">4% </i> از هفته گذشته</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> میانگین زمان</span>
                <div class="count">123.50</div>
                <span class="count_bottom"><i class="green"><i
                            class="fa fa-sort-asc"></i>3% </i> از هفته گذشته</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> مجموع مردان</span>
                <div class="count green">2,500</div>
                <span class="count_bottom"><i class="green"><i
                            class="fa fa-sort-asc"></i>34% </i> از هفته گذشته</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> مجموع زنان</span>
                <div class="count">4,567</div>
                <span class="count_bottom"><i class="red"><i
                            class="fa fa-sort-desc"></i>12% </i> از هفته گذشته</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> مجموعه کلی</span>
                <div class="count">2,315</div>
                <span class="count_bottom"><i class="green"><i
                            class="fa fa-sort-asc"></i>34% </i> از هفته گذشته</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> مجموع اتصالات</span>
                <div class="count">7,325</div>
                <span class="count_bottom"><i class="green"><i
                            class="fa fa-sort-asc"></i>34% </i> از هفته گذشته</span>
            </div>
        </div>
        <!-- /top tiles -->
        <br/>
    </div>
@endsection
