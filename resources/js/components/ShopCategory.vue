<template>
    <div  style="margin-top: 15px;">
        <div class="row clearfix" style="text-align: center">
            <div class="content-side col-lg-12 col-md-12 col-sm-12"
                 style="text-align: center">
                <flickity ref="flickity_categories" :options="flickityOptions">
                    <router-link :to="{ name: 'CategoryProducts', params: { id: category.id}}" @click.native="scrollToTop()"
                                 v-for="(category,key) in categories"
                                 :key="key"
                                 class="col-4 col-sm-3 col-md-2 col-lg-1">
                        <div class="category_image_box">
                            <img class=" img-fluid category_image"
                                 :data-flickity-lazyload="category.image"
                                 :src="category.image">
                        </div>
                        <p class="category_name"> {{category.name}} </p>
                    </router-link>
                </flickity>
            </div>
        </div>
    </div>
</template>

<script>
    import 'vue-loading-overlay/dist/vue-loading.css';
    import Flickity from 'vue-flickity';
    import axios from "axios";

    export default {
        components: {Flickity},
        data() {
            return {
                flickityOptions: {
                    initialIndex: 0,
                    // rightToLeft: true,
                    // groupCells: 1,
                    // rightToLeft: true,
                    // freeScroll: true,
                    cellAlign: 'center',
                    // contain: true,
                    freeScroll: true,
                    // contain: true,
                    lazyLoad: true,
                    autoPlay: 5000,
                    resize: true,
                    prevNextButtons: true,
                    groupCells: true,
                    pageDots: false,
                    // wrapAround: true

                    // any options from Flickity can be used
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

            all_categories() {
                axios({url: '/api/shop/all_categories', method: 'POST'})
                    .then(resp => {
                        this.categories = (resp.data.data);
                    }).then(response => {
                    this.$nextTick(function () { // the magic
                        this.$refs.flickity_categories.rerender()
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
