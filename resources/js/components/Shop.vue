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
        <div>
            <p class="d-flex justify-content-start mx-2 d-md-none">
                <a class="btn btn-primary" data-toggle="collapse" href="#sidebar"
                   role="button" aria-expanded="true" aria-controls="sidebar">
                    {{ $t('filter')  }}
                </a>
            </p>

            <div class="row">
                <div class="col-md-3 primary-sidebar sidebar-sticky sidebar pr-lg-8 d-md-block mt-5"
                     style=""
                     id="sidebar">

                    <div class="primary-sidebar-inner"
                         style="position: static; left: auto;">
                        <div class="card border-0 mb-6">
                            <div class="search-box row mt-4">

                                <div class=" col-12">
                                    <label class="typo__label">{{ $t('search.search') }}</label>
                                    <input type="text" v-model="search.search" class="form-control">
                                </div>
                                <div class=" col-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-6"><label>{{ $t('search.min_price') }}</label> <input
                                            class="form-control" v-model="search.min_price" placeholder="$0"
                                            type="number"></div>
                                        <div class="form-group text-right col-md-6"><label>{{ $t('search.min_price') }}</label> <input
                                            class="form-control" v-model="search.max_price" placeholder="$1,0000"
                                            type="number"></div>
                                    </div>
                                </div>

                                <div class=" col-12">
                                    <label class="typo__label">{{ $t('shop.govs') }}</label>
                                    <multiselect v-model="search.gov_id" :tag-placeholder="$t('add')"
                                                 :placeholder="$t('shop.govs')"
                                                 :label="oneLang('name_ar','name_en')"
                                                 track-by="id"
                                                 @select="add_gov"
                                                 :showLabels="false"
                                                 @remove="remove_gov"
                                                 open-direction="top"

                                                 :options="govs"
                                                 :multiple="false"></multiselect>
                                </div>
                                <div class=" col-12">
                                    <label class="typo__label"> {{ $t('shop.categories') }} </label>
                                    <multiselect v-model="search.category_id" :tag-placeholder="$t('add')"
                                                 :showLabels="false"

                                                 :maxHeight="3000"
                                                 :placeholder="$t('shop.categories') "
                                                 :label="oneLang('name','name_en')"
                                                 track-by="id"
                                                 open-direction="top"
                                                 :hide-selected="false" :options="categories"
                                                 :multiple="false">


                                    </multiselect>
                                </div>
                                <div class=" col-12 filter_option_serller">
                                    <label class="typo__label">{{ $t('shop.seller') }}</label>
                                    <multiselect
                                        :close-on-select="false"
                                        :showLabels="false"
                                        :clear-on-select="false"
                                        open-direction="bottom"
                                        v-model="search.seller_id"
                                        :placeholder=" $t('shop.seller')" label="sale_name"
                                        track-by="admin_id"

                                        :options="sellers"
                                        :multiple="false">


                                        <template slot="option" slot-scope="props">
                                            <div class="media">
                                                <img style="width: 40px"
                                                     :src="props.option.ssn_image"
                                                     class="align-self-end mr-n3">
                                                <div class="media-body mx-2">
                                                    <h7>{{ props.option.sale_name }}</h7>
                                                    <p>
                                                        {{ props.option.gov }}-
                                                        {{ props.option.district }}
                                                        <!--                                                        <br>-->
                                                        <!--                                                        <span class="option_more_address_info" style="">-->
                                                        <!--                                                                                                                    {{ props.option.more_address_info }}-->
                                                        <!--                                                        {{ props.option.more_address_info }}-->

                                                        <!--                                                        </span>-->
                                                    </p>

                                                </div>
                                            </div>
                                        </template>

                                    </multiselect>
                                </div>

                                <div class=" col-12">
                                    <div class="input-group-append my-5" >
                                        <button class="btn btn-primary"
                                                @click.prevent="get_product_by_categories22()"> {{ $t('filter') }}
                                        </button>
                                        <button v-if="search_result.data" class="btn btn-warning" @click="is_search=false; search_result={}"> {{ $t('search.close') }}
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">

                    <!--                    <div class="auto-container">-->
                    <div class="row clearfix">
                        <div v-if="!search_result.data" class="content-side col-lg-12 col-md-12 col-sm-12">
                            <div v-if="!search_result.data" class="our-courses" v-for="section in sections">
                                <!-- Options View -->
                                <div class="options-view">
                                    <div class="clearfix" v-if="section.products.length>0">
                                        <div class="d-flex justify-content-start mx-5">
                                            <h3> {{ oneLang(section.name_ar, section.name_en) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-content-around flex-wrap">
                                    <shop-gide-item2 v-for="product in section.products" :key="'shp-'+product.id"
                                                     :product="product">
                                    </shop-gide-item2>
                                </div>
                            </div>


                        </div>
                        <div v-else class="content-side col-lg-12 col-md-12 col-sm-12">
                            <div class="our-courses">
                                <!-- Options View -->
                                <div class="options-view">
                                    <div class="clearfix">
                                        <div class="d-flex justify-content-start mx-5">
                                            <h3> {{ $t('search.result') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-content-around flex-wrap">
                                    <shop-gide-item2 v-for="product in search_result.data" :key="'search-'+product.id"
                                                     :product="product">
                                    </shop-gide-item2>
                                </div>


                                <div class="styled-pagination">
                                    <pagination
                                        :align="'center'"
                                        :show-disabled=true
                                        @pagination-change-page="get_product_by_categories22"
                                        :data="search_result">
                                        <span slot="prev-nav">&lt; </span>
                                        <span slot="next-nav"> &gt;</span>
                                    </pagination>
                                </div>
                                <div style="text-align: center" v-show="search_result.data.length<1">
                                    <img style="width: 35%;margin-top: -150px;" src="/site/images/img-no-products.png">
                                    <h4>
                                        {{$t('shop.product_not_exisit') }}
                                    </h4>
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
            search: {
                search: '',
                min_price: '',
                max_price: '',
                category_id: '',
                seller_id: '',
                gov_id: '',
            },

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
        this.get_gov();
        this.gov_sellers();
        this.all_categories();
        this.get_product_type(0)
        this.get_product_type(1)
        this.get_product_type(2)
        this.get_product_type(3)


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
        get_product_by_categories22(page=1) {
            this.form.category_id = '';
            this.form.gov_id = '';
            this.form.seller_id = '';
            this.form.max_price = this.search.max_price;
            this.form.min_price = this.search.min_price;
            this.form.search = this.search.search;
            if (this.search.category_id)
                this.form.category_id = this.search.category_id.id

            if (this.search.seller_id)
                this.form.seller_id = this.search.seller_id.id

            if (this.search.gov_id)
                this.form.gov_id = this.search.gov_id.id

            if (this.is_search == false) {
                this.is_search = true;
                this.isLoading = true;
                axios({
                    url: '/api/shop/get_products_by_type?page=' + page,

                    data: this.form,
                    method: 'POST'
                })
                    .then(resp => {
                        this.search_result = (resp.data.data);
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
        ,
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

