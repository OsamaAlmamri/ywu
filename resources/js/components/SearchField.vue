<template>
    <!-- Page Title -->
    <section class="page-title">
        <div class="auto-container">
            <h1> {{ $t('MENU.' + $route.name) }} <span v-if="this.append_name!=null">({{ this.append_name }})</span>
            </h1>
            <!-- Search Boxed -->
            <div v-if="showSearchFiled==true" class="search-boxed">
                <div class="search-box">
                    <form method="post" action="contact.html">
                        <div class="form-group">
                            <input type="search"
                                   v-model="searchData"
                                   value="" :placeholder=" $t('search.description')"
                                   required="">
                            <button @click.prevent="search()" type="button"><span class="icon fa fa-search"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--End Page Title-->

</template>
<script>
import axios from "axios";

export default {
    data() {
        return {
            isLoading: false,
            fullPage: true,
            searchData: '',
        }
    },
    props: {
        'title': String,
        'append_name': {default: null, type: String},

    },
    methods: {

        search() {
            this.isLoading = true;
            axios({
                url: '/api/search', data: {'type': this.search_type, 'search': this.searchData}, method: 'POST'
            })
                .then(resp => {
                    this.isLoading = false;
                    var data = [];

                    if (resp.data.status == false) {
                        toastStack('   خطاء ', resp.data.msg, 'error');
                    } else {
                        data = resp.data.data;
                    }
                    this.$emit('search_result', {'data': data, 'title': this.searchData});
                })
                .catch(err => {
                    console.log(err)
                })
            this.$emit('click', this.$vnode.key)
        },
        toggle() {
            this.$emit('toggled', this.$vnode.key)
        },
        onCancel() {
            console.log('User cancelled the loader.')
        }
    },
    computed: {

        showSearchFiled: function () {
            return (this.$route.name == 'courses' ||
                this.$route.name == 'women' ||
                // this.$route.name == 'home' ||
                // this.$route.name == 'shop' ||
                // this.$route.name == 'home2' ||
                this.$route.name == 'consultant');
        }, search_type: function () {
            if (this.$route.name == 'courses' ||
                this.$route.name == 'home')
                return "trainings";
            else if (this.$route.name == 'women')
                return "women_posts";
            else
                return "posts";
        },

        pageName: function () {

            switch (this.$route.name) {
                case 'home' :
                    return trans('home');
                    break;

                case 'my_orders' :
                    return "طلباتي";
                    break;

                case 'shop_search' :
                    return "البحث عن منتجات محددة";
                    break;

                case 'shop_seller' :
                    return "منتجات متجر ";
                    break;

                case 'shop_like' :
                    return "منتجاتي المفضلة";
                    break;

                case 'CategoryProducts' :
                    return "منتجات الصنف ";
                    break;

                case 'shop' :
                    return "السوق الإلكتروني";
                    break;

                case 'product_details' :
                    return "تفاصيل المنتج";
                    break
                case 'cart' :
                    return " سلة المنتجات ";
                    break;

                case 'home2' :
                    return "السوق الإلكتروني";
                    break;

                case 'women_details' :
                    return "تفاصيل شؤون المرأة";
                    break;

                case 'courses' :
                    return "المواد التدريبية";
                    break;
                case 'women' :
                    return "شؤون المرأة ";
                    break;
                case 'course_details' :
                    return "تفاصيل المادة التدريبية";
                    break;

                case 'privacy' :
                    return "سياسة الخصوصية";
                    break;

                case 'concatUs' :
                    return "تواصل معنا";
                    break;
                case 'about' :
                    return "عنا ";
                    break;
                case 'profile' :
                    return "الصفحة الشخصية ";
                    break;
                case 'consultant' :
                    return " الإستشارات ";
                    break;
                case 'register' :
                    return "انشاء حساب جديد";
                    break;
                case 'login' :
                    return "تسجيل الدخول";
                    break;
                default:
                    return "";

            }
        }
    },

}
</script>
