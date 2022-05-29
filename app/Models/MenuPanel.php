<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MenuPanel extends Model implements Sortable
{
    const CACHING_TIME_ALL = 21600; // 60*24*15 ( 15 days )

    use Cachable;
    use SortableTrait;

    public $guarded = [];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery()
    {
        return static::query()
      ->where('gender', $this->gender)
      ->where('category', $this->category);
    }

    public static function all_sorted()
    {
        $tuples = [];

        foreach (static::ordered()->get() as $tuple) {
            $tuples[$tuple->category][$tuple->gender][] = $tuple;
        }

        return $tuples;
    }
}
