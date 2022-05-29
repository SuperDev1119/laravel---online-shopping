<?= '<?xml' ?> version="1.0" encoding="UTF-8"?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/" xmlns:moz="http://www.mozilla.org/2006/browser/search/">
    <ShortName>{{ config('app.site_name') }}</ShortName>
    <Description>{{ config('app.site_name') }}</Description>
    <Url type="text/html" method="get" template="{{ route('get.products.search') }}/?q={searchTerms}"/>
    <Image width="16" height="16">{{ asset('images/logo.svg', is_connection_secure()) }}</Image>
    <InputEncoding>UTF-8</InputEncoding>
    <moz:SearchForm>{{ config('app.url') }}</moz:SearchForm>
</OpenSearchDescription>
