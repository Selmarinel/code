<?php

namespace App\Modules\VergoInterview\Http\Controllers\Admin;

use App\Modules\VergoBase\Database\Models\Base;
use App\Modules\VergoBase\Http\Controllers\Admin\Controller;
use App\Modules\VergoInterview\Http\Services\Image;
use App\Modules\VergoInterview\Http\Services\InterviewDialogs;
use Illuminate\Http\Request;

class InterviewController extends Controller{
    protected $prefix = 'admin:interview';
    protected $moduleName = 'vergo_interview';
    protected $serviceName = 'App\Modules\VergoInterview\Http\Services\Interview';

    public function addPhoto(Request $request){
        if (!$request->hasFile('responder_cover')) {
            return $this->sendWithErrors('Image is not found', 404);
        }
        /* @var \App\Modules\VergoInterview\Database\Models\ResponderCover */
        $image = $this->saveFile($request);
        return $this->sendOk([
            'src' => $image->getCover(),
            'id'=> $image->id
        ]);
    }

    private function saveFile(Request $request){
        $service = new Image($request->file('responder_cover'));
        $service->saveFile($request->user()->id);
        return $service->getModel();
    }

    public function deleteDialog(Request $request,$id){
        if(!$id){
            return $this->sendWithErrors('Not found id');
        }
        $service = new InterviewDialogs();
        $service->setWhere(['id'=>$id]);
        if (! $service->getOne()){
            return $this->sendWithErrors('Not found Dialog');
        }
        $service->getModel()->status = Base::STATUS_DELETED;
        $service->getModel()->save();
        return $this->sendOk();
    }
}
