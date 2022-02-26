<div class="col-md-3 left_col hidden-print">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('home')}}" class="site_title"><i class="fa fa-paw"></i> <span>لوحة التحكم</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                @if (auth()->user()->type=='admin')

                    <img src="{{asset(auth()->user()->image)}}" alt="..."
                         class="img-circle profile_img">
                @else
                    <img src="{{url(auth()->user()->seller->ssn_image)}}" alt="..."
                         class="img-circle profile_img">
                @endif
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
                    @if ((Auth::user()->type=="admin") == true))
                    <li><a href="#" id="open_noti_modal"> ارسال اشعار </a></li>
                    @endif
                    <li>
                        <a><i class="fa fa-shopping-cart"></i> السوق <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @if ((Auth::user()->can('show sellers') == true))
                                <li><a href="{{route('admin.shop.sellers.index')}}"> البائعين </a></li>
                            @endif



{{--                            @if ((Auth::user()->type=="seller") != true))--}}
                            <li><a href="#" id="open_my_store"> رابط متجري </a></li>
{{--                            @endif--}}

                            <li><a><i class="fa fa-picture-o"></i> الصور <span
                                        class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{url('admin/shop/media/add')}}"> اضافة صور جديدة </a></li>
                                    <li><a href="{{url('admin/shop/media/display')}}"> اعدادات الصور </a></li>
                                </ul>
                            </li>
                            @if ((Auth::user()->can('show products_attributes') == true))

                                <li><a href="{{route('admin.shop.products_options.index')}}"> خيارات المنتجات </a>
                                </li>
                            @endif
                            @if ((Auth::user()->can('show coupons') == true))

                                <li><a href="{{route('admin.shop.coupons.index')}}"> كوبونات التسوق </a>
                                </li>
                                <li><a href="{{route('admin.shop.coupons.statistics')}}"> احصائيات كوبونات التسوق </a>
                                </li>
                            @endif
                            {{--                            <li><a href="{{route('admin.shop.spaces.index')}}"> ادارة المساحات </a></li>--}}
                            @if ((Auth::user()->can('show categories') == true))

                                <li><a href="{{route('admin.shop.categories.index')}}"> ادارة الاصناف </a></li>
                            @endif
                            @if ((Auth::user()->can('show products') == true))
                                <li><a href="{{route('admin.shop.products.index')}}"> ادارة المنتجات </a></li>
                                <li><a href="{{route('admin.shop.product_questions.index')}}"> اسئلة المنتجات </a>
                                </li>
                            @endif
                            @if ((Auth::user()->can('show orders') == true))
                                @if(auth()->user()->type=="admin")
                                    <li><a href="{{route('admin.shop.orders.index')}}"> الطلبات الاساسية </a></li>
                                @endif
                                <li><a href="{{route('admin.shop.orders.index','sub_orders')}}"> الطلبات
                                        الفرعية </a>
                                </li>
                            @endif
                            @if ((Auth::user()->can('show payment') == true))
                                <li><a href="{{route('admin.shop.payments.index')}}"> اشعارات الدفع(الحوالات) </a>
                                </li>

                            @endif

                        </ul>
                    </li>
                    @if (auth()->user()->type=='admin')
                        <li><a><i class="fa fa-user-plus"></i> مدراء النظام<span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                @if ((Auth::user()->can('show admins') == true))
                                    <li><a href="{{route('admin.admins.index')}}">عرض الكل</a></li>
                                @endif

                                @if ((Auth::user()->can('show permissions') == true))
                                    <li><a href="{{route('admin.permissions.index')}}"> مجموعات الوصول</a></li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    @if ((Auth::user()->can('show women') == true))

                        <li><a><i class="fa fa-female"></i> شؤون المرأة<span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{route('women')}}">عرض محتويات شؤون المرأة</a></li>
                                <li><a href="{{route('women-trashed')}}">سلة المحذوفات</a></li>
                            </ul>
                        </li>
                    @endif
                    @if ((Auth::user()->can('show training') == true))
                        <li><a><i class="fa fa-mortar-board"></i>
                                الدورات التدريبية <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{route('training')}}">إدارة الدورات التدريبية</a></li>
                                <li><a href="{{route('user_trainings')}}">طلبات الانضمام للدورة التدريبية</a></li>
                                <li><a href="{{route('training-trashed')}}">سلة المحذوفات</a></li>
                            </ul>
                        </li>

                        <li><a><i class="fa fa-book"></i> المواد التدريبية <span
                                    class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{route('subject')}}">عرض وادارة المواد التدريبية</a></li>
                                <li><a href="{{route('subject-trashed')}}">سلة المحذوفات</a></li>
                            </ul>
                        </li>


                    @endif


                    @if ((Auth::user()->can('show consultant') == true))
                        <li><a><i class="fa fa-edit"></i>
                                الإستشارات <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{route('showPosts')}}">عرض محتوى الإستشارات</a></li>
                                <li><a href="{{route('deleted_Post')}}">الإستشارات المرفوضة</a></li>
                            </ul>
                        </li>
                    @endif
                    @if ((Auth::user()->can('show slides') == true))
                        <li><a href="{{route('slides.index')}}">
                                <i class="fa fa-image"></i> السلايدات المتحركة </a>
                        </li>
                    @endif
                    @if ((Auth::user()->can('show activates') == true))
                        <li><a href="{{route('activates.index')}}"><i class="fa fa-calendar-times-o"></i> الانشطة
                            </a>
                        </li>
                    @endif
                    <li><a href="{{route('admin.shop.contacts.index')}}"><i class="fa fa-fax"></i> تواصل معنا
                        </a>
                    </li>
                    @if (
                    (Auth::user()->can('show employees') == true) or
                    (Auth::user()->can('show employees_jobs') == true) or
                    (Auth::user()->can('show employees_sections') == true)  )
                        <li><a><i class="fa fa-male"></i> حسابات الموظفين <span
                                    class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                @if ((Auth::user()->can('show employees_sections') == true))

                                    <li><a href="{{route('Emp_Category')}}"> الاقسام </a></li>
                                @endif

                                @if ((Auth::user()->can('show employees_jobs') == true))
                                    <li><a href="{{route('jobs')}}"> الوظائف</a></li>
                                @endif

                                @if ((Auth::user()->can('show employees') == true))

                                    <li><a href="{{route('employee')}}">إدارة حسابات الموظفين</a></li>
                                    <li><a href="{{route('employee-trashed')}}">حسابات موقفة</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ((Auth::user()->can('show share_users') == true))

                        <li><a><i class="fa fa-user-plus"></i> حسابات الشركاء<span
                                    class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{route('SharedUser')}}">طلبات العضوية</a></li>
                                <li><a href="{{route('SharedUserAgree')}}">حسابات تم الموافقة عليها</a></li>
                                <li><a href="{{route('SharedUserTrashed')}}">حسابات تم رفضها</a></li>
                            </ul>
                        </li>
                    @endif
                    @if ((Auth::user()->can('show users') == true))

                        <li><a><i class="fa fa-user-circle"></i> حسابات المستخدمين <span
                                    class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="{{route('user')}}">إدارة حسابات المستخدمين</a></li>
                                <li><a href="{{route('user-trashed')}}">حسابات موقفة</a></li>
                            </ul>
                        </li>

                    @endif
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
                        @if (auth()->user()->type=='admin')
                            <img src="{{asset(auth()->user()->image)}}" alt="">{{auth()->user()->name}}
                        @else

                            <img src="{{url(auth()->user()->seller->ssn_image)}}"
                                 alt="">{{auth()->user()->seller->sale_name}}
                        @endif
                        {{--                        <img src="{{asset('assets/images/'.auth()->user()->image)}}" alt="">{{auth()->user()->name}}--}}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{route('Admin_Edit')}}"><i class="fa fa-user-circle-o pull-right"></i> تعديل
                                البيانات الشخصية</a></li>
                        <li><a href="{{route('Admin_logout')}}"><i class="fa fa-sign-out pull-right"></i> خروج</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green"
                              id="notification_count">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </a>
                    <ul id="admin_notification" class="dropdown-menu list-unstyled msg_list" style="    max-height: 350px;
    overflow: scroll;" role="menu">

                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <li>
                                <a href="{{ notification_type($notification->data['order_id'],$notification->data['notification_type'])}}">
                                <span class="image">
                                    <img src="{{ ($notification->data['sender_image'])}}" alt=" Image"/>
                                </span>
                                    <span>
                          <span> {{ $notification->data['sender_name'] }}</span>
                          <span class="time">{{DatediffForHumans( $notification->data['date']) }}  </span>
                        </span>
                                    <span class="message">{{ $notification->data['message'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </li>
            </ul>
        </nav>
    </div>
</div>



