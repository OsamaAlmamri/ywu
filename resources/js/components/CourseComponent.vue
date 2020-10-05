<template>
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
                <div  v-for="training in subject.trainings" class="cource-block-two col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <course-gide-item
                            v-for="(training,index) in subject.trainings"
                            :item="training"
                            :key="index"
                            :is-register="activeIndex == index"
                            @toggled="onToggle"
                        ></course-gide-item>
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
                course: {
                    id: '',
                    title: '',
                    body: ''
                },
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
            fetchArticles() {
                let vm = this;
                fetch('/api/showTrainingByCategory', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.sections = res.Trainings;
                    })
                    .catch(err => console.log(err));
            },

        },
        mounted() {
            console.log('Component mounted.')
        },


    }
</script>
