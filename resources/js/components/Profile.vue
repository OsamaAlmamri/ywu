<template>


    <!-- Student Profile Section -->
    <section class="student-profile-section">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 color="#00ab15"
                 loader="dots"
                 background-color="#f8f9fa"
                 height="200"
                 width="140"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"></loading>
        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url(/site/images/icons/icon-1.png)"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url(/site/images/icons/icon-2.png)"></div>
        <div class="circle-one"></div>
        <div class="circle-two"></div>
        <div class="auto-container">

            <div class="row clearfix">


                <!-- Image Section -->
                <div class="image-column col-lg-3 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="image">
                            <img src="/site/images/resource/student-2.jpg" alt="">
                        </div>
                        <p>{{authUser.name}}</p>
                        <!--                        <a href="#" class="theme-btn btn-style-three"><span class="txt">Upload Picture <i-->
                        <!--                            class="fa fa-angle-left"></i></span></a>-->
                        <!--                        <a href="#" class="theme-btn btn-style-two"><span class="txt">Delete Picture <i-->
                        <!--                            class="fa fa-angle-left"></i></span></a>-->
                    </div>
                </div>
                <!-- Content Section -->
                <div class="content-column col-lg-9 col-md-12 col-sm-12">
                    <div class="inner-column">

                        <!-- Profile Info Tabs-->
                        <div class="profile-info-tabs">
                            <!-- Profile Tabs-->
                            <div class="profile-tabs tabs-box">

                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    <li data-tab="#prod-overview"
                                        @click="changeActive('prod-overview')" :class="['tab-btn', {'active-btn':(activeTap=='prod-overview')}]">Overview</li>
                                    <li data-tab="#prod-bookmark"
                                        @click="changeActive('prod-bookmark')" :class="['tab-btn', {'active-btn':(activeTap=='prod-bookmark')}]">Bookmarks</li>
                                    <li data-tab="#prod-setting"
                                        @click="changeActive('prod-setting')" :class="['tab-btn', {'active-btn':(activeTap=='prod-setting')}]">Settings</li>
                                </ul>

                                <!--Tabs Container-->
                                <div class="tabs-content">

                                    <!--Tab / Active Tab-->
                                    <div :class="['tab', {'active-tab':(activeTap=='prod-overview')}]"
                                         id="prod-overview">
                                        <div class="content">
                                            <!-- Sec Title -->
                                            <div class="sec-title">
                                                <h2>Courses In Progress</h2>
                                            </div>

                                            <div class="row clearfix">

                                                <!-- Cource Block Two -->
                                                <div class="cource-block-two col-lg-4 col-md-6 col-sm-12">
                                                    <div class="inner-box">
                                                        <div class="image">
                                                            <a href="course-detail.html"><img
                                                                src="/site/images/resource/course-6.jpg" alt=""></a>
                                                        </div>
                                                        <div class="lower-content">
                                                            <h5><a href="course-detail.html">Interaction Design</a></h5>
                                                            <div class="text">Replenish of third creature and meat
                                                                blessed void a fruit gathered waters.
                                                            </div>
                                                            <div class="clearfix">
                                                                <div class="pull-left">
                                                                    <div class="students">12 Lecturer</div>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <div class="hours">54 Hours</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cource Block Two -->
                                                <div class="cource-block-two col-lg-4 col-md-6 col-sm-12">
                                                    <div class="inner-box">
                                                        <div class="image">
                                                            <a href="course-detail.html"><img
                                                                src="/site/images/resource/course-7.jpg" alt=""></a>
                                                        </div>
                                                        <div class="lower-content">
                                                            <h5><a href="course-detail.html">Visual Design</a></h5>
                                                            <div class="text">Replenish of third creature and meat
                                                                blessed void a fruit gathered waters.
                                                            </div>
                                                            <div class="clearfix">
                                                                <div class="pull-left">
                                                                    <div class="students">12 Lecturer</div>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <div class="hours">54 Hours</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <!-- Tab -->
                                    <div :class="['tab', {'active-tab':(activeTap=='prod-bookmark')}]" id="prod-bookmark">
                                        <div class="content">

                                            <div class="row clearfix">

                                                <!-- Cource Block Two -->
                                                <div class="cource-block-two col-lg-4 col-md-6 col-sm-12">
                                                    <div class="inner-box">
                                                        <div class="image">
                                                            <a href="course-detail.html"><img
                                                                src="/site/images/resource/course-6.jpg" alt=""></a>
                                                        </div>
                                                        <div class="lower-content">
                                                            <h5><a href="course-detail.html">Interaction Design</a></h5>
                                                            <div class="text">Replenish of third creature and meat
                                                                blessed void a fruit gathered waters.
                                                            </div>
                                                            <div class="clearfix">
                                                                <div class="pull-left">
                                                                    <div class="students">12 Lecturer</div>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <div class="hours">54 Hours</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cource Block Two -->
                                                <div class="cource-block-two col-lg-4 col-md-6 col-sm-12">
                                                    <div class="inner-box">
                                                        <div class="image">
                                                            <a href="course-detail.html"><img
                                                                src="/site/images/resource/course-7.jpg" alt=""></a>
                                                        </div>
                                                        <div class="lower-content">
                                                            <h5><a href="course-detail.html">Visual Design</a></h5>
                                                            <div class="text">Replenish of third creature and meat
                                                                blessed void a fruit gathered waters.
                                                            </div>
                                                            <div class="clearfix">
                                                                <div class="pull-left">
                                                                    <div class="students">12 Lecturer</div>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <div class="hours">54 Hours</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cource Block Two -->
                                                <div class="cource-block-two col-lg-4 col-md-6 col-sm-12">
                                                    <div class="inner-box">
                                                        <div class="image">
                                                            <a href="course-detail.html"><img
                                                                src="/site/images/resource/course-8.jpg" alt=""></a>
                                                        </div>
                                                        <div class="lower-content">
                                                            <h5><a href="course-detail.html">Wireframe Protos</a></h5>
                                                            <div class="text">Replenish of third creature and meat
                                                                blessed void a fruit gathered waters.
                                                            </div>
                                                            <div class="clearfix">
                                                                <div class="pull-left">
                                                                    <div class="students">12 Lecturer</div>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <div class="hours">54 Hours</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cource Block Two -->
                                                <div class="cource-block-two col-lg-4 col-md-6 col-sm-12">
                                                    <div class="inner-box">
                                                        <div class="image">
                                                            <a href="course-detail.html"><img
                                                                src="/site/images/resource/course-9.jpg" alt=""></a>
                                                        </div>
                                                        <div class="lower-content">
                                                            <h5><a href="course-detail.html">Color Theory</a></h5>
                                                            <div class="text">Replenish of third creature and meat
                                                                blessed void a fruit gathered waters.
                                                            </div>
                                                            <div class="clearfix">
                                                                <div class="pull-left">
                                                                    <div class="students">12 Lecturer</div>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <div class="hours">54 Hours</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>

                                    <!-- Tab -->


                                    <div :class="['tab', {'active-tab':(activeTap=='prod-setting')}]"  id="prod-setting">
                                        <div class="content">
                                            <!-- Title Box -->
                                            <div class="title-box">
                                                <h5>Edit Profile</h5>
                                            </div>

                                            <!-- Profile Form -->
                                            <div class="profile-form">

                                                <!-- Profile Form -->
                                                <form method="post" action="blog.html">
                                                    <div class="row clearfix">

                                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                            <input type="text" name="username" placeholder="First Name"
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                            <input type="text" name="username" placeholder="Last Name"
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                            <input type="email" name="email" placeholder="Email"
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                            <input type="text" name="phone" placeholder="Phone"
                                                                   required="">
                                                            <span class="icon flaticon-edit-1"></span>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                            <select class="custom-select-box">
                                                                <option>Member Type</option>
                                                                <option>Member 01</option>
                                                                <option>Member 02</option>
                                                                <option>Member 03</option>
                                                                <option>Member 04</option>
                                                                <option>Member 05</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                            <textarea class="" name="message"
                                                                      placeholder="Your Message"></textarea>
                                                        </div>

                                                        <div
                                                            class="col-lg-12 col-md-12 col-sm-12 form-group text-right">
                                                            <button class="theme-btn btn-style-two" type="submit"
                                                                    name="submit-form"><span class="txt">Cancel <i
                                                                class="fa fa-angle-left"></i></span></button>
                                                            <button class="theme-btn btn-style-three" type="submit"
                                                                    name="submit-form"><span class="txt">Save Change <i
                                                                class="fa fa-angle-left"></i></span></button>
                                                        </div>

                                                    </div>
                                                </form>

                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <!-- Post Share Options -->
                        <div class="styled-pagination">
                            <ul class="clearfix">
                                <li class="prev"><a href="#"><span class="fa fa-angle-left"></span> </a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li class="active"><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">6</a></li>
                                <li><a href="#">7</a></li>
                                <li><a href="#">8</a></li>
                                <li class="next"><a href="#"><span class="fa fa-angle-left"></span> </a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <!-- Saved Books Section -->
        <div class="saved-books-section">
            <div class="auto-container">
                <div class="sec-title">
                    <h2>Saved Books</h2>
                </div>
                <div class="row clearfix">

                    <!-- Book Block -->
                    <div class="book-block col-lg-3 col-md-4 col-sm-12">
                        <div class="inner-box">
                            <figure class="image-box">
                                <img src="/site/images/resource/book-14.jpg" alt="">
                                <!-- Overlay Box -->
                                <div class="overlay-box">
                                    <div class="overlay-inner">
                                        <div class="content">
                                            <a href="books-detail.html" class="link"><span
                                                class="icon fa fa-link"></span></a>
                                            <a href="/site/images/resource/book-14.jpg" data-fancybox="books"
                                               data-caption="" class="link"><span
                                                class="icon flaticon-full-screen"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </figure>
                            <div class="lower-box">
                                <h6><a href="books-detail.html">Don’t make me think</a></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Book Block -->
                    <div class="book-block col-lg-3 col-md-4 col-sm-12">
                        <div class="inner-box">
                            <figure class="image-box">
                                <img src="/site/images/resource/book-15.jpg" alt="">
                                <!-- Overlay Box -->
                                <div class="overlay-box">
                                    <div class="overlay-inner">
                                        <div class="content">
                                            <a href="books-detail.html" class="link"><span
                                                class="icon fa fa-link"></span></a>
                                            <a href="/site/images/resource/book-15.jpg" data-fancybox="books"
                                               data-caption="" class="link"><span
                                                class="icon flaticon-full-screen"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </figure>
                            <div class="lower-box">
                                <h6><a href="books-detail.html">Design of Everyday</a></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Book Block -->
                    <div class="book-block col-lg-3 col-md-4 col-sm-12">
                        <div class="inner-box">
                            <figure class="image-box">
                                <img src="/site/images/resource/book-16.jpg" alt="">
                                <!-- Overlay Box -->
                                <div class="overlay-box">
                                    <div class="overlay-inner">
                                        <div class="content">
                                            <a href="books-detail.html" class="link"><span
                                                class="icon fa fa-link"></span></a>
                                            <a href="/site/images/resource/book-16.jpg" data-fancybox="books"
                                               data-caption="" class="link"><span
                                                class="icon flaticon-full-screen"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </figure>
                            <div class="lower-box">
                                <h6><a href="books-detail.html">Undercover UX Design</a></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Book Block -->

                </div>

            </div>
        </div>

    </section>
    <!-- End Profile Section -->


