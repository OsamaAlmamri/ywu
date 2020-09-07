@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">نتائج الدورة التدريبية</h3>
        <br/>
    </div>
@endsection
@section('models')
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
                        url: "{{route('questions.results',$id)}}",
                    },
                    columns: [

                        {
                            title: 'عنوان الدورة',
                            data: 'training',
                            name: 'training'
                        },
                        {
                            title: 'المختبر',
                            data: 'user.name',
                            name: 'user.name'
                        },
                        {
                            data: 'grade',
                            name: 'grade',
                            title: ' النتيجة '

                        },
                        {
                            title: 'تاريخ اكمال الاختبار',
                            name: 'published',
                            data: 'published',
                        },

                    ]
                });
            }
        });
    </script>

@endsection




