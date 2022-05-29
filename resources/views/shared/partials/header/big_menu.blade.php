@php
$data['categories'] = @$data['categories'] ?: get_categories_as_tree();
@endphp

<nav class="big-menu__section big-menu__main-menu big-menu__menu">
  <ul class="big-menu__main-menu__items">
    @foreach([
      App\Models\Gender::GENDER_FEMALE,
      App\Models\Gender::GENDER_MALE,
    ] as $gender)
      <li class="big-menu__main-menu__item">
        <a href="{{ route('get.products.byGender', ['gender' => _i($gender)]) }}" class="big-menu__main-menu__link">{{ _i($gender) }}</a>

        <ul class="big-menu__sub-menu big-menu__menu">
          @foreach($data['categories'] as $category) @if(App\Models\Gender::areMatching($gender, $category->gender))
            <li class="big-menu__sub-menu__item">
              <a href="{{ route('get.products.byGender.byCategory', ['gender' => _i($gender), 'category' => $category->slug]) }}" class="big-menu__sub-menu__link">{{ $category->title }}</a>

              <div class="big-menu__menu-panel big-menu__menu">
                <div class="big-menu__menu-panel__categories">
                  <div class="big-menu__menu-panel__title">
                    <a href="{{ route('get.products.byGender.byCategory', ['gender' => _i($gender), 'category' => $category->slug]) }}">{{ $category->title . ' ' . _i($gender) }}</a>
                  </div>

                  <ul class="big-menu__menu-panel__items">
                    @foreach ($category->children as $child) @if(App\Models\Gender::areMatching($gender, $child->gender))
                      <li class="big-menu__menu-panel__item">
                        <a
                          href="{{ route('get.products.byGender.byCategory', ['gender' => _i($gender), 'category' => $child->slug]) }}"
                          title="{{ clean_for_html(_i("%s %s", [
                            text_for_seo__category(['category_title' => $child->title]),
                            text_for_seo__gender(['gender' => $gender]),
                          ])) }}"
                          class="big-menu__menu-panel__link">{{ $child->title }}</a>
                      </li>
                    @endif @endforeach
                  </ul>

                  <a href="{{ route('get.products.byGender.byCategory', ['gender' => _i($gender), 'category' => $category->slug]) }}" class="big-menu__menu-panel__button">{{ $category->title . ' ' . _i($gender) }}</a>
                </div>

                @if( @$menu_selections[$category->slug][$gender] )
                  @foreach($menu_selections[$category->slug][$gender] as $menu_selection)
                    <a href="{{ @$menu_selection->url }}"
                      title="{{ @$menu_selection->title }}"
                      class="big-menu__menu-panel__currated lozad"
                      style="background: #000000"
                      @if( !empty($menu_selection->background) ) data-background-image="{{ $menu_selection->background }}" @endif>
                      <div class="big-menu__menu-panel__currated__title">{{ @$menu_selection->title }}</div>
                      <span class="big-menu__menu-panel__currated__cta">{{ _i("Découvrir") }}</span>
                    </a>
                  @endforeach
                @endif

              </div>
            </li>
          @endif @endforeach

          <li class="big-menu__sub-menu__item">
            <a href="{{ route('get.products.byPromotion.byGender', ['gender' => _i($gender)]) }}"
              class="big-menu__sub-menu__link big-menu__sub-menu__link--red">{{ get_current_sales_period() ?: _i('Promotions 🔥') }}</a>
          </li>

        </ul>
      </li>
    @endforeach

    <li class="big-menu__main-menu__item">
      <a href="{{ route('get.brands.index') }}" class="big-menu__main-menu__link">{{ _i("Marques") }}</a>

      <ul class="big-menu__sub-menu big-menu__menu">

        @foreach(collect($brand_types)->prepend(null) as $brand_type)
          @php
            if($brand_type) {
              $name = $brand_type->name;
              $brands = $brand_type->brands()->all_top()->get();

              $url_1 = route('get.brands.index_for_type', [ 'brand_type' => $brand_type, ]);
              $url_2 = route('get.brands.index_for_type', [ 'brand_type' => $brand_type, 'all' => true, ]);
            } else {
              $name = '';
              $brands = App\Models\Brand::doesnthave('brand_type')->all_top()->get();

              $url_1 = route('get.brands.index');
              $url_2 = route('get.brands.index', ['all' => true]);
            }
          @endphp

          <li class="big-menu__sub-menu__item">
            <a href="{{ $url_1 }}" class="big-menu__sub-menu__link">{{ $name ?: _i("TOP MARQUES") }}</a>

            <div
              @if($brand_types->count() == 0) style="display: block;" @endif
              class="big-menu__menu-panel big-menu__menu-panel-brands big-menu__menu">
              <div class="big-menu__menu-panel__brands">

                @if($brand_types->count() > 1)
                  <div class="big-menu__menu-panel__title">{{ trim(_i("TOP MARQUES %s", ['brand_type' => $name])) }}</div>
                @endif

                <ul class="big-menu__menu-panel__items">
                  @foreach($brands as $brand)
                    <li class="big-menu__menu-panel__item">
                      <a href="{{ route('get.products.byBrand', ['brand' => $brand]) }}"
                        class="big-menu__menu-panel__link">{{ $brand }}</a>
                    </li>
                  @endforeach
                </ul>

                <div class="text-center">
                  <a href="{{ $url_2 }}"
                    class="big-menu__menu-panel__button">{{ trim(_i("Voir toutes les marques %s", ['brand_type' => $name])) }}</a>
                </div>

              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </li>

    @if(config('app.enable_blog'))
      <li class="big-menu__main-menu__item">
        <a href="{{ url('/zine/') }}" class="big-menu__main-menu__link" target="_blank">{{ _i("Magazine") }}</a>
      </li>
    @endif

  </ul>
</nav>
