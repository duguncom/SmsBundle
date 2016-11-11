<?php

namespace Dugun\Bundle\SmsBundle\Sms\Provider\Infobip;

use Dugun\Bundle\SmsBundle\Sms\BaseProviderClient;
use infobip\api\client\SendSingleTextualSms;
use infobip\api\configuration\BasicAuthConfiguration;
use infobip\api\model\sms\mt\send\textual\SMSTextualRequest;

/**
 * Class Client.
 *
 * @author Farhad Safarov <farhad.safarov@gmail.com>
 */
class Client extends BaseProviderClient
{
    /**
     * @var SendSingleTextualSms
     */
    private $client;

    /**
     * @var SMSTextualRequest
     */
    private $requestBody;

    public function __construct(array $config)
    {
        $authConfiguration = new BasicAuthConfiguration($config['username'], $config['password']);
        $this->client = new SendSingleTextualSms($authConfiguration);

        $this->requestBody = new SMSTextualRequest();
    }

    public function setFrom($from)
    {
        $this->requestBody->setFrom($from);

        return $this;
    }

    public function setTo($to)
    {
        $to = $this->getEnvironment() == BaseProviderClient::ENVIRONMENT_PRODUCTION ? $to : $this->getDebugNumber();
        $this->requestBody->setTo($to);

        return $this;
    }

    /**
     * @param $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $text = $this->removeNewLines($text);
        $this->requestBody->setText($text);

        return $this;
    }

    public function send()
    {
        $response = $this->client->execute($this->requestBody);
        
        return $response;
    }
}
