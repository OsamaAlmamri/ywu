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
                    <h2>انشاء حساب جديد</h2>
                    <div class="text"><span class="theme_color">مرحبــا!</span>
                        قم بإنشاء حساب للاستفاد بشكل اكبر من
                        الخدمات الذي يقدمها الموقع
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
                                        مستخدم
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
                                        تاجر
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
                                <label> نوع المستخدم </label>

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
                                                    متسوق
                                                </li>
                                                <li data-tab="#prod-bookmark"
                                                    :class="[ 'tab-btn',{'active-btn':(form.userType=='visitor')},'usres_types_taps']"
                                                    style="padding: -23px 28px 46px;"
                                                    @click="form.userType='visitor'">
                                                    متدرب
                                                </li>
                                                <li data-tab="#prod-bookmark"
                                                    :class="[ 'tab-btn',{'active-btn':(form.share_user_type=='copartner')&& form.userType=='share_user'},'usres_types_taps']"
                                                    style="padding: -23px 28px 46px;"
                                                    @click="changeUserType('share_user','copartner')"
                                                >
                                                    عضوء شريك
                                                </li>
                                                <li data-tab="#prod-bookmark"
                                                    :class="[ 'tab-btn',{'active-btn':(form.share_user_type=='sub_cluster') && form.userType=='share_user'},'usres_types_taps']"
                                                    style="padding: -23px 28px 46px;"
                                                    @click="changeUserType('share_user','sub_cluster')"
                                                >
                                                    عضوء كتلة
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>الاسم </label>
                                <input type="text" v-model="form.name" placeholder=" الاسم" required="">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> الجنس </label>

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
                                                    ذكر
                                                </li>
                                                <li data-tab="#prod-bookmark"
                                                    :class="['tab-btn',{'active-btn':(form.gender=='female')},'gender_tap']"
                                                    style="padding:-23px 28px 46px;"
                                                    @click="form.gender='female'">
                                                    انثى
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <!--                                 v-show="form.userType=='customer' ||form.userType=='seller'">-->

                                <label> المحافظة </label>
                                <select @change="get_district()" class="form-control" id="sel1" v-model="form.gov_id">
                                    <option v-for="gov in govs " :value="gov.id"> {{gov.name_ar}}</option>
                                </select>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <!--                                 v-show="form.userType=='customer' || form.userType=='seller'">-->
                                <label> المديرية </label>
                                <select class="form-control" id="sel2" v-model="form.district_id">
                                    <option v-for="dist in districts " :value="dist.id"> {{dist.name_ar}}</option>
                                </select>

                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-md-6 col-sm-12">
                                <!--                                 v-show="form.userType=='customer' ||form.userType=='seller'">-->
                                <label> معلومات اضافية عن مكان التواجد </label>
                                <input type="text" name="" v-model="form.more_address_info" id="form_more_address_info"
                                       value="">
                            </div>
                            <!-- Form Group -->
                            <!-- Form Group -->
                            <div class="form-group col-md-6 col-sm-12">
                                <label> رقم الهاتف</label>
                                <input type="text" v-model="form.phone" placeholder="777777777" required="">
                            </div>


                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12"
                                 v-show="form.userType=='share_user'|| form.userType=='seller'">
                                <label>الايميل </label>
                                <input type="email" name="email" v-model="form.email" id="form_email" value=""
                                       placeholder="abcd@gmail.com">
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12"
                                 v-show="form.userType=='seller'">
                                <label>الاسم التجاري </label>
                                <input type="text" name="sale_name" v-model="form.sale_name" id="form_sale_name"
                                       value="">
                            </div>

                            <div class="form-group col-md-12 col-sm-12"
                                 v-show="form.userType=='seller'">
                                <div v-if="!image">
                                    <h3>صورة (شعار) المتجر </h3>
                                    <input type="file" id="file" accept="image/*" ref="file"
                                           v-on:change="onFileChange()">
                                </div>
                                <div v-else>
                                    <img id="slected_image" :src="BaseImagePath+image"/>
                                    <button class="btn btn-warning" id="slected_image_button" @click="removeImage()">حذف
                                        الصورة
                                    </button>
                                </div>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12" v-show="form.userType=='share_user'">
                                <label> الجهة</label>
                                <input type="text" name="destination" v-model="form.destination" id="form_destination"
                                       value=""
                                       placeholder="الجهة">
                            </div>
                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>كلمة السر</label>
                                <span class="eye-icon flaticon-eye" @click="show_password('password')"></span>
                                <input :type="password__type" name="password" v-model="form.password"
                                       placeholder="كلمة السر"
                                       required="">
                            </div>

                            <!-- Form Group -->
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label> تاكيد كلمة السر</label>
                                <span class="eye-icon flaticon-eye"
                                      @click="show_password('password_confirmation')"></span>
                                <input :type="password_confirmation_type" name="password"
                                       v-model="form.password_confirmation"
                                       placeholder="تاكيد كلمة السر"
                                       required="">
                            </div>

                            <div class="col-12 row" v-show="form.userType=='seller'">
                                <div class="col-md-8">
                                    <h5> شروط قبول المشاركة:</h5>
                                    <ul style="list-style: circle">
                                        <li>صور للمنتجات واضحه ذو جاذبيه و جودة عالية</li>
                                        <li>اظهار كل مزايا وخصائص المنتج</li>
                                        <li>التصوير بخلفية قماشية بيضاء او لون مناسب مع لون المنتج</li>
                                        <li>اختيار زاويه مناسبه لتصوير المنتج</li>
                                        <li>المنتجات بانواعها يدويه تصنعها النساء</li>

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
                                            dragText="اسحب"
                                            browseText="تصفح"
                                            primaryText="افتراضي"
                                            markIsPrimaryText="ضبط الصورة الافتراضية"
                                            popupText="وصف الصورة الافتراضية"
                                            dropText="اسحب و افلات"
                                        ></vue-upload-multiple-image>
                                    </div>

                                </div>

                            </div>


                            <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                                <button type="button" class="theme-btn btn-style-three"><span
                                    @click="register()" class="txt">التسجيل الان <i class="fa fa-angle-left"></i></span>
                                </button>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="users">هل لديك حساب من قبل ؟
                                    <router-link to="/login"> تسجيل
                                        الدخول
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

