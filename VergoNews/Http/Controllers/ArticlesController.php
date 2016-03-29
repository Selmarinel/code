<?php
namespace App\Modules\VergoNews\Http\Controllers;

use App\Modules\VergoBase\Database\Models\Base;
use Illuminate\Http\Request;
use App\Modules\VergoBase\Http\Controllers\Admin\Controller;

class ArticlesController extends Controller
{
    /* @var $service \App\Modules\VergoNews\Http\Services\Article */
    protected $service;
    protected $prefix = 'site:article';
    protected $moduleName = 'vergo_news';
    protected $serviceName = 'App\Modules\VergoNews\Http\Services\Article';

    public function getArticle(Request $request, $id)
    {
        $model = $this->service->getOne($id);
        if (!$model) {
            return abort(404);
        }
        $model->updateViews();
        return view($this->getViewRoute('page'), [
            'model' => $model,
            'last' => $this->service->getLast($id)
        ]);
    }

    public function getArticles(Request $request, $id = null){
        return view($this->getViewRoute('index'), ['collection' => $this->getCollection($id)]);
    }

    private function getCollection($id = null)
    {
        $where = ['status' => Base::STATUS_ACTIVE];
        if ($id) {
            $where = array_merge($where, ['category_id' => $id]);
        }
        $this->service->setWhere($where);
        return $collection = $this->service->getAll();
    }
}