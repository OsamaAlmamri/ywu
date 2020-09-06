@extends('adminpanel.master')
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <br/>
            <h3 align="right">سلة المحذوفات </h3>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user_table">
                    <thead>
                    <tr>
                        <th width="20%">اسم الدورة</th>
                        <th width="30%">اسم المادة</th>
                        <th width="10%">مدة الدورة</th>
                        <th width="10%">تاريخ بدء الدورة</th>
                        <th width="10%">تاريخ إنتهاء الدورة</th>
                        <th width="10%">تاريخ النشر</th>
                        <th width="15%">العمليات</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <br/>
            <br/>
        </div>
    </div>

    <div id="formShow" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> بيانات الدورة</h4>
                </div>
                <div class="modal-body">
                    <span id="form_show"></span>
                    <div id="show_name"></div>
                    <br>
                    <div id="show_subject"></div>
                    <br>
                    <div id="show_length"></div>
                    <br>
                    <div id="show_start_at"></div>
                    <br>
                    <div id="show_end_at"></div>
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
                    <h4 align="center" style="margin:0;">هل انت متاكد من استعادة المادة؟</h4>
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
                    <h2 class="modal-title">حذف المادة</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">سيتم حذف الدورة بشكل نهائي؟</h4>
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

            $('#user_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('training-trashed') }}",
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'subject',
                        name: 'subject',
                    },
                    {
                        data: 'length',
                        name: 'length',
                    },
                    {
                        data: 'start_at',
                        name: 'start_at',
                    },
                    {
                        data: 'end_at',
                        name: 'end_at',
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });

            $(document).on('click', '.show_training', function () {
                var id = $(this).attr('id');
                $('#form_show').html('');

                $.ajax({
                    url: "training/show-trashed/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#show_name').html("<h4>عنوان الدورة: <b>" + html.data.name + "</b></h4>");
                        $('#show_subject').html("اسم المادة: <b>" + html.data.subject.name + "</b>");
                        $('#show_length').html("مدة الدورة: <b>" + html.data.length + "</b>");
                        $('#show_start_at').html("تاريخ بدء الدورة: <b>" + html.data.start_at + "</b>");
                        $('#show_end_at').html("تاريخ انتهاء الدورة: <b>" + html.data.end_at + "</b>");
                        if (html.data.thumbnail != null) {
                            $('#show_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.thumbnail + " style='height:30em' class='img-thumbnail' />");
                        } else {
                            $('#show_image').html("<b><a href='#'></a>" + html.data.thumbnail + "</b>");
                        }
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("عرض المنشور");
                        $('#formShow').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.restore_training', function () {
                user_id = $(this).attr('id');
                $('#restoreModal').modal('show');
            });

            $('#restore_button').click(function () {
                $.ajax({
                    url: "restore-training/" + user_id,
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
            $(document).on('click', '.force_delete_training', function () {
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "force-training/" + user_id,
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
