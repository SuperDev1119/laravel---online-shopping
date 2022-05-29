@extends('shared.namespaces.static')
@section('page') page-faq @stop
@section('title'){{ _i("Foire aux questions") }}@stop
@section('description'){{ _i("Une question ? Ici, vous êtes au bon endroit pour trouver la réponse.") }}@stop

@section('static_content')
  <div class="container">

    <div class="static-main-heading">
      <h1 class="static-title">@yield('title')</h1>
      <h2 class="static-subtitle">@yield('description')</h2>
    </div>

    @cache('pages.shop.partials._faq', null, App\Models\FaqItem::CACHING_TIME_ALL)

  </div>

@stop
