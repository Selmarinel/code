<?php
namespace App\Modules\VergoNews\Http\Controllers\Admin;

use App;
use App\Modules\VergoBase\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class ArticlesController extends Controller {
    protected $prefix = 'admin:news';
    protected $moduleName = 'vergo_news';
    protected $serviceName = 'App\Modules\VergoNews\Http\Services\Article';
    const LAST_TIME = 604800;

    protected function prepareData($model = null){
        return [
            'model' => (isset($model->id)) ? $model : $this->service->getModel(),
            'users' => App::make('App\Modules\VergoBase\Http\Services\User')->prepareSelect(),
            'categories' => App::make('App\Modules\VergoNews\Http\Services\Category')->prepareSelect(),
            'media' =>  App::make('App\Modules\VergoMedia\Http\Services\Media')->prepareSelect(),
        ];
    }

    public function add(Request $request){
        $this->setRules([
            'name'          =>  'required|min:2',
            'info'          =>  'required|min:3',
            'text'          =>  'required|min:5',
            'image_id'      =>  '',
            'is_hot_topic'  =>  '',
            'category_id'   =>  'required',
            'user_id'       =>  'required',
            'media_id'      =>  '',
            'interview_id'  =>  ''
        ]);
        if($request->method() != 'GET' && isset($request['cover'])) {
            $imageId = $this->saveFile($request);
            $request->merge(array('image_id' => $imageId));
        }
        $media_id = $this->createGallery($request);
        if($media_id){
            $request->merge(array('media_id' => $media_id));
        }

        $interview_id = $this->saveInterview($request);
        if($interview_id){
            $request->merge(array('interview_id' => $interview_id));
        }
        return parent::add($request);
    }

    public function edit(Request $request, $id){
        $this->setRules([
            'id'            =>  'required',
            'name'          =>  'required|min:2',
            'info'          =>  'required|min:3',
            'text'          =>  'required|min:5',
            'image_id'      =>  '',
            'is_hot_topic'  =>  '',
            'category_id'   =>  'required',
            'user_id'       =>  'required',
            'media_id'      =>  '',
            'interview_id'  =>  ''
        ]);

        if($request->hasFile('cover')) {
            $imageId = $this->saveFile($request);
            $request->merge(array('image_id' => $imageId));
        }

        $media_id = $this->createGallery($request);
        if($media_id){
            $request->merge(array('media_id' => $media_id));
        }

        $interview_id = $this->saveInterview($request);
        if($interview_id){
            $request->merge(array('interview_id' => $interview_id));
        }

        return parent::edit($request, $id);
    }

    private function createGallery(Request $request){
        if(isset($request['photo_ids'][0])) {
            $media = new App\Modules\VergoMedia\Http\Services\Media();
            $media->getModel()->fill([
                'name'      =>  $request->input('name'),
                'cover_id'  =>  $request['photo_ids'][0]
            ]);
            $media->getModel()->save();
            foreach($request['photo_ids'] as $key=>$file_id){
                $relation = new App\Modules\VergoMedia\Http\Services\ImagesRelation();
                $model = $relation->getModel();
                $relation->setWhere(['files_id'=>$file_id]);
                if (!isset($relation->getOne()->id)) {
                    $model->create([
                        'files_id' => $file_id,
                        'media_id' => $media->getModel()->id
                    ]);
                }
            }
            return $media->getModel()->id;
        }
        return null;

    }

    private function saveFile(Request $request){
        $service = new App\Modules\VergoNews\Http\Services\Image($request->file('cover'));
        $service->saveFile($request->user()->id);
        return $service->getModel()->id;
    }

    private function saveInterview(Request $request){
        if (($request->input('questions')[0]) || ($request->input('answers')[0])){
            $this->setRules(array_merge(
                $this->getRules(),
                [
                    'responder_first_name'  =>  'required|min:2',
                    'responder_last_name'   =>  'required|min:2',
                    'responder_position'    =>  'required|min:3',
                    'responder_cover_id'    =>  '',
                    'answers.*'             =>  'required|min:5',
                    'questions.*'           =>  'required|min:5'
                ]
            ));
            if ($this->isValidationFails($request)){
                return $this->getValidatorErrors();
            }
            /** Save responder */
            $responders = new App\Modules\VergoInterview\Http\Services\Responder();
            $responder = $responders->getModel()->query()->find($request->input('responder_id'));
            $responder = (isset($responder)) ? $responder : $responders->getModel();
            $responder->getModel()->fill([
                'first_name'=>$request->input('responder_first_name'),
                'last_name'=>$request->input('responder_last_name'),
                'position'=>$request->input('responder_position'),
                'cover_id'=>$request->input('responder_cover_id'),
            ]);
            $responder->getModel()->save();
            /** Save Interview */
            $service = new App\Modules\VergoInterview\Http\Services\Interview();
            if ($request->input('interview_id')){
                $model = $service->getModel()->query()->find($request->input('interview_id'));
            }
            $model = (isset($model)) ? $model : $service->getModel();
            $model->fill(['responder_id'  =>  $responder->getModel()->id]);
            $model->save();
            /**
             * Adding dialogs to interview
             */
            foreach($request->input('dialog_id') as $key => $id){
                $service = new App\Modules\VergoInterview\Http\Services\InterviewDialogs();
                $dialog = null;
                if ($request->input('dialog_id')[$key]){
                    $dialog = $service->getModel()->query()->find($request->input('dialog_id')[$key]);
                }
                $dialog = (isset($dialog)) ? $dialog : $service->getModel();
                $dialog->fill([
                        'interview_id'  =>  $model->id,
                        'question'      =>  $request->input('questions')[$key],
                        'answer'        =>  $request->input('answers')[$key]
                    ]);
                $dialog->save();
            }
            return $model->id;
        }
        return null;
    }

    public function main(Request $request){
        $comments = new App\Modules\VergoComments\Http\Services\Comments();
        $comments = $comments
            ->getModel()
            ->query()
            ->where('created_at','>',date('Y-m-d H:i:s',time()-self::LAST_TIME))
            ->get();
        $media = new App\Modules\VergoMedia\Http\Services\Media();
        $media = $media
            ->getModel()
            ->query()
            ->where('created_at','>',date('Y-m-d H:i:s',time()-self::LAST_TIME))
            ->get();
        $users = new App\Modules\VergoBase\Http\Services\User();
        $users = $users->getModel()
            ->query()
            ->where('created_at','>',date('Y-m-d H:i:s',time()-self::LAST_TIME))
            ->get();
        $news = $this->service
            ->getModel()
            ->query()
            ->where('created_at','>',date('Y-m-d H:i:s',time()-self::LAST_TIME))
            ->get();
        return view('vergo_base::admin.index',[
            'news'      =>  ($news) ? $news->count() : 0,
            'comments'  =>  ($comments)? $comments->count() : 0,
            'users'     =>  ($users)? $users->count() : 0,
            'media'     =>  ($media)? $media->count() : 0,
            'newest'    =>  $this->service->getAll(5),
            'popular'   =>  $this->service->getPopular(5),
            'unchecked' =>  $this->service->getUnChecked(5),
        ]);
    }
}