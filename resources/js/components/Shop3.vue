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


        <main class="content">

            <section data-animated-id="2">
                <div class="container container-xl">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <p class="fs-18 font-weight-500 my-lg-0 my-2" style="color: #696969;">We found <strong
                            class="font-weight-bold text-secondary">95</strong>
                            products available for you</p>
                        <div class="d-flex align-items-center">
                            <div class="switch-layout d-lg-flex align-items-center d-none">
                                <span class="pr-5">See</span>
                                <a href="#" class="active pr-5" title="Grid View">
                                    <svg class="icon icon-squares-four fs-32 hover-secondary">
                                        <use xlink:href="#icon-squares-four"></use>
                                    </svg>
                                </a>
                                <a href="shop-page-05.html" title="List View">
                                    <svg class="icon icon-list fs-32 hover-secondary">
                                        <use xlink:href="#icon-list"></use>
                                    </svg>
                                </a>
                            </div>
                            <div class="dropdown show lh-1 rounded ml-lg-5 ml-0"
                                 style="background-color:#f5f5f5">
                                <a href="#"
                                   class="dropdown-toggle custom-dropdown-toggle text-decoration-none text-secondary p-3 mw-210 position-relative d-block"
                                   id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    Default Sorting
                                </a>
                                <div class="dropdown-menu custom-dropdown-item"
                                     aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Price high to low</a>
                                    <a class="dropdown-item" href="#">Price low to high</a>
                                    <a class="dropdown-item" href="#">Random</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mt-7 pb-11 pb-lg-13" data-animated-id="3">
                <div class="container container-xl">
                    <div class="row">
                        <div class="col-lg-3 primary-sidebar sidebar-sticky pr-lg-8 d-lg-block d-none"
                             id="sidebar">
                            <div class="primary-sidebar-inner"
                                 style="position: static; left: auto; width: 236px;">
                                <div class="card border-0 mb-6">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <h4 class="card-title fs-20 mb-3">Categories</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <a href="#"
                                                   class="text-uppercase fs-14 letter-spacing-005 font-weight-600 text-body hover-secondary text-decoration-none">BODY
                                                    CARE</a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#"
                                                   class="text-uppercase fs-14 letter-spacing-005 font-weight-600 text-body hover-secondary text-decoration-none">Skin
                                                    care</a>
                                                <ul class="list-unstyled ml-5 mt-2 mb-5">
                                                    <li class="mb-1">
                                                        <a href="#"
                                                           class="text-body hover-secondary">Cleanser</a>
                                                    </li>
                                                    <li class="mb-1">
                                                        <a href="#" class="text-body hover-secondary">Toner</a>
                                                    </li>
                                                    <li class="mb-1">
                                                        <a href="#" class="text-body hover-secondary">Scrubs
                                                            &amp; Masks</a>
                                                    </li>
                                                    <li class="mb-1">
                                                        <a href="#" class="text-body hover-secondary">Serum</a>
                                                    </li>
                                                    <li class="mb-1">
                                                        <a href="#" class="text-body hover-secondary">Face
                                                            Oils</a>
                                                    </li>
                                                    <li class="mb-1">
                                                        <a href="#"
                                                           class="text-body hover-secondary">Moisturizer</a>
                                                    </li>
                                                    <li class="mb-1">
                                                        <a href="#" class="text-body hover-secondary">Eye
                                                            Cream</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#"
                                                   class="text-uppercase fs-14 letter-spacing-005 font-weight-600 text-body hover-secondary text-decoration-none">Hair
                                                    CARE</a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#"
                                                   class="text-uppercase fs-14 letter-spacing-005 font-weight-600 text-body hover-secondary text-decoration-none">ACCESSORIES</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card border-0 mb-6">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <h4 class="card-title fs-20 mb-3">Hightlight</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">
                                                    Best Seller
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">
                                                    New Arrivals
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">
                                                    Sale
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">
                                                    Hot Items
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card border-0 mb-6">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <h4 class="card-title fs-20 mb-3">Price</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">
                                                    <span>All</span>
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">
                                                    <span>$50</span>
                                                    <span> - </span>
                                                    <span>$99</span>
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">
                                                    <span>$100</span>
                                                    <span> - </span>
                                                    <span>$499</span>
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">
                                                    <span>$500</span>
                                                    <span> - </span>
                                                    <span>$2000</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card border-0 mb-6">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <h4 class="card-title fs-20 mb-3">Size</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">Single</a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">5 Pack</a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">Full size</a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="#" class="text-body hover-secondary">Mini size</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card border-0 mb-6">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <h4 class="card-title fs-20 mb-3">Color</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-unstyled mb-0 widget-color d-flex flex-column">
                                            <li class="mb-1">
                                                <a href="#"
                                                   class="d-inline-flex align-items-center text-body text-decoration-none">
                                                            <span class="d-block item"
                                                                  style="background-color: #000;"></span>
                                                    <span class="ml-2">Black</span>
                                                </a>
                                            </li>
                                            <li class="mb-1">
                                                <a href="#"
                                                   class="d-inline-flex align-items-center text-body text-decoration-none">
                                            <span class="d-block item border"
                                                  style="background-color: #FFFFFF;box-sizing: content-box;"></span>
                                                    <span class="ml-2">White</span>
                                                </a>
                                            </li>
                                            <li class="mb-1">
                                                <a href="#"
                                                   class="d-inline-flex align-items-center text-body text-decoration-none">
                                                            <span class="d-block item"
                                                                  style="background-color: #0E328E;"></span>
                                                    <span class="ml-2">Pink</span>
                                                </a>
                                            </li>
                                            <li class="mb-1">
                                                <a href="#"
                                                   class="d-inline-flex align-items-center text-body text-decoration-none">
                                                            <span class="d-block item"
                                                                  style="background-color: #672612;"></span>
                                                    <span class="ml-2">Maroon</span>
                                                </a>
                                            </li>
                                            <li class="mb-1">
                                                <a href="#"
                                                   class="d-inline-flex align-items-center text-body text-decoration-none">
                                                            <span class="d-block item"
                                                                  style="background-color: #C71818;"></span>
                                                    <span class="ml-2">Red</span>
                                                </a>
                                            </li>
                                            <li class="mb-1">
                                                <a href="#"
                                                   class="d-inline-flex align-items-center text-body text-decoration-none">
                                                            <span class="d-block item"
                                                                  style="background-color: #5E5E5E;"></span>
                                                    <span class="ml-2">Dark Heathe</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card border-0" style="max-width:240px">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <h3 class="card-title fs-20 mb-3">
                                            Tags
                                        </h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">Cleansing</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">Make up</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">eye cream</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">nail</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">oil</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">shampoo</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">coffee bean</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">healthy</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">skin care</a>
                                            </li>
                                            <li class="list-inline-item mr-2 pb-1">
                                                <a href="#" class="text-body hover-secondary">sale</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">

                            <div class="our-courses" v-for="section in sections">
                                <!-- Options View -->
                                <div class="options-view">
                                    <div class="clearfix" v-if="section.products.length>0">
                                        <div class="d-flex justify-content-start mx-5">

                                            <h3> {{ oneLang(section.name_ar, section.name_en) }}</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <shop-gide-item2 v-for="product in section.products" :key="'shp-'+product.id"
                                                     :product="product">
                                    </shop-gide-item2>
                                </div>
                            </div>
                            <!--                            <nav class="pt-3">-->
                            <!--                                <ul class="pagination justify-content-center align-items-center mb-0 fs-16 font-weight-600">-->
                            <!--                                    <li class="page-item fs-18 d-none d-sm-block">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#" tabindex="-1"><i class="far fa-angle-double-left"></i></a>-->
                            <!--                                    </li>-->
                            <!--                                    <li class="page-item">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#">1</a>-->
                            <!--                                    </li>-->
                            <!--                                    <li class="page-item active" aria-current="page">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#">2</a>-->
                            <!--                                    </li>-->
                            <!--                                    <li class="page-item">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#">3</a>-->
                            <!--                                    </li>-->
                            <!--                                    <li class="page-item">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#">4</a>-->
                            <!--                                    </li>-->
                            <!--                                    <li class="page-item">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#">5</a>-->
                            <!--                                    </li>-->
                            <!--                                    <li class="page-item">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#">...</a>-->
                            <!--                                    </li>-->
                            <!--                                    <li class="page-item">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#">16</a>-->
                            <!--                                    </li>-->
                            <!--                                    <li class="page-item fs-18 d-none d-sm-block">-->
                            <!--                                        <a class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"-->
                            <!--                                           href="#"><i class="far fa-angle-double-right"></i></a>-->
                            <!--                                    </li>-->
                            <!--                                </ul>-->
                            <!--                            </nav>-->
                        </div>
                    </div>
                </div>
            </section>
        </main>

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

