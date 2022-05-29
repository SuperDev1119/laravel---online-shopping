<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ColorWhiteList extends Pivot
{
    public function color()
    {
        return $this->belongsTo(\App\Models\Color::class);
    }
}
