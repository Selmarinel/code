<?php

namespace App\Modules\VergoNews\Http\Services;

use App\Modules\VergoBase\Http\Services\Base;

class Category extends Base{
    protected $orderBy = [];
    protected $modelName = 'App\Modules\VergoNews\Database\Models\CategoryModel';
    const CATEGORIES_COUNT = 7;

    public function prepareSelect(){
        $categories = [];
        $this->setWhere(['status'=>\App\Modules\VergoBase\Database\Models\Base::STATUS_ACTIVE]);
        foreach($this->getAll() as $category){
            $categories[$category->id] = $category->name;
        }

        return $categories;
    }

    public function updateIsMain($id){
        $model = $this->getOne($id);

        if ($model){
            $model->is_main = !$model->is_main;
            return $model->save();
        }
    }

    public function getMain($count = self::CATEGORIES_COUNT){
        $this->setWhere([
            'is_main' => 1,
            'status' => \App\Modules\VergoNews\Database\Models\CategoryModel::STATUS_ACTIVE
        ]);
        return $this->getAll($count);
    }
}