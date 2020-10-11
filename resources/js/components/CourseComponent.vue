<template>
    <div>
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
                        <div class="our-courses" v-for="section in sections">
                            <!-- Options View -->
                            <div class="options-view">
                                <div class="clearfix">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CourseGideItem from './CourseGideItem.vue';

    export default {
        props: ['items'],
        components: {CourseGideItem},
        data() {
            return {
                activeIndex: null,
                sections: [],
                course_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {

            // if(localStorage.token) {
            //     axios.post('/api/showTrainingByCategory', {
            //             headers: {
            //                 'content-type': 'application/json',
            //                 Authorization: 'Bearer ' + localStorage.getItem('token')
            //             }
            //         },
            //     ).then(response => {
            //        var res = response.json()
            //         this.sections = res.Trainings;
            //         store.commit('loginUser')
            //     }).catch(error => {
            //         if (error.response.status === 401 || error.response.status === 403) {
            //             store.commit('logoutUser')
            //             localStorage.setItem('token', '')
            //             this.$router.push({name: 'login'})
            //         }
            //
            //     });
            // }

            if (localStorage.token)
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
                let vm = this;
                // fetch('/api/showTrainingByCategory', {
                //     method: 'post',
                //     headers: {
                //         Authorization: 'Bearer ' + localStorage.getItem('token'),
                //         'content-type': 'application/json'
                //     }
                // })
                axios.post('/api/showTrainingByCategory', {
                        headers: {
                            'content-type': 'application/json',
                            // Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    },
                ).then(res => {
                    this.sections = res.data.Trainings;
                })
                    .catch(err => console.log(err));
            },

        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>
