@extends('adminpanel.master')

@section('content')
    <div class="right_col" role="main">
        <div class="title_right">
            <form action="{{route('showPosts')}}" method="GET">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <br>
                    <div class="job-field" style="padding-right: 50%">
                        <select name="category"
                                style="border-radius: 10px;padding: 5px;color:  #172d44;background-color: white;font-weight: bold">
                            <option value="" style="font-weight: bold">اختر احد الاقسام</option>

                            @foreach ($categories as $cat)

                                <option value="{{ $cat->id }}" style="font-weight: bold">{{ $cat->name }}</option>

                            @endforeach
                        </select>
                        <select name="user"
                                style="border-radius: 10px;padding: 5px;color:  #172d44;background-color: white;font-weight: bold">
                            <option value="" style="font-weight: bold">اختر احد المستخدمين</option>

                            @foreach ($users as $user)

                                <option value="{{ $user->id }}" style="font-weight: bold">{{ $user->name }}</option>

                            @endforeach
                        </select>
                        <button class="btn btn-default" type="submit" style="color: white;background-color: #172d44">
                            عرض
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @if($posts->count())
            @foreach($posts as $post)
                <div class="container bootstrap snippet" style="direction: ltr">
                    <div class="col-sm-8">
                        <div class="panel panel-white post panel-shadow PostCard{{$post->id}}">
                            <a href="" post_delete="{{$post->id}}" class="post_delete btn btn-danger pull-left"
                               style=" font-weight: bold;border-radius: 3px 3px 25px 3px">X</a>
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
                                            <a href="trashedShow/{{$post->user()->withTrashed()->first()->id}}"><b>{{$post->user()->withTrashed()->first()->name}}</b></a>
                                        @else
                                            <a href="userShowId/{{ $post->user->id }}"><b>{{ $post->user->name }}</b></a>
                                        @endif
                                    </div>
                                    <h6 class="pull-right time">{{ $post->published }}</h6>
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
                                                                        <a href="" comment_delete="{{$comment->id}}"
                                                                           class="comment_delete btn btn-danger btn-round pull-left"
                                                                           style="font-weight: bold">X</a>
                                                                        @if(empty($comment->user->name))
                                                                            <span class='fa fa-close'
                                                                                  style="color: red;margin-right: 5px">
                                                                              <b>تم إيقاف الحساب</b>
                                                                                     </span>
                                                                            <h5 class="time">{{ $comment->published}}</h5>
                                                                            <a href="trashedShow/{{$comment->user()->withTrashed()->first()->id}}"><b>{{$comment->user()->withTrashed()->first()->name}}</b></a>
                                                                        @else
                                                                            <h5 class="time">{{ $comment->published}}</h5>
                                                                            <a href="userShowId/{{ $comment->user->id }}">
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
@endsection
@section('scripts')
    <script type="text/javascript">

        $(document).on('click', '.post_delete', function (e) {
            e.preventDefault();
            var offer_id = $(this).attr('post_delete');
            $.ajax({
                type: 'post',
                url: '{{ route('delete') }}',
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': offer_id,
                },
                success: function (data) {
                    if (data.status == true) {
                        //$('#success').show();
                    }
                    $('.PostCard' + data.id).remove();
                }, erorr: function (reject) {
                },
            });
        });

        {{--هذا الجزء خاص الحذف--}}

        $(document).on('click', '.comment_delete', function (e) {
            e.preventDefault();
            var offer_id = $(this).attr('comment_delete');
            $.ajax({
                type: 'post',
                url: '{{ route('delete_comment') }}',
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
    </script>
@endsection
