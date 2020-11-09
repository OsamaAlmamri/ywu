<a data-id="{{$id}}"
   data-status="{{$available}}" data-active_type="available" style=" margin-left: 10px;"
   class="active_disable_btn">
    @if($available==1)
        <i class="fa fa-eye"> </i>
    @else
        <i class="fa fa-eye-slash"> </i>

    @endif
</a>
