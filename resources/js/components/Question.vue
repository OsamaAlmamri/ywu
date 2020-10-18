<template>

    <!--container-->
    <div id="ques_body">
        <!--questionBox-->
        <div class="questionBox" id="app">
            <!-- transition -->
            <transition :duration="{ enter: 500, leave: 300 }" enter-active-class="animated zoomIn"
                        leave-active-class="animated zoomOut" mode="out-in">
                <!--qusetionContainer-->
                <div class="questionContainer" v-if="questionIndex<questions.length" v-bind:key="questionIndex">

                    <header>
                        <h2 class="title is-6">اختبار الدورة </h2>
                        <!--progress-->
                        <div class="progressContainer">
                            <progress class="progress is-info is-small" :value="(questionIndex/questions.length)*100"
                                      max="100">{{(questionIndex/questions.length)*100}}%
                            </progress>
                            <p>{{(questionIndex/questions.length)*100}}% تم اكمال </p>
                        </div>
                        <!--/progress-->
                    </header>

                    <!-- questionTitle -->
                    <h3 class="titleContainer title">{{ questions[questionIndex].text }}</h3>

                    <clazy-load class="wrapper"  v-show="questions[questionIndex].image!=null" :src="'/assets/images/' + questions[questionIndex].image" >
                        <transition name="fade">
                            <div class="divClass"
                                 v-bind:style="{ backgroundImage: 'url(/assets/images/' +questions[questionIndex].image + ')' }">
                            </div>
                        </transition>
                        <transition name="fade" slot="placeholder">
                            <div class="vue_preloader">
                                <div class="circle">
                                    <div class="circle-inner"></div>
                                </div>
                            </div>
                        </transition>
                    </clazy-load>


                    <!-- quizOptions -->
                    <div class="optionContainer">

                        <div class="option"
                             @click="selectOption('option1')"
                             :class="{ 'is-selected': userResponses[questionIndex] == 'option1'}" >
                            a -  {{ questions[questionIndex].option1 }}
                        </div>

                        <div class="option"
                             @click="selectOption('option2')"
                             :class="{ 'is-selected': userResponses[questionIndex] == 'option2'}" >
                            a -  {{ questions[questionIndex].option2 }}
                        </div>

                        <div class="option"
                             @click="selectOption('option3')"
                             :class="{ 'is-selected': userResponses[questionIndex] == 'option3'}" >
                            a -  {{ questions[questionIndex].option3 }}
                        </div>

                        <div class="option"
                             @click="selectOption('option4')"
                             :class="{ 'is-selected': userResponses[questionIndex] == 'option4'}" >
                            a -  {{ questions[questionIndex].option4 }}
                        </div>

                    </div>

                    <!--quizFooter: navigation and progress-->
                    <footer class="questionFooter">

                        <!--pagination-->
                        <nav class="pagination" role="navigation" aria-label="pagination">

                            <!-- back button -->
                            <a class="button" v-on:click="prev()"  :disabled="questionIndex < 1">رجوع

                            </a>

                            <!-- next button -->
                            <a class="button" v-show="questionIndex<questions.length" :class="(userResponses[questionIndex]==null)?'':'is-active'"
                               v-on:click="next()" :disabled="questionIndex>=questions.length">
                                {{ (userResponses[questionIndex]==null)?'تخطي':'التالي' }}
                            </a>
                            <a class="button" v-on:click="endExam()" v-show="questionIndex>=questions.length-1">
                                انهاء الاختبار وعرض النتيجة
                            </a>


                        </nav>
                        <!--/pagination-->

                    </footer>
                    <!--/quizFooter-->

                </div>
                <!--/questionContainer-->

                <!--quizCompletedResult-->
                <div v-if="questionIndex >= questions.length" v-bind:key="questionIndex"
                     class="quizCompleted has-text-centered">

                    <!-- quizCompletedIcon: Achievement Icon -->
                    <span class="icon">
                <i class="fa" :class="score()>3?'fa-check-circle-o is-active':'fa-times-circle'"></i>
              </span>

                    <!--resultTitleBlock-->
                    <h2 class="title">
                        You did {{ (score()>7?'an amazing':(score()<4?'a poor':'a good')) }} job!
                    </h2>
                    <p class="subtitle">
                        Total score: {{ score() }} / {{ questions.length }}
                    </p>
                    <br>
                    <a class="button" @click="restart()">restart <i class="fa fa-refresh"></i></a>
                    <!--/resultTitleBlock-->

                </div>
                <!--/quizCompetedResult-->

            </transition>

        </div>
        <!--/questionBox-->
    </div>

    <!--/container-->
