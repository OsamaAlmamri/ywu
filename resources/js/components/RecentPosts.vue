<template>
    <div class="sidebar-inner sticky-top">
        <aside class="sidebar ">
            <!-- Popular Posts -->
            <div class="sidebar-widget popular-posts">

                <!-- Sidebar Title -->
                <div class="sidebar-title">
                    <h5>{{name}}</h5>
                </div>

                <div class="widget-content">
                    <article class="post" v-for="post in posts">
                        <div class="post-inner">
                            <figure class="post-thumb">
                                <router-link :to="{ name: post_url, params: { id: post.id}}">
                                    <img  style="width: 82px; height: 82px;"  :src="BaseImagePath + post.image" alt="" v-if="type!='posts'">
<!--                                    <img :src="'assets/images/' + post.image" alt="" v-if="type=='posts'">-->
                                    <img v-if="type=='posts'" style="width: 82px; height: 82px;" :src="BaseImagePath+getImageType(post.category.id)">

                                </router-link>
                            </figure>
                            <div class="text">
                                <router-link :to="{ name: post_url, params: { id: post.id}}">
                                    {{post.title}}
                                </router-link>
                            </div>
                            <div class="post-info" v-html="getFirst20Word(post.body)">

                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </aside>
    </div>
</template>

<script>
    import CourseGideItem from './CourseGideItem.vue';
    import axios from "axios";

    export default {
        props: ['name', 'type'],
        components: {CourseGideItem},
        data() {
            return {
                activeIndex: null,
                posts: [],
                post_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {
            this.fetchArticles();
        },
        computed: {
            post_url() {
                switch (this.type) {
                    case 'trainings':
                        return 'course_details';
                        break;
                    case 'posts':
                        return 'consultant';
                        break;
                    default :
                        return 'women_details';
                        break;

                }
            },

        },
        methods: {
            fetchArticles() {
                axios({url: '/api/getLastPosts', data: {type: this.type}, method: 'POST'})
                    .then(res => {
                        this.posts = res.data.data;
                    })
                    .catch(err => console.log(err));
            },


        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>
