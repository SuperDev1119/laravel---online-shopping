<script type="text/html" id="grid--product-thumb-template">
  <div
    class="product-thumb grid-columns"
    itemscope
    itemtype="https://schema.org/Product"
    data-id="@{{ slug }}"
    data-index="@{{ index }}"
    data-is_on_first_page="@{{ is_on_first_page }}">

    <meta itemprop="url" content="@{{ url }}" />
    <meta itemprop="gtin" content="@{{ slug }}" />
    <meta itemprop="sku" content="@{{ slug }}" />

    <a href="@{{ url_redirect }}" rel="nofollow" target="_blank" class="product-thumb-photo">
      <img
        itemprop="image"
        data-original-src="@{{ image_url_original }}"

        loading="lazy"

        src="@{{ image_url }}"
        srcset="@{{ image_url }} 1x, @{{ image_url_retina }} 2x"
        sizes="(max-width: 720px) 50vw, 25vw"

        alt="@{{ name }} - @{{ brand_original }} - {{ config('app.site_name') }}">
    </a>
    <a itemprop="url" href="@{{ url }}" rel="nofollow" target="_blank" class="product-thumb-info">
      <span class="product-thumb-brand" itemprop="brand" itemscope itemtype="https://schema.org/Brand">
        <meta itemprop="url" content="@{{ url_brand }}" />
        <span itemprop="name">@{{ brand_original }}</span>
      </span>
      <span class="product-thumb-title" itemprop="name">@{{ name }}</span>
      <span class="product-thumb-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
        @{{# reduction }}
          <span class="old">@{{ old_price }}{{ config('app.currency_sign') }}</span>
          <span class="reduction">
            <span itemprop="price">@{{ price }}</span>
            <meta itemprop="priceCurrency" content="@{{ currency_original }}" />{{ config('app.currency_sign') }}
          </span>
          <span class="price-promotion">-@{{ reduction }}%</span>
        @{{/ reduction }}
        @{{^ reduction }}
          <span>
            <span itemprop="price">@{{ price }}</span>
            <meta itemprop="priceCurrency" content="@{{ currency_original }}" />{{ config('app.currency_sign') }}
          </span>
        @{{/reduction }}
        <meta itemprop="availability" content="https://schema.org/InStock" />
      </span>
    </a>
  </div>
</script>
