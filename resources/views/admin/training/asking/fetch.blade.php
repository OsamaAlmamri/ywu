<div class="table-responsive" id="table_data">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
        <tr class="headings">
            <th><input type="checkbox" id="check_all"></th>
            <th class="column-title">اسم المستخدم</th>
            <th class="column-title">القسم</th>
            <th class="column-title">العنوان</th>
            <th class="column-title">المحتوى</th>
            <th class="column-title">تاريخ الطلب</th>
            <th class="column-title">الإجراءات</th>
        </tr>
        </thead>
        @if($posts->count())
            @foreach($posts as $key => $post)
                <tbody>
                <tr id="tr_{{$post->id}}" class="even pointer OfferRow{{$post->id}}">
                    <td><input type="checkbox" class="checkbox" data-id="{{$post->id}}"></td>
                    @if(empty($post->user->name))
                        <td class=" "><a href="trashedShow/{{$post->user()->withTrashed()->first()->id}}"><b
                                    style="color: red">{{$post->user()->withTrashed()->first()->name}}</b></a></td>
                    @else
                        <td class=" ">
                            <a href="userShowId/{{$post->user->id}}"><b>{{$post->user->name}}</b></a>
                        </td>
                    @endif
                    <td class=" ">{{ $post->category->name }}</td>
                    <td class=" ">{{ $post->title }}</td>
                    <td class=" ">{{ $post->body }}</td>
                    <td class=" ">{{ $post->published }}</td>
                    <td class=" ">
                        <a href="" post_id="{{$post->id}}" class="post_update btn btn-primary btn-sm">موافقة</a>
                        <a href="" offer_id="{{$post->id}}" class="offer_btn_id btn btn-danger btn-sm">رفض</a>
                    </td>
                </tr>
                </tbody>
            @endforeach
        @endif
    </table>
    <div class="float-right">
        {!! $posts->links() !!}
    </div>
</div>
