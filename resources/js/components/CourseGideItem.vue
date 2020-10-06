<template>

    <div class="inner-box">
        <div class="image">
            <router-link  :to="{ name: 'course_details', params: { id: training.id}}">
                <clazy-load class="wrapper"  :src="'assets/images/' + training.thumbnail" >
                    <transition name="fade">
                        <div class="divClass"
                             v-bind:style="{ backgroundImage: 'url(assets/images/' + training.thumbnail + ')' }">
                        </div>
                    </transition>
                    <transition name="fade" slot="placeholder">
                        <div class="vue_preloader">
                            <div class="circle">
                                <div class="circle-inner"></div>
                            </div>
                        </div>
                    </transition>
                </clazy-load>
            </router-link>
        </div>
        <div class="lower-content">
            <h5>
                <router-link  :to="{ name: 'course_details', params: { id: training.id}}">

                {{training.name}}
                </router-link>
            </h5>

            <div class="clearfix">
                <div class="pull-right">
                    <div class=" students"> {{(training.start_at)}} <i class="fa fa-calendar"></i></div>
                </div>
                <div class="pull-left">
                    <div class="students hours">{{training.length}} <i class="fa fa-clock-o"></i></div>
                </div>
            </div>
        </div>

    </div>


</template>

<script>
    export default {
        props: ['training'],
        methods: {
            toggle() {
                this.$emit('toggled', this.$vnode.key)
            }
        }
    }
</script>
