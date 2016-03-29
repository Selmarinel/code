@extends('vergo_base::admin.layouts.all')

@section('page_title', ' Новости<small>управление публикациями</small>')

@section('tHead')
    <th>Название</th>
    <th>Краткая информация</th>
    <th>Обложка</th>
    <th>Создатель</th>
    <th>Изобраное</th>
    <th>Категория</th>
    <th width="10%">Галерея</th>
    <th>Статус</th>
@endsection

@section('tBody')
    @foreach($collection as $model)
        <tr class="even pointer {{($model->role_id == $model::STATUS_DELETED) ? "warning" : ""}}">
            <td class="a-center ">
                <input name="{{$model->id}}" type="checkbox" class="tableflat">
            </td>
            <td>{{$model->name}}

            </td>
            <td>{{$model->info}}</td>
            <td>
                <img src="{{$model->getCover()}}" width="75" class="img-responsive">
            </td>
            <td>{{$model->getUser()->getFullName()}}</td>
            <td class="text-center">
                <i class="fa {{($model->is_hot_topic)?"fa-star":"fa-star-o"}}"></i>
            </td>
            <td>
                @if(isset($model->getCategory()->name))
                    <span class="label" style="background-color: {{$model->getCategory()->color}};">
                        {{$model->getCategory()->name}}
                    </span>
                @endif
            </td>
            <td>
                @if(isset($model->media->id))
                    <div style="display: block; position: relative">
                        <img src="{{$model->media->getCover()}}" width="50">
                        <div class="label label-default">{{$model->media->name}}</div>
                    </div>
                @endif
            </td>
            <td>
                <span class=" {{$model->getStateClass()}}">
                    {{($model->getStateName())}}
                </span>
            </td>
            <td class="last">
                <a class="btn {{($model->status)?"btn-warning":"btn-info"}}"
                   href="{{route('admin:news:active',['id'=>$model->id])}}">
                    <i class="fa {{($model->status)?"fa-eye-slash":"fa-eye"}}"></i>
                </a>
                <a class="btn btn-success" href="{{route('admin:news:edit',['id'=>$model->id])}}">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                <a class="btn btn-danger" href="{{route('admin:news:delete',['id'=>$model->id])}}">
                    <i class="fa fa-remove"></i>
                </a>
            </td>
        </tr>
    @endforeach
@endsection