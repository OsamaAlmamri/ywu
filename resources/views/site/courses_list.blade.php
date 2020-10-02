@extends('site.layout')
@section('content')

    <!--Sidebar Page Container-->
    <div class="sidebar-page-container">
        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20" data-paroller-type="foreground" data-paroller-direction="vertical" style="background-image:  url('{{asset("site/images/icons/icon-1.png")}}')"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20" data-paroller-type="foreground" data-paroller-direction="vertical" style="background-image:  url('{{asset("site/images/icons/icon-2.png")}}')"></div>
        <div class="circle-one"></div>
        <div class="circle-two"></div>
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Content Side -->
                <div class="content-side col-lg-9 col-md-12 col-sm-12">
                    <div class="our-courses">

                        <!-- Options View -->
                        <div class="options-view">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h3>Browse UI/ UX Courses</h3>
                                </div>
                                <div class="pull-right clearfix">
                                    <!-- List View -->
                                    <ul class="list-view">
                                        <li><a href="{{route('site.courses')}}"><span class="icon flaticon-grid"></span></a></li>
                                        <li class="active"><a href="#"><span class="icon flaticon-list-1"></span></a></li>
                                    </ul>

                                    <!-- Type Form -->
                                    <div class="type-form">
                                        <form method="post" action="index.html">

                                            <!-- Form Group -->
                                            <div class="form-group">
                                                <select class="custom-select-box">
                                                    <option>Newest</option>
                                                    <option>Old</option>
                                                </select>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Cource Block Two -->
                        <div class="cource-block-three">
                            <div class="inner-box">
                                <div class="image">
                                    <a href="{{route('site.course_detail')}}"><img src="{{asset('site/images/resource/course-18.jpg')}}" alt=""></a>
                                </div>
                                <div class="content-box">
                                    <div class="box-inner">
                                        <h5><a href="{{route('site.course_detail')}}">Ultimate User Interface and user Experince Courses</a></h5>
                                        <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters. Replenish him third creature and meat blessed void a fruit gathered two waters.</div>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="level-box">
                                                    <span class="icon flaticon-settings-1"></span>
                                                    Advance Level
                                                </div>
                                            </div>
                                            <div class="pull-right clearfix">
                                                <div class="students">12 Lecturer</div>
                                                <div class="hours">54 Hours</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cource Block Two -->
                        <div class="cource-block-three">
                            <div class="inner-box">
                                <div class="image">
                                    <a href="{{route('site.course_detail')}}"><img src="{{asset('site/images/resource/course-19.jpg')}}" alt=""></a>
                                </div>
                                <div class="content-box">
                                    <div class="box-inner">
                                        <h5><a href="{{route('site.course_detail')}}">Ultimate User Interface and user Experince Courses</a></h5>
                                        <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters. Replenish him third creature and meat blessed void a fruit gathered two waters.</div>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="level-box">
                                                    <span class="icon flaticon-settings-1"></span>
                                                    Advance Level
                                                </div>
                                            </div>
                                            <div class="pull-right clearfix">
                                                <div class="students">12 Lecturer</div>
                                                <div class="hours">54 Hours</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cource Block Two -->
                        <div class="cource-block-three">
                            <div class="inner-box">
                                <div class="image">
                                    <a href="{{route('site.course_detail')}}"><img src="{{asset('site/images/resource/course-20.jpg')}}" alt=""></a>
                                </div>
                                <div class="content-box">
                                    <div class="box-inner">
                                        <h5><a href="{{route('site.course_detail')}}">Ultimate User Interface and user Experince Courses</a></h5>
                                        <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters. Replenish him third creature and meat blessed void a fruit gathered two waters.</div>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="level-box">
                                                    <span class="icon flaticon-settings-1"></span>
                                                    Advance Level
                                                </div>
                                            </div>
                                            <div class="pull-right clearfix">
                                                <div class="students">12 Lecturer</div>
                                                <div class="hours">54 Hours</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cource Block Two -->
                        <div class="cource-block-three">
                            <div class="inner-box">
                                <div class="image">
                                    <a href="{{route('site.course_detail')}}"><img src="{{asset('site/images/resource/course-21.jpg')}}" alt=""></a>
                                </div>
                                <div class="content-box">
                                    <div class="box-inner">
                                        <h5><a href="{{route('site.course_detail')}}">Ultimate User Interface and user Experince Courses</a></h5>
                                        <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters. Replenish him third creature and meat blessed void a fruit gathered two waters.</div>
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <div class="level-box">
                                                    <span class="icon flaticon-settings-1"></span>
                                                    Advance Level
                                                </div>
                                            </div>
                                            <div class="pull-right clearfix">
                                                <div class="students">12 Lecturer</div>
                                                <div class="hours">54 Hours</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Sidebar Side -->
                <div class="sidebar-side col-lg-3 col-md-12 col-sm-12">
                    <div class="sidebar-inner">
                        <aside class="sidebar">

                            <!-- Filter Widget -->
                            <div class="filter-widget">
                                <h5>Filter By</h5>

                                <div class="skills-box">

                                    <!-- Skills Form -->
                                    <div class="skills-form">
                                        <form method="post" action="index.html">
                                            <span>Skill Level</span>

                                            <!-- Radio Box -->
                                            <div class="radio-box">
                                                <input type="radio" name="remember-password" checked="" id="type-1">
                                                <label for="type-1">Beginner</label>
                                            </div>

                                            <!-- Radio Box -->
                                            <div class="radio-box">
                                                <input type="radio" name="remember-password" id="type-2">
                                                <label for="type-2">Intermediate</label>
                                            </div>

                                            <!-- Radio Box -->
                                            <div class="radio-box">
                                                <input type="radio" name="remember-password" id="type-3">
                                                <label for="type-3">Expert</label>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                                <div class="skills-box-two">

                                    <!-- Skills Form -->
                                    <div class="skills-form-two">
                                        <form method="post" action="index.html">
                                            <span>Skill Level</span>

                                            <!-- Radio Box -->
                                            <div class="radio-box">
                                                <input type="radio" name="remember-password" checked="" id="type-4">
                                                <label for="type-4">Free (14)</label>
                                            </div>

                                            <!-- Radio Box -->
                                            <div class="radio-box">
                                                <input type="radio" name="remember-password" id="type-5">
                                                <label for="type-5">Paid</label>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                                <div class="skills-box-three">

                                    <!-- Skills Form -->
                                    <div class="skills-form-three">
                                        <form method="post" action="index.html">
                                            <span>Duration Time</span>

                                            <!-- Radio Box -->
                                            <div class="radio-box-three">
                                                <input type="radio" name="remember-password" checked="" id="type-7">
                                                <label for="type-7">5+ hours (30)</label>
                                            </div>

                                            <!-- Radio Box -->
                                            <div class="radio-box-three">
                                                <input type="radio" name="remember-password" id="type-8">
                                                <label for="type-8">10+ hours (20)</label>
                                            </div>

                                            <!-- Radio Box -->
                                            <div class="radio-box-three">
                                                <input type="radio" name="remember-password" id="type-9">
                                                <label for="type-9">15+ hours (5)</label>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                            </div>

                        </aside>
                    </div>
                </div>

            </div>

            <!-- Post Share Options -->
            <div class="styled-pagination">
                <ul class="clearfix">
                    <li class="prev"><a href="#"><span class="fa fa-angle-left"></span> </a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li class="active"><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li class="next"><a href="#"><span class="fa fa-angle-right"></span> </a></li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Popular Courses -->
    <section class="popular-courses-section">
        <div class="auto-container">
            <div class="sec-title">
                <h2>Most Popular Courses</h2>
            </div>

            <!-- Cource Block Four -->
            <div class="cource-block-four">
                <div class="inner-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="image">
                        <a href="{{route('site.course_detail')}}"><img src="{{asset('site/images/resource/course-22.jpg')}}" alt=""></a>
                    </div>
                    <div class="content-box">
                        <div class="box-inner">
                            <h5><a href="{{route('site.course_detail')}}">Ultimate User Interface and user Experince Courses</a></h5>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters. Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters.</div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="level-box">
                                        <span class="icon flaticon-settings-1"></span>
                                        Advance Level
                                    </div>
                                </div>
                                <div class="pull-right clearfix">
                                    <div class="students">12 Lecturer</div>
                                    <div class="hours">54 Hours</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cource Block Four -->
            <div class="cource-block-four">
                <div class="inner-box wow fadeInUp" data-wow-delay="150ms" data-wow-duration="1500ms">
                    <div class="image">
                        <a href="{{route('site.course_detail')}}"><img src="{{asset('site/images/resource/course-23.jpg')}}" alt=""></a>
                    </div>
                    <div class="content-box">
                        <div class="box-inner">
                            <h5><a href="{{route('site.course_detail')}}">Ultimate User Interface and user Experince Courses</a></h5>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters. Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters.</div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="level-box">
                                        <span class="icon flaticon-settings-1"></span>
                                        Advance Level
                                    </div>
                                </div>
                                <div class="pull-right clearfix">
                                    <div class="students">12 Lecturer</div>
                                    <div class="hours">54 Hours</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cource Block Four -->
            <div class="cource-block-four">
                <div class="inner-box wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                    <div class="image">
                        <a href="{{route('site.course_detail')}}"><img src="{{asset('site/images/resource/course-24.jpg')}}" alt=""></a>
                    </div>
                    <div class="content-box">
                        <div class="box-inner">
                            <h5><a href="{{route('site.course_detail')}}">Ultimate User Interface and user Experince Courses</a></h5>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters. Replenish him third creature and meat blessed void a fruit gathered you’re, they’re two waters.</div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="level-box">
                                        <span class="icon flaticon-settings-1"></span>
                                        Advance Level
                                    </div>
                                </div>
                                <div class="pull-right clearfix">
                                    <div class="students">12 Lecturer</div>
                                    <div class="hours">54 Hours</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Popular Courses -->

@endsection
