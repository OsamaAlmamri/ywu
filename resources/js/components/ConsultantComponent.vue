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
            <div class="add_post_button" @click="openNewPostModal()"
                 style="display: block;">
                <span class="fa fa-comment" v-show="authUser"></span>
            </div>
            <sweet-modal :title="$t('consultants.add')"
                         :blocking=true :enable-mobile-fullscreen=true
                         :pulse-on-block=true
                         :overlay-theme="'dark'" ref="modal">
                <div class="row clearfix">
                    <div class="col-md-4">
                        <h5> {{ $t("privacy") }} </h5>
                        <section class="student-profile-section row">
                            <div class="inner-column">
                                <div class="profile-info-tabs">
                                    <div class="profile-tabs tabs-box">
                                        <ul class="tab-btns tab-buttons clearfix">
                                            <li
                                                @click="newPostData.is_public=0"
                                                :class="['user_type_tap', 'tab-btn',{'active-btn':(newPostData.is_public==0)}]">
                                                {{ $t('private') }}
                                            </li>
                                            <li
                                                @click="newPostData.is_public=1"
                                                :class="['user_type_tap', 'tab-btn',{'active-btn':(newPostData.is_public==1)}]">
                                                {{ $t('public') }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-8">
                        <h5> {{ $t("consultants.category") }} </h5>
                        <section class="student-profile-section row">
                            <div class="inner-column">
                                <div class="profile-info-tabs">
                                    <div class="profile-tabs tabs-box">
                                        <ul class="tab-btns tab-buttons clearfix">
                                            <li v-for="(category,key) in categories"
                                                @click="changeCategoryType(category.id)"
                                                :class="['user_type_tap', 'tab-btn',{'active-btn':(newPostData.category_id==category.id)}]">

                                                {{ oneLang(category.name, category.name_en) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="row clearfix">

                    <div class="form-group" style="width: 100%">
                        <fieldset class="the-fieldset">
                            <legend class="the-legend">{{ $t("consultants.title") }} *</legend>
                            <input style="width: 100%" type="text" v-model="newPostData.title" required="">
                        </fieldset>
                    </div>
                    <div class="form-group" style="width: 100%">
                        <fieldset class="the-fieldset">
                            <legend class="the-legend"> {{ $t("consultants.body") }}</legend>
                            <textarea style="width: 100%" rows="4" class="" v-model="newPostData.body"></textarea>
                        </fieldset>
                    </div>

                </div>
                <div slot="button">
                    <button class="btn btn-info" @click.prevent="(edit==false)?savePost():updatePost()">
                        {{ $t('done') }}
                    </button>
                </div>

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
                <div class="row clearfix mt-5" v-if="is_search==true">

                    <!-- Content Side -->
                    <div class="content-side mt-5  col-md-12 col-sm-12">
                        <div class="our-courses">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <h3> {{ $t('search.result') }} "{{ search_data }}"</h3>
                                    </div>
                                    <div class="pull-left">
                                        <button class="btn btn-info" @click="is_search=false"> {{ $t('search.close') }}
                                        </button>
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
                                        :lang="oneLang('ar','en')"
                                        :_key="key"
                                        :post="post"

                                        @toggled="onToggle"
                                    ></consultant-item>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <div class="row clearfix" v-if="is_search==false">

                    <!-- Content Side -->
                    <div class="content-side  col-md-12 col-sm-12 mt-5">
                        <div class="our-courses mt-5">


                            <div class="row clearfix">
                                <div class="cource-block-two  col-md-12 col-xs-12"
                                     v-for="(post,key) in consultant_data.data">
                                    <consultant-item
                                        v-on:edit_post="edit_post"
                                        v-on:delete_post="delete_post"
                                        :key="key"
                                        :_key="key"
                                        :post="post"
                                        @toggled="onToggle"
                                    ></consultant-item>
                                </div>

                            </div>
                            <div class="styled-pagination">
                                <pagination
                                    :align="'right'"
                                    :show-disabled=true
                                    @pagination-change-page="get_consultant_data"
                                    :data="consultant_data">
                                    <span slot="prev-nav">&lt;&lt; </span>
                                    <span slot="next-nav"> &gt;&gt;</span>
                                </pagination>
                            </div>

                        </div>

                    </div>

                    <!-- Sidebar Side -->
<!--                    <div class="sidebar-side style-two col-lg-4 col-md-12 col-sm-12">-->
<!--                        <recent-posts :name="$t('consultants.last')" type="posts"></recent-posts>-->
<!--                    </div>-->
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
            consultant_data: {},
            newPostData: {
                'id': 0,
                'title': '',
                is_public: 0,
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
        get_consultant_data(page = 1) {
            // http://127.0.0.1:8000/api/v2/consultants?page=1
            axios.post('api/v2/consultants?page=' + page)
                .then(response => {
                    this.consultant_data = response.data.data;
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
            console.log(this.consultant_data.data[key]);
            this.active_post = key;
            this.newPostData.title = this.consultant_data.data[key].title;
            this.newPostData.id = this.consultant_data.data[key].id;
            this.newPostData.is_public = this.consultant_data.data[key].is_public;
            this.newPostData.body = this.consultant_data.data[key].body;
            this.newPostData.category_id = this.consultant_data.data[key].category_id;
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
            // console.log('User cancelled the loader.')
        },
        setSearchResult(data) {
            this.is_search = true;
            this.search_data = data.title;
            this.search_result = data.data;
        },
        changeCategoryType(key) {
            this.newPostData.category_id = key;
        },
        openNewPostModal() {
            this.edit = false;
            this.newPostData = {
                'id': 0,
                'title': '',
                is_public: 0,
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
                            this.consultant_data.data.unshift(resp.data.data);
                            toastStack(resp.data.msg, '', 'success');
                            this.newPostData = {
                                'title': '',
                                'body': '',
                                is_public: 0,
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
                            this.consultant_data.data[this.active_post] = (resp.data.data);
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
            var id = this.consultant_data.data[key].id;
            axios({url: '/api/DePost/' + id, data: {id: this.id}, method: 'POST'})
                .then(resp => {
                    if (resp.data.status == false) {
                        toastStack('   خطاء ', resp.data.msg, 'error');
                    } else {
                        this.consultant_data.data.splice(key, 1);
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
        this.get_consultant_data();

    },


}
</script>
<style>
.student-profile-section {
    background-color: white;
    padding: 0px 0px 0px;

}

.student-profile-section .profile-tabs .tab-btns {
    border-bottom: 3px solid #593c97;
}
</style>
