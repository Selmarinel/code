@extends('vergo_news::site.layouts.main')
@section('title',$model->name)
{{-- Content --}}
@section('content')
    {{--Section Big Image--}}
    <section class="big-image" style="background-image: url('{{$model->getCover()}}');">
        <div class="container">
            <div class="row title-image-a">
                <div class="col-md-12 title_of_article">
                    <div class="col-sm-6 text-uppercase">
                        <div class="col-sm-7">
                            {{$model->category->name}}
                        </div>
                        <div class="col-md-5 unpadding text-right">
                            <div class="col-md-7 unpadding">
                                <i class="fa fa-eye"> {{$model->view}}</i>
                            </div>
                            <div class="col-md-5 unpadding">
                                <i class="fa fa-comment-o"> {{$model->getCountComments()}}</i>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 image-title">
                        {{$model->name}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--Section Article--}}
    <section id="article" class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                @include('vergo_news::site.article.block.left')
            </div>
            <div class="col-md-4 col-xs-12">
                @include('vergo_news::site.article.block.right')
            </div>
        </div>
    </section>
@stop