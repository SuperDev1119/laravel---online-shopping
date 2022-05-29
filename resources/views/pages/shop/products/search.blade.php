@extends('pages.shop.products.grid', [
  'title' => _i('Résultats de la recherche “%s”%s', [
    $data['query'],
    @$data['brand'] ? _i(" pour la marque “%s“", [$data['brand']]) : '',
  ]),
  'description' => _i("Résultats de votre recherche “%s”: %d produits trouvés à partir de %d euros, uniquement sur %s.", [
    'query' => $data['query'],
    'count' => text_for_seo__count($data),
    'starting_price' => text_for_seo__price($data),
    'site_name' => config('app.site_name'),
  ]),
])

@section('page') @parent page-shop-category page-shop-category-search @stop

@section('aside')@stop
@section('grid-products-classes') col-xs-12 no-padding @stop

@section('breadcrumb')@stop
