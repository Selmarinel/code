<?php

namespace App\Modules\VergoNews\Database\Models;

use App\Modules\VergoBase\Database\Models\Base;

class CategoryModel extends Base
{
    protected $table = 'categories';
    public $timestamps = false;
    protected $perPage = 15;
    const COLOR = '000000';
    protected $fillable = array(
        'color',
        'name',
        'is_main',
        'status'
    );

    public function setColorAttribute($value){
        $this->attributes['color'] = str_replace('#', '' , $value);
    }

    public function getColorAttribute($value){
        return '#' . $value;
    }

    public function setDefault(){
        $this->id       = 0;
        $this->color    = self::COLOR;
        $this->name     = '-';
        return $this;
    }

    public function getColor(){
        return ($this->color != '#') ? $this->color : $this->setDefault()->color;
    }
}
