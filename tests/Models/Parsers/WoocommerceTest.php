<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Woocommerce;

class WoocommerceTest extends \Tests\Models\SourceTest
{
    public static $klass = Woocommerce::class;

    public static $headers = '';

    public function test__parse_row__from_TooCoolForFur()
    {
        // given
        $headers = 'id,title,brand,link,main_image,price,featured_image,images,parent_category,category_path';

        $payload = 'eyJpZCI6IjU4OTkiLCJ0aXRsZSI6Ik1BU0sgLSBQSU5LIiwiYnJhbmQiOiJCUkFORCIsImxpbmsiOiJodHRwczpcL1wvd3d3LnRvb2Nvb2xmb3JmdXIuY29tXC9wcm9kb3R0b1wvbWFza1wvP2F0dHJpYnV0ZV9jb2xvcj1QSU5LJnV0bV9zb3VyY2U9bW9kYWxvdmEmdXRtX21lZGl1bT1jcGEmdXRtX2NhbXBhaWduPW1vZGFsb3ZhIiwibWFpbl9pbWFnZSI6Imh0dHBzOlwvXC93d3cudG9vY29vbGZvcmZ1ci5jb21cL3dwLWNvbnRlbnRcL3VwbG9hZHNcLzIwMjBcLzExXC9tYXNjaGVyaW5hLWZ1Y3NpYS5qcGciLCJwcmljZSI6IjE0LjkwIiwiZmVhdHVyZWRfaW1hZ2UiOiJodHRwczpcL1wvd3d3LnRvb2Nvb2xmb3JmdXIuY29tXC93cC1jb250ZW50XC91cGxvYWRzXC8yMDIwXC8xMVwvbWFzY2hlcmluYS1mdWNzaWEuanBnIiwiaW1hZ2VzIjoiaHR0cHM6XC9cL3d3dy50b29jb29sZm9yZnVyLmNvbVwvd3AtY29udGVudFwvdXBsb2Fkc1wvMjAyMFwvMTFcL21hc2NoZXJpbmEtZnVjc2lhLmpwZyxodHRwczpcL1wvd3d3LnRvb2Nvb2xmb3JmdXIuY29tXC93cC1jb250ZW50XC91cGxvYWRzXC8yMDIwXC8xMVwvTUFTSy5qcGciLCJwYXJlbnRfY2F0ZWdvcnkiOiJBQ0NFU1NPUklFUyIsImNhdGVnb3J5X3BhdGgiOiJBQ0NFU1NPUklFUz5BQ0NFU1NPUklaRSJ9';

        $expected_value = [
            'name' => 'MASK - PINK',
            'slug' => 'mask-pink-5899',
            'description' => '',
            'brand_original' => 'BRAND',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'accessories|accessories>accessorize',
            'color_original' => '',
            'price' => 14.9,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://www.toocoolforfur.com/prodotto/mask/?attribute_color=PINK&utm_source=modalova&utm_medium=cpa&utm_campaign=modalova',
            'image_url' => 'https://www.toocoolforfur.com/wp-content/uploads/2020/11/mascherina-fucsia.jpg',
            'gender' => 'mixte',
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
}
