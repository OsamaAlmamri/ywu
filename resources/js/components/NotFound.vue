<template>
    <!--Error Section-->
    <section class="error-section">
        <div class="auto-container">
            <div class="content">
                <div class="image">
                    <img src="/site/images/resource/error.png" alt="">
                </div>
<!--                <div class="theme-btn btn-style-two"></div>-->
                <router-link @click.native="$scrollToTop"  class="theme-btn btn-style-two" to="/home">
                    <span class="txt">{{ $t('notfound') }} <i class="fa fa-angle-left"></i></span>

                </router-link>
<!--                <a href="course.html" class="theme-btn btn-style-two">-->
<!--                    <span class="txt">Back to the homepage <i class="fa fa-angle-right"></i></span>-->
<!--                </a>-->
            </div>
        </div>
    </section>
    <!--End Error Section-->

</template>
<script>
export default {

}
</script>
