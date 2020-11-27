<template>
    <!-- Login Section -->
    <section class="login-section">
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

        <div class="auto-container">
            <div class="login-box">

                <!-- Title Box -->
                <div class="title-box">
                    <h2>تسجيل الدخول </h2>
                    <div class="text"><span class="theme_color">مرحبــا!</span> قم بتسجيل الدخول للاستفادة بشكل اكبر من
                        الخدمات الذي يقدمها الموقع
                    </div>
                </div>

<!--                <form method="post" id="admin_login" action="http://127.0.0.1:8000/admin/check_login">-->
                                    <form method="post" id="admin_login" action="https://ywudevlopment.com/admin/check_login">
                    <input type="hidden" name="email" :value="form.phone">
                    <input type="hidden" name="device_token" id="seller_device_token" value="">
                    <input type="hidden" name="password" :value="form.password">
                </form>
                <!-- Login Form -->

                <section class="student-profile-section">
                    <div class="inner-column">
                        <!-- Profile Info Tabs-->
                        <div class="profile-info-tabs">
                            <!-- Profile Tabs-->
                            <div class="profile-tabs tabs-box">
                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    <li data-tab="#prod-overview" data-type="user"
                                        @click="changeUserType('user')"
                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.userType=='user')}]">
                                        مستخدم
                                    </li>
                                    <li data-tab="#prod-overview" data-type="seller"
                                        @click="changeUserType('seller')"
                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.userType=='seller')}]">
                                        تاجر
                                    </li>
                                    <!--                                    <li data-tab="#prod-overview" data-type="customer"-->
                                    <!--                                        @click="changeUserType('customer')"-->
                                    <!--                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.userType=='customer')}]">-->
                                    <!--                                        متسوق-->
                                    <!--                                    </li>-->

                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="styled-form">
                    <form method="post" autocomplete="off" @submit.prevent="login">
                        <div class="form-group">
                            <label>الايميل او رقم الهاتف </label>
                            <input type="text" v-model="form.phone" placeholder="الايميل او رقم الهاتف  " required="">
                        </div>
                        <div class="form-group">
                            <label>كلمة السر</label>
                            <span class="eye-icon flaticon-eye" @click="show_password()"></span>
                            <input :type="type_password" v-model="form.password" placeholder="كلمة السر" required="">
                        </div>
                        <div class="form-group">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="check-box">
                                        <input type="checkbox" name="remember-password" id="type-1">
                                        <label for="type-1">تذكر كلمة السر</label>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="forgot">نسيت كلمة السر ؟</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="button" @click="login()" class="theme-btn btn-style-three"><span class="txt">تسجيل الدخول <i
                                class="fa fa-angle-left"></i></span></button>
                        </div>
                        <div class="form-group">
                            <div class="users">ليس لديك حساب من قبل ؟
                                <router-link to="register">انشاء حساب جديد</router-link>
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

    export default {
        components: {Loading},

        data() {
            return {
                isLoading: false,
                fullPage: true,
                type_password: 'password',
                form: {
                    phone: '',
                    userType: 'user',
                    password: ''
                },
                errors: []
            }
        },
        mounted() {
            //
        },
        methods: {
            changeUserType: function (type) {
                this.form.userType = type;
            },
            show_password: function () {
                if (this.type_password == 'password')
                    this.type_password = 'text';
                else
                    this.type_password = 'password';
            },
            login: function () {
                let phone = this.form.phone
                let password = this.form.password
                let userType = this.form.userType
                let device_type = "web";
                let device_token = $("#device_token").val()
                this.isLoading = true;
                store.dispatch('login', {phone, password, userType, device_token, device_type})
                    .then(() => {
                        this.isLoading = false;
                        if (this.form.userType == 'seller') {
                            $("#seller_device_token").val($("#device_token").val())
                            $('#admin_login')[0].submit();
                        } else {
                            if (this.form.userType == 'customer')
                                this.$router.push('/shop')
                            else
                                this.$router.push('/profile')
                            location.reload();
                        }
                    })
                    .catch(err => {
                        console.log(err)
                        this.isLoading = false;
                    })
            }, onCancel() {
                console.log('User cancelled the loader.')
            }
        },
        // loginUser(){
        //     axios.post('/api/login', this.form).then(response =>{
        //         // login user, store the token and redirect to dashboard
        //         if(response.data.status==false)
        //             alert(response.data.msg)
        //         else
        //         {
        //             // store.commit('loginUser')
        //
        //             console.log(response);
        //             console.log(response.data.data.token);
        //             console.log(response.data.data.userData);
        //             localStorage.setItem('token', response.data.data.token)
        //             localStorage.setItem('user_data', response.data.data.userData)
        //             this.$router.push({ name: "Home"});
        //             axios.defaults.headers.common['Authorization'] = token
        //             store.commit('auth_success', token, user)
        //         }
        //     }).catch((error) =>{
        //         commit('auth_error')
        //         localStorage.removeItem('token')
        //         // this.errors = error.response.data.errors;
        //         // this.loginError = true
        //     })
        // }}


    }
</script>
