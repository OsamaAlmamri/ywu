@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">منشورات حقوق المراءة المحذوفة</h3>

        <br/>
    </div>
@endsection
@section('models')

    <div id="formShow" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> منسور جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_show"></span>
                    <div id="show_title"></div>
                    <br>
                    <div id="show_body"></div>
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

    <div id="restoreModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">استعادة المنشور</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من استعادة المنشور؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="restore_button" id="restore_button" class="btn btn-success">نعم</button>
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
                    <h2 class="modal-title">حذف المنشور</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">سيتم حذف المنشور بشكل نهائي؟</h4>
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

                ],
                ajax: {
                    url: "{{ route('women-trashed') }}",
                },
                columns: [
                    {
                        title: 'العنوان',
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'body',
                        title: 'الوصف',
                        name: 'body'
                    },

                    {
                        data: 'image',
                        title: 'الصورة',

                        name: 'image',
                        render: function (data, type, full, meta) {
                            return "<img src={{ URL::to('/') }}/assets/images/" + data + " width='70' class='img-thumbnail' />";
                        },
                        orderable: false
                    },
                    {
                        data: 'published',
                        name: 'published',
                        title: 'تاريخ النشر',


                    },
                    {
                        data: 'action',
                        title: 'عمليات',

                        name: 'action',
                        orderable: false
                    },
                ]
            });

            $(document).on('click', '.show', function () {
                var id = $(this).attr('id');
                $('#form_show').html('');

                $.ajax({
                    url: "edit-trashed/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#show_title').html("<h4><b>" + html.data.title + "</b></h4>");
                        $('#show_body').html("<b>" + html.data.body + "</b>");

                        if (html.data.book != null) {
                            $('#show_book').html("<b>" + html.data.book + "</b>");
                        } else {
                            $('#show_book').html("<b>لا يوجد كتاب</b>");
                        }
                        if (html.data.video_url != null) {
                            $('#show_video').html("<b><a href='" + html.data.video_url + "'>" + html.data.video_url + "</a></b>");
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

            $(document).on('click', '.restore', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("استعادة المنشور");
                $('#restore_button').text('استعادة');
                $('#restoreModal').modal('show');
            });

            $('#restore_button').click(function () {
                $.ajax({
                    url: "restore-post/" + user_id,
                    beforeSend: function () {
                        $('#restore_button').text('جاري الاستعادة...');
                    },
                    success: function (data) {
                        setTimeout(function () {
                            $('#restoreModal').modal('hide');
                            $('#user_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });
            $(document).on('click', '.force_delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف المنشور");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "force-delete/" + user_id,
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

