<template>

        <header class="main-header header-style-one">

            <!-- Header Top -->
            <div class="header-top">
                <div class="auto-container">
                    <div class="clearfix">

                        <!-- Top Left -->
                        <div class="top-right pull-right clearfix">

                            <!-- Info List -->
                            <ul class="info-list">
                                <li><span>الخط الساخن:</span><a href="tel:8000999"> 01 8000999</a></li>
                                <!--							<li><span>Email Us:</span><a href="mailto:info@yourcompany.com"> info@yourcompany.com</a></li>-->
                            </ul>
<!--                            <router-link to="/">Home</router-link>-->
<!--                            |-->
<!--                            <router-link to="/about">About</router-link>-->
<!--                            <span v-if="isLoggedIn"> | <a @click="logout">Logout</a></span>-->

                        </div>

                        <!-- Top Right -->
                        <div class="top-left pull-left clearfix">
                            <!-- Login Nav -->
                            <ul class="login-nav">
                                <li v-if="!isLoggedIn">
                                    <router-link to="/login"> تسجيل الدخول</router-link>
                                </li>
                                <li v-if="!isLoggedIn">
                                    <router-link to="/register"> انشاء حساب</router-link>
                                </li>

                                <li v-if="isLoggedIn">
                                    <router-link to="/logout"> تسجيل الخروج</router-link>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Header Upper -->
            <div class="header-upper">
                <div class="auto-container">
                    <div class="clearfix">

                        <div class="pull-right logo-box">
                            <div class="logo"><a href="index.html">
                                <img width="50" src="/site/images/Logo250px.png" alt=""
                                     title="Bootcamp"></a></div>
                        </div>
                        <div class="nav-outer clearfix">
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>
                            <!-- Main Menu -->
                            <nav class="main-menu show navbar-expand-md">
                                <div class="navbar-header">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>

                                <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                    <ul class="navigation clearfix">
                                        <li>
                                            <router-link v-if="isLoggedIn" to="/profile"> الصفحة الشخصية</router-link>
                                        </li>
                                        <li>
                                            <router-link to="/home"> الرئيسية</router-link>
                                        </li>
                                        <li>
                                            <router-link to="/courses"> التدريب</router-link>
                                        </li>


                                        <li>
                                            <router-link to="/consultant"> الاستشارات</router-link>
                                        </li>
                                        <li>
                                            <router-link to="/women"> شوؤن المرأة</router-link>
                                        </li>
                                        <li>
                                            <router-link to="/privacy"> سياية الخصوصية</router-link>
                                        </li>
                                        <li>
                                            <router-link to="/concatUs"> تواصل معنا</router-link>
                                        </li>
                                    </ul>
                                </div>

                            </nav>

                        </div>

                    </div>
                </div>
            </div>
            <!-- End Header Upper -->

            <!-- Mobile Menu  -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><span class="icon flaticon-multiply"></span></div>

                <nav class="menu-box">
                    <div class="nav-logo" style="text-align: center">
                        <router-link to="/home"></router-link>
                        <img
                            style="width: 130px;    margin-bottom: -30px;" src="/site/images/Logo250px.png"
                            alt=""
                            title=""></a></div>
                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>
                </nav>
            </div>
            <!-- End Mobile Menu -->

        </header>

</template>

<script>
    import store from '../store'
    export default {
        computed: {
            isLoggedIn: function () {
                return store.getters.isLoggedIn
            }
        },
        methods: {
            logout: function () {
                this.$store.dispatch('logout')
                    .then(() => {
                        this.$router.push('/login')
                    })
            }
        },
    }
</script>
