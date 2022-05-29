function load_elastic() {
  function die(msg) {
    // console.debug(msg);
    var html = $('#shop-products-grid noscript').html();
    $('#shop-products-grid').html( html );
  }

  if( ! CONFIG.ELASTICSEARCH_URL ) return die('config not found');

  var elasticsearch_client = new es.Client({
    hosts: CONFIG.ELASTICSEARCH_URL,
  });

  if( (!$('body').hasClass('page-grid')) || 'undefined' == typeof QUERY_PARAMS )
    return die('not grid page');

  var org_QUERY_PARAMS = JSON.parse(JSON.stringify(QUERY_PARAMS));
  var org_VIEW_PARAMS = JSON.parse(JSON.stringify(VIEW_PARAMS));

  const INFINITE_SCROLL_THRESHOLD = window.innerHeight*3;

  var active_values_for_facet = {};
  var current_index_for_page = 0;
  var we_are_on_search_page = $('body').hasClass('page-shop-category-search');
  var $pagination = $('#pagination');

  var scroll_is_updating = false;

  function init_pagination() {
    var page = getParameterByName('page');

    try {
      page = $pagination.pagination('getCurrentPage');
    } catch(e) {}

    $pagination.pagination('destroy');
    $pagination.pagination({
      pages: Math.min(Math.ceil(VIEW_PARAMS.totalProducts / QUERY_PARAMS.size), 70),
      displayedPages: 4, // 4 is max for mobile view
      prevText: '«',
      nextText: '»',
      currentPage: page,
      hrefTextPrefix: '?page=',
      listStyle: 'pagination',
      onPageClick: function (page, event) {
        var new_href;

        if(event) { // real click -- wont be defined when called from JS API
          event.preventDefault();
          new_href = event.target.href;
        } else {
          new_href = location.pathname + '?page=' + page;

          // https://stackoverflow.com/a/41542008/1465029
          if('URLSearchParams' in window) {
            var searchParams = new URLSearchParams(window.location.search);
            searchParams.set('page', page);
            new_href = window.location.pathname + '?' + searchParams.toString();
          }
        }

        window.history.pushState(QUERY_PARAMS, document.title, new_href);

        QUERY_PARAMS.from = ( page - 1 ) * QUERY_PARAMS.size;
        run_search();
      }
    });
  }

  function update_query_params() {
    QUERY_PARAMS.query = JSON.parse(JSON.stringify(org_QUERY_PARAMS.query));

    for(var key in active_values_for_facet) {
      var values = [];

      for(var item in active_values_for_facet[ key ])
        if(true === active_values_for_facet[ key ][ item ])
          values.push(item);

      if(0 == values.length)
        continue;

      if('brand_original' == key) {
        var matches = [];

        values.forEach(function(value) {
          var term = {};
          term[ key ] = value;
          matches.push({match_phrase: term});
        });

        QUERY_PARAMS.query.bool.filter.push({
          bool: { should: matches }
        });

      } else {
        var term = {};
        term[ key + '.keyword' ] = values;
        QUERY_PARAMS.query.bool.filter.push({terms: term});
      }
    }

    (function() {
      var price_min = $('#filter-price form [name="filter-price-min"]').val();
      var price_max = $('#filter-price form [name="filter-price-max"]').val();
      var promotion = $('#filter-price form [name="filter-promotion"]').val();
      var opts = {};

      if(price_min) opts['gte'] = price_min;
      if(price_max) opts['lte'] = price_max;

      if(price_min || price_max)
        QUERY_PARAMS.query.bool.filter.push({range: {price: [opts]}});

      if('true' === promotion)
        QUERY_PARAMS.query.bool.filter.push({range: {reduction: {'gt': 0}}});
    })();
  }

  function run_search() {
    update_query_params();

    elasticsearch_client.search({
      index: 'products',
      body: QUERY_PARAMS,
      requestCache: true,
    }).then(function (body) {
      $('body').removeClass('loading');
      scroll_is_updating = false;

      update_products(body.hits);
      update_facets(flatten_aggregations(body.aggregations), true);
      update_stats(body.hits.total);

      init_pagination(); // after update_stats

    }, function (error) {
      console.trace(error.message);
    });
  }

  function set_all_to_unactive() {
    $(".filter[id^='filter-'] .filter--section.active").removeClass('active');
  }

  function remove_all_shadow() {
    $('.filter--section--shadow, .filter--section--body--before').remove();
  }

  function reset_grid() {
    $('body').addClass('loading');

    $(window).scrollTop( 0 );
    $('#shop-products-grid').find('.product-thumb.grid-columns:not(.bloc-must-have)').remove();
    $('#shop-products-grid').find('.products-grid-empty').remove();
    $pagination.pagination('selectPage', 1);
  }

  function add_shadow() {
    remove_all_shadow();

    var $shadow = $('<div class="filter--section--shadow"></div>');
    var $section = $('.filter--section.active:not(.filter--section--no-shadow)');

    var height = 0;
    $section.children().each(function(e) {
      $section.prepend($shadow.clone()
        .css('height', $(this).innerHeight())
        .css('width', $(this).innerWidth())
        .css('top', height)
        );

      height += $(this).innerHeight();
    });

    var $before = $('<div class="filter--section--body--before"></div>');

    $section.find('.filter--section--body').prepend(
      $before.css('width', $section.find('.filter--section--header').innerWidth())
      );
  }

  if($pagination.get(0))
    document.addEventListener('scroll', function() {
      var viewportOffset = $pagination.get(0).getBoundingClientRect();
      var top = viewportOffset.top - window.innerHeight;

      if(top < INFINITE_SCROLL_THRESHOLD && !scroll_is_updating) {
        scroll_is_updating = true;
        $pagination.pagination('nextPage');
      }
    }, {
      capture: true,
      passive: true
    });

  $(document).on('click', set_all_to_unactive);

  $(document).on('change', '#sort-by', function(e) {
    QUERY_PARAMS.sort = [JSON.parse(this.value), '_score'];
    reset_grid();
  });
  document.querySelector('#sort-by').removeAttribute('disabled');

  $(document).on('submit', '#filter-price form', function(e) {
    e.preventDefault();

    $('#filter-price .filter--section').removeClass('active');

    $('#filter-price form [name="filter-price-min"]').val(
      $('#filter-price form [name="temp-price-min"]').val()
      );
    $('#filter-price form [name="filter-price-max"]').val(
      $('#filter-price form [name="temp-price-max"]').val()
      );
    $('#filter-price form [name="filter-promotion"]').val(
      $('#filter-price form [name="temp-promotion"]').is(':checked')
      );

    reset_grid();
  });

  $(document).on('click', '.filter--section', function(e) { e.stopPropagation(); });

  $(document).on('click', '.filter--section--header', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var $this = $(this),
      $parent = $this.parents('.filter--section').first();

    if( ! $parent.hasClass('active') )
      set_all_to_unactive();

    $parent.toggleClass('active');

    add_shadow();
  });

  $(document).on('click', '.filter--section--item a', function(e) {
    e.preventDefault();

    var $this = $(this);
    var $that = $this.parents('.filter--section--item');

    $this.toggleClass('active');

    active_values_for_facet[ $that.data('facet-name') ] = active_values_for_facet[ $that.data('facet-name') ] || {};
    active_values_for_facet[ $that.data('facet-name') ][ $that.data('facet-value') ] = $this.hasClass('active');

    reset_grid();
  });

  $( window ).resize(add_shadow);

  function get_categories_list() {
    return CATEGORY_PATH;
  }

  function getTemplate(templateName) {
    return document.querySelector('#' + templateName + '-template').innerHTML;
  }

  function facet_config__getItem(item) {
    var klass = (true == item.active) ? ' active' : '';
    return '<li><a href="' + (item.url ? item.url : '#') + '" class="' + klass + '">' + item.key.ucfirst() + ' <small>(' + item.doc_count + ')</small></a> </li>';
  }

  function facet_config__sortBy(a, b) {
    if(a.doc_count < b.doc_count) return 1;
    if(a.doc_count > b.doc_count) return -1;

    return 0;
  }

  function facet_config__sortByName(a, b) {
    if(a.key < b.key) return -1;
    if(a.key > b.key) return 1;

    return 0;
  }

  function update_stats(total) {
    var container = '#amount-of-products-found';
    var $container = $(container);

    var price_min = Math.round($('#filter-price form [name="filter-price-min"]').val() || VIEW_PARAMS.aggs.price_min.value);
    var price_max = Math.round($('#filter-price form [name="filter-price-max"]').val() || VIEW_PARAMS.aggs.price_max.value);

    VIEW_PARAMS.totalProducts = total.value;

    var string = total.value <= 0 ?
      i18n.gettext('Aucun produit') :
      i18n.ngettext('%1 produit', ('gte' == total.relation ? 'Plus de %1 produits' : '%1 produits'), number_format(total.value, undefined, undefined, ' '));

    if(total.value > 0)
      string += i18n.gettext(
        ' <small>(de <span>%1</span> à %2)</small>',
        price_min + ' ' + CONFIG.CURRENCY_SIGN,
        price_max + ' ' + CONFIG.CURRENCY_SIGN
        );

    $container.html(string);
  }

  function init() {
    $('#filters').removeClass('hidden').find(".filter[id^='filter-']").empty();
    $('.filter > div[style]:hidden').parent().addClass('hidden');
  }

  function update_products__transform_data(hit) {
    hit.index = current_index_for_page % QUERY_PARAMS.size;
    hit.is_on_first_page = hit.index < VIEW_PARAMS.hitsOnFirstPage;

    current_index_for_page++;

    hit.name = hit.name ? hit.name : hit.brand_original;

    hit.url = laroute.route('get.products.product', {product: hit.slug});
    hit.url_redirect = laroute.route('get.products.redirect', {product: hit.slug});

    hit.url_brand = laroute.route('get.products.byBrand', {brand: hit.brand_original.slugify()});

    hit.image_url_original = hit.image_url;
    hit.image_url = getUrlForCloudinary(hit.image_url_original);
    hit.image_url_retina = getUrlForCloudinary(hit.image_url_original, true);

    hit.reduction = (hit.reduction && hit.reduction > 0) ? hit.reduction : false;

    return hit;
  }

  function update_products(response) {
    var container = '#shop-products-grid';
    var $container = $(container);

    if(0 === response.total) {
      return ;
    }

    var template = getTemplate('grid--product-thumb');
    Mustache.parse( template );

    response.hits.forEach(function (hit) {

      $container.append(
        Mustache.render( template, update_products__transform_data(hit._source) )
      );

    });
  }

  var facets_for_select = [{
    name: 'gender',
    only_if: function () { return we_are_on_search_page
      || document.querySelectorAll('.categories-section .nested-list > li').length > 1; },
    unless: function() { return VIEW_PARAMS.route.includes('byGender'); },
    header_text: i18n.gettext('filters__gender'),
    getItem: function (item) {
      var _item = JSON.parse(JSON.stringify(item));
      _item.key = i18n.gettext(_item.key);
      return facet_config__getItem(_item);
    },
  },{
    name: 'colors',
    header_text: i18n.gettext('filters__colors'),
    unless: function() { return VIEW_PARAMS.route.includes('byColor'); },
    // sort_by: facet_config__sortByName,
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez une couleur'), no_results: i18n.gettext('Aucune couleur ne correspond') },
  },{
    name: 'merchant_original',
    header_text: i18n.gettext('filters__merchant_original'),
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez un marchand'), no_results: i18n.gettext('Aucun marchand ne correspond') },
  },{
    name: 'brand_original',
    header_text: i18n.gettext('filters__brand_original'),
    unless: function() { return VIEW_PARAMS.route.includes('byBrand'); },
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez une marque'), no_results: i18n.gettext('Aucune marque ne correspond') },
  },{
    name: 'cols',
    header_text: i18n.gettext('filters__cols'),
    only_if: function () { var categories = get_categories_list(); return categories.length == 0 || categories.includes('vetements') },
    unless_for_these_categories: [
      'pantalon',
      'jean',
      'short',
      'maillot-de-bain',
      'sous-vetement',
      'chaussettes',
      'homewear',
      'collant',
      ],
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez un style de col'), no_results: i18n.gettext('Aucun style de col ne correspond') },
  },{
    name: 'coupes',
    header_text: i18n.gettext('filters__coupes'),
    only_if: function () { var categories = get_categories_list(); return categories.length == 0 || categories.includes('vetements') },
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez un style de coupe'), no_results: i18n.gettext('Aucun style de coupe ne correspond') },
  },{
    name: 'manchess',
    header_text: i18n.gettext('filters__manchess'),
    only_if: function () { var categories = get_categories_list(); return categories.length == 0 || categories.includes('vetements') },
    unless_for_these_categories: [
      'pantalon',
      'jean',
      'short',
      'maillot-de-bain',
      'sous-vetement',
      'chaussettes',
      'homewear',
      'collant',
      ],
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez un style de manche'), no_results: i18n.gettext('Aucun style de manche ne correspond') },
  },{
    name: 'materials',
    header_text: i18n.gettext('filters__materials'),
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez une matière'), no_results: i18n.gettext('Aucune matière ne correspond') },
  },{
    name: 'models',
    header_text: i18n.gettext('filters__models'),
    only_if: function () { var categories = get_categories_list(); return categories.length == 0 || categories.includes('chaussures') },
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez un modèle'), no_results: i18n.gettext('Aucun modèle ne correspond') },
  },{
    name: 'motifss',
    header_text: i18n.gettext('filters__motifss'),
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez un motif'), no_results: i18n.gettext('Aucun motif ne correspond') },
  },{
    name: 'events',
    only_if: function () { return false; },
    header_text: i18n.gettext('filters__events'),
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez un évènement'), no_results: i18n.gettext('Aucun évènement ne correspond') },
  },{
    name: 'styles',
    header_text: i18n.gettext('filters__styles'),
    unless: function () { var categories = get_categories_list(); return categories.includes('chaussures') },
    search_for_facet_values: { placeholder: i18n.gettext('Recherchez un style'), no_results: i18n.gettext('Aucun style ne correspond') },
  },{
    name: 'sizes',
    header_text: i18n.gettext('filters__sizes'),
    sort_by: facet_config__sortByName,
    unless_for_these_categories: [
      'sacs',
      'accessoires',
      'bijoux'
      ],
  },{
    name: 'livraison',
    header_text: i18n.gettext('filters__livraison'),
    only_if: function () { return false; },
  },{
    name: 'promotion',
    header_text: i18n.gettext('filters__promotion'),
    sort_by: facet_config__sortByName,
    getItem: function (item) {
      var klass = (true == item.active) ? ' active' : '';
      return '<li><a href="' + (item.url ? item.url : '#') + '" class="' + klass + '">&gt; ' + item.key + '% <small>(' + item.doc_count + ')</small></a> </li>';
    },
  }];

  function flatten_aggregations(aggregations) {
    var data = {};

    for(var key in aggregations) {
      var items = aggregations[key];
      var active_values = active_values_for_facet[ key ] || {};

      if(!items.buckets) // not an aggregation (probably price_min)
        continue;

      if(0 == items.buckets.length)
        continue ;

      items.buckets.forEach(function(item, idx) {

        item.url = '#';
        item.active = active_values[ item.key ] || false;

        data[ key ] = data[ key ] || [];
        data[ key ][ item.key ] = item;

      });
    };

    return data;
  }

  function init_price_filter() {
    $('#filter-price').html(
      Mustache.render(getTemplate('grid--filter--price'), {
        header: i18n.gettext('filters__price'),
      })
    );
  }

  function update_facets(flattened_aggregations, is_updating) {
    is_updating = is_updating || false;

    if(!is_updating)
      init_price_filter();

    facets_for_select.forEach(function(facet_config) {
      var facet_values = flattened_aggregations[facet_config.name];
      var active_values = active_values_for_facet[facet_config.name] || {};

      var number_of_active_values = Object.values(active_values).filter(function(v) {return true === v;}).length;

      if(true === is_updating) {
        var $header = $('#filter-' + facet_config.name + ' .filters--section--label');
        $header.html( facet_config.header_text );

        if(number_of_active_values > 0)
          $header.html( $header.html() + ' <small>(' + number_of_active_values + ')</small>' );
      }

      if(
        facet_config.only_if && false === facet_config.only_if()
        || facet_config.unless && true === facet_config.unless()
        ) {
        // console.debug('widget for "' + facet_config.name + '" was skipped (only_if OR unless)');
        return ;
      }

      if('undefined' == typeof facet_values) {
        // console.debug('no facet values for "' + facet_config.name + '": skipping');
        return ;
      }

      var categories = get_categories_list();

      if( facet_config.unless_for_these_categories
        && facet_config.unless_for_these_categories.some(function(category_to_skip) {
        if( categories.includes( category_to_skip ) ) {
          // console.debug('widget for "' + facet_config.name + '" was skipped because of "' + category_to_skip + '"');
          return true;
        }
      }) ) return;

      if( !we_are_on_search_page && categories.length == 0 || categories.length == 1 && categories[0] == 'vetements' ) {

        if( ! [
          'price',
          'gender',
          'promotion',
          'colors',
          'brand_original',
          'merchant_original',
          ].includes(facet_config.name) ) {
          // console.debug('widget for "' + facet_config.name + '" was skipped #3');
          return ;
        }

      }

      if(false === is_updating)
        $('#filter-' + facet_config.name).html(
          Mustache.render(getTemplate('grid--filter'), {
            header: facet_config.header_text,
          })
        );
      $('#filter-' + facet_config.name + ' .filter--section--list').empty();

      Object
        .entries(facet_values)
        .map(function(entry) { return entry[1]; })
        .sort(facet_config.sort_by ? facet_config.sort_by : facet_config__sortBy)
        .slice(0, facet_config.limit ? facet_config.limit : 200)
        .forEach(function(item, idx) {

          var html = (facet_config.getItem ? facet_config.getItem : facet_config__getItem)(item);

          $('#filter-' + facet_config.name + ' .filter--section--list').append(
            '<div class="ais-refinement-list--item filter--section--item item" data-facet-name="'
            + facet_config.name
            + '" data-facet-value="'
            + item.key
            + '"><div class="">'
            + html + '</div></div>'
          );
      });

    });

    add_shadow();
  }

  init();
  init_pagination();
  update_facets(VIEW_PARAMS.facets);
}

i18n = window.i18n({});
i18n.loadJSON(MESSAGES);

load_elastic();
