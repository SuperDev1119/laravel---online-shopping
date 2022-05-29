<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\NetaffiliationV3;

class NetaffiliationV3Test extends \Tests\Models\SourceTest
{
    public static $klass = NetaffiliationV3::class;

    public static $headers = 'Id product,Name,Internal reference,Price,Price excl.tax,Crossed prices,Shipping costs,Ecotax,Currency,Category,Id NetAff category,Category merchant,Url,Model,Brand,EAN,Description,Guarantee,Availability,Delivery delays,Quantity,Stock indicator,Novelty indicator,Discount indicator,Sales indicator,Performance indicator,Url small image,Url medium image,Url large image,Displays tracking url,Keywords,Constructor reference,Url image merchant';

    public function test__parse_row__from_Bazarchic()
    {
        // given
        $payload = 'WyI1MTIxMDE2MzAzNDYxIiwiU2xpcCBvbiBhdXRvbW5lIG11bHRpY29sb3JlcyIsIjEwMDAxOTAiLCIzNSwwMCIsIjAsMDAiLCIxMzAsMDAiLCI0LDI5IiwiMCwwMCIsIlx1MjBhYyIsIk5vbiBjbGFzc1x1MDBlOSIsIjIwIiwiRmVtbWUgPiBDaGF1c3N1cmVzID4gQmFza2V0cyIsImh0dHA6XC9cL2FjdGlvbi5tZXRhZmZpbGlhdGlvbi5jb21cL3Ryay5waHA/bWNsaWM9UDRGNERGNTY4MjMzMjQxUzFVRDUxMjEwMTYzMDM0NjFWMyIsIlZONDAwMyIsIkdvYnkiLCI4Njk4MDU4MDM4Njk4IiwiU2xpcC1vbiwgQSBlbmZpbGVyLCBNb3RpZiBzdXIgbCdlbnNlbWJsZSwgQm91dCBhcnJvbmRpLCBNdWx0aWNvbG9yZSwgRXh0XHUwMGU5cmlldXIgOiBDdWlyIFN5bnRoXHUwMGU5dGlxdWUsIEludFx1MDBlOXJpZXVyZSA6IEN1aXIgU3ludGhcdTAwZTl0aXF1ZSwgU2VtZWxsZSA6IFRoZXJtb3BsYXN0aXF1ZSIsIiIsIjQiLCIiLCIiLCIxIiwiMCIsIjAiLCIwIiwiMCIsImh0dHBzOlwvXC9jZG4uYmF6YXJjaGljLmNvbVwvaVwvdG1wXC8zMTQyMjQ2LmpwZyIsImh0dHBzOlwvXC9jZG4uYmF6YXJjaGljLmNvbVwvaVwvdG1wXC8zMTQyMjQ2LmpwZyIsImh0dHBzOlwvXC9jZG4uYmF6YXJjaGljLmNvbVwvaVwvdG1wXC8zMTQyMjQ2LmpwZyIsImh0dHA6XC9cL2FjdGlvbi5tZXRhZmZpbGlhdGlvbi5jb21cL3Ryay5waHA/bWFmZj1QNEY0REY1NjgyMzMyNDFTMVVENTEyMTAxNjMwMzQ2MVYzIiwiIiwiIiwiaHR0cHM6XC9cL2Nkbi5iYXphcmNoaWMuY29tXC9pXC90bXBcLzMxNDIyNDYuanBnIl0=';

        // when
        $expected_value = [
            'name' => 'Slip on automne multicolores',
            'slug' => 'slip-on-automne-multicolores-5121016303461',
            'description' => 'Slip-on, A enfiler, Motif sur l\'ensemble, Bout arrondi, Multicolore, Extérieur : Cuir Synthétique, Intérieure : Cuir Synthétique, Semelle : Thermoplastique',
            'brand_original' => 'Goby',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'femme > chaussures > baskets',
            'color_original' => '',
            'price' => 35.0,
            'old_price' => 130.0,
            'reduction' => 73.0,
            'url' => 'http://action.metaffiliation.com/trk.php?mclic=P4F4DF568233241S1UD5121016303461V3',
            'image_url' => 'https://cdn.bazarchic.com/i/tmp/3142246.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => 'VN4003',
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '',
            'livraison' => '4',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Spartoo()
    {
        // given
        $payload = 'WyI2NDIxNTAzNjMzODYwNSIsIkNoYXVzc3VyZXMgQXNoIFpBUFBJTkciLCIyMTMxNDgiLCIxOTUsMDAiLCIwLDAwIiwiMTk1LDAwIiwiMCwwMCIsIjAsMDAiLCJcdTIwYWMiLCJNb2RlICYgQWNjZXNzb2lyZXMiLCI3IiwiRmVtbWUgPiBDaGF1c3N1cmVzID4gQmFza2V0cyIsImh0dHA6XC9cL2FjdGlvbi5tZXRhZmZpbGlhdGlvbi5jb21cL3Ryay5waHA/bWNsaWM9UDM4NjY1NjgyMzMyNjJTMVVDNDM1Nzc2MzM4NjA1VjMiLCJaQVBQSU5HIiwiQXNoIiwiMCIsIkNoYXVzc3VyZXMgQXNoICBaQVBQSU5HICBNYXJyb24gRGlzcG9uaWJsZSBlbiB0YWlsbGUgZmVtbWUuIDQxLiAuIEZlbW1lID4gQ2hhdXNzdXJlcyA+IEJhc2tldHMuIiwiIiwiNzJoIiwiIiwiIiwiMSIsIjAiLCIyIiwiMCIsIjAiLCJodHRwczpcL1wvcGhvdG9zNi5zcGFydG9vLmNvbVwvcGhvdG9zXC8yMTNcLzIxMzE0OFwvMjEzMTQ4XzM1MF9BLmpwZyIsImh0dHBzOlwvXC9waG90b3M2LnNwYXJ0b28uY29tXC9waG90b3NcLzIxM1wvMjEzMTQ4XC8yMTMxNDhfMzUwX0EuanBnIiwiaHR0cHM6XC9cL3Bob3RvczYuc3BhcnRvby5jb21cL3Bob3Rvc1wvMjEzXC8yMTMxNDhcLzIxMzE0OF8zNTBfQS5qcGciLCJodHRwOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21hZmY9UDM4NjY1NjgyMzMyNjJTMVVDNDM1Nzc2MzM4NjA1VjMiLCIiLCJaQVBQSU5HLUNBTEZTVUVERS1TVE9ORSIsImh0dHBzOlwvXC9waG90b3M2LnNwYXJ0b28uY29tXC9waG90b3NcLzIxM1wvMjEzMTQ4XC8yMTMxNDhfMzUwX0EuanBnIl0=';

        // when
        $expected_value = [
            'name' => 'Chaussures Ash ZAPPING',
            'slug' => 'chaussures-ash-zapping-64215036338605',
            'description' => 'Chaussures Ash  ZAPPING  Marron Disponible en taille femme. 41. . Femme > Chaussures > Baskets.',
            'brand_original' => 'Ash',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'femme > chaussures > baskets',
            'color_original' => '',
            'price' => 195.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'http://action.metaffiliation.com/trk.php?mclic=P3866568233262S1UC435776338605V3',
            'image_url' => 'https://photos6.spartoo.com/photos/213/213148/213148_350_A.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => 'ZAPPING',
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '',
            'livraison' => '72h',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }
}
