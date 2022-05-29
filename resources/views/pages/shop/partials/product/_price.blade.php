@if( !empty($product['reduction']) && $product['reduction'] > 0 )
  <span class="price-old">{{ $product['old_price'] . config('app.currency_sign') }}</span>
  <span class="price-current" style="color:#DB1212;font-weight: 700;">
    <span itemprop="price">{{ $product['price'] }}</span>
    <meta itemprop="priceCurrency" content="{{ $product['currency_original'] }}" />{{ config('app.currency_sign') }}
  </span>
  <span class="price-promotion">-{{ @$product['reduction'] }}%</span>
@else
  <span class="price-current">
    <span itemprop="price">{{ $product['price'] }}</span>
    <meta itemprop="priceCurrency" content="{{ $product['currency_original'] }}" />{{ config('app.currency_sign') }}
  </span>
@endif

@if($current_sales_period = get_current_sales_period())
  <meta itemprop="priceValidUntil" content="{{ $current_sales_period->ends_at->format('Y-m-d') }}" />
@elseif($next_sales_period = get_next_sales_period())
  <meta itemprop="priceValidUntil" content="{{ $next_sales_period->starts_at->format('Y-m-d') }}" />
@endif
