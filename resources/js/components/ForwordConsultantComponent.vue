<template>
    <!--Sidebar Page Container-->
    <div>

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
                    <div class="col-md-12">
                        <h5> {{ $t("status") }} </h5>
                        <section class="student-profile-section row">
                            <div class="inner-column">
                                <div class="profile-info-tabs">
                                    <div class="profile-tabs tabs-box">
                                        <ul class="tab-btns tab-buttons clearfix">
                                            <li
                                                @click="newPostData.status='not_solve'"
                                                :class="['user_type_tap', 'tab-btn',{'active-btn':(newPostData.status=='not_solve')}]">
                                                {{ $t('not_solve') }}
                                            </li>
                                            <li
                                                @click="newPostData.status='not_complete'"
                                                :class="['user_type_tap', 'tab-btn',{'active-btn':(newPostData.status=='not_complete')}]">
                                                {{ $t('not_complete') }}
                                            </li>
                                            <li
                                                @click="newPostData.status='solved'"
                                                :class="['user_type_tap', 'tab-btn',{'active-btn':(newPostData.status=='solved')}]">
                                                {{ $t('solved') }}
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
                            <legend class="the-legend"> {{ $t("consultants.solve") }}</legend>
                            <textarea style="width: 100%" rows="4" class="" v-model="newPostData.solve"></textarea>
                        </fieldset>
                    </div>

                </div>
                <div slot="button">
                    <button class="btn btn-info" @click.prevent="updatePost()">
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
                <!-- Content Side -->
                <div class="content-side  col-md-12 col-sm-12">
                    <div class="our-courses">

                        <!-- Options View -->
                        <div class="options-view">
                            <div class="clearfix">
                                <div class="pull-right">
                                    <h3>{{ $t("MENU.forwordConsultant") }} </h3>
                                </div>

                            </div>
                        </div>
                        <!--                        v-for="post in consultant_data.data" :key="post.id"-->
                        <!--                        res.data.Posts.data;-->

                        <div class="row clearfix">
                            <div class="cource-block-two  col-sm-12 col-xs-12"
                                 v-for="(post,key) in consultant_data.data">
                                <forword-consultant-item
                                    v-on:edit_post="edit_post"
                                    :key="key"
                                    :_key="key"
                                    :post="post"
                                    @toggled="onToggle"
                                ></forword-consultant-item>
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
            </div>
        </div>
    </div>
</template>

<script>
import ForwordConsultantItem from "./ForwordConsultantItem";
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
import axios from "axios";
import store from '../store'

export default {
    props: ['items'],
    components: {ForwordConsultantItem, Loading},

    data() {
        return {
            consultant_data: {},
            newPostData: {
                'id': 0,
                status: 'solved',
                'solve': '',

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

    },
    computed: {

        authUser: function () {
            return store.getters.authUser
        }
    },
    methods: {
        get_consultant_data(page = 1) {
            // http://127.0.0.1:8000/api/v2/consultants?page=1
            axios.post('api/v2/forewordConsultants/index?page=' + page)
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

        edit_post(key) {
            this.edit = true;
            console.log(this.consultant_data.data[key]);
            this.active_post = key;
            this.newPostData.solve = this.consultant_data.data[key].solve;
            this.newPostData.id = this.consultant_data.data[key].id;
            this.newPostData.status = this.consultant_data.data[key].status;
            this.$refs.modal.open();
        },
        onCancel() {
            // console.log('User cancelled the loader.')
        },
        updatePost() {
            if (localStorage.token) {
                this.isLoading = true;
                axios({url: '/api/v2/forewordConsultants/add_sovle', data: this.newPostData, method: 'POST'})
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
