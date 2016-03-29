@if(isset($last->id))
    <div class="right-block">
        <a class="el-image" href="{{route('site:article:one',['id'=>$last->id])}}">
            <img src="{{$last->getCover(300)}}" class="img-responsive" >
            <div class="col-md-12 title-image alternative">
                <div class="col-md-12 title_of_article">
                    <div class="col-xs-5 green text-uppercase">
                        {{$last->category->name}}
                    </div>
                    <div class="col-xs-4 text-right">
                        <i class="fa fa-eye"></i> {{$last->view}}
                    </div>
                    <div class="col-xs-3 text-right">
                        <i class="fa fa-comment-o"></i> {{$last->getCountComments()}}
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr/>
                <span class="">
                    {{$last->info}}
                </span>
                <span class="footer-article alternative">{{$last->name}}</span>
            </div>
        </a>
    </div>
@endif

<div class="right-block" style="margin-top: 15px">
    <div class="col-xs-12">
        @foreach($app->make('App\Modules\VergoNews\Http\Services\Article')->getPopular(4, $model->id) as $article)
            <div class="col-sm-12 unpadding article-header">
                <div class="col-md-6 small sans">Популярное</div>
                <div class="col-md-6 text-right"><a class="b green" href="{{route('site:article:index')}}"> Просмотреть все</a></div>
            </div>
            <div class="col-sm-12 article-body">
                <a href="{{$getRoute('one', ['id' => $article->id])}}" class="el">
                    <div class="col-md-12 unpadding title_of_article">
                        <div class="col-md-7 unpadding green text-uppercase a">
                            {{$article->getCategory()->name}}
                        </div>
                        <div class="col-md-5 unpadding text-right">
                            <div class="col-md-7 unpadding a text-muted">
                                <i class="fa fa-eye"> {{$article->view}}</i>
                            </div>
                            <div class="col-md-5 unpadding a text-muted">
                                <i class="fa fa-comment-o"> {{$article->getCountComments()}}</i>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        <span class="name text">
                            {{$article->name}}
                        </span>
                        <span class="footer-article">
                            {{$article->getUser()->getFullName()}}
                        </span>
                    <hr/>
                </a>
            </div>
        @endforeach
    </div>
</div>