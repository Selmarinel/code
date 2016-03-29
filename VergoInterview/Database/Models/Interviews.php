<?php

namespace App\Modules\VergoInterview\Database\Models;

use App\Modules\VergoBase\Database\Models\Base;

class Interviews extends Base {
    protected $with = [
        'responder',
        'dialogs'
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interviews';

    public $timestamps = true;

    protected $fillable = array('status', 'responder_id');

    public function responder(){
        return $this->belongsTo('App\Modules\VergoInterview\Database\Models\Responders','responder_id');
    }

    public function dialogs(){
        return $this->hasMany('App\Modules\VergoInterview\Database\Models\InterviewsDialogs','interview_id','id')->where('status',self::STATUS_ACTIVE);
    }

    public function countDialogs(){
        return ($this->dialogs()) ? $this->dialogs()->count() : 0;
    }

    public function article(){
        return $this->hasOne('App\Modules\VergoNews\Database\Models\ArticleModel','interview_id','id');
    }
}
