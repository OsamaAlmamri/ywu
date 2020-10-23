<template>
    <section class="intro-section">
        <loading :active.sync="isLoading"
                 :can-cancel=false
                 :color="'#00ab15'"
                 :loader="'dots'"
                 :background-color="'#f8f9fa'"
                 :height='200'
                 :width='140'
                 :on-cancel="onCancel()"
                 :is-full-page="fullPage">
        </loading>

        <sweet-modal modal-theme="dark" :title="contentDeatail.name"
                     blocking="true" enable-mobile-fullscreen="true"
                     pulse-on-block="true"
                     overlay-theme="dark" ref="modal">
            <div v-html="contentDeatail.body"></div>

            <sweet-button slot="button">
                <button class="btn btn-info" @click.prevent="completeContent()">تم</button>
            </sweet-button>


        </sweet-modal>
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
                                            :class="['tab-btn', {'active-btn':(activeTap=='prod-reviews')}]">التقييمات

                                        </li>
                                        <li v-if="calculateProgress=='100' && training.result==null "
                                            data-tab="#mcq_tap"
                                            @click="changeActive('mcq_tap')" id="mcq_tap_open"
                                            :class="['tab-btn', {'active-btn':(activeTap=='mcq_tap')}]">الاختبار
                                        </li>
                                        <li v-if="training.result!=null"
                                            @click="changeActive('result')"
                                            :class="['tab-btn', {'active-btn':(activeTap=='result')}]">نتيجتي
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
                                                    <li class="accordion block"
                                                        v-for="(title,title_key) in training.titles">
                                                        <div :key="title_key" @click="change_active_lession(title_key)"
                                                             :class="['acc-btn',{'active':title_key==active_lession}]">
                                                            <div class="icon-outer"><span
                                                                class="icon icon-plus flaticon-angle-arrow-down"></span>
                                                            </div>
                                                            <i class="fa fa-check" :key="title_key"
                                                               v-if="title.is_complete"></i>

                                                            {{title.name}}
                                                        </div>

                                                        <div
                                                            :class="['acc-content',{'current':title_key==active_lession}]">
                                                            <div v-for="(content,content_key) in title.contents"
                                                                 class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-right">
                                                                        <!--                                                                        contentCompleted(content,content_key,title_key)-->
                                                                        <i class="fa fa-check" :key="content_key"
                                                                           v-if="content.is_complete"></i>
                                                                        <a href="void(0)"
                                                                           @click.prevent="showContent(content,content_key,title_key)"
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
                                                <course-questions v-on:set_result="set_my_result"></course-questions>

                                            </div>
                                        </div>


                                        <!-- Tab -->
                                        <div :class="['tab', {'active-tab':(activeTap=='result')}]">
                                            <div class="content" v-if="training.result!=null">
                                                <h3>نتيجتك بهذا المادة التدريبية هي </h3>
                                                <h2>{{training.result.grade}}</h2>

                                            </div>
                                        </div>


                                        <!-- Tab -->
                                        <div :class="['tab', {'active-tab':(activeTap=='prod-reviews')}]"
                                             id="prod-reviews">
                                            <div class="content">


                                                <div class="row" style="margin:0px 10px 30px;">
                                                    <div class=" col-md-4">
                                                        <div
                                                            class="udlite-heading-xxxl review-summary-widget--average-number--2Q0bz">
                                                            {{training.rating_details.average}}
                                                        </div>
                                                        <p class="review-summary-widget--average-rating-text--2BT9O">
                                                            <rating-stars system="5"
                                                                          :rating="training.rating_details.average"></rating-stars>
                                                            عدد المقيمين {{training.rating_details.sum}}
                                                        </p>
                                                    </div>

                                                    <div class=" col-md-7 ">
                                                        <div class="row" v-for="i in reverseKeys(5)">
                                                            <div class="col-8">
                                                                <div class="row progress md-progress"
                                                                     style="height: 20px; margin-bottom: 10px; ">
                                                                    <div class="progress-bar progress-bar-success"
                                                                         role="progressbar"
                                                                         :style="[{'width': valueWidth(i+1)+'%'}, {'height': '20px'}]"
                                                                         :aria-valuenow="valueWidth(i+1)"
                                                                         aria-valuemin="0" aria-valuemax="100">
                                                                        {{valueWidth(i+1)}} %
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <rating-stars system="5" :rating="i+1"></rating-stars>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                </div>

                                                <div class="row new_rating_dev " v-show="show_new_rateForm">
                                                    <fieldset class="the-fieldset new_rating_dev"
                                                              style="border: 1px solid #e0e0e0; padding: 10px;">
                                                        <legend class="the-legend"> اضافة تقييم</legend>
                                                        <rating-stars2 font_size='3' v-on:change="change_new_rating_val"
                                                                       :value="newRating.rating"></rating-stars2>
                                                        <div class="form-group" style="width: 100%">
                                                            <fieldset class="the-fieldset">
                                                                <legend class="the-legend">نص التقييم</legend>
                                                                <textarea style="width: 100%" rows="4" class=""
                                                                          v-model="newRating.message"></textarea>
                                                            </fieldset>
                                                        </div>
                                                        <button class="btn btn-primary" @click="rating()">حفظ التقييم
                                                        </button>
                                                        <button class="btn btn-warning" @click="edit_rate=false"
                                                                v-show="training.is_rating!=null"> الغاء
                                                        </button>
                                                    </fieldset>
                                                </div>

                                                <div v-if="showOldRating"
                                                     class="cource-review-box">
                                                    <div style="width: 100%; display: inline-block;">

                                                        <dropdown>
                                                            <div slot="items">
                                                                <a class="dropdown-item" href="#"
                                                                   @click.prevent="edit_rating()">تعديل</a>
                                                                <a class="dropdown-item" href="#"
                                                                   @click.prevent="deleteRating()"> حذف </a>
                                                            </div>
                                                        </dropdown>
                                                        <!--                                                        <div-->
                                                        <!--                                                            :class="['dropdown', 'pull-left',{'show':(is_active_dropdown)}]">-->
                                                        <!--                                                            <button type="button"-->
                                                        <!--                                                                    @click="is_active_dropdown=!is_active_dropdown"-->
                                                        <!--                                                                    class="btn btn-defaulty dropdown-toggle"-->
                                                        <!--                                                                    data-toggle="dropdown">-->
                                                        <!--                                                                <span style="font-size: 17px">...</span>-->
                                                        <!--                                                            </button>-->
                                                        <!--                                                            <div class="dropdown-menu"-->
                                                        <!--                                                                 :class="['dropdown-menu',{'dropdown_animation':(is_active_dropdown)},{'show':(is_active_dropdown)}]">-->
                                                        <!--                                                              -->

                                                        <!--                                                            </div>-->
                                                        <!--                                                        </div>-->
                                                        <h4 class="pull-right">
                                                            {{training.is_rating.user_rater.name}} </h4>
                                                    </div>
                                                    <div class="rating">
                                                        <rating-stars :rating="training.is_rating.rating" system="5">
                                                            <span slot="after"> {{training.is_rating.published}}</span>
                                                        </rating-stars>
                                                    </div>
                                                    <div class="text">{{training.is_rating.message}}</div>
                                                    <hr>
                                                </div>


                                                <div v-for="rating in training.ratings" class="cource-review-box">
                                                    <h4>{{rating.user_rater.name}} </h4>
                                                    <div class="rating">
                                                        <rating-stars :rating="rating.rating" system="5">
                                                            <span slot="after"> {{rating.published}}</span>
                                                        </rating-stars>
                                                    </div>
                                                    <div class="text">{{rating.message}}</div>
                                                    <hr>
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
                                 v-bind:style="{ backgroundImage: 'url('+BaseImagePath + training.thumbnail + ')' }">


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

                            <a href="#"
                               v-show="training.is_like==null"
                               class="theme-btn btn-style-three"><span
                                class="txt">
                                 <like-button type="trainings" :on-like="likeTraining" :key="training.id"
                                              count-likes="0" has-count="0"
                                              :liked_id="training.id" :is_liked="training.is_like"></like-button>
                                 {{(training.is_like==null?'اضافة للمفضلة':'الغاء من المفضلة')}}
                                <i
                                    class="fa fa-angle-left"></i></span></a>
                            <div>
                                <h4> التقدم بالدورة</h4>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success"
                                         role="progressbar"
                                         :style="[{'width': calculateProgress+'%'}, {'height': '20px'}]"
                                         :aria-valuenow="calculateProgress"
                                         aria-valuemin="0" aria-valuemax="100">{{calculateProgress}}%
                                    </div>
                                </div>
                            </div>

                            <a href="#" :disabled="!training.can_register"  @click="registerInCourse()"
                               class="theme-btn btn-style-two"><span
                                class="txt"> {{registerDecription}}   <i
                                class="fa fa-angle-left"></i></span></a>


                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</template>

