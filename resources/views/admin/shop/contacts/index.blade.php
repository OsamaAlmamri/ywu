@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> رسائل تواصل معنا </h3>
        <br/>


    </div>
@endsection
@section('models')

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف الرسالة</h2>
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
                        url: "{{route('admin.shop.contacts.index')}}",
                        data: {category_id: $("#filter_country").val()}
                    },
                    columns: [

                        {
                            title: 'المرسل',
                            data: 'name',
                            name: 'name',
                        },
                        {
                            title: 'رقم الهاتف',
                            data: 'phone',
                            name: 'phone',
                        },
                        {
                            title: 'الايميل',
                            data: 'email',
                            name: 'email',
                        },
                        {
                            title: 'نص االرسالة',
                            data: 'message',
                            name: 'message',
                        },

                        {
                            title: 'تاريخ الرسالة ',
                            data: 'published',
                        },
                        {
                            title: ' عمليات ',
                            data: 'action',
                        },


                    ],

                });
            }

            $(document).on('click', '#filter', function () {
                $('#user_table').DataTable().destroy();
                fill_datatable();
            });

            var deleted_id = 0;
            $(document).on('click', '.delete', function () {
                deleted_id = $(this).attr('id');
                $('.modal-title').text("حذف الرسالة ");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/contacts/destroy/" + deleted_id,
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


