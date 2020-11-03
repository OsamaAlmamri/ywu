<template>
    <div
        :class="['dropdown', 'pull-left',{'show':(is_active)}]">
        <button type="button"
                @click="is_active = !is_active"
                class="btn btn-defaulty dropdown-toggle"
                data-toggle="dropdown">
            <span style="font-size: 17px">...</span>
        </button>
        <div class="dropdown-menu"
             :class="['dropdown-menu',{'dropdown_animation':(is_active)},{'show':(is_active)}]">
            <slot name="items"></slot>

        </div>
    </div>
</template>

<script>

    export default {
        props: {
            is_active_dropdown: {default: false, type: Boolean},

        },
        data() {
            return {
                is_active: false,

            }
        },
        created() {
            this.is_active=this.is_active_dropdown;
        },


    }
</script>
