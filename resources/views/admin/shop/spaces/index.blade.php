@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> المساحات</h3>
        <br/>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <select name="filter_country" id="filter_country" class="form-control" required>
                        <option value="0">الكل</option>
                        @foreach(zones() as $c)
                            <option value="{{ $c->id }}">{{ $c->name_ar }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-info">عرض</button>
                    <button type="button" name="reset" id="reset" class="btn btn-default">الغاء</button>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

    </div>
@endsection
@section('models')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء مساحة جديد</h4>

                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">المحافظة :</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="zone_id" name="zone_id">

                                    @foreach(zones() as $c)
                                        <option value="{{$c->id}}">{{$c->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">اسم المساحة : </label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">معلومات اخرى : </label>
                            <div class="col-md-12">
                                <textarea class="form-control description" id="description" name="description" type="text">
                                    <div id="description_body"></div>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="action"/>
                            <input type="hidden" name="hidden_id" id="hidden_id"/>
                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                   value="اضافة"/>
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
                    <div id="show_description"></div>

                </div>
            </div>
        </div>
    </div>
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف المساحة</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من الحذف؟</h4>
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
    @include('adminpanel.wyswyg')
    <script>
        $(document).ready(function () {
            fill_datatable();
            function fill_datatable() {
                var dataTable = $('#user_table').DataTable({
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
                            text: '<i class="fa fa-plus" ></i>  إنشاء مساحة جديدة ',
                            className: 'btn btn-info create_record',
                        },
                    ],
                    ajax: {
                        url: "{{route('admin.shop.spaces.index')}}",
                        data: {zone_id: $("#filter_country").val()}
                    },
                    columns: [
                        {
                            title: ' الاسم ',
                            data: 'name',
                            name: 'name'
                        },

                        {
                            title: 'المحافظة ',
                            name: 'zone',
                            data: 'zone',
                        },
                        {
                            title: 'تاريخ الاضافة ',
                            data: 'published',
                        },
                        {
                            title: 'عمليات',
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ],

                });
            }

            $(document).on('click', '.create_record', function () {
                $('.modal-title').text("إ إنشاء مساحة  جديدة");
                $('#action_button').val("حفظ");
                $('#action').val("Add");
                $('#sample_form')[0].reset();
                $('#store_image').html('');
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add')
                    var url = "{{ route('admin.shop.spaces.store') }}";
                else
                    var url = "{{ route('admin.shop.spaces.update') }}";
                var formData = new FormData(this);
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        var html = '';
                        $('#sample_form')[0].reset();
                        $('#user_table').DataTable().ajax.reload();
                        $("#formModal .print-error-msg").html('');
                        $('#formModal').modal('hide');
                    },
                    error: function (jqXhr, status) {
                        console.log(jqXhr);
                        if (jqXhr.status === 422) {
                            $("#formModal .print-error-msg").html('');
                            var errors = jqXhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $("#formModal").find("#modal_error_" + key).html(value);
                            });
                        }
                    }
                })


            });

            $(document).on('click', '.show', function () {
                var id = $(this).attr('id');
                $('#form_show').html('');
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/spaces/show/" + id ,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#show_description').html(data.description);
                        $('.modal-title').text("  وصف المساحة");
                        $('#formShow').modal('show');
                    }
                })
            });

            $(document).on('click', '#filter', function () {
                $('#user_table').DataTable().destroy();
                fill_datatable();
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/spaces/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#name').val(html.data.name);
                        $('#description_body').html(html.data.description);
                        tinyMCE.activeEditor.setContent(html.data.description);
                        $('#zone_id').val(html.data.zone_id);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("تعديل بيانات المساحة ");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });
            var deleted_id = 0;
            $(document).on('click', '.delete', function () {
                deleted_id = $(this).attr('id');
                $('.modal-title').text("حذف المساحة ");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/spaces/destroy/" + deleted_id,
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


