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
        <sweet-modal :title="$t('cart.order_id_detail') +active_order.id"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="comments">
            <section class="content invoice">
                <div class="one_seller_box"
                     v-for="(order_seller,key) in active_order.sellers">
                    <div class="row invoice-info">
                        <div class="col-12 col-sm-5 invoice-col">
                            <address>
                                <span> <strong>   {{ $t('cart.order_id') }}  : </strong> <b>#{{order_seller.id}} </b></span>
                                <br>
                                <span> <strong> {{ $t('cart.sale_name') }}  : </strong> <b>{{order_seller.seller.seller.sale_name}} </b></span>
                                <br> <strong> <i class="fa fa-map-marker "></i> </strong>
                                {{order_seller.seller.seller.gov}}
                                ,{{order_seller.seller.seller.district}}
                                ,{{order_seller.seller.seller.more_address_info}}
                                <br> <strong> {{ $t('cart.new_delivery_location') }}   : </strong>
                                : {{order_seller.seller.seller.new_delivery_location}}
                                <br>
                                <b> {{ $t('cart.order_status_name') }}  :</b> {{order_seller.order_status_name}}
                            </address>
                        </div>
                        <!-- /.col -->
                        <!-- /.col -->
                        <div class="col-sm-7 col-7 invoice-col">
                            <p v-if="order_seller.coupon_discount>0">
                                <b> {{ $t('cart.coupon') }}  :</b> {{order_seller.coupon}}
                                <b> {{ $t('cart.coupon_discount') }}  :</b> {{order_seller.coupon_discount}}
                            </p>

                            <b>{{ $t('cart.order_cost') }} :</b> {{order_seller.price}}
                            <b> {{ $t('cart.total_price_tp_paid') }}  :</b> {{order_seller.shipping_cost}}
                            <br>
                            <p v-if="order_seller.coupon_discount>0">

                                <b>{{ $t('cart.total_price_tp_paid') }} :</b>
                                {{parseInt(order_seller.shipping_cost)+parseInt(order_seller.price)-parseInt(order_seller.coupon_discount)}}
                            </p>
                            <span v-if="order_seller.coupon_discount<1">
                                <b>{{ $t('cart.total_price_tp_paid') }} :</b> {{order_seller.shipping_cost+order_seller.price-order_seller.coupon_discount}}
                            </span>
                            <br>
                            <b>{{ $t('cart.payment_method') }}  :</b> {{order_seller.payment_method}}
                            <br>
                            <b>{{ $t('cart.payment_status_name') }} :</b> {{order_seller.payment_status_name}}

                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-xs-12 table">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>{{$t('cart.quantity')}} </th>
                                    <th>{{$t('cart.category')}} </th>
                                    <th>{{$t('cart.product')}} </th>
                                    <th style="width: 25%">{{$t('cart.products_options')}}  </th>
                                    <th>{{$t('cart.price')}}  </th>
                                    <th> {{$t('cart.total')}} </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="product in order_seller.products ">
                                    <td>{{product.quantity}}</td>
                                    <td>{{product.product.category}}</td>
                                    <td>{{product.product.name}}</td>
                                    <td>{
                                        <span v-for="att in product.product_attributes_descriptions">
                                             ( {{att.products_options_name}}
                                        , {{att.products_options_values_name}})
                                        </span>
                                        }
                                    </td>
                                    <td> {{product.price}} {{$t('cart.real')}}</td>
                                    <td> {{product.price * product.quantity }} {{$t('cart.real')}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <br>
                    <div class="form-group" style="    width: 90%;
                    margin-bottom:10px;

    margin-left: 5%;
    margin-right: 5%;">
                        <div class="pull-right"
                             v-if="order_seller.status=='new' || order_seller.status=='in_progress' ">
                            <button class="btn btn-secondary" style="font-size: 10px;"

                                    @click.prevent="cancel_order(order_seller.id,key)">
                                {{$t('cart.cancel_order')}}

                            </button>
                        </div>
                        <div class=" pull-left">
                            <button @click="addPayment(order_seller.id)" style="font-size: 10px;"
                                    class="btn btn-primary">
                                {{$t('cart.addPayment')}}

                            </button>
                        </div>
                    </div>
                    <br>
                    <br>
                </div>


            </section>
        </sweet-modal>

        <sweet-modal :title="$t('cart.addPayment')"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="add_payment">
            <div class="row clearfix">
                <fieldset class="the-fieldset">
                    <legend class="the-legend"> {{ $t('cart.payment_info') }}ة</legend>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12">
                            <label>  {{ $t('cart.invoice_number') }}  </label>
                            <input type="text" class="form-control" v-model="payment_data.invoice_number">
                        </div>

                        <div class="form-group col-md-12 col-sm-12">
                            <label> {{ $t('cart.amount') }}</label>
                            <input type="text" class="form-control" v-model="payment_data.amount">
                        </div>
                    </div>
                    <br>
                    <div class="form-group" style="width: 100%">
                        <div class="input-group-append">
                            <button class="btn btn-secondary"
                                    @click.prevent="send_payment()">{{ $t('cart.send') }}
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </sweet-modal>

        <sweet-modal :title=" $t('cart.cancel_order')"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="cancel_order">
            <div class="clearfix">
                <fieldset class="the-fieldset">
                    <legend class="the-legend"> {{$t('cart.cancel_description')}} </legend>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12">
                            <textarea style="margin-top: 0px; margin-bottom: 0px; height: 93px;" class="form-control"
                                      v-model="cancel_data.description">

                            </textarea>
                        </div>

                    </div>
                    <br>
                    <div class="form-group" style="width: 100%">
                        <div class="input-group-append">
                            <button class="btn btn-secondary"
                                    @click.prevent="send_cancel_order()">
                                {{$t('cart.send')}}

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
                            <div class="course-overview">
                                <div class="inner-box product-page" v-show="order_items.length>0">
                                    <div name="attributes" id="add-Product-form" method="post">
                                        <div class="pro-options row cart_item_box"
                                             v-for="(order,key) in order_items">
                                            <div class="col-12" style="    padding: 10px 26px;">
                                                <div class="pull-right">
                                                    <strong>
                                                        <i class="fa fa-tag"></i>

                                                        {{$t('cart.order_id')}}
                                                    </strong>
                                                    <span>({{order.id}})</span>
                                                </div>
                                                <div class="pull-left">
                                                    <strong><i class="fa fa-calendar-times-o"></i> </strong>
                                                    <span>{{order.published}}</span>
                                                </div>
                                                <hr style="margin-top: 30px;">
                                            </div>
                                            <div class="cart_product_details  row box">
                                                <p class="col-sm-6">
                                                    <strong>
                                                        <i class="fa fa-user "></i>

                                                        {{$t('cart.customer_name')}} :
                                                    </strong>
                                                    {{order.customer_name}}
                                                </p>
                                                <p class="col-sm-6">
                                                    <strong>
                                                        <i class="fa fa-user "></i>

                                                        {{$t('cart.phone')}} :
                                                    </strong>
                                                    {{order.phone}}
                                                </p>
                                                <p class="col-sm-6">
                                                    <strong>
                                                        <i class="fa fa-map-marker "></i>

                                                        {{$t('cart.recive_location')}} :
                                                    </strong>
                                                    ({{order.gov}}, {{order.district}}, {{order.more_address_info}})
                                                </p>
                                                <p class="col-sm-6">
                                                    <strong>
                                                        {{$t('cart.total')}}
                                                         </strong>
                                                    {{order.price}}
                                                </p>
                                                <p class="col-sm-6">
                                                    <strong>
                                                        {{$t('cart.payment_status_name')}}
                                                       :</strong>
                                                    {{order.payment_status_name}}
                                                </p>
                                                <p class="col-sm-6" v-if="order.payment_status==1">
                                                    <button @click="show_details(key)"
                                                            style="padding: 1px 30% 1px  30%;"
                                                            class="btn btn-secondary">
                                                        {{$t('cart.show_details')}}
                                                    </button>
                                                </p>
                                                <p class="col-sm-6" v-else>
                                                    <button @click="show_details(key)"
                                                            style="padding: 1px 10% 1px  10%;"
                                                            class="btn btn-secondary">
                                                        {{$t('cart.show_details')}}

                                                    </button>

                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div style="text-align: center" v-show="order_items.length<1">
                                    <img style="width: 20%" src="/site/images/no_order.png">
                                    <h4>
                                        {{$t('cart.not_found_order')}}

                                    </h4>
                                </div>
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
                attributes_price: 0,
                sub_order_key: 0,
                active_order_key: 0,
                order_items: [],
                active_order: {},
                payment_data: {
                    invoice_number: 1,
                    amount: 0,
                    order_id: 0
                },
                cancel_data: {
                    description: '',
                    order_id: 0
                },
                is_active_dropdown: false,
                edit: false,
            }
        },
        created() {
            this.fetchOrders();
        },
        computed: {
            authUser: function () {
                return store.getters.authUser
            }
        },
        methods: {
            fetchOrders() {
                this.isLoading = true;
                axios({url: '/api/shop/my_orders', method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.order_items = resp.data.data.data;
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        localStorage.removeItem('token')
                        localStorage.removeItem('user')
                        reject(err)
                    })
            },
            send_payment() {
                this.isLoading = true;
                axios({url: '/api/shop/add_payment', data: this.payment_data, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack('   تم اضافة العملية بنجاح  ', '', 'success');
                            this.$refs.add_payment.close();
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        reject(err)
                    })
            },
            send_cancel_order() {
                this.isLoading = true;
                axios({url: '/api/shop/cancel_order', data: this.cancel_data, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            this.order_items[this.active_order_key].sellers[this.sub_order_key] = resp.data.data;
                            this.active_order.sellers[this.sub_order_key] = resp.data.data;
                            this.$refs.cancel_order.close();
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        reject(err)
                    })
            },
            show_details(key) {
                console.log(this.order_items[key]);
                this.active_order_key = key;
                this.active_order = this.order_items[key];
                this.$refs.comments.open();
            },
            addPayment(key) {
                this.payment_data.order_id = key
                this.$refs.add_payment.open();
            },
            cancel_order(id, sub_key) {
                this.cancel_data.order_id = id;
                this.sub_order_key = sub_key;
                this.$refs.cancel_order.open();
            },
            openModal() {
                this.$refs.modal.open();
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },

        },
        mounted() {
            console.log('Component mounted.')
        },
    }
</script>

