@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">منشورات حقوق المرأة</h3>
        <br/>
    </div>
@endsection
@section('models')

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> منشور جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="control-label col-sm-4">لغة المنشور :</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="lang_type" name="lang_type">
                                    <option value="both">لغتين</option>
                                    <option value="ar">عربي</option>
                                    <option value="en">انجليزي</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="title_dev">
                            <label class="control-label col-md-4">العنوان : </label>
                            <div class="col-md-8">
                                <input type="text" name="title" id="title" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group" id="title_en_dev">
                            <label class="control-label col-md-4">العنوان EN: </label>
                            <div class="col-md-8">
                                <input type="text" name="title_en" id="title_en" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">نشر صورة : </label>
                            <div class="col-md-8">
                                <input type="file" name="image" id="image"/>
                                <span id="store_image"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">نوع الكتاب :</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="book_type" name="book_type">
                                    <option value="none">لا يوجد</option>
                                    <option value="book_internal">مرفوع الى النظام</option>
                                    <option value="book_external">رابط خارجي</option>
                                </select>
                                <div class="print-error-msg alert-danger" id="modal_error_training_id"></div>
                            </div>
                        </div>
                        <div class="form-group" id="book_internal" style="display: none">
                            <label class="control-label col-md-4">نشر كتاب : </label>
                            <div class="col-md-8">
                                <input type="file" name="book" id="book"/>
                                <span id="store_book"></span>
                            </div>
                        </div>
                        <div class="form-group" id="book_external" style="display: none">
                            <label class="control-label col-md-4">رابط الكتاب خارجي: </label>
                            <div class="col-md-8">
                                <input type="url" name="book_external_link" id="book_external_link"/>
                                <span id="book_external_link"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">رابط فيديو : </label>
                            <div class="col-md-8">
                                <input type="text" name="video" id="video" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group" id="body_dev">
                            <label class="control-label col-md-4">المحتوى : </label>
                            <div class="col-md-12">
                                <textarea type="text" name="body" id="body" class="form-control description"></textarea>
                            </div>
                        </div>
                        <div class="form-group" id="body_en_dev">
                            <label class="control-label col-md-4">المحتوى EN: </label>
                            <div class="col-md-12">
                                <textarea type="text" name="body_en" id="body_en"
                                          class="form-control description"></textarea>
                            </div>
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
    <div id="formShow" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> منسور جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_show"></span>
                    <div id="show_title"></div>
                    <br>
                    --------------------------------------------------------------
                    <br>
                    <div id="show_title_en"></div>
                    <br>
                    --------------------------------------------------------------
                    <br>
                    <div id="show_body"></div>
                    <br>
                    --------------------------------------------------------------
                    <br>

                    <div id="show_body_en"></div>
                    <br>
                    --------------------------------------------------------------
                    <br>
                    <div id="show_book"></div>
                    <br>
                    <div id="show_book_external_link"></div>
                    <br>
                    <div id="show_video"></div>
                    <br>
                    <div id="show_image"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف المنشور</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف المنشور؟</h4>
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

            $('#user_table').DataTable({
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
                        @if ((Auth::user()->can('manage women') == true))

                    {
                        text: '<i class="fa fa-plus" ></i>  إنشاء  منشور جديد  ',
                        className: 'btn btn-info create_record',
                    },
                    @endif
                ],
                ajax: {
                    url: "{{ route('ajax-crud.index') }}",
                },
                columns: [
                    {
                        title: 'العنوان',
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'lang_type',
                        title: 'اللغة',
                        name: 'lang_type'
                    },

                    {
                        data: 'image',
                        title: 'الصورة',

                        name: 'image',
                        render: function (data, type, full, meta) {
                            return "<img src={{ URL::to('/') }}/" + data + " width='70' class='img-thumbnail' />";
                        },
                        orderable: false
                    },
                    {
                        data: 'published',
                        name: 'published',
                        title: 'تاريخ النشر',


                    },
                        @if ((Auth::user()->can('manage women') == true))

                    {
                        data: 'action',
                        title: 'عمليات',

                        name: 'action',
                        orderable: false
                    },
                    @endif
                ]
            });
            $('.create_record').click(function () {
                $('.modal-title').text("إضافة منشور جديد");
                $('#sample_form')[0].reset();
                $('#store_image').html('');
                $('#store_book').html('');
                $('#action_button').val("نشر");
                $('#action').val("Add");
                $('#formModal').modal('show');
            });
            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add') {
                    $.ajax({
                        url: "{{ route('ajax-crud.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('#user_table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html);
                        }
                    })
                }

                if ($('#action').val() == "Edit") {
                    $.ajax({
                        url: "{{ route('ajax-crud.update') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('#store_image').html('');
                                $('#store_book').html('');
                                $('#user_table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html);
                        }
                    });
                }
            });
            $(document).on('click', '.edit_post', function () {
                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url: "{{URL::to('')}}/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#title').val(html.data.title);
                        $('#title_en').val(html.data.title_en);
                        $('#video').val(html.data.video_url);
                        // $('#body').val(html.data.body);
                        tinyMCE.get("body").setContent((html.data.body == null ? '' : html.data.body));
                        tinyMCE.get("body_en").setContent((html.data.body_en == null ? '' : html.data.body_en));

                        $('#store_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.image + " width='70' class='img-thumbnail' />");
                        $('#store_image').append("<input type='hidden' name='hidden_image' value='" + html.data.image + "' />");
                        $('#store_book').html("<b>'" + html.data.book + "'</b>");
                        $('#store_book').append("<input type='hidden' name='hidden_book' value='" + html.data.book + "' />");
                        if (html.data.book != null) {
                            $('#book_type').val('book_internal').change();
                        } else if (html.data.book_external_link != null) {
                            $('#book_type').val('book_external').change();
                        } else {
                            $('#book_type').val('none').change();
                        }

                        $('#lang_type').val(html.data.lang_type).change();

                        // $('#book_type').trigger('change');
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("تعديل المنشور");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });
            $(document).on('click', '.show_post', function () {
                var id = $(this).attr('id');
                $('#form_show').html('');
                $.ajax({
                    url: "{{URL::to('')}}/show/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#show_title').html("<h4><b>" + html.data.title + "</b></h4>");
                        $('#show_title_en').html("<h4><b>" + html.data.title_en + "</b></h4>");
                        $('#show_body').html("<b>" + html.data.body + "</b>");
                        $('#show_body_en').html("<b>" + html.data.body_en + "</b>");

                        if (html.data.book != null) {
                            $('#show_book').html("<b>" + html.data.book + " <span class='fa fa-file-pdf-o'></span></b>");
                        } else {
                            $('#show_book').html("<b>لا يوجد كتاب</b>");
                        }
                        if (html.data.book_external_link != null) {
                            $('#show_book_external_link').html("<a target='_blank' style='color: blue' href='" + html.data.book_external_link + "'> رابط الكتاب الخارجي <span class='fa fa-link'></span></a>");
                        } else {
                            $('#show_book_external_link').html("<b>لا يوجد رابط كتاب</b>");
                        }
                        if (html.data.video_url != null) {
                            $('#show_video').html("<b><a href='" + html.data.video_url + "'>" + html.data.video_url + " <span class='fa fa-file-video-o'></span></a></b>");
                        } else {
                            $('#show_video').html("<b><a href='#'></a>لايوجد رابط فيديو</b>");
                        }
                        if (html.data.image != null) {
                            $('#show_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.image + " style='height:30em' class='img-thumbnail' />");
                        } else {
                            $('#show_image').html("<b><a href='#'></a>لايوجد صورة</b>");
                        }
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("عرض المنشور");
                        $('#formShow').modal('show');
                    }
                })
            });
            var user_id;
            $(document).on('click', '.delete_post', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف المنشور");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });
            $('#book_type').change(function () {
                var type = $(this).val();
                if (type == 'book_internal') {
                    $('#book_internal').show();
                    $('#book_external').hide();
                } else if (type == 'book_external') {
                    $('#book_external').show();
                    $('#book_internal').hide();
                } else {
                    $('#book_external').hide();
                    $('#book_internal').hide();
                }
            });
            $('#lang_type').change(function () {
                var type = $(this).val();
                if (type == 'both') {
                    $('#title_dev').show();
                    $('#title_en_dev').show();
                    $('#body_en_dev').show();
                    $('#body_dev').show();
                } else if (type == 'ar') {
                    $('#title_dev').show();
                    $('#title_en_dev').hide();
                    $('#body_en_dev').hide();
                    $('#body_dev').show();
                } else {
                    $('#title_dev').hide();
                    $('#title_en_dev').show();
                    $('#body_en_dev').show();
                    $('#body_dev').hide();
                }
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/ajax-crud/destroy/" + user_id,
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
