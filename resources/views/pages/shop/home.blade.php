@extends('shared.namespaces.base')

@section('page') page-home page-inspirations page-lookbooks-index @stop
@section('description'){{ _i("Découvrez en exclusivité chez %s plus de 2 000 000 produits mode grâce à nos 10 000 marques partenaires. Les meilleurs articles mode Femme et Homme sélectionnés pour vous.", [
  'site_name' => config('app.site_name'),
]) }}@stop
@section('seo')<link rel="canonical" href="{{ route('home') }}" />@stop

@section('metas')
  <meta property="og:image"               content="{{ asset('images/modalova.jpg', is_connection_secure()) }}" />
  <meta property="og:image:type"          content="image/jpeg" />
  <meta property="og:image:width"         content="1200" />
  <meta property="og:image:height"        content="630" />
  <meta property="og:image:alt"           content="@yield('title')" />
  <meta property="og:type"                content="website" />

  <meta name="twitter:card"               content="summary_large_image">
  <meta name="twitter:image"              content="{{ asset('images/modalova.jpg', is_connection_secure()) }}" />
@stop

@section('schema-org')
  @parent

  <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'WebSite',
      'name' => config('app.site_name'),
      'url' => config('app.url'),
      'potentialAction' => [[
        '@type' => 'SearchAction',
        'target' => [
          '@type' => 'EntryPoint',
          'urlTemplate' => route('get.products.search') . '/?q={search_term_string}',
        ],
        'query-input' => 'required name=search_term_string',
      ]],
    ]) !!}
  </script>
@stop

@section('content')
  <div class="main-heading-banner">
    <div class="container content-propal">

      <h1 class="main-heading-title">{!! wordwrap(_i('Le Meilleur site de Shopping en Ligne'), 30, '<br class="hidden-xs"> ') !!}</h1>
      <div class="main-heading-content">
        <div class="page-inspiration-intro">
          <div class="page-inspiration-intro-cta">
            <a class="btn btn-black" href="{{ get_magic_route(['gender' => App\Models\Gender::GENDER_FEMALE]) }}" alt="{{ _i("Voir tous nos produits mode Femme | %s", ['site_name' => config('app.site_name'),]) }}">{{ _i(App\Models\Gender::GENDER_FEMALE) }}</a>
            <a class="btn btn-black" href="{{ get_magic_route(['gender' => App\Models\Gender::GENDER_MALE]) }}" alt="{{ _i("Voir tous nos produits mode Homme | %s", ['site_name' => config('app.site_name'),]) }}">{{ _i(App\Models\Gender::GENDER_MALE) }}</a>

            <a class="btn btn-white" style="display: block; margin: 1.5em auto 0" href="{{ route('get.brands.index') }}" alt="{{ _i("Voir toutes nos marques | %s", ['site_name' => config('app.site_name'),]) }}">{{ _i("Nos Marques") }}</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="full-bg-grey">

    <div class="box-home box-home--assurance container">
      <div class="box-home--assurance--content col-md-4 col-sm-12 col-xs-12">
        <div class="box-home--assurance--content--block">
          <img src="{{ base64_asset('images/first-rea-bloc.svg') }}" alt="" />
          <h2>{{ _i("+ 2 000 000 Produits") }}</h2>
          <p>{!! _i("Chaque jour, des centaines<br class='hidden-xs hidden-sm'/> de nouveautés") !!}</p>
        </div>
      </div>

      <div class="box-home--assurance--content col-md-4 col-sm-12 col-xs-12">
        <div class="box-home--assurance--content--block">
          <img src="{{ base64_asset('images/second-rea-bloc.svg') }}" alt="" />
          <h2>{{ _i("+ 10 000 Marques") }}</h2>
          <p>{!! _i("Boutiques en ligne<br class='hidden-xs hidden-sm'/> testées et certifiées") !!}</p>
        </div>
      </div>

      <div class="box-home--assurance--content col-md-4 col-sm-12 col-xs-12">
        <div class="box-home--assurance--content--block">
          <img src="{{ base64_asset('images/third-rea-bloc.svg') }}" alt="" />
          <h2>{{ _i("Meilleur prix") }}</h2>
          <p>{!! _i("Seules les meilleures<br class='hidden-xs hidden-sm'/> offres proposées") !!}</p>
        </div>
      </div>
    </div>

    <div class="box-home box-home--partners container hidden-xs hidden-sm">
      <div class="box-home--partners--content">
        <img src="{{ asset('images/logo-acceuil.jpg', is_connection_secure()) }}"
          alt="{{ _i("Plus de 10 000 marques") }} - {{ config('app.site_name') }}" class="img-responsive">
      </div>
    </div>

    <div class="box-home box-home--intro container">
      <h2 class="text-center">{{ config('app.site_name') }}</h2>
      <div class="box-home--intro--content">
        <h3 class="text-center">{!! _i("Modalova, c'est votre nouveau site favori pour le shopping en ligne 😉") !!}</h3>
        <p class="text-justify">{!! _i("<u>Notre mission</u>&nbsp;: rassembler sur un seul site, le meilleur de la mode Homme et Femme afin de <strong>simplifier votre expérience shopping en ligne</strong>. Fini les 35 onglets ouverts pour trouver la pièce qu'il vous faut. Fini les 50 applications à télécharger pour trouver un produit à la bonne taille.<br><br>Modalova, c'est simplement la meilleure offre du web&nbsp;: plus de 2,000,000 articles pour Homme et Femme, rassemblés sur seul site. Ce sont les catalogues de plus de 10,000 marques partenaires, que nous regroupons sur notre site, afin de vous proposer, chaque jour, des produits de qualité et au meilleur prix.") !!}<br><br></p>
      </div>
    </div>

    @unless(empty($data['blog_articles']))
      @include('pages.shop.partials._last_blog_articles')
    @endif

    @cache('pages.shop.partials._push_linking', null, App\Models\PushLinking::CACHING_TIME_ALL)
    @cache('pages.shop.partials._last_text_refs', null, App\Models\TextRef::CACHING_TIME_ALL)

  </div>
@stop
