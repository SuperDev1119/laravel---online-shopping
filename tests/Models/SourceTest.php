<?php

namespace Tests\Models;

use App\Models\Fetchers\CSV;
use App\Models\Fetchers\Xml;
use App\Models\Product;
use App\Models\Source;
use PHPUnit\Framework\TestCase;

class SourceTest extends TestCase
{
    public static $headers = '';

    private function skip_unless_running_on_SourceTest()
    {
        // do not run this test on SourceTest
        if (get_called_class() == self::class) {
            return $this->assertClassNotHasStaticAttribute('klass', self::class);
        }

        return true;
    }

    protected function parse_payload($payload, $headers = [])
    {
        if (empty($headers)) {
            $headers = static::$headers;
        }

        $source = new static::$klass;
        $source->name = 'Provider - Source Name';
        $source->title = 'Source Title';

        $data = (array) json_decode(base64_decode($payload));

        if (! empty($headers)) {
            $data = CSV::array_combine(explode(',', $headers), $data);
        }

        $data = Xml::xml2array($data);

        $parsed_data = $source->parse_row($data);

        if (! $parsed_data) {
            error_log('Could not parse data');
            var_dump($data);

            return;
        }

        array_push($parsed_data, 1); // i

        $result = (new Product(array_combine($source::$columns, $parsed_data)))->toArray();
        // $result['provider'] = $source::$parser;

        unset($result['payload']);
        unset($result['provider']);
        unset($result['i']);
        $result = array_filter($result, function ($v) {
            return ! is_array($v);
        });

        return $result;
    }

    public function test__is_recognized_as_Source_by_newFromBuilder()
    {
        if (! $this->skip_unless_running_on_SourceTest()) {
            return;
        }

        // given
        $class = static::$klass;

        // when
        $source = (new Source)->newFromBuilder((object) [
            'parser' => $class::$parser,
        ]);

        // then
        $this->assertContains($class, Source::PARSERS);
        $this->assertClassHasStaticAttribute('parser', static::$klass);
        $this->assertEquals(get_class($source), static::$klass);
    }

    /**
     * Remove accents from a string
     *
     * @return void
     */
    public function test__remove_accents()
    {
        // given
        $input = 'foo ééé ààà bar';

        // when
        $output = remove_accents($input);

        // then
        $this->assertEquals($output, 'foo eee aaa bar');
    }
}
