@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">حسابات مدراء النظام</h3>
        <br/>
    </div>
@endsection
@section('models')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء حساب مدير جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">اسم المدير :</label>
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
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title"> حذف الحساب</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف هذا الحساب؟</h4>
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
    @include('adminpanel.active')

    <script>

        Active('{{route('admin.admins.active')}}');
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
                        text: '<i class="fa fa-plus" ></i>  إنشاء حساب مدير جديد  ',
                        className: 'btn btn-info create_record',
                    },
                ],
                ajax: {
                    url: "{{ route('admin.admins.index') }}",
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
                        title: 'حالة الحساب',
                        data: 'btn_status',
                        name: 'btn_status'
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
                $('.modal-title').text("إضافة حساب مدير جديد");
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
                        url: "{{ route('admin.admins.store') }}",
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
                                $('#user_table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html);
                        }
                    })
                }

                if ($('#action').val() == "Edit") {
                    $.ajax({
                        url: "{{ route('admin.admins.update') }}",
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
                    url: "{{URL::to('')}}/admin/admins/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#name').val(html.data.name);
                        $('#email').val(html.data.email);
                        // $('#password').hide();
                        $('#phone').val(html.data.phone);
                        $('#status').val(html.data.status);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("تعديل بيانات الحساب");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف الحساب");
                $('#ok_button').text('إيقاف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/admins/destroy/" + user_id,
                    beforeSend: function () {
                        $('#ok_button').text('جاري حذف الحساب...');
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


