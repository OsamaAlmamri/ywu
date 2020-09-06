@extends('adminpanel.master')
@section('content')
<div class="right_col" role="main">
<div class="container">
    <br />
    <h3 align="right">المستخدمين</h3>
    <br />
    <br />
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="user_table">
            <thead>
            <tr>
                <th width="20%">اسم المستخدم</th>
                <th width="30%">رقم الهاتف</th>
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

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">ايقاف حالة الحساب</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">هل انت متاكد من ايقاف حالة هذا الحساب؟</h4>
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
                url: "{{ route('user') }}",
            },
            columns:[
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'status',
                    name: 'status'
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

        var user_id;

        $(document).on('click', '.delete', function(){
            user_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function(){
            $.ajax({
                url:"user/destroy/"+user_id,
                beforeSend:function(){
                    $('#ok_button').text('جاري توقيف الحساب...');
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
