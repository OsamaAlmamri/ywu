@if($image!=null)
    <div class="thumbnail">
        <div class="thumb">
            <a href="{{url('assets/images/'.$image)}}" data-lightbox="1" data-title="My caption 1">
                <img src="{{url('assets/images/'.$image)}}" width="100" alt="" class="img-fluid img-thumbnail">
            </a>
        </div>
    </div>
@endif
