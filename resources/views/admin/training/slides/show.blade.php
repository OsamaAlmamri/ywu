@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">السلايدات المتحركة</h3>
        <br/>
    </div>
@endsection
@section('models')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء سلايد جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">عند الضغط ينتقل الى قسم :</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="action_type" name="action_type">
                                    <option value="">غير محدد</option>
                                    <option value="posts"> الإستشارات</option>
                                    <option value="trainings"> المواد التدريبية</option>
                                    <option value="women"> شؤون المراة</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">عند الضغط ينتقل الى :</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="action_id" name="action_id">
                                    <option value="">غير محدد</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">نص السلايد : </label>
                            <div class="col-md-8">
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                            <div class="print-error-msg alert-danger" id="modal_error_description"></div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4"> الصورة : </label>
                            <div class="col-md-8">
                                <input type="file" name="image" id="image"/>
                                <span id="store_image"></span>
                            </div>
                            <div class="print-error-msg alert-danger" id="modal_error_image"></div>
                        </div>
                        <br/>
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

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف السلايد</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف السلايد؟</h4>
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
    <script>

        Active('{{route('slides.active')}}');
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
                            text: '<i class="fa fa-plus" ></i>  إنشاء  سلايد جديد  ',
                            className: 'btn btn-info create_record',
                        },
                    ],
                    ajax: {
                        url: "{{route('slides.index')}}",
                    },
                    columns: [
                            @if ((Auth::user()->can('manage slides') == true))
                        {
                            title: '  ترتيب العرض ',
                            data: 'btn_sort',
                            name: 'btn_sort'
                        },
                            @endif
                        {
                            title: 'نص  السلايد',
                            data: 'description',
                            name: 'description'
                        },

                        {
                            data: 'btn_image',
                            name: 'btn_image',
                            title: ' الصورة '

                        },
                            @if ((Auth::user()->can('manage slides') == true))

                        {
                            title: 'الحالة',
                            data: 'btn_status',
                            name: 'btn_status',
                        }, {
                            title: 'عمليات',
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                        @endif
                    ]
                });
            }

            $('.create_record').click(function () {
                $('.modal-title').text("إنشاء سلايد جديد");
                $("#formModal .print-error-msg").html('');
                $('#sample_form')[0].reset();
                $('#action_button').val("اضافة");
                $('#store_image').html('');
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add')
                    var url = "{{ route('slides.store') }}";
                else
                    var url = "{{ route('slides.update') }}";
                $.ajax({
                    url: url,
                    method: "POST",
                    data: new FormData(this),
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
                    url: "{{URL::to('')}}/slides/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#description').val(html.data.description);
                        $('#hidden_id').val(html.data.id);

                        $('#action_type').val(html.data.action_type);
                        $.when(change_type(html.data.action_type)).then(function (data) {
                            $('#action_id').val(html.data.action_id);
                        });
                        $('#hidden_id').val(html.data.id);
                        $('#store_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.image + " width='70' class='img-thumbnail' />");
                        $('.modal-title').text("تعديل السلايد ");
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

            function change_type(type = "") {

                if (type == "")
                    return $('#action_id').html("<option value=\"\">غير محدد</option>")
                else {
                    return $.ajax({
                        url: "{{route('slides.changeType')}}",//   var url=$('#news').attr('action');
                        method: 'post',
                        dataType: 'json',// data type that i want to return
                        data: '_token=' + ("{{csrf_token()}}") + '&type=' + type,// var form=$('#news').serialize();
                        success: function (data) {
                            $('#action_id').html(data);
                        },
                        error: function (xhr, status, error) {
                            alert(xhr.responseText);
                        }
                    });

                }

            }

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف السلايد");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/slides/destroy/" + user_id,
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
    <?php $controler = 'slides.changeOrder' ?>
    @include('sortFiles.scripts')

@endsection




