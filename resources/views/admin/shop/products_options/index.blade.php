@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> خيارات المنتجات </h3>
        <br/>
    </div>
@endsection
@section('models')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء خيار منتج جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-4">اسم الخيار : </label>
                            <div class="col-md-8">
                                <input type="text" name="products_options_name" id="products_options_name"
                                       class="form-control"/>
                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_products_options_name"></span>

                        </div>
                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="action"/>
                            <input type="hidden" name="hidden_id" id="hidden_id"/>
                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                   value="اضافة"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="formOptionValueModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء خيار منتج جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="formOptionValueModal_form" class="form-horizontal"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">الخيار :</label>
                            <div class="col-sm-8">
                                <input id="op_products_options_id" type="hidden" name="products_options_id" value="0">
                                <span id="op_products_options_name"> </span>
                            </div>
                            <span class="print-error-msg alert-danger" id="modal_error_category_id"></span>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">اسم الخيار : </label>
                            <div class="col-md-8">
                                <input type="text" name="products_options_values_name" id="products_options_values_name"
                                       class="form-control"/>
                            </div>
                            <span class="print-error-msg alert-danger"
                                  id="modal_error_products_options_values_name"></span>

                        </div>
                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="OptionValue_action"/>
                            <input type="hidden" name="hidden_id" id="OptionValue_hidden_id"/>
                            <input type="submit" name="action_button" id="OptionValue_action_button"
                                   class="btn btn-warning"
                                   value="اضافة"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف الخيار</h2>
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
    @include('adminpanel.wyswyg')
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
                    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, 'الكل']],
                    buttons: [

                        {
                            text: '<i class="fa fa-plus" ></i>  إنشاء خيار منتج جديد ',
                            className: 'btn btn-info create_record',
                        },
                    ],
                    ajax: {
                        url: "{{route('admin.shop.products_options.index')}}",
                        data: {zone_id: $("#filter_country").val()}
                    },
                    columns: [
                        {
                            title: ' الاسم ',
                            data: 'products_options_name',
                            name: 'products_options_name'
                        },
                        {
                            title: 'الخيارات ',
                            name: 'products_options_values',
                            data: 'products_options_values',
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
                $('.modal-title').text(" إنشاء خيار منتج  جديدة");
                $('#action_button').val("حفظ");
                $('#action').val("Add");
                $('#sample_form')[0].reset();
                $('#formModal').modal('show');
            });
            $(document).on('click', '.newOption_val', function () {
                $('.modal-title').text(" إنشاء قيمة خيار منتج  جديد");
                $('#OptionValue_action_button').val("حفظ");
                // OptionValue_hidden_id
                $('#op_products_options_name').text($(this).data('option_name'));
                $('#op_products_options_id').val($(this).data('option_id'));
                $('#OptionValue_action').val("Add");
                $('#formOptionValueModal_form')[0].reset();
                $('#formOptionValueModal').modal('show');
            });

            $('#formOptionValueModal_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#OptionValue_action').val() == 'Add')
                    var url = "{{ route('admin.shop.products_options.store_options_values') }}";
                else
                    var url = "{{ route('admin.shop.products_options.update_options_values') }}";
                var formData = new FormData(this);
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
                        $('#formOptionValueModal_form')[0].reset();
                        $('#user_table').DataTable().ajax.reload();
                        $("#formOptionValueModal_form .print-error-msg").html('');
                        $('#formOptionValueModal').modal('hide');
                    },
                    error: function (jqXhr, status) {
                        console.log(jqXhr);
                        if (jqXhr.status === 422) {
                            $("#formOptionValueModal_form .print-error-msg").html('');
                            var errors = jqXhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $("#formOptionValueModal_form").find("#modal_error_" + key).html(value);
                            });
                        }
                    }
                })


            });


            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add')
                    var url = "{{ route('admin.shop.products_options.store') }}";
                else
                    var url = "{{ route('admin.shop.products_options.update') }}";
                var formData = new FormData(this);
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


            $(document).on('click', '#filter', function () {
                $('#user_table').DataTable().destroy();
                fill_datatable();
            });
            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');
                $('#form_result').html('');
                $('#hidden_id').val($(this).data('id'));
                $('#products_options_name').val($(this).data('option_name'));
                $('.modal-title').text("تعديل بيانات الخيار ");
                $('#action_button').val("تعديل");
                $('#action').val("Edit");
                $('#formModal').modal('show');
            });

            $(document).on('click', '.edit_option_val', function () {
                $('#OptionValue_hidden_id').val($(this).data('option_val_id'));
                $('#op_products_options_name').text($(this).data('option_name'));
                $('#products_options_values_name').val($(this).data('option_val_name'));
                $('#op_products_options_id').val($(this).data('option_id'));
                $('.modal-title').text("تعديل بيانات قيمة الخيار  ");
                $('#OptionValue_action_button').val("تعديل");
                $('#OptionValue_action').val("Edit");
                $('#formOptionValueModal').modal('show');
            });

            var deleted_id = 0;
            var deleted_type = 'option';
            $(document).on('click', '.delete', function () {
                deleted_id = $(this).attr('id');
                deleted_type = $(this).data('type');
                $('.modal-title').text("حذف  ");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/products_options/destroy/" + deleted_id + "/" + deleted_type,
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


