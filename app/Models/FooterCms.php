<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class FooterCms extends Model
{
    const CACHING_TIME_ALL = 21600; // 60*24*15 ( 15 days )

    use Cachable;

    public $guarded = [];
}
