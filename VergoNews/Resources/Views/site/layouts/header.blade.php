<section id="main" class="container">
    <div class="row menu-set">
        <div class="col-md-3 unpadding">
            <img src="{{$app['vergo_news.assets']->getPath('/img/yeap.png')}}" class="img-responsive">
        </div>
        <div class="col-md-9">
            <div class="col-xs-6 unpadding">
                <div class="col-xs-3 unpadding small">27 Декабря</div>
                <div class="col-xs-3 unpadding small"><i class="fa fa-cloud green"></i> Ташкент</div>
                <div class="col-xs-6 unpadding small">+4..+6 дождь</div>
            </div>
            <div class="col-xs-6">
                <div class="col-xs-7 small text-right">
                    <a href="#">
                        <i class="fa big">+</i> Отправить материал
                    </a>
                </div>
                <div class="col-xs-3 unpadding small">
                    <a href="#">
                        На русском
                    </a>
                </div>
                <div class="col-xs-2 unpadding small">
                    <a href="#">
                        Подписка
                    </a>
                </div>
            </div>
            <div class="col-xs-12 unpadding menu-list">
                <div class="col-lg-9 col-md-8" style="padding: 0px">
                    <ul class="list-inline">
                        @foreach(App::make('App\Modules\VergoNews\Http\Services\Category')->getMain()  as $category)
                            <li class="text-uppercase">
                                <a href="{{route('site:article:category',['id'=>$category->id])}}">
                                    {{$category->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4" style="padding: 0px">
                    @if(isset(Request::user()->id))
                        <span class="btn btn-default btn-rounded">{{Request::user()->getFullName()}}</span>
                        <a href="{{route('site:logout')}}">
                            <span class="btn btn-default btn-rounded">Выйти</span>
                        </a>
                    @else
                        <a href="{{route('site:login')}}">
                            <span class="btn btn-default btn-rounded">Войти</span>
                        </a>
                        <a href="">
                            <span class="btn btn-default btn-rounded">Регистрация</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>