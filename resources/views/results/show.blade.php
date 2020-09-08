@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">اسئلة الدورة التدريبية</h3>
        <br/>
    </div>
@endsection
@section('models')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> إنشاء سؤال جديد</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-sm-4">عنوان الدورة :</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="training_id" name="training_id">
                                    @if($category->count())
                                        <option id="C_name" value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                </select>
                                <div class="print-error-msg alert-danger" id="modal_error_training_id"></div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">السؤال : </label>
                            <div class="col-md-8">
                                <textarea name="text" id="text" class="form-control"></textarea>
                            </div>
                            <div class="print-error-msg alert-danger" id="modal_error_text"></div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">اضافة صورة : </label>
                            <div class="col-md-8">
                                <input type="file" name="image" id="image"/>
                                <span id="store_image"></span>
                            </div>
                            <div class="print-error-msg alert-danger" id="modal_error_image"></div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                الجواب الصحيح
                            </label>
                            <label class=" col-md-9 col-sm-9 col-xs-12">
                                الخيارات
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" checked="" value="option1"
                                               name="answer">
                                        الخيار الاول
                                    </label>
                                </div>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" name="option1" id="option1"
                                       placeholder="الخيار الاول  ">
                                <div class="print-error-msg alert-danger" id="modal_error_option1"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="option2"
                                               name="answer">
                                        الخيار الثاني
                                    </label>
                                </div>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" name="option2" id="option2"
                                       placeholder="الخيار الثاني  ">
                                <div class="print-error-msg alert-danger" id="modal_error_option2"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="option3"
                                               name="answer">
                                        الخيار الثالث
                                    </label>
                                </div>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" name="option3" id="option3"
                                       placeholder="الخيار الثالث  ">
                                <div class="print-error-msg alert-danger" id="modal_error_option3"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="option4"
                                               name="answer">
                                        الخيار الرابع
                                    </label>
                                </div>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" name="option4" id="option4"
                                       placeholder="الخيار الرابع  ">
                                <div class="print-error-msg alert-danger" id="modal_error_option4"></div>

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
                    <h2 class="modal-title">حذف السؤال</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من حذف السؤال؟</h4>
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
                            text: '<i class="fa fa-plus" ></i>  إنشاء  سؤال جديد  ',
                            className: 'btn btn-info create_record',
                        },
                    ],
                    ajax: {
                        url: "{{route('questions.index',$id)}}",
                    },
                    columns: [

                        {
                            title: 'عنوان الدورة',
                            data: 'training',
                            name: 'training'
                        },
                        {
                            title: 'السؤال',
                            data: 'text',
                            name: 'text'
                        },
                        {
                            data: 'btn_image',
                            name: 'btn_image',
                            title: ' الصورة '

                        },
                        {
                            title: 'الخيار الاول',
                            name: 'option1',
                            data: 'option1',
                        }, {
                            title: 'الخيار الثاني',
                            name: 'option2',
                            data: 'option2',
                        }, {
                            title: 'الخيار الثالث',
                            name: 'option3',
                            data: 'option3',
                        }, {
                            title: 'الخيار الرابع',
                            name: 'option4',
                            data: 'option4',
                        }, {
                            title: ' الاجابة الصحيحة',
                            name: 'answer',
                            data: 'answer',
                        },
                        {
                            title: 'تاريخ الاضافة',
                            name: 'published',
                            data: 'published',
                        },
                        {
                            title: 'عمليات',
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ]
                });
            }

            $('.create_record').click(function () {
                $('.modal-title').text("إنشاء سؤال جديد");
                $("#formModal .print-error-msg").html('');
                $('#sample_form')[0].reset();
                $('#action_button').val("اضافة");
                $('#store_image').html('');
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == 'Add')
                    var url = "{{ route('questions.store') }}";
                else
                    var url = "{{ route('questions.update') }}";
                $.ajax({
                    url: url,
                    method: "POST",
                    data: new FormData(this),
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

            $(document).on('click', '.edit', function () {
                $('input:radio[name="answer"]').attr('checked', false);
                $('#sample_form')[0].reset();

                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url: "{{URL::to('')}}/questions/edit/" + id + "",
                    type: "GET",
                    dataType: "json",
                    success: function (html) {
                        $('#text').val(html.data.text);
                        $('#option1').val(html.data.option1);
                        $('#option2').val(html.data.option2);
                        $('#option3').val(html.data.option3);
                        $('#option4').val(html.data.option4);
                        $('#hidden_id').val(html.data.id);
                        $('#store_image').html("<img src={{ URL::to('/') }}/assets/images/" + html.data.image + " width='70' class='img-thumbnail' />");
                        $('.modal-title').text("تعديل السؤال ");
                        $('#action_button').val("تعديل");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                        $('input:radio[name="answer"]').filter('[value="'+html.data.answer+'"]').attr('checked', true);
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف السؤال");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/questions/destroy/" + user_id,
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




