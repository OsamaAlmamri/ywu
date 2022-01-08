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

            <div class="auto-container">
                <div class="row clearfix">
                    <div class="content-side col-lg-12 col-md-12 col-sm-12">
                        <div class="d-flex align-content-around flex-wrap">
                            <!-- Options View -->
                            <div class="filter"> <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#mobile-filter" aria-expanded="false" aria-controls="mobile-filter">Filters<span class="fa fa-filter pl-1"></span></button>
                            </div>
                            <div id="mobile-filter">
                                <div>
                                    <h6 class="p-1 border-bottom">Home Furniture</h6>
                                    <ul>
                                        <li><a href="#">Living</a></li>
                                        <li><a href="#">Dining</a></li>
                                        <li><a href="#">Office</a></li>
                                        <li><a href="#">Bedroom</a></li>
                                        <li><a href="#">Kitchen</a></li>
                                    </ul>
                                </div>
                                <div>
                                    <h6 class="p-1 border-bottom">Filter By</h6>
                                    <p class="mb-2">Color</p>
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-action mb-2 rounded"><a href="#"> <span class="fa fa-circle pr-1" id="red"></span>Red </a></li>
                                        <li class="list-group-item list-group-item-action mb-2 rounded"><a href="#"> <span class="fa fa-circle pr-1" id="teal"></span>Teal </a></li>
                                        <li class="list-group-item list-group-item-action mb-2 rounded"><a href="#"> <span class="fa fa-circle pr-1" id="blue"></span>Blue </a></li>
                                    </ul>
                                </div>
                                <div>
                                    <h6>Type</h6>
                                    <form class="ml-md-2">
                                        <div class="form-inline border rounded p-sm-2 my-2"> <input type="radio" name="type" id="boring"> <label for="boring" class="pl-1 pt-sm-0 pt-1">Boring</label> </div>
                                        <div class="form-inline border rounded p-sm-2 my-2"> <input type="radio" name="type" id="ugly"> <label for="ugly" class="pl-1 pt-sm-0 pt-1">Ugly</label> </div>
                                        <div class="form-inline border rounded p-md-2 p-sm-1"> <input type="radio" name="type" id="notugly"> <label for="notugly" class="pl-1 pt-sm-0 pt-1">Not Ugly</label> </div>
                                    </form>
                                </div>
                            </div>

                            <shop-gide-item2 v-for="product in products.data"
                                             :key="product.id"    :product="product">
                            </shop-gide-item2>


                        </div>

                        <div class="styled-pagination">
                            <pagination
                                :align="'center'"
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
                                {{$t('shop.product_not_exisit') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
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
