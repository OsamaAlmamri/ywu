@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">طلبات الانضمام للدورة التدريبية</h3>
        <br/>
    </div>
@endsection
@section('models')

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف الطلب </h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" class="modal_description" style="margin:0;">هل انت متاكد من حذف الطلب ؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" data-type="delete" class="btn btn-danger">
                        نعم
                    </button>
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
                    buttons: [],
                    ajax: {
                        url: "{{route('user_trainings',$id)}}",
                    },
                    columns: [
                        {
                            title: 'الدورة التدريبة',
                            data: 'training.name',
                            name: 'training.name'
                        },
                        {
                            title: ' المتدرب',
                            data: 'user.name',
                            name: 'user.name'
                        }, {
                            title: ' نوع المتدرب',
                            data: 'user.type',
                            name: 'user.type'
                        },
                        {
                            title: 'تاريخ الطلب',
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


            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("حذف الطلب ");
                $('.modal_description').text(" هل انت متاكد من حذف الطلب  ؟ ");
                $('#ok_button').text('حذف');
                $('#ok_button').addClass('btn-danger');
                $('#ok_button').removeClass('btn-info');
                $('#ok_button').attr('data-type', 'delete');
                $('#confirmModal').modal('show');
            });

            $(document).on('click', '.accept', function () {
                user_id = $(this).attr('id');
                $('.modal-title').text("قبول الطلب ");
                $('.modal_description').text(" هل انت متاكد من قبول الطلب  ؟ ");
                $('#ok_button').text('قبول');
                $('#ok_button').addClass('btn-info');
                $('#ok_button').removeClass('btn-danger');
                $('#ok_button').attr('data-type', 'accept');

                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                var action_type = $(this).data('type');
                $.ajax({
                    url: "{{URL::to('')}}/user_trainings/destroy/" + user_id + '/' + action_type,

                    beforeSend: function () {
                        $('#ok_button').text(action_type == 'accept' ? 'جاري القبول...' : 'جاري الحذف...');
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




