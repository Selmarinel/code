<?php
namespace App\Modules\VergoInterview\Http\Services;

use App\Modules\VergoBase\Http\Services\Base;

class InterviewDialogs extends Base
{
    /* @var \App\Modules\VergoInterview\Database\Models\InterviewsDialogs */
    protected $model;
    protected $modelName = 'App\Modules\VergoInterview\Database\Models\InterviewsDialogs';
    protected $hasStatus = false;
    protected $orderBy = [];
}