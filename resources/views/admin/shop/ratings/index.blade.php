@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> تقييمات المنتج ({{$product->name}}) </h3>
        <br/>


    </div>
@endsection
@section('models')

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">حذف التقييم</h2>
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
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass('row1');
                        $(row).attr('data-id', data.id);
                        $(row).attr('width', "100%");
                    },
                    lengthMenu: [[10, 50, 100, -1], [10, 50, 100, 'الكل']],
                    buttons: [],
                    ajax: {
                        url: "{{route('admin.shop.products.ratings.index',$product->id)}}",
                        data: {category_id: $("#filter_country").val()}
                    },
                    columns: [

                        {
                            title: 'العميل',
                            data: 'user_name',
                            name: 'user_name',
                        },
                        {
                            title: 'التقييم',
                            data: 'rating',
                            name: 'rating',
                        },
                        {
                            title: 'نص االتقييم',
                            data: 'message',
                            name: 'message',
                        },

                        {
                            title: 'تاريخ التقييم ',
                            data: 'published',
                        },


                    ],

                });
            }

            $(document).on('click', '.create_record', function () {
                $('.modal-title').text("إ إنشاء منتج  جديدة");
                $('#action_button').val("حفظ");
                $('#action').val("Add");
                $('#sample_form')[0].reset();
                $('#store_image').html('');
                $('#old_image_preview_box').hide();
                $('#old_image_preview').html('');
                $('#formModal').modal('show');
            });


            $(document).on('click', '#filter', function () {
                $('#user_table').DataTable().destroy();
                fill_datatable();
            });

            var deleted_id = 0;
            $(document).on('click', '.delete', function () {
                deleted_id = $(this).attr('id');
                $('.modal-title').text("حذف التقييم ");
                $('#ok_button').text('حذف');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function () {
                $.ajax({
                    url: "{{URL::to('')}}/admin/shop/products/ratings/destroy/" + deleted_id,
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


