<template>

    <li v-if="lang=='ar'"
        class="navi-item"
        :class="{ 'navi-item-active': isActiveLanguage('ar') }"

    >
        <a
            href="#"
            class="navi-link"
            data-lang="en"
            v-on:click="selectedLanguage('en')"
        >
          <span class="symbol symbol-20">
            <img style="width: 15px" src="/flags/226-united-states.svg" alt=""/>
          </span>
            <span class="navi-text">En</span>
        </a>
    </li>

    <li v-else
        class="navi-item"
        :class="{ 'navi-item-active': isActiveLanguage('en') }"

    >
        <a
            href="#"
            class="navi-link"

            v-on:click="selectedLanguage('ar')"
        >
          <span class="symbol symbol-20 ">
                 <img style="width: 15px" src="/flags/232-yemen.svg" alt=""/>

          </span>
            <span class="navi-text">Ar</span>
        </a>
    </li>

</template>

<script>
import i18nService from "@/services/i18n.service.js";
import i18n from "@/plugins/vue-i18n";
import router from "../routes";

export default {
    name: "KTDropdownLanguage",
    data() {
        return {
            lang: i18nService.getActiveLanguage(),
            clang: i18n,
            languages: i18nService.languages
        };
    },

    methods: {

        selectedLanguage(lang) {
            this.lang = lang;
            i18n.locale = lang;
            localStorage.setItem("lang", lang);
            // window.location.reload();
            let href = "";
            let body_style = "direction: rtl";
            let dir = "rtl";
            if (lang == 'ar') {
                href = '/site/css/main5.css';
                body_style = body_style;
            } else {
                body_style = "direction: ltr";
                href = '/site/css/main_en.css';
                dir = "ltr";
            }
            // document.head.appendChild(file);
            document.getElementById("style_lang").setAttribute("href", href);
            var body = document.getElementsByTagName("body")[0];
            body.style = body_style;
            body.setAttribute("dir", dir);
            body.setAttribute("direction", dir);
            document.cookie = "style_lang=" + lang + "; path=/";
            // const refreach_pages = [];
            const refreach_pages = ["women", "courses222"];
            if (refreach_pages.includes(router.currentRoute.name))
                window.location.reload();
        },
        isActiveLanguage(current) {
            return this.activeLanguage === current;
        }
    },
    computed: {
        activeLanguage() {
            return i18nService.getActiveLanguage();
        }
    }
};
</script>