</template>

<script>
    import CourseGideItem from './CourseGideItem.vue';
    import store from '../store'
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import ConsultantItem from "./ConsultantItem";
    export default {
        props: ['items'],
        components: {CourseGideItem, Loading},
        data() {
            return {
                isLoading: false,
                fullPage: false,
                activeIndex: null,
                sections: [],
                course_id: '',
                activeTap: 'prod-overview',
                pagination: {},
                edit: false
            }
        },
        computed: {

            authUser: function () {
                return store.getters.authUser
            }
        },
        created() {
            console.log(store.getters.authUser)
            if (localStorage.token)
                this.fetchArticles();
        },
        methods: {
            changeActive(index) {
                this.activeTap = index;
            },
            onToggle(index) {
                if (this.activeIndex == index) {
                    return (this.activeIndex = null);
                }
                this.activeIndex = index;
            },
            fetchArticles() {
                let vm = this;
                this.isLoading = true;
                axios.post('/api/showTrainingByCategory', {
                        headers: {
                            'content-type': 'application/json',
                            // Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    },
                ).then(res => {
                    this.isLoading = false;
                    this.sections = res.data.Trainings;
                })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    });
            }, onCancel() {
                console.log('User cancelled the loader.')
            }

        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>

<style>
    .student-profile-section {

        padding: 140px 0px 90px;
        background-color: #f0f5fb;

    }

    .student-profile-section .profile-tabs .tab-btns {
        border-bottom: 3px solid #00ab15;
    }
</style>

