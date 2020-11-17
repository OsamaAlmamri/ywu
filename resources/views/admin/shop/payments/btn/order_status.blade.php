@if (isset($order['payment_status']) and $order['payment_status']==0)
    <button type="button" name="delete" id="{{$order_id}}" actionType="change_order_payment"
            class="change_status btn btn-info btn-sm"
            style="float: right"> تاكيد عملية الدفع
    </button>
@else
    {{trans('status.payment_1')}}
@endif