<script>
    import RatingStars from './RatingStars.vue';
    import axios from "axios";
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import RatingStars2 from "./RatingStars2";
    import LikeButton from "./LikeButton";

    export default {
        props: ['items'],
        // components: {question},
        components: {RatingStars2, Loading, RatingStars, LikeButton},

        data() {
            return {
                isLoading: false,
                edit_rate: false,
                fullPage: true,
                is_active_dropdown: false,
                training: {
                    "id": 0,
                    "category_id": 0,
                    "name": "",
                    "description": "",
                    "learn": "",
                    "instructor": null,
                    "has_certificate": 0,
                    "mark": 0,
                    "type": " ",
                    "length": " ",
                    "start_at": " ",
                    "end_at": " ",
                    "thumbnail": " ",
                    "deleted_at": null,
                    "published": " ",
                    "can_register": 1,
                    "average_rating": 5,
                    "count_rating": 1,
                    "percent_rating": 100,
                    "is_like": null,
                    "user_complete": {
                        "is_complete": false,
                        "complete": 3,
                        "titles": 7
                    },
                    "ratings": [
                        {
                            "id": 2,
                            "rateable_type": "",
                            "rateable_id": 0,
                            "rating": 0,
                            "message": "",
                            "user_id": 0,
                            "created_at": "",
                            "updated_at": "",
                            "published": " ",
                            "user_rater": {
                                "id": 0,
                                "name": " ",
                                "type": "",
                                "published": ""
                            }
                        }
                    ],
                    "rating_details": {
                        "one": 0,
                        "tow": 0,
                        "three": 0,
                        "four": 0,
                        "five": 0,
                        "sum": 0,
                        "average": 0
                    },
                    "is_rating": null,
                    "result": null,
                    "is_register": {
                        "id": 0,
                        "user_id": 0,
                        "training_id": 0,
                        "status": 0,
                        "created_at": "",
                        "updated_at": "",
                        "published": ""
                    },
                    "titles": []
                },
                newRating:
                    {
                        course_id: 0,
                        rating: 1,
                        message: '',
                    },
                activeContent: {
                    "id": 0,
                    "is_complete": false,
                    "title": "",
                    "body": "",
                    "image": "",
                    "book": "",
                    "sound": "",
                    "video_url": "",
                    "title_id": 0,
                    "deleted_at": null,
                    "published": "منذ أسبوع"
                },
                activeIndex: null,
                active_lession: 0,
                active_title_complete: 0,
                activeTap: 'prod-overview',
                sections: [],
                course_id: '',
                activeContent_key: 0,
                activeContent_title_key: 0,
                pagination: {},
                edit: false
            }
        },
        created() {
            this.course_id = this.$route.params.id
            this.newRating.course_id = this.$route.params.id
            this.fetchTraining();
        },
        computed: {
            contentDeatail() {
                return this.activeContent;
            },
            registerDecription() {
                if (this.training.is_register == null)
                    return ' تسجيل ';
                else if (this.training.is_register.status == 0)
                    return ' الغاء التسجيل  ';
                else
                    return '  الغاء التسجيل  ';

            },
            calculateProgress() {
                let titles = this.training.user_complete.titles;
                let trainings = 0;

                for (var i = 0; i < this.training.titles.length; i++) {
                    if (this.training.titles[i].is_complete) {
                        trainings++;
                    }
                }
                var p = (trainings / ((titles > 0) ? titles : 1)) * 100;
                return (p.toFixed(0));
            },
            show_new_rateForm() {
                return (this.training.is_rating == null || this.edit_rate == true);
            },
            showOldRating() {
                // return false;
                return (this.training.is_rating != null && this.edit_rate == false);
            },

            contentCompleted(content, content_key, title_key) {
                return this.training.titles[title_key].contents[content_key].is_complete;

            },

        }
        ,
        methods: {
            valueWidth(i) {
                switch (i) {
                    case 1:
                        return this.training.rating_details.one;
                        break;
                    case 2:
                        return this.training.rating_details.tow;
                        break;
                    case 3:
                        return this.training.rating_details.three;
                        break;
                    case 4:
                        return this.training.rating_details.four;
                        break;
                    case 5:
                        return this.training.rating_details.five;
                        break;

                }
                return this.tr;
            },
            registerInCourse() {
                if (localStorage.token) {
                    axios({
                        url: '/api/register_to_training', data: {
                            training_id: this.training.id
                        }, method: 'POST'
                    }).then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.training.is_register = resp.data.data;
                            toastStack(resp.data.msg, '', 'success');
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
                this.$emit('click', this.$vnode.key)
            },
            change_new_rating_val: function (newVal) {
                this.newRating.rating = newVal;
            }, likeTraining: function (is_like) {
                if (is_like == 1)
                    this.training.is_like = {'id': this.rating.id}
                else
                    this.training.is_like = null;
            },

            onToggle(index) {
                if (this.activeIndex == index) {
                    return (this.activeIndex = null);
                }
                this.activeIndex = index;
            }
            ,
            showContent(content, content_key, title_key) {

                this.activeContent = content;
                this.activeContent_key = content_key;
                this.activeContent_title_key = title_key;
                this.$refs.modal.open();
            }
            ,
            openModal() {
                this.$refs.modal.open();
            }
            ,
            changeActive(index) {
                this.activeTap = index;
            }
            ,
            change_active_lession(index) {
                this.active_lession = index;
            }
            ,
            reverseKeys(n) {
                return [...Array(n).keys()].slice().reverse()
            }
            ,
            edit_rating() {
                this.is_active_dropdown = false;
                this.edit_rate = true;
                this.newRating.rating = this.training.is_rating.rating;
                this.newRating.message = this.training.is_rating.message;

            },
            fetchTraining() {
                this.isLoading = true;
                axios({url: '/api/getTrainingDetails', data: {id: this.course_id}, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.training = resp.data.Trainings;
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
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
            }
            ,

            completeContent() {
                axios({url: '/api/complete_content', data: {id: this.activeContent.id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.training.titles[this.activeContent_title_key].contents[this.activeContent_key].is_complete = true;
                            this.training.titles[this.activeContent_title_key].is_complete = resp.data.title_complete;
                            this.$refs.modal.close();
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            }
            ,

            rating() {
                this.isLoading = true;
                axios({url: '/api/training/rate2', data: this.newRating, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            // this.training.is_rating = resp.data.data;
                            this.training.is_rating = resp.data.data.is_rating;
                            this.training.ratings = resp.data.data.ratings;
                            this.training.rating_details = resp.data.data.rating_details;
                            this.edit_rate = false;
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            }
            ,

            deleteRating() {
                this.isLoading = true;
                axios({url: '/api/training/delete_rate2', data: {id: this.training.is_rating.id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            // if (resp.data.data == 1) {
                            this.training.is_rating = resp.data.data.is_rating;
                            this.training.ratings = resp.data.data.ratings;
                            this.training.rating_details = resp.data.data.rating_details;
                            // this.training.is_rating = null;
                            this.edit_rate = true;
                            // }


                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            },

            set_my_result(grade) {
                // this.isLoading = true;
                axios({
                    url: '/api/set_result',
                    data: {grade: grade, training_id: this.training.id},
                    method: 'POST'
                })
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            this.training.result = resp.data.data;
                            this.activeTap = 'result';

                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            }
            ,

            onCancel() {
                console.log('User cancelled the loader.')
            }

        }
        ,
        mounted() {
            console.log('Component mounted.')
        }
        ,


    }
</script>

<style>
    .dropdown_animation {
        position: absolute;
        transform: translate3d(0px, 38px, 0px);
        top: 0px;
        left: 0px;
        will-change: transform;
    }
</style>
