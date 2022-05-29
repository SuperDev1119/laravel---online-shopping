<?php

namespace App\Services\UpdateSources;

use App\Models\Source;

class Awin extends BaseSource
{
    protected $requiredEnvParams = [
        'AWIN_DATAFEEDS',
    ];

    public function update()
    {
        $all = $this->load_csv_file(config('imports.AWIN.DATAFEEDS'));

        foreach ($all as $data) {
            $this->update_source(
                $data['Advertiser Name'].' - '.$data['Feed Name'].' - '.$data['Feed ID'],
                $data['Advertiser Name'],
                $data['URL'],
                $data,
                [
                    'language' => 'Language:'.$data['Language'].' - Region:'.$data['Primary Region'],
                    'nb_of_products' => $data['No of products'],
                ],
              );
        }
    }

    private function load_csv_file($file)
    {
        $csv = array_map('str_getcsv', file($file));
        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv); // remove column header

        return $csv;
    }
}
