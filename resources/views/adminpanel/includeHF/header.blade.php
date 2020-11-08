<div class="col-md-3 left_col hidden-print">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('home')}}" class="site_title"><i class="fa fa-paw"></i> <span>لوحة التحكم</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{asset('assets/images/'.auth()->user()->image)}}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>الادمن</span>
                <h2>{{auth()->user()->name}}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>قوائم العرض</h3>
                <ul class="nav side-menu">
                    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> الرئيسية</a>
                    </li>
                    <li><a><i class="fa fa-female"></i> شؤون المرأة<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('women')}}">عرض محتويات شؤون المرأة</a></li>
                            <li><a href="{{route('women-trashed')}}">سلة المحذوفات</a></li>
                        </ul>
                    </li>
                    {{--                    <li><a><i class="fa fa-book"></i> المواد التدريبية <span--}}
                    {{--                                class="fa fa-chevron-down"></span></a>--}}
                    {{--                        <ul class="nav child_menu">--}}
                    {{--                            <li><a href="{{route('subject')}}">عرض وادارة المواد التدريبية</a></li>--}}
                    {{--                            <li><a href="{{route('subject-trashed')}}">سلة المحذوفات</a></li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                    <li><a><i class="fa fa-picture-o"></i> الصور <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{url('admin/media/add')}}"> اضافة صور جديدة </a></li>
                            <li><a href="{{url('admin/media/display')}}"> اعدادات الصور </a></li>
                        </ul>
                    </li>


                    <li><a><i class="fa fa-edit"></i>
                            الإستشارات <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('showPosts')}}">عرض محتوى الاستشارات</a></li>
                            <li><a href="{{route('deleted_Post')}}">الاستشارات المرفوضة</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('slides.index')}}"><i class="fa fa-image"></i> السلايدات المتحركة </a></li>
                    <li><a href="{{route('activates.index')}}"><i class="fa fa-calendar-times-o"></i> الانشطة </a></li>

                    <li><a><i class="fa fa-male"></i> حسابات الموظفين <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('Emp_Category')}}"> الاقسام </a></li>
                            <li><a href="{{route('jobs')}}"> الوظائف</a></li>
                            <li><a href="{{route('employee')}}">إدارة حسابات الموظفين</a></li>
                            <li><a href="{{route('employee-trashed')}}">حسابات موقفة</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-user-plus"></i> حسابات الشركاء<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('SharedUser')}}">طلبات العضوية</a></li>
                            <li><a href="{{route('SharedUserAgree')}}">حسابات تم الموافقة عليها</a></li>
                            <li><a href="{{route('SharedUserTrashed')}}">حسابات تم رفضها</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-user-circle"></i> حسابات المستخدمين <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('user')}}">إدارة حسابات المستخدمين</a></li>
                            <li><a href="{{route('user-trashed')}}">حسابات موقفة</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="تنظیمات">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="تمام صفحه" onclick="toggleFullScreen();">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="قفل" class="lock_btn">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="خروج" href="{{route('Admin_logout')}}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
<!-- top navigation -->
<div class="top_nav hidden-print">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{asset('assets/images/'.auth()->user()->image)}}" alt="">{{auth()->user()->name}}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{route('Admin_Edit')}}"><i class="fa fa-user-circle-o pull-right"></i> تعديل
                                البيانات الشخصية</a></li>
                        <li><a href="{{route('Admin_logout')}}"><i class="fa fa-sign-out pull-right"></i> خروج</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
