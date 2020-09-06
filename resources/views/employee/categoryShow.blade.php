@extends('adminpanel.master')
@section('content')
<div class="right_col" role="main">
<div class="container">
    <br />
    <h3 align="right">قسم الوظائف</h3>
    <br />
    <div align="right">
        <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">إضافة دورات تدريبية للقسم</button>
    </div>
    <br />
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="user_table">
            <thead>
            <tr>
                <th width="20%">عنولن الدورة</th>
                <th width="20%">القسم</th>
                <th width="10%">تاريخ إنشاء الدورة</th>
                <th width="15%">العمليات</th>
            </tr>
            </thead>
        </table>
    </div>
    <br />
    <br />
</div>
</div>
<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> إنشاء مسمى وظيفي جديد</h4>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-4" >المسمى الوظيفي :</label>
                        <div class="col-md-8">
                            <select class="form-control" name="category">
                                    <option value="{{$category->id}}">{{$category->id}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" >الدورات التدريبية :</label>
                        <div class="col-md-8">
                            <select class="form-control" name="training[]" multiple>
                                @foreach($trainings as $train)
                                <option value="{{$train->id}}">{{$train->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="نشر" />
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
                <h2 class="modal-title">حذف الدورة</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">سيتم حذف الدورة من القسم بشكل كامل؟</h4>
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
                url: "/CategoryShowId/{{$id}}",
            },
            columns:[
                {
                    data: 'training',
                    name: 'training'
                },
                {
                    data: 'category',
                    name: 'category'
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

        $('#create_record').click(function(){
            $('.modal-title').text("إضافة دورات جديده");
            $('#sample_form')[0].reset();
            $('#store_image').html('');
            $('#action_button').val("إضافة");
            $('#action').val("Add");
            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function(event){
            event.preventDefault();
            if($('#action').val() == 'Add')
            {
                $.ajax({
                    url:"{{ route('Emp_Category_Training.store') }}",
                    method:"POST",
                    data: new FormData(this),
                    contentType: false,
                    cache:false,
                    processData: false,
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#sample_form')[0].reset();
                            $('#user_table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    }
                })
            }
        });

        var user_id;

        $(document).on('click', '.delete', function(){
            user_id = $(this).attr('id');
            $('.modal-title').text("حذف الوظيفة");
            $('#ok_button').text('حذف');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function(){
            $.ajax({
                url:"/Category_training/destroy/"+user_id,
                beforeSend:function(){
                    $('#ok_button').text('جاري حذف الوظيفة...');
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
