@extends('adminpanel.master')
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <br />
            <h3 align="right">سلة المحذوفات </h3>
            <br />
            <br />
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user_table">
                    <thead>
                    <tr>
                        <th width="20%">العنوان</th>
                        <th width="30%">الوصف</th>
                        <th width="3%">القسم</th>
                        <th width="10%">الصورة</th>
                        <th width="10%">تاريخ النشر</th>
                        <th width="15%">العمليات</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <br />
            <br />
        </div>
    </div>
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
@section('scripts')
    <script>
        $(document).ready(function(){

            $('#user_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('women-trashed') }}",
                },
                columnDefs: [{
                    targets: 1,
                    render: function (data, type, row) {
                        return type === 'display' && data.length > 50 ? data.substr(0, 50) + '…' : data;
                    }
                }],
                columns:[
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'body',
                        name: 'body'
                    },
                    {
                        data: 'category',
                        name:'category',
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta){
                            return "<img src={{ URL::to('/') }}/assets/images/" + data + " width='70' class='img-thumbnail' />";
                        },
                        orderable: false
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

            $(document).on('click', '.show', function(){
                var id = $(this).attr('id');
                $('#form_show').html('');

                $.ajax({
                    url:"edit-trashed/"+id+"",
                    type: "GET",
                    dataType:"json",
                    success:function(html){
                        $('#show_title').html("<h4><b>"+html.data.title+"</b></h4>");
                        $('#show_body').html("<b>"+html.data.body+"</b>");

                        if(html.data.book!=null){
                            $('#show_book').html("<b>"+html.data.book+"</b>");
                        }
                        else {
                            $('#show_book').html("<b>لا يوجد كتاب</b>");
                        }
                        if(html.data.video_url!=null){
                            $('#show_video').html("<b><a href='"+html.data.video_url+"'>"+html.data.video_url+"</a></b>");
                        }
                        else {
                            $('#show_video').html("<b><a href='#'></a>لايوجد رابط فيديو</b>");
                        }
                        if(html.data.image !=null){
                            $('#show_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.image + " style='height:30em' class='img-thumbnail' />");
                        }
                        else {
                            $('#show_image').html("<b><a href='#'></a>لايوجد صورة</b>");
                        }
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("عرض المنشور");
                        $('#formShow').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.restore', function(){
                user_id = $(this).attr('id');
                $('.modal-title').text("استعادة المنشور");
                $('#restore_button').text('استعادة');
                $('#restoreModal').modal('show');
            });

            $('#restore_button').click(function(){
                $.ajax({
                    url:"restore-post/"+user_id,
                    beforeSend:function(){
                        $('#restore_button').text('جاري الاستعادة...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#restoreModal').modal('hide');
                            $('#user_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
           });
            $(document).on('click', '.force_delete', function(){
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف المنشور");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"force-delete/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('جاري الحذف...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#user_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });
        });
    </script>
@endsection
