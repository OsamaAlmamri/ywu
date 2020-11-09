<a data-id="{{$id}}"
   data-status="{{$status}}" data-active_type="account" style=" margin-left: 10px;"
   class="active_disable_btn" >
    @if($status==1)
        <i class="fa fa-eye"> </i>
    @else
        <i class="fa fa-eye-slash"> </i>

    @endif
</a>
