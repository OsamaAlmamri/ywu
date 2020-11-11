@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">صور المنتج ({{$product->name}}) </h3>
        <br/>
    </div>
@endsection
@section('models')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> اضافة صورة جديدة</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf

                </div>
                @include('adminpanel.includes.image_to_select')
                <span class="print-error-msg alert-danger" id="modal_error_image_id"></span>

                <br/>
                <div class="form-group" align="center">
                    <input type="hidden" name="action" id="action"/>
                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                    <input type="hidden" name="product_id" value="{{$product->id}}"/>
                    <input type="hidden" name="old_image_id" id="old_image_id"/>
                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                           value="نشر"/>
                </div>
                </form>
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
                    <h2 class="modal-title">حذف الصورة</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف الصورة؟</h4>
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
    @include('adminpanel.includes.add_new_image_sceipts')
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
                    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, 'الكل']],
                    buttons: [

                        {
                            text: '<i class="fa fa-plus" ></i>   اضافة صورة جديدة  ',
                            className: 'btn btn-info create_record',
                        },
                    ],
                    ajax: {
                        url: "{{route('admin.shop.products.images.index',$product->id)}}",
                    },
                    columns: [

                        {
                            title: '  ترتيب العرض ',
                            data: 'btn_sort',
                            name: 'btn_sort'
                        },

                        {
                            data: 'btn_image',
                            name: 'btn_image',
                            title: ' الصورة '
                        },

                        {
                            title: 'عمليات',
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ]
                });
            }

            $('.create_record').click(function () {
                $('.modal-title').text("اضافة صورة جديدة");
                $("#formModal .print-error-msg").html('');
                $('#sample_form')[0].reset();
                $('#action_button').val("اضافة");
                $('#store_image').html('');
                $('#old_image_preview_box').hide();
                $('#old_image_preview').html('');
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add')
                    var url = "{{ route('admin.shop.products.images.store') }}";
                else
                    var url = "{{ route('admin.shop.products.images.update') }}";
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
                    url: "{{URL::to('')}}/admin/shop/products/images/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#hidden_id').val(html.data.id);
                        $('#old_image_id').val(html.data.image_id);
                        $('#old_image_preview_box').show();
                        $('#old_image_preview').html("<img src={{ URL::to('/') }}/" + html.data.image + " width='70' class='img-thumbnail' />");
                        $('#action_type').val(html.data.action_type);
                        $('#action_id').val(html.data.action_id);

                        $('.modal-title').text("تعديل الصورة ");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            })
            $(document).on('change', '#action_type', function () {
                var type = $('#action_type').val();
                change_type(type);
            });

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف الصورة");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/products/images/destroy/" + user_id,
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
    <?php $controler = 'admin.shop.products.images.changeOrder' ?>
    @include('sortFiles.scripts')

@endsection




