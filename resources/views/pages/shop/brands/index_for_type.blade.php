@extends('pages.shop.brands.index')

@section('title'){{ _i('Les Top marques %s', ['brand_type' => $data['brand_type']->name]) }}@stop
@section('description'){{ _i("Retrouvez notre top 50 des marques %s les plus en vogue de la « modosphère » ! Recherchez, Comparez, Achetez. Modalova: Vous allez aimer le shopping en ligne.", ['brand_type' => $data['brand_type']->name]) }}@stop
@section('page__title'){{ _i('Top marques %s', ['brand_type' => $data['brand_type']->name]) }}@stop
@section('page__text'){!! strip_tags($data['brand_type']->text, '<br><i><em><strong>') !!}@stop
@section('cta_see_all')<a href="{{ route('get.brands.index_for_type', [
  'brand_type' => $data['brand_type'],
  'all' => true,
]) }}" class="btn btn-black">{{ _i("Voir toutes les marques %s", ['brand_type' => $data['brand_type']->name]) }}</a>@stop
