@extends('site.layout')
@section('content')


    <!-- Register Section -->

    <section class="register-section">
        <div class="auto-container">
            <div class="register-box">
                <!-- Title Box -->

                <div class="title-box">
                    <h2>انشاء حساب جديد</h2>
                    <div class="text"><span class="theme_color">مرحبــا!</span> قم بنشاء حساب للاستفاد بشكل اكبر من
                        الخدمات الذي يقدمها الموقع
                    </div>
                </div>
                <style>
                    .student-profile-section {
                        background-color: white;
                        padding: 21px 0px 67px;

                    }

                    .student-profile-section .profile-tabs .tab-btns {
                        border-bottom: 3px solid #00ab15;
                    }
                </style>
                <section class="student-profile-section">
                    <div class="inner-column">
                        <!-- Profile Info Tabs-->
                        <div class="profile-info-tabs">
                            <!-- Profile Tabs-->
                            <div class="profile-tabs tabs-box">
                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    <li data-tab="#prod-overview" data-type="user"
                                        class="user_type_tap tab-btn active-btn">مستخدم
                                    </li>
                                    <li data-tab="#prod-bookmark" data-type="sub_cluster"
                                        class="user_type_tap tab-btn ">شريك
                                    </li>
                                    <li data-tab="#prod-setting" data-type="copartner" class="user_type_tap tab-btn">عضو
                                        كتلة
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Login Form -->
                <div class="styled-form">
                    <form method="post" action="index.html">
                        @csrf
                        <input type="hidden" name="type" id="user_type_input" value="user">
                        <div class="row clearfix">

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>الاسم </label>
                                <input type="text" name="username" value="" placeholder=" الاسم" required="">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> رقم الهاتف</label>
                                <input type="text" name="phone" value="" placeholder="777777777" required="">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12" style="display: none" id="dev_email">
                                <label>الايميل </label>
                                <input type="email" name="email" id="form_email" value="" placeholder="abcd@gmail.com">
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12" style="display: none"
                                 id="dev_destination">
                                <label> الجهة</label>
                                <input type="text" name="destination" id="form_destination" value=""
                                       placeholder="الجهة">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>كلمة السر</label>
                                <span class="eye-icon flaticon-eye"></span>
                                <input type="password" name="password" value="" placeholder="كلمة السر" required="">
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> تاكيد كلمة السر</label>
                                <span class="eye-icon flaticon-eye"></span>
                                <input type="password" name="password" value="" placeholder="تاكيد كلمة السر"
                                       required="">
                            </div>


                            <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                                <button type="button" class="theme-btn btn-style-three"><span
                                        class="txt">التسجيل الان <i class="fa fa-angle-left"></i></span></button>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="users">هل لديك حساب من قبل ؟ <a href="{{route('site.login')}}"> تسجيل
                                        الدخول</a></div>
                            </div>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- End Login Section -->



@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $('.user_type_tap').on('click', function (e) {
                $('.user_type_tap').removeClass('active-btn');
                var type = $(this).data('type');
                $("#user_type_input").val(type);
                $(this).addClass('active-btn');
                if (type == 'user') {
                    $("#dev_destination").hide();
                    $("#dev_email").hide();
                } else {
                    $("#dev_destination").show();
                    $("#dev_email").show();
                }
            });
        });
    </script>
@endsection
