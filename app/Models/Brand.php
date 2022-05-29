<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Cachable;
    use Sluggable;

    public $syncDocument = false;

    public function buildDocument()
    {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'slug' => $this->slug,
            'gender' => $this->gender,
            'is_top' => $this->is_top,
            'in_listing' => $this->in_listing,
            'display_name' => $this->display_name,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public $guarded = [];

    protected $attributes = [
        'gender' => Gender::GENDER_BOTH,
        'is_top' => false,
        'in_listing' => false,
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'unique' => false,
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->display_name;
    }

    public function isPublic()
    {
        return $this->in_listing || $this->is_top;
    }

    public function save(array $options = [])
    {
        if (empty($this->display_name)) {
            $this->display_name = $this->name;
        }
        if ($this->is_top) {
            $this->in_listing = true;
        }

        return parent::save($options);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeAll_listing($query)
    {
        return $query->all_top()->orWhere('in_listing', true);
    }

    public function scopeAll_top($query)
    {
        return $query->where('is_top', true)->orderBy('name', 'asc');
    }

    public function brand_type()
    {
        return $this->belongsTo(\App\Models\BrandType::class);
    }

    public static function boot()
    {
        parent::boot();

        self::updated(function ($that) {
            if ($that->isPublic()) {
                \App\Jobs\UpdateWhiteList::dispatch($that);
            }
        });
    }
}
