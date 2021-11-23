if (!self.define) {
    const e = e => {
        "require" !== e && (e += ".js");
        let s = Promise.resolve();
        return i[e] || (s = new Promise((async s => {
            if ("document" in self) {
                const i = document.createElement("script");
                i.src = e, document.head.appendChild(i), i.onload = s
            } else importScripts(e), s()
        }))), s.then((() => {
            if (!i[e]) throw new Error(`Module ${e} didn’t register its module`);
            return i[e]
        }))
    }, s = (s, i) => {
        Promise.all(s.map(e)).then((e => i(1 === e.length ? e[0] : e)))
    }, i = {require: Promise.resolve(s)};
    self.define = (s, a, c) => {
        i[s] || (i[s] = Promise.resolve().then((() => {
            let i = {};
            const r = {uri: location.origin + s.slice(1)};
            return Promise.all(a.map((s => {
                switch (s) {
                    case"exports":
                        return i;
                    case"module":
                        return r;
                    default:
                        return e(s)
                }
            }))).then((e => {
                const s = c(...e);
                return i.default || (i.default = s), i
            }))
        })))
    }
}
define("./sw.js", ["./workbox-6f2d4622"], (function (e) {
    "use strict";

    self.addEventListener("message", (e => {
        e.data && "SKIP_WAITING" === e.data.type && self.skipWaiting()
    }))
    self.addEventListener('fetch', event => {
        event.respondWith(
            caches.match(event.request).then(function(response) {
                return response || fetch(event.request);
            })
        );
    })
        ,

        e.precacheAndRoute(
            [
                {
        url: "css/animate.css",
        revision: "9553df5b101bfd7910ed3637f4479e09"
    }, {url: "css/bootstrap-rtl.min.css", revision: "a7022c6fa83d91db67738d6e3cd3252d"}, {
        url: "css/bootstrap.css",
        revision: "a7022c6fa83d91db67738d6e3cd3252d"
    }, {url: "css/bootstrap.min.css", revision: "a7022c6fa83d91db67738d6e3cd3252d"}, {
        url: "css/custom-animate.css",
        revision: "649f3715aa89e5b224a289a663856b85"
    }, {url: "css/flaticon.css", revision: "1ae0cea97add6efd9493bd89f12f80c1"}, {
        url: "css/font-awesome.css",
        revision: "dea7ea7b02cfeddd406b817ab9e32922"
    }, {
        url: "css/images/ui-icons_444444_256x240.png",
        revision: "f27e6ab4519a9324edd36791643fe467"
    }, {
        url: "css/jquery-ui.css",
        revision: "a89a98dfbfe159c32615134e9fe85ceb"
    }, {
        url: "css/jquery.bootstrap-touchspin.css",
        revision: "c82a1dde47ad0956ce4a8a71761cc87e"
    }, {
        url: "css/jquery.fancybox.min.css",
        revision: "35d290afd71a6053d8195ea13170b4e9"
    }, {
        url: "css/jquery.mCustomScrollbar.min.css",
        revision: "48ced4b8591f0e0216bf4a44926cbbb2"
    }, {url: "css/main5.css", revision: "dfa32d2d099c2f52ffb2b4b660ad99d9"}, {
        url: "css/mcq.css",
        revision: "f4e14e9ceb667d59b748b0c2eab40880"
    }, {url: "css/osama3.css", revision: "eb0f1fd12469bb79eea8d0647e4aa158"}, {
        url: "css/owl.css",
        revision: "0c44b1327d7299a41c854b09bce96f83"
    }, {url: "css/responsive.css", revision: "4bd8c5103cee9119fb9844938bb123f9"}, {
        url: "css/responsive2.css",
        revision: "540cc12d6c53b6b95fe8aac0ad0bd922"
    }, {url: "css/rtl_bootstrap.css", revision: "dd3de3fd861b9f25fcafffa5ef6f2c8f"}, {
        url: "css/rtl/bootstrap-rtl.css",
        revision: "9fea7f92de0270d9ca1efb0a10d73d9f"
    }, {url: "css/rtl/bootstrap.css", revision: "82252d754417f95f7779be349acc6361"}, {
        url: "css/swiper.css",
        revision: "4aa7fea3fbfcf0e57572bda5cdf2ec04"
    }, {
        url: "fonts/DroidKufi-Bold.ttf",
        revision: "1b89eb34f74a02c0681727faadf48466"
    }, {url: "fonts/DroidKufi-Regular.ttf", revision: "a9b030e29a35f523a137ee0175be419f"}, {
        url: "fonts/flaticon-1.eot",
        revision: "ee223af2a2dc8273b735e0dad3b62560"
    }, {url: "fonts/flaticon.eot", revision: "ee223af2a2dc8273b735e0dad3b62560"}, {
        url: "fonts/flaticon.svg",
        revision: "5f119dcd8eb88922df5f7196d0c11abd"
    }, {url: "fonts/flaticon.ttf", revision: "2c8c502f2c400c7c59306dfa0682e170"}, {
        url: "fonts/flaticon.woff",
        revision: "12aab8dab96c953c7f614b56d9f0b27b"
    }, {
        url: "fonts/fontawesome-webfont-1.eot",
        revision: "404a525502f8e5ba7e93b9f02d9e83a9"
    }, {
        url: "fonts/fontawesome-webfont.eot",
        revision: "404a525502f8e5ba7e93b9f02d9e83a9"
    }, {
        url: "fonts/fontawesome-webfont.svg",
        revision: "bae4a87c1e5dff40baa3f49d52f5347a"
    }, {
        url: "fonts/fontawesome-webfont.ttf",
        revision: "fb650aaf10736ffb9c4173079616bf01"
    }, {
        url: "fonts/fontawesome-webfont.woff",
        revision: "891e3f340c1126b4c7c142e5f6e86816"
    }, {
        url: "fonts/fontawesome-webfont.woff2",
        revision: "926c93d201fe51c8f351e858468980c3"
    }, {url: "fonts/LICENSE.txt", revision: "0cc1a9e33dd7a6eb0b79927742cf005c"}, {
        url: "images/app-stor-img.png",
        revision: "0ad622076fca6c54b66d25c65a3aa375"
    }, {url: "images/background/_2.png", revision: "4a4cffeac4e1fa90721fb4bcace34f07"}, {
        url: "images/background/1.png",
        revision: "bc7bb6253ef5e361615c7c6af6a09e1d"
    }, {
        url: "images/background/3_1.png",
        revision: "0a9c0af92bd62b68f36127635576a3b6"
    }, {
        url: "images/background/4.png",
        revision: "8e88c8e8e1577c1f5ed3949e99784c41"
    }, {
        url: "images/background/pattern-1.png",
        revision: "615b1c13eacd1ea4127e89b6ff179d29"
    }, {
        url: "images/background/pattern-2.png",
        revision: "f8ef933192529d8208cad258034c1778"
    }, {
        url: "images/background/pattern-3.png",
        revision: "2d530be3044db2f2222cf732b0a09a32"
    }, {url: "images/deafult.png", revision: "9a328bfac18faa9058431cca77fc7884"}, {
        url: "images/empty-cart.png",
        revision: "afa6a28d0ee0b5e7d55b7a5aecdfedec"
    }, {url: "images/fam.png", revision: "5d654340c46ee33fa64ce9b29b8b7779"}, {
        url: "images/footer-logo.png",
        revision: "1c77e01b088b03ef3d08e1343f84559c"
    }, {url: "images/footer-logo.svg", revision: "a239d38ed82ee62ec467b9a48042aaee"}, {
        url: "images/footer/1.png",
        revision: "73f767ef36efda8843b2bb17346bea49"
    }, {url: "images/footer/2.png", revision: "15b3ec910e099452030d8e9b0ab6d090"}, {
        url: "images/footer/3.png",
        revision: "d2bfe452c927c01f5dcada6403b39a3d"
    }, {
        url: "images/google-play-img.png",
        revision: "4def321ec4cc3bd4f799f4d46aa612e0"
    }, {
        url: "images/icons/dotted-layer-1.png",
        revision: "8d2ec1947ac37cbee8bf2e467650cd9c"
    }, {
        url: "images/icons/dotted-layer-2.png",
        revision: "a793fa0a7c26252fdc33541565c46124"
    }, {
        url: "images/icons/dotted-layer-3.png",
        revision: "82d6d890be39f94ab69f435ea717fa7c"
    }, {
        url: "images/icons/dotted-layer.png",
        revision: "77014070533dde7a429ff7a5883290cd"
    }, {url: "images/icons/icon-1.png", revision: "78032e190e77962f102482ac2dc26482"}, {
        url: "images/icons/icon-2.png",
        revision: "f340e085e8162e328f07079e691143cf"
    }, {url: "images/icons/icon-3.png", revision: "73c5efea56c49dc7875270aed558ee1e"}, {
        url: "images/icons/icon-4.png",
        revision: "b531e728fd2698b83127c34ac75a04af"
    }, {url: "images/icons/icon-5.png", revision: "5899a337f6ea6c88f604c9c135d3d14e"}, {
        url: "images/icons/icon-6.png",
        revision: "8f1e5b274757f6541b8d79f4ad51dd79"
    }, {url: "images/icons/icon-7.png", revision: "e85f9994357945054ac34e083b802a0d"}, {
        url: "images/icons/icon-8.png",
        revision: "6be813baa9d2346ba93ec4facef878b1"
    }, {
        url: "images/icons/icon-9.png",
        revision: "63ff405d73f9d3d95f038d5646d831d5"
    }, {
        url: "images/icons/preloader.svg",
        revision: "cc1e6b430fcc65d5f843525813adb7ed"
    }, {
        url: "images/icons/waves-shape.png",
        revision: "6f1466c11e9f8f776317e864480dc326"
    }, {url: "images/img-no-products.png", revision: "85e87bd4fe8178614a75ff81b002dc5f"}, {
        url: "images/instructor.png",
        revision: "67d08f1b5e2793f892c703ad2946988e"
    }, {url: "images/law.jpg", revision: "4235846a39127f06c1918e3745c703fb"}, {
        url: "images/logo_white.png",
        revision: "69c62f3858db1c5a314936a88a7091e8"
    }, {url: "images/logo_white192.png", revision: "a963c01f4af53a90574b2070cbfc2a70"}, {
        url: "images/logo.png",
        revision: "641e765f47715f81c9bfc803b48edd71"
    }, {url: "images/Logo250p50x.png", revision: "cbcb3d0ef3d855f18ecf6780fc188476"}, {
        url: "images/Logo250p5xl.png",
        revision: "b7636649d4b877a11405b897cb363a25"
    }, {url: "images/Logo250px.png", revision: "7dbb296e7302967905cd3817ff08bdb5"}, {
        url: "images/Logo250px.svg",
        revision: "e2781aec169e8a81242f0759ac8c01c1"
    }, {url: "images/Logo250px2.png", revision: "641e765f47715f81c9bfc803b48edd71"}, {
        url: "images/my-style.css",
        revision: "37185e7ee5736389a44fd3de931ad2a4"
    }, {url: "images/no_order.png", revision: "795578d3870a01c2857c6eb419b06b4b"}, {
        url: "images/ph6.png",
        revision: "cc4a090fe34ab5cd97dab7e9f9990015"
    }, {url: "images/physc.png", revision: "e81e56627b9dfde9f09446d12f34b6da"}, {
        url: "images/siteloading.gif",
        revision: "fd42f6cbf2d662175f36d84895fdfba5"
    }, {url: "images/t/issue.png", revision: "d78d7a2ba1b2a73da786acfd32822396"}, {
        url: "images/t/law.png",
        revision: "c9009100d218b0eab8ad6871f0d585d2"
    }, {url: "images/t/phsycho.png", revision: "d69d4b8c99cf361ecd0d2800c31bc48a"}, {
        url: "js/appear.js",
        revision: "cbbd68c06c9cdb2481b7050f6e64375e"
    }, {url: "js/bootstrap.min.js", revision: "eb5fac582a82f296aeb74900b01a2fa3"}, {
        url: "js/element-in-view.js",
        revision: "71e2b6f29bd69ef91310ac47a18df647"
    }, {url: "js/jquery-ui.js", revision: "45bedc12dcfee87eeec2fab0eacc4282"}, {
        url: "js/jquery.countdown.js",
        revision: "4090eede0be32f5a0b40fe11afc5abaf"
    }, {url: "js/jquery.easing.min.js", revision: "55a5ad3c9dc153988571c9f428f5e872"}, {
        url: "js/jquery.fancybox.js",
        revision: "6e11711058a9459a94d5a19b26a78135"
    }, {
        url: "js/jquery.js",
        revision: "4f252523d4af0b478c810c2547a63e19"
    }, {
        url: "js/jquery.mCustomScrollbar.concat.min.js",
        revision: "71951b246c4726520dce912a5ac7f03c"
    }, {url: "js/jquery.paroller.min.js", revision: "394b3ad178eb6e985869e8182452c814"}, {
        url: "js/jquery.scrollTo.js",
        revision: "522f8cb082a0b45fa5c2c2e0a359b030"
    }, {url: "js/owl.js", revision: "54428880ec8df798ac3d666f5113c7ff"}, {
        url: "js/parallax.min.js",
        revision: "6dbee040c8d4fb731bd44936b2efc99a"
    }, {url: "js/popper.min.js", revision: "c1d29c9b4fa7a8ee8417a01bc9ac1b56"}, {
        url: "js/script.js",
        revision: "da410caab344ef46d8483beb9c4e811a"
    }, {url: "js/swiper.min.js", revision: "ab83c52f4352dd9925a565bfb48e9a11"}, {
        url: "js/tilt.jquery.min.js",
        revision: "567e7cce26dc2060b3be1b9c5ff0d0f9"
    }, {url: "js/validate.js", revision: "c28328398b66ade3679f4b2617c082ac"}, {
        url: "js/wow.js",
        revision: "105fb3799fcf14f1ea8fcff23f2686dc"
    }, {url: "logo_white192.png", revision: "a963c01f4af53a90574b2070cbfc2a70"}, {
        url: "vue/loading2.css",
        revision: "f7d4bd8106906f7b3e07c7ed511fb175"
    }, {
        url: "vue/vue-clazy-load.min.js",
        revision: "dda8b1c4ccff760195a708097ddcf6c8"
    }], {ignoreURLParametersMatching: [/^utm_/, /^fbclid$/]})
}));
//# sourceMappingURL=sw.js.map
