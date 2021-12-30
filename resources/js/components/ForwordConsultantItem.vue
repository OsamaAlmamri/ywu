<template>
    <div class="inner-box">
        <sweet-modal :title="post.title"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="comments">
            <div v-for="(comment,key ) in  post.comments">
                <div class="row">
                    <div class="col-xs-2 col-xs-4 d-flex justify-content-start">
                        <i class="fa fa-comment"> </i>
                    </div>
                    <div class="col-xs-4 d-flex justify-content-start">
                        <ul style="display: inline-block; list-style: none">
                            <li>
                                {{ comment.user.name }}
                            </li>
                            <li> {{ comment.date }}</li>
                        </ul>
                    </div>
                    <div class="col col-xs-5 " style="margin: 15px 0px  0 15px; text-align: end">
                        <dropdown>
                            <div slot="items">
                                <a class="dropdown-item" href="#"
                                   @click.prevent="edit_comment(key,comment)">{{ $t('edit') }}</a>
                                <a class="dropdown-item" href="#"
                                   @click.prevent="deleteComment(key,comment)"> {{ $t('delete') }} </a>
                            </div>
                        </dropdown>

                    </div>

                </div>
                <div class="lower-content" style="padding: 15px">
                    <div class="post-info" v-html="comment.body">
                    </div>
                </div>
                <hr>
            </div>
            <div class="row clearfix">
                <div class="form-group" style="width: 100%">
                    <div class="form-group" style="width: 100%">
                        <fieldset class="the-fieldset">
                            <legend class="the-legend">{{ $t("forewordConsultant.date") }} *</legend>
                            <input style="width: 100%" type="date" v-model="newComment.date" required="">
                        </fieldset>
                    </div>
                    <fieldset class="the-fieldset">
                        <legend class="the-legend"> {{ $t('add_comment') }}</legend>
                        <div class="input-group mb-3">
                            <textarea style="width: 100%" rows="3" class="" v-model="newComment.body"></textarea>

                        </div>
                    </fieldset>

                </div>
                <div class="input-group-append">
                    <button class="btn btn-info"
                            @click.prevent="(edit==false)?saveComment():updateComment()">
                        {{ (edit == false) ? $t('save') : $t('edit') }}
                    </button>
                </div>
                <div class="input-group-append">

                    <button v-if="edit==true" class="btn btn-secondary"
                            @click.prevent="CancelUpdate()">


                        {{ $t('cancel') }}
                    </button>

                </div>
            </div>
        </sweet-modal>

        <div class="row">
            <div class="col-xs-2 pull-right" style="margin: 20px 38px 0px 0px">
                <img style="width: 40px; border-radius: 49%;" :src="BaseImagePath+getImageType(post.post.category.id)">
            </div>
            <div class="col-xs-4 pull-right" style="margin: 15px 15px 0 0">
                <ul style="display: inline-block; list-style: none" class="">
                    <li> {{ oneLang(post.post.category.name, post.post.category.name_en) }}</li>
                    <li>
                        <i class="fa fa-clock-o"> </i>

                        {{ post.post.published }}
                    </li>
                </ul>
            </div>
            <div class="col col-xs-5 " style="margin: 15px 0px  0 15px; text-align: end">

                <dropdown>
                    <div slot="items">
                        <a class="dropdown-item" href="#"
                           @click.prevent="editPost()">{{ $t('edit') }}</a>

                    </div>
                </dropdown>

            </div>

        </div>
        <div class="lower-content" style="padding: 15px">
            <fieldset class="the-fieldset">
                <legend class="the-legend">{{ $t("forewordConsultant.consultant") }} *</legend>

                <h5 class="d-flex justify-content-start ">
                    {{ post.post.title }}
                </h5>
                <div class="d-flex justify-content-start ">
                    {{ post.post.body }}

                </div>
            </fieldset>
            <fieldset class="the-fieldset">
                <legend class="the-legend">{{ $t("forewordConsultant.solve") }}</legend>

                <h5 class="d-flex justify-content-start ">

                    <span class="text-info "> {{ $t('forewordConsultant.foreword_by') }}</span>:
                    {{ post.foreword_by_user.name }} <span class="text-info mx-2"> {{ post.published }}</span>

                </h5>
                <div class="d-flex justify-content-start">
                    <span class="text-info "> {{ $t("forewordConsultant.note") }}  </span>:

                    {{ post.note }}
                </div>
                <div class="d-flex justify-content-start  flex-column">
                    <h5 class="text-info "> {{ $t("forewordConsultant.solve") }} </h5>
                    {{ post.solve }}
                </div>
            </fieldset>
        </div>
        <span @click="readmore=!readmore" v-if="post_words.isMore && textMoreToShow"> ({{ $t('more') }})</span>
        <span @click="readmore=!readmore" v-if="post_words.isMore && !(textMoreToShow)"> ({{ $t('less') }})  </span>
        <hr>
        <div class="clearfix">
            <div class="pull-right" style="padding-right: 3em">
                <div @click="openCommentModal()" class="students"> {{ (comments_count) }} <i
                    class="fa fa-comments"></i></div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import LikeButton from './LikeButton.vue';

