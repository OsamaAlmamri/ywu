<template>
    <!--Sidebar Page Container-->
    <div class="sidebar-page-container">
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
                <div class="content-side col-lg-9 col-md-12 col-sm-12">
                    <div class="our-courses">

                        <!-- Options View -->
                        <div class="options-view">
                            <div class="clearfix">
                                <div class="pull-right">
                                    <h3> منشورات شؤون المراة</h3>
                                </div>

                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="cource-block-two col-lg-3 col-md-4 col-sm-6 col-xs-12"
                                 v-for="women_post in women_posts">
                                <women-item
                                    :women_post="women_post"
                                    @toggled="onToggle"
                                ></women-item>
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
                <div class="sidebar-side style-two col-lg-3 col-md-12 col-sm-12">
                    <recent-posts :mame="'اخر المنشورات'" :type="'women'"></recent-posts>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
    import WomenItem from './WomenItem.vue';

    export default {
        props: ['items'],
        components: {WomenItem},
        data() {
            return {
                activeIndex: null,
                women_posts: [],
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
                axios.post('/api/ShowP', {
                        headers: {
                            'content-type': 'application/json',
                            // Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    },
                ).then(res => {
                    // console.log(res.data.Posts.data)
                    this.women_posts = res.data.Posts.data;
                })
                    .catch(err => console.log(err));
            },

        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>
