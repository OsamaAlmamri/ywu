<template>
    <div class="inner-box">
        <div class="image">
            <a :href="training.id">
                <div class="divClass"
                     v-bind:style="{ backgroundImage: 'url(assets/images/' + training.thumbnail + ')' }">
                </div>
            </a>
        </div>
        <div class="lower-content">
            <h5><a href="">{{training.name}}</a>
            </h5>

            <div class="pull-right">
                <div class=" students"> {{(training.start_at)}} <i class="fa fa-calendar"></i></div>
            </div>
            <div class="pull-left">
                <div class="students hours">{{training.length}} <i class="fa fa-clock-o"></i></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['training', 'isRegister'],
        methods: {
            toggle() {
                this.$emit('toggled', this.$vnode.key)
            }
        }
    }
</script>
