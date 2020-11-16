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
                        <?php $getGovernorate = getCities(); $getGovernorate['all'] = 'all'; ?>
                        {!!Form ::select('to_zone', array_reverse($getGovernorate,true),'',['class' => 'select2 form-control', 'id' => 'to_zone'])!!}
                    </div>
                    {{--                    @if($type=='sub')--}}
                    <div class="input-group col-sm-3">
                        <span class="input-group-addon">حالة الطلب</span>
                        {!!Form ::select('status', getSpesificStatus(0),'',['class' => 'select2 form-control', 'id' => 'filter_status'])!!}
                    </div>
                    {{--                    @else--}}
                    {{--                        <input type="hidden" id="filter_status" value="{{getSpesificStatus(0)}}">--}}
                    {{--                        <input type="hidden" id="filter_status" value="{{getSpesificStatus($type)}}">--}}
                    {{--                    @endif--}}
                    <div class="input-group col-sm-3">
                        <span class="input-group-addon">حالة الدفع</span>
                        {!!Form ::select('payment', paymentStatus('all'),'',['class' => 'select2 form-control', 'id' => 'filter_payment_status'])!!}
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-sm-4">
                        <span class="input-group-addon">من تاريخ</span>
                        <input type="date" class="form-control" name="start" value="{{isset($start)?$start:''}}"
                               id="from_date">
                    </div>
                    <div class="input-group col-sm-4">
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
                    <h4 align="center" style="margin:0;">هل انت متاكد من الحذف؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">نعم</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom_js')
    @include('adminpanel.active')
    @include('adminpanel.wyswyg')
    <script>
        Active('{{route('admin.shop.orders.active')}}');
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
                        url: "{{route('admin.shop.orders.index')}}",
                        data: {
                            to_zone: $('#to_zone').val(),
                            from_date: $('#from_date').val(),
                            to_date: $('#to_date').val(),
                            filter_status: $('#filter_status').val(),
                            payment_status: $('#filter_payment_status').val(),
                            type: '{{$type}}',
                        }

                    },
                    columns: [
                            @if ($type=="main")
                        {
                            title: 'العميل',
                            data: 'user_name',
                            name: 'user_name',
                        }, {
                            title: ' المحافظة',
                            data: 'gov',
                            name: 'gov',
                        },
                        {
                            title: ' المديرية',
                            data: 'district',
                            name: 'district',
                        },
                        {
                            title: ' معلومات اخرى',
                            data: 'more_address_info',
                            name: 'more_address_info',
                        },
                        {
                            title: ' اجمالي تكلفة الطلب ',
                            data: 'price',
                            name: 'price',
                        },
                        {
                            title: 'تاريخ الطلب ',
                            data: 'created_at',
                        },
                            @else
                        {
                            title: 'البائع',
                            data: 'seller.sale_name',
                            name: 'seller.sale_name',
                        },
                        {
                            title: 'العميل',
                            data: 'order.user_name',
                            name: 'order.user_name',
                        },
                        {
                            title: ' المحافظة',
                            data: 'order.gov',
                            name: 'order.gov',
                        },
                        {
                            title: ' المديرية',
                            data: 'order.district',
                            name: 'order.district',
                        },
                        {
                            title: ' معلومات اخرى',
                            data: 'order.more_address_info',
                            name: 'order.more_address_info',
                        },
                        {
                            title: ' اجمالي تكلفة الطلب ',
                            data: 'price',
                            name: 'price',
                        },
                        {
                            title: 'تاريخ الطلب ',
                            data: 'order.created_at',
                        }, {
                            title: 'حالة الطلب ',
                            data: 'order_status_name',
                        },
                            @endif

                        {
                            title: 'الحالة',
                            data: 'btn_status',
                            name: 'btn_status',
                        },
                        {
                            title: 'عمليات',
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ],

                });
            }

            $(document).on('click', '.create_record', function () {
                $('.modal-title').text("إ إنشاء منتج  جديدة");
                $('#action_button').val("حفظ");
                $('#action').val("Add");
                $('#sample_form')[0].reset();
                $('#store_image').html('');
                $('#old_image_preview_box').hide();
                $('#old_image_preview').html('');
                $('#formModal').modal('show');
            });


            $(document).on('click', '#filter', function () {
                $('#user_table').DataTable().destroy();
                fill_datatable();
            });

            var deleted_id = 0;
            $(document).on('click', '.delete', function () {
                deleted_id = $(this).attr('id');
                $('.modal-title').text("حذف الطلب ");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/orders/destroy/" + deleted_id,
                    beforeSend: function () {
                        $('#ok_button').text('جاري الحذف...');
                    },
                    success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            $('#user_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });


        });


    </script>

@endsection


