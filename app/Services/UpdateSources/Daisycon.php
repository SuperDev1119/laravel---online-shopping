<?php

namespace App\Services\UpdateSources;

use App\Models\Source;

class Daisycon extends BaseSource
{
    protected $requiredEnvParams = [
        'DAISYCON_USER',
        'DAISYCON_PASS',
    ];

    private $client;
    private $apiBaseUrl = 'https://services.daisycon.com/';
    private $publisherId;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->apiBaseUrl,
            'auth' => [config('imports.DAISYCON.USER'), config('imports.DAISYCON.PASS')],
        ]);
    }

    public function update()
    {
        $this->publisherId = $this->getPublisherId();

        if (empty($this->publisherId)) {
            return error_log('[-] Cannot update Sources from Daisycon: cannot retrieve publisherId');
        }

        $filters = $this->getFilters();
        foreach ($filters as $filter) {
            $csvLink = $filter->url;

            if (substr($csvLink, 0, 2) === '//') {
                $csvLink = 'https:'.$csvLink;
            }

            $this->update_source(
                $filter->name,
                $filter->name,
                $csvLink,
                $filter,
                [
                    'language' => $filter->language_code,
                ],
            );
        }
    }

    private function getPublisherId()
    {
        $response = $this->client->get('publishers');
        $publisherData = json_decode($response->getBody()->getContents());

        if (! empty($publisherData)) {
            return reset($publisherData)->id;
        }

        return null;
    }

    private function getFilters()
    {
        $response = $this->client->get("publishers/{$this->publisherId}/productfeeds.v2/filters");

        return json_decode($response->getBody()->getContents());
    }
}
