<?php

namespace App\Modules\VergoInterview\Database\Models;

use App\Modules\VergoBase\Database\Models\Base;

class InterviewsDialogs extends Base {
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
    protected $table = 'interview_dialogs';

    public $timestamps = false;

    protected $fillable = array('interview_id', 'question','answer','status');

    public function getShortField($field){
        $text = mb_substr(strip_tags($this->$field), 0, 40, 'UTF-8');
        return (strlen($text) < strlen($this->$field)) ? $text . '...' : $this->$field;
    }

    public function interview(){
        return $this->hasOne('App\Modules\VergoInterview\Database\Models\Interviews','id','interview_id');
    }

    public function getName(){
        return ($this->interview) ? $this->interview->article->name : trans('vergo_base::main.status_delete');
    }
}
