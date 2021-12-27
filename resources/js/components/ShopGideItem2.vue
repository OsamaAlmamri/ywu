<template>
    <div class="product_countainer" >
        <!--        <a href="electric-stainless-steel-kettle-1-5l-1800w-white/N31981366A/p?o=c9d13846b27902cb"-->
        <!--           >-->
        <div class="product_countainer_link">
            <div class="product_image_box">
                <div class="productImage"
                     data-qa-id=" ">
                    <clazy-load class="wrapper" :src="BaseImagePath+product.image">
                        <transition name="fade">
                            <!--                                <div class="divClass"-->
                            <!--                                     v-bind:style="{ backgroundImage: 'url('+ product.image + ')' }">-->


                            <!--                                    &lt;!&ndash;                        <a :href=" product.image_actual" data-lightbox="1" data-title="">&ndash;&gt;-->
                            <!--                                    &lt;!&ndash;                            <img :src=" product.image_actual" width="100" alt="" class="img-fluid img-thumbnail">&ndash;&gt;-->
                            <!--                                    &lt;!&ndash;                        </a>&ndash;&gt;-->
                            <!--                                </div>-->
                            <div class=" product_image_inner_box">
                                <div class="image_box"><img
                                    :src="BaseImagePath+product.image"
                                    alt=""></div>
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
                <div class="pull-left" style="padding-left: 2em">
                    <like-button class="like_product_button" type="product" :key="product.id" count-likes="0"
                                 has-count="0"
                                 :liked_id="product.id" :is_liked="product.is_like"></like-button>
                </div>
            </div>
            <router-link @click.native="$scrollToTop" class="product_info_box"
                         :to="{ name: 'product_details', params: { id: product.id}}">
                <div class=" product_name_box">
                    <div class=" one_product_name"><span class="product_inner_name">
                           {{product.name}}
                        </span>
                    </div>
                    <div class="inner_currancy regular">
                        <strong>{{product.price}}</strong>.<span
                        class="currency"> {{$t('product.real')}}</span>

                    </div>
                </div>
                <div class="product_price_box">
                    <div class=" inner_price_box">
                        <rating-stars system="5"
                                      :rating="product.average_rating1">
                            <span slot="after">({{product.average_rating1}}) </span>
                        </rating-stars>
                        <p>
                            <i class="fa fa-map-marker "></i>
                            {{product.zone}}
                        </p>
                    </div>


                </div>
            </router-link>
            <!--        </a>-->
        </div>
    </div>


</template>

<script>
    import LikeButton from './LikeButton.vue';
    import axios from "axios";
    import RatingStars from "./RatingStars";

    export default {
        props: ['product'],
        components: {LikeButton, RatingStars},

    }
</script>
