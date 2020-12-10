<template>
    <section class="intro-section">
        <loading :active.sync="isLoading"
                 :can-cancel=false
                 :color="'#593c97'"
                 :loader="'dots'"
                 :background-color="'#f8f9fa'"
                 :height='200'
                 :width='140'
                 :on-cancel="onCancel()"
                 :is-full-page="fullPage">
        </loading>
        <sweet-modal :title="'تعديل السؤال'"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="edit_ques">
            <div class="row clearfix">
                <div class="form-group" style="width: 100%">
                    <fieldset class="the-fieldset">
                        <legend class="the-legend"> تعديل السؤال</legend>
                        <div class="input-group mb-3">
                            <textarea style="width: 100%" rows="3" class=""
                                      v-model="edit_question_data.text"></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-info"
                                        @click.prevent="updateQuestion()">
                                    حفظ التعديل
                                </button>
                            </div>
                            <div class="input-group-append">
                                <button v-if="edit==true" class="btn btn-secondary"
                                        @click.prevent="CancelUpdate()">الغاء التعديل
                                </button>


                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
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
                                                    <div class="inner-box product-page">
                                                        <form name="attributes" id="add-Product-form" method="post">
                                                            <div>
                                                                <h3>{{product.name}}</h3>
                                                                <p><strong>السعر </strong> {{calculatePrice}} ر.ي</p>
                                                                <p>
                                                                    <router-link @click.native="$scrollToTop"
                                                                                 :to="{ name: 'shop_seller', params: { id: product.admin_id}}">

                                                                        <img style="width: 31px;border-radius: 50px;"
                                                                             :src="product.sell_icon">
                                                                        <span>  {{product.sell_name}}    </span>
                                                                    </router-link>
                                                                </p>
                                                                <p>
                                                                    <i class="fa fa-map-marker "></i>
                                                                    {{product.zone}}/ {{product.space}}
                                                                </p>
                                                            </div>
                                                            <div class="pro-options row">
                                                                <div class="attributes col-12 col-md-4 box"
                                                                     v-for="(products_option,key) in product.product_options">
                                                                    <label class="">{{products_option.products_options_name}}</label>
                                                                    <div class="select-control">
                                                                        <select v-on:change="change_attribute(key)"
                                                                                v-model="selected_product_attributes[key]"
                                                                                class="currentstock form-control">
                                                                            <option
                                                                                v-for="products_option_val in products_option.values"
                                                                                :value="products_option_val">
                                                                                {{products_option_val.products_options_values_name}}
                                                                            </option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pro-counter">
                                                                <div class="input-group item-quantity">
                                                                    <h4>الكمية : </h4>
                                                                    <input type="number" name="quantity"
                                                                           class="form-control qty"
                                                                           min="1"
                                                                           v-model="cart_item.quantity">
                                                                    <span class="input-group-btn">
                                                                        <button type="button"
                                                                                class="quantity-plus1 btn qtyplus"
                                                                                @click="change_quantity('+')"><i
                                                                            class="fa fa-plus"></i></button>
                                                                        <button type="button"
                                                                                class="quantity-minus1 btn qtyminus"
                                                                                @click="change_quantity('-')"><i
                                                                            class="fa fa-minus"></i></button></span>
                                                                </div>
                                                            </div>
                                                            <button v-if="product.available==1"
                                                                    @click="addToCart()"
                                                                    class="btn btn-secondary btn-lg swipe-to-top  add-to-Cart stock-cart"
                                                                    type="button" products_id="3">
                                                                اضافة الى السلة
                                                            </button>
                                                            <button v-if="product.available==0"
                                                                    class="btn btn-danger btn btn-lg swipe-to-top  stock-out-cart"
                                                                    type="button">المنتج غير متوفر حاليا
                                                            </button>
                                                        </form>
                                                        <hr>
                                                        <h3>وصف المنتج </h3>
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
                                                <div class="row new_rating_dev ">
                                                    <fieldset class="the-fieldset new_rating_dev"
                                                              style="border: 1px solid #e0e0e0; padding: 10px;">
                                                        <legend class="the-legend"> اضافة سؤال جديد</legend>
                                                        <div class="form-group" style="width: 100%">
                                                            <fieldset class="the-fieldset">
                                                                <legend class="the-legend">نص السؤال</legend>
                                                                <textarea style="width: 100%" rows="4" class=""
                                                                          v-model="newQuestion.text"></textarea>
                                                            </fieldset>
                                                        </div>
                                                        <button class="btn btn-primary" @click="add_new_question()">
                                                            اضافة
                                                        </button>

                                                    </fieldset>
                                                </div>

                                                <product-question
                                                    v-for="(product_question,key) in  product.product_questions"
                                                    v-on:edit_question="edit_question"
                                                    v-on:delete_question="delete_question"
                                                    :_key="key"
                                                    :key="key"
                                                    :product_question="product_question">
                                                </product-question>

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
                            <flickity :ref="'flickity_product_detail'" :options="flickity_product_detail">

                                <div class="col-12">
                                    <div class="category_image_box">
                                        <div class="thumbnail">
                                            <div class="thumb">
                                                <a v-bind:href="product.image_actual"
                                                   data-lightbox="1" data-title="">
                                                    <img class="img-thumbnail img-fluid category_image"
                                                         :data-flickity-lazyload="BaseImagePath+product.image_actual"
                                                         :src="BaseImagePath+product.image_actual">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-for="image in product.images" class="col-12">
                                    <div class="category_image_box">
                                        <img class=" img-fluid category_image"
                                             :data-flickity-lazyload="BaseImagePath+image.image_actual"
                                             :src="BaseImagePath+image.image_actual">
                                    </div>
                                </div>
                            </flickity>

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
    import ProductQuestion from "./ProductQuestion";
    import LikeButton from "./LikeButton";
    import Flickity from "vue-flickity";

    export default {
        props: ['items'],
        // components: {question},
        components: {RatingStars2, Loading, RatingStars, LikeButton, Flickity, ProductQuestion},

        data() {
            return {
                flickity_product_detail: {
                    initialIndex: 0,
                    // rightToLeft: true,
                    // groupCells: 1,
                    freeScroll: true,
                    // contain: true,
                    lazyLoad: true,
                    autoPlay: 5000,
                    resize: true,
                    prevNextButtons: true,
                    groupCells: true,
                    pageDots: false,
                    wrapAround: true

                    // any options from Flickity can be used
                },
                isLoading: false,
                edit_rate: false,
                fullPage: true,
                attributes_price: 0,
                is_active_dropdown: false,
                cart_item: {
                    quantity: 1,
                    product_id: this.$route.params.id,
                    product_attributes: [],
                },
                product: {},
                newRating:
                    {
                        product_id: 0,
                        rating: 1,
                        message: '',
                    },
                newQuestion:
                    {
                        product_id: this.$route.params.id,
                        text: '',
                    },
                edit_question_data:
                    {
                        product_question_id: 0,
                        key: 0,
                        text: '',
                    },
                activeIndex: null,
                activeTap: 'overview',
                selected_product_attributes: [],
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
            calculatePrice() {
                this.attributes_price = 0;
                for (let i = 0; i < this.selected_product_attributes.length; i++) {
                    if (this.selected_product_attributes[i].price_prefix == "+")
                        this.attributes_price += parseInt(this.selected_product_attributes[i].price);
                    else
                        this.attributes_price -= parseInt(this.selected_product_attributes[i].price);
                }
                return (this.product.price + this.attributes_price) * this.cart_item.quantity;
            },

            show_new_rateForm() {
                return (this.product.is_rating == null || this.edit_rate == true);
            },
            showOldRating() {
                // return false;
                return (this.product.is_rating != null && this.edit_rate == false);
            },
        },
        methods: {
            delete_question(key) {
                this.isLoading = true;
                let id = this.product.product_questions[key].id;
                axios({url: '/api/shop/deleteQuestion', data: {product_question_id: id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.product.product_questions.splice(key, 1);
                            toastStack('تم الحذف بنجاح', '', 'success');
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            },
            edit_question(key) {
                this.edit_question_data.key = key;
                this.edit_question_data.product_question_id = this.product.product_questions[key].id;
                this.edit_question_data.text = this.product.product_questions[key].text;
                this.$refs.edit_ques.open();
            },
            CancelUpdate() {
                this.$refs.edit_ques.close();

            },
            updateQuestion() {
                if (localStorage.token) {
                    axios({
                        url: '/api/shop/updateQuestion', data: this.edit_question_data,
                        method: 'POST'
                    })
                        .then(resp => {
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                toastStack(resp.data.msg, '', 'success');
                                this.product.product_questions[this.edit_question_data.key].text = this.edit_question_data.text;
                                this.$refs.edit_ques.close();
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
            },
            change_quantity(type) {

                if (type == "+")
                    this.cart_item.quantity++;
                else {
                    if (this.cart_item.quantity > 1)
                        this.cart_item.quantity--;
                }
            },
            change_attribute(key) {
                this.cart_item.product_attributes[key] = this.selected_product_attributes[key].products_attributes_id;
            },
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
            addToCart() {
                if (localStorage.token) {
                    axios({
                        url: '/api/shop/add_to_cart', data: this.cart_item,
                        method: 'POST'
                    })
                        .then(resp => {
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                var cart = resp.data.data;
                                if (cart == 0)
                                    toastStack('   خطاء ', "المنتج موجود مسبقا بالسلة", 'error');
                                else {
                                    toastStack('   تم الاضافة الى السلة بنجاح ', '', 'success');
                                    // const user = JSON.stringify(resp.data.data.userData)
                                }
                                // this.product.in.is_like = null;
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
                            let product_options = resp.data.data.product_options;
                            console.log("product_options");
                            console.log(product_options);
                            if (product_options.length > 0) {
                                console.log('cccccccccoooo');
                                for (let i = 0; i < product_options.length; i++) {
                                    console.log('ccccccccc' + i);
                                    this.selected_product_attributes.push(product_options[i].values[0]);
                                    this.cart_item.product_attributes.push(product_options[i].values[0].products_attributes_id);
                                    if (product_options[i].values[0].price_prefix == "+")
                                        this.attributes_price += parseInt(product_options[i].values[0].price);
                                    else
                                        this.attributes_price -= parseInt(product_options[i].values[0].price);

                                }
                            }


                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        localStorage.removeItem('token')
                        localStorage.removeItem('user')
                        reject(err)
                    })
            },
            add_new_question() {
                this.isLoading = true;
                axios({url: '/api/shop/addQuestion', data: this.newQuestion, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            this.newQuestion.text = " ";
                            // this.product.is_rating = resp.data.data;
                            this.product.product_questions.unshift(resp.data.data);
                            this.edit_rate = false;
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
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
