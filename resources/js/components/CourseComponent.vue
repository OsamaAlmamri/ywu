<template>
    <div>
        <search-filed v-on:search_result="setSearchResult"></search-filed>
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
                            <div v-if="section.trainings.length>0" class="options-view p-2 text-primary" >
                                <div class="clearfix" v-if="section.trainings.length>0">
                                    <div class="d-flex justify-content-start">
                                        <h4>
                                            {{ oneLang( section.name, section.name_en) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div v-if="section.trainings.length>0" class="row clearfix">
                                <div class=" col-xs-12 col-md-6 mb-3"
                                     v-for="training in section.trainings">
                                    <!--                                    <course-gide-item-->
                                    <!--                                -->
                                    <!--                                    ></course-gide-item>-->
                                    <course-gide-item
                                        :training="training"
                                        @toggled="onToggle">

                                    </course-gide-item>
                                </div>
                            </div>
                        </div>
                        <div v-if="is_search==true" class="our-courses">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <h3>{{ $t('search.result') }}"{{ search_data }}"</h3>
                                    </div>
                                    <div class="pull-left">
                                        <button class="btn btn-info" @click="is_search=false"> {{ $t('search.close') }} </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="cource-block-two  col-xs-12"
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

        getLang(lang, txt_ar, txt_en) {
            console.log(lang)
            return (lang == 'en') ? txt_en : txt_ar;
        },
        onToggle(index) {
            if (this.activeIndex == index) {
                return (this.activeIndex = null);
            }
            this.activeIndex = index;
        },
        setSearchResult(data) {

            this.is_search = true;
            this.search_data = data.title;
            this.search_result = data.data;
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
