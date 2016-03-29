<div class="col-md-12 unpadding">
    <div class="col-md-1 col-xs-4 unpadding">
        <img src="{{$comment->user->getCover()}}" class="img-responsive img-circle">
    </div>
    <div class="col-md-3 col-xs-8 io">
        {{$comment->user->getFullName()}}
    </div>
    <div class="col-md-8 unpadding green small text-right io">
        {{$comment->getDate()}}
    </div>
</div>
<div class="clearfix"></div>
<div class="name text comment-text">
    {{$comment->text}}
</div>
<hr>