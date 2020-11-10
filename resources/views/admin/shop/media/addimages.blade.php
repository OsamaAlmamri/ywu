@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">اضافة صور </h3>
        <br/>
    </div>
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">عرض كافة الصور</h3>

                    <div style="margin-right:88px;" class="card-tools pull-left">
                        <button id="btn" type="button" class="btn btn-block btn-danger">حذف</button>

                    </div>
                    <div style="margin-right:162px;" class="box-tools pull-left">
                        <button id="btn11" type="button" class="btn btn-block btn-success">اختيار الكل   </button>

                    </div>
                    <div style="margin-right:253px;" class="box-tools pull-left">
                        <button id="btn12" type="button" class="btn btn-block btn-info">الغاء اختيار الكل </button>

                    </div>
                    <div class="box-tools pull-left">
                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal"
                                data-target="#myModal">اضافة صور جديدة</button>

                    </div>
                </div>
                <br>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-xs-12">
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
                    <style>
                        article, aside, figure, footer, header, hgroup,
                        menu, nav, section {
                            display: block;
                        }

                        ul {
                            list-style: none;
                        }

                        ul li {
                            display: inline;
                        }

                        img {
                            border: 2px solid white;
                            cursor: pointer;
                        }

                        img:hover {
                            border: 2px solid black;
                        }

                        img.hover {
                            border: 2px solid black;
                        }

                        .margin-bottomset .thumbnail {
                            margin-bottom: 0;
                        }
                    </style>
                    <form class="hidden" action="" method="" id="images_form">
                        @csrf
                        <input id="images" type="hidden" name="images" value=""/>
                    </form>
                    <div class="row">
                        @if(isset($images))
                            @foreach($images as $image)
                                <div class="col-xs-4 col-md-2 margin-bottomset">
                                    <div class="thumbnail thumbnail-imges">
                                        <img class="test_image" image_id="{{$image->id}}" src="{{asset($image->path)}}"
                                             alt="...">
                                    </div>
                                    <a class="btn btn-block btn-primary"
                                       href="{{url('admin/shop/media/detail')}}/{{$image->id}}">عرض التفاصيل</a>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">


                        <!-- /.box-header -->

                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <p id="demo"></p>

                <!-- /.col -->
            </div>
            <!-- /.row -->
            <script>

            </script>
            <!-- Main row -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">اضافة صور جديدة</h4>
                        </div>
                        <div class="modal-body">
                            <p>اضغط او اسحب الصور الى هنا للتحميل</p>
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


            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('custom_js')
    @include('adminpanel.includes.media')
@endsection



