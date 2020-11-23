@if($images!=null)
    <button type="button" id="{{$id}}" class="show_images btn btn-info btn-sm"
            style="float: right"><span class='fa fa-image'></span></button>
@endif
{{--<button type="button" name="edit_training" id="{{$id}}" class="edit btn btn-warning btn-sm" style="float: right"><span--}}
{{--        class='fa fa-edit'></span></button>--}}
@if(!($id==1 or auth()->id()==$id))
    <button type="button" name="delete_training" id="{{$id}}" class="delete btn btn-danger btn-sm" style="float: right">
        <span class='fa fa-trash'></span>
    </button>

@endif
