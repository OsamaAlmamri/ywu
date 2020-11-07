<template>
    <div>
        <search-filed v-on:search_result="setSearchResult"></search-filed>
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

        <div class="sidebar-page-container">
            <div class="row clearfix" style="text-align: center">
                <div  class="content-side col-lg-12 col-md-12 col-sm-12"
                     style="text-align: center">
                    <flickity ref="flickity_categories" :options="flickityOptions">
                        <router-link  @click.native="scrollToTop()"  to="/ShopCategory" v-for="category in categories"
                             class="col-4 col-sm-3 col-md-2 col-lg-1">

                            <div class="category_image_box">
                                <img class=" img-fluid category_image"
                                     :data-flickity-lazyload="category.image"
                                     :src="category.image">
                            </div>
                            <p class="category_name"> {{category.name}} </p>
                        </router-link>
                    </flickity>

                </div>


            </div>
        </div>
        <div class="sidebar-page-container">
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
                                        <h3 style="    background: #68a15d;
    padding: 5px 50px;
    color: white;">{{section.name}}</h3>
                                    </div>
                                </div>
                            </div>
                            <flickity :ref="'flickity'+section.id" :options="flickityOptions_products">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-6" v-for="training in section.products">
                                    <shop-gide-item
                                        :training="training"
                                        @toggled="onToggle"
                                    ></shop-gide-item>
                                </div>
                            </flickity>
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

    export default {
        props: ['items'],
        components: {CourseGideItem, ShopGideItem, Loading, Flickity},
        data() {
            return {
                flickityOptions: {
                    initialIndex: 0,
                    rightToLeft: true,
                    // freeScroll: true,
                    contain: true,
                    lazyLoad: true,
                    autoPlay: 5000,
                    resize: true,
                    prevNextButtons: true,
                    groupCells: 1,
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
                categories: [
                    {
                        id: 1,
                        name: 'اشغال يدوية',
                        image: 'site/images/categories/handsewing.png',
                    },
                    {
                        id: 2,
                        name: ' ملابس نسائية ',
                        image: 'site/images/categories/womencoat.png',
                    },
                    {
                        id: 3,
                        name: '  ازياء شعبية ',
                        image: 'site/images/categories/myanmar.png',
                    },
                    {
                        id: 4,
                        name: '  اكسسوارات  ',
                        image: 'site/images/categories/necklace.png',
                    },
                    {
                        id: 5,
                        name: '  عطور  ',
                        image: 'site/images/categories/perfume.png',
                    },
                    {
                        id: 6,
                        name: '  مستحضرات تجميل  ',
                        image: 'site/images/categories/cosmetics.png',
                    },
                    {
                        id: 7,
                        name: '  صنائع غذائية  ',
                        image: 'site/images/categories/manufacturing.png',
                    },
                ],
                isLoading: false,
                fullPage: true,
                activeIndex: null,
                sections: [
                    {
                        id: 1,
                        name: 'اشغال يدوية',
                        image: 'site/images/categories/handsewing.png',
                        products: [
                            {
                                id: 1,
                                price: 10000,
                                rating_avg: 2,
                                name: "بالطو تشكيلة جديدة وجودة عالية",
                                image: 'site/images/products/i8.jpg',
                                is_like: false,
                            },
                            {
                                id: 2,
                                price: 10000,
                                rating_avg: 5,
                                name: "بالطو  جديد تشكيلة هندي ",
                                image: 'site/images/products/i5.jpg',
                                is_like: false,
                            }]
                    },
                    {
                        id: 2,
                        name: ' ملابس نسائية ',
                        image: 'site/images/categories/womencoat.png',
                        products: [
                            {
                                id: 1,
                                price: 10000,
                                rating_avg: 2,
                                name: "بالطو تشكيلة جديدة وجودة عالية",
                                image: 'site/images/products/i8.jpg',
                                is_like: false,
                            },
                            {
                                id: 2,
                                price: 10000,
                                rating_avg: 5,
                                name: "بالطو  جديد تشكيلة هندي ",
                                image: 'site/images/products/i5.jpg',
                                is_like: false,
                            },
                            {
                                id: 1,
                                price: 10000,
                                rating_avg: 2,
                                name: "بالطو تشكيلة جديدة وجودة عالية",
                                image: 'site/images/products/i8.jpg',
                                is_like: false,
                            },
                            {
                                id: 2,
                                price: 10000,
                                rating_avg: 5,
                                name: "بالطو  جديد تشكيلة هندي ",
                                image: 'site/images/products/i5.jpg',
                                is_like: false,
                            },
                            {
                                id: 3,
                                price: 10000,
                                rating_avg: 2,
                                name: "بالطو تشكيلة جديدة وجودة عالية",
                                image: 'site/images/products/i8.jpg',
                                is_like: false,
                            },
                            {
                                id: 4,
                                price: 10000,
                                rating_avg: 5,
                                name: "بالطو  جديد تشكيلة هندي ",
                                image: 'site/images/products/i5.jpg',
                                is_like: false,
                            },

                        ]
                    },
                    {
                        id: 3,
                        name: '  ازياء شعبية ',
                        image: 'site/images/categories/myanmar.png',
                        products: [
                            {
                                id: 1,
                                price: 10000,
                                rating_avg: 2,
                                name: "زي صنعاني نسائي لون اسود",
                                image: 'site/images/products/i4.jpeg',
                                is_like: false,
                            },
                            {
                                id: 2,
                                price: 10000,
                                rating_avg: 5,
                                name: "زي صنعاني نسائي لون احمر",
                                image: 'site/images/products/i2.jpeg',
                                is_like: false,
                            }, {
                                id: 3,
                                price: 10000,
                                rating_avg: 2,
                                name: "زي تهامي للاعراس",
                                image: 'site/images/products/i3.jpeg',
                                is_like: false,
                            },
                            {
                                id: 4,
                                price: 10000,
                                rating_avg: 5,
                                name: "بالطو  جديد تشكيلة هندي ",
                                image: 'site/images/products/i5.jpg',
                                is_like: false,
                            },

                        ]
                    },
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
            fetchArticles() {
                let vm = this;
                // fetch('/api/showTrainingByCategory', {
                //     method: 'post',
                //     headers: {
                //         Authorization: 'Bearer ' + localStorage.getItem('token'),
                //         'content-type': 'application/json'
                //     }
                // })
                this.isLoading = true;
                axios.post('/api/showTrainingByCategory', {
                        headers: {
                            'content-type': 'application/json',
                            // Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    },
                ).then(res => {
                    this.sections = res.data.Trainings;
                    this.isLoading = false;
                })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    });
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
