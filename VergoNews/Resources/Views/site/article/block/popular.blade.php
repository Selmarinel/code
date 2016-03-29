<div class="grid-item col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="news_right_block">
        <div class="col-sm-12 unpadding article-header">
            <div class="col-md-6 small sans">Популярное</div>
            <div class="col-md-6 green b text-right">Просмотреть все</div>
        </div>
        @foreach($app->make('App\Modules\VergoNews\Http\Services\Article')->getPopular(4) as $model)
            <div class="col-sm-12 article-body">
                <a href="{{$getRoute('one', ['id' => $model->id])}}" class="el">
                    <div class="col-md-12 unpadding title_of_article">
                        <div class="col-md-7 unpadding green text-uppercase a">
                            {{$model->getCategory()->name}}
                        </div>
                        <div class="col-md-5 unpadding text-right">
                            <div class="col-md-7 unpadding a text-muted">
                                <i class="fa fa-eye"> {{$model->view}}</i>
                            </div>
                            <div class="col-md-5 unpadding a text-muted">
                                <i class="fa fa-comment-o"> {{$model->getCountComments()}}</i>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <span class="name text">
                        {{$model->name}}
                    </span>
                    <span class="footer-article">
                        {{$model->getUser()->getFullName()}}
                    </span>
                    <hr/>
                </a>
            </div>
        @endforeach
    </div>
</div>