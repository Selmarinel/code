<?php
namespace App\Modules\VergoInterview\Http\Services;

use App\Modules\VergoBase\Http\Services\Base;

class Responder extends Base
{
    /* @var \App\Modules\VergoInterview\Database\Models\Responders */
    protected $model;
    protected $modelName = 'App\Modules\VergoInterview\Database\Models\Responders';
    protected $hasStatus = false;
    protected $orderBy = [];
}