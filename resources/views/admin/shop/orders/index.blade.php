@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> الطلبات </h3>
        <br/>
        <div class="card-body">
            <style>
                .input-group[class*=col-] {
                    margin: 10px;
                    float: right;;
                }
            </style>
            <div class="card-body">
                <div class="row">
                    <div class="input-group col-sm-3">
                        <span class="input-group-addon">الى محافظة </span>
                        <?php $getGovernorate = getCities(); $getGovernorate['all'] = 'الكل'; ?>
                        {!!Form ::select('to_zone', array_reverse($getGovernorate,true),'',['class' => 'select2 form-control', 'id' => 'to_zone'])!!}
                    </div>
                    @if($type!='main')
                        <div class="input-group col-sm-3">
                            <span class="input-group-addon">حالة الطلب</span>
                            <?php $getGovernorate = getSpesificStatus(0); $getGovernorate['all'] = 'الكل'; ?>
                            {!!Form ::select('status',  array_reverse($getGovernorate,true),'',['class' => 'select2 form-control', 'id' => 'filter_status'])!!}
                        </div>
                        {{--                    @endif--}}
                    @else
                        <input type="hidden" id="filter_status" value="all">
                    @endif
                    <div class="input-group col-sm-3">
                        <span class="input-group-addon">حالة الدفع</span>
                        {!!Form ::select('payment', paymentStatus('all'),'',['class' => 'select2 form-control', 'id' => 'filter_payment_status'])!!}
                    </div>
                </div>
                <div class="row">

                    @if($type!='main' and (auth()->user()->type=='admin'))
                        <div class="input-group col-sm-3">
                            <span class="input-group-addon">البائع </span>
                            <select name="filter_seller" id="filter_seller" class="form-control" required>
                                <option value="all">الكل</option>
                                @foreach(sellers() as $c)
                                    <option value="{{ $c->admin_id }}">{{ $c->sale_name }}</option>
                            @endforeach
                        </div>
                    @else
                        <option value="all">الكل</option>
                        @endif
                        </select>
                </div>

                <div class="input-group col-sm-3">
                    <span class="input-group-addon">من تاريخ</span>
                    <input type="date" class="form-control" name="start" value="{{isset($start)?$start:''}}"
                           id="from_date">
                </div>
                <div class="input-group col-sm-3">
                    <span class="input-group-addon">الى تاريخ</span>
                    <input type="date" class="form-control" name="end" value="{{isset($end)?$end:''}}" required
                           id="to_date">
                </div>

                <div class="input-group col-sm-2">
                    <button type="button" name="filter" id="filter"
                            class="btn btn-primary btn-ms waves-effect waves-light">فرز<i
                                class="fa fa-filter"></i></button>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
