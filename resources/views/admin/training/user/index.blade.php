@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">المستخدمين</h3>
        <br/>
    </div>
@endsection
@section('models')
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
                buttons: [],
                ajax: {
                    url: "{{ route('user',$id) }}",
                    {{--                    url: "{{route('questions.index',$id)}}",--}}
                },
                columns: [
                    {
                        title: ' #',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        title: 'اسم المستخدم',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'نوع المستخدم',
                        data: 'type',
                        name: 'type'
                    },
                    {
                        title: ' المحافظة',
                        data: 'gov',
                        name: 'gov'
                    },
                    {
                        title: ' المديرية',
                        data: 'district',
                        name: 'district'
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
                        @if ((Auth::user()->can('active users') == true))

                    {
                        title: 'حالة الحساب',
                        data: 'status',
                        name: 'status'
                    },
                        @endif
                    {
                        title: 'تاريخ إنشاء الحساب',
                        data: 'published',
                        data: 'published',
                    },
                        @if ((Auth::user()->can('manage users') == true))

                    {
                        title: 'العمليات',
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                    @endif
                ]
            });

            var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/user/destroy/" + user_id,
                    beforeSend: function () {
                        $('#ok_button').text('جاري توقيف الحساب...');
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




