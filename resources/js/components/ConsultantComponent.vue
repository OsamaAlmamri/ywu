<template>
    <!--Sidebar Page Container-->
    <div class="sidebar-page-container">
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
             style="background-image: url(site/images/icons/icon-1.png)"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url(site/images/icons/icon-2.png)"></div>
        <div class="circle-one"></div>
        <div class="circle-two"></div>
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Content Side -->
                <div class="content-side col-lg-8 col-md-12 col-sm-12">
                    <div class="our-courses">

                        <!-- Options View -->
                        <div class="options-view">
                            <div class="clearfix">
                                <div class="pull-right">
                                    <h3>الاستشارات </h3>
                                </div>

                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="cource-block-two  col-sm-12 col-xs-12"
                                 v-for="post in posts">
                                <consultant-item
                                    :post="post"
                                    @toggled="onToggle"
                                ></consultant-item>
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
                                <li class="next"><a href="#"><span class="fa fa-angle-right"></span> </a></li>
                            </ul>
                        </div>

                    </div>

                </div>

                <!-- Sidebar Side -->
                <div class="sidebar-side style-two col-lg-4 col-md-12 col-sm-12">
                    <recent-posts name="اخر الاستشارات" type="posts"></recent-posts>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
    import ConsultantItem from "./ConsultantItem";
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
        props: ['items'],
        components: {ConsultantItem, Loading},
        data() {
            return {
                isLoading: false,
                fullPage: false,
                activeIndex: null,
                posts: [],
                women_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {
            this.fetchArticles();
        },
        methods: {
            onToggle(index) {
                if (this.activeIndex == index) {
                    return (this.activeIndex = null);
                }
                this.activeIndex = index;
            },
            fetchArticles() {
                this.isLoading = true;

                axios.post('/api/AllPosts', {
                        headers: {
                            'content-type': 'application/json',
                            // Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    },
                ).then(res => {
                    // console.log(res.data.Posts.data)
                    this.posts = res.data.Posts.data;
                    this.isLoading = false;

                })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    });
            },
            onCancel() {
                console.log('User cancelled the loader.')
            }

        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>
