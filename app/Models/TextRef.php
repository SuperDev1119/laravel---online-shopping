<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class TextRef extends Model
{
    const CACHING_TIME_ALL = 10080; // 1 week in minutes

    use Cachable;

    public $guarded = [];
}
