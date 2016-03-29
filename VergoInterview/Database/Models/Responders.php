<?php

namespace App\Modules\VergoInterview\Database\Models;

use App\Modules\VergoBase\Database\Models\Base;

class Responders extends Base {
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
    protected $table = 'responders';

    public $timestamps = false;

    protected $fillable = array('first_name', 'last_name', 'position', 'cover_id');

    public function cover(){
        return $this->belongsTo('App\Modules\VergoInterview\Database\Models\ResponderCover','cover_id');
    }

    public function getCover($w = null){
        return ($this->cover) ? $this->cover->getCover($w) : App('logo');
    }

    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name;
    }

}
