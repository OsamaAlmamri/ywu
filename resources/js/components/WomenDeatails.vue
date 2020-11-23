<template>
    <!--Sidebar Page Container-->
    <div class="sidebar-page-container">
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
        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url(images/icons/icon-1.png)"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url(images/icons/icon-2.png)"></div>
        <div class="circle-one"></div>
        <div class="circle-two"></div>
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Sidebar Side -->
                <div class="sidebar-side style-two blog-sidebar col-lg-3 col-md-12 col-sm-12">
                    <recent-posts name="اخر المنشورات" type="women"></recent-posts>
                </div>

                <!-- Content Side -->
                <div class="content-side blog-detail-column col-lg-9 col-md-12 col-sm-12">
                    <div class="blog-detail">
                        <div class="inner-box">
                            <h2>{{post.title}}</h2>
                            <ul class="author-info">
                                <li><span class="theme_color">{{post.published}}</span></li>
                            </ul>
                            <div class="image" v-show="post.image!=null">
                                <img :src="BaseImagePath+post.image" alt="">
                            </div>
                            <div v-html="post.body"></div>
                            <!--                            <div class="social-box">-->
                            <!--                                <span>Share this article on </span>-->
                            <!--                                <a href="#" class="fa fa-facebook-square"></a>-->
                            <!--                                <a href="#" class="fa fa-twitter-square"></a>-->
                            <!--                                <a href="#" class="fa fa-linkedin-square"></a>-->
                            <!--                                <a href="#" class="fa fa-github"></a>-->
                            <!--                            </div>-->
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</template>

<script>
    // import question from './Question.vue';
    import axios from "axios";
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        props: ['items'],
        components: {Loading},
        data() {
            return {
                isLoading: false,
                fullPage: false,
                post: {
                    "id": 0,
                    "title": "",
                    "body": "",
                    "image": null,
                    "book": null,
                    "book_external_link": null,
                    "sound": null,
                    "video_url": null,
                    "deleted_at": null,
                    "published": " ",
                    "user_like": null
                },
                post_id: 0,
                activeIndex: null,
                edit: false
            }
        },
        created() {
            this.post_id = this.$route.params.id
            this.fetchTraining();
        },
        methods: {
            fetchTraining() {
                this.isLoading = true;
                axios({url: '/api/ShowPId/' + this.post_id, data: {id: this.post_id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.post = resp.data.Post;
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        // localStorage.removeItem('token')
                        // localStorage.removeItem('user')
                        console.log(err)
                        this.isLoading = false;
                        // reject(err)
                    })

            },
            onCancel() {
                console.log('User cancelled the loader.')
            }

        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>
