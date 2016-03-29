<div class="left-block">
    <div class="col-md-12 user-ava-block">
        <div class="user_cover">
            <div class="image alt">
                <img src="{{$model->getUser()->getCover(100)}}">
            </div>
            <div class="info">
                <span class="name">{{$model->getUser()->getFullName()}}</span>
                <span class="post">{{$model->getUser()->role['name']}}</span>
            </div>
        </div>
    </div>
    <div class="article-text col-md-12">
        <div class="block-text">
            <?php echo $model->text ?>
        </div>
    </div>
    @include('vergo_media::site.block.media')
    @include('vergo_interview::site.block.article')
</div>
<div class="col-xs-12 comment">
    <div class="comments-block">
        @foreach($model->comments as $comment)
            @include('vergo_news::site.article.block.comment')
        @endforeach
        <div class="clearfix"></div>
        @if(isset(Request::user()->id))
            {!! Form::open(['url' => $getRoute('comment:add'), 'class' => 'popup form-horizontal form-label-left', 'enctype' => 'multipart/form-data']) !!}
            <div class="x_content">
                <div class="form-group">
                    {!! Form::textarea('text', '', ['class'=>'form-control comment-textarea','required','placeholder'=>'Оставить комментарий','maxlength'=>200] ) !!}
                </div>
                {!! Form::text('user_id', Request::user()->id ,['class'=>'hidden']) !!}
                {!! Form::text('article_id', $model->id,['class'=>'hidden']) !!}
                {!! Form::submit('Отправить', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close()!!}
        @endif
    </div>
</div>

@section('scripts')
    <link rel="stylesheet" href="{{$app['vergo_base.assets']->getPath('/css/pnotify.core.min.css')}}">
    <script type="text/javascript" src="{{$app['vergo_base.assets']->getPath('/js/lib/notify/pnotify.core.js')}}"></script>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/underscore/underscore-min.js')}}"></script>
    <script>
        var comment = _.template('<div class="col-md-12 unpadding">'+
                '<div class="col-md-1 col-xs-4 unpadding">'+
                '<img src="<%= cover %>" class="img-responsive img-circle">'+
                '</div><div class="col-md-3 col-xs-8 io"><%= user_name %></div>'+
                '<div class="col-md-8 unpadding green small text-right io"><%= date %></div></div>'+
                '<div class="clearfix"></div>'+
                '<div class="name text comment-text"><%= text %></div><hr>');

        $('form').on('submit',function(e){
            var form = $(e.target);
            if(! form.hasClass('popup')) {
                console.log(form);
                return true;
            }
            var formData = new FormData();
            form.serializeArray().reduce(function(obj, item) {
                formData.append(item.name, item.value);
                return obj;
            }, {});
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    var response = JSON.parse(res)
                    new PNotify({
                        title: 'Успех',
                        text: 'Комментарий добавлен.',
                        type: 'success',
                        animate: {
                            animate: true,
                            in_class: 'rotateInDownLeft',
                            out_class: 'rotateOutUpRight'
                        }
                    });
                    $('.comments-block').prepend(comment({
                        cover:response.cover,
                        user_name:response.name,
                        date:response.date,
                        text:response.text
                    }));
                    $('.comment-textarea').val('');
                },
                error: function(res){
                    var errors = JSON.parse(res.responseText).errors || ['Данные не валидные'];
                    new PNotify({
                        title: 'Ошибка',
                        text: errors.join("<br>"),
                        type: 'error',
                        animate: {
                            animate: true,
                            in_class: 'rotateInDownLeft',
                            out_class: 'rotateOutUpRight'
                        }
                    });
                    return false;
                }
            });
            return false;
        })
    </script>
@endsection