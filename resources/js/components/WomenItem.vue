<template>
    <div class="card m-2">
        <div class="media border p-1">

            <img :src="BaseImagePath+women_post.image" alt="" class="mr-3 mt-2 img-thumbnail"
                 @click="$router.push({ name: 'women_details', params: { id: women_post.id}})"
                 style="width:200px;">
            <div class="media-body">
                <div class="content-box">
                    <div class="box-inner  mt-2">
                        <h5>
                            <router-link @click.native="$scrollToTop"
                                         :to="{ name: 'women_details', params: { id: women_post.id}}">
                                {{ oneLang(women_post.title, women_post.title_en) }}
                            </router-link>
                        </h5>
                        <div class="text text-center" style="min-height: 4rem"
                             v-html="getFirst20Word(oneLang(women_post.body,women_post.body_en))"></div>

                        <div class="text mt-2 ">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <i class="fa fa-clock-o"> </i>

                                    {{ (women_post.published) }}
                                </div>

                                <div>
                                    <nav class="menu">
                                        <input type="checkbox" href="#" class="menu-open" name="menu-open"
                                               :id="'menu-open'+women_post.id"/>
                                        <label class="menu-open-button" :for="'menu-open'+women_post.id">
                                            <i class="fa fa-share-alt share-icon"></i>
                                        </label>

                                        <a :href="'https://www.facebook.com/sharer/sharer.php?u=https://yemenwe.com/women_details/'+women_post.id"
                                           target="_blank"
                                           class="menu-item facebook_share_btn"> <i class="fa fa-facebook"></i> </a>

                                        <a :href="'https://twitter.com/intent/tweet?text=Default+share+text&amp;url=https://yemenwe.com/women_details/'+women_post.id"
                                           target="_blank"
                                           class="menu-item twitter_share_btn"> <i class="fa fa-twitter"></i> </a>

                                        <a :href="'http://www.linkedin.com/shareArticle?mini=true&amp;url=https://yemenwe.com/women_details/'+women_post.id+'&amp;title=Default+share+text&amp;summary='"
                                           target="_blank"
                                           class="menu-item linkedin_share_btn"> <i class="fa fa-linkedin"></i> </a>

                                        <a :href="'https://www.instagram.com/sharer/sharer.php?u=https://yemenwe.com/women_details/'+women_post.id"
                                           target="_blank"
                                           class="menu-item instagram_share_btn"> <i class="fa fa-instagram"></i> </a>

                                        <a :href="'https://wa.me/?text=https://yemenwe.com/women_details/'+women_post.id"
                                           target="_blank"
                                           class="menu-item whatsapp_share_btn">
                                            <i class="fa fa-whatsapp"></i> </a>
                                        <a :href="'https://telegram.me/share/url?url=https://yemenwe.com/women_details/'+women_post.id+'&amp;text=Default+share+text'"
                                           target="_blank"
                                           class="menu-item telegram_share_btn">
                                            <i class="fa fa-telegram"></i>
                                        </a>


                                    </nav>
                                </div>

                                <div style="margin-top: -8px">
                                    <like-button type="women_posts" :key="women_post.id" count-likes="0" has-count="0"
                                                 :liked_id="women_post.id"
                                                 :is_liked="women_post.user_like"></like-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--    <div class="inner-box">-->
    <!--        <div class="image">-->
    <!--            <router-link  @click.native="$scrollToTop"  :to="{ name: 'women_details', params: { id: women_post.id}}">-->
    <!--                <clazy-load class="wrapper" :src="BaseImagePath+women_post.image">-->
    <!--                    <transition name="fade">-->
    <!--                        <div class="divClass"-->
    <!--                             v-bind:style="{ backgroundImage: 'url('+BaseImagePath+women_post.image+')' }">-->
    <!--                        </div>-->
    <!--                    </transition>-->
    <!--                    <transition name="fade" slot="placeholder">-->
    <!--                        <div class="vue_preloader">-->
    <!--                            <div class="circle">-->
    <!--                                <div class="circle-inner"></div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </transition>-->
    <!--                </clazy-load>-->
    <!--            </router-link>-->
    <!--        </div>-->
    <!--        <div class="lower-content">-->
    <!--            <h5 class="text-center" style="min-height: 3rem">-->
    <!--                <router-link  @click.native="$scrollToTop"  :to="{ name: 'women_details', params: { id: women_post.id}}">-->
    <!--                    {{oneLang(women_post.title,women_post.title_en)}}-->
    <!--                </router-link>-->
    <!--            </h5>-->

    <!--            <div   class="text text-center" style="min-height: 4rem" v-html="getFirst20Word(oneLang(women_post.body,women_post.body_en))"></div>-->

    <!--            <div class="clearfix">-->
    <!--                <div class="pull-right">-->
    <!--                    <div class=" students"> {{(women_post.published)}} <i class="fa fa-calendar"></i></div>-->
    <!--                </div>-->
    <!--                <div class="pull-left">-->
    <!--                    <like-button type="women_posts" :key="women_post.id" count-likes="0" has-count="0"-->
    <!--                             :liked_id="women_post.id"    :is_liked="women_post.user_like"></like-button>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
</template>

<script>
import LikeButton from './LikeButton.vue';

export default {
    props: ['women_post'],
    components: {LikeButton},
}
</script>
