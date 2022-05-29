<?php

namespace App\Services\UpdateSources;

class Impact extends BaseSource
{
    const API_BASE_URL = 'https://api.impact.com/';

    protected $requiredEnvParams = [
        'IMPACT_SID',
        'IMPACT_TOKEN',
    ];

    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => self::API_BASE_URL.'Mediapartners/'.config('imports.IMPACT.SID').'/',
            'auth' => [config('imports.IMPACT.SID'), config('imports.IMPACT.TOKEN')],
            'headers' => [
                'Accept' => 'application/json',
                'IR-Version' => 12,
            ],
        ]);
    }

    public function update()
    {
        $catalogs = $this->getCatalogs();

        foreach ($catalogs as $catalog) {
            foreach ($catalog->FTPLocations as $ftp_location) {
                $this->update_source(
                    $catalog->Name.' ('.basename($ftp_location).')',
                    $catalog->Name,
                    $ftp_location,
                    $catalog,
                    [
                        'language' => $catalog->Language,
                        'nb_of_products' => $catalog->NumberOfItems,
                    ],
                );
            }
        }
    }

    private function getCatalogs()
    {
        $catalogs = [];
        $response = $this->client->get('Catalogs');
        $data = json_decode($response->getBody()->getContents());
        $catalogs = array_merge($catalogs, $data->Catalogs);

        return $catalogs;
    }
}
