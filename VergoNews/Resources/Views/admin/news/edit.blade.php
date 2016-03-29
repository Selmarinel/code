@extends('vergo_base::admin.layouts.edit')

@section('title_name', 'Новости')

@section('form_body')
    @include('vergo_interview::admin.interview.block.panel')
    @include('vergo_media::admin.article.block.panel')
    {!! Form::hidden('id', $model->id, ['class'=>'form-control']) !!}
    <div class="form-group">
        {!! Form::label('Название') !!}
        {!! Form::text('name', $model->name, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Краткая информация') !!}
        {!! Form::text('info', $model->info, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Обложка') !!}
        <div class="addCover" id="addICover">
            <span class="addCoverPhoto"><div class="middle"><i class="glyphicon glyphicon-plus"></i> Выбрать обложку</div></span>
            {!! Form::file('cover',['class'=>'hidden','id'=>'selectCover']) !!}
            <img src="{{$model->getCover()}}" width="250" class="img-responsive">
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('Текст') !!}
        {!! Form::textarea('text', $model->text, ['class'=>'form-control','id'=>'edit']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Избраное') !!}
        {!! Form::checkbox('is_hot_topic',$model->is_hot_topic,true) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Категория') !!}
        {!! Form::select('category_id', $categories,$model->category_id, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Создатель') !!}
        {!! Form::select('user_id', $users, ($model->user_id) ? $model->user_id : Request::user()->id, ['class'=>'form-control']) !!}
    </div>
    @yield('media_block')
    @yield('interview_block')
@endsection

@section('scripts')
    @yield('add_script')
    @yield('media_script')
    <link href="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/css/froala_editor.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/css/froala_style.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/css/themes/gray.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/froala_editor.min.js')}}"></script>
    <!--[if lt IE 9]>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/froala_editor_ie8.min.js')}}"></script>
    <![endif]-->
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/plugins/tables.min.js')}}"></script>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/plugins/lists.min.js')}}"></script>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/plugins/colors.min.js')}}"></script>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/plugins/media_manager.min.js')}}"></script>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/plugins/font_family.min.js')}}"></script>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/plugins/font_size.min.js')}}"></script>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/plugins/block_styles.min.js')}}"></script>
    <script src="{{$app['vergo_base.assets']->getPath('js/lib/froala_editor/plugins/video.min.js')}}"></script>
    <script>
        $(function () {
            $('#edit').editable({
                inlineMode: false,
                theme: 'gray',
                height: '300',
                language: 'ru'
            })
            $('.froala-box div').last().remove()
        });

    </script>
@endsection