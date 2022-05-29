<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Awin;

class AwinTest extends \Tests\Models\SourceTest
{
    public static $klass = Awin::class;

    public static $headers = 'data_feed_id,merchant_id,merchant_name,aw_product_id,aw_deep_link,aw_image_url,aw_thumb_url,category_id,category_name,brand_id,brand_name,merchant_product_id,merchant_category,ean,mpn,model_number,product_name,description,merchant_deep_link,merchant_image_url,delivery_time,currency,search_price,rrp_price,delivery_cost,stock_quantity,condition,product_type,parent_product_id,colour,custom_1,Fashion:suitable_for,Fashion:size,Fashion:material,alternate_image,large_image,product_price_old,stock_status';

    /**
     * Test a Row from Asos
     *
     * @return void
     */
    public function test__parse_row__from_Asos()
    {
        // given
        $payload = 'WyIxNzU5OSIsIjcyNTIiLCJBc29zLmNvbSBGUiIsIjI0NTU0NDA5ODQ5IiwiaHR0cHM6XC9cL3d3dy5hd2luMS5jb21cL3BjbGljay5waHA/cD0yNDU1NDQwOTg0OSZhPTI4NDQ1NyZtPTcyNTIiLCJodHRwczpcL1wvaW1hZ2VzMi5wcm9kdWN0c2VydmUuY29tXC8/dz0yMDAmaD0yMDAmYmc9d2hpdGUmdHJpbT01JnQ9bGV0dGVyYm94JnVybD1zc2wlM0FpbWFnZXMuYXNvcy1tZWRpYS5jb20lMkZwcm9kdWN0cyUyRmFzb3MtZGVzaWduLWJhZ3VlLWF2ZWMtc2VycGVudC1lbnJvdWxlLW9yLWJydWxlJTJGOTY2NDg4MS0xLWdvbGQlM0YlMjRYWEwlMjQmZmVlZElkPTE3NTk5Jms9YmZhMWIwMGE4NzgzYmEzYjMyODM4YzY4OTk0MmFmNWZkMWY5Njc4ZSIsImh0dHBzOlwvXC9pbWFnZXMyLnByb2R1Y3RzZXJ2ZS5jb21cLz93PTcwJmg9NzAmYmc9d2hpdGUmdHJpbT01JnQ9bGV0dGVyYm94JnVybD1zc2wlM0FpbWFnZXMuYXNvcy1tZWRpYS5jb20lMkZwcm9kdWN0cyUyRmFzb3MtZGVzaWduLWJhZ3VlLWF2ZWMtc2VycGVudC1lbnJvdWxlLW9yLWJydWxlJTJGOTY2NDg4MS0xLWdvbGQlM0YlMjRYWEwlMjQmZmVlZElkPTE3NTk5Jms9YmZhMWIwMGE4NzgzYmEzYjMyODM4YzY4OTk0MmFmNWZkMWY5Njc4ZSIsIjU0MiIsIk1lbidzIEpld2VsbGVyeSIsIjAiLCJBU09TIERFU0lHTiIsIjc4NzY4OTAiLCJIb21tZSA+IEJpam91eCA+IEJhZ3VlcyIsIjIyMDE0ODI5MjUyNjUiLCJTSi01LTcxMTA5MS0yQiIsIjk2NjQ4ODEiLCJBU09TIERFU0lHTiAtIEJhZ3VlIGF2ZWMgc2VycGVudCBlbnJvdWxcdTAwZTkgLSBPciBiclx1MDBmYmxcdTAwZTktRG9yXHUwMGU5IiwiQ2hldmFsaVx1MDBlOHJlIHBhciBBU09TIERFU0lHTiBGaW5pIGRvclx1MDBlOSBTdHlsZSBzZXJwZW50IENvdXBlIGNyb2lzXHUwMGU5ZSIsImh0dHBzOlwvXC93d3cuYXdpbjEuY29tXC9wY2xpY2sucGhwP3A9MjQ1NTQ0MDk4NDkmYT0yODQ0NTcmbT03MjUyIiwiaHR0cHM6XC9cL2ltYWdlcy5hc29zLW1lZGlhLmNvbVwvcHJvZHVjdHNcL2Fzb3MtZGVzaWduLWJhZ3VlLWF2ZWMtc2VycGVudC1lbnJvdWxlLW9yLWJydWxlXC85NjY0ODgxLTEtZ29sZD8kWFhMJCIsIjEgLSA1IEpvdXJzIiwiRVVSIiwiOC40OSIsIiIsIjAuMDAiLCIxMSIsIk5ldyIsIkhvbW1lID4gQmlqb3V4ID4gQmFndWVzIiwiMTI2NjExNSIsIkRvclx1MDBlOSIsIkhvbW1lID4gQmlqb3V4ID4gQmFndWVzIiwibWFsZSIsIlhTIiwiemluYyIsImh0dHBzOlwvXC9pbWFnZXMuYXNvcy1tZWRpYS5jb21cL3Byb2R1Y3RzXC9hc29zLWRlc2lnbi1iYWd1ZS1hdmVjLXNlcnBlbnQtZW5yb3VsZS1vci1icnVsZVwvOTY2NDg4MS0yPyRYWEwkIiwiIiwiOC40OSBcdTIwYWMiLCIxIl0=';

        // when
        $expected_value = [
            'name' => 'Bague avec serpent enroulé - Or brûlé',
            'slug' => 'bague-avec-serpent-enroul-or-br-l-1266115',
            'description' => 'Chevalière par ASOS DESIGN Fini Style serpent Coupe croisée',
            'brand_original' => 'ASOS DESIGN',
            'merchant_original' => 'Asos.com',
            'currency_original' => 'EUR',
            'category_original' => 'homme > bijoux > bagues|men\'s jewellery',
            'color_original' => 'doré',
            'price' => 8.49,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://www.awin1.com/pclick.php?p=24554409849&a=284457&m=7252',
            'image_url' => 'https://images2.productserve.com/?w=1000&h=1000&bg=white&trim=5&t=letterbox&url=ssl%3Aimages.asos-media.com%2Fproducts%2Fasos-design-bague-avec-serpent-enroule-or-brule%2F9664881-1-gold%3F%24XXL%24&feedId=17599&k=bfa1b00a8783ba3b32838c689942af5fd1f9678e',
            'gender' => 'homme',
            'col' => '',
            'coupe' => 'coupe croisée',
            'manches' => '',
            'material' => 'zinc',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'XS',
            'livraison' => '1 - 5 Jours',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }
}
