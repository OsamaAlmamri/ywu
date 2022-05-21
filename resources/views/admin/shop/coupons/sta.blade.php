<h3 align="right"> الكوبونات @if($year!='all') <h6> {{$year}}</h6> @endif</h3>
<br/>
<div class="card-body">
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #265a88;">
        <div class="card">
            <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-question-circle"
                                                                     style="font-size: 20px"></i> عدد  الكوبونات  </span>
                <div class="count">{{$count_all}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #6B6464;">
        <div class="card">
            <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-id-card"
                                                                     style="font-size: 20px"></i>   المستخدمة </span>
                <div class="count">{{$count_used}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #82ad2b;">
        <div class="card">
            <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-check-circle"
                                                                     style="font-size: 20px"></i>  الصالحة للاستخدام </span>
                <div class="count">{{$count_unend}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #dd0066;">
        <div class="card">
            <div class="card-block">
                        <span class="count_top" style="font-weight: bold"><i class="fa fa-close"
                                                                             style="font-size: 20px"></i> عدد المنتهية وغير المستخدمة </span>
                <div class="count">{{$count_end}}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #265a88;">
        <div class="card">
            <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-question-circle"
                                                                     style="font-size: 20px"></i> مبلغ  الكوبونات  </span>
                <div class="count">{{$sum_all}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #6B6464;">
        <div class="card">
            <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-id-card"
                                                                     style="font-size: 20px"></i> مبلغ  المستخدمة </span>
                <div class="count">{{$sum_used}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #82ad2b;">
        <div class="card">
            <div class="card-block">
                <span class="count_top" style="font-weight: bold"><i class="fa fa-check-circle"
                                                                     style="font-size: 20px"></i> مبلغ الصالحة للاستخدام </span>
                <div class="count">{{$sum_unend}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="color: #dd0066;">
        <div class="card">
            <div class="card-block">
                        <span class="count_top" style="font-weight: bold"><i class="fa fa-close"
                                                                             style="font-size: 20px"></i> مبلغ المنتهية وغير مستخدمة </span>
                <div class="count">{{$sum_end}}</div>
            </div>
        </div>
    </div>


    <style>
        .input-group[class*=col-] {
            margin: 10px;
            float: right;;
        }
    </style>

</div>
