<template>
    <section class="intro-section">
        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('site/images/icons/icon-1.png')"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('site/images/icons/icon-2.png')"></div>
        <div class="circle-one"></div>
        <div class="auto-container">
            <div class="sec-title">
                <h2>{{training.name}}</h2>
            </div>

            <div class="inner-container">
                <div class="row clearfix">

                    <!-- Content Column -->
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        <div class="inner-column">

                            <!-- Intro Info Tabs-->
                            <div class="intro-info-tabs">
                                <!-- Intro Tabs-->
                                <div class="intro-tabs tabs-box">

                                    <!--Tab Btns-->
                                    <ul class="tab-btns tab-buttons clearfix">
                                        <li data-tab="#prod-overview" @click="changeActive('prod-overview')"
                                            :class="['tab-btn', {'active-btn':(activeTap=='prod-overview')}]">نظرة عامة
                                        </li>
                                        <li data-tab="#prod-curriculum" @click="changeActive('prod-curriculum')"
                                            :class="['tab-btn', {'active-btn':(activeTap=='prod-curriculum')}]">العناوين
                                        </li>
                                        <li data-tab="#prod-reviews" @click="changeActive('prod-reviews')"
                                            :class="['tab-btn', {'active-btn':(activeTap=='prod-reviews')}]">المحتوى
                                            التدريبي
                                        </li>
                                        <li data-tab="#mcq_tap" @click="changeActive('mcq_tap')" id="mcq_tap_open"
                                            :class="['tab-btn', {'active-btn':(activeTap=='mcq_tap')}]">الاختبار
                                        </li>
                                    </ul>

                                    <!--Tabs Container-->
                                    <div class="tabs-content">

                                        <!--Tab / Active Tab-->
                                        <div :class="['tab', {'active-tab':(activeTap=='prod-overview')}]"
                                             id="prod-overview">
                                            <div class="content">

                                                <!-- Cource Overview -->
                                                <div class="course-overview">
                                                    <div class="inner-box">
                                                        <h3>ماذا سوف تتعلم </h3>
                                                        <div v-html="training.learn"></div>

                                                        <h3>متطلبات الدورة التدريبية </h3>
                                                        <div v-html="training.description"></div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Tab -->
                                        <div class="tab" :class="['tab', {'active-tab':(activeTap=='prod-curriculum')}]"
                                             id="prod-curriculum">
                                            <div class="content">

                                                <!-- Accordion Box -->
                                                <ul class="accordion-box">
                                                    <!-- Block -->
                                                    <li class="accordion block" v-for="(title,key) in training.titles">
                                                        <div :key="key" @click="change_active_lession(key)"
                                                             :class="['acc-btn',{'active':key==active_lession}]">
                                                            <div class="icon-outer"><span
                                                                class="icon icon-plus flaticon-angle-arrow-down"></span>
                                                            </div>
                                                            {{title.name}}
                                                        </div>

                                                        <div :class="['acc-content',{'current':key==active_lession}]">
                                                            <div v-for="content in title.contents" class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-right">
                                                                        <a href="void(0)"
                                                                           :data-content="content"
                                                                           class="showContent">
                                                                            {{content.title}}
                                                                        </a>
                                                                    </div>
                                                                    <div class="pull-left">
                                                                        <a v-if="content.video_url"
                                                                           :href="content.video_url"
                                                                           class="lightbox-image play-icon">
                                                                                    <span class="fa fa-play"><i
                                                                                        class="ripple"></i></span>
                                                                        </a>

                                                                        <a v-if="content.sound" :href="content.sound"
                                                                           class="lightbox-image play-icon">
                                                                                    <span class="fa fa-file-sound-o"><i
                                                                                        class="ripple"></i></span>
                                                                        </a>
                                                                        <a v-if="content.book" :href="content.book"
                                                                           class="lightbox-image play-icon">
                                                                                    <span class="fa fa-file-pdf-o"><i
                                                                                        class="ripple"></i></span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </li>

                                                </ul>

                                            </div>
                                        </div>

                                        <!-- Tab -->
                                        <div :class="['tab', {'active-tab':(activeTap=='mcq_tap')}]" id="mcq_tap">
                                            <div class="content">
                                                <course-questions></course-questions>

                                            </div>
                                        </div>


                                        <!-- Tab -->
                                        <div :class="['tab', {'active-tab':(activeTap=='prod-reviews')}]"
                                             id="prod-reviews">
                                            <div class="content">

                                                <div class="cource-review-box">
                                                    <h4>Stephane Smith</h4>
                                                    <div class="rating">
                                                        <span class="total-rating">4.5</span> <span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span class="fa fa-star"></span>&ensp;
                                                        256 Reviews
                                                    </div>
                                                    <div class="text">Phasellus enim magna, varius et commodo ut,
                                                        ultricies vitae velit. Ut nulla tellus, eleifend euismod
                                                        pellentesque vel, sagittis vel justo. In libero urna, venenatis
                                                        sit amet ornare non, suscipit nec risus.
                                                    </div>
                                                    <div class="helpful">Was this review helpful?</div>
                                                    <ul class="like-option">
                                                        <li><span class="icon fa fa-thumbs-o-up"></span></li>
                                                        <li><span class="icon fa fa-thumbs-o-down"></span></li>
                                                        <span class="report">Report</span>
                                                    </ul>
                                                </div>

                                                <div class="cource-review-box">
                                                    <h4>Anna Sthesia</h4>
                                                    <div class="rating">
                                                        <span class="total-rating">4.5</span> <span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span class="fa fa-star"></span>&ensp;
                                                        256 Reviews
                                                    </div>
                                                    <div class="text">Phasellus enim magna, varius et commodo ut,
                                                        ultricies vitae velit. Ut nulla tellus, eleifend euismod
                                                        pellentesque vel, sagittis vel justo. In libero urna, venenatis
                                                        sit amet ornare non, suscipit nec risus.
                                                    </div>
                                                    <div class="helpful">Was this review helpful?</div>
                                                    <ul class="like-option">
                                                        <li><span class="icon fa fa-thumbs-o-up"></span></li>
                                                        <li><span class="icon fa fa-thumbs-o-down"></span></li>
                                                        <span class="report">Report</span>
                                                    </ul>
                                                </div>

                                                <div class="cource-review-box">
                                                    <h4>Petey Cruiser</h4>
                                                    <div class="rating">
                                                        <span class="total-rating">4.5</span> <span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span class="fa fa-star"></span>&ensp;
                                                        256 Reviews
                                                    </div>
                                                    <div class="text">Phasellus enim magna, varius et commodo ut,
                                                        ultricies vitae velit. Ut nulla tellus, eleifend euismod
                                                        pellentesque vel, sagittis vel justo. In libero urna, venenatis
                                                        sit amet ornare non, suscipit nec risus.
                                                    </div>
                                                    <div class="helpful">Was this review helpful?</div>
                                                    <ul class="like-option">
                                                        <li><span class="icon fa fa-thumbs-o-up"></span></li>
                                                        <li><span class="icon fa fa-thumbs-o-down"></span></li>
                                                        <span class="report">Report</span>
                                                    </ul>
                                                </div>

                                                <div class="cource-review-box">
                                                    <h4>Rick O'Shea</h4>
                                                    <div class="rating">
                                                        <span class="total-rating">4.5</span> <span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span
                                                        class="fa fa-star"></span><span class="fa fa-star"></span>&ensp;
                                                        256 Reviews
                                                    </div>
                                                    <div class="text">Phasellus enim magna, varius et commodo ut,
                                                        ultricies vitae velit. Ut nulla tellus, eleifend euismod
                                                        pellentesque vel, sagittis vel justo. In libero urna, venenatis
                                                        sit amet ornare non, suscipit nec risus.
                                                    </div>
                                                    <div class="helpful">Was this review helpful?</div>
                                                    <ul class="like-option">
                                                        <li><span class="icon fa fa-thumbs-o-up"></span></li>
                                                        <li><span class="icon fa fa-thumbs-o-down"></span></li>
                                                        <span class="report">Report</span>
                                                    </ul>

                                                    <a href="#" class="more">View More</a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Video Column -->
                    <div class="video-column col-lg-4 col-md-12 col-sm-12">
                        <div class="inner-column sticky-top">
                            <div class="intro-video"
                                 v-bind:style="{ backgroundImage: 'url(assets/images/' + training.thumbnail + ')' }">


                                <!--                            <clazy-load class="wrapper intro-video" :src="'assets/images/' + training.thumbnail">-->
                                <!--                                <transition name="fade">-->
                                <!--                                    <div class="intro-video"-->
                                <!--                                         v-bind:style="{ backgroundImage: 'url(assets/images/' + training.thumbnail + ')' }">-->
                                <!--                                    </div>-->
                                <!--                                </transition>-->
                                <!--                                <transition name="fade" slot="placeholder">-->
                                <!--                                    <div class="vue_preloader">-->
                                <!--                                        <div class="circle">-->
                                <!--                                            <div class="circle-inner"></div>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </transition>-->
                                <!--                            </clazy-load>-->
                            </div>

                            <!-- End Video Box -->
                            <div class="price">{{training.length}} <i class="fa fa-clock-o"></i></div>
                            <div class="time-left"> تبدا في {{training.start_at}}</div>
                            <div class="time-left"> تنتهي في {{training.end_at}}</div>

                            <a href="#" v-show="training.is_like==null" class="theme-btn btn-style-three"><span
                                class="txt">اضافة للمفضلة  <i
                                class="fa fa-angle-left"></i></span></a>
                            <a href="#" v-show="training.is_register==null" class="theme-btn btn-style-two"><span
                                class="txt">التسجيل بالدورة  <i
                                class="fa fa-angle-left"></i></span></a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</template>

