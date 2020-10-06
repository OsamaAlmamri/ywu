<template>
<div>




    <!-- Contact Page Section -->
    <section class="contact-page-section">
        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20"
             data-paroller-type="foreground" data-paroller-direction="vertical"
             style="background-image: url('site/images/icons/icon-1.png')"></div>
    <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20"
         data-paroller-type="foreground" data-paroller-direction="vertical"
         style="background-image: url('site/images/icons/icon-2.png')"></div>
    <div class="auto-container">
        <div class="inner-container">
            <!-- Sec Title -->
            <div class="sec-title centered">
                <h2><a href="http://idioms.in/in-touch/">راسلنا</a></h2>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">

                <!-- Profile Form -->
                <form method="post" action="sendemail.php" id="contact-form">
                    <div class="row clearfix">

                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="text" name="username" placeholder="الاسم *" required="">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="text" name="lastname" placeholder=" المنظمة *" required="">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="email" name="email" placeholder="الايميل *" required="">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="text" name="phone" placeholder="رقم الهاتف *" required="">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <textarea class="" name="message" placeholder="الرسالة"></textarea>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-left">
                            <button class="theme-btn btn-style-three" type="submit" name="submit-form"><span
                                class="txt">ارسال  <i class="fa fa-angle-left"></i></span></button>
                        </div>

                    </div>
                </form>

            </div>

        </div>

        <!-- Contact Info Section -->
        <div class="contact-info-section">
            <div class="title-box">
                <h2>معلومات التواصل</h2>
                <div class="text">
                </div>
            </div>

            <div class="row clearfix">

                <!-- Info Column -->
                <div class="info-column col-lg-4 col-md-6 col-sm-12">
                    <div class="info-inner">
                        <div class="icon fa fa-phone"></div>
                        <strong> معلومات التواصل</strong>
                        <ul>
                            <li><a href="tel:+96701480489">+967 01 480489</a></li>
                            <li><a href="mailto:info@yourcompany.com">info@yourcompany.com</a></li>

                        </ul>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="info-column col-lg-4 col-md-6 col-sm-12">
                    <div class="info-inner">
                        <div class="icon fa fa-clock-o"></div>
                        <strong>ساعات الدوام</strong>

                        <ul>
                            <li>السبت - الاربعاء
                                9:00 صباحاً - 2:00 ظهراً</li>
                        </ul>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="info-column col-lg-4 col-md-6 col-sm-12">
                    <div class="info-inner">
                        <div class="icon fa fa-map-marker"></div>
                        <strong>العنوان</strong>
                        <ul>
                            <li>المكتب التنفيذي
                                صنعاء - التحرير خلف البنك المركزي</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

    </div>
    </section>
    <!-- End Contact Page Section -->

    <!-- Map Section -->
    <section class="map-section">
        <!-- Map Boxed -->
        <div class="map-boxed">
            <!--Map Outer-->
            <div class="map-outer">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3847.4912839734206!2d44.211639785392165!3d15.349856989328774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1603dbab376b81db%3A0xe04a368156121a0d!2z2KPYqtit2KfYryDZhtiz2KfYoSDYp9mE2YrZhdmG!5e0!3m2!1sar!2s!4v1601595513798!5m2!1sar!2s"
                    width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                    tabindex="0"></iframe>
            </div>
        </div>
    </section>
    <!-- End Map Section -->


</div>

</template>
<script>
export default {

}
</script>
