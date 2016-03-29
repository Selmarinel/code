<div class="grid-item col-lg-3 col-md-4 col-sm-6 col-xs-12 panel">
    <a href="{{$getRoute('one',['id'=>$model->id])}}" class="el unpadding el-image">
        <img src="{{$model->getCover()}}" class="img-responsive"> <!--запихнуть в модель-->
        <div class="col-md-12 title-image alternative">
            <div class="col-md-12 title_of_article">
                <div class="col-md-6 unpadding text-uppercase">
                    {{$model->getCategory()->name}}
                </div>
                <div class="col-md-6 unpadding text-right">
                    <div class="col-md-7 unpadding">
                        <i class="fa fa-eye"> {{$model->view}}</i>
                    </div>
                    <div class="col-md-5 unpadding">
                        <i class="fa fa-comment-o"> {{$model->getCountComments()}}</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 green dtn">{{$model->getDate()}}</div>
        <div class="col-xs-12">
            <p class="text">
               {{$model->name}}
            </p>
            <span class="article-foot-text">{{$model->info}}</span>
        </div>
    </a>
</div>