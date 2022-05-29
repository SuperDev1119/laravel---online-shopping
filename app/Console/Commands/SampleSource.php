<?php

namespace App\Console\Commands;

use Ajgl\Csv\Rfc;
use App\Models\Fetchers\CSV;
use App\Models\Product;
use App\Models\Source;
use Illuminate\Console\Command;

class SampleSource extends Command
{
    protected $signature = 'sample:source {source} {skip?} {quantity?}';

    protected $description = 'Parse an sample product from specified Source';

    public function handle()
    {
        $opts_source = $this->argument('source');
        $opts_skip = intval($this->argument('skip') ?: 0);
        $opts_quantity = intval($this->argument('quantity') ?: 1);

        $source = Source::find($opts_source);

        echo "[+] Downloading from: $source->name\n{$source->path}\n\n";

        if (! $handle = popen($source->download_feed_command(), 'r')) {
            echo '[-] Failed to open handle';

            return false;
        }

        echo '[+] Parser: '.get_class($source)."\n";

        $fetcher = $source->getFetcher($handle);
        echo '[+] Fetcher: '.get_class($fetcher)."\n";

        if ($headers = @$fetcher->headers) {
            echo "\$headers = '".implode(',', $headers)."';\n\n";
        }

        $fetcher->parse(function ($row, $raw) use ($source, $opts_skip, $opts_quantity) {
            static $i = -1;
            $i++;

            if ($i < $opts_skip) {
                return;
            }

            static $j = -1;
            $j++;
            if ($j >= $opts_quantity) {
                return;
            }

            if (! $data = $source->parse_row($row)) {
                echo "[!] Failed to parse:\n".print_r($row, true).".\n\n";

                return;
            }

            echo "\$headers = '".implode(',', array_keys($row))."';\n\n";

            echo "\$payload = '".base64_encode(json_encode($raw))."';\n\n";

            $attrs = CSV::array_combine($source::$columns, $data);
            $product = new Product($attrs);

            $v = $product->buildDocument();
            foreach ($v as $key => $value) {
                if (is_array($value)) {
                    unset($v[$key]);
                }
            }

            echo '$expected_value = '.var_export($v, true).";\n\n";

            echo 'DATA : '.print_r($row, true)."\n\n";
        });

        pclose($handle);
    }
}
