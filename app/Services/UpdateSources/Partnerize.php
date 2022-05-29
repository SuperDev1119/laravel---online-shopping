<?php

namespace App\Services\UpdateSources;

use App\Models\Source;

class Partnerize extends BaseSource
{
    protected $requiredEnvParams = [
        'PARTNERIZE_API_LOGIN',
        'PARTNERIZE_API_PASSWORD',
    ];

    public function update()
    {
        $client = new \GuzzleHttp\Client([
            'cookies' => true,
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Basic '.base64_encode(config('imports.PARTNERIZE.LOGIN').':'.config('imports.PARTNERIZE.PASS')),
            ],
        ]);

        $res = $client->get('https://api.partnerize.com/user/account');
        $accountInfo = json_decode($res->getBody()->getContents());

        foreach ($accountInfo->user_accounts as $account) {
            $publisherId = $account->publisher->publisher_id;

            $res = $client->get("https://api.partnerize.com/user/publisher/{$publisherId}/feed");
            $campaigns = json_decode($res->getBody()->getContents());

            if (! $campaigns) {
                $this->handle__Exception(new \Exception('[-] Could not get campaigns!' . print_r(['contents' => $res->getBody()->getContents()], true)));
            }

            foreach ($campaigns->campaigns as $campaign) {
                foreach ($campaign->campaign->feeds as $feed) {
                    $real_feed = $feed->feed;
                    $name = 'partnerize - '.$real_feed->title.' - '.$real_feed->name;
                    $url = $real_feed->location_compressed ?: $real_feed->location;

                    echo "[+] Updating Source: '$name': ";

                    if ($real_feed->filesize <= 0) {
                        echo "feed is not ready.\t→ Sending request: ";
                        $res = $client->get($real_feed->location);

                        if (404 == ($code = $res->getStatusCode())) {
                            echo 'done';
                        } else {
                            echo "weird, got ($code)";
                        }

                        echo " (not saving)\n";
                        continue;
                    }

                    Source::where('path', $url)->update(['name' => $name]);

                    try {
                        $source = Source::updateOrCreate([
                            'name' => $name,
                        ], [
                            'title' => $real_feed->name,
                            'path' => $url,
                            'extra' => print_r([
                                'feed' => $real_feed,
                            ], true),
                        ]);

                        echo "done (id: $source->id)\n";
                    } catch (\Exception $e) {
                        $this->handle__Exception($e, $url);
                    }
                }
            }
        }
    }
}
