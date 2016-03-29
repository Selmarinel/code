<?php
namespace App\Modules\VergoNews\Http\Services;

use App\Modules\VergoBase\Http\Services\Base;

class Article extends Base
{
    /* @var \App\Modules\VergoNews\Database\Models\ArticleModel */
    protected $model;
    protected $modelName = 'App\Modules\VergoNews\Database\Models\ArticleModel';

    public function oneArticle($id)
    {
        $model = $this->getModel();
        $this->setWhere(['status'=>$model::STATUS_ACTIVE]);
        return $this->getOne($id);
    }

    public function prepareSelect(){
        $articles = [];
        foreach($this->getAll() as $article){
            $articles[$article->id] = $article->name;
        }

        return $articles;
    }

    public function getAPI($limit = self::MAX_LIMIT, $offset = 0){
        $model = $this->getModel();
        $this->setWhere(['status'=>$model::STATUS_ACTIVE]);
        return $this->getModel()->query()->take($limit)->skip($offset)->get()->map(function($model){ return $model->getInfo(); });
    }

    public function getPopular($count = 5, $id = 0){
        $this->setWhere(['status'=> \App\Modules\VergoNews\Database\Models\ArticleModel::STATUS_ACTIVE]);
        return $this->getAll()
            ->filter(function($model) use ($id) {
                return $model->id != $id;
            })
            ->sortByDesc('view')
            ->take($count);
    }

    public function getLast($id = 0){
        return $this->getModel()
            ->where('id','!=',$id)
            ->where('status', \App\Modules\VergoNews\Database\Models\ArticleModel::STATUS_ACTIVE)
            ->orderBy('created_at','desc')
            ->first();
    }

    public function getUnChecked($count = 5){
        $this->setWhere(['status'=>\App\Modules\VergoBase\Database\Models\Base::STATUS_NOT_CHK]);
        return $this->getAll($count);
    }
}