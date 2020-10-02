@extends('site.layout')
@section('content')


    <!-- Login Section -->
    <section class="login-section">
        <div class="auto-container">
            <div class="login-box">

                <!-- Title Box -->
                <div class="title-box">
                    <h2>تسجيل الدخول </h2>
                    <div class="text"><span class="theme_color">مرحبــا!</span> قم بتسجيل الدخول للاستفادة  بشكل اكبر من الخدمات الذي يقدمها الموقع</div>
                </div>

                <!-- Login Form -->
                <div class="styled-form">
                    <form method="post" action="index.html">
                        <div class="form-group">
                            <label>الايميل او رقم الهاتف </label>
                            <input type="text" name="username" value="" placeholder="الايميل او رقم الهاتف  " required="">
                        </div>
                        <div class="form-group">
                            <label>كلمة السر</label>
                            <span class="eye-icon flaticon-eye"></span>
                            <input type="password" name="password" value="" placeholder="كلمة السر" required="">
                        </div>
                        <div class="form-group">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="check-box">
                                        <input type="checkbox" name="remember-password" id="type-1">
                                        <label for="type-1">تذكر كلمة السر</label>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="forgot">نسيت كلمة السر ؟</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="button" class="theme-btn btn-style-three"><span class="txt">تسجيل الدخول <i class="fa fa-angle-left"></i></span></button>
                        </div>
                        <div class="form-group">
                            <div class="users">ليس لديك حساب من قبل ؟ <a href="{{route('site.register')}}">انشاء حساب جديد</a></div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- End Login Section -->



@endsection
