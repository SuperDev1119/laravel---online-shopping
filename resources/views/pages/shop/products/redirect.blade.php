@extends('shared.namespaces.base')

@section('title'){{ Str::limit($data['product']['name'], 60) }}@stop
@section('page') page-shop-redirect @stop
@section('robots')<meta name="robots" content="NOINDEX">@stop
@section('seo')<link rel="canonical" href="{{ route('get.products.product', ['product' => $data['product']['slug']]) }}" />@stop

@section('append_head')
	<meta http-equiv="refresh" content="3; url={!! $data['product']['url'] !!}">
	<script>
	window.setTimeout(function(){
		window.location.href = {!! json_encode($data['product']['url']) !!};
	}, 3000);
	</script>
@stop

@section('body_content')
	<div class="content-redirect">
		<div class="logo">
			<img src="{{ asset('images/logo.svg', is_connection_secure()) }}" alt="Logo - {{ config('app.site_name') }}">
		</div>

		<div class="loading-redirect"></div>

		<div class="merchant-redirect">
			<span>{!! _i("Redirection vers le site <a rel='nofollow' href='%s'>%s</a>", [
				'url' => $data['product']['url'],
				'merchant_name' => $data['product']['merchant_original'],
			]) !!}</span>
			<br><br>
			<span style="text-decoration: underline; font-style: italic;">{!! _i("<a rel='nofollow' href='%s'>Cliquez ici si vous n'êtes pas automatiquement redirigé.</a>", [
				'url' => $data['product']['url'],
			]) !!}</span>
		</div>
	</div>
@stop

@section('external_javascripts')@stop
@section('templates')@stop
