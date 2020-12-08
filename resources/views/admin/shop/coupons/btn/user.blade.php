@if ($user_id>0)

    {{--    @if(empty($post->user->name))--}}
    {{--        <td class=" "><a href="trashedShow/{{$user_id}}"><b--}}
    {{--                    style="color: red">{{$user_name}}</b></a></td>--}}
    {{--    @else--}}
    <td class=" ">
        <a href="/userShowId/{{$user_id}}"><b>{{$user_name}}</b></a>
    </td>
    {{--    @endif--}}
@endif
