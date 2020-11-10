@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">تفاصيل الصورة </h3>
        <br/>
    </div>
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <br/>
                    <h3 align="right"> احجام الصور </h3>
                    <br/>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-xs-12">
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if (count($errors) > 0)
                                @if($errors->any())
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    @if(isset($result['images']))
                        @foreach($result['images'] as $key=>$image)
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="caption">
                                        <h2>{{$image->image_type}} ({{$image->height}} X {{$image->width}})</h2>
                                    </div>
                                    <div class="thumbnail">
                                        <img src="{{asset($image->path)}}" alt="{{$image->height}} X {{$image->width}}">
                                        <div class="col-md-6 col-md-offset-3">
                                            <div class="caption">
                                                <div class="input-group">
                                                    <span class="input-group-addon">المسار</span>
                                                    <input type="text" class="form-control" name="path"
                                                           value="{{asset($image->path)}}">
                                                </div>
                                            </div>
                                            @if($image->image_type !='ACTUAL')
                                                {!! Form::open(array('url' =>'admin/shop/media/regenerateimage', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                                {!! Form::hidden('image_id',  $image->image_id, array('class'=>'form-control', 'id'=>'id')) !!}
                                                {!! Form::hidden('id',  $image->id, array('class'=>'form-control', 'id'=>'id')) !!}
                                                <div class="caption">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">الحجم</span>
                                                        <input required type="text" class="form-control" name="height"
                                                               value="{{$image->height}}">
                                                        <span class="input-group-addon">X</span>
                                                        <input required type="text" class="form-control" name="width"
                                                               value="{{$image->width}}">
                                                        <span class="input-group-addon" style="padding: 0">
                                                        <button type="submit"
                                                                class="btn btn-primary"> اعادة ضبط الصورة</button>
                                                    </span>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
            <p id="demo"></p>
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add File Here</h4>
                        </div>
                        <div class="modal-body">
                            <p>Click or Drop Images in the Box for Upload.</p>
                            <form action="{{ url('admin/shop/media/uploadimage') }}" enctype="multipart/form-data"
                                  class="dropzone " id="my-dropzone">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" disabled="disabled" id="compelete"
                                    data-dismiss="modal">Done
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModaldetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <h3 class="modal-title text-primary" id="myModalLabel">Image Details</h3>
                        </div>

                        {!! Form::open(array('url' =>'admin/shop/media/delete', 'method'=>'post', 'class' => 'form-horizontal',
                        'enctype'=>'multipart/form-data', 'onsubmit' => 'return ConfirmDelete()')) !!}
                        <div class="image_embed">

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" id="myDeleteImage"
                                    data-toggle="modal">Delete
                            </button>
                            {{--<a href="#myModal2" role="button" type="submit" class="btn btn-danger" data-toggle="modal">Delete</a>--}}
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>


                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div id="myModal2" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirmation!!</h4>
                        </div>
                        <div class="modal-body">
                            <p>You are sure to delete It!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" id="myDeleteImage"
                                    data-toggle="modal">Delete
                            </button>
                            <button class="btn btn-default" data-dismiss="modal" data-dismiss="modal"
                                    aria-hidden="true">Cancel
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('custom_js')

@endsection


