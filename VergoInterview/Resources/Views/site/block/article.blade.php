<div class="col-xs-12">
    @if($model->interview)
        @foreach($model->interview->dialogs as $dialog)
            @if (isset($dialog))
                <div class="conversation">
                    <div class="title">
                        <div class="user_cover">
                            <div class="image">
                                <img src="{{$model->user->getCover()}}">
                            </div>
                            <div class="query">
                                {{$dialog->question}}
                            </div>
                            @if($model->interview->responder)
                                <div class="user_cover">
                                    <div class="image">
                                        <img class="answer" src="{{$model->interview->responder->getCover()}}">
                                    </div>
                                    <div class="info">
                                        <span class="name">{{$model->interview->responder->getFullName()}}</span>
                                        <span class="post">{{$model->interview->responder->position}}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="info-ar">
                    {{$dialog->answer}}
                </div>
            @endif
        @endforeach
    @endif
</div>