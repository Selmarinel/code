@extends('vergo_base::admin.layouts.edit')

@section('title_name', 'Категории')

@section('form_body')
<link href="{{$app['vergo_news.assets']->getPath('/css/colorpicker/bootstrap-colorpicker.min.css')}}" rel="stylesheet">

{!! Form::hidden('id', $model->id, ['class'=>'form-control'] ) !!}

<div class="form-group">
    {!! Form::label('Название') !!}
    {!! Form::text('name', $model->name, ['class'=>'form-control','required'] ) !!}
</div>
<div class="form-group">
    {!! Form::label('Цвет *') !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="input-group colorpicker_init">
            {!! Form::text('color', $model->getColor(), ['class'=>'form-control','data-validate-length-range' => '6', 'required' => "required"] ) !!}
            <span class="input-group-addon"><i></i></span>
        </div>
    </div>
</div>
<div class="ln_solid"></div>
@endsection

@section('scripts')
    <script src="{{$app['vergo_news.assets']->getPath('/js/lib/colorpicker/bootstrap-colorpicker.js')}}"></script>
    <script>
        $(function () {
            $('.colorpicker_init').colorpicker({format: 'hex'});
        });
    </script>
@endsection