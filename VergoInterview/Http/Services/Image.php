<?php
namespace App\Modules\VergoInterview\Http\Services;

use App\Modules\VergoBase\Http\Services\Files;

class Image extends Files
{
    protected $modelName = 'App\Modules\VergoInterview\Database\Models\ResponderCover';
    protected $orderBy = [];
    protected $hasStatus = false;
}