<!DOCTYPE html>
<html lang=en>
    <head>
        <meta charset=utf-8>
        <meta http-equiv=X-UA-Compatible content="IE=edge">
        <meta name=viewport content="width=device-width,initial-scale=1">
        <meta name=description content="">
        <meta name=keywords content="">
        <meta name=author content="">
        <title>
            @yield('title')
        </title>
        <!-- Bootstrap core CSS -->
        <link href="{{$app['vergo_base.assets']->getPath('/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{$app['vergo_base.assets']->getPath('/fonts/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{$app['vergo_base.assets']->getPath('/css/animate.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{$app['vergo_news.assets']->getPath('/css/vergo.css')}}">
        <link rel="stylesheet" href="{{$app['vergo_news.assets']->getPath('/css/vergo-article.css')}}">
        <script src="{{$app['vergo_base.assets']->getPath('/js/lib/jquery/jquery-2.1.3.min.js')}}"></script>
        <script src="{{$app['vergo_base.assets']->getPath('/js/lib/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{$app['vergo_news.assets']->getPath('/js/lib/masonry/masonry.pkgd.min.js')}}"></script>
        <script src="{{$app['vergo_news.assets']->getPath('/js/lib/masonry/imagesloaded.pkgd.min.js')}}"></script>
    </head>
    <body>
        @yield('head_panel')
        <!-- Section Main -->
        @include('vergo_news::site.layouts.header')

        <nav class="navbar navbar-fixed-top navbar-inverse" style="opacity: 0.25; position: absolute; top: 0px; left: 0px;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-model" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">TEMP PANNEL</a>
                </div>
                <div class="collapse navbar-collapse" id="top-model">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="/vadmin"><i class="fa fa-empire"></i> Admin Panel</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- CONTENT -->
        @yield('content')
        <!-- FOOTER -->
        @include('vergo_news::site.layouts.footer')
    </body>
    <!-- Scripts -->
    @yield('scripts')
    <script>
        var $grid = $('.grid').masonry({
        });
        $grid.imagesLoaded().progress( function() {
            $grid.masonry('layout');
        });
    </script>
</html>