@extends('adminpanel.master')
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <br />
            <h3 align="right">حسابات تم ايقافها</h3>
            <br />
            <br />
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user_table">
                    <thead>
                    <tr>
                        <th width="20%">اسم المستخدم</th>
                        <th width="30%">الايميل</th>
                        <th width="10%">نوع الموظف</th>
                        <th width="10%">حالة الحساب</th>
                        <th width="10%">تاريخ إنشاء الحساب</th>
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
                    <h4 class="modal-title"> بيانات الحساب</h4>
                </div>
                <div class="modal-body">
                    <span id="form_show"></span>
                    <div id="show_name"></div>
                    <br>
                    <div id="show_email"></div>
                    <br>
                    <div id="show_type"></div>
                    <br>
                    <div id="show_status"></div>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div id="restoreModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">استعادة حساب المستخدم</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من استعادة حالة الحساب؟</h4>
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
                    <h2 class="modal-title">حذف حساب</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">سيتم حذف الحساب بشكل نهائي؟</h4>
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
                    url: "{{ route('employee-trashed') }}",
                },
                columns:[
                    {
                        title: 'الاسم ',

                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'الايميل ',
                        data: 'email',
                        name: 'email'
                    },
                    {
                        title: 'القسم ',
                        data: 'department',
                        name: 'department'
                    },{
                        title: ' الوظيفة',
                        data: 'job',
                        name: 'job'
                    },{
                        title: ' الفرع',
                        data: 'branch',
                        name: 'branch'
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
                    url:"Employee/edit-trashed/"+id+"",
                    type: "GET",
                    dataType:"json",
                    success:function(html){
                        $('#show_name').html("<h4>اسم الموظف : <b>"+html.data.name+"</b></h4>");
                        $('#show_email').html("الايميل : <b>"+html.data.email+"</b>");
                        if(!html.data.category){
                            $('#show_type').html("<b>الوظيفة : تم حذف القسم</b>");
                        }
                        else{
                            $('#show_type').html("الوظيفة : <b>"+html.data.category.name+"</b>");
                        }
                        $('#show_status').html("حالة الحساب : <b>"+html.data.status+"</b>");
                        $('#title').attr("href","/showID/" + id);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("عرض تفاصيل الحساب");
                        $('#formShow').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.restore', function(){
                user_id = $(this).attr('id');
                $('.modal-title').text("إستعادة الحساب");
                $('#restore_button').text('إستعادة');
                $('#restoreModal').modal('show');
            });

            $('#restore_button').click(function(){
                $.ajax({
                    url:"restore-Employee/"+user_id,
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
                $('.modal-title').text("حذف الحساب ");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"force-Employee/"+user_id,
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
