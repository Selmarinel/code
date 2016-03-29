@extends('vergo_base::admin.layouts.all')

@section('page_title', ' Категории<small>управление категориями</small>')

@section('tHead')
    <th>Id</th>
    <th>Название</th>
    <th>Цвет</th>
    <th>Отображение в меню</th>
    <th>Статус</th>
@endsection

@section('tBody')
    @foreach($collection as $model)
        <tr class="even pointer {{($model->version > $model->install_version) ? "info" : ""}}">
            <td class="a-center ">
                <input name="{{$model->id}}" type="checkbox" class="tableflat">
            </td>
            <td>{{$model->id}}</td>
            <td>{{$model->name}}</td>
            <td><span class="label" style="background: {{$model->color}}">&nbsp;</span> {{$model->color}}</td>
            <td>
                <a class="btn {{($model->is_main) ? "btn-success" : "btn-warning"}}"
                   href="{{route('admin:categories:update',['id'=>$model->id])}}">
                    <i class="fa {{($model->is_main) ? "fa-star" : "fa-star-o"}}"></i>
                </a>
            <td>
                <span class=" {{$model->getStateClass()}}">
                    {{($model->getStateName())}}
                </span>
            </td>
            <td class="last">
                <a class="btn btn-danger" href="{{route('admin:categories:delete',['id'=>$model->id])}}">
                    <i class="fa fa-remove"></i>
                </a>
                <a class="btn btn-success" href="{{route('admin:categories:edit',['id'=>$model->id])}}">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                <a class="btn {{($model->status)?"btn-warning":"btn-info"}}"
                   href="{{route('admin:categories:active',['id'=>$model->id])}}">
                    <i class="fa {{($model->status)?"fa-eye-slash":"fa-eye"}}"></i>
                </a>
            </td>
        </tr>
    @endforeach
@endsection