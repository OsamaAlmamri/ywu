@extends('adminpanel.master')

@section('content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>استشارات تم رفضها</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <button style="margin: 5px;" class="btn btn-primary  btn-sm restore-all" data-url="">استعادة
                    </button>
                    <button style="margin: 5px;" class="btn btn-danger btn-sm force-all" data-url="">حذف نهائي</button>
                    @csrf
                    <div class="table-responsive" id="table_data">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                            <tr class="headings">
                                <th><input type="checkbox" id="check_all"></th>
                                <th class="column-title">اسم المستخدم</th>
                                <th class="column-title">القسم</th>
                                <th class="column-title">المحتوى</th>
                                <th class="column-title">تاريخ الطلب</th>
                                <th class="column-title">الإجراءات</th>
                            </tr>
                            </thead>
                            @if($soft_delete->count())
                                @foreach ($soft_delete as $trashed)
                                    <tbody>
                                    <tr id="tr_{{$trashed->id}}" class="even pointer OfferRow{{$trashed->id}}">
                                        <td><input type="checkbox" class="checkbox" data-id="{{$trashed->id}}"></td>
                                        @if(empty($trashed->user->name))
                                            <td class=" "><a
                                                    href="trashedShow/{{$trashed->user()->withTrashed()->first()->id}}"><b
                                                        style="color: red">{{$trashed->user()->withTrashed()->first()->name}}</b></a>
                                            </td>
                                        @else
                                            <td class=" ">
                                                <a href="userShowId/{{$trashed->user->id}}"><b>{{$trashed->user->name}}</b></a>
                                            </td>
                                        @endif
                                        <td class=" ">{{ $trashed->category->name }}</td>
                                        <td class=" ">{{ $trashed->body }}</td>
                                        <td class=" ">{{ $trashed->published }}</td>
                                        <td class=" ">
                                            <a href="" post_id="{{$trashed->id}}"
                                               class="post_restore btn btn-primary btn-sm">استعادة</a>
                                            <a href="" offer_id="{{$trashed->id}}"
                                               class="offer_force btn btn-danger btn-sm">حذف نهائي</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            @endif
                        </table>
                    </div>
                    <div class="float-right">
                        {!! $soft_delete->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).on('click', '.post_restore', function (e) {
            e.preventDefault();

            var offer_id = $(this).attr('post_id');
            $.ajax({
                type: 'post',
                url: '{{ route('restore') }}',
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': offer_id,
                },
                success: function (data) {
                    if (data.status == true) {
                        $('#success').show();
                    }
                    $('.OfferRow' + data.id).remove();
                }, erorr: function (reject) {
                },
            });
        });

        {{--هذا الجزء خاص الحذف--}}

        $(document).on('click', '.offer_force', function (e) {
            e.preventDefault();
            var offer_id = $(this).attr('offer_id');
            $.ajax({
                type: 'post',
                url: '{{ route('force') }}',
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': offer_id,
                },
                success: function (data) {
                    if (data.status == true) {
                        $('#success').show();
                    }
                    $('.OfferRow' + data.id).remove();
                }, erorr: function (reject) {
                },
            });
        });
        {{--هذا الجزء خاص بحذف عدة صفوف--}}

        $(document).ready(function () {

            $('#check_all').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked', false);
                }
            });

            $('.checkbox').on('click', function () {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#check_all').prop('checked', true);
                } else {
                    $('#check_all').prop('checked', false);
                }
            });

            $('.force-all').on('click', function (e) {


                var idsArr = [];
                $(".checkbox:checked").each(function () {
                    idsArr.push($(this).attr('data-id'));
                });


                if (idsArr.length <= 0) {
                    alert("قم باختيار عنصر او اكثر للحذف ^_^");
                } else {

                    if (confirm("هل انت متاكد من رفض نشر العناصر المحددة؟")) {

                        var strIds = idsArr.join(",");

                        $.ajax({
                            url: "{{ route('post.multiple-force') }}",
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids=' + strIds,
                            success: function (data) {
                                if (data['status'] == true) {
                                    $(".checkbox:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['message']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });


                    }
                }
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.closest('form').submit();
                }
            });

        });

        {{--هذا الجزء خاص بموافقة عدة صفوف--}}

        $(document).ready(function () {

            $('#check_all').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked', false);
                }
            });

            $('.checkbox').on('click', function () {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#check_all').prop('checked', true);
                } else {
                    $('#check_all').prop('checked', false);
                }
            });

            $('.restore-all').on('click', function (e) {


                var idsArr = [];
                $(".checkbox:checked").each(function () {
                    idsArr.push($(this).attr('data-id'));
                });


                if (idsArr.length <= 0) {
                    alert("قم باختيار عنصر او اكثر للموافقة ^_^");
                } else {

                    if (confirm("هل انت متاكد من موافقة نشر العناصر المحددة؟")) {

                        var strIds = idsArr.join(",");

                        $.ajax({
                            url: "{{ route('post.multiple-restore') }}",
                            type: 'post',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids=' + strIds,
                            success: function (data) {
                                if (data['status'] == true) {
                                    $(".checkbox:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['message']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                    }
                }
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.closest('form').submit();
                }
            });

        });
    </script>
@endsection
