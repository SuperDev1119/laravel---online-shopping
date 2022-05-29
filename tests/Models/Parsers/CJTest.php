<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\CJ;

class CJTest extends \Tests\Models\SourceTest
{
    public static $klass = CJ::class;

    public static $headers = 'PROGRAM_NAME,PROGRAM_URL,CATALOG_NAME,LAST_UPDATED,ID,TITLE,DESCRIPTION,LINK,IMPRESSION_URL,IMAGE_LINK,MOBILE_LINK,ADDITIONAL_IMAGE_LINK,AVAILABILITY,AVAILABILITY_DATE,EXPIRATION_DATE,PRICE,SALE_PRICE,SALE_PRICE_EFFECTIVE_DATE,UNIT_PRICING_MEASURE,UNIT_PRICING_BASE_MEASURE,INSTALLMENT,LOYALTY_POINTS,GOOGLE_PRODUCT_CATEGORY,GOOGLE_PRODUCT_CATEGORY_NAME,PRODUCT_TYPE,BRAND,GTIN,MPN,IDENTIFIER_EXISTS,CONDITION,ADULT,MULTIPACK,IS_BUNDLE,ENERGY_EFFICIENCY_CLASS,AGE_GROUP,COLOR,GENDER,MATERIAL,PATTERN,SIZE,SIZE_TYPE,SIZE_SYSTEM,ITEM_GROUP_ID,CUSTOM_LABEL_0,CUSTOM_LABEL_1,CUSTOM_LABEL_2,CUSTOM_LABEL_3,CUSTOM_LABEL_4,PROMOTION_ID,SHIPPING_LABEL,SHIPPING_WEIGHT,SHIPPING_LENGTH,SHIPPING_WIDTH,SHIPPING_HEIGHT,MIN_HANDLING_TIME,MAX_HANDLING_TIME,SHIPPING(COUNTRY:REGION:SERVICE:PRICE),SHIPPING(COUNTRY:POSTAL_CODE:SERVICE:PRICE),SHIPPING(COUNTRY:LOCATION_ID:SERVICE:PRICE),SHIPPING(COUNTRY:LOCATION_GROUP_NAME:SERVICE:PRICE),TAX(RATE:COUNTRY:TAX_SHIP:REGION),TAX(RATE:COUNTRY:TAX_SHIP:POSTAL_CODE),TAX(RATE:COUNTRY:TAX_SHIP:LOCATION_ID),TAX(RATE:COUNTRY:TAX_SHIP:LOCATION_GROUP_NAME)';

