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
    protected $client;

    /**
     * @var SMSTextualRequest
     */
    protected $requestBody;

    public function __construct(array $credentials)
    {
        if (!class_exists('\infobip\api\configuration\BasicAuthConfiguration')) {
            throw $this->createNotInstalledException('InfoBip', 'infobip/infobip-api-php-client');
        }

        $authConfiguration = new BasicAuthConfiguration($credentials['username'], $credentials['password']);
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
        if ($this->disabled) {
            return false;
        }

        $response = $this->client->execute($this->requestBody);

        return $response;
    }
}
