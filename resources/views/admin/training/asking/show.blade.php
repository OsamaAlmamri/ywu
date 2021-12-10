@extends('adminpanel.master')

@section('content')
    <div class="right_col" role="main">
        <div class="title_right">
            <form action="{{route('showPosts')}}" method="GET">
                <div class="row  top_search">
                    <div class="col-xs-3">
                        <div class="job-field">
                            <select name="category"
                                    style="border-radius: 10px;padding: 5px;color:  #172d44;background-color: white;font-weight: bold">
                                <option value="" style="font-weight: bold">اختر احد الاقسام</option>

                                @foreach ($categories as $cat)

                                    <option value="{{ $cat->id }}" style="font-weight: bold">{{ $cat->name }}</option>

                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="job-field">
                            <select name="type"
                                    style="border-radius: 10px;padding: 5px;color:  #172d44;background-color: white;font-weight: bold">
                                <option value="" style="font-weight: bold"> النوع</option>
                                <option value="all" style="font-weight: bold"> جميع الاستشارات</option>
                                <option value="re_publish" style="font-weight: bold">الاستشارات الذي تمت اعادة صياعتها
                                </option>
                                <option value="not_re_publish" style="font-weight: bold">الاستشارات العامة لم تتم اعادة
                                    صياعتها
                                </option>
                                <option value="public" style="font-weight: bold">الاستشارات العامة</option>
                                <option value="private" style="font-weight: bold">الاستشارات الخاصة</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="job-field">
                            <select name="user"
                                    style="border-radius: 10px;padding: 5px;color:  #172d44;background-color: white;font-weight: bold">
                                <option value="" style="font-weight: bold">اختر احد المستخدمين</option>

                                @foreach ($users as $user)

                                    <option value="{{ $user->id }}" style="font-weight: bold">{{ $user->name }}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="job-field">

                            <button class="btn btn-default" type="submit"
                                    style="color: white;background-color: #172d44">
                                عرض
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @if($posts->count())
            @foreach($posts as $post)
                <div class="container bootstrap snippet" style="direction: ltr">
                    <div class="col-sm-12">
                        <div class="panel panel-white post panel-shadow PostCard{{$post->id}}">
                            <a href="javascript:void(0)" id="{{$post->id}}"
                               class="delete_post btn btn-danger pull-left"
                               delete_type="post"
                               style=" font-weight: bold;border-radius: 3px 3px 25px 3px">X</a>

                            <a href="javascript:void(0)" id="{{$post->id}}"
                               class="edit_post btn btn-info pull-left"
                               id="{{$post->id}}"
                               style=" font-weight: bold;border-radius: 3px 3px 25px 3px">
                                <i class="fa fa-share-alt" title="اعادة صياغة "></i>
                            </a>
                            <div class="post-heading">
                                <div class="pull-right image">
                                    <img src="https://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar"
                                         alt="user profile image">
                                </div>
                                <div class="pull-right meta">
                                    <div class="title h5">
                                        @if(empty($post->user->name))
                                            <span class='fa fa-close' style="color: red;margin-right: 5px">
                                                    <b>تم إيقاف الحساب</b>
                                                    </span>
                                            <a class="post_user_name"
                                               href="trashedShow/{{$post->user()->withTrashed()->first()->id}}"><b>{{$post->user()->withTrashed()->first()->name}}</b></a>
                                        @else
                                            <a class="post_user_name"
                                               href="userShowId/{{ $post->user->id }}"><b>{{ $post->user->name }}</b></a>
                                        @endif
                                    </div>
                                    <h6 class="pull-right time">
                                        {{ $post->published }}

                                        @if($post->original_post_id!=null)
                                            <i class="fa fa-share-alt" title="استشارة تمت اعادة نشرها"></i>
                                        @endif
                                        @if($post->is_public==1)
                                            <i class="fa fa-globe" title="استشارة عامة"></i>
                                        @else
                                            <i class="fa fa-user" title="استشارة خاصة"></i>
                                        @endif
                                    </h6>
                                </div>
                                <div class="pull-left meta">
                                    <div class="title h5"
                                         style="background-color: #172d44; color: white;border-radius: 8px;padding: 8px">
                                        {{ $post->category->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="title h4 pull-right meta" style="color: orangered;padding-right: 35px">
                                <p>{{ $post->title }}</p>
                            </div>
                            <br>
                            <br>
                            <div class="post-description">
                                <p>{{ $post->body }}</p>
                            </div>
                            <div class="x_panel">
                                <div class="pull-right meta">
                                    <div class="title h5" style="margin-right: 15px"> التعليقات</div>
                                </div>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="x_content">
                                    <div class="post-footer">
                                        @if($comments->count())
                                            @foreach($comments as $comment)
                                                <ul class="comments-list">
                                                    <li class="comment">
                                                        @if($comment->id!=null and $comment->post_id==$post->id and $comment->user_id!=null)
                                                            <div class="even pointer OfferRow{{$comment->id}}">
                                                                <a class="pull-right" href="#">
                                                                    <img class="avatar"
                                                                         src="https://bootdey.com/img/Content/user_1.jpg"
                                                                         alt="avatar">
                                                                </a>
                                                                <div class="comment-body">
                                                                    <div class="comment-heading">
                                                                        <a href="javascript:void(0)"
                                                                           id="{{$comment->id}}"
                                                                           delete_type="comment"
                                                                           class="delete_post btn btn-danger btn-round pull-left"
                                                                           style="font-weight: bold">X</a>
                                                                        @if(empty($comment->user->name))
                                                                            <span class='fa fa-close'
                                                                                  style="color: red;margin-right: 5px">
                                                                              <b>تم إيقاف الحساب</b>
                                                                                     </span>
                                                                            <h5 class="time">{{ $comment->published}}</h5>
                                                                            <a class="post_user_name"
                                                                               href="trashedShow/{{$comment->user()->withTrashed()->first()->id}}"><b>{{$comment->user()->withTrashed()->first()->name}}</b></a>
                                                                        @else
                                                                            <h5 class="time">{{ $comment->published}}</h5>
                                                                            <a class="post_user_name"
                                                                               href="userShowId/{{ $comment->user->id }}">
                                                                                <h4 class="user">{{$comment->user->name}}</h4>
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                    <p> {{ $comment->body }}</p>
                                                                </div>
                                                            </div>
                                                        @elseif( $comment->post_id==$post->id and $comment->emp_id!=null)
                                                            <a class="pull-right" href="#">
                                                                <img class="avatar"
                                                                     src="https://bootdey.com/img/Content/user_3.jpg"
                                                                     alt="avatar">
                                                            </a>
                                                            <div class="comment-body">
                                                                <div class="comment-heading">
                                                                    @if(empty($comment->employee->name))
                                                                        <h6 class="pull-left">
                                                                            {{$comment->employee()->withTrashed()->first()->type}}
                                                                        </h6>
                                                                    @else
                                                                        <h6 class="pull-left">{{$comment->employee->type}}</h6>
                                                                    @endif
                                                                    @if(empty($comment->employee->name))
                                                                        <span class='fa fa-close'
                                                                              style="color: red ;margin-right: 5px">
                                                                            <b>تم إيقاف الحساب</b>
                                                                        </span>
                                                                        <h5 class="time">{{ $comment->published}}</h5>
                                                                        <a href="E_trashedShow/{{$comment->employee()->withTrashed()->first()->id}}"><b>{{$comment->employee()->withTrashed()->first()->name}}</b></a>
                                                                    @else
                                                                        <h5 class="time">{{ $comment->published}}</h5>
                                                                        <a href="EmployeeShowId/{{ $comment->employee->id }}">
                                                                            <h4 class="user">{{$comment->employee->name}}</h4>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                                <p> {{ $comment->body }}</p>
                                                            </div>
                                                        @endif
                                                    </li>
                                                </ul>
                                            @endforeach
                                    </div>
                                    @elseif($comments->count()==null)
                                        <h5 style="text-align: center">لايوجد تعليقات</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif($posts->count()==null)
            <h2><b>لايوجد منشورات</b></h2>
        @endif
        <div class="float-right">
            {!! $posts->links() !!}
        </div>
    </div>
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> اعادة صياغة الاستشارة</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" id="title_dev">
                            <label class="control-label col-md-4">العنوان : </label>
                            <div class="col-md-8">
                                <input type="text" name="title" id="title" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group" id="body_dev">
                            <label class="control-label col-md-4">المحتوى : </label>
                            <div class="col-md-12">
                                <textarea type="text" name="body" id="body" class="form-control description"></textarea>
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
                    <h2 class="modal-title">حذف </h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">هل انت متاكد من الحذف ؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">نعم</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script type="text/javascript">


        {{--هذا الجزء خاص الحذف--}}
        var type = 0;
        var post_id = 0;
        $(document).on('click', '.delete_post', function () {
            post_id = $(this).attr('id');
            type = $(this).attr('delete_type');
            $('#confirmModal').modal('show');
        });


        $(document).on('click', '#ok_button', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: (type == "post") ? '{{ route('delete') }}' : '{{ route('delete_comment') }}',
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': post_id,
                },
                success: function (data) {
                    if (data.status == true) {
                        //$('#success').show();
                        $('#confirmModal').modal('hide');
                        if (type == 'post')
                            $('.PostCard' + data.id).remove();
                        else
                            $('.OfferRow' + data.id).remove();
                    }

                }, erorr: function (reject) {
                },
            });

        });


        $(document).on('click', '.edit_post', function () {
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url: "{{URL::to('')}}/editConsultant/" + id + "",
                type: "GET",
                dataType: "json",
                success: function (html) {
                    $('#title').val(html.data.title);
                    $('#body').val(html.data.body);
                    $('#hidden_id').val(html.data.id);
                    $('#action').val(html.type);
                    $('#formModal').modal('show');
                }
            })
        });

        $(document).on('submit', '#sample_form', function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('rePublish') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        $('#formModal').modal('hide');
                       toastr.info("تم اعادة النشر بنجاح");
                        $('#sample_form')[0].reset();

                    }
                }
            })
        });

    </script>
@endsection
