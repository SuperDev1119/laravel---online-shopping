<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\XXX;

class XXXTest extends \Tests\Models\SourceTest
{
    public static $klass = XXX::class;

    public static $headers = '';

    public function test__parse_row__from_()
    {
        // given
        $headers = self::$headers;
        $payload = '';

        // when
        $expected_value = [];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }
}