</template>

<script>
    export default {

        data() {
            return {
                user: "Dave",
                questions: [],
                questionIndex: 0,
                course_id: '',
                userResponses:0,
                isActive: false
            }
        },
        created() {
            this.course_id=this.$route.params.id
            this.fetchTraining();
        },
        filters: {
            charIndex: function (i) {
                return String.fromCharCode(97 + i);
            }
        },

        methods: {
            fetchTraining() {
                let vm = this;
                fetch('/api/getTrainingQuestions2', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        // 'Authorization': 'Bearer my-token',
                        // 'My-Custom-Header': 'foobar'
                    },
                    body: JSON.stringify({ id:this.course_id, title: 'Vue POST Request Example' })
                })
                    .then(res => res.json())
                    .then(res => {
                        this.questions = res.Trainings;
                        this.userResponses= Array(res.Trainings.length).fill(null)

                    })
                    .catch(err => console.log(err));
            },
            restart: function () {
                this.questionIndex = 0;
                this.userResponses = Array(this.questions.length).fill(null);
            },
            selectOption: function (index) {
                Vue.set(this.userResponses, this.questionIndex, index);
                //console.log(this.userResponses);
            },
            next: function () {
                if (this.questionIndex < this.questions.length)
                    this.questionIndex++;
            },

            prev: function () {
                if (this.questions.length > 0) this.questionIndex--;
            },
            // Return "true" count in userResponses
            score: function () {
                var score = 0;
                for (let i = 0; i < this.userResponses.length; i++) {
                    if ( this.questions[i].answer==this.userResponses[i]) {
                        score = score + 1;
                    }
                }
                // this.$emit('set_result', score)

                return score;

                //return this.userResponses.filter(function(val) { return val }).length;
            }   ,
            endExam: function () {
                var all=this.questions.length
                this.questionIndex=all;
                var score = 0;
                for (let i = 0; i < this.userResponses.length; i++) {
                    if ( this.questions[i].answer==this.userResponses[i]) {
                        score = score + 1;
                    }
                }
                this.$emit('set_result', (score/(all>0?all:1))*100)

                return score;

                // this.$emit('set_result', score)


                //return this.userResponses.filter(function(val) { return val }).length;
            }
        }
    }
</script>

