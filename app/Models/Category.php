<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    const CACHING_TIME_ALL = 21600; // 60*24*15 ( 15 days )

    const QUERY_SEPARATOR = ',';

    use NodeTrait, Sluggable {
    NodeTrait::replicate as replicateNode;
    Sluggable::replicate as replicateSlug;
  }

    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    public $guarded = [];

    public $attributes = [
        'gender' => Gender::GENDER_BOTH,
    ];

    public function __toString()
    {
        return $this->title;
    }

    public function getQuery()
    {
        return trim($this->title.self::QUERY_SEPARATOR.$this->query, self::QUERY_SEPARATOR);
    }

    public function getQueryAsArray()
    {
        return array_unique(array_map('trim', explode(self::QUERY_SEPARATOR, $this->getQuery())));
    }

    public function save(array $options = [])
    {
        if (null == $this->parent_id) {
            $this->depth = 0;
        } else {
            $this->depth = $this->parent->depth + 1;
        }

        return parent::save($options);
    }

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'title']];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function isEqualOrChildren($category)
    {
        if (null === $category) {
            return false;
        }
        if ($this->slug === $category->slug) {
            return true;
        }

        return $this->getAncestors()->contains($category);
    }

    public function google_product_category()
    {
        return $this->belongsTo(\App\Models\GoogleProductCategory::class);
    }
}
