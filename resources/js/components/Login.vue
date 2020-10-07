<template>
    <!-- Login Section -->
    <section class="login-section">
        <div class="auto-container">
            <div class="login-box">

                <!-- Title Box -->
                <div class="title-box">
                    <h2>تسجيل الدخول </h2>
                    <div class="text"><span class="theme_color">مرحبــا!</span> قم بتسجيل الدخول للاستفادة  بشكل اكبر من الخدمات الذي يقدمها الموقع</div>
                </div>

                <!-- Login Form -->
                <div class="styled-form">
                    <form method="post" autocomplete="off" @submit.prevent="loginUser" >
                        <div class="form-group">
                            <label>الايميل او رقم الهاتف </label>
                            <input type="text"  v-model="phone"  placeholder="الايميل او رقم الهاتف  " required="">
                        </div>
                        <div class="form-group">
                            <label>كلمة السر</label>
                            <span class="eye-icon flaticon-eye"></span>
                            <input type="password"   v-model="password"  placeholder="كلمة السر" required="">
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
                            <button type="button" @click="loginUser()" class="theme-btn btn-style-three"><span class="txt">تسجيل الدخول <i class="fa fa-angle-left"></i></span></button>
                        </div>
                        <div class="form-group">
                            <div class="users">ليس لديك حساب من قبل ؟ <router-link to="register">انشاء حساب جديد</router-link></div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- End Login Section -->


</template>
<script>
    export default {
        data() {
            return {
                phone: null,
                password: null,
                has_error: false
            }
        },
        mounted() {
            //
        },
        methods: {
            login() {
                // get the redirect object
                var redirect = this.$auth.redirect()
                var app = this
                this.$auth.login({
                    params: {
                        email: app.email,
                        password: app.password
                    },
                    success: function() {
                        // handle redirection
                        const redirectTo =  'profile'
                        this.$router.push({name: redirectTo})
                    },
                    error: function() {
                        app.has_error = true
                    },
                    rememberMe: true,
                    fetchUser: true
                })
            }
        }
    }
</script>
