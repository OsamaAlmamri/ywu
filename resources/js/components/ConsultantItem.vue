<template>
    <div class="inner-box">
        <div class="row">
                <div class="col-xs-2 pull-right" style="margin: 20px 38px 0px 0px">
                    <i class="fa fa-facebook-f"> </i>
                </div>
                <div class="col-xs-4 pull-right" style="margin: 15px 15px 0 0">
                    <ul style="display: inline-block; list-style: none" class="">
                        <li> {{post.category.name}}</li>
                        <li>
                            <i class="fa fa-clock-o"> </i>
                            {{post.published}}
                        </li>
                    </ul>
                </div>
                <div class="col col-xs-5 " style="margin: 15px 0px  0 15px; text-align: end">

                    <dropdown v-if="authUser.id==post.user_id">
                        <div slot="items">
                            <a class="dropdown-item" href="#"
                               @click.prevent="edit_rating()">تعديل</a>
                            <a class="dropdown-item" href="#"
                               @click.prevent="deleteRating()"> حذف </a>
                        </div>
                    </dropdown>

                </div>

        </div>
        <div class="lower-content" style="padding: 15px">
            <h5>
                <router-link @click.native="$scrollToTop" :to="{ name: 'post_details', params: { id: post.id}}">
                    {{post.title}}
                </router-link>
            </h5>

            <div class="post-info" id="targetMore" v-html="textToDisplay">
            </div>
            <span @click="readmore=!readmore" v-if="post_words.isMore && !textMoreToShow">( عرض المزيد) </span>
            <span @click="readmore=!readmore" v-if="post_words.isMore && (textMoreToShow)"> (عرض اقل)  </span>
            <hr></hr>
            <div class="clearfix">
                <div class="pull-right" style="padding-right: 3em">
                    <div class="students"> {{(post.comments_count)}} <i class="fa fa-comments"></i></div>
                </div>
                <div class="pull-left" style="padding-left: 3em">
                    <like-button type="posts" :key="post.id" :count-likes="post.likes_count" has-count="1"
                                 :liked_id="post.id" :is_liked="post.user_like"></like-button>
                </div>
            </div>
        </div>
    </div>
    <!--    <div class="inner-box">-->
    <!--        <div class="image">-->
    <!--            <div class="widget-content">-->
    <!--                <article class="post">-->
    <!--                    <div class="row">-->
    <!--                        <div class="col-xs-6 pull-right"><i class="fa fa-facebook-f"> </i> {{post.category.name}}</div>-->
    <!--                        <div class="col-xs-6 pull-left"><i class="fa fa-clock-o"> </i> {{post.published}}</div>-->
    <!--                    </div>-->
    <!--                    <div class="post-inner">-->
    <!--                        <div class="text">-->
    <!--                            <router-link :to="{ name: 'post_details', params: { id: post.id}}">-->
    <!--                                {{post.title}}-->
    <!--                            </router-link>-->
    <!--                        </div>-->
    <!--                        <div class="post-info" v-html="getFirst20Word(post.body)">-->
    <!--                        </div>-->

    <!--                        <div class="clearfix">-->
    <!--                            <div class="pull-right">-->
    <!--                                <div class="students"> {{(post.comments_count)}} <i class="fa fa-comments"></i></div>-->
    <!--                            </div>-->
    <!--                            <div class="pull-left">-->
    <!--                                <like-button type="posts" :key="post.id" :count-likes="post.likes_count" has-count="1"-->
    <!--                                             :liked_id="post.id" :is_liked="post.user_like"></like-button>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </article>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->


</template>

<script>
    import LikeButton from './LikeButton.vue';
    import axios from "axios";
    import store from '../store'

    export default {

        props: ['post','key'],
        components: {LikeButton},
        data() {
            return {
                readmore: false,
                bodyDisplay: '',
                is_active_dropdown: false,
                edit_post: false,
                post_words: {
                    'words': 0,
                    'newText': '',
                    'isMore': false
                }
            }
        },
        created() {
            this.post_words = this.countWords(this.post.body, 20);
        },
        methods: {
            deleteRating() {
                this.$emit('delete_post', this.$vnode.key)

            },
            edit_rating() {
                this.is_active_dropdown = false;
                this.edit_post = true;
                // this.$emit('edit_post', this.post.id);
                this.$emit('edit_post', this.$vnode.key)

                // this.newRating.rating = this.training.is_rating.rating;
                // this.newRating.message = this.training.is_rating.message;

            },
        },
        computed: {
            textToDisplay: function () {
                return (this.readmore) ? this.post_words.newText : this.post.body;
            },
            authUser: function () {
                return store.getters.authUser
            },

            textMoreToShow: function () {
                return (this.readmore);
            }

        }
    }
</script>
