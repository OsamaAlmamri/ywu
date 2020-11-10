@if($thumbnail!=null)
    <div class="thumbnail">
        <div class="thumb">
            <a href="{{url('assets/images/'.$thumbnail)}}" data-lightbox="1" data-title="My caption 1">
                <img src="{{url('assets/images/'.$thumbnail)}}" width="100" alt="" class="img-fluid img-thumbnail">
            </a>
        </div>
    </div>
@endif
