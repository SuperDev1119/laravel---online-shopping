<?php

namespace App\Services\UpdateSources;

use App\Models\Source;

class Netaffiliation extends BaseSource
{
    protected $requiredEnvParams = [
        'NETAFFILIATION_FEEDS_URL',
    ];

    public function update()
    {
        $feedsUrl = config('imports.NETAFFILIATION.FEEDS_URL');

        $client = new \GuzzleHttp\Client([
            'cookies' => true,
            'verify' => false,
            'allow_redirects' => ['track_redirects' => true],
        ]);

        $res = $client->get($feedsUrl);

        $campaigns = simplexml_load_string($res->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);

        if (empty($campaigns)) {
            return error_log('[-] Cannot update Sources from Netaffiliation: cannot get campaigns list');
        }

        foreach ($campaigns->campaign as $campaign) {
            foreach ($campaign->product_feeds->product_feed as $feed) {
                $feedVersion = intval($feed->attributes()->version);
                $feedName = trim($feed->attributes()->name);
                $campaign->name = trim($campaign->name);
                $name = "netaffiliationv{$feedVersion} - {$campaign->name} - {$feedName}";

                echo "[+] Updating Source: '$name': ";

                $url = $feed->__toString();
                $type = null;

                if ($source = Source::where('path', $url)->first()) {
                    @list(, $type) = explode('(type: ', $source->name, 2);
                    $type = rtrim($type, ')');
                }

                if (empty($type)) {
                    try {
                        echo '*loading type* ';

                        $res = $client->head($url);
                        list($type) = explode(';', $res->getHeaderLine('Content-Type'), 2);
                    } catch (\Exception $e) {
                        echo "ERROR.\n\tCouldn't get feed type (".$e->getMessage().")\n\t\t";
                    }
                }

                if (! empty($type)) {
                    $s = " (type: $type)";
                    $name .= $s;
                    echo $s;
                }

                try {
                    $source = Source::updateOrCreate([
                        'path' => $url,
                    ], [
                        'title' => $campaign->name,
                        'name' => $name,
                    ]);

                    echo " done (id: $source->id)\n";
                } catch (\Exception $e) {
                    $this->handle__Exception($e, $url);
                }
            }
        }
    }
}
