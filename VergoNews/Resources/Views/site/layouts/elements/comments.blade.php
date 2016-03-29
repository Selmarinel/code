<div class="grid-item col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <a href="{{$getRoute('index',['id'=>$model->article->id])}}" class="el panel panel-body">
        <div class="col-md-12 unpadding">
            <div class="col-md-2 col-xs-4 unpadding">
                <img src="{{$model->user->getCover()}}" class="img-responsive img-circle" width="50px">
            </div>
            <div class="col-md-3 col-xs-8 io">
                {{$model->user->first_name}}
            </div>
            <div class="col-md-7 unpadding green small text-right io">
                {{$model->getDate()}}
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="name text comment-text">
            {{$model->text}}
        </div>
        <div class="col-xs-12 unpadding">{{$model->article->name}}</div>
        <hr/>
    </a>
</div>