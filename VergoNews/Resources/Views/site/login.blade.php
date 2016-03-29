@extends('vergo_base::admin.layouts.simple')

{{-- Content --}}
@section('content')
<div id="login" class="form">
    <section class="login_content">
        @if(isset($errors))
            @foreach($errors as $error)
                <div class="alert alert-success" role="alert">
                    {{$error}}
                </div>
            @endforeach
        @endif
        {!! Form::open(['route' => 'site:login', 'class' => 'form-horizontal form-label-left', 'enctype' => 'multipart/form-data']) !!}
            <img src="{{$app['logo']}}" width="200px">
            <div>
                <input name="login" type="text" class="form-control" placeholder="E-Mail / Login" required="" />
            </div>
            <div>
                <input name="password" type="password" class="form-control" placeholder="Пароль" required="" />
            </div>
            <div>
                <button type="submit" class="btn btn-success btn-lg submit">Войти</button>
            </div>
            <div class="clearfix"></div>
            <div class="separator">

                <div class="clearfix"></div>
                <div>
                    <h1><i class="fa fa-copyright" style="font-size: 26px;"></i> VERGO</h1>

                    <p>©2015-{{date('Y')}} All Rights Reserved. Privacy and Terms</p>
                </div>
            </div>
        {!! Form::close()!!}
        <!-- form -->
    </section>
    <!-- content -->
</div>
@stop