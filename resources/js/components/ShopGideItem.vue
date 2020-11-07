<template>

    <div class="inner-box">
        <div class="image">
                <clazy-load class="wrapper" :src=" training.image">
                    <transition name="fade">
                        <div class="divClass"
                             v-bind:style="{ backgroundImage: 'url('+ training.image + ')' }">
                        </div>
                    </transition>
                    <transition name="fade" slot="placeholder">
                        <div class="vue_preloader">
                            <div class="circle">
                                <div class="circle-inner"></div>
                            </div>
                        </div>
                    </transition>
                </clazy-load>

        </div>
        <div class="clearfix after_course_image">
            <div class="pull-right" style="padding-right: 2em">
                <div class=" students"><i class="fa fa-star"></i>5/5</div>
            </div>
            <div class="pull-left" style="padding-left: 2em">
                <like-button type="trainings" :key="training.id" count-likes="0" has-count="0"
                             :liked_id="training.id" :is_liked="training.is_like"></like-button>
            </div>
        </div>

        <div class="lower-content">
            <h6>
                <router-link @click.native="$scrollToTop" :to="{ name: 'course_details', params: { id: training.id}}">
                    {{training.name}}
                </router-link>
            </h6>

            <div class="clearfix row add_to_cart_box" >
                <div class="col-sm-2 cart_icon" style=""
                ><i class="fa fa-cart-plus"></i></div>
                <div class="col-sm-8"> إضافة الى السلة</div>
            </div>
        </div>
    </div>


</template>

<script>
    import LikeButton from './LikeButton.vue';
    import axios from "axios";

    export default {
        props: ['training'],
        components: {LikeButton},
        computed: {
            registerDecription() {
                if (this.training.is_register == null)
                    return ' تسجيل ';
                else if (this.training.is_register.status == 0)
                    return ' الغاء التسجيل  ';
                else
                    return '  الغاء التسجيل  ';

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
