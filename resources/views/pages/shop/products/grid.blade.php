@extends('shared.namespaces.base')

<?php
  $price_min = round(@$data['aggs']['price_min']['value']);
  $price_max = round(@$data['aggs']['price_max']['value']);
?>

@section('page') page-shop page-grid page-shop-products @stop

@section('title'){{ clean_for_html(@$title ?: _i("Tous les produits %s", [
  'text_gender' => text_for_seo__gender($data),
])) }}@stop

@section('description'){!! clean_for_html(Str::limit(@$data['ref_text']->text, 160) ?: @$description ?: _i("Choisissez parmi nos %d produits %s, pour toutes les tailles et toutes vos envies shopping, à partir de %d euros, seulement sur %s.", [
  'count' => text_for_seo__count($data),
  'text_gender' => text_for_seo__gender($data),
  'starting_price' => text_for_seo__price($data),
  'site_name' => config('app.site_name'),
])) !!}@stop

@section('preload')
  @if($first_product = @$data['products']['data'][0])
    <link rel="preload" as="image"
      href="{{ show_product_image($first_product, true, true) }}"
      imagesrcset="
        {{ \App\Libraries\Cloudinary::get($first_product['image_url'], '0x150', $first_product['slug']) }} 150w,
        {{ \App\Libraries\Cloudinary::get($first_product['image_url'], '0x350', $first_product['slug']) }} 350w,
        {{ \App\Libraries\Cloudinary::get($first_product['image_url'], '0x400', $first_product['slug']) }} 400w,
        {{ show_product_image($first_product, true, true) }} 500w"
      imagesizes="(max-width: 720px) 50vw, 25vw">
  @endif
@stop

@section('schema-org')
  @parent

  <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'ItemList',
      'itemListElement' => array_map(function($product) {
        static $index = 1;
        return [
          '@type'     => 'ListItem',
          'position'  => $index ++,
          'item' => [
            '@type'         => 'Product',
            'url'           => route('get.products.product', ['product' => $product['slug']]),
            'gtin'          => $product['slug'],
            'sku'           => $product['slug'],
            'name'          => $product['name'] ?: $product['brand_original'],
            'description'   => $product['description'] ?: config('app.name'),
            'image'         => [
              show_product_image_for_google($product),
            ],
            'brand' => [
              '@type'         => 'Brand',
              'name'          => $product['brand_original'],
              'url'           => route('get.products.byBrand', ['brand' => \Slugify::slugify($product['brand_original'])]),
            ],
            'offers' => [
              '@type'         => 'Offer',
              'url'           => route('get.products.product', ['product' => $product['slug']]),
              'availability'  => 'https://schema.org/InStock',
              'price'         => $product['price'],
              'priceCurrency' => $product['currency_original'],
            ]
          ]
        ];
      }, array_slice($data['products']['data'], 0, 10))
      ]) !!}
  </script>
@stop

@section('javascripts')
  <script>var QUERY_PARAMS = {!! json_encode(@$data['query_params']) !!};</script>
  <script>var VIEW_PARAMS = {!! json_encode([
    'hitsOnFirstPage' => $data['hitsOnFirstPage'],
    'totalProducts' => $data['products']['total']['value'],
    'aggs' => @$data['aggs'],
    'route' => @$data['route'],
    'facets' => @$data['facets'],
  ]) !!};</script>
  <script>var CATEGORY_PATH = {!! json_encode(isset($data['category']) ?
    $data['category']->getAncestors()->map(function($v) {
      return $v->slug;
    }) : []) !!};</script>

  @parent
@stop

@section('templates')
  @parent

  @include('shared.templates.grid.product-thumb')
  @include('shared.templates.grid.filter')
  @include('shared.templates.grid.filter--price')
  @include('shared.templates.grid.no-results')
@stop

@section('seo')
  <link rel="canonical" href="{{ $data['urls']['canonical'] }}" />
  @if($data['urls']['prev']) <link rel="prev" href="{{ $data['urls']['prev'] }}"> @endif
  @if($data['urls']['next']) <link rel="next" href="{{ $data['urls']['next'] }}"> @endif
@stop

