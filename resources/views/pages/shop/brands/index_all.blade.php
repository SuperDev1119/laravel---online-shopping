@extends('shared.namespaces.base')

@section('title'){{ _i('Toutes les marques') }}@stop
@section('description'){{ _i("Plus de 10,000 Marques partenaires à découvrir en ligne. Retrouvez toutes nos marques, Homme et Femme, de AllSaints à Shein en passant par Sandro et The Kooples, nous vous sélectionnons le meilleur du web pour faciliter votre shopping en ligne.") }}@stop
@section('page') page-shop page-grid page-marques-index page-marques-index-all @stop
@section('page__text'){!! _i("Faites votre shopping chez toutes les marques de la « modosphère » sur un seul site ! De Nike à Levi's en passant par Michael Kors, nous vous sélectionnons chaque jour nos meilleures idées shopping pour faciliter votre recherche. Vous préférez une autre marque ? Nous vous proposons des sélections parmi plus de 10,000 marques sur le site, et nous mettons tout en oeuvre pour en découvrir des nouvelles et vous les proposer.") !!}@stop

@section('content')
<div class="full-width">
  <div class="container brands-top brand-container">

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h1 class="brands-top__title">@section('page__title'){{ _i('Toutes les marques') }}@show</h1>
        <p class="brands-top__text">@section('page__text')@show</p>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-md-8 col-md-offset-2">
        <div class="brand-index--letters">
          @foreach($data['brands_by_letter'] as $letter => $brands)
            <a href="#{{ $letter }}" class="brand-index--letter">{{ $letter }}</a>
          @endforeach
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">

        @foreach($data['brands_by_letter'] as $letter => $brands)
          <div class="brand-section brand-section--letter">
            <div id="{{ $letter }}"></div>
            <h2>{{ $letter }}</h2>
            <ul class="brands--list">
              @foreach($brands as $brand)
                <li
                  class="brands--list__item @if($brand->is_top) brands--list__item--is-top @endif"
                  ><a href="{{ route('get.products.byBrand', ['brand' => $brand->slug]) }}">{{ $brand }}</a></li>
              @endforeach
            </ul>
          </div>
        @endforeach

      </div>
    </div>

  </div>
@stop
