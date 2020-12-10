<template>
    <div>
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
        <div class="sidebar-page-container" style=" margin-top:-130">
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
                        <div class="our-courses all_cat_products">
                            <!-- Options View -->
                            <shop-gide-item2 v-for="product in products.data"
                                             :product="product">
                            </shop-gide-item2>


                        </div>
                        <div class="styled-pagination">
                            <pagination
                                :align="'right'"
                                :show-disabled=true
                                @pagination-change-page="get_category_products"
                                :data="products">
                                <span slot="prev-nav">&lt;&lt; </span>
                                <span slot="next-nav"> &gt;&gt;</span>
                            </pagination>
                        </div>
                        <div style="text-align: center" v-show="products.data.length<1">
                            <img style="width: 35%;margin-top: -150px;" src="/site/images/img-no-products.png">
                            <h4>
                                ليس هناك اي منتجات بهذ التصنيف
                            </h4>
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
    import ShopGideItem2 from './ShopGideItem2';
    import axios from "axios";

    export default {
        props: ['items'],
        components: {ShopGideItem2, Loading},
        data() {
            return {

                isLoading: false,
                fullPage: true,
                activeIndex: null,
                products: {},
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
            this.get_category_products();
        },
        methods: {
            setSearchResult(data) {

                this.is_search = true;
                this.search_data = data.title;
                this.search_result = data.data;
            },

            get_category_products(page = 1) {
                this.isLoading = true;
                axios({
                    url: '/api/shop/get_category_products?page=' + page,
                    data: {category_id: this.$route.params.id},
                    method: 'POST'
                })
                    .then(resp => {
                        this.products = (resp.data.data);
                        this.isLoading = false;
                    })
                    .catch(err => {
                        console.log(err)
                        this.isLoading = false;
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
