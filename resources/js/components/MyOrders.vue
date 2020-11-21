<template>
    <section class="intro-section">
        <loading :active.sync="isLoading"
                 :can-cancel=false
                 :color="'#00ab15'"
                 :loader="'dots'"
                 :background-color="'#f8f9fa'"
                 :height='200'
                 :width='140'
                 :on-cancel="onCancel()"
                 :is-full-page="fullPage">
        </loading>
        <sweet-modal :title="'تفاصيل  الطلب رقم : '+active_order.id"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="comments">

        </sweet-modal>

        <sweet-modal :title="'اضافة عملية دفع الطلب '"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="add_payment">
            <div class="row clearfix">
                <fieldset class="the-fieldset">
                    <legend class="the-legend"> معلومات الحوالة</legend>
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12">
                            <label> رقم الحوالة </label>
                            <input type="text" class="form-control" v-model="payment_data.invoice_number">
                        </div>

                        <div class="form-group col-md-12 col-sm-12">
                            <label>المبلغ </label>
                            <input type="text" class="form-control" v-model="payment_data.amount">
                        </div>
                    </div>
                    <br>
                    <div class="form-group" style="width: 100%">
                        <div class="input-group-append">
                            <button class="btn btn-secondary"
                                    @click.prevent="send_payment()">ارسال
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
                                                        رقم الطلب
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
                                                        اسم المستلم :
                                                    </strong>
                                                    {{order.customer_name}}
                                                </p>
                                                <p class="col-sm-6">
                                                    <strong>
                                                        <i class="fa fa-user "></i>
                                                        رقم تلفون المستلم :
                                                    </strong>
                                                    {{order.phone}}
                                                </p>
                                                <p class="col-sm-6">
                                                    <strong>
                                                        <i class="fa fa-map-marker "></i>
                                                        مكان التسليم :
                                                    </strong>
                                                    ({{order.gov}}, {{order.district}}, {{order.more_address_info}})
                                                </p>
                                                <p class="col-sm-6">
                                                    <strong> السعر الاجمالي</strong>
                                                    {{order.price}}
                                                </p>
                                                <p class="col-sm-6">
                                                    <strong> حالة الدفع :</strong>
                                                    {{order.payment_status_name}}
                                                </p>
                                                <p class="col-sm-6" v-if="order.payment_status==1">
                                                    <button @click="show_details(key)"
                                                            style="padding: 1px 30% 1px  30%;"
                                                            class="btn btn-secondary">
                                                        عرض التفاصل
                                                    </button>
                                                </p>
                                                <p class="col-sm-6" v-else>
                                                    <button @click="show_details(key)"
                                                            style="padding: 1px 10% 1px  10%;"
                                                            class="btn btn-secondary">
                                                        عرض التفاصل
                                                    </button>
                                                    <button @click="addPayment(key)"
                                                            style="padding: 1px 10% 1px  10%;"
                                                            class="btn btn-secondary">
                                                        اضافة عملية الدفع
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div style="text-align: center">
                                    <img style="width: 20%" v-show="order_items.length<1" src="site/images/no_order.png">
                                    <h4>
                                        لم تقم باضافة اي طلب من قبل
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
                order_items: [],
                active_order: {},
                payment_data: {
                    invoice_number: 1,
                    amount: 0,
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
                            this.$refs.add_payment.open();
                        }
                    })
                    .catch(err => {
                        this.isLoading = false;
                        reject(err)
                    })
            },
            show_details(key) {
                console.log(this.order_items[key]);
                this.active_order = this.order_items[key];
                this.$refs.comments.open();
            },
            addPayment(key) {
                this.active_order = this.order_items[key];
                this.payment_data.order_id = this.order_items[key].id
                this.$refs.add_payment.open();
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

