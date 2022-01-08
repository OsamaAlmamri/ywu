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

                 :is-full-page="fullPage">
        </loading>
        <shop-category :lang="oneLang('ar','en')"></shop-category>
        <div style="margin-top:-130">
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
                <div class="row clearfix">
                    <div class="content-side col-lg-12 col-md-12 col-sm-12">
                        <div class="our-courses" v-for="section in sections">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix" v-if="section.products.length>0">
                                    <div class="d-flex justify-content-start mx-5">

                                        <h3> {{ oneLang(section.name_ar, section.name_en) }}</h3>

                                    </div>
                                </div>
                            </div>
                            <!--                            <swiper :ref="'flickity'+section.type" :options="swiperOption">-->
                            <!--                                <swiper-slide class="swiper-slide" v-for="product in section.products"-->
                            <!--                                              :key="product.id">-->
                            <!--                                    <shop-gide-item2 :key="'shp-'+product.id"-->
                            <!--                                                     :product="product">-->
                            <!--                                    </shop-gide-item2>-->
                            <!--                                </swiper-slide>-->
                            <!--                            </swiper>-->

                            <div class="d-flex align-content-around flex-wrap">
                                <shop-gide-item2 v-for="product in section.products"  :key="'shp-'+product.id"
                                                 :product="product">
                                </shop-gide-item2>
                            </div>
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
            //random,rating,new,most_sales
            sections: [
                {
                    type: "random",
                    name_ar: "منتجات مقترحة لك ",
                    name_en: "Suggested products for you",
                    products: [],
                },
                {
                    type: "rating",
                    name_ar: "المنتجات الاكثر تقييما ",
                    name_en: "Most  Suggest for You",
                    products: [],
                },
                {
                    type: "new",
                    name_ar: "المنتجات  الجديدة ",
                    name_en: "new Products",
                    products: [],
                },
                {
                    type: "most_sales",
                    name_ar: "المنتجات الاكثر مبيعا ",
                    name_en: "most selling products",
                    products: [],
                }
            ],
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
        this.get_product_type(0)
        this.get_product_type(1)
        this.get_product_type(2)
        this.get_product_type(3)


    },
    computed: {},
    methods: {
        all_categories() {
            axios({url: '/api/shop/all_categories', method: 'POST'})
                .then(resp => {
                    this.categories = (resp.data.data);
                })
                .catch(err => {
                    console.log(err)
                })
        },
        get_product_type(type) {
            this.is_search = true;
            this.isLoading = true;
            axios({
                url: '/api/shop/get_products_by_type',
                data: {type: this.sections[type].type},
                method: 'POST'
            })
                .then(resp => {
                    this.sections[type].products = (resp.data.data.data);
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


        },
    },
    mounted() {
    },


}
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

