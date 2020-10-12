<template>
    <div class="wrap">
        <div class="container" :style="paddingTop">
            <h1 class="title scale">Vodal</h1>
            <h3 class="intro scale">A vue modal with animations.</h3>
            <div class="btn-area">
                <button class="btn scale" v-text="item" v-bind:key="index" v-for="(item, index) in types"
                        :style="delay(index)" @click="onShow(item)"/>
            </div>
            <vodal measure="em" :show="show" :animation="animation" :width="28.5" :height="17" :duration="301"
                   className="my-dialog" @hide="show = false">
                <div class="header">Vodal</div>
                <div class="body">A vue modal with animations.</div>
                <button class="vodal-confirm-btn" @click="show = false">ok</button>
                <button class="vodal-cancel-btn" @click="show = false">close</button>
            </vodal>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                show: false,
                animation: '',
                paddingTop: `paddingTop: ${(window.innerHeight - 440) / 2}px`,
                types: ['zoom', 'fade', 'flip', 'door', 'rotate', 'slideUp', 'slideDown', 'slideLeft', 'slideRight']
            }
        },

        methods: {
            delay(index) {
                return `
        animationDelay: ${index * 100}ms;
        WebkitAnimationDelay: ${index * 100}ms;
      `;
            },

            onShow(animation) {
                this.animation = animation;
                this.show = true;
            }
        }
    }
</script>

<style>
    @import "/vodal/common.css";
    @import "/vodal/rotate.css";
</style>


