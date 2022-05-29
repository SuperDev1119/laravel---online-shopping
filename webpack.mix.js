const mix = require('laravel-mix');

mix
  .sass('resources/styles/style.scss', 'public/styles/style.css')
  .js('resources/scripts/app.js', 'public/js')
  .scripts([
    'resources/scripts/lib/jquery.simplePagination.js',
    'resources/scripts/lib/_gettext.js',
    'resources/scripts/lib/_mustache.js',
    'resources/scripts/lib/jquery.autocomplete.js',

    'resources/scripts/pages/statics/faq.js',

    'resources/scripts/shared/partials/header.js',
    'resources/scripts/shared/partials/detecting_scroll_direction.js',
    'resources/scripts/shared/common.js',

    'resources/scripts/elasticsearch_for_grid.js',
    'resources/scripts/pages/search/search_elasticsearch.js',
    ], 'public/js/scripts/app.js')
  .browserSync({
    proxy: 'localhost:8002',
  })

if (mix.inProduction())
  mix.version();
else
  mix.sourceMaps();

/* Optional: uncomment for bootstrap fonts */
// mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/fonts/bootstrap');