@section('models')

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف الطلب</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من تاكيد الدفع ؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">نعم</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">تاكيد عملية الدفع</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من التاكيد؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">تاكيد المراجعة</button>
                    <button type="button" name="ok_button" id="ok_button_with_order" class="btn btn-danger">تاكيد
                        المراجعة معا
                        الطلب
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmDeleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف الطلب</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف الطلب؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_delete_button" class="btn btn-danger">نعم</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom_js')
    @include('adminpanel.active')
    <script>
        Active('{{route('admin.shop.orders.active')}}');

        $(document).ready(function () {
            var user_id = 0;
            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف الصنف");
                $('#ok_delete_button').text('حذف');
                $('#confirmDeleteModal').modal('show');
            });
            $('#ok_delete_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/orders/destroy/" + user_id,
                    beforeSend: function () {
                        $('#ok_button').text('جاري الحذف...');
                    },
                    success: function (data) {
                        setTimeout(function () {
                            $('#confirmDeleteModal').modal('hide');
                            $('#user_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });
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
                    language: lang,
                    dom: 'Brfltip',
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass('row1');
                        $(row).attr('data-id', data.id);
                        $(row).attr('width', "100%");
                    },
                    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, 'الكل']],
                    buttons: [],
                    ajax: {
                        url: "{{route('admin.shop.orders.index')}}",
                        data: {
                            to_zone: $('#to_zone').val(),
                            from_date: $('#from_date').val(),
                            to_date: $('#to_date').val(),
                            filter_seller: $('#filter_seller').val(),
                            filter_status: $('#filter_status').val(),
                            payment_status: $('#filter_payment_status').val(),
                            type: '{{$type}}',
                        }

                    },
                    columns: [
                        {
                            title: ' #',
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            sortable:false
                        },
                        {
                            title: ' رقم الطلب ',
                            data: 'id',
                            name: 'id'
                        },
                            @if ($type=="main")
                        {
                            title: 'العميل',
                            data: 'user_name',
                            name: 'user_name',
                            sortable:false
                        }, {
                            title: ' المحافظة',
                            data: 'gov',
                            name: 'gov',
                            sortable:false
                        },
                        {
                            title: ' المديرية',
                            data: 'district',
                            name: 'district',
                            sortable:false
                        },
                        {
                            title: ' معلومات اخرى',
                            data: 'more_address_info',
                            name: 'more_address_info',
                            sortable:false
                        },
                        {
                            title: ' اجمالي تكلفة الطلب ',
                            data: 'price',
                            name: 'price',
                        },
                        {
                            title: 'تاريخ الطلب ',
                            data: 'created_at',
                        }, {
                            title: 'طريقة الدفع ',
                            data: 'payment_method',

                        },
                            @else
                        {
                            title: 'البائع',
                            data: 'seller_name',
                            name: 'seller_name',
                            sortable:false
                        },
                        {
                            title: 'العميل',
                            data: 'user_name',
                            name: 'user_name',
                            sortable:false
                        },
                        {
                            title: ' المحافظة',
                            data: 'gov',
                            name: 'gov',
                            sortable:false
                        },
                        {
                            title: ' المديرية',
                            data: 'district',
                            name: 'district',
                            sortable:false
                        },
                        {
                            title: ' معلومات اخرى',
                            data: 'more_address_info',
                            name: 'more_address_info',
                            sortable:false
                        },
                        {
                            title: ' اجمالي تكلفة الطلب ',
                            data: 'price',
                            name: 'price',
                        },
                        {
                            title: 'تاريخ الطلب ',
                            data: 'published',
                            sortable:false
                        },
                        {
                            title: 'حالة الطلب ',
                            data: 'order_status_name',
                            sortable:false
                        },
                        {
                            title: 'حالة الدفع ',
                            data: 'payment_status_name',
                            sortable:false
                        },
                        @endif
                        @if ((Auth::user()->can('manage orders') == true))

                        // {
                        //     title: 'الحالة',
                        //     data: 'btn_status',
                        //     name: 'btn_status',
                        // },
                        {
                            title: 'عمليات',
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                        @endif
                    ],

                });
            }


            $(document).on('click', '#filter', function () {
                $('#user_table').DataTable().destroy();
                fill_datatable();
            });


        });
        var type_id;
        var actionType;

        $(document).on('click', '.change_status', function () {
            type_id = $(this).attr('id');
            actionType = $(this).attr('actionType');
            if (actionType == "change_payment") {
                $('.modal-title').text("تاكيد مراجعة الطلب");
            }
            // else if (type_id == "delete_payment")
            //     $('.modal-title').text("حذف الصنف");
            else {
                $('.modal-title').text("تاكيد دفع الطلب");
            }
            $('#ok_button').text('تاكيد');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function () {
            confirm_payment(0);
        });

        $('#ok_button_with_order').click(function () {
            confirm_payment(1);
        });

        function confirm_payment(with_order) {
            $.ajax({
                url: "{{route('admin.shop.payments.change_status')}}",
                method: "post",
                data: '_token=' + ("{{csrf_token()}}") +
                    '&type=' + actionType +
                    '&with_order=' + with_order +
                    '&type_id=' + type_id,
                beforeSend: function () {
                    $('#ok_button').text('جاري التاكيد...');
                },
                success: function (data) {
                    setTimeout(function () {
                        $('#confirmModal').modal('hide');
                        $('#user_table').DataTable().ajax.reload();
                    }, 2000);
                }
            });
        }


    </script>

@endsection


