<?php
namespace App\Modules\VergoNews\Http\Services;

use App\Modules\VergoBase\Http\Services\Files;

class Image extends Files
{
    protected $modelName = 'App\Modules\VergoNews\Database\Models\Cover';
    protected $orderBy = [];
    protected $hasStatus = false;
}