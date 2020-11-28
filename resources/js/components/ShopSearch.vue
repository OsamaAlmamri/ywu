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
                <div class="search-boxed">
                    <div class="search-box row">
                        <div class="col-md-6 ">
                            <label class="typo__label">المحافظات</label>
                            <multiselect v-model="value" tag-placeholder="Add this as new tag"
                                         placeholder="Search or add a tag" label="name_ar" track-by="id"
                                         @select="add_gov"
                                         @remove="remove_gov"
                                         :hide-selected="true" :options="govs" :multiple="true"></multiselect>
                        </div>
                        <div class="col-md-6 ">
                            <label class="typo__label">البائعون</label>
                            <multiselect
                                v-model="seller_value" tag-placeholder="Add this as new tag"
                                placeholder="Search or add a tag" label="sale_name" track-by="admin_id"
                                :hide-selected="true" :options="sellers" :multiple="true"></multiselect>
                        </div>
                        <div class="col-md-6 ">
                            <label class="typo__label">الاصناف</label>
                            <multiselect v-model="categiries_value" tag-placeholder="اضافةبائع جديد"
                                         placeholder="بحث" label="name" track-by="id"
                                         :hide-selected="true" :options="categories" :multiple="true"></multiselect>
                        </div>
                        <div class="col-md-6 " style="margin-top: 33px;">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" style="padding: 0 98px;"
                                        @click.prevent="get_product_by_categories22()"> بحث
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
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
                                        :product="product">

                                    </shop-gide-item>
                                </div>
                            </flickity>

                            <div class="row" v-if="section.products.length<4">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12" v-for="product in section.products">
                                    <shop-gide-item
                                        :product="product"
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
    import Multiselect from 'vue-multiselect'

    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import Flickity from 'vue-flickity';
    import ShopGideItem from './ShopGideItem';
    import axios from "axios";

    export default {
        props: ['items'],
        components: {Multiselect, ShopGideItem, Loading, Flickity},
        data() {
            return {
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
                isLoading: false,
                fullPage: true,
                activeIndex: null,
                categories: [],
                is_search: false,
                search_data: '',
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
                options: [
                    {name: 'Vue.js', code: 'vu'},
                    {name: 'Javascript', code: 'js'},
                    {name: 'Open Source', code: 'os'}
                ]
            }
        },
        created() {
            this.all_categories();
            this.get_category_products();
            this.get_gov();
        },
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
            // "categories": 1
            // "seller_id":7,
            // "govs": 11
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
            setSearchResult(data) {

                this.is_search = true;
                this.search_data = data.title;
                this.search_result = data.data;
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
            get_category_products() {
                axios({
                    url: '/api/shop/get_category_products',
                    data: {category_id: this.$route.params.id},
                    method: 'POST'
                })
                    .then(resp => {
                        this.products = (resp.data.data.data);
                    })
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
                this.isLoading = true;
                axios({
                    url: '/api/shop/get_product_by_categories22',
                    data: this.form,
                    method: 'POST'
                })
                    .then(resp => {
                        this.sections = (resp.data.data);
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

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