    public function test__parse_row__from_Mytheresa()
    {
        // given
        $payload = 'WyJNeXRoZXJlc2EgLSBGUiIsImh0dHA6XC9cL3d3dy5teXRoZXJlc2EuY29tXC8iLCJNeXRoZXJlc2FfRlJfRnJhbmNlLWZyLUVVUiAoR1NGKSIsIjIwMTktMTItMTdUMDU6NTY6MzguNTQ5LTA4OjAwIiwiUDAwMTkwMDE4LTEiLCJMdW5ldHRlcyBkZSBzb2xlaWwgU0wgNTEgTmV3IFNsaW0iLCJcdTAwYzAgbGFiZWwgaWNvbmlxdWUsIG1vZFx1MDBlOGxlIGljb25pcXVlLCB0ZWwgZXN0IGxlIG1lc3NhZ2UgZGUgbGEgbWFpc29uIFNhaW50IExhdXJlbnQgYXZlYyBsZXMgbHVuZXR0ZXMgZGUgc29sZWlsIFNMIDUxIE5ldyBTbGltLiIsImh0dHA6XC9cL3d3dy5rcXp5ZmouY29tXC9jbGljay03ODE0ODQ5LTEzNDYyNzUxP3VybD1odHRwcyUzQSUyRiUyRnd3dy5teXRoZXJlc2EuY29tJTJGZnItZnIlMkZzYWludC1sYXVyZW50LXNsLTUxLW5ldy1zbGltLXN1bmdsYXNzZXMtMTM5NDg4MC5odG1sIiwiaHR0cDpcL1wvd3d3LnRxbGtnLmNvbVwvaW1hZ2UtNzgxNDg0OS0xMzQ2Mjc1MSIsImh0dHBzOlwvXC9pbWcubXl0aGVyZXNhLmNvbVwvMTAwMFwvMTAwMFwvOTVcL2pwZWdcL2NhdGFsb2dcL3Byb2R1Y3RcL2ZhXC9QMDAxOTAwMTguanBnIiwiIiwiaHR0cHM6XC9cL2ltZy5teXRoZXJlc2EuY29tXC8xMDAwXC8xMDAwXC85NVwvanBlZ1wvY2F0YWxvZ1wvcHJvZHVjdFwvZmFcL1AwMDE5MDAxOF9kMS5qcGcsaHR0cHM6XC9cL2ltZy5teXRoZXJlc2EuY29tXC8xMDAwXC8xMDAwXC85NVwvanBlZ1wvY2F0YWxvZ1wvcHJvZHVjdFwvZmFcL1AwMDE5MDAxOF9kMi5qcGcsaHR0cHM6XC9cL2ltZy5teXRoZXJlc2EuY29tXC8xMDAwXC8xMDAwXC85NVwvanBlZ1wvY2F0YWxvZ1wvcHJvZHVjdFwvZmFcL1AwMDE5MDAxOF9kMy5qcGciLCJpbiBzdG9jayIsIiIsIiIsIjI3NS4wMCBFVVIiLCIyNzUuMDAgRVVSIiwiIiwiIiwiIiwiIiwiIiwiMTc4IiwiVlx1MDBlYXRlbWVudHMgZXQgYWNjZXNzb2lyZXMgPiBBY2Nlc3NvaXJlcyBkJ2hhYmlsbGVtZW50ID4gTHVuZXR0ZXMgZGUgc29sZWlsIiwiQWNjZXNzb2lyZXM+THVuZXR0ZXMgZGUgc29sZWlsIiwiU2FpbnQgTGF1cmVudCIsIiIsIlAwMDE5MDAxOC0xIiwieWVzIiwibmV3IiwiIiwiIiwiIiwiIiwiYWR1bHQiLCJub2lyIiwiZmVtYWxlIiwic3ludGhldGljIGdsYXNzZXMsIEZEQSBSZWc6IDEwMDUwMzg1LCBNREw6RDI1MzA0OCIsInNhbnMgbW90aWYiLCJPTkUgU0laRSIsInJlZ3VsYXIiLCJGUiIsIlAwMDE5MDAxOCIsIm1hdFx1MDBlOXJpYXVcdTAwYTA6IGFjXHUwMGU5dGF0ZX5jb3VsZXVyIGRlcyB2ZXJyZXMgOiBub2lyfmNvdWxldXIgZGUgbGEgbW9udHVyZSA6IG5vaXJ+Y2F0XHUwMGU5Z29yaWUgZHUgZmlsdHJlXHUwMGEwOiAzfkZhYnJpcXVcdTAwZTkgZW4gSXRhbGllIH5saXZyXHUwMGU5ZXMgYXZlYyBtaWNyb2ZpYnJlIGRlIG5ldHRveWFnZSwgbGl2clx1MDBlOWVzIGF2ZWMgXHUwMGU5dHVpIHBvcnRhbnQgbGUgbG9nbyBkdSBkZXNpZ25lciIsIlNTMjAiLCIiLCJORVcgQVJSSVZBTCIsIiIsIiIsIiIsIiIsIiIsIiIsIiIsIjIiLCIzIiwiRlI6OjowLjAwIEVVUiIsIiIsIiIsIiIsIiIsIiIsIiIsIiJd';

        // when
        $expected_value = [
            'name' => 'Lunettes de soleil SL 51 New Slim',
            'slug' => 'lunettes-de-soleil-sl-51-new-slim-p00190018-1',
            'description' => 'À label iconique, modèle iconique, tel est le message de la maison Saint Laurent avec les lunettes de soleil SL 51 New Slim.',
            'brand_original' => 'Saint Laurent',
            'merchant_original' => 'Mytheresa',
            'currency_original' => 'EUR',
            'category_original' => 'vêtements et accessoires > accessoires d\'habillement > lunettes de soleil|accessoires>lunettes de soleil',
            'color_original' => 'noir',
            'price' => 275.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'http://www.kqzyfj.com/click-7814849-13462751?url=https%3A%2F%2Fwww.mytheresa.com%2Ffr-fr%2Fsaint-laurent-sl-51-new-slim-sunglasses-1394880.html',
            'image_url' => 'https://img.mytheresa.com/500/500/80/jpeg/catalog/product/fa/P00190018.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'synthetic glasses',
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
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_TheKooples()
    {
        // given
        $payload = 'WyJUaGUgS29vcGxlcyIsImh0dHBzOlwvXC93d3cudGhla29vcGxlcy5jb21cL2VuIiwiU2ltcGxlIERFIiwiMjAyMC0wMS0wNFQwMzowMzoyNS45ODEtMDg6MDAiLCIzNjE1ODcwMzM3ODEwIiwiVGhlIEtvb3BsZXMgLSBHcmF1ZXMgQmF1bXdvbGwtVC1TaGlydCBtaXQgVG90ZW5rb3BmLUJhZGdlIC0gREFNRU4iLCJEaWVzZXMgZ3JhdWUgQmF1bXdvbGwtVC1TaGlydCBicmluZ3QgZGVuIHJvY2tpZ2VuIFN0aWwgdW5zZXJlcyBIYXVzZXMgenVtIEF1c2RydWNrIHVuZCB0clx1MDBlNGd0IGdsZWljaHplaXRpZyBkaWUgY2hhcmFrdGVyaXN0aXNjaGVuIEVsZW1lbnRlIGRlcyBBdGhsZWlzdXJlLVN0aWxzLiBEaWUgVmVyYXJiZWl0dW5nIGF1cyBKZXJzZXkgdmVybGVpaHQgZGVtIE1vZGVsbCBlaW5lIGxlaWNodGUgU3RydWt0dXIsIGRpZSBzaWNoIGhlcnZvcnJhZ2VuZCBmXHUwMGZjciBoZWlcdTAwZGZlIFNvbW1lcnRhZ2UgZWlnbmV0LiBVbSBlaW5lbiBLb250cmFzdGVmZmVrdCB6dSBzY2hhZmZlbiwgaGF0IFRoZSBLb29wbGVzIGRhcyBNb2RlbGwgYXVmIGRlciBWb3JkZXJzZWl0ZSBtaXQgZWluZW0ga2xlaW5lbiBUb3RlbmtvcGYtQmFkZ2UgdmVyc2VoZW4uIFRyYWdlbiBTaWUgZGFzIGxcdTAwZTRzc2lnZSBULVNoaXJ0IHp1IGRlbiBCYXNpY3MgSWhyZXMgS2xlaWRlcnNjaHJhbmtzLCBldHdhIHp1IGVpbmVyIFNraW5ueS1KZWFucywgZWluZXIga3VyemVuIFNwb3J0aG9zZSBvZGVyIGVpbmVyIENoaW5vaG9zZS4gLSBHUkFVIC0gREFNRU4iLCJodHRwOlwvXC93d3cuZHBib2x2dy5uZXRcL2NsaWNrLTc4MTQ4NDktMTM2MjAxMjQ/dXJsPWh0dHBzJTNBJTJGJTJGd3d3LnRoZWtvb3BsZXMuY29tJTJGZGVfZGUlMkZncmF1ZXMtYmF1bXdvbGwtdC1zaGlydC1taXQtdG90ZW5rb3BmLWJhZGdlLWh0c2MxOTAzMWtncnk0MS5odG1sIiwiaHR0cDpcL1wvd3d3LnRxbGtnLmNvbVwvaW1hZ2UtNzgxNDg0OS0xMzYyMDEyNCIsImh0dHBzOlwvXC93d3cudGhla29vcGxlcy5jb21cL21lZGlhXC9jYXRhbG9nXC9wcm9kdWN0XC8xXC84XC8xODQxMS5qcGVnIiwiIiwiaHR0cHM6XC9cL3d3dy50aGVrb29wbGVzLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcLzFcLzRcLzE0OTA0LmpwZWcsaHR0cHM6XC9cL3d3dy50aGVrb29wbGVzLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcLzFcLzhcLzE4NDExLmpwZWcsaHR0cHM6XC9cL3d3dy50aGVrb29wbGVzLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcLzFcLzRcLzE0OTA1LmpwZWcsaHR0cHM6XC9cL3d3dy50aGVrb29wbGVzLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcLzFcLzhcLzE4NDEwLmpwZWcsaHR0cHM6XC9cL3d3dy50aGVrb29wbGVzLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcLzFcLzRcLzE0OTA2LmpwZWcsaHR0cHM6XC9cL3d3dy50aGVrb29wbGVzLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcLzFcLzRcLzE0OTA3LmpwZWcsaHR0cHM6XC9cL3d3dy50aGVrb29wbGVzLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcLzFcLzRcLzE0OTA4LmpwZWcsaHR0cHM6XC9cL3d3dy50aGVrb29wbGVzLmNvbVwvbWVkaWFcL2NhdGFsb2dcL3Byb2R1Y3RcLzFcLzRcLzE0OTA5LmpwZWciLCJpbiBzdG9jayIsIiIsIiIsIjc4LjAwIEVVUiIsIjQ2LjUwIEVVUiIsIiIsIiIsIiIsIiIsIiIsIjE2MDQiLCJCZWtsZWlkdW5nICYgQWNjZXNzb2lyZXMgPiBCZWtsZWlkdW5nIiwiSGVycmVuID4gU2FsZSxIZXJyZW4gPiBCZWtsZWlkdW5nLEhlcnJlbiA+IFNhbGUgPiBULVNoaXJ0cyxIZXJyZW4gPiBCZWtsZWlkdW5nID4gVC1TaGlydHMsSGVycmVuID4gQmVrbGVpZHVuZyA+IE11c3QgSGF2ZSIsIjAwMSIsIjM2MTU4NzAzMzc4MTAiLCJIVFNDMTkwMzFLR1JZNDEiLCJ5ZXMiLCJuZXciLCIiLCIiLCIiLCIiLCJhZHVsdCIsIkdSSSIsIm1hbGUiLCIiLCIiLCJNIiwiIiwiIiwiSFRTQzE5MDMxS0dSWTQxIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiMTgwLjAwZyIsIiIsIiIsIiIsIiIsIiIsIkRFOjo6MC4wMCBFVVIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiXQ==';

        // when
        $expected_value = [
            'name' => 'Graues Baumwoll-T-Shirt mit Totenkopf-Badge - DAMEN',
            'slug' => 'the-kooples-graues-baumwoll-t-shirt-mit-totenkopf-badge-damen-3615870337810',
            'description' => 'Dieses graue Baumwoll-T-Shirt bringt den rockigen Stil unseres Hauses zum Ausdruck und trägt gleichzeitig die charakteristischen Elemente des Athleisure-Stils. Die Verarbeitung aus Jersey verleiht dem Modell eine leichte Struktur, die sich hervorragend für heiße Sommertage eignet. Um einen Kontrasteffekt zu schaffen, hat The Kooples das Modell auf der Vorderseite mit einem kleinen Totenkopf-Badge versehen. Tragen Sie das lässige T-Shirt zu den Basics Ihres Kleiderschranks, etwa zu einer Skinny-Jeans, einer kurzen Sporthose oder einer Chinohose. - GRAU - DAMEN',
            'brand_original' => 'The Kooples',
            'merchant_original' => 'The Kooples',
            'currency_original' => 'EUR',
            'category_original' => 'bekleidung & accessoires > bekleidung|herren > sale,herren > bekleidung,herren > sale > t-shirts,herren > bekleidung > t-shirts,herren > bekleidung > must have',
            'color_original' => 'gri',
            'price' => 46.5,
            'old_price' => 78.0,
            'reduction' => 40.0,
            'url' => 'http://www.dpbolvw.net/click-7814849-13620124?url=https%3A%2F%2Fwww.thekooples.com%2Fde_de%2Fgraues-baumwoll-t-shirt-mit-totenkopf-badge-htsc19031kgry41.html',
            'image_url' => 'https://www.thekooples.com/media/catalog/product/1/8/18411.jpeg',
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
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Shein()
    {
        // given
        $payload = 'WyJTSEVJTiIsImh0dHBzOlwvXC93d3cuU0hFSU4uY29tIiwiRnJlbmNoIExhbmd1YWdlIEZlZWQgU0hFSU4iLCIyMDIwLTA2LTI5VDAyOjM1OjIyLjQzMS0wNzowMCIsInN3bmVjazE4MjAwNDAyNDMyIiwiMSBwaVx1MDBlOGNlIENvbGxpZXIgYXZlYyBwZW5kZW50aWYgZGUgY1x1MDE1M3VyIiwiTXVsdGljb2xvcmUgQ2FzdWFsICAgICBDb2xsaWVycyBhdmVjIHBlbmRlbnRpZiAgICBDb2xsaWVycywgc2l6ZSBmZWF0dXJlcyBhcmU6QnVzdDogLExlbmd0aDogICxTbGVldmUgTGVuZ3RoOiIsImh0dHBzOlwvXC93d3cuZHBib2x2dy5uZXRcL2NsaWNrLTc4MTQ4NDktMTM4NDY4NDg/dXJsPWh0dHBzJTNBJTJGJTJGZnIuc2hlaW4uY29tJTJGMXBjLVJvc2UtUGF0dGVybi1IZWFydC1DaGFybS1OZWNrbGFjZS1wLTEwODcyOTUtY2F0LTE3NTUuaHRtbCUzRnJlZiUzRGNqJTI2YWZmaWxpYXRlSUQlM0QlM0NQSUQlM0UtJTNDQ0lEJTNFJTI2dXJsX2Zyb20lM0Rjai5jb20lMjZ1dG1fY2FtcGFpZ24lM0RjanByb2ZlZWQyMDA2Mjlfc3duZWNrMTgyMDA0MDI0MzIiLCJodHRwczpcL1wvd3d3LnRxbGtnLmNvbVwvaW1hZ2UtNzgxNDg0OS0xMzg0Njg0OCIsImh0dHA6XC9cL2ltZy5sdHdlYnN0YXRpYy5jb21cL2ltYWdlczNfcGlcLzIwMjBcLzA0XC8wMlwvMTU4NTgwMDQ3OTBjOTFkZTI5YWZkZDFjYjUzZmEzYTQzOGVhY2UxODRjX3RodW1ibmFpbF8yMjB4MjkzLmpwZyIsIiIsImh0dHA6XC9cL2ltZy5sdHdlYnN0YXRpYy5jb21cL2ltYWdlczNfcGlcLzIwMjBcLzA0XC8wMlwvMTU4NTgwMDQ3MTMxODM4MDA1YThjNWJkODc5ZDNhMzJlYTFkYTg2MDU1X3RodW1ibmFpbF8yMjB4MjkzLmpwZyxodHRwOlwvXC9pbWcubHR3ZWJzdGF0aWMuY29tXC9pbWFnZXMzX3BpXC8yMDIwXC8wNFwvMDJcLzE1ODU4MDA0NzVlZTI1M2ZhMjI4NGU4NzQ2OThiM2FkMTU0ZjlkNTk1MV90aHVtYm5haWxfMjIweDI5My5qcGciLCJpbiBzdG9jayIsIiIsIiIsIjIuOTkgRVVSIiwiMi45OSBFVVIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCJTSEVJTiIsIiIsInN3bmVjazE4MjAwNDAyNDMyIiwieWVzIiwibmV3IiwiIiwiIiwiIiwiIiwiIiwiTXVsdGljb2xvcmUiLCJmZW1hbGUiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCI6Ojo0LjQ5IEVVUiIsIiIsIiIsIiIsIiIsIiIsIiIsIiJd';

        // when
        $expected_value = [
            'name' => 'Pièce Collier avec pendentif de cœur',
            'slug' => '1-pi-ce-collier-avec-pendentif-de-c-ur-swneck18200402432',
            'description' => 'Multicolore Casual     Colliers avec pendentif    Colliers, size features are:Bust: ,Length:  ,Sleeve Length:',
            'brand_original' => 'SHEIN',
            'merchant_original' => 'SHEIN',
            'currency_original' => 'EUR',
            'category_original' => '',
            'color_original' => 'multicolore',
            'price' => 2.99,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://www.dpbolvw.net/click-7814849-13846848?url=https%3A%2F%2Ffr.shein.com%2F1pc-Rose-Pattern-Heart-Charm-Necklace-p-1087295-cat-1755.html%3Fref%3Dcj%26affiliateID%3D%3CPID%3E-%3CCID%3E%26url_from%3Dcj.com%26utm_campaign%3Dcjprofeed200629_swneck18200402432',
            'image_url' => 'https://img.ltwebstatic.com/images3_pi/2020/04/02/15858004790c91de29afdd1cb53fa3a438eace184c.jpg',
            'gender' => 'femme',
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
      $this->parse_payload($payload),
    );
    }
}
