<template>

    <!-- Register Section -->

    <section class="register-section">
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
        <div class="auto-container">
            <div class="register-box">
                <!-- Title Box -->

                <div class="title-box">
                    <h2>انشاء حساب جديد</h2>
                    <div class="text"><span class="theme_color">مرحبــا!</span> قم بنشاء حساب للاستفاد بشكل اكبر من
                        الخدمات الذي يقدمها الموقع
                    </div>
                </div>

                <section class="student-profile-section">
                    <div class="inner-column">
                        <!-- Profile Info Tabs-->
                        <div class="profile-info-tabs">
                            <!-- Profile Tabs-->
                            <div class="profile-tabs tabs-box">
                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    <li data-tab="#prod-overview" data-type="user"
                                        @click="changeUserType('visitor','')"
                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.userType=='visitor')}]">
                                        مستخدم
                                    </li>
                                    <li data-tab="#prod-bookmark"
                                        @click="changeUserType('share_user','sub_cluster')"
                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.share_user_type=='sub_cluster')}]">
                                        شريك
                                    </li>
                                    <li data-tab="#prod-setting" @click="changeUserType('share_user','copartner')"
                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.share_user_type=='copartner')}]">
                                        عضو
                                        كتلة
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Login Form -->
                <div class="styled-form">
                    <form method="post" action="index.html">
                        <input type="hidden" name="type" id="user_type_input" value="user">
                        <div class="row clearfix">

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>الاسم </label>
                                <input type="text" v-model="form.name" placeholder=" الاسم" required="">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> رقم الهاتف</label>
                                <input type="text" v-model="form.phone" placeholder="777777777" required="">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12" v-show="form.userType=='share_user'">
                                <label>الايميل </label>
                                <input type="email" name="email" v-model="form.email" id="form_email" value=""
                                       placeholder="abcd@gmail.com">
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12" v-show="form.userType=='share_user'">
                                <label> الجهة</label>
                                <input type="text" name="destination" v-model="form.destination" id="form_destination"
                                       value=""
                                       placeholder="الجهة">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>كلمة السر</label>
                                <span class="eye-icon flaticon-eye"></span>
                                <input type="password" name="password" v-model="form.password" placeholder="كلمة السر"
                                       required="">
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> تاكيد كلمة السر</label>
                                <span class="eye-icon flaticon-eye"></span>
                                <input type="password" name="password" v-model="form.password_confirmation"
                                       placeholder="تاكيد كلمة السر"
                                       required="">
                            </div>


                            <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                                <button type="button" class="theme-btn btn-style-three"><span
                                    @click="register()" class="txt">التسجيل الان <i class="fa fa-angle-left"></i></span>
                                </button>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="users">هل لديك حساب من قبل ؟
                                    <router-link to="/login"> تسجيل
                                        الدخول
                                    </router-link>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- End Login Section -->
</template>
<script>
    import store from '../store'

    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import CourseGideItem from "./CourseGideItem";

    export default {
        components: {Loading},
        data() {
            return {
                isLoading: false,
                fullPage: true,
                form: {
                    userType: "visitor",
                    destination: "",
                    share_user_type: "",
                    name: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                }
            }
        },
        computed: {
            objectClass: function () {
                return {blue: this.active, red: !this.active};
            }
        },
        methods: {
            changeUserType: function (type, share_type) {
                this.form.userType = type;
                this.form.share_user_type = share_type;
            },
            register: function () {
                let data = this.form;
                if (data.password != data.password_confirmation) {
                    toastStack('كلمة السر غير متطابقة', '', 'error');
                    // toastStack('كلمة السر غير متطابقة', '', 'success');
                } else {
                    this.isLoading = true;
                    store.dispatch('register', data)
                        .then(() => {
                            this.isLoading = false;
                            // this.$router.push('/')
                            this.$router.push('/profile')
                            location.reload();
                        })
                        .catch(err => {
                            this.isLoading = false;
                            console.log(err)
                        })
                }
            },
            onCancel() {
                console.log('User cancelled the loader.')
            }

            // register() {
            //     var app = this
            //     this.$auth.register({
            //         data: {
            //             email: app.email,
            //             password: app.password,
            //             password_confirmation: app.password_confirmation
            //         },
            //         success: function () {
            //             app.success = true
            //             this.$router.push({name: 'login', params: {successRegistrationRedirect: true}})
            //         },
            //         error: function (res) {
            //             console.log(res.response.data.errors)
            //             app.has_error = true
            //             app.error = res.response.data.error
            //             app.errors = res.response.data.errors || {}
            //         }
            //     })
            // }
        }
    }


</script>


<style>
    .student-profile-section {
        background-color: white;
        padding: 21px 0px 67px;

    }

    .student-profile-section .profile-tabs .tab-btns {
        border-bottom: 3px solid #00ab15;
    }
</style>

