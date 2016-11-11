<?php

namespace Dugun\Bundle\SmsBundle\Sms;

use Dugun\Bundle\SmsBundle\Sms\Provider\Infobip\Client as InfoBip;

/**
 * Class ProviderFactory.
 *
 * @author Farhad Safarov <farhad.safarov@gmail.com>
 */
class ProviderFactory
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $environment;

    public function __construct(array $config, $environment = BaseProviderClient::ENVIRONMENT_PRODUCTION)
    {
        $this->config = $config;
        $this->environment = $environment;
    }

    /**
     * @param $providerName
     *
     * @return ProviderClientInterface
     */
    public function get($providerName)
    {
        if (!array_key_exists($providerName, $this->config['providers'])) {
            throw new \InvalidArgumentException(sprintf('No such provider named %s. Check config.yml', $providerName));
        }

        switch ($providerName) {
            case 'infobip':
                $client = new InfoBip($this->config['providers']['infobip']);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('%s is not a supported provider', $providerName));
        }

        $client->setEnvironment($this->environment);

        if (array_key_exists('debug_number', $this->config)) {
            $client->setDebugNumber($this->config['debug_number']);
        }

        return $client;
    }
}
