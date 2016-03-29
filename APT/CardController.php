<?php
namespace App\Http\Controllers;

use App\Modules\MedicalCard\Models\Diagnosises;
use App\Modules\MedicalCard\Models\Symptoms;
use App\Modules\MedicalCard\Models\Times;
use App\Modules\medicalDrugs\Models\medicalGoods;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use App\Modules\MedicalCard\Service\Blank as Service;
use App\Modules\MedicalCard\Models\Blank as Model;
use App\Modules\MedicalCard\Models\SymptomsCard;
use App\Modules\MedicalCard\Models\DiagnosisesCard;
use App\Modules\MedicalCard\Models\Doctors;
use App\Modules\MedicalCard\Service\PhotoUrl;
use App\Modules\MedicalCard\Models\Drugs;
use App\Modules\MedicalCard\Models\Photos;
use Illuminate\Support\Facades\Cookie;
use App\Modules\User\Models\Token;

class CardController extends Controller {

    private $symptoms = [];
    private $diagnosises = [];
    private $doctors = [];
    private $drugs = [];

    public function getCard(Request $request,$id){
        if(!isset($id)){
            return $this->sendJsonError('Invalid Data');
        }
        $service = new Service();
        $take = $request->input('take');
        $skip = $request->input('skip');
        $filter = [
            'take'  =>  isset($take)?$take:500,
            'skip'  =>  isset($skip)?$skip:0,
            'user_id'    =>  $id
        ];
        return $this->sendJsonOk($service->getAll($filter));
    }
    public function getOwnCard(Request $request){
        if (!Cookie::has('token')) {
            return $this->sendJsonError('User not Auth');
        }
        $model = Token::query()->where('token', Cookie::get('token'))->first();
        if (!isset($model)) {
            return $this->sendJsonError('User not Auth');
        }
        return $this->getCard($request,$model->user_id);
    }

    public function createCard(Request $request){
        $userId = null;
        if (Cookie::has('token')) {
            $token = Token::query()->where('token', Cookie::get('token'))->first();
            if (isset($token)) {
                $userId = $token->user_id;
            }
        }
        $doctors = [];
        $drugs = [];
        $photos_s = [];
        $this->setRules([
            'user_id' => 'integer',
            'complaints' => 'required|min:10',
            'notes' =>'',
            'symptoms_ids'=>'',
            'diagnosis_ids' => '',
            'doctors_ids' => '',
            'photos'=>'',
            'drugs' => '',
        ]);
        if($this->isValidationFails($request)) {
            return $this->sendJsonError($this->getValidatorErrors());
        }
        $model = new Model();
        if (!$userId){
            return $this->sendJsonError('Not found user');
        }
        $model->fill($this->getRulesInput($request));
        $model->user_id  = $request->input('user_id')? $request->input('user_id') : $userId;
        $model->save();

        if ($request->input('symptoms_ids') && !empty($request->input('symptoms_ids'))){
            foreach($request->input('symptoms_ids') as $symptom_id) {
                SymptomsCard::create([
                    'medical_card_id' => $model->id,
                    'symptom_id' => $symptom_id
                ]);
            }
        }
        if ($request->input('diagnosis_ids') && !empty($request->input('diagnosis_ids'))){
            foreach($request->input('diagnosis_ids') as $diagnosis_id) {
                DiagnosisesCard::create([
                    'medical_card_id' => $model->id,
                    'diagnosis_id' => $diagnosis_id
                ]);
            }
        }
        if ($request->input('doctors_ids') && !empty($request->input('doctors_ids'))){
            foreach ($request->input('doctors_ids') as $key=>$value){
                $doctors[$key]=
                    [
                        'medical_card_id'=> $model->id,
                        'doctor_id'=> $value,
                        'inference'=> $request->input('doctors_inference')[$key],
                        'recommendations'=> $request->input('doctors_recommendations')[$key],
                    ];
            }
        }
        if (!empty($doctors)){
            foreach ($doctors as $doctor){
                Doctors::create($doctor);
            }
        }
        if ($request->input('drugs_ids') && !empty($request->input('drugs_ids'))) {
            foreach ($request->input('drugs_ids') as $key => $value) {
                $drugs[$key] =
                    [
                        'medical_card_id' => $model->id,
                        'drug_id' => $value,
                        'recipe' => $request->input('drug_recipe')[$key]
                    ];
            }
        }
        if (!empty($drugs)){
            foreach ($drugs as $drug){
                Drugs::create($drug);
            }
        }

        if ($request->input('photo_name') && !empty($request->input('photo_name'))){
            foreach ($request->input('photo_name') as $key => $value) {
                $cover = new PhotoUrl($request->file('photo_url')[$key]);
                $photos_s[$key] =
                    [
                        'medical_card_id' => $model->id,
                        'photo_url' => $cover->saveFile(),
                        'name' => $value,
                        'description' => $request->input('photo_description')[$key]
                    ];
            }
        }
        if(!empty($photos_s)){
            foreach($photos_s as $photo) {
                Photos::create($photo);
            }
        }
        return $this->sendJsonOk(['message'=>'Success']);
    }

