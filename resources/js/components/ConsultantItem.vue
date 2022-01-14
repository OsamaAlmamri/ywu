<template>
    <div class="inner-box">
        <sweet-modal :title="post.title"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="comments">
            <div v-for="(comment,key ) in  post.comments">
                <div class="row">
                    <div class="col-xs-2 pull-right" style="margin: 20px 38px 0px 0px">
                        <i class="fa fa-comment"> </i>
                    </div>
                    <div class="col-xs-4 pull-right" style="margin: 15px 15px 0 0">
                        <ul style="display: inline-block; list-style: none"
                            :class="{condultant_comment:comment.is_consonant==1}">
                            <li>
                                <span v-if="comment.is_consonant==1">  {{ $t('consultants.consonant') }} : </span>
                                {{ comment.user.name }}
                            </li>

                            <li> {{ comment.published }}</li>

                        </ul>
                    </div>
                    <div class="col col-xs-5 " style="margin: 15px 0px  0 15px; text-align: end">
                        <dropdown v-if="(authUser.id==comment.user_id )">
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
                    <fieldset class="the-fieldset">
                        <legend class="the-legend"> {{ $t('add_comment') }}</legend>
                        <div class="input-group mb-3">
                            <textarea style="width: 100%" rows="3" class="" v-model="newComment.body"></textarea>
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
                    </fieldset>
                </div>
            </div>
        </sweet-modal>

        <sweet-modal :title="post.title"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="foreword">
            <div class="card-body" v-if="post.forewordConsultant!=null">
                <h6 class="card-title">
                    <span class="text-info ">{{ $t('foreword_to_user') }}:</span>
                    : {{ post.forewordConsultant.foreword_to_user.name }}
                </h6>
                <h6 class="card-title">
                    <span class="text-info ">{{ $t('foreword_by') }}:</span>
                    {{ post.forewordConsultant.foreword_by_user.name }}
                </h6>
                <br>
                <h6 class="card-title">
                    <span class="text-info ">{{ $t('solve') }}:</span>
                </h6>
                <br>
                <p class="card-text"> {{ post.forewordConsultant.solve }}</p>

            </div>
            <fieldset class="the-fieldset">
                <legend class="the-legend text-info"> {{ $t('foreword') }}</legend>
                <div class="d-flex flex-column">
                    <div class="form-group">
                        <label for="foreword_to" class="text-info ">{{ $t('foreword_to') }}:</label>
                        <select name="cars" id="foreword_to" v-model="forword_data.foreword_to" class="custom-select">
                            <option value="0" selected>Select User</option>
                            <option v-for="(user,key) in forewordConsultantUsers" :key="key"

                                    :value="user.id">{{ user.name }}
                            </option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="text-info" for="note">{{ $t('Note') }}:</label>
                        <textarea id="note"
                                  v-model="forword_data.note"
                                  style="width: 100%" rows="3" class=""></textarea>
                    </div>
                    <button type="button"
                            @click.prevent="saveForword()"
                            class="btn btn-primary">
                        {{ $t('save') }}
                    </button>
                </div>
            </fieldset>
        </sweet-modal>


        <div class="lower-content" style="padding: 15px">
            <h5 class="text-primary mb-2 ">
                {{ post.title }}

            </h5>

            <div class="post-info mb-2 " id="targetMore">
                {{ post.body }}
            </div>

            <div class="clearfix">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fa fa-clock-o"> </i>

                        {{ post.published }}
                    </div>
                    <div class="consultant_category"> {{ oneLang(post.category.name, post.category.name_en) }}</div>

                    <div @click="openCommentModal()"> {{ (comments_count) }} <i
                        class="fa fa-comments"></i></div>


                    <div style="margin-top: -8px">
                        <like-button type="posts"
                                     :key="post.id"
                                     :count-likes="post.likes_count"
                                     has-count="1"
                                     :liked_id="post.id"
                                     :is_liked="post.user_like"
                        ></like-button>
                    </div>



                    <div v-if="authUser.id==post.user_id" class="d-flex justify-content-between">
                        <div class="consultant_category"
                             @click.prevent="editPost()">
                            <span class="fa fa-pencil-square-o"> </span>
                        </div>

                        <div class="consultant_category"
                             @click.prevent="deletePost()">
                            <span class="fa fa-trash-o"> </span>
                        </div>

                    </div>
                    <div class="consultant_category px-2"
                         v-if="authUser.permissions.replay_social_consultant==1"
                         @click.prevent="forewordPost()"> {{ $t('foreword') }}
                        <span
                            :class="['fa',oneLang('ar','en')=='ar'? 'fa-arrow-circle-left':'fa-arrow-circle-right']"> </span>
                    </div>
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

    props: ['post', '_key', 'lang'],
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
            forword_data: {
                'note': '',
                'post_id': this.post.id,
                'foreword_to': 0
            },
            newComment: {
                'key': 0,
                'body': '',
                'id': 0,
                'post_id': this.post.id,
            }
        }
    },
    created() {
        this.post_words = this.countWords(this.post.body, 20);
    },
    methods: {
        deletePost() {
            this.$emit('delete_post', this._key)

        },
        change_like_count(c) {
            this.post.likes_count += c;
        },
        editPost() {
            this.is_active_dropdown = false;
            this.edit_post = true;
            // this.$emit('edit_post', this.post.id);
            this.$emit('edit_post', this._key)


            // this.newRating.rating = this.training.is_rating.rating;
            // this.newRating.message = this.training.is_rating.message;

        },
        forewordPost() {

            if (this.forewordConsultantUsers.length == 0)
                axios.get('/api/v2/forewordConsultantUsers').then(res => {
                    this.forewordConsultantUsers = res.data.data;

                }).catch(err => {
                    console.log(err)
                });
            this.$refs.foreword.open();

            if (this.post.forewordConsultant != null) {
                this.forword_data.note = this.post.forewordConsultant.note;
                this.forword_data.foreword_to = this.post.forewordConsultant.foreword_to;
            }


        },

        deleteComment(key, comment) {
            this.isLoading = true;
            var id = comment.id;
            axios({url: '/api/DeComment/' + id, data: {id: id}, method: 'POST'})
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
        saveForword() {
            if (this.authUser.id > 0 && this.forword_data.foreword_to > 0) {
                this.isLoading = true;
                axios({url: '/api/v2/forewordToUsers', data: this.forword_data, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            toastStack(resp.data.msg, '', 'success');
                            this.forword_data.note = '';

                            // this.$refs.modal.close();
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            } else {
                toastStack('   خطاء ', 'يجب تحديد المحال اليه  ', 'error');
            }
            this.$emit('click', this.$vnode.key)
        },
        saveComment() {
            if (localStorage.token) {
                this.isLoading = true;
                axios({url: '/api/StComment', data: this.newComment, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.post.comments.push(resp.data.comment);
                            toastStack(resp.data.msg, '', 'success');
                            this.newComment = {
                                'post_id': this.post.id,
                                'key': 0,
                                'body': '',
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
                axios({url: '/api/UpComment/' + this.newComment.id, data: this.newComment, method: 'POST'})
                    .then(resp => {
                        this.isLoading = false;
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.post.comments[this.newComment.key].body = (this.newComment.body);
                            toastStack(resp.data.msg, '', 'success');
                            this.newComment = {
                                'post_id': this.post.id,
                                'key': 0,
                                'body': '',
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

        },

        CancelUpdate() {
            this.is_active_dropdown = true;
            this.edit = false;
            this.newComment.key = 0;
            this.newComment.body = '';
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
