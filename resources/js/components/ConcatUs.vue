<template>
    <div>
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
        <!-- Contact Page Section -->
        <section class="contact-page-section">
            <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
                 data-paroller-type="foreground" data-paroller-direction="vertical"
                 style="background-image: url('site/images/icons/icon-1.png')"></div>
            <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
                 data-paroller-type="foreground" data-paroller-direction="vertical"
                 style="background-image: url('site/images/icons/icon-2.png')"></div>
            <div class="auto-container">
                <div class="inner-container">
                    <!-- Sec Title -->
                    <div class="sec-title centered">
                        <h2><a href="http://idioms.in/in-touch/"> {{ $t("concatUs.concatUs") }}</a></h2>
                    </div>
                    <!-- Contact Form -->
                    <div class="contact-form">
                        <!-- Profile Form -->
                        <form method="post" action="sendemail.php" id="contact-form">
                            <div class="row clearfix">

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" v-model="form.name" name="username"
                                           :placeholder="$t('concatUs.name') +'*'"
                                           required="">
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="lastname" v-model="form.gov" :placeholder="$t('concatUs.gov') +'*'"
                                           required="">
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="email" v-model="form.email" name="email" :placeholder="$t('concatUs.email') +'*'"
                                           required="">
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" v-model="form.phone" name="phone" :placeholder="$t('concatUs.phone') +'*'"
                                           required="">
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <textarea class="" v-model="form.message" name="message"
                                              :placeholder="$t('concatUs.message') +'*'"></textarea>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group text-left">
                                    <button class="theme-btn btn-style-three" @click="sendConcat()" type="button"
                                            name="submit-form"><span
                                        class="txt">{{ $t('concatUs.submit') }}  <i class="fa fa-angle-left"></i></span></button>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>

                <!-- Contact Info Section -->
                <div class="contact-info-section">
                    <div class="title-box">
                        <h2> {{ $t("concatUs.concatInfo") }}</h2>
                        <div class="text">
                        </div>
                    </div>

                    <div class="row clearfix">

                        <!-- Info Column -->
                        <div class="info-column col-lg-4 col-md-6 col-sm-12">
                            <div class="info-inner">
                                <div class="icon fa fa-phone"></div>
                                <strong>   {{ $t("concatUs.concatInfo") }}  </strong>
                                <ul>
                                    <li><a href="tel:+96701480489">+967 01 480489</a></li>
                                    <li><a href="mailto:info@yourcompany.com">info@yourcompany.com</a></li>

                                </ul>
                            </div>
                        </div>

                        <!-- Info Column -->
                        <div class="info-column col-lg-4 col-md-6 col-sm-12">
                            <div class="info-inner">
                                <div class="icon fa fa-clock-o"></div>
                                <strong>   {{ $t("concatUs.workHour") }} </strong>

                                <ul>
                                    <li>
                                        {{ $t("concatUs.workHourInfo") }}

                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Info Column -->
                        <div class="info-column col-lg-4 col-md-6 col-sm-12">
                            <div class="info-inner">
                                <div class="icon fa fa-map-marker"></div>
                                <strong>  {{ $t("concatUs.Location") }} </strong>
                                <ul>
                                    <li>
                                        {{ $t("concatUs.LocationInfo") }}

                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>
        <!-- End Contact Page Section -->

        <!-- Map Section -->
        <section class="map-section">
            <!-- Map Boxed -->
            <div class="map-boxed">
                <!--Map Outer-->
                <div class="map-outer">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3847.4912839734206!2d44.211639785392165!3d15.349856989328774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1603dbab376b81db%3A0xe04a368156121a0d!2z2KPYqtit2KfYryDZhtiz2KfYoSDYp9mE2YrZhdmG!5e0!3m2!1sar!2s!4v1601595513798!5m2!1sar!2s"
                        width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
            </div>
        </section>
        <!-- End Map Section -->




    </div>

</template>
<script>
    import Loading from "vue-loading-overlay";
    import axios from "axios";

    export default {
        props: ['items'],
        components: {Loading},
        data() {
            return {

                isLoading: false,
                fullPage: true,
                form: {
                    name: "", gov: "", email: "", phone: "", message: ""
                },
            }
        },
        created() {
            // this.fetchArticles();
        },
        methods: {

            sendConcat() {
                this.isLoading = true;
                axios({
                    url: '/api/concatUs',
                    data: this.form,
                    method: 'POST'
                })
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                        }
                        this.isLoading = false;

                    })
                    .catch(err => {
                        console.log(err)
                        this.isLoading = false;
                    })
            },

            onCancel() {
                console.log('User cancelled the loader.')
            }

        },


    }
</script>
