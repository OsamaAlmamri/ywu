@extends('adminpanel.master')
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <br/>
            <h3 align="right">محتوى عناوين الدورات التدريبية</h3>
            <br/>
            <div align="right">
                <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">إنشاء محتوى
                    جديد
                </button>
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user_table">
                    <thead>
                    <tr>
                        <th width="20%">عنوان المحتوى</th>
                        <th width="10%">محتوى النص</th>
                        <th width="10%">العنوان</th>
                        <th width="10%">تاريخ النشر</th>
                        <th width="10%">العمليات</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <br/>
            <br/>
        </div>
    </div>

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء محتوى جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">العنوان :</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="title_id" name="title_id">
                                    @if($category->count())
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">عنوان المحتوى : </label>
                            <div class="col-md-8">
                                <input type="text" name="title" id="title" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">محتوى النص : </label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="body" name="body" type="text"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">صورة : </label>
                            <div class="col-md-8">
                                <input type="file" name="image" id="image"/>
                                <span id="store_image"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">صوت : </label>
                            <div class="col-md-8">
                                <input type="file" name="sound" id="sound"/>
                                <span id="store_sound"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">كتاب : </label>
                            <div class="col-md-8">
                                <input type="file" name="book" id="book"/>
                                <span id="store_book"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">رابط فيديو : </label>
                            <div class="col-md-8">
                                <input type="text" name="video" id="video" class="form-control"/>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> عناصر المحتوى</h4>
                </div>
                <div class="modal-body">
                    <span id="form_show"></span>
                    <div id="show_title"></div>
                    <br>
                    <div id="show_body"></div>
                    <br>
                    <div id="show_sound"></div>
                    <br>
                    <div id="show_book"></div>
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
                    <h2 class="modal-title">حذف المادة</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف محتوى عنوان الدورة؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">نعم</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            fill_datatable();

            function fill_datatable() {
                var dataTable = $('#user_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/showContentID/{{ $id }}",
                    },
                    columnDefs: [{
                        targets: 1,
                        render: function (data, type, row) {
                            return type === 'display' && data.length > 50 ? data.substr(0, 50) + '…' : data;
                        }
                    }],
                    columns: [
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'body',
                            name: 'body'
                        },
                        {
                            data: 'title_C',
                            name: 'title_C',
                        },
                        {
                            data: 'published',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ]
                });
            }

            $('#create_record').click(function () {
                $('.modal-title').text("إضافة دورة تدريبية جديده");
                $('#action_button').val("نشر");
                $('#action').val("Add");
                $('#sample_form')[0].reset();
                $('#store_image').html('');
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add') {
                    $.ajax({
                        url: "{{ route('content.store') }}",
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
                        url: "{{ route('content.update') }}",
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
                                $('#user_table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html);
                        }
                    });
                }
            });

            $(document).on('click', '.show', function () {
                var id = $(this).attr('id');
                $('#form_show').html('');

                $.ajax({
                    url: "/content/show/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#show_title').html("<h4><b>العنوان : " + html.data.title + "</b></h4>");
                        $('#show_body').html("<b>محتوى النص : " + html.data.body + "</b>");

                        if (html.data.sound != null) {
                            $('#show_sound').html("<b>ملف صوتي : " + html.data.sound + " <span class='fa fa-file-pdf-o'></span></b>");
                        } else {
                            $('#show_sound').html("<b>ملف صوتي : لا يوجد ملف صوتي</b>");
                        }
                        if (html.data.book != null) {
                            $('#show_book').html("<b>كتاب : " + html.data.book + " <span class='fa fa-file-pdf-o'></span></b>");
                        } else {
                            $('#show_book').html("<b>كتاب : لا يوجد كتاب</b>");
                        }
                        if (html.data.video_url != null) {
                            $('#show_video').html("<b>رابط فيديو : <a href='" + html.data.video_url + "'>" + html.data.video_url + " <span class='fa fa-file-video-o'></span></a></b>");
                        } else {
                            $('#show_video').html("<b>رابط فيديو : <a href='#'></a>لايوجد رابط فيديو</b>");
                        }
                        if (html.data.image != null) {
                            $('#show_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.image + " style='height:30em' class='img-thumbnail' />");
                        } else {
                            $('#show_image').html("<b><a href='#'></a>لايوجد صورة</b>");
                        }
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("عرض بيانات المحتوى");
                        $('#formShow').modal('show');
                    }
                })
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url: "/content/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#title').val(html.data.title);
                        $('#body').val(html.data.body);
                        $('#video').val(html.data.video);
                        $('#store_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.image + " width='70' class='img-thumbnail' />");
                        $('#store_image').append("<input type='hidden' name='hidden_image' value='" + html.data.image + "' />");
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("تعديل بيانات الدورة");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف المحتوى");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "/content/destroy/" + user_id,
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
