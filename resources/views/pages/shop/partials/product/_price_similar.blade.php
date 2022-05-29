@if( !empty($product['reduction']) && $product['reduction'] > 0 )
  <span class="old">{{ $product['old_price']. config('app.currency_sign') }}</span>
  <span class="reduction" itemprop="price">{{ $product['price'] }}
    <meta itemprop="priceCurrency" content="{{ $product['currency_original'] }}" />{{ config('app.currency_sign') }}</span>
@else
  <span>
    <span itemprop="price">{{ $product['price'] }}</span>
    <meta itemprop="priceCurrency" content="{{ $product['currency_original'] }}" />{{ config('app.currency_sign') }}
  </span>
@endif
