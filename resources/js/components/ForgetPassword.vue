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
                    <h2> {{ $t('MENU.ForgetPassword') }} </h2>

                </div>


                <div class="styled-form">
                    <form method="post" autocomplete="off" @submit.prevent="login">
                        <div class="form-group">
                            <label>{{ $t('register.email') }}</label>
                            <input type="email" v-model="form.email" :placeholder=" $t('register.email') " required="">
                        </div>

                        <div class="form-group">
                            <div class="clearfix">
                                <div class="d-flex justify-content-around">
                                    <div class="check-box">
                                        {{ $t('register.has_account') }}
                                        <router-link to="/login">
                                            {{ $t('MENU.login') }}
                                        </router-link>
                                    </div>
                                    <div class="check-box">
                                        <router-link to="register"> {{ $t('login.register') }}</router-link>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="button" @click="login()" class="theme-btn btn-style-three"><span class="txt">
                                {{ $t('MENU.ForgetPassword') }}
                                 <i
                                     class="fa fa-angle-left"></i></span></button>
                        </div>
                        <div class="form-group">
                            <div class="users">
                                {{ $t('login.have_account') }}
                                <router-link to="register"> {{ $t('login.register') }}</router-link>
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
import axios from "axios";

export default {
    components: {Loading},

    data() {
        return {
            isLoading: false,
            fullPage: true,
            form: {
                email: '',
            },
            errors: []
        }
    },
    mounted() {
        //
    },
    methods: {
        login: function () {
            this.isLoading = true;
            axios({url: '/api/forget_password', data: this.form, method: 'POST'})
                .then(resp => {
                    this.isLoading = false;
                    if (resp.data.status == false) {
                        toastStack('   خطاء ', resp.data.msg, 'error');
                    } else {
                        toastStack(resp.data.msg, '', 'success');
                        this.$router.push('/ResetPassword')
                    }
                })
                .catch(err => {
                    console.log(err)
                })
        }, onCancel() {
        }
    },

}
</script>
