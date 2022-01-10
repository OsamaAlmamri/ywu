<template>
    <!--Sidebar Page Container-->
    <div>
        <search-filed v-on:search_result="setSearchResult"></search-filed>


        <div class="sidebar-page-container">

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
            <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
                 data-paroller-type="foreground" data-paroller-direction="vertical"
                 style="background-image: url(site/images/icons/icon-1.png)"></div>
            <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
                 data-paroller-type="foreground" data-paroller-direction="vertical"
                 style="background-image: url(site/images/icons/icon-2.png)"></div>
            <div class="circle-one"></div>
            <div class="circle-two"></div>
            <div class="auto-container">
                <div v-if="is_search==true" class="row clearfix">

                    <!-- Content Side -->
                    <div class="content-side  col-md-12 col-sm-12">
                        <div class="our-courses">

                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <h3> {{$t('search.result')}}"{{ search_data }}"</h3>
                                    </div>
                                    <div class="pull-left">
                                        <button class="btn btn-info" @click="is_search=false">{{$t('search.close')}}  </button>
                                    </div>

                                </div>
                            </div>


                            <div class="row clearfix">
                                <div class="cource-block-two col-lg-4 col-md-6 col-sm-12 col-xs-12"
                                     v-for="women_post in search_result">
                                    <women-item
                                        :women_post="women_post"
                                        @toggled="onToggle"
                                    ></women-item>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>

                <div v-if="is_search==false" class="row clearfix">

                    <!-- Content Side -->
                    <div class="content-side col-lg-9 col-md-12 col-sm-12">
                        <div class="our-courses">

                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <h3> {{ $t('women.title') }}</h3>
                                    </div>

                                </div>
                            </div>


                            <div class="row clearfix">
                                <div class="cource-block-two col-lg-4 col-md-6 col-sm-12 col-xs-12"
                                     v-for="women_post in pagesData.data">
                                    <women-item
                                        :women_post="women_post"
                                        @toggled="onToggle"
                                    ></women-item>
                                </div>

                            </div>
                            <div class="styled-pagination">
                                <pagination
                                    :align="'right'"
                                    :show-disabled=true
                                    @pagination-change-page="fetchArticles"
                                    :data="pagesData">
                                    <span slot="prev-nav">&lt;&lt; </span>
                                    <span slot="next-nav"> &gt;&gt;</span>
                                </pagination>
                                <!--                        <pagination :data="laravelData" @pagination-change-page="getResults"></pagination>-->
                            </div>
                        </div>

                    </div>

                    <!-- Sidebar Side -->
                    <div class="sidebar-side style-two col-lg-3 col-md-12 col-sm-12">
                        <recent-posts :name="$t('last_posts')" type="women"></recent-posts>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
import WomenItem from './WomenItem.vue';
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
import ConsultantItem from "./ConsultantItem";
import axios from "axios";

export default {
    props: ['items'],
    components: {WomenItem, Loading},
    data() {

        return {
            pagesData: {},
            isLoading: false,
            fullPage: false,
            activeIndex: null,
            women_posts: [],
            women_id: '',
            is_search: false,
            search_data: '',
            search_result: [],
            pagination: {},
            edit: false
        }
    },
    created() {
        this.fetchArticles();
    },
    methods: {
        onToggle(index) {
            if (this.activeIndex == index) {
                return (this.activeIndex = null);
            }
            this.activeIndex = index;
        },
        // getResults(page = 1) {
        //     axios.post('api/AllPosts?page=' + page)
        //         .then(response => {
        //             this.laravelData = response.data.Posts;
        //         });
        // },
        setSearchResult(data) {

            this.is_search = true;
            this.search_data = data.title;
            this.search_result = data.data;
        },
        fetchArticles(page = 1) {
            this.isLoading = true;
            axios({url: '/api/ShowP?page=' + page, data: {limit: 9}, method: 'POST'})
                .then(res => {
                    // console.log(res.data.Posts.data)
                    this.isLoading = false;
                    this.pagesData = res.data.Posts;
                    this.women_posts = res.data.Posts.data;
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
        this.fetchArticles();

    },


}
</script>
