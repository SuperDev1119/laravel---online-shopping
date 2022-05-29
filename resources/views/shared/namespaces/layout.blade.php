@php
$title = _i('Meilleur site de Shopping en Ligne, Mode, Vêtement');
$description = _i('Les meilleures boutiques de mode en ligne Femme et Homme');
$suffix = ' | ' . config('app.site_name');
@endphp
<!DOCTYPE html>
<html lang="{{ explode('_', config('app.locale'))[0] }}">
  <head>
    @yield('prepend_head')

    <title>@yield('title', $title){{ $suffix }}</title>
    <meta name="description" content="@yield('description', $description)">
    @yield('seo')
    @yield('robots')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @yield('metas')

    <!-- TradeDoubler site verification {{ config('imports.TRADEDOUBLER.SITE_ID') }} -->
    <meta name="verify-admitad" content="{{ env('VERIFICATION_ADMITAD') }}" />
    <meta name="msvalidate.01" content="0E25FAE38E4604FF9D5A2D99F6FE89FA" />

    <meta name="verification"               content="43b26dba1f8249dc41efe5d018d935d9" />
    <meta name="google-site-verification"   content="4uvcw4bVck9YDN1RshOE1l3Xtqi9VEN_KrbwVN5wJiw" />
    <meta name="p:domain_verify"            content="77d35b5488dd148a42131ae448cfef40"/>

    <meta property="fb:app_id"              content="2794784317289154" />

    <meta property="og:url"                 content="{{ URL::current() }}" />
    <meta property="og:site_name"           content="{{ config('app.site_name') }}" />
    <meta property="og:locale"              content="{{ config('app.locale') }}" />

    <meta property="og:title"               content="@yield('title', $title)" />
    <meta property="og:description"         content="@yield('description', $description)" />

    <meta property="article:author"         content="{{ config('app.link_to_facebook') }}" />
    <meta property="article:publisher"      content="{{ config('app.link_to_facebook') }}" />

    <meta name="twitter:card"               content="summary" />
    <meta name="twitter:site"               content="{{ '@' . explode('/', config('app.link_to_twitter'))[3] }}" />
    <meta name="twitter:creator"            content="{{ '@' . explode('/', config('app.link_to_twitter'))[3] }}" />
    <meta name="twitter:title"              content="@yield('title', $title)" />
    <meta name="twitter:description"        content="@yield('description', $description)" />

    <meta itemprop="url"                    content="{{ URL::current() }}" />
    <meta itemprop="description"            content="@yield('description', $description)" />

    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="icon" type="image/x-icon" href="/favicon/favicon.ico" />

    <meta name="application-name" content="{{ config('app.site_name') }}"/>

    @yield('preload')
    <link rel="preload" as="font" href="/fonts/montserrat/Mont-Regular/Montserrat-Regular.woff" type="font/woff" crossorigin="anonymous">
    <link rel="preload" as="font" href="/fonts/montserrat/Mont-Bold/Montserrat-Bold.woff" type="font/woff" crossorigin="anonymous">
    <link rel="preload" as="font" href="/fonts/montserrat/Mont-SemiBold/Montserrat-SemiBold.woff" type="font/woff" crossorigin="anonymous">
    <link rel="preload" as="font" href="/fonts/montserrat/Mont-Light/Montserrat-Light.woff" type="font/woff" crossorigin="anonymous">
    <link rel="preload" as="font" href="/fonts/icons/Nouvelle-collection-typo.woff" type="font/woff" crossorigin="anonymous">

    <link rel="preload" as="script" href="{{ mix('js/app.js') }}">
    <link rel="preload" as="script" href="{{ mix('js/scripts/app.js') }}">

    <link rel="stylesheet" href="{{ mix('styles/style.css') }}">
    @yield('styles')

    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <link rel="search" type="application/opensearchdescription+xml" href="{{ route('opensearch', 1) }}" title="{{ config('app.site_name') }}">

    @yield('schema-org')

    @yield('append_head')
  </head>

  <body
    @if (!empty($data['gender'])) data-route-gender="{{ $data['gender']}}" @endif
    class="page no-js fixed @yield('namespace', '') @yield('page', 'page')">

    @include('googletagmanager::script')

    <script type="text/javascript">document.body.classList.remove('no-js')</script>

    <div class="overlay hidden"></div>

    @yield('body_content')

    @yield('templates')

    @section('javascripts')
      <script>
        var CONFIG = {
          LOCALE: '{{ config('app.locale') }}',
          CURRENCY: '{{ config('app.currency') }}',
          CURRENCY_SIGN: '{{ config('app.currency_sign') }}',
          THUMBOR_URLS: {!! json_encode(config('app.thumbor_urls')) !!},
          ELASTICSEARCH_URL: '{{ config('elasticsearch.connections.default.hosts.0.scheme') . '://' . config('elasticsearch.connections.default.hosts.0.host') . ':' . config('elasticsearch.connections.default.hosts.0.port') }}',
        };
      </script>
      <script>
        var MESSAGES = {!! json_encode(json_decode(@file_get_contents('../resources/lang/' . App::currentLocale() . '.json') ?: '{}')) !!};
      </script>
      <script>
        var DATA = {
          QUERY: '{{ Request::get('q') }}',
        };
      </script>

      @section('external_javascripts')
        <script src={{ asset('js/scripts/laroute.js', is_connection_secure()) }}></script>
        <script defer src={{ mix('js/app.js') }}></script>
        <script defer src={{ mix('js/scripts/app.js') }}></script>
      @show

      @if(config('sentry.dsn'))
        @if($sentry_id = @parse_url(config('sentry.dsn'), PHP_URL_USER))
          <script
            defer
            src="https://js.sentry-cdn.com/{{ $sentry_id }}.min.js"
            crossorigin="anonymous"
          ></script>
          <script>
            window.addEventListener('load', function() {
              var interval_sentry = setInterval(function() {
                if(!window.Sentry) return;
                clearInterval(interval_sentry);

                Sentry.onLoad(function() {
                  Sentry.init({
                    release: "{{ config('sentry.release') }}",
                    environment: "{{ config('app.heroku_app_name') }}",
                  });
                });
              }, 1000);
            });
          </script>
        @else
          <script
            defer
            src=https://browser.sentry-cdn.com/5.19.0/bundle.min.js
            integrity=sha384-edPCPWtQrj57nipnV3wt78Frrb12XdZsyMbmpIKZ9zZRi4uAxNWiC6S8xtGCqwDG
            crossorigin=anonymous></script>
          <script type="text/javascript" defer>window.addEventListener('load', function() {
            if('undefined' != typeof Sentry)
              Sentry.init({ dsn: '{{ config('sentry.dsn') }}' });
          });</script>
        @endif
      @endif
    @show
  </body>

</html>
