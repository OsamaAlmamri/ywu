@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right">الدورات التدريبية</h3>
        <br/>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <select name="filter_country" id="filter_country" class="form-control" required>
                        <option value="">اختر اسم المادة</option>
                        @foreach($categories as $country)

                            <option value="{{ $country->id }}">{{ $country->name }}</option>

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
                    <h4 class="modal-title"> إنشاء دورة تدريبية جديده</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4"> التصنيف :</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="category_id" name="category_id">
                                    @if($categories->count())
                                        @foreach ($categories as $category)
                                            <option id="C_name" value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">اسم الدورة : </label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">نوع الدورة : </label>
                            <div class="col-md-8">
                                <select class="form-control" id="type" name="type">
                                    <option value="عام">عام</option>
                                    <option value="خاص">خاص</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">المدرب : </label>
                            <div class="col-md-8">
                                <input type="text" name="instructor" id="instructor" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col col-md-4">الاقسام : </label>
                            <div class="col col-md-8">
                                <div class="row" id="checkboxes">
                                    @foreach($departments as $department)
                                        <div class="col col-sm-6">
                                            <input type="checkbox" name="departments[]"
                                                   id="department_{{$department->id}}" value="{{$department->id}}"/>
                                            {{$department->name}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">الشهادة : </label>
                            <div class="col-md-8">
                                <select class="form-control" id="has_certificate" name="has_certificate">
                                    <option value="0">لا</option>
                                    <option value="1">نعم</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">مدة الدروة : </label>
                            <div class="col-md-8">
                                <select class="form-control" id="length" name="length">
                                    <option></option>
                                    @for($i=3;$i<=10;$i++)
                                        <option value="{{$i}} ساعات">{{$i}} ساعات</option>
                                    @endfor
                                    @for($j=11;$j<=100;$j++)
                                        <option value="{{$j}} ساعة">{{$j}} ساعة</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">تاريخ بدء الدورة : </label>
                            <div class="col-md-8">
                                <input class="form-control" id="start_at" name="start_at" value="" type="date">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-4">تاريخ انتهاء الدورة : </label>
                            <div class="col-md-8">
                                <input class="form-control" id="end_at" name="end_at" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">صورة الغلاف : </label>
                            <div class="col-md-8">
                                <input type="file" name="image" id="image"/>
                                <span id="store_image"></span>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="control-label col-md-12">الوصف : </label>
                            <div class="col-md-12">
                                <textarea name="description" id="description" class="description"> </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-12">المتطابات : </label>
                            <div class="col-md-12">
                                <textarea name="learn" id="learn" class="description"> </textarea>
                            </div>


                            <div class="form-group" align="center">
                                <input type="hidden" name="action" id="action"/>
                                <input type="hidden" name="hidden_id" id="hidden_id"/>
                                <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                       value="نشر"/>
                            </div>
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
                    <div id="show_category_id"></div>
                    <br>
                    <div id="show_type"></div>
                    <br>
                    <div id="show_mark"></div>
                    <br>
                    <div id="show_length"></div>
                    <br>
                    <div id="show_start_at"></div>
                    <br>
                    <div id="show_end_at"></div>
                    <br>
                    <div id="show_title"></div>
                    <div>
                        <a id="title" href="" class="btn btn-info btn-sm" style="float: right">
                            عرض عناوين الدورة
                        </a>
                    </div>
                    <br>
                    <br>
                    <div id="show_image"></div>
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
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف الدورة؟</h4>
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

    @include('adminpanel.active')
    <script>

        Active('{{route('training.active')}}');
        $(document).ready(function () {
            fill_datatable();

            function fill_datatable(filter_country = '') {
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
                            @if ((Auth::user()->can('manage training') == true))
                        {
                            text: '<i class="fa fa-plus" ></i>  إنشاء دورة تدريبية جديده ',
                            className: 'btn btn-info create_record',
                        },
                        @endif
                    ],
                    ajax: {
                        url: "{{ route('training') }}",
                        data: {filter_country: ''}
                    },
                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                            title: 'عنوان الدورة'
                        },
                        {
                            data: 'subject',
                            name: 'subject',
                            title: '  التصنيف'

                        }, {
                            data: 'btn_image',
                            name: 'btn_image',
                            title: ' الصورة '

                        },
                        {
                            data: 'type',
                            name: 'type',
                            title: ' النوع '

                        },
                        {
                            data: 'btn_mark',
                            name: 'btn_mark',
                            title: '   مييز',

                        },
                        {
                            data: 'length',
                            name: 'length',
                            title: '  مدة الدورة'

                        },
                        {
                            data: 'start_at',
                            name: 'start_at',
                            title: 'تاريخ بدء الدورة'
                        },
                        {
                            data: 'end_at',
                            name: 'end_at',
                            title: 'تاريخ إنتهاء الدورة'
                        },
                        {
                            data: 'published',
                            name: 'published',
                            title: 'تاريخ  النشر'
                        },
                        {
                            data: 'instructor',
                            name: 'instructor',
                            title: ' المدرب',
                            orderable: false,
                        },
                        {
                            data: 'has_certificate',
                            name: 'has_certificate',
                            title: 'الشهادة ',
                            render: function (data, row) {
                                return (data == '1') ? "نعم" : "لا";
                            }
                        }, {
                            data: 'content',
                            name: 'content',
                            title: 'عرض المحتويات',
                            orderable: false,
                        },
                            @if ((Auth::user()->can('manage training') == true))
                        {
                            data: 'action',
                            name: 'action',
                            title: 'عمليات',
                            orderable: false,
                        },
                        @endif
                    ],
                });
            }

            $('#filter').click(function () {
                var filter_country = $('#filter_country').val();

                if (filter_country != '') {
                    $('#user_table').DataTable().destroy();
                    fill_datatable(filter_country);
                } else {
                    alert('قم باختيار اسم المادة ');
                }
            });
            $('#reset').click(function () {
                $('#filter_country').val('');
                $('#user_table').DataTable().destroy();
                fill_datatable();
            });

            $('.create_record').click(function () {
                $('.modal-title').text("إضافة دورة تدريبية جديده");
                $('#checkboxes').find('input:checkbox').attr('checked', false);
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
                        url: "{{ route('training.store') }}",
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
                                $('#formModal').modal('hide');

                            }
                            $('#form_result').html(html);
                        }
                    })
                }

                if ($('#action').val() == "Edit") {
                    $.ajax({
                        url: "{{ route('training.update') }}",
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
                                $('#store_image').html('');
                                $('#user_table').DataTable().ajax.reload();
                                $('#formModal').modal('hide');

                            }
                            $('#form_result').html(html);
                        }
                    });
                }
            });

            $(document).on('click', '.show_training', function () {
                var id = $(this).attr('id');
                $('#form_show').html('');
                $.ajax({
                    url: "{{URL::to('')}}/training/show/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#show_name').html("<h4>عنوان الدورة: <b>" + html.data.name + "</b></h4>");
                        $('#show_category_id').html("اسم المادة: <b>" + html.data.category.name + "</b>");
                        $('#show_type').html("نوع الدورة : <b>" + html.data.type + "</b>");

                        if (html.data.mark != null) {
                            $('#show_mark').html("علامة : <b>" + html.data.mark + "</b>");
                        } else {
                            $('#show_mark').html("<b>علامة :</b>");
                        }
                        if (html.data.length != null) {
                            $('#show_length').html("مدة الدورة: <b>" + html.data.length + "</b>");
                        } else {
                            $('#show_length').html("<b>مدة الدورة: غير محدد</b>");
                        }
                        if (html.data.start_at != null) {
                            $('#show_start_at').html("تاريخ بدء الدورة: <b>" + html.data.start_at + "</b>");
                        } else {
                            $('#show_start_at').html("<b>تاريخ بدء الدورة : غير محدد</b>");
                        }
                        if (html.data.end_at != null) {
                            $('#show_end_at').html("تاريخ انتهاء الدورة: <b>" + html.data.end_at + "</b>");
                        } else {
                            $('#show_end_at').html("<b>تاريخ انتهاء الدورة : غير محدد</b>");
                        }
                        $('#title').attr("href", "/showID/" + id);
                        if (html.data.thumbnail != null) {
                            $('#show_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.thumbnail + " style='height:30em' class='img-thumbnail' />");
                        } else {
                            $('#show_image').html("<b><a href='#'></a>" + html.data.thumbnail + "</b>");
                        }
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("عرض تفاصيل الدورة");
                        $('#formShow').modal('show');
                    }
                })
            });

            $(document).on('click', '.edit_training', function () {
                // $('#sample_form')[0].reset();
                $('#checkboxes').find('input:checkbox').attr('checked', false);

                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url: "{{URL::to('')}}/training/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#name').val(html.data.name);
                        $('#category_id').val(html.data.category_id);
                        $('#start_at').val(html.data.start_at);
                        $('#end_at').val(html.data.end_at);
                        $('#length').val(html.data.length);
                        $('#has_certificate').val(html.data.has_certificate);
                        $('#instructor').val(html.data.instructor);
                        // $('#description').val(html.data.description);
                        tinyMCE.get("description").setContent((html.data.description == null ? '' : html.data.description));
                        tinyMCE.get("learn").setContent((html.data.learn == null ? '' : html.data.learn));

                        $('#store_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.thumbnail + " width='70' class='img-thumbnail' />");
                        $('#store_image').append("<input type='hidden' name='hidden_image' value='" + html.data.thumbnail + "' />");
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("تعديل بيانات الدورة");
                        $('#action_button').val("تعديل");

                        $('#action').val("Edit");
                        // $('input[name="departments[]"]').each(function() {
                        //     this.checked = false;
                        // });

                        $.each(html.data.departments, function (key, department) {
                            $("#department_" + department.id).prop('checked', 'checked');
                        });

                        $('#formModal').modal('show');
                    }
                })
            });

            var user_id;
            $(document).on('click', '.delete_training', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف الدورة التدريبية");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/training/destroy/" + user_id,
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
