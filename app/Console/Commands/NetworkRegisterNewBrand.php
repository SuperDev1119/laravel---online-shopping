<?php

namespace App\Console\Commands;

use App\Classes\AffiliationSoftwareClient;
use Illuminate\Console\Command;

class NetworkRegisterNewBrand extends Command
{
    protected $signature = 'network:register-brand
    {merchant_name : The Merchant name}
    {merchant_mail : The Merchant email address}
    {campaign_name : Name of the Brand}
    {campaign_type : Type of campaign (one of ____)}
    {campaign_domain : Domain of the website}';

    protected $description = 'Register a new brand on the affiliate network';

    public function __construct()
    {
        $this->signature = str_replace('____', implode(', ', array_keys(AffiliationSoftwareClient::CAMPAIGN_TYPES)), $this->signature);
        parent::__construct();
    }

    public function handle()
    {
        $campaign_type = AffiliationSoftwareClient::CAMPAIGN_TYPES[$this->argument('campaign_type')];

        $client = new AffiliationSoftwareClient(
      $this->argument('merchant_name'),
      $this->argument('merchant_mail'),
      $this->argument('campaign_name'),
      $campaign_type,
      $this->argument('campaign_domain'),
    );

        $client->login();
        $client->createMerchant();
        $client->createCampaign();
        $client->configureCommission();
        $client->createDeepLink();
        $client->sendCredentials();
        $client->addAffiliate();
    }
}
