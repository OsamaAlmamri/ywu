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
                                    {{ $t('MENU.for_help') }}
                               :</span><a style="font-size: 19px" href="tel:+967778998366">
                                778998366 967+</a></li>
                        </ul>

                    </div>

                    <!-- Top Right -->
                    <div class="top-left pull-left clearfix">
                        <!-- Login Nav -->
                        <ul class="login-nav">
                            <li class="navbar-default">
                                <a href="#" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false"> <sup
                                    class="badge badge-primary">{{ notifications_total }} </sup>
                                    <i
                                        class="fa fa-bell-o"></i>
                                </a>
                                <ul class="dropdown-menu notify-drop">
                                    <div class="notify-drop-title">
                                        <div class="row">

                                            <!--                                            <div class="col-md-6 col-sm-6 col-xs-6 text-right">-->
                                            <!--                                                <a href=""-->
                                            <!--                                                   class="rIcon allRead"-->
                                            <!--                                                   data-tooltip="tooltip"-->
                                            <!--                                                   data-placement="bottom"-->
                                            <!--                                                   title="tümü okundu."><i-->
                                            <!--                                                    class="fa fa-bell-o"></i></a>-->
                                            <!--                                            </div>-->
                                        </div>
                                    </div>
                                    <!-- end notify title -->
                                    <!-- notify content -->
                                    <div class="drop-content">
                                        <li v-for="notification in notifications">
                                            <div class="media  p-1" style="">

                                                <img :src="notification.sender_image" alt=""
                                                     class="mr-3 me-2 img-thumbnail"
                                                     style="width:45px;">
                                                <div class="media-body">
                                                    <div class="content-box">
                                                        <div class="box-inner  mt-2">
                                                            <h5 class="d-flex justify-content-between">
                                                               <span style="flex-shrink: 1;">
                                                                    {{ notification.sender_name }}
                                                               </span>
                                                                <small class="" style="flex-shrink: 4;">
                                                                    {{ notification.created_at }}


                                                                    <i class="fa fa-clock-o"> </i>
                                                                </small>
                                                            </h5>

                                                            <div>
                                                                {{ notification.message }}
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>
                                        <infinite-loading @infinite="getNotifications"></infinite-loading>
                                    </div>
                                    <div class="notify-drop-footer text-center">
                                        <a href=""><i class="fa fa-eye"></i> تحديد الكل كمقروءة </a>
                                    </div>
                                </ul>
                            </li>
                            <li :class="[{'login-nav_active':currentMenu!='register'}]"
                                @click="$scrollToTop" v-if="!isLoggedIn">

                                <router-link to="/login">
                                    {{ $t('MENU.login') }}
                                </router-link>
                            </li>
                            <li @click="$scrollToTop" v-if="!isLoggedIn"
                                :class="[{'login-nav_active':currentMenu=='register'}]"
                            >
                                <router-link to="/register">
                                    {{ $t('MENU.register') }}
                                </router-link>
                            </li>
                            <li>
                                <router-link @click.native="scrollToTop()" v-if="isLoggedIn" to="/profile">

                                </router-link>
                            </li>

                            <li :class="[{'login-nav_active':currentMenu!='profile'}]" @click="$scrollToTop"
                                v-if="isLoggedIn">
                                <router-link to="/logout"> {{ $t('MENU.logout') }}
                                </router-link>
                            </li>
                            <li :class="[{'login-nav_active':currentMenu=='profile'}]" @click="$scrollToTop"
                                v-if="isLoggedIn">
                                <router-link to="/profile">
                                    {{ $t('MENU.profile') }}
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
                                    <li
                                        v-if="isLoggedIn"

                                        :class="['dropdown' , {'shop_drown':(currentMenu=='shop'|| currentMenu=='my_orders'
                                     || currentMenu=='CategoryProducts' || currentMenu=='home' || currentMenu=='home2' || currentMenu=='shop_search'|| currentMenu=='course_details'||
                                     currentMenu=='shop_like' ||currentMenu=='cart')},{'current':currentMenu=='shop'}]">
                                        <a href="#">
                                            {{ $t('MENU.shop') }}

                                        </a>
                                        <ul style="display: inherit">
                                            <li :class="['shop_element_item',{'current':currentMenu=='shop'}]">
                                                <router-link @click.native="scrollToTop()" to="/shop">

                                                    {{ $t('MENU.home') }}
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentMenu=='my_orders'}]">
                                                <router-link @click.native="scrollToTop()"
                                                             to="/my_orders" v-if="isLoggedIn">

                                                    {{ $t('MENU.my_orders') }}
                                                </router-link>
                                            </li>
                                            <!--                                            <li :class="['shop_element_item',{'current':currentMenu=='shop_search'}]">-->
                                            <!--                                                <router-link @click.native="scrollToTop()"-->
                                            <!--                                                             to="/shop_search">-->

                                            <!--                                                    {{$t('MENU.shop_search') }}-->
                                            <!--                                                </router-link>-->
                                            <!--                                            </li>-->
                                            <li :class="['shop_element_item',{'current':currentMenu=='shop_like'}]">
                                                <router-link @click.native="scrollToTop()"
                                                             to="/shop_like" v-if="isLoggedIn">

                                                    {{ $t('MENU.shop_like') }}
                                                </router-link>
                                            </li>
                                            <li :class="['shop_element_item',{'current':currentMenu=='cart'}]">
                                                <router-link @click.native="scrollToTop()" to="/cart" v-if="isLoggedIn">

                                                    {{ $t('MENU.cart') }}
                                                </router-link>
                                            </li>

                                        </ul>
                                    </li>
                                    <li v-if="!isLoggedIn" :class="[{'current':currentMenu=='shop'}]">
                                        <router-link @click.native="scrollToTop()" to="/shop">
                                            {{ $t('MENU.shop') }}
                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentMenu=='courses'}]">
                                        <router-link @click.native="scrollToTop()" to="/courses">
                                            {{ $t('MENU.courses') }}
                                        </router-link>
                                    </li>


                                    <li :class="[{'current':currentMenu=='consultant'}]">
                                        <router-link @click.native="scrollToTop()" to="/consultant">
                                            {{ $t('MENU.consultant') }}

                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentMenu=='ForwordConsultant'}]"
                                        v-if="isLoggedIn && authUser.permissions.foreword_consultant==1">
                                        <router-link @click.native="scrollToTop()" to="/forwordConsultant">
                                            {{ $t('MENU.forwordConsultant') }}

                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentMenu=='women'}]">
                                        <router-link @click.native="scrollToTop()" to="/women">
                                            {{ $t('MENU.women') }}

                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentMenu=='privacy'}]">
                                        <router-link @click.native="scrollToTop()" to="/privacy">
                                            {{ $t('MENU.privacy') }}

                                        </router-link>
                                    </li>
                                    <li :class="[{'current':currentMenu=='concatUs'}]">
                                        <router-link @click.native="scrollToTop()" to="/concatUs">
                                            {{ $t('MENU.concatUs') }}
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
import InfiniteLoading from 'vue-infinite-loading'

