<div class="form-group" id="imageselected">
    <label for="name"
           class="col-sm-2 col-md-3 control-label">الصورة
        <span style="color:red;">*</span></label>
    <div class="col-sm-10 col-md-4">
        <div id="imageselected">
            {!! Form::button('اضافة صورة', array('id'=>'newImage','class'=>"btn btn-primary", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
            <br>
            <div id="selectedthumbnail" class="selectedthumbnail col-md-5"></div>
            <div class="closimage">
                <button type="button" class="close pull-left image-close "
                        id="image-close"
                        style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; "
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>

    </div>
</div>
    <div class="form-group" id="old_image_preview_box" style="display: none">
        <label for="name" class="col-sm-2 col-md-3 control-label"></label>
        <div class="col-sm-10 col-md-4">
            <span class="help-block"
                  style="font-weight: normal;font-size: 11px;margin-bottom: 0;">الصورة السابقة </span>
            <br>
            <img src="" alt="" width=" 100px">
            <div id="old_image_preview">

            </div>
        </div>
    </div>
