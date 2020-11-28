<template>
    <div>
        <search-filed v-on:search_result="setSearchResult"></search-filed>
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
        <shop-category></shop-category>
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
                <div class="row clearfix">
                    <div class="content-side col-lg-12 col-md-12 col-sm-12">
                        <div v-if="is_search==false" class="our-courses" v-for="section in sections">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix" v-if="section.products.length>0">
                                    <div class="pull-right">
                                        <h3 style="    background: #593c97;
    padding: 5px 50px;
    color: white;">{{section.name}}</h3>
                                    </div>
                                </div>
                            </div>
                            <flickity v-if="section.products.length>=4" :ref="'flickity'+section.id"
                                      :options="flickityOptions_products">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12" v-for="product in section.products">
                                    <shop-gide-item
                                        :product="product"
                                        @toggled="onToggle">

                                    </shop-gide-item>
                                </div>
                            </flickity>

                            <div class="row" v-if="section.products.length<4">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12" v-for="product in section.products">
                                    <shop-gide-item
                                        :product="product"
                                        @toggled="onToggle"
                                    ></shop-gide-item>
                                </div>
                            </div>
                        </div>
                        <div v-if="is_search==true" class="our-courses">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <h3> نتائج البحث عن "{{search_data}}"</h3>
                                    </div>
                                    <div class="pull-left">
                                        <button class="btn btn-info" @click="is_search=false">اغلاق نتائج البحث</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="cource-block-two col-lg-3 col-md-4 col-sm-6 col-xs-12"
                                     v-for="training in search_result">
                                    <shop-gide-item
                                        :training="training"
                                        @toggled="onToggle"
                                    ></shop-gide-item>
                                </div>
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
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import Flickity from 'vue-flickity';
    import ShopGideItem from './ShopGideItem';
    import axios from "axios";

    export default {
        props: ['items'],
        components: {CourseGideItem, ShopGideItem, Loading, Flickity},
        data() {
            return {
                flickityOptions: {
                    initialIndex: 0,
                    // rightToLeft: true,
                    // groupCells: 1,
                    // rightToLeft: true,
                    // freeScroll: true,
                    cellAlign: 'center',
                    // contain: true,
                    freeScroll: true,
                    // contain: true,
                    lazyLoad: true,
                    autoPlay: 5000,
                    resize: true,
                    prevNextButtons: true,
                    groupCells: true,
                    pageDots: false,
                    // wrapAround: true

                    // any options from Flickity can be used
                },
                flickityOptions_products: {
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
                categories:[],
                isLoading: false,
                fullPage: true,
                activeIndex: null,
                sections: [
                    // {
                    //     id: 1,
                    //     name: 'اشغال يدوية',
                    //     image: 'site/images/categories/handsewing.png',
                    //     products: [
                    //         {
                    //             id: 1,
                    //             price: 10000,
                    //             rating_avg: 2,
                    //             name: "بالطو تشكيلة جديدة وجودة عالية",
                    //             image: 'site/images/products/i8.jpg',
                    //             is_like: false,
                    //         },
                    //         {
                    //             id: 2,
                    //             price: 10000,
                    //             rating_avg: 5,
                    //             name: "بالطو  جديد تشكيلة هندي ",
                    //             image: 'site/images/products/i5.jpg',
                    //             is_like: false,
                    //         }]
                    // },
                    // {
                    //     id: 2,
                    //     name: ' ملابس نسائية ',
                    //     image: 'site/images/categories/womencoat.png',
                    //     products: [
                    //         {
                    //             id: 1,
                    //             price: 10000,
                    //             rating_avg: 2,
                    //             name: "بالطو تشكيلة جديدة وجودة عالية",
                    //             image: 'site/images/products/i8.jpg',
                    //             is_like: false,
                    //         },
                    //         {
                    //             id: 2,
                    //             price: 10000,
                    //             rating_avg: 5,
                    //             name: "بالطو  جديد تشكيلة هندي ",
                    //             image: 'site/images/products/i5.jpg',
                    //             is_like: false,
                    //         },
                    //         {
                    //             id: 1,
                    //             price: 10000,
                    //             rating_avg: 2,
                    //             name: "بالطو تشكيلة جديدة وجودة عالية",
                    //             image: 'site/images/products/i8.jpg',
                    //             is_like: false,
                    //         },
                    //         {
                    //             id: 2,
                    //             price: 10000,
                    //             rating_avg: 5,
                    //             name: "بالطو  جديد تشكيلة هندي ",
                    //             image: 'site/images/products/i5.jpg',
                    //             is_like: false,
                    //         },
                    //         {
                    //             id: 3,
                    //             price: 10000,
                    //             rating_avg: 2,
                    //             name: "بالطو تشكيلة جديدة وجودة عالية",
                    //             image: 'site/images/products/i8.jpg',
                    //             is_like: false,
                    //         },
                    //         {
                    //             id: 4,
                    //             price: 10000,
                    //             rating_avg: 5,
                    //             name: "بالطو  جديد تشكيلة هندي ",
                    //             image: 'site/images/products/i5.jpg',
                    //             is_like: false,
                    //         },
                    //
                    //     ]
                    // },
                    // {
                    //     id: 3,
                    //     name: '  ازياء شعبية ',
                    //     image: 'site/images/categories/myanmar.png',
                    //     products: [
                    //         {
                    //             id: 1,
                    //             price: 10000,
                    //             rating_avg: 2,
                    //             name: "زي صنعاني نسائي لون اسود",
                    //             image: 'site/images/products/i4.jpeg',
                    //             is_like: false,
                    //         },
                    //         {
                    //             id: 2,
                    //             price: 10000,
                    //             rating_avg: 5,
                    //             name: "زي صنعاني نسائي لون احمر",
                    //             image: 'site/images/products/i2.jpeg',
                    //             is_like: false,
                    //         }, {
                    //             id: 3,
                    //             price: 10000,
                    //             rating_avg: 2,
                    //             name: "زي تهامي للاعراس",
                    //             image: 'site/images/products/i3.jpeg',
                    //             is_like: false,
                    //         },
                    //         {
                    //             id: 4,
                    //             price: 10000,
                    //             rating_avg: 5,
                    //             name: "بالطو  جديد تشكيلة هندي ",
                    //             image: 'site/images/products/i5.jpg',
                    //             is_like: false,
                    //         },
                    //
                    //     ]
                    // },
                ],
                is_search: false,
                search_data: '',
                search_result: [],
                course_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {
            // this.fetchArticles();
            this.get_product_by_categories();
            this.all_categories();
        },
        methods: {
            next(c_flickity) {
                this.refs[c_flickity].next();
            },

            previous(c_flickity) {
                this.refs[c_flickity].previous();
            },
            onToggle(index) {
                if (this.activeIndex == index) {
                    return (this.activeIndex = null);
                }
                this.activeIndex = index;
            },
            setSearchResult(data) {

                this.is_search = true;
                this.search_data = data.title;
                this.search_result = data.data;
            },

            get_product_by_categories() {
                axios({url: '/api/shop/get_product_by_categories', method: 'POST'})
                    .then(resp => {
                        this.sections = (resp.data.data);
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            all_categories() {
                axios({url: '/api/shop/all_categories', method: 'POST'})
                    .then(resp => {
                        this.categories = (resp.data.data);
                    }).then(response => {
                    this.$nextTick(function () { // the magic
                        this.$refs.flickity_categories.rerender()
                    })
                })
                    .catch(err => {
                        console.log(err)
                    })
            },
            onCancel() {
                console.log('User cancelled the loader.')
            }

        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>


<style>
    .flickity-button:disabled {
        display: none;
    }

</style>
