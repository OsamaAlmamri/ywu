<template>
    <div class=" mx-2 my-5" style="width: 170px;">
        <!--        <a href="electric-stainless-steel-kettle-1-5l-1800w-white/N31981366A/p?o=c9d13846b27902cb"-->
        <!--           >-->
        <div class="product_countainer_link">
            <router-link @click.native="$scrollToTop" class="product_info_box"
                         :to="{ name: 'product_details', params: { id: product.id}}">
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
                    <div class="product_price_top d-flex justify-content-end">
                        <div>
                            <span class="">{{ product.price }}</span>
                        </div>
                    </div>
                </div>
            </router-link>

            <div class=" product_name_box d-flex justify-content-between">
                <div class=" one_product_name flex-grow-1"><span class="">
                           {{ product.name }}
                          <span style="display: none"> {{ lang }}</span>
                        </span>
                </div>
                <div class="regular product_gov">
                    {{ getLang( product.gov,  product.gov_en) }}
                </div>


            </div>
            <div class="product_price_box d-flex justify-content-between">
                <div class="  flex-grow-1"><span class="">
                           {{ product.category }}
                        </span>
                </div>
                <like-button class="like_product_button" style="
margin-right: -20px" type="product" :key="product.id" count-likes="0"
                             has-count="0"
                             :liked_id="product.id" :is_liked="product.is_like"></like-button>


            </div>
            <!--        </a>-->
        </div>
    </div>


</template>

<script>
import LikeButton from './LikeButton.vue';
import axios from "axios";
import RatingStars from "./RatingStars";

export default {
    //  props: ['product', 'lang'],
    props: {
        product: Object,
        lang:  String,

    },
    components: {LikeButton, RatingStars},
    methods: {

        getLang(txt_ar, txt_en) {
            return (localStorage.getItem("lang") == 'en') ? txt_en : txt_ar;
        },
        getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

    },
    computed: {
        // lang() {
        //     return this.getCookie(('style_lang'));
        //     return localStorage.getItem("lang")
        // }
    },


}
</script>
