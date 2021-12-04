<template>
    <div style="margin-top: 15px;">
        <div class="row clearfix" style="text-align: center">
            <div class="content-side col-lg-12 col-md-12 col-sm-12"
                 style="text-align: center">
                <swiper ref="flickity_categories" :options="swiperOption">
                    <swiper-slide class="swiper-slide" v-for="(category,key) in categories"
                                  :key="key">
                        <router-link :to="{ name: 'CategoryProducts', params: { id: category.id}}"
                                     @click.native="scrollToTop()">
                            <div class="category_image_box">
                                <img class=" img-fluid category_image"
                                     :data-flickity-lazyload="BaseImagePath+category.image"


                                     :src="BaseImagePath+category.image">
                            </div>


                            <p class="category_name">
                                {{ getLang(category.name, category.name_en) }}

                            </p>
                        </router-link>
                        <div class="swiper-button-prev" slot="button-prev"></div>
                        <div class="swiper-button-next" slot="button-next"></div>
                    </swiper-slide>
                </swiper>
            </div>

        </div>
    </div>
</template>

<script>

import {Swiper, SwiperSlide} from "vue-awesome-swiper";
import {lang} from "../../../public/vendors/moment/moment";

export default {
    components: {Swiper, SwiperSlide,},
    props: {
        lang:  String,
    },
    data() {
        return {
            swiperOption: {
                slidesPerView: 8,
                spaceBetween: 5,
                grabCursor: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    type: 'fraction'
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false
                },
                breakpoints: {
                    1024: {
                        slidesPerView: 10,
                        spaceBetween: 5
                    },
                    768: {
                        slidesPerView: 7,
                        spaceBetween: 5
                    },
                    640: {
                        slidesPerView: 5,
                        spaceBetween: 5
                    },
                    320: {
                        slidesPerView: 3,
                        spaceBetween: 5
                    }
                },

            },

            categories: [],
            isLoading: false,
            fullPage: true,
        }

    },
    created() {
        this.all_categories();
    }
    ,
    methods: {
        getLang (txt_ar, txt_en) {
            return (this.lang == 'en') ? txt_en : txt_ar;
        },

        all_categories() {
            axios({url: '/api/shop/all_categories', method: 'POST'})
                .then(resp => {
                    this.categories = (resp.data.data);
                }).then(response => {
                this.$nextTick(function () { // the magic
                    // this.$refs.flickity_categories.$swiper.slideTo(1, 1000, false)
                })
            })
                .catch(err => {
                    console.log(err)
                })
        },
        onCancel() {
            console.log('User cancelled the loader.')
        }

    }
    ,
    mounted() {
        console.log('Component mounted.')
    }
    ,


}
</script>


<style>
.flickity-button:disabled {
    display: none;
}


</style>
