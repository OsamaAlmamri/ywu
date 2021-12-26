<template>
    <section class="intro-section">
        <loading :active.sync="isLoading"
                 :can-cancel=false
                 :color="'#593c97'"
                 :loader="'dots'"
                 :background-color="'#f8f9fa'"
                 :height='200'
                 :width='140'
                 :on-cancel="onCancel()"
                 :is-full-page="fullPage">
        </loading>
        <sweet-modal :title="$t('cart.complete')"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="comments">
            <div class="row clearfix">
                <fieldset class="the-fieldset">
                    <legend class="the-legend"> {{$t('cart.complete')}}</legend>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12">
                            <label>  {{$t('cart.customer_name')}} </label>
                            <input type="text" class="form-control" v-model="form.customer_name">
                        </div>

                        <div class="form-group col-md-12 col-sm-12">
                            <label> {{$t('cart.phone')}}</label>
                            <input type="text" class="form-control" v-model="form.phone">
                        </div>

                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <label> {{$t('cart.gov')}} </label>
                            <select @change="get_district()" class="form-control" id="sel1" v-model="form.gov_id">
                                <option v-for="gov in govs " :value="gov.id"> {{gov.name_ar}}</option>
                            </select>
                        </div>
                        <!-- Form Group -->
                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <label> {{$t('cart.district')}} </label>
                            <select class="form-control" id="sel2" v-model="form.district_id">
                                <option v-for="dist in districts " :value="dist.id"> {{dist.name_ar}}</option>
                            </select>
                        </div>
                        <!--                        &lt;!&ndash; Form Group &ndash;&gt;-->
                        <!--                        <div class="form-group col-md-12 col-sm-12">-->
                        <!--                            <input type="text" name="" v-model="form.more_address_info" id="form_more_address_info"-->
                        <!--                                   value="">-->
                        <!--                        </div>-->
                        <div class="form-group col-md-12 col-sm-12">
                            <label>{{$t('cart.more_address_info')}} </label>
                            <input type="text" class="form-control" v-model="form.more_address_info">
                        </div>
                        <br>
                        <h5 style="padding: 1px 18px;">{{$t('cart.payment_method')}}
                        </h5>
                        <section class="student-profile-section">
                            <div class="inner-column">
                                <div class="profile-info-tabs">
                                    <div class="profile-tabs tabs-box">
                                        <ul class="tab-btns tab-buttons clearfix">
                                            <li
                                                @click="changeCategoryType('transfer')"
                                                :class="['user_type_tap', 'tab-btn',{'active-btn':(form.payment_method=='transfer')}]">
                                                {{$t('cart.transfer')}}
                                            </li>
                                            <li
                                                @click="changeCategoryType('on_delivery')"
                                                :class="['user_type_tap', 'tab-btn',{'active-btn':(form.payment_method=='on_delivery')}]">
                                                {{$t('cart.on_delivery')}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                    <br>
                    <div class="form-group" style="width: 100%">
                        <div class="input-group-append">
                            <button class="btn btn-secondary"
                                    @click.prevent="confirm_order()"> {{$t('cart.complete')}}
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </sweet-modal>

        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('site/images/icons/icon-1.png')"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('site/images/icons/icon-2.png')"></div>
        <div class="circle-one"></div>
        <div class="auto-container">
            <div class="sec-title">
            </div>
            <div class="inner-container">
                <div class="row clearfix">
                    <div class="content-column col-md-12 col-sm-12">
                        <div class="inner-column">

                            <div v-show="cart_items.length>0" class="container pb-5 mb-2">

                                <div class="cart-item d-md-flex justify-content-between"
                                     v-for="(cart_item,key) in cart_items">
                                    <span class="remove-item" @click="delete_fromCart(cart_item.id,key)">
                                        <i class="fa fa-times"></i></span>
                                    <div class="px-3 my-3">
                                        <a class="cart-item-product" href="#">
                                            <div class="cart-item-product-thumb"><img
                                                :src="BaseImagePath+cart_item.product.image" alt="Product">
                                            </div>
                                            <div class="d-flex flex-column align-items-start mx-2 ">
                                                <h4 class="cart-item-product-title">{{cart_item.product.name}}</h4>
                                                <span v-for="op in cart_item.product_attributes_descriptions">
                                                    <strong> {{op.products_options_name}}:</strong> {{op.products_options_values_name}}
                                                </span>
                                                <span><strong><i class="fa fa-map-marker "></i>:</strong> {{cart_item.product.zone}}</span>
                                                <span><img style="width: 31px;border-radius: 50px;"
                                                           :src="BaseImagePath+cart_item.product.sell_icon"> {{cart_item.product.sell_name}}  </span>

                                            </div>
                                        </a>
                                    </div>
                                    <div class="px-3 my-3 text-center">
                                        <div class="cart-item-label">{{$t('cart.quantity')}} </div>
                                        <div class="count-input">
                                            <div class="pro-counter">
                                                <div class="input-group item-quantity ">
                                                    <input type="number" name="quantity"
                                                           class="form-control qty"
                                                           min="1"
                                                           v-model="cart_item.quantity">
                                                    <span class="input-group-btn">
                                                                        <button type="button"
                                                                                class="quantity-plus1 btn qtyplus"
                                                                                @click="change_quantity('+',key)"><i
                                                                            class="fa fa-plus"></i></button>
                                                                        <button type="button"
                                                                                class="quantity-minus1 btn qtyminus"
                                                                                @click="change_quantity('-',key)"><i
                                                                            class="fa fa-minus"></i></button></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-3 my-3 text-center">
                                        <div class="cart-item-label">{{$t('cart.total')}}  </div>
                                        <span class="text-xl font-weight-medium">{{cart_item.total}}</span>
                                    </div>
                                    <div class="px-3 my-3 text-center">
                                        <div class="cart-item-label">{{$t('cart.total')}}   </div>
                                        <span
                                            class="text-xl font-weight-medium">{{cart_item.price*cart_item.quantity}}</span>
                                    </div>
                                </div>

                                <!-- Coupon + Subtotal-->
                                <div
                                    class="d-sm-flex justify-content-between align-items-center text-center text-sm-left">
                                    <form class="form-inline py-2">
                                        <label class="sr-only">  {{$t('cart.coupon')}} </label>
                                        <input class="form-control form-control-sm my-2 mr-3" type="text"
                                               v-model="coupon"
                                             required="">
                                        <button @click="apply_my_coupon()"
                                                class="btn btn-style-1 btn-secondary btn-sm my-2 mx-auto mx-sm-0"
                                                type="button">
                                            {{$t('cart.apply_my_coupon')}}

                                        </button>
                                    </form>
                                    <div class="py-2"><span
                                        class="d-inline-block align-middle text-sm text-muted font-weight-medium text-uppercase mr-2"> {{$t('cart.cart_total')}} :</span>
                                        <span v-if="apply_coupon==null"
                                              class="d-inline-block align-middle text-xl font-weight-medium">{{calculatePrice}}</span>
                                        <span v-if="apply_coupon!=null"
                                              class="d-inline-block align-middle text-xl font-weight-medium old_price"
                                              >{{calculatePrice}}</span>
                                        <span v-if="apply_coupon!=null"
                                              class="d-inline-block  new_price align-middle text-xl font-weight-medium">{{calculatePrice-apply_coupon.amount}}</span>

                                        <span v-if="apply_coupon!=null"
                                              @click="delete_coupon()"
                                              class="d-inline-block align-middle text-xl font-weight-medium">
                                            <i class="fa fa-trash" :title="$t('cart.delete_coupon')"> </i></span>
                                    </div>

                                </div>
                                <!-- Buttons-->
                                <hr class="my-2">
                                <div class="row pt-3 pb-5 mb-2">
                                    <div class="col-sm-6 mb-3">
                                        <button class="btn btn-style-1 btn-secondary btn-block"
                                                @click="updateCart()"
                                        ><i class="fe-icon-refresh-ccw"></i>&nbsp;
                                            {{$t('cart.updateCart')}}
                                        </button>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <button v-if="cart_items.length>0" @click="openModal()"
                                                class="btn btn-style-1 btn-primary btn-block"
                                        ><i
                                            class="fe-icon-credit-card"></i>&nbsp;
                                            {{$t('cart.confirm')}}

                                        </button>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div style="text-align: center">
                            <img v-show="cart_items.length<1" :src="BaseImagePath+'site/images/empty-cart.png'">


                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </section>
</template>
<script>
    import axios from "axios";
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import store from "../store";

    export default {
        props: ['items'],
        components: {Loading},

        data() {
            return {
                isLoading: false,
                fullPage: true,
                coupon: "",
                apply_coupon: null,
                attributes_price: 0,
                cart_items: [],
                is_active_dropdown: false,
                cart_item: {
                    quantity: 1,
                    product_id: this.$route.params.id,
                    product_attributes: [],
                },
                product: {},
                activeContent_key: 0,
                activeContent_title_key: 0,
                edit: false,
                gov_id: 0,
                district_id: 0,
                govs: [],
                districts: [],
                form: {
                    customer_name: store.getters.authUser.name,
                    phone: store.getters.authUser.phone,
                    gov_id: store.getters.authUser.gov_id,
                    district_id: store.getters.authUser.district_id,
                    more_address_info: store.getters.authUser.more_address_info,
                    payment_method: "transfer",
                }
            }
        },
        created() {
            this.fetchTraining();
            this.get_gov();
        },
        computed: {
            calculatePrice() {
                let total = 0;
                for (let i = 0; i < this.cart_items.length; i++) {
                    total += (parseInt(this.cart_items[i].price) * parseInt(this.cart_items[i].quantity));
                }
                return total;
            },
            authUser: function () {
                return store.getters.authUser
            }
        },
        methods: {
            fetchTraining() {
                this.isLoading = true;
                axios({url: '/api/shop/my_cart2', method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.cart_items = resp.data.data.cart;
                            this.apply_coupon = resp.data.data.coupon;
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        localStorage.removeItem('token')
                        localStorage.removeItem('user')
                        reject(err)
                    })
            },
            delete_coupon() {
                this.isLoading = true;
                axios({url: '/api/shop/delete_coupon', data: {id: this.apply_coupon.id}, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.apply_coupon = null;
                            toastStack('    ', resp.data.msg, 'success');
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        reject(err)
                    })
            },
            apply_my_coupon() {
                this.isLoading = true;
                axios({url: '/api/shop/apply_coupon', data: {coupon: this.coupon}, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.apply_coupon = resp.data.data;
                            toastStack('    ', resp.data.msg, 'success');
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        reject(err)
                    })
            },
            delete_fromCart(id, key) {
                this.isLoading = true;
                axios({url: '/api/shop/delete_from_cart', data: {id: id}, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.cart_items.splice(key, 1);
                            // this.cart_items[key]
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        reject(err)
                    })
            },
            changeCategoryType(type) {
                this.form.payment_method = type;
            },
            change_quantity(type, key) {
                if (type == "+")
                    this.cart_items[key].quantity++;
                else {
                    if (this.cart_items[key].quantity > 1)
                        this.cart_items[key].quantity--;
                }
            },
            change_attribute(key) {
                this.cart_item.product_attributes[key] = this.selected_product_attributes[key].products_attributes_id;
            },

            updateCart() {
                if (localStorage.token) {
                    axios({
                        url: '/api/shop/update_cart', data: {cart_items: this.cart_items},
                        method: 'POST'
                    })
                        .then(resp => {
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                var cart = resp.data.data;
                                if (cart == 0)
                                    toastStack('   خطاء ', "المنتج موجود مسبقا بالسلة", 'error');
                                else {
                                    toastStack('   تم تحديث السلة بنجاح ', '', 'success');
                                }
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
            },
            confirm_order() {
                if (localStorage.token) {
                    axios({
                        url: '/api/shop/confirm_order', data: this.form,
                        method: 'POST'
                    })
                        .then(resp => {
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                {
                                    toastStack('تم  تاكيد الطلب  بنجاح', '', 'success');
                                    this.cart_items = [];
                                    this.$refs.comments.close();
                                }
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                } else {
                    toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
                }
            },
            openModal() {
                this.$refs.modal.open();
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            get_district() {
                axios({url: '/api/get_district', data: {"gov_id": this.form.gov_id}, method: 'POST'})
                    .then(resp => {
                        this.districts = (resp.data.data);
                        this.form.district_id = this.districts[0].id;

                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            get_gov() {
                axios({url: '/api/get_gov', method: 'POST'})
                    .then(resp => {
                        this.govs = (resp.data.data);
                        this.form.gov_id = this.govs[0].id;
                        this.get_district()
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            openModal() {
                this.$refs.comments.open();
            },
        },
        mounted() {
            console.log('Component mounted.')
        },
    }
</script>

<style>
    .student-profile-section {
        background-color: white;
        padding: 0px 0px 0px;

    }

    .student-profile-section .profile-tabs .tab-btns {
        border-bottom: 3px solid #593c97;
    }
</style>
