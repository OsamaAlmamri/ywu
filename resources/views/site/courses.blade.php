@extends('site.layout')
@section('content')

    <!--Sidebar Page Container-->
    <div class="sidebar-page-container">
        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('{{asset("site/images/icons/icon-1.png")}}')"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('{{asset("site/images/icons/icon-2.png")}}')"></div>
        <div class="circle-one"></div>
        <div class="circle-two"></div>
        <div class="auto-container">
            <div class="row clearfix">

                {{--                <!-- Content Side -->--}}
                {{--                <div class="content-side col-lg-12 col-md-12 col-sm-12">--}}
                {{--                    @foreach($sections as $section)--}}
                {{--                        <div class="our-courses">--}}
                {{--                            <!-- Options View -->--}}
                {{--                            <div class="options-view">--}}
                {{--                                <div class="clearfix">--}}
                {{--                                    <div class="pull-right">--}}
                {{--                                        <h3>{{$section->name}}</h3>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="row clearfix">--}}
                {{--                                <!-- Cource Block Two -->--}}
                {{--                                @foreach($section->trainings as $training)--}}
                {{--                                    <div class="cource-block-two col-lg-3 col-md-4 col-sm-6 col-xs-12 ">--}}
                {{--                                        <div class="inner-box">--}}
                {{--                                            <div class="image">--}}
                {{--                                                <a href="{{route('site.course_detail',$training->id)}}">--}}
                {{--                                                    <img src="{{url('assets/images/resource/course-6.jpg')}}"--}}
                {{--                                                         alt=""></a>--}}
                {{--                                                <div class="divClass"--}}
                {{--                                                     style="background-image:url('{{asset("assets/images/".$training->thumbnail)}}')"></div>--}}

                {{--                                            </div>--}}
                {{--                                            <div class="lower-content">--}}
                {{--                                                <h5>--}}
                {{--                                                    <a href="{{route('site.course_detail',$training->id)}}">{{$training->name}}</a>--}}
                {{--                                                </h5>--}}
                {{--                                                <div class="text">Replenish of third creature and meat blessed void--}}
                {{--                                                    a--}}
                {{--                                                    fruit--}}
                {{--                                                    gathered waters.--}}
                {{--                                                </div>--}}
                {{--                                                <div class="clearfix">--}}
                {{--                                                    <div class="pull-right">--}}
                {{--                                                        <div--}}
                {{--                                                            class=" students"> {{getViewCustomDate($training->start_at)}}--}}
                {{--                                                            <i class="fa fa-calendar"></i></div>--}}
                {{--                                                    </div>--}}
                {{--                                                    <div class="pull-left">--}}
                {{--                                                        <div class="students hours">{{$training->length}} <i--}}
                {{--                                                                class="fa fa-clock-o"></i></div>--}}
                {{--                                                    </div>--}}
                {{--                                                </div>--}}
                {{--                                            </div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                @endforeach--}}


                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    @endforeach--}}
                {{--                </div>--}}

                <course-component></course-component>

            </div>
        </div>
    </div>

@endsection
