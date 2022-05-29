@extends('pages.shop.products.grid', [
  'title' => vsprintf("%s %s %s %s", [
    text_for_seo__category($data, ''),
    text_for_seo__brand($data),
    empty($data['color']) ? '' : ucfirst($data['color']),
    text_for_seo__gender($data),
  ]),
  'description' => _i('Découvrez en exclusivité nos %4$s %2$s %3$s. Une sélection de %1$d articles pour toutes les tailles et toutes vos envies shopping, à partir de %5$d euros, seulement sur %6$s.', [
    'count' => text_for_seo__count($data),
    'brand_name' => text_for_seo__brand($data),
    'text_gender' => text_for_seo__gender($data),
    'category_title' => text_for_seo__category($data),
    'starting_price' => text_for_seo__price($data),
    'site_name' => config('app.site_name'),
  ])
])
