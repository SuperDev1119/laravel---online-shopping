<?php

namespace App\Classes;

use App\Mail\NotifyBrandOnRegistration;
use Illuminate\Support\Facades\Mail;

class AffiliationSoftwareClient
{
    private $client;

    private $merchant_id;

    private $merchant_name;

    private $merchant_email;

    private $merchant_password;

    private $campaign_id;

    private $campaign_name;

    private $campaign_type;

    private $campaign_domain;

    const MODALOVA_MID = 'qugci';

    const MODALOVA_AFFILIATE_ID = 1; // Modalova

    const DEFAULT_COMMISSION_VALUE = 8; // 8%

    const NETWORK_HOST = 'https://network.modalova.com';

    const LINK_TO_DOC = 'https://www.notion.so/modalova/Modalova-Instructions-86c22a019cfc44399d7d853d3d80105e';

    const CAMPAIGN_TYPES = [
        'woocommerce' => 'woocommerce',
        'prestashop' => 'prestashop',
        'shopify' => 'shopify',
        'wix' => 'wix',
    ];

    public function __construct($merchant_name, $merchant_email, $campaign_name, $campaign_type, $campaign_domain)
    {
        libxml_use_internal_errors(true);

        $this->client = new \GuzzleHttp\Client(['cookies' => true, 'allow_redirects' => false]);

        $this->merchant_name = $merchant_name;
        $this->merchant_email = $merchant_email;
        $this->campaign_name = $campaign_name;
        $this->campaign_type = $campaign_type;
        $this->campaign_domain = $campaign_domain;

        $this->merchant_password = self::generatePassword();
    }

    private function getCsrfToken($response)
    {
        $content = $response->getBody()->getContents();

        preg_match('#name="csrf" value="(.*?)"#', $content, $matches);
        $csrf = $matches[1];

        return $csrf;
    }

    private function getError($response)
    {
        $content = $response->getBody()->getContents();

        preg_match("#<div class='error_panel'><span class='msgtitle'>Error</span><br />(.*?)<br></div>#", $content, $matches);
        $error_message = @$matches[1];

        return trim($error_message);
    }

    public static function generatePassword($length = 16)
    {
        return bin2hex(openssl_random_pseudo_bytes(round($length / 2)));
    }

    private function log($message)
    {
        echo $message."\n";
    }

    public function login()
    {
        $this->log('[=] Login in...');

        $response_1 = $this->client->request(
      'GET',
      self::NETWORK_HOST.'/admin/login.php'
    );

        $response_2 = $this->client->request(
      'POST',
      self::NETWORK_HOST.'/admin/login.php', [
          'form_params' => [
              'email' => config('imports.ML.USER'),
              'password' => config('imports.ML.PASS'),
              'cookie' => 1,
              'csrf' => $this->getCsrfToken($response_1),
          ],
      ]
    );

        return 200 == $response_2->getStatusCode();
    }

    public function getMerchantId()
    {
        $response = $this->client->request(
      'POST',
      self::NETWORK_HOST.'/admin/merchants.php', [
          'form_params' => [
              'p' => 1,
              'r' => 200,
              'c' => 'signup',
              'o' => 'desc',
          ],
      ]
    );

        $content = $response->getBody()->getContents();
        $content = str_replace('&nbsp;', ' ', $content);

        $dom = new \DomDocument();
        $dom->loadHTML($content);

        $table = $dom->getElementsByTagName('table')[0];

        if (empty($table)) {
            $this->log("[!] Error: `$content`");

            return false;
        }

        foreach ($table->getElementsByTagName('tr') as $i => $tr) {
            if (0 == $i) {
                continue;
            } // skip Headers row

            $tds = $tr->getElementsByTagName('td');

            $id = trim($tds[0]->getElementsByTagName('input')[0]->getAttribute('value'));
            $email = trim($tds[3]->textContent);

            if ($email == $this->merchant_email) {
                $this->merchant_id = $id;
                $this->log("[+] Merchant ID is: $id");

                return true;
            }
        }

        return false;
    }

