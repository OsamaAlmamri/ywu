<a data-id="{{$id}}"
   data-status="{{$status}}" data-active_type="account" style=" margin-left: 10px;"
   class="active_disable_btn" >
    @if($status==1)
        <i class="fa fa-toggle-on"> </i>
    @else
        <i class="fa fa-toggle-off"> </i>

    @endif
</a>
