<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login To Admin Panel </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('login/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('login/vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{asset('login/css/font.css')}}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('login/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('login/css/custom.css')}} ">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('login/img/favicon.ico')}}">
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
    <![endif]-->
</head>

<body>
<div class="login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row justify-content-center">
                <div class=" col-lg-5 col-md-9 col-xs-12">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <i class="fa fa-question-circle" style="font-size: 100px"></i>
                            <br>
                            <br>
                            <form method="POST" action="{{ route('admin.forget_check') }}" class="form-validate mb-4">
                                @csrf
                                <div class="form-group row" style="margin-left: 10%">
                                    <div class="col-md-10">
                                        <input id="name" type="text" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}" placeholder="اسم المستخدم" required autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <label for="name" class="col-md-2 col-form-label text-md-left ">
                                        <i class="fa fa-user" style=" font-size: 40px"></i>
                                    </label>
                                </div>
                                <div class="form-group row" style="margin-left: 10%">
                                    <div class="col-md-10">
                                    <input id="email" type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="ايميل المستخدم" required autocomplete="email" autofocus>
{{--                                    <label for="email" class="label-material font-weight-bold" style="font-size: 17px;">إيميل المستخدم</label>--}}
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                    <label for="email" class="col-md-2 col-form-label text-md-left ">
                                        <i class="fa fa-envelope-square" style=" font-size: 40px"></i>
                                    </label>
                                </div>
                                <div class="form-group row" style="margin-left: 10%">
                                    <div class="col-md-10">
                                    <input id="password" type="password" name="password" required
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="كلمة المرور الجديدة" autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
{{--                                    <label for="login-password" class="label-material font-weight-bold" style="font-size: 17px;">كلمة المرور</label>--}}
                                </div>
                                    <label for="password" class="col-md-2 col-form-label text-md-left">
                                            <i class="fa fa-user-secret" style=" font-size: 40px"></i>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary font-weight-bold" style="font-size: 17px;">حفظ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="copyrights text-center">--}}
{{--        <p>Design by <a href="#" class="external">Adnan Almaqwali</a></p>--}}
{{--        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->--}}
{{--    </div>--}}
</div>
<!-- JavaScript files-->
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src="{{asset('login/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('login/vendor/popper.js/umd/popper.min.js')}}">
</script>
<script src="{{asset('login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('login/vendor/jquery.cookie/jquery.cookie.js')}}">
</script>
<script src="{{asset('login/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('login/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('login/js/front.js')}}"></script>
</body>
</html>