    public function createMerchant()
    {
        $this->log("[=] Adding merchant ({$this->merchant_name}, {$this->merchant_email})");

        $response = $this->client->request(
      'POST',
      self::NETWORK_HOST.'/admin/merchants_add.php', [
          'form_params' => [
              'name' => $this->merchant_name,
              'email' => $this->merchant_email,
              'password' => $this->merchant_password,
              'password_confirm' => $this->merchant_password,
              'status' => 1,  // Active
              'manageT' => 1, // Allow management Transactions
              'add' => 'Add',
          ],
      ]
    );

        if (302 != $response->getStatusCode()) {
            $this->log('[-] Error: `'.$this->getError($response).'`');

            return false;
        }

        $this->log('[+] Added! Getting ID...');

        return $this->getMerchantId();
    }

    public function createCampaign()
    {
        $this->log("[=] Adding campaign ({$this->campaign_name}, {$this->campaign_type})");

        $response = $this->client->request(
      'POST',
      self::NETWORK_HOST.'/admin/campaign_add.php', [
          'form_params' => [
              'name' => $this->campaign_name,
              'category' => $this->campaign_type,
              'sort' => 0,
              'mid' => [
                  self::MODALOVA_MID, // Gabriel Kaam (merchant) account
                  $this->merchant_id,
              ],
              'status' => 3, // Active (Hidden)
              'add' => 'Save',
          ],
      ]
    );

        if (302 != $response->getStatusCode()) {
            $this->log('[-] Error: `'.$this->getError($response).'`');

            return false;
        }

        $location = $response->getHeader('location')[0];

        $this->campaign_id = str_replace(['commission_edit.php?id=', '&added'], '', $location);

        $this->log("[+] Added! Campaign ID is: {$this->campaign_id}.");

        return true;
    }

    public function configureCommission($value = self::DEFAULT_COMMISSION_VALUE)
    {
        $this->log("[=] Updating comission on Campaign ({$this->campaign_id}) to `$value%`");

        $response = $this->client->request(
      'POST',
      self::NETWORK_HOST.'/admin/commission_edit.php?id='.$this->campaign_id, [
          'form_params' => [
              'type2' => 'S', // type = Sale
              'c1' => $value,
              'percentage' => 1, // percentage
              'edit' => 'Save',
          ],
      ]
    );

        if (302 != $response->getStatusCode()) {
            $this->log('[-] Error: `'.$this->getError($response).'`');

            return false;
        }

        return true;
    }

    public function createDeepLink()
    {
        $this->log("[=] Creating DeepLink for the Campaign ({$this->campaign_id})");

        $response = $this->client->request(
      'GET',
      self::NETWORK_HOST.'/admin/banner_edit_deeplink.php?new');

        $location = $response->getHeader('location')[0];
        $deepLink_id = str_replace('?id=', '', $location);

        $response = $this->client->request(
      'POST',
      self::NETWORK_HOST.'/admin/banner_edit_deeplink.php?id='.$deepLink_id, [
          'form_params' => [
              'name' => $this->campaign_name,
              'cid' => $this->campaign_id,
              'status' => 1, // Active
              'code' => $this->campaign_domain,
              'edit' => 'Save',
          ],
      ]
    );

        $error = $this->getError($response);
        if (200 != $response->getStatusCode() || ! empty($error)) {
            $this->log('[-] Error: `'.$error.'`');

            return false;
        }

        $this->log('[+] Creating the DeepLink ('.$deepLink_id.')');

        return true;
    }

    public function sendCredentials()
    {
        return Mail::send(new NotifyBrandOnRegistration((object) [
            'name' => $this->merchant_name,
            'password' => $this->merchant_password,
            'email' => $this->merchant_email,
        ]));
    }

    public function addAffiliate()
    {
        $this->log("[=] Adding (us) affiliate to campaign ({$this->campaign_id})");

        $response = $this->client->request(
      'POST',
      self::NETWORK_HOST.'/admin/group_add.php', [
          'form_params' => [
              'aid' => self::MODALOVA_AFFILIATE_ID,
              'cid' => $this->campaign_id,
              'afs_segment' => 'default',
              'status' => 1,  // Approved
              'add' => 'Add',
          ],
      ]
    );

        if (302 != $response->getStatusCode()) {
            $this->log('[-] Error: `'.$this->getError($response).'`');

            return false;
        }
    }
}
