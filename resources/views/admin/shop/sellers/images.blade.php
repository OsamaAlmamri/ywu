@foreach($images as $image)
    <div class="col-6">
        <div class="thumbnail">
            <div class="thumb">
                <a href="{{url($image)}}" data-lightbox="1" data-title="My caption 1">
                    <img src="{{url($image)}}" width="100" alt="" class="img-fluid img-thumbnail">
                </a>
            </div>
        </div>
    </div>
@endforeach
