@extends('adminpanel.master')
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <br />
            <h3 align="right">عناوين الدورة التدريبية</h3>
            <br />
            <div align="right">
                <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">إنشاء عنوان فرعي جديده</button>
            </div>
            <br />
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user_table">
                    <thead>
                    <tr>
                        <th width="20%">العنوان</th>
                        <th width="30%">عنوان الدورة</th>
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

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء عنوان جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4" >عنوان الدورة :</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="training" name="training">
                                    @if($category->count())
                                            <option id="C_name"  value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" >العنوان : </label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control" />
                            </div>
                        </div>
                        <br />
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
                    <div>
                        <a id="title" href="" class="btn btn-info btn-sm" style="float: right">
                            عرض محتوى العوان
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف العنوان</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف العنوان؟</h4>
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

            fill_datatable();

            function fill_datatable()
            {
                var dataTable = $('#user_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax:{
                        url: "/showID/{{ $id }}",
                    },
                    columns: [
                        {
                            data:'name',
                            name:'name'
                        },
                        {
                            data:'training',
                            name:'training'
                        },
                        {
                            data:'published',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ]
                });
            }

            $('#create_record').click(function(){
                $('.modal-title').text("إضافة عنوان فرعي جديد");
                $('#sample_form')[0].reset();
                $('#action_button').val("نشر");
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                if($('#action').val() == 'Add')
                {
                    $.ajax({
                        url:"{{ route('title.store') }}",
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

                if($('#action').val() == "Edit")
                {
                    $.ajax({
                        url:"{{ route('title.update') }}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
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
                    });
                }
            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url:"/title/edit/"+id+"",
                    type: "GET",
                    dataType:"json",
                    success:function(html){
                        $('#name').val(html.data.name);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("تعديل العنوان");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });

            $(document).on('click', '.show', function(){
                var id = $(this).attr('id');
                window.location.href="/showContentID/" + id;
            });

            var user_id;

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف العنوان");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"/title/destroy/"+user_id,
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