export default {
    name: "Header",
    components: {
        DropdownLanguage,
        InfiniteLoading
    },

    data() {
        return {
            notifications: [],
            interval: null,
            currentPage: 0,
            notifications_total: 0
        }
    },

    methods: {
        logout: function () {
            this.$store.dispatch('logout')
                .then(() => {
                    this.$router.push('/home')
                })
        },


        toggleNotificationsPanel: function () {
            this.$emit('toggleNotificationsPanel')
        },
        getNotifications: function ($state) {
            this.currentPage += 1
            axios({url: '/api/notification?page=' + this.currentPage, method: 'POST'})
                .then(response => {
                    // this.$emit('showUnreadNotificationCount', response.data.data.unread_count)
                    console.log(response.data.data.data)
                    if (response.data.data.data.length) {
                        response.data.data.data.forEach(i => {
                            this.notifications.push(i)
                        })
                        if ($state !== undefined) {
                            $state.loaded()
                        }
                    } else {
                        if ($state !== undefined) {
                            $state.complete()
                        }
                    }
                    // Assign current page just for redundancy's sake
                    this.currentPage = response.data.data.current_page
                    this.notifications_total = response.data.data.total
                })
        },
        refresh() {
            this.currentPage = 0;
            this.notifications = [];
            this.getNotifications();
        },
        listenForNotifications() {


            // window.userPrivateChannel
            //     .notification((notification) => {
            //         // Increment the unread count
            //         this.$emit('incrementUnreadCount')
            //         // Add the notification to the top
            //         this.notifications.unshift(notification)
            //         // Show a toast
            //         this.$toasted.show(notification.data.message, {type: notification.data.level})
            //     })
        }
    },
    created() {
        this.getNotifications()
        this.listenForNotifications()
    },

    computed: {
        isLoggedIn: function () {
            return store.getters.isLoggedIn
        },
        authUser: function () {

            return store.getters.authUser
        },
        currentMenu: function () {
            return this.$route.name
        }
    },


};
</script>
