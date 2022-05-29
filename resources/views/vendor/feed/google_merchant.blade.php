<?=
/* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0"
    xmlns:g="http://base.google.com/ns/1.0">
    <channel>
        <title><![CDATA[{{ $meta['title'] }}]]></title>
        <link><![CDATA[{{ url($meta['link']) }}]]></link>
        <description><![CDATA[{{ $meta['description'] }}]]></description>
        <language>{{ $meta['language'] }}</language>

        @foreach($items as $item)
            <item>
                <g:id><![CDATA[{{ md5($item->slug) }}]]></g:id>
                <g:mpn><![CDATA[{{ md5($item->slug) }}]]></g:mpn>
                <g:title><![CDATA[{{ $item->title }}]]></g:title>
                <g:description><![CDATA[{{ $item->summary }}]]></g:description>
                <g:link>{{ url($item->link) }}</g:link>
                <g:image_link>{{ url(\App\Libraries\Cloudinary::get($item->image)) }}</g:image_link>
                <g:condition><![CDATA[new]]></g:condition>
                <g:availability><![CDATA[in stock]]></g:availability>
                <g:price>{{ $item->price . ' ' . $item->currency }}</g:price>
                <g:brand><![CDATA[{{ $item->brand }}]]></g:brand>
                <g:gender><![CDATA[{{ $item->gender }}]]></g:gender>
                <g:age_group><![CDATA[adult]]></g:age_group>
                <g:color><![CDATA[{{ $item->color }}]]></g:color>
                <g:material><![CDATA[{{ $item->material }}]]></g:material>
                <g:size><![CDATA[{{ $item->size }}]]></g:size>

                <g:shipping>
                    <g:country>FR</g:country>
                    <g:service>Par la marque</g:service>
                    <g:price>0 EUR</g:price>
                </g:shipping>

                @foreach($item->category as $category)
                    <g:google_product_type><![CDATA[{{ $item->gender . ' > ' . $category->title }}]]></g:google_product_type>
                    @if($category->google_product_category)
                        <g:google_product_category><![CDATA[{{ $category->google_product_category->name }}]]></g:google_product_category>
                    @endif
                @endforeach
            </item>
        @endforeach
    </channel>
</rss>
