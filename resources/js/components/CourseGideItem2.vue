<template>

    <div class="inner-box">
        <div class="image">

            <router-link @click.native="$scrollToTop" :to="{ name: 'course_details', params: { id: training.id}}">
                <clazy-load class="wrapper" :src="BaseImagePath +training.thumbnail">
                    <transition name="fade">
                        <div class="divClass"
                            v-bind:style="{ backgroundImage: 'url('+BaseImagePath +training.thumbnail+')' }">
                        </div>
<!--                        <div>-->
<!--                            <div class="thumbnail">-->
<!--                                <div class="thumb">-->
<!--                                    <a v-bind:href="BaseImagePath + training.thumbnail"-->
<!--                                       data-lightbox="1" data-title="My caption 1">-->
<!--                                        <img v-bind:src="BaseImagePath + training.thumbnail"-->
<!--                                             width="100%" alt="" class="img-fluid img-thumbnail">-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </transition>
                    <transition name="fade" slot="placeholder">
                        <div class="vue_preloader">
                            <div class="circle">
                                <div class="circle-inner"></div>
                            </div>
                        </div>
                    </transition>
                </clazy-load>
            </router-link>
        </div>
        <div class=" after_course_image d-flex justify-content-around">
            <div >
                <div class=" students"><i class="fa fa-star"></i> {{(training.average_rating)}}/5</div>
            </div>
            <div >
                <like-button type="trainings" :key="training.id" count-likes="0" has-count="0"
                             :liked_id="training.id" :is_liked="training.is_like"></like-button>
            </div>
        </div>

        <div class="lower-content">
            <h6 class="text-center" style="min-height: 3rem">
                <router-link @click.native="$scrollToTop" :to="{ name: 'course_details', params: { id: training.id}}">
                    {{training.name}}
                </router-link>
            </h6>

<!--            <h6 v-show="training.instructor!=null">-->
            <h6 class="d-flex justify-content-start">
                <img src="/site/images/instructor.png" style="width: 9%">
                {{training.instructor}}
            </h6>

            <div class="clearfix">
                <!--                <div class="pull-right">-->
                <!--                    <div class=" students" :disabled="!training.can_register">-->
                <!--                        <button @click="registerInCourse()" class="btn btn-secondary btn_course_register">-->
                <!--                            {{registerDecription}}-->
                <!--                        </button>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="">
                    <div class="students hours">
                        <button class="btn btn-primary btn_course_type"> {{training.type}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import LikeButton from './LikeButton.vue';
    import axios from "axios";
    import i18n from "./../plugins/vue-i18n";

    export default {
        props: ['training'],
        components: {LikeButton},
        computed: {
            registerDecription() {
                if (this.training.is_register == null)
                return i18n.t('training.register');
                else if (this.training.is_register.status == 0)
                    return i18n.t('training.cancel_register');
                else
                    return i18n.t('training.cancel_register');

            }
        },
        methods: {
            registerInCourse() {
                if (localStorage.token) {
                    axios({
                        url: '/api/register_to_training', data: {
                            training_id: this.training.id
                        }, method: 'POST'
                    }).then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.training.is_register = resp.data.data;
                            toastStack(resp.data.msg, '', 'success');
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
                this.$emit('click', this.$vnode.key)
            },
            toggle() {
                this.$emit('toggled', this.$vnode.key)
            }
        }
    }
</script>
