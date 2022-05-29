<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Partnerize;

class PartnerizeTest extends \Tests\Models\SourceTest
{
    public static $klass = Partnerize::class;

    public static $headers = 'additional_image_link_0,additional_image_link_1,additional_image_link_2,additional_image_link_3,adult,age_group,availability,brand,category,categoryurl,CategoryAndBrandURL,color,condition,currency_code,custom_label_0,custom_label_1,custom_label_2,custom_label_3,custom_label_4,delivery_label,description,description_short,discount_figure,discount_percentage,discount_rate,gender,google_product_category,gtin,id,image_link,link,material,mobile_link,mpn,msg_discount,msg_shipping,new_in,pattern,price,price_without_currency_symbol,product_type,sale_price,sale_price_effective_date,sale_price_without_currency_symbol,shipping,shipping_country,shipped_from,shipping_price,shipping_service,size,size_standard,size_type,storeid,storename,sub_category_url,subsubcategory,sub_sub_category_and_brand_url,third_category_url,title,total_stock,top_products,SubCategoryAndBrandURL,item_group_id,best_seller';

    /**
     * @group ignore
     */
    public function test__parse_row__from_Converse()
    {
        // given
        $payload = 'WyJodHRwczpcL1wvY2RuLWltYWdlcy5mYXJmZXRjaC1jb250ZW50cy5jb21cLzEwXC80MlwvODNcLzcyXC8xMDQyODM3Ml8yMTc5MjEyXzEwMDAuanBnIiwiaHR0cHM6XC9cL2Nkbi1pbWFnZXMuZmFyZmV0Y2gtY29udGVudHMuY29tXC8xMFwvNDJcLzgzXC83MlwvMTA0MjgzNzJfMjE3OTIxM18xMDAwLmpwZyIsImh0dHBzOlwvXC9jZG4taW1hZ2VzLmZhcmZldGNoLWNvbnRlbnRzLmNvbVwvMTBcLzQyXC84M1wvNzJcLzEwNDI4MzcyXzIxNzkyMTRfMTAwMC5qcGciLCIiLCJubyIsIkFkdWx0IiwiaW4gc3RvY2siLCJDb252ZXJzZSIsIkNoYXVzc3VyZXMiLCJodHRwczpcL1wvcHJmLmhuXC9jbGlja1wvY2FtcmVmOjEwMTFsN015bVwvY3JlYXRpdmVyZWY6MTEwMWwzODgzMlwvZGVzdGluYXRpb246aHR0cHM6XC9cL3d3dy5mYXJmZXRjaC5jb21cL2ZyXC9zaG9wcGluZ1wvd29tZW5cL2NoYXVzc3VyZXNcL2l0ZW1zLmFzcHgiLCJodHRwczpcL1wvcHJmLmhuXC9jbGlja1wvY2FtcmVmOjEwMTFsN015bVwvY3JlYXRpdmVyZWY6MTEwMWwzODgzMlwvZGVzdGluYXRpb246aHR0cHM6XC9cL3d3dy5mYXJmZXRjaC5jb21cL2ZyXC9zaG9wcGluZ1wvd29tZW5cL2NvbnZlcnNlXC9jaGF1c3N1cmVzXC9pdGVtcy5hc3B4IiwiUm91Z2UiLCJuZXciLCJFVVIiLCJGZW1hbGUiLCJTUzEzIiwiTFVYRSIsIjUwMC0xMDAwIiwicm91Z2UiLCJOb3JtYWwiLCJMby10b3Agd29ybiBzdHJpcGVkIGluIHJlZCBmcm9tIENvbnZlcnNlLiBUaGlzIGNhbnZhcyBzbmVha2VyIGZlYXR1cmVzIGEgcm91bmQgY2FwIHRvZSwgbGFjZSB1cCBkZXRhaWwsIHdvcm4gb3V0IHN0cmlwZXMgcHJpbnQgdGhyb3VnaG91dCwgYW5kIGZsYXQgcnViYmVyIHNvbGUuIiwibG8tdG9wIHN0cmlwZWQgc25lYWtlciIsIjAuMDAiLCIwJSIsIjEiLCJGZW1hbGUiLCIxNjA0IiwiMDAyMjg2NDEwNDI4MSIsIjEwNDI4MzcyIiwiaHR0cHM6XC9cL2Nkbi1pbWFnZXMuZmFyZmV0Y2gtY29udGVudHMuY29tXC8xMFwvNDJcLzgzXC83MlwvMTA0MjgzNzJfMjE3OTIxMV8xMDAwLmpwZyIsImh0dHBzOlwvXC9wcmYuaG5cL2NsaWNrXC9jYW1yZWY6MTAxMWw3TXltXC9jcmVhdGl2ZXJlZjoxMTAxbDM4ODMyXC9kZXN0aW5hdGlvbjpodHRwczpcL1wvd3d3LmZhcmZldGNoLmNvbVwvZnJcL3Nob3BwaW5nXC93b21lblwvY29udmVyc2UtbG8tdG9wLXN0cmlwZWQtc25lYWtlci1pdGVtLTEwNDI4MzcyLmFzcHgiLCJDYW91dGNob3VjXC9Db3RvbiIsImh0dHBzOlwvXC9wcmYuaG5cL2NsaWNrXC9jYW1yZWY6MTAxMWw3TXltXC9jcmVhdGl2ZXJlZjoxMTAxbDM4ODMyXC9kZXN0aW5hdGlvbjpodHRwczpcL1wvd3d3LmZhcmZldGNoLmNvbVwvZnJcL3Nob3BwaW5nXC93b21lblwvY29udmVyc2UtbG8tdG9wLXN0cmlwZWQtc25lYWtlci1pdGVtLTEwNDI4MzcyLmFzcHgiLCJTVzEzNjcxOENMT1RPUFdPUk5TVFJJUEVEMTA0MjgzNzIiLCIiLCIiLCIiLCIiLCI1MDkuMDAgRVVSIiwiNTA5LjAwIiwiQ2hhdXNzdXJlcyA+IENoYXVzc3VyZXMgXHUwMGUwIGxhY2V0cyIsIjUwOS4wMCBFVVIiLCIiLCI1MDkuMDAiLCJGUjo6REhMIEVYUFJFU1M6MTAuMDAgRVVSIiwiRlIiLCJSb3lhdW1lLVVuaSIsIjEwLjAwIEVVUiIsIkRITCBFWFBSRVNTIiwiNy02LjUtNy41IiwiVGFpbGxlIGFtXHUwMGU5cmljYWluZSIsInJlZ3VsYXIiLCIxMTEyNywxMTEyOCIsIkJPVVRJUVVFIDEgTE9ORE9OLEJPVVRJUVVFIDEgRFVCQUkiLCJodHRwczpcL1wvcHJmLmhuXC9jbGlja1wvY2FtcmVmOjEwMTFsN015bVwvY3JlYXRpdmVyZWY6MTEwMWwzODgzMlwvZGVzdGluYXRpb246aHR0cHM6XC9cL3d3dy5mYXJmZXRjaC5jb21cL2ZyXC9zaG9wcGluZ1wvd29tZW5cL2NoYXVzc3VyZXMtXHUwMGUwLWxhY2V0c1wvaXRlbXMuYXNweCIsIiIsIiIsIiIsIkNvbnZlcnNlIGxvLXRvcCBzdHJpcGVkIHNuZWFrZXIgLSBSb3VnZSIsIjYiLCIsIiwiaHR0cHM6XC9cL3ByZi5oblwvY2xpY2tcL2NhbXJlZjoxMDExbDdNeW1cL2NyZWF0aXZlcmVmOjExMDFsMzg4MzJcL2Rlc3RpbmF0aW9uOmh0dHBzOlwvXC93d3cuZmFyZmV0Y2guY29tXC9mclwvc2hvcHBpbmdcL3dvbWVuXC9jb252ZXJzZVwvY2hhdXNzdXJlcy1cdTAwZTAtbGFjZXRzXC9pdGVtcy5hc3B4IiwiIiwiIl0=';

        // when
        $expected_value = [
            'name' => 'Lo-top striped sneaker',
            'slug' => 'converse-lo-top-striped-sneaker-rouge-10428372',
            'description' => 'Lo-top worn striped in red from Converse. This canvas sneaker features a round cap toe, lace up detail, worn out stripes print throughout, and flat rubber sole.',
            'brand_original' => 'Converse',
            'currency_original' => 'EUR',
            'category_original' => 'chaussures|chaussures > chaussures à lacets|vêtements et accessoires > vêtements',
            'color_original' => 'rouge',
            'price' => 509.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://prf.hn/click/camref:1011l7Mym/creativeref:1101l38832/destination:https://www.farfetch.com/fr/shopping/women/converse-lo-top-striped-sneaker-item-10428372.aspx',
            'image_url' => 'https://cdn-images.farfetch-contents.com/10/42/83/72/10428372_2179211_1000.jpg',
            'gender' => 'femme',
            'provider' => 'partnerize',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'caoutchouc|coton',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '7|6.5|7.5',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    /**
     * @group ignore
     */
    public function test__parse_row__from_Garrard()
    {
        $headers = 'id,item_group_id,title,description,price,sale_price,shipping,image_link,link,ads_redirect,mobile_link,availability,product_type,google_product_category,condition,gtin,mpn,brand,color,size,size_type,gender,age_group,material,adult,excluded_destination,expiration_date,custom_label_0,custom_label_1,custom_label_2,custom_label_3,custom_label_4,sale_price_effective_date,display_ads_similar_id,display_ads_title,ads_labels,promotion_id';

        $payload = 'WyIxMDQwMDMxNC04NDk3MTA1MTA4MTA4MTAxMzI4NTExMDEwNTExMzExNzEwMSIsIjEwNDAwMzE0IiwiR2FycmFyZCAtIGJvdWNsZXMgZCdvcmVpbGxlcyBcdTAwZTAgZGVzaWduIGQnYWlsZXMgZW4gb3IgMThjdCBldCBuYWNyZSAtIGZlbW1lIC0gb3IgLSBUYWlsbGUgVW5pcXVlIC0gTVx1MDBlOXRhbGxpc1x1MDBlOSIsIkJvdWNsZXMgZCdvcmVpbGxlcyBcdTAwZTAgZGVzaWduIGQnYWlsZXMgZW4gb3IgMThjdCBldCBuYWNyZSBHYXJyYXJkLiIsIjI5NDcuMDAgRVVSIiwiMjk0Ny4wMCBFVVIiLCJGUjo6REhMIEVYUFJFU1M6MjAuMDAgRVVSIiwiaHR0cHM6XC9cL2Nkbi1pbWFnZXMuZmFyZmV0Y2gtY29udGVudHMuY29tXC8xMFwvNDBcLzAzXC8xNFwvMTA0MDAzMTRfMjA0NTA0NF8xMDAwLmpwZyIsImh0dHBzOlwvXC9wcmYuaG5cL2NsaWNrXC9jYW1yZWY6MTAxMWw3TXltXC9jcmVhdGl2ZXJlZjoxMTAwbDU3NDM4XC9kZXN0aW5hdGlvbjpodHRwczpcL1wvd3d3LmZhcmZldGNoLmNvbVwvZnJcL3Nob3BwaW5nXC93b21lblwvZ2FycmFyZC1ib3VjbGVzLWRvcmVpbGxlcy1hLWRlc2lnbi1kYWlsZXMtZW4tb3ItMThjdC1ldC1uYWNyZS1pdGVtLTEwNDAwMzE0LmFzcHg/c2l6ZT0xNyZzdG9yZWlkPTk0ODMiLCJodHRwczpcL1wvcHJmLmhuXC9jbGlja1wvY2FtcmVmOjEwMTFsN015bVwvY3JlYXRpdmVyZWY6MTEwMGw1NzQzOFwvZGVzdGluYXRpb246aHR0cHM6XC9cL3d3dy5mYXJmZXRjaC5jb21cL2ZyXC9zaG9wcGluZ1wvd29tZW5cL2dhcnJhcmQtYm91Y2xlcy1kb3JlaWxsZXMtYS1kZXNpZ24tZGFpbGVzLWVuLW9yLTE4Y3QtZXQtbmFjcmUtaXRlbS0xMDQwMDMxNC5hc3B4P3NpemU9MTcmc3RvcmVpZD05NDgzIiwiaHR0cHM6XC9cL3ByZi5oblwvY2xpY2tcL2NhbXJlZjoxMDExbDdNeW1cL2NyZWF0aXZlcmVmOjExMDBsNTc0MzhcL2Rlc3RpbmF0aW9uOmh0dHBzOlwvXC93d3cuZmFyZmV0Y2guY29tXC9mclwvc2hvcHBpbmdcL3dvbWVuXC9nYXJyYXJkLWJvdWNsZXMtZG9yZWlsbGVzLWEtZGVzaWduLWRhaWxlcy1lbi1vci0xOGN0LWV0LW5hY3JlLWl0ZW0tMTA0MDAzMTQuYXNweD9zaXplPTE3JnN0b3JlaWQ9OTQ4MyIsImluIHN0b2NrIiwiRmluZSBKZXdlbGxlcnkgPiBGaW5lIEVhcnJpbmdzIiwiMTg4IiwibmV3IiwiMzA3MzEwNDAwMzE0NCIsIjIwMTA5MTcxMDQwMDMxNCIsIkdhcnJhcmQiLCJNXHUwMGU5dGFsbGlzXHUwMGU5IiwiVGFpbGxlIFVuaXF1ZSIsInJlZ3VsYXIiLCJGZW1hbGUiLCJBZHVsdCIsIm9yIiwibm8iLCIiLCIiLCJGZW1hbGUiLCJDb250aW51aXR5IiwiTFVYRSIsIjEwMDArIiwibVx1MDBlOXRhbGxpc1x1MDBlOSIsIiIsIjEwNDAwMzE0IiwiR2FycmFyZCIsImZyYW5jZSIsIiJd';

        $expected_value = [
            'name' => 'Boucles d\'oreilles à design d\'ailes en or 18ct et nacre - - or - Taille Unique',
            'slug' => 'garrard-boucles-d-oreilles-design-d-ailes-en-or-18ct-et-nacre-femme-or-taille-unique-m-tallis-10400314-84971051081081013285110105113117101',
            'description' => 'Boucles d\'oreilles à design d\'ailes en or 18ct et nacre Garrard.',
            'brand_original' => 'Garrard',
            'merchant_original' => '',
            'currency_original' => 'EUR',
            'category_original' => 'fine jewellery > fine earrings|vêtements et accessoires > bijoux',
            'color_original' => 'métallisé',
            'price' => 2947.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://prf.hn/click/camref:1011l7Mym/creativeref:1100l57438/destination:https://www.farfetch.com/fr/shopping/women/garrard-boucles-doreilles-a-design-dailes-en-or-18ct-et-nacre-item-10400314.aspx?size=17&storeid=9483',
            'image_url' => 'https://cdn-images.farfetch-contents.com/10/40/03/14/10400314_2045044_1000.jpg',
            'gender' => 'femme',
            'provider' => 'partnerize - Farfetch France NMPI',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'or',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'TAILLE UNIQUE',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }
}
