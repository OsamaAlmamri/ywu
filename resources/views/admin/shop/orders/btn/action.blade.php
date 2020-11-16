@if (auth()->user()->type=='admin')
    <button type="button" name="delete" id="{{$id}}" class="delete btn btn-danger btn-sm" style="float: right"><span
            class='glyphicon glyphicon-trash'> </span></button>
    <a class="btn btn-info btn-sm" href="{{route('admin.shop.orders.show_seller_order',$id)}}"
       style=" margin-left: 10px;">
        عرض التفاصيل
    </a>
@else
    <a class="btn btn-info btn-sm" href="{{route('admin.shop.orders.show_main_order',$id)}}"
       style=" margin-left: 10px;">
        عرض التفاصيل
    </a>
@endif
