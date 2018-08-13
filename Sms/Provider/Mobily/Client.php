<?php

namespace Dugun\Bundle\SmsBundle\Sms\Provider\Mobily;

use Dugun\Bundle\SmsBundle\Sms\BaseProviderClient;

/**
 * Class Client.
 *
 * @author Farhad Safarov <farhad.safarov@dugun.com>
 */
class Client extends BaseProviderClient
{
    private $client;
    private $to;
    private $text;

    public function __construct(array $credentials, array $config = [])
    {
        $this->client = new \MobilyAPI\Client($credentials['username'], $credentials['password'], $config);
    }

    public function setFrom($from)
    {
        throw new \BadMethodCallException('Not implemented');
    }

    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function send()
    {
        if ($this->disabled) {
            return false;
        }

        $sms = new \MobilyAPI\requests\sendSMS($this->client, [$this->to], $this->text);
        $sms->send();

        return $sms->getResponse();
    }
}
