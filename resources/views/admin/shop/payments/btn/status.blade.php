@if (isset($status)and $status==0)
    <button type="button" name="delete" id="{{$id}}" actionType="change_payment" class="change_status btn btn-info btn-sm"
            style="float: right"> تاكيد مراجعة الدفع
    </button>
@else
    {{$status_name}}
@endif


