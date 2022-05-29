@php
$data['categories'] = @$data['categories'] ?: get_categories_as_tree();
@endphp

<ul class="header-menu">
  @foreach([
    App\Models\Gender::GENDER_FEMALE(),
    App\Models\Gender::GENDER_MALE(),
  ] as $gender)

    <li class="header-menu-big">
      <a href="{{ get_magic_route(['gender' => $gender]) }}">{{ _i($gender) }}</a>

      <ul class="submenu">
        <li class="submenu-item hidden-lg hidden-md">
          <a class="submenu-item-title" href="{{ get_magic_route(['gender' => $gender]) }}" >{{ _i("Tous les produits") }}</a>
        </li>
        <li class="submenu-item hidden-lg hidden-md">
          <a class="submenu-item-title"
            href="{{ route('get.products.byPromotion.byGender', ['gender' => $gender]) }}" style="color:#db1212">{{ get_current_sales_period() ?: _i('Promotions 🔥') }}</a>
        </li>

        @foreach($data['categories'] as $category) @if(App\Models\Gender::areMatching($gender, $category->gender))
          <li class="submenu-item">
            <a href="{{ get_magic_route(['category' => $category, 'gender' => $gender]) }}" class="submenu-item-title">{{ $category->title }}</a>
          </li>
        @endif @endforeach

      </ul>

    </li>

  @endforeach

  <li class="header-menu-big">
    <a href="{{ route('get.brands.index') }}">{{ _i("Marques") }}</a>

    <ul class="submenu hidden-lg hidden-md">
      <li class="submenu-item">
        <a class="submenu-item-title" href="{{ route('get.brands.index') }}" >{{ _i("Top Marques") }}</a>
      </li>

      @foreach($brand_types as $brand_type)
        <li class="submenu-item">
          <a href="{{ route('get.brands.index_for_type', [ 'brand_type' => $brand_type, ]) }}" class="submenu-item-title">{{ trim(_i("Top Marques %s", ['brand_type' => $brand_type->name])) }}</a>
        </li>
      @endforeach

    </ul>
  </li>

</ul>
