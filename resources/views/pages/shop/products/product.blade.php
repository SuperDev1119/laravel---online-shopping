@extends('shared.namespaces.base')

@section('title'){{ Str::limit($data['product']['name'], 60) }}@stop
@section('page') page-shop-product @stop
@section('description'){{ Str::limit($data['product']['description'], 160) }}@stop
@section('seo')<link rel="canonical" href="{{ URL::current() }}" />@stop

@section('metas')
  <meta property="og:type"                content="product" />

  <meta property="og:image"               content="{{ show_product_opengraph_image($data['product']) }}" />
  <meta property="og:image:type"          content="image/jpeg" />
  <meta property="og:image:width"         content="1200" />
  <meta property="og:image:height"        content="630" />
  <meta property="og:image:alt"           content="{{ $data['product']['name'] }}" />

  <meta property="product:original_price:amount"   content="{{ $data['product']['price'] }}" />
  <meta property="product:original_price:currency" content="{{ config('app.currency_sign') }}" />

  <meta name="twitter:image"              content="{{ show_product_opengraph_image($data['product']) }}" />
@stop

@section('preload')
  <link rel="preload" as="image"
    href="{{ show_product_image($data['product']) }}"
    imagesrcset="
      {{ \App\Libraries\Cloudinary::get($data['product']['image_url'], '0x350', $data['product']['slug']) }} 350w,
      {{ \App\Libraries\Cloudinary::get($data['product']['image_url'], '0x800', $data['product']['slug']) }} 800w,
      {{ \App\Libraries\Cloudinary::get($data['product']['image_url'], '0x1500', $data['product']['slug']) }} 1500w"
    imagesizes="(max-width: 720px) 100vw, 50vw">
@stop

@section('breadcrumb')@stop

@section('content')
  <div class="full-bg-grey">

    <div class="product-infos container" itemscope itemtype="https://schema.org/Product">

      <meta itemprop="url" content="{{ route('get.products.product', [ 'product' => $data['product']['slug'] ]) }}" />
      <meta itemprop="gtin" content="{{ $data['product']['slug'] }}" />
      <meta itemprop="sku" content="{{ $data['product']['slug'] }}" />
      <meta itemprop="image" content="{{ show_product_image_for_google($data['product']) }}" />

      <div class="product-infos-photos col-md-5">
        <a rel="nofollow" href="{{ route('get.products.redirect', [ 'product' => $data['product']['slug'] ]) }}" target="_blank">
          <img class="photos-main-photo"
            data-original-src="{{ $data['product']['image_url'] }}"

            src="{{ show_product_image($data['product']) }}"
            srcset="
              {{ \App\Libraries\Cloudinary::get($data['product']['image_url'], '0x350', $data['product']['slug']) }} 350w,
              {{ \App\Libraries\Cloudinary::get($data['product']['image_url'], '0x800', $data['product']['slug']) }} 800w,
              {{ \App\Libraries\Cloudinary::get($data['product']['image_url'], '0x1500', $data['product']['slug']) }} 1500w"
            sizes="(max-width: 720px) 100vw, 50vw"

            alt="{{ alt_for_product_image($data['product']) }}">
        </a>
      </div>

      <div class="product-infos-content">
        <div class="section-bg-color">

          <div class="infos-group">
            <div class="primary-infos">
              <div class="infos-brand">
                <h1 itemprop="name" class="infos-title">{{ $data['product'] ?: $data['product']['brand_original'] }}</h1>
              </div>
              <div itemprop="brand" itemscope itemtype="https://schema.org/Brand">
                <a
                  href="{{ route('get.products.byBrand', ['brand' => \Slugify::slugify($data['product']['brand_original']) ]) }}"
                  target="_blank"
                  itemprop="url"
                  class="brand-name"><span itemprop="name">{{ $data['product']['brand_original'] }}</span></a>
              </div>
            </div>

            <div class="infos-datas">
              <div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="infos-price">
                <div class="infos-price-numbers">
                  @include('pages.shop.partials.product._price', ['product' => $data['product']])
                </div>
                <meta itemprop="availability" content="https://schema.org/InStock" />
                <meta itemprop="url" content="{{ route('get.products.product', [ 'product' => $data['product']['slug'] ]) }}" />
                <span class="infos-stock">{{ _i("En stock") }}</span>
              </div>
              <div class="infos-sizes">
                <p class="infos-seller">{{ _i("Vendu et expédié par") }} <a rel="nofollow" href="{{ route('get.products.redirect', [
                'product' => $data['product']['slug'],
                ]) }}" target="_blank">{{ $data['product']['merchant_original'] }}</a></p>
                <a rel="nofollow" class="btn btn-primary btn-filled" href="{{ route('get.products.redirect', [
                'product' => $data['product']['slug'],
                ]) }}" target="_blank">{{ _i("Acheter") }}</a>

              </div>
            </div>
            <div class="product-description accordion open">
              <span class="accordion-title">{{ _i("Description") }}</span>
              <p itemprop="description" class="accordion-content">{{ $data['product']['description'] }}</p>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

@stop
