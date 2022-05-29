<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Impact;

class ImpactTest extends \Tests\Models\SourceTest
{
    public static $klass = Impact::class;

    public static $headers = '';

    public function test__parse_row__from_()
    {
        // given
        $headers = 'Unique_Merchant_SKU,Product_Name,Product_URL,Image_URL,Current_Price,Stock_Availability,Manufacturer,Product_Description,Category,Parent_SKU,Parent_Name,Size,Product_Launch_Date,Alternative_Image_URL_1,Alternative_Image_URL_2,Alternative_Image_URL_3,Alternative_Image_URL_4,Alternative_Image_URL_5,Weight_Unit_of_Measure,Currency,Labels';

        $payload = 'eyJVbmlxdWVfTWVyY2hhbnRfU0tVIjoiMzkyOTI0NDc5NDg5NjciLCJQcm9kdWN0X05hbWUiOiJOYXZ5IChYTCkiLCJQcm9kdWN0X1VSTCI6Imh0dHBzOlwvXC9tYXJkYS5weGYuaW9cL2NcLzI1MzQ4OTVcLzEwODc4OTFcLzEzNjcyP3Byb2Rza3U9MzkyOTI0NDc5NDg5NjcmdT1odHRwcyUzQSUyRiUyRm1hcmRhc3dpbS5teXNob3BpZnkuY29tJTJGcHJvZHVjdHMlMkZibHVlLXN3aW0tc2hvcnRzJmludHNyYz1DQVRGXzg0NjAiLCJJbWFnZV9VUkwiOiJodHRwczpcL1wvY2RuLnNob3BpZnkuY29tXC9zXC9maWxlc1wvMVwvMDUzM1wvMjE4OVwvMjAwN1wvcHJvZHVjdHNcLzI3RU5XQlVJUjkyaHZFZ21OMmJmM2dfdGh1bWJfNmQuanBnP3Y9MTYyNDgwODMzMSIsIkN1cnJlbnRfUHJpY2UiOiIxMTkuMDAiLCJTdG9ja19BdmFpbGFiaWxpdHkiOiJZIiwiTWFudWZhY3R1cmVyIjoiTWFyZGFTd2ltIiwiUHJvZHVjdF9EZXNjcmlwdGlvbiI6IjxtZXRhIGNoYXJzZXQ9XCJ1dGYtOFwiPlxuPHAgZGF0YS1tY2UtZnJhZ21lbnQ9XCIxXCI+PGVtIGRhdGEtbWNlLWZyYWdtZW50PVwiMVwiPlJFQ09NTUVOREVEIEJZIEZPUkJFUyAmYW1wOyBHUTxcL2VtPjxcL3A+XG48cCBkYXRhLW1jZS1mcmFnbWVudD1cIjFcIj48ZW0gZGF0YS1tY2UtZnJhZ21lbnQ9XCIxXCI+PFwvZW0+XHUyNjA1IFx1MjYwNSBcdTI2MDUgXHUyNjA1IFx1MjYwNVx1MDBhMDxzcGFuIHN0eWxlPVwiY29sb3I6ICMxMDBmMGY7XCI+KDxhIGhyZWY9XCJodHRwczpcL1wvd3d3LnRydXN0cGlsb3QuY29tXC9yZXZpZXdcL21hcmRhc3dpbXdlYXIuY29tXCIgdGFyZ2V0PVwiX2JsYW5rXCIgc3R5bGU9XCJjb2xvcjogIzEwMGYwZjtcIiByZWw9XCJub29wZW5lciBub3JlZmVycmVyXCI+MjE8XC9hPik8XC9zcGFuPjxcL3A+IiwiQ2F0ZWdvcnkiOiJNaWQtTGVuZ3RoIFN3aW0gU2hvcnRzIiwiUGFyZW50X1NLVSI6IjY1NDQ3MDkxMjQyNjMiLCJQYXJlbnRfTmFtZSI6Ik5hdnkiLCJTaXplIjoiWEwiLCJQcm9kdWN0X0xhdW5jaF9EYXRlIjoiMjAyMTAyMjgiLCJBbHRlcm5hdGl2ZV9JbWFnZV9VUkxfMSI6Imh0dHBzOlwvXC9jZG4uc2hvcGlmeS5jb21cL3NcL2ZpbGVzXC8xXC8wNTMzXC8yMTg5XC8yMDA3XC9wcm9kdWN0c1wvR1hvcm9IekVRYWl2YU1fRlJOSElWZ190aHVtYl82Yy5qcGc/dj0xNjI0ODA4MzMxIiwiQWx0ZXJuYXRpdmVfSW1hZ2VfVVJMXzIiOiJodHRwczpcL1wvY2RuLnNob3BpZnkuY29tXC9zXC9maWxlc1wvMVwvMDUzM1wvMjE4OVwvMjAwN1wvcHJvZHVjdHNcL2Z1bGxzaXplb3V0cHV0XzE0Yi5qcGc/dj0xNjIzMTc2OTE2IiwiQWx0ZXJuYXRpdmVfSW1hZ2VfVVJMXzMiOiJodHRwczpcL1wvY2RuLnNob3BpZnkuY29tXC9zXC9maWxlc1wvMVwvMDUzM1wvMjE4OVwvMjAwN1wvcHJvZHVjdHNcL0RTaGZrUWU3UU15THBseWpLcXBoZndfdGh1bWJfNzIuanBnP3Y9MTYyMzE3NjkyMCIsIkFsdGVybmF0aXZlX0ltYWdlX1VSTF80IjoiaHR0cHM6XC9cL2Nkbi5zaG9waWZ5LmNvbVwvc1wvZmlsZXNcLzFcLzA1MzNcLzIxODlcLzIwMDdcL3Byb2R1Y3RzXC9mdWxsc2l6ZW91dHB1dF8xNjEuanBnP3Y9MTYyMzE3NjkyMyIsIkFsdGVybmF0aXZlX0ltYWdlX1VSTF81IjoiaHR0cHM6XC9cL2Nkbi5zaG9waWZ5LmNvbVwvc1wvZmlsZXNcLzFcLzA1MzNcLzIxODlcLzIwMDdcL3Byb2R1Y3RzXC9mdWxsc2l6ZW91dHB1dF8xNjAuanBnP3Y9MTYyMzE3NjkyOCIsIldlaWdodF9Vbml0X29mX01lYXN1cmUiOiJLaWxvZ3JhbXMiLCJDdXJyZW5jeSI6IkVVUiIsIkxhYmVscyI6IkNhdGVnb3J5X0RlZmF1bHQgQ2F0ZWdvcnlcL1Nob3AsIENhdGVnb3J5X0RlZmF1bHQgQ2F0ZWdvcnlcL1Nob3BcL1Nob3J0cywgQ2F0ZWdvcnlfRGVmYXVsdCBDYXRlZ29yeVwvU2hvcFwvU3dpbXdlYXIsIHNpemUgY2hhcnQifQ==';

        $expected_value = [
            'name' => 'Navy (XL)',
            'slug' => 'navy-xl-39292447948967',
            'description' => 'RECOMMENDED BY FORBES & GQ
★ ★ ★ ★ ★ (21)',
            'brand_original' => 'MardaSwim',
            'merchant_original' => 'MardaSwim',
            'currency_original' => 'EUR',
            'category_original' => 'mid-length swim shorts|category_default category|shop|shorts|swimwear|size chart',
            'color_original' => '',
            'price' => 119.0,
            'old_price' => 0.0,
            'reduction' => 0,
            'url' => 'https://marda.pxf.io/c/2534895/1087891/13672?prodsku=39292447948967&u=https%3A%2F%2Fmardaswim.myshopify.com%2Fproducts%2Fblue-swim-shorts&intsrc=CATF_8460',
            'image_url' => 'https://cdn.shopify.com/s/files/1/0533/2189/2007/products/27ENWBUIR92hvEgmN2bf3g_thumb_6d.jpg?v=1624808331',
            'gender' => 'mixte',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'XL',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }
}
