<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Tradetracker;

class TradetrackerTest extends \Tests\Models\SourceTest
{
    public static $klass = Tradetracker::class;

    public function test__parse_row__from_Yoins_Femme()
    {
        self::$headers = 'product ID,name,currency,price,description,productURL,imageURL,categories,fromPrice,discount,categoryPath,subcategories,subsubcategories,gender,size,stock,sizeStock,sale,brand,deliveryTime,deliveryCosts,color,material';

        // given
        $payload = 'WyJTS1VBNzEzNjciLCJTd2VhdCBcdTAwZTAgY2FwdWNoZSBjb3VydCBjb3VydCBncmlzIiwiRVVSIiwiMTQuNDEiLCJQb3J0ZXogY2Ugc3dlYXQgXHUwMGUwIGNhcHVjaGUgYXZlYyB1biBqZWFuIHNraW5ueSB0YWlsbGUgaGF1dGUgcG91ciB1biBsb29rIHBhcmZhaXQuIEF2ZWMgcHVsbCwgY29yZG9uIGRlIHNlcnJhZ2UgXHUwMGUwIGxhIHRhaWxsZSBldCBtYW5jaGVzIGxvbmd1ZXMuIFZvdXMgXHUwMGVhdGVzIHNcdTAwZmJyIGQnYXR0cmFwZXIgbGVzIHlldXggZGVzIGdlbnMuIEp1c3RlIHByZW5kcy1sZS4iLCJodHRwczpcL1wvdGMudHJhZGV0cmFja2VyLm5ldFwvP2M9MjM2NDcmbT05NzEwNDMmYT0zNzYwMTQmdT1odHRwcyUzQSUyRiUyRnd3dy55b2lucy5jb20lMkZmciUyRkdyZXktRHJhd3N0cmluZy1XYWlzdC1Mb25nLVNsZWV2ZXMtTG9vc2UtQ3JvcHBlZC1Ib29kaWUtcC0xMzgzMjI5Lmh0bWwlM0ZjdXJyZW5jeSUzREVVUiUyNnN0eWxlJTNEMSIsImh0dHBzOlwvXC9pbWFnZXMuY2hpY2Nkbi5jb21cL3RodW1iXC9zb3VyY2VcL29hdXBsb2FkXC95b2luc1wvaW1hZ2VzXC83MVwvNTdcL2UwZDQ2NTdkLTNlYjktNDRiOC05NWYzLWI3MGM2NDJlOGYwZC5qcGVnIiwiVE9QUyIsIjI1LjI1IiwiNDMuMDAiLCIzMjE5PjMyMjUiLCJTd2VhdHNoaXJ0cyIsIiIsImZlbW1lcyIsInhzfHN8bSIsIjEiLCJ4cz0xfHM9MXxtPTIiLCJZZXMiLCJZb2lucyIsIjctMjAgZGF5cyIsIjIuNzAiLCJHcmlzIiwiQ290b25cL1BvbHllc3RlciJd';

        // when
        $expected_value = [
            'name' => 'Sweat à capuche court court gris',
            'slug' => 'sweat-capuche-court-court-gris-skua71367',
            'description' => 'Portez ce sweat à capuche avec un jean skinny taille haute pour un look parfait. Avec pull, cordon de serrage à la taille et manches longues. Vous êtes sûr d\'attraper les yeux des gens. Juste prends-le.',
            'brand_original' => 'Yoins',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'tops|sweatshirts',
            'color_original' => 'gris',
            'price' => 14.41,
            'old_price' => 25.25,
            'reduction' => 43.0,
            'url' => 'https://tc.tradetracker.net/?c=23647&m=971043&a=376014&u=https%3A%2F%2Fwww.yoins.com%2Ffr%2FGrey-Drawstring-Waist-Long-Sleeves-Loose-Cropped-Hoodie-p-1383229.html%3Fcurrency%3DEUR%26style%3D1',
            'image_url' => 'https://images.chiccdn.com/thumb/source/oaupload/yoins/images/71/57/e0d4657d-3eb9-44b8-95f3-b70c642e8f0d.jpeg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => 'manches longues',
            'material' => 'coton|polyester',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'XS|S|M',
            'livraison' => '7-20 days',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Ulla_Popken_Homme()
    {
        self::$headers = 'product ID,name,currency,price,description,productURL,imageURL,categories,item_group_id,sale_price,shipping,imageURL_2,availability,product_type,condition,gtin,mpn,brand,color,size,gender,age_group,material,expiration_date,custom_label_1,custom_label_2,custom_label_4,sale_price_effective_date,display_ads_title,promotion_id';

        // given
        $payload = 'WyI2NzY2NzE1MCIsIkNhbGVcdTAwZTdvbnMgSG9tbWUgKHRhaWxsZSA2LCByb3VnZSBmb25jXHUwMGU5XC9ibGV1IG1hcmluZSBmb25jXHUwMGU5KSB8IEpQMTg4MCBTb3VzLXZcdTAwZWF0ZW1lbnRzIHwgY290b24iLCJFVVIiLCIyNS45OSIsIkxlcyBjYWxlXHUwMGU3b25zIGVuIGxvdCBkZSAyLiBDZWludHVyZSBcdTAwZTlsYXN0aXF1ZSwgZmVybWV0dXJlIHBhciBib3V0b24uIiwiaHR0cHM6XC9cL3RjLnRyYWRldHJhY2tlci5uZXRcLz9jPTI4ODQ4Jm09MTQ5NDAwMSZhPTM3NjAxNCZ1PWh0dHBzJTNBJTJGJTJGd3d3LnVsbGFwb3BrZW4uZnIlMkZwcm9kdWl0JTJGNjc2NjcxNTAtMTQ0MyUyRiIsImh0dHBzOlwvXC9hc3NldHMudWxsYXBvcGtlbi5kZVwvaW1hZ2VzXC9wcm9kdWN0c1wvNjc2NjcxNTBfbW9kZWxfZ18wMS5qcGc/aW1wb2xpY3k9cmVzaXplX3dpZHRoJndpZHRoPTgyMCIsIkFwcGFyZWwgJiBBY2Nlc3NvcmllcyA+IENsb3RoaW5nID4gVW5kZXJ3ZWFyICYgU29ja3MgPiBVbmRlcndlYXIiLCI2NzY2NzEiLCIiLCI1LjUwIiwiaHR0cHM6XC9cL2Fzc2V0cy51bGxhcG9wa2VuLmRlXC9pbWFnZXNcL3Byb2R1Y3RzXC82NzY2NzE1MF9tb2RlbF9nXzAyLmpwZz9pbXBvbGljeT1yZXNpemVfd2lkdGgmd2lkdGg9ODIwIiwiaW4gc3RvY2siLCJNb2RlIE1hc2N1bGluZSA+IFNvdXMtdlx1MDBlYXRlbWVudHMgJiBQeWphbWFzID4gU291cy12XHUwMGVhdGVtZW50cyIsIm5ldyIsIjQwNjI0NzgxOTM4NDAiLCI2NzY2NzE1MC0xNDQzIiwiSlAxODgwIiwicm91Z2UgZm9uY1x1MDBlOVwvYmxldSBtYXJpbmUgZm9uY1x1MDBlOSIsIjYiLCJNYWxlIiwiMCIsImNvdG9uIiwiMjAyMC0wNC0yMCIsIjAiLCIwIiwiIiwiIiwiQ2FsZVx1MDBlN29ucyAtIEdyYW5kZSBUYWlsbGUgSlAxODgwIiwiU2Vhc29uX09wZW5pbmdfT2t0Il0=';

        // when
        $expected_value = [
            'name' => 'Caleçons Homme',
            'slug' => 'cale-ons-homme-67667150',
            'description' => 'Les caleçons en lot de 2. Ceinture élastique, fermeture par bouton.',
            'brand_original' => 'JP1880',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'apparel & accessories|clothing|underwear & socks|underwear',
            'color_original' => 'rouge foncé|bleu marine foncé',
            'price' => 25.99,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://tc.tradetracker.net/?c=28848&m=1494001&a=376014&u=https%3A%2F%2Fwww.ullapopken.fr%2Fproduit%2F67667150-1443%2F',
            'image_url' => 'https://assets.ullapopken.de/images/products/67667150_model_g_01.jpg?impolicy=resize_width&width=820',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'coton',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '6',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_GStar_Femme()
    {
        self::$headers = 'product ID,name,currency,price,description,productURL,imageURL,categories,fromPrice,currency,categoryPath,deliveryTime,shipping,gender,color,extra_MainColor,fabric,brand,availability,EAN';

        // given
        $payload = 'WyJEMTU3MzQtQjg1MS1CMDI2IiwiSGF1dCBWZWx2IFJpbmdlciBPcHRpYyBTbGltIiwiRVVSIiwiNTkuOTUiLCJVbmUgbWF0aVx1MDBlOHJlIGVuIGplcnNleSBmaW4sIHByXHUwMGU5c2VudGFudCB1biBpbXByaW1cdTAwZTkgZmxvcXVcdTAwZTkgbXVsdGljb2xvcmUgXHUwMGUwIG1vdGlmIGNhbW91ZmxhZ2UuIERvc1x1MDBhMDogNTglIENvdG9uLCAzOSUgUG9seWVzdGVyIChSZWN5Y2xcdTAwZTkpLCAzJSBcdTAwYzlsYXN0aGFubmUgTWF6YXJpbmUgQmx1ZVwvTGVnaW9uIEJsdWUgQWxsb3ZlciIsImh0dHBzOlwvXC90Yy50cmFkZXRyYWNrZXIubmV0XC8/Yz0xNzc0MiZtPTE3MzkwNTImYT0zNzYwMTQmdT1odHRwcyUzQSUyRiUyRmFhYS5hcnRlZmFjdC5jb20lMkZ0cmNrJTJGZWNsaWNrJTJGYzI1NjBlMjlkZDFhN2FmOTAwZWZiODQxNTIyYWFlZGQlM0Zwcm9kaWQlM0REMTU3MzQtQjg1MS1CMDI2JTI2ZmlkJTNENzElMjZUeXBlJTNEWlhoMGNtRmZVSEp2WkhWamRGVlNUQSUzRCUzRCIsImh0dHBzOlwvXC9hYWEuYXJ0ZWZhY3QuY29tXC90cmNrXC9ldmlld1wvYzI1NjBlMjlkZDFhN2FmOTAwZWZiODQxNTIyYWFlZGQ/cHJvZGlkPUQxNTczNC1CODUxLUIwMjYmZmlkPTcxIiwiVC1TaGlydHMiLCI1OS45NSIsIkVVUiIsIldvbWVuXC9ULVNoaXJ0cyIsIlZvdHJlIGNvbW1hbmRlIHNlcmEgZXhwXHUwMGU5ZGlcdTAwZTllIHNvdXMgMS0yIGpvdXIocykuIiwiMC4wMCIsImZlbWFsZSIsIk1hemFyaW5lIEJsdWVcL0xlZ2lvbiBCbHVlIEFvIiwiQmxldSBtb3llbiIsIlZlbHZldCBqYWNxIGplcnNleSBjbG91ZCBjIGFvIiwiRy1TdGFyIFJBVyIsIjEiLCI4NzE5NzY4NzQ2NjU2Il0=';

        // when
        $expected_value = [
            'name' => 'Haut Velv Ringer Optic Slim',
            'slug' => 'haut-velv-ringer-optic-slim-d15734-b851-b026',
            'description' => 'Une matière en jersey fin, présentant un imprimé floqué multicolore à motif camouflage. Dos : 58% Coton, 39% Polyester (Recyclé), 3% Élasthanne Mazarine Blue/Legion Blue Allover',
            'brand_original' => 'G-Star RAW',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 't-shirts',
            'color_original' => 'mazarine blue|legion blue ao|bleu moyen',
            'price' => 59.95,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://tc.tradetracker.net/?c=17742&m=1739052&a=376014&u=https%3A%2F%2Faaa.artefact.com%2Ftrck%2Feclick%2Fc2560e29dd1a7af900efb841522aaedd%3Fprodid%3DD15734-B851-B026%26fid%3D71%26Type%3DZXh0cmFfUHJvZHVjdFVSTA%3D%3D',
            'image_url' => 'https://aaa.artefact.com/trck/eview/c2560e29dd1a7af900efb841522aaedd?prodid=D15734-B851-B026&fid=71',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'velvet jacq jersey cloud c ao',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '',
            'livraison' => 'Votre commande sera expédiée sous 1-2 jour(s).',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Deichmann()
    {
        self::$headers = 'product ID,name,currency,price,description,productURL,imageURL,categories,description_short,article_number,extra_KategorieId,category,manufacturer,image_url,shipping,extra_ProduktID,extra_Farbe,extra_Streichpreis,extra_Streichpreistyp,extra_Gr_en,extra_Asset,extra_KategoriepfadName,extra_KategoriepfadCode,extra_Zielgruppe,extra_Sichtbar,extra_Bild2,extra_Bild3,extra_stock,EAN,extra_margin,extra_Size,extra_Material,extra_SizeRange';

        // given
        $payload = 'WyJlOWIyZWNhMjZhNDFmZjc2ZDAxM2UzNmJiYmUzNzgzYjU1YmQ0M2FkIiwiU2FuZGFsZXMiLCJFVVIiLCIxMy45MCIsIiIsImh0dHBzOlwvXC90Yy50cmFkZXRyYWNrZXIubmV0XC8/Yz0yNzgyOCZtPTE3MjEwMjcmYT0zNzYwMTQmdT1odHRwcyUzQSUyRiUyRmFhYS5hcnRlZmFjdC5jb20lMkZ0cmNrJTJGZWNsaWNrJTJGN2QzMzFkZDgzZWIzNWJlNTM4MTEwYjljYmQ0ODJjYzMlM0Zwcm9kaWQlM0QxMjEwNjY3JTI2ZmlkJTNEMzgiLCIiLCIiLCIiLCIxMjEwNjY3IiwiMDAwMTYzMTU3NWhvbWUtcHJvbW90aW9ucy1zb2xkZXNmZW1tZXMiLCJTb2xkZXMgRmVtbWVzIiwiR3JhY2VsYW5kIiwiaHR0cHM6XC9cL2FhYS5hcnRlZmFjdC5jb21cL3RyY2tcL2V2aWV3XC83ZDMzMWRkODNlYjM1YmU1MzgxMTBiOWNiZDQ4MmNjMz9wcm9kaWQ9MTIxMDY2NyZmaWQ9MzgiLCIwLjAwIiwiMDAwMDAwMDE1OTUzNDgiLCJvcmFuZ2UiLCIxOSw5MCIsImRpc2NvdW50IiwiNDBNLDM4TSwzNk0sMzlNLDM3TSIsIjE1OTUzNDhfUCIsIlwvUHJvbW90aW9uc1wvU29sZGVzIEZlbW1lcyIsIlwvaG9tZS1wcm9tb3Rpb25zXC9ob21lLXByb21vdGlvbnMtc29sZGVzZmVtbWVzIiwiRmVtbWVzIiwidHJ1ZSIsImh0dHBzOlwvXC9hYWEuYXJ0ZWZhY3QuY29tXC90cmNrXC9lY2xpY2tcLzdkMzMxZGQ4M2ViMzViZTUzODExMGI5Y2JkNDgyY2MzP3Byb2RpZD0xMjEwNjY3JmZpZD0zOCZUeXBlPVpYaDBjbUZmUW1sc1pEST0iLCJodHRwczpcL1wvYWFhLmFydGVmYWN0LmNvbVwvdHJja1wvZWNsaWNrXC83ZDMzMWRkODNlYjM1YmU1MzgxMTBiOWNiZDQ4MmNjMz9wcm9kaWQ9MTIxMDY2NyZmaWQ9MzgmVHlwZT1aWGgwY21GZlFtbHNaRE09IiwiMzY4IiwiIiwiQyIsIjM2TSwzN00sMzhNLDM5TSw0ME0sNDFNLDQyTSIsIlN5bnRoXHUwMGU5dGlxdWUsUG9seXVyXHUwMGU5dGhhbmUsU3ludGhcdTAwZTl0aXF1ZSxUUFIiLCI3MSJd';

        // when
        $expected_value = [
            'name' => 'Sandales',
            'slug' => 'sandales-e9b2eca26a41ff76d013e36bbbe3783b55bd43ad',
            'description' => '',
            'brand_original' => 'Graceland',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'promotions|soldes femmes',
            'color_original' => 'orange',
            'price' => 13.90,
            'old_price' => 19.90,
            'reduction' => 30,
            'url' => 'https://tc.tradetracker.net/?c=27828&m=1721027&a=376014&u=https%3A%2F%2Faaa.artefact.com%2Ftrck%2Feclick%2F7d331dd83eb35be538110b9cbd482cc3%3Fprodid%3D1210667%26fid%3D38',
            'image_url' => 'https://aaa.artefact.com/trck/eview/7d331dd83eb35be538110b9cbd482cc3?prodid=1210667&fid=38',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'synthetique|polyurethane|tpr',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '36M|37M|38M|39M|40M|41M|42M',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }
}
