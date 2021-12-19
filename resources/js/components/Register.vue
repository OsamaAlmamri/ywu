<template>
    <!-- Register Section -->
    <section class="register-section">
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
        <div class="auto-container">
            <div class="register-box">
                <!-- Title Box -->

                <div class="title-box">
                    <h2> {{ $t('MENU.register') }} </h2>

                    <div class="text"><span class="theme_color">{{ $t('login.hello') }}!</span>
                        {{ $t('register.title') }}
                    </div>
                </div>

                <section class="student-profile-section">
                    <div class="inner-column">
                        <!-- Profile Info Tabs-->
                        <div class="profile-info-tabs">
                            <!-- Profile Tabs-->
                            <div class="profile-tabs tabs-box">
                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    <li data-tab="#prod-overview" data-type="user"
                                        @click="changeUserType('visitor','')"
                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.userType=='visitor')}]">
                                        {{ $t('login.user') }}
                                    </li>
                                    <!--                                    <li data-tab="#prod-bookmark"-->
                                    <!--                                        @click="changeUserType('share_user','sub_cluster')"-->
                                    <!--                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.share_user_type=='sub_cluster')}]">-->
                                    <!--                                        شريك-->
                                    <!--                                    </li>-->
                                    <!--                                    <li data-tab="#prod-setting" @click="changeUserType('share_user','copartner')"-->
                                    <!--                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.share_user_type=='copartner')}]">-->
                                    <!--                                        عضو-->
                                    <!--                                        كتلة-->
                                    <!--                                    </li>-->
                                    <li data-tab="#prod-overview" data-type="seller"
                                        @click="changeUserType('seller','')"
                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.userType=='seller')}]">
                                        {{ $t('login.seller') }}
                                    </li>

                                    <!--                                    <li data-tab="#prod-overview" data-type="customer"-->
                                    <!--                                        @click="changeUserType('customer','')"-->
                                    <!--                                        :class="['user_type_tap', 'tab-btn',{'active-btn':(form.userType=='customer')}]">-->
                                    <!--                                        متسوق-->
                                    <!--                                    </li>-->

                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Login Form -->
                <div class="styled-form">
                    <form method="post" action="index.html">
                        <input type="hidden" name="type" id="user_type_input" value="user">
                        <div class="row clearfix">
                            <div class="form-group  col-md-12 col-sm-12" v-show="form.userType!='seller'">
                                <label> {{ $t('register.userType') }}</label>

                                <div class="student-profile-section" style="  margin-top: 0px;">
                                    <!-- Profile Info Tabs-->
                                    <div class="profile-info-tabs">
                                        <!-- Profile Tabs-->
                                        <div class="profile-tabs tabs-box">
                                            <ul class="tab-btns tab-buttons clearfix" style="display: flex">
                                                <li data-tab="#prod-bookmark"
                                                    :class="[ 'tab-btn',{'active-btn':(form.userType=='customer')},'usres_types_taps']"
                                                    style="padding: -23px 28px 46px;"
                                                    @click="form.userType='customer'">


                                                    {{ $t('register.customer') }}
                                                </li>
                                                <li data-tab="#prod-bookmark"
                                                    :class="[ 'tab-btn',{'active-btn':(form.userType=='visitor')},'usres_types_taps']"
                                                    style="padding: -23px 28px 46px;"
                                                    @click="form.userType='visitor'">

                                                    {{ $t('register.visitor') }}
                                                </li>
                                                <li data-tab="#prod-bookmark"
                                                    :class="[ 'tab-btn',{'active-btn':(form.share_user_type=='copartner')&& form.userType=='share_user'},'usres_types_taps']"
                                                    style="padding: -23px 28px 46px;"
                                                    @click="changeUserType('share_user','copartner')"
                                                >

                                                    {{ $t('register.copartner') }}
                                                </li>
                                                <li data-tab="#prod-bookmark"
                                                    :class="[ 'tab-btn',{'active-btn':(form.share_user_type=='sub_cluster') && form.userType=='share_user'},'usres_types_taps']"
                                                    style="padding: -23px 28px 46px;"
                                                    @click="changeUserType('share_user','sub_cluster')"
                                                >

                                                    {{ $t('register.sub_cluster') }}
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> {{ $t('register.name') }}</label>
                                <input type="text" v-model="form.name" :placeholder=" $t('register.name')" required="">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> {{ $t('register.gender') }}</label>

                                <div class="student-profile-section" style="  margin-top: 0px;">
                                    <!-- Profile Info Tabs-->
                                    <div class="profile-info-tabs">
                                        <!-- Profile Tabs-->
                                        <div class="profile-tabs tabs-box">
                                            <ul class="tab-btns tab-buttons clearfix" style="display: flex">
                                                <li data-tab="#prod-bookmark"
                                                    :class="[ 'tab-btn',{'active-btn':(form.gender=='male')},'gender_tap']"
                                                    style="padding: -23px 28px 46px;"
                                                    @click="form.gender='male'">
                                                    {{ $t('register.male') }}
                                                </li>
                                                <li data-tab="#prod-bookmark"
                                                    :class="['tab-btn',{'active-btn':(form.gender=='female')},'gender_tap']"
                                                    style="padding:-23px 28px 46px;"
                                                    @click="form.gender='female'">
                                                    {{ $t('register.female') }}
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> {{ $t('register.gov') }} </label>
                                <select @change="get_district()" class="form-control" id="sel1" v-model="form.gov_id">
                                    <option v-for="gov in govs " :value="gov.id"> {{ oneLang(gov.name_ar,gov.name_en) }}</option>
                                </select>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> {{ $t('register.dist') }} </label>
                                <select class="form-control" id="sel2" v-model="form.district_id">
                                    <option v-for="dist in districts " :value="dist.id"> {{  oneLang(dist.name_ar,dist.name_en)  }}</option>
                                </select>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-md-6 col-sm-12">
                                <!--                                 v-show="form.userType=='customer' ||form.userType=='seller'">-->
                                <label>

                                    {{ $t('register.more_address_info') }}
                                </label>
                                <input type="text" name="" v-model="form.more_address_info" id="form_more_address_info"
                                       value="">
                            </div>
                            <!-- Form Group -->
                            <!-- Form Group -->
                            <div class="form-group col-md-6 col-sm-12">
                                <label>
                                    {{ $t('register.phone') }}
                                </label>
                                <input type="text" v-model="form.phone" placeholder="777777777" required="">
                            </div>
                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12"
                                 v-show="form.userType=='share_user'|| form.userType=='seller'">
                                <label>
                                    {{ $t('register.email') }}
                                </label>
                                <input type="email" name="email" v-model="form.email" id="form_email" value=""
                                       placeholder="abcd@gmail.com">
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12"
                                 v-show="form.userType=='seller'">
                                <label>

                                    {{ $t('register.sale_name') }}
                                </label>
                                <input type="text" name="sale_name" v-model="form.sale_name" id="form_sale_name"
                                       value="">
                            </div>

                            <div class="form-group col-md-12 col-sm-12"
                                 v-show="form.userType=='seller'">
                                <div v-if="!image">
                                    <h3>
                                        {{ $t('register.logo') }}
                                    </h3>
                                    <input type="file" id="file" accept="image/*" ref="file"
                                           v-on:change="onFileChange()">
                                </div>
                                <div v-else>
                                    <img id="slected_image" :src="BaseImagePath+image"/>
                                    <button class="btn btn-warning" id="slected_image_button" @click="removeImage()">
                                        {{ $t('register.delete_image') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12" v-show="form.userType=='share_user'">
                                <label>{{ $t('register.destination') }} </label>
                                <input type="text" name="destination" v-model="form.destination" id="form_destination"
                                       value="">
                            </div>
                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>{{ $t('login.password') }} </label>
                                <span class="eye-icon flaticon-eye" @click="show_password('password')"></span>
                                <input :type="password__type" name="password" v-model="form.password"

                                       required="">
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>{{ $t('register.password_confirmation') }} </label>
                                <span class="eye-icon flaticon-eye"
                                      @click="show_password('password_confirmation')"></span>
                                <input :type="password_confirmation_type" name="password"
                                       v-model="form.password_confirmation"
                                       required="">
                            </div>

                            <div class="col-12 row" v-show="form.userType=='seller'">
                                <div class="col-md-8">
                                    <h5> {{ $t('register.term_of_register') }} </h5>
                                    <ul style="list-style: circle">

                                        <li>{{ $t('register.term1') }}</li>
                                        <li>{{ $t('register.term2') }}</li>
                                        <li>{{ $t('register.term3') }}</li>
                                        <li>{{ $t('register.term4') }}</li>
                                        <li>{{ $t('register.term5') }}</li>

                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <div id="my-strictly-unique-vue-upload-multiple-image"
                                         style="display: flex; justify-content: center;">
                                        <vue-upload-multiple-image
                                            @upload-success="uploadImageSuccess"
                                            @before-remove="beforeRemove"
                                            :data-images="images"
                                            idUpload="myIdUpload"
                                            editUpload="myIdEdit"
                                            :showPrimary="false"
                                            :showEdit="false"
                                            :maxImage="4"
                                            :dragText="$t('register.dragText')"
                                            :browseText="$t('register.browseText')"
                                            :primaryText="$t('register.primaryText')"
                                            :markIsPrimaryText="$t('register.markIsPrimaryText')"
                                            :popupText="$t('register.popupText')"
                                            :dropText="$t('register.dropText')"
                                        ></vue-upload-multiple-image>
                                    </div>


                                </div>

                            </div>


                            <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                                <button type="button" class="theme-btn btn-style-three"><span
                                    @click="register()" class="txt">
                                    {{ $t('register.register') }}
                                     <i class="fa fa-angle-left"></i></span>
                                </button>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="users">
                                    {{ $t('register.has_account') }}
                                    <router-link to="/login">
                                        {{ $t('MENU.login') }}
                                    </router-link>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- End Login Section -->
</template>
<script>
import store from '../store'
import VueUploadMultipleImage from 'vue-upload-multiple-image'


import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
import CourseGideItem from "./CourseGideItem";
import axios from "axios";

export default {
    components: {Loading, VueUploadMultipleImage},
    data() {
        return {
            isLoading: false,
            fullPage: true,
            gov_id: 0,
            image: '',
            images: [],
            selected_images: [],
            uploaded_image: [],
            password_confirmation_type: 'password',
            password__type: 'password',
            district_id: 0,
            govs: [],
            districts: [],
            form: {
                userType: "visitor",
                device_type: "web",
                device_token: $("#device_token").val(),
                destination: "",
                share_user_type: "",
                name: "",
                email: "",
                gender: "female",
                password_confirmation: "",
                password: "",
                images: [],
                sale_name: "",
                ssn_image: "",
                gov_id: "",
                district_id: "",
                more_address_info: "",
            }
        }
    },
    computed: {
        objectClass: function () {
            return {blue: this.active, red: !this.active};
        }
    },
    created() {
        this.get_gov();

    },
    methods: {
        uploadImageSuccess(formData, index, fileList) {
            console.log('data', formData, index, fileList)
            // Upload image api
            this.isLoading = true;
            axios({url: '/api/upload_image', data: formData, method: 'POST'})
                .then(resp => {
                    if (resp.data.status == false) {
                        toastStack('   خطاء ', resp.data.msg, 'error');
                        fileList.slice(index, 1)
                    } else {
                        fileList[index].name = resp.data.data;
                        console.log(resp.data);
                    }
                    this.selected_images = fileList;
                    this.isLoading = false;
                })
                .catch(err => {
                    fileList.slice(index, 1)
                    this.selected_images = fileList;
                    reject(err)
                    this.isLoading = false;
                })
        },
        beforeRemove(index, done, fileList) {
            console.log('index', index, fileList)
            var r = confirm("remove image")
            if (r == true) {
                done()
                fileList.slice(index, 1)
            } else {
            }
            this.selected_images = fileList;
        },
        show_password: function (type) {
            if (type == 'password_confirmation') {
                if (this.password_confirmation_type == 'password')
                    this.password_confirmation_type = 'text';
                else
                    this.password_confirmation_type = 'password';
            } else {
                if (this.password__type == 'password')
                    this.password__type = 'text';
                else
                    this.password__type = 'password';
            }
        },
        changeUserType: function (type, share_type) {
            this.form.userType = type;
            this.form.share_user_type = share_type;
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
        register: function () {
            this.form.device_token = $("#device_token").val();
            console.log(this.selected_images)
            this.form.images = [];
            for (var i = 0; i < this.selected_images.length; i++) {
                this.form.images.push(this.selected_images[i].name)
            }
            let data = this.form;
            if (data.password != data.password_confirmation) {
                toastStack('كلمة السر غير متطابقة', '', 'error');
                // toastStack('كلمة السر غير متطابقة', '', 'success');
            } else if (this.selected_images.length < 2 && this.form.userType == 'seller') {
                toastStack('يجب اضافة على الاقل صورتين لكي يتم قبول حسابك', '', 'error');
                // toastStack('كلمة السر غير متطابقة', '', 'success');
            } else {
                this.isLoading = true;
                store.dispatch('register', data)
                    .then(() => {
                        this.isLoading = false;
                        // this.$router.push('/')
                        this.$router.push('/profile')
                        location.reload();
                    })
                    .catch(err => {
                        this.isLoading = false;
                        if (err == 'seller')
                            this.$router.push('/login')
                        // location.reload();
                        // console.log(err)
                    })
            }
        },
        onCancel() {
            console.log('User cancelled the loader.')
        },
        onFileChange(e) {
            this.form.ssn_image = this.$refs.file.files[0];
            // var files = e.target.files || e.dataTransfer.files;
            if (!this.form.ssn_image)
                return;
            this.createImage(this.form.ssn_image);
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (e) {
            this.image = '';
            this.form.ssn_image = '';
        },


        // register() {
        //     var app = this
        //     this.$auth.register({
        //         data: {
        //             email: app.email,
        //             password: app.password,
        //             password_confirmation: app.password_confirmation
        //         },
        //         success: function () {
        //             app.success = true
        //             this.$router.push({name: 'login', params: {successRegistrationRedirect: true}})
        //         },
        //         error: function (res) {
        //             console.log(res.response.data.errors)
        //             app.has_error = true
        //             app.error = res.response.data.error
        //             app.errors = res.response.data.errors || {}
        //         }
        //     })
        // }
    }
}


</script>


<style>
.student-profile-section {
    background-color: white;
    padding: 21px 0px 67px;

}


.student-profile-section .profile-tabs .tab-btns {
    border-bottom: 3px solid #593c97;
}

#slected_image {
    width: 30%;
    margin: auto;
    display: block;
    margin-bottom: 10px;
}

#slected_image_button {

    margin-right: 45%;
}
</style>

