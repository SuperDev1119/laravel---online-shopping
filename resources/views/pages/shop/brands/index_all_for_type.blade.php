@extends('pages.shop.brands.index_all')

@section('title'){{ _i('Toutes les marques %s', ['brand_type' => $data['brand_type']->name]) }}@stop
@section('page__title'){{ _i('Toutes les marques %s', ['brand_type' => $data['brand_type']->name]) }}@stop
@section('page__text'){!! strip_tags($data['brand_type']->text, '<br><i><em><strong>') !!}@stop
@section('description'){{ _i("Plus de 10,000 Marques %s à découvrir faire votre shopping en ligne. Recherchez, Comparez, Achetez. Modalova: Vous allez aimer le shopping en ligne.", ['brand_type' => $data['brand_type']->name]) }}@stop
