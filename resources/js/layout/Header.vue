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
                            <li><span>
                                    {{$t('MENU.for_help') }}
                               :</span><a style="font-size: 19px" href="tel:+967778998366">
                                778998366 967+</a></li>
                        </ul>

                    </div>

                    <!-- Top Right -->
                    <div class="top-left pull-left clearfix">
                        <!-- Login Nav -->
                        <ul class="login-nav">
                            <li :class="[{'login-nav_active':currentPage!='register'}]"
                                @click="$scrollToTop" v-if="!isLoggedIn">

                                <router-link to="/login">
                                    {{$t('MENU.login') }}
                                    </router-link>
                            </li>
                            <li @click="$scrollToTop" v-if="!isLoggedIn"
                                :class="[{'login-nav_active':currentPage=='register'}]"
                            >
                                <router-link to="/register">
                                    {{$t('MENU.register') }}
                                    </router-link>
                            </li>
                            <li>
                                <router-link @click.native="scrollToTop()" v-if="isLoggedIn" to="/profile">

                                </router-link>
                            </li>

                            <li :class="[{'login-nav_active':currentPage!='profile'}]" @click="$scrollToTop"
                                v-if="isLoggedIn">
                                <router-link to="/logout">    {{$t('MENU.logout') }}
                                   </router-link>
                            </li>
                            <li :class="[{'login-nav_active':currentPage=='profile'}]" @click="$scrollToTop"
                                v-if="isLoggedIn">
                                <router-link to="/profile">
                                    {{$t('MENU.profile') }}
                                    </router-link>
                            </li>
                            <dropdown-language v-if="$route.name!='women_details'"></dropdown-language>

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
                        <div class="logo"
                        ><a href="#" class="">
                            <img width="50" src="site/images/logo_white.png" alt=""
                                 title=" Yemen Women Union Developments"></a></div>
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
                                    <li :class="['dropdown' , {'shop_drown':(currentPage=='shop'|| currentPage=='my_orders'
                                     || currentPage=='CategoryProducts' || currentPage=='home' || currentPage=='home2' || currentPage=='shop_search'|| currentPage=='course_details'||
                                     currentPage=='shop_like' ||currentPage=='cart')},{'current':currentPage=='shop'}]">
                                        <a href="#">
                                            {{$t('MENU.shop') }}

                                        </a>
                                        <ul style="display: inherit">
                                            <li :class="['shop_element_item',{'current':currentPage=='shop'}]">
                                                <router-link @click.native="scrollToTop()" to="/shop">

                                                    {{$t('MENU.home') }}
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentPage=='my_orders'}]">
                                                <router-link @click.native="scrollToTop()"
                                                             to="/my_orders" v-if="isLoggedIn">

                                                    {{$t('MENU.my_orders') }}
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentPage=='shop_search'}]">
                                                <router-link @click.native="scrollToTop()"
                                                             to="/shop_search">

                                                    {{$t('MENU.shop_search') }}
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentPage=='shop_like'}]">
                                                <router-link @click.native="scrollToTop()"
                                                             to="/shop_like" v-if="isLoggedIn">

                                                    {{$t('MENU.shop_like') }}
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentPage=='cart'}]">
                                                <router-link @click.native="scrollToTop()" to="/cart" v-if="isLoggedIn">

                                                    {{$t('MENU.cart') }}
                                                </router-link>
                                            </li>

                                        </ul>
                                    </li>

                                    <li :class="[{'current':currentPage=='courses'}]">
                                        <router-link @click.native="scrollToTop()" to="/courses">
                                            {{$t('MENU.courses') }}
                                            </router-link>
                                    </li>

                                    <li :class="[{'current':currentPage=='consultant'}]">
                                        <router-link @click.native="scrollToTop()" to="/consultant">
                                            {{$t('MENU.consultant') }}

                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentPage=='ForwordConsultant'}]"    v-if="isLoggedIn">
                                        <router-link @click.native="scrollToTop()" to="/ForwordConsultant">
                                            {{$t('MENU.ForwordConsultant') }}

                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentPage=='women'}]">
                                        <router-link @click.native="scrollToTop()" to="/women">
                                            {{$t('MENU.women') }}

                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentPage=='privacy'}]">
                                        <router-link @click.native="scrollToTop()" to="/privacy">
                                            {{$t('MENU.privacy') }}

                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentPage=='concatUs'}]">
                                        <router-link @click.native="scrollToTop()" to="/concatUs">
                                            {{$t('MENU.concatUs') }}
                                        </router-link>
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
                    <router-link @click.native="scrollToTop()" to="/home"></router-link>
                    <img
                        style="width: 130px;    margin-bottom: -30px;" src="site/images/logo_white.png"
                        alt=""
                        title=""></div>
                <div class="menu-outer">
                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                </div>
            </nav>
        </div>
        <!-- End Mobile Menu -->

    </header>
</template>
i
<script>
import DropdownLanguage from './DropdownLanguage'
import store from "../store";

export default {
    name: "Header",
    components: {
        DropdownLanguage,
    },

    computed: {
        isLoggedIn: function () {
            return store.getters.isLoggedIn
        },
        authUser: function () {
            return store.getters.authUser
        },
        currentPage: function () {
            return this.$route.name
        }
    },
    methods: {
        // scrollToTop: function () {
        //     window.scrollTo(0, 0);
        //     const div =  document.querySelector('body');
        //     div.classList.remove('mobile-menu-visible');
        //
        // },
        logout: function () {
            this.$store.dispatch('logout')
                .then(() => {
                    this.$router.push('/home')
                })
        }
    },
};
</script>
