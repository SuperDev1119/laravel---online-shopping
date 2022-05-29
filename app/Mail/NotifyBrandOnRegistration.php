<?php

namespace App\Mail;

use App\Classes\AffiliationSoftwareClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyBrandOnRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $merchant;

    public $link;

    public $link_to_doc;

    public function __construct($merchant)
    {
        $this->link = AffiliationSoftwareClient::NETWORK_HOST.'/merchant/';
        $this->link_to_doc = AffiliationSoftwareClient::LINK_TO_DOC;

        $this->merchant = $merchant;
    }

    public function build()
    {
        return $this
      ->to($this->merchant->email, $this->merchant->name)
      ->from('team@modalova.com', 'Team Modalova')
      ->bcc(config('imports.ML.USER'))
      ->subject('[Modalova] Your Dashboard is now ready !')
      ->markdown('emails.network.notify');
    }
}
