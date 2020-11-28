@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">حسابات البائعين النظام</h3>
        <br/>
    </div>
    <div id="formShow" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> الصور </h4>
                </div>
                <div class="modal-body">
                    <span id="form_show"></span>
                    <div id="show_description" class="row">
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
                    <h2 class="modal-title">حذف التاجؤ</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من الحذف؟</h4>
                    <p>ستم حذف جميع المنتجات و الطلبات المرتبطة بهذا التاجر ولن تستطيع استعادها مرة اخرى بعد الحذف </p>
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
        Active('{{route('admin.shop.sellers.active')}}');
        $(document).on('click', '.show_images', function () {

            var id = $(this).attr('id');
            $.ajax({
                url: "{{URL::to('')}}/admin/shop/sellers/showImages/" + id + "",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#show_description").html(data);
                }
            })
            $('#formShow').modal('show');
        });


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

                    // {
                    //     text: '<i class="fa fa-plus" ></i>  إنشاء حساب مدير جديد  ',
                    //     className: 'btn btn-info create_record',
                    // },
                ],
                ajax: {
                    url: "{{ route('admin.shop.sellers.index') }}",
                },
                columns: [
                    {
                        title: ' الرقم',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
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
                    // '', 'ssn_image', 'gov_id', 'district_id', 'more_address_info'

                    {
                        title: '  الاسم التجاري ',
                        data: 'seller.sale_name',
                        name: 'seller.sale_name'
                    },

                    {
                        title: '  المحافظة ',
                        data: 'seller.gov',
                        name: 'seller.gov'
                    },

                    {
                        title: ' المديرية  ',
                        data: 'seller.district',
                        name: 'seller.district'
                    },

                    {
                        title: ' معلومات اخرى  ',
                        data: 'seller.more_address_info',
                        name: 'seller.more_address_info'
                    },


                    {
                        title: 'تاريخ إنشاء الحساب',
                        data: 'published',
                        data: 'published',
                    },
                        @if ((Auth::user()->can('active sellers') == true))
                    {
                        title: 'حالة الحساب',
                        data: 'btn_status',
                        name: 'btn_status'
                    },
                        @endif
                        @if ((Auth::user()->can('manage sellers') == true))


                    {
                        title: 'العمليات',
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                    @endif
                ]
            });
        });

        var deleted_id = 0;
        $(document).on('click', '.delete', function () {
            deleted_id = $(this).attr('id');
            $('#ok_button').text('حذف');
            $('#confirmModal').modal('show');
        });
        $('#ok_button').click(function () {
            $.ajax({
                url: "{{URL::to('')}}/admin/shop/sellers/destroy/" + deleted_id,
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
    </script>
@endsection


