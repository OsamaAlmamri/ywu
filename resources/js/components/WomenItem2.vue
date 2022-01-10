<template>
    <div class="inner-box">
        <div class="image">
            <router-link  @click.native="$scrollToTop"  :to="{ name: 'women_details', params: { id: women_post.id}}">
                <clazy-load class="wrapper" :src="BaseImagePath+women_post.image">
                    <transition name="fade">
                        <div class="divClass"
                             v-bind:style="{ backgroundImage: 'url('+BaseImagePath+women_post.image+')' }">
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
            </router-link>
        </div>
        <div class="lower-content">
            <h5 class="text-center" style="min-height: 3rem">
                <router-link  @click.native="$scrollToTop"  :to="{ name: 'women_details', params: { id: women_post.id}}">
                    {{oneLang(women_post.title,women_post.title_en)}}
                </router-link>
            </h5>

            <div   class="text text-center" style="min-height: 4rem" v-html="getFirst20Word(oneLang(women_post.body,women_post.body_en))"></div>

            <div class="clearfix">
                <div class="pull-right">
                    <div class=" students"> {{(women_post.published)}} <i class="fa fa-calendar"></i></div>
                </div>
                <div class="pull-left">
                    <like-button type="women_posts" :key="women_post.id" count-likes="0" has-count="0"
                             :liked_id="women_post.id"    :is_liked="women_post.user_like"></like-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LikeButton from './LikeButton.vue';
    export default {
        props: ['women_post'],
        components: {LikeButton},
    }
</script>
