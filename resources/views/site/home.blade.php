@extends('site.layout')
@section('content')
    <!-- Banner Section -->

    <section class="banner-section">
        <div class="pattern-layer" style="background-image: url('{{asset("site/images/background/1.png")}}')"></div>
        <div class="auto-container">

            <!-- Content Boxed -->
            <div class="content-boxed">
                <div class="inner-column">
                    <h1>Learn Math, Science, English and Test <br> Prep from our Experts</h1>
                    <div class="buttons-box">
                        <a href="course.html" class="theme-btn btn-style-one"><span class="txt">Get Stared <i
                                    class="fa fa-angle-left"></i></span></a>
                        <a href="course.html" class="theme-btn btn-style-two"><span class="txt">All Courses <i
                                    class="fa fa-angle-left"></i></span></a>
                    </div>
                </div>
            </div>

            <!-- Image Boxed -->
            <div class="image titlt" data-tilt="" data-tilt-max="4">
                <a href="{{asset('site/images/resource/banner.png')}}" data-fancybox="banner" data-caption=""
                   class=""><img
                        src="{{asset('site/images/resource/banner.png')}}" alt=""></a>
            </div>

            <!-- Search Boxed -->
            <div class="search-boxed">
                <div class="search-box">
                    <form method="post" action="contact.html">
                        <div class="form-group">
                            <input type="search" name="search-field" value="" placeholder="What do you want to learn?"
                                   required="">
                            <button type="submit"><span class="icon fa fa-search"></span></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <section class="education-section">
        <div class="patern-layer-one paroller" data-paroller-factor="0.60" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('{{asset("site/images/icons/icon-1.png")}}')"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.60" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('{{asset("site/images/icons/icon-2.png")}}')"></div>
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Image Column -->
                <div class="image-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column parallax-scene-1">
                        <div class="image parallax-layer" data-depth="0.30">
                            <img src="{{asset('site/images/resource/education.png')}}" alt="">
                        </div>
                    </div>
                </div>

                <!-- Content Column -->
                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <h2>Our education system <br> works for you</h2>
                        <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re,
                            they’re two waters own morning gathered greater shall had behold had seed.
                        </div>
                        <a href="course.html" class="theme-btn btn-style-two"><span class="txt">Learn More <i
                                    class="fa fa-angle-left"></i></span></a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Education Section -->

    <!-- Courses Section -->
    <section class="courses-section">
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Title Column -->
                <div class="title-column col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title">
                            <h2>Our top courses</h2>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters own morning gathered.
                            </div>
                        </div>
                        <a href="course.html" class="theme-btn btn-style-three"><span class="txt">Get Stared <i
                                    class="fa fa-angle-left"></i></span></a>
                    </div>
                </div>

                <!-- Cource Block -->
                <div class="cource-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="course-detail.html"><img src="{{asset('site/images/resource/course-1.jpg')}}"
                                                              alt=""></a>
                        </div>
                        <div class="lower-content">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h5><a href="course-detail.html">Computer Science</a></h5>
                                </div>
                                <div class="pull-right">
                                    <div class="price">$140</div>
                                </div>
                            </div>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters.
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="students">125 Student</div>
                                </div>
                                <div class="pull-right">
                                    <a href="course-detail.html" class="enroll">Enroll Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cource Block -->
                <div class="cource-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="course-detail.html"><img src="{{asset('site/images/resource/course-2.jpg')}}"
                                                              alt=""></a>
                        </div>
                        <div class="lower-content">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h5><a href="course-detail.html">Data Science</a></h5>
                                </div>
                                <div class="pull-right">
                                    <div class="price">$140</div>
                                </div>
                            </div>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters.
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="students">125 Student</div>
                                </div>
                                <div class="pull-right">
                                    <a href="course-detail.html" class="enroll">Enroll Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cource Block -->
                <div class="cource-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="course-detail.html"><img src="{{asset('site/images/resource/course-3.jpg')}}"
                                                              alt=""></a>
                        </div>
                        <div class="lower-content">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h5><a href="course-detail.html">Development Course</a></h5>
                                </div>
                                <div class="pull-right">
                                    <div class="price">$140</div>
                                </div>
                            </div>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters.
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="students">125 Student</div>
                                </div>
                                <div class="pull-right">
                                    <a href="course-detail.html" class="enroll">Enroll Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cource Block -->
                <div class="cource-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="course-detail.html"><img src="{{asset('site/images/resource/course-4.jpg')}}"
                                                              alt=""></a>
                        </div>
                        <div class="lower-content">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h5><a href="course-detail.html">Language Course</a></h5>
                                </div>
                                <div class="pull-right">
                                    <div class="price">$140</div>
                                </div>
                            </div>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters.
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="students">125 Student</div>
                                </div>
                                <div class="pull-right">
                                    <a href="course-detail.html" class="enroll">Enroll Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cource Block -->
                <div class="cource-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="course-detail.html"><img src="{{asset('site/images/resource/course-5.jpg')}}"
                                                              alt=""></a>
                        </div>
                        <div class="lower-content">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h5><a href="course-detail.html">Business Course</a></h5>
                                </div>
                                <div class="pull-right">
                                    <div class="price">$140</div>
                                </div>
                            </div>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters.
                            </div>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="students">125 Student</div>
                                </div>
                                <div class="pull-right">
                                    <a href="course-detail.html" class="enroll">Enroll Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Courses Section -->

    <!-- Call To Action Section -->
    <section class="call-to-action-section">
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Title Column -->
                <div class="title-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title">
                            <h2>Live the experience <br> learn at your own pace</h2>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="form-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="help">For Help?</div>
                        <div class="search-box">
                            <form method="post" action="contact.html">
                                <div class="form-group">
                                    <input type="search" name="search-field" value=""
                                           placeholder="What do you want to learn?" required="">
                                    <button type="submit"><span class="icon fa fa-search"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Call To Action Section -->

    <!-- Video Section -->
    <section class="video-section" style="background-image: url('{{asset("site/images/background/2.jpg")}}')">
        <div class="auto-container">
            <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image video-box"><span
                    class="fa fa-play"><i class="ripple"></i></span></a>
            <h4>Watch Intro Video</h4>
        </div>
    </section>
    <!-- End Video Section -->

    <!-- Achievement Section -->
    <section class="achievements-section">
        <div class="auto-container">
            <!-- Sec Title -->
            <div class="sec-title centered">
                <h2>Our achievements</h2>
                <div class="text">Replenish him third creature and meat blessed void a fruit gathered you’re, they’re
                    <br> two waters own morning gathered greater shall had behold had seed.
                </div>
            </div>

            <!-- Fact Counter -->
            <div class="fact-counter">
                <div class="row clearfix">

                    <!-- Column -->
                    <div class="column counter-column col-lg-4 col-md-6 col-sm-12">
                        <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="content">
                                <div class="icon-box">
                                    <span class="icon flaticon-course"></span>
                                </div>
                                <h4 class="counter-title">Total Courses</h4>
                                <div class="count-outer count-box">
                                    <span class="count-text" data-speed="2000" data-stop="50">0</span>+
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column -->
                    <div class="column counter-column col-lg-4 col-md-6 col-sm-12">
                        <div class="inner wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="content">
                                <div class="icon-box">
                                    <span class="icon flaticon-course-1"></span>
                                </div>
                                <h4 class="counter-title">Total Student</h4>
                                <div class="count-outer count-box alternate">
                                    <span class="count-text" data-speed="3000" data-stop="45">0</span>K+
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column -->
                    <div class="column counter-column col-lg-4 col-md-6 col-sm-12">
                        <div class="inner wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="content">
                                <div class="icon-box">
                                    <span class="icon flaticon-world"></span>
                                </div>
                                <h4 class="counter-title">Global Position</h4>
                                <div class="count-outer count-box">
                                    <span class="count-text" data-speed="4000" data-stop="115">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- End Achievement Section -->

    <!-- Fluid Section One -->
    <section class="fluid-section-one">
        <div class="patern-layer-one paroller" data-paroller-factor="0.60" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('{{asset("site/images/icons/icon-1.png")}}')"></div>
        <div class="outer-container clearfix">

            <!-- Image Column -->
            <div class="image-column" style="background-image:url('{{asset("site/images/resource/image-1.jpg")}}')">
                <figure class="image-box"><img src="{{asset('site/images/resource/image-1.jpg')}}" alt=""></figure>
            </div>

            <!-- Content Column -->
            <div class="content-column">
                <div class="inner-column">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h2>Upcoming events</h2>
                        </div>
                        <div class="pull-right">
                            <a href="course-detail.html" class="events">All Events</a>
                        </div>
                    </div>

                    <!-- Blocks Outer -->
                    <div class="blocks-outer">

                        <!-- Event Block -->
                        <div class="event-block">
                            <div class="inner-box">
                                <div class="clearfix">
                                    <!-- Event Date -->
                                    <div class="event-date clearfix"><span class="date">21</span>JAN 2020</div>
                                    <!-- Event List -->
                                    <ul class="event-list">
                                        <li><a href="course-detail.html">ART & DESIGN</a></li>
                                        <li><a href="course-detail.html">PAINTING</a></li>
                                    </ul>
                                </div>
                                <h3><a href="course-detail.html">Workshop on UI/ UX</a></h3>
                            </div>
                        </div>

                        <!-- Event Block -->
                        <div class="event-block">
                            <div class="inner-box">
                                <div class="clearfix">
                                    <!-- Event Date -->
                                    <div class="event-date clearfix"><span class="date">15</span>Mar 2020</div>
                                    <!-- Event List -->
                                    <ul class="event-list">
                                        <li><a href="course-detail.html">ART & DESIGN</a></li>
                                        <li><a href="course-detail.html">PAINTING</a></li>
                                    </ul>
                                </div>
                                <h3><a href="course-detail.html">Amsterdam art weekend</a></h3>
                            </div>
                        </div>

                        <!-- Event Block -->
                        <div class="event-block">
                            <div class="inner-box">
                                <div class="clearfix">
                                    <!-- Event Date -->
                                    <div class="event-date clearfix"><span class="date">21</span>mar 2020</div>
                                    <!-- Event List -->
                                    <ul class="event-list">
                                        <li><a href="course-detail.html">ART & DESIGN</a></li>
                                        <li><a href="course-detail.html">PAINTING</a></li>
                                    </ul>
                                </div>
                                <h3><a href="course-detail.html">Outside fashion - Group exhibition</a></h3>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- News Section -->
    <section class="news-section">
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Title Column -->
                <div class="title-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title">
                            <h2>Our Latest blog posts</h2>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters own morning gathered greater shall had behold had seed.
                            </div>
                        </div>
                        <a href="course.html" class="theme-btn btn-style-three"><span class="txt">All Blog Post <i
                                    class="fa fa-angle-left"></i></span></a>
                    </div>
                </div>

                <!-- News Column -->
                <div class="news-block col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="blog-detail.html"><img src="{{asset('site/images/resource/news-1.jpg')}}"
                                                            alt=""></a>
                        </div>
                        <div class="lower-content">
                            <h3><a href="blog-detail.html">To apply signal detection theory</a></h3>
                            <div class="text">Replenish him third creature and meat blessed void a fruit gathered
                                you’re, they’re two waters
                            </div>
                            <a href="blog-detail.html" class="read-more">Continue Reading</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End News Section -->


@endsection
