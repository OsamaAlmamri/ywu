<div class="modal fade" id="Modalmanufactured" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" id="closemodal"
                        aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h3 class="modal-title text-primary"
                    id="myModalLabel">اختر صورة  </h3>
            </div>
            <div class="modal-body manufacturer-image-embed">
                <select class="image-picker show-html" name="image_id" id="select_img">
                    <option value=""></option>
                    @foreach(getAllImages() as $key=>$image)
                        <option data-img-src="{{asset($image->path)}}"
                                class="imagedetail" data-img-alt="{{$key}}"
                                value="{{$image->id}}"> {{$image->id}} </option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <a href="{{url('admin/shop/media/add')}}" target="_blank"
                   class="btn btn-primary pull-left">اضافة صور جديدة</a>
                <button type="button"
                        class="btn btn-default refresh-image">
                    <i class="fa fa-refresh"></i></button>
                <button type="button" class="btn btn-primary" id="selected"
                        data-dismiss="modal">تم</button>
            </div>
        </div>
    </div>
</div>
