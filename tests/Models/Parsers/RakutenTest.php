<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Rakuten;

class RakutenTest extends \Tests\Models\SourceTest
{
    public static $klass = Rakuten::class;

    public static $headers = 'Product ID,Product Name,SKU Number,Primary Category,Secondary Category(ies),Product URL,Product Image URL,Buy URL,Short description of product.,Long Product,Description,Discount Type,Sale Price,Retail Price,Begin Date,End Date,Brand,Shipping,Keyword(s),Manufacturer Part #,Manufacturer Name,Shipping Information,Availability,Universal Product Code,Class ID,Currency,M1,Pixel,Miscellaneous,Product Type,Size,Material,Color,Gender,Style,Age,Attribute 9,Attribute 10,Attribute 11,Attribute 12,Attribute 13,Attribute 14,Attribute 15,Attribute 16,Attribute 17,Attribute 18,Attribute 19,Attribute 20,Attribute 21,Modification';

    public function test__parse_row__from_Zadig()
    {
        // given
        $payload = 'WyIxMzg4NSIsIlQtc2hpcnQgU3RvcnkgRmlzaG5ldCBCbGFuYyAtIFRhaWxsZSBMIC0gRmVtbWUgLSBaYWRpZyAmIFZvbHRhaXJlIiwiV0dUUzE4MDVGXzUiLCJTYWxlIiwiV29tZW5+flNlZSBFdmVyeXRoaW5nIiwiaHR0cHM6XC9cL2NsaWNrLmxpbmtzeW5lcmd5LmNvbVwvbGluaz9pZD1McXRJOVwvbVJES00mb2ZmZXJpZD04MDgxNzAuMTM4ODUmdHlwZT0xNSZtdXJsPWh0dHBzJTNBJTJGJTJGemFkaWctZXQtdm9sdGFpcmUuY29tJTJGZXUlMkZmciUyRnAlMkZXR1RTMTgwNUZfQkxBTiUyRnQtc2hpcnQtZmVtbWUtdC1zaGlydC1zdG9yeS1maXNobmV0LWJsYW5jLXdndHMxODA1ZiIsImh0dHBzOlwvXC96YWRpZy1ldC12b2x0YWlyZS5pbWdpeC5uZXRcL1wvV1wvR1wvV0dUUzE4MDVGX0JMQU5DX1NRVUFSRV8yMDIwMDkxODE2NTkuanBnIiwiIiwiVC1zaGlydCBibGFuYyBmZW1tZSB6YWRpZyAmIHZvbHRhaXJlLCBjb2wgdiwgYWdyXHUwMGU5bWVudFx1MDBlOSBkJ3VuIG1vdGlmIFx1MDBlOWNsYWlyIGF1IGRvcyBmb3JtXHUwMGU5IHBhciBkZXMgZFx1MDBlOWNvdXBlcyBhdSBsYXNlciBpbmNydXN0XHUwMGU5ZXMgZGUgclx1MDBlOXNpbGxlLiIsIlQtc2hpcnQgYmxhbmMgZmVtbWUgemFkaWcgJiB2b2x0YWlyZSwgY29sIHYsIGFnclx1MDBlOW1lbnRcdTAwZTkgZCd1biBtb3RpZiBcdTAwZTljbGFpciBhdSBkb3MgZm9ybVx1MDBlOSBwYXIgZGVzIGRcdTAwZTljb3VwZXMgYXUgbGFzZXIgaW5jcnVzdFx1MDBlOWVzIGRlIHJcdTAwZTlzaWxsZS4iLCIiLCJhbW91bnQiLCI2Ni4wMCIsIjk1LjAwIiwiIiwiIiwiWmFkaWcgJiBWb2x0YWlyZSIsIiIsIiIsIldHVFMxODA1Rl81IiwiIiwiIiwiaW4tc3RvY2siLCIwMzYwNzYyMTk2MDk3MiIsIjYwIiwiRVVSIiwiaHR0cHM6XC9cL3phZGlnLWV0LXZvbHRhaXJlLmltZ2l4Lm5ldFwvXC9XXC9HXC9XR1RTMTgwNUZfQkxBTl8yLmpwZz93PTY4MyZoPTEwMjQgaHR0cHM6XC9cL3phZGlnLWV0LXZvbHRhaXJlLmltZ2l4Lm5ldFwvXC9XXC9HXC9XR1RTMTgwNUZfQkxBTl8zLmpwZz93PTY4MyZoPTEwMjQiLCJodHRwczpcL1wvYWQubGlua3N5bmVyZ3kuY29tXC9mcy1iaW5cL3Nob3c/aWQ9THF0STlcL21SREtNJmJpZHM9ODA4MTcwLjEzODg1JnR5cGU9MTUmc3ViaWQ9MCIsIldHVFMxODA1RiIsIiIsIkwiLCIxMDAlIENvdG9uIiwiQmxhbmMiLCJmZW1hbGUiLCIiLCJhZHVsdCIsIiIsIiJd';

        // when
        $expected_value = [
            'name' => 'T-shirt Story Fishnet - Taille L',
            'slug' => 't-shirt-story-fishnet-blanc-taille-l-femme-zadig-voltaire-13885',
            'description' => 'T-shirt blanc femme zadig & voltaire, col v, agrémenté d\'un motif éclair au dos formé par des découpes au laser incrustées de résille.',
            'brand_original' => 'Zadig & Voltaire',
            'merchant_original' => 'Zadig & Voltaire',
            'currency_original' => 'EUR',
            'category_original' => 'sale|women~~see everything',
            'color_original' => 'blanc',
            'price' => 66.0,
            'old_price' => 95.0,
            'reduction' => 31.0,
            'url' => 'https://click.linksynergy.com/link?id=LqtI9/mRDKM&offerid=808170.13885&type=15&murl=https%3A%2F%2Fzadig-et-voltaire.com%2Feu%2Ffr%2Fp%2FWGTS1805F_BLAN%2Ft-shirt-femme-t-shirt-story-fishnet-blanc-wgts1805f',
            'image_url' => 'https://zadig-et-voltaire.imgix.net//W/G/WGTS1805F_BLANC_SQUARE_202009181659.jpg',
            'gender' => 'femme',
            'col' => 'col v',
            'coupe' => '',
            'manches' => '',
            'material' => 'coton',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'L',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }
}
