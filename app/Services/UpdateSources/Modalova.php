<?php

namespace App\Services\UpdateSources;

use App\Models\Source;

class Modalova extends BaseSource
{
    protected $requiredEnvParams = [
        'ML_USER',
        'ML_PASS',
    ];

    private $client;

    const IGNORE_THESE_CAMPAIGN_IDS = [
        'afsr', // DEFAULT
    ];

    const DEFAULT_NAME_FOR_FEED = 'default';
    const BASE_URL = 'https://network.modalova.com';

    public function __construct()
    {
        $internalErrors = libxml_use_internal_errors(true);
        $this->client = new \GuzzleHttp\Client(['cookies' => true]);
    }

    private function login()
    {
        $response = $this->client->request(
          'GET',
          self::BASE_URL.'/admin/login.php?login=1&url=admin'
      );

        $content = $response->getBody()->getContents();

        preg_match('#name="csrf" value="(.*?)"#', $content, $matches);
        $csrf = $matches[1];

        $response = $this->client->request(
          'POST',
          self::BASE_URL.'/admin/login.php', [
              'form_params' => [
                  'email' => config('imports.ML.USER'),
                  'password' => config('imports.ML.PASS'),
                  'csrf' => $csrf,
              ],
          ]
      );

        return 200 == $response->getStatusCode();
    }

    private function get_campaigns()
    {
        $response = $this->client->request(
            'POST',
            self::BASE_URL.'/admin/campaigns.php', [
                'form_params' => [
                    'p' => 1,
                    'r' => 200,
                    'c' => 'added',
                    'o' => 'desc',
                ],
            ]
        );

        $content = $response->getBody()->getContents();
        $content = str_replace('&nbsp;', ' ', $content);

        $dom = new \DomDocument();
        $dom->loadHTML($content);

        $table = $dom->getElementsByTagName('table')[0];

        $campaigns = [];

        foreach ($table->getElementsByTagName('tr') as $i => $tr) {
            if (0 == $i) {
                continue;
            }

            $tds = $tr->getElementsByTagName('td');

            $input = $tds[0]->getElementsByTagName('input')[0];

            if (! $input) {
                continue;
            }

            $id = trim($input->getAttribute('value'));
            $name = trim($tds[2]->textContent);

            if (in_array($id, self::IGNORE_THESE_CAMPAIGN_IDS)) {
                continue;
            }

            $campaigns[$id] = $this->get_campaign($id);
        }

        return array_filter($campaigns);
    }

    private function get_campaign($id)
    {
        $response = $this->client->request(
            'GET',
            self::BASE_URL.'/admin/campaign_edit.php?id='.$id
        );

        $content = $response->getBody()->getContents();

        $dom = new \DomDocument();
        $dom->loadHTML($content);

        $link = $this->get_deep_link($id);

        if (! $link) {
            return null;
        }

        return [
            'id' => $id,
            'name' => $dom->getElementById('name')->getAttribute('value'),
            'category' => $dom->getElementById('category')->getAttribute('value'),
            'feeds' => $this->parse_note($dom->getElementById('note')->textContent),
            'deep_link' => $link,
        ];
    }

    private function parse_note($string)
    {
        $string = trim($string);

        if ($json_decoded = json_decode($string, true)) {
            return $json_decoded;
        }

        $feeds = [];
        foreach (preg_split("/\r\n|\n|\r/", $string) as $line) {
            if (empty($line)) {
                continue;
            }

            $feed = array_map('trim', explode('|', $line));

            $link = array_shift($feed);
            $config = [];
            foreach ($feed as $configuration_line) {
                $c = array_map('trim', explode(':', $configuration_line, 2));
                $config[$c[0]] = $c[1];
            }

            $name = '';

            if (0 != strpos($link, 'http')) {
                list($name, $link) = array_map('trim', explode(':', $link, 2));
            }

            $feeds[] = [
                'name' => $name,
                'link' => $link,
                'config' => $config,
            ];
        }

        return $feeds;
    }

    private function get_deep_link($id)
    {
        $response = $this->client->request(
            'GET',
            self::BASE_URL.'/admin/banners.php?cid='.$id
        );

        $content = $response->getBody()->getContents();

        $dom = new \DomDocument();
        $dom->loadHTML($content);

        $table = $dom->getElementsByTagName('table')[0];
        $tr = $table->getElementsByTagName('tr')[1];
        $td = $tr->getElementsByTagName('td')[0];
        $input = $td->getElementsByTagName('input')[0];

        if (empty($input)) {
            return false;
        }

        $deep_link_id = $input->getAttribute('value');

        return trim($deep_link_id);
    }

    public function update()
    {
        if (! $this->login()) {
            return error_log('[-] Cannot update Sources from Modalova: could not login');
        }

        $campaigns = $this->get_campaigns();

        foreach ($campaigns as $campaign) {
            if (empty($campaign['category']) || empty($campaign['feeds'])) {
                error_log('[-] Campaign ('.$campaign['name'].') has no category or no feeds: skipping');
                continue;
            }

            foreach ($campaign['feeds'] as $feed) {
                $feed['name'] = @$feed['name'] ?: self::DEFAULT_NAME_FOR_FEED;

                if (empty($feed['config'][Source::CONFIG_FORCE_BRAND_NAME])) {
                    $feed['config'][Source::CONFIG_FORCE_BRAND_NAME] = $campaign['name'];
                }

                $feed['config'][Source::CONFIG_TRANSFORM_URL] = self::BASE_URL.'/c1-'.$campaign['deep_link'].'?u={url_encoded}';

                $source = $this->update_source(
                    $campaign['name'].' '.$feed['name'],
                    $campaign['name'],
                    $feed['link'],
                    ['campaign' => $campaign, 'feed' => $feed],
                );

                if ($source) {
                    $source->parser = $campaign['category'];
                    $source->config = array_merge($source->config ?: [], $feed['config']);

                    if ($source->wasRecentlyCreated) {
                        $source->priority = 0;
                    }

                    $source->save();
                }
            }
        }
    }
}
