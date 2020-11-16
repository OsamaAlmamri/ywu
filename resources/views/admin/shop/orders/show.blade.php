@extends('adminpanel.dataTableLayout')
@section('content')
    <style>

        #timeline {
            list-style: none;
            position: relative;
        }

        #timeline:before {
            top: 0;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 2px;
            background-color: #4997cd;
            left: 50%;
            margin-left: -1.5px;
        }

        #timeline .clearFix {
            clear: both;
            height: 0;
        }

        #timeline .timeline-badge {
            color: #fff;
            width: 50px;
            height: 50px;
            font-size: 1.2em;
            text-align: center;
            position: absolute;
            top: 20px;
            left: 50%;
            margin-left: -25px;
            background-color: #4997cd;
            z-index: 100;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        #timeline .timeline-badge span.timeline-balloon-date-day {
            font-size: 1.4em;
        }

        #timeline .timeline-badge span.timeline-balloon-date-month {
            font-size: .7em;
            position: relative;
            top: -10px;
        }

        #timeline .timeline-badge.timeline-filter-movement {
            background-color: #ffffff;
            font-size: 1.7em;
            height: 35px;
            margin-left: -18px;
            width: 35px;
            top: 40px;
        }

        #timeline .timeline-badge.timeline-filter-movement a span {
            color: #4997cd;
            font-size: 1.3em;
            top: -1px;
        }

        #timeline .timeline-badge.timeline-future-movement {
            background-color: #ffffff;
            height: 35px;
            width: 35px;
            font-size: 1.7em;
            top: -16px;
            margin-left: -18px;
        }

        #timeline .timeline-badge.timeline-future-movement a span {
            color: #4997cd;
            font-size: .9em;
            top: 2px;
            left: 1px;
        }

        #timeline .timeline-movement {
            border-bottom: dashed 1px #4997cd;
            position: relative;
        }

        #timeline .timeline-movement.timeline-movement-top {
            height: 60px;
        }

        #timeline .timeline-movement .timeline-item {
            padding: 20px 0;
        }

        #timeline .timeline-movement .timeline-item .timeline-panel {
            border: 1px solid #d4d4d4;
            border-radius: 3px;
            background-color: #FFFFFF;
            color: #666;
            padding: 10px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        }

        #timeline .timeline-movement .timeline-item .timeline-panel .timeline-panel-ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul {
            text-align: right;
        }

        #timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul li {
            color: #666;
        }

        #timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul li span.importo {
            color: #468c1f;
            font-size: 1.3em;
        }

        #timeline .timeline-movement .timeline-item .timeline-panel.debits .timeline-panel-ul {
            text-align: left;
        }

        #timeline .timeline-movement .timeline-item .timeline-panel.debits .timeline-panel-ul span.importo {
            color: #e2001a;
            font-size: 1.3em;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.product_questions') }} <small>{{ trans('labels.ListingAllproduct_questions') }}
                    ...</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.login')}}"><i
                            class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ route('admin.shop.product_questions.index')}}"><i
                            class="fa fa-dashboard"></i> {{ trans('labels.product_questions') }}</a></li>
                <li class="active"> {{ trans('labels.replay_product_questions') }}</li>
            </ol>
        </section>

        <!--  content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="container">
                <div id="timeline">
                    <div class="row timeline-movement timeline-movement-top">
                        <div class="timeline-badge timeline-future-movement">
                            <a href="#" class="replay_btn">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                        <div class="timeline-badge timeline-filter-movement">
                            <a href="#">
                                <span class="glyphicon glyphicon-time"></span>
                            </a>
                        </div>
                    </div>
                    <?php  $old_day = 0;  $first = 0 ?>
                    @foreach($productQuestion->replies as $replay)
                        <?php $date = formatDateToTimeLine($replay->created_at); ?>
                        @if($old_day!= $date['day'])
                            @if($first == 1 ) </div> @endif
                <div class="row timeline-movement">
                    <div class="timeline-badge">
                        <span class="timeline-balloon-date-day">{{$date['day']}}</span><br>
                        <span class="timeline-balloon-date-month">{{$date['month']}}</span>
                    </div>
                    @endif

                    @if($replay->replay_user_type=='admin')
                        <div class="col-sm-6  timeline-item" id="replay_dev_{{$replay->id}}" style="float: none">
                            <div class="row">
                                <div class="col-sm-11">
                                    <div class="timeline-panel credits">
                                        <a href="#" style="float: left" data-id="{{$replay->id}}"
                                           class="btn_delete_replay"> <i class="fa fa-trash"></i></a>
                                        <a href="#" style="float: left ; margin-left: 8px" class="btn_update_replay"
                                           data-id="{{$replay->id}}"> <i class="fa fa-edit"></i></a>
                                        <ul class="timeline-panel-ul">
                                            <li><span
                                                    class="importo">{{$replay->admin->name }}</span>
                                            </li>
                                            <li><span class="causale"
                                                      id="replay_text_{{$replay->id}}">{{$replay->text}} </span>
                                            </li>
                                            <li><p><small class="text-muted"><i
                                                            class="glyphicon glyphicon-time"></i>
                                                        {{$date['all']}}</small>
                                                </p></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @else
                        <div style="float: none" id="replay_dev_{{$replay->id}}"
                             class="col-sm-offset-6 col-sm-6 timeline-item">
                            <div class="row">
                                <div class="col-sm-offset-1 col-sm-11">
                                    <div class="timeline-panel debits">
                                        <a href="#" style="float: right" data-id="{{$replay->id}}"
                                           class="btn_delete_replay"> <i class="fa fa-trash"></i></a>

                                        <ul class="timeline-panel-ul">
                                            <li><span
                                                    class="importo">{{$replay->user->name  }}</span>
                                            </li>
                                            <li><span class="causale">{{$replay->text}}  </span>
                                            </li>
                                            <li><p><small class="text-muted"><i
                                                            class="glyphicon glyphicon-time"></i>
                                                        {{$date['all']}} </small>
                                                </p></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                    <?php $old_day = $date['day']; $first = 1 ?>
                    @endforeach

                </div>
                <!--due -->

            </div>
    </div>
    </section>
    </div>
    <
    <!-- /.row -->
    <!-- deletelanguagesModal -->
    <div class="modal fade" id="replayModal" tabindex="-1" role="dialog"
         aria-labelledby="deleteLanguagesModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="deleteLanguagesModalLabel">{{ trans('labels.replayToQuestion') }}</h4>
                </div>
                <input type="hidden" id="ques_ques_id" value="{{$productQuestion->product_id}}">
                <input type="hidden" id="ques_ques_replay_id" value="0">
                <div class="modal-body">
                    <div class="form-group">
                            <textarea id="question_reply" class="form-control" rows="6">


                            </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('labels.Close') }}</button>
                    <button type="button" class="btn btn-primary"
                            id="btnSendReply">{{ trans('labels.sendReplay') }}</button>

                </div>
            </div>
        </div>
    </div>

    <!--  row -->

    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
