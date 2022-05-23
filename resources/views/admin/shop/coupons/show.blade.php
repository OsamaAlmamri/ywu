@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
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
                    <span class="input-group-addon"> البائع </span>
                    <select name="filter_seller" id="filter_seller" class="form-control" required>
                        <option value="all">الكل</option>
                        @foreach(sellers() as $c)
                            <option value="{{ $c->admin_id }}">{{ $c->sale_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group col-sm-3">
                    <span class="input-group-addon">استخدام الكوبون</span>
                    {!!Form ::select('status', CouponUsedStatus(),'',['class' => 'select2 form-control', 'id' => 'coupon_used'])!!}
                </div>

                <div class="input-group col-sm-3">
                    <span class="input-group-addon">صلاحية الكوبون</span>
                    {!!Form ::select('payment', CouponEndStatus('all'),'',['class' => 'select2 form-control', 'id' => 'filter_coupon_end'])!!}
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

    </div>
@endsection
@section('models')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        إنشاء كوبونات جديدة</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="control-label col-md-4"> المستخدم : </label>
                            <div class="col-8">
                                <select name="user_id" id="user_id" class=" form-control select2" style="width:60%" required>
                                    <option value="all"> عشوائي</option>
                                    @foreach($users as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_user_id"></span>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"> عدد الكوبونات : </label>
                            <div class="col-md-8">
                                <input type="number" min="1" name="number" id="number" value="1" class="form-control"/>
                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_number"></span>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"> المبلغ : </label>
                            <div class="col-md-8">
                                <input name="amount" id="amount" class="form-control"/>
                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_amount"></span>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4"> تاريخ الانتهاء : </label>
                            <div class="col-md-8">
                                <input type="date" name="end_date" id="end_date" class="form-control"/>
                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_end_date"></span>

                        </div>

                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="action"/>
                            <input type="hidden" name="hidden_id" id="hidden_id"/>
                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                   value="نشر"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="confirm_multi_Modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        تعديل الكوبونات </h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <div class="form-group">
                        <label class="control-label col-md-4"> المبلغ : </label>
                        <div class="col-md-8">
                            <input name="amount" id="update_amount" class="form-control"/>
                        </div>
                        <span class="print-error-msg alert-danger" id="modal_error_amount"></span>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4"> تاريخ الانتهاء : </label>
                        <div class="col-md-8">
                            <input type="date" name="end_date" id="update_end_date" class="form-control"/>
                        </div>
                        <span class="print-error-msg alert-danger" id="modal_error_end_date"></span>

                    </div>
                    <div class="form-group" align="center">
                        <input type="button" name="action_button" id="update_button-all" class="btn btn-info"
                               value="تعديل"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('adminpanel.includes.image_to_selected_model')
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف الكوبونات</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف الكوبونات؟</h4>
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

    <script>

        $(document).on('click', '#select_all', function () {
            if (this.checked) {
                // Iterate each checkbox
                $('input:checkbox.selectGroup').each(function () {
                    // alert($(this).attr('data-id'))
                    this.checked = true;
                });

            } else {
                $('input:checkbox.selectAll').each(function () {
                    this.checked = false;
                });
                $('input:checkbox.selectGroup').each(function () {
                    this.checked = false;
                });
            }
        });
        $(document).on('click', ".update-all", function (e) {
            selected_data('edit')

        });

        $(document).on('click', ".delete-all", function (e) {
            selected_data('delete')

        });

        $(document).on('click', "#update_button-all", function (e) {

            $.ajax({
                url: "{{ route('admin.shop.coupons.update_selected') }}",
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    ids: idsArr,
                    end_date: $("#update_end_date").val(),
                    amount: $("#update_amount").val(),
                },
                success: function (data) {
                    $('#confirm_multi_Modal').modal('hide');
                    toastr.info(data.success);
                    $('#user_table').DataTable().ajax.reload();
                },
                error: function (jqXhr, status) {
                    console.log(jqXhr);
                    if (jqXhr.status === 422) {
                        $("#confirm_multi_Modal .print-error-msg").html('');
                        var errors = jqXhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $("#confirm_multi_Modal").find("#modal_error_" + key).html(value);
                        });
                    }
                }
            });

        });

        var idsArr = [];

        function selected_data(type = 'edit') {
            idsArr = [];
            $(".selectGroup:checked").each(function () {
                idsArr.push($(this).attr('data-id'));
            });
            if (type == 'edit') {
                var confirm_message = "هل انت متاكد تعديل الكوبونات المحددة؟";
            } else {
                var confirm_message = "هل انت متاكد حذف الكوبونات المحددة؟";
            }
            if (idsArr.length <= 0) {
                alert("قم باختيار عنصر او اكثر  ^_^");
            } else {

                if (confirm(confirm_message)) {
                    if (type == 'edit') {

                        $('#confirm_multi_Modal').modal('show');
                    } else {

                        $.ajax({
                            url: "{{ route('admin.shop.coupons.delete_selected') }}",
                            type: 'post',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {ids: idsArr, type: type},
                            success: function (data) {
                                $('#user_table').DataTable().ajax.reload();
                                toastr.info(data.success);
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                    }

                }
            }
        }


        $(document).ready(function () {


            $(document).on('click', '#filter', function () {
                $('#user_table').DataTable().destroy();
                fill_datatable();
                get_sta()
            });
            get_sta();
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
                    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, 'الكل']],
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
                        },
                            @if ((Auth::user()->can('manage coupons') == true))
                        {
                            text: '<i class="fa fa-plus" ></i>   إنشاء كوبونات جديد  ',
                            className: 'btn btn-info create_record',
                        },
                        {
                            text: '<i class="fa fa-edit" ></i>   تعديل المحدد  ',
                            className: 'btn btn-primary update-all',
                        },
                        {
                            text: '<i class="fa fa-trash" ></i>  حذف المحدد  ',
                            className: 'btn btn-error delete-all',
                        },
                        @endif
                    ],
                    ajax: {
                        url: "{{route('admin.shop.coupons.index')}}",
                        data: {
                            gov_id: $('#gov_id').val(),
                            seller_id: $('#filter_seller').val(),
                            year: $('#filter_year').val(),
                            coupon_used: $('#coupon_used').val(),
                            coupon_end: $('#filter_coupon_end').val(),
                        }
                    },
                    columns: [
                        {
                            title: ' الرقم',
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },

                        {
                            title: '   <th><input type="checkbox" id="select_all"></th>',
                            name: ' <th><input type="checkbox" id="check_all"></th>',
                            data: 'check',
                            orderable: false
                        },
                        //'coupon', 'amount', 'used', 'order_id', 'end_date'
                        {
                            data: 'coupon',
                            name: 'coupon',
                            title: ' الكوبون '
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            title: ' المبلغ '
                        },
                        {
                            data: 'user',
                            name: 'user',
                            title: ' المستخدم '
                        }, {
                            data: 'phone',
                            name: 'phone',
                            title: ' رقم الهاتف '
                        },
                        {
                            data: 'end_date',
                            name: 'end_date',
                            title: ' تاريخ الانتتهاء '
                        },
                        {
                            data: 'gov1',
                            name: 'gov1',
                            title: ' المحافظة المستخدم فيها  '
                        },
                        {
                            data: 'order_id',
                            name: 'order_id',
                            title: ' الطلب  '
                        },
                        {
                            data: 'order_status',
                            name: 'order_status',
                            title: ' حالة الطلب  '
                        },
                        {
                            data: 'used',
                            name: 'used',
                            title: ' مستخدم  ',
                            render: function (data, row) {
                                return (data == '1') ? "نعم" : "لا";
                            }
                        },
                        {
                            data: 'ended',
                            name: 'ended',
                            title: ' منتهي الصلاحية  ',
                            render: function (data, row) {
                                return (data == '1') ? "نعم" : "لا";
                            }
                        },
                        {{--                            @if ((Auth::user()->can('manage coupons') == true))--}}
                        {{--                        {--}}
                        {{--                            title: 'عمليات',--}}
                        {{--                            data: 'action',--}}
                        {{--                            name: 'action',--}}
                        {{--                            orderable: false--}}
                        {{--                        },--}}
                        {{--                        @endif--}}
                    ]
                });
            }

            $('.create_record').click(function () {
                $('.modal-title').text("إنشاء كوبونات جديد");
                $("#formModal .print-error-msg").html('');
                $('#sample_form')[0].reset();
                $('#action_button').val("اضافة");
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add')
                    var url = "{{ route('admin.shop.coupons.store') }}";
                else
                    var url = "{{ route('admin.shop.coupons.update') }}";
                var formData = new FormData(this);
                formData.append("image_id", $("#select_img").val());
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        var html = '';
                        $('#sample_form')[0].reset();
                        toastr.info(data.success);
                        $('#user_table').DataTable().ajax.reload();
                        $("#formModal .print-error-msg").html('');
                        $('#formModal').modal('hide');
                    },
                    error: function (jqXhr, status) {
                        console.log(jqXhr);
                        if (jqXhr.status === 422) {
                            $("#formModal .print-error-msg").html('');
                            var errors = jqXhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $("#formModal").find("#modal_error_" + key).html(value);
                            });
                        }
                    }
                })


            });

            $(document).on('click', '.edit', function () {
                $('#sample_form')[0].reset();
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/coupons/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#name').val(html.data.name);
                        $('#hidden_id').val(html.data.id);
                        $('#old_image_id').val(html.data.image_id);
                        $('#old_image_preview_box').show();
                        $('#old_image_preview').html("<img src={{ URL::to('/') }}/" + html.data.image + " width='70' class='img-thumbnail' />");
                        $('#action_type').val(html.data.action_type);
                        $('#action_id').val(html.data.action_id);

                        $('.modal-title').text("تعديل الكوبونات ");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })

            })

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

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف الكوبونات");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/coupons/destroy/" + user_id,
                    beforeSend: function () {
                        $('#ok_button').text('جاري الحذف...');
                    },
                    success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            toastr.info(data.success);
                            $('#user_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });
        });
    </script>

@endsection

