@extends('adminpanel.master')

@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>إضافة مستخدم جديد</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="اسم الموظف">
                        <span class="input-group-btn">
                              <button class="btn btn-default" type="button">بحث</button>
                          </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <small>ملاحظة !!</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <form class="form-horizontal form-label-left" novalidate>

                            <p>يرجى كتابة جميع البيانات المطلوبة بدقة
                            </p>
                            <span class="section">بيانات الموظف</span>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">الاسم <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" class="form-control col-md-7 col-xs-12"
                                           data-validate-length-range="6" data-validate-words="2" name="name"
                                           placeholder="اسم الموظف" required="required" type="text">
                                </div>

                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">الإيميل <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" id="email" name="email" required="required"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">رقم الهاتف <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="tel" id="telephone" name="phone" required="required"
                                           data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="password" class="control-label col-md-3">التخصص <span
                                    class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="heard"  class="form-control col-md-7 col-xs-12" required="required">
                                    <option value="">استشاري</option>
                                    <option value="press">اخبار</option>
                                    <option value="net">اینترنت</option>
                                    <option value="mouth">دهان به دهان</option>
                                </select>
                            </div>
                            </div>

                            <div class="item form-group">
                                <label for="password" class="control-label col-md-3">كلمة المرور <span
                                    class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password" type="password" name="password" data-validate-length="6,8"
                                           class="form-control col-md-7 col-xs-12" required="required">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label for="photo" class="control-label col-md-3">إضافة صورة <span
                                    class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="photo" type="file" name="photo" data-validate-length="6,8"
                                           class="form-control col-md-7 col-xs-12" required="required">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">ملاحضة
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="textarea" required="required" name="textarea"
                                              class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="send" type="submit" class="btn btn-success">حفظ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