@section('metas')
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ $data['urls']['canonical'] }}" />
  <meta itemprop="url" content="{{ $data['urls']['canonical'] }}" />

  @if($product = @$data['products']['data'][0])
    <meta property="og:image"               content="{{ show_product_opengraph_image($product) }}" />
    <meta property="og:image:type"          content="image/jpeg" />
    <meta property="og:image:width"         content="1200" />
    <meta property="og:image:height"        content="630" />
    <meta property="og:image:alt"           content="{{ alt_for_product_image($product) }}" />

    <meta name="twitter:card"               content="summary_large_image" />
    <meta name="twitter:image"              content="{{ show_product_opengraph_image($product) }}" />
  @endif

  @parent
@stop

@section('robots')
  @if($robots_meta_tags = get_robots_meta_tags($data))
    <meta name="robots" content="{{ $robots_meta_tags['content'] }}" data-reason="{{ $robots_meta_tags['reason'] }}">
  @endif
@stop

@section('post__footer-nav')
  <div itemscope="" itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating" style="margin: 1em auto 2em; font-size: .9em">
    {{ _i("Nos clients nous font confiance, retrouvez la note de Google de ") }}
    <span itemscope="" itemprop="itemReviewed" itemtype="https://schema.org/Organization">
      <span itemprop="name" content="{{ config('app.site_name') }}">{{ config('app.site_name') }}</span>
    </span> : <span itemprop="ratingValue">4.5</span> / <span itemprop="bestRating">5</span> {{ _i("étoiles") }}
    (<a rel="noopener" href="https://www.google.com/search?q={{ config('app.site_name') }}" target="_blank"><span itemprop="ratingCount">12</span> {{ _i("notes") }}</a>)
  </div>
@stop