<script>
    // import question from './Question.vue';
    import axios from "axios";

    export default {
        props: ['items'],
        // components: {question},
        data() {
            return {
                training: {
                    "id": 0,
                    "category_id": 0,
                    "name": "",
                    "description": "",
                    "certificate": "",
                    "mark": "",
                    "type": "",
                    "length": "",
                    "start_at": "",
                    "end_at": "",
                    "thumbnail": "",
                    "published": "",
                    "result": null,
                    "category": {
                        "id": 0,
                        "name": " "
                    },
                    "is_register": null,
                    "titles": []
                },
                activeIndex: null,
                active_lession: 0,
                activeTap: 'prod-overview',
                sections: [],
                course_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {
            this.course_id = this.$route.params.id
            this.fetchTraining();
        },
        methods: {
            onToggle(index) {
                if (this.activeIndex == index) {
                    return (this.activeIndex = null);
                }
                this.activeIndex = index;
            },
            changeActive(index) {
                this.activeTap = index;
            },
            change_active_lession(index) {
                this.active_lession = index;
            },
            fetchTraining() {
                axios({url: '/api/ShowTrainings2', data: {id: this.course_id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.training = resp.data.Trainings;
                        }
                    })
                    .catch(err => {
                        localStorage.removeItem('token')
                        localStorage.removeItem('user')
                        reject(err)
                    })
                // fetch('/api/ShowTrainings2', {
                //     method: 'post',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         // 'Authorization': 'Bearer my-token',
                //         // 'My-Custom-Header': 'foobar'
                //     },
                //     body: JSON.stringify({id: this.course_id, title: 'Vue POST Request Example'})
                // })
                //     .then(res => res.json())
                //     .then(res => {
                //         this.training = res.Trainings;
                //     })
                //     .catch(err => console.log(err));
            },

        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>
