<template>
    <div>
        <search-filed  v-on:search_result="setSearchResult"></search-filed>
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
        <div class="sidebar-page-container">
            <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
                 data-paroller-type="foreground" data-paroller-direction="vertical"
                 style="background-image: url('/site/images/icons/icon-1.png')">
            </div>
            <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
                 data-paroller-type="foreground" data-paroller-direction="vertical"
                 style="background-image: url('/site/images/icons/icon-2.png')">
            </div>
            <div class="circle-one"></div>
            <div class="circle-two"></div>
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="content-side col-lg-12 col-md-12 col-sm-12">
                        <div v-if="is_search==false" class="our-courses" v-for="section in sections">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix" v-if="section.trainings.length>0">
                                    <div class="pull-right">
                                        <h3>{{section.name}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="cource-block-two col-lg-3 col-md-4 col-sm-6 col-xs-12"
                                     v-for="training in section.trainings">
                                    <course-gide-item
                                        :training="training"
                                        @toggled="onToggle"
                                    ></course-gide-item>
                                </div>
                            </div>
                        </div>
                        <div v-if="is_search==true" class="our-courses">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <h3> نتائج البحث عن "{{search_data}}"</h3>
                                    </div>
                                    <div class="pull-left">
                                        <button class="btn btn-info" @click="is_search=false">اغلاق نتائج البحث</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="cource-block-two col-lg-3 col-md-4 col-sm-6 col-xs-12"
                                     v-for="training in search_result">
                                    <course-gide-item
                                        :training="training"
                                        @toggled="onToggle"
                                    ></course-gide-item>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CourseGideItem from './CourseGideItem.vue';
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        props: ['items'],
        components: {CourseGideItem, Loading},
        data() {
            return {
                isLoading: false,
                fullPage: true,
                activeIndex: null,
                sections: [],
                is_search: false,
                search_data: '',
                search_result: [],
                course_id: '',
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
            setSearchResult(data) {

              this.is_search=true;
              this.search_data=data.title;
              this.search_result=data.data;
            },
            fetchArticles() {
                let vm = this;
                // fetch('/api/showTrainingByCategory', {
                //     method: 'post',
                //     headers: {
                //         Authorization: 'Bearer ' + localStorage.getItem('token'),
                //         'content-type': 'application/json'
                //     }
                // })
                this.isLoading = true;
                axios.post('/api/showTrainingByCategory', {
                        headers: {
                            'content-type': 'application/json',
                            // Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    },
                ).then(res => {
                    this.sections = res.data.Trainings;
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
