<?=
/* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0"
    xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title><![CDATA[{{ $meta['title'] }}]]></title>
        <link><![CDATA[{{ url($meta['link']) }}]]></link>
        <description><![CDATA[{{ $meta['description'] }}]]></description>
        <language>{{ $meta['language'] }}</language>
        <pubDate>{{ $meta['updated'] }}</pubDate>
        <atom:link href="{{ URL::current() }}" rel="self" type="application/rss+xml" />

        @foreach($items as $item)
            <item>
                <id><![CDATA[{{ $item->slug }}]]></id>
                <mpn><![CDATA[{{ md5($item->slug) }}]]></mpn>
                <title><![CDATA[{{ $item->title }}]]></title>
                <link>{{ url($item->link) }}</link>
                <description><![CDATA[{!! $item->summary !!}]]></description>
                <author>hello@modalova.com (modalova)</author>
                <guid isPermaLink="false">{{ url($item->slug) }}</guid>
                <pubDate>{{ $item->updated->toRssString() }}</pubDate>
                <enclosure url="{{ url(\App\Libraries\Cloudinary::get($item->image)) }}" type="audio/jpeg" length="78645" />

                <price>{{ $item->price . ' ' . $item->currency }}</price>
                <availability><![CDATA[in stock]]></availability>
                <image_link>{{ url(\App\Libraries\Cloudinary::get($item->image)) }}</image_link>
                <condition><![CDATA[new]]></condition>
                <brand><![CDATA[{{ $item->brand }}]]></brand>

                <color><![CDATA[{{ $item->color }}]]></color>
                <material><![CDATA[{{ $item->material }}]]></material>
                <size><![CDATA[{{ $item->size }}]]></size>
                <gender><![CDATA[{{ $item->gender }}]]></gender>

                <age_group><![CDATA[adult]]></age_group>

                @foreach($item->category as $category)
                    <product_type><![CDATA[{{ $item->gender . ' > ' . $category->title }}]]></product_type>
                    @if($category->google_product_category)
                        <google_product_category><![CDATA[{{ $category->google_product_category->name }}]]></google_product_category>
                    @endif
                @endforeach
            </item>
        @endforeach
    </channel>
</rss>