<style>

    @import url("https://fonts.googleapis.com/css?family=Montserrat:400,400i,700");
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700");

    #ques_body {
        font-family: "Open Sans", sans-serif;
        font-size: 14px;
        height: 100vh;
        background: #CFD8DC;
        /* mocking native UI */
        cursor: default !important;
        /* remove text selection cursor */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        /* remove text selection */
        user-drag: none;
        /* disbale element dragging */
        display: -webkit-box;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
    }

    .button {
        -webkit-transition: 0.3s;
        transition: 0.3s;
    }

    .title,
    .subtitle {
        font-family: Montserrat, sans-serif;
        font-weight: normal;
    }

    .animated {
        -webkit-transition-duration: 0.15s;
        transition-duration: 0.15s;
    }


    .questionBox {
        max-width: 30rem;
        width: 30rem;
        min-height: 30rem;
        background: #FAFAFA;
        position: relative;
        display: -webkit-box;
        display: flex;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    }

    .questionBox header {
        background: rgba(0, 0, 0, 0.025);
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .questionBox header h1 {
        font-weight: bold;
        margin-bottom: 1rem !important;
    }

    .questionBox header .progressContainer {
        width: 60%;
        margin: 0 auto;
    }

    .questionBox header .progressContainer > progress {
        margin: 0;
        border-radius: 5rem;
        overflow: hidden;
        border: none;
        color: #00ab15;
    }

    .questionBox header .progressContainer > progress::-moz-progress-bar {
        background: #00ab15;
    }

    .questionBox header .progressContainer > progress::-webkit-progress-value {
        background: #00ab15;
    }

    .questionBox header .progressContainer > p {
        margin: 0;
        margin-top: 0.5rem;
    }

    .questionBox .titleContainer {
        text-align: center;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .questionBox .quizForm {
        display: block;
        white-space: normal;
        height: 100%;
        width: 100%;
    }

    .questionBox .quizForm .quizFormContainer {
        height: 100%;
        margin: 15px 18px;
    }

    .questionBox .quizForm .quizFormContainer .field-label {
        text-align: left;
        margin-bottom: 0.5rem;
    }

    .questionBox .quizCompleted {
        width: 100%;
        padding: 1rem;
        text-align: center;
    }

    .questionBox .quizCompleted > .icon {
        color: #FF5252;
        font-size: 5rem;
    }

    .questionBox .quizCompleted > .icon .is-active {
        color: #00E676;
    }

    .questionBox .questionContainer {
        white-space: normal;
        height: 100%;
        width: 100%;
    }

    .questionBox .questionContainer .optionContainer {
        margin-top: 12px;
        -webkit-box-flex: 1;
        flex-grow: 1;
    }

    .questionBox .questionContainer .optionContainer .option {
        border-radius: 290486px;
        padding: 9px 18px;
        margin: 0 18px;
        margin-bottom: 12px;
        -webkit-transition: 0.3s;
        transition: 0.3s;
        cursor: pointer;
        background-color: rgba(0, 0, 0, 0.05);
        color: rgba(0, 0, 0, 0.85);
        border: transparent 1px solid;
    }

    .questionBox .questionContainer .optionContainer .option.is-selected {
        border-color: rgba(0, 0, 0, 0.25);
        background-color: #8df091;
    }

    .questionBox .questionContainer .optionContainer .option:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }

    .questionBox .questionContainer .optionContainer .option:active {
        -webkit-transform: scaleX(0.9);
        transform: scaleX(0.9);
    }

    .questionBox .questionContainer .questionFooter {
        background: rgba(0, 0, 0, 0.025);
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        width: 100%;
        align-self: flex-end;
    }

    .questionBox .questionContainer .questionFooter .pagination {
        margin: 15px 25px;
    }

    .pagination {
        display: -webkit-box;
        display: flex;
        -webkit-box-pack: justify;
        justify-content: space-between;
    }

    .button {
        padding: 0.5rem 1rem;
        border: 1px solid rgba(0, 0, 0, 0.25);
        border-radius: 5rem;
        margin: 0 0.25rem;
        -webkit-transition: 0.3s;
        transition: 0.3s;
    }

    .button:hover {
        cursor: pointer;
        background: #ECEFF1;
        border-color: rgba(0, 0, 0, 0.25);
    }

    .button.is-active {
        background: #00ab15;
        color: white !important;;
        border-color: transparent;
    }

    .button.is-active:hover {
        background: #00ab15;
    }

    @media screen and (min-width: 769px) {
        .questionBox {
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
        }

        .questionBox .questionContainer {
            display: -webkit-box;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            flex-direction: column;
        }
    }

    @media screen and (max-width: 768px) {
        .sidebar {
            height: auto !important;
            border-radius: 6px 6px 0px 0px;
        }
    }
</style>
