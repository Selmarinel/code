<?php
namespace App\Modules\VergoNews\Database\Models;

use App;
use App\Modules\VergoBase\Database\Models\Base;

class ArticleModel extends Base {
    protected $with = [
        'user',
        'category',
        'cover',
        'media',
        'interview'
    ];

    public $timestamps = true;
    protected $table = 'articles';
    protected $fillable = array(
        'user_id',
        'name',
        'info',
        'text',
        'image_id',
        'category_id',
        'is_hot_topic',
        'view',
        'status',
        'media_id',
        'interview_id'
    );

    public function category(){
        return $this->belongsTo('\App\Modules\VergoNews\Database\Models\CategoryModel','category_id');
    }

    /**
     * @return \App\Modules\VergoBase\Database\Models\User
     */
    public function user(){
        return $this->belongsTo('\App\Modules\VergoBase\Database\Models\User','user_id');
    }

    public function cover(){
        return $this->belongsTo('\App\Modules\VergoNews\Database\Models\Cover','image_id');
    }

    public function getCategory(){
        if(!isset($this->category->id) || $this->category->status != self::STATUS_ACTIVE) {
            $this->category = (new CategoryModel())->setDefault();
        }
        return $this->category;
    }

    public function setIsHotTopicAttribute($value){
        $this->attributes['is_hot_topic'] = isset($value);
    }
    public function media(){
        return $this->hasOne('App\Modules\VergoMedia\Database\Models\Media','id','media_id');
    }

    public function getDate($format = 'j M Y'){
        return date($format, strtotime($this->created_at));
    }

    public function comments(){
        return $this->hasMany('App\Modules\VergoComments\Database\Models\Comments','article_id','id')->where('status',self::STATUS_ACTIVE)->orderBy('created_at','desc');
    }

    public function getCountComments(){
        return ($this->comments())? $this->comments()->count() : 0;
    }

    public function updateViews()
    {
        $this->view = ++$this->view;
        self::query()->where('id', $this->id)->update(['view' => $this->view]);
    }

    public function getCover($w = null){
        return ($this->cover) ? $this->cover->getCover($w) : App('logo');
    }

    public function getUser(){
        return (isset($this->user)) ? $this->user : App::make('\App\Modules\VergoBase\Database\Models\User')->setDefault();
    }

    public function getInfo(){
        return [
            'id'        =>  $this->id,
            'cover'     =>  $this->getCover(),
            'name'      =>  $this->name,
            'info'      =>  $this->info,
            'views'     =>  $this->view,
            'category'  =>  $this->category->name,
            'created_at'=>  $this->getDate(),
            'comments'  =>  $this->getCountComments()
        ];
    }

    public function setImageIdAttribute($value){
        if (isset($value)){
            $this->attributes['image_id'] = $value;
        }
    }

    public function interview(){
        return $this->belongsTo('App\Modules\VergoInterview\Database\Models\Interviews','interview_id')->where('status',self::STATUS_ACTIVE);
    }
}
