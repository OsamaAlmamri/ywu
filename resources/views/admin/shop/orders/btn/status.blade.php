@if (auth()->user()->type=='admin')

    @if (isset($payment_status)and $payment_status==0)
        <button type="button" name="delete" id="{{$id}}" actionType="change_order_payment"
                class="change_status btn btn-info btn-sm"
                style="float: right"> تاكيد الدفع
        </button>
    @else
        تم الدفع
    @endif

@else
    <a class="btn btn-info btn-sm" href="{{route('admin.shop.orders.show_main_order',$id)}}"
       style=" margin-left: 10px;">
        عرض التفاصيل
    </a>
@endif
