<?php
namespace App\Modules\VergoInterview\Http\Services;

use App\Modules\VergoBase\Http\Services\Base;

class Interview extends Base
{
    /* @var \App\Modules\VergoInterview\Database\Models\Interviews */
    protected $model;
    protected $modelName = 'App\Modules\VergoInterview\Database\Models\Interviews';
}