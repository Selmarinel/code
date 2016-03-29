<?php
namespace App\Modules\VergoNews\Http\Controllers\Admin;

use App;
use Illuminate\Http\Request;
use App\Modules\VergoBase\Http\Controllers\Admin\Controller;

class UserController extends Controller
{
    protected $prefix = 'site';
    protected $moduleName = 'vergo_news';
    protected $serviceName = 'App\Modules\VergoBase\Http\Services\User';

    public function login(Request $request){
        if ($request->method() == 'GET') {
            return view($this->getViewRoute('login'));
        }
        $this->setRules([
            'login'     =>  'required|min:2|max:60',
            'password'  =>  'required|min:2|max:60'
        ]);
        if ($this->isValidationFails($request)){
            return view($this->getViewRoute('login'), ['errors' => $this->getValidatorErrors()]);
        }
        $this->service->auth($this->getRulesInput($request));

        if($this->service->isErrors()) {
            return view($this->getViewRoute('login'), ['errors' => $this->service->getErrors()]);
        }

        $request->session()->put('token', $this->service->getModel()->token->getApiKey());
        return redirect($this->getRoute('article:index'));
    }

    public function logout(Request $request){
        $request->session()->forget('token');
        return redirect($this->getRoute('article:index'));
    }
}