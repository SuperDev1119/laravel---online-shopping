<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class GoogleProductCategory extends Model
{
    use Cachable;

    public $guarded = [];
}
