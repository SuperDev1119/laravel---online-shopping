<div
  class="product-thumb grid-columns"
  itemscope
  itemtype="https://schema.org/Product"
  data-id="{{ $product['slug'] }}"
  data-index="{{ $index }}"
  data-is_on_first_page="{{ $is_on_first_page ? 'true' : 'false' }}">

  <meta itemprop="url" content="{{ route('get.products.product', ['product' => $product['slug']]) }}" />
  <meta itemprop="gtin" content="{{ $product['slug'] }}" />
  <meta itemprop="sku" content="{{ $product['slug'] }}" />

  <meta itemprop="description" content="{{ $product['description'] ?: config('app.name') }}" />
  <meta itemprop="image" content="{{ show_product_image_for_google($product) }}" />

  <a target="_blank"
    class="link-seo-js product-thumb-photo"
    href="{{ config('app.obfuscate_link_to_pdp') ? '#' : route('get.products.product', ['product' => $product['slug']]) }}"
    data-href="{{ route('get.products.redirect', ['product' => $product['slug']]) }}">
    <img
      data-original-src="{{ $product['image_url'] }}"

      src="{{ show_product_image($product, true, true) }}"
      srcset="
        {{ \App\Libraries\Cloudinary::get($product['image_url'], '0x150', $product['slug']) }} 150w,
        {{ \App\Libraries\Cloudinary::get($product['image_url'], '0x350', $product['slug']) }} 350w,
        {{ \App\Libraries\Cloudinary::get($product['image_url'], '0x400', $product['slug']) }} 400w,
        {{ show_product_image($product, true, true) }} 500w"
      sizes="(max-width: 720px) 50vw, 25vw"

      loading="lazy"

      alt="{{ alt_for_product_image($product) }}">
  </a>

  <a target="_blank"
    class="link-seo-js product-thumb-info"
    href="{{ config('app.obfuscate_link_to_pdp') ? '#' : route('get.products.product', ['product' => $product['slug']]) }}"
    data-href="{{ route('get.products.product', ['product' => $product['slug']]) }}" >
    <span class="product-thumb-brand" itemprop="brand" itemscope itemtype="https://schema.org/Brand">
      <meta itemprop="url" content="{{ route('get.products.byBrand', ['brand' => \Slugify::slugify($product['brand_original']) ]) }}" />
      <span itemprop="name">{{ $product['brand_original'] }}</span>
    </span>
    <span class="product-thumb-title" itemprop="name">{{ $product['name'] ?: $product['brand_original'] }}</span>
    <span class="product-thumb-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
      @include('pages.shop.partials.product._price_grid', ['product' => $product])
      <meta itemprop="availability" content="https://schema.org/InStock" />
      <meta itemprop="url" content="{{ route('get.products.product', ['product' => $product['slug']]) }}" />
    </span>
  </a>
</div>
