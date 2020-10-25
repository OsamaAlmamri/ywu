<template>
    <!--Sidebar Page Container-->
    <div>
        <search-filed  v-on:search_result="setSearchResult"></search-filed>

        <div class="sidebar-page-container">

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
        <div class="add_post_button" @click="openNewPostModal()"
             style="display: block;">
            <span class="fa fa-comment" v-show="authUser"></span>
        </div>
        <sweet-modal :title="'اضافة استشارة جديدة'"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="modal">
            <div class="row clearfix">

                <div class="form-group" style="width: 100%">
                    <fieldset class="the-fieldset">
                        <legend class="the-legend">عنوان الاستشارة *</legend>
                        <input style="width: 100%" type="text" v-model="newPostData.title" required="">
                    </fieldset>
                </div>
                <div class="form-group" style="width: 100%">
                    <fieldset class="the-fieldset">
                        <legend class="the-legend">نص الاستشارة</legend>
                        <textarea style="width: 100%" rows="4" class="" v-model="newPostData.body"></textarea>
                    </fieldset>
                </div>
                <h5>نوع الاستشارة </h5>
                <section class="student-profile-section">
                    <div class="inner-column">
                        <div class="profile-info-tabs">
                            <div class="profile-tabs tabs-box">
                                <ul class="tab-btns tab-buttons clearfix">

                                    <li v-for="(category,key) in categories"
                                        @click="changeCategoryType(category.id)"
                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(newPostData.category_id==category.id)}]">
                                        {{category.name}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
            <sweet-button slot="button">
                <button class="btn btn-info" @click.prevent="(edit==false)?savePost():updatePost()">تم</button>
            </sweet-button>

        </sweet-modal>

        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url(site/images/icons/icon-1.png)"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url(site/images/icons/icon-2.png)"></div>
        <div class="circle-one"></div>
        <div class="circle-two"></div>
        <div class="auto-container">
            <div class="row clearfix"  v-if="is_search==true">

                <!-- Content Side -->
                <div class="content-side  col-md-12 col-sm-12">
                    <div class="our-courses">
                        <!-- Options View -->
                        <div class="options-view">
                            <div class="clearfix" >
                                <div class="pull-right">
                                    <h3> نتائج البحث عن "{{search_data}}"</h3>
                                </div>
                                <div class="pull-left">
                                    <button class="btn btn-info" @click="is_search=false">اغلاق نتائج البحث</button>
                                </div>

                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="cource-block-two  col-sm-12 col-xs-12"
                                 v-for="(post,key) in search_result">
                                <consultant-item
                                    v-on:edit_post="edit_post"
                                    v-on:delete_post="delete_post"
                                    :key="key"
                                    :post="post"

                                    @toggled="onToggle"
                                ></consultant-item>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="row clearfix"  v-if="is_search==false">

                <!-- Content Side -->
                <div class="content-side col-lg-8 col-md-12 col-sm-12">
                    <div class="our-courses">

                        <!-- Options View -->
                        <div class="options-view">
                            <div class="clearfix">
                                <div class="pull-right">
                                    <h3>الاستشارات </h3>
                                </div>

                            </div>
                        </div>
                        <!--                        v-for="post in laravelData.data" :key="post.id"-->
                        <!--                        res.data.Posts.data;-->

                        <div class="row clearfix">
                            <div class="cource-block-two  col-sm-12 col-xs-12"
                                 v-for="(post,key) in laravelData.data">
                                <consultant-item
                                    v-on:edit_post="edit_post"
                                    v-on:delete_post="delete_post"
                                    :key="key"
                                    :post="post"

                                    @toggled="onToggle"
                                ></consultant-item>
                            </div>

                        </div>
                        <!--                        <pagination :data="laravelData" @pagination-change-page="getResults"></pagination>-->
                        <div class="styled-pagination">
                            <pagination
                                :align="'right'"
                                :show-disabled=true
                                @pagination-change-page="getResults"
                                :data="laravelData">
                                <span slot="prev-nav">&lt;&lt; </span>
                                <span slot="next-nav"> &gt;&gt;</span>
                            </pagination>
                            <!--                        <pagination :data="laravelData" @pagination-change-page="getResults"></pagination>-->
                        </div>
                        <!-- Post Share Options -->
                        <!--                        <div class="styled-pagination">-->
                        <!--                            <ul class="clearfix">-->
                        <!--                                <li class="prev"><a href="#"><span class="fa fa-angle-left"></span> </a></li>-->
                        <!--                                <li><a href="#">1</a></li>-->
                        <!--                                <li><a href="#">2</a></li>-->
                        <!--                                <li class="active"><a href="#">3</a></li>-->
                        <!--                                <li><a href="#">4</a></li>-->
                        <!--                                <li><a href="#">5</a></li>-->
                        <!--                                <li><a href="#">6</a></li>-->
                        <!--                                <li><a href="#">7</a></li>-->
                        <!--                                <li><a href="#">8</a></li>-->
                        <!--                                <li class="next"><a href="#"><span class="fa fa-angle-right"></span> </a></li>-->
                        <!--                            </ul>-->
                        <!--                        </div>-->

                    </div>

                </div>

                <!-- Sidebar Side -->
                <div class="sidebar-side style-two col-lg-4 col-md-12 col-sm-12">
                    <recent-posts name="اخر الاستشارات" type="posts"></recent-posts>
                </div>

            </div>


        </div>
    </div>
    </div>
</template>

<script>
    import ConsultantItem from "./ConsultantItem";
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import axios from "axios";
    import store from '../store'

    export default {
        props: ['items'],
        components: {ConsultantItem, Loading},

        data() {
            return {
                laravelData: {},
                newPostData: {
                    'id': 0,
                    'title': '',
                    'body': '',
                    'category_id': '1',
                },
                isLoading: false,
                active_post: 0,
                fullPage: false,
                is_search: false,
                search_data: '',
                search_result: [],
                activeIndex: null,
                posts: [],
                categories: [],
                women_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {
            // this.fetchArticles();
            this.fetchCategories();

        },
        computed: {

            authUser: function () {
                return store.getters.authUser
            }
        },
        methods: {
            getResults(page = 1) {
                axios.post('api/AllPosts?page=' + page)
                    .then(response => {
                        this.laravelData = response.data.Posts;
                    });
            },
            onToggle(index) {
                if (this.activeIndex == index) {
                    return (this.activeIndex = null);
                }
                this.activeIndex = index;
            },
            deleteRating() {
                this.isLoading = true;
                axios({url: '/api/training/delete_rate', data: {id: this.training.is_rating.id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            if (resp.data.data == 1) {
                                this.training.is_rating = null;
                                this.edit_rate = true;
                            }


                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            },
            edit_post(key) {
                this.edit = true;
                console.log(this.posts[key]);
                this.active_post = key;
                this.newPostData.title = this.posts[key].title;
                this.newPostData.id = this.posts[key].id;
                this.newPostData.body = this.posts[key].body;
                this.newPostData.category_id = this.posts[key].category_id;
                this.$refs.modal.open();
            },
            fetchArticles() {
                this.isLoading = true;

                axios.post('/api/AllPosts', {
                        headers: {
                            'content-type': 'application/json',
                            // Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    },
                ).then(res => {
                    // console.log(res.data.Posts.data)
                    this.posts = res.data.Posts.data;
                    this.isLoading = false;

                })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    });
            },
            fetchCategories() {
                axios.post('/api/AllCategories', {
                        headers: {
                            'content-type': 'application/json',
                        }
                    },
                ).then(res => {
                    this.categories = res.data.categories;
                })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    });
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            setSearchResult(data) {

                this.is_search=true;
                this.search_data=data.title;
                this.search_result=data.data;
            },
            changeCategoryType(key) {
                this.newPostData.category_id = key;
            },
            openNewPostModal() {
                this.edit = false;
                this.newPostData = {
                    'id': 0,
                    'title': '',
                    'body': '',
                    'category_id': '1',
                };
                this.$refs.modal.open();
            },
            savePost() {
                if (localStorage.token) {
                    this.isLoading = true;
                    axios({url: '/api/store_post', data: this.newPostData, method: 'POST'})
                        .then(resp => {
                            this.isLoading = false;
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                this.posts.unshift(resp.data.data);
                                toastStack(resp.data.msg, '', 'success');
                                this.newPostData = {
                                    'title': '',
                                    'body': '',
                                    'category_id': '1',
                                }
                                this.$refs.modal.close();
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
                this.$emit('click', this.$vnode.key)
            },
            updatePost() {
                if (localStorage.token) {
                    this.isLoading = true;
                    axios({url: '/api/update_post_web', data: this.newPostData, method: 'POST'})
                        .then(resp => {
                            this.isLoading = false;
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                this.posts[this.active_post] = (resp.data.data);
                                toastStack(resp.data.msg, '', 'success');
                                this.$refs.modal.close();
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
                this.$emit('click', this.$vnode.key)
            },
            delete_post(key) {
                this.isLoading = true;
                var id = this.posts[key].id;
                axios({url: '/api/DePost/' + id, data: {id: this.id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.posts.splice(key, 1);
                            toastStack(resp.data.msg, '', 'success');
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            },


        },
        mounted() {
            console.log('Component mounted.')
            this.getResults();

        },


    }
</script>
<style>
    .student-profile-section {
        background-color: white;
        padding: 0px 0px 0px;

    }

    .student-profile-section .profile-tabs .tab-btns {
        border-bottom: 3px solid #00ab15;
    }
</style>
