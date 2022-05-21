@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> الكوبونات </h3>
        <br/>
        <div id="statistics_data">

        </div>

        <div class="card-body">
            <div class="row">
                <div class="input-group col-sm-3">
                    <span class="input-group-addon"> المحافظة </span>
                    <?php $getGovernorate = getCities(); $getGovernorate['all'] = 'all'; ?>
                    {!!Form ::select('gov_id', array_reverse($getGovernorate,true),'',['class' => 'select2 form-control', 'id' => 'gov_id'])!!}
                </div>
                <div class="input-group col-sm-3">
                    <span class="input-group-addon"> السنة </span>
                    <select name="filter_seller" id="filter_year" class="form-control" required>
                        <option value="all">الكل</option>
                        @foreach($years as $y)
                            <option value="{{ $y }}"
                                    @if($year!='all' and $y==$year) selected @endif >{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group col-sm-2">
                    <button type="button" name="filter" id="filter"
                            class="btn btn-primary btn-ms waves-effect waves-light">فرز<i
                            class="fa fa-filter"></i></button>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('custom_js')

    <script>


        $(document).ready(function () {
            $(document).on('click', '#filter', function () {
                $('#user_table').DataTable().destroy();
                fill_datatable();
                get_sta()
            });
            fill_datatable();
            get_sta()

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
                    lengthMenu: [[-1, 10, 50, 100, -1], ['الكل', 10, 50, 100]],
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
                        data: {
                            gov_id: $('#gov_id').val(),
                            year: $('#filter_year').val(),

                        }
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


            function get_sta() {
                let year = $('#filter_year').val();
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/coupons/sta/" + year + "",
                    type: "GET",
                    success: function (html) {
                        console.log(html)
                        console.log("html")
                        console.log(html)
                        $('#statistics_data').html(html);

                    }
                })
            }

        });
    </script>

@endsection

