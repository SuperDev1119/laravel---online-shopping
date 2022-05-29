@extends('pages.shop.products.category')

@section('page') @parent page-shop-promotions @stop

@php $title = _i("%s %s %s %s", [
  'promotions_title_start' => empty($data['category']) ? (get_current_sales_period() ?: _i('Promotions')) : '',
  'category_title' => ucwords($data['category_title']),
  'promotions_title_end' => empty($data['category']) ? '' : _i('en Promotion'),
  'text_gender' => empty($data['gender']) ? '' : _i('pour %s', ['gender' => ucfirst(_i($data['gender']))]),
]) @endphp

@section('title'){!! $title !!}@stop

@section('description'){{ (get_current_sales_period() ?: _i('Promotions')) . ': ' . _i("Choisissez parmi nos %d %s %s en Solde et en Promotion ⚡️ pour toutes les tailles et toutes vos envies shopping, à partir de %d euros. En exclusivité sur %s", [
  'count' => text_for_seo__count($data),
  'category_title' => text_for_seo__category($data, 'articles'),
  'text_gender' => text_for_seo__gender($data),
  'starting_price' => text_for_seo__price($data),
  'site_name' => config('app.site_name'),
]) }}@stop
