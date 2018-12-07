<?php

namespace Dugun\Bundle\SmsBundle\Sms\Provider\Infobip;

use Dugun\Bundle\SmsBundle\Sms\BaseProviderClient;
use infobip\api\client\SendMultipleTextualSmsAdvanced;
use infobip\api\configuration\BasicAuthConfiguration;
use infobip\api\model\Destination;
use infobip\api\model\sms\mt\send\Message;
use infobip\api\model\sms\mt\send\textual\SMSAdvancedTextualRequest;

class Client extends BaseProviderClient
{
    /**
     * @var SendMultipleTextualSmsAdvanced
     */
    private $client;

    /**
     * @var Message
     */
    public $message;

    public function __construct(array $credentials)
    {
        if (!class_exists('\infobip\api\configuration\BasicAuthConfiguration')) {
            throw $this->createNotInstalledException('InfoBip', 'infobip/infobip-api-php-client');
        }

        $authConfiguration = new BasicAuthConfiguration($credentials['username'], $credentials['password']);
        $this->client = new SendMultipleTextualSmsAdvanced($authConfiguration);
        $this->message = new Message();
    }

    public function setFrom($from)
    {
        $this->message->setFrom($from);

        return $this;
    }

    public function setTo($to)
    {
        $destination = new Destination();
        $destination->setTo($to);
        $this->message->setDestinations([$destination]);

        return $this;
    }

    public function setText($text)
    {
        $this->message->setText($this->removeNewLines($text));

        return $this;
    }

    public function send()
    {
        if ($this->disabled) {
            return false;
        }

        $request = new SMSAdvancedTextualRequest();
        $request->setMessages([$this->message]);

        $response = $this->client->execute($request);

        return $response;
    }
}
