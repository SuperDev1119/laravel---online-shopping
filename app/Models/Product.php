<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Product extends Model implements Feedable
{
    const FACET_SEPARATOR = '|';

    public $guarded = [];

    public $primaryKey = 'slug';

    public $incrementing = false;

    public $timestamps = false;

    public function toFeedItem($category = null): FeedItem
    {
        $date = Carbon::now();
        $app_name = config('app.site_name');

        return FeedItem::create([
            'id' => $this->slug,
            'slug' => $this->slug,

            'title' => ($this->name ?: $this->slug).' - '.$this->brand_original,
            'summary' => $this->brand_original.' - '.$this->description,
            'image' => $this->image_url,
            'updated' => $date,
            'link' => route('get.products.product', ['product' => $this]),
            'authorName' => $this->brand_original.' x '.$app_name,

            'price' => $this->price,
            'currency' => $this->currency_original,
            'brand' => $this->brand_original,
            'gender' => $this->gender,
            'color' => $this->color,
            'material' => $this->material,
            'size' => $this->size,

            'category' => [$category],
        ]);
    }

    public function buildDocument()
    {
        return [
            'i' => $this->i,

            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'brand_original' => $this->brand_original,
            'merchant_original' => $this->merchant_original,
            'currency_original' => $this->currency_original,
            'category_original' => $this->category_original,
            'color_original' => $this->color_original,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'reduction' => $this->reduction,
            'url' => $this->url,
            'image_url' => $this->image_url,
            'gender' => $this->gender,
            'provider' => $this->provider,
            'col' => $this->col,
            'coupe' => $this->coupe,
            'manches' => $this->manches,
            'material' => $this->material,
            'model' => $this->model,
            'motifs' => $this->motifs,
            'event' => $this->event,
            'style' => $this->style,
            'size' => $this->size,
            'livraison' => $this->livraison,

            // 'payload' => $this->payload,

            'sizes' => $this->sizes(),
            'cols' => $this->cols(),
            'colors' => $this->colors(),
            'categories' => $this->categories(),
            'coupes' => $this->coupes(),
            'manchess' => $this->manchess(),
            'materials' => $this->materials(),
            'models' => $this->models(),
            'motifss' => $this->motifss(),
            'events' => $this->events(),
            'styles' => $this->styles(),
        ];
    }

    public function __toString()
    {
        return $this->name ?: '';
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sizes()
    {
        return $this->handle_multi_facet('size');
    }

    public function colors()
    {
        return $this->handle_multi_facet('color_original');
    }

    public function categories()
    {
        return $this->handle_multi_facet('category_original');
    }

    public function cols()
    {
        return $this->handle_multi_facet('col');
    }

    public function coupes()
    {
        return $this->handle_multi_facet('coupe');
    }

    public function manchess()
    {
        return $this->handle_multi_facet('manches');
    }

    public function materials()
    {
        return $this->handle_multi_facet('material');
    }

    public function models()
    {
        return $this->handle_multi_facet('model');
    }

    public function motifss()
    {
        return $this->handle_multi_facet('motifs');
    }

    public function events()
    {
        return $this->handle_multi_facet('event');
    }

    public function styles()
    {
        return $this->handle_multi_facet('style');
    }

    private function handle_multi_facet($attribute_name, $separator = self::FACET_SEPARATOR)
    {
        return array_values(array_filter(explode($separator, $this->$attribute_name), function ($v) {
            return ! empty($v);
        }));
    }
}
