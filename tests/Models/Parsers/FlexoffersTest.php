<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Flexoffers;

class FlexoffersTest extends \Tests\Models\SourceTest
{
    public static $klass = Flexoffers::class;

    public static $headers = '';

    public function test__parse_row__from_Moncler_men()
    {
        // given
        $headers = 'pid,name,description,categoryId,category,imageUrl,price,priceCurrency,finalPrice,isInStock,brand,manufacturer,mpn,upcorean,sku,color,gender,condition,deepLinkUrl,linkUrl';
        $payload = 'eyJwaWQiOiIxNzg2MzkuMi41REQ5MzI4MTBBNUJFRkIxLjMyRTZDQUU5NTRBNTQ1MEEuMjg0NTc3LTgwNTMzMDgyMDczOTAiLCJuYW1lIjoiTW9uY2xlciAtIE1hdGhpZXUgU25lYWtlcnMgV2hpdGUgMzMgKFVLIDEpIiwiZGVzY3JpcHRpb24iOiIgTWFkZSBpbiBJdGFseSBMZWF0aGVyIHVwcGVyIFBhZGRlZCBjb2xsYXIgTGFjZSBhdCB0aGUgZnJvbnQgTGVhdGhlciBpbnNvbGUgTm9uLXNsaXAgc29sZSIsImNhdGVnb3J5SWQiOiIxODciLCJjYXRlZ29yeSI6IkFwcGFyZWwgJiBBY2Nlc3NvcmllcyA+IFNob2VzIiwiaW1hZ2VVcmwiOiJodHRwOlwvXC93d3cubWVsaWpvZS5jb21cL2ltYWdlc1wvMTA1NDI2XC9jYXJkX2xhcmdlLmpwZyIsInByaWNlIjoiNDYwLjAwIiwicHJpY2VDdXJyZW5jeSI6IlVTRCIsImZpbmFsUHJpY2UiOiI0NjAuMDAiLCJpc0luU3RvY2siOiJUcnVlIiwiYnJhbmQiOiJNb25jbGVyIiwibWFudWZhY3R1cmVyIjoiTW9uY2xlciIsIm1wbiI6IjRNNzAzMjAwMlM5VSIsInVwY29yZWFuIjoiODA1MzMwODIwNzM5MCIsInNrdSI6IjI4NDU3Ny04MDUzMzA4MjA3MzkwIiwiY29sb3IiOiJXaGl0ZSIsImdlbmRlciI6Im1hbGUiLCJjb25kaXRpb24iOiJuZXciLCJkZWVwTGlua1VybCI6Imh0dHA6XC9cL3d3dy5tZWxpam9lLmNvbVwvZW5cL3Byb2R1Y3RcLzg3NjMwXC9tYXRoaWV1LXNuZWFrZXJzLXdoaXRlP2NvdW50cnlfb3ZlcnJpZGU9VVMiLCJsaW5rVXJsIjoiaHR0cHM6XC9cL3RyYWNrLmZsZXhsaW5rcy5jb21cL3AuYXNoeD9mb2M9MTAyJmZvcGlkPTExODQ2NTEuMTc4NjM5LjIuNUREOTMyODEwQTVCRUZCMS4zMkU2Q0FFOTU0QTU0NTBBLjI4NDU3Ny04MDUzMzA4MjA3MzkwIn0=';

        $expected_value = [
            'name' => 'Mathieu Sneakers 33 (UK 1)',
            'slug' => 'moncler-mathieu-sneakers-white-33-uk-1-178639-2-5dd932810a5befb1-32e6cae954a5450a-284577-8053308207390',
            'description' => 'Made in Italy Leather upper Padded collar Lace at the front Leather insole Non-slip sole',
            'brand_original' => 'Moncler',
            'merchant_original' => 'Moncler',
            'currency_original' => 'USD',
            'category_original' => 'apparel & accessories > shoes',
            'color_original' => 'white',
            'price' => 460.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://track.flexlinks.com/p.ashx?foc=102&fopid=1184651.178639.2.5DD932810A5BEFB1.32E6CAE954A5450A.284577-8053308207390',
            'image_url' => 'http://www.melijoe.com/images/105426/card_large.jpg',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Designers_Remix_Girls_unisex()
    {
        // given
        $headers = 'pid,name,shortDescription,description,imageUrl,price,priceCurrency,salePrice,finalPrice,isInStock,brand,mpn,sku,color,gender,size,deepLinkUrl,linkUrl';
        $payload = 'eyJwaWQiOiIxOTg5MTMuMS5BODZDLjlDRUI3OThFNzdDQ0ZCMi4xNDk2OCIsIm5hbWUiOiJCTEFCQkVSIEdVTU1ZIiwic2hvcnREZXNjcmlwdGlvbiI6IkNlcyBzYW5kYWxlcyBlbiB0aXNzdSBjaGF0b3lhbnQgc2UgZmVybWVudCBcdTAwZTAgbCdhaWRlIGRlIGJyaWRlcyBWZWxjcm8gZXQgYXJib3JlbnQgdW5lIGJyaWRlIGFycmlcdTAwZThyZS4gRWxsZXMgcmVwb3NlbnQgc3VyIHVuZSBzZW1lbGxlIGVuIGNhb3V0Y2hvdWMgQmxhYmJlciBtYXJxdVx1MDBlOWUgZHUgbG9nby4iLCJkZXNjcmlwdGlvbiI6IkNlcyBzYW5kYWxlcyBlbiB0aXNzdSBjaGF0b3lhbnQgc2UgZmVybWVudCBcdTAwZTAgbCdhaWRlIGRlIGJyaWRlcyBWZWxjcm8gZXQgYXJib3JlbnQgdW5lIGJyaWRlIGFycmlcdTAwZThyZS4gRWxsZXMgcmVwb3NlbnQgc3VyIHVuZSBzZW1lbGxlIGVuIGNhb3V0Y2hvdWMgQmxhYmJlciBtYXJxdVx1MDBlOWUgZHUgbG9nby4iLCJpbWFnZVVybCI6Imh0dHBzOlwvXC93d3cuZ2l1c2VwcGV6YW5vdHRpLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcL1JcL1NcL1JTMDAwNTcwMDFfQV8xXzEuanBnIiwicHJpY2UiOiI2NTAuMDAiLCJwcmljZUN1cnJlbmN5IjoiNjUwIiwic2FsZVByaWNlIjoiMzI1LjAwIiwiZmluYWxQcmljZSI6IjMyNS4wMCIsImlzSW5TdG9jayI6IlRydWUiLCJicmFuZCI6IkdpdXNlcHBlIFphbm90dGkiLCJtcG4iOiJSUzAwMDU3MDAxMDMiLCJza3UiOiIxNDk2OCIsImNvbG9yIjoiTXVsdGljb2xvcmUiLCJnZW5kZXIiOiJmZW1hbGUiLCJzaXplIjoiSVQzNiIsImRlZXBMaW5rVXJsIjoiaHR0cHM6XC9cL3d3dy5naXVzZXBwZXphbm90dGkuY29tXC9mclwvYmxhYmJlci1ndW1teS1yczAwMDU3MDAxP19fX3N0b3JlPWZyIiwibGlua1VybCI6Imh0dHBzOlwvXC90cmFjay5mbGV4bGlua3MuY29tXC9wLmFzaHg/Zm9jPTEwMiZmb3BpZD0xMTg0NjUxLjE5ODkxMy4xLkE4NkMuOUNFQjc5OEU3N0NDRkIyLjE0OTY4In0=';

        $expected_value = [
            'name' => 'BLABBER GUMMY',
            'slug' => 'blabber-gummy-198913-1-a86c-9ceb798e77ccfb2-14968',
            'description' => 'Ces sandales en tissu chatoyant se ferment à l\'aide de brides Velcro et arborent une bride arrière. Elles reposent sur une semelle en caoutchouc Blabber marquée du logo.',
            'brand_original' => 'Giuseppe Zanotti',
            'merchant_original' => 'Giuseppe Zanotti',
            'currency_original' => 'EUR',
            'category_original' => '',
            'color_original' => 'multicolore',
            'price' => 325.0,
            'old_price' => 650.0,
            'reduction' => 50.0,
            'url' => 'https://track.flexlinks.com/p.ashx?foc=102&fopid=1184651.198913.1.A86C.9CEB798E77CCFB2.14968',
            'image_url' => 'https://www.giuseppezanotti.com/media/catalog/product/R/S/RS00057001_A_1_1.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'IT36',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Adidas_women()
    {
        // given
        $headers = 'pid,name,description,imageUrl,price,finalPrice,isInStock,brand,manufacturer,upcorean,sku,color,gender,size,deepLinkUrl,linkUrl';
        $payload = 'eyJwaWQiOiIxOTEzNDQuMTU2MTc4LjU5ODkuNjAzRTc0QzE5LmFkaSIsIm5hbWUiOiJhZGlkYXMgQWRpemVybyBXb21lbidzIEJvb3R5IFNob3J0cyIsImRlc2NyaXB0aW9uIjoiYWRpZGFzIEFkaXplcm8gV29tZW4ncyBCb290eSBTaG9ydHMgICAgU3RheSBmb2N1c2VkIG9uIHlvdXIgc3RyaWRlIGluIHRoZXNlIHdvbWVuJ3MgcmFjaW5nIHJ1bm5pbmcgc2hvcnRzLiBUaGUgc2hvcnRzIGh1ZyB0aGUgbGVncyBhbmQgdG9yc28gd2l0aCBhIG1lZGl1bSBjb21wcmVzc2lvbiBmaXQsIHdoaWxlIHRoZWlyIENsaW1hbGl0ZSBmYWJyaWMga2VlcHMgeW91IGRyeSBhbmQgY29tZm9ydGFibGUgYnkgbW92aW5nIHN3ZWF0IGF3YXkgZnJvbSB5b3VyIHNraW4uICAgIFRoZSBhZGlkYXMgQWRpemVybyBXb21lbidzIEJvb3R5IFNob3J0cyBhcmUgZW5yaWNoZWQgd2l0aCBDbGltYWxpdGUgdGVjaG5vbG9neSB3aGljaCB3b3JrcyB0byB3aWNrIHN3ZWF0IGF3YXkgZnJvbSB0aGUgc2tpbiBvbiB0byB0aGUgb3V0ZXIgbGF5ZXIgb2YgdGhlIGdhcm1lbnQgd2hlcmUgaXQgY2FuIGJlIGV2YXBvcmF0ZWQsIGxlYXZpbmcgeW91IGZlZWxpbmcgY29vbCwgZHJ5IGFuZCBjb21mb3J0YWJsZS4gVGhlIG1lZGl1bSBjb21wcmVzc2lvbiBmaXQgcHJvdmlkZXMgYSBjb21mb3J0YWJsZSBhbmQgc3VwcG9ydGl2ZSBmZWVsLCB3aGlsc3QgdGhlIGZsYXRsb2NrIHNlYW1zIHByZXZlbnQgY2hhZmluZyBhbmQgc2tpbiBpcnJpdGF0aW9uLiBUaGUgc3RyZXRjaCBmYWJyaWMgY29uc3RydWN0aW9uIHByb3ZpZGVzIG1heGltdW0gZnJlZWRvbSBvZiBtb3ZlbWVudCwgYXMgeW91ciBjbG90aGluZyBjaG9pY2Ugc2hvdWxkIG5ldmVyIGluaGliaXQgeW91ciBwZXJmb3JtYW5jZS4gU2lsdmVyIHJlZmxlY3RpdmUgc3RyaXBlcyBvbiBlYWNoIHNpZGUgaGVscCB0byBpbXByb3ZlIHZpc2liaWxpdHkgaW4gbG93LWxpZ2h0IGNvbmRpdGlvbnMuICAgIFNpemUgR3VpZGUgIFdhaXN0IFNpemluZzogWCBTbWFsbCAoNC02KTogMjRcIi0yNlwiICBcLyAgU21hbGwgKDgtMTApOiAyN1wiLTI4XCIgIFwvICBNZWRpdW0gKDEyLTE0KTogMjlcIi0zMVwiICBcLyAgTGFyZ2UgKDE2LTE4KTogMzJcIi0zNFwiICBcLyAgWCBMYXJnZSAoMjAtMjIpOiAzNVwiLTM3XCIgIEhpcCBTaXppbmc6IFggU21hbGwgKDQtNik6IDM0XCItMzZcIiAgXC8gIFNtYWxsICg4LTEwKTogMzdcIi0zOFwiICBcLyAgTWVkaXVtICgxMi0xNCk6IDM5XCItNDFcIiAgXC8gIExhcmdlICgxNi0xOCk6IDQyXCItNDNcIiAgXC8gIFggTGFyZ2UgKDIwLTIyKTogNDRcIi00NlwiICBJbnNlYW0gU2l6aW5nOiBYIFNtYWxsICg0LTYpOiAzMC43XCIgIFwvICBTbWFsbCAoOC0xMCk6IDMwLjlcIiAgXC8gIE1lZGl1bSAoMTItMTQpOiAzMS4xXCIgIFwvICBMYXJnZSAoMTYtMTgpOiAzMS4zXCIgIFwvICBYIExhcmdlICgyMC0yMik6IDMxLjVcIiIsImltYWdlVXJsIjoiaHR0cHM6XC9cL2Nkbi5zcG9ydHNzaG9lcy5jb21cL3Byb2R1Y3RcL0FcL0FESTEyODU0XC9BREkxMjg1NF8xMDAwXzIuanBnIiwicHJpY2UiOiIxMS4xOSIsImZpbmFsUHJpY2UiOiIxMS4xOSIsImlzSW5TdG9jayI6IlRydWUiLCJicmFuZCI6IkFkaWRhcyIsIm1hbnVmYWN0dXJlciI6IkFkaWRhcyIsInVwY29yZWFuIjoiNDA1NzI4ODMzMjY4OCIsInNrdSI6ImFkaSIsImNvbG9yIjoiQmxhY2sgXC8gQmx1ZSIsImdlbmRlciI6IndvbWVucyIsInNpemUiOiJNZWRpdW0iLCJkZWVwTGlua1VybCI6Imh0dHBzOlwvXC93d3cuc3BvcnRzc2hvZXMuY29tXC9mci1mclwvcHJvZHVpdFwvYWRpMTI4NTQiLCJsaW5rVXJsIjoiaHR0cHM6XC9cL3RyYWNrLmZsZXhsaW5rcy5jb21cL3AuYXNoeD9mb2M9MTAyJmZvcGlkPTExODQ2NTEuMTkxMzQ0LjE1NjE3OC41OTg5LjYwM0U3NEMxOS5hZGkifQ==';

        $expected_value = [
            'name' => 'Adidas Adizero Women\'s Booty Shorts',
            'slug' => 'adidas-adizero-women-s-booty-shorts-191344-156178-5989-603e74c19-adi',
            'description' => 'adidas Adizero Women\'s Booty Shorts    Stay focused on your stride in these women\'s racing running shorts. The shorts hug the legs and torso with a medium compression fit, while their Climalite fabric keeps you dry and comfortable by moving sweat away from your skin.    The adidas Adizero Women\'s Booty Shorts are enriched with Climalite technology which works to wick sweat away from the skin on to the outer layer of the garment where it can be evaporated, leaving you feeling cool, dry and comfortable. The medium compression fit provides a comfortable and supportive feel, whilst the flatlock seams prevent chafing and skin irritation. The stretch fabric construction provides maximum freedom of movement, as your clothing choice should never inhibit your performance. Silver reflective stripes on each side help to improve visibility in low-light conditions.    Size Guide  Waist Sizing: X Small (4-6): 24"-26"  /  Small (8-10): 27"-28"  /  Medium (12-14): 29"-31"  /  Large (16-18): 32"-34"  /  X Large (20-22): 35"-37"  Hip Sizing: X Small (4-6): 34"-36"  /  Small (8-10): 37"-38"  /  Medium (12-14): 39"-41"  /  Large (16-18): 42"-43"  /  X Large (20-22): 44"-46"  Inseam Sizing: X Small (4-6): 30.7"  /  Small (8-10): 30.9"  /  Medium (12-14): 31.1"  /  Large (16-18): 31.3"  /  X Large (20-22): 31.5"',
            'brand_original' => 'Adidas',
            'merchant_original' => 'Adidas',
            'currency_original' => 'EUR',
            'category_original' => '',
            'color_original' => 'black|blue',
            'price' => 11.19,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://track.flexlinks.com/p.ashx?foc=102&fopid=1184651.191344.156178.5989.603E74C19.adi',
            'image_url' => 'https://cdn.sportsshoes.com/product/A/ADI12854/ADI12854_1000_2.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'MEDIUM',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }
}
