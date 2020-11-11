@if($has_attribute)
    <a href="{{route('admin.shop.products.attributes',$id)}}" class=" btn btn-primary btn-sm" style="float: right"><i
            class='fa fa-bars'></i></a>
@endif
<a href="{{route('admin.shop.products.images.index',$id)}}" class=" btn btn-primary btn-sm" style="float: right"><i
        class='fa fa-image'></i></a>
<button type="button" name="show" id="{{$id}}" class="show btn btn-primary btn-sm" style="float: right"><span
        class='glyphicon glyphicon-eye-open'></span></button>
<button type="button" name="edit" id="{{$id}}" class="edit btn btn-warning btn-sm" style="float: right"><span
        class='glyphicon glyphicon-pencil'></span></button>
<button type="button" name="delete" id="{{$id}}" class="delete btn btn-danger btn-sm" style="float: right"><span
        class='glyphicon glyphicon-trash'> </span></button>
