<?php

namespace App\Console\Commands;

use Ajgl\Csv\Rfc;
use Illuminate\Console\Command;

class ParsePayload extends Command
{
    protected $signature = 'parse:payload {source} {data?}';

    protected $description = 'Parse an sample product from specified Source';

    public function handle()
    {
        $opts_source = $this->argument('source');
        $opts_data = $this->argument('data');

        if (empty($opts_data)) {
            $opts_data = stream_get_contents(STDIN);
        }

        $payload = base64_decode($opts_data);
        $row = (array) json_decode($payload);

        var_dump($payload);
        print_r($row);

        $klass = \App\Models\Source::class.ucfirst($opts_source);
        $source = new $klass;

        if ($parsed = $source->parse_row($row)) {
            array_pop($parsed); // remove payload
            print_r($parsed);
        }
    }
}
