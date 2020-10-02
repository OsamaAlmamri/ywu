@extends('site.layout')
@section('content')
    <!-- Page Title -->
    <section class="page-title">
        <div class="auto-container">
            <h1>Course Introduction</h1>

            <!-- Search Boxed -->
            <div class="search-boxed">
                <div class="search-box">
                    <form method="post" action="contact.html">
                        <div class="form-group">
                            <input type="search" name="search-field" value="" placeholder="What do you want to learn?" required="">
                            <button type="submit"><span class="icon fa fa-search"></span></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!--End Page Title-->

    <!-- Intro Courses -->
    <section class="intro-section">
        <div class="patern-layer-one paroller" data-paroller-factor="0.40" data-paroller-factor-lg="0.20" data-paroller-type="foreground" data-paroller-direction="vertical" style="background-image: url('{{asset("site/images/icons/icon-1.png")}}')"></div>
        <div class="patern-layer-two paroller" data-paroller-factor="0.40" data-paroller-factor-lg="-0.20" data-paroller-type="foreground" data-paroller-direction="vertical" style="background-image: url('{{asset("site/images/icons/icon-2.png")}}')"></div>
        <div class="circle-one"></div>
        <div class="auto-container">
            <div class="sec-title">
                <h2>Learn  User Interface and <br> User Experience</h2>
            </div>

            <div class="inner-container">
                <div class="row clearfix">

                    <!-- Content Column -->
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        <div class="inner-column">

                            <!-- Intro Info Tabs-->
                            <div class="intro-info-tabs">
                                <!-- Intro Tabs-->
                                <div class="intro-tabs tabs-box">

                                    <!--Tab Btns-->
                                    <ul class="tab-btns tab-buttons clearfix">
                                        <li data-tab="#prod-overview" class="tab-btn active-btn">نظرة عامة </li>
                                        <li data-tab="#prod-curriculum" class="tab-btn">العناوين</li>
                                        <li data-tab="#prod-reviews" class="tab-btn">المحتوى التدريبي</li>
                                        <li data-tab="#mcq_tap" class="tab-btn">الاختبار</li>
                                    </ul>

                                    <!--Tabs Container-->
                                    <div class="tabs-content">

                                        <!--Tab / Active Tab-->
                                        <div class="tab active-tab" id="prod-overview">
                                            <div class="content">

                                                <!-- Cource Overview -->
                                                <div class="course-overview">
                                                    <div class="inner-box">
                                                        <h4>25 That Prevent Job Seekers From Overcoming Failure</h4>
                                                        <p>Phasellus enim magna, varius et commodo ut, ultricies vitae velit. Ut nulla tellus, eleifend euismod pellentesque vel, sagittis vel justo. In libero urna, venenatis sit amet ornare non, suscipit nec risus. Sed consequat justo non mauris pretium at tempor justo sodales. Quisque tincidunt laoreet malesuada. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur.</p>
                                                        <ul class="student-list">
                                                            <li>23,564 Total Students</li>
                                                            <li><span class="theme_color">4.5</span> <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span> (1254 Rating)</li>
                                                            <li>256 Reviews</li>
                                                        </ul>
                                                        <h3>What you’ll learn?</h3>
                                                        <ul class="review-list">
                                                            <li>Phasellus enim magna, varius et commodo ut.</li>
                                                            <li>Sed consequat justo non mauris pretium at tempor justo.</li>
                                                            <li>Ut nulla tellus, eleifend euismod pellentesque vel, sagittis vel justo</li>
                                                            <li>Phasellus enim magna, varius et commodo ut.</li>
                                                            <li>Phasellus enim magna, varius et commodo ut.</li>
                                                            <li>Sed consequat justo non mauris pretium at tempor justo.</li>
                                                            <li>Ut nulla tellus, eleifend euismod pellentesque vel, sagittis vel justo</li>
                                                            <li>Phasellus enim magna, varius et commodo ut.</li>
                                                        </ul>
                                                        <h3>Requirements</h3>
                                                        <ul class="requirement-list">
                                                            <li>Phasellus enim magna, varius et commodo ut, ultricies vitae velit. Ut nulla tellus, eleifend euismod pellentesque vel, sagittis vel justo</li>
                                                            <li>Ultricies vitae velit. Ut nulla tellus, eleifend euismod pellentesque vel.</li>
                                                            <li>Phasellus enim magna, varius et commodo ut.</li>
                                                            <li>Varius et commodo ut, ultricies vitae velit. Ut nulla tellus.</li>
                                                            <li>Phasellus enim magna, varius et commodo ut.</li>
                                                        </ul>
                                                        <h3>Instructors</h3>

                                                        <div class="row clearfix">

                                                            <!-- Student Block -->
                                                            <div class="student-block col-lg-6 col-md-6 col-sm-12">
                                                                <div class="block-inner">
                                                                    <div class="image">
                                                                        <img src="{{asset('site/images/resource/student-1.jpg')}}" alt="">
                                                                    </div>
                                                                    <h2>Stephane Smith</h2>
                                                                    <div class="text">Certified instructor Architecture& Developer</div>
                                                                    <div class="social-box">
                                                                        <a href="#" class="fa fa-facebook-square"></a>
                                                                        <a href="#" class="fa fa-twitter-square"></a>
                                                                        <a href="#" class="fa fa-linkedin-square"></a>
                                                                        <a href="#" class="fa fa-github"></a>
                                                                    </div>
                                                                    <a href="#" class="more">Know More <span class="fa fa-angle-left"></span></a>
                                                                </div>
                                                            </div>

                                                            <!-- Student Block -->
                                                            <div class="student-block col-lg-6 col-md-6 col-sm-12">
                                                                <div class="block-inner">
                                                                    <div class="image">
                                                                        <img src="{{asset('site/images/resource/student-2.jpg')}}" alt="">
                                                                    </div>
                                                                    <h2>Marvin Zona</h2>
                                                                    <div class="text">Certified instructor Architecture& Developer</div>
                                                                    <div class="social-box">
                                                                        <a href="#" class="fa fa-facebook-square"></a>
                                                                        <a href="#" class="fa fa-twitter-square"></a>
                                                                        <a href="#" class="fa fa-linkedin-square"></a>
                                                                        <a href="#" class="fa fa-github"></a>
                                                                    </div>
                                                                    <a href="#" class="more">Know More <span class="fa fa-angle-left"></span></a>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Tab -->
                                        <div class="tab" id="prod-curriculum">
                                            <div class="content">

                                                <!-- Accordion Box -->
                                                <ul class="accordion-box">

                                                    <!-- Block -->
                                                    <li class="accordion block">
                                                        <div class="acc-btn active"><div class="icon-outer"><span class="icon icon-plus flaticon-angle-arrow-down"></span></div> UI/ UX Introduction</div>
                                                        <div class="acc-content current">
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"><i class="ripple"></i></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <!-- Block -->
                                                    <li class="accordion block">
                                                        <div class="acc-btn"><div class="icon-outer"><span class="icon icon-plus flaticon-angle-arrow-down"></span></div> Color Theory</div>
                                                        <div class="acc-content">
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"><i class="ripple"></i></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <!-- Block -->
                                                    <li class="accordion block">
                                                        <div class="acc-btn"><div class="icon-outer"><span class="icon icon-plus flaticon-angle-arrow-down"></span></div> Basic Typography</div>
                                                        <div class="acc-content">
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"><i class="ripple"></i></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <!-- Block -->
                                                    <li class="accordion block">
                                                        <div class="acc-btn"><div class="icon-outer"><span class="icon icon-plus flaticon-angle-arrow-down"></span></div> Wireframing & Prototyping</div>
                                                        <div class="acc-content">
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"><i class="ripple"></i></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="clearfix">
                                                                    <div class="pull-left">
                                                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image play-icon"><span class="fa fa-play"></span>What is UI/ UX Design?</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <div class="minutes">35 Minutes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>

                                            </div>
                                        </div>

                                        <!-- Tab -->
                                        <div class="tab" id="mcq_tap">
                                            <div class="content">

                                                <div id="quiz">
                                                    <h1 id="quiz-name"></h1>
                                                    <button id="submit-button">انهاء وحفظ الاختبار</button>
                                                    <button id="next-question-button">التالي </button>
                                                    <button id="prev-question-button">السابق</button>

                                                    <div id="quiz-results">

                                                        <p id="quiz-results-message"></p>
                                                        <p id="quiz-results-score"></p>
                                                        <button id="quiz-retry-button">اعادة الاختبار</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Tab -->
                                        <div class="tab" id="prod-reviews">
                                            <div class="content">

                                                <div class="cource-review-box">
                                                    <h4>Stephane Smith</h4>
                                                    <div class="rating">
                                                        <span class="total-rating">4.5</span> <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>&ensp; 256 Reviews
                                                    </div>
                                                    <div class="text">Phasellus enim magna, varius et commodo ut, ultricies vitae velit. Ut nulla tellus, eleifend euismod pellentesque vel, sagittis vel justo. In libero urna, venenatis sit amet ornare non, suscipit nec risus.</div>
                                                    <div class="helpful">Was this review helpful?</div>
                                                    <ul class="like-option">
                                                        <li><span class="icon fa fa-thumbs-o-up"></span></li>
                                                        <li><span class="icon fa fa-thumbs-o-down"></span></li>
                                                        <span class="report">Report</span>
                                                    </ul>
                                                </div>

                                                <div class="cource-review-box">
                                                    <h4>Anna Sthesia</h4>
                                                    <div class="rating">
                                                        <span class="total-rating">4.5</span> <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>&ensp; 256 Reviews
                                                    </div>
                                                    <div class="text">Phasellus enim magna, varius et commodo ut, ultricies vitae velit. Ut nulla tellus, eleifend euismod pellentesque vel, sagittis vel justo. In libero urna, venenatis sit amet ornare non, suscipit nec risus.</div>
                                                    <div class="helpful">Was this review helpful?</div>
                                                    <ul class="like-option">
                                                        <li><span class="icon fa fa-thumbs-o-up"></span></li>
                                                        <li><span class="icon fa fa-thumbs-o-down"></span></li>
                                                        <span class="report">Report</span>
                                                    </ul>
                                                </div>

                                                <div class="cource-review-box">
                                                    <h4>Petey Cruiser</h4>
                                                    <div class="rating">
                                                        <span class="total-rating">4.5</span> <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>&ensp; 256 Reviews
                                                    </div>
                                                    <div class="text">Phasellus enim magna, varius et commodo ut, ultricies vitae velit. Ut nulla tellus, eleifend euismod pellentesque vel, sagittis vel justo. In libero urna, venenatis sit amet ornare non, suscipit nec risus.</div>
                                                    <div class="helpful">Was this review helpful?</div>
                                                    <ul class="like-option">
                                                        <li><span class="icon fa fa-thumbs-o-up"></span></li>
                                                        <li><span class="icon fa fa-thumbs-o-down"></span></li>
                                                        <span class="report">Report</span>
                                                    </ul>
                                                </div>

                                                <div class="cource-review-box">
                                                    <h4>Rick O'Shea</h4>
                                                    <div class="rating">
                                                        <span class="total-rating">4.5</span> <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>&ensp; 256 Reviews
                                                    </div>
                                                    <div class="text">Phasellus enim magna, varius et commodo ut, ultricies vitae velit. Ut nulla tellus, eleifend euismod pellentesque vel, sagittis vel justo. In libero urna, venenatis sit amet ornare non, suscipit nec risus.</div>
                                                    <div class="helpful">Was this review helpful?</div>
                                                    <ul class="like-option">
                                                        <li><span class="icon fa fa-thumbs-o-up"></span></li>
                                                        <li><span class="icon fa fa-thumbs-o-down"></span></li>
                                                        <span class="report">Report</span>
                                                    </ul>

                                                    <a href="#" class="more">View More</a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Video Column -->
                    <div class="video-column col-lg-4 col-md-12 col-sm-12">
                        <div class="inner-column sticky-top">

                            <!-- Video Box -->
                            <div class="intro-video" style="background-image:url('{{asset("site/images/resource/video-image-1.jpg")}}')">
                                <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image intro-video-box"><span class="fa fa-play"><i class="ripple"></i></span></a>
                                <h4>Preview this course</h4>
                            </div>
                            <!-- End Video Box -->
                            <div class="price">$11.99</div>
                            <div class="time-left">23 hours left at this price!</div>

                            <a href="#" class="theme-btn btn-style-three"><span class="txt">Add To Cart <i class="fa fa-angle-left"></i></span></a>
                            <a href="#" class="theme-btn btn-style-two"><span class="txt">Buy Now <i class="fa fa-angle-left"></i></span></a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- End intro Courses -->


