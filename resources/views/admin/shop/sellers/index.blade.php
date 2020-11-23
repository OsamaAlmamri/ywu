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
    </script>
@endsection