@endsection



@section('custom_js')
    <script>

        $(document).on('click', '.replay_btn', function () {
            $('#replayModal').modal('show');
            $("#ques_ques_replay_id").val(0);
            $("#question_reply").val('');
        });


        $(document).on('click', '.btn_update_replay', function () {
            $('#replayModal').modal('show');
            var id = $(this).data('id');
            var old = $('#replay_text_' + id).text();
            $("#ques_ques_replay_id").val(id)
            $("#question_reply").val(old);
        });


        $(document).on('click', '.btn_delete_replay', function () {

            if (confirm('هل تريد حذف هذا الاستفسار') == true) {
                var id = $(this).data('id');
                var data = '_token=' + encodeURIComponent("{{csrf_token()}}")
                    + '&reply_id=' + id;
                $.ajax({
                    type: 'POST',
                    url: '{{ route("admin.shop.product_questions.delete_replay")}}', //Returns ID in body
                    data: data,
                    // async: false, // <<== THAT makes us wait until the server is done.
                    success: function (data) {
                        if (data == 1)
                            $('#replay_dev_' + id).remove();
                        else
                            alert(('حدث خطاء ماء اثناء الحذف'))
                    },
                    error: function (jqXhr, status) {
                        console.log(jqXhr);
                        // alert("Your error message goes here");
                    }
                });
            }

        });


        $(document).on('click', '#btnSendReply', function (e) {
                var ques_ques_id = $('#ques_ques_id').val();
                var question_reply = $('#question_reply').val();
                var ques_ques_replay_id = $('#ques_ques_replay_id').val();
                var describtion = $('#question_reply').val();
                var describtion = describtion.replace(/\s+/g, '');
                if (describtion == '')
                    alert('يجب الرد على السؤوال');
                else {
                    var data = '_token=' + encodeURIComponent("{{csrf_token()}}")
                        + '&ques_ques_id=' + ques_ques_id
                        + '&ques_ques_replay_id=' + ques_ques_replay_id
                        + '&reply=' + question_reply;
                    $.ajax({
                        type: 'POST',
                        url: '{{route("admin.shop.product_questions.replay")}}', //Returns ID in body
                        data: data,
                        // async: false, // <<== THAT makes us wait until the server is done.
                        success: function (data) {
                            $('#ReplyText' + ques_ques_id).text(question_reply);
                            $('#replayModal').modal('hide');
                            if (ques_ques_replay_id == 0)
                                location.reload();
                            else
                                $('#replay_text_' + ques_ques_replay_id).text(question_reply);
                        },
                        error: function (jqXhr, status) {
                            console.log(jqXhr);
                            // alert("Your error message goes here");
                        }
                    });
                }
            }
        );
    </script>
@endsection