import axios from "axios";
import store from '../store'

export default {

    props: ['post', '_key'],
    components: {LikeButton},
    data() {
        return {
            readmore: false,
            edit: false,
            forewordConsultantUsers: [],
            bodyDisplay: '',
            is_active_dropdown: false,
            edit_post: false,
            post_words: {
                'words': 0,
                'newText': '',
                'isMore': false
            },

            newComment: {
                'key': 0,
                'date': '',
                'body': '',
                'id': 0,
                'foreword_id': this.post.id,
            }
        }
    },
    created() {
        this.post_words = this.countWords(this.post.solve, 20);
    },
    methods: {

        editPost() {
            this.is_active_dropdown = false;
            this.edit_post = true;
            // this.$emit('edit_post', this.post.id);
            this.$emit('edit_post', this._key)

        },

        deleteComment(key, comment) {
            this.isLoading = true;
            var id = comment.id;
            axios({url: '/api/v2/forewordConsultants/delete/' + id, data: {id: id}, method: 'POST'})
                .then(resp => {
                    if (resp.data.status == false) {
                        toastStack('   خطاء ', resp.data.msg, 'error');
                    } else {
                        this.post.comments.splice(key, 1);
                        toastStack(resp.data.msg, '', 'success');
                    }
                    this.isLoading = false;
                })
                .catch(err => {
                    this.isLoading = false;
                    console.log(err)
                })
        },
        saveComment() {
            if (localStorage.token) {
                this.isLoading = true;

                axios({url: '/api/v2/forewordConsultants/store', data: this.newComment, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            console.log(resp.data)
                            this.post.comments.push(resp.data.data);
                            toastStack(resp.data.msg, '', 'success');
                            this.newComment = {
                                'foreword_id': this.post.id,
                                'key': 0,
                                'body': '',
                                'date': '',
                                'id': 0,
                            }
                            // this.$refs.modal.close();
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            } else {
                toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
            }
            this.$emit('click', this.$vnode.key)
        },
        updateComment() {
            if (localStorage.token) {
                this.isLoading = true;
                axios({url: '/api/v2/forewordConsultants/store', data: this.newComment, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.post.comments[this.newComment.key].body = (this.newComment.body);
                            toastStack(resp.data.msg, '', 'success');
                            this.newComment = {
                                'foreword_id': this.post.id,
                                'key': 0,
                                'body': '',
                                'date': '',
                                'id': 0,
                            }
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            } else {
                toastStack('   خطاء ', 'يجب تسجيل الدخول اولا', 'error');
            }
            this.$emit('click', this.$vnode.key)
        },
        openCommentModal() {
            this.$refs.comments.open();
        },
        edit_comment(key, comment) {
            this.is_active_dropdown = false;
            this.edit = true;
            this.newComment.key = key;
            this.newComment.body = comment.body;
            this.newComment.id = comment.id;
            this.newComment.date = comment.date;

        },

        CancelUpdate() {
            this.is_active_dropdown = true;
            this.edit = false;
            this.newComment.key = 0;
            this.newComment.body = '';
            this.newComment.date = '';
            this.newComment.id = 0;

        },
    },
    computed: {
        textToDisplay: function () {
            return (this.readmore) ? this.post_words.newText : this.post.body;
        },
        authUser: function () {
            return store.getters.authUser
        },
        comments_count: function () {
            return this.post.comments.length
        },

        textMoreToShow: function () {
            return (this.readmore);
        }

    }
}
</script>
