<?php
namespace App\Modules\VergoNews\Http\Controllers\Admin;

use App\Modules\VergoBase\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $prefix = 'admin:categories';
    protected $moduleName = 'vergo_news';
    protected $serviceName = 'App\Modules\VergoNews\Http\Services\Category';

    public function active($id)
    {
        $model = $this->service->getOne($id);
        $model->is_main = false;
        $model->save();
        return parent::active($id);
    }

    public function add(Request $request){
        $this->setRules([
            'name'  =>  'required|min:2',
            'color'   =>  'required|min:6'
        ]);
        return parent::add($request);
    }

    public function edit(Request $request, $id){
        $this->setRules([
            'id'    =>  'required',
            'name'  =>  'required|min:2',
            'color' =>  'required|min:7|max:7'
        ]);
        return parent::edit($request, $id);
    }

    public function update(Request $request, $id){
        $this->service->updateIsMain($id);
        return redirect($this->getRoute());
    }
}