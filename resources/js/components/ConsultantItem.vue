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
                                {{comment.user.name}}
                            </li>
                            <li> {{comment.published}}</li>

                        </ul>
                    </div>
                    <div class="col col-xs-5 " style="margin: 15px 0px  0 15px; text-align: end">

                        <dropdown v-if="authUser.id==comment.user_id">
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
                        <legend class="the-legend"> {{$t('add_comment')}}</legend>
                        <div class="input-group mb-3">
                            <textarea style="width: 100%" rows="3" class="" v-model="newComment.body"></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-info"
                                        @click.prevent="(edit==false)?saveComment():updateComment()">
                                    {{(edit==false)?$t('save') :$t('edit')   }}
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

        <div class="row">
            <div class="col-xs-2 pull-right" style="margin: 20px 38px 0px 0px">
                <img style="width: 40px; border-radius: 49%;" :src="BaseImagePath+getImageType(post.category.id)">
            </div>
            <div class="col-xs-4 pull-right" style="margin: 15px 15px 0 0">
                <ul style="display: inline-block; list-style: none" class="">
                    <li> {{ oneLang(post.category.name,post.category.name_en) }}</li>
                    <li>
                        <i class="fa fa-clock-o"> </i>

                        {{post.published}}
                    </li>
                </ul>
            </div>
            <div class="col col-xs-5 " style="margin: 15px 0px  0 15px; text-align: end">

                <dropdown v-if="authUser.id==post.user_id">
                    <div slot="items">
                        <a class="dropdown-item" href="#"
                           @click.prevent="editPost()">{{ $t('edit') }}</a>
                        <a class="dropdown-item" href="#"
                           @click.prevent="deletePost()"> {{ $t('delete') }} </a>
                    </div>
                </dropdown>

            </div>

        </div>
        <div class="lower-content" style="padding: 15px">
            <h5>
                <router-link @click.native="$scrollToTop" :to="{ name: 'post_details', params: { id: post.id}}">
                    {{post.title}}
                </router-link>
            </h5>

            <div class="post-info" id="targetMore" v-html="textToDisplay">
            </div>
            <span @click="readmore=!readmore" v-if="post_words.isMore && textMoreToShow"> ({{$t('more')}})</span>
            <span @click="readmore=!readmore" v-if="post_words.isMore && !(textMoreToShow)"> ({{$t('less')}})  </span>
            <hr>
            <div class="clearfix">
                <div class="pull-right" style="padding-right: 3em">
                    <div @click="openCommentModal()" class="students"> {{(comments_count)}} <i
                        class="fa fa-comments"></i></div>
                </div>
                <div class="pull-left" style="padding-left: 3em">
                    <like-button type="posts"
                                 :key="post.id"
                                 :count-likes="post.likes_count"
                                 has-count="1"
                                 :liked_id="post.id"
                                 :is_liked="post.user_like"
                    ></like-button>
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
