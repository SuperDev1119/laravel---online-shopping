@extends('shared.namespaces.base')

@section('title'){{ _i('Page non trouvée') }}@stop
@section('page') page-error page-error-404 @stop

@section('categories-aside-inner')
  {{ _i('Aucun produit trouvé') }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="page-404 shop-products">
        <div class="col-xs-12">

          @include('pages.shop.partials._404')

        </div>
      </div>
    </div>
  </div>
@stop
