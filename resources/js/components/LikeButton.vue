<template>
    <div class="students hours" @click="likePost()">
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
        <i
            :class="['fa', {'fa-heart-o':(like==0)}, {'fa-heart':(like==1)}]"></i>
        <span style="padding: 0 5px" v-show="hasCount==1">{{countLikes}}</span>
    </div>
</template>

<script>
    import axios from "axios";
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        props: ['is_liked', 'hasCount', 'countLikes', 'type', 'liked_id'],
        components: {Loading},

        data() {
            return {
                isLoading: false,
                fullPage: false,
                like: 0,
                likeCount: 0
            }
        },
        created() {
            this.like = (this.is_liked != null);
        },
        methods: {
            likePost() {
                if (localStorage.token) {
                    this.isLoading = true;
                    axios({
                        url: '/api/like', data: {
                            type: this.type,
                            liked_id: this.liked_id
                        }, method: 'POST'
                    })
                        .then(resp => {
                            this.isLoading = false;
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                this.like = resp.data.data;
                                if (resp.data.data == 1) {
                                    this.countLikes++;
                                    this.$emit('like', 1);
                                } else {
                                    this.countLikes--;
                                    this.$emit('like', -1);
                                }
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

        }
    }
</script>
