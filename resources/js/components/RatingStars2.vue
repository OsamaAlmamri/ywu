<template>
    <div class="star-rating">
        <label class="star-rating__star" :style="[{'font-size':font_size+'em'}]" v-for="rating in ratings"
               :class="{'is-selected': ((value >= rating) && value != null), 'is-disabled': disabled}"
               v-on:click="set(rating)" v-on:mouseover="star_over(rating)" v-on:mouseout="star_out">
            <input class="star-rating star-rating__checkbox" type="radio" :value="rating" :name="name"
                   v-model="value" :disabled="disabled">★</label></div>

</template>
<script>
    export default {

        props: {
            'name': String,
            'font_size': {default:'2' ,type:String},
            // 'value': null,
            'id': String,
            'disabled': Boolean,
            'required': Boolean
        },
        data: function () {
            return {
                value: 1,
                temp_value: null,
                ratings: [1, 2, 3, 4, 5]
            };
        },
        methods: {
            /*
             * Behaviour of the stars on mouseover.
             */
            star_over: function (index) {
                var self = this;

                if (!this.disabled) {
                    this.temp_value = this.value;
                    return this.value = index;
                }

            },

            /*
             * Behaviour of the stars on mouseout.
             */
            star_out: function () {
                var self = this;

                if (!this.disabled) {
                    return this.value = this.temp_value;
                }
            },

            /*
             * Set the rating.
             */
            set: function (value) {
                var self = this;
                this.$emit('change', value);
                if (!this.disabled) {
                    this.temp_value = value;

                    return this.value = value;
                }
                // this.$emit('change', value);
            }
        }
    }

</script>

<style>
    .star-rating__checkbox {
        position: absolute;
        overflow: hidden;
        clip: rect(0 0 0 0);
        height: 1px;
        width: 1px;
        margin: -1px;
        padding: 0;
        border: 0;
    }

    .star-rating__star {
        display: inline-block;
        padding: 3px;
        vertical-align: middle;
        line-height: 1;
        font-size: 1.5em;
        color: #ababab;
        -webkit-transition: color 0.2s ease-out;
        transition: color 0.2s ease-out;
    }

    .star-rating__star:hover {
        cursor: pointer;
    }

    .star-rating__star.is-selected {
        color: #ffd700;
    }

    .star-rating__star.is-disabled:hover {
        cursor: default;
    }

</style>


