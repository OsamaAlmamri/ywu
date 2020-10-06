<template>
    <!-- Page Title -->
    <section class="page-title">
        <div class="auto-container">
            <h1> {{pageName}}</h1>
            <!-- Search Boxed -->
            <div class="search-boxed">
                <div class="search-box">
                    <form method="post" action="contact.html">
                        <div class="form-group">
                            <input type="search" name="search-field" value="" placeholder=" هل تبحث عن شيء ؟"
                                   required="">
                            <button type="submit"><span class="icon fa fa-search"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--End Page Title-->

</template>
<script>
    export default {
        props: ['title'],

        methods: {
            toggle() {
                this.$emit('toggled', this.$vnode.key)
            }
        },
        computed: {
            pageName: function () {
                switch (this.title) {
                    case 'home' :
                        return "الرئيسية";
                        break;

                    case 'courses' :
                        return "المواد التدريبية";
                        break;

                    case 'privacy' :
                        return "سياية الخصوصية";
                        break;

                    case 'concatUs' :
                        return "تواصل معنا";
                        break;
                    case 'register' :
                        return "انشاء حساب جديد";
                        break;
                    case 'login' :
                        return "تسجيل الدخول";
                        break;
                    default:
                        return " --";

                }
            }
        },

    }
</script>
