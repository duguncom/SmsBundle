<?php

namespace Dugun\Bundle\SmsBundle\Sms;

/**
 * Class BaseProviderClient.
 */
abstract class BaseProviderClient implements ProviderClientInterface
{
    const ENVIRONMENT_PRODUCTION = 'prod';

    /**
     * @var string
     */
    private $environment = self::ENVIRONMENT_PRODUCTION;

    /**
     * @var mixed
     */
    private $debugNumber;

    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setDebugNumber($number)
    {
        $this->debugNumber = $number;
    }

    public function getDebugNumber()
    {
        return $this->debugNumber;
    }

    protected function removeNewLines($string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }
}
