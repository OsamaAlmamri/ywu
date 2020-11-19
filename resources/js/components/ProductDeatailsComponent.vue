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

        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('site/images/icons/icon-1.png')"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('site/images/icons/icon-2.png')"></div>
        <div class="circle-one"></div>
        <div class="auto-container">
            <div class="sec-title">
                <h2>{{product.name}}</h2>
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
                                        <li data-tab="#overview" @click="changeActive('overview')"
                                            :class="['tab-btn', {'active-btn':(activeTap=='overview')}]"> التفاصيل
                                        </li>
                                        <li data-tab="#questioins" @click="changeActive('questioins')"
                                            :class="['tab-btn', {'active-btn':(activeTap=='questioins')}]">الاسئلة
                                        </li>
                                        <li data-tab="#reviews" @click="changeActive('reviews')"
                                            :class="['tab-btn', {'active-btn':(activeTap=='reviews')}]">التقييمات
                                        </li>
                                    </ul>

                                    <!--Tabs Container-->
                                    <div class="tabs-content">
                                        <!--Tab / Active Tab-->
                                        <div :class="['tab', {'active-tab':(activeTap=='overview')}]"
                                             id="overview">
                                            <div class="content">

                                                <!-- Cource Overview -->
                                                <div class="course-overview">
                                                    <div class="inner-box">
                                                        <h3>تفاصيل المنتج </h3>
                                                        <div v-html="product.description"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Tab -->
                                        <div class="tab" :class="['tab', {'active-tab':(activeTap=='questioins')}]"
                                             id="questioins">
                                            <div class="content">
                                                <!-- Accordion Box -->
                                                <ul class="accordion-box">
                                                    الاسئلة
                                                </ul>

                                            </div>
                                        </div>
                                        <!-- Tab -->
                                        <div :class="['tab', {'active-tab':(activeTap=='reviews')}]"
                                             id="reviews">
                                            <div class="content">
                                                <div class="row" style="margin:0px 10px 30px;">
                                                    <div class=" col-md-4">
                                                        <div
                                                            class="udlite-heading-xxxl review-summary-widget--average-number--2Q0bz">
                                                            {{product.rating_details.average}}
                                                        </div>
                                                        <p class="review-summary-widget--average-rating-text--2BT9O">
                                                            <rating-stars system="5"
                                                                          :rating="product.rating_details.average"></rating-stars>
                                                            عدد المقيمين {{product.rating_details.sum}}
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
                                                                v-show="product.is_rating!=null"> الغاء
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

                                                        <h4 class="pull-right">
                                                            {{product.is_rating.user_rater.name}} </h4>
                                                    </div>
                                                    <div class="rating">
                                                        <rating-stars :rating="product.is_rating.rating" system="5">
                                                            <span slot="after"> {{product.is_rating.published}}</span>
                                                        </rating-stars>
                                                    </div>
                                                    <div class="text">{{product.is_rating.message}}</div>
                                                    <hr>
                                                </div>


                                                <div v-for="rating in product.ratings" class="cource-review-box">
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
                            <div class="intro-video" style=": "
                                 v-bind:style="{padding:'170px 6px', backgroundImage: 'url('+ product.image + ')' }">
                            </div>

                            <button @click="likePost()"
                                    class="theme-btn btn-style-three" style="margin-top"><span
                                class="txt">
                                 {{(product.is_like==null?'اضافة للمفضلة':'الغاء من المفضلة')}}
                                <i class="fa fa-angle-left"></i>
                            </span></button>

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
                product: {
                    "id": 3,
                    "admin_id": 1,
                    "category_id": 2,
                    "name": "pkpk",
                    "description": "<div id=\"description_body\"></div>",
                    "image_id": 72,
                    "price": 846,
                    "has_attribute": 1,
                    "available": 1,
                    "sort": 2,
                    "status": 1,
                    "created_at": "2020-11-09T22:03:26.000000Z",
                    "updated_at": "2020-11-11T18:31:24.000000Z",
                    "in_cart": 0,
                    "image": "images/media/2020/11/thumbnail1604929449c1liS09104.jpeg",
                    "image_actual": "images/media/2020/11/c1liS09104.jpeg",
                    "zone": "صنعاء / صنعاء",
                    "category": "عطورات",
                    "space": "ihjoihoi",
                    "published": "منذ أسبوع",
                    "average_rating": 5,
                    "count_rating": 1,
                    "percent_rating": 100,
                    "rating_details": {
                        "one": 0,
                        "tow": 0,
                        "three": 0,
                        "four": 0,
                        "five": 100,
                        "sum": 1,
                        "average": 5
                    },
                    "product_options": [
                        {
                            "options_id": 5,
                            "products_options_name": "الوزن",
                            "values": [
                                {
                                    "products_attributes_id": 9,
                                    "options_values_id": 11,
                                    "products_options_values_name": "jo",
                                    "price": "0.00",
                                    "price_prefix": "+",
                                    "is_default": 0
                                }
                            ]
                        },
                        {
                            "options_id": 4,
                            "products_options_name": "الحجماهع",
                            "values": [
                                {
                                    "products_attributes_id": 10,
                                    "options_values_id": 7,
                                    "products_options_values_name": "صغير",
                                    "price": "0.00",
                                    "price_prefix": "+",
                                    "is_default": 0
                                }
                            ]
                        },
                        {
                            "options_id": 1,
                            "products_options_name": "اللون",
                            "values": [
                                {
                                    "products_attributes_id": 11,
                                    "options_values_id": 6,
                                    "products_options_values_name": "احمرni",
                                    "price": "0.00",
                                    "price_prefix": "+",
                                    "is_default": 1
                                },
                                {
                                    "products_attributes_id": 11,
                                    "options_values_id": 2,
                                    "products_options_values_name": "ازرق",
                                    "price": "100.00",
                                    "price_prefix": "-",
                                    "is_default": 0
                                }
                            ]
                        }
                    ],
                    "is_like": null,
                    "defaults_attributes": [
                        {
                            "products_attributes_id": 11,
                            "product_id": 3,
                            "options_id": 1,
                            "options_values_id": 6,
                            "options_values_price": "0.00",
                            "price_prefix": "+",
                            "is_default": 1,
                            "created_at": null,
                            "updated_at": null,
                            "products_options_name": "اللون",
                            "products_options_values_name": "احمرni"
                        }
                    ],
                    "images": [
                        {
                            "id": 4,
                            "product_id": 3,
                            "image_id": 68,
                            "sort": 1,
                            "image": "images/media/2020/11/thumbnail1604929441ujrrh09804.jpg",
                            "image_actual": "images/media/2020/11/ujrrh09804.jpg"
                        }
                    ],
                    "product_questions": [
                        {
                            "id": 3,
                            "product_id": 3,
                            "customers_id": 3,
                            "text": "giug",
                            "question_read": 0,
                            "sort": 1,
                            "status": 0,
                            "created_at": "2020-11-15T22:07:04.000000Z",
                            "updated_at": "2020-11-15T22:07:04.000000Z",
                            "user_name": "صدام حسين",
                            "published": "منذ 3 أيام",
                            "replaies": 1,
                            "products_name": "pkpk",
                            "replies": [
                                {
                                    "id": 1,
                                    "product_question_id": 3,
                                    "replay_user_id": 1,
                                    "text": "zxxxxxxxxxx",
                                    "replay_user_type": "admin",
                                    "created_at": "2020-11-14T15:32:13.000000Z",
                                    "updated_at": "2020-11-14T15:32:13.000000Z",
                                    "user_name": "Osama Mohammed"
                                }
                            ]
                        }
                    ]
                },
                newRating:
                    {
                        product_id: 0,
                        rating: 1,
                        message: '',
                    },
                activeIndex: null,
                activeTap: 'overview',
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
            this.newRating.product_id = this.$route.params.id
            this.fetchTraining();
        },
        computed: {
            show_new_rateForm() {
                return (this.product.is_rating == null || this.edit_rate == true);
            },
            showOldRating() {
                // return false;
                return (this.product.is_rating != null && this.edit_rate == false);
            },
        }
        ,
        methods: {
            valueWidth(i) {
                switch (i) {
                    case 1:
                        return this.product.rating_details.one;
                        break;
                    case 2:
                        return this.product.rating_details.tow;
                        break;
                    case 3:
                        return this.product.rating_details.three;
                        break;
                    case 4:
                        return this.product.rating_details.four;
                        break;
                    case 5:
                        return this.product.rating_details.five;
                        break;

                }
                return this.tr;
            },
            likePost() {
                if (localStorage.token) {
                    axios({
                        url: '/api/like', data: {type: 'product', liked_id: this.product.id},
                        method: 'POST'
                    })
                        .then(resp => {
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                var like = resp.data.data;
                                if (like == 1)
                                    this.product.is_like = {'product_id': '1'};
                                else
                                    this.product.is_like = null;
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
            },
            change_new_rating_val: function (newVal) {
                this.newRating.rating = newVal;
            },
            likeTraining: function (is_like) {
                if (is_like == 1)
                    this.product.is_like = {'id': this.rating.id}
                else
                    this.product.is_like = null;
            },
            onToggle(index) {
                if (this.activeIndex == index) {
                    return (this.activeIndex = null);
                }
                this.activeIndex = index;
            },
            openModal() {
                this.$refs.modal.open();
            },
            changeActive(index) {
                this.activeTap = index;
            },
            reverseKeys(n) {
                return [...Array(n).keys()].slice().reverse()
            },
            edit_rating() {
                this.is_active_dropdown = false;
                this.edit_rate = true;
                this.newRating.rating = this.product.is_rating.rating;
                this.newRating.message = this.product.is_rating.message;

            },
            fetchTraining() {
                this.isLoading = true;
                axios({url: '/api/shop/product_details', data: {product_id: this.course_id}, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.product = resp.data.data;
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        localStorage.removeItem('token')
                        localStorage.removeItem('user')
                        reject(err)
                    })
            },
            rating() {
                this.isLoading = true;
                axios({url: '/api/shop/product_rate2', data: this.newRating, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            // this.product.is_rating = resp.data.data;
                            this.product.is_rating = resp.data.data.is_rating;
                            this.product.ratings = resp.data.data.ratings;
                            this.product.rating_details = resp.data.data.rating_details;
                            this.edit_rate = false;
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            },
            deleteRating() {
                this.isLoading = true;
                axios({url: '/api/training/delete_rate2', data: {id: this.product.is_rating.id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            // if (resp.data.data == 1) {
                            this.product.is_rating = resp.data.data.is_rating;
                            this.product.ratings = resp.data.data.ratings;
                            this.product.rating_details = resp.data.data.rating_details;
                            // this.product.is_rating = null;
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
            onCancel() {
                console.log('User cancelled the loader.')
            }

        }
        ,
        mounted() {
            console.log('Component mounted.')
        },
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
