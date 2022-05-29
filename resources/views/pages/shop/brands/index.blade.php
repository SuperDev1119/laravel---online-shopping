@php
$title = _i('Top des marques');
@endphp

@extends('shared.namespaces.base')

@section('title'){{ $title }}@stop
@section('description'){{ _i("Retrouvez notre top 50 des marques les plus en vogue de la « modosphère » ! De ASOS à Mango en passant par ETAM et Max Mara, nous vous sélectionnons le meilleur du web pour faciliter votre shopping en ligne.") }}@stop
@section('page') page-shop page-grid page-marques-index @stop
@section('seo')<meta name="robots" content="INDEX,FOLLOW">@stop

@section('content')
<div class="full-width">
  <div class="container brands-top brand-container">
    <div class="col-md-8 col-md-offset-2">
      <h1 class="brands-top__title">@section('page__title'){{ $title }}@show</h1>
      <p class="brands-top__text">@section('page__text'){!! _i("Retrouvez notre top 50 des marques les plus en vogue de la « modosphère » ! De Nike à Levi's en passant par Michael Kors, nous vous sélectionnons chaque jour nos meilleures idées shopping pour faciliter votre recherche. Vous préférez une autre marque ? Nous vous proposons des sélections parmi plus de 10,000 marques sur le site, et nous mettons tout en oeuvre pour en découvrir des nouvelles et vous les proposer. Toutes vos envies ont une adresse : <a href=%s>%s</a>.", [
      'site_url' => config('app.url'),
      'site_name' => config('app.site_name'),
      ]) !!}@show</p>
    </div>

    <div class="container brand-section">
      <ul class="brands--list">
        @foreach($data['brands'] as $brand)
          <li><a href="{{ route('get.products.byBrand', ['brand' => $brand->slug]) }}">{{ $brand }}</a></li>
        @endforeach
      </ul>
    </div>

    <p class="text-center">
      @section('cta_see_all')<a href="{{ route('get.brands.index', ['all' => true]) }}" class="btn btn-black">{{ _i("Voir toutes les marques") }}</a>@show
    </p>

  </div>
</div>
@stop
