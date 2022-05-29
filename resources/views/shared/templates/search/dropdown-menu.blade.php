<script type="text/template" id="custom-autocomplete-dropdown-menu-template">
  <ul class="search__datasets">
    <li class="search__dataset-container">
      <span class="search__dataset-title">{{ _i("Marques") }}</span>
      <div class="search-dataset-brands search-mobile-dataset-brands search__dataset search__dataset-brands">
        <div class="search__suggestions-list">
          @{{#brands}}
            <div class="search__suggestion">
              <a class="search__suggestion-link" href="@{{url}}">
                @{{data.name_with_type}}
              </a>
            </div>
          @{{/brands}}
          @{{^brands.0}}{{ _i("Aucune marque ne correspond") }}@{{/brands.0}}
        </div>
      </div>

      <div class="search__dataset-all-link-wrapper">
        <i class="icon-flechepdroite search__dataset-all-link-icon"></i>
        <a
          href="{{ route('get.brands.index', ['all' => true]) }}"
          class="search__dataset-all-link"
        >{{ _i("Toutes les marques") }}</a>
      </div>
    </li>

    <li class="search__dataset-container">
      <span class="search__dataset-title">{{ _i("Catégories") }}</span>
      <div class="search-dataset-categories search-mobile-dataset-categories search__dataset search__dataset-categories">
        <div class="search__suggestions-list">
          @{{#categories}}
            <div class="search__suggestion">
              <a class="search__suggestion-link" href="@{{url}}">
                @{{data.title}}
              </a>
            </div>
          @{{/categories}}
          @{{^categories.0}}{{ _i("Aucune catégorie ne correspond") }}@{{/categories.0}}
        </div>
      </div>

      <div class="search__dataset-all-link-wrapper">
        <i class="icon-flechepdroite search__dataset-all-link-icon"></i>
        <a
          href="{{ route('get.products.all_products') }}"
          class="search-results-all-categories-link search__dataset-all-link"
        >{{ _i("Toutes les catégories") }}</a>
      </div>
    </li>

    <li class="search__dataset-container hidden">
      <span class="search__dataset-title">{{ _i("Produits") }}</span>
      <div class="search-dataset-products search-mobile-dataset-products search__dataset search__dataset-products"></div>

      <div class="search__dataset-all-link-wrapper">
        <i class="icon-flechepdroite search__dataset-all-link-icon"></i>
        <a
          href="{{ route('get.products.all_products') }}"
          class="search-results-all-products-link search__dataset-all-link"
        >{{ _i("Tous les produits") }}
          <span class="search__products-count">
            (<span class="search-results-products-count"></span>)
          </span>
        </a>
      </div>
    </li>
  </ul>
</script>
