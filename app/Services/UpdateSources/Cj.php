<?php

namespace App\Services\UpdateSources;

use App\Models\Source;

class Cj extends BaseSource
{
    protected $requiredEnvParams = [
        'CJ_USER',
        'CJ_PASS',
        'CJ_HTTP_USER',
        'CJ_HTTP_PASS',
        'CJ_CATALOG_ID',
    ];

    public function update()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://members.cj.com/member/',
            'cookies' => true,
            'allow_redirects' => false,
        ]);

        $client->request(
            'POST',
            'login/foundation/memberlogin.do', [
                'form_params' => [
                    'uname' => config('imports.CJ.USER'),
                    'pw' => config('imports.CJ.PASS')
                ],
            ]
        );

        $res = $client->get(
            'api/publisher/'.env('CJ_HTTP_USER').'/subscription/'.env('CJ_CATALOG_ID').'/productCatalogDetails?page=0&rpp=10000'
        );

        $raw = json_decode($res->getBody());

        foreach ($raw->details as $data) {
            $this->update_source(
                $data->advertiserName.' - '.$data->adName,
                $data->advertiserName,
                $this->get_url($data),
                $data,
                [
                    'language' => 'Language:'.$data->targetCountry.' - Region:'.$data->targetCountry,
                    'nb_of_products' => $data->numberOfRecords,
                ],
            );
        }
    }

    private function get_url($data)
    {
        return str_replace(
          ['___', '__'],
          ['_', '_'],
          'https://'.
          config('imports.CJ.HTTP.USER').':'.config('imports.CJ.HTTP.PASS').
          '@datatransfer.cj.com/datatransfer/files/'.
          config('imports.CJ.HTTP.USER').
          '/outgoing/productcatalog/'.
          config('imports.CJ.CATALOG_ID').
          '/'.
          str_replace(
            [' ', '(', ')', '.', ','],
            ['_', '_', '_', '_', '_'],
            str_replace(
              ['-'],
              [' '],
              $data->advertiserName
          ).
            '-'.
            str_replace(
              ['-'],
              [' '],
              $data->adName
          )
        ).
          '-shopping.txt.zip'
      );
    }
}