@section('content')
  @section('content_heading')
    <div class="full-bg-grey">
      <div class="main-heading-banner--grid">
        @section('content_heading_top')

          <div class="row">
            <div class="col-xs-12">
              <div class="main-heading-content">

                <div class="title-content text-center">
                  <div class="main-heading-title">
                    <h1>@section('content_heading__h1')@yield('title')@show</h1>
                  </div>

                  @if(isset($data['products']['code']) && $data['products']['code'] == 404)
                    <span>{{ _i("Aucun produit trouvé") }}</span>
                  @endif
                </div>

              </div>
            </div>
          </div>

          <div class="row">

            <div class="col-lg-10 col-md-8 col-xs-12">
              @section('breadcrumb')
                <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                  @cache('pages.shop.partials._breadcrumb', [
                    'brand' => @$data['brand'],
                    'gender' => @$data['gender'],
                    'category' => @$data['category'],
                    'promotion' => @$data['promotion'],
                    'color' => @$data['color'],
                  ], null, create_cache_key(@$data['brand'], @$data['gender'], @$data['category'], @$data['promotion'], @$data['color']))
                </ul>
              @show
            </div>

            <div class="col-lg-2 col-md-4 col-xs-12 no-padding">
              <div class="text-right">
                <div class="filter--sort"><select id="sort-by" disabled>
                  <option selected disabled hidden>{{ _i("Trier par") }}</option>
                  <option value="{}">{{ _i('Nouveautés') }}</option>
                  <option value="{{ json_encode(['price' => 'asc']) }}">{{ _i('Prix croissant') }}</option>
                  <option value="{{ json_encode(['price' => 'desc']) }}">{{ _i('Prix décroissant') }}</option>
                </select></div>
              </div>
            </div>

          </div>

        @show
      </div>
    </div>
  @show

  <div class="full-bg-grey full-width">

    <div class="container">

      <div class="row shop-products">

        @section('aside')
          <aside class="shop-products-aside col-lg-2 col-md-3 col-sm-3 col-xs-12">
            <div class="aside-container">

              @section('aside_filters')
                @section('aside_filter_clear')
                  <div id="clear-all-filters"></div>
                @show

                @section('aside_filter_prepend')
                  @cache('pages.shop.partials.aside._categories', [
                      'current_brand' => @$data['brand'],
                      'current_gender' => @$data['gender'],
                      'current_category' => @$data['category'],
                    ],
                    7200,
                    create_cache_key(@$data['brand'], @$data['gender'], @$data['category'], @$data['promotion'], @$data['color'])
                  )
                @show

                @section('aside_ref_text')
                  @if( !empty(@$data['ref_text']->text) )
                    <div class="aside-section aside-section-ref-text filter--section filter--section--no-shadow active">
                      <div class="filter--section--header">
                        <span class="aside-section-close filters--section--close"><div><h2 class="aside-section-label">@yield ('title')</h2></div></span>
                      </div>
                      <div class="aside-section-content filter--section--body"><div>{!! clean_for_html($data['ref_text']->text, ['p','a','br']) !!}</div></div>
                    </div>
                  @endif
                @show

                @section('aside_associated_searches')
                  @cache('pages.shop.partials.aside._associated_searches', [
                      'current_brand' => @$data['brand'],
                      'current_gender' => @$data['gender'],
                      'current_category' => @$data['category'],
                      'current_promotion' => @$data['promotion'],
                    ],
                    43800,
                    create_cache_key(@$data['brand'], @$data['gender'], @$data['category'], @$data['promotion'], @$data['color'])
                  )
                @show

              @show

            </div>
          </aside>
        @show

        <div
          id="shop-products-grid--wrapper"
          class="@section('grid-products-classes') col-lg-10 col-md-9 col-sm-9 col-xs-12 no-padding @show">

          <div id="filters" class="hidden">

            <label id="toggle-filters" for="toggle-filters__input" class="filter ais-root ais-refinement-list filter--section filter--section--no-shadow">
              <div class="ais-refinement-list--header ais-header filter--section--header">
                <span class="filters--section--close">
                  <div>
                    <span class="filters--section--label">{{ _i('Afficher les filtres') }}</span>
                  </div>
                </span>
              </div>
            </label>

            <input type="checkbox" id="toggle-filters__input" />

            @if(!empty($data['products']['data']))
              <div id="filter-price" class="filter"></div>
            @endif

            @foreach($data['facets'] as $facet => $values)
              <?php $facet_name = $data['facetsConfiguration'][$facet]; ?>

              @section('aside_filter_' . $facet)
                <div id="filter-{{ $facet }}" class="filter">
                  <div class="ais-root ais-refinement-list filter--section">
                    <div class="ais-refinement-list--header ais-header filter--section--header">
                      <span class="filters--section--close">
                        <div>
                          <span class="filters--section--label">{{ _i('filters__' . $facet) }}</span>
                        </div>
                      </span>
                    </div>

                    <div class="ais-body ais-refinement-list--body filter--section--body">
                      <div class="ais-refinement-list--list filter--section--list nested-list">

                        @if('colors' === $facet && !empty($data['brand']))
                          @if($white_list = $data['white_list'])
                            @forelse($white_list->colors as $color)
                              <li><a href="{{ $white_list->getRoute(['color' => $color->name]) }}">{{ $white_list->toString($color) }} <small>({{ $color->pivot->amount }})</small></a></li>
                              @empty
                                {{ _i('Pas de résultat') }}
                              @endforelse
                            @else
                              {{ _i('Pas de résultat') }}
                          @endif
                        @else
                          {{ _i('Pas de résultat') }}
                        @endif

                      </div>
                    </div>
                  </div>
                </div>
              @show

            @endforeach
          </div>

          @if(empty($data['products']['data']))
            @include('pages.shop.partials._404')
          @else

          <div id="shop-products-grid" class="shop-products-grid shop-products-grid--page--{{ $data['products_paginated']->resolveCurrentPage() }}">

            <div class="bloc-must-have product-thumb grid-columns">
              <div class="must-have-container">
                <div class="must-have-content">
                  <span class="must-have-title">Must<br/>have</span><br/>
                  @if( empty($data['category']) )
                    <span class="must-have-category">{{ _i("Tous les produits") }}</span>
                  @else
                    <span class="must-have-category">{{ $data['category']->title }}</span>
                  @endif
                </div>
              </div>
            </div>

            @foreach($data['products']['data'] as $index => $product)
              @include('pages.shop.partials._grid_product', [
                'product' => $product,
                'index' => $index,
                'is_on_first_page' => $index < $data['hitsOnFirstPage'],
                ])
            @endforeach

          </div>

          <div id="pagination" class="pagination-for-grid center-block text-center">
            {{ $data['products_paginated']->links() }}
          </div>

          <p id="amount-of-products-found">
            {{ _i('gte' == $data['products']['total']['relation'] ? 'Plus de %s produits' : '%s produits', [
            number_format($data['products']['total']['value'], 0, '.', ' ')
            ]) }} {!! _i(' <small>(de <span>%s</span> à %s)</small>', [
              $price_min . ' ' . config('app.currency_sign'),
              $price_max . ' ' . config('app.currency_sign'),
            ]) !!}
          </p>

          @endif
        </div>

      </div>
    </div>

  </div>

@stop
