@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <h3 align="right">اعدادات الصور </h3>
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
                        <div class="col-12">
                            @if (session('update'))
                                <div
                                    class="alert alert-success alert-dismissable custom-success-box"
                                    style="margin: 15px;">
                                    <a href="#" class="close" data-dismiss="alert"
                                       aria-label="close">&times;</a>
                                    <strong> {{ session('update') }} </strong>
                                </div>
                            @endif

                            @if( count($errors) > 0)
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-success" role="alert">
                                        <span class="icon fa fa-check" aria-hidden="true"></span>
                                        <span
                                            class="sr-only">حجم الصور:</span>
                                        {{ $error }}</div>
                                @endforeach
                            @endif

                            {!! Form::open(array('url' =>'admin/media/updatemediasetting', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                            <h4>اعدادات الصورة المصغرة</h4>
                            <hr>
                            <div class="form-group">
                                <label for="name"
                                       class="col-sm-2 col-md-3 control-label">طول الصورة المصغرة</label>
                                <div class="col-sm-10 col-md-4">
                                    {!! Form::text( setting('Thumbnail_height'),  setting('Thumbnail_height'), array('class'=>'form-control number-validate', 'id'=>setting('Thumbnail_height'), 'name'=>'ThumbnailHeight')) !!}
                                    <span class="help-block"
                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">طول الصورة المصغرة</span>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="name"
                                       class="col-sm-2 col-md-3 control-label">عرض الصورة المصغرة</label>
                                <div class="col-sm-10 col-md-4">
                                    {!! Form::text(setting('Thumbnail_width'),  setting('Thumbnail_width'), array('class'=>'form-control number-validate', 'id'=>setting('Thumbnail_width'), 'name'=>'ThumbnailWidth')) !!}
                                    <span class="help-block"
                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">عرض الصورة المصغرة</span>
                                </div>

                            </div>

                            <h4>اعدادات الصورة المتوسطة</h4>
                            <hr>
                            <div class="form-group">
                                <label for="name"
                                       class="col-sm-2 col-md-3 control-label">طول الصورة المتوسطة</label>
                                <div class="col-sm-10 col-md-4">
                                    {!! Form::text(setting('Medium_height'),  setting('Medium_height'), array('class'=>'form-control number-validate', 'id'=>setting('Medium_height'), 'name'=>'MediumHeight')) !!}
                                    <span class="help-block"
                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">طول  الصورة المتوسطة</span>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="name"
                                       class="col-sm-2 col-md-3 control-label">عرض الصورة المتوسطة</label>
                                <div class="col-sm-10 col-md-4">
                                    {!! Form::text(setting('Medium_width'),  setting('Medium_width'), array('class'=>'form-control number-validate', 'id'=>setting('Medium_width'), 'name'=>'MediumWidth')) !!}
                                    <span class="help-block"
                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">عرض  الصورة المتوسطة</span>
                                </div>

                            </div>
                            <h4>اعدادات الصورة الكبيرة</h4>
                            <hr>
                            <div class="form-group">
                                <label for="name"
                                       class="col-sm-2 col-md-3 control-label">طول الصورة الكبيرة</label>
                                <div class="col-sm-10 col-md-4">
                                    {!! Form::text(setting('Large_height'),  setting('Large_height'), array('class'=>'form-control number-validate', 'id'=>setting('Large_height'), 'name'=>'LargeHeight')) !!}
                                    <span class="help-block"
                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">طول  الصورة الكبيرة</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name"
                                       class="col-sm-2 col-md-3 control-label">عرض الصورة الكبيرة</label>
                                <div class="col-sm-10 col-md-4">
                                    {!! Form::text(setting('Large_width'),  setting('Large_width'), array('class'=>'form-control number-validate', 'id'=>setting('Large_width'), 'name'=>'LargeWidth')) !!}
                                    <span class="help-block"
                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">عرض  الصورة الكبيرة</span>
                                </div>

                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <button type="submit"
                                        class="btn btn-primary">حفظ
                                </button>
                                <button type="submit" class="btn btn-success" id="regenrate"
                                        name="regenrate"
                                        value="yes"> حفظ وضبط الصور القديمة بهذا الاعدادات
                                </button>
                                <a href="{{ URL::to('admin/home')}}" type="button"
                                   class="btn btn-default">رجوع</a>
                            </div>

                            <!-- /.box-footer -->
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('custom_js')

@endsection






