<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use Cachable;

    public $guarded = [];

    public function __toString()
    {
        return $this->name;
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public static function all_as_string($glue)
    {
        try {
            return implode($glue, self::all()->pluck('name')->toArray());
        } catch (\Exception $e) {
            return '';
        }
    }
}