    private function prepareData(){
        foreach(Symptoms::query()->where('status',Service::ACTIVE)->get(['id', 'name']) as $symptom) {
            $this->symptoms[$symptom->id] = $symptom->name;
        }
        foreach(Diagnosises::query()->where('status',Service::ACTIVE)->get(['id', 'name']) as $diagnosis) {
            $this->diagnosises[$diagnosis->id] = $diagnosis->name;
        }
        foreach(User::query()->where('role',Service::TYPE_DOCTOR)->get(['id', 'first_name']) as $doctor) {
            $this->doctors[$doctor->id] = $doctor->first_name;
        }
        foreach(medicalGoods::query()->where('status',Service::ACTIVE)->get(['id', 'name']) as $drug) {
            $this->drugs[$drug->id] = $drug->name;
        }
    }

    public function newCard(Request $request){
        $model = new Model();
        $this->prepareData();
        return view('admin/card/add', ['model' => $model,
            'symptoms'=>$this->symptoms,
            'diagnosises'=>$this->diagnosises,
            'doctors'=>$this->doctors,
            'drugs'=>$this->drugs
        ]);
    }

    public function addSymptom(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $data = $this->checkSymptom($id,$id1,0);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        SymptomsCard::create(['medical_card_id'=>$id,'symptom_id'=>$id1]);

        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function delSymptom(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $data = $this->checkSymptom($id,$id1,1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        SymptomsCard::query()->where('medical_card_id',$id)->where('symptom_id',$id1)->delete();
        return $this->sendJsonOk(['message'=>'Success']);

    }

    public function addDiagnosis(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $data = $this->checkDiagnosis($id,$id1,0);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        DiagnosisesCard::create(['medical_card_id'=>$id,'diagnosis_id'=>$id1]);
        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function delDiagnosis(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $data = $this->checkDiagnosis($id,$id1,1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        DiagnosisesCard::query()->where('medical_card_id',$id)->where('diagnosis_id',$id1)->delete();
        return $this->sendJsonOk(['message'=>'Success']);
    }

    public function checkData($cardId,$oneId){
        if(!isset($cardId) && !isset($oneId)){
            return 'Invalid Data';
        }
        $card = Model::query()->where('status',Service::ACTIVE)->find($cardId);
        if (!isset($card)){
            return 'Not found card';
        }
    }
    public function checkDiagnosis($cardId,$oneId,$del=0){
        $diagnosis = Diagnosises::query()->where('status',Service::ACTIVE)->find($oneId);
        if (!isset($diagnosis)){
            return 'Not found diagnosis';
        }
        $relation = DiagnosisesCard::query()->where('diagnosis_id',$oneId)->where('medical_card_id',$cardId)->first();
        if (isset($relation) && ($del == 0)){
            return 'Diagnosis already added';
        }
        if (!isset($relation) && ($del == 1)){
            return 'Not found relation';
        }
        return null;
    }
    public function checkSymptom($cardId,$oneId,$del=0){
        $symptom = Symptoms::query()->where('status',Service::ACTIVE)->find($oneId);
        if (!isset($symptom)){
            return 'Not found symptom';
        }
        $relation = SymptomsCard::query()->where('symptom_id',$oneId)->where('medical_card_id',$cardId)->first();
        if (isset($relation) && ($del == 0)){
            return 'Symptom already added';
        }
        if (!isset($relation) && ($del == 1)){
            return 'Not found relation';
        }
        return null;
    }

    public function addPhoto(Request $request,$id){
        if(!isset($id)){
            return $this->sendJsonError('Invalid Data');
        }
        $card = Model::query()->where('status',Service::ACTIVE)->find($id);
        if(!isset($card)){
            return $this->sendJsonError('Not found medical card');
        }
        $this->setRules([
            'url' => 'required|image',
            'name'   => 'required',
            'description'   => '',
        ]);
        if($this->isValidationFails($request)) {
            return $this->sendJsonError($this->getValidatorErrors());
        }
        $model = new Photos();
        $model->fill($this->getRulesInput($request));
        if ($request->hasFile('url')) {
            $coverService = new PhotoUrl($request->file('url'));
            $model->photo_url = $coverService->saveFile();
        }
        $model->medical_card_id = intval($id);
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function showPhoto(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $model = Photos::query()->where('medical_card_id',$id)->where('status',Service::ACTIVE)->find($id1);
        if(!isset($model)){
            return $this->sendJsonError('Not found photo');
        }
        return $this->sendJsonOk(['photo'=>$model->getInfo()]);
    }
    public function editPhoto(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $this->setRules([
            'url' => 'image',
            'name'   => 'required|min:5',
            'description'   => '',
        ]);
        if($this->isValidationFails($request)) {
            return $this->sendJsonError($this->getValidatorErrors());
        }
        $model = Photos::query()->find($id1);
        if(!isset($model)){
            return $this->sendJsonError('Not found photo');
        }
        $model->fill($this->getRulesInput($request));
        if ($request->hasFile('url')) {
            $coverService = new PhotoUrl($request->file('url'));
            $model->photo_url = $coverService->saveFile();
        }
        $model->medical_card_id = intval($id);
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function delPhoto(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $model = Photos::query()->where('medical_card_id',$id)->where('status',Service::ACTIVE)->find($id1);
        if (!isset($model)){
            return $this->sendJsonError('Not found photo');
        }
        $model->status = Service::NOT_ACTIVE;
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);
    }

    public function addDrug(Request $request,$id){
        if(!isset($id)){
            return $this->sendJsonError('Invalid Data');
        }
        $card = Model::query()->where('status',Service::ACTIVE)->find($id);
        if(!isset($card)){
            return $this->sendJsonError('Not found medical card');
        }
        $this->setRules([
            'drug_id'   => 'required|integer',
            'recipe'   => 'min:5'
        ]);
        if($this->isValidationFails($request)) {
            return $this->sendJsonError($this->getValidatorErrors());
        }

        $drug = medicalGoods::query()->where('status',Service::ACTIVE)->find($request->input('drug_id'));
        if (!isset($drug)){
            return $this->sendJsonError('Not found drug');
        }

        $check = Drugs::query()
            ->where('medical_card_id',$id)
            ->where('drug_id',$request->input('drug_id'))
            ->first();
        if(isset($check)){
            return $this->sendJsonError('Drug already added');
        }
        $model = new Drugs();
        $model->fill($this->getRulesInput($request));
        $model->medical_card_id = intval($id);
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);

    }
    public function editDrug(Request $request,$id){
        if(!isset($id)){
            return $this->sendJsonError('Invalid Data');
        }
        $card = Model::query()->where('status',Service::ACTIVE)->find($id);
        if(!isset($card)){
            return $this->sendJsonError('Not found medical card');
        }

        $this->setRules([
            'drug_id' =>'required|integer',
            'recipe'   => 'min:5'
        ]);
        if($this->isValidationFails($request)) {
            return $this->sendJsonError($this->getValidatorErrors());
        }
        $model = new Drugs();
        $drug = Drugs::query()
            ->where('status',Service::ACTIVE)
            ->where('medical_card_id',$id)
            ->where('drug_id',$request->input('drug_id'))
            ->first();

        if(isset($drug)){
            $model->where('medical_card_id',$id)
                ->where('drug_id',$drug->id)
                ->update([
                'recipe'=>$request->input('recipe')
            ]);
            return $this->sendJsonOk(['message'=>'Success']);
        }
        $model->fill($this->getRulesInput($request));
        $model->medical_card_id = $id;
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function delDrug(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $model = Drugs::query()
            ->where('status',Service::ACTIVE)
            ->where('medical_card_id',$id)
            ->where('drug_id',$id1)
            ->first();
        if (!isset($model)){
            return $this->sendJsonError('Not found drug');
        }
        $model->status = Service::NOT_ACTIVE;
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function showDrug(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $model = Drugs::query()
            ->where('medical_card_id',$id)
            ->where('status',Service::ACTIVE)
            ->where('drug_id',$id1)
            ->first();
        if(!isset($model)){
            return $this->sendJsonError('Not found drug');
        }
        return $this->sendJsonOk(["drug"=>$model->getInfo()]);
    }

    public function addDoctor(Request $request,$id){
        if(!isset($id)){
            return $this->sendJsonError('Invalid Data');
        }
        $card = Model::query()->where('status',Service::ACTIVE)->find($id);
        if(!isset($card)){
            return $this->sendJsonError('Not found medical card');
        }

        $this->setRules([
            'inference' =>'min:5',
            'recommendations'   => 'min:5',
            'doctor_times_id' =>'required|integer'
        ]);
        if($this->isValidationFails($request)) {
            return $this->sendJsonError($this->getValidatorErrors());
        }
        $time = Times::query()
            ->where('status',Service::ACTIVE)
            ->find($request->input('doctor_times_id'));
        if (!isset($time)){
            return $this->sendJsonError('Not found time');
        }
        $time->status = Service::NOT_ACTIVE;
        $time->save();
        $model = new Doctors();
        $model->fill($this->getRulesInput($request));
        $model->medical_card_id = $id;
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function editDoctor(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $this->setRules([
            'inference' =>'required|min:5',
            'recommendations'   => 'required|min:5',
            'doctor_times_id' =>'required|integer'
        ]);
        if($this->isValidationFails($request)) {
            return $this->sendJsonError($this->getValidatorErrors());
        }
        $time = Times::query()
            ->where('status',Service::ACTIVE)
            ->find($request->input('doctor_times_id'));
        if (!isset($time)){
            return $this->sendJsonError('Not found time');
        }
        $model = Doctors::query()->find($id1);
        if (!isset($model)){
            return $this->sendJsonError('Not found relation');
        }
        $old_time = Times::query()->find($model->doctor_times_id);
        $old_time->status = Service::ACTIVE;
        $old_time->save();
        $time->status = Service::NOT_ACTIVE;
        $time->save();
        $model->fill($this->getRulesInput($request));
        $model->medical_card_id = $id;
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function delDoctor(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $model = Doctors::query()
            ->where('status',Service::ACTIVE)
            ->where('medical_card_id',$id)
            ->where('doctor_times_id',$id1)
            ->first();
        if (!isset($model)){
            return $this->sendJsonError('Not found doctor');
        }
        $time = Times::query()->find($model->doctor_times_id);
        $time->status = Service::ACTIVE;
        $time->save();
        $model->status = Service::NOT_ACTIVE;
        $model->save();
        return $this->sendJsonOk(['message'=>'Success']);
    }
    public function showDoctor(Request $request,$id,$id1){
        $data = $this->checkData($id,$id1);
        if(isset($data)){
            return $this->sendJsonError($data);
        }
        $model = Doctors::query()
            ->where('medical_card_id',$id)
            ->where('status',Service::ACTIVE)
            ->where('doctor_times_id',$id1)
            ->first();
        if(!isset($model)){
            return $this->sendJsonError('Not found doctor');
        }
        return $this->sendJsonOk(['doctor'=>$model->getInfo()]);
    }
}
