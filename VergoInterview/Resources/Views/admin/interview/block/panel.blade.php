@section('interview_block')
    <span class="btn btn-default" id="interview" style="display: {{($model->interview) ? 'none' : 'block'}}"><i class="fa fa-plus"></i> Добавить Интервью</span>
    <div id="interview_panel"  style="display: {{($model->interview) ? 'block' : 'none' }}">
        {!! Form::hidden('interview_id',$model->interview_id) !!}
        <span class="btn btn-default btn-xs" style="position: absolute; right:0px; z-index: 100;" id="close_interview_button"><i class="fa fa-close"></i> </span>
        <div id="responder" class="col-xs-12">
            <div class="form-group">
                {!! Form::label('Фото респондента') !!}
                <div class="addCover" id="addReponderCover">
                        <span class="addCoverPhoto">
                            <div class="middle">
                                <i class="glyphicon glyphicon-plus"></i> Выбрать обложку
                            </div>
                        </span>
                    {!! Form::file('responder_cover',['class'=>'hidden','id'=>'selectResponderCover']) !!}
                    {!! Form::hidden('responder_cover_id',(isset($model->interview->id)) ? $model->interview->responder->cover_id : 0,['id'=>'responderCoverId']) !!}
                    <img src="{{(isset($model->interview)) ? $model->interview->responder->getCover() : App('logo') }}" width="250" class="img-responsive">
                </div>
            </div>
            {!! Form::hidden('responder_id',(isset($model->interview->id)) ? $model->interview->responder->id : 0) !!}
            <div class="form-group">
                {!! Form::label('Имя респондента') !!}
                {!! Form::text('responder_first_name',(isset($model->interview->id)) ? $model->interview->responder->first_name : '',['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Фамилия респондента') !!}
                {!! Form::text('responder_last_name',(isset($model->interview->id)) ? $model->interview->responder->last_name : '',['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Должность респондента') !!}
                {!! Form::text('responder_position',(isset($model->interview->id)) ? $model->interview->responder->position : '',['class'=>'form-control']) !!}
            </div>

        </div>
        <div class="col-xs-12 questions_list">
            @if(isset($model->interview->dialogs[0]))
                @foreach($model->interview->dialogs as $dialog)
                    <div class="col-sm-6 col-xs-12 form-group dialog" style="display: block;">
                        <span class="btn btn-danger btn-xs btn-round" style="position: absolute; right:0px; z-index: 100;" id="{{$dialog->id}}"><i class="fa fa-close"></i> </span>
                        {!! Form::hidden('dialog_id[]',$dialog->id) !!}
                        {!! Form::label("Вопрос") !!}
                        {!! Form::textarea("questions[]", $dialog->question, ["class"=>"form-control","rows"=>"3"]) !!}
                        {!! Form::label("Ответ") !!}
                        {!! Form::textarea("answers[]", $dialog->answer, ["class"=>"form-control","rows"=>"3"]) !!}
                    </div>
                @endforeach
            @else
                <div class="col-sm-6 col-xs-12 form-group dialog" style="display: block;">
                    <span class="btn btn-danger btn-xs btn-round" style="position: absolute; right:0px; z-index: 100;" id=""><i class="fa fa-close"></i> </span>
                    {!! Form::hidden('dialog_id[]','') !!}
                    {!! Form::label("Вопрос") !!}
                    {!! Form::textarea("questions[]", '', ["class"=>"form-control","rows"=>"3"]) !!}
                    {!! Form::label("Ответ") !!}
                    {!! Form::textarea("answers[]", '', ["class"=>"form-control","rows"=>"3"]) !!}
                </div>
            @endif
        </div>
        <div class="col-xs-12">
            <span class="btn btn-default btn-rounded" id="add_question"><i class="fa fa-plus"></i> Добавить вопрос</span>
        </div>
    </div>
@endsection
@section('add_script')
    <script>
        var question_element = _.template('<div class="col-sm-6 col-xs-12 form-group dialog" style="display: none;">'+
                '<span class="btn btn-danger btn-xs btn-round" style="position: absolute; right:0px; z-index: 100;" id=""><i class="fa fa-close"></i> </span>'+
                '{!! Form::hidden('dialog_id[]',"") !!}'+
                '{!! Form::label("Вопрос") !!}' +
                '{!! Form::textarea("questions[]", "", ["class"=>"form-control","rows"=>"3"]) !!}' +
                '{!! Form::label("Ответ") !!}' +
                '{!! Form::textarea("answers[]", "", ["class"=>"form-control","rows"=>"3"]) !!}' +
                '</div>');

        $('#interview').on('click',function(){
            $(this).hide();
            $('#interview_panel').toggle(500);
        });
        $('#close_interview_button').on('click',function(){
            $('#interview').show();
            $('#interview_panel').hide(500);
        });

        var deleteDialog = function(self){
            var id = $(self).attr('id');
            if (id){
                $.ajax({
                    type: 'DELETE',
                    url: '/vadmin/interview/deleteDialog/' + id,
                    processData: false,
                    contentType: false,
                    success: function () {
                        $(self).parent().fadeOut(333,function(){
                            $(this).remove();
                        });
                        return new PNotify({
                            title: 'Успех',
                            text: 'Диалог удален',
                            type: 'success'
                        })
                    },
                    error: function () {
                        new PNotify({
                            title: 'Ошибка',
                            text: 'Диалог не удален',
                            type: 'error'
                        });
                        return false;
                    }
                });
            }

        }
        $('.dialog span').on('click',function(el){
            deleteDialog(this);
        });
        $("#add_question").on('click',function() {
            $('.questions_list').append(question_element);
            $('.dialog').slideDown(333);
            $('.dialog span:last').on('click',function(){
                deleteDialog(this);
            });
        });
        $('#addReponderCover span').on('click', function(){
            $('#selectResponderCover').click();
            return;
        });
        $('#selectResponderCover[type=file]').on('change', function(){
            PopUpShow();
            var formData = new FormData();
            if(this.files[0] == undefined) {
                return new PNotify({
                    title: 'Ошибка',
                    text: 'Файл не найден',
                    type: 'error'
                })
            }
            formData.append($(this).attr('name'), this.files[0]);
            $.ajax({
                type: 'POST',
                url: '/vadmin/interview/addCover',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    PopUpHide();
                    var response = JSON.parse(res);
                    $('#addReponderCover img').attr('src',response.src);
                    $('#responderCoverId').val(response.id);
                    new PNotify({
                        title: 'Успех',
                        text: 'Добавление данных прошло успешно!',
                        type: 'success'
                    });
                },
                error: function (res) {
                    PopUpHide();
                    new PNotify({
                        title: 'Ошибка',
                        text: 'Фото не загружено',
                        type: 'error'
                    });
                    return false;
                }
            });
        });
    </script>
@endsection