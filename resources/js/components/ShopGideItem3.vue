<template>
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
        <div class="card border-0 product mb-6 fadeInUp animated"
        >
            <div class="position-relative">
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

                <div class="card-img-overlay d-flex p-3 flex-column">
                    <div class="mb-auto d-flex justify-content-center">
                        <div>
                            <span class="badge badge-primary">-20%</span>
                        </div>
                        <div class="w-100 content-change-vertical">
                            <a href="#" data-toggle="tooltip" data-placement="left"
                               title=""
                               class="add-to-wishlist ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-40px h-40px rounded-circle mb-2"
                               data-original-title="Add to wishlist">
                                <svg class="icon icon-star-light fs-20">
                                    <use xlink:href="#icon-star-light"></use>
                                </svg>
                            </a>
                            <a href="#" data-toggle="tooltip" data-placement="left"
                               title=""
                               class="add-to-compare ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-40px h-40px rounded-circle mb-2"
                               data-original-title="Compare">
                                <svg
                                    class="icon icon-arrows-left-right-light fs-20">
                                    <use
                                        xlink:href="#icon-arrows-left-right-light"></use>
                                </svg>
                            </a>
                            <a href="#" data-toggle="tooltip" data-placement="left"
                               title=""
                               class="preview ml-auto d-md-flex align-items-center justify-content-center cursor-pointer text-secondary bg-white hover-white bg-hover-secondary w-40px h-40px rounded-circle mb-2 d-none"
                               data-original-title="Quick view">
<span data-toggle="modal" data-target="#quick-view">
<svg class="icon icon-eye-light fs-20">
<use xlink:href="#icon-eye-light"></use>
</svg>
</span>
                            </a>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="#"
                           class="btn btn-secondary bg-hover-primary border-hover-primary lh-12">Add
                            To Bag</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4 text-center px-0">
                <p class="card-text font-weight-bold fs-16 mb-1 text-secondary">
                                                        <span
                                                            class="fs-13 font-weight-500 text-decoration-through text-body pr-1">$39.00</span>
                    <span>$29.00</span>
                </p>
                <h2 class="card-title fs-15 font-weight-500 mb-2"><a
                    href="product-page-01.html">Facial
                    cleanser</a></h2>
                <div
                    class="d-flex align-items-center justify-content-center flex-wrap">
                    <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-12 text-primary mr-0"><i
                            class="fas fa-star"></i></li>
                        <li class="list-inline-item fs-12 text-primary mr-0"><i
                            class="fas fa-star"></i></li>
                        <li class="list-inline-item fs-12 text-primary mr-0"><i
                            class="fas fa-star"></i></li>
                        <li class="list-inline-item fs-12 text-primary mr-0"><i
                            class="fas fa-star"></i></li>
                        <li class="list-inline-item fs-12 text-primary mr-0"><i
                            class="fas fa-star"></i></li>
                    </ul>
                    <span
                        class="card-text fs-14 font-weight-400 pl-2 lh-1">2947 reviews</span>
                </div>
            </div>
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
