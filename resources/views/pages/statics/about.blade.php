@extends('shared.namespaces.static')
@section('page') page-about @stop
@section('title'){{ _i("À propos") }}@stop
@section('description'){{ _i("Plus d'informations à propos de %s, les blogueuses, les produits.", [config('app.site_name')]) }}@stop

@section('schema-org')
  @parent

  <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'Organization',
      'name' => config('app.site_name'),
      'url' => config('app.url'),
      'description' => _i('Les meilleures boutiques de mode en ligne Femme et Homme'),
      'logo' => asset('images/logo.svg', is_connection_secure()),
      'sameAs' => [
        config('app.link_to_facebook'),
        config('app.link_to_twitter'),
        config('app.link_to_instagram'),
        config('app.link_to_youtube'),
        config('app.link_to_pinterest'),
        config('app.link_to_wikipedia'),
      ]
    ]) !!}
  </script>
@stop

@section('static_content')

  <div class="container">

    <div class="page-about-background"></div>

    <div class="page-about-content">
      <h1 class="main-heading-title">{{ _i("À propos") }}</h1>
      <p>{!! _i("%s est un moteur de recherche shopping dédié à la mode. Il permet de trouver instantanément les résultats les plus pertinents du web.", [config('app.site_name')]) !!}</p>
      <p>{!! _i("La plateforme a référencé environ 1,6 million de produits Homme et Femme provenant de plus de 10 000 marques. Nous avons effectué plus de 150 partenariats avec les plus grands marchands Européen (La Redoute, Sarenza, Galeries Lafayette…) mais aussi avec de jeunes créateurs Français en exclusivité.") !!}</p>
      <p>{!! _i("4 000 critères (couleurs, taille, coupes, matières, motifs, col, manches, styles...) permettent une navigation rapide sans rechargement des pages d’où un gain de temps considérable pour le visiteur. Des filtres encore jamais vus en France dans le domaine de la mode en ligne.") !!}</p>
      <p>{!! _i("Bienvenue chez %s", [config('app.site_name')]) !!}</p>
    </div>

  </div>

@stop
