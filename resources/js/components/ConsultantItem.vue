<template>
    <div class="inner-box">
        <div class="image">
            <router-link :to="{ name: 'post_details', params: { id: post.id}}">

                <div class="col-xs-6 pull-right" style="margin: 15px 15px 0 0"><i class="fa fa-facebook-f"> </i>
                    {{post.category.name}}
                </div>
                <div class="col-xs-6 pull-left" style="margin: 15px 0px  0 15px"><i class="fa fa-clock-o"> </i> {{post.published}}
                </div>
            </router-link>
        </div>
        <div class="lower-content" style="padding: 15px">
            <h5>
                <router-link :to="{ name: 'post_details', params: { id: post.id}}">
                    {{post.title}}
                </router-link>
            </h5>

            <div class="post-info" v-html="getFirst20Word(post.body)">
            </div>
            <hr></hr>
            <div class="clearfix">
                <div class="pull-right">
                    <div class="students"> {{(post.comments_count)}} <i class="fa fa-comments"></i></div>
                </div>
                <div class="pull-left">
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

    export default {
        props: ['post'],
        components: {LikeButton},
    }
</script>
