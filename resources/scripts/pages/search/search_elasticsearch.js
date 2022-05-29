(function($) {
  var $dropdownMenuTemplate = $('#custom-autocomplete-dropdown-menu-template');

  // Desktop
  var $topMenu = $('.big-menu__top-menu');
  var $searchContainer = $('.search, .search-mobile');
  var $searchForm = $('.search__form');
  var $searchInput = $searchContainer.find('.search__input, .search-mobile__input');
  var $submitInput = $searchContainer.find('.search__submit');

  // Mobile
  var $mobileSearchContainer = $('.search-mobile');
  var $mobileSearchInput = $mobileSearchContainer.find('.search-mobile__input');

  var $searchResults = $('.search__results');

  var final_results = {
    brands: [],
    categories: [],
    products: [],
  };

  // Modifier class to change styles of desktop header when results are expanded
  var modifierClass = 'big-menu__top-menu--search-results-expanded';

  if(DATA.QUERY)
    $searchInput.val(html_entity_decode(DATA.QUERY));

  $(document).mouseup(function(e) {
    var container = $('.big-menu__section.big-menu__top-menu');

    if(!container.is(e.target) && container.has(e.target).length === 0)
      $searchResults.addClass('hidden');
  });

  $('.big-menu__main-menu__item').on('mouseenter', function() {
    $searchResults.addClass('hidden');
  });

  $searchInput
    .on('focus', function () { $topMenu.addClass(modifierClass); this.select(); })
    .on('blur', function () { $topMenu.removeClass(modifierClass); })
    .autocomplete({
      // lookup: suggestions,
      serviceUrl: laroute.route('api.brands'),
      triggerSelectOnValidInput: false,
      lookupLimit: 10,
      appendTo: ' ',
      beforeRender: autocomplete__beforeRender,
      // formatResult: autocomplete__formatResult,
      onSearchStart: autocomplete__onSearchStart,
      onSearchComplete: autocomplete__onSearchComplete,
      transformResult: autocomplete__transformResult,
      onHide: autocomplete__onHide,
    })
    .on('autocomplete:shown', updateAllProductsLinks);

  var template = $dropdownMenuTemplate.html();

  var available_categories = [];
  $.getJSON(laroute.route('api.categories'), function(data) {
    for(var category in data)
      available_categories.push({
        data: data[category],
        value: data[category].title,
      });
  });

  function updateResults(data) {
    // console.debug('updateResults', data);

    final_results = Object.assign(final_results, data);

    final_results.categories.forEach(function(category) {
      category.url = getCategoryLink(category.data.slug);
    });
    final_results.brands.forEach(function(brand) {
      brand.url = getBrandLink(brand.data.slug);
    });

    $searchResults.html(
      Mustache.render(template, final_results)
    );
  }

  function autocomplete__beforeRender(container, suggestions) {
    // console.debug('beforeRender', container, suggestions);
  }

  function autocomplete__formatResult(suggestion, currentValue) {
    // console.debug('formatResult', suggestion, currentValue);
  }

  function autocomplete__onSearchStart(params) {
    // console.debug('onSearchStart', params);
    $searchResults.removeClass('hidden');

    var queryLowerCase = params.query.toLowerCase();
    var matching_categories = [];

    available_categories.forEach(function(category) {
      if(category.value.toLowerCase().indexOf(queryLowerCase) !== -1)
        matching_categories.push(category);
      else if(category.data.slug.toLowerCase().indexOf(queryLowerCase) !== -1)
        matching_categories.push(category);
    });

    matching_categories.sort(function(a, b) {
      var v_a = a.value.length;
      var v_b = b.value.length;

      return v_a - v_b;
    });

    if(matching_categories.length < 10)
      available_categories.forEach(function(category) {
        var chunks = queryLowerCase.split(' ');
        var amount_of_chunk_found = 0;

        chunks.forEach(function(chunk) {
          if(category.value.toLowerCase().indexOf(chunk) !== -1)
            amount_of_chunk_found ++;
        });

        if(amount_of_chunk_found == chunks.length)
          matching_categories.push(category);
      });

    updateResults({
      // https://stackoverflow.com/a/39272754/1465029
      categories: matching_categories
      .filter(function(x, i, a) { return a.indexOf(x) == i})
      .slice(0, 10)
    });
  }

  function autocomplete__onSearchComplete(query, suggestions) {
    // console.debug('onSearchComplete', query, suggestions);

    updateResults({
      brands: suggestions,
    });
  }

  function autocomplete__transformResult(brands, originalQuery) {
    // console.debug('transformResult', brands, originalQuery);
    brands = typeof brands === 'string' ? JSON.parse(brands) : brands;
    brands = brands.data || brands;

    brands = brands.map(function(brand) {
      brand.name_with_type = brand.display_name;

      if(brand.brand_type)
        brand.name_with_type = brand.name_with_type + ' (' + brand.brand_type.name + ')';

      return brand;
    });

    // removes duplicates | https://stackoverflow.com/a/27194673/1465029
    var brands = brands.reduce(function(memo, brand_1) {
      var matches = memo.filter(function(brand_2) {
        return brand_1.name_with_type == brand_2.name_with_type
      });

      if (matches.length == 0)
        memo.push(brand_1);

      return memo;
    }, []);

    return {
      suggestions: brands.map(function(data) {
        return {
          data: data,
          value: data.slug,
        };
      })
    };
  }

  function autocomplete__onHide() {
    // console.debug('onHide');
    // $searchResults.addClass('hidden');
  }

  function updateProductsCount(hitsCount) {
    $('.search-results-products-count').html(hitsCount);
  }

  function updateAllProductsLinks() {
    var allProductsRoute = laroute.route('get.products.all_products');

    $('.search-results-all-categories-link').attr('href', allProductsRoute);
    $('.search-results-all-products-link').attr('href',
      (getMostRelevantAllProductsLink() || allProductsRoute)
    );
  }

  function getMostRelevantAllProductsLink() {
    var firstCategoryResult = $('.search__dataset-categories a').first();
    var firstBrandResult = (
      !firstCategoryResult.length && $('.search__dataset-brands a').first()
    );

    return (
      firstCategoryResult.attr('href') || firstBrandResult.attr('href') || false
    );
  }

  function getCategoryLink(slug) {
    return laroute.route('get.products.byCategory', { category: slug });
  }

  function getBrandLink(slug) {
    return laroute.route('get.products.byBrand', { brand: slug });
  }
})(jQuery);
