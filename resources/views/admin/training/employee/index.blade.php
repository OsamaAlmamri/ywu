@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">حسابات الموظفين</h3>
        <br/>
    </div>
@endsection
@section('models')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء حساب موظف جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">اسم الموظف :</label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">الايميل : </label>
                            <div class="col-md-8">
                                <input type="text" name="email" id="email" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">رقم الهاتف : </label>
                            <div class="col-md-8">
                                <input type="number" name="phone" id="phone" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">كلمة المرور : </label>
                            <div class="col-md-8">
                                <input type="text" name="password" id="password" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">الوظيفة : </label>
                            <div class="col-md-8">
                                <select class="form-control" id="job_id" name="job_id">
                                    @foreach($jobs as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="control-label col-md-4">القسم : </label>
                            <div class="col-md-8">
                                <select class="form-control" id="department_id" name="department_id">
                                    @foreach($departments as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="control-label col-md-4">الفرع : </label>
                            <div class="col-md-8">
                                <select class="form-control" id="branch_id" name="branch_id">
                                    @foreach($branchs as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
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
                    <h4 class="modal-title"> بيانات الدورة</h4>
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
                    <div>
                        <a id="title" href="" class="btn btn-info btn-sm" style="float: right">
                            عرض عناوين الدورة
                        </a>
                    </div>
                    <br>
                </div>
            </div>
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

                    {
                        text: '<i class="fa fa-plus" ></i>  إنشاء حساب موظف جديد  ',
                        className: 'btn btn-info create_record',
                    },
                ],
                ajax: {
                    url: "{{ route('employee',$id) }}",
                },
                columns: [
                    {
                        title: 'اسم المستخدم',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: ' الهاتف',
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        title: 'الايميل',
                        data: 'email',
                        name: 'email'
                    },
                    {
                        title: 'القسم ',
                        data: 'department',
                        name: 'department'
                    }, {
                        title: ' الوظيفة',
                        data: 'job',
                        name: 'job'
                    }, {
                        title: ' الفرع',
                        data: 'branch',
                        name: 'branch'
                    },
                    {
                        title: 'حالة الحساب',
                        data: 'status',
                        name: 'status'
                    },
                    {
                        title: 'تاريخ إنشاء الحساب',
                        data: 'published',
                        data: 'published',
                    },
                    {
                        title: 'العمليات',
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });

            $('.create_record').click(function () {
                $('.modal-title').text("إضافة حساب موظف جديد");
                $('#sample_form')[0].reset();
                $('#store_image').html('');
                $('#action_button').val("نشر");
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add') {
                    $.ajax({
                        url: "{{ route('employee.store') }}",
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
                        url: "{{ route('employee.update') }}",
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
                                $('#formModal').modal('hide');

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

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url: "{{URL::to('')}}/Employee/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#name').val(html.data.name);
                        $('#email').val(html.data.email);
                        // $('#password').hide();
                        $('#job_id').val(html.data.employee.job_id);
                        $('#branch_id').val(html.data.employee.branch_id);
                        $('#phone').val(html.data.phone);
                        $('#department_id').val(html.data.employee.department_id);
                        $('#status').val(html.data.status);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("تعديل بيانات الحساب");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });

            $(document).on('click', '.show', function () {
                var id = $(this).attr('id');
                $('#form_show').html('');
                $.ajax({
                    url: "{{URL::to('')}}/Employee/show/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#show_name').html("<h4>اسم الموظف : <b>" + html.data.name + "</b></h4>");
                        $('#show_email').html("الايميل : <b>" + html.data.email + "</b>");
                        if (!html.data.category) {
                            $('#show_type').html("<b>الوظيفة : تم حذف القسم</b>");
                        } else {
                            $('#show_type').html("الوظيفة : <b>" + html.data.category.name + "</b>");
                        }
                        $('#show_status').html("حالة الحساب : <b>" + html.data.status + "</b>");
                        $('#title').attr("href", "/showID/" + id);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("عرض تفاصيل الحساب");
                        $('#formShow').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("إيقاف حالة الحساب");
                $('#ok_button').text('إيقاف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/Employee/destroy/" + user_id,
                    beforeSend: function () {
                        $('#ok_button').text('جاري إيقاف الحساب...');
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


