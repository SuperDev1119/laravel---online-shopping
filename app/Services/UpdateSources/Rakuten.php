<?php

namespace App\Services\UpdateSources;

use App\Models\Source;

class Rakuten extends BaseSource
{
    protected $requiredEnvParams = [
        'RAKUTEN_FTP_USER',
        'RAKUTEN_FTP_PASS',
        'RAKUTEN_FTP_HOST',
        'RAKUTEN_SID_NUMBER',
        'RAKUTEN_CONSUMER_SECRET',
        'RAKUTEN_USER',
        'RAKUTEN_PASS',
    ];

    public function update()
    {
        if (! $access_token = $this->get_access_token()) {
            return error_log('[-] Cannot get access token for Rakuten');
        }

        if (! $advertisersList = $this->get_advertisers_ids_list($access_token)) {
            return error_log('[-] Cannot update Advertisers from Rakuten');
        }

        foreach ($advertisersList as $advertiser) {
            if (empty($advertiser->merchantname)) {
                continue;
            }

            $this->update_source(
                $advertiser->merchantname,
                $advertiser->merchantname,
                $this->get_url($advertiser->mid),
                $advertiser,
            );
        }
    }

    private function get_advertisers_ids_list($access_token)
    {
        $client = new \GuzzleHttp\Client();

        $res = $client->request(
            'GET',
            'https://api.rakutenmarketing.com/advertisersearch/1.0', [
                'headers' => [
                    'Authorization' => 'Bearer '.$access_token,
                ],
                'http_errors' => false,
            ]
        );

        $advertisers = [];
        if (200 == $res->getStatusCode()) {
            $xml = new \SimpleXMLElement($res->getBody());

            foreach ($xml->midlist->merchant as $item) {
                $advertisers[] = $item;
            }
        }

        return $advertisers;
    }

    private function get_url($id)
    {
        return 'ftp://'
            . config('imports.RAKUTEN.FTP.USER')
            . ':' . config('imports.RAKUTEN.FTP.PASS')
            . '@' . config('imports.RAKUTEN.FTP.HOST')
            . '/' . $id . '_'
            . config('imports.RAKUTEN.SID_NUMBER')
            . '_mp.txt.gz';
    }

    private function get_access_token()
    {
        $client = new \GuzzleHttp\Client();

        $basicAuthToken = base64_encode(config('imports.RAKUTEN.CONSUMER.KEY').':'.config('imports.RAKUTEN.CONSUMER.SECRET'));
        $response = $client->request(
          'POST',
          'https://api.rakutenmarketing.com/token', [
              'headers' => [
                  'Authorization' => 'Basic '.$basicAuthToken,
              ],
              'form_params' => [
                  'grant_type' => 'password',
                  'username' => config('imports.RAKUTEN.USER'),
                  'password' => config('imports.RAKUTEN.PASS'),
                  'scope' =>config('imports.RAKUTEN.SID_NUMBER')
              ],
              'http_errors' => false,
          ]
        );

        if (200 == $response->getStatusCode()) {
            $response = json_decode($response->getBody());

            return $response->access_token;
        }
    }
}
