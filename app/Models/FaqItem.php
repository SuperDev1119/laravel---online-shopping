<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class FaqItem extends Model implements Sortable
{
    const CACHING_TIME_ALL = 10080; // 1 week in minutes

    use Cachable;
    use SortableTrait;

    public $guarded = [];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];
}
