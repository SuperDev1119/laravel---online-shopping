@php $base_for_data = [] @endphp
@php $position = 1 @endphp

@if( true === @$promotion )

  @php $base_for_data['promotion'] = true @endphp

  <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <a itemprop="item" href="{{ route('get.products.byPromotion') }}">
      <span itemprop="name">{{ get_current_sales_period() ?: _i('Les promotions') }}</span>
    </a>
    <meta itemprop="position" content="{{ $position++ }}" />
  </li>

@endif

@if( ! empty($brand) )

  @if($brand_type = $brand->brand_type)
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="{{ route('get.brands.index_for_type', ['brand_type' => $brand_type]) }}">
        <span itemprop="name">{{ _i('Nos marques %s', ['brand_type' => $brand_type]) }}</span>
      </a>
      <meta itemprop="position" content="{{ $position++ }}" />
    </li>
  @else
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="{{ route('get.brands.index') }}">
        <span itemprop="name">{{ _i('Nos marques') }}</span>
      </a>
      <meta itemprop="position" content="{{ $position++ }}" />
    </li>
  @endif

  <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <a itemprop="item" href="{{ get_magic_route(array_merge($base_for_data, [ 'brand' => $brand ])) }}">
      <span itemprop="name">{{ $brand }}</span>
    </a>
    <meta itemprop="position" content="{{ $position++ }}" />
  </li>

  @php $base_for_data['brand'] = $brand @endphp

@endif

@if( ! empty($gender) )

  <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <a itemprop="item" href="{{ get_magic_route(array_merge($base_for_data, [ 'gender' => $gender ])) }}">
      <span itemprop="name">{{ ucfirst(_i($gender)) }}</span>
    </a>
    <meta itemprop="position" content="{{ $position++ }}" />
  </li>

  @php $base_for_data['gender'] = $gender @endphp

@endif

@if( ! empty($category) )

  @foreach($category->ancestors()->orderBy('depth', 'asc')->get() as $ancestor)
    @php if($ancestor->isRoot()) continue @endphp
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="{{ get_magic_route(array_merge($base_for_data, [ 'category' => $ancestor ])) }}">
        <span itemprop="name">{{ $ancestor->title }}</span>
      </a>
      <meta itemprop="position" content="{{ $position++ }}" />
    </li>
  @endforeach

  <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <a itemprop="item" href="{{ get_magic_route(array_merge($base_for_data, [ 'category' => $category ])) }}">
      <span itemprop="name">{{ $category->title }}</span>
    </a>
    <meta itemprop="position" content="{{ $position++ }}" />
  </li>

  @php $base_for_data['category'] = $category @endphp

@endif

@if( ! empty($color) )

  <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <a itemprop="item" href="{{ get_magic_route(array_merge($base_for_data, [ 'color' => $color ])) }}">
      <span>{{ __('Couleur: ') }}</span>
      <span itemprop="name">{{ ucfirst($color->name) }}</span>
    </a>
    <meta itemprop="position" content="{{ $position++ }}" />
  </li>

  @php $base_for_data['color'] = $color @endphp

@endif
