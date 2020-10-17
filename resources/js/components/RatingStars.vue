<template>
    <div class="rating_star">
        <slot name="before">    </slot>

        <span v-for="i in parseInt(rating)" class="fa fa-star"></span>
        <span v-for="i in system-rating" class="fa fa-star-o"></span>
        <slot name="after">    </slot>
    </div>
</template>
<script>
    export default {
        props: ['rating', 'system'],
    }
</script>


