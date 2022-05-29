@php
  $brand_types = App\Models\BrandType::ordered()->get();
  $menu_selections = [];
@endphp

<header id="header">
  <div class="big-menu">

    <div class="big-menu__container">

      <div class="big-menu__section big-menu__top-menu">
        <a href="{{ route('home') }}" class="big-menu__top-menu__logo">
          <img width="170" height="36" src="{{ asset('images/logo.svg', is_connection_secure()) }}" alt="Logo - {{ config('app.site_name') }}">
        </a>

        <div class="search">
          <div class="search__wrapper">
            <form class="search__form" method="get" action="{{ route('get.products.search') }}">
              <input
                class="search__input"
                type="text"
                border="1"
                name="q"
                placeholder="{{ _i("Recherchez. Comparez. Achetez.") }}"
                autocomplete="off">

              <button type="submit" class="search__submit">
                <i class="icon-search search__submit-icon" arial-role="search" aria-label="{{ _i("Recherchez.") }}"></i>
              </button>

              <div class="results search__results hidden"></div>
            </form>
          </div>
        </div>
      </div>

      @include('shared.partials.header.big_menu')

    </div>
  </div>

  <div class="header">
    <a class="header-responsive-button">
      <span></span>
    </a>

    <a href="{{ route('home') }}" class="header-logo">
      <img width="100" height="31" class="hidden-md hidden-lg" src="{{ asset('images/logo.svg', is_connection_secure()) }}" alt="Logo - {{ config('app.site_name') }}">
    </a>

    <button class="header-search-button">
      <i class="icon-search header-search-button__icon" arial-role="search" aria-label="{{ _i("Recherchez.") }}"></i>
    </button>

    <form class="search-mobile" method="get" action="{{ route('get.products.search') }}">
      <div class="search-mobile__algolia-wrapper">
        <input
          class="search-mobile__input"
          type="text"
          name="q"
          placeholder="{{ _i("Recherchez.") }}"
          autocomplete="off">

        <div class="results search__results search-mobile__results"></div>

        <i class="icon-search search-mobile__search-icon"></i>

        <div class="search-mobile__close"></div>
      </div>
    </form>

    @include('shared.partials.header.big_menu--mobile')

  </div>
</header>
