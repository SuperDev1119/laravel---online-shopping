@extends('shared.namespaces.layout')

@section('body_content')
  @cache('shared.partials.header', null, App\Models\Category::CACHING_TIME_ALL)

  <main class="main">
    @yield('content')
  </main>

  @cache('shared.partials.footer',
    null,
    null,
    create_cache_key(request()->route() ? @request()->route()->getAction()['as'] : 'no-route')
  )

  @section('templates')
    @cache('shared.templates.search.dropdown-menu')
  @stop
@stop
