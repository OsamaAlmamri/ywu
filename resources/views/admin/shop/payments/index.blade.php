@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> عمليات الدفع </h3>
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
                        <span class="input-group-addon">من تاريخ</span>
                        <input type="date" class="form-control" name="start" value="{{isset($start)?$start:''}}"
                               id="from_date">
                    </div>
                    <div class="input-group col-sm-3">
                        <span class="input-group-addon">الى تاريخ</span>
                        <input type="date" class="form-control" name="end" value="{{isset($end)?$end:''}}" required
                               id="to_date">
                    </div>
                    <div class="input-group col-sm-3">
                        <span class="input-group-addon">حالة تاكيد الدفع</span>
                        {!!Form ::select('payment', confirm_paymentStatus('all'),'',['class' => 'select2 form-control', 'id' => 'filter_payment_status'])!!}
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
                        url: "{{route('admin.shop.payments.index')}}",
                        data: {
                            from_date: $('#from_date').val(),
                            to_date: $('#to_date').val(),
                            payment_status: $('#filter_payment_status').val(),
                        }

                    },
                    columns: [
                        {
                            title: ' #',
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            title: 'العميل',
                            data: 'user_name',
                            name: 'user_name',
                        },

                        {
                            title: '  رقم الطلب ',
                            data: 'order_id',
                            name: 'order_id',
                        },
                        {
                            title: ' اجمالي تكلفةالطلب ',
                            data: 'order.price',
                            name: 'order.price',
                        },
                        {
                            title: ' مبلغ الحوالة ',
                            data: 'amount',
                            name: 'amount',
                        },
                        {
                            title: 'رقم الحوالة ',
                            data: 'invoice_number',
                        },
                        {
                            title: 'تاريخ الحوالة ',
                            data: 'created_at',
                        },
                            @if ((Auth::user()->can('manage payment') == true))
                        {
                            title: 'حالة مراجعة الدفع',
                            data: 'btn_status',
                            name: 'btn_status',
                        }, {
                            title: 'حالة تاكيد الدفع',
                            data: 'btn_order_status',
                            name: 'btn_order_status',
                        },
                        {
                            title: 'المسؤول المراجع',
                            data: 'admin_name',
                            name: 'admin',
                        },


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


