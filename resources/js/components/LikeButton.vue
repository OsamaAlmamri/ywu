<template>
    <div class="students hours" @click="likePost()">
        <i
           :class="['fa', {'fa-heart-o':(like_description==0)}, {'fa-heart':(like_description==1)}]"></i>
        <span style="padding: 0 5px" v-show="hasCount==1">{{like_description_count}}</span>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        props: ['is_liked','hasCount','countLikes','type','liked_id'],
        data() {
            return {
                like: 0,
                likeCount: 0
            }
        },
        computed: {
            like_description() {
                return this.like;
            },
            like_description_count() {
                return this.likeCount;
            }

        },
        created() {
            this.like = (this.is_liked != null);
        },
        methods: {
            likePost() {
                if (localStorage.token) {
                    axios({url: '/api/like', data: {type: this.type,
                            liked_id: this.liked_id}, method: 'POST'})
                        .then(resp => {
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                this.like = resp.data.data;
                                if(resp.data.data==1)
                                this.likeCount++;
                                else
                                this.likeCount--;
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
                this.$emit('click', this.$vnode.key)
            }

        }
    }
</script>