@endsection

@section('js')
    <script>
        // Array of all the questions and choices to populate the questions. This might be saved in some JSON file or a database and we would have to read the data in.
        var all_questions = [{
            question_string: "What color is the sky?",
            choices: {
                correct: "Blue",
                wrong: ["Pink", "Orange", "Green"]
            }
        }, {
            question_string: "Which of the following elements aren’t introduced in HTML5?",
            choices: {
                correct: "<input>",
                wrong: ["<article>", "<footer>", "<hgroup>"]
            }
        }, {
            question_string: "How many wheels are there on a tricycle?",
            choices: {
                correct: "Three",
                wrong: ["One", "Two", "Four"]
            }
        }, {
            question_string: 'Who is the main character of Harry Potter?',
            choices: {
                correct: "Harry Potter",
                wrong: ["Hermione Granger", "Ron Weasley", "Voldemort"]
            }
        }];

        // An object for a Quiz, which will contain Question objects.
        var Quiz = function(quiz_name) {
            // Private fields for an instance of a Quiz object.
            this.quiz_name = quiz_name;

            // This one will contain an array of Question objects in the order that the questions will be presented.
            this.questions = [];
        }

        // A function that you can enact on an instance of a quiz object. This function is called add_question() and takes in a Question object which it will add to the questions field.
        Quiz.prototype.add_question = function(question) {
            // Randomly choose where to add question
            var index_to_add_question = Math.floor(Math.random() * this.questions.length);
            this.questions.splice(index_to_add_question, 0, question);
        }

        // A function that you can enact on an instance of a quiz object. This function is called render() and takes in a variable called the container, which is the <div> that I will render the quiz in.
        Quiz.prototype.render = function(container) {
            // For when we're out of scope
            var self = this;

            // Hide the quiz results modal
            $('#quiz-results').hide();

            // Write the name of the quiz
            $('#quiz-name').text(this.quiz_name);

            // Create a container for questions
            var question_container = $('<div>').attr('id', 'question').insertAfter('#quiz-name');

            // Helper function for changing the question and updating the buttons
            function change_question() {
                self.questions[current_question_index].render(question_container);
                $('#prev-question-button').prop('disabled', current_question_index === 0);
                $('#next-question-button').prop('disabled', current_question_index === self.questions.length - 1);


                // Determine if all questions have been answered
                var all_questions_answered = true;
                for (var i = 0; i < self.questions.length; i++) {
                    if (self.questions[i].user_choice_index === null) {
                        all_questions_answered = false;
                        break;
                    }
                }
                $('#submit-button').prop('disabled', !all_questions_answered);
            }

            // Render the first question
            var current_question_index = 0;
            change_question();

            // Add listener for the previous question button
            $('#prev-question-button').click(function() {
                if (current_question_index > 0) {
                    current_question_index--;
                    change_question();
                }
            });

            // Add listener for the next question button
            $('#next-question-button').click(function() {
                if (current_question_index < self.questions.length - 1) {
                    current_question_index++;
                    change_question();
                }
            });

            // Add listener for the submit answers button
            $('#submit-button').click(function() {
                // Determine how many questions the user got right
                var score = 0;
                for (var i = 0; i < self.questions.length; i++) {
                    if (self.questions[i].user_choice_index === self.questions[i].correct_choice_index) {
                        score++;
                    }

                    $('#quiz-retry-button').click(function(reset) {
                        quiz.render(quiz_container);
                    });

                }



                // Display the score with the appropriate message
                var percentage = score / self.questions.length;
                console.log(percentage);
                var message;
                if (percentage === 1) {
                    message = 'Great job!'
                } else if (percentage >= .75) {
                    message = 'You did alright.'
                } else if (percentage >= .5) {
                    message = 'Better luck next time.'
                } else {
                    message = 'Maybe you should try a little harder.'
                }
                $('#quiz-results-message').text(message);
                $('#quiz-results-score').html('You got <b>' + score + '/' + self.questions.length + '</b> questions correct.');
                $('#quiz-results').slideDown();
                $('#submit-button').slideUp();
                $('#next-question-button').slideUp();
                $('#prev-question-button').slideUp();
                $('#quiz-retry-button').sideDown();

            });

            // Add a listener on the questions container to listen for user select changes. This is for determining whether we can submit answers or not.
            question_container.bind('user-select-change', function() {
                var all_questions_answered = true;
                for (var i = 0; i < self.questions.length; i++) {
                    if (self.questions[i].user_choice_index === null) {
                        all_questions_answered = false;
                        break;
                    }
                }
                $('#submit-button').prop('disabled', !all_questions_answered);
            });
        }

        // An object for a Question, which contains the question, the correct choice, and wrong choices. This block is the constructor.
        var Question = function(question_string, correct_choice, wrong_choices) {
            // Private fields for an instance of a Question object.
            this.question_string = question_string;
            this.choices = [];
            this.user_choice_index = null; // Index of the user's choice selection

            // Random assign the correct choice an index
            this.correct_choice_index = Math.floor(Math.random(0, wrong_choices.length + 1));

            // Fill in this.choices with the choices
            var number_of_choices = wrong_choices.length + 1;
            for (var i = 0; i < number_of_choices; i++) {
                if (i === this.correct_choice_index) {
                    this.choices[i] = correct_choice;
                } else {
                    // Randomly pick a wrong choice to put in this index
                    var wrong_choice_index = Math.floor(Math.random(0, wrong_choices.length));
                    this.choices[i] = wrong_choices[wrong_choice_index];

                    // Remove the wrong choice from the wrong choice array so that we don't pick it again
                    wrong_choices.splice(wrong_choice_index, 1);
                }
            }
        }

        // A function that you can enact on an instance of a question object. This function is called render() and takes in a variable called the container, which is the <div> that I will render the question in. This question will "return" with the score when the question has been answered.
        Question.prototype.render = function(container) {
            // For when we're out of scope
            var self = this;

            // Fill out the question label
            var question_string_h2;
            if (container.children('h2').length === 0) {
                question_string_h2 = $('<h2>').appendTo(container);
            } else {
                question_string_h2 = container.children('h2').first();
            }
            question_string_h2.text(this.question_string);

            // Clear any radio buttons and create new ones
            if (container.children('input[type=radio]').length > 0) {
                container.children('input[type=radio]').each(function() {
                    var radio_button_id = $(this).attr('id');
                    $(this).remove();
                    container.children('label[for=' + radio_button_id + ']').remove();
                });
            }
            for (var i = 0; i < this.choices.length; i++) {
                // Create the radio button
                var choice_radio_button = $('<input>')
                    .attr('id', 'choices-' + i)
                    .attr('type', 'radio')
                    .attr('name', 'choices')
                    .attr('value', 'choices-' + i)
                    .attr('checked', i === this.user_choice_index)
                    .appendTo(container);

                // Create the label
                var choice_label = $('<label>')
                    .text(this.choices[i])
                    .attr('for', 'choices-' + i)
                    .appendTo(container);
            }

            // Add a listener for the radio button to change which one the user has clicked on
            $('input[name=choices]').change(function(index) {
                var selected_radio_button_value = $('input[name=choices]:checked').val();

                // Change the user choice index
                self.user_choice_index = parseInt(selected_radio_button_value.substr(selected_radio_button_value.length - 1, 1));

                // Trigger a user-select-change
                container.trigger('user-select-change');
            });
        }

        // "Main method" which will create all the objects and render the Quiz.
        $(document).ready(function() {
            // Create an instance of the Quiz object
            var quiz = new Quiz('My Quiz');

            // Create Question objects from all_questions and add them to the Quiz object
            for (var i = 0; i < all_questions.length; i++) {
                // Create a new Question object
                var question = new Question(all_questions[i].question_string, all_questions[i].choices.correct, all_questions[i].choices.wrong);

                // Add the question to the instance of the Quiz object that we created previously
                quiz.add_question(question);
            }

            // Render the quiz
            var quiz_container = $('#quiz');
            quiz.render(quiz_container);
        });
    </script>
@endsection
