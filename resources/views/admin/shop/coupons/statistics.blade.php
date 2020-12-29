@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> الكوبونات </h3>
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

    </div>
@endsection

@section('custom_js')

    <script>


        $(document).ready(function () {

            fill_datatable();

            function fill_datatable() {
                var dataTable = $('#user_table').DataTable({
                    processing: true,
                    serverSide: true,
                    paging: true,
                    scrollX: true,
                    responsive: true,
                    autoWidth: false,
                    searching: true,
                    search: [
                        regex => true,
                    ],
                    info: false,
                    searchDelay: 350,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass('row1');
                        $(row).attr('data-id', data.id);
                        $(row).attr('width', "100%");
                    },
                    language: lang,
                    dom: 'Brfltip',
                    lengthMenu: [[-1,10, 50, 100, -1], ['الكل',10, 50, 100]],
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o" ></i> Excel',
                            className: 'btn btn-info '
                        },

                        {
                            extend: 'print',
                            text: '<i class="fa fa-print" ></i> Print',
                            className: 'btn btn-info '
                        }
                    ],
                    ajax: {
                        url: "{{route('admin.shop.coupons.statistics')}}",
                    },
                    columns: [
                        {
                            title: ' الرقم',
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            title: ' اسم التاجر '
                        },
                        {
                            data: 'sale_name',
                            name: 'sale_name',
                            title: ' المتجر '
                        },
                        {
                            data: 'gov1',
                            name: 'gov1',
                            title: ' المحافظة   '
                        },

                        {
                            data: 'phone',
                            name: 'phone',
                            title: ' رقم الهاتف '
                        },
                        {
                            data: 'count_all_coupons',
                            name: 'count_all_coupons',
                            title: ' عدد الكوبونات '
                        },

                        {
                            data: 'sum_all_coupons',
                            name: 'sum_all_coupons',
                            title: ' مجموع مبلغ الكوبونات '
                        },
  {
                            data: 'count_delivery_coupons',
                            name: 'count_delivery_coupons',
                            title: ' عدد  الكوبونات  المستلمة'
                        },

                        {
                            data: 'sum_delivery_coupons',
                            name: 'sum_delivery_coupons',
                            title: ' مجموع مبلغ الكوبونات المستلمة '
                        },


                    ]
                });
            }

        });
    </script>

@endsection

