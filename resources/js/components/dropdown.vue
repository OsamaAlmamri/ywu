<template>
    <div
        :class="['dropdown', 'pull-left',{'show':(is_active_dropdown)}]">
        <button type="button"
                @click="is_active_dropdown=!is_active_dropdown"
                class="btn btn-defaulty dropdown-toggle"
                data-toggle="dropdown">
            <span style="font-size: 17px">...</span>
        </button>
        <div class="dropdown-menu"
             :class="['dropdown-menu',{'dropdown_animation':(is_active_dropdown)},{'show':(is_active_dropdown)}]">
            <slot name="items">    </slot>

        </div>
    </div>
</template>

<script>

    export default {
        props: {
            is_active_dropdown:{default:false ,type:Boolean},

        },
    }
</script>
