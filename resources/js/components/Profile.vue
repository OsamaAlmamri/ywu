<template>


    <!-- Student Profile Section -->
    <section class="student-profile-section">
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
             style="background-image: url(/site/images/icons/icon-1.png)"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url(/site/images/icons/icon-2.png)"></div>
        <div class="circle-one"></div>
        <div class="circle-two"></div>
        <div class="auto-container">

            <div class="row clearfix">


                <!-- Image Section -->
                <div class="image-column col-lg-3 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="image">
                            <img class="thumbnail-imges" src="/site/images/deafult.png" alt="">
                        </div>
                        <p>{{authUser.name}}</p>
                        <!--                        <a href="#" class="theme-btn btn-style-three"><span class="txt">Upload Picture <i-->
                        <!--                            class="fa fa-angle-left"></i></span></a>-->
                        <!--                        <a href="#" class="theme-btn btn-style-two"><span class="txt">Delete Picture <i-->
                        <!--                            class="fa fa-angle-left"></i></span></a>-->
                    </div>
                </div>
                <!-- Content Section -->
                <div class="content-column col-lg-9 col-md-12 col-sm-12">
                    <div class="inner-column">

                        <!-- Profile Info Tabs-->
                        <div class="profile-info-tabs">
                            <!-- Profile Tabs-->
                            <div class="profile-tabs tabs-box">

                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    <li data-tab="#prod-complete"
                                        @click="changeActive('prod-complete')"
                                        :class="['tab-btn', {'active-btn':(activeTap=='prod-complete')}]">
                                        {{ $t('profile.complete_courses') }}
                                        <span class="tap_count_label"> {{my_complete_trainings_data.data.length}}</span>
                                    </li>
                                    <li data-tab="#prod-overview"
                                        @click="changeActive('prod-overview')"
                                        :class="['tab-btn', {'active-btn':(activeTap=='prod-overview')}]">
                                        {{ $t('profile.not_complete_courses') }}
                                        <span class="tap_count_label"> {{my_trainings_data.data.length}}</span>


                                    </li>
                                    <li data-tab="#prod-bookmark"
                                        @click="changeActive('prod-bookmark')"
                                        :class="['tab-btn', {'active-btn':(activeTap=='prod-bookmark')}]">
                                        {{ $t('profile.my_consultant') }}

                                        <span class="tap_count_label"> {{my_consultantData.data.length}}</span>

                                    </li>
                                    <li
                                        @click="changeActive('prod-fav')"
                                        :class="['tab-btn', {'active-btn':(activeTap=='prod-fav')}]">

                                        {{ $t('profile.fav_courses') }}
                                        <span class="tap_count_label"> {{my_favData.data.length}}</span>

                                    </li>
                                    <li data-tab="#prod-setting"
                                        @click="changeActive('prod-setting')"
                                        :class="['tab-btn', {'active-btn':(activeTap=='prod-setting')}]">
                                        {{ $t('profile.setting') }}

                                    </li>
                                    <li data-tab="#prod-password"
                                        @click="changeActive('prod-password')"
                                        :class="['tab-btn', {'active-btn':(activeTap=='prod-password')}]">
                                        {{ $t('profile.change_password') }}
                                    </li>
                                </ul>

                                <!--Tabs Container-->
                                <div class="tabs-content">

                                    <!--Tab / Active Tab-->
                                    <div :class="['tab', {'active-tab':(activeTap=='prod-complete')}]"
                                         id="prod-complete">
                                        <!-- Sec Title -->
                                        <div class="content">
                                            <div class="row clearfix">
                                                <h4 style="margin: 25%"
                                                    v-if="my_complete_trainings_data.data.length==0">

                                                    {{ $t('profile.not_have_courses') }}
                                                </h4>
                                                <div class=" col-12"
                                                     v-for="(training,key) in my_complete_trainings_data.data">
                                                    <course-gide-item
                                                        :training="training"
                                                        @toggled="onToggle"
                                                    ></course-gide-item>
                                                </div>
                                            </div>
                                            <div class="styled-pagination">
                                                <pagination
                                                    :align="'right'"
                                                    :show-disabled=true
                                                    @pagination-change-page="my_complete_trainings"
                                                    :data="my_complete_trainings_data">
                                                    <span slot="prev-nav">&lt;&lt; </span>
                                                    <span slot="next-nav"> &gt;&gt;</span>
                                                </pagination>
                                            </div>


                                        </div>

                                    </div>

                                    <!--Tab / Active Tab-->
                                    <div :class="['tab', {'active-tab':(activeTap=='prod-overview')}]"
                                         id="prod-overview">
                                        <!-- Sec Title -->
                                        <div class="content">
                                            <div class="row clearfix">
                                                <h4 style="margin: 25%" v-if="my_trainings_data.data.length==0">
                                                    {{ $t('profile.not_have_courses') }}

                                                </h4>
                                                <div class=" col-12"
                                                     v-for="(training,key) in my_trainings_data.data">
                                                    <course-gide-item
                                                        :training="training"
                                                        @toggled="onToggle"
                                                    ></course-gide-item>
                                                </div>
                                            </div>
                                            <div class="styled-pagination">
                                                <pagination
                                                    :align="'right'"
                                                    :show-disabled=true
                                                    @pagination-change-page="my_trainings"
                                                    :data="my_trainings_data">
                                                    <span slot="prev-nav">&lt;&lt; </span>
                                                    <span slot="next-nav"> &gt;&gt;</span>
                                                </pagination>
                                            </div>


                                        </div>

                                    </div>

                                    <!-- Tab -->
                                    <div :class="['tab', {'active-tab':(activeTap=='prod-bookmark')}]">
                                        <div class="content">
                                            <div class="row clearfix">
                                                <h4 style="margin: 25%" v-if="my_consultantData.data.length==0">


                                                    {{ $t('profile.not_have_consultant') }}
                                                </h4>
                                                <div class="cource-block-two  col-sm-12 col-xs-12"
                                                     v-for="(post,key) in my_consultantData.data">
                                                    <consultant-item
                                                        v-on:edit_post="edit_post"
                                                        v-on:delete_post="delete_post"
                                                        :key="key"
                                                        :post="post"
                                                        :_key="key"
                                                        @toggled="onToggle"
                                                    ></consultant-item>
                                                </div>

                                            </div>
                                            <div class="styled-pagination">
                                                <pagination
                                                    :align="'right'"
                                                    :show-disabled=true
                                                    @pagination-change-page="myConsultant"
                                                    :data="my_consultantData">
                                                    <span slot="prev-nav">&lt;&lt; </span>
                                                    <span slot="next-nav"> &gt;&gt;</span>
                                                </pagination>
                                            </div>

                                        </div>

                                    </div>

                                    <div :class="['tab', {'active-tab':(activeTap=='prod-fav')}]">
                                        <div class="content">
                                            <div class="row clearfix">
                                                <h4 style="margin: 25%" v-if="my_like_trainings.data.length==0">
                                                    {{ $t('profile.not_have_courses_fav') }}
                                                   </h4>
                                                <div class=" col-12"
                                                     v-for="(training,key) in my_like_trainings.data">
                                                    <course-gide-item
                                                        :training="training"
                                                        @toggled="onToggle"
                                                    ></course-gide-item>
                                                </div>
                                            </div>
                                            <div class="styled-pagination">
                                                <pagination
                                                    :align="'right'"
                                                    :show-disabled=true
                                                    @pagination-change-page="fav_trainings"
                                                    :data="my_like_trainings">
                                                    <span slot="prev-nav">&lt;&lt; </span>
                                                    <span slot="next-nav"> &gt;&gt;</span>
                                                </pagination>
                                            </div>


                                        </div>
                                    </div>


                                    <div :class="['tab', {'active-tab':(activeTap=='prod-setting')}]" id="prod-setting">
                                        <div class="content">
                                            <!-- Title Box -->
                                            <div class="title-box">
                                                <h5>
                                                    {{ $t('profile.change_profile_info') }}
                                                </h5>
                                            </div>

                                            <!-- Profile Form -->
                                            <div class="profile-form">

                                                <!-- Profile Form -->
                                                <form>
                                                    <div class="row clearfix">

                                                        <div class=" col-sm-12 form-group">
                                                            <input type="text" v-model="profile_info.name"
                                                                   :placeholder="$t('register.name')"
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>

                                                        <div class=" col-sm-12 form-group"
                                                             v-if="authUser.type!='visitor'">
                                                            <input type="email" v-model="profile_info.email"
                                                                   :placeholder="$t('register.email') "
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>

                                                        <div class=" col-sm-12 form-group">
                                                            <input type="text" v-model="profile_info.phone"
                                                                   :placeholder="$t('register.phone') "
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>
                                                        <!-- Form Group -->
                                                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                            <label>    {{ $t('register.gov') }} </label>
                                                            <select @change="get_district()" class="form-control"
                                                                    id="sel1" v-model="profile_info.gov_id">
                                                                <option v-for="gov in govs " :value="gov.id">
                                                                    {{gov.name_ar}}
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <!-- Form Group -->
                                                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                            <label>  {{ $t('register.dist') }}  </label>
                                                            <select class="form-control" id="sel2"
                                                                    v-model="profile_info.district_id">
                                                                <option v-for="dist in districts " :value="dist.id">
                                                                    {{dist.name_ar}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <!-- Form Group -->
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <!--                                 v-show="form.userType=='customer' ||form.userType=='seller'">-->
                                                            <label>  {{ $t('register.more_address_info') }} </label>
                                                            <input type="text" name=""
                                                                   v-model="profile_info.more_address_info"
                                                                   id="form_more_address_info"
                                                                   value="">
                                                        </div>
                                                        <div
                                                            class="col-lg-12 col-md-12 col-sm-12 form-group text-right">
                                                            <button class="theme-btn btn-style-three" type="button"
                                                                    @click.prevent="update_user_info()"><span
                                                                class="txt">{{ $t('save') }}  <i
                                                                class="fa fa-angle-left"></i></span></button>
                                                        </div>

                                                    </div>
                                                </form>

                                            </div>

                                        </div>
                                    </div>

                                    <div :class="['tab', {'active-tab':(activeTap=='prod-password')}]">
                                        <div class="content">


                                            <!-- Profile Form -->
                                            <div class="profile-form">

                                                <!-- Profile Form -->
                                                <form>
                                                    <div class="row clearfix">

                                                        <div class=" col-sm-12 form-group">
                                                            <input type="text" v-model="password.current_password"
                                                                   placeholder="كلمة السر القديمة"
                                                                   :placeholder=" $t('profile.current_password')   "
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>


                                                        <div class=" col-sm-12 form-group">
                                                            <input type="text" v-model="password.new_password"
                                                                   :placeholder=" $t('profile.new_password')   "
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>
                                                        <div
                                                            class="col-lg-12 col-md-12 col-sm-12 form-group text-right">
                                                            <button class="theme-btn btn-style-three" type="submit"
                                                                    @click.prevent="changePassword()"
                                                                    name="submit-form"><span class="txt">{{ $t('save') }}  <i
                                                                class="fa fa-angle-left"></i></span></button>
                                                        </div>

                                                    </div>
                                                </form>

                                            </div>

                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </section>
    <!-- End Profile Section -->


</template>

<script>
    import CourseGideItem from './CourseGideItem.vue';
    import store from '../store'
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import ConsultantItem from "./ConsultantItem";
    import axios from "axios";

    export default {
        props: ['items'],
        components: {CourseGideItem, ConsultantItem, Loading},
        data() {
            return {
                isLoading: false,
                district_id: 0,
                govs: [],
                districts: [],
                profile_info: {
                    "name": store.getters.authUser.name,
                    "email": store.getters.authUser.email,
                    "phone": store.getters.authUser.phone,
                    "more_address_info": store.getters.authUser.more_address_info,
                    "gov_id": store.getters.authUser.gov_id,
                    "district_id": store.getters.authUser.district_id
                },
                password: {
                    'current_password': '',
                    'new_password': ''
                },
                categories: [],
                my_consultantData: {
                    data: []
                },
                newPostData: {
                    'id': 0,
                    'is_public': 0,
                    'title': '',
                    'body': '',
                    'category_id': '1',
                },
                my_favData: {
                    data: []
                },
                // my_favData: {},
                my_trainings_data: {
                    data: []
                },
                my_like_trainings: {
                    data: []
                },
                my_complete_trainings_data: {
                    data: []
                },
                fullPage: false,
                activeIndex: null,
                sections: [],
                posts: [],
                course_id: '',
                activeTap: 'prod-overview',
                pagination: {},
                edit: false
            }
        },
        computed: {

            authUser: function () {
                return store.getters.authUser
            }
        },
        created() {
            console.log(store.getters.authUser)

            // if (localStorage.token) {
            //     this.fav_trainings();
            //     this.myConsultant();
            //
            // }
            // this.get_gov();
        },
        methods: {
            changeActive(index) {
                this.activeTap = index;
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
            changeCategoryType(key) {
                this.newPostData.category_id = key;
            },
            onToggle(index) {
                if (this.activeIndex == index) {
                    return (this.activeIndex = null);
                }
                this.activeIndex = index;
            },
            edit_post(key) {
                this.edit = true;
                console.log(this.my_consultantData.data[key]);
                this.active_post = key;
                this.newPostData.title = this.my_consultantData.data[key].title;
                this.newPostData.is_public = this.my_consultantData.data[key].is_public;
                this.newPostData.id = this.my_consultantData.data[key].id;
                this.newPostData.body = this.my_consultantData.data[key].body;
                this.newPostData.category_id = this.my_consultantData.data[key].category_id;
                this.$refs.modal.open();
            },
            delete_post(key) {
                this.isLoading = true;
                var id = this.my_consultantData.data[key].id;
                axios({url: '/api/DePost/' + id, data: {id: this.id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.my_consultantData.data.splice(key, 1);
                            toastStack(resp.data.msg, '', 'success');
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            },
            update_user_info() {
                this.isLoading = true;
                axios({url: '/api/update_profile', data: this.profile_info, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            // this.posts.splice(key, 1);
                            let user = store.getters.authUser;
                            user.name = this.profile_info.name;
                            user.email = this.profile_info.email;
                            user.phone = this.profile_info.phone;
                            user.more_address_info = this.profile_info.more_address_info;
                            user.gov_id = this.profile_info.gov_id;
                            user.district_id = this.profile_info.district_id;
                            localStorage.setItem('user', JSON.stringify(user));
                            toastStack(resp.data.msg, '', 'success');
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            },
            changePassword() {
                this.isLoading = true
                if (this.password.new_password.length < 6)
                    toastStack('   خطاء ', 'كلمة السر يجب ان تكون على الاقل 5 ارقام وحروف', 'error');
                else {

                    axios({url: '/api/changePassword', data: this.password, method: 'POST'})
                        .then(resp => {
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                toastStack(resp.data.msg, '', 'success');
                            }
                            this.isLoading = false;
                        })
                        .catch(err => {
                            this.isLoading = false;
                            console.log(err)
                        })
                }
            },
            getmyfav_courses(page = 1) {
                axios.post('api/AllPosts?page=' + page)
                    .then(response => {
                        this.laravelData = response.data.Posts;
                    });
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
            fav_trainings(page = 1) {
                axios({url: 'api/my_likes_page?page=' + page, data: {type: 'trainings'}, method: 'POST'})
                    .then(response => {
                        this.my_like_trainings = response.data.data;
                    });
            },
            my_trainings(page = 1) {
                axios({url: 'api/myTraining?page=' + page, data: {type: 'in_progress'}, method: 'POST'})
                    .then(response => {
                        this.my_trainings_data = response.data.Trainings;
                    });
            },
            my_complete_trainings(page = 1) {
                axios({url: 'api/myTraining?page=' + page, data: {type: 'complete'}, method: 'POST'})
                    .then(response => {
                        this.my_complete_trainings_data = response.data.Trainings;
                    });
            },
            myConsultant(page = 1) {
                axios({url: 'api/myPosts_pages?page=' + page, method: 'POST'})
                    .then(response => {
                        this.my_consultantData = response.data.data;
                    });
            },
            get_district() {
                axios({url: '/api/get_district', data: {"gov_id": this.profile_info.gov_id}, method: 'POST'})
                    .then(resp => {
                        this.districts = (resp.data.data);
                        // this.profile_info.district_id = this.districts[0].id;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            get_gov() {
                axios({url: '/api/get_gov', method: 'POST'})
                    .then(resp => {
                        this.govs = (resp.data.data);
                        // this.profile_info.gov_id = this.govs[0].id;
                        this.get_district()
                    })
                    .catch(err => {
                        console.log(err)
                    })
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
                                this.my_consultantData.data.unshift(resp.data.data);
                                toastStack(resp.data.msg, '', 'success');
                                this.newPostData = {
                                    'title': '',
                                    'body': '',
                                    'is_public': 0,
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
                                this.my_consultantData.data[this.active_post] = (resp.data.data);
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

            onCancel() {
                console.log('User cancelled the loader.')
            }

        },

        mounted() {
            console.log('Component mounted.')
            this.fav_trainings();
            this.myConsultant();
            this.my_trainings();
            this.get_gov();
            this.fetchCategories();

        },


    }
</script>

<style>
    .student-profile-section {

        padding: 140px 0px 90px;
        background-color: #f0f5fb;
        margin-top: 50px;
    }

    .student-profile-section .profile-tabs .tab-btns {
        border-bottom: 3px solid #593c97;
    }
</style>

