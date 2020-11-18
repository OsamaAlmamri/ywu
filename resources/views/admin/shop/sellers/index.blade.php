@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">حسابات البائعين النظام</h3>
        <br/>
    </div>
@endsection

@section('custom_js')
    @include('adminpanel.active')
    <script>
        Active('{{route('admin.shop.sellers.active')}}');
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


