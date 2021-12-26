<template>
    <div class="inner-box">
        <sweet-modal :title="$t('product.new_reply')"
                     :blocking=true :enable-mobile-fullscreen=true
                     :pulse-on-block=true
                     :overlay-theme="'dark'" ref="new_reply">
            <div v-for="(reply,key ) in  product_question.replies" :key="key">
                <div class="row">
                    <div class="col-xs-2 pull-right" style="margin: 20px 38px 0px 0px">
                        <i class="fa fa-comment"> </i>
                    </div>
                    <div class="col-xs-4 pull-right" style="margin: 15px 15px 0 0">
                        <ul style="display: inline-block; list-style: none" class="">
                            <li><i class="fa fa-user"> </i>
                                {{reply.user_name}}
                            </li>
                            <li> {{reply.created_at}}</li>

                        </ul>
                    </div>
                    <div class="col col-xs-5 " style="margin: 15px 0px  0 15px; text-align: end">
                        <dropdown v-if="authUser.id==reply.replay_user_id">
                            <div slot="items">
                                <a class="dropdown-item" href="#"
                                   @click.prevent="edit_reply_question(key,reply)">{{ $t('edit') }}</a>
                                <a class="dropdown-item" href="#"
                                   @click.prevent="deleteReply(key,reply)"> {{ $t('delete')}} </a>
                            </div>
                        </dropdown>

                    </div>

                </div>
                <div class="lower-content" style="padding: 15px">
                    <div class="post-info" v-html="">
                        {{reply.text}}
                    </div>
                </div>
                <hr>
            </div>
            <div class="row clearfix">
                <div class="form-group" style="width: 100%">
                    <fieldset class="the-fieldset">
                        <legend class="the-legend"> {{ $t('product.new_reply') }}</legend>
                        <div class="input-group mb-3">
                            <textarea style="width: 100%" rows="3" class=""
                                      v-model="new_reply_question.text"></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-info"
                                        @click.prevent="(edit==false)?addReplay():updateComment()">
                                    {{(edit==false)?$t('save') :$t('update') }}
                                </button>
                            </div>
                            <div class="input-group-append">
                                <button v-if="edit==true" class="btn btn-secondary"
                                        @click.prevent="CancelUpdate()">{{ $t('cancel')}}
                                </button>

                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </sweet-modal>

        <div class="row">
            <div class="col-xs-2 pull-right" style="margin: 20px 38px 0px 0px">
                <img style="width: 40px; border-radius: 49%;" :src="BaseImagePath+getImageType(1)">
            </div>
            <div class="col-xs-4 pull-right" style="margin: 15px 15px 0 0">
                <ul style="display: inline-block; list-style: none" class="">
                    <li> {{product_question.user_name}}</li>
                    <li>
                        <i class="fa fa-clock-o"> </i>
                        {{product_question.published}}
                    </li>
                </ul>
            </div>
            <div class="col col-xs-5 " style="margin: 15px 0px  0 15px; text-align: end">
                <dropdown v-if="authUser.id==product_question.customers_id">
                    <div slot="items">
                        <a class="dropdown-item" href="#"
                           @click.prevent="editPost()">{{ $t('edit') }}</a>
                        <a class="dropdown-item" href="#"
                           @click.prevent="deletePost()"> {{ $t('delete')}} </a>
                    </div>
                </dropdown>
            </div>

        </div>
        <div class="lower-content" style="padding: 15px">
            <div class="post-info">
                {{product_question.text}}
            </div>
            <div class="clearfix">
                <div class="pull-right" style="padding-right: 3em">
                    <div @click="openCommentModal()" class="students"> {{(product_replyes_count())}} <i
                        class="fa fa-reply"></i></div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import store from '../store'

    export default {
        props: ['product_question', '_key'],
        data() {
            return {
                readmore: false,
                edit: false,
                bodyDisplay: '',
                is_active_dropdown: false,
                edit_product: false,
                product_words: {
                    'words': 0,
                    'newText': '',
                    'isMore': false
                },
                new_reply_question: {
                    'key': 0,
                    'text': '',
                    'replay_id': 0,
                    'id': 0,
                    'product_question_id': this.product_question.id,
                }
            }
        },
        methods: {
            deletePost() {
                this.$emit('delete_question', this._key)
            },
            product_replyes_count: function () {
                // return 0;
                if (this.product_question.replies)
                    return this.product_question.replies.length;
                else
                    return 0;
            },
            editPost() {
                this.is_active_dropdown = false;
                this.edit_product = true;
                // this.$emit('edit_product', this.product.id);
                this.$emit('edit_question', this._key)

                // this.newRating.rating = this.training.is_rating.rating;
                // this.newRating.message = this.training.is_rating.message;

            },
            deleteReply(key, replay) {
                this.isLoading = true;
                var id = replay.id;
                axios({url: '/api/shop/deleteReplay', data: {replay_id: id}, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                        } else {
                            this.product_question.replies.splice(key, 1);
                            toastStack(resp.data.msg, '', 'success');
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.isLoading = false;
                        console.log(err)
                    })
            },
            addReplay() {
                if (localStorage.token) {
                    this.isLoading = true;
                    axios({url: '/api/shop/addReplay', data: this.new_reply_question, method: 'POST'})
                        .then(resp => {
                            this.isLoading = false;
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                this.product_question.replies.push(resp.data.data);
                                toastStack(resp.data.msg, '', 'success');
                                this.new_reply_question = {
                                    'key': 0,
                                    'text': '',
                                    'id': 0,
                                    'replay_id': 0,
                                    'product_question_id': this.product_question.id,
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
                    axios({
                        url: '/api/shop/updateReplay',
                        data: this.new_reply_question,
                        method: 'POST'
                    })
                        .then(resp => {
                            this.isLoading = false;
                            if (resp.data.status == false) {
                                toastStack('   خطاء ', resp.data.msg, 'error');
                            } else {
                                this.product_question.replies[this.new_reply_question.key].text = (this.new_reply_question.text);
                                toastStack(resp.data.msg, '', 'success');

                                this.new_reply_question = {
                                    'product_id': this.product.id,
                                    'key': 0,
                                    'text': '',
                                    'replay_id': 0,
                                    'id': 0,
                                }
                                this.edit=false;
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
                this.$refs.new_reply.open();
            },
            edit_reply_question(key, replay) {
                this.is_active_dropdown = false;
                this.edit = true;
                this.new_reply_question.key = key;
                this.new_reply_question.text = replay.text;
                this.new_reply_question.id = replay.id;
                this.new_reply_question.replay_id = replay.id;

            },
            CancelUpdate() {
                this.is_active_dropdown = true;
                this.edit = false;
                this.new_reply_question.key = 0;
                this.new_reply_question.text = '';
                this.new_reply_question.id = 0;
                this.new_reply_question.replay_id = 0;

            },
        },
        computed: {
            authUser: function () {
                return store.getters.authUser
            },


            textMoreToShow: function () {
                return (this.readmore);
            }

        }
    }
</script>
