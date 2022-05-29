@extends('pages.shop.products.grid', [
  'title' => vsprintf("%s %s %s", [
    text_for_seo__category($data),
    empty($data['color']) ? '' : ucfirst($data['color']),
    text_for_seo__gender($data),
  ]),
  'description' => _i("Choisissez parmi nos %d %s %s pour toutes les tailles et toutes vos envies shopping, à partir de %d euros, uniquement sur %s.", [
    'count' => text_for_seo__count($data),
    'category_title' => text_for_seo__category($data),
    'text_gender' => text_for_seo__gender($data),
    'starting_price' => text_for_seo__price($data),
    'site_name' => config('app.site_name'),
  ]),
])

@section('page') @parent page-shop-category page-shop-category-{{ @$data['gender'] }} @stop
