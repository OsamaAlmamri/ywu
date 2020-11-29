<template>

    <div class="inner-box" style="margin-bottom: 10px">
        <div class="image">

            <clazy-load class="wrapper" :src="product.image">
                <transition name="fade">

                    <div class="divClass"
                         v-bind:style="{ backgroundImage: 'url('+ product.image + ')' }">


                        <!--                        <a :href=" product.image_actual" data-lightbox="1" data-title="">-->
                        <!--                            <img :src=" product.image_actual" width="100" alt="" class="img-fluid img-thumbnail">-->
                        <!--                        </a>-->
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
        <div class="clearfix ">
            <div class="pull-left" style="padding-left: 2em">
                <like-button class="like_product_button" type="product" :key="product.id" count-likes="0"
                             has-count="0"
                             :liked_id="product.id" :is_liked="product.is_like"></like-button>
            </div>
        </div>

        <div class="lower-content">
            <router-link @click.native="$scrollToTop"
                         :to="{ name: 'product_details', params: { id: product.id}}">
                <div class="product_name_and_price">
                    <h6>

                        {{product.name}}

                    </h6>
                    <h6>
                        {{product.price}} ر.ي
                    </h6>
                </div>

                <div class="detail_product_item">

<!--                    <p>-->
<!--                        <img style="width: 31px;border-radius: 50px;" :src="product.sell_icon">-->
<!--                        <span>-->
<!--                      {{product.sell_name}}-->
<!--                    </span>-->
<!--                    </p>-->

                    <p>
                        <i class="fa fa-map-marker "></i>
                        {{product.zone}}/ {{product.space}}
                    </p>

                    <rating-stars system="5"
                                  :rating="product.average_rating">
                        <span slot="after">({{product.average_rating}}) </span>
                    </rating-stars>
                </div>
            </router-link>
            <!--            <div class="clearfix row add_to_cart_box">-->
            <!--                <div class="col-2 cart_icon" style=""-->
            <!--                ><i class="fa fa-cart-plus"></i></div>-->
            <!--                <div class="col-8"> إضافة الى السلة</div>-->
            <!--            </div>-->
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
