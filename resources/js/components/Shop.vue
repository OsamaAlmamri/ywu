<template>
    <div>
        <search-filed :append_name="append_name"></search-filed>
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
        <shop-category  :lang="oneLang('ar','en')"></shop-category>
        <div class="sidebar-page-container" style="margin-top:-130">
            <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
                 data-paroller-type="foreground" data-paroller-direction="vertical"
                 style="background-image: url('/site/images/icons/icon-1.png')">
            </div>
            <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
                 data-paroller-type="foreground" data-paroller-direction="vertical"
                 style="background-image: url('/site/images/icons/icon-2.png')">
            </div>
            <div class="circle-one"></div>
            <div class="circle-two"></div>
            <div class="auto-container">
                <div class="search-boxed" v-if="(this.$route.name != 'shop_seller')">
                    <div class="search-box row">
                        <div class=" col-6 col-md-3">
                            <label class="typo__label">{{ $t('shop.govs') }}</label>
                            <multiselect v-model="value" :tag-placeholder="$t('add')"
                                         :placeholder="$t('shop.govs')" :label="oneLang('name_ar','name_en')" track-by="id"
                                         @select="add_gov"
                                         @remove="remove_gov"
                                         :hide-selected="true" :options="govs" :multiple="true"></multiselect>
                        </div>

                        <div class=" col-6 col-md-3">
                            <label class="typo__label">{{ $t('shop.seller') }}</label>
                            <multiselect
                                v-model="seller_value" :tag-placeholder="$t('add')"
                                :placeholder=" $t('shop.seller')" label="sale_name" track-by="admin_id"
                                :hide-selected="true" :options="sellers" :multiple="true"></multiselect>
                        </div>
                        <div class=" col-6 col-md-3">
                            <label class="typo__label"> {{ $t('shop.categories') }} </label>
                            <multiselect v-model="categiries_value" :tag-placeholder="$t('add')"
                                         :placeholder="$t('shop.categories') "
                                         :label="oneLang('name','name_en')"
                                         track-by="id"
                                         :hide-selected="true" :options="categories" :multiple="true"></multiselect>
                        </div>
                        <div class=" col-6 col-md-3 ">
                            <div class="input-group-append" style="margin-top: 30px;">
                                <button class="btn btn-primary" style="padding: 7px 58px;"
                                        @click.prevent="get_product_by_categories22()"> {{ $t('filter') }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row clearfix">
                    <div class="content-side col-lg-12 col-md-12 col-sm-12">
                        <div class="our-courses" v-for="section in sections">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix" v-if="section.products2.length>0">
                                    <div class="pull-right">
                                        <router-link :to="{ name: 'CategoryProducts', params: { id: section.id}}"
                                                     @click.native="scrollToTop()">
                                            <h3 style="padding: 5px 50px; direction: inherit">{{oneLang( section.name , section.name_en)}}</h3>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <swiper :ref="'flickity'+section.id" :options="swiperOption">
                                <swiper-slide class="swiper-slide" v-for="product in section.products2"
                                              :key="product.id">
                                    <shop-gide-item2 :key="'shp-'+product.id"
                                                     :product="product">
                                    </shop-gide-item2>
                                </swiper-slide>
                            </swiper>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import CourseGideItem from './CourseGideItem.vue';
import Multiselect from 'vue-multiselect'
import {Swiper, SwiperSlide, directive} from 'vue-awesome-swiper'

// import style (>= Swiper 6.x)
import 'swiper/swiper-bundle.css'

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import ShopGideItem2 from './ShopGideItem2';

export default {
    props: ['items'],
    components: {
        Swiper, SwiperSlide, Multiselect, ShopGideItem2, Loading
    },

    data() {
        return {
            swiperOption: {
                slidesPerView: 7,
                spaceBetween: 5,
                grabCursor: true,
                // centeredSlides: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },

                breakpoints: {
                    1024: {
                        slidesPerView: 7,
                        spaceBetween: 5
                    },
                    768: {
                        slidesPerView: 5,
                        spaceBetween: 5
                    },
                    640: {
                        slidesPerView: 4,
                        spaceBetween: 5
                    },
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 5
                    }
                },

            },
            isLoading: false,
            fullPage: true,
            activeIndex: null,
            categories: [],
            is_search: false,
            search_data: '',
            append_name: null,
            search_result: [],
            sections: [],
            course_id: '',
            pagination: {},
            edit: false,
            govs: [],
            value: [],
            seller_value: [],
            sellers: [],
            form: {
                "categories": [],
                "seller_id": [],
                "govs": []
            },
            categiries_value: [],
            options: []
        }
    },
    created() {

        if (this.$route.name != 'shop_search')
            this.get_product_by_categories22();
        if (this.$route.name == 'shop_seller')
            this.get_seller_name();
        else {
            this.get_gov();
            this.gov_sellers();
            this.all_categories();
        }

    },
    computed: {},
    methods: {
        remove(array, element) {
            const index = array.indexOf(element);
            array.splice(index, 1);
        },
        add_gov(gov) {

            this.form.govs.push(gov.id);
            this.gov_sellers();
        },
        remove_gov(gov) {
            this.remove(this.form.govs, gov.id);
            this.gov_sellers();
            for (let i = 0; i < this.seller_value.length; i++) {
                let obj = this.seller_value.find(x => x.id == gov.id);
                let index = this.seller_value.indexOf(obj);
                this.seller_value.splice(index, 1);
            }

        },
        addTag(newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(tag)
            this.value.push(tag)
        },
        all_categories() {
            axios({url: '/api/shop/all_categories', method: 'POST'})
                .then(resp => {
                    this.categories = (resp.data.data);
                })
                .catch(err => {
                    console.log(err)
                })
        },
        gov_sellers() {
            axios({url: '/api/shop/gov_sellers', data: {govs: this.form.govs}, method: 'POST'})
                .then(resp => {
                    this.sellers = (resp.data.data);
                })
                .catch(err => {
                    console.log(err)
                })
        },

        get_gov() {
            axios({url: '/api/get_gov', method: 'POST'})
                .then(resp => {
                    this.govs = (resp.data.data);
                    // this.form.gov_id = this.govs[0].id;
                })
                .catch(err => {
                    console.log(err)
                })
        },
        get_seller_name() {
            axios({url: '/api/shop/seller_name', data: {id: this.$route.params.id}, method: 'POST'})
                .then(resp => {
                        if (resp.data.status == false)
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        else
                            this.append_name = (resp.data.data.sale_name);
                    }
                )
                .catch(err => {
                    console.log(err)
                })
        },
        get_product_by_categories22() {
            this.form.seller_id = [];
            this.form.categories = [];
            for (let i = 0; i < this.seller_value.length; i++) {
                this.form.seller_id.push(this.seller_value[i].admin_id);
            }
            for (let i = 0; i < this.categiries_value.length; i++) {
                this.form.categories.push(this.categiries_value[i].id);
            }
            if (this.$route.name == 'shop_seller')
                this.form.seller_id.push(this.$route.params.id);

            if (this.is_search == false) {
                this.is_search = true;
                this.isLoading = true;
                axios({
                    url: '/api/shop/get_product_by_categories33',
                    data: this.form,
                    method: 'POST'
                })
                    .then(resp => {
                        this.sections = (resp.data.data);
                        this.isLoading = false;
                        this.is_search = false;
                    }).then(response => {
                    this.$nextTick(function () { // the magic
                        // this.$refs.flickity_categories.rerender()
                        // for (var i = 0; i < this.sections.length; i++)
                        // this.refs["flickity" + this.sections[i].id].rerender();
                        // this.refs["flickity" + this.sections[i].id].$swiper.slideTo(3, 1000, false)
                    })
                }).catch(err => {
                    this.isLoading = false;
                    this.is_search = false;
                    console.log(err)
                })
            }

        },
        onCancel() {
        }

    },
    mounted() {
    },


}
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

