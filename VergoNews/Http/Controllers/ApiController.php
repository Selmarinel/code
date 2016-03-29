<?php
namespace App\Modules\VergoNews\Http\Controllers;

use App\Modules\VergoBase\Database\Models\Base;
use App\Modules\VergoComments\Http\Services\Comments;
use App\Modules\VStaticPage\Http\Services\PageService;
use Illuminate\Http\Request;
use App\Modules\VergoBase\Http\Controllers\Admin\Controller;

class ApiController extends Controller
{
    protected $prefix = 'site:article';
    protected $moduleName = 'vergo_news';
    protected $serviceName = 'App\Modules\VergoNews\Http\Services\Article';

    public function getAPINews(Request $request){
        return $this->service->getAPI();
    }

    public function getArticles(Request $request){
        $this->prefix = 'site';
        return view($this->getViewRoute('index'),['collection'=>$this->getCollection()]);
    }

    private function getCollection(){
        $this->service->setWhere(['status'=>Base::STATUS_ACTIVE]);
        $collection = $this->service->getAll();
        $comments = new Comments();
        $comments->setWhere(['status'=>Base::STATUS_ACTIVE]);
        foreach($comments->getAll() as $comment){
            $collection->add($comment);
        }
        $pages = new PageService();
        $pages->setWhere(['status'=>Base::STATUS_ACTIVE]);
        foreach($pages->getAll() as $page){
            $collection->add($page);
        }
        return $collection->sortByDesc(function ($item) {
            return $item->created_at;
        });
    }
}